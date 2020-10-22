<?php   include( 'inc/connection.php' ) ;  ?>
<?php 

    $ProductId =$_GET['prodToUpdate'];       
      
    //print_r($ProductId);           
    $selectQuery = "SELECT  ProdID,ProdName,UnitPrice,Quantity,SupplierID  FROM  Product WHERE ProdID='$ProductId'";
    $resultOfProdSelected = mysqli_query($connection,$selectQuery);   

    while($record = mysqli_fetch_assoc($resultOfProdSelected)){
        $existingProdName = $record['ProdName'];
        $existingUnitPrice = $record['UnitPrice'];
        $existingQuantity = $record['Quantity'];
        $existingSupplierID = $record['SupplierID'];

    }
    
?>
<DOCTYPE  html>
<html  lang = "en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    <style>
        @media (min-width: 1200px) {
            .container{
                max-width: 700px;
            }
        }
        h2 {
            text-align: center;
            color: SlateBlue;
            font-size: 40px;
            font-weight: bold;
        }
    </style>
</head>
<body>
               
      <div class="container">
           <h2>Update  Product </h2>
         
           <form class="form-horizontal"  role="form"  method="post"  action="ViewProducts.php?ProdId=<?php echo $ProductId;?>">
         
              
                <div class="form-group">
                    <label class="control-label col-sm-2">Name:</label>
                    <div class="col-sm-7">          
                        <input class="form-control" id="productName" placeholder="Update product name" name="productName" value="<?php echo $existingProdName;?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2">Unit Price:</label>
                    <div class="col-sm-7">          
                        <input  class="form-control" id="unitPrice" placeholder="Update unit price" name="unitPrice" value="<?php echo $existingUnitPrice;?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2">Quantity:</label>
                    <div class="col-sm-7">          
                        <input class="form-control" id="quantity" placeholder="Update quantity" name="quantity"  value="<?php echo $existingQuantity;?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="supid">Supplier:</label>
                    <div class="col-sm-7">          
                        <select class="form-control" id="supplier" name="supplier" >
                            <option value="1">Prasadika Fernando</option>
                            <option value="2">Shalomi Fernando</option>
                            <option value="3">Prageeth Wijesinghe</option>
                            <option value="4">Nermala Perera</option>
                        </select>
                    </div>
                </div>  

                <div class="form-group">        
                    <div class="col-sm-offset-2 col-sm-10">                         
                         <button type="submit" name="updateProd" id="updateProd" class="btn btn-default">Update</button>
                    </div>
                </div>
            </form>
        </div>
</body>
</html>
