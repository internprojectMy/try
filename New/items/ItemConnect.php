<?php include_once'../include/dbh.php';
?>

<form>

<table cellpadding="5" cellspacing="0" border="1">
	<tr>
		<th>Item Code</th>
    <th>Item Name</th>
		<th>Item Types</th>
		<th>Supplier code</th>
		<th>Item Description</th>
		<th>Item Cost</th>
		<th>Action</th>
		
	</tr>

	<?php
$sql="SELECT * FROM product;";
$result=mysqli_query($con,$sql);
$resultCheck=mysqli_num_rows($result);
if($resultCheck>0){
	while ($row =mysqli_fetch_object($result)) {
		?>
	 	<tr>
   <td><?php echo $row-> ICode;?></td>
   <td><?php echo $row-> Iname;?></td>
   <td><?php echo $row-> ITtype;?></td>
   <td><?php echo $row-> SCode;?></td>
   <td><?php echo $row-> Ides;?></td>
   <td><?php echo $row-> ICost;?></td>
   <td> 
		<a href="EditItem.php?edited=1&icode=<?php echo $row->ICode; ?>">Edit</a>
		<a href="ItemConnect.php?edited=1&icode=<?php echo $row->ICode; ?>">delect</a>
   </td>

  </tr>

  <?php
	 } 
}

?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style>

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

 table{
 	width: 75%;
 	margin:30px auto;
 	border-collapse:collapse;
 	text-align: left;
 	color:#588c7e; 
 }
 tr{
    border-bottom: 1px solid #cbcbcb;
    background-color: #f2f2f2;
   }
 th,td{
       border: none;
       height: 20px;
       padding: 15px;
      }
 tr:hover{
           background:#f5f5f5;
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
<h1>List Of Item Details..</h1>
</table>
</form>
</body>
</html>