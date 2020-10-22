<?php require_once('../dbConnect.php');?>
<table cellpadding="5" cellspacing="0" border="1">
	<tr>
	    <th>Numbers</th>
	    <th>Name</th>
		<th>Address</th>
		<th>City</th>
		<th>Account</th>
		<th>Phone</th>
		<th>E-mail</th>
		<th>Type</th>
		<th>Code</th>
        <th>Action</th>
	</tr>
	<?php
$sql= "SELECT  Sup_name,Sup_address,Sup_city,Sup_account,Sup_phone,Sup_email,It_type,Scode FROM supplier";
$query=mysqli_query($con,$sql);
if(mysqli_num_rows($query)>0){
	$i=1;

	while ($row=mysqli_fetch_object($query)) {
  ?>   

   <tr>
   <td><?php echo $i++; ?></td>
   <td><?php echo $row-> Sup_name;?></td>
   <td><?php echo $row-> Sup_address;?></td>
   <td><?php echo $row-> Sup_city;?></td>
   <td><?php echo $row-> Sup_account;?></td>
   <td><?php echo $row-> Sup_phone;?></td>
   <td><?php echo $row-> Sup_email;?></td>
   <td><?php echo $row-> It_type;?></td>
   <td><?php echo $row-> Scode;?></td>
   <td> 
		<a href="">Edit</a>
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