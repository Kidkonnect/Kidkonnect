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
//$newChildID = "x";
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $passedSort = "ParentID";

  //we need to get the next parent ID so we can tie an image to them
  mysql_select_db($database_dbs, $dbs);
  $query_Sort = "SELECT * FROM parent ORDER BY $passedSort ASC"; 
  //echo $query_Sort;
  $Sort = mysql_query($query_Sort, $dbs) or die(mysql_error());
  $totalRows = mysql_num_rows($Sort);
  $row_Sort = mysql_fetch_assoc($Sort);
  //first we need to track the number of entries that are in the database
  $count = 0;
  $newParentID = 0;
  //echo $totalRows.'<br>';
  //this while loop will stop at the last entry so we could add 1 to the Child ID!
  while (($row_Sort = mysql_fetch_assoc($Sort)) && ($count < $totalRows - 1)){
  $newParentID = $row_Sort['ParentID']; 
  //echo '<br> else CID = '.$row_Sort['ChildID'].'<br>';
  //echo $newParentID;
  $count++;
  //echo '<br>';
  }
  echo $newParentID;

  $newParentID++; //add one to the previous childID



  $insertSQL = sprintf("INSERT INTO parent (ParentID, FirstName, LastName, Address, City, HomePhone, CellPhone1, Email, VolunteerLocation, VolunteerTitle, ChildID1, ChildID2, ChildID3, ChildID4, ChildID5, ChildID6, ChildID7, ChildID8, ChildID9, ChildID10) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($newParentID, "text"),
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
		       GetSQLValueString($_POST['ChildID10'], "text"));

  mysql_select_db($database_dbs, $dbs);
  $Result1 = mysql_query($insertSQL, $dbs) or die(mysql_error()); 
//you can add more code here to add this information into oher tables 


  $new_image_location = "/var/www/ParentPictures/".$newParentID.".jpg";
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
  else {
    //replace with Question mark man
    //system("cp $org_file $image_file");
    system("cp /var/www/ParentPictures/0.jpg $new_image_location");
  } 
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
    $new_image_location = "/var/www/ParentPictures/".$newParentID.".jpg";
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
  //get first letter of last name so we can hand it back to index as a filter option.
  $passedSort = "LastName";

  $passedFilter = substr($_POST['LastName'], 0, 1);  // returns first letter of last name
  if (!isset($passedFilter)) {
    $passedFilter = "A";
  }
}//end if isset image file
  echo '<meta HTTP-EQUIV="REFRESH" content="0; url=http://192.168.12.158/Admin/Parent/index.php?Sort='.$passedSort.'&Filter='.substr($_POST['LastName'], 0, 1).'">';
}
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
				<td nowrap align="right">* ParentID:</td>
				<td><input type="hidden" name="ParentID" value="" size="32" >will be created by computer!</td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* FirstName:</td>
				<td><input type="text" class="textbox" name="FirstName" value="First" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* LastName:</td>
				<td><input type="text" class="textbox" name="LastName" value="Last" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* Address:</td>
				<td><input type="text" class="textbox" name="Address" value="Address" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* City:</td>
				<td><input type="text" class="textbox" name="City" value="City" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* HomePhone:</td>
				<td><input type="text" class="textbox" name="HomePhone" value="none" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* CellPhone1:</td>
				<td><input type="text" class="textbox" name="CellPhone1" value="none" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* Email:</td>
				<td><input type="text" class="textbox" name="Email" value="Email" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">VolunteerLocation:</td>
				<td><input type="text" class="textbox" name="VolunteerLocation" value="" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">VolunteerTitle:</td>
				<td><input type="text" class="textbox" name="VolunteerTitle" value="" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">ChildID1:</td>
				<td><input type="text" class="textbox" name="ChildID1" value="" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">ChildID2:</td>
				<td><input type="text" class="textbox" name="ChildID2" value="" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">ChildID3:</td>
				<td><input type="text" class="textbox" name="ChildID3" value="" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">ChildID4:</td>
				<td><input type="text" class="textbox" name="ChildID4" value="" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">ChildID5:</td>
				<td><input type="text" class="textbox" name="ChildID5" value="" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">ChildID6:</td>
				<td><input type="text" class="textbox" name="ChildID6" value="" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">ChildID7:</td>
				<td><input type="text" class="textbox" name="ChildID7" value="" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">ChildID8:</td>
				<td><input type="text" class="textbox" name="ChildID8" value="" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">ChildID9:</td>
				<td><input type="text" class="textbox" name="ChildID9" value="" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">ChildID10:</td>
				<td><input type="text" class="textbox" name="ChildID10" value="" size="32"></td>
			  </tr>
			  <tr>
			  	<td><input type="hidden" class="textbox" name="MAX_FILE_SIZE" value="25000000">  Upload Image:</td> 
				<td><input type="file" class="textbox" name="imgfile" value=""></td>
				<td>Picture needs to be in jpg or gif format</td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">&nbsp;</td>
				<td><input type="submit" value="Insert Record" class="button"></td>
			  </tr>

			</table>
			<input type="hidden" name="MM_insert" value="form1">  </form>
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


