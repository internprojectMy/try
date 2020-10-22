<?php require_once('../dbConnect.php');?>


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
  <a class="active" href="ListSuppliers.php">Add new Suppliers</a>
  <a href="viewsuppliers.php">List of Suppliers</a>
  <a href="AAAAA.php">Add new Items</a>
  <a href="BBBBB.php">List of Items</a>
</div>

<h2>Add New Suppliers </h2>

<form name="form1" action="ListSuppliers.php" method="post">
	<table>
	  <tr>
	  <td> Supplier Name: </td>
	  <td> <input type="text" style="width: 265px; height: 30px;" name="Sup_name" required></td>
	  </tr>

	  <tr>
	  <td> Supplier Address: </td>
	  <td> <input type="text" style="width: 265px; height: 30px;" name="Sup_address" required></td>
	  </tr>

	  <tr>
	  <td> City: </td>
	  <td> <input type="text" style="width: 265px; height: 30px;" name="Sup_city"></td>
	  </tr>

	  <tr>
	  <td> Account No: </td>
	  <td> <input type="text" style="width: 265px; height: 30px;" name="Sup_account" required ></td>
	  </tr>

	  <tr>
	  <td> Phone No: </td>
	  <td> <input type="text" style="width: 265px; height: 30px;" name="Sup_phone" required></td>
	  </tr>

	  <tr>
	  <td> E-mail: </td>
	  <td> <input type="text" style="width:265px; height: 30px;" name="Sup_email" required></td>
	  </tr>

	  <tr>
	  <td> Date: </td>
	  <td> <input type="Date" style="width: 265px; height: 30px;" name="Sup_date" required></td>
	  </tr>

	  <tr>
	  <td> Item Type : </td>
	  <td> <input type="text" style="width: 265px; height: 30px;" name="It_type" required></td>
	  </tr>
	  <tr>
	  <td> Supplier code: </td>
	  <td> <input type="text" style="width: 265px; height: 30px;" name="Scode" required></td>
	  </tr>

	  <tr>
	  <td colspan="2" align="center "> <input type="submit" style="width: 150px; height: 60px;" name="submit" value=" Add"></td>
	  </tr>
   </table>				
	</form>


</body>
</html>
<?php mysqli_close($con);?>