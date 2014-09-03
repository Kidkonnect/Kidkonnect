<?php
ob_start(); //lets you set the cookie

	$hostname_dbs = "localhost";
	$username_dbs = "root";
	$password_dbs = "kidserver1";
	$database_dbs = "sunnybrook";
	$dbs = mysql_connect($hostname_dbs, $username_dbs, $password_dbs) or die ('I cannot connect to the database:'. mysql_eror());
	//$dbh = mysql_connect($hostname_dbh, $username_dbh, $password_dbh) or trigger_error(mysql_error(),E_USER_ERROR); 
	session_start();
	//mysql_select_db($database_dbs, $dbs);
	//$query_Sort = "SELECT * FROM child ORDER BY LastName ASC";
	//$Sort = mysql_query($query_Sort, $dbs) or die(mysql_error());

// Turn off all error reporting
//error_reporting(1);

//-------------------LOG OUT--------------------//
	// ** Logout the current user. **
	$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
	if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
	  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
	}
	if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
	  //to fully log out a visitor we need to clear the session varialbles
	  session_unregister('MM_Username');
	  session_unregister('MM_AccessLevel');
		
	  $logoutGoTo = "/index.php";
	  if ($logoutGoTo) {
		//if you pass in FALSE as the second argument you can force multiple headers of the same type.
		header("Location: $logoutGoTo", false);
		exit;
	  }
	}

//--------------------SET SESSIONS-----------------//
	if (isset($_POST['username'])&&($_POST['username']!='')) {
	  //echo 'username is = '. $_POST['username'].' blah';
	  $loginUsername=$_POST['username'];
	  $password=$_POST['password'];
	  $MM_fldUserAuthorization = "access_level";
	  $MM_redirectLoginSuccess = "/loggedon.php";
	  $MM_redirectLoginFailed = "/register.php";
	  $MM_redirecttoReferrer = false;
	  mysql_select_db($database_dbs, $dbs);	
	  $LoginRS__query=sprintf("SELECT UserName, Password, AccessLevel, FirstName, LastName FROM admin WHERE UserName='%s' AND Password='%s'",
	  get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
	  $LoginRS = mysql_query($LoginRS__query, $dbs) or die(mysql_error());
	  $loginFoundUser = mysql_num_rows($LoginRS);
	  //session_start();  //tell php to start the session.
	  if ($loginFoundUser) { 
		// set the cookies
		$loginStrGroup  = mysql_result($LoginRS,0,'AccessLevel');
		$loginFirstName = mysql_result($LoginRS,0,'UserName');
		//setcookie("MM_Username", $loginUsername, 122);
		//setcookie("MM_AccessLevel", $loginStrGroup, 122);
		//testing
		//echo $loginUsername;//works!
		//echo $loginStrGroup;//works!
		
		//declare three session variables and assign them
		//$GLOBALS['MM_Username'] = $loginUsername;
		//$GLOBALS['MM_AccessLevel'] = $loginStrGroup;
		$_SESSION["MM_Username"] = $loginUsername;
		$_SESSION['MM_AccessLevel'] = $loginStrGroup;
		//register the session variables
		session_register("MM_Username");
		session_register("MM_AccessLevel");
		
	  }
	  else {echo '<meta HTTP-EQUIV="REFRESH" content="0; url=http://192.168.12.158/Admin/forgotpw.php">';}
	}
	else {
	  //echo 'username is not set';
	}

ob_end_flush(); //finish the ob_start


//--------------------Functions used-----------------//

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

// Generate a random character string
function rand_str($length = 3, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    // Length of character list
    $chars_length = (strlen($chars) - 1);

    // Start our string
    $string = $chars{rand(0, $chars_length)};
   
    // Generate random string
    for ($i = 1; $i < $length; $i = strlen($string))
    {
        // Grab a random character from our list
        $r = $chars{rand(0, $chars_length)};
       
        // Make sure the same two characters don't appear next to each other
        if ($r != $string{$i - 1}) $string .=  $r;
    }
   
    // Return the string
    return $string;
}

//global variables
//max image width
$max_width = 500;
?>