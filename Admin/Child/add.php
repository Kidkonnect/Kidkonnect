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
$newChildID = "x";
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  //before we update we need to find the next ChildID from the data base.
  //we will do this by the year that was specified.
  $passedSort = "ChildID";
  //get birthday month day year 
  $birthday = $_POST['Birthday']; // format "mm/dd/yyyy"
  //echo $birthday.'<br>';
  //$bmonth = substr($birthday, 0, 2);  // returns "mm"
  //$bday   = substr($birthday, 3, 2);  // returns "dd"
  $lenght = strlen($birthday);
  $byear = substr($birthday, $lenght-2, 2);  // returns "yy"
  mysql_select_db($database_dbs, $dbs);
  $query_Sort = "SELECT * FROM child WHERE ChildID LIKE '$byear%' ORDER BY $passedSort ASC"; 
  //echo $query_Sort;
  $Sort = mysql_query($query_Sort, $dbs) or die(mysql_error());
  $totalRows = mysql_num_rows($Sort);
  $row_Sort = mysql_fetch_assoc($Sort);
  //first we need to track the number of entries that are in the database
  $count = 0;
  $newChildID = 0;
  //echo $totalRows.'<br>';
  if ($row_Sort['ChildID'] == ''){
    $newChildID = $byear."00";
    //echo 'if CID = '.$newChildID;
  }
  else{
    //special case of only one id
    $newChildID = $row_Sort['ChildID']; 
    //this while loop will stop at the last entry so we could add 1 to the Child ID!
      while (($row_Sort = mysql_fetch_assoc($Sort)) && (($newChildID+1) == $row_Sort['ChildID'])) {
        $newChildID = $row_Sort['ChildID']; 
        //echo '<br> else CID = '.$row_Sort['ChildID'].'<br>';
        //echo $newChildID;
         $count++;
        //echo '<br>';
      }
  
    $newChildID++; //add one to the previous childID
    //if childID is lenght of 3 then we need to add a zero to the front.
    if (strlen($newChildID)==1){
    //add a zero to the front
    $newChildID = "000".$newChildID;
    }
    else if (strlen($newChildID)==2){
    //add a zero to the front
    $newChildID = "00".$newChildID;
    }
    else if (strlen($newChildID)==3){
    //add a zero to the front
    $newChildID = "0".$newChildID;
    }
  }

  //this will gengerate the AgeGroup data, there are to many "Visitors" with incorrect agegroups
  $AgeGroup = "";
  //if same lenght, then no Grade or age group was selected, remove the "AND"
  $Grade = substr($_POST['Grade'], 4, 5);  //looking to only get "Grade" from 1st_Grade
  //echo $Grade;
  if ($Grade == "Grade") { //We found our 1-9 Agegroup
    $Number = substr($_POST['Grade'], 0, 1);//looking to only get "1" from 1st_Grade
    if ($Number == "1"){$AgeGroup = "K-5";}
    else if ($Number == "2"){$AgeGroup = "K-5";}
    else if ($Number == "3"){$AgeGroup = "K-5";}
    else if ($Number == "4"){$AgeGroup = "K-5";}
    else if ($Number == "5"){$AgeGroup = "K-5";}
    else if ($Number == "6"){$AgeGroup = "6-8";}
    else if ($Number == "7"){$AgeGroup = "6-8";}
    else if ($Number == "8"){$AgeGroup = "6-8";}
    else if ($Number == "9"){$AgeGroup = "9-12";}
  }
  else if ($Grade == "_Grad") { //We found our 10-12 Agegroup 
    $AgeGroup = "9-12";
  }
  else if (($Grade == "ergar") && (date(n)>6)) { //We found our kindergarten, check current date for being in nusery of grade school 
    $AgeGroup = "K-5";
  }
  else { //we have a "N-K" age group
    $AgeGroup = "N-K";
  }
  
//								>SmallGroup:<>CellPhone:<>Email:<>Twitter:<>Instagram:<
 
//echo 'newChildID = '.$newChildID.'<br>';
  $insertSQL = sprintf("INSERT INTO child (ChildID, FirstName, LastName, Address, City, Gender, Grade,  AgeGroup, Birthday, DateEntered, Status, StatusChange, Allergies, Notes, ParentID1, ParentID2, ParentID3, ParentID4, SmallGroup, CellPhone, Email, Twitter, Instagram) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($newChildID, "text"),
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
		       GetSQLValueString($_POST['Instagram'], "text"));

  mysql_select_db($database_dbs, $dbs);
  $Result1 = mysql_query($insertSQL, $dbs) or die(mysql_error()); 
  //$insertGoTo = "////";
  //if (isset($_SERVER['QUERY_STRING'])) {
  //  $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
  //  $insertGoTo .= $_SERVER['QUERY_STRING'];
  //}
//CREATE NEW PICTURE
  $new_image_location = "/var/www/ChildPictures/".$newChildID.".jpg";
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
    $new_image_location = "/var/www/ChildPictures/".$newChildID.".jpg";
    //remove file if exists
    if(file_exists($new_image_location)){
      system("rm $new_image_location");
    }
    //Scale the image if it is greater than the width set above  
    //system command runs on the server. you will need to install imagemagick
    system("convert $large_image_location -resize '300x200' $new_image_location");
    //echo "Stored in: " . "/var/www/ChildPictures/" . $_POST['ChildID'].".jpg";

    if ((($_FILES["imgfile"]["type"] == "image/gif")|| ($_FILES["imgfile"]["type"] == "image/jpeg")|| ($_FILES["imgfile"]["type"] == "image/jpg"))){
      if ($_FILES["imgfile"]["error"] > 0){
        echo "Return Code: " . $_FILES["imgfile"]["error"] . "<br />";
      }
      else{
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
    else{
      echo "Invalid file";
    }
     //echo "point END";
    $passedGrade = $_POST['Grade'];
    if (!isset($passedGrade)) {
      $passedGrade = "Nursery";
    }
  }//end if isset image file
  //echo '<meta HTTP-EQUIV="REFRESH" content="0; url=http://192.168.12.158/Admin/Child/index.php?GradeSort='.$passedGrade.'">';
}
?>
<div id="web"><!--start web -->
<?php include ('/var/www/Templates/masterhead.php'); ?>
  <div id="content"> <!--start content -->
	  <div id="breadCrumb">
	  </div> 
		<h2 id="pageName">Welcome to Sunnybrook Admin Section</h2>
		  <div class="feature">
		        <?php if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) { //only print this if form was updated ?>
			<form action="index.php" METHOD="POST" name="form2">
			<table align="center" class="table">
			  <tr valign="baseline">
				<td colspan="2" nowrap align="center">-----INSERT WAS A SUCCESS!----</td>
			  </tr>
			  <tr valign="baseline">
				<td><input type="submit" name="Status" value="GO BACK"  class="button"></td>
			  </tr>
			</table>
			</form>
			<?php } else { //print the update form?>
		  
			<form action="<?php echo $editFormAction; ?>" METHOD="POST" name="form1" name="form1" enctype="multipart/form-data">
			<table align="center" class="table">
			  <tr valign="baseline">
				<td nowrap align="right">* ChildID:</td>
				<td><input type="hidden" name="ChildID" value="" size="32" >will be created by computer!</td>
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
				<td nowrap align="right">* Gender:</td>
				<td><input type="text" class="textbox" name="Gender" value="Gender" size="32"></td>
				<td>Male or Female</td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* Grade:</td>
				<td><select name="Grade" >
				<option  class="textbox" value="Nursery" selected>Nursery&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="1YearOlds" >1YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="2YearOlds" >2YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="3YearOlds" >3YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="4YearOlds" >4YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="5YearOlds" >5YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="Kindergarten" >Kindergarten&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="1st_Grade" >1st_Grade&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="2nd_Grade" >2nd_Grade&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="3rd_Grade" >3rd_Grade&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="4th_Grade" >4th_Grade&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="5th_Grade" >5th_Grade&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="6th_Grade" >6th_Grade&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="7th_Grade" >7th_Grade&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="8th_Grade" >8th_Grade&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="9th_Grade" >9th_Grade&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="10th_Grade" >10th_Grade&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="11th_Grade" >11th_Grade&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="12th_Grade" >12th_Grade&nbsp;&nbsp;&nbsp;</option>
				</select></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* Birthday:</td>
				<td><input type="text" class="textbox" name="Birthday" value="mm/dd/yyyy" size="32"></td>
				<td>mm/dd/yyyy (critical format!)</td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* DateEntered:</td>
				<td><input type="hidden" class="textbox" name="DateEntered" value="<?php echo date('m/d/Y');?>" size="32"><?php echo date('m/d/Y');?></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">Status:</td>
				<td><input type="Hidden" class="textbox" name="Status" value="X" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">StatusChange:</td>
				<td><input type="Hidden" class="textbox" name="StatusChange" value="X" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* Allergies:</td>
				<td><input type="text" class="textbox" name="Allergies" value="none" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* Notes:</td>
				<td><input type="text" class="textbox" name="Notes" value="none" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">ParentID1:</td>
				<td><input type="text" class="textbox" name="ParentID1" value="" size="32"></td>
				<td>xxxx four digit number</td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">ParentID2:</td>
				<td><input type="text" class="textbox" name="ParentID2" value="" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">ParentID3:</td>
				<td><input type="text" class="textbox" name="ParentID3" value="" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">ParentID4:</td>
				<td><input type="text" class="textbox" name="ParentID4" value="" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td colspan="2" nowrap align="center">-----Junior High and High School Info----</td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">SmallGroup:</td>
				<td><input type="text" class="textbox" name="SmallGroup" value="" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">CellPhone:</td>
				<td><input type="text" class="textbox" name="CellPhone" value="" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">Email:</td>
				<td><input type="text" class="textbox" name="Email" value="" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">Twitter:</td>
				<td><input type="text" class="textbox" name="Twitter" value="" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">Instagram:</td>
				<td><input type="text" class="textbox" name="Instagram" value="" size="32"></td>
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


