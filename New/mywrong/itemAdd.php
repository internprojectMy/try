<?php '../dbConnect.php';?>


<!DOCTYPE html>
<html>
<head>
	<title>
		Add Suppliers Here
	</title>

<style>
body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.topnav {
  overflow: hidden;
  background-color: #333;
}

.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}
	
</style>
</head>
<body>
	<header>
		<h1> Website Name</h1>
	</header>
<div class="topnav">
  <a class="active" href="supplyAdd.php">Add new Suppliers</a>
  <a href="viewsuppliers.php">List of Suppliers</a>
  <a href="itemAdd.php">Add new Items</a>
  <a href="ListItem.php">List of Items</a>
  <a href="viewItem.php">View List of Items</a>
</div>

<h2>Add New Items </h2>

<form name="form1" action="ListItem.php" method="post">
	<table>
	  <tr>
	  <td> Supplier code: </td>
	  <td> <input type="text" style="width: 265px; height: 30px;" name="Scode" required></td>
	  </tr>
	  <tr>
	  <td> Item Name: </td>
	  <td> <input type="text" style="width: 265px; height: 30px;" name="I_name" required></td>
	  </tr>
	  <tr>
	  <td> Item Type : </td>
	  <td> <input type="text" style="width: 265px; height: 30px;" name="It_type" required></td>
	  </tr>
	  
	  <tr>
	  <td> Unit Cost: </td>
	  <td> <input type="text" style="width: 265px; height: 30px;" name="I_cost" required></td>
	  </tr>
	  <tr>
	  <td> Item Description: </td>
	  <td> <input type="text" style="width: 265px; height: 30px;" name="I_des" required></td>
	  </tr>
	  <tr>
	  <td> Item Code: </td>
	  <td> <input type="text" style="width: 265px; height: 30px;" name="Icode" required></td>
	  </tr>
	  <tr>
	  <td colspan="2" align="center "> <input type="submit" style="width: 150px; height: 60px;" name="submit" value=" Add"></td>
	  </tr>
   </table>				
	</form>


</body>
</html>