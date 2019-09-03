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
<div align="center"><font face="幼圆" size="5" color="#0080FF"><b>学生成绩查询</b></font></div>
<form name="frm1" method="post" action="ShowStuKC.php" style="margin:0">
	<table width="500" align="center">
		<tr>
			<td width="60"><span class="STYLE1">学号:</span></td>
			<td width="160"><input name="StuNum" type="text" size="20"></td>
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
$number=@$_POST['StuNum'];
$_SESSION['number']=$number;
$sql1="select KCH,KCM,CJ from XS_KC_CJ where XH='$number'";
$sql2="select XM,ZXF from XSB where XH='$number'";
$result1=mysql_query($sql1);
$result2=mysql_query($sql2);    

echo "<table width=500 height=350 align=center>";
echo "<tr><td>";
echo "<table width=350 height=340 border=1 align=center cellpadding=0 cellspacing=0 class=STYLE1>";
    echo "<tr bgcolor=#CCCCCC class='STYLE1''>";
    echo "<td width=100>课程号</td>";
    echo "<td width=150>课程名</td>";
    echo "<td width=100>成绩</td>";
if(!$result1)
{
    for($i=0;$i<12;$i++)
    {
        echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
        
    }
}
else{
    $count=0;
    while($row1=mysql_fetch_array($result1))
    {
      
        list($KCH,$KCM,$CJ)=$row1;
        echo "<tr class=STYLE1><td>$KCH&nbsp;</td>";
        echo "<td>$KCM&nbsp;</td>";
        echo "<td>$CJ&nbsp;</td></tr>";
        $count++;
    }  
    for($i=0;$i<12-$count;$i++)
    {
        echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
    }
    }
echo "</table></td>";
$row2=mysql_fetch_array($result2);
list($XM,$ZXF)=$row2;
if($number&&(!$XM))
    echo "<script>alert('该学号不存在！');location.href='ShowStuKC.php';</script>";
else
{
    echo "<td><table width=150 height=340 border=1 cellpadding=0 cellspacing=0>";
    echo "<tr class=STYLE1><td height=25 bgcolor=#CCCCCC>姓名：</td></tr>";
    echo "<tr class=STYLE1><td height=25 align=center>$XM&nbsp;</td></tr>";
    echo "<tr class=STYLE1><td height=25 bgcolor=#CCCCCC>总学分：</td></tr>";
    echo "<tr class=STYLE1><td height=25 align=center>$ZXF&nbsp;</td></tr>";
    echo "<tr><td height=170 align=center>";
    echo "<tr><td align=center>";
    echo "<input type=button name=exit class=STYLE1
           value=退出 onclick=\"window.location='main.html'\"></td></tr>";
    echo "</table></td>";
}
echo "</tr></table>";
?>

</body>
</html>
