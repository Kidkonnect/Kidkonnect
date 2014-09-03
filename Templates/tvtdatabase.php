<?php
	$hostname_tvt = "webstreet1.provalue.net";
		$database_tvt = "terraverdetech";
		$username_tvt = "ddavis";
		$password_tvt = "jeannieandme";
		$tvt = mysql_pconnect($hostname_tvt, $username_tvt, $password_tvt) or trigger_error(mysql_error(),E_USER_ERROR); 
		session_start();
?>
<?php
// Turn off all error reporting
error_reporting(0);
?>
<?php
	// ** Logout the current user. **
	$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
	if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
	  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
	}
	if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
	  //to fully log out a visitor we need to clear the session varialbles
	  session_unregister('MM_Username');
	  session_unregister('MM_UserGroup');
		
	  $logoutGoTo = "/index.php";
	  if ($logoutGoTo) {
		//if you pass in FALSE as the second argument you can force multiple headers of the same type.
		header("Location: $logoutGoTo", false);
		exit;
	  }
	}
?>
<?php
	if (isset($accesscheck)) {
	  $GLOBALS['PrevUrl'] = $accesscheck;
	  session_register('PrevUrl');
	}
	if (isset($_POST['txtemail'])) {
	  $loginUsername=$_POST['txtemail'];
	  $password=$_POST['txtpassword'];
	  $MM_fldUserAuthorization = "access_level";
	  $MM_redirectLoginSuccess = "/loggedon.php";
	  $MM_redirectLoginFailed = "/register.php";
	  $MM_redirecttoReferrer = false;
	  mysql_select_db($database_tvt, $tvt);	
	  $LoginRS__query=sprintf("SELECT email, password, access_level, first_name, company_name FROM userinfo WHERE email='%s' AND password='%s'",
	  get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
	  $LoginRS = mysql_query($LoginRS__query, $tvt) or die(mysql_error());
	  $loginFoundUser = mysql_num_rows($LoginRS);
	  if ($loginFoundUser) { 
		$loginStrGroup  = mysql_result($LoginRS,0,'access_level');
		$loginFirstName = mysql_result($LoginRS,0,'first_name');
		$loginCompanyName = mysql_result($LoginRS,0,'company_name');
		//declare three session variables and assign them
		$GLOBALS['MM_Username'] = $loginUsername;
		$GLOBALS['MM_UserGroup'] = $loginStrGroup;
		$GLOBALS['MM_FirstName'] = $loginFirstName;
		$GLOBALS['MM_CompanyName'] = $loginCompanyName;
		//register the session variables
		session_register("MM_Username");
		session_register("MM_UserGroup");
		session_register("MM_FirstName");
		session_register("MM_CompanyName");
		if (isset($_SESSION['PrevUrl']) && false) {
		  $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
		}
	  }
	  else {echo '<meta HTTP-EQUIV="REFRESH" content="0; url=http://www.terraverdetech.com/logon.php">';}
	}
?>