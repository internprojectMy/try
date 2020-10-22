<?php include_once'../include/dbh.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
<style >
	html,body{
	height:100%;
    }
    
.heading{
    width: 100%;
    height:11%;
    background-color: #3498db;
    top: 0%;
    text-align: center;
    font-size: 50px;
    color: white;
}
.line1{
    width:100%;
    height:6%;
    background-color: #3498db;
    transform: translateY(10px);
}
.btnhome{
    background-color: #de0e1d;
    border: none;
    color: white;
    width: 10%;
    height: 100%;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 18px;
    transform: translateX(200px);
}
.btnlogout{
    background-color: #de0e1d;
    border: none;
    color: white;
    width: 10%;
    height: 100%;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 18px;
    transform: translateX(800px);
}
.line2{
    width:100%;
    height:20%;
    
    background-color: white;
    transform: translateY(50px);
}
.topnav {
  overflow: hidden;
  background-color:#000080;
}

.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 26px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}
h1{
	 text-align: center;
	 font-size: 60px;
}
</style>

</head>
<body>

<div class="heading"> Dash Board</div>
<div class="line1">
  <input class="btnhome" type="button" value="home" onclick="window.location.href = 'adminhome.php';">
 <input class="btnlogout" type="button" value="logout" onclick="window.location.href = 'adminlogin.php';">
</div>
<br>


 <div class="topnav">
  <a class="active" href="AddNewSupplier.php">Add new Suppliers</a>
  <a href="NewSuppliersList.php">List of Suppliers</a>
  <a href="ReOrder.php">Order Details</a>
  <a href="NewOne.php">List of Orders</a>
</div>
<h1>Add New Suppliers</h1>
<div class="C">
<form name="form1" action="../include/Supplierssubmit.php" method="POST">
	<table>
     <tr>
	  <td> Supplier code: </td>
	  <td> <input type="text" style="width: 265px; height: 30px;" name="Scod" required></td>
	  </tr>
	  <tr>
	  <td> Supplier Name: </td>
	  <td> <input type="text" style="width: 265px; height: 30px;" name="Snam" required></td>
	  </tr>

	  <tr>
	  <td> Supplier Address: </td>
	  <td> <input type="text" style="width: 265px; height: 30px;" name="Saddres" required></td>
	  </tr>

	  <tr>
	  <td> City: </td>
	  <td> <input type="text" style="width: 265px; height: 30px;" name="Scit"></td>
	  </tr>
      
      <tr>
	  <td> E-mail: </td>
	  <td> <input type="text" style="width:265px; height: 30px;" name="Semai" required></td>
	  </tr>

	  <tr>
	  <td> Account No: </td>
	  <td> <input type="text" style="width: 265px; height: 30px;" name="Saccoun" required ></td>
	  </tr>
     <tr>
	  <td> Bank Name: </td>
	  <td> <input type="text" style="width:265px; height: 30px;" name="Sban" required></td>
	  </tr>

	  <tr>
	  <td> Phone No: </td>
	  <td> <input type="text" style="width: 265px; height: 30px;" name="Sphon" required></td>
	  </tr>

	  <tr>
	  <td> Date: </td>
	  <td> <input type="Date" style="width: 265px; height: 30px;" name="Sdat" required></td>
	  </tr>

	  <tr>
	  <td> Item Type : </td>
	  <td> <input type="text" style="width: 265px; height: 30px;" name="Ittyp" required></td>
	  </tr>

	  <tr>
	  <td colspan="2" align="center "> <input type="submit" style="width: 150px; height: 60px;" name="submit" value=" Add"></td>
	  </tr>
   </table>				
	</form>

</body>
</html>