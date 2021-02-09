<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>AID</title>
    <link rel="shortcut icon" href="<?=base_url()?>assets/img/dens_tv.png">
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/animate.css/animate.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/app.min.css">
</head>

    <body data-sa-theme="9">
        <form action="<?php echo base_url('auth/process'); ?>" method="post">
            <div class="login">
                <div class="login__block active" id="l-login">
                    <div class="login__block__header">
                        <i class="zmdi zmdi-account-circle"></i>
                        Hi there! Please Sign in
                        <?php
                        echo show_err_msg($this->session->flashdata('error_msg'));
                        ?>
                    </div>
                    <div class="login__block__body">
                        <div class="form-group">
                            <input type="text" name="username" class="form-control" placeholder="Username">
                        </div>

                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="Password">
                        </div>

                        <button type="submit" name="login" class="btn btn-success btn-block btn-flat">Sign In</button>
                    </div>
                </div>
            </div>
        </form>


        <script src="<?=base_url()?>assets/vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/bower_components/popper.js/dist/umd/popper.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="<?=base_url()?>assets/js/app.min.js"></script>

    </body>
</html>