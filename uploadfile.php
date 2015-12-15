<?php

$file_name = $_FILES['file']['name'];
$file_ext = pathinfo($file_name,PATHINFO_EXTENSION);
$file_dest_name = $file_name;
$file_dest = dirname(__FILE__) . '\\upload\\' . $file_dest;

$limit_size = 1024 * 1024 * 2; //byte

$support_file_types = array('jpeg','jpg','png','gif','bmp');


/********************************************************************
 * Sometimes, the $_FILES['file']['type'] can be wrong,
 * so the better way to get the file type is to get the file extension
 * *****************************************************************/

if (in_array($file_ext, $support_file_types)) {
	
	if ($_FILES['file']['size'] < $limit_size) {
		
		if ($_FILES ['file'] ['error'] > 0) {
			echo 'Error: ' . $_FILES ['file'] ['error'] . '<br/>';
		} 
		else {			
			move_uploaded_file($_FILES['file']['tmp_name'], $file_dest);
			echo 'Stored in: ' . $file_dest . '<br/>';
		}
	}
	else {
		echo 'Exceeded the max file size limit' . '<br/>';
	}
} 
else {
	echo 'Invalid file' . '<br/>';
}