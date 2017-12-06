<?php
function check_valid_date( $date, $format = 'd/m/Y' ) {
    
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function format_date_db( $input_date ) {
  
   $dbdate="";
           
   list($d,$m,$y) = explode("/", $input_date);
   
   $dbdate= $y."-".$m."-".$d;
   
   return $dbdate;
}