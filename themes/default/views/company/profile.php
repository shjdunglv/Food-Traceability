<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#edit_profile"><?= lang('edit'); ?></a></li>

                </ul>
                <div class="tab-content">
                    <div id="edit_profile" class="tab-pane active">
                        <div class="col-lg-6">
                            <p><?= lang('update_info'); ?></p>
                            <?=form_open('auth/edit_user/' . $company->id);?>
                            <div class="form-group">
                                <?= lang('code_of_company', 'code_of_company'); ?>
                                <?= form_input('code_of_company', $company->id, 'class="form-control tip" id="first_name"  required="required" disabled'); ?>
                            </div>
                            <div class="form-group">
                                <?= lang('name_of_company', 'name_of_company'); ?>
                                <?= form_input('name_of_company', $company->name, 'class="form-control tip" id="name_of_company"  required="required"'); ?>
                            </div>
                            <div class="form-group">
                                <?= lang('address_of_company', 'address_of_company'); ?>
                                <?= form_input('address_of_company',isset($company->phone)?$company->phone:'', 'class="form-control tip" id="address_of_company"  required="required"'); ?>
                            </div>
                            <div class="form-group">
                                <?= lang('phone', 'phone'); ?>
                                <?= form_input('phone', $company->phone, 'class="form-control tip" id="phone"  required="required"'); ?>
                            </div>



                            <div class="form-group">
                                <?= lang('email', 'email'); ?>
                                <?= form_input('email', isset($company->email)?$company->email:'', 'class="form-control tip" id="email"  required="required"'); ?>
                            </div>
                            <?php if ($Admin && $id != $this->session->userdata('user_id')) { ?>
                                <div class="panel panel-warning">
                                    <div class="panel-heading"><?= lang('if_you_need_to_rest_password_for_user') ?></div>
                                    <div class="panel-body" style="padding: 5px;">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php echo lang('password', 'password'); ?>
                                                <?php echo form_input($password); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php echo lang('confirm_password', 'password_confirm'); ?>
                                                <?php echo form_input($password_confirm); ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <?= lang('status', 'status'); ?>
                                    <?php
                                    $opt = array('' => '', 1 => lang('Active'), 0 => lang('Unconfirmed'), 2 => lang('Banned'));
                                    echo form_dropdown('status', $opt, $company->status, 'id="status" data-placeholder="' . lang("select") . ' ' . lang("status") . '" class="form-control input-tip select2" style="width:100%;"');
                                    ?>
                                </div>

                            <?php } ?>

                            <?php echo form_hidden('id', $id); ?>
                            <?php echo form_hidden($csrf); ?>
                            <div class="form-group">
                                <?= form_submit('update_company_info', lang('update'), 'class="btn btn-primary"'); ?>
                            </div>
                            <?= form_close(); ?>
                            <div class="clearfix"></div>
                        </div>

                        <div class="col-lg-6">
                            <?=
                            $company->photo_passport ? '<img alt="" src="' . base_url() . 'uploads/photo_passport/' . $company->photo_passport . '" class="avatar img-thumbnail img-rounded">' :
                                '<img alt="" src="' . base_url() . 'uploads/photo_passport/default_img.png" class="avatar img-thumbnail img-rounded">';
                            ?>


                            <div class="form-group">
                                <?= lang("change_avatar", "change_avatar"); ?>
                                <input type="file" data-browse-label="<?= lang('browse'); ?>" name="avatar" id="product_image" required="required"
                                       data-show-upload="false" data-show-preview="false" accept="image/*"
                                       class="form-control file"/>
                            </div>

                        </div>

                    </div>




                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</section>

