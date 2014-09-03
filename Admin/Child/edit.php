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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  //this will gengerate the AgeGroup data, there are to many "Visitors" with incorrect agegroups
  $AgeGroup = "";
  //if same lenght, then no Grade or age group was selected, remove the "AND"
  $Grade = substr($_POST['Grade'], 4, 5);  //looking to only get "Grade" from 1st_Grade
  //echo $Grade;
  if ($Grade == "Grade") { //We found our 1-9 Agegroup
    $Number = substr($_POST['Grade'], 0, 1);//looking to only get "1" from 1st_Grade
    if ($Number == "1"){$AgeGroup = "1-5";}
    else if ($Number == "2"){$AgeGroup = "1-5";}
    else if ($Number == "3"){$AgeGroup = "1-5";}
    else if ($Number == "4"){$AgeGroup = "1-5";}
    else if ($Number == "5"){$AgeGroup = "1-5";}
    else if ($Number == "6"){$AgeGroup = "6-8";}
    else if ($Number == "7"){$AgeGroup = "6-8";}
    else if ($Number == "8"){$AgeGroup = "6-8";}
    else if ($Number == "9"){$AgeGroup = "9-12";}
  }
  else if ($Grade == "_Grad") { //We found our 10-12 Agegroup 
    $AgeGroup = "9-12";
  }
  else { //we have a "N-K" age group
    $AgeGroup = "N-K";
  }
  
//																																>SmallGroup:<>CellPhone:<>Email:<>Twitter:<>Instagram:<
  
  $updateSQL = sprintf("UPDATE child SET FirstName=%s, LastName=%s, Address=%s, City=%s, Gender=%s, Grade=%s, AgeGroup=%s, Birthday=%s, DateEntered=%s, Status=%s, StatusChange=%s, Allergies=%s, Notes=%s, ParentID1=%s, ParentID2=%s, ParentID3=%s, ParentID4=%s, SmallGroup=%s, CellPhone=%s, Email=%s, Twitter=%s, Instagram=%s WHERE ChildID=%s",
                       GetSQLValueString($_POST['FirstName'], "text"),
                       GetSQLValueString($_POST['LastName'], "text"),
                       GetSQLValueString($_POST['Address'], "text"),
                       GetSQLValueString($_POST['City'], "text"),
		       GetSQLValueString($_POST['Gender'], "text"),
                       GetSQLValueString($_POST['Grade'], "text"),
                       GetSQLValueString($AgeGroup, "text"),
                       GetSQLValueString($_POST['Birthday'], "text"),
                       GetSQLValueString($_POST['DateEntered'], "text"),
		       GetSQLValueString($_POST['Status'], "text"),
                       GetSQLValueString($_POST['StatusChange'], "text"),
                       GetSQLValueString($_POST['Allergies'], "text"),
                       GetSQLValueString($_POST['Notes'], "text"),
		       GetSQLValueString($_POST['ParentID1'], "text"),
		       GetSQLValueString($_POST['ParentID2'], "text"),
		       GetSQLValueString($_POST['ParentID3'], "text"),
		       GetSQLValueString($_POST['ParentID4'], "text"),
		       GetSQLValueString($_POST['SmallGroup'], "text"),
		       GetSQLValueString($_POST['CellPhone'], "text"),
		       GetSQLValueString($_POST['Email'], "text"),
		       GetSQLValueString($_POST['Twitter'], "text"),
		       GetSQLValueString($_POST['Instagram'], "text"),
                       GetSQLValueString($_POST['ChildID'], "text"));

  mysql_select_db($database_dbs, $dbs);
  $Result1 = mysql_query($updateSQL, $dbs) or die(mysql_error());
//you can add more code here to add this information into oher tables 

//echo "point 1";
$imgfile2 = $_POST['imgfile'];
//echo "$ChildIDPicture";
   //set the image that was uploaded
   //if (isset($_POST['imgfile']))
//echo $imgfile2;
//echo "Upload: " . $_FILES["imgfile"]["name"] . "<br />";
//echo "Type: " . $_FILES["imgfile"]["type"] . "<br />";
//echo "Size: " . ($_FILES["imgfile"]["size"] / 1024) . " Kb<br />";
//echo "Stored in: " . $_FILES["imgfile"]["tmp_name"];
if (isset($_FILES["imgfile"]["tmp_name"])&&($_FILES["imgfile"]["tmp_name"]!='')){
  $large_image_location = $_FILES["imgfile"]["tmp_name"];
  $new_image_location = "/var/www/ChildPictures/" . $_POST['ChildID'].".jpg";
  //remove file if exists
  if(file_exists($new_image_location)){
    system("rm $new_image_location");
  }
  //Scale the image if it is greater than the width set above  
  //system command runs on the server. you will need to install imagemagick
  system("convert $large_image_location -resize '300x200' $new_image_location");
  //echo "Stored in: " . "/var/www/ChildPictures/" . $_POST['ChildID'].".jpg";

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
      //move_uploaded_file($_FILES["imgfile"]["tmp_name"],"/var/www/ChildPictures/" . $_POST['ChildID'].".jpg");
      //echo "Stored in: " . "/var/www/ChildPictures/" . $_POST['ChildID'].".jpg";
    //  }
    }
  }
else
  {
  echo "Invalid file";
  }
   //echo "point END";
  $passedGrade = $_POST['Grade'];
  if (!isset($passedGrade)) {
    $passedGrade = "Nursery";
  }
}//end if isset image file
  //echo '<meta HTTP-EQUIV="REFRESH" content="0; url=http://192.168.12.158/Admin/Child/index.php?GradeSort='.$_POST['Grade'].'">';
}

$passedChildID=$_GET['passedChildID'];
mysql_select_db($database_dbs, $dbs);
$query_Sort = "SELECT * FROM child WHERE ChildID = '".$passedChildID."'"; 
$Sort = mysql_query($query_Sort, $dbs) or die(mysql_error());
$totalRows = mysql_num_rows($Sort);
$row_Sort = mysql_fetch_assoc($Sort);

//code for the copy to adult database

if ((isset($_GET["passedCopy"])) && ($_GET["passedCopy"] == "Yes")) {
  $passedSort = "ParentID";

  //we need to get the next parent ID so we can tie an image to them
  mysql_select_db($database_dbs, $dbs);
  $query_Sort_p = "SELECT * FROM parent ORDER BY $passedSort ASC"; 
  //echo "point1";
  $Sort_p = mysql_query($query_Sort_p, $dbs) or die(mysql_error());
  $totalRows_p = mysql_num_rows($Sort_p);
  $row_Sort_p = mysql_fetch_assoc($Sort_p);
  //first we need to track the number of entries that are in the database
  $count = 0;
  $newParentID = 0;
  //echo $totalRows.'<br>';
  //this while loop will stop at the last entry so we could add 1 to the Child ID!
  while (($row_Sort_p = mysql_fetch_assoc($Sort_p)) && ($count < $totalRows_p - 1)){
  $newParentID = $row_Sort_p['ParentID']; 
  //echo '<br> else CID = '.$row_Sort['ChildID'].'<br>';
  //echo $newParentID;
  $count++;
  //echo '<br>';
  }
  
  $newParentID++; //add one to the previous parentID
  //echo "point2";


  $insertSQL = sprintf("INSERT INTO parent (ParentID, FirstName, LastName, Address, City, HomePhone, CellPhone1, Email, ChildID1, ChildID2, ChildID3, ChildID4, ChildID5, ChildID6, ChildID7, ChildID8, ChildID9, ChildID10) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($newParentID, "text"),
		       GetSQLValueString($row_Sort['FirstName'], "text"),
                       GetSQLValueString($row_Sort['LastName'], "text"),
                       GetSQLValueString($row_Sort['Address'], "text"),
                       GetSQLValueString($row_Sort['City'], "text"),
		       GetSQLValueString("HomePhone", "text"),
                       GetSQLValueString($row_Sort['CellPhone'], "text"),
                       GetSQLValueString($row_Sort['Email'], "text"),
		       GetSQLValueString("", "text"),
		       GetSQLValueString("", "text"),
		       GetSQLValueString("", "text"),
		       GetSQLValueString("", "text"),
		       GetSQLValueString("", "text"),
		       GetSQLValueString("", "text"),
		       GetSQLValueString("", "text"),
		       GetSQLValueString("", "text"),
		       GetSQLValueString("", "text"),
		       GetSQLValueString("", "text"));

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
    system("cp /var/www/ChildPictures/$passedChildID.jpg $new_image_location");
  }
  else{
    system("cp /var/www/ChildPictures/$passedChildID.jpg $new_image_location");
  }

  //get first letter of last name so we can hand it back to index as a filter option.
  $passedSort = "LastName";
  $passedFilter = substr($row_Sort['LastName'], 0, 1);  // returns first letter of last name
  if (!isset($passedFilter)) {
    $passedFilter = "A";
  }

  //echo '<meta HTTP-EQUIV="REFRESH" content="0; url=http://192.168.12.158/Admin/Parent/index.php?Sort='.$passedSort.'&Filter='.$passedFilter.'">';
}

?>
<div id="web"><!--start web -->
<?php include ('/var/www/Templates/masterhead.php'); ?>
  <div id="content"> <!--start content -->
	  <div id="breadCrumb">
	  </div> 
		<h2 id="pageName">Welcome to Sunnybrook Admin Section</h2>
		  <div class="feature">
		  
		  
		        <?php if (((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) || ((isset($_GET["passedCopy"])) && ($_GET["passedCopy"] == "Yes"))) { ?>
			<form action="index.php" METHOD="POST" name="form2">
			<table align="center" class="table">
			  <tr valign="baseline">
				<td colspan="2" nowrap align="center">-----UPDATE WAS A SUCCESS!----</td>
			  </tr>
			  <tr valign="baseline">
				<td><input type="submit" name="Status" value="GO BACK"  class="button"></td>
			  </tr>
			</table>
			</form>
			<?php } else { //print the update form?>
			
			
			<form action="<?php echo $editFormAction; ?>" METHOD="POST" name="form1" enctype="multipart/form-data">
			<table align="center" class="table">
			  <tr valign="baseline">
				<td colspan="3" nowrap align="right"><img height="200" src="/ChildPictures/<?php echo $passedChildID; ?>.jpg"></td>
				<td align="left" nowrap="true"><a href="/Admin/Child/edit.php?passedCopy=Yes&passedChildID=<?php echo $row_Sort['ChildID']; ?>">Copy to Adult database</a>&nbsp;</td>

			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* ChildID:</td>
				<td><input type="hidden" name="ChildID" value="<?php echo  $row_Sort['ChildID']; ?>" size="32" ><?php echo  $row_Sort['ChildID']; ?></td>
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
				<td nowrap align="right">* Gender:</td>
				<td><input type="text" class="textbox" name="Gender" value="<?php echo  $row_Sort['Gender']; ?>" size="32"></td>
			  	<td>Male or Female</td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* Grade:</td>
				<td><select name="Grade" >
				<option  class="textbox" value="Nursery" <?php if ($row_Sort['Grade'] == 'Nursery'){ echo 'selected';} ?>>Nursery&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="1YearOlds" <?php if ($row_Sort['Grade'] == '1YearOlds'){ echo 'selected';} ?>>1YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="2YearOlds" <?php if ($row_Sort['Grade'] == '2YearOlds'){ echo 'selected';} ?>>2YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="3YearOlds" <?php if ($row_Sort['Grade'] == '3YearOlds'){ echo 'selected';} ?>>3YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="4YearOlds" <?php if ($row_Sort['Grade'] == '4YearOlds'){ echo 'selected';} ?>>4YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="5YearOlds" <?php if ($row_Sort['Grade'] == '5YearOlds'){ echo 'selected';} ?>>5YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="1st_Grade" <?php if ($row_Sort['Grade'] == '1st_Grade'){ echo 'selected';} ?>>1st_Grade&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="2nd_Grade" <?php if ($row_Sort['Grade'] == '2nd_Grade'){ echo 'selected';} ?>>2nd_Grade&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="3rd_Grade" <?php if ($row_Sort['Grade'] == '3rd_Grade'){ echo 'selected';} ?>>3rd_Grade&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="4th_Grade" <?php if ($row_Sort['Grade'] == '4th_Grade'){ echo 'selected';} ?>>4th_Grade&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="5th_Grade" <?php if ($row_Sort['Grade'] == '5th_Grade'){ echo 'selected';} ?>>5th_Grade&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="6th_Grade" <?php if ($row_Sort['Grade'] == '6th_Grade'){ echo 'selected';} ?>>6th_Grade&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="7th_Grade" <?php if ($row_Sort['Grade'] == '7th_Grade'){ echo 'selected';} ?>>7th_Grade&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="8th_Grade" <?php if ($row_Sort['Grade'] == '8th_Grade'){ echo 'selected';} ?>>8th_Grade&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="9th_Grade" <?php if ($row_Sort['Grade'] == '9th_Grade'){ echo 'selected';} ?>>9th_Grade&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="10th_Grade" <?php if ($row_Sort['Grade'] == '10th_Grade'){ echo 'selected';} ?>>10th_Grade&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="11th_Grade" <?php if ($row_Sort['Grade'] == '11th_Grade'){ echo 'selected';} ?>>11th_Grade&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="12th_Grade" <?php if ($row_Sort['Grade'] == '12th_Grade'){ echo 'selected';} ?>>12th_Grade&nbsp;&nbsp;&nbsp;</option>
			        </select></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">AgeGroup:</td>
				<td><input type="hidden" name="AgeGroup" value="<?php echo  $row_Sort['AgeGroup']; ?>" size="32"><?php echo  $row_Sort['AgeGroup']; ?></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* Birthday:</td>
				<td><input type="text" class="textbox" name="Birthday" value="<?php echo  $row_Sort['Birthday']; ?>" size="32"></td>
			  	<td>mm/dd/yyyy</td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* DateEntered:</td>
				<td><input type="text" class="textbox" name="DateEntered" value="<?php echo  $row_Sort['DateEntered']; ?>" size="32"></td>
			  	<td>mm/dd/yyyy Today's Date</td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">Status:</td>
				<td><input type="hidden" name="Status" value="<?php echo  $row_Sort['Status']; ?>" size="32"><?php echo  $row_Sort['Status']; ?></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">StatusChange:</td>
				<td><input type="hidden" name="StatusChange" value="<?php echo  $row_Sort['StatusChange']; ?>" size="32"><?php echo  $row_Sort['StatusChange']; ?></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">Allergies:</td>
				<td><input type="text" class="textbox" name="Allergies" value="<?php echo  $row_Sort['Allergies']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">Notes:</td>
				<td><input type="text" class="textbox" name="Notes" value="<?php echo  $row_Sort['Notes']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">ParentID1:</td>
				<td><input type="text" class="textbox" name="ParentID1" value="<?php echo  $row_Sort['ParentID1']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">ParentID2:</td>
				<td><input type="text" class="textbox" name="ParentID2" value="<?php echo  $row_Sort['ParentID2']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">ParentID3:</td>
				<td><input type="text" class="textbox" name="ParentID3" value="<?php echo  $row_Sort['ParentID3']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">ParentID4:</td>
				<td><input type="text" class="textbox" name="ParentID4" value="<?php echo  $row_Sort['ParentID4']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td colspan="2" nowrap align="center">-----Junior High and High School Info----</td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">SmallGroup:</td>
				<td><input type="text" class="textbox" name="SmallGroup" value="<?php echo  $row_Sort['SmallGroup']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">CellPhone:</td>
				<td><input type="text" class="textbox" name="CellPhone" value="<?php echo  $row_Sort['CellPhone']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">Email:</td>
				<td><input type="text" class="textbox" name="Email" value="<?php echo  $row_Sort['Email']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">Twitter:</td>
				<td><input type="text" class="textbox" name="Twitter" value="<?php echo  $row_Sort['Twitter']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">Instagram:</td>
				<td><input type="text" class="textbox" name="Instagram" value="<?php echo  $row_Sort['Instagram']; ?>" size="32"></td>
			  </tr>
			  <tr>
			  	<td><input type="hidden" class="textbox" name="MAX_FILE_SIZE" value="25000000">  Upload Image:</td> 
				<td><input type="file" class="textbox" name="imgfile" value=""></td>
				<td>Picture needs to be in jpg or gif format</td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">&nbsp;</td>
				<td><input type="submit" name="submit" value="Update Record" class="button"></td>
			  </tr>

			</table>
			<input type="hidden" name="MM_update" value="form1">  </form>
			
			<?php } //END ELSE print the update form?>
			
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


