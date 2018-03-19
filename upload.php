<?php
header('Content-Type: application/json');
 
 
if(isset($_FILES['file']['type'])){
 
	$validextensions = array('jpeg', 'jpg', 'png');
	$temporary = explode('.', $_FILES['file']['name']);
	$file_extension = strtolower(end($temporary));
	
	if(($_FILES['file']['size'] > 1000000)){
		$data = array(
					'error'	=> 'Max file size is 1Mb',
				);
				
		http_response_code(500);
		echo json_encode($data);
	}else {
			
		if (
	 
			(($_FILES['file']['type'] == 'image/png') || 
			($_FILES['file']['type'] == 'image/jpg') || 
			($_FILES['file']['type'] == 'image/jpeg'))
	 
			&& 
			
			in_array($file_extension, $validextensions)){
	 
			if ($_FILES['file']['error'] > 0){
	 
				$data = array(
					'error' => $_FILES['file']['error']
					);
	 
				echo json_encode($data);
	 
			}else{
				
				if (file_exists('file/' . $_FILES['file']['name'])) {
	 
					$data = array(
						'error' => $_FILES['file']['name'] . ' already exists' 
					);
					
					http_response_code(500);
					echo json_encode($data);
				
				}else{
					
					$filename = $_FILES['file']['name'];
					$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
					$targetPath = 'file/'.$filename; // Target path where file is to be stored
					move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
					
					$data = array(
						'message'	=> 'Image Uploaded Successfully',
						'file' 		=> $targetPath
					);
				
					echo json_encode($data);
				}
			}
	 
		} else{
	 
			$data = array(
				'error'	=> 'Invalid file Type',
			);
			http_response_code(500);
		
			echo json_encode($data);
	 
		}
	}
}
// $ds = "/";

// 	$storeFolder = 'file';

// 	if(!empty($_FILES)) {
// 		$tempFile = $_FILES['file']['tmp_name'];
// 		$targetPath = dirname(__FILE__) . $ds . $storeFolder . $ds;
// 		$targetFile = $targetPath . $_FILES['file']['name'];
// 		move_uploaded_file($tempFile, $targetFile);
// 	}
?>