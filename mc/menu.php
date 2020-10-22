<?php
$access_code = $_SESSION['ACCESS_CODE'];

$primary_nav = array();

$max_levels_query = "SELECT
MAX(MM.MENU_LEVEL) AS MAX_LEVEL
FROM
mas_permission AS MP
INNER JOIN mas_module AS MM ON MP.MOD_CODE = MM.MOD_CODE
WHERE
MP.ACCESS_CODE = $access_code AND
MM.IN_MENU = 1 AND
MM.`STATUS` = 1";

$max_levels_sql = mysqli_query($con_main, $max_levels_query);
$max_level_res = mysqli_fetch_assoc($max_levels_sql);

$max_levels = $max_level_res['MAX_LEVEL'];

for ($i = 1; $i <= $max_levels; $i++){
    $menu_link_query = "SELECT
    MP.ACCESS_CODE,
    MM.MOD_CODE,
    MM.MOD_NAME,
    MM.CHECK_CODE,
    MM.URL,
    MM.ICON,
    MM.MAIN_MODULE,
    MM.PARENT_MODULE_CODE,
    MM.IN_MENU,
    MM.MENU_LEVEL,
    MM.OPENABLE
    FROM
    mas_permission AS MP
    INNER JOIN mas_module AS MM ON MP.MOD_CODE = MM.MOD_CODE
    WHERE
    MP.ACCESS_CODE = $access_code AND
    MM.IN_MENU = 1 AND
    MM.`STATUS` = 1 AND
    MM.MENU_LEVEL = $i
    ORDER BY
    MM.MOD_NAME ASC";

    $menu_link_sql = mysqli_query($con_main, $menu_link_query);

    while ($menu_link = mysqli_fetch_assoc($menu_link_sql)){
        $module_id = $menu_link['MOD_CODE'];
        $main_module_id = $menu_link['PARENT_MODULE_CODE'];
        $sub_menu_array = array();

        if ($i == 1){
            $primary_nav[$module_id]['name'] = $menu_link['MOD_NAME'];
            $primary_nav[$module_id]['url'] = $menu_link['URL'];
            $primary_nav[$module_id]['icon'] = $menu_link['ICON'];
            $primary_nav[$module_id]['is_main'] = ($menu_link['MAIN_MODULE'] == 1) ? true : false;
            $primary_nav[$module_id]['main_module_code'] = $main_module_id;
            $primary_nav[$module_id]['is_openable'] = ($menu_link['OPENABLE'] == 1) ? true : false;
            $primary_nav[$module_id]['sub'] = "";
        }

        if ($i == 2){
            $sub_menu_array['name'] = $menu_link['MOD_NAME'];
            $sub_menu_array['url'] = $menu_link['URL'];
            $sub_menu_array['icon'] = $menu_link['ICON'];
            $sub_menu_array['is_main'] = ($menu_link['MAIN_MODULE'] == 1) ? true : false;
            $sub_menu_array['main_module_code'] = $main_module_id;
            $sub_menu_array['is_openable'] = ($menu_link['OPENABLE'] == 1) ? true : false;
            $sub_menu_array['sub'] = "";

            $primary_nav[$main_module_id]['sub'][$module_id] = $sub_menu_array;
        }

        if ($i == 3){
            $super_main_module_query = "SELECT M.PARENT_MODULE_CODE FROM mas_module AS M WHERE M.MOD_CODE = $main_module_id";
            $super_main_module_sql = mysqli_query ($con_main, $super_main_module_query);
            $super_main_module_res = mysqli_fetch_assoc($super_main_module_sql);
            $super_main_module_id = $super_main_module_res['PARENT_MODULE_CODE'];

            $sub_menu_array['name'] = $menu_link['MOD_NAME'];
            $sub_menu_array['url'] = $menu_link['URL'];
            $sub_menu_array['icon'] = $menu_link['ICON'];
            $sub_menu_array['is_main'] = ($menu_link['MAIN_MODULE'] == 1) ? true : false;
            $sub_menu_array['main_module_code'] = $main_module_id;
            $sub_menu_array['is_openable'] = ($menu_link['OPENABLE'] == 1) ? true : false;

            $primary_nav[$super_main_module_id]['sub'][$main_module_id]['sub'][$module_id] = $sub_menu_array;
        }
    }
}
?>