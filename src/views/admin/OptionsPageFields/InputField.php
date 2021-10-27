<input 
type="text" 
name="<?php echo $data['settings_field_name'] ?>" 
value="<?php echo esc_attr(get_option($data['settings_field_name'])) ?>">