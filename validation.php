<?php
include '../dbincludes.php';

session_start();

$name = $_POST['user'];
$pass = $_POST['password'];

$_SESSION['username'] = $name;

$hashedPwd = Password_hash($pass,);

$s= "SELECT * FROM users WHERE username = '$name';";

$result = $conn->query($s);
	
	$Getrow = mysqli_fetch_array($result);

//if($result->num_rows>0) {
//	$_SESSION['username'] = $name;
//
//	error_reporting(E_ALL);
//
//	$myFile = $_SESSION['username']."-profile.php"; // or .html   
//	$fh = fopen($myFile, 'w'); // or die("error");  
//
//	$homepage = file_get_contents('home.php');
//
//	fwrite($fh, $homepage);
//	fclose($fh);
//
//	header('location:'.$_SESSION['username'] . '-profile.php');
//}else {
//	header('location:index.php');
//}

if($result->num_rows>0) {
	if (Password_verify($pass, $Getrow[3])) {
		$_SESSION['username'] = $name;
	
		$SID = "SELECT id FROM users WHERE username = '$name' && password = '$Getrow[3]';";
	
		$getID = $conn->query($SID);
		
		$row = mysqli_fetch_array($getID);

		$SType = "SELECT account_type FROM users WHERE username = '$name' && password = '$Getrow[3]';";
	
		$getType = $conn->query($SType);
		
		$row2 = mysqli_fetch_array($getType);
		
		error_reporting(E_ALL);
	
	
		// change the name below for the folder you want
		//$reg = "insert into gui(bg-color) values (5)";
		//$conn->query($reg);
	
		if ($row2[0] === 'Staff') {
			$dir = '../Users/Staffs/Staff-' . $_SESSION['username'];

			$file_to_write = $_SESSION['username']."-index.php";
			$content_to_write = file_get_contents('SiteFiles/Admin.php');

		}else {
			$dir = '../Users/Customers/Customer-' . $_SESSION['username'];

			$file_to_write = $_SESSION['username']."-index.php";
			$content_to_write = file_get_contents('SiteFiles/Shop.php');
		}
	
		if( is_dir($dir) === false )
		{
			mkdir($dir);
		}

		function custom_copy($src, $dst) { 
				  
		    // open the source directory
		    $dir2 = opendir($src); 
		  
		    // Make the destination directory if not exist
		    @mkdir($dst); 
		  
		    // Loop through the files in source directory
		    while( $file = readdir($dir2) ) { 
		  
		        if (( $file != '.' ) && ( $file != '..' )) { 
		            if ( is_dir($src . '/' . $file) ) 
		            { 
		  
		                // Recursively calling custom copy function
		                // for sub directory 
		                custom_copy($src . '/' . $file, $dst . '/' . $file); 
		  
		            } 
		            else { 
		                copy($src . '/' . $file, $dst . '/' . $file); 
		            } 
		        } 
		    } 
		  
		    closedir($dir2);
		}

		if ($row2[0] === 'Staff') {

			$src = "SiteFiles/Admin_Files/assets";
			$src2 = "SiteFiles/Admin_Files/css";
			$src3 = "SiteFiles/Admin_Files/html_php";
			$src4 = "SiteFiles/Admin_Files/js";
			  
			$dst = '../Users/Staffs/Staff-' . $_SESSION['username']. '/assets';
			$dst2 = '../Users/Staffs/Staff-' . $_SESSION['username']. '/css';
			$dst3 = '../Users/Staffs/Staff-' . $_SESSION['username']. '/html_php';
			$dst4 = '../Users/Staffs/Staff-' . $_SESSION['username']. '/js';
			  
			custom_copy($src, $dst);
			custom_copy($src2, $dst2);
			custom_copy($src3, $dst3);
			custom_copy($src4, $dst4);
			
		}else { 
				  
			$src = "SiteFiles/Shop_Files/css";
			$src2 = "SiteFiles/Shop_Files/html_php";
			$src3 = "SiteFiles/Shop_Files/img";
			$src4 = "SiteFiles/Shop_Files/js";
			$src5 = "SiteFiles/Shop_Files/scss";
			$src6 = "SiteFiles/Shop_Files/vendors";
			  
			$dst = '../Users/Customers/Customer-' . $_SESSION['username']. '/css';
			$dst2 = '../Users/Customers/Customer-' . $_SESSION['username']. '/html_php';
			$dst3 = '../Users/Customers/Customer-' . $_SESSION['username']. '/img';
			$dst4 = '../Users/Customers/Customer-' . $_SESSION['username']. '/js';
			$dst5 = '../Users/Customers/Customer-' . $_SESSION['username']. '/scss';
			$dst6 = '../Users/Customers/Customer-' . $_SESSION['username']. '/vendors';
			  
			custom_copy($src, $dst);
			custom_copy($src2, $dst2);
			custom_copy($src3, $dst3);
			custom_copy($src4, $dst4);
			custom_copy($src5, $dst5);
			custom_copy($src6, $dst6);
		}
	
		$file = fopen($dir . '/' . $file_to_write,"w");
	
		// a different way to write content into
		// fwrite($file,"Hello World.");
	
		fwrite($file, $content_to_write);
	
		// closes the file
		fclose($file);
	
		// this will show the created file from the created folder on screen
		//include $dir . '/' . $file_to_write;
		header('location:' . $dir . '/' . $file_to_write);
	}else {
		header('location:index.php');
	}
}else {
	header('location:index.php');
}

$conn->close();

?>