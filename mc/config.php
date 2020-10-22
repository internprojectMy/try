<?php
/**
 * config.php
 *
 * Configuration file. 
 * It contains variables used in the template as well as the company data array 
 * which store all data about company and system required wherever they need in system-wide
 *
 */

$folder_depth_db = "";
$prefix_db = "";

$folder_depth_db = substr_count($_SERVER["PHP_SELF"] , "/");
$folder_depth_db = ($folder_depth_db == false) ? 2 : (int)$folder_depth_db;

$prefix_db = str_repeat("../", $folder_depth_db - 2);

$prefix_db = ($prefix_db != "" || isset($prefix_db)) ? $prefix_db : "";

$company = array();
$config = array();
$title_prefix = "";

$config_file = $prefix_db.'config/config_local.ini';

if (file_exists ($config_file)){
    $config = parse_ini_file($config_file, true);
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
}

$con_primary = mysqli_connect($p_db_host, $p_db_user, $p_db_password, $p_db_dbname, $p_db_port);

if (!$con_primary) {
    die('Primary database connection error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
}

$primary_query =   "SELECT
COM.ID AS COMPANY_ID,
CON.ID AS CONFIG_ID,
COM.SHORT_NAME,
COM.FULL_NAME,
COM.SLOGAN,
COM.LOGO_LARGE,
COM.LOGO_MEDIUM,
COM.LOGO_SMALL,
CON.TITLE_PREFIX,
COM.HEAD_LOCATION_ADDRESS_LINE1 AS ADDRESS_LINE1,
COM.HEAD_LOCATION_ADDRESS_LINE2 AS ADDRESS_LINE2,
COM.HEAD_LOCATION_ADDRESS_LINE3 AS ADDRESS_LINE3,
COM.HEAD_LOCATION_CITY AS CITY,
COM.HEAD_LOCATION_COUNTRY AS COUNTRY,
COM.HEAD_LOCATION_TEL1 AS TEL1,
COM.HEAD_LOCATION_TEL2 AS TEL2,
COM.HEAD_LOCATION_TEL3 AS TEL3,
COM.HEAD_LOCATION_TEL4 AS TEL4,
COM.HEAD_LOCATION_FAX1 AS FAX1,
COM.HEAD_LOCATION_FAX2 AS FAX2,
COM.HEAD_LOCATION_FAX3 AS FAX3,
COM.HEAD_LOCATION_FAX4 AS FAX4,
COM.HEAD_LOCATION_EMAIL AS EMAIL,
CON.DB_HOST,
CON.DB_PORT,
CON.DB_USER,
CON.DB_PASSWORD,
CON.DB_DATABASE,
CON.MAIN_DOCUMENT_PATH,
COM.CORPORATE_CODE,
COM.BUSINESS_REG_CODE,
COM.VAT_REG_CODE,
COM.SVAT_REG_CODE,
CON.MAIN_MENU_PATH,
CON.SYSTEM_NAME_FULL,
CON.SYSTEM_NAME_SHORT,
CON.FAVICON,
CON.SYSTEM_LOGO,
CON.TITLE_SEPERATOR,
CON.CREDIT_TEXT,
CON.SYSTEM_VERSION
FROM
company AS COM
LEFT JOIN sys_config AS CON ON COM.ID = CON.COMPANY_ID
WHERE
COM.`STATUS` = 1 AND
COM.`DEFAULT` = 1 AND
CON.`STATUS` = 1 AND
CON.`DEFAULT` = 1
ORDER BY
COMPANY_ID DESC,
CONFIG_ID DESC
LIMIT 1";

$primary_sql = mysqli_query($con_primary, $primary_query);
$main_para = mysqli_fetch_array($primary_sql);

mysqli_close($con_primary);

$company['COMPANY_ID'] = $main_para['COMPANY_ID'];
$company['CONFIG_ID'] = $main_para['CONFIG_ID'];
$company['SHORT_NAME'] = $main_para['SHORT_NAME'];
$company['FULL_NAME'] = $main_para['FULL_NAME'];
$company['SLOGAN'] = $main_para['SLOGAN'];
$company['LOGO_LARGE'] = $main_para['LOGO_LARGE'];
$company['LOGO_MEDIUM'] = $main_para['LOGO_MEDIUM'];
$company['LOGO_SMALL'] = $main_para['LOGO_SMALL'];
$company['FAVICON'] = $main_para['FAVICON'];
$company['SYSTEM_LOGO'] = $main_para['SYSTEM_LOGO'];
$company['TITLE_PREFIX'] = $main_para['TITLE_PREFIX'];
$company['TITLE_SEPERATOR'] = $main_para['TITLE_SEPERATOR'];
$company['ADDRESS_LINE1'] = $main_para['ADDRESS_LINE1'];
$company['ADDRESS_LINE2'] = $main_para['ADDRESS_LINE2'];
$company['ADDRESS_LINE3'] = $main_para['ADDRESS_LINE3'];
$company['CITY'] = $main_para['CITY'];
$company['COUNTRY'] = $main_para['COUNTRY'];
$company['TEL1'] = $main_para['TEL1'];
$company['TEL2'] = $main_para['TEL2'];
$company['TEL3'] = $main_para['TEL3'];
$company['TEL4'] = $main_para['TEL4'];
$company['FAX1'] = $main_para['FAX1'];
$company['FAX2'] = $main_para['FAX2'];
$company['FAX3'] = $main_para['FAX3'];
$company['FAX4'] = $main_para['FAX4'];
$company['EMAIL'] = $main_para['EMAIL'];
$company['DB_HOST'] = $main_para['DB_HOST'];
$company['DB_PORT'] = $main_para['DB_PORT'];
$company['DB_USER'] = $main_para['DB_USER'];
$company['DB_PASSWORD'] = $main_para['DB_PASSWORD'];
$company['DB_DATABASE'] = $main_para['DB_DATABASE'];
$company['MAIN_DOC_PATH'] = $main_para['MAIN_DOCUMENT_PATH'];
$company['CORPORATE_CODE'] = $main_para['CORPORATE_CODE'];
$company['BUSINESS_REG_CODE'] = $main_para['BUSINESS_REG_CODE'];
$company['VAT_REG_CODE'] = $main_para['VAT_REG_CODE'];
$company['SVAT_REG_CODE'] = $main_para['SVAT_REG_CODE'];
$company['MAIN_MENU_PATH'] = $main_para['MAIN_MENU_PATH'];
$company['SYSTEM_NAME_FULL'] = $main_para['SYSTEM_NAME_FULL'];
$company['SYSTEM_NAME_SHORT'] = $main_para['SYSTEM_NAME_SHORT'];
$company['CREDIT_TEXT'] = $main_para['CREDIT_TEXT'];
$company['VERSION'] = $main_para['SYSTEM_VERSION'];

$title_prefix = $company['TITLE_PREFIX'].$company['TITLE_SEPERATOR'];

$con_main = mysqli_connect($company['DB_HOST'], $company['DB_USER'], $company['DB_PASSWORD'], $company['DB_DATABASE'], $company['DB_PORT']);

if (!$con_main) {
    die('Main database connection error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
}

/* Template variables */
$template = array(
    'name'              => $company['SYSTEM_NAME_SHORT'],
    'version'           => $company['VERSION'],
    'author'            => $company['CREDIT_TEXT'],
    'robots'            => '',
    'title'             => $title_prefix.$title_suffix,
    'description'       => $company['SYSTEM_NAME_FULL'],
    // true                     enable page preloader
    // false                    disable page preloader
    'page_preloader'    => true,
    // true                     enable main menu auto scrolling when opening a submenu
    // false                    disable main menu auto scrolling when opening a submenu
    'menu_scroll'       => true,
    // 'navbar-default'         for a light header
    // 'navbar-inverse'         for a dark header
    'header_navbar'     => 'navbar-default',
    // ''                       empty for a static layout
    // 'navbar-fixed-top'       for a top fixed header / fixed sidebars
    // 'navbar-fixed-bottom'    for a bottom fixed header / fixed sidebars
    'header'            => 'navbar-fixed-top',
    // ''                                               for a full main and alternative sidebar hidden by default (> 991px)
    // 'sidebar-visible-lg'                             for a full main sidebar visible by default (> 991px)
    // 'sidebar-partial'                                for a partial main sidebar which opens on mouse hover, hidden by default (> 991px)
    // 'sidebar-partial sidebar-visible-lg'             for a partial main sidebar which opens on mouse hover, visible by default (> 991px)
    // 'sidebar-mini sidebar-visible-lg-mini'           for a mini main sidebar with a flyout menu, enabled by default (> 991px + Best with static layout)
    // 'sidebar-mini sidebar-visible-lg'                for a mini main sidebar with a flyout menu, disabled by default (> 991px + Best with static layout)
    // 'sidebar-alt-visible-lg'                         for a full alternative sidebar visible by default (> 991px)
    // 'sidebar-alt-partial'                            for a partial alternative sidebar which opens on mouse hover, hidden by default (> 991px)
    // 'sidebar-alt-partial sidebar-alt-visible-lg'     for a partial alternative sidebar which opens on mouse hover, visible by default (> 991px)
    // 'sidebar-partial sidebar-alt-partial'            for both sidebars partial which open on mouse hover, hidden by default (> 991px)
    // 'sidebar-no-animations'                          add this as extra for disabling sidebar animations on large screens (> 991px) - Better performance with heavy pages!
    'sidebar'           => 'sidebar-partial sidebar-visible-lg',
    // ''                       empty for a static footer
    // 'footer-fixed'           for a fixed footer
    'footer'            => 'footer-fixed',
    // ''                       empty for default style
    // 'style-alt'              for an alternative main style (affects main page background as well as blocks style)
    'main_style'        => '',
    // ''                           Disable cookies (best for setting an active color theme from the next variable)
    // 'enable-cookies'             Enables cookies for remembering active color theme when changed from the sidebar links (the next color theme variable will be ignored)
    'cookies'           => '',
    // 'night', 'amethyst', 'modern', 'autumn', 'flatie', 'spring', 'fancy', 'fire', 'coral', 'lake',
    // 'forest', 'waterlily', 'emerald', 'blackberry' or '' leave empty for the Default Blue theme
    'theme'             => 'flatie',
    // ''                       for default content in header
    // 'horizontal-menu'        for a horizontal menu in header
    // This option is just used for feature demostration and you can remove it if you like. You can keep or alter header's content in page_head.php
    'header_content'    => '',
    'active_page'       => basename($_SERVER['PHP_SELF'])
);

?>