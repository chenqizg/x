<?php
    //1,接收用户输入的内容
    $user = $_POST['user'] ?? '';
    $content = $_POST['content'] ?? '';
    //2,将用户输入的内容拼接组装
    $newStr = $user.'&^&'.$content.'&^&'.time().'@^@';
    // echo $newStr;
    //3,写入到文件中保存
      //3.1, 打开文件
      $file = fopen('./mysql.txt','a');
      //3.2, 枷锁，写入文件
      if(flock($file,LOCK_EX)){
        //写入
        $result_int = fwrite($file,$newStr);
        flock($file,LOCK_UN);
      }
      //3.3, 关闭文件
      fclose($file);
    //4,写入成功到查看页面，失败到留言页面
    if($result_int){
         echo '<script>alert("留言成功");location="../Admin/show.php"</script>';
    }else{
        echo '<script>alert("留言失败");location="../Hdmin/hello.html"</script>';
    }