<html>
<head>
	<title>学生成绩查询</title>
	<style type="text/css">
	<!--
		.STYLE1 {font-size: 15px; font-family: "幼圆";}
	-->
	</style>
</head>
<body bgcolor="57C9FF">
<div align="center"><font face="幼圆" size="5" color="#0080FF"><b>课程信息查询</b></font></div>
<form name="frm1" method="post" action="ShowClass.php" style="margin:0">
	<table width="500" align="center">
		<tr>
			<td width="60" align="center"><span class="STYLE1">课程号:</span></td>
			<td width="200" align="center"><input name="ClaNum" type="text" size="20"></td>
			<td><input type="submit" name="query" class="STYLE1" value="查找"></td>
			<td>&nbsp;</td>
		</tr>
	</table>
</form>
<?php
$conn=mysql_connect("localhost","root","") or die('连接失败');	//连接服务器
mysql_select_db("PXSCJ2",$conn) or die('连接数据库失败');			//选择数据库
mysql_query("SET NAMES 'utf8'");
session_start();
$Clanumber=@$_POST['ClaNum'];
$_SESSION['Clanumber']=$Clanumber;
$sql="select KCH,KCM,KKXQ,XS,XF from KCB where KCH='$Clanumber'";
$result=mysql_query($sql);
echo "<table width=500 align=center>";
echo "<tr><td>";
echo "<table width=500 border=1 align=center cellpadding=0 cellspacing=0 class=STYLE1>";
    echo "<tr bgcolor=#CCCCCC class='STYLE1''>";
    echo "<td width=100>课程号</td>";
    echo "<td width=100>课程名</td>";
    echo "<td width=150>开课学期</td>";
    echo "<td width=100>学时</td>";
    echo "<td width=100>学分</td>";
if(!$result)
{

        echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";

}
else{
    while($row=mysql_fetch_array($result))
    {
        list($KCH,$KCM,$KKXQ,$XS,$XF)=$row;
        echo "<tr class=ATYLE1><td>$KCH&nbsp;</td>";
        echo "<td width=150>$KCM&nbsp;</td>";
        echo "<td>$KKXQ&nbsp;</td>";
        echo "<td>$XS&nbsp;</td>";
        echo "<td>$XF&nbsp;</td></tr>";
     }

}
echo "</table></td>";
echo "</tr></table>";
?>
</body>
</html>
