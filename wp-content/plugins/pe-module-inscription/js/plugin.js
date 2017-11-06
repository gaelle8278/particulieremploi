/* 
 * JS du plugin module inscription
 */

        function veriftaux(valeur) {
            var selectedmetier = $('input[name=jobSelect]:checked').val();
            
            if (selectedmetier=='4') {
                if (valeur < 2.53){
                    alert("Veuillez saisir un taux horaire brut minimum de 2.53 €");

                } else if (valeur > 50) {
                    alert("Merci de ne pas saisir de taux horaire brut dépassant 50 €");

                }
            }  else  {
                if (valeur < 9.76){
                    alert("Veuillez saisir un taux horaire brut minimum de 9.76 €");

                } else if (valeur > 50) {
                    alert("Merci de ne pas saisir de taux horaire brut dépassant 50 €");

                }
            }
        }
        
        function check_compat() {
            if (typeof GBrowserIsCompatible === 'undefined') {
                alert('Echec du chargment de Google Maps API.');
                return false;
            } else {
                if (GBrowserIsCompatible()) {
                    return true;
                } else {
                    alert("Votre navigateur n'est pas compatibe avec Google Maps");
                    return false;
                }
            }
        }
        function showAddress() {
                var readyGM = check_compat();
                if( readyGM == true ) {
                    var geo = new GClientGeocoder();
                    // ====== Array for decoding the failure codes ======
                    var reasons=[];
                    reasons[G_GEO_SUCCESS]            = "Success";
                    reasons[G_GEO_MISSING_ADDRESS]    = "L'adresse est manquante.";
                    reasons[G_GEO_UNKNOWN_ADDRESS]    = "Adresse inconnu:  Aucune correspondance géographique n'a été trouvée. Merci de n'indiquer que le nom de votre rue.";
                    reasons[G_GEO_UNAVAILABLE_ADDRESS]= "Unavailable Address:  The geocode for the given address cannot be returned due to legal or contractual reasons.";
                    reasons[G_GEO_BAD_KEY]            = "Une problème de clé a été détécté. Contactez un administrateur";
                    reasons[G_GEO_TOO_MANY_QUERIES]   = "Trop de demande de vérification d'adresse ont été faites aujourd'hui.";
                    reasons[G_GEO_SERVER_ERROR]       = "Problème lié au serveur, veuillez réassayer dans quelques secondes.";
                    var codepostal = document.getElementById("job-codepostal").value;
                    if(codepostal=='') {
                        codepostal ='00';
                    }
                    var ville = document.getElementById("job-ville").value;
                    var adresse = document.getElementById("job-adresse").value;
                    var search = ''+adresse+', '+codepostal+' '+ville+'';
                    // ====== Perform the Geocoding ======
                    geo.getLocations(search, function (result) {
                        // If that was successful
                        if (result.Status.code == G_GEO_SUCCESS) {
                            var divMessageContent = '';
                            // Loop through the results, placing markers
                            var resultats= "";
                            for (var i=0; i<result.Placemark.length; i++) {
                                var p = result.Placemark[i].Point.coordinates;
                                var marker = new GMarker(new GLatLng(p[1],p[0]));
                                if(i==0){
                                    resultats += '<input id="geoadresse_'+ i +'" type="radio" name="geoadresse" value="'+marker.getPoint().lat()+"/"+marker.getPoint().lng()+'" onClick="selectAdresse()"><label for="geoadresse_'+ i +'" ><span>'+ result.Placemark[i].address +'</span></label>';
                                } else {
                                    resultats += '<input id="geoadresse_'+ i +'" type="radio" name="geoadresse" value="'+marker.getPoint().lat()+"/"+marker.getPoint().lng()+'" onClick="selectAdresse()"><label for="geoadresse_'+ i +'"><span>'+ result.Placemark[i].address +'</span></label>';
                                }
                            }
                            divMessageContent += resultats+'<p class="text-italic">Si votre adresse ne s\'affiche pas, s&eacute;lectionnez le code postal.</p>';
                            document.getElementById('list-adress').innerHTML=divMessageContent;
                          


                        }
                        // ====== Decode the error status ======
                        else {
                            var reason="Code "+result.Status.code;
                            if (reasons[result.Status.code]) {
                              reason = reasons[result.Status.code]
                            }
                            alert('Impossible de trouver "'+search+ '" ' + reason);
                        }
                    });
                }
            }
        function showAddress2() {
                var readyGM = check_compat();
                 if( readyGM == true ) {
                    var geo = new GClientGeocoder();
                    // ====== Array for decoding the failure codes ======
                    var reasons=[];
                    reasons[G_GEO_SUCCESS]            = "Success";
                    reasons[G_GEO_MISSING_ADDRESS]    = "L'adresse est manquante.";
                    reasons[G_GEO_UNKNOWN_ADDRESS]    = "Adresse inconnu:  Aucune correspondance géographique n'a été trouvée. Merci de n'indiquer que le nom de votre rue.";
                    reasons[G_GEO_UNAVAILABLE_ADDRESS]= "Unavailable Address:  The geocode for the given address cannot be returned due to legal or contractual reasons.";
                    reasons[G_GEO_BAD_KEY]            = "Une problème de clé a été détécté. Contactez un administrateur";
                    reasons[G_GEO_TOO_MANY_QUERIES]   = "Trop de demande de vérification d'adresse ont été faites aujourd'hui.";
                    reasons[G_GEO_SERVER_ERROR]       = "Problème lié au serveur, veuillez réassayer dans quelques secondes.";
               

                    var gp_codepostal = document.getElementById("gp_codepostal").value;
                    if(gp_codepostal=='') {
                        gp_codepostal ='00';
                    }
                    var gp_ville = document.getElementById("gp_ville").value;
                    var gp_localisation = document.getElementById("gp_localisation").value;
                    switch(gp_localisation){
                        case 'FRANCE':
                            gp_localisation='France';
                        break;
                        case 'GLP':
                            gp_localisation='Guadeloupe';
                        break;
                        case 'GUF':
                            gp_localisation='Guyane';
                        break;
                        case 'MTQ':
                            gp_localisation='Martinique';
                        break;
                        case 'PYF':
                            gp_localisation='Polynésie Française';
                        break;
                        case 'REU':
                            gp_localisation='Réunion';
                        break;
                    }
                    var search = ''+gp_codepostal+' '+gp_ville+', '+gp_localisation+'';
                    // ====== Perform the Geocoding ======
                    geo.getLocations(search, function (result) {
                        // If that was successful
                        if (result.Status.code == G_GEO_SUCCESS) {
                            var resultats= "";
                            resultats +='';
                            // Loop through the results, placing markers
                            for (var i=0; i<result.Placemark.length; i++) {
                                var p = result.Placemark[i].Point.coordinates;
                                var marker = new GMarker(new GLatLng(p[1],p[0]));
                                if(i==0){
                                    resultats += '<input id="geoadresse2_'+ i +'" type="radio" name="geoadresse2"  value="'+marker.getPoint().lat()+'/'+marker.getPoint().lng()+'" /><label for="geoadresse2_'+ i +'" ><span>'+result.Placemark[i].address +'</span></label>';
                                } else {
                                    resultats += '<input id="geoadresse2_'+ i +'" type="radio" name="geoadresse2"  value="'+marker.getPoint().lat()+'/'+marker.getPoint().lng()+'" /><label for="geoadresse2_'+ i +'" ><span>'+result.Placemark[i].address +'</span></label>';
                                }
                            }
                            resultats += '<p class="text-italic">Si votre adresse ne s\'affiche pas, sélectionnez le code postal.</p>';
                            document.getElementById("message2").innerHTML = resultats;
                        }
                        // ====== Decode the error status ======
                        else {
                            var reason="Code "+result.Status.code;
                            if (reasons[result.Status.code]) {
                                reason = reasons[result.Status.code]
                            }
                            alert('Impossible de trouver "'+search+ '" ' + reason);
                        }
                    });
                }
            }
            
        //fonction appelée lors de la sélection d'une adresse
        function selectAdresse() {
            document.getElementById("conditions-submit").style.display ="inline-block";
            document.getElementById("valider").style.display ="none";
        }
        
        function showcadregpemp() {
            if(document.getElementById("bt_dejanounou1")) {
                if (document.getElementById("bt_dejafamille1").checked == true && document.getElementById("bt_dejanounou1").checked==true){
                    alert("Veuillez vérifier votre saisie, car vous ne pouvez pas avoir besoin de nos services si vous avez déjà une garde d’enfant et une famille.");
                }
            }
            $("#nbenfantsBloc").show();
            $("#ageBlock").show();

        }
        
        function showcadregp(baliseId) {
            if(document.getElementById("bt_dejanounou1")) {
                if (document.getElementById("bt_dejafamille1").checked==true && document.getElementById("bt_dejanounou1").checked==true){
                    alert("Veuillez vérifier votre saisie, car vous ne pouvez pas avoir besoin de nos services si vous avez déjà une garde d’enfant et une famille.");
                }
            }
            if (baliseId==0){
                if (type_compte=="emp"){
                    jQuery("#postalCodeBlock").hide();
                }
                else if (type_compte=="sal"){
                    jQuery("#ageBlock").show();
                    jQuery("#nbenfantsBloc").hide();
                    jQuery("#postalCodeBlock").hide();
                }

            } else if (baliseId==1){
                if(type_compte=="emp"){
                    jQuery("#postalCodeBlock").show();
                } else if(type_compte=="sal"){
                    jQuery("#postalCodeBlock").show();
                    jQuery("#nbenfantsBloc").show();
                    jQuery("#ageBlock").show();
                }

            }
        }
        
       
        
         function checkAssMat() {
            if (type_compte == "sal") {
                jQuery('#numagrement').show();
                jQuery('#partedateagre').show();
                    
            } else if (type_compte == "emp") {
                jQuery("#infoassmat").show();
            }
            //bloc accueil des enfants
            jQuery("#enfants").show();
        }

        function checkGP() {
            if(type_compte == "emp"){
                jQuery("#tr_nounou").show();
            }
            jQuery("#tr_famille").show();
            
            jQuery("#cadregp").show();

            if(type_compte=="sal"){
                    if (document.getElementById("bt_dejafamille2").checked == true) {
                      jQuery("#ageBlock").show();
                    } else if (document.getElementById("bt_dejafamille1").checked==true){
                      jQuery("#postalCodeBlock").show();
                      jQuery("#nbenfantsBloc").show();
                      jQuery("#ageBlock").show();
                    }
                
            } else if (type_compte=="emp") {
                    if (document.getElementById("bt_dejafamille1").checked==true){
                        jQuery("#postalCodeBlock").show();
                    }
                
                
                    if (document.getElementById("bt_dejanounou2").checked==true ||
                          document.getElementById("bt_dejanounou1").checked==true) {
                        $("#nbenfantsBloc").show();
                        $("#ageBlock").show();
                    }
                
            }
        }
    jQuery(document).ready( function($) { 
        $('#tr_famille input[name=dejafamille]:radio').click(function() {
            var val = $(this).val();
            showcadregp(val);
        });

        $('#tr_nounou input[name=dejanounou]:radio').click(function() {
            showcadregpemp();
        });
        
        
        function hideQualifElements() {
                //caché par défaut, affiché si asssitant maternel et annonce salarié
            $("#numagrement").hide();
            $("#partedateagre").hide();
                //caché par défaut, affiché si asssitant maternel
            $("#enfants").hide();
                //caché par défaut affiché si assitant maternel et annonce employeur
            $("#infoassmat").hide();
                //=> voir fonction checkAssMat

                //caché par défaut affiché si garde partagée
            $("#tr_famille").hide();
            $("#tr_nounou").hide();
                //caché par défaut, affiché si garde partagé
            $("#cadregp").hide();
            $("#postalCodeBlock").hide();
            $("#nbenfantsBloc").hide();
            $("#ageBlock").hide();
                //=> voir fonction checkGP

            //le bouton de soumission est caché tant que l'adresse n'est pas validée
            $('p#valider').show();
            $('#conditions-submit').hide();
            $('#list-adress').text("");
        }
        
        function hideSteps() {
            //des parties du forumaire sont cachées s'il n'y a pas d'erreur
            if(! $('#form-error') || $('#form-error').text() =="") {
                $('#choix-metier').hide();
                $('#qualification').hide();
            }
            
        }
        
        //init on page load
        hideQualifElements();
        hideSteps();
        
        
        
        $('.form-header').click(function() {
            if( $(this).next('div').is(':visible') ) {
                $(this).next('div').fadeOut();
            } else {
                $(this).next('div').fadeIn();
            }
        });
        
        function showFormSection( section ) {
            $(section).slideDown(600);
            
        }
        function hideFormSection( section ) {
            $(section).slideUp();
            
        }
        
        //clic sur le bouton de validation du compte
        $('#button-infos-compte').click(function() {

            //vérification dispo email
            $.ajax({

                url : '/pe/ajax/dispo-email.php',
                type : 'POST',
                data : 'email=' + $('#form-email').val(),
                success : function(code_html){
                        if(code_html == "NOK") {
                            $('#form-email').parents(".field-req").next(".msg-error-valid").show().text(
                                    "Cet e-mail est déjà associé à un compte existant. Veuillez en indiquer un autre.");

                        } else {
                            $("#form-email").parents(".field-req").next(".msg-error-valid").hide().text("");
                            var valid = checkInfosCompte();
                            if(valid===true) {
                                //remplissage des champs de validation de l'adresse
                                $('#job-ville').val($('#form-ville').val());
                                $('#job-codepostal').val($('#form-cp').val());
                                $('#job-adresse').val($('#form-adresse').val());
                                hideFormSection('#compte');
                                hideFormSection('#qualification');
                                showFormSection('#choix-metier');
                            } else {
                                $('html, body').animate({
                                        scrollTop: $('#compte').offset().top
                                    }, 600);
                            }
                        }
                }
            });

        });

        function checkInfosCompte() {
            var valid=true;
            
            //vérification s'il y a des champs requis non rempli
            $("#compte .field-req input[type='text'], #form-module-inscription .field-req input[type='password']").each(function () {
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
            //vérification mot de passe 
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
            //vérification ville
            if (!$("#form-ville").val().match(/^[a-zA-ZÀ-ÿ\s\'-]+$/i)) {
                 $("#form-ville").parents(".field-req").next(".msg-error-valid").show().text(
                         "La ville ne doit contenir que des caractères alphabétiques");
                 valid=false;
            } else {
                $("#form-ville").parents(".field-req").next(".msg-error-valid").hide().text("");
            }
            //vérification adresse
            if (!$("#form-adresse").val().match(/^[a-zA-ZÀ-ÿ0-9\s\'-]+$/i)) {
                 $("#form-adresse").parents(".field-req").next(".msg-error-valid").show().text(
                         "L'adresse ne doit contenir que des caractères alphanumériques");
                 valid=false;
            } else {
                $("#form-adresse").parents(".field-req").next(".msg-error-valid").hide().text("");
            }
            //vérification cp
            if (!$("#form-cp").val().match(/^[0-9]{5}$/i)) {
                 $("#form-cp").parents(".field-req").next(".msg-error-valid").show().text("Le code postal doit contenir 5 chiffres");
                 valid=false;
            } else {
                $("#form-cp").parents(".field-req").next(".msg-error-valid").hide().text("");
            }
            //vériification tel
            if ($("#form-tel").length > 0 && $("#form-tel").val() != '' && !$("#form-tel").val().match(/^[0-9]{10}$/i)) {
                 $("#form-tel").parents(".field-check").next(".msg-error-valid").show().text(
                         "Merci de saisir un numéro valide à 10 chiffres.");
                 valid=false;
            } else {
                $("#form-tel").parents(".field-check").next(".msg-error-valid").hide().text("");
            }
            //vérification email
            if($('#form-email').val() !='') {
                if($('#form-email').val() != $('#form-check-email').val()) {
                    $('#form-email').parents(".field-req").next(".msg-error-valid").show().text("Les e-mail ne correspondent pas ");
                    valid=false;
                } else {
                    $("#form-email").parents(".field-req").next(".msg-error-valid").hide().text("");
                }
            }
            
            return valid;
        };
        
        function checkJob() {
            valid= true;
            
            var selectedjob=$('input[name=jobSelect]:checked').val();
            if( !selectedjob ) {
                valid=false;
            }
            
            return valid;
        }
        
        //clic sur le bouton de validation de l'étape de choix du métier
        $('#button-infos-metier').click(function () {
            var validJob=checkJob();
            
            if( validJob==false ) {
                $('#choix-metier').children(".msg-error-valid").show().text("Veuillez sélectionner un métier");
                $('html, body').animate({
                        scrollTop: $('#choix-metier').offset().top
                    }, 600);
            } else {
                //hide error message
                $('#choix-metier').children(".msg-error-valid").hide().text("");
                
                //init qualif section
                var selectedjob=$('input[name=jobSelect]:checked').val();
                hideQualifElements();
                if(selectedjob=='4') {
                    checkAssMat();
                }
                else if(selectedjob=='1408') {
                    checkGP();
                }
                
                //filled selected job
                $('#selected-job').text($('label[for="job_' + selectedjob + '"]').html());
                //show/hide form section
                hideFormSection('#compte');
                hideFormSection('#choix-metier');
                showFormSection('#qualification');
            }
            
            
        });
        
        //clic sur le bouton de soummission du formulaire
        function checkQualif() {
            valid=true;
            
            //vérification s'il y a des champs requis non rempli
            $("#qualification .field-req input[type='text']").each(function () {
            
                if($(this).val() == '') {
                    $(this).parents(".field-req").next(".msg-error-valid").fadeIn().text("Veuillez remplir ce champ");
                    valid= false;
                } else {
                    $(this).parents(".field-req").next(".msg-error-valid").hide().text("");
                }
            });
            
              
            //experience 
            if($("#experience option[value='0']").is(":checked")) {
                $("#experience").parents(".field-req").next(".msg-error-valid").fadeIn().text("Veuillez sélectionner une valeur");
                valid= false;
            } else {
                $("#experience").parents(".field-req").next(".msg-error-valid").hide().text("");
            }
       
            //validation de l'adresse
            if ($("#list-adress").html()==""){
                $("#list-adress").next(".msg-error-valid").fadeIn().text("Veuillez valider l'adresse");
                valid=false;
            } else if ($("#list-adress").html()!=""){
                if($("input[type=radio][name=geoadresse]:checked").length!=1) {
                    $("input[type=radio][name=geoadresse]").parents(".field-req").next(".msg-error-valid").fadeIn().text("Veuillez valider l'adresse");
                    valid=false;
                } else {
                    $("input[type=radio][name=geoadresse]").parents(".field-req").next(".msg-error-valid").hide().text("");
                }
            } 
        
            //validation du format de la durée hebdomadaire 
            if ($("#durehebdojs").val() != '') { 
                if(!$("#durehebdojs").val().match(/^[0-9.]*$/i)) {
                    $("#durehebdojs").parents(".field-check").next(".msg-error-valid").fadeIn().text("Le format n'est pas bon. Veuillez saisir un nombre");
                    valid=false;
                } else {
                    $("#durehebdojs").parents(".field-check").next(".msg-error-valid").hide().text("");
                }
            }
            
            //validation du format du taux horaire
            if ( $("#tauxhoraire").val() != '' ) {
                if(!$("#tauxhoraire").val().match(/^[0-9.]*$/i)) {
                    $("#tauxhoraire").parents(".field-check").next(".msg-error-valid").fadeIn().text("Le format n'est pas bon. Veuillez saisir un nombre");
                    valid=false;
                } else {
                    $("#tauxhoraire").parents(".field-check").next(".msg-error-valid").hide().text("");
                }
            }
        
            var selectedmetier = $('input[name=jobSelect]:checked').val();
            var type_compte = $('#type_compte').val();
            if (selectedmetier=='1408'){
                
                if(type_compte=="EMP") {
                    if($("input[type=radio][name=dejanounou]:checked").length !=1) {
                        alert("Avez vous une garde d\'enfants ?");
                        valid=false;
                    }
                }
                
                if($("input[type=radio][name=dejafamille]:checked").length !=1) {
                    alert("Avez vous une famille ?");
                    valid=false;
                }
            
                if(type_compte=="SAL") {
                    
                    var collectionsal = document.getElementById("ageBlock").getElementsByTagName('INPUT');
                    veriage1=0;
                    for ( var x=0; x < collectionsal.length; x++ ) {
                        if (collectionsal[x].checked==true){
                            veriage1=1;
                            break;
                        }
                    }
                    if (veriage1!=1){
                        alert("Merci de selectionner l\'age des enfants.");
                        valid=false;
                    }
                
                    var nbenfant = document.getElementById("nbenfantsBloc");
                    if (nbenfant.style.display=="block"){
                        if($("#listNumOfChildren option[value='0']").is(":checked")) {
                            $("#listNumOfChildren").parents(".field-req").next(".msg-error-valid").fadeIn().text("Veuillez sélectionner une valeur");
                            valid= false;
                        } else {
                            $("#listNumOfChildren").parents(".field-req").next(".msg-error-valid").hide().text("");
                        }
                    }
                
                    var cadrefamille = document.getElementById("postalCodeBlock");
                    if (cadrefamille.style.display=="block"){
                        var chp_ville = document.getElementById("gp_ville").value;
                        if (chp_ville==""){
                            alert("Merci de saisir la ville de votre famille");
                            valid=false;
                        }
                        var chp_cpo = document.getElementById("gp_codepostal").value;
                        if (chp_cpo==""){
                            alert("Merci de saisir le code postal de votre famille");
                            valid=false;
                        }
                        if (document.getElementById("message2").innerHTML==""){
                            alert("Merci de valider l\'adresse de votre famille.");
                            valid=false;
                        } else if (document.getElementById("message2").innerHTML!=""){
                            if($("input[type=radio][name=geoadresse2]:checked").length!=1) {
                                alert("Merci de valider l\'adresse de votre famille.");
                                valid=false;
                            }
                        }
                    }
                } else if(type_compte=="EMP") {
                    var collectionsal = document.getElementById("ageBlock").getElementsByTagName('INPUT');
                    veriage1=0;
                    for (var x=0; x<collectionsal.length; x++) {
                        if (collectionsal[x].checked==true){
                            veriage1=1;
                            break;
                        }
                    }
                    if (veriage1!=1){
                        alert("Merci de selectionner l\'age des enfants.");
                        valid=false;
                    }
                   
                    
                    if($("#listNumOfChildren option[value='0']").is(":checked")) {
                        $("#listNumOfChildren").parents(".field-req").next(".msg-error-valid").fadeIn().text("Veuillez sélectionner une valeur");
                        valid= false;
                    } else {
                        $("#listNumOfChildren").parents(".field-req").next(".msg-error-valid").hide().text("");
                    }
                    
                    
                    var cadrefamille = document.getElementById("postalCodeBlock");
                    if (cadrefamille.style.display=="block"){
                        var chp_ville = document.getElementById("gp_ville").value;
                        if (chp_ville==""){
                            alert("Merci de saisir la ville de votre famille");
                            valid=false;
                        }
                        var chp_cpo = document.getElementById("gp_codepostal").value;
                        if (chp_cpo==""){
                            alert("Merci de saisir le code postal de votre famille");
                            valid=false;
                        }
                        if (document.getElementById("message2").innerHTML==""){
                            alert("Merci de valider l'adresse de votre famille.");
                           valid=false;
                        } else if (document.getElementById("message2").innerHTML!=""){
                            if($("input[type=radio][name=geoadresse2]:checked").length!=1) {
                                alert("Merci de valider l'adresse de votre famille.");
                                valid=false;
                            }
                        }
                    }
                    
                    
                }
            
            }
            
            return valid;
        };
        
        $("#conditions-submit").click(function() {
            var valid=true;
            var validCompte=checkInfosCompte();
            var validJob=checkJob();
            var validQualif=checkQualif();
            
            //vérification des sections
            if(validCompte===false) {
                showFormSection('#compte');
                valid=false;
            }
            if(validJob===false) {
                showFormSection('#choix-metier');
                valid=false;
            }
            if(validQualif===false) {
                showFormSection('#qualification');
                valid=false;
            }
            
            //placement du focus
            if(validCompte===false) {
                $('html, body').animate({
                        scrollTop: $('#compte').offset().top
                    }, 600);
            } else if(validJob===false) {
                $('html, body').animate({
                        scrollTop: $('#choix-metier').offset().top
                    }, 600);
            } else if(validQualif===false) {
                $('html, body').animate({
                        scrollTop: $('#qualification').offset().top
                    }, 600);
            }
                
            return valid;
            
        });
        
});
