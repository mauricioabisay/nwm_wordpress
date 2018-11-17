<p>
    <label for="<?php echo $field->id;?>_value"><?php echo $field->name;?>:</label>
</p>
<?php
    $js_friendly_name = str_replace('-', '_', $field->id);
    $lat = get_post_meta($post->ID, $field->id.'-lat', true);
    $lng = get_post_meta($post->ID, $field->id.'-lng', true);
    if( !$lat || !$lng ) {
        $lat = '19.434070';
        $lng = '-99.149115';
        $zoom = '10';
    } else {
        $zoom = '16';
    }
?>

<input type="text" name="<?php echo trim($field->id);?>-lat" id="<?php echo trim($field->id);?>-lat" value="<?php echo $lat;?>">

<input type="text" name="<?php echo trim($field->id);?>-lng" id="<?php echo trim($field->id);?>-lng" value="<?php echo $lng;?>">

<div id="map-<?php echo trim($field->id);?>" class="map" style="width:100%;height:50em;"></div>
<script type="text/javascript">
    window.onload = function() {
        var lat = <?php echo $lat;?>;
        var lng = <?php echo $lng;?>;
        //Setting up map
        var map<?php echo $js_friendly_name;?> = new L.Map('map-<?php echo trim($field->id);?>');
        var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
        var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
        var osm = new L.TileLayer(osmUrl, {minZoom: 10, maxZoom: 18, attribution: osmAttrib});
        map<?php echo $js_friendly_name;?>.setView(new L.LatLng(lat, lng), <?php echo $zoom;?>);
        map<?php echo $js_friendly_name;?>.addLayer(osm);
        //Creating default marker
        var marker<?php echo $js_friendly_name;?> = L.marker([lat, lng]).addTo(map<?php echo $js_friendly_name;?>);
        //Adding event to change marker location by clicking on the map
        map<?php echo $js_friendly_name;?>.on('click', function(e) {
            marker<?php echo $js_friendly_name;?>.setLatLng(e.latlng);
            document.getElementById('<?php echo trim($field->id);?>-lat').value = e.latlng.lat;
            document.getElementById('<?php echo trim($field->id);?>-lng').value = e.latlng.lng;
        });
    };
</script>