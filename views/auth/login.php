<?php
/**
 * Login View
 *
 * @author       Firoz Ahmad Likhon <likh.deshi@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Bootstrap 3.3.6 -->

<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/ionicons.min.css');?>">

<link href="<?php echo base_url('assets/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">
<!-- Font Awesome -->

<!-- Theme style -->
<link rel="stylesheet" href="<?php echo base_url('assets/css/AdminLTE.min.css');?>">
<!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="<?php echo base_url('assets/css/skins/_all-skins.min.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/blue.css');?>">

<link href="<?php echo base_url('assets/css/dataTables.bootstrap.css')?>" rel="stylesheet">



<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo base_url('assets/js/jquery.min.js');?>"></script>
<script>
window.jQuery || document.write('<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"><\/script>')
</script>
<script src="<?php echo base_url('assets/js/jquery-ui.min.js');?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script src="<?php echo base_url('assets/js/jquery.form-validator.min.js');?>"></script>
<script>
$.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
  <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap-datepicker.min.js')?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/js/app.min.js');?>"></script>
<!-- input mask -->
<script src="<?php echo base_url('assets/moment/moment.min.js');?>"></script>
<script src="<?php echo base_url('assets/inputmask/min/jquery.inputmask.bundle.min.js');?>"></script>


<!-- iCheck -->
<script src="<?php echo base_url('assets/js/icheck.min.js');?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('assets/js/demo.js');?>"></script>
<script src="<?php echo base_url('assets/js/custom.js');?>"></script>

<script src="<?php echo base_url('assets/js/icheck.min.js');?>"></script>

<script src="<?php echo base_url('assets/js/bootstrap-select.min.js')?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.bootstrap.js')?>"></script>

<script>
$(function() {
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });
});
</script>
<body class="hold-transition login-page">
    <div class="login-box">
       
        <!-- /.login-logo -->
        <div class="login-box-body">
            <h3 class="login-box-msg">Login in to start your session</h3>
            <?php if($this->session->flashdata("messagePr")){?>
            <div class="alert alert-info">
                <?php echo $this->session->flashdata("messagePr")?>
            </div>
            <?php } ?>
            <form class="form-signin" method="post" id="loginForm" action="<?= site_url('login') ?>">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                    value="<?= $this->security->get_csrf_hash(); ?>">
              <!--   <h1 class="h3 mb-3 font-weight-normal">Please Login Here!</h1> -->
                <?= isset($failed) && !empty($failed) ? "<p class='err'>{$failed}</p>" : ""; ?>
                <?= $this->session->flashdata('success'); ?>
                <div class="form-group">
                    <label for="username" class="sr-only">UserName</label>
                    <?= form_error('username', '<div class="err">', '</div>'); ?>
                    <input type="text" id="inputEmail" class="form-control" placeholder="Username"
                        value="<?= set_value('username'); ?>" name="username" autofocus>
                </div>
                <div class="form-group">
                    <label for="password" class="sr-only">Password</label>
                    <?= form_error('password', '<div class="err">', '</div>'); ?>
                    <input type="password" id="inputPassword" class="form-control" placeholder="Password"
                        value="<?= set_value('password'); ?>" name="password">

                    <div class="checkbox mb-3">
                        <label>
                            <input type="checkbox" value="remember-me"> Remember me
                        </label>
                    </div>
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>

            </form>

        </div>
        <!-- /.login-box-body -->
    </div>
</body>