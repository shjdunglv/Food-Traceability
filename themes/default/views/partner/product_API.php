<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<?php foreach($settings as $key=>$val){?>
<div class="form-group">
    <?= lang($key, $key); ?>
    <?= form_input($key, set_value($val), 'class="form-control tip" id="'.$key.'"  required="required"'); ?>
</div>
<?php } ?>
