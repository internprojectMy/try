<?php require_once('../dbConnect.php');?>
<a href="AddNewItem.php">Add New Items</a>
<table cellpadding="5" cellspacing="0" border="1">
	<tr>
	 <th>Numbers</th>
	 <th>Supplier Code</th>
	 <th>Item Name</th>
     <th>Item Type</th>
     <th>Unit Cost</th>
	 <th>Item Description</th>
	 <th>Item Code</th>
	 <th>Action</th>
	</tr>
	<?php
$sql= "SELECT Scode,I_name,It_type,I_cost,I_des,Icode FROM product";
$query=mysqli_query($con,$sql);
if(mysqli_num_rows($query)>0){
	$i=1;

	while ($row=mysqli_fetch_object($query)) {
  ?>   


   <tr>
   <td><?php echo $i++; ?></td>
   <td><?php echo $row-> Scode;?></td>
   <td><?php echo $row-> I_name;?></td>
   <td><?php echo $row-> It_type;?></td>
   <td><?php echo $row-> I_cost;?></td>
   <td><?php echo $row-> I_des;?></td>
   <td><?php echo $row-> Icode;?></td>
   <td> 
		<a href="AddNewItem.php?edited=6&Icode=<?php echo $row->Icode;?>">Edit</a>
		<a href="">delect</a>
   </td>

  </tr>
	


	
	<?php
}
}
?>
</table>
<!DOCTYPE html>
<html>
<head>
	<title></title>
<style>
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

</body>
</html>