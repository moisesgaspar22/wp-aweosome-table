<h1><?php echo $data['table_data']['title']?></h1> 
<table style="width:100%">
    <tr>
    <?php 
        foreach ($data['table_data']['data']['headers'] as $headers){
            printf('<th>%s</th>', $headers);
        } ?>
    </tr>
    <?php
        foreach ($data['table_data']['data']['rows'] as $rows){
            ?><tr><?php
            foreach($rows as $columData){
                printf('<th>%s</th>', $columData);
            }
            ?></tr><?php
        }
    ?>
</table>