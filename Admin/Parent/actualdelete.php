<?php include ('/var/www/Templates/database.php'); ?>
<?php include ('/var/www/Access/accessadmin.php'); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Sunnybrook Child Checkin Admin pages</title>
<link rel="stylesheet" href="/scc.css" type="text/css" >
<link rel="stylesheet" href="/print.css" type="text/css" media="print">

</head>
<body>
<?php
$passedParentID = $_GET['passedParentID'];
if ((isset($passedParentID)) && ($passedParentID != "")) {
  $deleteSQL = sprintf("DELETE FROM parent WHERE ParentID=%s",
                       GetSQLValueString($passedParentID, "text"));

  mysql_select_db($database_dbs, $dbs);
  $Result1 = mysql_query($deleteSQL, $dbs) or die(mysql_error());

  $new_image_location = "/var/www/ParentPictures/".$passedParentID.".jpg";
  //remove file if exists
  //echo 'test point 1';
  //echo $new_image_location;
  if(file_exists($new_image_location)){
    //echo 'test point 2';
    system("rm $new_image_location");
    //replace with Question mark man
    //system("cp $org_file $image_file");
    system("cp /var/www/ParentPictures/0.jpg $new_image_location");
  }
  $deleteGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $deleteGoTo));
  //echo '<meta HTTP-EQUIV="REFRESH" content="0; url=http://www.terraverdetech.com/Admin/Cameras/camera.php">';
  
  //now we need to search all adults for this childID and update them
  mysql_select_db($database_dbs, $dbs);
  //SELECT * FROM foo WHERE b = 'abc' ORDER BY number ASC;
  //$query_Sort2 = sprintf("SELECT * FROM child WHERE ChildID='$passedChildID'"); 
  echo $query_Sort;
  $query_Sort2 = "SELECT * FROM child WHERE ParentID1='$passedParentID' 
					  OR ParentID2='$passedParentID' 
					  OR ParentID3='$passedParentID' 
					  OR ParentID4='$passedParentID' 
					  ORDER BY ChildID ASC"; 
  //NOTE: there should only be one ParentID per child, but we will check them ALL
  $Sort2 = mysql_query($query_Sort2, $dbs) or die(mysql_error());

  //We now need to find where the ParentID is located with in the ChildID (is it in ParentID1? 3?)
  // then we need to update that child before checking the next ChildID
  while ($row_Sort2 = mysql_fetch_assoc($Sort2)) { 
    $TempPID1 = $row_Sort2['ParentID1'];
    $TempPID2 = $row_Sort2['ParentID2'];
    $TempPID3 = $row_Sort2['ParentID3'];
    $TempPID4 = $row_Sort2['ParentID4']; 
    
    if($TempPID1==$passedParentID){$TempPID1="";}
    if($TempPID2==$passedParentID){$TempPID2="";}
    if($TempPID3==$passedParentID){$TempPID3="";}
    if($TempPID4==$passedParentID){$TempPID4="";}
    
    //once we have all the parents with a child id, we need to update those fields
    $updateSQL = sprintf("UPDATE child SET FirstName=%s, LastName=%s, Address=%s, City=%s, Gender=%s, Grade=%s, AgeGroup=%s, Birthday=%s, DateEntered=%s, Status=%s, StatusChange=%s, Allergies=%s, Notes=%s, ParentID1=%s, ParentID2=%s, ParentID3=%s, ParentID4=%s, SmallGroup=%s, CellPhone=%s, Email=%s, Twitter=%s, Instagram=%s WHERE ChildID=%s",
                       GetSQLValueString($row_Sort2['FirstName'], "text"),
                       GetSQLValueString($row_Sort2['LastName'], "text"),
                       GetSQLValueString($row_Sort2['Address'], "text"),
                       GetSQLValueString($row_Sort2['City'], "text"),
		       GetSQLValueString($row_Sort2['Gender'], "text"),
                       GetSQLValueString($row_Sort2['Grade'], "text"),
                       GetSQLValueString($row_Sort2['AgeGroup'], "text"),
                       GetSQLValueString($row_Sort2['Birthday'], "text"),
                       GetSQLValueString($row_Sort2['DateEntered'], "text"),
		       GetSQLValueString($row_Sort2['Status'], "text"),
                       GetSQLValueString($row_Sort2['StatusChange'], "text"),
                       GetSQLValueString($row_Sort2['Allergies'], "text"),
                       GetSQLValueString($row_Sort2['Notes'], "text"),
		       GetSQLValueString($TempPID1, "text"),
		       GetSQLValueString($TempPID2, "text"),
		       GetSQLValueString($TempPID3, "text"),
		       GetSQLValueString($TempPID4, "text"),
		       GetSQLValueString($row_Sort2['SmallGroup'], "text"),
		       GetSQLValueString($row_Sort2['CellPhone'], "text"),
		       GetSQLValueString($row_Sort2['Email'], "text"),
		       GetSQLValueString($row_Sort2['Twitter'], "text"),
		       GetSQLValueString($row_Sort2['Instagram'], "text"),
                       GetSQLValueString($row_Sort2['ChildID'], "text"));

    mysql_select_db($database_dbs, $dbs);
    $Result1 = mysql_query($updateSQL, $dbs) or die(mysql_error());
  }//end while row_Sort2  
  
  
}

mysql_select_db($database_dbs, $dbs);
$query_Recordset1 = "SELECT * FROM parent";
$Recordset1 = mysql_query($query_Recordset1, $dbs) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?>
<div id="web"><!--start web -->
<?php include ('/var/www/Templates/masterhead.php'); ?>
  <div id="content"> <!--start content -->
	  <div id="breadCrumb">
	  </div> 
		<h2 id="pageName">Are you sure that you want to delete parent with an ID of <?php echo $passedParentID; ?> ? </h2>
		  <div class="feature">
			<meta HTTP-EQUIV="REFRESH" content="2; url=http://192.168.12.158/Admin/Parent/">
		  </div>
		  <!--end feature -->
	    </div> 
	  <!--end content -->
   <div id="sidebar" ><!--start sidebar -->
   	  <div class="relatedLinks"><!--start relatedLinks -->
        	<?php include ('/var/www/Templates/sidebar.php'); ?>
		<?php include ('/var/www/Admin/adminrelatedlinks.php'); ?>
	  </div><!--end relatedLinks -->
  </div> <!--start sidebar -->
</div><!--end web -->

</body>
</html>


