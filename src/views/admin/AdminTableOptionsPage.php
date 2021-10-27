<?php
$text = esc_html__(
    'Aweosome Table Options',
    $data['language_domain']
);
?>
<div class="wrap">
    <h1><?php echo $text ?></h1>
    <form action="options.php" method="post">
        <?php
            settings_errors();
            settings_fields($data['settings_group_name']);
            do_settings_sections($data['admin_options_page_slug']);
            submit_button();
        ?>
    </form>
</div>
    