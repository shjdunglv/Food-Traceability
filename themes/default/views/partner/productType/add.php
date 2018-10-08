<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?= lang('enter_info'); ?></h3>
                </div>
                <div class="box-body">
                    <div class="col-lg-12">

                        <?php echo form_open_multipart(partner_url("productType/addNew"), 'class="validation"'); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?= lang('name', 'name'); ?>
                                    <?= form_input('type_name', set_value('name'), 'class="form-control tip" id="type_name"  required="required"'); ?>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-sm">

                                    <label class="input-group-addon no-border">
                                        <?= lang('date_expired', 'date_expired'); ?>
                                    </label>
                                        <div class="icheckbox_flat-green checked text-right" aria-checked="false" aria-disabled="false">
                                            <input type="checkbox" class="myCheck flat-red" name="productCheckList[]" value="date_expired" checked="" style="position: absolute; opacity: 0;" name="date_expired">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-sm">

                                        <label class="input-group-addon no-border">
                                            <?= lang('date_manufacte', 'date_manufacte'); ?>
                                        </label>
                                        <div class="icheckbox_flat-green checked text-right" aria-checked="false" aria-disabled="false">
                                            <input type="checkbox" class="myCheck flat-red" name="productCheckList[]" value="date_manufacte" checked="" style="position: absolute; opacity: 0;" name="date_manufacte">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-sm">

                                        <label class="input-group-addon no-border">
                                            <?= lang('date_harvest', 'date_harvest'); ?>
                                        </label>
                                        <div class="icheckbox_flat-green checked text-right" aria-checked="false" aria-disabled="false">
                                            <input type="checkbox" class="myCheck flat-red" name="productCheckList[]" value="date_harvest" checked="" style="position: absolute; opacity: 0;" name="date_harvest">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <?= lang('image', 'image'); ?>
                                    <input type="file" name="userfile" id="image">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <?= form_submit('add_product_type', lang('add_product_type'), 'class="btn btn-primary"'); ?>
                        </div>

                        <?php echo form_close(); ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section>
