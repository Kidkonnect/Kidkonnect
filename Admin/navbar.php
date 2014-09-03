<?php   
		if ($MM_UserGroup == 'registered')
		{
		  //echo '<div class="login">  <!--start login --> '; 
			echo '<img name="SideMenuReg" src="/Menus/SideMenuReg.gif" width="135" height="65" border="0" usemap="#m_SideMenuReg" alt="">';
			echo '<map name="m_SideMenuReg">';
			  echo '<area shape="rect" coords="0,0,135,21" href="/index.php?doLogout=true" alt="" >';
			  echo '<area shape="rect" coords="0,21,135,43" href="/UserGuides/index.php" alt="" onMouseOut="MM_startTimeout();" onMouseOver="MM_showMenu(window.UserGuides,115,115,null,SideMenuReg);" >';
			  echo '<area shape="rect" coords="0,43,135,65" href="/Tutorials/index.php" alt="" onMouseOut="MM_startTimeout();" onMouseOver="MM_showMenu(window.tutorials,115,140,null,SideMenuReg);" >';
			echo '</map>';
		  //echo '</div><!-- end login -->';
		  echo '<div id="whiteBar"></div>';
		}
		else if ($MM_UserGroup == 'customer')
		{
		 // echo '<div class="login">  <!--start login --> '; 
			echo '<img name="SideMenuCust" src="/Menus/SideMenuCust.gif" width="135" height="90" border="0" usemap="#m_SideMenuCust" alt="">';
			echo '<map name="m_SideMenuCust">';
			  echo '<area shape="rect" coords="0,0,135,21" href="/index.php?doLogout=true" alt="" >';
			  echo '<area shape="rect" coords="0,21,135,43" href="/UserGuides/index.php" alt="" onMouseOut="MM_startTimeout();" onMouseOver="MM_showMenu(window.UserGuides,115,115,null,SideMenuCust);" >';
			  echo '<area shape="rect" coords="0,43,135,65" href="/Tutorials/index.php" alt="" onMouseOut="MM_startTimeout();"  onMouseOver="MM_showMenu(window.tutorials,115,140,null,SideMenuCust);" >';
			  echo '<area shape="rect" coords="0,65,135,90" href="/Customer/index.php" alt="" onMouseOut="MM_startTimeout();"  onMouseOver="MM_showMenu(window.customer,115,165,null,SideMenuCust);"  >';
			echo '</map>';
		  //echo '</div><!-- end login -->';
		  echo '<div id="whiteBar"></div>';
		}
		else if ($MM_UserGroup == 'admin')
		{
		  //echo '<div class="login">  <!--start login --> '; 
			echo '<img name="SideMenuAdmin" src="/Menus/SideMenuAdmin.gif" width="135" height="115" border="0" usemap="#m_SideMenuAdmin" alt="">';
			echo '<map name="m_SideMenuAdmin">';
			  echo '<area shape="rect" coords="0,0,135,21" href="/index.php?doLogout=true" alt="" >';
			  echo '<area shape="rect" coords="0,21,135,43" href="/UserGuides/index.php" alt="" onMouseOut="MM_startTimeout();" onMouseOver="MM_showMenu(window.UserGuides,115,115,null,SideMenuAdmin);" >';
			  echo '<area shape="rect" coords="0,43,135,65" href="/Tutorials/index.php" alt="" onMouseOut="MM_startTimeout();" onMouseOver="MM_showMenu(window.tutorials,115,140,null,SideMenuAdmin);" >';
			  echo '<area shape="rect" coords="0,65,135,90" href="/Customer/index.php" alt="" onMouseOut="MM_startTimeout();"  onMouseOver="MM_showMenu(window.customer,115,165,null,SideMenuAdmin);"  >';
			  echo '<area shape="rect" coords="0,90,135,115" href="/Admin/admin.php" alt="" onMouseOut="MM_startTimeout();"  onMouseOver="MM_showMenu(window.admin,115,190,null,SideMenuAdmin);"  >';
			echo '</map>';
			//echo '</div><!-- end login -->';
		  echo '<div id="whiteBar"></div>';
		}
?>
<div class="login">  <!--start login -->     
		<?php
		if (empty($MM_Username)) 
		{  
		?>
			 <form ACTION= "/logon.php"  METHOD="POST" name="logonfield"> 
			   <table width="150px"> 
				 <tr><td><font>Login to see more<br>or&nbsp;<a href="/register.php">Register with us.</a></B></font></td></tr> 
				 <tr><td><font>Email Address</font><br><input name="txtemail" id="txtboxLogin" value="" type="text" size=18></td></tr> 
				 <tr><td><font>Password     </font><br><input name="txtpassword" value=""  type="password" id="txtboxLogin" size=18></td></tr> 
				 <tr><td><font>&nbsp;<input type="submit" name="Submit" id="txtboxLogin" value="Log In"></font></td></tr> 
				 <tr><td><font>&nbsp;<a href="/forgotpw.php">Forgot Your Password?</a></font></td></tr> 
			   </table> 
			 </form> 
		<?php
		}
		else if ($MM_UserGroup == 'registered')
		{
		?>
			 <font>&nbsp;Welcome <?php echo $MM_FirstName; ?><br> 
			 &nbsp;Logged on with<br> 
			 &nbsp;registered access<br>
			 &nbsp;<br>
			 &nbsp;Are you a Customer?<br>
			 &nbsp;<a href="/Contact/index.php">Contact us</a> and let<br>
			 &nbsp;us know so you can<br>
			 &nbsp;see more.</font> 
		<?php
		}
		else if ($MM_UserGroup == 'customer')
		{
		?>
			 <font>&nbsp;Welcome <?php echo $MM_FirstName; ?><br> 
			 &nbsp;Logged on with<br> 
			 &nbsp;customer access</font> 
		<?php
		} 
		else
		{
		?>
			 <font>&nbsp;Welcome <?php echo $MM_FirstName; ?><br> 
			 &nbsp;Logged on with<br> 
			 &nbsp;administrator access</font> 
		<?php
		}
		?>
</div><!--end login -->
<div id="whiteBar"></div>
<div class="search"> <!--start search -->
  <form action="/search.php" method="GET" name="search_form"  style="text-align: left;" id="search_form">
		<table width="150px" border="0" class="textbox">
		  <tr><td colspan="2"><font>Search for</font><br><input name="search" id="txtboxSearch" type="text" size="18"></td></tr>
		  <tr><td width="120px">
			<select class="textbox" name="section" id="txtboxSearch">
			  <option value="Whole Site" selected="selected">Whole Site</option>
			  <option value="Products">Products</option> 
			  <option value="TerraHawk">TerraHawk</option> 
			  <option value="Cameras">Cameras</option>
			  <option value="Radiometers">Radiometers</option> 
			  <option value="Software">Software</option>
			  <option value="Components">Components</option>
			  <option value="RemoteSensing">Remote Sensing</option> 
			  <option value="SchiebeMethod">Schiebe Method</option> 
			  <option value="Services">Services</option> 
			  <?php
			  if ($MM_UserGroup == 'admin')
			  {
				echo '<option value="admin">Admin</option>';
			  }
			  ?>                
			</select></td>
			<td width="30"><input type="submit" id="txtboxLogin" class="textbox" value="Go" size="3"/></td>
		  </tr>
		  <tr><td colspan="2"><input type="checkbox" name="exact_search" value="yes" /><font>Exact Search</font></td></tr>
		</table>
    </form>
</div> <!--end search -->
