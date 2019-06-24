<?php 
session_start();
include_once '../config.php';
include_once '../../classes/database/db_broker.php';
$broker = new db_broker();

/*  	$zip = new ZipArchive();

	$filename = "reports/website_files.zip";
	
	if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
		exit("cannot open <$filename>\n");
	}else{
		echo 'otvorio';
	}
	
	//var_dump(file_exists("../../files/tribes/image/1002_foresta.png"));
	
	$zip->addFile("../../files/",'files/');
	
	
	
	*/
	
	
	// Get real path for our folder
	$rootPath = realpath('../../files/');
	
	// Initialize archive object
	$zip = new ZipArchive;
	$zip->open('downloads/website_files.zip', ZipArchive::CREATE);
	// Create recursive directory iterator
	$files = new RecursiveIteratorIterator(
	    new RecursiveDirectoryIterator($rootPath),
	    RecursiveIteratorIterator::LEAVES_ONLY
	);
	
	foreach ($files as $name => $file) {
	    // Get real path for current file
	    $filePath = $file->getRealPath();
	
	    // Add current file to archive
	    $zip->addFile($filePath);
	
	    // Add current file to "delete list" (if need)
	    if ($file->getFilename() != 'important.txt') 
	    {
	        $filesToDelete[] = $filePath;
	    }
	}
	
	// Zip archive will be created only after closing object
	$zip->close();
	
$file = 'downloads/website_files.zip';

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    flush();
    readfile($file);
    exit;
}	

?>
