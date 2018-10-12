<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?= lang('enter_info'); ?></h3>
                </div>
                <div class="box-body">
                    <?= form_open_multipart(site_url('API/Download_API/DownloadSampleFile'),array('id'=>'download_form')); ?>
                    <div class="well well-sm">
                        <a href="#" id="download_sample_file" type="submit"
                           class="btn btn-info btn-sm pull-right"><i
                                    class="fa fa-download"></i> <?= lang("download_sample_file"); ?></a>

                        <p><?= "<span class=\"text-info\">" . lang("csv1") . ": </span><span class=\"text-success\">" . " (<b>(name,code,category code)</b>)</span> <span class=\"text-primary\"><br/>" . lang("csv2") . "</span>"; ?></p>
                        <input type="hidden" name="type_id" id="type_id" value="">
                    </div>
                    <?= form_close(); ?>
                    <?= form_open_multipart(partner_url("product/import")); ?>
                    <div class="form-group">
                        <?= lang('category', 'category'); ?>

                        <select name="type" id="type" class="form-control tip select2" id="type"  required="required" style="width:100%;">
                            <option disabled selected value><?=lang('chose_type_product')?></option>
                            <?php foreach($productType as $type){?>
                                <option value="<?=$type->type_id?>"><?=$type->type_name?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <?= lang("upload_file", 'csv_file'); ?>
                            <input type="file" name="userfile" id="csv_file">
                            <div class="inline-help"><?= lang("csv_file_tip"); ?></div>
                        </div>
                        <?= form_submit('import', lang('import'), 'class="btn btn-primary"'); ?>
                    </div>
                    <?= form_close(); ?>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function() {
    $('#download_sample_file').click(function (e) {
        e.preventDefault();
        var type = $('#type').val();
        if((type==undefined) || type <1)
        {
$('#content-modal').html('Choose producttype');
$('#myModal').modal();
return;
        }
        else {
            $('#type_id').val(type);
            $('#download_form').submit();
        }
    });
    });
</script>
