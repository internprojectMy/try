<?php include_once'../include/dbh.php';
$error="";
$icode="";
$iname="";
$ittype="";
$scode="";
$ides="";
$icost="";

if(isset($_GET['edited']))
{
  $sql="SELECT * FROM product WHERE ICode='{$_GET['icode']}'";
  $result=mysqli_query($con,$sql);
  $row=mysqli_fetch_object($result);
  $icode=$row->ICode;
  $iname=$row->Iname;
  $ittype=$row->ITtype;
  $scode=$row->SCode;
  $ides=$row->Ides;
  $icost=$row->ICost;
}
if(isset($_GET['delected']))
{
  $sql="DELECT FROM product WHERE SCode ='{$_GET['icode']}'";
  $result=mysqli_query($con,$sql);
  if($result){
    header('Refresh:0; ItemConnect.php');
  }
}


?>

<!DOCTYPE html>

<html>
<head>
	<title> Item  Details </title>
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
  font-size: 20px;
}

input[type=text]:focus {
  border: 3px solid #555;
}
S
select[type=text]{
  
font-size: 20px;
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
  <a class="active" href="../Supply/AddNewSupplier.php">Add new Suppliers</a>
  <a href="../Supply/NewSuppliersList.php">List of Suppliers</a>
  <a href="../Supply/ReOrder.php">Order Details</a>
  <a href="../Supply/NewOne.php">List of Orders</a>
  <a href="finalitemAdd.php">Add New Item</a>
  <a href="ItemConnect.php">Item List</a>

</div>
	<h1>Item Details..</h1>
<div class="container">
	<form action="../include/itemsubmit.php" method="POST">
<table>
	
<tr>
<td><h2>Item Code:</h2></td>
<td><input type="text" style="width: 265px; height: 60px;" name="icode" value="<?php echo $row->ICode; ?>" placeholder="001" required>
</td>
 </tr>
  <tr>
  <td><h2>Item Name </h2></td>
  <td><input type="text" style="width: 265px; height: 60px;" name="iname" value="<?php echo $row->Iname; ?>" placeholder="Bajaj 2PX" required></td>
  </tr>

 <tr>
 <td><h2>Item Type:</h2> </td>
 <td><select  type="text" style="width: 265px; height: 60px;" name="ittype" value="<?php echo $row->ITtype; ?>" required>
  <option value="Bajaj Paint">Bajaj Paint</option>
  <option value="Bajaj Parts">Bajaj Parts</option>
  <option value="Bajaj all">Bajaj All</option>
  <option value="Causeway Paints">Causeway Paints</option>
  <option value="Causeway vehicalPaints">Causeway vehicalPaints</option>
  <option value="Causeway floorPaints">Causeway floorPaints</option>
</select></td>
 </tr>
  <tr><td><h2>Supplier Code:</h2></td>
    <td><select  type="text" style="width: 265px; height: 60px;" name="scode" value="<?php echo $row->SCode; ?>" required>
  <option value="AB001">AB001</option>
  <option value="AB002">AB002</option>
  <option value="AB003">AB003</option>
  <option value="AB004">AB004</option>
  <option value="AC001">AC001</option>
  <option value="AC002">AC002</option>
  <option value="AC003">AC003</option>
  <option value="AC004">AC004</option>
  <option value="AD001">AD001</option>
  <option value="AD002">AD002</option>
  <option value="AD003">AD003</option>
  <option value="AD004">AD004</option>
</select></td>
    
  </tr>

  </tr>
  <tr><td><h2>Item Describtion :</h2></td>
    <td><input type="text" style="width: 265px; height: 60px;" name="ides" value="<?php echo $row->Ides; ?>" placeholder=" add more details" required></td>
  </tr>

  </tr>
  <tr><td><h2>Unit Cost:</h2></td>
    <td><input type="text" style="width: 265px; height: 60px;" name="icost" value="<?php echo $row->ICost; ?>" placeholder=" 100.00" required></td>
  </tr>


      <tr>	 
		<td><button  class="button" type="submit"  style="width: 265px; height: 60px;" name="submit">Update
		</button></td>
	</tr>
	</table>
	</form>
</div>

</body>
</html>