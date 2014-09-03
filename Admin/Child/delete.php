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
mysql_select_db($database_dbs, $dbs);
//SELECT * FROM foo WHERE b = 'abc' ORDER BY number ASC;
$query_Sort = sprintf("SELECT * FROM child WHERE ChildID='$passedChildID'"); 
//echo $query_Sort;
$Sort = mysql_query($query_Sort, $dbs) or die(mysql_error());
?>
<div id="web"><!--start web -->
<?php include ('/var/www/Templates/masterhead.php'); ?>
  <div id="content"> <!--start content -->
	  <div id="breadCrumb">
	  </div> 
		<h2 id="pageName">Are you sure that you want to delete child with an ID of <?php echo $passedChildID; ?> ?  <br> This will also remove this ChildID from all adults.</h2>
		  <div class="feature">
			<form action="" method="get">
				<table border="1" class="table">
				<tr>
				<td>Photo</td>
				<td>Delete</td>
				<td>ChildID</td>
				<td>FirstName</a></td>
				<td>LastName</td>
				<td>Address</td>       
				<td>City</td>
				<td>G</td>
				<td>Grade</td>
				<td>AgeGroup</td>
				<td>Birthday</td>
				<?php//<td>DateEntered&GradeSort=<?php echo $passedGrade">DateEntered</td>?>       
				<td>Status</td>
				<td>StatusChange</td>
				<td>Allergies</td>
				<td>PID1</td>       
				<td>PID2</td>
				<td>PID3</td>
				<td>PID4</td>        
				<td>Notes</td>
				<td>Child&nbsp;ID</td>
				</tr>

			<?php while ($row_Sort = mysql_fetch_assoc($Sort)) { ?>
				<tr>
				<td align="left" nowrap="true"><a href="/Admin/Child/edit.php?passedChildID=<?php echo $row_Sort['ChildID']; ?>"><img height="50" src="/ChildPictures/<?php echo $row_Sort['ChildID']; ?>.jpg"></a></td>
				<td align="left" nowrap="true"><a href="/Admin/Child/delete.php?passedChildID=<?php echo $row_Sort['ChildID']; ?>">delete</a></td>      
				<td align="left" nowrap="true"><a href="/Admin/Child/edit.php?passedChildID=<?php echo $row_Sort['ChildID']; ?>"><?php echo $row_Sort['ChildID']; ?></a>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['FirstName']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['LastName']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['Address']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['City']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['Gender']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['Grade']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['AgeGroup']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['Birthday']; ?>&nbsp;</td>
				<?php//<td align="left" nowrap="true"><?php echo $row_Sort['DateEntered']; &nbsp;</td>?>
				<td align="left" nowrap="true"><a href="/childinfo.php?passedChildID=<?php echo $row_Sort['ChildID']; ?>"><?php echo $row_Sort['Status']; ?></a>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['StatusChange']; ?>&nbsp;</td>
				<td align="left" width="75"><?php echo $row_Sort['Allergies']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/Admin/Parent/edit.php?passedParentID=<?php echo $row_Sort['ParentID1']; ?>"><?php if($row_Sort['ParentID1']!=""){echo '<img height="50" src="/ParentPictures/'.$row_Sort['ParentID1'].'.jpg"></a>';}?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/Admin/Parent/edit.php?passedParentID=<?php echo $row_Sort['ParentID2']; ?>"><?php if($row_Sort['ParentID2']!=""){echo '<img height="50" src="/ParentPictures/'.$row_Sort['ParentID2'].'.jpg"></a>';}?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/Admin/Parent/edit.php?passedParentID=<?php echo $row_Sort['ParentID3']; ?>"><?php if($row_Sort['ParentID3']!=""){echo '<img height="50" src="/ParentPictures/'.$row_Sort['ParentID3'].'.jpg"></a>';}?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/Admin/Parent/edit.php?passedParentID=<?php echo $row_Sort['ParentID4']; ?>"><?php if($row_Sort['ParentID4']!=""){echo '<img height="50" src="/ParentPictures/'.$row_Sort['ParentID4'].'.jpg"></a>';}?>&nbsp;</td>
				<td align="left" width="75"><?php echo $row_Sort['Notes']; ?>&nbsp;</td>
				<td align="left"><?php echo '<IMG SRC="/barcode.php?barcode=',$row_Sort['ChildID'], '&text=0&width=200&height=40">';?></td>
			</tr>
			
			<?php } ?>
				</table>
				<table width="100" border="0" class="table">
				<tr>
					<td><a href="actualdelete.php?passedChildID=<?php echo $_GET['passedChildID']; ?>">YES</a></td>
					<td><a href="index.php">NO</a></td>
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
		<?php include ('/var/www/Admin/adminrelatedlinks.php'); ?>
	  </div><!--end relatedLinks -->
  </div> <!--start sidebar -->
</div><!--end web -->

</body>
</html>


