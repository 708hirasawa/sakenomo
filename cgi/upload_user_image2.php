<?php

require_once("../db_functions.php");

if(!$db = opendatabase("../sake.db"))
{
	$return = "データベース接続エラー";
	echo '["' .$return .'", "upload failed"]';
	return 0;
}

ini_set('memory_limit', '64M');

$in_time = time();
$username = $_POST['username'];
$destWidth = (isset($_POST['max_width']) && $_POST['max_width'] != 'undefined') ?	$_POST['max_width'] : 200;
$destHeight = (isset($_POST['max_height']) && $_POST['max_height'] != 'undefined') ? $_POST['max_height'] : 200;

$fileName = $in_time.$_FILES["file1"]["name"]; // The file name
$fileTmpLoc = $_FILES["file1"]["tmp_name"];	// File in the PHP tmp folder
$fileType = $_FILES["file1"]["type"]; // The type of file it is
$fileSize = $_FILES["file1"]["size"]; // File size in bytes
$fileErrorMsg = $_FILES["file1"]["error"]; // 0 for false... and 1 for true

if(!$fileTmpLoc) { // if file not chosen
    echo "ERROR: Please browse for a file before clicking the upload button.";
    exit();
}

if(move_uploaded_file($fileTmpLoc, "../images/profile/$fileName"))
{
    $path = "../images/profile/$fileName";
    $newpath = "../images/profile/resized_$fileName";
    $newfileName = "resized_" .$fileName;

    list($width, $height, $type) = getimagesize($path);

    // resize image 
	if($width < $destWidth && $height < $destHeight) { // image is smaller
		$destWidth = $width;
		$destHeight = $height;
	}
	else if($width > $height) {
        $destHeight = $height * ($destWidth / $width);
	}
	else if($width < $height) {
        $destWidth = $width * ($destHeight / $height);
	}

	$exif = exif_read_data($path);
	$orientation = $exif['Orientation'];

    $source = imagecreatefromjpeg($path);
    $dest = imagecreatetruecolor($destWidth, $destHeight);
    $ret = imagecopyresampled($dest, $source, 0, 0, 0, 0, $destWidth, $destHeight, $width, $height);

	switch($orientation)
    {
    case 2: // horizontal flip
        break;
    case 3: // 180 rotate left
		$dest = imagerotate($dest, 180, 0);
		break;
    case 4: // vertical flip
		break;
    case 5: // vertical flip + 90 rotate right
        $dest = imagerotate($dest, -90, 0);
        break;
    case 6: // 90 rotate right
        $dest = imagerotate($dest, -90, 0);
        break;
    case 7: // horizontal flip + 90 rotate right
		$dest = imagerotate($dest, -90, 0);
		break;
    case 8: // 90 rotate left
		$dest = imagerotate($dest, 90, 0);
	}

    imagejpeg($dest, $newpath);
    imagedestroy($source);
    imagedestroy($dest);

	/////////////////////////////////////////////////////////////////
	// delete temporary image
	/////////////////////////////////////////////////////////////////
	$sql = "SELECT * FROM PROFILE_IMAGE WHERE contributor = '$username' AND STATUS = 2";
	$res = executequery($db, $sql);

	if(!$res)   
	{
		$return = "failed ".$sql;
		echo '["' .$return .'", "upload failed"]';
		return 0;
	}

	/*
	while($row = getnextrow($res)) 
	{
		$imagefile = $row["filename"];
		$path = "../images/profile/" .$imagefile;

		if(file_exists($path)) {

			$ret = unlink($path);	

			if($ret == FALSE) {
				$return = "failed unlink1";
			}
		}
		else {
			$return = "file_does_not_exit";
		}
	}
	*/

	$sql = "DELETE FROM PROFILE_IMAGE WHERE contributor = '$username' AND STATUS = 2";
	$res = executequery($db, $sql);

	if(!$res)   
	{
		$return = "failed ".$sql;
		echo '["' .$return .'", "upload failed"]';
		return 0;

	}

	/////////////////////////////////////////////////////////////////
	// insert new image
	/////////////////////////////////////////////////////////////////

	$status = 2;
	$sql = "INSERT INTO PROFILE_IMAGE(contributor, filename, added_date, status) VALUES ('$username', '$newfileName', '$in_time', '$status')";
	$ret = executequery($db, $sql);
    
	if(!$ret) {
		$return = '登録できません、このイメージはすでに登録されています、username:' .$username .' filename:' .$fileName;
		echo '["' .$return .'", "upload failed"]';
		return 0;
	}

    echo "[\"" .$newfileName  ."\", \"upload is complete\", \"" .$username ."\"]";
} 
else {
    echo "move_uploaded_file function failed";
}

?>
