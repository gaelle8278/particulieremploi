/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready( function($) {

    //*** menu principal **/
    //ajout d'une classe au clic d'un élément de 1er niveau avec sous-menu
    // classe current utilisée en css si menu responsive
    $(".main-dropdown > .sub > a").click(function(e) {
         e.preventDefault();
         $(this).toggleClass('current');
         $(this).next('ul').toggleClass('current');
    });
    //3ème niveau apparait au clic sur items 2ème niveau
    $(".main-dropdown > .sub > .sub-menu > li.show-subsub-menu > a").click(function(e) {
        e.preventDefault();
        $(this).next("ul").toggle();
        $(this).parent("li").toggleClass('show-subsub-menu hide-subsub-menu');
    });

    //affichage menu responsive
    $('.main-menu #menu-res').click(function(){
        $('nav.main-menu .main-dropdown').toggleClass('responsive');
    });
    //effet grisé au survol du menu
    /*$('nav.main-menu').mouseover(function() {
        $('.container').addClass('show-menu');
    });
     $('nav.main-menu').mouseout(function() {
        $('.container').removeClass('show-menu');
    });*/
    /*** menu espace pe **/
    $('.menu-espacepe #menu-res').click(function(){
        $('.menu-espacepe ul').toggleClass('responsive');
    });

    //*** tooltips **/
    $('.tipHelp').tooltip({
        position: { my: "left+15 center", at: "right center" }
    });

    //**** datepicker des formulaires **/
    $.datepicker.regional['fr'] = {
	closeText: "Fermer",
	prevText: "Précédent",
	nextText: "Suivant",
	currentText: "Aujourd'hui",
	monthNames: [ "janvier", "février", "mars", "avril", "mai", "juin",
		"juillet", "août", "septembre", "octobre", "novembre", "décembre" ],
	monthNamesShort: [ "janv.", "févr.", "mars", "avr.", "mai", "juin",
		"juil.", "août", "sept.", "oct.", "nov.", "déc." ],
	dayNames: [ "dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi" ],
	dayNamesShort: [ "dim.", "lun.", "mar.", "mer.", "jeu.", "ven.", "sam." ],
	dayNamesMin: [ "D","L","M","M","J","V","S" ],
	weekHeader: "Sem.",
	dateFormat: "dd/mm/yy",
	firstDay: 1,
	isRTL: false,
	showMonthAfterYear: false,
	yearSuffix: ""
    };
    $.datepicker.setDefaults($.datepicker.regional["fr"]);

    $( ".datepicker" ).datepicker({
        showOn: "focus",
        dateFormat: "yy",
        maxDate: "+1m +1w",
        changeYear: true,
        changeMonth: true,
        beforeShow: function (textbox, inst) {
            setTimeout(function () {
                inst.dpDiv.css({
                    marginTop: (-35) + 'px',
                        marginLeft: textbox.offsetWidth + 10 + 'px'
                });
            }, 0);
        }
    });

    $( ".datepicker-full" ).datepicker({
        showOn: "focus",
        dateFormat: "dd/mm/yy",
        maxDate: "+1m +1w",
        changeYear: true,
        changeMonth: true,
        beforeShow: function (textbox, inst) {
            setTimeout(function () {
                inst.dpDiv.css({
                    marginTop: (250) + 'px',
                        marginLeft: textbox.offsetWidth + 10 + 'px'
                });
            }, 0);
        }
    });

    //********** recherche *********/
    //******************************/
    //**** formulaire de recherche du menu principal
    $("#custom-form").hide();
    $(".error404 #custom-form").show();
    $(".search-menu").click(function() {
        $("#custom-form").toggle();
    });
    //**** tabs du formulaire de recherche de la hp
    $( "#search-tabs" ).tabs();
    //**** soumission formulaire de recherche de la hp
    $("#hp-search input[type='submit']").click(function() {
        valid=true;

        var codepostal;
        var metier;
        if($(this).attr('name')=="searchEmp") {
            codepostal = $("#codepEmp").val();
            metier = $("#metierEmp").val();
        } else {
            codepostal = $("#codepSal").val();
            metier = $("#metierSal").val();
        }
        var $messageValidForm='';

        if(metier=='0' && !codepostal.match(/^[0-9]{5}$/i)) {
            $messageValidForm +="Veuillez sélectionner un métier et renseigner un code postal valide.";
        } else if (metier=='0') {
            $messageValidForm +="Veuillez sélectionner un métier.";
        } else if (!codepostal.match(/^[0-9]{5}$/i)) {
            $messageValidForm +="Veuillez renseigner un code postal valide.";
        }
        if($messageValidForm!='') {
            alert($messageValidForm);
            valid=false;
        }
        return valid;
    });
    //**** table responsive pour les résultats de la recherche ***/
    $('#resultsTable').cardtable({myClass:'resultats_recherche'});
    //****** formulaire de recherche espace pe **/
    $("#espacepe-search .advanced-search").hide();
    $("#advanced-search-toggle").click(function() {
        $("#espacepe-search .advanced-search input[type='text']").each(function() {
             $(this).val('');
        });
        $("#espacepe-search .advanced-search").toggle();
    });


    //**** fonction de zoom/dezoom ***/
    $('#agrandir').click(function () {
        curSize= parseInt($('article').css('font-size')) + 2;
        if(curSize<=50) {
            $('article').css('font-size', curSize);
        }
    });
    $('#diminuer').click(function () {
        curSize= parseInt($('article').css('font-size')) - 2;
        if(curSize>=10) {
            $('article').css('font-size', curSize);
        }
    });


    //**** section du Cesu 10 points **/
    $('.title-section-cesu').click(function() {
        $(this).next('.content-section-cesu').toggle('1000');
        //adaptation du picto associÃ© au pliement/dÃ©pliement (croix ou trait)
        $(this).toggleClass('show-cesu-section hide-cesu-section')
    });



    //************* popup/modale ****************/
    //******************************************/

    //**** popup contenu d'infos fixe ****/
        //popup de connexion
    var popup = (function()
    {

        function init() {

            var overlay = $('.overlay');

            $('.popup-button').each(function(i, el)
            {
                var modal = $('#' + $(el).attr('data-modal'));
                var close = $('.close');

                // fonction qui enleve la class .show de la popup et la fait disparaitre
                function removeModal() {
                    modal.removeClass('show');
                }

                // evenement qui appelle la fonction removeModal()
                function removeModalHandler() {
                    removeModal();
                }

                // au clic sur le bouton on ajoute la class .show a la div de la popup qui permet au CSS3 de prendre le relai
                $(el).click(function(event)
                {
                    event.preventDefault();
                    modal.addClass('show');
                    overlay.unbind("click");
                    // on ajoute sur l'overlay la fonction qui permet de fermer la popup
                    overlay.bind("click", removeModalHandler);
                });

                // en cliquant sur le bouton close on ferme tout et on arrÃªte les fonctions
                close.click(function(event)
                {
                    event.stopPropagation();
                    removeModalHandler();
                });

            });
        }

        init();

    })();


    //******** popup de confirmation ***/
    //construction des popups
    function afficherPopupConfirmation (message, targetUrl) {
        //contenu de la popup
        $('body').append('<div id="popupconfirmation"> </div>');
        $("#popupconfirmation").html(message);

        $("#popupconfirmation").dialog({
            autoOpen: false,
            width: "auto",
            maxWidth: 400,
            height: 'auto',
            dialogClass: "dialog_confirm",
            modal: true,
            fluid: true,
            buttons: [
                {
                    text: "Annuler",
                    class: "cancel_button",
                    click: function () {
                        $(this).dialog("close");
                    }
                },
                {
                    text: "confirmer",
                    class: "ok_button",
                    click: function () {
                        window.location.href = targetUrl;
                    }
                }

            ]
        }).dialog("open");
    }
     // on window resize run function
    $(window).resize(function () {
        fluidDialog();
    });

    // catch dialog if opened within a viewport smaller than the dialog width
    $(document).on("dialogopen", ".ui-dialog", function (event, ui) {
        fluidDialog();
    });

    function fluidDialog() {
        var $visible = $(".ui-dialog:visible");
        // each open dialog
        $visible.each(function () {
            var $this = $(this);
            var dialog = $this.find(".ui-dialog-content").data("ui-dialog");
            // if fluid option == true
            if (dialog.options.fluid) {
                var wWidth = $(window).width();
                // check window width against dialog width
                if (wWidth < (parseInt(dialog.options.maxWidth) + 50))  {
                    // keep dialog from filling entire screen
                    $this.css("max-width", "90%");
                } else {
                    // fix maxWidth bug
                    $this.css("max-width", dialog.options.maxWidth + "px");
                }
                //reposition dialog
                dialog.option("position", dialog.options.position);
            }
        });

    }

    //appel de la popup
        //suppression annonce
    $(".suppr-button").click(function(event) {
        event.preventDefault();
        // lien de redirection après confirmation
        var targetUrl = $(this).attr("href");
        //message à afficher dans la popup
        var message= $(this).data('message');
        afficherPopupConfirmation(message, targetUrl);
    });
    /***********************/


    //********** popup d'infos dynamique ***/
    $(".custom-popup .close_button").click(function(event) {
          event.preventDefault();
          var popup = $(this).parents('.custom-popup');
          hidePopup(popup);
    });
    $(".custom-popup .ok_button").click(function(event) {
          event.preventDefault();
          var popup = $(this).parents('.custom-popup');
          hidePopup(popup);
    });
    function showPopup(popup) {
         $(popup).before('<div id="gray-overlay"></div>');
         $("#gray-overlay ").css('opacity', 0).fadeTo(300, 0.5, function () { $(popup).fadeIn(500); });
    }
    function hidePopup(popup) {
        // on fait disparaitre le gris de fond rapidement
        $("#gray-overlay").fadeOut('fast', function () { $(this).remove() });
        // on fait disparaitre le popup à la mÃªme vitesse
        $(popup).fadeOut('fast', function () { $(this).hide() });
    }
    // appel de la popup
        // détail d'une annonce
     $("a.button_details").click(function(event){
        event.preventDefault();
        var popup=$(this).nextAll('.custom-popup');
        showPopup(popup);
    });
        //affichage détail d'une annonce en responsive
     $(".res_button_details").click(function(){
         $(this).nextAll('.res-custom-popup').toggle();
     });

    //******* cesu  ******/
    //********************/
    $('#cesu-submit').click(function() {
        valid= true;
        if($('#cesu-form input[name=cesu_salaire]').val()=='') {
            $('#cesu-form input[name=cesu_salaire]').parents(".field-req").children(".msg-error-valid").fadeIn().text("Veuillez indiquer un montant horaire brut");
            valid=false;
        } else {
            $('#cesu-form input[name=cesu_salaire]').parents(".field-req").children(".msg-error-valid").fadeOut().text("");
        }
        if($('#cesu-form input[name=cesu_type]:checked').length !=1) {
            $('#cesu-form input[name=cesu_type]').parents(".field-req").children(".msg-error-valid").fadeIn().text("Veuillez indiquer si vous êtes particulier employeur ou salarié ?");
            valid=false;
        } else {
            $('#cesu-form input[name=cesu_type]').parents(".field-req").children(".msg-error-valid").fadeOut().text("");
        }

        return valid;
    });

    //***** mot de passe oublié **/
    //****************************/
    $("#mdpform input[type='submit']").click(function() {

        valid=true;

        //vérification s'il y a des champs requis non rempli
        $("#mdpform .field-req input[type='text']").each(function () {
            if($(this).val() == '') {

                $(this).parents(".field-req").next(".msg-error-valid").fadeIn().text("Veuillez remplir ce champ");
                valid= false;
            } else {
                $(this).parents(".field-req").next(".msg-error-valid").hide().text("");
            }
        });
        return valid;
    });


    //*** espace pe ******/
    //********************/
    //note des annonces favorites ***/
    $('.edit-note').hide();

    $('.edit-note-button').click(function() {
        $(this).parents('.display-note').children('.edit-note').show('500');
    });

    $(".edit-cancel").click(function(e) {
        e.preventDefault();
        $(this).parents(".edit-note").hide('500');
    });


    /********* étape 1 parcours inscription ***/
    /***********************************************/
    // validation à  la soumission
    $(".submit_button_ins").click(function(event) {
        event.preventDefault();

        //renseignement du bouton du formulaire qui a été cliqué
        $('#form-inscription #form-button').val($(this).attr("name"));

        //vérification dispo email
        $.ajax({

            url : '/pe/ajax/dispo-email.php',
            type : 'POST',
            data : 'email=' + $('#form-email').val(),
            success : function(code_html){
                    if(code_html == "NOK") {
                        $('#form-email').parents(".field-req").next(".msg-error-valid").show().text(
                                "Cet e-mail est déjà associé à un compte existant. Veuillez en indiquer un autre.");
                        return false;

                    } else {
                        $("#form-email").parents(".field-req").next(".msg-error-valid").hide().text("");
                        checkFormIns();
                    }
            }
        });

    });

    function checkFormIns() {
        valid=true;

        //vérification s'il y a des champs requis non rempli
        $("#form-inscription .field-req input[type='text'], #form-inscription .field-req input[type='password']").each(function () {
            if($(this).val() == '') {
                $(this).parents(".field-req").next(".msg-error-valid").fadeIn().text("Veuillez remplir ce champ");
                valid= false;
            } else {
                $(this).parents(".field-req").next(".msg-error-valid").hide().text("");
            }
        });
        if($('input[type=radio][name=civilite]:checked').length !=1) {
            $("input[type=radio][name=civilite]").parents(".field-req").next(".msg-error-valid").fadeIn().text(
                    "Veuillez choisir une des options");
            valid=false
        } else {
            $("input[type=radio][name=civilite]").parents(".field-req").next(".msg-error-valid").hide().text("");
        }

        //vérification de la valeur de certains champs
        if($('#form-mdp').val() != '') {
            if (!$("#form-mdp").val().match(/^[a-z0-9_\.@]{6,}$/i)) {
                 $("#form-mdp").parents(".field-req").next(".msg-error-valid").show().text(
                         "Le mot de passe doit contenir au moins 6 caractères sans caractères spéciaux");
                 valid=false;
            } else if ($('#form-mdp').val() != $('#form-check-mdp').val()) {
                $('#form-mdp').parents(".field-req").next(".msg-error-valid").show().text("Les mots de passe ne correspondent pas ");
                valid=false;
            } else {
                $("#form-mdp").parents(".field-req").next(".msg-error-valid").hide().text("");
            }
        }
        if (!$("#form-ville").val().match(/^[a-zA-ZÀ-ÿ\s\'-]+$/i)) {
             $("#form-ville").parents(".field-req").next(".msg-error-valid").show().text(
                     "La ville ne doit contenir que des caractères alphabétiques");
             valid=false;
        } else {
            $("#form-ville").parents(".field-req").next(".msg-error-valid").hide().text("");
        }
        if (!$("#form-adresse").val().match(/^[a-zA-ZÀ-ÿ0-9\s\'-]+$/i)) {
             $("#form-adresse").parents(".field-req").next(".msg-error-valid").show().text(
                     "L'adresse ne doit contenir que des caractères alphanumériques");
             valid=false;
        } else {
            $("#form-adresse").parents(".field-req").next(".msg-error-valid").hide().text("");
        }
        if (!$("#form-cp").val().match(/^[0-9]{5}$/i)) {
             $("#form-cp").parents(".field-req").next(".msg-error-valid").show().text("Le code postal doit contenir 5 chiffres");
             valid=false;
        } else {
            $("#form-cp").parents(".field-req").next(".msg-error-valid").hide().text("");
        }
        if ($("#form-tel").length > 0 && $("#form-tel").val() != '' && !$("#form-tel").val().match(/^[0-9]{10}$/i)) {
             $("#form-tel").parents(".field-check").next(".msg-error-valid").show().text(
                     "Merci de saisir un numéro valide à 10 chiffres.");
             valid=false;
        } else {
            $("#form-tel").parents(".field-check").next(".msg-error-valid").hide().text("");
        }
        if($('#form-email').val() !='') {
            if($('#form-email').val() != $('#form-check-email').val()) {
                $('#form-email').parents(".field-req").next(".msg-error-valid").show().text("Les e-mail ne correspondent pas ");
                valid=false;
            } else {
                $("#form-email").parents(".field-req").next(".msg-error-valid").hide().text("");
            }
        }
        if(valid==true) {
            $('#form-inscription').submit();
        }
    };

    //validation temps réel
    $("#form-mdp").keyup(function() {
        if (!$("#form-mdp").val().match(/^[a-z0-9_\.@]{6,}$/i)) {
             $("#form-mdp").parents(".field-req").next(".msg-error-valid").show().text("Le mot de passe doit contenir au moins 6 caractères sans caractères spéciaux");
        } else {
            $("#form-mdp").parents(".field-req").next(".msg-error-valid").hide().text("");
        }
    });
    $("#form-cp").keyup(function() {
        if (!$("#form-cp").val().match(/^[0-9]{5}$/i)) {
             $("#form-cp").parents(".field-req").next(".msg-error-valid").show().text("Le code postal doit contenir 5 chiffres");
        } else {
            $("#form-cp").parents(".field-req").next(".msg-error-valid").hide().text("");
        }
    });
    $("#form-tel").keyup(function() {
        if ($("#form-tel").val() !='' && !$("#form-tel").val().match(/^[0-9]{10}$/i)) {
             $("#form-tel").parents(".field-check").next(".msg-error-valid").show().text("Merci de saisir un numéro valide à 10 chiffres.");
        } else {
            $("#form-tel").parents(".field-check").next(".msg-error-valid").hide().text("");
        }
    });
    $("#form-ville").keyup(function() {
        if (!$("#form-ville").val().match(/^[a-zA-ZÀ-ÿ\s\'-]+$/i)) {
             $("#form-ville").parents(".field-req").next(".msg-error-valid").show().text("La ville ne doit contenir que des caractères alphabétiques");
             valid=false;
        } else {
            $("#form-ville").parents(".field-req").next(".msg-error-valid").hide().text("");
        }
    });
    $("#form-adresse").keyup(function() {
        if (!$("#form-adresse").val().match(/^[a-zA-ZÀ-ÿ0-9\s\'-]+$/i)) {
             $("#form-adresse").parents(".field-req").next(".msg-error-valid").show().text("L'adresse ne doit contenir que des caractères alphanumériques");
             valid=false;
        } else {
            $("#form-adresse").parents(".field-req").next(".msg-error-valid").hide().text("");
        }
    });

    //**************** étape 2 parcours inscription ***********/
    //**********************************************************/
    //*** gestion accordeon  ***/
    //les options = choix des emplois-repères sont cachés après chargement de la page
    // accessibilité : si js désactivé les options seront affichées
    $("div.optionER").css("display","none");

    //enclenchement de l'accordéon
    $("#accordion").accordion({
        icons: {
            header: "ui-icon-plus",
            activeHeader: "ui-icon-minus"
        },
        heightStyle: "content",
        active: true,
        collapsible: true
    });

    //gestion de l'affichage et de la sélection des emplois-repères
    $("input.choixMetier").click(function () {
        //si un métier est choisi
        if ($(this).is(":checked")) {
            //les options ER sont déselectionnées
            $("input.choixER").each(
                function () {
                    $(this).prop("checked", false);
                }
            );
            //les blocs des options ER (= les ER liés aux métiers) sont cachées
            $("div.optionER").css("display", "none");
            //le panneau actif est redimensionné pour qu'à l'affichage des options la hauteur soit correcte (ne masque pas une partie du contenu)
            $("#accordion").css("height", "auto");
            $(this).parent("p.optionMetier").parents("div.ui-accordion-content-active").css("height", "auto");
            //les options liées au métier sélectionné sont affichées
            $(this).parent("p.optionMetier").next("div.optionER").css("display", "block");
        }
    });

    //**************** étape 4 parcours inscription ***********/
    //**********************************************************/
    $("#submit_button_recap").click(function() {
        valid=true;
        if(!$("#cgu").is(":checked")) {
            $("#cgu").parents(".field-req").next(".msg-error-valid").fadeIn().text("Merci de confirmer que les informations sont exactes en cochant cette case");
            valid=false
        } else {
            $("#cgu").parents(".field-req").next(".msg-error-valid").fadeOut().text("");
        }
        return valid;
    });

    //********* messagerie interne ************/
    //****************************************/
    //validation avant envoi d'un message
    $('#button-send-msg').click(function() {
        valid=true;
         $("#envoyermsg .field-req input[type='text'], #envoyermsg .field-req textarea").each(function () {
            if($(this).val() == '') {
                $(this).next(".msg-error-valid").fadeIn().text("Veuillez remplir ce champ");
                valid= false;
            } else {
                $(this).next(".msg-error-valid").hide().text("");
            }
        });
        if(($('#id_dest_msg_select').length > 0 && !$('#id_dest_msg_select option:selected').length)) {
            $('#envoyermsg #id_dest_msg_select').parents('.field-req').children(".msg-error-valid").fadeIn().text("Veuillez saisir un destinataire");
            valid=false;
        } else {
            $('#envoyermsg #id_dest_msg_select').parents('.field-req').children(".msg-error-valid").hide().text("");
        }


        return valid;

    });
    //gestion de la réponse dans l'interface de lecture d'un message
    $('.hidden-form').hide();
    $('#resp-button').click( function() {
        $('.hidden-form').show();
        $('.bloc-msg-button').hide();
    });

    /************ Les essentiels ******/
    /** gestion du marquage des options choisies */
    $( ".aplat-option-choosen" ).click(function() {
        $(this).parents(".bloc-offre").find(".aplat-option-choosen").each(function() {
            if( $(this).find('input[type="radio"]:checked').length ===1) {
                $(this).addClass('aplat-option-selected');
            } else {
                $(this).removeClass('aplat-option-selected');
            }
        });
    });


});



