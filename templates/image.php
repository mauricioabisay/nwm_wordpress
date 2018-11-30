<?php
    $current_value = get_post_meta($post->ID, $field->id, true);
?>
<p>
    <label for="<?php echo $field->id ; ?>_value"><?php echo $field->name ; ?></label>
    <input 
        type="url" 
        name="<?php echo $field->id ; ?>" 
        id="<?php echo $field->id ; ?>_value" 
        style="width:100%"
        value="<?php echo $current_value ; ?>">
    <img 
        id="nwm-image-preview-<?php echo $field->id ;?>" 
        <?php echo ($current_value) ? 'src="'.$current_value.'"' : '' ; ?>
        style="width:100%;height:auto;">
    <button 
        type="button" class="button nwm-image-uploader" 
        id="nwm-image-uploader-<?php echo $field->id ; ?>" >
        <?php _e( 'Upload Media' )?>
    </button>
</p>
<script>
	jQuery(document).ready( function() {
        var metaImageFrame;
        jQuery('#nwm-image-uploader-<?php echo $field->id ; ?>').click( function() {
            metaImageFrame = wp.media.frames.metaImageFrame = wp.media({
                title: 'Seleccionar imagen para <?php echo $field->name ; ?>'
            });
            metaImageFrame.on('select', function() {
                var media_attachment = metaImageFrame.state().get('selection').first().toJSON();
                jQuery('#<?php echo $field->id ; ?>_value').val(media_attachment.url);
                jQuery('#nwm-image-preview-<?php echo $field->id ; ?>').attr('src', media_attachment.url);
            });
            metaImageFrame.open();
        });
    });
</script>

<?php
/*
<label for="myplugin_media"><?php _e( 'Field Label', 'events' )?></label><br>
<input 
    type="url" class="large-text" 
    name="myplugin_media" id="myplugin_media" value="<?php echo esc_attr( $saved ); ?>"><br>
<button type="button" class="button" id="events_video_upload_btn" data-media-uploader-target="#myplugin_media"><?php _e( 'Upload Media', 'myplugin' )?></button>
<script>
	jQuery(document).ready(function($){
		'use strict';
        // Instantiates the variable that holds the media library frame.
        var metaImageFrame;
        // Runs when the media button is clicked.
        $( 'body' ).click(function(e) {
            // Get the btn
            var btn = e.target;
            // Check if it's the upload button
            if ( !btn || !$( btn ).attr( 'data-media-uploader-target' ) ) return;
            // Get the field target
            var field = $( btn ).data( 'media-uploader-target' );
            // Prevents the default action from occuring.
            e.preventDefault();
            // Sets up the media library frame
            metaImageFrame = wp.media.frames.metaImageFrame = wp.media({
                title: 'test',
                button: { text:  'Use this file' },
            });

            // Runs when an image is selected.
            metaImageFrame.on('select', function() {
                // Grabs the attachment selection and creates a JSON representation of the model.
                var media_attachment = metaImageFrame.state().get('selection').first().toJSON();
                // Sends the attachment URL to our custom image input field.
                $( field ).val(media_attachment.url);
            });
            // Opens the media library frame.
            metaImageFrame.open();
        });
    });
</script>
*/?>