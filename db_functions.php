<?php

function opendatabase($dbpath)
{
	$dbhandle = new SQLite3($dbpath);
	return $dbhandle;
}

function closedatabase($dbhandle)
{
	$dbhandle->close();
}

function sqlite_escapeString($dbhandle, $string)
{
	$ret_string = $dbhandle->escapeString($string);
	return $ret_string;
}

function executequery($dbhandle, $query) 
{ 
    $array['dbhandle'] = $dbhandle; 
    $array['query'] = $query; 
    
	$result = $dbhandle->query($query); 
    return $result; 
} 

function GetLastInsertRowID($dbhandle) 
{ 
    $result = $dbhandle->lastInsertRowID(); 
    return $result; 
} 

function getnextrow(&$result) 
{ 
    #Get Columns 
    $i = 0; 
    
	while($result->columnName($i)) 
    { 
        $columns[ ] = $result->columnName($i); 
        $i++; 
    } 
    
    $resx = $result->fetchArray(SQLITE3_ASSOC); 
    return $resx; 
} 

function generateRandomString($length = 6)
{
	$characters = '0123456789';
	$charactersLength = strlen($characters);
	$randomString = '';

	for($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}

	return $randomString;
}

?>
