<p>
    <label for="<?php echo $field->id;?>_value"><?php echo $field->name;?>:</label>
<?php
foreach($options as $opt) :
?>
    <label for="<?php echo $opt->id;?>">
        <input
            type="checkbox"
            name="<?php echo $opt->name;?>"
            id="<?php echo $opt->id;?>"
            value="<?php echo $opt->value;?>"
            <?php echo ($opt->current) ? 'checked' : '';?>/>
        <?php echo $opt->text;?>
    </label>
<?php
endforeach;
?>
</p>