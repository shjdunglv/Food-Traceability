<div class="container">
    <div class="row">
        <div class="col-md-5 center-block-e">



            <div class="login-form">

                <div class="login-form-inner">
                    <?php $gl = $this->session->flashdata('globalmsg'); ?>
                    <?php if(!empty($gl)) :?>
                        <div class="alert alert-success"><b><span class="glyphicon glyphicon-ok"></span></b> <?php echo $this->session->flashdata('globalmsg') ?></div>
                    <?php endif; ?>

                </div>
                <div class="login-form-bottom clearfix">

                    <hr>

                </div>


            </div>


        </div>
    </div>
</div>

<div class="login-footer">

</div>
<script>
    setTimeout(function(){
        window.location.href = '<?=site_url("Auth/Login")?>';
    },5000)</script>
