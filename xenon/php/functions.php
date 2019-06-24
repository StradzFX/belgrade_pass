<?php
//=============================== DELETE DIRECTORY AND ITS CONTENT ================================
//prima target i targetfolder za raspakivanje i brise zip sa servera
//
function extractZipFile($targetSource, $targetDestination)
{
	$zip =  new ZipArchive();
	$res = $zip->open($targetSource);
	
	if($res === TRUE) 
	{
		$zip->extractTo($targetDestination);
		$zip->close(); 
	}
	else 
		echo 'There was an error while unpacking file!';
	unlink($targetSource);	
}
//=============================== ZIP FILE FROM ARRAY OF FILES ================================
//prima string $zipFile kao naziv fajla i niz fajlova $fileArray koji ima izvor i destinaciju
//$zipFile = 'DBUpdate.zip';
//primer niza: $fileArray[] = array("source" => "domain/". $dbtable .".class.php", "dest" => $dbtable .".class.php");
function makeZipFile($zipFile,$fileArray)
{
	$zip = new ZipArchive;
	$res = $zip->open($zipFile, ZipArchive::CREATE);
	if ($res === TRUE) {
		for ($i=0; $i<sizeof($fileArray); $i++)
			$zip->addFile($fileArray[$i]['source'], $fileArray[$i]['dest']);
		
    	$zip->close();
		
		header("Content-type: application/octet-stream");
		header("Content-Length: ".filesize($zipFile));
		header("Content-Disposition: attachment; filename=" . $zipFile);

		$fp = fopen($zipFile, 'rb');
		fpassthru($fp);
		fclose($fp); 
	} 
	//unlink($zipFile);
}

//=============================== DELETE DIRECTORY AND ITS CONTENT ================================
function delete_directory($dirname) {
   if (is_dir($dirname))
      $dir_handle = opendir($dirname);
   if (!$dir_handle)
      return false;
   while($file = readdir($dir_handle)) {
      if ($file != "." && $file != "..") {
         if (!is_dir($dirname."/".$file))
            unlink($dirname."/".$file);
         else
            delete_directory($dirname.'/'.$file);     
      }
   }
   closedir($dir_handle);
   rmdir($dirname);
}
//=============================== FULL RECURSIVE FILES AND FOLDERS COPYING ================================
function copy_files_and_folders($source,$target) 
{
	if (is_dir($source)){
		@mkdir( $target );
		$d = dir( $source );
		while ( FALSE !== ( $entry = $d->read() ) ) {
			if ( $entry == '.' || $entry == '..' ) {
				continue;
			}
			$Entry = $source . '/' . $entry; 
			if ( is_dir( $Entry ) ) {
				copy_files_and_folders( $Entry, $target . '/' . $entry );
				continue;
			}
			copy( $Entry, $target . '/' . $entry );
		}
		$d->close();
	}else 
		copy( $source, $target );
}
//=============================== FUNCKIJA ZA GENERISANJE LINKA ================================
function url_link($args) 
{ 
	$get = $_GET;
	$pairs = explode("&",$args);
	foreach($pairs as $pair) 
		if(strpos($pair,"=") === false)
			unset($get[$pair]);
		else {
			list($key, $value) = explode("=",$pair);
			$get[$key] = $value;
		}
	foreach($get as $key => $value)
		if($value == "")
			unset($get[$key]);
	return "index.php?".((count($get) > 0)?http_build_query($get):"");
}
//===============================  ================================
?>