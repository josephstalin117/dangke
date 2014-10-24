<?php
	require_once 'logincheck.php';
	require_once '../config/config.system.php';
	date_default_timezone_set("Asia/Shanghai");
?>
<div class="title">系统配置</div>
<?php 
if(isset($_COOKIE["message"])){
	echo '<font size="-1" color="#ff0000">'.$_COOKIE["message"].'</font>';
	setcookie("message");	//删除cookie
}?>
<form action="optionsave.php" method="post" name="config">
系统名称：<input type="text" name="title" value="<?php echo $config_system["title"] ?>" /><br />
系统是否开启：
<input type="radio" id="enable1" name="enable" value="1" />开启
<input type="radio" id="enable0" name="enable" value="0" />关闭
<br />
系统开放时间：
<select id="idYear1" name="select[]"></select>年
<select id="idMonth1" name="select[]"></select>月
<select id="idDay1" name="select[]"></select>日
&nbsp;到&nbsp;
<select id="idYear2" name="select[]"></select>年
<select id="idMonth2" name="select[]"></select>月
<select id="idDay2" name="select[]"></select>日
<br />
考试开放时间：
<select id="idYear3" name="select[]"></select>年
<select id="idMonth3" name="select[]"></select>月
<select id="idDay3" name="select[]"></select>日
&nbsp;到&nbsp;
<select id="idYear4" name="select[]"></select>年
<select id="idMonth4" name="select[]"></select>月
<select id="idDay4" name="select[]"></select>日
<br />
<input type="submit" value="保存" style="width:100px; height:30px; margin-top:10px;" />
</form>

<script type="text/javascript">
var $ = function (id) {
	return "string" == typeof id ? document.getElementById(id) : id;
};

function addEventHandler(oTarget, sEventType, fnHandler) {
	if (oTarget.addEventListener) {
		oTarget.addEventListener(sEventType, fnHandler, false);
	} else if (oTarget.attachEvent) {
		oTarget.attachEvent("on" + sEventType, fnHandler);
	} else {
		oTarget["on" + sEventType] = fnHandler;
	}
};

var Class = {
  create: function() {
	return function() {
	  this.initialize.apply(this, arguments);
	}
  }
}

var Extend = function(destination, source) {
	for (var property in source) {
		destination[property] = source[property];
	}
	return destination;
}

var DateSelector = Class.create();
DateSelector.prototype = {
  initialize: function(oYear, oMonth, oDay, options) {
	this.SelYear = $(oYear);//年选择对象
	this.SelMonth = $(oMonth);//月选择对象
	this.SelDay = $(oDay);//日选择对象
	
	this.SetOptions(options);
	
	var dt = new Date(), iMonth = parseInt(this.options.Month), iDay = parseInt(this.options.Day), iMinYear = parseInt(this.options.MinYear), iMaxYear = parseInt(this.options.MaxYear);
	
	this.Year = parseInt(this.options.Year) || dt.getFullYear();
	this.Month = 1 <= iMonth && iMonth <= 12 ? iMonth : dt.getMonth() + 1;
	this.Day = iDay > 0 ? iDay : dt.getDate();
	this.MinYear = iMinYear && iMinYear < this.Year ? iMinYear : this.Year;
	this.MaxYear = iMaxYear && iMaxYear > this.Year ? iMaxYear : this.Year;
	this.onChange = this.options.onChange;
	
	//年设置
	this.SetSelect(this.SelYear, this.MinYear, this.MaxYear - this.MinYear + 1, this.Year - this.MinYear);
	//月设置
	this.SetSelect(this.SelMonth, 1, 12, this.Month - 1);
	//日设置
	this.SetDay();
	
	var oThis = this;
	//日期改变事件
	addEventHandler(this.SelYear, "change", function(){
		oThis.Year = oThis.SelYear.value; oThis.SetDay(); oThis.onChange();
	});
	addEventHandler(this.SelMonth, "change", function(){
		oThis.Month = oThis.SelMonth.value; oThis.SetDay(); oThis.onChange();
	});
	addEventHandler(this.SelDay, "change", function(){ oThis.Day = oThis.SelDay.value; oThis.onChange(); });
  },
  //设置默认属性
  SetOptions: function(options) {
	this.options = {//默认值
		Year:		0,//年
		Month:		0,//月
		Day:		0,//日
		MinYear:	0,//最小年份
		MaxYear:	0,//最大年份
		onChange:	function(){}//日期改变时执行
	};
	Extend(this.options, options || {});
  },
  //日设置
  SetDay: function() {
	//取得月份天数
	var daysInMonth = new Date(this.Year, this.Month, 0).getDate();
	if (this.Day > daysInMonth) { this.Day = daysInMonth; };
	this.SetSelect(this.SelDay, 1, daysInMonth, this.Day - 1);
  },
  //select设置
  SetSelect: function(oSelect, iStart, iLength, iIndex) {
	//添加option
	oSelect.options.length = iLength;
	for (var i = 0; i < iLength; i++) { oSelect.options[i].text = oSelect.options[i].value = iStart + i; }
	//设置选中项
	oSelect.selectedIndex = iIndex;
  }
};
</script>
<br /><!--
你选择的日期：<span id="idShow"></span>
--><script>
var ds1 = new DateSelector("idYear1", "idMonth1", "idDay1", {
	Year: <?php echo date('Y',$config_system["start_time"]); ?>,
	Month: <?php echo date('m',$config_system["start_time"]); ?>,
	Day: <?php echo date('d',$config_system["start_time"]); ?>,
	MaxYear: new Date().getFullYear() + 2,
	MinYear: new Date().getFullYear(),
//	onChange: function(){ $("idShow").innerHTML = this.Year + "/" + this.Month + "/" + this.Day; }
});
var ds2 = new DateSelector("idYear2", "idMonth2", "idDay2", {
	Year: <?php echo date('Y',$config_system["end_time"]); ?>,
	Month: <?php echo date('m',$config_system["end_time"]); ?>,
	Day: <?php echo date('d',$config_system["end_time"]); ?>,
	MaxYear: new Date().getFullYear() + 2,
	MinYear: new Date().getFullYear(),
//	onChange: function(){ $("idShow").innerHTML = this.Year + "/" + this.Month + "/" + this.Day; }
});
var ds3 = new DateSelector("idYear3", "idMonth3", "idDay3", {
	Year: <?php echo date('Y',$config_system["exam_start_time"]); ?>,
	Month: <?php echo date('m',$config_system["exam_start_time"]); ?>,
	Day: <?php echo date('d',$config_system["exam_start_time"]); ?>,
	MaxYear: new Date().getFullYear() + 2,
	MinYear: new Date().getFullYear(),
//	onChange: function(){ $("idShow").innerHTML = this.Year + "/" + this.Month + "/" + this.Day; }
});
var ds4 = new DateSelector("idYear4", "idMonth4", "idDay4", {
	Year: <?php echo date('Y',$config_system["exam_end_time"]); ?>,
	Month: <?php echo date('m',$config_system["exam_end_time"]); ?>,
	Day: <?php echo date('d',$config_system["exam_end_time"]); ?>,
	MaxYear: new Date().getFullYear() + 2,
	MinYear: new Date().getFullYear(),
//	onChange: function(){ $("idShow").innerHTML = this.Year + "/" + this.Month + "/" + this.Day; }
});
ds.onChange();
</script>
<script type="text/javascript" language="javascript">
var obj = document.getElementsByName('enable');

for(i = 0; i < obj.length; i++)
{  

  if(obj[i].value == <?php echo $config_system["enable"]; ?>)
  {  
    obj[i].checked = true;
  }  
}
</script>