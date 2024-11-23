<!------del.php-----------show.php---------update.php----->

<!DOCTYPE html>
    <html lang="en">
      <head>
        <meta charset="utf-8">
        <title>查看页面</title> 
        <link rel="stylesheet" href="../Home/css/gloge.css">		 
      </head>
      <body>     
        <?php
           //1,读取留言内容mysql.txt
           $file = fopen('./mysql.txt','r');
           $content = '';
           if(flock($file,LOCK_SH)){
              while(!feof($file)){
                $content .= fread($file,1);
              }
              flock($file,LOCK_UN);
           }
           fclose($file);
		            //将读取到的内容遍历到表格中显示
          $arr = explode('@^@',$content);
          array_pop($arr);
		  
		  /****************制作搜索效果******************/
		  //var_dump($_GET);
		  //接收--用户名--留言内容--留言时间--
		  $array = [];
		  $user = $_GET['user'] ?? '';
		  $time = $_GET['datetime'] ?? 'xz';
		  //判断用户搜索内容
		  if($user != ''){
			  //进行查找操作--按用户名搜索
			  foreach($arr as $k=>$v){
				  $vals = explode('&^&',$v);
				  $b = stristr($vals[0],$user);
				  //var_dump($vals);
				  if($b){
					  $array[$k] = $v;
				  }
			  }
			  //将查询到的数据复制到老数组变量中
			  $arr = $array;
			  $userUrl = '&user='.$user;
			  $u = true;
		  }else{
			  $u = false;
			  $userUrl = '';
		  }
		  //按时间搜索也就是--一天---一周---一月--
		  if($time != 'xz'){
			   if($u){
			   $ars = [];
			   //有用户搜素时
			   foreach($arr as $k=>$v){
			   $vals = explode('&^&',$v);
			   //var_dump($vals);
			   if($vals[2] >= strtotime($time) && $vals[2] < time()){
				   $ars[$k] = $v;
				 }
			  }
			  $arr = $ars;
			  }else{
				  //没有用户搜素时
			  }
			  foreach($arr as $k=>$v){
			  $vals = explode('&^&',$v);
			  //var_dump($vals);
			  if($vals[2] >= strtotime($time) && $vals[2] < time()){
				  $array[$k] = $v;
				  }
			  }
			  $arr = $array;
			  $timeUrl = '&datetime='.$time;
		  }else{
			  $timeUrl = '';
		  }
		  //按照键排序
		  if(isset($_GET['sort']) && $_GET['sort'] == 'ksort'){
			  ksort($arr);
			  $sortUrl = '&sort='.$_GET['sort'];
		  }else{
			  //默认情况是倒序
			  krsort($arr);
			  $sortUrl = '&sort=krsort';
		  }
		  //var_dump($_GET);
		  //var_dump($arr);
		  //echo strtotime('-1 day');
		  //var_dump($array);
           //2,遍历到表格中显示
          //var_dump($content);
          echo '<table border="1" width="800" align="center">';
            echo '<caption><h2>查看留言</h2></caption>';
			echo '<thead>';
			
		  /*************制作表头查询功能****************/	
			    echo '<tr align="left">';
                    echo '<td colspan="5">';
					echo '<form method="get" action="">';
					echo '<input type="search" name="user" placeholder="用户名">&nbsp;&nbsp;';
					echo '留言时间&nbsp;&nbsp;';
					echo '<select name="addtime">';
					
					echo '<option value="xz">--请选择--</option>';
					echo '<option value="-1 day">一天内</option>';
					echo '<option value="-1 week">一周内</option>';
					echo '<option value="-1 month">一月内</option>';
					
					echo '</select>&nbsp;&nbsp;';
					
					echo '<input type="submit" value="查询">&nbsp;&nbsp;';
					echo '<a href="?"><input type="button" value="重置"></a>&nbsp;&nbsp;';
					echo '<a href="?sort=krsort'.$userUrl.$timeUrl.'"><input type="button" value="倒序"></a>&nbsp;&nbsp;';
					echo '<a href="?sort=ksort'.$userUrl.$timeUrl.'"><input type="button" value="正序"></a>&nbsp;&nbsp;';
					echo '</form>';
					echo '</td>';                               
                echo '</tr>';
			
		  /*************制作表头查询功能结束************/
		  
                echo '<tr>';
                    echo '<th>编号</th>';
                    echo '<th>用户名</th>';
                    echo '<th>留言内容</th>';
                    echo '<th>留言时间</th>';
                    echo '<th>操作</th>';
                echo '</tr>';
            echo '</thead>';   
 
		  /************制作搜索效果结束******************/
		  	  
		  /****************分页效果制作******************/
		  //1,定义每页显示多少条
		  $page = 22;
		  //2,获取总条数
		  $total = count($arr);
		  //3,得到总页数
		  $pageAll = ceil($total / $page);
		  //4,获取当前页
		  $dpage = $_GET['page'] ?? 1;
		  //5,处理上一页
		  $pagePrev = $dpage - 1 <= 1 ? 1 : ($dpage - 1);
		  //6,处理下一页
		  $pageNext = $dpage + 1 >= $pageAll ? $pageAll : ($dpage + 1);
		  //7,通过系统函数array_slice来获取数据
		  $num = ($dpage - 1) * $page;
		  $con = array_slice($arr,$num,$page,true);
		  
		  
		   /************分页效果制作结束******************/
		   
		  //将读取到的内容遍历到表格中显示	   
		  //var_dump($arr);
          foreach($con as $k=>$v){			  
            $vals = explode('&^&',$v);
            //var_dump($vals);
            echo '<tr align="center">';
                echo '<td>'.$k.'</td>';
                echo '<td>'.$vals[0].'</td>';
                echo '<td>'.$vals[1].'</td>';
                echo '<td>'.date('Y-m-d H:i:s',$vals[2]).'</td>';
                echo '<td><a href="./del.php?key='.$k.'">删除</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="./update.php?key='.$k.'">修改</a></td>';
            echo '</tr>';
          }
          echo '<tfoot>';
			 echo '<tr>';
				echo '<td colspan="2" align="center"><a href="../Home/hello.html">继续添加留言</a></td>';
				echo '<td colspan="3" align="right">';
					echo $total.'条/当前'.$dpage.'页/共'.$pageAll.'页&nbsp;';
					echo '<a href="?page=1'.$userUrl.$timeUrl.$sortUrl.'">首页</a>&nbsp;&nbsp;';
					echo '<a href="?page='.$pagePrev.$userUrl.$timeUrl.$sortUrl.'">上一页</a>&nbsp;&nbsp;';
					echo '<a href="?page='.$pageNext.$userUrl.$timeUrl.$sortUrl.'">下一页</a>&nbsp;&nbsp;';
					echo '<a href="?page='.$pageAll.$userUrl.$timeUrl.$sortUrl.'">尾页</a>';		
				echo '</td>';
			 echo '</tr>';
		  echo '</tfoot>';
		  echo '</table>';
        ?>
        </div>
      </body>
    </html>