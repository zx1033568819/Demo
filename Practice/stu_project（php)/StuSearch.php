<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf8"/>
<head>
	<title>学生信息查询</title>
	<style type="text/css">
	<!--
		.STYLE1 {font-size: 15px; font-family: "幼圆";}
	-->
	div{
		text-align:center;
		font-family:"幼圆";
		font-size:15px;
		color:"#008000";
	}
	</style>
</head>
<body bgcolor="#57C9FF">
<div align="center"><font face="幼圆" size="5" color="#0080FF"><b>学生信息查询</b></div>
<form name="frm1" method="GET" action="StuSearch.php">
	<table align="center" width="480" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td height="10" bgcolor="#CCCCCC"><span class="STYLE1">学号:</span></td>
			<td><input name="StuNumber" type="text" size="13"></td>
            <td><td height="10" bgcolor="#CCCCCC"><span class="STYLE1">姓名:</span></td></td>
            <td><input name="StuName" type="text" size="13"></td>
            <td><td height="10" bgcolor="#CCCCCC"><span class="STYLE1">专业:</span></td></td>
            <td><select>
                <option>所有专业</option>
                <option>计算机</option>
                <option>通信工程</option>
            </select>
            </td>	
            <td><input type="submit" name="Query" class="STYLE1" value="查询"></td>
		</tr>
	</table>
</form>
<?php
$conn=mysql_connect("localhost","root","") or die('连接失败');	//连接服务器
mysql_select_db("PXSCJ2",$conn) or die('连接数据库失败');			//选择数据库
mysql_query("SET NAMES 'gb2312'");;
$StuNumber=@$_GET['StuNumber'];   		  		//学号
$StuName=@$_GET['StuName'];       		 	 	//姓名
$Project=@$_GET['select'];           		  	//专业
//生成sql语句的getsql函数
function getsql($StuNum,$StuNa,$Pro)
{
	$sql="select * from XSB where ";
	$note=0;
	if($StuNum)
	{
   		$sql.="XH like '%$StuNum%'";
   		$note=1;
	}
	if($StuNa)
	{  	
		if($note==1)	
			$sql=" and XM like '%$StuNa%'";   
	  	else
	   		$sql.="XM like '%$StuNa%'";
	  	$note=1;
	}
	if($Pro&&($Pro!="所有专业"))
	{	 
		 if($note==1)  
			$sql.=" and ZY='$Pro'";
		 else
		 {
	   		$sql.="ZY='$Pro'";
	   		$note=1;
		 }
	}
	if($note==0)  
	{  
		 $sql="select * from XSB"; 
	}
	return $sql;
}
$sql=getsql($StuNumber, $StuName, $Project);		//得到查询语句
$result=mysql_query($sql);
$total=mysql_num_rows($result);
$page=isset($_GET['page'])?intval($_GET['page']):1;	//获取地址栏中page的值，不存在则设为1
$num=12;                                     		//每页显示12条记录
$url='StuSearch.php';								//本页URL
//页码计算
$pagenum=ceil($total/$num);							//获得总页数，也是最后一页
$page=min($pagenum,$page);							//获得首页
$prepg=$page-1;										//上一页
$nextpg=($page==$pagenum? 0: $page+1);		 		//下一页
$new_sql=$sql." limit ".($page-1)*$num.",".$num;	//按每页记录数生成查询语句
$new_result=mysql_query($new_sql);
if($new_row=mysql_fetch_array($new_result))
{   
	//若有查询结果，则以表格形式输出学生信息
	echo "<br><center><font size=5 face=楷体_GB2312 color=#0000FF>学生信息查询结果</font></center>";
	echo "<table width=480 border=1 align=center cellpadding=0 cellspacing=0 class=STYLE1>";
    echo "<tr bgcolor=#CCCCCC><td>学号</td>";
    echo "<td>姓名</td>";
    echo "<td>性别</td>";
    echo "<td>出生时间</td>";
    echo "<td>专业</td>";
    echo "<td>总学分</td></tr>";
	do
	{
		list($XH,$XM,$XB,$CSSJ,$ZY,$ZXF)=$new_row;
		//设置学号超链接
        echo "<tr><td><a href='info.php?id=$XH' target=search_frmright>$XH</a></td>";
        echo "<td>$XM</td>";
		if($XB==1)
		  	echo "<td>男</td>";
		else 
		  	echo "<td>女</td>"; 
	  	$timeTemp=strtotime($CSSJ);     		//将日期时间解析为UNIX时间戳
	  	$time=date("Y-n-j",$timeTemp); 			//用date函数将时间转换为“年-月-日”形式	
      	echo "<td>$time</td>";					//输出出生日期
      	echo "<td>$ZY</td>";					//输出专业
      	echo "<td>$ZXF</td>";					//输出总学分
      	echo "</tr>";  
	}while($new_row=mysql_fetch_array($new_result));
	echo "</table>";
	//开始分页导航条代码
	$pagenav="";
	if($prepg) 
		$pagenav.="<a href='$url?page=$prepg&StuNumber=$StuNumber&StuName=$StuName&select=$Project'>上一页</a> "; 
	for($i=1;$i<=$pagenum;$i++)
	{
		if($page==$i)
			$pagenav.=$i." ";
		else 
		  	$pagenav.=" <a href='$url?page=$i&StuNumber=$StuNumber&StuName=$StuName&select=$Project'>$i</a>"; 
	}
	if($nextpg)
		$pagenav.=" <a href='$url?page=$nextpg&StuNumber=$StuNumber&StuName=$StuName&select=$Project'>下一页</a>"; 
	$pagenav.="共(".$pagenum.")页";
	//输出分页导航
	echo "<br><div align=center class=STYLE1><b>".$pagenav."</b></div>";	   
}
else
	echo "<script>alert('无记录!');location.href='StuSearch.php';</script>";
?>
