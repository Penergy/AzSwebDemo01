<?php 
/**
 * manipulate user table
 * @return resource
 */


function insertUser($formData, $conn){
	$table = "users";
	print_r($formData);
	return insert($table, $formData, $conn, null);
}