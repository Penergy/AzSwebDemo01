<?php 
/**
 * connect database
 * @return resource
 */
function connect(){
	try{
		$conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DBNAME.";charset=".DB_CHARSET, DB_USER, DB_PWD);
		print_r("database: Connected...\n");
		print_r($_ENV);
	}catch (Exception $e){
		print_r( "Unable to connect: " . $e->getMessage()."...");
		print_r($_ENV);
	}
	return $conn;
}

/**
 * \u5b8c\u6210\u8bb0\u5f55\u63d2\u5165\u7684\u64cd\u4f5c
 * @param string $table
 * @param array $array
 * @return number
 */
function insert($table,$array,$conn,$str=null){
	foreach($array as $key=>$val){
		if($str==null){
			$sep="";
		}else{
			$sep=",";
		}
		$str.=$sep.$key."='".$val."'";
	}
	$sql="insert {$table} set {$str} ";
	$result=$conn->prepare($sql)->execute();
	if($result){
		return true;
	}else{
		return false;
	}
}
//update imooc_admin set username='king' where id=1
/**
 * \u8bb0\u5f55\u7684\u66f4\u65b0\u64cd\u4f5c
 * @param string $table
 * @param array $array
 * @param string $where
 * @return number
 */
function update($table,$array,$where=null,$conn,$str=null){
	foreach($array as $key=>$val){
		if($str==null){
			$sep="";
		}else{
			$sep=",";
		}
		$str.=$sep.$key."='".$val."'";
	}
	$sql="update {$table} set {$str} ".($where==null?null:" where ".$where);
	$result=$conn->prepare($sql)->execute();
	if($result){
		return true;
	}else{
		return false;
	}
}

/**
 *	\u5220\u9664\u8bb0\u5f55
 * @param string $table
 * @param string $where
 * @return number
 */
function delete($table,$where=null){
	$where=$where==null?null:" where ".$where;
	$sql="delete from {$table} {$where}";
	mysql_query($sql);
	return mysql_affected_rows();
}

/**
 *\u5f97\u5230\u6307\u5b9a\u4e00\u6761\u8bb0\u5f55
 * @param string $sql
 * @param string $result_type
 * @return multitype:
 */
function fetchOne($sql,$result_type=MYSQL_ASSOC){
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result,$result_type);
	return $row;
}


/**
 * \u5f97\u5230\u7ed3\u679c\u96c6\u4e2d\u6240\u6709\u8bb0\u5f55 ...
 * @param string $sql
 * @param string $result_type
 * @return multitype:
 */
function fetchAll($sql,$conn){
	// $result=$conn->query($sql)->fetchAll(PDO::FETCH_KEY_PAIR);
	$result = $conn->query($sql)->fetchAll(PDO::FETCH_UNIQUE);
	foreach ($result as $key => $value) {
		# code...
	}
	return $result;
}

/**
 * \u5f97\u5230\u7ed3\u679c\u96c6\u4e2d\u7684\u8bb0\u5f55\u6761\u6570
 * @param unknown_type $sql
 * @return number
 */
function getResultNum($sql){
	$result=mysql_query($sql);
	return mysql_num_rows($result);
}

/**
 * \u5f97\u5230\u4e0a\u4e00\u6b65\u63d2\u5165\u8bb0\u5f55\u7684ID\u53f7
 * @return number
 */
function getInsertId(){
	return mysql_insert_id();
}