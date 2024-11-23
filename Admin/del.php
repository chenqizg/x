<?php
    /* show.php------del.php-------show.php
	   1,告诉本页面你需要删除那一条（指定要删除的key)
	   2,j将数据从mysql.txt 中读出，转换成数组，show.
	   php页面一样的数组
	   3，把指定的key在查询的数组中删除
	   4，将数组再次转换成字符串
	   5，将新的字符串再次保存到文件中
	   6，删除成功
	*/
	//1,判断用户传入要删除数据的指定key
	//date_default_timezone_set('PRC');
	if(isset($_GET['key'])){
		//执行删除
		//1,打开文件
		$file = fopen('./mysql.txt','r');
		//2,读取文件
		if(flock($file,LOCK_SH)){
			$con = '';
			while(!feof($file)){
				$con .= fread($file,1);
			}
		}
		$arr = explode('@^@',$con);
		//删除内容
		unset($arr[$_GET['key']]);
		//再次将数组转换成字符串
		$newStr = implode('@^@',$arr);
		//var_dump($newStr);
		
		//3,关闭文件
		fclose($file);
		//var_dump($newStr);
		//4,再次打开文件  以 W 方式打开文件
		$file = fopen('./mysql.txt','w');
		//5,将组装后的新字符串保存到文件中
		if(flock($file,LOCK_EX)){
			$int = fwrite($file,$newStr);
		}
		//再次关闭文件
		fclose($file);
		//判断如果将新数据写入成功，则代表删除成功
		if($int > 0){
			echo '<script>alert("删除成功");location="../Admin/show.php"</script>';
		}else{
			echo '<script>alert("删除失败");location="../Admin/show.php"</script>';
		}
	}else{
		/*没有指定要删除的key--不能删除
		  提示信息并返回到查询留言页面
		*/
		
		echo '<script>alert("没有传入指定数据的key")
		;location="../Admin/show.php"</script>';
	} 