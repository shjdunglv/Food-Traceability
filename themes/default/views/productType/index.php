<?php (defined('BASEPATH')) OR exit('No direct script access allowed');?>

<script type="text/javascript">
    $(document).ready(function() {

        var style = "";

        function image(n) {
            if (n !== null) {
                return '<div style="width:32px; margin: 0 auto;"><a href="<?=base_url();?>uploads/'+n+'" class="open-image"><img src="<?=base_url();?>uploads/thumbs/'+n+'" alt="" class="img-responsive"></a></div>';
            }
            return '';
        }

        function method(n) {
            return (n == 0) ? '<span class="label label-primary"><?= lang('inclusive'); ?></span>' : '<span class="label label-warning"><?= lang('exclusive'); ?></span>';
        }

        var table = $('#prTables').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: '<?=lang('export_excel')?>',
            }
            ],
            "oLanguage": {
                "sSearch": "<?=lang('quick_search')?>",
                "oPaginate": {
                    "sFirst": "<?=lang('first_page')?>", // This is the link to the first page
                    "sPrevious": "<?=lang('previous_page')?>", // This is the link to the previous page
                    "sNext": "<?=lang('next_page')?>", // This is the link to the next page
                    "sLast": "<?=lang('last_page')?>" // This is the link to the last page
                }
            }
        });

        // $('#prTables tfoot th:not(:last-child, :nth-last-child(2), :nth-last-child(3))').each(function () {
        //     var title = $(this).text();
        //     $(this).html( '<input type="text" class="text_filter" placeholder="'+title+'" />' );
        // });

        $('#search_table').on( 'keyup change', function (e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if (((code == 13 && table.search() !== this.value) || (table.search() !== '' && this.value === ''))) {
                table.search( this.value ).draw();
            }
        });

        table.columns().every(function () {
            var self = this;
            $( 'input', this.footer() ).on( 'keyup change', function (e) {
                var code = (e.keyCode ? e.keyCode : e.which);
                if (((code == 13 && self.search() !== this.value) || (self.search() !== '' && this.value === ''))) {
                    self.search( this.value ).draw();
                }
            });
            $( 'select', this.footer() ).on( 'change', function (e) {
                self.search( this.value ).draw();
            });
        });

    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#prTables').on('click', '.image', function() {
            var a_href = $(this).attr('href');
            var code = $(this).attr('id');
            $('#myModalLabel').text(code);
            $('#product_image').attr('src',a_href);
            $('#picModal').modal();
            return false;
        });
        $('#prTables').on('click', '.barcode', function(e) {
            e.preventDefault();
            var a_href = $(this).attr('data-url');
            var code = $(this).attr('id');
            $('#myModalLabel').text(code);
            $('#product_image').attr('src',a_href);
            $.get(a_href, function (t) {
                return $("#picModal").html(t), $("#picModal").modal({backdrop: "static"}), cActions(), !1
            });
            return false;
        });
        $('#prTables').on('click', '.open-image', function() {
            var a_href = $(this).attr('href');
            var code = $(this).closest('tr').find('.image').attr('id');
            $('#myModalLabel').text(code);
            $('#product_image').attr('src',a_href);
            $('#picModal').modal();
            return false;
        });
    });
</script>
<style type="text/css">
    .table td:first-child { padding: 1px; }
    .table td:nth-child(6), .table td:nth-child(7), .table td:nth-child(8) { text-align: center; }
    .table td:nth-child(9)<?= $Admin ? ', .table td:nth-child(10)' : ''; ?> { text-align: right; }
</style>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="prTables" class="table table-striped table-bordered table-hover" style="margin-bottom:5px;">
                            <thead>
                            <tr class="active">
                                <th><?= lang("code"); ?></th>
                                <th><?= lang("name"); ?></th>
                                <th><?= lang("type"); ?></th>
                                <th><?= lang("create_at"); ?></th>
                                <th style="width:165px;"><?= lang("action"); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(isset($productType))foreach($productType as $product){?>
                                <tr>
                                    <th><?=$product->type_id?></th>
                                    <th><?=$product->type_name?></th>
                                    <th><?=$product->sets?></th>
                                    <th><?=$product->create_at?></th>
                                    <th style="width:165px;"></th>
                                </tr>
                            <?php } ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th><input type="text" class="text_filter" placeholder="[<?= lang('code'); ?>]"></th>
                                <th><input type="text" class="text_filter" placeholder="[<?= lang('name'); ?>]"></th>
                                <th><input type="text" class="text_filter" placeholder="[<?= lang('type'); ?>]"></th>
                                <th><input type="text" class="text_filter" placeholder="[<?= lang('create_at'); ?>]"></th>
                                <th style="width:165px;"><?= lang("action"); ?></th>

                            </tr>

                            </tfoot>
                        </table>
                    </div>

                    <div class="modal fade" id="picModal" tabindex="-1" role="dialog" aria-labelledby="picModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                                    <button type="button" class="close mr10" onclick="window.print();"><i class="fa fa-print"></i></button>
                                    <h4 class="modal-title" id="myModalLabel">title</h4>
                                </div>
                                <div class="modal-body text-center">
                                    <img id="product_image" src="" alt="" />
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section>
