<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#UTable').DataTable({
            "dom": '<"row"r>t<"row"<"col-md-6"i><"col-md-6"p>><"clear">',
            "order": [[ 0, "desc" ]],
            "pageLength": Settings.rows_per_page,
            "processing": false, "serverSide": false,
            "buttons": []
        });
    });
</script>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?= lang('list_results'); ?></h3>
                </div>
                <div class="box-body">
                    <table id="UTable" class="table table-bordered table-striped table-hover">
                        <thead class="cf">
                        <tr>
                            <th><?php echo lang('code_of_company'); ?></th>
                            <th><?php echo lang('name_of_company'); ?></th>
                            <th><?php echo lang('email'); ?></th>
                            <th><?php echo lang('address_of_company'); ?></th>
                            <th><?php echo lang('phone'); ?></th>
                            <th style="width:100px;"><?php echo lang('status'); ?></th>
                            <th style="width:80px;"><?php echo lang('action'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($companys as $company) {
                            echo '<tr>';
                            echo '<td>' . $company->partner_id . '</td>';
                            echo '<td>' . $company->name . '</td>';
                            echoTextIfIsset(isset($company->email)?$company->email:'','td');
                            echoTextIfIsset(isset($company->address)?$company->address:'','td');
                            echoTextIfIsset(isset($company->phone)?$company->phone:'','td');
                            echo '<td class="text-center" style="padding:6px;">' . ($company->status ? '<span class="label label-success">' . lang('Active') . '</span' : '<span class="label label-danger">' . lang('Unconfirmed') . '</span>') . '</td>';
                            echo '<td class="text-center" style="padding:6px;"><div class="btn-group btn-group-justified" role="group"><div class="btn-group btn-group-xs" role="group"><a class="tip btn btn-warning btn-xs" title="' . lang("profile") . '" href="' . admin_url('Company/profile/' . $company->partner_id) . '"><i class="fa fa-edit"></i></a></div>
                            <div class="btn-group btn-group-xs" role="group"><a class="tip btn btn-danger btn-xs" title="' . lang("delete_user") . '" href="' . site_url('auth/delete/' . $company->partner_id) . '" onclick="return confirm(\''.lang('alert_x_user').'\')"><i class="fa fa-trash-o"></i></a></div></div></td>';
                            echo '</tr>';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
