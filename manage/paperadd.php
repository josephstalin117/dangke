<div class="title">题库编辑</div>
<?php
$type=isset($_GET["type"])?$_GET["type"]:'';
if($type=="single"){
	echo "<form action='papersave.php?type=single' method='post'>
		  <table width='100%'>
		  <tr><td width='8%'>题目</td><td><textarea name='question' style='width:90%; padding:6px;'></textarea></td>
		  <tr><td><input type=radio name=answer value=A />A：</td><td><input type=text name=option_a style='width:90%; padding:6px;' /></td></tr>
		  <tr><td><input type=radio name=answer value=B />B：</td><td><input type=text name=option_b style='width:90%; padding:6px;' /></td></tr>
		  <tr><td><input type=radio name=answer value=C />C：</td><td><input type=text name=option_c style='width:90%; padding:6px;' /></td></tr>
		  <tr><td><input type=radio name=answer value=D />D：</td><td><input type=text name=option_d style='width:90%; padding:6px;' /></td></tr>
		  <tr><td></td><td><input type=submit value='保存' /></td></tr>
		  </table>
		  </form>
		  ";
}
if($type=="multi"){
	echo "<form action='papersave.php?type=multi' method='post'>
		  <table width='100%'>
		  <tr><td width='8%'>题目</td><td><textarea name='question' style='width:90%; padding:6px;'></textarea></td>
		  <tr><td><input type=checkbox name=answer[] value=A />A：</td><td><input type=text name=option_a style='width:90%; padding:6px;' /></td></tr>
		  <tr><td><input type=checkbox name=answer[] value=B />B：</td><td><input type=text name=option_b style='width:90%; padding:6px;' /></td></tr>
		  <tr><td><input type=checkbox name=answer[] value=C />C：</td><td><input type=text name=option_c style='width:90%; padding:6px;' /></td></tr>
		  <tr><td><input type=checkbox name=answer[] value=D />D：</td><td><input type=text name=option_d style='width:90%; padding:6px;' /></td></tr>
		  <tr><td></td><td><input type=submit value='保存' /></td></tr>
		  </table>
		  </form>
		  ";
}
if($type=="judge"){
	echo "<form action='papersave.php?type=judge' method='post'>
		  <table width='100%'>
		  <tr><td width='8%'>题目</td><td><textarea name='question' style='width:90%; padding:6px;'></textarea></td>
		  <tr><td><input type=radio name=answer value=0 />错</td><td></td></tr>
		  <tr><td><input type=radio name=answer value=1 />对</td><td></td></tr>
		  <tr><td></td><td><input type=submit value='保存' /></td></tr>
		  </table>
		  </form>
		  ";
}
?>