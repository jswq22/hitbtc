<?php
include("ini.php");

if(isset($_POST["symbol_active"]))
	{$symbol_active = $_POST["symbol_active"];}
		else
	{$symbol_active = "BTCUSD";}

if(isset($_POST["period"]))
	{$period = $_POST["period"];}
		else
	{$period = "M1";}

if(isset($refresh))
	{$refresh = $_POST["refresh"];}
		else
	{$refresh = 3000;}



if(isset($_POST["till_year"]))
	{$till_year = $_POST["till_year"];}
		else
	{$till_year = date("Y");}

if(isset($_POST["till_month"]))
	{$till_month = $_POST["till_month"];}
		else
	{$till_month = date("m");}

if(isset($_POST["till_day"]))
	{$till_day = $_POST["till_day"];}
		else
	{$till_day = date("d");}

if(isset($_POST["till_hour"]))
	{$till_hour = $_POST["till_hour"];}
		else
	{$till_hour = date("H");}

if(isset($_POST["till_minute"]))
	{$till_minute = $_POST["till_minute"];}
		else
	{$till_minute = date("i");}

if(isset($_POST["till_second"]))
	{$till_second = $_POST["till_second"];}
		else
	{$till_second = date("s");}
//		$till = $till_year."-".$till_month."-".$till_day."T".$till_hour.":".$till_minute.":00.000Z";




if(isset($_POST["from_year"]))
	{$from_year = $_POST["from_year"];}
		else
	{$from_year = date("Y");}

if(isset($_POST["from_month"]))
	{$from_month = $_POST["from_month"];}
		else
	{$from_month = date("m");}

if(isset($_POST["from_day"]))
	{$from_day = $_POST["from_day"];}
		else
	{$from_day = date("d");}

if(isset($_POST["from_hour"]))
	{$from_hour = $_POST["from_hour"];}
		else
	{$from_hour = date("H");}

if(isset($_POST["from_minute"]))
	{$from_minute = $_POST["from_minute"];}
		else
	{$from_minute = date("i");}

if(isset($_POST["from_second"]))
	{$from_second = $_POST["from_second"];}
		else
	{$from_second = date("s");}
//		$from = $from_year."-".$from_month."-".$from_day."T".$from_hour.":".$from_minute.":00.000Z";

$dtTill = new DateTime($till_year."-".$till_month."-".($till_day)."T".$till_hour.":".$till_minute.":00.000Z");
$till = $dtTill->format('Y-m-d\TH:i:s').".000Z"; 

$dtFrom = new DateTime($from_year."-".$from_month."-".($from_day)."T".$from_hour.":".$from_minute.":00.000Z");
$from = $dtFrom->format('Y-m-d\TH:i:s').".000Z"; 

$dtTill = strtotime($till);
$dtFrom = strtotime($from);

$dtLoad = $dtFrom;


$et_time = date("h:m:s", time() + 2);
$dtLoad = date("Y-m-d\TH:i:s", $dtLoad).".000Z";
$percentage=0;

 $chart= array();
 $ii=0;
	while(round($percentage)<100)
	{
		if(strtotime($et_time) <= strtotime(date("h:m:s")))
		{
			$link = new mysqli($mysql["server"], $mysql["user"], $mysql["password"]);
			if ($link->connect_error) 
			{
				die('Nelze se připojit k MySQL: ' . mysql_error());
			}

			//$api_a = array();
			$json = file_get_contents("https://api.hitbtc.com/api/2/public/candles/".$symbol_active."?period=".$period."&sort=ASC&from=".$dtLoad."&till=".$till."&limit=400");
			$api_a = json_decode($json, true);

			$i=0;
			while(!empty($api_a[$i]["timestamp"])) 
			{
				$res = mysqli_query($link, "INSERT INTO ".$mysql["dbname"].".chart (datetime, open, close, min, max, symbol) VALUES ('".$api_a[$i]["timestamp"]."', '".$api_a[$i]["open"]."', '".$api_a[$i]["close"]."', '".$api_a[$i]["min"]."', '".$api_a[$i]["max"]."', '".$symbol_active."')");

					$chart[$ii]["open"] =  $api_a[$i]["open"];
					$chart[$ii]["close"] =  $api_a[$i]["close"];
					$chart[$ii]["max"] =  $api_a[$i]["max"];
					$chart[$ii]["min"] =  $api_a[$i]["min"];
					$ii++;

				$i++;
			}
			mysqli_close($link);
		

			if($i > 0)
			{
			$i--;
			$dtLoad = strtotime($api_a[$i]['timestamp']);
			$percentage =round( (($dtLoad-$dtFrom)/($dtTill-$dtFrom))*100 );
			$et_time = date("h:m:s", time() + 2);
			$dtLoad = date("Y-m-d\TH:i:s", $dtLoad).".000Z";
			}
				else
			{$percentage=100;}


		}		
		else
		{
			usleep(2000);
		}
	}
/*
$convertedTill = date('Y-m-d h:i:s', strtotime($till));
$convertedFrom = date('Y-m-d h:i:s', strtotime($from));
$link = new mysqli($mysql["server"], $mysql["user"], $mysql["password"]);
if ($link->connect_error) 
	{
		die('Nelze se připojit k MySQL: ' . mysql_error());
	}
	/*SELECT * FROM `chart` WHERE datetime BETWEEN '2021-01-01' AND '2021-02-02' AND symbol='HOTBTC' LIMIT 400*/
/*	$res = mysqli_query($link, "select datetime from ta.chart where datetime between ".$convertedFrom." and ".$convertedFrom." and symbol='".$symbol_active."' order by datetime asc;");


			mysqli_close($link);

			
$rows = [];
while($row = $result->fetch_row()) {
    $rows[] = $row;
}
*/



$chRes = json_encode($chart);

echo "...Hotovo

<script type='text/javascript'>
	localStorage.setItem('chart','".$chRes."' );
	localStorage.setItem('count',".($ii-1)." );
	localStorage.setItem('reload', true);
</script>";

?>

