<?php
/**
 * Template Name: CESU 10 points
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

//enregistrement et récupération du cp de l'internaute
set_user_depcode();
$depCode=get_user_depcode();

get_header();
include(locate_template('plugin-form-cp.php'));
?>

<div class="content-central-column">
    <section>
        <div class="bloc-page-cesu bloc-cesu-oneblock">
             <div class="article-toolbar">
                <?php
                get_template_part('article-features-bar');
                get_template_part('small-social-links');
                ?>
            </div>
            <div class="wrap-clear"></div>

            <h1>Le CESU en 10 points</h1>
            <div class='cesu-table'>
                <div class='cesu-row'>
                     <div class="cesu-cell first-cesu-block">
                        <p class="text-bold text-upper">
                            L'emploi par chèque emploi service universel 
                            <span class="text-underlined">bancaire</span></p>
                        <p>
                            Les bénéficiaires de la Paje ne peuvent pas utiliser le
                            Cesu déclaratif.
                        </p>
                    </div>
                    <div class='cesu-cell cesu-sep-cell'></div>
                    <div class="cesu-cell second-cesu-block">
                        <p class="text-bold text-upper">
                            L'emploi par chèque emploi service universel
                            <span class="text-underlined">préfinancé</span>
                        </p>
                        <p>
                            Les bénéficiaires de la Paje peuvent utiliser le Cesu préfinancé pour
                            le versement de la rémunération du salarié 
                            mais pas pour la déclaration des salaires.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class='cesu-points'>
                <div class="title-section-cesu show-cesu-section">
                    <span class='cesu-section-number'>1.</span>
                    <p>Votre salarié peut-il être rémunéré par Cesu ?</p>
                </div>
                <div class="content-section-cesu">
                    <p class='text-bold'>Vous devez vous assurer que les tâches 
                        effectuées par votre salarié peuvent être rémunérées par Cesu.</p>
                    <div class='highlighted-text'>
                        Les emplois concernés sont ceux de la convention collective
                        nationale des salariés du particulier employeur :
                    </div>
                    <ul>
                        <li>tâches familiales ou ménagères,</li>
                        <li>la garde d'enfant,</li>
                        <li>l'assistance aux personnes âgées, en situation de handicap
                        ou aux personnes qui ont besoin d'une aide personnelle à leur domicile ...</li>
                        <li>les emplois de petit jardinage.</li>
                    </ul>
                    <p class='text-bold'>D'autres activités ont également été ouvertes à l'utilisation du Cesu</p>
                    <div class='highlighted-text'>
                        Activités effectuées exclusivement à domicile :
                    </div>
                    <ul>
                        <li>entretien de la maison et travaux ménagers,</li>
                        <li>petits travaux de jardinage, y compris les travaux de débroussaillage,</li>
                        <li>prestations de petit bricolage dites "hommes toutes mains",</li>
                        <li>garde d'enfant à domicile,</li>
                        <li>soutien scolaire à domicile et cours à domicile,</li>
                        <li>assistance informatique et Internet à domicile,</li>
                        <li>assistance administrative à domicile,</li>
                        <li>assistance aux personnes âgées ou aux autres personnes qui
                        ont besoin d'une aide personnelle à leur domicile, 
                        à l'exception d'actes de soins relevant d'actes médicaux,</li>
                        <li>assistance aux personnes en situation de handicap y compris les activités d'interprète en langue
                        des signes, de technicien de l'écrit et de codeur en langage parlé complété,</li>
                        <li>garde malade à l'exclusion des soins,</li>
                        <li>soins d'esthétique à domicile pour les personnes dépendantes,</li>
                        <li>maintenance, entretien et vigilance temporaires, à domicile,
                        de la résidence principale et secondaire</li>
                    </ul>
                    <div class='highlighted-text'>
                        Activités partiellement réalisées en dehors du domicile,
                        alors que la prestation principale de travail a lieu au domicile
                    </div>
                    <ul>
                        <li>préparation des repas à domicile, y compris le temps
                        passé aux commissions, livraison de repas ou de courses à domicile,</li>
                        <li>collecte et livraison à domicile de linge repassé,</li>
                        <li>aide à la mobilité et au transport de personnes ayant des difficultés
                        de déplacement lorsque cette activité est incluse dans une offre
                        de services d'assistance à domicile,</li>
                        <li>prestation de conduite de véhicule personnel des 
                        personnes dépendantes, du domicile au travail, sur le lieu de vacances,
                        pour les démarches administratives, accompagnement des enfants
                        et des personnes âgées ou en situation de handicap dans 
                        leurs déplacements en dehors de leur domicile (promenades, transports, actes de la vie courante)</li>
                        <li>soins et promenades d'animaux de compagnie, à l'exclusion des soins
                        vétérinaires et du toilettage, pour les personnes dépendantes.</li>
                    </ul>
                </div>
                
                <div class="title-section-cesu show-cesu-section">
                    <span class='cesu-section-number'>2.</span>
                    <p> Où se procurer des Cesu déclaratif ? Des titres Cesu (ou Cesu préfinancés) ? </p>
                </div>
                <div class="content-section-cesu">
                    <span class="text-bold">Pour  les Cesu déclaratifs</span>, 
                    deux possibilités se présentent :
                    <ul>
                    <li>
                        Soit vous demandez un dossier d'adhésion au Centre national 
                        du chèque emploi service universel auprès de votre 
                        agence bancaire.<br>
                        La banque vous adresse alors un chéquier papier 
                        composé de vingt chèques emploi service universel et 
                        vingt volets sociaux, qui vous permettront de faire 
                        une déclaration papier des salaires versés et des 
                        heures effectuées par votre salarié.
                    </li>
                    <li>
                        Soit vous vous inscrivez directement sur 
                        <a href="http://www.cesu.urssaf.fr/cesweb/infoadh.jsp" target="_blank">
                            le site Internet du Cesu.</a><br>
                        Vous recevrez dans les 48 heures un e-mail de confirmation 
                        de votre inscription. 
                        Dans cette hypothèse, vous rémunérez votre salarié par 
                        tout moyen de paiement (ex : chèque bancaire, virement…) et 
                        vous déclarez le salaire versé et les heures effectuées par 
                        votre salarié directement en ligne.
                    </li>
                    </ul>
                    <p>Dans les deux cas, vous remplissez une autorisation de 
                        prélèvement au profit du Cncesu qui prélèvera les 
                        cotisations sociales sur votre compte.
                    </p>
                    <p><span class="text-bold">Les titres Cesu (ou Cesu préfinancés)</span> 
                        sont délivrés par votre propre employeur, comité d'entreprise, 
                        mutuelle ou caisse de retraite, qui finance une partie 
                        ou la totalité du titre. Une partie peut donc rester à votre charge.
                    </p>

                </div>
                
                <div class="title-section-cesu show-cesu-section">
                    <span class='cesu-section-number'>3.</span>
                    <p> La rédaction du contrat de travail et l'accord du salarié</p>
                </div>
                <div class="content-section-cesu">
                    <p>La convention collective nationale des salariés du 
                        particulier employeur prévoit que la rédaction d'un 
                        contrat de travail est obligatoire pour tout emploi 
                        régulier de plus de 8 heures par semaine ou de plus de 
                        4 semaines consécutives. </p>
                    <div>
                        Depuis le 1er juin 2015, les modalités d'indemnisation 
                        des congés payés pour les particuliers employeurs
                        déclarant leur salarié par le biais du Cesu ont été
                        modifiées.  Ainsi, une distinction doit désormais être 
                        opérée : 
                        <ul>
                            <li><span class="text-bold">si le salarié est employé pour une durée inférieure 
                                ou égale à 32 heures mensuelles et est déclaré 
                                au Cesu en ligne OU quelque soit la durée du 
                                travail si il est déclaré par volet Cesu papier</span> : 
                                l'indemnité de congés payés reste versée par 
                                le biais d’une majoration du salaire horaire de 10%. 
                                Pour ces salariés, il n'y a donc pas de modification 
                                du mode de paiement des congés payés. 
                            </li>
                            <li>
                                <span class="text-bold"> si le salarié est employé pour une durée supérieure 
                                 à 32 heures mensuelles et est déclaré par le biais 
                                 du Cesu en ligne </span>: en principe, le paiement des congés 
                                 se fait au moment de leur prise et non plus par 
                                 majoration du salaire horaire de 10%. 
                            </li>
                        </ul>
                    </div>
                    <p>
                        Toutefois, en cas d’accord des parties, le versement de 
                        l'indemnité de congés payés par le biais de 
                        la majoration de salaire de 10% reste possible. 
                    </p>

                    
                </div>
                
                <div class="title-section-cesu show-cesu-section">
                    <span class='cesu-section-number'>4.</span>
                    <p>L'immatriculation de l'employeur</p>
                </div>
                <div class="content-section-cesu">
                    <p>L'envoi du premier volet social au Centre national du 
                        Cesu équivaut à votre immatriculation auprès de l'Urssaf.
                    </p>
                    <div>
                        Pour l'affiliation du salarié :
                        <ul>
                            <li> si vous avez déjà été particulier employeur et 
                                que vous êtes déjà titulaire d'un numéro Urssaf 
                                auprès du Cncesu, aucune démarche n'est à 
                                effectuer.
                            </li>
                            <li>si vous n'avez pas de numéro Urssaf, 
                                votre adhésion se fait automatiquement par transfert 
                                d'informations entre votre financeur de Cesu 
                                préfinancé (entreprise, mutuelle …) et l'émetteur du 
                                Cesu préfinancé.
                            </li>
                        </ul>
                    </div>    
                    <p> 
                        Le Centre national du Cesu vous adresse une autorisation
                        de prélèvement automatique des cotisations de votre compte.
                    </p>   
                </div>
                
                <div class="title-section-cesu show-cesu-section">
                   <span class='cesu-section-number'>5.</span>
                     <p>La déclaration du salarié à la caisse primaire d'Assurance Maladie (CPAM)</p>
                </div>
                <div class="content-section-cesu">
                    <p>
                        La déclaration du salarié se fait lors de l'envoi du 
                        premier volet social. Vous n'avez pas de déclaration à 
                        faire directement à la caisse primaire d'Assurance Maladie.
                        L'envoi du volet social permet une déclaration automatique
                        de votre salarié. 
                    </p>
                    <p>
                        Pour votre immatriculation ainsi que pour la déclaration 
                        de votre salarié à la caisse primaire d‘Assurance Maladie,
                        le volet social peut être envoyé par courrier ou peut être
                        complété directement sur 
                        <a href="http://www.cesu.urssaf.fr/cesweb/infoadh.jsp" target="_blank">
                            le site Internet du Cesu.
                        </a>
                    </p>

                </div>
                
                <div class="title-section-cesu show-cesu-section">
                     <span class='cesu-section-number'>6.</span>
                     <p>La déclaration de salaire</p>
                </div>
                <div class="content-section-cesu">
                    <p>
                        Lorsque vous rémunérez votre salarié par Cesu 
                        (Cesu déclaratif), vous avez l'obligation de déclarer 
                        le salaire en complétant le volet social. 
                        Vous devez le transmettre au Cncesu afin que celui-ci 
                        calcule le montant des cotisations dues. Cette formalité 
                        peut se faire directement sur le site Internet du 
                        <span class="text-bold">Cesu</span>.
                    </p>
                        
                    <div>
                        Le calendrier des démarches est le suivant : 
                        <ol>
                            <li>
                                A la fin du mois : vous réglez le salaire de votre 
                                salarié par Cesu déclaratif ou Cesu préfinancé. 
                                Attention, pour ce deuxième mode de paiement la somme 
                                à verser à votre salarié peut être différente de 
                                la valeur imprimée sur ce chèque, il sera donc
                                nécessaire de faire l'appoint. Pour ce faire, 
                                vous pouvez régler cette différence par Cesu déclaratif, 
                                par chèque bancaire ou en espèce contre remise 
                                d'un reçu par le salarié.
                            </li>
                            <li>
                                Vous adressez le volet social au Cncesu au plus 
                                tard dans les quinze jours suivant la fin du 
                                mois au cours duquel le salarié a effectué 
                                sa prestation. Le volet social doit faire 
                                apparaître le montant total net versé.
                            </li>
                            <li>
                                Quelques jours après la réception du volet social, 
                                le salarié reçoit une attestation d'emploi 
                                valant bulletin de salaire adressée par le Cncesu.
                            </li>
                            <li>
                                Début du mois suivant : le Cncesu vous envoie 
                                un avis détaillé du montant des cotisations dues 
                                qui sera prélevé sur votre compte bancaire.
                            </li>
                            <li>
                                Le prélèvement automatique est effectué à la fin du 
                                mois de réception de l'avis de prélèvement.
                            </li>
                        </ol>
                    </div>
                    
                    
                </div>
                
                <div class="title-section-cesu show-cesu-section">
                    <span class='cesu-section-number'>7.</span>
                    <p>Bulletin de salaire ou attestation d'emploi ?</p>
                </div>
                <div class="content-section-cesu">
                    <p>Le Centre national du Cesu envoie au salarié une 
                        attestation d'emploi qui vaut bulletin de salaire. 
                        Vous n'êtes donc pas obligé d'établir un bulletin de paie.
                    </p>
                    <p>
                        Il est déconseillé l'utilisation du Cesu dans 
                        certaines situations délicates : en cas d'avantages 
                        en nature ou de prestations en nature, en cas de présence
                        de nuit, etc. Néanmoins, il est recommandé l'établissement 
                        d'un bulletin de paie pour toutes ces situations.
                    </p>

                </div>
                
                <div class="title-section-cesu show-cesu-section">
                    <span class='cesu-section-number'>8.</span>
                    <p>Les avantages fiscaux</p>
                </div>
                <div class="content-section-cesu ">
                    <p>
                        L'utilisation du Cesu en elle-même ne vous permet pas de 
                        bénéficier d'avantages fiscaux. Il ne s'agit que d'un 
                        moyen de paiement. C'est l'emploi d'un salarié à votre 
                        domicile ou d'un assistant maternel qui permet de bénéficier 
                        d'avantages fiscaux. Ainsi, que votre salarié soit 
                        rémunéré par Cesu ou par un autre moyen de paiement, 
                        vous bénéficierez des mêmes dispositifs de réduction 
                        d'impôt ou de crédit d'impôt selon les cas. 
                    </p>
                    <p>
                        Pour bénéficier de ces avantages fiscaux, le Centre national 
                        du Cesu vous adresse chaque année une attestation fiscale. 
                        Depuis 2013,  quel que soit le mode déclaratif de 
                        vos revenus (Internet sur www.impots.gouv.fr ou envoi 
                        de la déclaration papier), vous ne devez plus joindre 
                        l'attestation fiscale Cesu à votre déclaration de revenus.
                    </p>
                </div>
                
                <div class="title-section-cesu show-cesu-section">
                    <span class='cesu-section-number'>9.</span>
                    <p>Les exonérations de charges patronales</p>
                </div>
                <div class="content-section-cesu">
                    <p>
                       Vous pouvez bénéficier d’une déduction forfaitaire de 2 euros 
                       appliquée pour chaque heure déclarée. Cette déduction 
                       forfaitaire n'est pas cumulable avec les exonérations de 
                       cotisations patronales de Sécurité sociale accordées si 
                       vous êtes un particulier employeur âgé de 70 ans ou plus, 
                       un particulier employeur titulaire de l’allocation personnalisée 
                       d'autonomie (Apa), un particulier employeur titulaire 
                       de la prestation de compensation du handicap (PCH) ou 
                       un particulier employeur titulaire de l’allocation d'éducation 
                       de l'enfant handicapé (AEEH). 
                    </p>
                </div>
                
                <div class="title-section-cesu show-cesu-section">
                     <span class='cesu-section-number'>10.</span>
                     <p>La rupture du contrat de travail : que faire lorsque le salarié est rémunéré avec le Cesu ? <p>
                </div>
                <div class="content-section-cesu">
                    <p>
                        Le fait de rémunérer votre salarié par le biais d'un 
                        Cesu ne vous dispense pas de vos obligations 
                        d'employeur en cas de rupture. <br>
                        Quel que soit le motif de la rupture et qu'elle soit à 
                        votre initiative ou à celle du salarié, la procédure
                        décrite dans la convention collective doit être respectée.<br>
                        En cas de licenciement d'un salarié ayant au moins un an 
                        d'ancienneté, vous êtes dans l'obligation de lui 
                        verser une indemnité de licenciement. Il n'est pas 
                        possible de verser l'indemnité de licenciement par Cesu. 
                        De même, cette indemnité ne doit pas être déclarée sur 
                        le volet social du Cesu. Ainsi, l'indemnité de licenciement
                        doit être versée par un autre moyen de paiement.<br>
                        En outre, un préavis doit également être respecté dont la durée varie selon l'ancienneté du salarié.
                        Aussi, lors de la rupture du contrat de travail, vous n'avez pas d'indemnité 
                        compensatrice de congés payés à verser lorsque votre 
                        salarié est déclaré par le biais du Cesu. En effet, son 
                        salaire comprenait déjà une majoration obligatoire de 10% au titre des congés payés.<br>
                        Enfin, en cas de rupture du contrat de travail, y compris 
                        lorsque le salarié est rémunéré par Cesu, vous devez 
                        remettre à votre salarié ses documents de fin de contrat 
                        à savoir : un certificat de travail et une attestation 
                        destinée à Pôle emploi. Un reçu pour solde de tout compte 
                        est également préconisé. Un deuxième exemplaire de 
                        l'attestation destinée à Pôle emploi doit être directement 
                        transmis à Pôle emploi. 
                    </p>
                </div>
                
            </div>
            
        </div>
    </section><!-- @white-space
    --><aside>
        <?php
        get_sidebar();
        ?>
    </aside>
</div>
<?php
get_template_part("logos-partenaires");
get_footer();