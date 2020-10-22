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
$query = "SELECT * FROM tbl_image ORDER BY id ASC";
$sql = mysqli_query($conn, $query);
while ($type = mysqli_fetch_array($sql))
{
    $id=$type['id'];
    $path=$type['path'];
        ?>  
            <div class="image">
            <?php 
                if(file_exists($query[$key]["path"])) 
                { 
            ?>
            <img src="<?php echo $query[$key]["path"] ; ?>" />
            <p class="card-text"><?php echo $type['name'];?></p>
            <h3><?php echo $type['name']; ?></h3>
            <?php 
                } else { 
            ?>
            <img src="gallery/default.jpeg" />
            <?php
                }
            ?>
            </div>
            <p class="card-text"><?php echo $type['name'];?></p>
<?php
}
?>
    </div>
</body>
</html>