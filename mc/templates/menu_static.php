<?php
/**
 * config.php
 *
 * Configuration file. 
 * It contains variables used in the template as well as the company data array 
 * which store all data about company and system required wherever they need in system-wide
 *
 */

 /* Primary navigation array (the primary navigation will be created automatically based on this array, up to 3 levels deep) */
$primary_nav = array(
    array(
        'name'  => 'Administrator',
        'icon'  => 'gi gi-user',
        'sub'   => array(
            array(
                'name'  => 'Dashboard',
                'url'   => 'admin/index.php',
                'icon'  => 'gi gi-pie_chart'
            ),
            array(
                'name'  => 'Locations',
                'url'   => 'admin/location.php',
                'icon'  => 'gi gi-factory'
            ),
            array(
                'name'  => 'Departments',
                'url'   => 'admin/department.php',
                'icon'  => 'gi gi-podium'
            ),
            array(
                'name'  => 'Designations',
                'url'   => 'admin/designation.php',
                'icon'  => 'gi gi-briefcase'
            ),
            array(
                'name'  => 'User Profiles',
                'url'   => 'admin/user_profile.php',
                'icon'  => 'gi gi-user_add'
            ),
            array(
                'name'  => 'Modules',
                'url'   => 'admin/module.php',
                'icon'  => 'gi gi-cogwheels'
            ),
            array(
                'name'  => 'Permissions',
                'url'   => 'admin/permission.php',
                'icon'  => 'gi gi-circle_ok'
            ),
            array(
                'name'  => 'Groups',
                'url'   => 'admin/group.php',
                'icon'  => 'gi gi-group'
            )
        )
    ),
    array(
        'name'  => 'Mobile',
        'icon'  => 'gi gi-earphone',
        'sub' => array (
            array(
                'name'  => 'Upload',
                'url'   => 'mobile/upload.php',
                'icon'  => 'gi gi-upload'
            ),
            array(
                'name'  => 'Mobile Accounts',
                'url'   => 'mobile/mobile_account.php',
                'icon'  => 'gi gi-address_book'
            ),
            array(
                'name'  => 'Service Providers',
                'url'   => 'mobile/service_provider.php',
                'icon'  => 'gi gi-factory'
            ),
            array(
                'name'  => 'Connection Types',
                'url'   => 'mobile/connection_type.php',
                'icon'  => 'gi gi-factory'
            ),
            array(
                'name'  => 'Packages',
                'url'   => 'mobile/packages.php',
                'icon'  => 'gi gi-factory'
            ),
            array(
                'name'  => 'VAS',
                'url'   => 'mobile/vas.php',
                'icon'  => 'gi gi-factory'
            ),
            array(
                'name'  => 'Reports',
                'url'   => 'mobile/report.php',
                'icon'  => 'fa fa-file-text'
            )
        )
    )
);
?>