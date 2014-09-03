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
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$passedSort = $_GET['Sort'];
if (!isset($passedSort)) {
	$passedSort = "LastName";
}
$passedFilter = $_GET['Filter'];
if (!isset($passedFilter)) {
  $passedFilter = "A";
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE parent SET FirstName=%s, LastName=%s, Address=%s, City=%s, HomePhone=%s, CellPhone1=%s, Email=%s, VolunteerLocation=%s, VolunteerTitle=%s, ChildID1=%s, ChildID2=%s, ChildID3=%s, ChildID4=%s, ChildID5=%s, ChildID6=%s, ChildID7=%s, ChildID8=%s, ChildID9=%s, ChildID10=%s WHERE ParentID=%s",
                       GetSQLValueString($_POST['FirstName'], "text"),
                       GetSQLValueString($_POST['LastName'], "text"),
                       GetSQLValueString($_POST['Address'], "text"),
                       GetSQLValueString($_POST['City'], "text"),
		       GetSQLValueString($_POST['HomePhone'], "text"),
                       GetSQLValueString($_POST['CellPhone1'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['VolunteerLocation'], "text"),
                       GetSQLValueString($_POST['VolunteerTitle'], "text"),
		       GetSQLValueString($_POST['ChildID1'], "text"),
		       GetSQLValueString($_POST['ChildID2'], "text"),
		       GetSQLValueString($_POST['ChildID3'], "text"),
		       GetSQLValueString($_POST['ChildID4'], "text"),
		       GetSQLValueString($_POST['ChildID5'], "text"),
		       GetSQLValueString($_POST['ChildID6'], "text"),
		       GetSQLValueString($_POST['ChildID7'], "text"),
		       GetSQLValueString($_POST['ChildID8'], "text"),
		       GetSQLValueString($_POST['ChildID9'], "text"),
		       GetSQLValueString($_POST['ChildID10'], "text"),
                       GetSQLValueString($_POST['ParentID'], "text"));

  mysql_select_db($database_dbs, $dbs);
  $Result1 = mysql_query($updateSQL, $dbs) or die(mysql_error());
//you can add more code here to add this information into oher tables 

//echo "point 1";
$imgfile2 = $_POST['imgfile'];
//echo "$ChildIDPicture";
   //set the image that was uploaded

//echo $imgfile2;
//echo "Upload: " . $_FILES["imgfile"]["name"] . "<br />";
//echo "Type: " . $_FILES["imgfile"]["type"] . "<br />";
//echo "Size: " . ($_FILES["imgfile"]["size"] / 1024) . " Kb<br />";
//echo "Stored in: " . $_FILES["imgfile"]["tmp_name"];
if (isset($_FILES["imgfile"]["tmp_name"])&&($_FILES["imgfile"]["tmp_name"]!='')){
  $large_image_location = $_FILES["imgfile"]["tmp_name"];
  $new_image_location = "/var/www/ParentPictures/" . $_POST['ParentID'].".jpg";
  //remove file if exists
  if(file_exists($new_image_location)){
    system("rm $new_image_location");
  }
  //Scale the image if it is greater than the width set above  
  //system command runs on the server. you will need to install imagemagick
  system("convert $large_image_location -resize '300x200' $new_image_location");
  //echo "Stored in: " . "/var/www/ParentPictures/" . $_POST['ParentID'].".jpg";

  if ((($_FILES["imgfile"]["type"] == "image/gif")|| ($_FILES["imgfile"]["type"] == "image/jpeg")|| ($_FILES["imgfile"]["type"] == "image/jpg")))
    {
    if ($_FILES["imgfile"]["error"] > 0)
      {
      echo "Return Code: " . $_FILES["imgfile"]["error"] . "<br />";
      }
    else
      {
    //echo "Upload: " . $_FILES["imgfile"]["name"] . "<br />";
    //echo "Type: " . $_FILES["imgfile"]["type"] . "<br />";
    //echo "Size: " . $_FILES["imgfile"]["size"] . " Kb<br />";
    //echo "Temp file: " . $_FILES["imgfile"]["tmp_name"] . "<br />";

    //if (file_exists("upload/" . $_FILES["imgfile"]["name"]))
    //  {
    //  echo $_FILES["imgfile"]["name"] . " already exists. ";
    //  }
    //else
    //  {
      //move_uploaded_file($_FILES["imgfile"]["tmp_name"],"/var/www/ParentPictures/" . $_POST['ParentID'].".jpg");
      //echo "Stored in: " . "/var/www/ChildPictures/" . $_POST['ChildID'].".jpg";
    //  }
      }
    }
  else
    {
    echo "Invalid file";
    }
     //echo "point END";
}
   echo '<meta HTTP-EQUIV="REFRESH" content="0; url=http://192.168.12.158/Admin/Parent/index.php?Sort='.$passedSort.'&Filter='.$passedFilter.'">';
}
$passedParentID=$_GET['passedParentID'];
mysql_select_db($database_dbs, $dbs);
$query_Sort = "SELECT * FROM parent WHERE ParentID = '".$passedParentID."'"; 
$Sort = mysql_query($query_Sort, $dbs) or die(mysql_error());
$totalRows = mysql_num_rows($Sort);
$row_Sort = mysql_fetch_assoc($Sort);
?>
<div id="web"><!--start web -->
<?php include ('/var/www/Templates/masterhead.php'); ?>
  <div id="content"> <!--start content -->
	  <div id="breadCrumb">
	  </div> 
		<h2 id="pageName">Welcome to Sunnybrook Admin Section</h2>
		  <div class="feature">
			<form action="<?php echo $editFormAction; ?>" METHOD="POST" name="form1" enctype="multipart/form-data">
			<table align="center" class="table">
			  <tr valign="baseline">
				<td colspan="2" nowrap align="right"><img height="200" src="/ParentPictures/<?php echo $passedParentID; ?>.jpg"></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* ParentID:</td>
				<td><input type="hidden" name="ParentID" value="<?php echo  $row_Sort['ParentID']; ?>" size="32" ><?php echo  $row_Sort['ParentID']; ?></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* FirstName:</td>
				<td><input type="text" class="textbox" name="FirstName" value="<?php echo  $row_Sort['FirstName']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* LastName:</td>
				<td><input type="text" class="textbox" name="LastName" value="<?php echo  $row_Sort['LastName']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* Address:</td>
				<td><input type="text" class="textbox" name="Address" value="<?php echo  $row_Sort['Address']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* City:</td>
				<td><input type="text" class="textbox" name="City" value="<?php echo  $row_Sort['City']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* HomePhone:</td>
				<td><input type="text" class="textbox" name="HomePhone" value="<?php echo  $row_Sort['HomePhone']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* CellPhone1:</td>
				<td><input type="text" class="textbox" name="CellPhone1" value="<?php echo  $row_Sort['CellPhone1']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* Email:</td>
				<td><input type="text" class="textbox" name="Email" value="<?php echo  $row_Sort['Email']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">VolunteerLocation:</td>
				<td><input type="text" class="textbox" name="VolunteerLocation" value="<?php echo  $row_Sort['VolunteerLocation']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">VolunteerTitle:</td>
				<td><input type="text" class="textbox" name="VolunteerTitle" value="<?php echo  $row_Sort['VolunteerTitle']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">ChildID1:</td>
				<td><input type="text" class="textbox" name="ChildID1" value="<?php echo  $row_Sort['ChildID1']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">ChildID2:</td>
				<td><input type="text" class="textbox" name="ChildID2" value="<?php echo  $row_Sort['ChildID2']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">ChildID3:</td>
				<td><input type="text" class="textbox" name="ChildID3" value="<?php echo  $row_Sort['ChildID3']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">ChildID4:</td>
				<td><input type="text" class="textbox" name="ChildID4" value="<?php echo  $row_Sort['ChildID4']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">ChildID5:</td>
				<td><input type="text" class="textbox" name="ChildID5" value="<?php echo  $row_Sort['ChildID5']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">ChildID6:</td>
				<td><input type="text" class="textbox" name="ChildID6" value="<?php echo  $row_Sort['ChildID6']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">ChildID7:</td>
				<td><input type="text" class="textbox" name="ChildID7" value="<?php echo  $row_Sort['ChildID7']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">ChildID8:</td>
				<td><input type="text" class="textbox" name="ChildID8" value="<?php echo  $row_Sort['ChildID8']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">ChildID9:</td>
				<td><input type="text" class="textbox" name="ChildID9" value="<?php echo  $row_Sort['ChildID9']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">ChildID10:</td>
				<td><input type="text" class="textbox" name="ChildID10" value="<?php echo  $row_Sort['ChildID10']; ?>" size="32"></td>
			  </tr>
			  <tr>
			  	<td><input type="hidden" class="textbox" name="MAX_FILE_SIZE" value="25000000">  Upload Image:</td> 
				<td><input type="file" class="textbox" name="imgfile" value=""></td>
				<td>Picture needs to be in jpg or gif format</td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">&nbsp;</td>
				<td><input type="submit" value="Update Record" class="button"></td>
			  </tr>

			</table>
			<input type="hidden" name="MM_update" value="form1">  </form>
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


