<?php include ('/var/www/Templates/database.php'); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Sunnybrook Child Checkin </title>
<link rel="stylesheet" href="/scc.css" type="text/css" >
<link rel="stylesheet" href="/print.css" type="text/css" media="print">

</head>
<body>
<div id="web"><!--start web -->
<?php include ('/var/www/Templates/masterhead.php'); ?>
  <div id="content"> <!--start content -->
	<h2 id="pageName">Welcome to Sunnybrook Kids</h2>
		<table class="table"> 
		<form ACTION= "/result.php"  METHOD="POST" name="searchfield"> 
		
			<tr><td width="150">First Name   <br></td><td><input name="FirstName" id="textbox" value="" type="text" size=26></td>
			    </tr> 
			<tr><td width="150">Last Name    <br></td><td><input name="LastName"  id="textbox" value="" type="text" size=26></td>
			    </tr>
			<tr>
  			    <td>&nbsp;</td>
  			    <td><font>&nbsp;<input style="font-size: 28px;" type="submit" name="Submit" id="textbox" value="Search"></font></td>
			</tr> 
		</form> 
			<tr><td>&nbsp;</td></tr> <tr><td>&nbsp;</td></tr> <tr><td>&nbsp;</td></tr> <tr><td>&nbsp;</td></tr> 

		 
			    
		<form ACTION= "/childinfo.php"  METHOD="POST" name="searchfield2"> 
			<tr><td width="150">Child's ID           <br></td><td><input name="passedChildID" id="textbox" value="" type="text" size=26></td></tr>
			<tr><td>&nbsp;</td><td><font>&nbsp;<input style="font-size: 28px;" type="submit" name="Submit" value="Search"></font></td> 
		</form>		
		
		<form ACTION= "/tempbadge.php"  METHOD="POST" name="searchfield3"> 

			    <td><font>&nbsp;<input style="font-size: 28px;" type="submit" name="Submit" id="textbox" value="Visitor?"></font></td>
			</tr> 
			    
			    
			    
		</table> 
		</form> 
	<SCRIPT language="JavaScript">
		document.searchfield.LastName.focus();
	</SCRIPT> 
	</div> <!--end content -->
   <div id="sidebar" ><!--start sidebar -->
   	  <div class="relatedLinks"><!--start relatedLinks -->
        	<?php include ('/var/www/Templates/sidebar.php'); ?>
	  </div><!--end relatedLinks -->
  </div> <!--start sidebar -->
</div><!--end web -->

</body>
</html>


