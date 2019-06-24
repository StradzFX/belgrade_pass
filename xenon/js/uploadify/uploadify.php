<?php
if(!empty($_FILES)) 
{
	$random_number = rand(1,10000);
	
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_GET['folder'];
	
	if(!file_exists($targetPath))
	{
		mkdir($targetPath, 0777, true);
		chmod($targetPath, 0755);	
	}
	$targetFile = rtrim($targetPath,'/') . '/' .$random_number."_". $_FILES['Filedata']['name'];
	
	$fileTypes = array("php", "phtml", "php3", "php4", "js", "shtml", "pl" ,"py","exe","bat"); 
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	if(strlen($_FILES['Filedata']["name"]) < $_GET['maxchar'])
	{
		if($_FILES['Filedata']["size"]/(1024*1024) < str_replace("M","",ini_get("upload_max_filesize")))
		{
			if(!in_array($fileParts['extension'],$fileTypes)) 
			{
				move_uploaded_file($tempFile,$targetFile);
				echo $random_number . "_" . $_FILES['Filedata']['name'];
			} 
		}
	}else{
		header('HTTP/1.1 500 Internal Server Error');	
	}
	
	
		
	
	
		
}
?>