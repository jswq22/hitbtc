<html>
<head>
   <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
   <script src="f.js" type="text/javascript"></script>
   <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>


<div id="upper-toolbar">

		<?php
		/**********************************************
				Nastavitelné údaje
		**********************************************/
		include("ini.php");

		/**********************************************
				Zavedení DB
		**********************************************/
		$link = new mysqli($mysql["server"], $mysql["user"], $mysql["password"]);
				if ($link->connect_error) 
					{
						die('Nelze se připojit k MySQL: ' . mysql_error());
					}

		$res = mysqli_query($link, "CREATE DATABASE IF NOT EXISTS ".$mysql["dbname"].";");
		$res = mysqli_query($link, "CREATE TABLE `ta`.`chart` ( `datetime` DATETIME NOT NULL , `open` FLOAT NOT NULL , `close` FLOAT NOT NULL , `min` FLOAT NOT NULL , `max` FLOAT NOT NULL , `symbol` TEXT NOT NULL , PRIMARY KEY (`datetime`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_czech_ci;");

		mysqli_close($link);
		

		/**********************************************
		načte všechny páry
		symbolSELECT[číslo]	= "BTCUSD"
		//nastaví počet svíček (500 max, 100 default) 
		časový rozsah svíček M1, M3, M5, M15, M30, H1, H4, D1, D7, 1M
		časový úsek od do (from - till) tvar: 2018-12-12T12:12:12.121Z ,nebo číslo
		šířka svíček
		**********************************************/
		include("load_symbols.php");
		?>

</div>

<div id="chart">
</div>

<div id="lower-toolbar">
	<div id="results"></div>
</div>





<!------------------------------------>
<!------------------------------------>
<!----   VYKRESLÍ    GRAF  ----------->
<!------------------------------------>
<!------------------------------------>
<script type="text/javascript">
	setInterval(function(){

		if (localStorage.getItem('reload')=='true') 
		{
			localStorage.setItem('reload', false);
			 document.getElementById("chart").innerHTML=" ";

			_chart = JSON.parse(localStorage.getItem("chart"));
			var _count = localStorage.getItem("count");

			var e = document.getElementById("chart");

			var i, _o,_c,_h,_l, _L=" ",_H=" ",_D,_To,_Tc;
			var _chH=e.clientHeight , _chW = e.clientWidth;
			var _R, _Roc,_Rco,_Rhl,_Rlh;//rozdil


			for (i=0;i<=_count;i++) 
			{
				_h = _chart[i]['max'];
				_l = _chart[i]['min'];

				if(_l < _L || _L==" ")
				{
				_L=_l;
				}

				if(_h > _H || _H==" ")
				{
				_H=_h;
				}
			}

			_D = _H - _L;
			_R = _chH/_D;

			_chartI["hPrice"]=_H;
			_chartI["lPrice"]=_L;

			for (i=0;i<=_count;i++) 
			{
				_o = _chart[i]['open'];
				_c = _chart[i]['close'];

				_h = _chart[i]['max'];
				_l = _chart[i]['min'];

				_Roc = ((_o-_c)/_D)*_chH;
				_Roc = ((_c-_o)/_D)*_chH;

				_Rhl = ((_h-_l)/_D)*_chH;
				_Rlh = (((_H-_h)/_D)*_chH);

				_To =(((_H-_o)/_D)*_chH); //100+ ((_o-_L)/(_H-_L))*_chH; 
				_Tc =(((_H-_c)/_D)*_chH); //100+ ((_o-_L)/(_H-_L))*_chH; 

		//document.getElementById("info").innerHTML = document.getElementById("info").innerHTML+"<br>H = "+_H+" L = "+_L+" Roc = "+_Roc+" _To = "+_To;
				if (_o > _c) 
				{
				e.innerHTML = e.innerHTML + "<div style=\"position:absolute; left:"+(i*6)+"px;  width:4px; top:"+(_To)+"px; height:"+(_Roc)+"px; background-color:red; \"></div>";
				e.innerHTML = e.innerHTML + "<div style=\"position:absolute; left:"+((i*6)+2)+"px;  width:1px; top:"+(_Rlh)+"px; height:"+(_Rhl)+"px; background-color:red; \"></div>";
				}
				else 
				{
				e.innerHTML = e.innerHTML + "<div style=\"position:absolute; left:"+(i*6)+"px;  width:4px; top:"+(_Tc)+"px; height:"+(_Rco)+"px; background-color:green; \"></div>";	
				e.innerHTML = e.innerHTML + "<div style=\"position:absolute; left:"+((i*6)+2)+"px;  width:1px; top:"+(_Rlh)+"px; height:"+(_Rhl)+"px; background-color:green; \"></div>";
				}

			}
			e.innerHTML = e.innerHTML + "<div id='_chartInfo' style=\"left:0;bottom:0;position:absolute;\">počet svíček:"+_count+"</div>";

		}

}, 10000);
</script>

 
</body>
</html>