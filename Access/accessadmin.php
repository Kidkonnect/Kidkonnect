<?php
//isset($_COOKIE['cookie'])) {
if (isset($_SESSION['MM_AccessLevel']))
{
	//echo $_SESSION['MM_AccessLevel'];
  if ($_SESSION['MM_AccessLevel'] != "admin")
  {
	echo 'You do not have the proper access level to view this page.';
	exit;
  }
}
else
{
  //echo $_SESSION['MM_AccessLevel'];
  echo 'Access Level is not set. You do not have the proper access level to view this page.';
  echo '<meta HTTP-EQUIV="REFRESH" content="0; url=http://192.168.12.158/Admin/login.php">';
  exit;

}
?>
