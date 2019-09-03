<?php
$conn=mysql_connect("localhost","root","") or die('连接失败');	//连接服务器
mysql_select_db("PXSCJ2",$conn) or die('连接数据库失败');			//选择数据库
mysql_query("SET NAMES 'utf8'");
header("Content-Type:text/html;charset=utf8");	//使用GB2312编码，防止输出中文时出现乱码
$id=$_GET['id'];									//单击超链接得到的id值
$kcname=$_GET['kcname'];
$points=$_GET['points'];
$array=explode("-",$id);							//将字符串$id分解成数组
$action=$array[0];									//数组第一个值为单击的超链接的动作，keep或delete
$number=$array[1];									//第二个值为当前行的学号
//查询课程号
$kc_sql="select KCH from KCB where KCM='$kcname'"; 
$kc_result=mysql_query($kc_sql);
$kc_row=mysql_fetch_array($kc_result);
$kcnumber=$kc_row['KCH'];
if($action=="keep")									//如果单击了保存超链接
{
	if($points)
	{
		//调用存储过程CJ_DATA实现成绩的插入和修改
		$cj_sql="CALL CJ_data('$number','$kcnumber',$points)";	
		$cj_result=mysql_query($cj_sql);
		if($cj_result)
			echo '保存成功!';
		else
			echo "保存失败！";
	}
	else
		echo "成绩值为空，请输入成绩！";
}
if($action=="delete")								//如果单击了删除链接
{
	//调用存储过程CJ_DATA，成绩参数的值设为-1
	$cj_sql="CALL CJ_data('$number','$kcnumber',-1)";	
	$cj_result=mysql_query($cj_sql);
	if(mysql_affected_rows($conn)!=0)
		echo "删除成功！";
	else
		echo "删除失败！";
}
?>
