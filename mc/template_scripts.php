<?php
/**
 * template_scripts.php
 *
 * Author: pixelcave
 *
 * All vital JS scripts are included here
 *
 */

$prefix = ($prefix != "" || isset($prefix)) ? $prefix : "";
?>

<!-- jQuery, Bootstrap.js, jQuery plugins and Custom JS code -->
<script src="<?php echo($prefix); ?>js/vendor/jquery.min.js"></script>
<script src="<?php echo($prefix); ?>js/vendor/bootstrap.min.js"></script>
<script src="<?php echo($prefix); ?>js/plugins.js"></script>
<script src="<?php echo($prefix); ?>js/app.js"></script>
