<?php

use MgTest\controlers\AdminController;

$text = esc_html__(
    'Get Aweosome Table from external Api',
    $data['language_domain']
);

$button = esc_html__(
    'Refresh Data',
    $data['language_domain']
);

?>

<div class="wrap">
    <h1><?php echo $text ?></h1>
        <?php
            settings_errors();
            settings_fields($data['settings_group_name']);
            do_settings_sections($data['admin_options_page_slug']);
            //var_dump($data['table_data']);
            ?>
        <div id="mg-aweosome-table-data"><?php
            AdminController::getInstance()->view(
                'admin/partials/table',
                [
                    'table_data' => $data['table_data']
                ]
            );?>
        </div>
        <a href="#" class="button button-primary" id="refresh-md-table-data">Refresh Data</a>
</div>
<script type="text/javascript" >
jQuery(document).ready(function($) {
    jQuery('#refresh-md-table-data').click(function(e){
        e.preventDefault(); 
        jQuery.ajax({
            type: "POST",
            dataType: "html",
            async:true,
            url: "/wp-admin/admin-ajax.php",
            data : {action: "table_data_html"},
            success: function(msg){
                jQuery('#mg-aweosome-table-data').html(msg);
            },
            error: function(msg){
                alert('something went wrong');
            }

        });
    });
});
</script>
