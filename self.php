<?php include ('/var/www/Templates/database.php'); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
 <!--sets page break for lables -->
<title>Sunnybrook Child Checkin </title>
<link rel="stylesheet" href="/scc.css" type="text/css" >
<!-- print.css are located in the status.php -->
<link rel="stylesheet" href="/printchildlabels.css" type="text/css" media="print">

<!-- Find what variable was set in the index.php file -->
<?php
$editFormAction = $_SERVER['PHP_SELF'];
$newstatus = "x";
//select the database 
  //echo 'the start';
  //echo $_POST["passedChildID"];
  //echo $_POST["MM_update"];

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  if((isset($_POST['Status'])) && ($_POST['Status'] == "Check Out")){
    $newstatus = "Checked Out";
  }
//echo $newstatus;
  $updateSQL = sprintf("UPDATE child SET Status=%s, StatusChange=%s WHERE ChildID=%s",
                       GetSQLValueString($newstatus, "text"),
		       GetSQLValueString(date('Y/m/d H:i:s'), "text"),
                       GetSQLValueString($_POST['passedChildID'], "text"));
  //echo $_POST["MM_update"];
  mysql_select_db($database_dbs, $dbs);	
  //mysql_select_db($database_tvt, $tvt);
  $Result1 = mysql_query($updateSQL, $dbs) or die(mysql_error());

  //print the parent sheet only when Checked out is set!!!
  if((isset($_POST['Status'])) && ($_POST['Status'] == "Check Out")){
  //echo Update the atandance;
//  $ChildID = $row_Sort['ChildID'];
//  $DayOfYear = date('z');
//  $query_Sort2 = "SELECT * FROM attendance WHERE ChildID=$ChildID AND DayOfYear=$DayOfYear ORDER BY ChildID ASC";
//  $Sort2 = mysql_query($query_Sort2, $dbs) or die(mysql_error());
//  $row_Sort2 = mysql_fetch_assoc($Sort2);

    $updateSQL = sprintf("UPDATE attendance SET OutTime=%s WHERE ChildID=%s AND Date=%s",
                       GetSQLValueString(date('Hi'), "text"),
                       GetSQLValueString($_POST['passedChildID'], "text"),
		       GetSQLValueString(date('m-d-Y'), "text"));

  //echo $_POST["MM_update"];
  mysql_select_db($database_dbs, $dbs);	
  //mysql_select_db($database_tvt, $tvt);
  $Result1 = mysql_query($updateSQL, $dbs) or die(mysql_error());
  //set print parent sheets
    //echo '<link rel="stylesheet" href="/printparent.css" type="text/css" media="print">';
    //echo '<SCRIPT language="JavaScript">window.print()</SCRIPT>';
    
  }

//required to refresh query from database
//echo '<meta HTTP-EQUIV="REFRESH" content="0; url=http://192.168.12.158/checkout.php">';

}
?>
</head>
<body>
<div id="web"><!--start web -->
<?php include ('/var/www/Templates/masterhead.php'); ?>
  <div id="content"> <!--start content -->
	  <div id="breadCrumb">
	  </div> 
		<h2 id="pageName">Child Check Out</h2>
		  <div class="feature">
		     <form action="checkout.php" METHOD="POST" name="form1">
			<input type="hidden" name="MM_update" value="form1">
			<table width="400" border="0" class="table">
			  <tr>
			    <td width="150" nowrap="true">Child's&nbsp;ID<br></td>
			    <td><input name="passedChildID" id="textbox" value="" type="text" size=26></td>
			    <td><font>&nbsp;<input style="font-size: 28px;" type="submit" name="Status" value="Check Out"></font></td>
			  </tr> 
			</table>
		      </form>
		  </div>
		  <!--end feature -->
	<SCRIPT language="JavaScript">
		document.form1.passedChildID.focus();
	</SCRIPT> 
  </div> 
  <!--end content -->

   <div id="sidebar" ><!--start sidebar -->
   	  <div class="relatedLinks"><!--start relatedLinks -->
        	<?php include ('/var/www/Templates/sidebar.php'); ?>
	  </div><!--end relatedLinks -->
  </div> <!--start sidebar -->
</div><!--end web -->



</body>

<div id="printchildlabels">
  <?php include ('/var/www/printer.php'); ?>
</div>
</html>
