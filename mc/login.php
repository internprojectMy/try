<?php
	session_start();
	
	if (!empty($_SESSION['ACCESS_CODE']) || $_SESSION['ACCESS_CODE'] != NULL){
		header ('Location: home.php');
		exit;
	}
	
	$folder_depth = "";
	$prefix = "";
	
	$folder_depth = substr_count($_SERVER["PHP_SELF"] , "/");
	$folder_depth = ($folder_depth == false) ? 2 : (int)$folder_depth;
	
	$prefix = str_repeat("../", $folder_depth - 2);
?>
<?php include 'config.php'; ?>
<?php include 'template_start.php'; ?>


<img src="img/placeholders/backgrounds/lock_full_bg.jpg" alt="Login Full Background" class="full-bg animation-pulseSlow">



<div id="login-container" class="animation-fadeIn">
  
    <div class="login-title text-center">
        <h1><img src="img/pic3.png" width="350px"><br><small>Please <strong>Login</strong> or <strong>Register</strong></small></h1>
        <!-- <h1>SANDAHIRU<br><small>MICRO CREDIT</small><br><small>Please <strong>Login</strong> or <strong>Register</strong></small></h1> -->
    </div>
    
    <div class="block push-bit">
        <!-- Login Form -->
        <form action="login_check.php" method="post" id="form-login" class="form-horizontal form-bordered form-control-borderless">
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                        <input type="text" id="login-username" name="login-username" class="form-control input-lg" placeholder="Username">
                    </div><!--col-xs-12-->
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="gi gi-keys"></i></span>
                        <input type="password" id="login-password" name="login-password" class="form-control input-lg" placeholder="Password">
                    </div>
                </div>
            </div>
            <div class="form-group form-actions">
                <div class="col-xs-4">
                    <label class="switch switch-primary" data-toggle="tooltip" title="Remember Me?">
                        <input type="checkbox" id="login-remember-me" name="login-remember-me" checked>
                        <span></span>
                    </label>
                </div>
                <div class="col-xs-8 text-right">
                    <button type="submit" id="btn-login" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Login </button>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 response"></div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 text-center">
                    <a href="javascript:void(0)" id="link-reminder-login"><small>Forgot password?</small></a> -
                    <a href="javascript:void(0)" id="link-register-login"><small>Create a new account</small></a>
                </div>
            </div>
        </form>
        <!-- END Login Form -->

        <!-- Reminder Form -->
        <form action="login_full.php#reminder" method="post" id="form-reminder" class="form-horizontal form-bordered form-control-borderless display-none">
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                        <input type="text" id="reminder-email" name="reminder-email" class="form-control input-lg" placeholder="Email">
                    </div>
                </div>
            </div>
            <div class="form-group form-actions">
                <div class="col-xs-12 text-right">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Reset Password</button>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 text-center">
                    <small>Did you remember your password?</small> <a href="javascript:void(0)" id="link-reminder"><small>Login</small></a>
                </div>
            </div>
        </form>
        <!-- END Reminder Form -->

        <!-- Register Form -->
        <form action="login_full.php#register" method="post" id="form-register" class="form-horizontal form-bordered form-control-borderless display-none">
            <div class="form-group">
                <div class="col-xs-6">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                        <input type="text" id="register-firstname" name="register-firstname" class="form-control input-lg" placeholder="Firstname">
                    </div>
                </div>
                <div class="col-xs-6">
                    <input type="text" id="register-lastname" name="register-lastname" class="form-control input-lg" placeholder="Lastname">
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                        <input type="text" id="register-email" name="register-email" class="form-control input-lg" placeholder="Email">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                        <input type="password" id="register-password" name="register-password" class="form-control input-lg" placeholder="Password">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                        <input type="password" id="register-password-verify" name="register-password-verify" class="form-control input-lg" placeholder="Verify Password">
                    </div>
                </div>
            </div>
            <div class="form-group form-actions">
                <div class="col-xs-6">
                    <a href="#modal-terms" data-toggle="modal" class="register-terms">Terms</a>
                    <label class="switch switch-primary" data-toggle="tooltip" title="Agree to the terms">
                        <input type="checkbox" id="register-terms" name="register-terms">
                        <span></span>
                    </label>
                </div>
                <div class="col-xs-6 text-right">
                    <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Register Account</button>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 text-center">
                    <small>Do you have an account?</small> <a href="javascript:void(0)" id="link-register"><small>Login</small></a>
                </div>
            </div>
        </form>
        <!-- END Register Form -->
    </div>
    <!-- END Login Block -->
</div>
<!-- END Login Container -->

<!-- Modal Terms -->
<div id="modal-terms" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Terms &amp; Conditions</h4>
            </div>
            <div class="modal-body">
                <h4>Title</h4>
                <p>Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis ligula elit. Aliquam at orci ac neque semper dictum. Sed tincidunt scelerisque ligula, et facilisis nulla hendrerit non. Suspendisse potenti. Pellentesque non accumsan orci. Praesent at lacinia dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <p>Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis ligula elit. Aliquam at orci ac neque semper dictum. Sed tincidunt scelerisque ligula, et facilisis nulla hendrerit non. Suspendisse potenti. Pellentesque non accumsan orci. Praesent at lacinia dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <h4>Title</h4>
                <p>Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis ligula elit. Aliquam at orci ac neque semper dictum. Sed tincidunt scelerisque ligula, et facilisis nulla hendrerit non. Suspendisse potenti. Pellentesque non accumsan orci. Praesent at lacinia dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <p>Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis ligula elit. Aliquam at orci ac neque semper dictum. Sed tincidunt scelerisque ligula, et facilisis nulla hendrerit non. Suspendisse potenti. Pellentesque non accumsan orci. Praesent at lacinia dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <h4>Title</h4>
                <p>Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis ligula elit. Aliquam at orci ac neque semper dictum. Sed tincidunt scelerisque ligula, et facilisis nulla hendrerit non. Suspendisse potenti. Pellentesque non accumsan orci. Praesent at lacinia dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <p>Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis ligula elit. Aliquam at orci ac neque semper dictum. Sed tincidunt scelerisque ligula, et facilisis nulla hendrerit non. Suspendisse potenti. Pellentesque non accumsan orci. Praesent at lacinia dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
        </div>
    </div>
</div>
<!-- END Modal Terms -->

<?php include 'template_scripts.php'; ?>

<script type="text/javascript">
// Function for switching form views (login, reminder and register forms)
function switchView(viewHide, viewShow, viewHash){
    viewHide.slideUp(250);
    viewShow.slideDown(250, function(){
        $('input').placeholder();
    });

    if ( viewHash ) {
        window.location = '#' + viewHash;
    } else {
        window.location = '#';
    }
};

var formLogin       = $('#form-login'),
    formReminder    = $('#form-reminder'),
    formRegister    = $('#form-register');

$('#link-register-login').click(function(){
    switchView(formLogin, formRegister, 'register');
});

$('#link-register').click(function(){
    switchView(formRegister, formLogin, '');
});

$('#link-reminder-login').click(function(){
    switchView(formLogin, formReminder, 'reminder');
});

$('#link-reminder').click(function(){
    switchView(formReminder, formLogin, '');
});

// If the link includes the hashtag 'register', show the register form instead of login
if (window.location.hash === '#register') {
    formLogin.hide();
    formRegister.show();
}

// If the link includes the hashtag 'reminder', show the reminder form instead of login
if (window.location.hash === '#reminder') {
    formLogin.hide();
    formReminder.show();
}

/*
*  Jquery Validation, Check out more examples and documentation at https://github.com/jzaefferer/jquery-validation
*/

/* Login form - Initialize Validation */
$('#form-login').validate({
    errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
    errorElement: 'div',
    errorPlacement: function(error, e) {
        e.parents('.form-group > div').append(error);
    },
    highlight: function(e) {
        $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
        $(e).closest('.help-block').remove();
    },
    success: function(e) {
        e.closest('.form-group').removeClass('has-success has-error');
        e.closest('.help-block').remove();
    },
    rules: {
        'login-username': {
            required: true
        },
        'login-password': {
            required: true,
            minlength: 5
        }
    },
    messages: {
        'login-username': {
            required: 'Please provide your username'
        },
        'login-password': {
            required: 'Please provide your password',
            minlength: 'Your password must be at least 5 characters long'
        }
    },
    submitHandler: function() {
        var url = $( '#form-login' ).attr('action');
        var data = $( '#form-login' ).serializeArray();

        $.ajax({
            url: url,
            data: data,
            method: 'post',
            dataType: 'json',

            // If error occurs
            error: function(xhr) {
                $('#form-login .response').html('<div class="alert alert-danger alert-dismissable"><i class="fa fa-close"></i> An error occured: ' + xhr.status + ' - ' + xhr.statusText + '</div>');
            },

            // Before send the request
            beforeSend: function() {
                $('#btn-login').button('loading');
                NProgress.start();
            },

            // After complete
            complete: function() {
                $('#btn-login').button('reset');
                NProgress.done();
            },

            // If success occurs
            success: function(r) {
                
                $('#form-login .response').html(r.html);
                
                // If response for the server is a 'success-message'
                if ( r.result ) {
                    $('#btn-login').button('loading');
                    NProgress.start();
                    
                    window.location.replace('home.php');
                }else{
                    setTimeout(function(){
                        // Delete success message after 3 seconds
                        $('#form-login .response div').fadeOut(600);
                    }, 2500);
                }
                
            }
        });
    }
});

/* Reminder form - Initialize Validation */
$('#form-reminder').validate({
    errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
    errorElement: 'div',
    errorPlacement: function(error, e) {
        e.parents('.form-group > div').append(error);
    },
    highlight: function(e) {
        $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
        $(e).closest('.help-block').remove();
    },
    success: function(e) {
        e.closest('.form-group').removeClass('has-success has-error');
        e.closest('.help-block').remove();
    },
    rules: {
        'reminder-email': {
            required: true,
            email: true
        }
    },
    messages: {
        'reminder-email': 'Please enter your account\'s email'
    }
});

/* Register form - Initialize Validation */
$('#form-register').validate({
    errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
    errorElement: 'div',
    errorPlacement: function(error, e) {
        e.parents('.form-group > div').append(error);
    },
    highlight: function(e) {
        $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
        $(e).closest('.help-block').remove();
    },
    success: function(e) {
        if (e.closest('.form-group').find('.help-block').length === 2) {
            e.closest('.help-block').remove();
        } else {
            e.closest('.form-group').removeClass('has-success has-error');
            e.closest('.help-block').remove();
        }
    },
    rules: {
        'register-firstname': {
            required: true,
            minlength: 2
        },
        'register-lastname': {
            required: true,
            minlength: 2
        },
        'register-email': {
            required: true,
            email: true
        },
        'register-password': {
            required: true,
            minlength: 5
        },
        'register-password-verify': {
            required: true,
            equalTo: '#register-password'
        },
        'register-terms': {
            required: true
        }
    },
    messages: {
        'register-firstname': {
            required: 'Please enter your firstname',
            minlength: 'Please enter your firstname'
        },
        'register-lastname': {
            required: 'Please enter your lastname',
            minlength: 'Please enter your lastname'
        },
        'register-email': 'Please enter a valid email address',
        'register-password': {
            required: 'Please provide a password',
            minlength: 'Your password must be at least 5 characters long'
        },
        'register-password-verify': {
            required: 'Please provide a password',
            minlength: 'Your password must be at least 5 characters long',
            equalTo: 'Please enter the same password as above'
        },
        'register-terms': {
            required: 'Please accept the terms!'
        }
    }
});
</script>

<?php include 'template_end.php'; ?>