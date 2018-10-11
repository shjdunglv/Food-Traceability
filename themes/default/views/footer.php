<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

</div>
<footer class="main-footer">
    Copyright &copy; Chainos. All rights reserved.
</footer>
</div>
<div class="modal" data-easein="flipYIn" id="posModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div class="modal" data-easein="flipYIn" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"></div>
<div id="ajaxCall"><i class="fa fa-spinner fa-pulse"></i></div>
<script type="text/javascript">
    var base_url = '<?=base_url();?>';
    var site_url = '<?=site_url();?>';
    var dateformat = "D j M Y", timeformat = "h:i A";
    <?php unset($Settings->protocol, $Settings->smtp_host, $Settings->smtp_user, $Settings->smtp_pass, $Settings->smtp_port, $Settings->smtp_crypto, $Settings->mailpath, $Settings->timezone, $Settings->setting_id, $Settings->default_email, $Settings->version, $Settings->stripe, $Settings->stripe_secret_key, $Settings->stripe_publishable_key); ?>
    var Settings = "";
    $(window).load(function () {
        $('.mm_<?=$m?>').addClass('active');
        $('#<?=$m?>_<?=$v?>').addClass('active');
    });

</script>
<script src="<?= $assets ?>dist/js/adminLTE.js" type="text/javascript"></script>
<script src="<?= $assets ?>plugins/select2/select2.js" type="text/javascript"></script>
<script src="<?= $assets ?>plugins/filestyle/bootstrap-filestyle.js" type="text/javascript"></script>
<script src="<?= $assets ?>plugins/formvalidation/js/formValidation.js" type="text/javascript"></script>
<script src="<?= $assets ?>plugins/formvalidation/js/framework/bootstrap.js" type="text/javascript"></script>
<script src="<?= $assets ?>plugins/iCheck/icheck.js" type="text/javascript"></script>
<script src="<?= $assets ?>plugins/redactor/redactor.min.js" type="text/javascript"></script>
<script src="<?= $assets ?>plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="<?= $assets ?>plugins/datatables/jszip.min.js" type="text/javascript"></script>
<script src="<?= $assets ?>plugins/datatables/buttons.html5.min.js" type="text/javascript"></script>
<script src="<?= $assets ?>dist/js/scripts.min.js" type="text/javascript"></script>
</body>
</html>
