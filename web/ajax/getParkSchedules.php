<?php

$openingTime = 10;
$closingTime = 20;


$date = $_POST['date'];

$winterBegginigDay 		= 6;
$winterBegginingMonth 	= 5;

$winterFinishingDay 	= 5;
$winterFinishingMonth 	= 11;

$explodedDate 	= explode('/', $date);
$day			= (int) $explodedDate[0];
$month			= (int) $explodedDate[1];
$year			= (int) $explodedDate[2];
$unixDate		= mktime(0,0,0,$month,$day,$year);
$firstWinterDay	= mktime(0,0,0,$winterBegginingMonth,$winterBegginigDay,$year);
$lastWinterDay	= mktime(0,0,0,$winterFinishingMonth,$winterFinishingDay,$year);
$weekDay 		= date('N',$unixDate);

if ($unixDate >= $firstWinterDay && $unixDate <= $lastWinterDay){
	if ($weekDay < 6){
		$openingTime = 9;
		$closingTime = 19;
	}
}	
else{
	if ($weekDay > 5){
		$openingTime = 10;
		$closingTime = 22;
	}
}

$code = "";
for ($i=$openingTime;$i<$closingTime+1;$i++) {
	$hora = $i;
	if ($i < 10){
		$hora = '0'.$hora;
	} 
	$code .= '<option value="'.$i.'">'.$hora.'</option>';
}

$response = array(
	"open" => $openingTime,
	"close" => $closingTime,
	"code" => $code,
	"weekDay" => $weekDay,
	"month" => $month
	);

echo json_encode($response);

?>