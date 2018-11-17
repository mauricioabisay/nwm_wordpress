<p>
    <label for="<?php echo $field->id;?>_value"><?php echo $field->name;?>:</label>
</p>
<?php
    $current_value = get_post_meta($post->ID, $field->id, true);
?>
<p>
    <textarea
        id="<?php echo $field->id;?>_value"
        name="<?php echo $field->id;?>"
        style="width: 100%;"><?php echo $current_value;?></textarea>
</p>