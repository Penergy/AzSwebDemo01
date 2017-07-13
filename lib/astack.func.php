<?php
	
	/**
	 * $info = [
	 *		'user' => 
	 *		'dnsName' =>
	 *		'ipAddr' => 
	 * ]
	 *
	 */
	function setDNS($info){
		$azConfig = AZ_ROOT;
		$loginConfig = [
			'azureUser' => $info["azureENUser"],
			'azurePwd' => $info["azureENPwd"],
			'azureEnv' => $info["azureENEnv"],
		];

		$rgConfig = [
			'rgName' => DNS_RG,
			'azConfig' => AZ_ROOT,
			'location' => $info["locationEN"],
		];
		
		$azureCNUser = $info["azureCNUser"];
		$azureCNPwd = $info["azureCNPwd"];
		$azureENUser = $info["azureENUser"];
		$azureENPwd = $info["azureENPwd"];
		$azureCNEnv = $info["azureCNEnv"];
		$azureENEnv = $info["azureENEnv"];
		$location = $info["locationEN"];
		$ipAddr = $info["ipAddr"];
		$dnsPrefix = $info["dnsPrefix"];

		azureLogin($loginConfig);
		$setDnsCmd = $azConfig."az network dns record-set a add-record -g ".DNS_RG." -z i-stack.org -n ".$dnsPrefix." -a ".$ipAddr;
		print_r($setDnsCmd);
		echo "\n";
		$output = shell_exec($setDnsCmd);
		$output = json_decode($output);
		echo "\n";
		azureLogout($info);
		return $output;
	}

	function setAzureVM($info){
		$azConfig = AZ_ROOT;
		$loginConfig = [
			'azureUser' => $info["azureCNUser"],
			'azurePwd' => $info["azureCNPwd"],
			'azureEnv' => $info["azureCNEnv"],
		];

		$rgConfig = [
			'rgName' => $info["rgName"],
			'azConfig' => AZ_ROOT,
			'location' => $info["locationCN"],
		];
		azureLogin($loginConfig);
		createRg($rgConfig);
		// Creating template
		$filePath = $info['fileName'];
		$vmName = $info["rgName"];
		$vmName = '--parameters "{\"vmName\":{\"value\":\"'.$vmName.'\"}}"';
		$appName = $info["rgName"];
		$deployTemplateCmd = $azConfig."az group deployment create --name '".$appName."' --resource-group '".$info["rgName"]."' --template-file '".$filePath."' ".$vmName;
		$output = shell_exec($deployTemplateCmd);
		echo "Set Azure VM ...";
		echo "\n";
		$output = json_decode($output);

		azureLogout($info);
		if(isset($output->properties->outputs->publicIp)){
			return $output->properties->outputs->publicIp->value;
		}else{
			return false;
		}

		
	}

	function createRg($rgConfig){
		// create a resource group 
		$azConfig = AZ_ROOT;
		$rgName = $rgConfig['rgName'];
		$location = $rgConfig["location"];

		$createRGcmd = $azConfig."az group create --name '".$rgName."' --location '".$location."'";
		$output = shell_exec($createRGcmd);
		// print_r($output);
		echo "create resource group ...";
		echo "\n";
	}

	function azureDeleteRg($rgConfig){
		$azConfig = AZ_ROOT;
		$rgName = $rgConfig['rgName'];

		$createRGcmd = $azConfig."az group delete --yes --name '".$rgName."'";
		$output = shell_exec($createRGcmd);
		// print_r($output);
		echo "delete resource group ...";
		echo "\n";
		return json_decode($output);
	}
	
	// $filePath = "/var/www/html/curlTest/azuredeploy.json";
	function azureLogin($loginConfig){
		$azConfig = AZ_ROOT;
		$azureUser = $loginConfig["azureUser"];
		$azurePwd = $loginConfig["azurePwd"];
		$azureEnv = $loginConfig["azureEnv"];

		$setEnvCmd = $azConfig."az cloud set --name ".$azureEnv;
		$loginCmd = $azConfig."az login -u '".$azureUser."' -p '".$azurePwd."'";
		// login Azure
		$output = shell_exec($setEnvCmd);
		$output = shell_exec($loginCmd);
		$output = json_decode($output);
		echo "log in azure ...";
		echo "\n";
	}

	function azureLogout($info){
		$azConfig = AZ_ROOT;
		$logoutCmd = $azConfig."az logout";
		// logout Azure
		$output = shell_exec($logoutCmd);
		echo "log out azure ...";
		echo "\n";
	}

?>