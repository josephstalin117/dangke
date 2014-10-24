<div class="title">视频管理</div>
<form action="insertvideo.php" method="post">
<table>
<tr><td>标题：</td><td><input type="text" style="width:240px;" name=videoinfo[] /></td>
<tr><td>缩略图：</td><td><input type="file"  accept="image/gif, image/jpeg" name="imgfile" /></td>
<tr><td>视频文件：</td><td><input type="file" name="videofile" /></td>
<tr><td>简介：</td><td><textarea name="videoinfo" style="height:100px;width:380px;" rows="" cols=""></textarea></td>
<tr><td></td><td><input type="submit" value="保存" style="width:60px; height:30px;" /></td></tr>
</table>
</form>