<?php

function istackDeleteStack($info){
	echo "start to delete i-stack app ...\n";
	$user = $info->user;
	print_r($user);
	$app = $info->app;
	$keystoneBaseUrl = $info->keystoneBaseUrl;
	$deleteCmd = "openstack --os-username ".$user->os_user_name." --os-password ".$user->os_password." --os-tenant-name ".$user->os_project_name." --os-auth-url ".$keystoneBaseUrl." stack delete --yes ".$app->stack_id;
	echo $deleteCmd."\n";
	$output = shell_exec($deleteCmd);
	$output = json_decode($output);
	print_r($output);
	if($output){
		return true;
	}else{
		return false;
	}

}