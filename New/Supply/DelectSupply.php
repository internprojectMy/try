<?php include_once'../include/dbh.php';
$error="";
$scode="";
$Snam="";
$Saddres="";
$Scit="";
$Semai="";
$Saccoun="";
$Sban="";
$Sphon="";
$Sdat="";
$Ittype="";

if(isset($_GET['edited']))
{
  $sql="SELECT * FROM supply WHERE SCode='{$_GET['Scod']}'";
  $result=mysqli_query($con,$sql);
  $row=mysqli_fetch_object($result);
  $Scod=$row->SCode;
  $Snam=$row->Sname;
  $Saddres=$row->SAddress;
  $Scit=$row->SCity;
  $Semai=$row->Semail;
  $Saccoun=$row->Saccount;
  $Sban=$row->Sbank;
  $Sphon=$row->Sphone;
  $Sdat=$row->Sdate;
  $Ittype=$row->ITtype;
}

if(isset($_GET['delected']))
{
  $sql="delect FROM supply WHERE SCode ='{$_GET['Scod']}'";
  $result=mysqli_query($con,$sql);
  if($result){
    header('Refresh:0; NewSuppliersList.php');
  }
}
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
  font-size: 20px;
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
<h1>Add New Suppliers</h1>
<div class="container">
<form name="form1" action="../include/Supplierssubmit.php" method="POST">
	<table>
     <tr>
	  <td> <h2>Supplier code:</h2> </td>
	  <td> <input type="text" style="width: 265px; height: 60px;" name="Scod" required></td>
	  </tr>
	  <tr>
	  <td> <h2>Supplier Name:</h2> </td>
	  <td> <input type="text" style="width: 400px; height: 60px;" name="Snam"  required></td>
	  </tr>

	  <tr>
	  <td> <h2>Supplier Address:</h2> </td>
	  <td> <input type="text" style="width: 465px; height: 60px;" name="Saddres" required></td>
	  </tr>

	  <tr>
	  <td><h2> City:</h2> </td>
	  <td> <input type="text" style="width: 265px; height: 60px;" name="Scit"  required=""></td>
	  </tr>
      
      <tr>
	  <td><h2> E-mail:</h2> </td>
	  <td> <input type="text" style="width:380px; height: 60px;" name="Semai"  required></td>
	  </tr>

	  <tr>
	  <td><h2> Account No:</h2> </td>
	  <td> <input type="text" style="width: 265px; height: 60px;" name="Saccoun"   required ></td>
	  </tr>
     <tr>
	  <td><h2> Bank Name:</h2> </td>
	  <td> <input type="text" style="width:320px; height: 60px;" name="Sban"   required></td>
	  </tr>

	  <tr>
	  <td><h2> Phone No:</h2> </td>
	  <td> <input type="text" style="width: 300px; height: 60px;" name="Sphon"  required></td>
	  </tr>

	  <tr>
	  <td><h2> Date:</h2> </td>
	  <td> <input type="Date" style="width: 265px; height: 60px;" name="Sdat"  required></td>
	  </tr>

	  <tr>
	  <td><h2> Item Type :</h2> </td>
	  <td><select  type="text" style="width: 265px; height: 60px;" name="ittype" required>
  <option value="Bajaj Paint">Bajaj Paint</option>
  <option value="Bajaj Parts">Bajaj Parts</option>
  <option value="Bajaj all">Bajaj All</option>
  <option value="Causeway Paints">Causeway Paints</option>
  <option value="Causeway vehicalPaints">Causeway vehicalPaints</option>
  <option value="Causeway floorPaints">Causeway floorPaints</option>
</select></td>
	  </tr>

	  <tr>
	  <td colspan="2" align="center "> <input class="button" type="submit" style="width: 150px; height: 60px;" name="submit" value=" Add"></td>
	  </tr>
   </table>				
	</form>
</div>

</body>
</html>