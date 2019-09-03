<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf8"/>
<head>
	<title>课程信息更新</title>
	<style type="text/css">
	<!--
		.STYLE1 {font-size: 15px; font-family: "幼圆";}
	-->
	div{
		text-align:center;
		font-family:"幼圆";
		font-size:24px;
		font-weight:bold;
		color:"#008000";
	}
	table{
		width:300px;
	}
	</style>
</head>
<body topMargin="0" leftMargin="0" bottomMargin="0" vlink="#009FEC" bgcolor="#57C9FF">
<div align="center"><font face="幼圆" size="5" color="#0080FF">课程表操作</div>
<form name="frm1" method="post">
	<table align="center">
		<tr>
			<td width="120"><span class="STYLE1">根据课程号查询:</span></td>
			<td>
				<input name="KCNumber" id="KCNumber" type="text" size="10">
				<input type="submit" name="test" class="STYLE1" value="查找">
			</td>
		</tr>
	</table>
</form>
<?php
$conn=mysql_connect("localhost","root","") or die('连接失败');	//连接服务器
mysql_select_db("PXSCJ2",$conn) or die('连接数据库失败');			//选择数据库
mysql_query("SET NAMES 'utf8'");								//设置字符集
$KCNumber=@$_POST['KCNumber'];									//获取课程号
$sql="select * from KCB where KCH='$KCNumber'";				//查找课程信息
$result=mysql_query($sql);	
$row=@mysql_fetch_array($result);								//取得查询结果
if(($KCNumber!==NULL)&&(!$row))									//判断课程是否存在
	echo "<script>alert('没有该课程信息！')</script>";
?>
<form name="frm2" method="post">
	<table bgcolor="#CCCCCC" border="1" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td bgcolor="#CCCCCC" width="90"><span class="STYLE1">课程号:</span></td>
			<td>
				<input name="KCNum" type="text" class="STYLE1" value="<?php echo $row['KCH']; ?>">
				<input name="h_KCNum" type="hidden" value="<?php echo $row['KCH']; ?>">
			</td>
		</tr>
		<tr>
			<td bgcolor="#CCCCCC" width="90"><span class="STYLE1">课程名:</span></td>
			<td><input name="KCName" type="text" class="STYLE1"	value="<?php echo $row['KCM']; ?>"></td>
		</tr>
		<tr>
			<td bgcolor="#CCCCCC"><span class="STYLE1">开课学期:</span></td>
			<td><input name="KCTerm" type="text" class="STYLE1"	value="<?php echo $row['KKXQ']; ?>"></td>
		</tr>
		<tr>
			<td bgcolor="#CCCCCC"><span class="STYLE1">学时:</span></td>
			<td><input name="KCtime" type="text" class="STYLE1"	value="<?php echo $row['XS']?>"></td>
		</tr>
		<tr>
			<td bgcolor="#CCCCCC"><span class="STYLE1">学分:</span></td>
			<td><input name="KCCredit" type="text" class="STYLE1" value="<?php echo $row['XF'];?>"></td>
		</tr>
		<tr>
			<td align="center" colspan="2" bgcolor="#CCCCCC">
				<input name="b" type="submit" value="修改" class="STYLE1">&nbsp;
				<input name="b" type="submit" value="添加" class="STYLE1"/>&nbsp;
				<input name="b" type="submit" value="删除" class="STYLE1">&nbsp;
			</td>
		</tr>
	</table>
</form>
</body>
</html>
<?php
$KCH=@$_POST['KCNum'];							//课程号
$h_KCH=@$_POST['h_KCNum'];						//表单中原有的隐藏文本中的课程号
$KCM=@$_POST['KCName'];							//课程名
$KKXQ=@$_POST['KCTerm'];						//开课学期
$XS=@$_POST['KCtime'];							//学时
$XF=@$_POST['KCCredit'];						//学分
//简单的验证函数，验证表单数据的正确性
function test($KCH,$KCM,$KKXQ,$XF)
{
	if(!$KCH)									//判断课程号是否为空
		echo "<script>alert('课程号不能为空!');location.href='AddClass.php';</script>";
   	elseif(!$KCM)								//判断课程名是否为空
   		echo "<script>alert('课程名不能为空!');location.href='AddClass.php';</script>";
   	elseif($KKXQ>8||$KKXQ<1)					//判断开课学期是否在1-8之间
       	echo "<script>alert('开课学期必须为1-8的数字!');location.href='AddClass.php';</script>";
   	elseif(!is_numeric($XF))					//判断学分是否为数字
       	echo "<script>alert('学分必须为数字!');location.href='AddClass.php';</script>";
}
//单击【修改】按钮
if(@$_POST["b"]=='修改')									
{    
	test($KCH,$KCM,$KKXQ,$XF);					//检查输入信息
	if($KCH!=$h_KCH)							//判断用户是否修改了原来的课程号值
		echo "<script>alert('课程号与原数据有异，无法修改!');</script>";
	else
	{						  	
		$update_sql="update KCB set KCM='$KCM',KKXQ=$KKXQ,XS=$XS,XF=$XF WHERE KCH='$KCH'";		
		$update_result=mysql_query($update_sql);						
     	if(mysql_affected_rows($conn)!=0)
			echo "<script>alert('修改成功!');</script>";
		else
			echo "<script>alert('信息未修改!');</script>";
	}
}
//单击【添加】按钮
if(@$_POST["b"]=='添加')						
{
	test($KCH,$KCM,$KKXQ,$XF);					
	$s_sql="select KCH from KCB where KCH='$KCH'";	
	$s_result=mysql_query($s_sql);
	$s_row=mysql_fetch_array($s_result);
	if($s_row)									//若要添加的课程已经存在则提示
		echo "<script>alert('课程已存在，无法添加!');</script>";
	else
	{
		$insert_sql="insert into KCB(KCH,KCM,KKXQ,XS,XF) values('$KCH', '$KCM', $KKXQ, $XS, $XF)";
		$insert_result=mysql_query($insert_sql) or die('添加失败！');
		if(mysql_affected_rows($conn)!=0)
     	 	echo "<script>alert('添加成功!');</script>"; 
	}
}
//单击【删除】按钮
if(@$_POST["b"]=='删除')						
{
	if(!$KCH)
	{
		echo "<script>alert('请输入要删除的课程号!');</script>";
	}
	else
	{
		$d_sql="select KCH from KCB where KCH='$KCH'";	
		$d_result=mysql_query($d_sql);
		$d_row=mysql_fetch_array($d_result);
		if(!$d_row)								//课程如果不存在则提示
			echo "<script>alert('课程号不存在，无法删除!');</script>";
		else
		{
			$del_sql="delete from KCB where KCH='$KCH'";
			$del_result=mysql_query($del_sql) or die('删除失败！');
			if(mysql_affected_rows($conn)!=0)
				echo "<script>alert('删除课程".$KCH."成功!');</script>";
		}
	}
}
?>
