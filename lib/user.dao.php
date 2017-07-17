<?php 
/**
 * manipulate user table
 * @return resource
 */


function insertUser($formData, $conn){
	$table = "users";
	return insert($table, $formData, $conn, null);
}

function getUserList($conn){
	$table = "users";
	return fetchAll($table, $conn);
}