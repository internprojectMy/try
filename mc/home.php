<?php
	session_start();
	
	if (empty($_SESSION['ACCESS_CODE']) || $_SESSION['ACCESS_CODE'] == NULL){
		header ('Location: login.php');
		exit;
	}else{
        header ('Location: dashboard/dashboard.php');
    }
	
	$folder_depth = "";
	$prefix = "";
	
	$folder_depth = substr_count($_SERVER["PHP_SELF"] , "/");
	$folder_depth = ($folder_depth == false) ? 2 : (int)$folder_depth;   ///Should be ask!!!!
	
	$prefix = str_repeat("../", $folder_depth - 2);
?>
<?php include $prefix.'config.php'; ?>
<?php include $prefix.'menu.php'; ?>
<?php include $prefix.'template_start.php'; ?>
<?php include $prefix.'page_head.php'; ?>

<!-- Page content -->
<div id="page-content">
    <!-- Blank Header -->   
    <div class="content-header">
        <div class="header-section">
            <h1>
                <i class="gi gi-home"></i>Home<br><small>Home you always like to return</small>
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li>Home</li>
    </ul>
    <!-- END Blank Header -->

    <!-- Example Block -->
    <div class="block">
        <!-- Example Title -->
        <div class="block-title">
            <h2>Home Page</h2>
        </div>
        <!-- END Example Title -->

        <!-- Example Content -->
        <p>Your content..</p>
        <!-- END Example Content -->
    </div>
    <!-- END Example Block -->
</div>
<!-- END Page Content -->

<?php include $prefix.'page_footer.php'; ?>
<?php include $prefix.'template_scripts.php'; ?>
<?php include $prefix.'template_end.php'; ?>