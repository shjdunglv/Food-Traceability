<!DOCTYPE html>
<?php
$system_title = $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;
$system_name  = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;
?>
<html lang="en">
    <head>
        <title><?php echo $system_title?></title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css');?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/font.css');?>">


         <!-- Styles -->
        <link href="<?php echo base_url();?>assets/login_page/css/login_layout.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url();?>assets/login_page/css/elements.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url();?>assets/login_page/css/custom.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url('assets/login_page/css/font-awesome.min.css');?>">
<!--        <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />-->

        <!-- SCRIPTS -->
        <script type="text/javascript">
        var global_base_url = "<?php echo site_url('/') ?>";
        </script>
        <script src="<?php echo base_url('assets/login_page/js/vendor/jquery-1.12.0.min.js');?>"></script>
        <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<!--        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>-->


        <!-- Favicon: http://realfavicongenerator.net -->
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url() ?>images/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" href="<?php echo base_url() ?>images/favicon/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="<?php echo base_url() ?>images/favicon/favicon-16x16.png" sizes="16x16">
        <link rel="manifest" href="<?php echo base_url() ?>images/favicon/manifest.json">
        <link rel="mask-icon" href="<?php echo base_url() ?>images/favicon/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="theme-color" content="#ffffff">


        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->


    </head>
    <body>
    <div class="wrapper">
    <div class="container">
    <div class="row">
        <div class="col-lg-12 alerts">
            <div id="custom-alerts" style="display:none;">
                <div class="alert alert-dismissable">
                    <div class="custom-msg"></div>
                </div>
            </div>
            <?php if (!empty($this->session->flashdata('error'))) { ?>
                <div class="alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="icon fa fa-ban"></i> <?= lang('error'); ?></h4>
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php }
            if (!empty($this->session->flashdata('warning'))) { ?>
                <div class="alert alert-warning alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="icon fa fa-warning"></i> <?= lang('warning'); ?></h4>
                    <?= $this->session->flashdata('warning'); ?>
                </div>
            <?php }
            if (!empty($this->session->flashdata('message'))) { ?>
                <div class="alert alert-success alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="icon fa fa-check"></i> <?= lang('Success'); ?></h4>
                    <?= $this->session->flashdata('message'); ?>
                </div>
            <?php } ?>
        </div>
    <div class="col-md-12">


        <?php include $page_name.'.php'; ?>

    </div>
    </div>
    </div>

        <ul class="bg-bubbles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>

</div>
    </body>
</html>
