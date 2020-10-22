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

    <div id="gridview">
        <div class="heading">Image Gallery</div>
<?php
$query = $db_handle->runQuery("SELECT * FROM tbl_image ORDER BY id ASC");
if (! empty($query)) {
    foreach ($query as $key => $value) {
        ?>  
            <div class="image">
            <?php 
                if(file_exists($query[$key]["path"])) 
                { 
            ?>
            <img src="<?php echo $query[$key]["path"] ; ?>" />
            <p class="card-text"><?php echo $query['name'];?></p>
            <h3><?php echo $query['name']; ?></h3>
            <?php 
                } else { 
            ?>
            <img src="gallery/default.jpeg" />
            <?php
                }
            ?>
            </div>
<?php
    }
}
?>
    </div>
</body>
</html>