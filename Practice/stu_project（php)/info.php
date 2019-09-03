<?php
$conn=mysql_connect("localhost","root","") or die('连接失败');	//连接服务器
mysql_select_db("PXSCJ2",$conn) or die('连接数据库失败');			//选择数据库
mysql_query("SET NAMES 'utf8'");
header("Cache-Control: No-Cache");					//不使用缓存
header("Pragma: No-Cache");
session_start();									//启动SESSION
@$number=$_GET['id'];								//得到StuQuery.php页面的链接中传来的值
$_SESSION['number']=$number;						//使用SESSION将学号传到其他页面
$sql="select BZ from XSB where XH='$number'";	//查找备注和照片列
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$BZ=$row['BZ'];
?>
<html>
<head>
	<title>备注</title>
	<style type="text/css">
	<!--
		.STYLE1 {font-size: 16px; font-family: "幼圆";color:"#0000FF";}
	-->
	</style>
</head>
<body bgcolor="#57C9FF">
<br><br><br>
<table width="100" border="1">
	<tr>
		<td class="STYLE1" align="center">附加信息</td>
	</tr>
	<tr>
		<td class="STYLE1" bgcolor="#CCCCCC" align="center">备注</td>
	</tr>
	<tr>
		<td>
			<textarea rows="7" name="StuBZ" ><?php if($BZ)echo $BZ;else echo "暂无";?></textarea>
		</td>
	</tr>
</table>
</body>
</html>
