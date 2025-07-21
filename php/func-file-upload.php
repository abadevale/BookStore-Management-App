<?php

# function to help upload files into the database

function upload_file($files, $allowed_exs, $path){

	# getting the data and store them in var
	$file_name = $files['name'];
	$tmp_name = $files['tmp_name'];
	$error = $files['error'];

	# checking if there is no error occurred while uploading
	if ($error === 0) {
		# code...
		#getting the file extension store it in var
		$file_ex = pathinfo($file_name, PATHINFO_EXTENSION);
		
		#converting the file into lower case and store it in var
		$file_ex_lc = strtolower($file_ex);
		
		#check if the file extension exist in $allowed_exs array
		if (in_array($file_ex_lc, $allowed_exs)) {
			# code...
			
			# renaming the file with random strings
		    $new_file_name = uniqid("",true).'.'.$file_ex_lc;
		    
		    # assigning upload path
		    $file_upload_path = '../uploads/'.$path.'/'.$new_file_name;

		    #moving uploaded file to the root directory path folder
		    move_uploaded_file($tmp_name,$file_upload_path);
		    #creating a success message
		    $sm['status'] = 'Success';
	        $sm['data'] = $new_file_name;

	        return $sm;

		}else{


	    $em['status'] = 'success';
	    $em['data'] = $new_file_name;
		}

	}else{
		# creating an error message with associatuve array with named keys status and data
	$em['status'] = 'error';
	$em['data'] = "Error Occurred while uploading the file!";

	# returning the em array
	return $em;
	}
}