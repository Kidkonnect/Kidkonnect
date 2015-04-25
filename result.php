<?php include ('/var/www/Templates/database.php'); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Sunnybrook Child Checkin </title>
<link rel="stylesheet" href="/scc.css" type="text/css" >
<link rel="stylesheet" href="/print.css" type="text/css" media="print">
<!-- Find what variable was set in the index.php file -->
<?php
//select the database 
if (isset($_POST['FirstName'])&&($_POST['FirstName']!='')&&(isset($_POST['LastName'])&&($_POST['LastName']!=''))) {
        //get child names
	$passedFirstNameC=$_POST['FirstName'];
	$passedLastNameC=$_POST['LastName'];
	mysql_select_db($database_dbs, $dbs);
	$query_SortC = "SELECT * FROM child WHERE FirstName LIKE '$passedFirstNameC%' AND LastName LIKE '$passedLastNameC%' ORDER BY FirstName, LastName ASC"; 
	$SortC = mysql_query($query_SortC, $dbs) or die(mysql_error());
	$totalRowsC = mysql_num_rows($SortC);
        //get parent names
	$passedFirstNameP=$_POST['FirstName'];
	$passedLastNameP=$_POST['LastName'];
	mysql_select_db($database_dbs, $dbs);
	$query_SortP = "SELECT * FROM parent WHERE FirstName LIKE '$passedFirstNameP%'  AND LastName LIKE '$passedLastNameP%' ORDER BY FirstName, LastName ASC"; 
	$SortP = mysql_query($query_SortP, $dbs) or die(mysql_error());
	$totalRowsP = mysql_num_rows($SortP);

}
else if (isset($_POST['FirstName'])&&($_POST['FirstName']!='')) {
        //get child names
	$passedFirstNameC=$_POST['FirstName'];
	mysql_select_db($database_dbs, $dbs);
	$query_SortC = "SELECT * FROM child WHERE FirstName LIKE '$passedFirstNameC%' ORDER BY FirstName, LastName ASC"; 
	$SortC = mysql_query($query_SortC, $dbs) or die(mysql_error());
	$totalRowsC = mysql_num_rows($SortC);
        //get parent names
	$passedFirstNameP=$_POST['FirstName'];
	mysql_select_db($database_dbs, $dbs);
	$query_SortP = "SELECT * FROM parent WHERE FirstName LIKE '$passedFirstNameP%' ORDER BY FirstName, LastName ASC"; 
	$SortP = mysql_query($query_SortP, $dbs) or die(mysql_error());
	$totalRowsP = mysql_num_rows($SortP);

}
else if (isset($_POST['LastName'])&&($_POST['LastName']!='')) {
        //get child names
	$passedLastNameC=$_POST['LastName'];
	mysql_select_db($database_dbs, $dbs);
	$query_SortC = "SELECT * FROM child WHERE LastName LIKE '$passedLastNameC%' ORDER BY LastName, FirstName ASC"; 
	$SortC = mysql_query($query_SortC, $dbs) or die(mysql_error());
	$totalRowsC = mysql_num_rows($SortC);
        //get parent names
	$passedLastNameP=$_POST['LastName'];
	mysql_select_db($database_dbs, $dbs);
	$query_SortP = "SELECT * FROM parent WHERE LastName LIKE '$passedLastNameP%' ORDER BY LastName, FirstName ASC"; 
	$SortP = mysql_query($query_SortP, $dbs) or die(mysql_error());
	$totalRowsP = mysql_num_rows($SortP);
}
else {
	$totalRows = 0;
}
?>
</head>
<body>
<div id="web"><!--start web -->
<?php include ('/var/www/Templates/masterhead.php'); ?>
  <div id="content"> <!--start content -->
	  <div id="breadCrumb">
	  </div> 
		<h2 id="pageName">Welcome to Sunnybrook Kids</h2>
		  <div class="feature">

		     <form action="" method="get">
			<table width="200" border="1" class="table">			
			<tr>
			   <td colspan="2" align="center"><h2> CHILD</h2></td>
			   <td colspan="2" align="center"><h2> VOLUNTEER / ADULT</h2></td>
			</tr>
			<tr>
			   <td colspan="2" nowrap><?php if($totalRowsC == 0){echo 'Could NOT find "'.$_POST['FirstName'].' '.$_POST['LastName']. '" in the Child database';}?></td>
			   <td colspan="2" nowrap><?php if($totalRowsP == 0){echo 'Could NOT find "'.$_POST['FirstName'].' '.$_POST['LastName']. '" in the Adult database';}?></td>
			</tr>
			<?php while (($totalRowsC > 0) || ($totalRowsP > 0)) { //keep printing while we still have rows?>
			<tr>
			  <?php if ($totalRowsC < 1) { ?> 
			    <td width="50">&nbsp;</td><td width="50">&nbsp;</td>
			  <?php } 
			  else { 
			    //print one child and check rows again
			    $totalRowsC--; //subtract one from totalrows 
			    $row_SortC = mysql_fetch_assoc($SortC);?> 
			    <td width="100" align="left"><?php echo '<a href="/childinfo.php?passedChildID=', $row_SortC['ChildID'], '"><img width="150" height="110" src = "/ChildPictures/', $row_SortC['ChildID'], '.jpg"><br>',$row_SortC['FirstName'],'&nbsp;',$row_SortC['LastName'], '</a>';?></a></td>
			    <?php if ($totalRowsC > 0) {
			    //print one child and check rows again
			    $totalRowsC--; //subtract one from totalrows 
			    $row_SortC = mysql_fetch_assoc($SortC);?> 
			    <td width="100" align="left"><?php echo '<a href="/childinfo.php?passedChildID=', $row_SortC['ChildID'], '"><img width="150" height="110" src = "/ChildPictures/', $row_SortC['ChildID'], '.jpg"><br>',$row_SortC['FirstName'],'&nbsp;',$row_SortC['LastName'], '</a>';?></a></td>
			    <?php } else {echo '<td width="50">&nbsp;</td>';} } ?> 

			  <?php if ($totalRowsP < 1) { ?> 
			    <td width="50">&nbsp;</td><td width="50">&nbsp;</td>
			  <?php } 
			  else { 
			    //print one child and check rows again
			    $totalRowsP--; //subtract one from totalrows 
			    $row_SortP = mysql_fetch_assoc($SortP);?> 
			    <td width="100" align="left"><?php echo '<a href="/parentinfo.php?passedParentID=', $row_SortP['ParentID'], '"><img width="150" height="110" src = "/ParentPictures/', $row_SortP['ParentID'], '.jpg"><br>', $row_SortP['FirstName'],'&nbsp;',$row_SortP['LastName'], '</a>';?></a></td>
			    <?php if ($totalRowsP > 0) {
			    //print one child and check rows again
			    $totalRowsP--; //subtract one from totalrows 
			    $row_SortP = mysql_fetch_assoc($SortP);?> 
			    <td width="100" align="left"><?php echo '<a href="/parentinfo.php?passedParentID=', $row_SortP['ParentID'], '"><img width="150" height="110" src = "/ParentPictures/', $row_SortP['ParentID'], '.jpg"><br>', $row_SortP['FirstName'],'&nbsp;',$row_SortP['LastName'], '</a>';?></a></td>
			    <?php } else {echo '<td width="50">&nbsp;</td>';} } ?> 

			</tr>
			 <?php } // end while?>
			
			</table>
		    </form>
		    <form ACTION= "/index.php"  METHOD="POST" name="index"> 
			<table width="200" border="0" class="table">			
			    <td><font>&nbsp;<input style="font-size: 28px;" type="submit" name="back" id="textbox" value="Back"></font></td>
			    </tr> 
			</table>
		    </form> 		
		  </div>
		  <!--end feature -->
	    </div> 
	  <!--end content -->
   <div id="sidebar" ><!--start sidebar -->
   	  <div class="relatedLinks"><!--start relatedLinks -->
        	<?php include ('/var/www/Templates/sidebar.php'); ?>
	  </div><!--end relatedLinks -->
  </div> <!--start sidebar -->
</div><!--end web -->

</body>
</html>


