<?php
/**
 * Plugin Name:       ParticulierEmploi  Member
 * Description:       Plugin pour gérer les roles nécessaires à la gestion de particulieremploi
 * Version:           1.0.0
 * Author:            Gaëlle Rauffet
 */

class PE_Member_Plugin {
    public function __construct() {

        // cache l'admin bar si l'utilisateur est un chargé d'information
        add_action('init',array( $this, 'disable_admin_bar' ) );
        //empeche l'accès au BO aux chargés d'information
        add_action('admin_init', array( $this, 'restrict_access_administration'));

        // shortcode pour afficher formulaire de connexion
        add_shortcode( 'pe-login-form', array( $this, 'render_login_form' ) );

        //redirection vers la page de login perso lorsque la page de login par défaut est appelée
        add_action( 'login_form_login', array( $this, 'redirect_to_custom_login' ) );
        //interception du processus d'authentifcation pour rediriger vers la page de login perso si erreurs :
        // priorité haute (101) pour que la fonction soit appelée à la fin de la chaine de filtre et qu'elle récolte les erreurs éventuelles
        add_filter( 'authenticate', array( $this, 'maybe_redirect_at_authenticate' ), 101, 3 );
        // redirection après déconnexion
        add_action( 'wp_logout', array( $this, 'redirect_after_logout' ) );
        //redirection après connexion réussie
        add_filter( 'login_redirect', array( $this, 'redirect_after_login' ), 10, 3 );

    }

    /**
    * Plugin activation hook.
    */
    public static function plugin_activated() {
        //ajout du role pour les chargés d'informations
        add_role( 'pe-officer', "Chargé d'informations",
            array(
                'read' => true,
                'edit_posts' => false,
                'edit_pages' => false,
                'edit_others_posts' => false,
                'create_posts' => false,
                'manage_categories' => false,
                'publish_posts' => false
            ));

        //création des pages nécessaires
        $page_definitions = array(
            'connexion' => array(
                'title' => "Connexion",
                'content' => "<p class=\"section-title\">Se connecter à mon compte</p>"
                            ."<div class=\"title-separator\"></div>"
                            . "Pour vous connecter au module d'inscription, nous vous remercions de renseigner vos identifiants"
                            . "<br /> "
                            . "[pe-login-form]",
                'template' => ''
            ),
            'accueil-module-inscription' => array(
                'title' => "Accueil module d'inscription",
                'content' => "",
                'template' => plugin_dir_url( __FILE__ )."page-templates/module-inscription.php"
            )
        );
        foreach ( $page_definitions as $slug => $page ) {
            // Check that the page doesn't exist already
            $query = new WP_Query( 'pagename=' . $slug );
            if ( ! $query->have_posts() ) {
                // Add the page using the data from the array above
                $page_id=wp_insert_post(
                    array(
                        'post_content'   => $page['content'],
                        'post_name'      => $slug,
                        'post_title'     => $page['title'],
                        'post_status'    => 'publish',
                        'post_type'      => 'page',
                        'ping_status'    => 'closed',
                        'comment_status' => 'closed',
                    )
                );
                if(!empty($page['template'])) {
                    update_post_meta($page_id, "_wp_page_template", "page-templates/module-inscription.php");
                }
            }
        }
    }

    /**
     * Plugin deactivation hook
     */
     public static function plugin_deactivated() {
         //suppression du role chargé d'informations
        remove_role( 'pe-officer' );
    }

    /**
     * Fonction qui masque l'admin bar aux membres extranet
     */
    function disable_admin_bar() {
        $user = wp_get_current_user();
        if( in_array( 'pe-officer', $user->roles ) ) {
            // for the front-end
            remove_action('wp_footer', 'wp_admin_bar_render', 1000);

            // css override for the frontend
            function remove_admin_bar_style_frontend() {
      		echo '<style type="text/css" media="screen">
      			html { margin-top: 0px !important; }
      			* html body { margin-top: 0px !important; }
      			</style>';
            }
            add_filter('wp_head','remove_admin_bar_style_frontend', 99);
    	}
    }

    /**
     * Fonction pour empecher l'accès au BO
     */
    public function restrict_access_administration() {
        $user = wp_get_current_user();
        if( in_array( 'pe-officer', $user->roles ) ) {
            wp_redirect( home_url() );
            exit;
        }
    }

    /**
    * Hook to redirect the user to the custom login when default wp-login.php is called.
    */
    public function redirect_to_custom_login() {
        // redirection uniquement si la page de login est appelée
        // l'authentification (POST) doit être gérée par wp-login.php
        if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
            $redirect_to = isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : null;

            if ( is_user_logged_in() ) {
                $this->redirect_logged_in_user( $redirect_to );
                exit;
            }

            // The rest are redirected to the login page
            $login_url = home_url( 'connexion' );
            
            if ( ! empty( $redirect_to ) ) {
                $login_url = add_query_arg( 'redirect_to', $redirect_to, $login_url );
            }

            wp_redirect( $login_url );
            exit;
        }
    }

    /**
    * A shortcode for rendering the login form.
    *
    * @param  array   $attributes  Shortcode attributes.
    * @param  string  $content     The text content for shortcode. Not used.
    *
    * @return string  The shortcode output
    */
    public function render_login_form( $attributes, $content = null ) {
        // Parse shortcode attributes
        $default_attributes = array( 'show_title' => false );
        $attributes = shortcode_atts( $default_attributes, $attributes );
        $show_title = $attributes['show_title'];

        if ( is_user_logged_in() ) {
            //in shortcode so redirection not possible because some page html already displayed
            return $this->get_template_html('logout');

        }

        // Pass the redirect parameter to the WordPress login functionality: by default,
        // don't specify a redirect, but if a valid redirect URL has been passed as
        // request parameter, use it.
        $attributes['redirect'] = '';
        if ( isset( $_REQUEST['redirect_to'] ) ) {
            $attributes['redirect'] = wp_validate_redirect( $_REQUEST['redirect_to'], $attributes['redirect'] );
        }

        // erreur(s) à la connexion
        $errors = array();
        if ( isset( $_REQUEST['login'] ) ) {
            $error_codes = explode( ',', $_REQUEST['login'] );

            foreach ( $error_codes as $code ) {
                $errors[]= $this->get_error_message( $code );
            }
        }
        $attributes['errors'] = $errors;

        // message redirection page connexion après déconnexion
        $attributes['logged_out'] = isset( $_REQUEST['logged_out'] ) && $_REQUEST['logged_out'] == true;

       

        // Render the login form using an external template
        return $this->get_template_html( 'login_form', $attributes );
    }

    /**
    * Hook to redirect the user after authentication if there were any errors.
    *
    * @param Wp_User|Wp_Error  $user       The signed in user, or the errors that have occurred during login.
    * @param string            $username   The user name used to log in.
    * @param string            $password   The password used to log in.
    *
    * @return Wp_User|Wp_Error The logged in user, or error information if there were errors.
    */
    public function maybe_redirect_at_authenticate( $user, $username, $password ) {
        // Check if the earlier authenticate filter (most likely,
        // the default WordPress authentication) functions have found errors
        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            if ( is_wp_error( $user ) ) {
                $error_codes = join( ',', $user->get_error_codes() );

                $login_url = home_url( 'connexion' );
                $login_url = add_query_arg( 'login', $error_codes, $login_url );

                wp_redirect( $login_url );
                exit;
            }
        }

        return $user;
    }

    /**
    * Hook to redirect to custom login page after the user has been logged out.
    */
    public function redirect_after_logout() {
        $redirect_url = home_url( 'connexion?logged_out=true' );
        wp_safe_redirect( $redirect_url );
        exit;
    }

    /**
    * Hook to returns the URL to which the user should be redirected after the (successful) login.
    *
    * @param string           $redirect_to           The redirect destination URL.
    * @param string           $requested_redirect_to The requested redirect destination URL passed as a parameter.
    * @param WP_User|WP_Error $user                  WP_User object if login was successful, WP_Error object otherwise.
    *
    * @return string Redirect URL
    */
    public function redirect_after_login( $redirect_to, $requested_redirect_to, $user ) {
        $redirect_url = home_url('connexion');

        if ( ! isset( $user->ID ) ) {
            return $redirect_url;
        }

        if( in_array( 'pe-officer', $user->roles ) ) {
            // les chargés d'informations sont redirigés vers la page d'accueil du module d'inscription
            $redirect_url = home_url( 'accueil-module-inscription' );
        } else {
            //si administrateur et si le paramètre requested_redirect_to est défini, requested_redirect_to est utilisé
            if ( user_can( $user, 'manage_options' ) && $requested_redirect_to != '') {
                $redirect_url = $requested_redirect_to;
            } else {
                //sinon redirection vers le tabelau de bord
                $redirect_url = admin_url();
            }
        }

        return wp_validate_redirect( $redirect_url, home_url() );
    }

    /**
    * Renders the contents of the given template to a string and returns it.
    *
    * @param string $template_name The name of the template to render (without .php)
    * @param array  $attributes    The PHP variables for the template
    *
    * @return string               The contents of the template.
    */
    private function get_template_html( $template_name, $attributes = null ) {
        if ( ! $attributes ) {
            $attributes = array();
        }

        ob_start();

        do_action( 'custom_login_before_' . $template_name );

        require( 'templates/' . $template_name . '.php');

        do_action( 'custom_login_after_' . $template_name );

        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }

    /**
    * Finds and returns a matching error message for the given error code.
    *
    * @param string $error_code    The error code to look up.
    *
    * @return string               An error message.
    */
    private function get_error_message( $error_code ) {
        switch ( $error_code ) {
            case 'empty_username':
                return "Vous devez indiquer une adresse e-mail.";

            case 'empty_password':
                return "Vous devez indiquer un mot de passe.";

            case 'invalid_username':
                return "L'adresse email n'existe pas.";

            case 'incorrect_password':
                return "Le mot de passe est incorrect.";

            case 'invalid_email':
            case 'invalidcombo':
                return "Aucun compte n'existe avec cette adresse e-mail.";


            default:
            break;
        }

        return "Une erreur innatendue est survenue. Veuillez réessayer ultérieurement.";
    }

    /**
     * Manages redirection of the connected user to the correct page depending
     * on whether he / she is an admin or not.
     *
     * @param string $redirect_to   An optional redirect_to URL for admin users
     */
    private function redirect_logged_in_user( $redirect_to = null ) {
        $user = wp_get_current_user();
        if( in_array( 'pe-officer', $user->roles ) ) {
            //si c'est un chargé d'informations => redirection vers la page d'accueil du module d'inscription
            wp_redirect( home_url( 'accueil-module-inscription' ) );
        } else {
            //autres roles accèdent au BO
            if ( user_can( $user, 'manage_options' ) && $redirect_to ) {
                //si c'est un administrateur prise en compte du paramètre redirect_to
                wp_safe_redirect( $redirect_to );
            } else {
                //sinon redirection vers l'url admin par défaut
                wp_redirect( admin_url() );
            }
        }
    }

}

new PE_Member_Plugin();
//gestion des données l'activation/désactivation du plugin
register_activation_hook( __FILE__, array( 'PE_Member_Plugin', 'plugin_activated' ) );
register_deactivation_hook( __FILE__, array( 'PE_Member_Plugin', 'plugin_deactivated' ) );


