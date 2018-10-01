<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Food</title>
    <link rel="shortcut icon" href="<?= $assets ?>images/icon.png"/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="<?= $assets ?>dist/css/styles.css" rel="stylesheet" type="text/css"/>
    <?= $Settings->rtl ? '<link href="' . $assets . 'dist/css/rtl.css" rel="stylesheet" />' : ''; ?>
    <script src="<?= $assets ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
</head>
<body class="skin-green fixed sidebar-mini">
<div class="wrapper rtl rtl-inv">

    <header class="main-header">
        <a href="<?= admin_url(); ?>" class="logo">
            <?php if ($store) { ?>
                <span class="logo-mini"><?= $store->code; ?></span>
                <span class="logo-lg"><?= isset($store->name) ? 'Food<b>Trace</b>' : $store->name; ?></span>
            <?php } else { ?>
                <span class="logo-mini">POS</span>
                <span class="logo-lg"><?= isset($Settings->site_name) ? 'Food<b>Trace</b>' : $Settings->site_name; ?></span>
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
                                src="<?= $assets; ?>images/<?= $Settings->selected_language; ?>.png"
                                alt="<?= $Settings->selected_language; ?>"></a>
                    <ul class="dropdown-menu">
                        <?php $scanned_lang_dir = array_map(function ($path) {
                            return basename($path);
                        }, glob(APPPATH . 'language/*', GLOB_ONLYDIR));
                        foreach ($scanned_lang_dir as $entry) { ?>
                            <li><a href="<?= admin_url('pos/language/' . $entry); ?>"><img
                                            src="<?= $assets; ?>images/<?= $entry; ?>.png"
                                            class="language-img"> &nbsp;&nbsp;<?= ucwords($entry); ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
                <?php if ($Settings->multi_store && !$this->session->userdata('has_store_id') && $this->session->userdata('store_id')) { ?>
                    <li>
                        <a href="<?= admin_url('stores/deselect_store'); ?>" data-toggle="tooltip" data-placement="right"
                           title="<?= lang('deselect_store'); ?>"><i class="fa fa-square"></i></a>
                    </li>
                <?php } ?>
            </ul>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="hidden-xs hidden-sm"><a href="#" class="clock"></a></li>
                    <li class="hidden-xs"><a href="<?= admin_url(); ?>" data-toggle="tooltip" data-placement="bottom"
                                             title="<?= lang('dashboard'); ?>"><i class="fa fa-dashboard"></i></a></li>
                    <?php if ($Admin) { ?>
                        <li class="hidden-xs"><a href="<?= admin_url('settings'); ?>" data-toggle="tooltip"
                                                 data-placement="bottom" title="<?= lang('settings'); ?>"><i
                                        class="fa fa-cogs"></i></a></li>
                    <?php } ?>
                    <?php if ($this->db->dbdriver != 'sqlite3') { ?>
                        <li><a href="<?= admin_url('pos/view_bill'); ?>" target="_blank" data-toggle="tooltip"
                               data-placement="bottom" title="<?= lang('view_bill'); ?>"><i
                                        class="fa fa-desktop"></i></a></li>
                    <?php } ?>
                    <li><a href="<?= admin_url('pos'); ?>" data-toggle="tooltip" data-placement="bottom"
                           title="<?= lang('pos'); ?>"><i class="fa fa-th"></i></a></li>
                    <?php if ($Admin && $this->session->userdata('store_id')) { ?>
                        <li>
                            <a href="<?= admin_url('reports/alerts'); ?>" data-toggle="tooltip" data-placement="bottom"
                               title="<?= lang('alerts'); ?>">
                                <i class="fa fa-bullhorn"></i>
                                <span class="label label-warning"><?= $qty_alert_num; ?></span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($this->session->userdata('store_id')) { ?>
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell-o"></i>
                                <span class="label label-warning"><?= sizeof($suspended_sales); ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header"><?= lang('recent_suspended_sales'); ?></li>
                                <li>
                                    <ul class="menu">
                                        <li>
                                            <?php
                                            foreach ($suspended_sales as $ss) {
                                                echo '<a href="' . admin_url('pos/?hold=' . $ss->id) . '" class="load_suspended">' . $this->tec->hrld($ss->date) . ' (' . $ss->customer_name . ')<br><strong>' . $ss->hold_ref . '</strong></a>';
                                            }
                                            ?>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer"><a
                                            href="<?= admin_url('sales/opened'); ?>"><?= lang('view_all'); ?></a></li>
                            </ul>
                        </li>
                    <?php } ?>
                    <li class="dropdown user user-menu" style="padding-right:5px;">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?= base_url('uploads/avatar/' . ($this->session->userdata('avatar') ? $this->session->userdata('avatar') : 'default_avatar.png')) ?>"
                                 class="user-image" alt="Avatar"/>
                            <span class="hidden-xs"><?= $this->session->userdata('name'); ?></span>
                        </a>
                        <ul class="dropdown-menu" style="padding-right:3px;">
                            <li class="user-header">
                                <img src="<?= base_url('uploads/avatar/' . ($this->session->userdata('avatar') ? $this->session->userdata('avatar') : 'default_avatar.png')) ?>"
                                     class="img-circle" alt="Avatar"/>
                                <?php
                                if (!$Admin) {
                                    ?>
                                    <p>
                                        <?= $this->session->userdata('email'); ?>
                                        <small><?= lang('member_since') . ' ' . $this->session->userdata('created_on'); ?></small>
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
                                    <a href="<?= admin_url('logout'); ?>"
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
                <!-- <li class="header"><?= lang('mian_navigation'); ?></li> -->

                <li class="mm_welcome"><a href="<?= admin_url(); ?>"><i class="fa fa-dashboard"></i>
                        <span><?= lang('dashboard'); ?></span></a></li>


                <?php if ($Admin) { ?>


                    <li class="treeview mm_products">
                        <a href="#">
                            <i class="fa fa-barcode"></i>
                            <span><?= lang('products'); ?></span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li id="products_index"><a href="<?= admin_url('products'); ?>"><i
                                            class="fa fa-circle-o"></i> <?= lang('list_products'); ?></a></li>
                            <li id="products_add"><a href="<?= admin_url('products/add'); ?>"><i
                                            class="fa fa-circle-o"></i> <?= lang('add_products'); ?></a></li>
                            <li id="products_import"><a href="<?= admin_url('products/import'); ?>"><i
                                            class="fa fa-circle-o"></i> <?= lang('import_products'); ?></a></li>
                            <li class="divider"></li>

                        </ul>
                    </li>
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


                    <li class="treeview mm_auth mm_user mm_suppliers">
                        <a href="#">
                            <i class="fa fa-users"></i>
                            <span><?= lang('company'); ?></span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li id="auth_users"><a href="<?= admin_url('company'); ?>"><i
                                            class="fa fa-circle-o"></i> <?= lang('list_company'); ?></a></li>
                            <li id="auth_add"><a href="<?= admin_url('company/add'); ?>"><i
                                            class="fa fa-circle-o"></i> <?= lang('add_company'); ?></a></li>
                            <li class="divider"></li>

                        </ul>
                    </li>


                <?php } else { ?>

                    <li class="mm_products"><a href="<?= admin_url('products'); ?>"><i class="fa fa-barcode"></i>
                            <span><?= lang('products'); ?></span></a></li>
                    <li class="mm_categories"><a href="<?= admin_url('categories'); ?>"><i class="fa fa-folder-open"></i>
                            <span><?= lang('company'); ?></span></a></li>

                    <li class="treeview mm_customers">
                        <a href="#">
                            <i class="fa fa-users"></i>
                            <span><?= lang('customers'); ?></span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li id="customers_index"><a href="<?= admin_url('customers'); ?>"><i
                                            class="fa fa-circle-o"></i> <?= lang('list_customers'); ?></a></li>
                            <li id="customers_add"><a href="<?= admin_url('customers/add'); ?>"><i
                                            class="fa fa-circle-o"></i> <?= lang('add_customer'); ?></a></li>
                        </ul>
                    </li>

                <?php } ?>
            </ul>
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
