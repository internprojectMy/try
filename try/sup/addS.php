<?php '../datacon.php';?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
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


	<title>
		Add Suppliers Here
	</title>
	
</head>
<body>
	<header>
		<h1> Website Name</h1>
	</header>


<div class="topnav">
  <a class="active" href="addS.php">Add new Suppliers</a>
  <a href="listSupply.php">List of Suppliers</a>
  <a href="addI.php">Add new Items</a>
  <a href="listItem.php">List of Items</a>
</div>


<h2>Add New Suppliers </h2>
<form name="form1" action="ListS.php" method="post">
	<table>
	  <tr>
	  <td> Supplier Name: </td>
	  <td> <input type="text"  name="name" required></td>
	  </tr>

	  <tr>
	  <td> Supplier Address: </td>
	  <td> <input type="text" name="address" required></td>
	  </tr>

	  <tr>
	  <td> City: </td>
	  <td> <input type="text" name="city"></td>
	  </tr>

	  <tr>
	  <td> Account No: </td>
	  <td> <input type="text" name="account" required ></td>
	  </tr>

	  <tr>
	  <td> Phone No: </td>
	  <td> <input type="text" name="phone" required></td>
	  </tr>

	  <tr>
	  <td> E-mail: </td>
	  <td> <input type="text" name="email" required></td>
	  </tr>

	  <tr>
	  <td> Date: </td>
	  <td> <input type="Date" name="date" required></td>
	  </tr>

	  <tr>
	  <td> Item Type : </td>
	  <td> <input type="text" name="type" required></td>
	  </tr>
	  <tr>
	  <td> Supplier code: </td>
	  <td> <input type="text" name="code" required></td>
	  </tr>

	  <tr>
	  <td colspan="2" align="center "> <input type="submit" name="submit" value=" Add"></td>
	  </tr>
   </table>				
	</form>



<footer><p> Company Name | Address | Tel:123 345 567  </p> </footer>
</body>
</html>