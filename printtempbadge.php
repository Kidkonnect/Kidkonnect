<?php
$newgrade = "";
if($_POST['Grade']=='Nursery'){
  $newgrade="Nursery";
}
else if($_POST['Grade']=='1YearOlds'){
  $newgrade="Ones";
}
else if($_POST['Grade']=='2YearOlds'){
  $newgrade="Twos";
}
else if($_POST['Grade']=='3YearOlds'){
  $newgrade="Threes";
}
else if($_POST['Grade']=='4YearOlds'){
  $newgrade="Fours";
}
else if($_POST['Grade']=='5YearOlds'){
  $newgrade="Fives";
}
else{
  $newgrade=$_POST['Grade'];
}
//echo '1';
?>
<?php //$randomchars = rand_str();  ?>
    <table width="480" height="240" border="0" class="table" >
      <tr>
        <td colspan="2" align="left"><?php echo '<img width="115" height="90" src="/ChildPictures/0.jpg">';?></td>
        <td colspan="3" align="center"><h1><?php echo $_POST['FirstName'];?> <?php echo $_POST['LastName'];?> </h1><h2><?php echo $_POST['Birthday'];?> <?php echo $newgrade;?></h2></td>
        <td colspan="3" align="center"><?php echo '<IMG SRC="barcode.php?barcode=',$tempID, '&text=0">';?><h1><?php echo $tempID;?></h1></td>
      </tr>
      <tr>
	<td colspan="2" align="left"><?php echo '<img width="115" height="90" src="/ChildPictures/0.jpg">';?></td>
	<?php echo '<td colspan="6" align="center"><h1>Date: '.date('m/d/Y').'</h1></td>'; ?>
	<?php //if($_POST['ParentID3']!=''){echo '<td colspan="2"><img width="120" src="/ParentPictures/',$_POST['ParentID3'],'.jpg"></td>';} ?>
	<?php //if($_POST['ParentID4']!=''){echo '<td colspan="2"><img width="120" src="/ParentPictures/',$_POST['ParentID4'],'.jpg"></td>';} ?>
      </tr>
      <tr>
        <td colspan="2" align="center"><?php echo $_POST['PFirstName'];?> <?php echo $_POST['PLastName'];?> </td>
	<?php //if($_POST['ParentID2']!=''){getparentnames($_POST['ParentID2'], $database_dbs, $dbs);} ?>
	<?php //if($_POST['ParentID3']!=''){getparentnames($_POST['ParentID3'], $database_dbs, $dbs);} ?>
	<?php //if($_POST['ParentID4']!=''){getparentnames($_POST['ParentID4'], $database_dbs, $dbs);} ?>
      </tr>
<?php   //used to print black bar when child has allergies!
   if ($_POST['Allergies'] != 'none'){
      echo '<tr>';
        echo '<td colspan="8" align="left"><h1>'.$_POST['Allergies'].'</h1></td>';
      echo '</tr>';
   }?>
  </table>
    <table width="480" height="240" border="0" class="table" >
      <tr>
        <td colspan="2" align="left"><?php echo '<img width="115" height="90" src="/ChildPictures/0.jpg">';?></td>
        <td colspan="3" align="center"><h1><?php echo $_POST['FirstName'];?> <?php echo $_POST['LastName'];?> </h1><h2><?php echo $_POST['Birthday'];?> <?php echo $newgrade;?></h2></td>
        <td colspan="3" align="center"><?php echo '<IMG SRC="barcode.php?barcode=',$tempID, '&text=0">';?><h1><?php echo $tempID;?></h1></td>
      </tr>
      <tr>
	<td colspan="2" align="left"><?php echo '<img width="115" height="90" src="/ChildPictures/0.jpg">';?></td>
	<?php echo '<td colspan="6" align="center"><h1>Date: '.date('m/d/Y').'</h1></td>'; ?>
	<?php //if($_POST['ParentID3']!=''){echo '<td colspan="2"><img width="120" src="/ParentPictures/',$_POST['ParentID3'],'.jpg"></td>';} ?>
	<?php //if($_POST['ParentID4']!=''){echo '<td colspan="2"><img width="120" src="/ParentPictures/',$_POST['ParentID4'],'.jpg"></td>';} ?>
      </tr>
      <tr>
        <td colspan="2" align="center"><?php echo $_POST['PFirstName'];?> <?php echo $_POST['PLastName'];?> </td>
	<?php //if($_POST['ParentID2']!=''){getparentnames($_POST['ParentID2'], $database_dbs, $dbs);} ?>
	<?php //if($_POST['ParentID3']!=''){getparentnames($_POST['ParentID3'], $database_dbs, $dbs);} ?>
	<?php //if($_POST['ParentID4']!=''){getparentnames($_POST['ParentID4'], $database_dbs, $dbs);} ?>
      </tr>
<?php   //used to print black bar when child has allergies!
   if ($_POST['Allergies'] != 'none'){
      echo '<tr>';
        echo '<td colspan="8" align="left"><h1>'.$_POST['Allergies'].'</h1></td>';
      echo '</tr>';
   }?>
  </table>
