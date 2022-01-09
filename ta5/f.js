var _chart = new Array();  //['".$i."']=new Array(); _chart[".$i."]['open'] = ".$api_a[$i]["open"]."; _chart[".$i."]['close'] = ".$api_a[$i]["close"].";	
var _chartP = new Array();
var _chartI = new Array();
var _count;
			/**		při načtení údajů z apiurl pouze refreshuje graf	**/
localStorage.setItem('reload', false);


/*******************************************************
		Odeslat formulář z Upper-toolbar na urlapi.php
*******************************************************/
function SubmitFormData() 
{
    var symbol_active = $("#symbol_active").val();

    var till_year = $("#till_year").val();
	var till_month = $("#till_month").val();
	var till_day = $("#till_day").val();
	var till_hour = $("#till_hour").val();
	var till_minute = $("#till_minute").val();

	var from_year = $("#from_year").val();
	var from_month = $("#from_month").val();
	var from_day = $("#from_day").val();
	var from_hour = $("#from_hour").val();
	var from_minute = $("#from_minute").val();

    var period = $("#period").val();

    $.post("apiurl.php", { symbol_active: symbol_active, till_year: till_year, till_month: till_month, till_day:till_day, till_hour:till_hour, till_minute:till_minute, 
    					from_year:from_year, from_month:from_month, from_day:from_day, from_hour:from_hour, from_minute:from_minute, period:period},
    		function(data) {
   								$('#results').html(data);
   								//$('#apiurl')[0].reset();
    						});
}



/****************************************
		Zadat interval svíčky
****************************************/
function cwActive(elem)
{	
	for(i=0;document.getElementById("candleScale").children.length >= i;i++)
	{
		if(elem==document.getElementById("candleScale").children[i])
		{
			document.getElementById("period").value = elem.innerHTML;
   			elem.classList.add("active"); 
		}
			else
		{
			document.getElementById("candleScale").children[i].classList.remove("active");
		}
	}
}






/*****************************************
		Po načtení stránky
*****************************************/
$( document ).ready(function() 
{
var el_symbolsSearch = document.getElementById("symbols-search");


var _chH,_chW; // = e.clientHeight/Width;
var el,stl,_reY; //el = element, styl, přepočítaná osa Y
var hc_ratio;	
var divPos = {};
var offset = $("#chart").offset();
    
    
var _H = _chartI["hPrice"];
var _L = _chartI["lPrice"];
var _D = _H - _L;

el = document.getElementById("chart");

stl = el.style.top; //=divPos["left"];
_reY =(parseInt(stl.substr(0,(stl.length)-2)));
 

//hc_ratio = (6*_count)/_chW;

var currentdate = new Date(); 

	var time_till = new Array();
		time_till["year"] = currentdate.getFullYear();
		time_till["month"] = currentdate.getMonth()+1;
		time_till["day"] = currentdate.getDay();
		time_till["hour"] = currentdate.getHours();
		time_till["minute"] = currentdate.getMinutes();
		time_till["second"] = currentdate.getSeconds();

	var time_from = new Array();
		time_from["year"] = currentdate.getFullYear();
		time_from["month"] = currentdate.getMonth()+1;
		time_from["day"] = currentdate.getDay();
		time_from["hour"] = currentdate.getHours()-2;		//graf 2 hodiny nazpět
		time_from["minute"] = currentdate.getMinutes();
		time_from["second"] = currentdate.getSeconds();

var symbol_active = "BTCUSD";
var candle_width = 3;
var period = "M1";


el_symbolsSearch.onkeyup = function()
{
	el_symbolsSearch.value = el_symbolsSearch.value.toUpperCase();
	var i=0;
	
		while(symbolList[i]["id"])
		{
			if(document.getElementById("symbolOption-"+i).value.includes(el_symbolsSearch.value) == false)
			{
				document.getElementById("symbolOption-"+i).hidden = true;
			}
				else
			{
				document.getElementById("symbolOption-"+i).hidden = false;
			}

		i++;
		}
};

var price, time;
price = localStorage.getItem("price");
time = localStorage.getItem("time");
//document.getElementById("_chartStats").innerHTML =  "Price:"+price+"<br> Time:"+time;

document.getElementById("_chartInfo").style.zIndex = 1;
	      

	/******************************************
					Refresh grafu
	******************************************/
setInterval(function(){
alert("chart[0]");
	//chart = localStorage.getItem("chart");

	//drawchart(document.getElementById("chart"));

}, 3000);


});