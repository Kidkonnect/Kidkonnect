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
//used to see if parent is allready in the data base.
function CheckParent($PFirstName, $PLastName, $Pdatabase_dbs, $Pdbs) {
  $Pquery_Sort = "SELECT * FROM parent WHERE LastName='$PLastName' And FirstName='$PFirstName' ORDER BY LastName ASC"; 
  mysql_select_db($Pdatabase_dbs, $Pdbs);
  $PSort = mysql_query($Pquery_Sort, $Pdbs) or die(mysql_error());
  $PtotalRows = mysql_num_rows($PSort);
  $Prow_Sort = mysql_fetch_assoc($PSort);
  return $Prow_Sort['ParentID']; 
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
//-------- give error if not Child 1 or Parent 1 ------------------//
   if ($_POST["P1FirstName"] == "") {
	//give error
	echo 'Parent One Name was not entered! There has to be at least one parent.';
	exit;
   }
   if ($_POST["C1FirstName"] == "") {
	//give error
	echo 'Child One Name was not entered! There has to be at least one child.';
	exit;
   }
//---------------- find next Parent ID ----------------------------//
//we assume that parentID in always new. ParentID2 3 4 may already be in the database so we need to check for them
$newParentID1 = 0;
$newParentID2 = 0;
$newParentID3 = 0;
$newParentID4 = 0;
$PID2 = 0;
$PID3 = 0;
$PID4 = 0;
$query_Sort = "SELECT * FROM parent ORDER BY ParentID ASC"; 
//echo $query_Sort;
mysql_select_db($database_dbs, $dbs);
$Sort = mysql_query($query_Sort, $dbs) or die(mysql_error());
$totalRows = mysql_num_rows($Sort);
$row_Sort = mysql_fetch_assoc($Sort);
//first we need to track the number of entries that are in the database
$count = 0;
//this while loop will stop at the last entry so we could add 1 to the Child ID!
   if ((isset($_POST["P1FirstName"])) && ($_POST["P1FirstName"] != "")) {
	while (($row_Sort = mysql_fetch_assoc($Sort)) && ($count < $totalRows - 1)) {
	$newParentID1 = $row_Sort['ParentID']; 
	}
	$newParentID1++;
	//CREATE NEW PICTURE 
  	$new_image_location = "/var/www/ParentPictures/".$newParentID1.".jpg";
	system("cp /var/www/ParentPictures/0.jpg $new_image_location");

   }
   if ((isset($_POST["P2FirstName"])) && ($_POST["P2FirstName"] != "")) {
	//check to see if allready there
	$PID2 = CheckParent($_POST["P2FirstName"], $_POST["P2LastName"],$database_dbs, $dbs);
	if ($PID2 != ""){
	  $newParentID2 = $PID2;
	}
	else{
	  $newParentID2 = $newParentID1+1;
	  //CREATE NEW PICTURE 
  	  $new_image_location = "/var/www/ParentPictures/".$newParentID2.".jpg";
	  system("cp /var/www/ParentPictures/0.jpg $new_image_location");
	}
   }
   if ((isset($_POST["P3FirstName"])) && ($_POST["P3FirstName"] != "")) {
	//check to see if allready there
	$PID3 = CheckParent($_POST["P3FirstName"], $_POST["P3LastName"],$database_dbs, $dbs);
	if ($PID3 != ""){
	  $newParentID3 = $PID3;
	}
	else{
	  $newParentID3 = $newParentID1+2;
	  //CREATE NEW PICTURE 
  	  $new_image_location = "/var/www/ParentPictures/".$newParentID3.".jpg";
	  system("cp /var/www/ParentPictures/0.jpg $new_image_location");
	}
   }
   if ((isset($_POST["P4FirstName"])) && ($_POST["P4FirstName"] != "")) {
	//check to see if allready there
	$PID4 = CheckParent($_POST["P4FirstName"], $_POST["P4LastName"],$database_dbs, $dbs);
	if ($PID4 != ""){
	  $newParentID4 = $PID4;
	}
	else{
	  $newParentID4 = $newParentID1+3;
	  //CREATE NEW PICTURE 
  	  $new_image_location = "/var/www/ParentPictures/".$newParentID4.".jpg";
	  system("cp /var/www/ParentPictures/0.jpg $new_image_location");
	}
   }
//echo '$newParentID1 = '.$newParentID1. '<br>';
//echo '$newParentID2 = '.$newParentID2. '<br>';
//echo '$newParentID3 = '.$newParentID3. '<br>';
//echo '$newParentID4 = '.$newParentID4. '<br>';
//---------------- find next Child ID1 ----------------------------//
   //if ((isset($_POST["C1FirstName"])) && ($_POST["C1FirstName"] != "")) {
	$newChildID1 = 0;
	//before we update we need to find the next ChildID from the data base.
	//we will do this by the year that was specified.
	$passedSort = "ChildID";
	//get birthday month day year 
	$birthday = $_POST['C1Birthday']; // format "mm/dd/yyyy"
	$lenght = strlen($birthday);
	$byear = substr($birthday, $lenght-2, 2);  // returns "yy"
	if (($byear == "yy")||($byear == "ne")){
	    exit("can not create ChildID from birthday of ($birthday)");
	}
	mysql_select_db($database_dbs, $dbs);
	$query_Sort = "SELECT * FROM child WHERE ChildID LIKE '$byear%' ORDER BY $passedSort ASC"; 
	$Sort = mysql_query($query_Sort, $dbs) or die(mysql_error());
	$totalRows = mysql_num_rows($Sort);
	$row_Sort = mysql_fetch_assoc($Sort);
	//first we need to track the number of entries that are in the database
	$count = 0;
	if ($row_Sort['ChildID'] == ''){
	$newChildID1 = $byear."00";
	}
	else{
	//special case of only one id
	$newChildID1 = $row_Sort['ChildID']; 
	$i = 0;
	//this while loop will stop at the last entry so we could add 1 to the Child ID!
	while (($row_Sort = mysql_fetch_assoc($Sort)) && (($newChildID1+1) == $row_Sort['ChildID'])) {
	$newChildID1 = $row_Sort['ChildID']; 
	//echo '<br> else CID = '.$row_Sort['ChildID'].'<br>';
	//echo $newChildID;
	$count++;
	//echo '<br>';
	}
	$newChildID1++; //add one to the previous childID
	//if childID is lenght of 3 then we need to add a zero to the front.
	if (strlen($newChildID1)==1){
	//add a zero to the front
	$newChildID1 = "000".$newChildID1;
	}
	else if (strlen($newChildID1)==2){
	//add a zero to the front
	$newChildID1 = "00".$newChildID1;
	}
	else if (strlen($newChildID1)==3){
	//add a zero to the front
	$newChildID1 = "0".$newChildID1;
	}
	}
	//CREATE NEW PICTURE 
  	$new_image_location = "/var/www/ChildPictures/".$newChildID1.".jpg";
	system("cp /var/www/ParentPictures/0.jpg $new_image_location");
	
	$insertSQL = sprintf("INSERT INTO child (ChildID, FirstName, LastName, Address, City, Gender, Grade, AgeGroup, Birthday, DateEntered, Status, StatusChange, Allergies, Notes, ParentID1, ParentID2, ParentID3, ParentID4) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
			GetSQLValueString($newChildID1, "text"),
			GetSQLValueString($_POST['C1FirstName'], "text"),
			GetSQLValueString($_POST['C1LastName'], "text"),
			GetSQLValueString($_POST['Address'], "text"),
			GetSQLValueString($_POST['City'], "text"),
			GetSQLValueString($_POST['C1Gender'], "text"),
			GetSQLValueString($_POST['C1Grade'], "text"),
			GetSQLValueString($_POST['C1AgeGroup'], "text"),
			GetSQLValueString($_POST['C1Birthday'], "text"),
			GetSQLValueString($_POST['DateEntered'], "text"),
			GetSQLValueString($_POST['Status'], "text"),
			GetSQLValueString($_POST['StatusChange'], "text"),
			GetSQLValueString($_POST['C1Allergies'], "text"),
			GetSQLValueString($_POST['C1Notes'], "text"),
			GetSQLValueString($newParentID1, "text"),
			GetSQLValueString($newParentID2, "text"),
			GetSQLValueString($newParentID3, "text"),
			GetSQLValueString($newParentID4, "text"));
	
	mysql_select_db($database_dbs, $dbs);
	$Result1 = mysql_query($insertSQL, $dbs) or die(mysql_error()); 
   //}
//---------------- find next Child ID2 ----------------------------//
   if ((isset($_POST["C2FirstName"])) && ($_POST["C2FirstName"] != "")) {
	$newChildID2 = "x";
	//before we update we need to find the next ChildID from the data base.
	//we will do this by the year that was specified.
	$passedSort = "ChildID";
	//get birthday month day year 
	$birthday = $_POST['C2Birthday']; // format "mm/dd/yyyy"
	$lenght = strlen($birthday);
	$byear = substr($birthday, $lenght-2, 2);  // returns "yy"
	if (($byear == "yy")||($byear == "ne")){
	    exit("can not create ChildID from birthday of ($birthday)");
	}	
	mysql_select_db($database_dbs, $dbs);
	$query_Sort = "SELECT * FROM child WHERE ChildID LIKE '$byear%' ORDER BY $passedSort ASC"; 
	$Sort = mysql_query($query_Sort, $dbs) or die(mysql_error());
	$totalRows = mysql_num_rows($Sort);
	$row_Sort = mysql_fetch_assoc($Sort);
	//first we need to track the number of entries that are in the database
	$count = 0;
	$count = 0;
	if ($row_Sort['ChildID'] == ''){
	$newChildID3 = $byear."00";
	}
	else{
	//special case of only one id
	$newChildID2 = $row_Sort['ChildID']; 
	//this while loop will stop at the last entry so we could add 1 to the Child ID!
	while (($row_Sort = mysql_fetch_assoc($Sort)) && (($newChildID2+1) == $row_Sort['ChildID'])) {
	$newChildID2 = $row_Sort['ChildID']; 
	//echo '<br> else CID = '.$row_Sort['ChildID'].'<br>';
	//echo $newChildID;
	$count++;
	//echo '<br>';
	}
	$newChildID2++; //add one to the previous childID
	//if childID is lenght of 3 then we need to add a zero to the front.
	if (strlen($newChildID2)==1){
	//add a zero to the front
	$newChildID2 = "000".$newChildID2;
	}
	else if (strlen($newChildID2)==2){
	//add a zero to the front
	$newChildID2 = "00".$newChildID2;
	}
	else if (strlen($newChildID2)==3){
	//add a zero to the front
	$newChildID2 = "0".$newChildID2;
	}
	}
	//CREATE NEW PICTURE 
  	$new_image_location = "/var/www/ChildPictures/".$newChildID2.".jpg";
	system("cp /var/www/ParentPictures/0.jpg $new_image_location");	
	
	$insertSQL = sprintf("INSERT INTO child (ChildID, FirstName, LastName, Address, City, Gender, Grade, AgeGroup, Birthday, DateEntered, Status, StatusChange, Allergies, Notes, ParentID1, ParentID2, ParentID3, ParentID4) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
			GetSQLValueString($newChildID2, "text"),
			GetSQLValueString($_POST['C2FirstName'], "text"),
			GetSQLValueString($_POST['C2LastName'], "text"),
			GetSQLValueString($_POST['Address'], "text"),
			GetSQLValueString($_POST['City'], "text"),
			GetSQLValueString($_POST['C2Gender'], "text"),
			GetSQLValueString($_POST['C2Grade'], "text"),
			GetSQLValueString($_POST['C2AgeGroup'], "text"),
			GetSQLValueString($_POST['C2Birthday'], "text"),
			GetSQLValueString($_POST['DateEntered'], "text"),
			GetSQLValueString($_POST['Status'], "text"),
			GetSQLValueString($_POST['StatusChange'], "text"),
			GetSQLValueString($_POST['C2Allergies'], "text"),
			GetSQLValueString($_POST['C2Notes'], "text"),
			GetSQLValueString($newParentID1, "text"),
			GetSQLValueString($newParentID2, "text"),
			GetSQLValueString($newParentID3, "text"),
			GetSQLValueString($newParentID4, "text"));
	
	mysql_select_db($database_dbs, $dbs);
	$Result1 = mysql_query($insertSQL, $dbs) or die(mysql_error()); 
   } 
//---------------- find next Child ID3 ----------------------------//
   if ((isset($_POST["C3FirstName"])) && ($_POST["C3FirstName"] != "")) {
	$newChildID3 = "x";
	//before we update we need to find the next ChildID from the data base.
	//we will do this by the year that was specified.
	$passedSort = "ChildID";
	//get birthday month day year 
	$birthday = $_POST['C3Birthday']; // format "mm/dd/yyyy"
	$lenght = strlen($birthday);
	$byear = substr($birthday, $lenght-2, 2);  // returns "yy"
	if (($byear == "yy")||($byear == "ne")){
	    exit("can not create ChildID from birthday of ($birthday)");
	}	
	mysql_select_db($database_dbs, $dbs);
	$query_Sort = "SELECT * FROM child WHERE ChildID LIKE '$byear%' ORDER BY $passedSort ASC"; 
	$Sort = mysql_query($query_Sort, $dbs) or die(mysql_error());
	$totalRows = mysql_num_rows($Sort);
	$row_Sort = mysql_fetch_assoc($Sort);
	//first we need to track the number of entries that are in the database
	$count = 0;
	$count = 0;
	if ($row_Sort['ChildID'] == ''){
	$newChildID3 = $byear."00";
	}
	else{
	//special case of only one id
	$newChildID3 = $row_Sort['ChildID']; 
	//this while loop will stop at the last entry so we could add 1 to the Child ID!
	while (($row_Sort = mysql_fetch_assoc($Sort)) && (($newChildID3+1) == $row_Sort['ChildID'])) {
	$newChildID3 = $row_Sort['ChildID']; 
	//echo '<br> else CID = '.$row_Sort['ChildID'].'<br>';
	//echo $newChildID;
	$count++;
	//echo '<br>';
	}
	$newChildID3++; //add one to the previous childID
	//if childID is lenght of 3 then we need to add a zero to the front.
	if (strlen($newChildID3)==1){
	//add a zero to the front
	$newChildID3 = "000".$newChildID3;
	}
	else if (strlen($newChildID3)==2){
	//add a zero to the front
	$newChildID3 = "00".$newChildID3;
	}
	else if (strlen($newChildID3)==3){
	//add a zero to the front
	$newChildID3 = "0".$newChildID3;
	}
	}
	//CREATE NEW PICTURE 
  	$new_image_location = "/var/www/ChildPictures/".$newChildID3.".jpg";
	system("cp /var/www/ParentPictures/0.jpg $new_image_location");	
	
	$insertSQL = sprintf("INSERT INTO child (ChildID, FirstName, LastName, Address, City, Gender, Grade, AgeGroup, Birthday, DateEntered, Status, StatusChange, Allergies, Notes, ParentID1, ParentID2, ParentID3, ParentID4) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
			GetSQLValueString($newChildID3, "text"),
			GetSQLValueString($_POST['C3FirstName'], "text"),
			GetSQLValueString($_POST['C3LastName'], "text"),
			GetSQLValueString($_POST['Address'], "text"),
			GetSQLValueString($_POST['City'], "text"),
			GetSQLValueString($_POST['C3Gender'], "text"),
			GetSQLValueString($_POST['C3Grade'], "text"),
			GetSQLValueString($_POST['C3AgeGroup'], "text"),
			GetSQLValueString($_POST['C3Birthday'], "text"),
			GetSQLValueString($_POST['DateEntered'], "text"),
			GetSQLValueString($_POST['Status'], "text"),
			GetSQLValueString($_POST['StatusChange'], "text"),
			GetSQLValueString($_POST['C3Allergies'], "text"),
			GetSQLValueString($_POST['C3Notes'], "text"),
			GetSQLValueString($newParentID1, "text"),
			GetSQLValueString($newParentID2, "text"),
			GetSQLValueString($newParentID3, "text"),
			GetSQLValueString($newParentID4, "text"));
	
	mysql_select_db($database_dbs, $dbs);
	$Result1 = mysql_query($insertSQL, $dbs) or die(mysql_error()); 
   }
//---------------- find next Child ID4 ----------------------------//
   if ((isset($_POST["C4FirstName"])) && ($_POST["C4FirstName"] != "")) {
	$newChildID4 = "x";
	//before we update we need to find the next ChildID from the data base.
	//we will do this by the year that was specified.
	$passedSort = "ChildID";
	//get birthday month day year 
	$birthday = $_POST['C4Birthday']; // format "mm/dd/yyyy"
	$lenght = strlen($birthday);
	$byear = substr($birthday, $lenght-2, 2);  // returns "yy"
	if (($byear == "yy")||($byear == "ne")){
	    exit("can not create ChildID from birthday of ($birthday)");
	}	
	mysql_select_db($database_dbs, $dbs);
	$query_Sort = "SELECT * FROM child WHERE ChildID LIKE '$byear%' ORDER BY $passedSort ASC"; 
	$Sort = mysql_query($query_Sort, $dbs) or die(mysql_error());
	$totalRows = mysql_num_rows($Sort);
	$row_Sort = mysql_fetch_assoc($Sort);
	//first we need to track the number of entries that are in the database
	$count = 0;
	$count = 0;
	if ($row_Sort['ChildID'] == ''){
	$newChildID4 = $byear."00";
	}
	else{
	//special case of only one id
	$newChildID4 = $row_Sort['ChildID']; 
	//this while loop will stop at the last entry so we could add 1 to the Child ID!
	while (($row_Sort = mysql_fetch_assoc($Sort)) && (($newChildID4+1) == $row_Sort['ChildID'])) {
	$newChildID4 = $row_Sort['ChildID']; 
	//echo '<br> else CID = '.$row_Sort['ChildID'].'<br>';
	//echo $newChildID;
	$count++;
	//echo '<br>';
	}
	$newChildID4++; //add one to the previous childID
	//if childID is lenght of 3 then we need to add a zero to the front.
	if (strlen($newChildID4)==1){
	//add a zero to the front
	$newChildID4 = "000".$newChildID4;
	}
	else if (strlen($newChildID4)==2){
	//add a zero to the front
	$newChildID4 = "00".$newChildID4;
	}
	else if (strlen($newChildID4)==3){
	//add a zero to the front
	$newChildID4 = "0".$newChildID4;
	}
	}
	//CREATE NEW PICTURE 
  	$new_image_location = "/var/www/ChildPictures/".$newChildID4.".jpg";
	system("cp /var/www/ParentPictures/0.jpg $new_image_location");	
	
	$insertSQL = sprintf("INSERT INTO child (ChildID, FirstName, LastName, Address, City, Gender, Grade, AgeGroup, Birthday, DateEntered, Status, StatusChange, Allergies, Notes, ParentID1, ParentID2, ParentID3, ParentID4) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
			GetSQLValueString($newChildID4, "text"),
			GetSQLValueString($_POST['C4FirstName'], "text"),
			GetSQLValueString($_POST['C4LastName'], "text"),
			GetSQLValueString($_POST['Address'], "text"),
			GetSQLValueString($_POST['City'], "text"),
			GetSQLValueString($_POST['C4Gender'], "text"),
			GetSQLValueString($_POST['C4Grade'], "text"),
			GetSQLValueString($_POST['C4AgeGroup'], "text"),
			GetSQLValueString($_POST['C4Birthday'], "text"),
			GetSQLValueString($_POST['DateEntered'], "text"),
			GetSQLValueString($_POST['Status'], "text"),
			GetSQLValueString($_POST['StatusChange'], "text"),
			GetSQLValueString($_POST['C4Allergies'], "text"),
			GetSQLValueString($_POST['C4Notes'], "text"),
			GetSQLValueString($newParentID1, "text"),
			GetSQLValueString($newParentID2, "text"),
			GetSQLValueString($newParentID3, "text"),
			GetSQLValueString($newParentID4, "text"));
	
	mysql_select_db($database_dbs, $dbs);
	$Result1 = mysql_query($insertSQL, $dbs) or die(mysql_error()); 
   }
   //if ((isset($_POST["P1FirstName"])) && ($_POST["P1FirstName"] != "")) {
	$insertSQL = sprintf("INSERT INTO parent (ParentID, FirstName, LastName, Address, City, HomePhone, CellPhone1, Email, ChildID1, ChildID2, ChildID3, ChildID4) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
			GetSQLValueString($newParentID1, "text"),
			GetSQLValueString($_POST['P1FirstName'], "text"),
			GetSQLValueString($_POST['P1LastName'], "text"),
			GetSQLValueString($_POST['Address'], "text"),
			GetSQLValueString($_POST['City'], "text"),
			GetSQLValueString($_POST['P1HomePhone'], "text"),
			GetSQLValueString($_POST['P1CellPhone1'], "text"),
			GetSQLValueString($_POST['P1Email'], "text"),
			GetSQLValueString($newChildID1, "text"),
			GetSQLValueString($newChildID2, "text"),
			GetSQLValueString($newChildID3, "text"),
			GetSQLValueString($newChildID4, "text"));
	
	mysql_select_db($database_dbs, $dbs);
	$Result1 = mysql_query($insertSQL, $dbs) or die(mysql_error()); 
   //}
   if ((isset($_POST["P2FirstName"])) && ($_POST["P2FirstName"] != "") && ($PID2 == 0)) {
	$insertSQL = sprintf("INSERT INTO parent (ParentID, FirstName, LastName, Address, City, HomePhone, CellPhone1, Email, ChildID1, ChildID2, ChildID3, ChildID4) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
			GetSQLValueString($newParentID2, "text"),
			GetSQLValueString($_POST['P2FirstName'], "text"),
			GetSQLValueString($_POST['P2LastName'], "text"),
			GetSQLValueString($_POST['Address'], "text"),
			GetSQLValueString($_POST['City'], "text"),
			GetSQLValueString($_POST['P2HomePhone'], "text"),
			GetSQLValueString($_POST['P2CellPhone1'], "text"),
			GetSQLValueString($_POST['P2Email'], "text"),
			GetSQLValueString($newChildID1, "text"),
			GetSQLValueString($newChildID2, "text"),
			GetSQLValueString($newChildID3, "text"),
			GetSQLValueString($newChildID4, "text"));
	
	mysql_select_db($database_dbs, $dbs);
	$Result1 = mysql_query($insertSQL, $dbs) or die(mysql_error()); 
   }
   //else update 
   else {

   }

   if ((isset($_POST["P3FirstName"])) && ($_POST["P3FirstName"] != "") && ($PID3 == 0)) {
	$insertSQL = sprintf("INSERT INTO parent (ParentID, FirstName, LastName, Address, City, HomePhone, CellPhone1, Email, ChildID1, ChildID2, ChildID3, ChildID4) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
			GetSQLValueString($newParentID3, "text"),
			GetSQLValueString($_POST['P3FirstName'], "text"),
			GetSQLValueString($_POST['P3LastName'], "text"),
			GetSQLValueString($_POST['Address'], "text"),
			GetSQLValueString($_POST['City'], "text"),
			GetSQLValueString($_POST['P3HomePhone'], "text"),
			GetSQLValueString($_POST['P3CellPhone1'], "text"),
			GetSQLValueString($_POST['P3Email'], "text"),
			GetSQLValueString($newChildID1, "text"),
			GetSQLValueString($newChildID2, "text"),
			GetSQLValueString($newChildID3, "text"),
			GetSQLValueString($newChildID4, "text"));
	
	mysql_select_db($database_dbs, $dbs);
	$Result1 = mysql_query($insertSQL, $dbs) or die(mysql_error()); 
   }
   //else update 
   else {

   }

   if ((isset($_POST["P4FirstName"])) && ($_POST["P4FirstName"] != "") && ($PID4 == 0)) {
	$insertSQL = sprintf("INSERT INTO parent (ParentID, FirstName, LastName, Address, City, HomePhone, CellPhone1, Email, ChildID1, ChildID2, ChildID3, ChildID4) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
			GetSQLValueString($newParentID4, "text"),
			GetSQLValueString($_POST['P4FirstName'], "text"),
			GetSQLValueString($_POST['P4LastName'], "text"),
			GetSQLValueString($_POST['Address'], "text"),
			GetSQLValueString($_POST['City'], "text"),
			GetSQLValueString($_POST['P4HomePhone'], "text"),
			GetSQLValueString($_POST['P4CellPhone1'], "text"),
			GetSQLValueString($_POST['P4Email'], "text"),
			GetSQLValueString($newChildID1, "text"),
			GetSQLValueString($newChildID2, "text"),
			GetSQLValueString($newChildID3, "text"),
			GetSQLValueString($newChildID4, "text"));
	
	mysql_select_db($database_dbs, $dbs);
	$Result1 = mysql_query($insertSQL, $dbs) or die(mysql_error()); 
   }
   //else update 
   else {

   }

  //Now we need to email Staff members of new people that have entered information into the database
  //this requires "sudo apt-get install sendmail" 
   $to      = 'mikehenson@hotmail.com, patti@sunnybrookcc.org';
   $subject = 'New Visitor to Sunnybrook';
   $message = '
This information was added on '.date('m/d/Y').'
Parent1 Name:'.$_POST['P1FirstName'].' '.$_POST['P1LastName'].'
Parent1 ID and email:'.$newParentID1.' and '.$_POST['P1Email'].'
Child1 Name:'.$_POST['C1FirstName'].' '.$_POST['C1LastName'].'
Child1 ID:'.$newChildID1.'
Other Parents and Children are not included because they are not required to be entered.
Please Check the Admin section of http://192.168.12.158/
';
   $headers = 'From: noreply@kidkonnect.org' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

   mail($to, $subject, $message, $headers);

  //echo '<meta HTTP-EQUIV="REFRESH" content="0; url=http://192.168.12.158/">';

}
?>
<div id="web"><!--start web -->
<?php include ('/var/www/Templates/masterhead.php'); ?>
  <div id="content"> <!--start content -->
	  <div id="breadCrumb">
	  </div> 
		<h2 id="pageName">Welcome to Sunnybrook!</h2>
		  <div class="feature">
			<form action="<?php echo $editFormAction; ?>" METHOD="POST" name="form1">
			<table align="center" class="table">
			  <tr><TD colspan="3"><b>Family Information</b></TD></tr>
			  <tr valign="baseline">
				<td nowrap align="right">* LastName:</td>
				<td><input type="text" class="textbox" name="LastName" value="" size="32"></td>
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
				<td nowrap align="right">* DateEntered:</td>
				<td><input type="hidden" class="textbox" name="DateEntered" value="<?php echo date('m/d/Y');?>" size="32"><?php echo date('m/d/Y');?></td>
			  </tr>
			  <tr valign="baseline">
				<td><input type="Hidden" class="textbox" name="Status" value="X" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td><input type="Hidden" class="textbox" name="StatusChange" value="X" size="32"></td>
			  </tr>

			  <tr><TD colspan="4" bgcolor="Gray">&nbsp;</TD></tr>
			  <tr><TD colspan="4"><b>Child 1 Information</b></TD></tr>
			  <tr valign="baseline">
				<td nowrap align="right">* FirstName:</td>
				<td><input type="text" class="textbox" name="C1FirstName" value="" size="32"></td>

				<td nowrap align="right">* LastName:</td>
				<td><input type="text" class="textbox" name="C1LastName" value="" size="32"></td>
			  </tr>

			  <tr valign="baseline">
				<td nowrap align="right">* Gender:</td>
				<td><input type="text" class="textbox" name="C1Gender" value="Male or Female" size="32"></td>

				<td nowrap align="right">* Grade:</td>
				<td><select name="C1Grade" >
				<option  class="textbox" value="Nursery" selected>Nursery&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="1YearOlds" >1YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="2YearOlds" >2YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="3YearOlds" >3YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="4YearOlds" >4YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="5YearOlds" >5YearOlds&nbsp;&nbsp;&nbsp;</option>
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
				<td><input type="text" class="textbox" name="C1Birthday" value="mm/dd/yyyy" size="32"></td>
				
				<td nowrap align="right">* AgeGroup:</td>
				<td><select name="C1AgeGroup" >
				<option  class="textbox" value="N-K" selected>N-K&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="1-5" >1-5&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="6-8" >6-8&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="9-12" >9-12&nbsp;&nbsp;&nbsp;</option>
				</select></td>
			  </tr>

			  <tr valign="baseline">
				<td nowrap align="right">* Allergies:</td>
				<td><input type="text" class="textbox" name="C1Allergies" value="none" size="32"></td>

				<td nowrap align="right">* Notes:</td>
				<td><input type="text" class="textbox" name="C1Notes" value="none" size="32"></td>
			  </tr>

			  <tr><TD colspan="4" bgcolor="Gray">&nbsp;</TD></tr>
			  <tr><TD colspan="4"><b>Child 2 Information</b></TD></tr>
			  <tr valign="baseline">
				<td nowrap align="right">* FirstName:</td>
				<td><input type="text" class="textbox" name="C2FirstName" value="" size="32"></td>

				<td nowrap align="right">* LastName:</td>
				<td><input type="text" class="textbox" name="C2LastName" value="" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* Gender:</td>
				<td><input type="text" class="textbox" name="C2Gender" value="Male or Female" size="32"></td>

				<td nowrap align="right">* Grade:</td>
				<td><select name="C2Grade" >
				<option  class="textbox" value="Nursery" selected>Nursery&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="1YearOlds" >1YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="2YearOlds" >2YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="3YearOlds" >3YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="4YearOlds" >4YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="5YearOlds" >5YearOlds&nbsp;&nbsp;&nbsp;</option>
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
				<td><input type="text" class="textbox" name="C2Birthday" value="mm/dd/yyyy" size="32"></td>
				
				<td nowrap align="right">* AgeGroup:</td>
				<td><select name="C2AgeGroup" >
				<option  class="textbox" value="N-K" selected>N-K&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="1-5" >1-5&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="6-8" >6-8&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="9-12" >9-12&nbsp;&nbsp;&nbsp;</option>
				</select></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* Allergies:</td>
				<td><input type="text" class="textbox" name="C2Allergies" value="none" size="32"></td>

				<td nowrap align="right">* Notes:</td>
				<td><input type="text" class="textbox" name="C2Notes" value="none" size="32"></td>
			  </tr>

			  <tr><TD colspan="4" bgcolor="Gray">&nbsp;</TD></tr>
			  <tr><TD colspan="4"><b>Child 3 Information</b></TD></tr>
			  <tr valign="baseline">
				<td nowrap align="right">* FirstName:</td>
				<td><input type="text" class="textbox" name="C3FirstName" value="" size="32"></td>

				<td nowrap align="right">* LastName:</td>
				<td><input type="text" class="textbox" name="C3LastName" value="" size="32"></td>
			  </tr>

			  <tr valign="baseline">
				<td nowrap align="right">* Gender:</td>
				<td><input type="text" class="textbox" name="C3Gender" value="Male or Female" size="32"></td>

				<td nowrap align="right">* Grade:</td>
				<td><select name="C3Grade" >
				<option  class="textbox" value="Nursery" selected>Nursery&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="1YearOlds" >1YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="2YearOlds" >2YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="3YearOlds" >3YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="4YearOlds" >4YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="5YearOlds" >5YearOlds&nbsp;&nbsp;&nbsp;</option>
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
				<td><input type="text" class="textbox" name="C3Birthday" value="mm/dd/yyyy" size="32"></td>
				
				<td nowrap align="right">* AgeGroup:</td>
				<td><select name="C3AgeGroup" >
				<option  class="textbox" value="N-K" selected>N-K&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="1-5" >1-5&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="6-8" >6-8&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="9-12" >9-12&nbsp;&nbsp;&nbsp;</option>
				</select></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* Allergies:</td>
				<td><input type="text" class="textbox" name="C3Allergies" value="none" size="32"></td>

				<td nowrap align="right">* Notes:</td>
				<td><input type="text" class="textbox" name="C3Notes" value="none" size="32"></td>
			  </tr>

			  <tr><TD colspan="4" bgcolor="Gray">&nbsp;</TD></tr>
			  <tr><TD colspan="4"><b>Child 4 Information</b></TD></tr>
			  <tr valign="baseline">
				<td nowrap align="right">* FirstName:</td>
				<td><input type="text" class="textbox" name="C4FirstName" value="" size="32"></td>

				<td nowrap align="right">* LastName:</td>
				<td><input type="text" class="textbox" name="C4LastName" value="" size="32"></td>
			  </tr>

			  <tr valign="baseline">
				<td nowrap align="right">* Gender:</td>
				<td><input type="text" class="textbox" name="C4Gender" value="Male or Female" size="32"></td>

				<td nowrap align="right">* Grade:</td>
				<td><select name="C4Grade" >
				<option  class="textbox" value="Nursery" selected>Nursery&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="1YearOlds" >1YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="2YearOlds" >2YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="3YearOlds" >3YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="4YearOlds" >4YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="5YearOlds" >5YearOlds&nbsp;&nbsp;&nbsp;</option>
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
				<td><input type="text" class="textbox" name="C4Birthday" value="mm/dd/yyyy" size="32"></td>
				
				<td nowrap align="right">* AgeGroup:</td>
				<td><select name="C4AgeGroup" >
				<option  class="textbox" value="N-K" selected>N-K&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="1-5" >1-5&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="6-8" >6-8&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="9-12" >9-12&nbsp;&nbsp;&nbsp;</option>
				</select></td>
			  </tr>

			  <tr valign="baseline">
				<td nowrap align="right">* Allergies:</td>
				<td><input type="text" class="textbox" name="C4Allergies" value="none" size="32"></td>

				<td nowrap align="right">* Notes:</td>
				<td><input type="text" class="textbox" name="C4Notes" value="none" size="32"></td>
			  </tr>

			  <tr><TD colspan="4" bgcolor="Gray">&nbsp;</TD></tr>
			  <tr><TD colspan="4"><b>Parent 1 Information</b></TD></tr>
			  <tr valign="baseline">
				<td nowrap align="right">* FirstName:</td>
				<td><input type="text" class="textbox" name="P1FirstName" value="" size="32"></td>

				<td nowrap align="right">* LastName:</td>
				<td><input type="text" class="textbox" name="P1LastName" value="" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* HomePhone:</td>
				<td><input type="text" class="textbox" name="P1HomePhone" value="none" size="32"></td>

				<td nowrap align="right">* CellPhone1:</td>
				<td><input type="text" class="textbox" name="P1CellPhone1" value="none" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* Email:</td>
				<td><input type="text" class="textbox" name="P1Email" value="none" size="32"></td>
			  </tr>

			  <tr><TD colspan="4" bgcolor="Gray">&nbsp;</TD></tr>
			  <tr><TD colspan="4"><b>Parent 2 Information</b></TD></tr>
			  <tr valign="baseline">
				<td nowrap align="right">* FirstName:</td>
				<td><input type="text" class="textbox" name="P2FirstName" value="" size="32"></td>
				<td nowrap align="right">* LastName:</td>
				<td><input type="text" class="textbox" name="P2LastName" value="" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* HomePhone:</td>
				<td><input type="text" class="textbox" name="P2HomePhone" value="none" size="32"></td>

				<td nowrap align="right">* CellPhone1:</td>
				<td><input type="text" class="textbox" name="P2CellPhone1" value="none" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* Email:</td>
				<td><input type="text" class="textbox" name="P2Email" value="none" size="32"></td>
			  </tr>

			  <tr><TD colspan="4" bgcolor="Gray">&nbsp;</TD></tr>
			  <tr><TD colspan="4"><b>Parent 3 Information</b></TD></tr>
			  <tr valign="baseline">
				<td nowrap align="right">* FirstName:</td>
				<td><input type="text" class="textbox" name="P3FirstName" value="" size="32"></td>
				<td nowrap align="right">* LastName:</td>
				<td><input type="text" class="textbox" name="P3LastName" value="" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* HomePhone:</td>
				<td><input type="text" class="textbox" name="P3HomePhone" value="none" size="32"></td>

				<td nowrap align="right">* CellPhone1:</td>
				<td><input type="text" class="textbox" name="P3CellPhone1" value="none" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* Email:</td>
				<td><input type="text" class="textbox" name="P3Email" value="none" size="32"></td>
			  </tr>

			  <tr><TD colspan="4" bgcolor="Gray">&nbsp;</TD></tr>
			  <tr><TD colspan="4"><b>Parent 4 Information</b></TD></tr>
			  <tr valign="baseline">
				<td nowrap align="right">* FirstName:</td>
				<td><input type="text" class="textbox" name="P4FirstName" value="" size="32"></td>
				<td nowrap align="right">* LastName:</td>
				<td><input type="text" class="textbox" name="P4LastName" value="" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* HomePhone:</td>
				<td><input type="text" class="textbox" name="P4HomePhone" value="none" size="32"></td>

				<td nowrap align="right">* CellPhone1:</td>
				<td><input type="text" class="textbox" name="P4CellPhone1" value="none" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* Email:</td>
				<td><input type="text" class="textbox" name="P4Email" value="none" size="32"></td>
			  </tr>
			  <tr><TD colspan="4" bgcolor="Gray">&nbsp;</TD></tr>
			  <tr valign="baseline">
				<td nowrap align="right">&nbsp;</td>
				<td><input type="submit" value="Insert Record" class="button"></td>
			  </tr>

			</table>
			<input type="hidden" name="MM_insert" value="form1">  </form>

		<SCRIPT language="JavaScript">
			document.form1.LastName.focus();
		</SCRIPT> 
		

		  </div>
		  <!--end feature -->
	    </div> 
	  <!--end content -->
   <div id="sidebar" ><!--start sidebar -->
   	  <div class="relatedLinks"><!--start relatedLinks -->
        	<?php include ('/var/www/Templates/sidebar.php'); ?>
		<?php //include ('/var/www/Admin/adminrelatedlinks.php'); ?>
	  </div><!--end relatedLinks -->
  </div> <!--start sidebar -->
</div><!--end web -->

</body>
</html>


