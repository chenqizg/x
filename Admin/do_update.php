<?php
	//---show.php------doupdate.php-----update.php---
	var_dump($_POST);
	
	//1,拼接修改的数据内容（字符串）
	$newStr = $_POST['user'].'&^&'.$_POST['content'].'&^&
	'.$_POST['datetime'];
	
	echo $newStr;
	//2,查找MySQL.txt中的所有内容
	$str = file_get_contents('./mysql.txt');
	//3,遍历成数组格式
	$arr = explode('@^@',$str);

	//4,将修改的内容替换掉原有的内容
	//数组变量【下标】= 新值
	$arr[$_POST['key']] = $newStr;
	//var_dump($arr);
	//将修改后的数组再次转换成字符串
	$strs = implode('@^@',$arr);
	//var_dump($strs);
	
	//5,以覆盖的方式写回文件中保存
	$int = file_put_contents('./mysql.txt',$strs);
	if($int > 0){
		echo '<script>alert("修改成功");location="./show.php"</script>';
	}else{
		echo '<script>alert("修改失败");location="./update.php?key='.$_POST['key'].'"</script>';
	}