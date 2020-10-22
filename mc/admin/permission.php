<?php
	session_start();
	
	if (empty($_SESSION['ACCESS_CODE']) || $_SESSION['ACCESS_CODE'] == NULL){
		header ('Location: login.php');
		exit;
	}
	
	$folder_depth = "";
	$prefix = "";
	
	$folder_depth = substr_count($_SERVER["PHP_SELF"] , "/");
	$folder_depth = ($folder_depth == false) ? 2 : (int)$folder_depth;
	
    $prefix = str_repeat("../", $folder_depth - 2);
    
    $title_suffix = " Permission Master";
?>
<?php include $prefix.'config.php'; ?>
<?php include $prefix.'menu.php'; ?>
<?php include $prefix.'template_start.php'; ?>
<?php include $prefix.'page_head.php'; ?>

<!-- Page content -->
<div id="page-content">
    <!-- Page Header -->
    <div class="content-header">
        <div class="header-section">
            <h1>
                <i class="gi gi-circle_ok"></i>Permission Master<br><small>Manage user permissions</small>
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../home.php">Home</a></li>
        <li>Permissions</li>
    </ul>
    <!-- END Page Header -->

    <!-- User Access Block -->
    <div class="block">
        <!-- User Access Title -->
        <div class="block-title">
            <h2>User Access</h2>
        </div>
        <!-- END User Access Title -->

        <!-- User Access Content -->
        <form id="form-user-access" name="form-user-access" class="form-horizontal form-bordered" >
            <div class="form-group">
                <label class="col-md-2 control-label" for="user_access">User Access</label>
                <div class="col-md-8">
                    <select id="user_access" name="user_access" style="width: 100%;">
                        <option value="0" selected disabled>Select User Profile</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-warning" id="btn_clear_access"><i class="fa fa-close"></i> Clear</button>
                </div>
            </div>
        </form>
        <!-- END User Access Content -->
    </div>
    <!-- END User Access Block -->

    <!-- Modules Block -->
    <div class="block">
        <!-- Modules Title -->
        <div class="block-title">
            <h2>Modules</h2>
        </div>
        <!-- END Modules Title -->

        <!-- Modules Content -->
        <form id="form-permitted-modules" name="form-permitted-modules" class="form-horizontal form-bordered">
            <div class="form-group">
                <div class="col-md-5 col-md-offset-1">
                    <h4 class="sub-header">Menu Permissions</h4>
                    <div class="well">
                    <ul class="fa-ul">
                    <?php
                        $query_level1_mods = "SELECT
													`MOD`.MOD_CODE,
													`MOD`.MOD_NAME,
													`MOD`.CHECK_CODE,
													`MOD`.ICON,
													`MOD`.MAIN_MODULE,
													`MOD`.PARENT_MODULE_CODE,
													IFNULL(MAIN.MOD_NAME, '') AS PARENT_MOD_NAME,
													`MOD`.IN_MENU,
													`MOD`.MENU_LEVEL,
													`MOD`.OPENABLE
												FROM
													mas_module AS `MOD`
												LEFT JOIN mas_module AS MAIN ON `MOD`.PARENT_MODULE_CODE = MAIN.MOD_CODE
												WHERE
													`MOD`.`STATUS` = 1
												AND MAIN.`STATUS` = 1
												AND `MOD`.MENU_LEVEL = 1
												AND `MOD`.IN_MENU = 1
												AND `MOD`.MOD_CODE = '73'
												OR `MOD`.MOD_CODE = '95'
												OR `MOD`.MOD_CODE = '122'
												ORDER BY
													`MOD`.MOD_NAME ASC";

                        $sql_level1_mods = mysqli_query($con_main, $query_level1_mods);

                        while ($level1_mods = mysqli_fetch_assoc($sql_level1_mods)){
                            $level1_mod_id = $level1_mods['MOD_CODE'];
                            $level1_parent_id = $level1_mods['PARENT_MODULE_CODE'];

                            if($level1_mod_id == 73){

                                $query_level2_mods="SELECT
                                `MOD`.MOD_CODE,
                                `MOD`.MOD_NAME,
                                `MOD`.CHECK_CODE,
                                `MOD`.ICON,
                                `MOD`.MAIN_MODULE,
                                `MOD`.PARENT_MODULE_CODE,
                                IFNULL(MAIN.MOD_NAME, '') AS PARENT_MOD_NAME,
                                `MOD`.IN_MENU,
                                `MOD`.MENU_LEVEL,
                                `MOD`.OPENABLE
                            FROM
                                mas_module AS `MOD`
                            LEFT JOIN mas_module AS MAIN ON `MOD`.PARENT_MODULE_CODE = MAIN.MOD_CODE
                            WHERE
                                `MOD`.`STATUS` = 1
                            AND MAIN.`STATUS` = 1
                            AND `MOD`.MENU_LEVEL = 2
                            AND `MOD`.IN_MENU = 1
                            AND `MOD`.PARENT_MODULE_CODE = '73'
                            AND `MOD`.MOD_CODE = '77'
                            OR `MOD`.MOD_CODE = '79'
                            OR `MOD`.MOD_CODE = '78'
                            ORDER BY
                                `MOD`.MOD_NAME ASC";
                            }else{

                            $query_level2_mods = "SELECT
                            `MOD`.MOD_CODE,
                            `MOD`.MOD_NAME,
                            `MOD`.CHECK_CODE,
                            `MOD`.ICON,
                            `MOD`.MAIN_MODULE,
                            `MOD`.PARENT_MODULE_CODE,
                            IFNULL(MAIN.MOD_NAME, '') AS PARENT_MOD_NAME,
                            `MOD`.IN_MENU,
                            `MOD`.MENU_LEVEL,
                            `MOD`.OPENABLE
                            FROM
                            mas_module AS `MOD`
                            LEFT JOIN mas_module AS MAIN ON `MOD`.PARENT_MODULE_CODE = MAIN.MOD_CODE
                            WHERE
                            `MOD`.`STATUS` = 1 AND
                            MAIN.`STATUS` = 1 AND
                            `MOD`.MENU_LEVEL = 2 AND
                            `MOD`.IN_MENU = 1 AND
                            `MOD`.PARENT_MODULE_CODE = $level1_mod_id
                            ORDER BY
                            `MOD`.MOD_NAME ASC";
                        }

                            $sql_level2_mods = mysqli_query($con_main, $query_level2_mods);
                            $num_level2_mods = mysqli_num_rows($sql_level2_mods);
                            
                            echo ("<li>&nbsp;</li>");

                            if ($num_level2_mods > 0){
                                echo ("<li>");
                                echo ("<input type='checkbox' class='auto_check' name='mod_id[]' value='".$level1_mod_id."' id='".$level1_mod_id."' data-parent-code='".$level1_parent_id."'>&nbsp;");
                                echo ("<i class='".$level1_mods['ICON']." fa-li text-info'></i>".$level1_mods['MOD_NAME']." <code>".$level1_mods['CHECK_CODE']."</code>");
                                echo ("<ul class='fa-ul'>");

                                while ($level2_mods = mysqli_fetch_assoc($sql_level2_mods)) {
                                    $level2_mod_id = $level2_mods['MOD_CODE'];
                                    $level2_parent_id = $level2_mods['PARENT_MODULE_CODE'];

                                    $query_level3_mods = "SELECT
                                    `MOD`.MOD_CODE,
                                    `MOD`.MOD_NAME,
                                    `MOD`.CHECK_CODE,
                                    `MOD`.ICON,
                                    `MOD`.MAIN_MODULE,
                                    `MOD`.PARENT_MODULE_CODE,
                                    IFNULL(MAIN.MOD_NAME, '') AS PARENT_MOD_NAME,
                                    `MOD`.IN_MENU,
                                    `MOD`.MENU_LEVEL,
                                    `MOD`.OPENABLE
                                    FROM
                                    mas_module AS `MOD`
                                    LEFT JOIN mas_module AS MAIN ON `MOD`.PARENT_MODULE_CODE = MAIN.MOD_CODE
                                    WHERE
                                    `MOD`.`STATUS` = 1 AND
                                    MAIN.`STATUS` = 1 AND
                                    `MOD`.MENU_LEVEL = 3 AND
                                    `MOD`.IN_MENU = 1 AND
                                    `MOD`.PARENT_MODULE_CODE = $level2_mod_id
                                    ORDER BY
                                    `MOD`.MOD_NAME ASC";

                                    $sql_level3_mods = mysqli_query($con_main, $query_level3_mods);
                                    $num_level3_mods = mysqli_num_rows($sql_level3_mods);
                                    
                                    echo ("<li>&nbsp;</li>");

                                    if ($num_level3_mods > 0){
                                        echo ("<li>");
                                        echo ("<input type='checkbox' class='auto_check' name='mod_id[]' value='".$level2_mod_id."' id='".$level2_mod_id."' data-parent-code='".$level2_parent_id."'>&nbsp;");
                                        echo ("<i class='".$level2_mods['ICON']." fa-li text-warning'></i>".$level2_mods['MOD_NAME']." <code>".$level2_mods['CHECK_CODE']."</code>");
                                        echo ("<ul class='fa-ul'>");

                                        while ($level3_mods = mysqli_fetch_assoc($sql_level3_mods)) {
                                            $level3_mod_id = $level3_mods['MOD_CODE'];
                                            $level3_parent_id = $level3_mods['PARENT_MODULE_CODE'];

                                            echo ("<li>");
                                            echo ("<input type='checkbox' class='auto_check' name='mod_id[]' value='".$level3_mod_id."' id='".$level3_mod_id."' data-parent-code='".$level3_parent_id."'>&nbsp;");
                                            echo ("<i class='".$level3_mods['ICON']." fa-li text-danger'></i>".$level3_mods['MOD_NAME']." <code>".$level3_mods['CHECK_CODE']."</code>");
                                            echo ("</li>");
                                        }

                                        echo ("</ul>");
                                        echo ("</li>");
                                    }else{
                                        echo ("<li>");
                                        echo ("<input type='checkbox' class='auto_check' name='mod_id[]' value='".$level2_mod_id."' id='".$level2_mod_id."' data-parent-code='".$level2_parent_id."'>&nbsp;");
                                        echo ("<i class='".$level2_mods['ICON']." fa-li text-warning'></i>".$level2_mods['MOD_NAME']." <code>".$level2_mods['CHECK_CODE']."</code>");
                                        echo ("</li>");
                                    }
                                }

                                echo ("</ul>");
                                echo ("</li>");
                            }else{
                                echo ("<li>");
                                echo ("<input type='checkbox' class='auto_check' name='mod_id[]' value='".$level1_mod_id."' id='".$level1_mod_id."' data-parent-code='".$level1_parent_id."'>&nbsp;");
                                echo ("<i class='".$level1_mods['ICON']." fa-li text-info'></i>".$level1_mods['MOD_NAME']." <code>".$level1_mods['CHECK_CODE']."</code>");
                                echo ("</li>");
                            }
                        }
                    ?>
                    </ul>
                    </div>
                </div>

                <div class="col-md-5 col-md-offset-1">
                    <h4 class="sub-header">Other Permissions</h4>
                    <div class="well">
                    <ul class="fa-ul">
                    <?php
                        $query_other_mods = "SELECT
                        `MOD`.MOD_CODE,
                        `MOD`.MOD_NAME,
                        `MOD`.CHECK_CODE,
                        `MOD`.ICON,
                        `MOD`.MAIN_MODULE,
                        `MOD`.PARENT_MODULE_CODE,
                        `MOD`.IN_MENU,
                        `MOD`.MENU_LEVEL,
                        `MOD`.OPENABLE
                        FROM
                        mas_module AS `MOD`
                        WHERE
                        `MOD`.`STATUS` = 1
                        AND `MOD`.IN_MENU = 0
                        ORDER BY
                        `MOD`.MOD_NAME ASC";

                        $sql_other_mods = mysqli_query($con_main, $query_other_mods);

                        while ($mods = mysqli_fetch_assoc($sql_other_mods)){
                            echo ("<li>");
                            echo ("<input type='checkbox' name='mod_id[]' value='".$mods['MOD_CODE']."' id='".$mods['MOD_CODE']."' data-parent-code='".$mods['PARENT_MODULE_CODE']."'>&nbsp;");
                            echo ("<i class='".$mods['ICON']." fa-li text-danger'></i>".$mods['MOD_NAME']." <code>".$mods['CHECK_CODE']."</code>");
                            echo ("</li>");
                        }
                    ?>
                    </ul>
                    </div>
                </div>
            </div>

            <div class="form-group form-actions">
                <input type="hidden" name="id" id="id" value="0" />

                <div class="col-md-12">
                    <button type="submit" class="btn btn-success primary-btn pull-right"><i class="fa fa-angle-right"></i> Submit</button>
                    <button type="reset" class="btn btn-warning"><i class="fa fa-plus"></i> New</button>
                </div>
            </div>
        </form>
        <!-- END Modules Content -->
    </div>
    <!-- END Modules Block -->
</div>
<!-- END Page Content -->

<?php include $prefix.'page_footer.php'; ?>
<?php include $prefix.'template_scripts.php'; ?>
<?php include $prefix.'template_end.php'; ?>

<script type="text/javascript">
    $('#user_access').select2({
        minimumInputLength: 2,
        ajax: {
            url: 'data/data_user_access.php',
            dataType: 'json',
            delay: 100,
            data: function (term) {
                return term;
            },
            processResults: function (r) {
                d = r.data;

                return {
                    results: $.map(d, function (item) {
                        return {
                            text: "[" + item.EMP_NO + "] " + item.EMP_NAME,
                            id: item.ACCESS_CODE
                        }
                    })
                };
            }
        }
    });

    $('#user_access').on('change', function(){
        var access_code = $('#user_access').select2('val');

        if (access_code == "" || access_code == null || access_code == "0") return;

        $('#id').val(access_code);

        $.ajax({
            url: 'data/data_permission.php',
            data: {
                id: access_code
            },
            dataType: 'json',
            error: function (e) {
                $.bootstrapGrowl('<h4>Error!</h4> <p>Error fetching existing permission data</p>', {
                    type: 'danger',
                    delay: 2500,
                    allow_dismiss: true
                });
            },
            success: function (r) {
                if (r.result){
                    $.each(r.data, function (k,v) {
                        var id = v.MOD_CODE;

                        $('#'+id).prop('checked',true);
                    })
                }else{
                    $.bootstrapGrowl('<h4>Error!</h4> <p>'+r.message+'</p>', {
                        type: 'danger',
                        delay: 2500,
                        allow_dismiss: true
                    });
                }
            }
        });
    });

    $('#btn_clear_access').on('click', function(){
        $('#user_access').val("0").trigger('change');
        $('#id').val("0");
    });

    $('.auto_check').on('change', function (e){
        var parent_id = $(this).data('parent-code');
        var this_checked = $(this).prop('checked');
        var parent_checked = $('#'+parent_id).prop('checked');

        if (this_checked && !parent_checked){
            $('#'+parent_id).prop('checked',true).trigger('change');
        }

        if (!this_checked){
            $(this).parent().find(":checkbox").prop('checked',false);
        }
    });

    $('#form-permitted-modules').on('submit', function(e){
        e.preventDefault();
        
        var access_id = $('#id').val();
        var form_data = $('#form-permitted-modules').serializeArray();

        form_data.push({'name':'operation', 'value':'insert'});

        if (access_id == 0){
            $.bootstrapGrowl('<h4>Warning!</h4> <p>Please select an user profile.</p>', {
                type: 'warning',
                delay: 2500,
                allow_dismiss: true
            });

            return;
        }

        $.ajax({
            url: 'permission_crud.php',
            data: form_data,
            dataType: 'json',
            error: function (e) {
                $.bootstrapGrowl('<h4>Error!</h4> <p>Error saving permission data</p>', {
                    type: 'danger',
                    delay: 2500,
                    allow_dismiss: true
                });
            },
            success: function (r) {
                var msg_typ = "info";
                var msg_txt = "";

                if (r.result){
                    msg_typ = 'success';
                    msg_txt = '<h4>Success!</h4> <p>'+r.message+'</p>';
                }else{
                    msg_typ = 'danger';
                    msg_txt = '<h4>Error!</h4> <p>'+r.message+'</p>';
                }

                $.bootstrapGrowl(msg_txt, {
                    type: msg_typ,
                    delay: 2500,
                    allow_dismiss: true
                });
            }
        });
    });

    $('#form-permitted-modules').on('reset', function(e){
        $('#id').val("0");
        $('#user_access').val("0").trigger('change');
    });
</script>