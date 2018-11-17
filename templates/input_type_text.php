<p>
    <label for="<?php echo $field->id;?>_value"><?php echo $field->name;?>:</label>
<?php
    $current_value = get_post_meta($post->ID, $field->id, true);
?>
    <input
        type="<?php echo (isset($type)) ? $type : $field->type; ?>"
        id="<?php echo $field->id;?>_value"
        name="<?php echo $field->id;?>"
        value="<?php echo $current_value;?>"
        style="width:100%;"/>
</p>