<?php include '../dbConnect.php';
$error="";
$Scod="";
$I_nam="";
$It_typ="";
$I_cos="";
$I_de="";
$Icod="";

$error="";
if(isset($_POST['submit'])){
$Scod    =$_POST['Scode'];
$I_nam =$_POST['I_name'];
$It_typ   =$_POST['It_type'];
$I_cos =$_POST['I_cost'];
$I_de  =$_POST['I_des'];
$Icod   =$_POST['Icode'];

if(strlen($Icod)<4)
{
	$error=" Scode at least 4 ";
	exit();
}else
   {

	if($_POST['txtid']=="0")
	{
	$sql="INSERT into product(Scode,I_name, It_type,I_cost,I_des,Icode) VALUES ('$Scod', '$I_nam','$It_typ' ,'$I_cos', '$I_de','$Icod')";
	$query=mysqli_query($con,$sql);
	if($query)
	{
		header('Refresh:0; newList.php');
	}
	}else{
	$sql="UPDATE product set Scode='$Scod', I_name='$I_nam',It_type='$It_typ',I_cost='$I_cos',I_des='$I_de',Icode='$Icod'";
	$query=mysqli_query($sql);
	if($query)
	{
		header('Refresh:0; newList.php');
     }
	}
    }
}
if (isset($_GET['edited'])) 
{
$sql="SELECT  Scode,I_name,It_type,I_cost,I_des,Icode FROM product WHERE Icode='{$_GET['Icode']}' ";
   $query=mysqli_query($con,$sql);
   $row=mysqli_fetch_object($query);
   //$Icod=$row->Icode;
   $Scod=$row->Scode;
   $I_nam=$row->I_name;
   $It_typ=$row->It_type;
   $I_cos=$row->I_cost;
   $I_de=$row->I_des;
   $Icod=$row->Icode;
}

?>
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
  <a class="active" href="AddNewItem.php">Add new Suppliers</a>
  <a href="viewsuppliers.php">List of Suppliers</a>
  <a href="itemAdd.php">Add new Items</a>
  <a href="ListItem.php">List of Items</a>
  <a href="viewItem.php">View List of Items</a>
</div>

<h2>Add New Items </h2>

<form name="form1" action="newList.php" method="post">
	<table>

    <tr>
    	<td colspan="2"><span style="color: red;"><?php echo $error; ?> </span> </td>
    </tr>

	  <tr>
	  <td> Supplier code: </td>
	  <td> <input type="text" style="width: 265px; height: 30px;" name="Scode" value="<?php echo ($Scod)?>" required></td>
	  </tr>
	  <tr>
	  <td> Item Name: </td>
	  <td> <input type="text" style="width: 265px; height: 30px;" name="I_name" value="<?php echo($I_nam)?>" required></td>
	  </tr>
	  <tr>
	  <td> Item Type : </td>
	  <td> <input type="text" style="width: 265px; height: 30px;" name="It_type"  value="<?php echo($It_typ)?>"required></td>
	  </tr>
	  
	  <tr>
	  <td> Unit Cost: </td>
	  <td> <input type="text" style="width: 265px; height: 30px;" name="I_cost" value="<?php echo ($I_cos)?>" required></td>
	  </tr>
	  <tr>
	  <td> Item Description: </td>
	  <td> <textarea type="text" style="width: 265px; height: 30px;" name="I_des" value="<?php echo($I_de)?>" required></textarea></td>
	  </tr>
	  <tr>
	  <td> Item Code: </td>
	  <td> <input type="text" style="width: 265px; height: 30px;" name="Icode" value="<?php echo($Icod)?>" required><input type="hidden" name="txtid" value=""/></td>
	  </tr>
	  <tr>
	  <td colspan="2" align="center "> <input type="submit" style="width: 150px; height: 60px;" name="submit" value=" Add"></td>
	  </tr>
   </table>				
	</form>



</body>
</html>