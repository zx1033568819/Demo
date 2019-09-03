<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf8"/>
<meta name="author" content="phpadmin" />
<head>
	<title>学生信息更新</title>
	<style type="text/css">
	<!--
		.STYLE1 {font-size: 15px; font-family: "幼圆";}
	-->
	div{
		text-align:center;
		font-family:"幼圆";
		font-size:24px;
		font-weight:bold;
	}
	</style>
</head>
<body bgcolor="#57C9FF">
<div align="center"><font face="幼圆" size="5" color="#0080FF"><b>学生信息录入</b></font></div>
<form name="frm1" method="post" action="AddStu.php" style="margin: 0;">
	<table width="340" align="center">
		<tr>
			<td width="168"><span class="STYLE1">根据学号查询学生信息:</span></td>
			<td>
				<input name="StuNumber" id="StuNumber" type="text" size="10">
				<input type="submit" name="test" class="STYLE1" value="查找">
			</td>
		</tr>
	</table>
</form>
<?php
$conn=mysql_connect("localhost","root","") or die('连接失败');	//连接服务器
mysql_select_db("PXSCJ2",$conn) or die('连接数据库失败');			//选择数据库
mysql_query("SET NAMES 'utf8'");
session_start();
$number=@$_POST['StuNumber'];
$_SESSION['number']=$number;								//设置字符集									//获取课程号
$sql="select * from XSB where XH='$number'";				//查找课程信息
$result=mysql_query($sql);	
$row=@mysql_fetch_array($result);								//取得查询结果
if(($number!==NULL)&&(!$row))									//判断课程是否存在
	echo "<script>alert('没有该学生信息！')</script>";
 $timeTemp=strtotime($row['CSSJ']);
 $time=date("Y-n-j",$timeTemp);
?>
<form name="frm2" method="post" style="margin: 0;" enctype="multipart/form-data">
	<table bgcolor="#CCCCCC" width="430" border="1" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td bgcolor="#CCCCCC" width="90"><span class="STYLE1">学号:</span></td>
			<td>
				<input name="StuNum" type="text" class="STYLE1" size="35" value="<?php echo $row['XH']; ?>">
				<input name="h_StuNum" type="hidden" value="<?php echo $row['XH']; ?>">
			</td>
		</tr>
		<tr>
			<td bgcolor="#CCCCCC" width="90"><span class="STYLE1">姓名:</span></td>
			<td><input name="StuName" type="text" class="STYLE1" size="35"	value="<?php echo $row['XM']; ?>"></td>
		</tr>
        <tr>
            <td bgcolor="#CCCCCC"><div class="STYLE1">性别</div></td>
            <?php if($row['XB']==0){?>
            <td>
                <input type="radio" name="Sex" value="1"/><span class="STYLE1">男</span>
                <input type="radio" name="Sex" value="0" checked="checked"/><span class="STYLE1">女</span>
            </td>
            <?php } else {?>
            <td>
                <input type="radio" name="Sex" value="1" checked="checked"/><span class="STYLE1">男</span>
                <input type="radio" name="Sex" value="0"/><span class="STYLE1">女</span>
            </td>
            <?php }?>
        </tr>
		<tr>
			<td bgcolor="#CCCCCC"><span class="STYLE1">出生日期:</span></td>
			<td><input name="Birthday" size="35" type="text" class="STYLE1"	value="<?php if($time) echo $time; ?>"></td>
		</tr>
		<tr>
			<td bgcolor="#CCCCCC"><span class="STYLE1">专业:</span></td>
			<td><input name="Project" size="35" type="text" class="STYLE1"	value="<?php echo $row['ZY']?>"></td>
		</tr>
		<tr>
			<td bgcolor="#CCCCCC"><span class="STYLE1">总学分:</span></td>
			<td><input name="StuZXF" size="35" type="text" class="STYLE1" value="<?php echo $row['ZXF'];?>" readonly></td>
		</tr>
        <tr>
            <td bgcolor="#CCCCCC"><span class="STYLE1">备注:</span></td>
            <td>
                <textarea cols="34" rows="4" name="stuBZ" class="STYLE1"><?php echo $row['BZ'] ?></textarea>
            </td>
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
$num=@$_POST['StuNum'];							
$XH=@$_POST['h_StuNum'];					
$name=@$_POST['StuName'];							
$sex=@$_POST['Sex'];						
$birthday=@$_POST['Birthday'];							
$project=@$_POST['Project'];
$points=@$_POST['StuZXF'];
$note=@$_POST['StuBZ'];	
$checkbirthday=preg_match('/^\d{4}-(0?\d|1?[012])-(0?\d|[12]\d|3[01])$/',$birthday);				
//简单的验证函数，验证表单数据的正确性
function test($num,$name,$checkbirthday)
{
	if(!$num)									//判断课程号是否为空
		echo "<script>alert('学号不能为空!');location.href='AddStu.php';</script>";
   	elseif(!$name)								//判断课程名是否为空
   		echo "<script>alert('姓名不能为空!');location.href='AddStu.php';</script>";
   	elseif($checkbirthday==0)					//判断开课学期是否在1-8之间
       	echo "<script>alert('日期格式错误！');location.href='AddStu.php';</script>";
   	
}
//单击【修改】按钮
if(@$_POST["b"]=='修改')									
{   
    echo "<script>if(!confirm('确认修改')) return FALSE;</script>";
	test($num,$name,$checkbirthday);					//检查输入信息
	if($num!=$XH)							//判断用户是否修改了原来的课程号值
		echo "<script>alert('学号与原数据有异，无法修改!');</script>";
	else
	{						  	
		$update_sql="update XSB set XM='$name',XB=$KKXQ,学时=$sex,CSSJ='$birthday',ZY='$project',BZ='$note' WHERE XH='$XH'";		
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
	test($num,$name,$checkbirthday);					
	$s_sql="select XH from XSB where XH='$num'";	
	$s_result=mysql_query($s_sql);
	$s_row=mysql_fetch_array($s_result);
	if($s_row)									//若要添加的课程已经存在则提示
		echo "<script>alert('课程已存在，无法添加!');</script>";
	else
	{
		$insert_sql="insert into XSB(XH,XM,XB,CSSJ,ZY,ZXF,BZ) values('$num', '$name', $sex, '$birthday', '$project',0,'$note')";
		$insert_result=mysql_query($insert_sql) or die('添加失败！');
		if(mysql_affected_rows($conn)!=0)
     	 	echo "<script>alert('添加成功!');</script>"; 
	}
}
//单击【删除】按钮
if(@$_POST["b"]=='删除')						
{
	if(!$num)
	{
		echo "<script>alert('请输入要删除的学号!');</script>";
	}
	else
	{
		$d_sql="select XH from XSB where XH='$num'";	
		$d_result=mysql_query($d_sql);
		$d_row=mysql_fetch_array($d_result);
		if(!$d_row)								//课程如果不存在则提示
			echo "<script>alert('学号不存在，无法删除!');</script>";
		else
		{
			$del_sql="delete from XSB where XH='$num'";
			$del_result=mysql_query($del_sql) or die('删除失败！');
			if(mysql_affected_rows($conn)!=0)
				echo "<script>alert('删除课程".$KCH."成功!');</script>";
		}
	}
}
?>
