<style>
    .wp-custom-post-radio:before {
        margin: 1px !important;
    }
</style>
<p>
    <label for="<?php echo $field->id;?>_value"><?php echo $field->name;?>:</label>
<?php
foreach($options as $opt) :
?>
    <label for="<?php echo $opt->id;?>">
        <input
            type="radio"
            name="<?php echo $opt->name;?>"
            id="<?php echo $opt->id;?>"
            value="<?php echo $opt->value;?>"
            <?php echo ($opt->current) ? 'checked' : '';?>
            class="wp-custom-post-radio"/>
        <?php echo $opt->text;?>
    </label>
<?php
endforeach;
?>
</p>