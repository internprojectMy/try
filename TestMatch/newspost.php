<?php
  $connect = mysqli_connect("localhost","root","","slcscore_slcs");
  $query ="SELECT
  slcscore_slcs.author_details.AUTHOR_ID,
  slcscore_slcs.author_details.AUTHOR_NAME
  FROM
  slcscore_slcs.author_details
  ";
    $result1= mysqli_query($connect,$query);   
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="newspost.php" method="POST">

    <p>
        <label for="title">Title</label>
        <input type="text" name="title" id="title">
    </p>

    <p>
        <label for="news">News</label>
        <input type="text" name="news" id="news">
    </p>

    <p>
        <label for="description">Description</label>
        <input type="text" name="description" id="description">
    </p>

    <h4 >Upload Main Image......</h4>
                                <!-- <h6 class="card-subtitle">For multiple file upload put class <code>.dropzone</code> to form.</h6> -->
                                <div class="col-md-2" id="update_image">
                                      </div>
                                       <h4 id="update_image_titl">Update Image</h4>
                                 <input type="file" name="file_main" id="file_main" accept="image/*" class="btn btn-success"> 
                                  <br></br>


        <select>
            <?php while($row1 =mysqli_fetch_array($result1)):;?>
            <option value=""><?php echo $row1[1]; ?></option>
            <?php endwhile; ?>
        </select>
        
        </div>
     

</form>
    
</body>
</html>