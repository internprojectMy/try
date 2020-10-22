<?php include_once'../include/dbh.php';
?>

<!DOCTYPE html>

<html>
<head>
	<title> Order Details </title>
<style >
*{
	margin:0;
  }
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
.container {
 border-radius: 5px;
 background-color: #f2f2f2;
 padding: 120px;
}
input[type=text] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border: 3px solid #ccc;
  -webkit-transition: 0.5s;
  transition: 0.5s;
  outline: none;
}

input[type=text]:focus {
  border: 3px solid #555;
}
.button {
  padding: 15px 25px;
  font-size: 24px;
  text-align: center;
  cursor: pointer;
  outline: none;
  color: #fff;
  background-color: #4CAF50;
  border: none;
  border-radius: 15px;
  box-shadow: 0 9px #999;
}

.button:hover {background-color: #3e8e41}

.button:active {
  background-color: #3e8e41;
  box-shadow: 0 5px #666;
  transform: translateY(4px);
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
  <a href="../items/finalitemAdd.php">Add New Item</a>
  <a href="../items/ItemConnect.php">Item List</a>
</div>
	<h1>Order Details..</h1>
<div class="container">
	<form action="../include/ordersubmit.php" method="POST">
<table>
	
<tr>
<td><h2>Request Order Number:</h2></td>
<td><input type="text" style="width: 265px; height: 60px;" name="rid" placeholder="001" required>
</td>
 </tr>
  <tr>
  <td><h2>Item Code: </h2></td>
  <td><input type="text" style="width: 265px; height: 60px;" name="icode" placeholder="B01" required></td>
  </tr>

 <tr>
 <td><h2>Item Type:</h2> </td>
 <td><input type="text" style="width: 265px; height: 60px;" name="ittype" placeholder="Bajaj paints" required></td>
 </tr>
 <tr>
 <td><h2>Supplier Name: </h2></td>
 <td><input type="text" style="width: 320px; height: 60px;" name="sname" placeholder="supplier name" required></td>
</tr>
  
 <tr>
 	<td><h2>supplier Email: </h2></td>
		<td><input type="text" style="width: 320px; height: 60px;" name="semail" placeholder="aaa@gmail.com" required></td>
	</tr>

	<tr><td><h2>Supplier Code:</h2></td>
		<td><input type="text" style="width: 265px; height: 60px;" name="scode" placeholder=" AB001" required></td>
	</tr>

	 <tr>
	 	<td><h2>Item quantity :</h2></td>

		<td><input type="text" style="width: 265px; height: 60px;" name="iquantity" placeholder="12" required></td>
	 </tr>
      <tr>	 
		<td><button  class="button" type="submit"  style="width: 265px; height: 60px;" name="submit">Submit
		</button></td>
	</tr>
	</table>
	</form>
</div>

</body>
</html>