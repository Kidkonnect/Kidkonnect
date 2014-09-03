<?php
function getparentnames($passedParentID, $database_dbs3, $dbs3){
//get the data from the parent
/*
mysql_select_db($database_tvt, $tvt);
$query_computerdata = sprintf("SELECT * FROM computerdata WHERE TerrahawkSN = '%s'", $colname_computerdata);
$computerdata = mysql_query($query_computerdata, $tvt) or die(mysql_error());
$row_computerdata = mysql_fetch_assoc($computerdata);
$totalRows_computerdata = mysql_num_rows($computerdata);
*/
	mysql_select_db($database_dbs3, $dbs3); //database already selected
	$query_Sort3 = "SELECT * FROM parent WHERE ParentID = '".$passedParentID."'"; 
	$Sort3 = mysql_query($query_Sort3, $dbs3) or die(mysql_error());
	$totalRows3 = mysql_num_rows($Sort3);
	$row_Sort3 = mysql_fetch_assoc($Sort3);
//Put the data on the sreen
  echo '<td colspan="2">', $row_Sort3['FirstName'], ' ', $row_Sort3['LastName'], '</td>';
  //echo $totalRows2;
  //echo $row_Sort3['FirstName'];
  //echo $row_Sort3['LastName'];

}
?>
<?php
$newgrade = "";
if($row_Sort['Grade']=='Nursery'){
  $newgrade="Nursery";
}
else if($row_Sort['Grade']=='1YearOlds'){
  $newgrade="Ones";
}
else if($row_Sort['Grade']=='2YearOlds'){
  $newgrade="Twos";
}
else if($row_Sort['Grade']=='3YearOlds'){
  $newgrade="Threes";
}
else if($row_Sort['Grade']=='4YearOlds'){
  $newgrade="Fours";
}
else if($row_Sort['Grade']=='5YearOlds'){
  $newgrade="Fives";
}
else{
  $newgrade=$row_Sort['Grade'];
}
?>
<?php $randomchars = rand_str();  ?>
    <table width="480" height="240" border="0" class="table" >
      <tr>
        <td colspan="2" align="left"><?php echo '<img width="120" src="/ChildPictures/', $row_Sort['ChildID'], '.jpg">';?></td>
        <td colspan="3" align="center"><h1><?php echo $row_Sort['FirstName'];?> <?php echo $row_Sort['LastName'];?> </h1><h2><?php echo $row_Sort['Birthday'];?> <?php echo $newgrade;?></h2></td>
        <td colspan="3" align="center"><?php echo '<IMG SRC="barcode.php?barcode=',$row_Sort['ChildID'], '&text=0">';?><h1><?php echo $row_Sort['ChildID'];?></h1></td>
      </tr>
      <tr>
	<?php if($row_Sort['ParentID1']!=''){echo '<td colspan="2"><img width="120" src="/ParentPictures/',$row_Sort['ParentID1'],'.jpg"></td>';} ?>
	<?php if($row_Sort['ParentID2']!=''){echo '<td colspan="2"><img width="120" src="/ParentPictures/',$row_Sort['ParentID2'],'.jpg"></td>';} ?>
	<?php if($row_Sort['ParentID3']!=''){echo '<td colspan="2"><img width="120" src="/ParentPictures/',$row_Sort['ParentID3'],'.jpg"></td>';} ?>
	<?php if($row_Sort['ParentID4']!=''){echo '<td colspan="2"><img width="120" src="/ParentPictures/',$row_Sort['ParentID4'],'.jpg"></td>';} ?>
      </tr>
      <tr>
	<?php if($row_Sort['ParentID1']!=''){getparentnames($row_Sort['ParentID1'], $database_dbs, $dbs);} ?>
	<?php if($row_Sort['ParentID2']!=''){getparentnames($row_Sort['ParentID2'], $database_dbs, $dbs);} ?>
	<?php if($row_Sort['ParentID3']!=''){getparentnames($row_Sort['ParentID3'], $database_dbs, $dbs);} ?>
	<?php if($row_Sort['ParentID4']!=''){getparentnames($row_Sort['ParentID4'], $database_dbs, $dbs);} ?>
      </tr>
<?php   //used to print black bar when child has allergies!
   if ($row_Sort['Allergies'] != 'none'){
      echo '<tr>';
        echo '<td colspan="8" align="left"><h1>'.$row_Sort['Allergies'].'</h1></td>';
      echo '</tr>';
   }?>
  </table>
