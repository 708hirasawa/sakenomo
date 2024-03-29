﻿<?php

require_once("../db_functions.php");
$username = $_POST['username'];
$nickname = $_POST['nickname'];
$email = $_POST['email'];

if(!$db = opendatabase("../sake.db"))
{
   die("データベース接続エラー .<br />");
}

$item = "";

if((isset($_POST['nickname']) && $_POST['nickname'] != 'undefined') && $_POST['nickname'] != "")
{
    $nickname = str_replace("%", "\%", sqlite3::escapeString($_POST['nickname']));
    $item = "nickname='$nickname'";
}

if(isset($_POST['fname']) && $_POST['fname'] != 'undefined')
{
    $fname = str_replace("%", "\%", sqlite3::escapeString($_POST['fname']));
    
	if($item == "")
	{
        $item = "fname='$fname'";
    }
	else
	{
        $item .= ", fname='$fname'";
    }
}

if(isset($_POST['lname']) && $_POST['lname'] != 'undefined')
{
    $lname = str_replace("%", "\%", sqlite3::escapeString($_POST['lname']));
    
	if($item == "")
	{
        $item = "lname='$lname'";
    }
	else
	{
        $item .= ", lname='$lname'";
    }
}

if(isset($_POST['minit']) && $_POST['minit'] != 'undefined')
{
    $minit = str_replace("%", "\%", sqlite3::escapeString($_POST['minit']));
    
	if($item == "")
	{
        $item = "minit='$minit'";
    }
	else
	{
        $item .= ", minit='$minit'";
    }
}

if(isset($_POST['password']) && $_POST['password'] != 'undefined')
{
    $password = str_replace("%", "\%", sqlite3::escapeString($_POST['password']));
    
	if($item == "")
	{
        $item = "password='$password'";
    }
	else
	{
        $item .= ", password='$password'";
    }
}

if(isset($_POST['sex']) && $_POST['sex'] != 'undefined')
{
    $sex = str_replace("%", "\%", sqlite3::escapeString($_POST['sex']));
    
	if($item == "")
	{
        $item = "sex='$sex'";
    }
	else
	{
        $item .= ", sex='$sex'";
    }
}


if((isset($_POST['birthday_year']) && $_POST['birthday_year'] != 'undefined') && 
   (isset($_POST['birthday_month']) && $_POST['birthday_month'] != 'undefined') &&
   (isset($_POST['birthday_day']) && $_POST['birthday_day'] != 'undefined')) 
{

	// 全部入力しておかないといけない

	$birthday_year = $_POST['birthday_year'];
	$birthday_month = $_POST['birthday_month'];
	$birthday_day = $_POST['birthday_day'];

    $bdate = $birthday_month .'-' .$birthday_day .'-' .$birthday_year;
    
	if($item == "")
	{
        $item = "bdate='$bdate'";
    }
	else
	{
        $item .= ", bdate='$bdate'";
    }
}

if(isset($_POST['email']) && $_POST['email'] != 'undefined')
{
    $email = str_replace("%", "\%", sqlite3::escapeString($_POST['email']));
    
	if($item == "")
	{
        $item = "email='$email'";
    }
	else
	{
        $item .= ", email='$email'";
    }
}

if(isset($_POST['phone']) && $_POST['phone'] != 'undefined')
{
    $phone = str_replace("%", "\%", sqlite3::escapeString($_POST['phone']));
    
	if($item == "")
	{
        $item = "phone='$phone'";
    }
	else
	{
        $item .= ", phone='$phone'";
    }
}

if(isset($_POST['country']) && $_POST['country'] != 'undefined')
{
    $country = str_replace("%", "\%", sqlite3::escapeString($_POST['country']));
    
	if($item == "")
	{
        $item = "country='$country'";
    }
	else
	{
        $item .= ", country='$country'";
    }
}

if(isset($_POST['pref']) && $_POST['pref'] != 'undefined')
{
    $pref = str_replace("%", "\%", sqlite3::escapeString($_POST['pref']));
    
	if($item == "")
	{
        $item = "pref='$pref'";
    }
	else
	{
        $item .= ", pref='$pref'";
    }
}

if(isset($_POST['address']) && $_POST['address'] != 'undefined')
{
    $address = str_replace("%", "\%", sqlite3::escapeString($_POST['address']));
    
	if($item == "")
	{
        $item = "address='$address'";
    }
	else
	{
        $item .= ", address='$address'";
    }
}

if(isset($_POST['address_read']) && $_POST['address_read'] != 'undefined')
{
    $address_read = str_replace("%", "\%", sqlite3::escapeString($_POST['address_read']));
    
	if($item == "")
	{
        $item = "address_read='$address_read'";
    }
	else
	{
        $item .= ", address_read='$address_read'";
    }
}

if(isset($_POST['postal_code']) && $_POST['postal_code'] != 'undefined')
{
    $postal_code = str_replace("%", "\%", sqlite3::escapeString($_POST['postal_code']));
    
	if($item == "")
	{
        $item = "postal_code='$postal_code'";
    }
	else
	{
        $item .= ", postal_code='$postal_code'";
    }
}

if(isset($_POST['user_introduction']) && $_POST['user_introduction'] != 'undefined')
{
    $user_introduction = str_replace("%", "\%", sqlite3::escapeString($_POST['user_introduction']));
    
	if($item == "")
	{
        $item = "introduction='$user_introduction'";
    }
	else
	{
        $item .= ", introduction='$user_introduction'";
    }
}

/**************
 * 利酒資格
 *************/

if(isset($_POST['certification']) && $_POST['certification'] != 'undefined')
{
	$certification = "";

	if(!empty($_POST['certification']))
	{
		foreach($_POST['certification'] as $selected)
		{
			$certification = ($certification == "") ? $selected : ($certification ."," .$selected);	
		}	

		if($item == "")
		{
			$item = "certification='$certification'";
		}
		else
		{
			$item .= ", certification='$certification'";
		}
	}
	else
	{
		if($item == "")
		{
			$item = "certification='$certification'";
		}
		else
		{
			$item .= ", certification='$certification'";
		}
	}
}

if(isset($_POST['age_disclose_select']) && $_POST['age_disclose_select'] != 'undefined')
{
    $age_disclose = str_replace("%", "\%", sqlite3::escapeString($_POST['age_disclose_select']));
    
	if($item == "")
	{
        $item = "age_disclose='$age_disclose'";
    }
	else
	{
        $item .= ", age_disclose='$age_disclose'";
    }
}

if(isset($_POST['sex_disclose_select']) && $_POST['sex_disclose_select'] != 'undefined')
{
    $sex_disclose = str_replace("%", "\%", sqlite3::escapeString($_POST['sex_disclose_select']));
    
	if($item == "")
	{
        $item = "sex_disclose='$sex_disclose'";
    }
	else
	{
        $item .= ", sex_disclose='$sex_disclose'";
    }
}

if(isset($_POST['address_disclose_select']) && $_POST['address_disclose_select'] != 'undefined')
{
    $address_disclose = str_replace("%", "\%", sqlite3::escapeString($_POST['address_disclose_select']));
    
	if($item == "")
	{
        $item = "address_disclose='$address_disclose'";
    }
	else
	{
        $item .= ", address_disclose='$address_disclose'";
    }
}

if(isset($_POST['certification_disclose_select']) && $_POST['certification_disclose_select'] != 'undefined')
{
    $certification_disclose = str_replace("%", "\%", sqlite3::escapeString($_POST['certification_disclose_select']));
    
	if($item == "")
	{
        $item = "certification_disclose='$certification_disclose'";
    }
	else
	{
        $item .= ", certification_disclose='$certification_disclose'";
    }
}

if(isset($_POST['delete_image']) && $_POST['delete_image'] != 'undefined')
{
    if($_POST['delete_image'] == 1) 
	{
		$sql = "DELETE FROM PROFILE_IMAGE WHERE contributor = '$username'";
		$res = executequery($db, $sql);

		if(!$res)   
		{
			$return = "failed ".$sql;
			header("Content-type: application/xml");
			echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
			echo '<xml>'."\n";
			echo '<str>'.$return.'</str>'."\n";
			echo '</xml>'."\n";
		}

		/*
		if(file_exists($path)) {
			$ret = unlink($path);	

			if($ret == FALSE)
				$return = "failed unlink1";
		}
		else {
			$return = "file_does_not_exit";
		}
		*/

		$currdir = dirname(dirname(__FILE__));
		$basedir = '/' .substr(strrchr($currdir, "/"), 1) .'/';
		$basedir = (strcmp($basedir, '/public_html/') == 0) ? '/' : $basedir;

		$path = "images/icons/noimage_user30.svg";
		setcookie("user_profile_image", $path, time() + (10 * 365 * 24 * 60 * 60), $basedir);
	}
}

//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
$sql = "SELECT * FROM PROFILE_IMAGE WHERE contributor = '$username' AND STATUS = 2";
$res = executequery($db, $sql);

if($res) 
{   
	$row = getnextrow($res); 

	if($row) 
	{
		////////////////////////////////
		// set the new file
		$path = "../images/icons/noimage_user30.svg";
		$imagefile = null;

		$currdir = dirname(dirname(__FILE__));
		$basedir = '/' .substr(strrchr($currdir, "/"), 1) .'/';
		$basedir = (strcmp($basedir, '/public_html/') == 0) ? '/' : $basedir;

		$imagefile = $row["filename"];
		$path = "../images/profile/" .$imagefile;
		setcookie("user_profile_image", $path, time() + (10 * 365 * 24 * 60 * 60), $basedir);
		
		////////////////////////////////
		// delete old file
		$sql = "SELECT * FROM PROFILE_IMAGE WHERE contributor = '$username' AND STATUS = 1";
		$res = executequery($db, $sql);
		$rd = getnextrow($res); 

		if($rd) 
		{
			$imagefile = $rd["filename"];
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

		///////////////////////////////////////////////////////////////////////////////////////////////////////
		$sql = "DELETE FROM PROFILE_IMAGE WHERE contributor = '$username' AND STATUS = 1";
		$res = executequery($db, $sql);

		if(!$res)   
		{
			$return = "failed ".$sql;
			header("Content-type: application/xml");
			echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
			echo '<xml>'."\n";
			echo '<str>'.$return.'</str>'."\n";
			echo '</xml>'."\n";
			return;
		}

		///////////////////////////////////////////////////////////////////////////////////////////////////////
		$sql = "UPDATE PROFILE_IMAGE SET STATUS = 1 WHERE contributor = '$username' AND STATUS = 2";
		$res = executequery($db, $sql);

		if(!$res)   
		{
			$return = "failed ".$sql;
			header("Content-type: application/xml");
			echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
			echo '<xml>'."\n";
			echo '<str>'.$return.'</str>'."\n";
			echo '</xml>'."\n";
			return;
		}
	}
}

$sql = "UPDATE USERS_J SET ".$item." WHERE username = '$username'";

$res = executequery($db, $sql);

if(!$res)   
{
	$return = "failed ".$sql;
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo '<str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
}
else
{
	$return = "success";

	$currdir = dirname(dirname(__FILE__));
	$basedir = '/' .substr(strrchr($currdir, "/"), 1) .'/';
	$basedir = (strcmp($basedir, '/public_html/') == 0) ? '/' : $basedir;

	setcookie("login_cookie", $username, time() + (10 * 365 * 24 * 60 * 60), $basedir);
	setcookie("username", $username, time() + (10 * 365 * 24 * 60 * 60), $basedir);
	setcookie("nickname", $nickname, time() + (10 * 365 * 24 * 60 * 60), $basedir);
	setcookie("email", $email, time() + (10 * 365 * 24 * 60 * 60), $basedir);
	setcookie("password_cookie", $password, time() + (10 * 365 * 24 * 60 * 60), $basedir);
	//setcookie("usertype_cookie", $usertype, time() + (10 * 365 * 24 * 60 * 60), $basedir);

	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";

	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo ' <sql>'.$sql.'</sql>'."\n";
	echo ' <username>'.$username.'</username>'."\n";
	echo ' <fname>'.$fname.'</fname>'."\n";
	echo ' <lname>'.$lname.'</lname>'."\n";
	echo ' <minit>'.$minit.'</minit>'."\n";
	echo ' <password>'.$password.'</password>'."\n";
	echo ' <sex>'.$sex.'</sex>'."\n";
	echo ' <bdate>'.$bdate.'</bdate>'."\n";
	echo ' <email>'.$email.'</email>'."\n";
	echo ' <phone>'.$phone.'</phone>'."\n";
	echo ' <pref>'.$pref.'</pref>'."\n";
	echo ' <address>'.$address.'</address>'."\n";
	echo ' <address_read>'.$address_read.'</address_read>'."\n";
	echo ' <postal_code>'.$postal_code.'</postal_code>'."\n";
	echo '</xml>'."\n";
}
?>

