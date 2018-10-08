<div class="container">
    <div class="row">
        <div class="col-md-5 center-block-e">



            <div class="login-form">

                <div class="login-form-inner">
                    <?php $gl = $this->session->flashdata('globalmsg'); ?>
                    <?php if(!empty($gl)) :?>
                        <div class="alert alert-success"><b><span class="glyphicon glyphicon-ok"></span></b> <?php echo $this->session->flashdata('globalmsg') ?></div>
                    <?php endif; ?>
                    <?php $gl = $this->session->flashdata('error'); ?>
                    <?php if(!empty($gl)) :?>
                        <div class="alert alert-danger"><b><span class="glyphicon glyphicon-ok"></span></b> <?php echo $this->session->flashdata('error') ?></div>
                    <?php endif; ?>
                    <p class="login-form-intro"><img src="<?php echo base_url() ?>assets/login_page/img/ava2.png" width="100"></p>
                    <?php if(isset($_GET['redirect'])) : ?>
                        <?php echo form_open(site_url("login/pro/" . urlencode($_GET['redirect'])), array("id" => "login_form")) ?>
                    <?php else : ?>
                        <?php echo form_open(site_url("Auth/submit_register"), array("id" => "register_form")) ?>
                    <?php endif; ?>
                    <div class="form-group login-form-area has-feedback">
                        <input type="text" class="form-control" name="email" placeholder="<?php echo lang("email") ?>">
                        <i class="glyphicon glyphicon-user form-control-feedback login-icon-color"></i>
                    </div>
                    <div class="form-group login-form-area has-feedback">
                        <input type="text" class="form-control" name="name" placeholder="<?php echo lang("name") ?>">
                        <i class="glyphicon glyphicon-user form-control-feedback login-icon-color"></i>
                    </div>
                    <div class="form-group login-form-area has-feedback">
                        <input type="password" name="password" class="form-control" placeholder="<?=lang('password')?>">
                        <i class="glyphicon glyphicon-lock form-control-feedback login-icon-color"></i>
                    </div>
                    <div class="form-group login-form-area has-feedback">
                        <input type="password" name="comfirm_password" class="form-control" placeholder="<?=lang('confirm_password')?>">
                        <i class="glyphicon glyphicon-lock form-control-feedback login-icon-color"></i>
                    </div>

                    <p><input type="submit" class="btn btn-flat-login form-control" value="<?php echo lang("register") ?>"></p>
                    <p class="decent-margin small-text"><a href="<?php echo site_url("login/forgotpw") ?>"><?php echo lang("forgot_your_password") ?></a> <span class="pull-right"><a href="<?php echo site_url("Authlogin") ?>"><?php echo lang("login") ?></a></span></p>
                </div>
                <div class="login-form-bottom clearfix">

                    <hr>
                    <?php echo form_close() ?>
                </div>


            </div>


        </div>
    </div>
</div>

<div class="login-footer">

</div>
