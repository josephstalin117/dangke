<div class="title">题库编辑</div>
<?php
require_once 'logincheck.php';
$singleID=isset($_GET["single_id"])?$_GET["single_id"]:'';
$multiID=isset($_GET["multi_id"])?$_GET["multi_id"]:'';
$judgeID=isset($_GET["judge_id"])?$_GET["judge_id"]:'';
if($singleID){
	$sql="select * from single_selections where ID='$singleID'";
	$db->query($sql);
	$row=$db->getrow();
	$strCheck=array("A"=>'',"B"=>'',"C"=>'',"D"=>'');
	$strCheck[$row["ANSWER"]]='checked=true';
	echo "<form action='papermodify.php' method='post'>
	<input type=hidden name=single_id value='$singleID' />
		  <table width='100%'>
		  <tr><td width='8%'>题目</td><td><textarea name='question' style='width:90%; padding:6px;'>$row[QUESTION]</textarea></td>
		  <tr><td><input type=radio name=answer value=A $strCheck[A] />A：</td><td><input type=text name=option_a value='$row[OPTION_A]' style='width:90%; padding:6px;' /></td></tr>
		  <tr><td><input type=radio name=answer value=B $strCheck[B] />B：</td><td><input type=text name=option_b value='$row[OPTION_B]' style='width:90%; padding:6px;' /></td></tr>
		  <tr><td><input type=radio name=answer value=C $strCheck[C] />C：</td><td><input type=text name=option_c value='$row[OPTION_C]' style='width:90%; padding:6px;' /></td></tr>
		  <tr><td><input type=radio name=answer value=D $strCheck[D] />D：</td><td><input type=text name=option_d value='$row[OPTION_D]' style='width:90%; padding:6px;' /></td></tr>
		  <tr><td></td><td><input type=submit value='保存' /></td></tr>
		  </table>
		  </form>
		  ";
}
if($multiID){
	$sql="select * from multi_selections where ID='$multiID'";
	$db->query($sql);
	$row=$db->getrow();
	$strCheck=array("A"=>'',"B"=>'',"C"=>'',"D"=>'');
	$i=0;
	$answer=$row["ANSWER"];
	for($i=0;$i<strlen($answer);$i++)
		$strCheck[$answer[$i]]='checked=true';
	echo "<form action='papermodify.php' method='post'>
	<input type=hidden name=multi_id value='$multiID' />
		  <table width='100%'>
		  <tr><td width='8%'>题目</td><td><textarea name='question' style='width:90%; padding:6px;'>$row[QUESTION]</textarea></td>
		  <tr><td><input type=checkbox name=answer[] value=A $strCheck[A] />A：</td><td><input type=text name=option_a value='$row[OPTION_A]' style='width:90%; padding:6px;' /></td></tr>
		  <tr><td><input type=checkbox name=answer[] value=B $strCheck[B] />B：</td><td><input type=text name=option_b value='$row[OPTION_B]' style='width:90%; padding:6px;' /></td></tr>
		  <tr><td><input type=checkbox name=answer[] value=C $strCheck[C] />C：</td><td><input type=text name=option_c value='$row[OPTION_C]' style='width:90%; padding:6px;' /></td></tr>
		  <tr><td><input type=checkbox name=answer[] value=D $strCheck[D] />D：</td><td><input type=text name=option_d value='$row[OPTION_D]' style='width:90%; padding:6px;' /></td></tr>
		  <tr><td></td><td><input type=submit value='保存' /></td></tr>
		  </table>
		  </form>
		  ";
}
if($judgeID){
	$sql="select * from judge_list where ID='$judgeID'";
	$db->query($sql);
	$row=$db->getrow();
	$strCheck=array("1"=>'',"0"=>'');
	$strCheck[$row["ANSWER"]]='checked=true';
	echo "<form action='papermodify.php' method='post'>
	<input type=hidden name=judge_id value='$judgeID' />
		  <table width='100%'>
		  <tr><td width='8%'>题目</td><td><textarea name='question' style='width:90%; padding:6px;'>$row[QUESTION]</textarea></td>
		  <tr><td><input type=radio name=answer value=0 $strCheck[0] />错</td><td></td></tr>
		  <tr><td><input type=radio name=answer value=1 $strCheck[1] />对</td><td></td></tr>
		  <tr><td></td><td><input type=submit value='保存' /></td></tr>
		  </table>
		  </form>
		  ";
}
?>
