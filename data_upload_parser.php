<?php

require_once("db_functions.php");

if(!$db = opendatabase("sake.db"))
{
   die("データベース接続エラー .<br />");
}

//ini_set('memory_limit', '64M');
ini_set('memory_limit', '128M');

$in_time = time();
$id = $_POST['id'];
$title = $_POST['title'];
$data_type = $_POST['data_type'];
$tablename = $data_type ."_image";

$fileName = $in_time.$_FILES["file1"]["name"];  // The file name
$fileName = str_replace(" ", "_", $fileName);

$fileTmpLoc = $_FILES["file1"]["tmp_name"];		// File in the PHP tmp folder
$fileType = $_FILES["file1"]["type"];			// The type of file it is
$fileSize = $_FILES["file1"]["size"];			// File size in bytes
$fileErrorMsg = $_FILES["file1"]["error"];		// 0 for false... and 1 for true
$path = "images/original/$fileName";

if(!$fileTmpLoc) { // if file not chosen
    echo "ERROR: Please browse for a file before clicking the upload button.";
    exit();
}

if(move_uploaded_file($fileTmpLoc, $path))
{
	$newpath  = "images/photo/resized_$fileName";
	$thumbpath = "images/photo/thumb/resized_$fileName";
	$newfileName = "resized_" .$fileName;

	if($data_type == "sakagura")
	{	
		$newpath  = "images/sakagura/resized_$fileName";
		$thumbpath = "images/sakagura/thumb/resized_$fileName";
		$newfileName = "resized_" .$fileName;
	}

    list($width, $height, $type) = getimagesize($path);
   
    if($width > 640 && $width > $height)
    {
        /**********************************************************
         * resize image 
         **********************************************************/
        $newwidth = 640;
        $newheight = $height * ($newwidth / $width);

        $source = imagecreatefromjpeg($path);
        $dest = imagecreatetruecolor($newwidth, $newheight);

		$exif = exif_read_data($path);
		$orientation = $exif['Orientation'];

        $ret = imagecopyresampled($dest, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

		switch($orientation)
        {
        case 2: // horizontal flip
			//$this->ImageFlip($dimg);
            break;

        case 3: // 180 rotate left
			$dest = imagerotate($dest, 180, -1);
			break;

        case 4: // vertical flip
			//$this->ImageFlip($dimg);
			break;

        case 5: // vertical flip + 90 rotate right
            //$this->ImageFlip($dest);
            $dest = imagerotate($dest, -90, -1);
            break;

        case 6: // 90 rotate right
            $dest = imagerotate($dest, -90, -1);
            break;

        case 7: // horizontal flip + 90 rotate right
			//$this->ImageFlip($dest);
			$dest = imagerotate($dest, -90, -1);
			break;

        case 8: // 90 rotate left
			$dest = imagerotate($dest, 90, -1);
			break;
		}
 
        imagejpeg($dest, $newpath);
        
        imagedestroy($dest);
        imagedestroy($source);

        /**********************************************************
         * thumb image 
         **********************************************************/
        $newwidth = 200;
        $newheight = $height * ($newwidth / $width);
        
        $source = imagecreatefromjpeg($path);
        $dest = imagecreatetruecolor($newwidth, $newheight);
        $ret = imagecopyresampled($dest, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

		switch($orientation)
        {
        case 2: // horizontal flip
			//$this->ImageFlip($dimg);
            break;

        case 3: // 180 rotate left
			$dest = imagerotate($dest, 180, -1);
			break;

        case 4: // vertical flip
			//$this->ImageFlip($dimg);
			break;

        case 5: // vertical flip + 90 rotate right
            //$this->ImageFlip($dest);
            $dest = imagerotate($dest, -90, -1);
            break;

        case 6: // 90 rotate right
            $dest = imagerotate($dest, -90, -1);
            break;

        case 7: // horizontal flip + 90 rotate right
			//$this->ImageFlip($dest);
			$dest = imagerotate($dest, -90, -1);
			break;

        case 8: // 90 rotate left
			$dest = imagerotate($dest, 90, -1);
			break;
		}

        imagejpeg($dest, $thumbpath);
        imagedestroy($dest);
        imagedestroy($source);

        /**********************************************************
         * add path to database 
         **********************************************************/
        $sql = "INSERT INTO " .$tablename ." VALUES('$id', '$newfileName')";

        executequery($db, $sql)
          or die("登録できませんでした。この酒蔵IDはすでに登録されています");

        echo "[\"" .$newfileName  ."\", \"upload is complete\", \"" .$id ."\", \"6.mp3\"]";
    }
    else if($height > 640 && $height > $width)
    {
        /**********************************************************
         * resize image 
         **********************************************************/
        $newheight = 640;
        $newwidth = $width * ($newheight / $height);

        $source = imagecreatefromjpeg($path);
        $dest = imagecreatetruecolor($newwidth, $newheight);
		$exif = exif_read_data($path);
		$orientation = $exif['Orientation'];
        $ret = imagecopyresampled($dest, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

		switch($orientation)
        {
        case 2: // horizontal flip
			//$this->ImageFlip($dimg);
            break;

        case 3: // 180 rotate left
			$dest = imagerotate($dest, 180, -1);
			break;

        case 4: // vertical flip
			//$this->ImageFlip($dimg);
			break;

        case 5: // vertical flip + 90 rotate right
            //$this->ImageFlip($dest);
            $dest = imagerotate($dest, -90, -1);
            break;

        case 6: // 90 rotate right
            $dest = imagerotate($dest, -90, -1);
            break;

        case 7: // horizontal flip + 90 rotate right
			//$this->ImageFlip($dest);
			$dest = imagerotate($dest, -90, -1);
			break;

        case 8: // 90 rotate left
			$dest = imagerotate($dest, 90, -1);
			break;
		}

        imagejpeg($dest, $newpath);
        imagedestroy($dest);
        imagedestroy($source);

        /**********************************************************
         * thumb image 
         **********************************************************/
        $newheight = 200;
        $newwidth = $width * ($newheight / $height);
        
        $source = imagecreatefromjpeg($path);
        $dest = imagecreatetruecolor($newwidth, $newheight);
        $ret = imagecopyresampled($dest, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

		switch($orientation)
        {
        case 2: // horizontal flip
			//$this->ImageFlip($dimg);
            break;

        case 3: // 180 rotate left
			$dest = imagerotate($dest, 180, -1);
			break;

        case 4: // vertical flip
			//$this->ImageFlip($dimg);
			break;

        case 5: // vertical flip + 90 rotate right
            //$this->ImageFlip($dest);
            $dest = imagerotate($dest, -90, -1);
            break;

        case 6: // 90 rotate right
            $dest = imagerotate($dest, -90, -1);
            break;

        case 7: // horizontal flip + 90 rotate right
			//$this->ImageFlip($dest);
			$dest = imagerotate($dest, -90, -1);
			break;

        case 8: // 90 rotate left
			$dest = imagerotate($dest, 90, -1);
			break;
		}

        imagejpeg($dest, $thumbpath);
        imagedestroy($dest);
        imagedestroy($source);

        /**********************************************************
         * add path to database 
         **********************************************************/
        $sql = "INSERT INTO " .$tablename ." VALUES('$id', '$newfileName')";

        executequery($db, $sql)
          or die("登録できませんでした。この酒蔵IDはすでに登録されています");

        echo "[\"" .$newfileName  ."\", \"upload is complete\", \"" .$id ."\", \"6.mp3\"]";
    }
    else
    {
        /**********************************************************
         * resize image 
         **********************************************************/
        $newheight = 640;
        $newwidth = 640;

        $source = imagecreatefromjpeg($path);
        $dest = imagecreatetruecolor($newwidth, $newheight);
		$exif = exif_read_data($path);
		$orientation = $exif['Orientation'];
        $ret = imagecopyresampled($dest, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

		switch($orientation)
        {
        case 2: // horizontal flip
			//$this->ImageFlip($dimg);
            break;

        case 3: // 180 rotate left
			$dest = imagerotate($dest, 180, -1);
			break;

        case 4: // vertical flip
			//$this->ImageFlip($dimg);
			break;

        case 5: // vertical flip + 90 rotate right
            //$this->ImageFlip($dest);
            $dest = imagerotate($dest, -90, -1);
            break;

        case 6: // 90 rotate right
            $dest = imagerotate($dest, -90, -1);
            break;

        case 7: // horizontal flip + 90 rotate right
			//$this->ImageFlip($dest);
			$dest = imagerotate($dest, -90, -1);
			break;

        case 8: // 90 rotate left
			$dest = imagerotate($dest, 90, -1);
			break;
		}
        
        imagejpeg($dest, $newpath);
        imagedestroy($dest);
        imagedestroy($source);

        /**********************************************************
         * thumb image 
         **********************************************************/
        $newheight = 200;
        $newwidth = $width * ($newheight / $height);
        
        $source = imagecreatefromjpeg($path);
        $dest = imagecreatetruecolor($newwidth, $newheight);
        $ret = imagecopyresampled($dest, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

		switch($orientation)
        {
        case 2: // horizontal flip
			//$this->ImageFlip($dimg);
            break;

        case 3: // 180 rotate left
			$dest = imagerotate($dest, 180, -1);
			break;

        case 4: // vertical flip
			//$this->ImageFlip($dimg);
			break;

        case 5: // vertical flip + 90 rotate right
            //$this->ImageFlip($dest);
            $dest = imagerotate($dest, -90, -1);
            break;

        case 6: // 90 rotate right
            $dest = imagerotate($dest, -90, -1);
            break;

        case 7: // horizontal flip + 90 rotate right
			//$this->ImageFlip($dest);
			$dest = imagerotate($dest, -90, -1);
			break;

        case 8: // 90 rotate left
			$dest = imagerotate($dest, 90, -1);
			break;
		}

        imagejpeg($dest, $thumbpath);
        imagedestroy($dest);
        imagedestroy($source);

        /**********************************************************
         * add path to database 
         **********************************************************/
        $sql = "INSERT INTO " .$tablename ." VALUES('$id', '$newfileName')";

        executequery($db, $sql)
          or die("登録できませんでした。この酒蔵IDはすでに登録されています");

        echo "[\"" .$newfileName  ."\", \"upload is complete\", \"" .$id ."\", \"6.mp3\"]";
    }
} 
else 
{
    echo "move_uploaded_file function failed";
}

?>
