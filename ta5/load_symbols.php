

						<!-- SYMBOLS -->
<form id="apiurl" action="apiurl.php" method="post">
<div id="symbols"> 
 <div class="vertical-center">
	 <input id='symbols-search' type='text' class='symbols-select'>
	 <select id="symbol_active" name='symbol_active' class='symbols-select'>
	<?php
		$symbols = array();
		$json = file_get_contents("https://api.hitbtc.com/api/2/public/symbol");
		$symbols = json_decode($json, true);

			$i=0;
			while($symbols[$i]["id"])
			{
				echo "<option id='symbolOption-".$i."' value='".$symbols[$i]["id"]."'>".$symbols[$i]["id"]."</option>";
				$i++;
			}
	?>
			<script type="text/javascript">var symbolList = <?php echo json_encode($symbols); ?>;</script>
	</select>
 </div>
</div>


<div id="time">
	<div class="vertical-center">
		<input id="till_year" type="text" class="time-longinput"> - <input id="till_month" type="text" class="time-shortinput"> - <input id="till_day" type="text" class="time-shortinput"> T 
		<input  id="till_hour" type="text" class="time-shortinput"> : <input id="till_minute" type="text" class="time-shortinput">
				<br>
		<input id="from_year" type="text" class="time-longinput"> - <input id="from_month" type="text" class="time-shortinput"> - <input id="from_day" type="text" class="time-shortinput"> T 
		<input id="from_hour" type="text" class="time-shortinput"> : <input id="from_minute" type="text" class="time-shortinput">
    </div>
    
    <div class="loadbuttondiv">
    	<a href="#" id="submitFormData" onclick="SubmitFormData();" class="loadbutton"> Načíst </a>
    </div>

    <div id="cScaleOutter" style="position: absolute;top: 50%; left: calc(6% + 290px); width: 500px;">
 		<div id="candleScale" class="vertical-center">
			 <a href="#" onclick="cwActive(this)" class="loadbutton active">M1</a>
			 <a href="#" onclick="cwActive(this)" class="loadbutton">M3</a>
			 <a href="#" onclick="cwActive(this)" class="loadbutton">M5</a>
			 <a href="#" onclick="cwActive(this)" class="loadbutton">M15</a>
			 <a href="#" onclick="cwActive(this)" class="loadbutton">M30</a>
			 <a href="#" onclick="cwActive(this)" class="loadbutton">H1</a>
			 <a href="#" onclick="cwActive(this)" class="loadbutton">H4</a>
			 <a href="#" onclick="cwActive(this)" class="loadbutton">D1</a>
			 <a href="#" onclick="cwActive(this)" class="loadbutton">D7</a>
			 <a href="#" onclick="cwActive(this)" class="loadbutton">1M</a>
    	</div>   	
    </div>

    <input type="hidden" name="period" id="period" value="M1">

    <div id="candlewidth">
		<div class="vertical-center">
			 <input type="text" class="time-shortinput" value="3">
    	</div>
    </div>
</div>

</form>
