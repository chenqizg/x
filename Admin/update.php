<?php
	//----do_update.php--------update.php--------show.php----
	//1,本页面执行也需要修改指定的key
	if(isset($_GET['key'])){
		//读取文件操作 查找到指定key的数据
		$content = file_get_contents('./mysql.txt');
		//将得到的内容转换成数组
		$arr = explode('@^@',$content);
		//分割得到数组中指定的数据
		$array = explode('&^&',$arr[$_GET['key']]);
		//var_dump($array);
		//获取用户名及留言内容
		$user = $array[0];
		$content = $array[1];
		$time = $array[2];
	}else{
		$user = '';
		$content = '';
		echo '<script>alert("没有传入要修改数据的key");
		location="../Admin/show.php"</script>';
	}
	 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>修改留言</title>
	 <link rel="stylesheet" href="../Home/css/gloge.css">
  </head>
  <body>
    <div id="one">
      <form action="./do_update.php" method="post">
        用户名:
        <input type="text" name="user" placeholder="
        请你输入用户名" value="<?=$user ?>"><br/><br/>
        留言内容:
        <textarea name="content" cols="50" rows="5"
        placeholder="请你输入留言内容"><?=$content?>
		</textarea><br/><br/>
		<input type="hidden" name="datetime" value="
		<?=$time?>"/>
		<input type="hidden" name="key" value="<?=$_GET['key']?>"/>
        <input type="submit" value="修改留言"/>
		<a href="./show.php">
			<input type="button" value="返回"/>
		</a>
      </form>
    </div>
  </body>
</html>