<?php
?>

                    <div id="qualification">
                        <div class="qualif-intro">
                            <p><span class="txt-bold">Métier choisi : </span><span id='selected-job'></span></p>
                        </div>
                        <div class="bloc-field-form" id="numagrement">
                            <label class="field-label" for="txtInputId01">Numéro d'agrément
                                <span class="tipHelp" title="L'obtention de l'agrément est validée par un document officiel.
                                      Vous devez absolument fournir ce document aux parents employeurs lors de votre entretien.">
                                    <img class="tipHelp" src="<?php echo plugins_url('/img/tooltip.png', __DIR__ . "/../../") ?>"
                                         alt="tooltip" tilte="" />
                                </span>
                            </label>
                            <div class="field-value">
                                <input class="input-style" id="txtInputId01" name="agrement"
                                       value="<?php
                                       if (isset($_SESSION['officer-inscription']['agrement'])) {
                                           echo $_SESSION['officer-inscription']['agrement'];
                                       }
                                       ?>" />

                            </div>
                            <?php
                            if (isset($_SESSION['officer-inscription']['form-error']['agrement'])) {
                                ?>
                                <div class="error-valid">
                                    <?php
                                    echo $_SESSION['officer-inscription']['form-error']['agrement'];
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="bloc-field-form" id="partedateagre">
                            <?php
                            if (isset($_SESSION['officer-inscription']['dateagrement'])) {
                                $dateagrement = $_SESSION['officer-inscription']['dateagrement'];
                            } else {
                                $dateagrement = '00/00/0000';
                            }
                            if ($dateagrement == '00/00/0000') {
                                $dateagrement = '';
                            }
                            ?>
                            <label class="field-label" for="dateagrement">Date d’obtention</label>
                            <div class="field-value">
                                <input class="input-style datepicker-full" id="dateagrement"  name="dateagrement"
                                       value="<?php echo $dateagrement ?>" />
                            </div>
                            <?php
                            if (isset($_SESSION['officer-inscription']['form-error']['dateagrement'])) {
                                ?>
                                <div class="error-valid">
                                    <?php
                                    echo $_SESSION['officer-inscription']['form-error']['dateagrement'];
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <!-- garde partagée -->
                        <?php
                            if ($type_compte == "emp") {
                                ?>
                                <div id="tr_nounou">
                                    <div class="bloc-field-form">
                                            <label class="field-label-inline">
                                                J'ai déja une garde d'enfant : <span class="field-required">*</span></label>
                                            <div class="field-value-inline">
                                                <input type="radio" name="dejanounou" id="bt_dejanounou1" value="1"
                                                    <?php if((isset($_SESSION['officer-inscription']['dejanounou'])
                                                        && $_SESSION['officer-inscription']['dejanounou']==1)
                                                        ) {
                                                        echo "checked='checked'";

                                                    } ?>
                                                />
                                                <label for="bt_dejanounou1" >oui</label>
                                                <input type="radio" name="dejanounou" id="bt_dejanounou2" value="0"
                                                    <?php if((isset($_SESSION['officer-inscription']['dejanounou'])
                                                        && $_SESSION['officer-inscription']['dejanounou']==0) ) {
                                                        echo "checked='checked'";

                                                    } ?> />
                                                <label for="bt_dejanounou2" >non</label>
                                            </div>
                                            <?php
                                            if (isset($_SESSION['officer-inscription']['form-error']['dejanounou'])) {
                                                ?>
                                                <div class="error-valid">
                                                    <?php
                                                    echo $_SESSION['officer-inscription']['form-error']['dejanounou'];
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <div id="tr_famille">
                                <div class="bloc-field-form">
                                        <label class="field-label-inline">J'ai déja une famille : <span class="field-required">*</span></label>
                                        <div class="field-value-inline">
                                            <input type="radio" name="dejafamille" id="bt_dejafamille1" value="1"
                                                <?php if((isset($_SESSION['officer-inscription']['dejafamille'])
                                                    && $_SESSION['officer-inscription']['dejafamille']==1) ){
                                                    echo "checked='checked'";

                                                } ?>
                                            />
                                            <label for="bt_dejafamille1" >oui</label>
                                            <input type="radio" name="dejafamille" id="bt_dejafamille2" value="0"
                                                <?php if((isset($_SESSION['officer-inscription']['dejafamille'])
                                                    && $_SESSION['officer-inscription']['dejafamille']==0) ){
                                                    echo "checked='checked'"; } ?>
                                            />
                                            <label for="bt_dejafamille2" >non</label>
                                        </div>
                                        <?php
                                        if (isset($_SESSION['officer-inscription']['form-error']['dejafamille'])) {
                                            ?>
                                            <div class="error-valid">
                                                <?php
                                                echo $_SESSION['officer-inscription']['form-error']['dejafamille'];
                                                ?>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                </div>
                            </div>
                            <div id="cadregp" >
                                <div id="postalCodeBlock" class="postalCodeBlock">
                                    <p>Validez le code postal et la ville de la famille</p>
                                    <div class="bloc-field-form">
                                        <div class="bloc-field-inline">
                                            <label class="field-label" for="gp_codepostal">
                                                Code postal <span class="field-required">*</span></label>
                                            <div class="field-value">
                                                <input type="text" class="input-style" name="gp_codepostal" id="gp_codepostal"
                                                       value="<?php
                                                        if(isset($_SESSION['officer-inscription']['gp_codepostal']) ) {
                                                            echo $_SESSION['officer-inscription']['gp_codepostal'];
                                                        }
                                                        ?>" />
                                            </div>
                                            <?php
                                            if(isset($_SESSION['officer-inscription']['form-error']['gp_codepostal'])) {
                                                ?>
                                                <div class="error-valid">
                                                    <?php
                                                    echo $_SESSION['officer-inscription']['form-error']['gp_codepostal'];
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>

                                        <div class="bloc-field-inline">
                                            <label class="field-label" for="gp_ville">Ville<span class="field-required">*</span></label>
                                            <div class="field-value">
                                                <input type="text" class="input-style" name="gp_ville" id="gp_ville"
                                                       value="<?php
                                                        if (isset($_SESSION['officer-inscription']['gp_ville'])) {
                                                            echo $_SESSION['officer-inscription']['gp_ville'];
                                                        }
                                                        ?>" />
                                            </div>
                                            <?php
                                            if (isset($_SESSION['officer-inscription']['form-error']['gp_ville'])) {
                                                ?>
                                                <div class="error-valid">
                                                    <?php
                                                    echo $_SESSION['officer-inscription']['form-error']['gp_ville'];
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <div class="bloc-field-form">
                                        <label class="field-label-inline">Localisation</label>
                                        <div class="field-value-inline">
                                            <div class="select-style">
                                                <select name="gp_localisation" id="gp_localisation">
                                                    <?php
                                                    if ((isset($_SESSION['officer-inscription']['gp_localisation']) &&
                                                        $_SESSION['officer-inscription']['gp_localisation']== 'FRANCE') ) {
                                                        $checked = 'selected="selected"';
                                                    } else {
                                                        $checked = "";
                                                    }
                                                    echo '<option value="FRANCE" ' . $checked . '>France m&eacute;tropolitaine</option>';
                                                    if ((isset($_SESSION['officer-inscription']['gp_localisation']) &&
                                                        $_SESSION['officer-inscription']['gp_localisation'] == 'GUF') ) {
                                                        $checked = 'selected="selected"';
                                                    } else {
                                                        $checked = "";
                                                    }
                                                    echo '<option value="GUF" ' . $checked . '>Guyane</option>';
                                                    if ((isset($_SESSION['officer-inscription']['gp_localisation']) &&
                                                        $_SESSION['officer-inscription']['gp_localisation'] == 'GLP') ) {
                                                        $checked = 'selected="selected"';
                                                    } else {
                                                        $checked = "";
                                                    }
                                                    echo '<option value="GLP" ' . $checked . '>Guadeloupe</option>';
                                                    if ((isset($_SESSION['officer-inscription']['gp_localisation']) &&
                                                        $_SESSION['officer-inscription']['gp_localisation'] == 'MTQ') ) {
                                                        $checked = 'selected="selected"';
                                                    } else {
                                                        $checked = "";
                                                    }
                                                    echo '<option value="MTQ" ' . $checked . '>Martinique</option>';
                                                    if ((isset($_SESSION['officer-inscription']['gp_localisation']) &&
                                                        $_SESSION['officer-inscription']['gp_localisation'] == 'REU') ) {
                                                        $checked = 'selected="selected"';
                                                    } else {
                                                        $checked = "";
                                                    }
                                                    echo '<option value="REU" ' . $checked . '>R&eacute;union</option>';
                                                    if ((isset($_SESSION['officer-inscription']['gp_localisation']) &&
                                                        $_SESSION['officer-inscription']['gp_localisation'] == 'PYF') ) {
                                                        $checked = 'selected="selected"';
                                                    } else {
                                                        $checked = "";
                                                    }
                                                    echo '<option value="PYF" ' . $checked . '>Polyn&eacute;sie Fran&ccedil;aise</option>';
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <?php
                                        if (isset($_SESSION['officer-inscription']['form-error']['gp_localisation'])) {
                                            ?>
                                            <div class="error-valid">
                                                <?php
                                                echo $_SESSION['officer-inscription']['form-error']['gp_localisation'];
                                                ?>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <input type="button" value="Valider l'adresse" onClick="showAddress2(); return false;" />
                                    <div class="bloc-field-form">
                                        <div id="message2" class="field-req field-value">
                                        </div>
                                        <div class="msg-error-valid"></div>
                                    </div>
                                </div><!-- postal block -->
                                <div id="nbenfantsBloc">
                                    <div class="bloc-field-form">
                                        <label for="listNumOfChildren" class="field-label-inline">Nombre d'enfants gardés
                                            <span class="field-required">*</span></label>
                                        <div class="field-req field-value-inline">
                                            <div class="select-style">
                                                <select name="annonce_nbenfgardes" id="listNumOfChildren" >
                                                    <option value="0">Sélectionnez</option>
                                                    <?php
                                                    if ((isset($_SESSION['officer-inscription']['annonce_nbenfgardes'])
                                                        &&  $_SESSION['officer-inscription']['annonce_nbenfgardes']== '1') ) {
                                                        $selected = ' selected="selected"';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                    echo '<option value="1"' . $selected . '>1</option>';
                                                    if ((isset($_SESSION['officer-inscription']['annonce_nbenfgardes'])
                                                        && $_SESSION['officer-inscription']['annonce_nbenfgardes'] == '2') ) {
                                                        $selected = ' selected="selected"';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                    echo '<option value="2"' . $selected . '>2</option>';
                                                    if ((isset($_SESSION['officer-inscription']['annonce_nbenfgardes'])
                                                        && $_SESSION['officer-inscription']['annonce_nbenfgardes'] == '3') ) {
                                                        $selected = ' selected="selected"';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                    echo '<option value="3"' . $selected . '>3</option>';
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="msg-error-valid"></div>
                                        <?php
                                        if (isset($_SESSION['officer-inscription']['form-error']['nbenfgardes'])) {
                                            ?>
                                            <div class="error-valid">
                                                <?php
                                                echo $_SESSION['officer-inscription']['form-error']['nbenfgardes'];
                                                ?>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div><!-- nombre d'enfants -->


                                <div id="ageBlock" class="ageBlock">
                                    <div class="bloc-field-form">
                                        <label class="field-label-inline">Age des enfants gardés</label>
                                        <div class="field-value-inline ageList">
                                            <div>
                                                <input type="checkbox" name="agenfants1" id="agenfants1" value="012"
                                                    <?php if((isset($_SESSION['officer-inscription']['agenfants1'])
                                                        && $_SESSION['officer-inscription']['agenfants1'] == '012') ) {
                                                        echo 'checked="checked"';

                                                    } ?>
                                                />
                                                <label for="agenfants1">De 0 à 12 mois</label>
                                            </div>
                                            <div>
                                                <input type="checkbox" name="agenfants2" id="agenfants2" value="1218"
                                                    <?php if((isset($_SESSION['officer-inscription']['agenfants2'])
                                                        && $_SESSION['officer-inscription']['agenfants2'] == '1218') ) {
                                                        echo 'checked="checked"';

                                                    } ?>
                                                />
                                                <label for="agenfants2" >De 12 à 18 mois</label>
                                            </div>
                                            <div>
                                                <input type="checkbox" name="agenfants3" id="agenfants3" value="1836"
                                                    <?php if((isset($_SESSION['officer-inscription']['agenfants3'])
                                                        && $_SESSION['officer-inscription']['agenfants3'] == '1836') ){
                                                            echo 'checked="checked"';

                                                        } ?>
                                                />
                                                <label for="agenfants3" >De 18 à 36 mois</label>
                                            </div>
                                            <div>
                                                <input type="checkbox" name="agenfants4" id="agenfants4" value="36"
                                                    <?php if((isset($_SESSION['officer-inscription']['agenfants41'])
                                                        && $_SESSION['officer-inscription']['agenfants4'] == '36') ) {
                                                        echo 'checked="checked"'; }
                                                        ?>
                                                />
                                                <label for="agenfants4" >De 3 à 6 ans</label>
                                            </div>
                                            <div>
                                                <input type="checkbox" name="agenfants5" id="agenfants5" value="68"
                                                    <?php if((isset($_SESSION['officer-inscription']['agenfants5'])
                                                        && $_SESSION['officer-inscription']['agenfants5'] == '68') ){
                                                        echo 'checked="checked"';

                                                    } ?>
                                                />
                                                <label for="agenfants5" >De 6 à 8 ans</label>
                                            </div>
                                            <div>
                                                <input type="checkbox" name="agenfants6" id="agenfants6" value="8"
                                                    <?php if((isset($_SESSION['officer-inscription']['agenfants6'])
                                                        && $_SESSION['officer-inscription']['agenfants6'] == '8') ) {
                                                        echo 'checked="checked"'; }
                                                        ?>
                                                />
                                                <label for="agenfants6" >Plus de 8 ans</label>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- age des enfants  -->

                            </div><!-- cadre gp -->
                            <!-- fin garde partagée -->
                            <div class="bloc-field-form">
                                <label class="field-label" for="experience">
                                    <?php
                                    if ($type_compte == 'sal') {
                                        echo "Expérience professionnelle";
                                    } else {
                                        echo "Expérience demandée";
                                    }
                                    ?>
                                    <span class="field-required">*</span>
                                </label>
                                <div class="field-req field-value">
                                    <div class="select-style">
                                        <select id="experience" name="experience" >
                                            <option value="0">Sélectionnez un niveau d'expérience</option>
                                            <?php
                                            if ((isset($_SESSION['officer-inscription']['experience']) &&
                                                $_SESSION['officer-inscription']['experience'] == 'M5') ) {
                                                $selected = ' selected';
                                            } else {
                                                $selected = '';
                                            }
                                            echo '<option value="M5"' . $selected . '>moins de 2 ans</option>';
                                            if ((isset($_SESSION['officer-inscription']['experience']) &&
                                                $_SESSION['officer-inscription']['experience'] == 'E510')  ) {
                                                $selected = ' selected';
                                            } else {
                                                $selected = '';
                                            }
                                            echo '<option value="E510"' . $selected . '>2 &agrave; 5 ans</option>';
                                            if ((isset($_SESSION['officer-inscription']['experience']) &&
                                                $_SESSION['officer-inscription']['experience'] == 'P10') ) {
                                                $selected = ' selected';
                                            } else {
                                                $selected = '';
                                            }
                                            echo '<option value="P10"' . $selected . '>plus de 5 ans</option>';
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="msg-error-valid"></div>
                                <?php
                                if (isset($_SESSION['officer-inscription']['form-error']['experience'])) {
                                    ?>
                                    <div class="error-valid">
                                        <?php
                                        echo $_SESSION['officer-inscription']['form-error']['experience'];
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>

                            <div class="bloc-field-form bloc_desc_annonce">
                                <p class="text-bold">
                                    <img src="<?php echo plugins_url("img/picto_redac.png", __DIR__ . "/../../"); ?>" alt="" />Votre annonce
                                </p>
                                <p>Rédigez votre annonce en précisant toutes les
                                    informations que vous jugez utiles (horaires souhaitées,
                                    diplômes, formations etc..) – saisie limitée à 255 caractères
                                </p>
                                <div class="field-value">
                                    <textarea name="particularites" id="particularites" rows="5" cols="40" maxlength="255"><?php
                                        if(isset($_SESSION['officer-inscription']['particularites'])) {
                                            echo $_SESSION['officer-inscription']['particularites'];
                                        }
                                    ?></textarea>
                                </div>
                                <?php
                                if (isset($_SESSION['officer-inscription']['form-error']['particularites'])) {
                                    ?>
                                    <div class="error-valid">
                                        <?php
                                        echo $_SESSION['officer-inscription']['form-error']['particularites'];
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="bloc-field-form">
                                <label class="field-label" for="tauxhoraire">
                                    <?php
                                    if ($type_compte == 'sal') {
                                        echo "Taux horaires brut souhaité ";
                                    } else {
                                        echo "Taux brut proposé <br>(hors Cesu, hors ancienneté) ";
                                    }
                                    ?>
                                    <span class="field-required">*</span> €/heure
                                    <span class="tipHelp"
                                          title="A compter du 1er janvier 2017, le SMIC est porté à 9,76 € bruts par heure pour
                                          le salarié du particulier employeur hors Cesu, hors ancienneté">
                                        <img class="tipHelp" src="<?php echo plugins_url("img/tooltip.png", __DIR__ . "/../../") ?>"
                                             alt="tooltip" tilte="" />
                                    </span>
                                </label>
                                <div class="field-req field-value field-check">
                                    <input type="text" name="tauxhoraire" id="tauxhoraire" class="input-style input-mini"
                                           value="<?php
                                            if(isset($_SESSION['officer-inscription']['tauxhoraire'])) {
                                               echo $_SESSION['officer-inscription']['tauxhoraire'];
                                            }
                                           ?>"
                                    />
                                </div>
                                <div class="msg-error-valid"></div>
                                <?php
                                if (isset($_SESSION['officer-inscription']['form-error']['tauxhoraire'])) {
                                    ?>
                                    <div class="error-valid">
                                        <?php
                                        echo $_SESSION['officer-inscription']['form-error']['tauxhoraire'];
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>

                            <div class="bloc-field-form">
                                <div class="bloc-field-inline">
                                    <label class="field-label" for="dateprisefonction">
                                        <?php
                                        if ($type_compte == 'sal') {
                                            echo "Date de disponibilité";
                                        } else {
                                            echo "Date de prise de poste souhaitée";
                                        }
                                        ?>
                                        <span class="field-required">*</span>
                                    </label>
                                    <div class="field-req field-value">
                                        <?php
                                        if (isset($_SESSION['officer-inscription']['dateprisefonction'])) {
                                            $dateprisefonction =$_SESSION['officer-inscription']['dateprisefonction'];
                                        } else {
                                            $dateprisefonction = date("d/m/Y");
                                        }
                                        ?>
                                        <input id="dateprisefonction" name="dateprisefonction" type="text"
                                               class="input-style input-mini datepicker-full" value="<?php echo $dateprisefonction;?>" >
                                    </div>
                                    <div class="msg-error-valid"></div>
                                    <?php
                                    if (isset($_SESSION['officer-inscription']['form-error']['dateprisefonction'])) {
                                        ?>
                                        <div class="error-valid">
                                            <?php
                                            echo $_SESSION['officer-inscription']['form-error']['dateprisefonction'];
                                            ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>

                                <div class="bloc-field-inline">
                                    <label class="field-label" for="durehebdojs">Durée hebdomadaire (h/semaine)</label>
                                    <div class="field-check field-value">
                                        <input type="text" name="durehebdojs" id="durehebdojs" class="input-style input-mini"
                                               value="<?php
                                                if (isset($_SESSION['officer-inscription']['durehebdojs'])) {
                                                    echo $_SESSION['officer-inscription']['durehebdojs'];
                                               }
                                               ?>"/>
                                        heure/semaine
                                    </div>
                                    <div class="msg-error-valid"></div>
                                    <?php
                                    if (isset($_SESSION['officer-inscription']['form-error']['durehebdojs'])) {
                                        ?>
                                        <div class="error-valid">
                                            <?php
                                            echo $_SESSION['officer-inscription']['form-error']['durehebdojs'];
                                            ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div id="enfants">
                                <p class="text-bold">Accueil de l'enfant</p>
                                <div class="childcareSelect bloc-field-form">
                                    <div>
                                        <label class="field-label-inline" for="lstLessThanTwoYears">Moins de 2 ans (Crèche)</label>
                                        <div class="field-value-inline">
                                            <div class="select-style">
                                                <select name="nbenfants1" id="lstLessThanTwoYears" >
                                                    <?php
                                                    if ((isset( $_SESSION['annonce']['annonce_nbenfants1']) &&
                                                        $_SESSION['annonce']['annonce_nbenfants1'] == '0') )  {
                                                        $selected = ' selected="selected"';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                    echo '<option value="0" ' . $selected . '>0</option>';
                                                    if ((isset($_SESSION['annonce']['annonce_nbenfants1']) &&
                                                        $_SESSION['annonce']['annonce_nbenfants1'] == '1') ) {
                                                        $selected = ' selected="selected"';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                    echo '<option value="1" ' . $selected . '>1</option>';
                                                    if ((isset($_SESSION['officer-inscription']['nbenfants1']) &&
                                                        $_SESSION['annonce']['annonce_nbenfants1'] == '2') )  {
                                                        $selected = ' selected="selected"';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                    echo ' <option value="2" ' . $selected . '>2</option>';
                                                    if ((isset($_SESSION['officer-inscription']['nbenfants1']) &&
                                                        $_SESSION['annonce']['annonce_nbenfants1'] == '3') ) {
                                                        $selected = ' selected="selected"';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                    echo ' <option value="3" ' . $selected . '>3</option>';
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <?php
                                        if (isset($_SESSION['officer-inscription']['form-error']['nbenfants1'])) {
                                            ?>
                                            <div class="error-valid">
                                                <?php
                                                echo $_SESSION['officer-inscription']['form-error']['nbenfants1'];
                                                ?>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div>
                                        <label for="listTwoToFive" class="field-label-inline">De 2 à 5 ans (Maternel)</label>
                                        <div class="field-value-inline">
                                            <div class="select-style">
                                                <select name="nbenfants2" id="listTwoToFive" >
                                                    <?php
                                                    if ((isset($_SESSION['officer-inscription']['nbenfants2']) &&
                                                        $_SESSION['officer-inscription']['nbenfants2'] == '0') ) {
                                                        $selected = ' selected="selected"';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                    echo '<option value="0" ' . $selected . '>0</option>';
                                                    if ((isset($_SESSION['officer-inscription']['nbenfants2']) &&
                                                        $_SESSION['officer-inscription']['nbenfants2'] == '1') ) {
                                                        $selected = ' selected="selected"';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                    echo '<option value="1" ' . $selected . '>1</option>';
                                                    if ((isset($_SESSION['officer-inscription']['nbenfants2']) &&
                                                        $_SESSION['officer-inscription']['nbenfants2'] == '2') ) {
                                                        $selected = ' selected="selected"';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                    echo ' <option value="2" ' . $selected . '>2</option>';
                                                    if ((isset($_SESSION['officer-inscription']['nbenfants2']) &&
                                                        $_SESSION['officer-inscription']['nbenfants2'] == '3') ) {
                                                        $selected = ' selected="selected"';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                    echo ' <option value="3" ' . $selected . '>3</option>';
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <?php
                                        if (isset($_SESSION['officer-inscription']['form-error']['nbenfants2'])) {
                                            ?>
                                            <div class="error-valid">
                                                <?php
                                                echo $_SESSION['officer-inscription']['form-error']['nbenfants2'];
                                                ?>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div>
                                            <label for="lstSixToEight" class="field-label-inline">De 6 à 8 ans (Primaire)</label>
                                            <div class="field-value-inline">
                                                <div class="select-style">
                                                <select name="nbenfants3" id="lstSixToEight" >
                                                    <?php
                                                    if ((isset($_SESSION['officer-inscription']['nbenfants3']) &&
                                                        $_SESSION['officer-inscription']['nbenfants3'] == '0') ) {
                                                        $selected = ' selected="selected"';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                    echo '<option value="0" ' . $selected . '>0</option>';
                                                    if ((isset($_SESSION['officer-inscription']['nbenfants3']) &&
                                                        $_SESSION['officer-inscription']['nbenfants3'] == '1') ) {
                                                        $selected = ' selected="selected"';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                    echo '<option value="1" ' . $selected . '>1</option>';
                                                    if ((isset($_SESSION['officer-inscription']['nbenfants3']) &&
                                                        $_SESSION['officer-inscription']['nbenfants3'] == '2') ) {
                                                        $selected = ' selected="selected"';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                    echo ' <option value="2" ' . $selected . '>2</option>';
                                                    if ((isset($_SESSION['officer-inscription']['nbenfants3']) &&
                                                        $_SESSION['officer-inscription']['nbenfants3'] == '3') ) {
                                                        $selected = ' selected="selected"';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                    echo ' <option value="3" ' . $selected . '>3</option>';
                                                    ?>
                                                </select>
                                                </div>
                                            </div>
                                            <?php
                                            if (isset($_SESSION['officer-inscription']['form-error']['nbenfants3'])) {
                                                ?>
                                                <div class="error-valid">
                                                    <?php
                                                    echo $_SESSION['officer-inscription']['form-error']['nbenfants3'];
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                    </div>
                                    <div>
                                            <label for="lstBeyondEightYears" class="field-label-inline">Au delà de 8 ans</label>
                                            <div class="field-value-inline">
                                                <div class="select-style">
                                                    <select name="nbenfants4" id="lstBeyondEightYears" class="simpleSelect simpleSelect07  unit">
                                                        <?php
                                                        if ((isset($_SESSION['officer-inscription']['nbenfants4']) &&
                                                            $_SESSION['officer-inscription']['nbenfants4'] == '0') ) {
                                                            $selected = ' selected="selected"';
                                                        } else {
                                                            $selected = '';
                                                        }
                                                        echo '<option value="0" ' . $selected . '>0</option>';
                                                        if ((isset($_SESSION['officer-inscription']['nbenfants4']) &&
                                                            $_SESSION['officer-inscription']['nbenfants4'] == '1') ) {
                                                            $selected = ' selected="selected"';
                                                        } else {
                                                            $selected = '';
                                                        }
                                                        echo '<option value="1" ' . $selected . '>1</option>';
                                                        if ((isset($_SESSION['officer-inscription']['nbenfants4']) &&
                                                            $_SESSION['officer-inscription']['nbenfants4'] == '2') ) {
                                                            $selected = ' selected="selected"';
                                                        } else {
                                                            $selected = '';
                                                        }
                                                        echo ' <option value="2" ' . $selected . '>2</option>';
                                                        if ((isset($_SESSION['officer-inscription']['nbenfants4']) &&
                                                            $_SESSION['officer-inscription']['nbenfants4'] == '3') ) {
                                                            $selected = ' selected="selected"';
                                                        } else {
                                                            $selected = '';
                                                        }
                                                        echo ' <option value="3" ' . $selected . '>3</option>';
                                                        ?>
                                                    </select>
                                                </div>

                                            </div>
                                            <?php
                                            if (isset($_SESSION['officer-inscription']['form-error']['nbenfants4'])) {
                                                ?>
                                                <div class="error-valid">
                                                    <?php
                                                    echo $_SESSION['officer-inscription']['form-error']['nbenfants4'];
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                    </div>
                                </div>
                            </div><!-- bloc accueil enfant -->
                            <div class="addContact">
                                    <p class="txt-bold">Adresse du lieu de travail <span class="field-required">*</span></p>
                                    <p>
                                        L’adresse du lieu de travail renseignée ci-après par défaut est l'adresse du lieu de résidence.
                                        Si l’adresse du lieu de travail est différente du lieu de résidence, nous vous remercions de la modifier.
                                    </p>
                                    <div class="bloc-field-form">
                                        <label for="job-adresse" class="field-label">Adresse</label>
                                        <div class="field-value">
                                            <input type="text" name="job_adresse" id="job-adresse" class="input-style"
                                                   value="<?php
                                                    if (isset($_SESSION['officer-inscription']['job_adresse'])) {
                                                        echo $_SESSION['officer-inscription']['job_adresse'];
                                                    }?>"
                                            />
                                        </div>
                                        <?php
                                            if (isset($_SESSION['officer-inscription']['form-error']['job_adresse'])) {
                                                ?>
                                                <div class="error-valid">
                                                    <?php
                                                    echo $_SESSION['officer-inscription']['form-error']['job_adresse'];
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                    </div>

                                    <div class="bloc-field-form">
                                        <div class="bloc-field-inline">
                                            <label for="job-codepostal" class="field-label">Code postal <span class="field-required">*</span></label>
                                            <div class="field-req field-value">
                                                <input type="text" name="job_codepostal" id="job-codepostal" class="input-style"
                                                       value="<?php
                                                        if (isset($_SESSION['officer-inscription']['job_codepostal'])) {
                                                            echo $_SESSION['officer-inscription']['job_codepostal'];
                                                        }?>"
                                                />
                                            </div>
                                            <div class="msg-error-valid"></div>
                                            <?php
                                            if (isset($_SESSION['officer-inscription']['form-error']['job_codepostal'])) {
                                                ?>
                                                <div class="error-valid">
                                                    <?php
                                                    echo $_SESSION['officer-inscription']['form-error']['job_codepostal'];
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="bloc-field-inline">
                                            <label for="job-ville" class="field-label">Ville</label>
                                            <div class="field-value">
                                                <input type="text" name="job_ville" id="job-ville" class="input-style"
                                                       value="<?php
                                                        if (isset($_SESSION['officer-inscription']['job_ville'])) {
                                                            echo $_SESSION['officer-inscription']['job_ville'];
                                                        }?>"
                                                />
                                            </div>
                                            <?php
                                            if (isset($_SESSION['officer-inscription']['form-error']['job_ville'])) {
                                                ?>
                                                <div class="error-valid">
                                                    <?php
                                                    echo $_SESSION['officer-inscription']['form-error']['job_ville'];
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <p>
                                        La validation de l’adresse du lieu de travail est obligatoire.
                                        Une fois validée,  vous devez sélectionner l’adresse affichée
                                        pour pouvoir finaliser le dépôt de l'annonce
                                    </p>
                                    <input type="button" value="Valider l'adresse du lieu de travail" onClick="showAddress(); return false;" />

                                    <div class="bloc-field-form">
                                        <div id="list-adress" class="field-req field-value">
                                        </div>
                                        <div class="msg-error-valid"></div>
                                    </div>
                            </div>

                            <div class="bloc-submit-form bloc-submit-inscription text-right">

                                <p id="valider">Merci de bien sélectionner votre adresse pour continuer</p>
                                <input type="submit" name="emploi" class="step-validation" value="Valider l'inscription" id="conditions-submit" />

                            </div>

                    </div>
