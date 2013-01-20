<?php //


//If(!file_exists(CDMPATH.date('d-m-Y'))) //part A
//{mkdir(CDMPATH.date('d-m-Y')); }
//else
//{
////part C
//}

header( "Content-Type: application/json" );
print_r(json_encode(array('time'=> get_declared_classes())));
