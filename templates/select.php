<p>
    <label for="<?php echo $field->id;?>_value"><?php echo $field->name;?>:</label>
<?php
$current_value = get_post_meta($post->ID, $field->id, true);
?>
<select name="<?php echo $field->id;?>">
<?php
foreach($options as $opt) :
?>
<option
    id="<?php echo $opt->id;?>"
    value="<?php echo $opt->value;?>"
    <?php echo ( $opt->current ) ? 'selected' : '';?>
>
    <?php echo $opt->text;?>
</option>
<?php
endforeach;
?>
</select>
</p>