<?php
include 'DBController.php';
$db_handle = new DBController();
?>
<!DOCTYPE html>
<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class="gallery">
    <?php
$query = $db_handle->runQuery("SELECT * FROM tbl_image ORDER BY id ASC");
if (! empty($query)) {
    foreach ($query as $key => $value) {
        ?>
        <?php 
                if(file_exists($query[$key]["path"])) 
                { 
            ?>  
  <a target="_blank" href="img_5terre.jpg">

    <img src="<?php echo $query[$key]["path"] ; ?>" />
  </a>
  <div class="desc">  <p class="card-text"><?php echo $query["name"];?></p></div>
  <?php 
                } else { 
            ?>

            <img src="gallery/default.jpeg" />
            <?php
                }
            ?>
            <?php
    }
}
?>
</div>
</body>
</html>