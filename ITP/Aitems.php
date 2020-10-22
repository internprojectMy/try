<?php
	 $link=mysql_connect("localhost","root","");
	 mysql_select_db($link,"itproject");
?>
<!DOCTYPE html>
<html>
<head>
	<title>
		
	</title>
</head>
<body>

<div class=" grid_10">
<div class=" box round first ">
	<h2> Add Product </h2>
<div class="block">
	<form name="form1" action="ListS.php" method=" post">
	<table>
	  <tr>
	  <td> Supplier Name: </td>
	  <td> <input type="text" name="sname" required></td>
	  </tr>

	  <tr>
	  <td> Supplier Address: </td>
	  <td> <input type="text" name="saddress" required></td>
	  </tr>

	  <tr>
	  <td> City: </td>
	  <td> <input type="text" name="scity"></td>
	  </tr>

	  <tr>
	  <td> Account No: </td>
	  <td> <input type="text" name="saccount" required ></td>
	  </tr>

	  <tr>
	  <td> Phone No: </td>
	  <td> <input type="text" name="sphone" required></td>
	  </tr>

	  <tr>
	  <td> E-mail: </td>
	  <td> <input type="text" name="semail" required></td>
	  </tr>

	  <tr>
	  <td> Date: </td>
	  <td> <input type="Date" name="sdate" required></td>
	  </tr>

	  <tr>
	  <td> Supplier code: </td>
	  <td> <input type="text" name="scode" required></td>
	  </tr>

	  <tr>
	  <td colspan="2" align="center "> <input type="submit" name="submit" value=" Add"></td>
	  </tr>
   </table>				
	</form>
	<?php

	if (isset($_POST[submit])) {
	 	# code...


	 } 
	 ?>

 
				
</div>			
</div>	
</div>

</body>
</html>