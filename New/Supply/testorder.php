
<?php
if (isset($_POST['search'])) {
  $valueToSearch=$_POST['valueToSearch'];
  $query="SELECT * FROM rdetails WHERE CONCAT('RId','ICode','ITtype','Sname','Semail','SCode','IQuantity') LIKE '%$valueToSearch%'";
  $search_result=filterTable($query);
  
}else{
  $query="SELECT * FROM rdetails";
    $search_result=filterTable($query);

}
function filterTable($query){
  $con=mysqli_connect("localhost","root","","svauto");
  $filter_Result=mysqli_query($con,$query);
  return $filter_Result;
}
?>
<form>
  
<table cellpadding="5" cellspacing="0" border="1">



	<tr>
	    <th>Request Oder</th>
		<th>Item Code</th>
		<th>Item Types</th>
		<th>Supplier Name</th>
		<th>Supplier Email</th>
		<th>Supplier code</th>
		<th>Item Quantity</th>
		<th>Action</th>
		
	</tr>

<?php while($row=mysqli_fetch_object($search_result));?>
  <tr>
   <td><?php echo $row['RId'];?></td>
   <td><?php echo $row['ICode'];?></td>
   <td><?php echo $row['ITtype'];?></td>
   <td><?php echo $row['Sname'];?></td>
   <td><?php echo $row['Semail'];?></td>
   <td><?php echo $row['SCode'];?></td>
   <td><?php echo $row['IQuantity'];?></td>
   <td> 
		<a href="">Edit</a>
		<a href="">delect</a>
   </td>

  </tr>

  <?php?>


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
  <a class="active" href="AddNewSupplier.php">Add new Suppliers</a>
  <a href="NewSuppliersList.php">List of Suppliers</a>
  <a href="ReOrder.php">Order Details</a>
  <a href="NewOne.php">List of Orders</a>
  <a href="../items/finalitemAdd.php">Add New Item</a>
  <a href="../items/ItemConnect.php">Item List</a>
</div>
<h1>List Of Order Details..</h1>
<tr>
  <input type="text" name="valueToSearch" placeholder="value to search"><br>
  <input type="submit" name="search" value="Filter"><br>
  </tr>

</table>
</form>
</body>
</html>