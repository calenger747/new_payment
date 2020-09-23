<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url(); ?>app-assets/images/AAI Icon.ico">
    <title>Payment Gateway Healtcare System</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?= base_url(); ?>app-assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url(); ?>app-assets/css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="<?= base_url(); ?>app-assets/css/colors/blue.css" id="theme" rel="stylesheet">
    <!-- toast CSS -->
    <link href="<?= base_url(); ?>app-assets/plugins/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> 
        </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper">
        <div class="login-register" style="background-image:url(<?= base_url(); ?>app-assets/images/background/bg3.jpg);">
            <div class="row m-t-40">
                <div class="col-md-7 m-l-20 m-t-40">
                    <!-- <div class="card">
                        <div class="card-body">
                            <h1>Payment Gateway for Healtcare System</h1>
                            <div class="row"></div>
                        </div>
                    </div> -->
                </div>
                <div class="col-md-4 m-r-10 m-t-40">
                    <div class="card">
                        <div class="card-body">
                            <form class="form-horizontal form-material" id="loginform" action="<?= base_url(); ?>new_auth" autocomplete="off" method="POST">
                                <a href="javascript:void(0)" class="text-center db"><img src="<?= base_url(); ?>app-assets/images/aai.png" alt="Home" /><br/><img src="<?= base_url(); ?>app-assets/images/payment-text-2.png" alt="Home" /></a>
                                <div class="form-group m-t-40">
                                    <div class="col-xs-12">
                                        <input class="form-control" name="username" id="password" type="text" required="" placeholder="Username"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <input class="form-control" name="password" id="password" type="password" required="" placeholder="Password"> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12 font-14">
                                        <!-- <div class="checkbox checkbox-primary pull-left p-t-0">
                                            <input id="checkbox-signup" type="checkbox">
                                            <label for="checkbox-signup"> Remember me </label>
                                        </div> --> 
                                        <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"> Forgot Password?</a> 
                                    </div>
                                </div>
                                <div class="form-group text-center m-t-20">
                                    <div class="col-xs-12">
                                        <button type="submit" class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">LogIn</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="<?= base_url(); ?>app-assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?= base_url(); ?>app-assets/plugins/bootstrap/js/popper.min.html"></script>
    <script src="<?= base_url(); ?>app-assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?= base_url(); ?>app-assets/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="<?= base_url(); ?>app-assets/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="<?= base_url(); ?>app-assets/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="<?= base_url(); ?>app-assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="<?= base_url(); ?>app-assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="<?= base_url(); ?>app-assets/js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="<?= base_url(); ?>app-assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
    <!-- toast JS -->
    <script src="<?= base_url(); ?>app-assets/plugins/toast-master/js/jquery.toast.js"></script>
    <script src="<?= base_url(); ?>app-assets/js/toastr.js"></script>
    <?php if ($this->session->flashdata('notif')): ?>
        <script type="text/javascript">
            $(function() {
                "use strict";

                $.toast({
                    heading: 'Login Failed!',
                    text: '<?php echo $this->session->flashdata("notif"); ?>',
                    position: 'top-right',
                    loaderBg:'#ff6849',
                    icon: 'error',
                    hideAfter: 3500
                });
            });
        </script>
    <?php endif; ?>
</body>

</html>