<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
$system_name  = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Food</title>
    <link rel="shortcut icon" href="<?= $assets ?>images/icon.png"/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="<?= $assets ?>dist/css/styles.css" rel="stylesheet" type="text/css"/>
    <link href="<?= $assets ?>plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?= $assets ?>plugins/iCheck/all.css" rel="stylesheet" type="text/css"/>

    <script src="<?= $assets ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
</head>
<body class="skin-green fixed sidebar-mini">
<div class="wrapper rtl rtl-inv">

    <header class="main-header">
        <a href="<?= admin_url(); ?>" class="logo">
            <?php if (isset($store)) { ?>
                <span class="logo-mini"><?= $store->code; ?></span>
                <span class="logo-lg"><?= isset($store->name) ? 'Food<b>Trace</b>' : $store->name; ?></span>
            <?php } else { ?>
                <span class="logo-mini">Trace</span>
                <span class="logo-lg"><?= isset($Settings->site_name) ? 'Food<b>Trace</b>' : $system_name ?></span>
            <?php } ?>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <ul class="nav navbar-nav pull-left">
                <li class="dropdown hidden-xs">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img
                                src="<?= $assets; ?>images/<?= $Settings['selected_language']; ?>.png"
                                alt="<?= $Settings['selected_language']; ?>"></a>
                    <ul class="dropdown-menu">
                        <?php $scanned_lang_dir = array_map(function ($path) {
                            return basename($path);
                        }, glob(APPPATH . 'language/*', GLOB_ONLYDIR));
                        foreach ($scanned_lang_dir as $entry) { ?>
                            <li><a href="<?= site_url('language/index/' . $entry); ?>"><img
                                            src="<?= $assets; ?>images/<?= $entry; ?>.png"
                                            class="language-img"> &nbsp;&nbsp;<?= ucwords($entry); ?></a></li>
                        <?php } ?>
                    </ul>
                </li>

            </ul>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="hidden-xs hidden-sm"><a href="#" class="clock"></a></li>
                    <li class="hidden-xs"><a href="<?= site_url(); ?>" data-toggle="tooltip" data-placement="bottom"
                                             title="<?= lang('dashboard'); ?>"><i class="fa fa-dashboard"></i></a></li>
                    <?php if (isset($user_type)) { ?>
                        <li class="hidden-xs"><a href="<?= admin_url('settings'); ?>" data-toggle="tooltip"
                                                 data-placement="bottom" title="<?= lang('settings'); ?>"><i
                                        class="fa fa-cogs"></i></a></li>
                    <?php } ?>



                    <li class="dropdown user user-menu" style="padding-right:5px;">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?= base_url('uploads/avatar/' . ($this->session->userdata('avatar') ? $this->session->userdata('avatar') : 'default_avatar.png')) ?>"
                                 class="user-image" alt="Avatar"/>
                            <span class="hidden-xs"><?= $this->session->userdata('user_data')->name; ?></span>
                        </a>
                        <ul class="dropdown-menu" style="padding-right:3px;">
                            <li class="user-header">
                                <img src="<?= base_url('uploads/avatar/' . ($this->session->userdata('avatar') ? $this->session->userdata('avatar') : 'default_avatar.png')) ?>"
                                     class="img-circle" alt="Avatar"/>
                                <?php
                                if ($user_type) {
                                    ?>
                                    <p>
                                        <?= $this->session->userdata('user_data')->email; ?>
                                        <small><?= lang('member_since') . ' ' . $this->session->userdata('user_data')->create_at; ?></small>
                                    </p>
                                    <?php
                                }
                                ?>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="<?= admin_url('users/profile/' . $this->session->userdata('user_id')); ?>"
                                       class="btn btn-default btn-flat"><?= lang('profile'); ?></a>
                                </div>
                                <div class="pull-right">
                                    <a href="<?= site_url('Auth/logout'); ?>"
                                       class="btn btn-default btn-flat<?= $this->session->userdata('register_id') ? ' logout' : ''; ?>"><?= lang('logout'); ?></a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu">

                <li class="mm_welcome"><a href="<?= admin_url(); ?>"><i class="fa fa-dashboard"></i>
                        <span><?= lang('dashboard'); ?></span></a></li>


                <?php if ($user_type == 1) { ?>



                    <li class="treeview mm_company">
                        <a href="#">
                            <i class="fa fa-folder"></i>
                            <span><?= lang('company'); ?></span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li id="company_index"><a href="<?= admin_url('company/listCompany'); ?>"><i
                                            class="fa fa-circle-o"></i> <?= lang('list_company'); ?></a></li>
                            <li id="company_add"><a href="<?= admin_url('company/addCompany'); ?>"><i
                                            class="fa fa-circle-o"></i> <?= lang('add_company'); ?></a></li>
                        </ul>
                    </li>





                <?php } else{ ?>
                    <li id="auth_users"><a href="<?= partner_url('Profile/profile'); ?>"><i
                                    class="fa fa-user"></i> <?= lang('profile'); ?></a>
                    </li>
                    <li class="treeview mm_products">
                        <a href="#">
                            <i class="fa fa-barcode"></i>
                            <span><?= lang('products'); ?></span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li id="products_index"><a href="<?= partner_url('product'); ?>"><i
                                            class="fa fa-circle-o"></i> <?= lang('list_products'); ?></a></li>
                            <li id="products_add"><a href="<?= partner_url('product/add'); ?>"><i
                                            class="fa fa-circle-o"></i> <?= lang('add_products'); ?></a></li>
                            <li id="products_import"><a href="<?= partner_url('product/import'); ?>"><i
                                            class="fa fa-circle-o"></i> <?= lang('import_products'); ?></a></li>
                            <li class="divider"></li>

                        </ul>
                    </li>
                    <li class="treeview mm_auth mm_user mm_suppliers">
                        <a href="#">
                            <i class="fa fa-cab"></i>
                            <span><?= lang('product_type'); ?></span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li id="auth_users"><a href="<?= partner_url('productType'); ?>"><i
                                            class="fa fa-circle-o"></i> <?= lang('list_product_type'); ?></a></li>
                            <li id="auth_add"><a href="<?= partner_url('productType/add'); ?>"><i
                                            class="fa fa-circle-o"></i> <?= lang('add_product_type'); ?></a></li>
                            <li class="divider"></li>

                        </ul>
                    </li>
                <?php } ?>
            </ul>
            <div class="sidebar-background" style="background-image: url(<?= $assets ?>images/sidebar-1.jpg)"></div>
        </section>
    </aside>

    <div class="content-wrapper">
        <section class="content-header">
            <h1><?= $page_title; ?></h1>
            <ol class="breadcrumb">
                <li><a href="<?= admin_url(); ?>"><i class="fa fa-dashboard"></i> <?= lang('home'); ?></a></li>
                <?php
                foreach ($bc as $b) {
                    if ($b['link'] === '#') {
                        echo '<li class="active">' . $b['page'] . '</li>';
                    } else {
                        echo '<li><a href="' . $b['link'] . '">' . $b['page'] . '</a></li>';
                    }
                }
                ?>
            </ol>
        </section>

        <div class="col-lg-12 alerts">
            <div id="custom-alerts" style="display:none;">
                <div class="alert alert-dismissable">
                    <div class="custom-msg"></div>
                </div>
            </div>
            <?php if ($error) { ?>
                <div class="alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="icon fa fa-ban"></i> <?= lang('error'); ?></h4>
                    <?= $error; ?>
                </div>
            <?php }
            if ($warning) { ?>
                <div class="alert alert-warning alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="icon fa fa-warning"></i> <?= lang('warning'); ?></h4>
                    <?= $warning; ?>
                </div>
            <?php }
            if ($message) { ?>
                <div class="alert alert-success alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="icon fa fa-check"></i> <?= lang('Success'); ?></h4>
                    <?= $message; ?>
                </div>
            <?php } ?>
        </div>
        <div class="clearfix"></div>
