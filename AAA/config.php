<?php

$config_file = 'config/config_local.ini';

if (file_exists ($config_file)){ // file_exists is inbuilt function used to check whether a file or directory exists or not
    $config = parse_ini_file($config_file, true); // this function used to read in our own configuration file and returns the setting
}else{
    echo ('Can not find file: '.$config_file.'<br>');
    die ('Configuration file doesn\'t exists.<br>');
}

$p_db_host = $config['primary_database']['host'];
$p_db_port = $config['primary_database']['port'];
$p_db_user = $config['primary_database']['user'];
$p_db_password = $config['primary_database']['password'];
$p_db_dbname = $config['primary_database']['dbname'];

if (!$config){
    die ('Configuration file read error.<br>');
}else{
	$con_main = mysqli_connect($p_db_host, $p_db_user, $p_db_password, $p_db_dbname, $p_db_port);
}


if (!$con_main) {
    die('Primary database connection error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
}

/* Template variables */
$template = array(
    'robots'            => '',
    'title'             => $title_prefix.$title_suffix,
    'page_preloader'    => true,
    'menu_scroll'       => true,
    'header_content'    => '',
    'active_page'       => basename($_SERVER['PHP_SELF'])
);
?>

