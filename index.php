

<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <title>留言板</title>
   <link rel="stylesheet" href="./Home/css/gloge.css" type="text/css">
  </head>
  <body>
<?php
	//foreach是遍历数组的专用循环，所有的数组都能遍历，关联，混合，
	//索引（不连续的索引值）
	$arr = array(
		array('id'=>1,'name'=>'杜子腾','age'=>18,'sex'=>1),
		array('id'=>2,'name'=>'魏升值','age'=>20,'sex'=>0),
		array('id'=>3,'name'=>'朱大常','age'=>18,'sex'=>1),
		array('id'=>4,'name'=>'段家才','age'=>17,'sex'=>0),
		array('id'=>5,'name'=>'马飞多','age'=>23,'sex'=>1),
		array('id'=>6,'name'=>'无能','age'=>25,'sex'=>0),
		array('id'=>7,'name'=>'范童','age'=>24,'sex'=>1),
		array('id'=>8,'name'=>'猴屁股','age'=>22,'sex'=>0),
		array('id'=>9,'name'=>'范童','age'=>24,'sex'=>1),
		array('id'=>10,'name'=>'猴屁股','age'=>22,'sex'=>0),
	);
	//var_dump($arr);
	//var_dump($_GET);
	//定义一个性别数组
	$sex = array('女','男');
	//var_dump($sex);
	echo '<form action="" method="get">';
	 echo '<table border="1" align="center" width="800">';
		echo '<caption><h2>学习园地员工管理表</h2></caption>';
	    echo '<tr>';
			echo '<td colspan="4">';
				echo '<a href="?order=1"><input type="button"
				   value="从小到大"></a>&nbsp;&nbsp;';
				echo '<a href="?order=2"><input type="button"
     			   value="从大到小"></a>&nbsp;&nbsp;';
				
				   echo '<select name="sex">';
				      echo '<option value="xz">--请选择--</option>';
					  echo '<option value="0">女</option>';
					  echo '<option value="1">男</option>';
				   echo '</select>';
				   echo '<input type="submit" value="查询"/>&nbsp;&nbsp;';
				   echo '<a href="?"><input type="button" value="重置"/></a>';				   
			echo '</td>';
	    echo '</tr>';
		echo '<tr>';
			echo '<th>编号</th>';
			echo '<th>姓名</th>';
			echo '<th>年龄</th>';
			echo '<th>性别</th>';			 
	    echo '</tr>';
		
		//如果传参order的话，判断等于 0 表示从小到大排序数组 
		//等于 1 表示从大到小排序数组 都是安年龄排序	

		/*思考：
		  1，只要用户添加了搜索条件，需要按照用户的搜索条件来组成按照
		  这个要求的数组
		*/
		//1,接收order参数
		$order = $_GET['order'] ?? null;
		$sexSearch = $_GET['sex'] ?? 'xz';
		//echo $sexSearch;
		$len = count($arr);
		//初始化url传参变量
		$sexUrl = $orderUrl = '';
		//2,判断用户到底选择的是那一个操作
		if($order == 1){
			//用户需要从小到大按照年龄排序
			for($i = 0; $i < $len - 1; $i ++){
				for($j = 0; $j < $len - $i -1; $j ++){
					if($arr[$j]['age'] > $arr[$j+1]['age']){
						$tmp = $arr[$j];
						$arr[$j] = $arr[$j + 1];
						$arr[$j + 1] = $tmp;
					}
				}
				//打印
				//var_dump($arr);
			}
			//赋值url
			$ordeUrl = '&order=1';
		}elseif($order == 2){
			//用户需要按照年龄从大到小排序
			for($i = 0; $i < $len - 1; $i ++){
				for($j = 0; $j < $len - $i -1; $j ++){
					if($arr[$j]['age'] < $arr[$j+1]['age']){
						$tmp = $arr[$j];
						$arr[$j] = $arr[$j + 1];
						$arr[$j + 1] = $tmp;
					}
				}
				//var_dump($arr);
			}
			//赋值url
			$ordeUrl = '&order=2';
		} 
		if($sexSearch != 'xz'){
			//echo 'aaa';
			 /*性别判断：
		     如果用户需要按照性别搜索，从原始的$arr数组中提取所有按照
		     用户搜索的性别数据，单独成立一个数组，为了兼容下面数组遍
			 历输出，提取的数组最后还需要赋值给$arr    */
			$array = array();
			foreach($arr as $v){
				 if($sexSearch == $v['sex']){
					    //var_dump($v);
					    $array[] = $v;
				     }		     
		        }
				//var_dump($array);
				//将得到的新数组再赋值给$arr，目的是
				//不影响下面代码的数据遍历
				$arr = $array;
				$sexUrl = '&sex='.$sexSearch;
				//echo $sexUrl;
		   }
		   
		/***************添加分页效果****************/
		    //1.定义每页显示多少条
			$page = 3;
		    //2.获取数据总条数
			$len = count($arr);
		    //3.得到总页数 ceil() 函数可以进一取整数
			$pageAll = ceil($len / $page);
			//4.打印输出数据
			//var_dump($pageAll);
			//5,获取当前页
			$dpage = $_GET['page'] ?? 1;
			//6,处理上一页
			$prePage = $dpage - 1 <= 1 ? 1 : ($dpage - 1);
			//7,处理下一页
			$nextPage = $dpage + 1 >= $pageAll ? $pageAll : ($dpage + 1);
		    //8,处理数据
			$num = ($dpage - 1) * $page;
			$arr = array_slice($arr,$num,$page,true);
	    /***************分页效果结束****************/
		
		foreach($arr as $k=>$v){		
			$bgcolor = $k % 2 == 1?'#ddd':'';
			 echo '<tr align="center" bgcolor="'.$bgcolor.'">';
				 echo '<td>'.$v['id'].'</td>';
				 echo '<td>'.$v['name'].'</td>';
				 echo '<td>'.$v['age'].'</td>';
				 echo '<td>'.$sex[$v['sex']].'</td>';				 
			 echo '</tr>';
		} 
		echo '<tr>';
		     echo '<td align="right" colspan="4">';
		     echo '<span>共'.$len.'条,'.$dpage.'/'.$pageAll.'
			      页</span>&nbsp;&nbsp;';
			 echo '<a href="?page=1'.$sexUrl.$orderUrl.'
			      ">首页</a>&nbsp;&nbsp;';
			 echo '<a href="?page='.$prePage.$sexUrl.$orderUrl.'
			      ">上一页</a>&nbsp;&nbsp;';
			 echo '<a href="?page='.$nextPage.$sexUrl.$orderUrl.'
			      ">下一页</a>&nbsp;&nbsp;';
			 echo '<a href="?page='.$pageAll.$sexUrl.$orderUrl.'
			      ">尾页</a>';		 
		    echo '</td>';
		echo '</tr>';
	echo '</table>';
	echo '</form>';	
?>	  
	</body>
	</html>