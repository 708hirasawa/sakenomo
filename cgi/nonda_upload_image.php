<?php

define('MUTEX_KEY', 123456); # the key to access you unique semaphore

require_once("../db_functions.php");

//ini_set('memory_limit', '64M');
//ini_set('memory_limit', '128M');
//ini_set('memory_limit', '1024M');
ini_set('memory_limit', '256M');
//ini_set('memory_limit', '512M');


$id = $_POST['id'];
$tablename = $_POST['tablename'];
$contributor = $_POST['contributor'];
$desc = $_POST['desc'];
$status = $_POST['status'];
$prefix = $_POST['prefix'];

$destWidth = (isset($_POST['max_width']) && $_POST['max_width'] != 'undefined') ?	$_POST['max_width'] : 640;
$destHeight = (isset($_POST['max_height']) && $_POST['max_height'] != 'undefined') ? $_POST['max_height'] : 640;
$thumbWidth = (isset($_POST['thumb_width']) && $_POST['thumb_width'] != 'undefined') ? $_POST['thumb_width'] : 200;
$thumbHeight = (isset($_POST['thumb_height']) && $_POST['thumb_height'] != 'undefined') ? $_POST['thumb_height'] : 200;
$in_time = time();

$fileName = $prefix.$_FILES["file1"]["name"];  // The file name
$fileTmpLoc = $_FILES["file1"]["tmp_name"];		// File in the PHP tmp folder
$fileType = $_FILES["file1"]["type"];			// The type of file it is
$fileSize = $_FILES["file1"]["size"];			// File size in bytes
$fileErrorMsg = $_FILES["file1"]["error"];		// 0 for false... and 1 for trueetur
$path = "../images/original/$fileName";

if(!$fileTmpLoc) { // if file not chosen
	$return = "Please browse for a file before clicking the upload button";
	echo '["' .$return .'", "upload failed"]';
	return 0;
}

if(move_uploaded_file($fileTmpLoc, $path)) {
	$newpath  = "../images/photo/$fileName";
	$thumbpath = "../images/photo/thumb/$fileName";
    list($width, $height, $type) = getimagesize($path);
	$ratio_orig = $width / $height;

    ////////////////////////////////////////////////////////////
    // resize image
    ////////////////////////////////////////////////////////////

	if($ratio_orig < 1) {
	   $destWidth = $destHeight * $ratio_orig;
	   $thumbWidth = $thumbHeight * $ratio_orig;
	} else {
	   $destHeight = $destWidth / $ratio_orig;
	   $thumbHeight = $thumbWidth / $ratio_orig;
	}

	$image_type = exif_imagetype($path);

	//////////////////////////////////////////////////////
	//////////////////////////////////////////////////////
	//////////////////////////////////////////////////////
	if($image_type == IMAGETYPE_JPEG) {

		$exif = exif_read_data($path);
 		$source = imagecreatefromjpeg($path);
		$dest = imagecreatetruecolor($destWidth, $destHeight);
		$ret = imagecopyresampled($dest, $source, 0, 0, 0, 0, $destWidth, $destHeight, $width, $height);
		$dest_thumb = imagecreatetruecolor($thumbWidth, $thumbHeight);
		$ret = imagecopyresampled($dest_thumb, $dest, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $destWidth, $destHeight);
		$orientation = $exif['Orientation'];

		switch($orientation)
		{
		case 2: // horizontal flip
			break;
		case 3: // 180 rotate left
			$dest = imagerotate($dest, 180, 0);
			$dest_thumb = imagerotate($dest_thumb, 180, 0);
			break;
		case 4: // vertical flip
			break;
		case 5: // vertical flip + 90 rotate right
			$dest = imagerotate($dest, -90, 0);
			$dest_thumb = imagerotate($dest_thumb, -90, 0);
			break;
		case 6: // 90 rotate right
			$dest = imagerotate($dest, -90, 0);
			$dest_thumb = imagerotate($dest_thumb, -90, 0);
			break;
		case 7: // horizontal flip + 90 rotate right
			$dest = imagerotate($dest, -90, 0);
			$dest_thumb = imagerotate($dest_thumb, -90, 0);
			break;
		case 8: // 90 rotate left
			$dest = imagerotate($dest, 90, 0);
			$dest_thumb = imagerotate($dest_thumb, 90, 0);
		}

		imagejpeg($dest, $newpath);
		imagejpeg($dest_thumb, $thumbpath);

		imagedestroy($dest_thumb);
		imagedestroy($dest);
		imagedestroy($source);
	} 
	else if($image_type == IMAGETYPE_PNG) { 

		$source = imagecreatefrompng($path);

		header('Content-Type: image/png');

		$dest = imagecreatetruecolor($destWidth, $destHeight);
		$ret = imagecopyresampled($dest, $source, 0, 0, 0, 0, $destWidth, $destHeight, $width, $height);

		$dest_thumb = imagecreatetruecolor($thumbWidth, $thumbHeight);
		$ret = imagecopyresampled($dest_thumb, $dest, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $destWidth, $destHeight);

		imagepng($dest, $newpath);
		imagepng($dest_thumb, $thumbpath);

		imagedestroy($dest_thumb);
		imagedestroy($dest);
		imagedestroy($source);
	}
	else if($image_type == IMAGETYPE_GIF) { 

		$source = imagecreatefromgif($path);

		header('Content-Type: image/gif');

		$dest = imagecreatetruecolor($destWidth, $destHeight);
		$ret = imagecopyresampled($dest, $source, 0, 0, 0, 0, $destWidth, $destHeight, $width, $height);

		$dest_thumb = imagecreatetruecolor($thumbWidth, $thumbHeight);
		$ret = imagecopyresampled($dest_thumb, $dest, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $destWidth, $destHeight);

		imagegif($dest, $newpath);
		imagegif($dest_thumb, $thumbpath);

		imagedestroy($dest_thumb);
		imagedestroy($dest);
		imagedestroy($source);
	}

    ///////////////////////////////////////////////////////////
    // add path to table sake_image
    ///////////////////////////////////////////////////////////

	sem_get( MUTEX_KEY, 1, 0666, 1 );
	sem_acquire( ($resource = sem_get( MUTEX_KEY )) );

	if(!$db = opendatabase("../sake.db")) {
		$return = "データベース接続エラー";
		echo '["' .$return .'", "upload failed"]';
		sem_release( $resource );
		return 0;
	}

	$sql = "SELECT * FROM TABLE_NONDA WHERE sake_id = '$id' AND contributor = '$contributor'";
	$res = executequery($db, $sql);

	if(!$res) {
		$return = "ドラフトは作成されていません".$sql;
		echo '["' .$return .'", \"upload failed"]';
		sem_release( $resource );
		return 0;
	}

	if(!($row = getnextrow($res))) {
		$return = "ドラフトは作成されていません:".$sql;
		echo '["' .$return .'", "upload failed"]';
		sem_release( $resource );
		return 0;
	}

	//////////////////////////////////////////////////////////
    $sql = "INSERT INTO " .$tablename ."(sake_id, contributor, filename, added_date, desc, status) VALUES('$id', '$contributor', '$fileName', '$in_time', '$desc', '$status')";
    $ret = executequery($db, $sql);

    if(!$ret) {
		$return = '登録できません、このイメージはすでに登録されています、ID:' .$id .' filename:' .$fileName;
		echo '["' .$return .'", "upload failed"]';
		sem_release( $resource );
		return 0;
	}

	sem_release( $resource );

    echo '["' .$fileName .'", "upload is complete", "' .$id .'", "' .$sql .'", "' .$width .'", "' .$height .'"]';
	return 1;
}
else
{
    echo '["move_uploaded_file function failed"]';
	return 1;
}
