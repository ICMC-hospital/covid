<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ICMC General Hospital - <?php echo $title;?></title>
    <meta name="description" content="overview &amp; stats" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <?php include('common.php'); ?>
</head>

<body class="hold-transition skin-black-light sidebar-mini" data-base-url="<?php echo base_url(); ?>">

    <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo base_url('PatientController/index');?>" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>IC</b>MC</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"> <small>
                    <i class="fa fa-hospital"></i>
                    ICMC General Hospital
                </small></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Control Sidebar Toggle Button -->
                    <!-- <li>
                          <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                        </li> -->
                    <!-- User Account: style can be found in dropdown.less -->

                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img class="user-image" src="<?php echo base_url('');?>assets/avatars/avatar2.png"
                                alt="Admin Photo" />
                            <span class="hidden-xs"><?php echo $this->session->userdata('fullName') ?></span> </a>
                        <ul class="dropdown-menu" role="menu" style="width: 164px;">
                            <li><a href="<?php echo base_url('user/profile');?>"><i class="fa fa-user mr10"></i>My
                                    Account</a></li>
                                    <li><a href="<?php echo base_url('UserController/change_password');?>"><i class="fa fa-user mr10"></i>
                                    Change Password</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url('login/logout');?>"><i class="fa fa-power-off mr10"></i>
                                    Sign Out</a></li>
                        </ul>
                    </li>
                </ul>

            </div>
        </nav>
    </header>


    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar" style="height: auto;">

            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu tree" data-widget="tree">

                <li class="<?php echo $title == 'Home' ? 'active' : '' ?>">
                    <a href="<?php echo base_url('DashboardController/index');?>">
                        <i class="menu-icon fa fa-tachometer"></i>
                        <span class="menu-text"> Dashboard </span>
                    </a>

                    <b class="arrow"></b>
                </li>

                
            <?php if($this->auth->can('view_patient')): ?>
            <li class="<?php echo $title == 'index' ? 'active' : ''?>">
                    <a href="<?php echo base_url('PatientController/index');?>">
                        <i class="menu-icon fa fa-users"></i>
                        <span class="menu-text"> Client/Patient </span>
                    </a>

                    <b class="arrow"></b>
                </li>

            <?php else : ?>

            <?php endif; ?>
               
               <?php if($this->auth->can('view_sample')): ?>
                <li class="<?php echo $title == 'index' ? 'active' : ''?>">
                    <a href="<?php echo base_url('SampleController/index');?>">
                        <i class="menu-icon fa fa-list-alt"></i>
                        <span class="menu-text"> Sample Collection </span>
                    </a>

                    <b class="arrow"></b>
                </li>
                 <?php endif; ?>
                  <?php if($this->auth->can('view_lab_result')): ?>
                <li class="<?php echo $title == 'index' ? 'active' : ''?>">
                    <a href="<?php echo base_url('LabController/index');?>">
                        <i class="menu-icon fa fa-list-alt"></i>
                        <span class="menu-text"> LabResult </span>
                    </a>

                    <b class="arrow"></b>
                </li>
                  <?php endif;?>
                   <?php if($this->auth->can('maintain_settings')): ?>
                <li class="treeview">
                    <a href="#"> <i class="menu-icon fa fa-chevron-circle-right"></i> Settings</a>
                    <ul class="treeview-menu">
                        <li class="<?php echo $title == 'index' ? 'active' : ''?>">
                            <a href="<?php echo base_url('UserController/index');?>">
                                <i class="menu-icon fa fa-circle"></i>
                                <span class="menu-text"> Users </span>
                            </a>

                            <b class="arrow"></b>
                    </ul>

		   <ul class="treeview-menu">
                        <li class="<?php echo $title == 'index' ? 'active' : ''?>">
                            <a href="<?php echo base_url('MembersController/index');?>">
                                <i class="menu-icon fa fa-circle"></i>
                                <span class="menu-text"> Members </span>
                            </a>

                            <b class="arrow"></b>
                    </ul>

                     <ul class="treeview-menu">
                        <li class="<?php echo $title == 'index' ? 'active' : ''?>">
                            <a href="<?php echo base_url('UserController/role_permissions');?>">
                                <i class="menu-icon fa fa-circle"></i>
                                <span class="menu-text"> Role Permission </span>
                            </a>

                            <b class="arrow"></b>
                    </ul>

                </li>
 <?php endif;?>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->

    <!-- Main content -->
    <section class="content">
        <div class="content-wrapper clearfix">
            <!-- Main content -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-body">
                            <?php echo $contents;?>
                        </div>

                    </div>
                </div>
            </div>

    </section>
    <!-- /.content -->

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0
        </div>
        <strong> Copyright � ICMC.com.</strong> All rights
        reserved.
    </footer>

</body>

</html>