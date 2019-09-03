<?php
$conn=mysql_connect("localhost","root","") or die('连接失败');	//连接服务器
mysql_select_db("PXSCJ2",$conn) or die('连接数据库失败');			//选择数据库
mysql_query("SET NAMES 'utf8'");
$KCName=$_GET['KCName'];
$ZYName=$_GET['ZYName'];
echo "<br><div align=center class=STYLE2>$KCName</div>";	//输出课程名
echo "<table width=450 border=1 align=center cellpadding=0 cellspacing=0 class=STYLE1>";
echo "<tr bgcolor=#CCCCCC height=25 align=center><td>学号</td>";
echo "<td>姓名</td>";
echo "<td>成绩</td>";
echo "<td width=160>操作</td></tr>";
if(!$KCName&&!$ZYName)							//课程名和专业都为空则输出一张空表
{
	for($i=0;$i<10;$i++)
	{
		echo "<tr height=28><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
	}
}
else
{
	if($KCName=="请选择")						//如果未选课程则进行相应提示
		echo "<script>alert('请选择课程');location.href='AddStuScore.php'</script>";
	else
	{
		$total=0;								//初始化总记录数的值为0
		if($ZYName=="请选择")
		{
			//查找学号、姓名和所在的行数
			$XS_sql="select XH,XM from XSB";				 
		}
		else
		{
			$XS_sql="select XH,XM from XSB where ZY='$ZYName'";
		}
		$XS_result=mysql_query($XS_sql);
		$total=mysql_num_rows($XS_result);		//计算总记录数
		//获取地址栏中page的值不存在则设为1
		$page=isset($_GET['page'])?intval($_GET['page']):1;
		$url='AddStuScore.php';					//本页URL
		//页码计算
		$num=10;								//设置每页显示的记录数
		$pagenum=ceil($total/$num);             //获得总页数，也是最后一页
		$page=min($pagenum,$page);				//获得首页
		$prepg=$page-1;							//上一页
		$nextpg=($page==$pagenum? 0: $page+1);	//下一页
		$offset=($page-1)*$num;                 //获取本页记录数的起始值
		$endnum=$offset+$num;					//本页记录数的最大值
		//查找从($offset+1)行到$endnum行的记录
		$new_sql=$XS_sql." limit ".($page-1)*$num.",".$num;
		$new_result=mysql_query($new_sql);		//执行查询语句
		while($new_row=mysql_fetch_array($new_result))
		{
			list($number,$name)=$new_row;		//列出结果值
			//查找成绩的SQL语句			
			$CJ_sql="select CJ from CJB where XH='$number' and KCH=(select KCH from KCB where KCM='$KCName')";
			$CJ_result=mysql_query($CJ_sql);						
			$CJ_row=mysql_fetch_array($CJ_result);
			$points=$CJ_row['CJ'];				//取出成绩值
			//设置一个隐藏控件用于存放课程名
			echo "<input type=hidden value=$KCName id='course'>";	
			//输出学号
			echo "<tr class=STYLE1 align=center><td width=110>$number</td>"; 
			echo "<td width=110>$name</td>";	//输出姓名
			//在文本框中输出成绩
			echo "<td width=110><input id='points-$number' type=text size=12 value=$points></td>";			//设置保存超链接，单击超链接时调用run()函数
			echo "<td><a href=# onclick=\"run(this.id,'$number')\" id='keep-$number'>保存</a>&nbsp;&nbsp;";
			//设置删除超链接
			echo "<a href=# onclick=\"run(this.id,'$number')\" id='delete-$number'>删除</a></td></tr>";
		}
		echo "</table>";
		//开始分页导航条代码
		$pagenav="";
		if($prepg)				
			$pagenav.=" <a href='$url?page=$prepg&KCName=$KCName&ZYName=$ZYName'>上一页</a> ";
		for($i=1;$i<=$pagenum;$i++)
		{
			if($page==$i) 
				$pagenav.=$i." ";
			else
			$pagenav.="<a href='$url?page=$i&KCName=$KCName&ZYName=$ZYName'>$i</a>";
		}
		if($nextpg)
			$pagenav.=" <a href='$url?page=$nextpg&KCName=$KCName&ZYName=$ZYName'>下一页</a> ";
		$pagenav.="共(".$pagenum.")页";
		echo "<br><div align=center class=STYLE1><b>".$pagenav."</b></div>"; //输出分页导航 
	}
}
?>
<script>
//使用AJAX无刷新技术
var xmlHttp;      				//定义一个XMLHTTP变量
function GetXmlHttpObject()    	//XMLHTTP的实例化函数，用于创建一个XMLHTTP对象
{
	var xmlHttp=null;
	try	 
	{ 	
		xmlHttp=new XMLHttpRequest();	   
	}
	catch(e)
	{   
		 try
		 {   
			ttp=new ActiveXObject("Msxml2.XMLHTTP");    
		 }
		 catch(e)
		 {
			mlHttp=new ActiveXObject("Microsoft.XMLHTTP"); 
		 }
	}
	return xmlHttp;
}  
//run()函数的参数str是超链接的id，num是成绩文本框id的后缀
function run(str,num)
{ 
	//调用GetXmlHttpObject()创建一个XMLHTTP对象
	xmlHttp=GetXmlHttpObject();   			
	var kcname=document.getElementById("course").value;			//得到课程名
	var points=document.getElementById("points-"+num).value;	//得到文本框中的成绩值
	var url="StuCJ.php";        								//服务器端在StuCJ.php中处理
	url=url+"?id="+str+"&points="+points+"&kcname="+kcname;		//url地址，以GET方式传递
	//添加一个随机数，以防服务器使用缓存的文件
	url=url+"&sid="+Math.random();  						
	//通过给定的URL打开XMLHTTP对象
	xmlHttp.open("GET",url,true);    						
	xmlHttp.send(null);       									//向服务器发送HTTP请求
	xmlHttp.onreadystatechange = function()
	{
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") 
		{ 
			alert(xmlHttp.responseText);						//弹出对话框提示操作结果
			//如果执行了删除动作就将成绩文本框中的值清空
			if(xmlHttp.responseText=='删除成功！')		
				document.getElementById("points-"+num).value="";
		}        
	}
}
</script>
