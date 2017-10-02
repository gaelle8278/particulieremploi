<?php

/**
 *
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

$step1 = '';
$numStep1 = '';
$labelStep1='';
$step2 = '';
$numStep2 = '';
$labelStep2='';
$step3 = '';
$numStep3 = '';
$labelStep3='';;
$step4 = '';
$numStep4 = '';
$labelStep4='';
if($step_active=='compte') {
    $step1 = 'step-active';
    $numStep1 = 'step-numb-active';
    $labelStep1='step-label-active';
} else if ($step_active=='emploi'){
    $step1 = 'step-active';
    $numStep1 = 'step-active';
    $labelStep1='step-label-active';
    $step2 = 'step-active';
    $numStep2 = 'step-numb-active';
    $labelStep2='step-label-active';
} else if ($step_active=='conditions') {
    $step1 = 'step-active';
    $numStep1 = 'step-active';
    $labelStep1='step-label-active';
    $step2 = 'step-active';
    $numStep2 = 'step-active';
    $labelStep2='step-label-active';
    $step3 = 'step-active';
    $numStep3 = 'step-numb-active';
    $labelStep3='step-label-active';
} elseif ($step_active=='recap') {
    $step1 = 'step-active';
    $numStep1 = 'step-active';
    $labelStep1='step-label-active';
    $step2 = 'step-active';
    $numStep2 = 'step-active';
    $labelStep2='step-label-active';
    $step3 = 'step-active';
    $numStep3 = 'step-active';
    $labelStep3='step-label-active';
    $step4 = 'step-active';
    $numStep4 = 'step-numb-active';
    $labelStep4='step-label-active';
}
?>

<div class="nav-parcours <?php echo "nav-".strtolower($type_compte); ?>">
    <div class="step-ins-line step-ins-line-first <?php echo $step1 ?>"></div>
    <div class="step-ins-numb <?php echo $numStep1;?>">1</div>
    <div class="step-ins-line <?php echo $step2 ?>"></div>
    <div class="step-ins-numb <?php echo $numStep2;?>">2</div>
    <div class="step-ins-line <?php echo $step3; ?>"></div>
    <div class="step-ins-numb <?php echo $numStep3;?>">3</div>
    <div class="step-ins-line <?php echo $step4;?>"></div>
    <div class="step-ins-numb <?php echo $numStep4;?>">4</div>
    <div class="step-ins-line step-ins-line-last <?php echo $step4; ?>"></div>
    <div class="label-step label-step-1 <?php echo $labelStep1;?>">
        <span class="res-label-numb">1.</span>Création de compte
    </div>
    <div class="label-step label-step-2 <?php echo $labelStep2;?>">
        <span class="res-label-numb">2.</span>Choix du métier
    </div>
    <div class="label-step label-step-3 <?php echo $labelStep3;?>">
        <span class="res-label-numb">3.</span>Rédaction de l'annonce
    </div>
    <div class="label-step label-step-4 <?php echo $labelStep4;?>">
        <span class="res-label-numb">4.</span>Confirmation
    </div>
</div>