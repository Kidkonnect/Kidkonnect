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
$passedChildID = $_GET['passedChildID'];
if ((isset($passedChildID)) && ($passedChildID != "")) {
  $deleteSQL = sprintf("DELETE FROM child WHERE ChildID=%s",
                       GetSQLValueString($passedChildID, "text"));

  mysql_select_db($database_dbs, $dbs);
  $Result1 = mysql_query($deleteSQL, $dbs) or die(mysql_error());
  //also delete the picture and replace with Qestion Mark man (0.jpg)
  $new_image_location = "/var/www/ChildPictures/".$passedChildID.".jpg";
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
  $query_Sort2 = "SELECT * FROM parent WHERE ChildID1='$passedChildID' 
					  OR ChildID2='$passedChildID' 
					  OR ChildID3='$passedChildID' 
					  OR ChildID4='$passedChildID' 
					  OR ChildID5='$passedChildID'
					  OR ChildID6='$passedChildID'
					  OR ChildID7='$passedChildID'
					  OR ChildID8='$passedChildID'
					  OR ChildID9='$passedChildID'
					  OR ChildID10='$passedChildID'
					  ORDER BY ParentID ASC"; 
  //NOTE: there should only be one ChildID per parent, i.e. PartentID=254 ChildID1=2025, ChildID2 should NOT BE 2025, but we will check them ALL
  $Sort2 = mysql_query($query_Sort2, $dbs) or die(mysql_error());

  //We now need to find where the ChildID is located with in the ParentID (is it in ChildID1? 3? 6?)
  // then we need to update that parent before checking the next ParnetID
  while ($row_Sort2 = mysql_fetch_assoc($Sort2)) { 
    $TempCID1 = $row_Sort2['ChildID1'];
    $TempCID2 = $row_Sort2['ChildID2'];
    $TempCID3 = $row_Sort2['ChildID3'];
    $TempCID4 = $row_Sort2['ChildID4'];
    $TempCID5 = $row_Sort2['ChildID5'];
    $TempCID6 = $row_Sort2['ChildID6'];
    $TempCID7 = $row_Sort2['ChildID7'];
    $TempCID8 = $row_Sort2['ChildID8'];
    $TempCID9 = $row_Sort2['ChildID9'];
    $TempCID10 = $row_Sort2['ChildID10']; 
    
    if($TempCID1==$passedChildID){$TempCID1="";}
    if($TempCID2==$passedChildID){$TempCID2="";}
    if($TempCID3==$passedChildID){$TempCID3="";}
    if($TempCID4==$passedChildID){$TempCID4="";}
    if($TempCID5==$passedChildID){$TempCID5="";}
    if($TempCID6==$passedChildID){$TempCID6="";}
    if($TempCID7==$passedChildID){$TempCID7="";}
    if($TempCID8==$passedChildID){$TempCID8="";}
    if($TempCID9==$passedChildID){$TempCID9="";}
    if($TempCID10==$passedChildID){$TempCID10="";}
    
    //once we have all the parents with a child id, we need to update those fields
    $updateSQL = sprintf("UPDATE parent SET FirstName=%s, LastName=%s, Address=%s, City=%s, HomePhone=%s, CellPhone1=%s, Email=%s, VolunteerLocation=%s, VolunteerTitle=%s, ChildID1=%s, ChildID2=%s, ChildID3=%s, ChildID4=%s, ChildID5=%s, ChildID6=%s, ChildID7=%s, ChildID8=%s, ChildID9=%s, ChildID10=%s WHERE ParentID=%s",
                       GetSQLValueString($row_Sort2['FirstName'], "text"),
                       GetSQLValueString($row_Sort2['LastName'], "text"),
                       GetSQLValueString($row_Sort2['Address'], "text"),
                       GetSQLValueString($row_Sort2['City'], "text"),
		       GetSQLValueString($row_Sort2['HomePhone'], "text"),
                       GetSQLValueString($row_Sort2['CellPhone1'], "text"),
                       GetSQLValueString($row_Sort2['Email'], "text"),
                       GetSQLValueString($row_Sort2['VolunteerLocation'], "text"),
                       GetSQLValueString($row_Sort2['VolunteerTitle'], "text"),
		       GetSQLValueString($TempCID1, "text"),
		       GetSQLValueString($TempCID2, "text"),
		       GetSQLValueString($TempCID3, "text"),
		       GetSQLValueString($TempCID4, "text"),
		       GetSQLValueString($TempCID5, "text"),
		       GetSQLValueString($TempCID6, "text"),
		       GetSQLValueString($TempCID7, "text"),
		       GetSQLValueString($TempCID8, "text"),
		       GetSQLValueString($TempCID9, "text"),
		       GetSQLValueString($TempCID10, "text"),
                       GetSQLValueString($row_Sort2['ParentID'], "text"));

    mysql_select_db($database_dbs, $dbs);
    $Result1 = mysql_query($updateSQL, $dbs) or die(mysql_error());
  }//end while row_Sort2
   
}

mysql_select_db($database_dbs, $dbs);
$query_Recordset1 = "SELECT * FROM child";
$Recordset1 = mysql_query($query_Recordset1, $dbs) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?>
<div id="web"><!--start web -->
<?php include ('/var/www/Templates/masterhead.php'); ?>
  <div id="content"> <!--start content -->
	  <div id="breadCrumb">
	  </div> 
		<h2 id="pageName">deleting child with an ID of <?php echo $passedChildID; ?>... Searching adult database also...</h2>
		  <div class="feature">
			<meta HTTP-EQUIV="REFRESH" content="2; url=http://192.168.12.158/Admin/Child/">
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


