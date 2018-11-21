<div class="wrap" id="profile-page">
    <h1 class="wp-heading-inline">Ajustes del Sitio</h1>
    <hr class="wp-header-end">
    <form id="nwm-ajustes" method="post">
        <h2>OAuth</h2>
        <table class="form-table">
            <tbody>
                <tr class="user-description-wrap">
                    <th><label for="google_oauth">Google OAuth:</label></th>
                    <td><input name="google_oauth" id="google_oauth" value="<?php echo get_option('google_oauth', '');?>" class="regular-text" type="text" placeholder="Google OAuth key"></td>
                </tr>
            </tbody>
        </table>
        <h2>SEO</h2>
        <table class="form-table">
            <tbody>
                <tr class="user-description-wrap">
                    <th><label for="seo_description">Descripción:</label></th>
                    <td><textarea name="seo_description" id="seo_description" rows="5" cols="30"><?php echo get_option('seo_description', '');?></textarea>
                    <p class="description">Trata de incluir palabras con las que quieres ser encontrado. Ej. "Soy un programador mexicano que vive en Puebla. Conozco Java, Javascript, PHP, Python, ..."</p></td>
                </tr>

                <tr class="user-description-wrap">
                    <th><label for="seo_keywords">Palabras Clave:</label></th>
                    <td><textarea name="seo_keywords" id="seo_keywords" rows="5" cols="30"><?php echo get_option('seo_keywords', '');?></textarea>
                    <p class="description">Trata de incluir palabras con las que quieres ser relacionado. Solo sustantivos, separados por ','</p></td>
                </tr>
            </tbody>
        </table>
        <h2>REDES SOCIALES</h2>
        <table class="form-table">
            <tbody>
                <tr class="user-first-name-wrap">
                    <th><label for="fb">Facebook:</label></th>
                    <td><input name="fb" id="fb" value="<?php echo get_option('fb', '');?>" class="regular-text" type="text" placeholder="Link a Facebook"></td>
                </tr>
                <tr class="user-first-name-wrap">
                    <th><label for="tw">Twitter:</label></th>
                    <td><input name="tw" id="tw" value="<?php echo get_option('tw', '');?>" class="regular-text" type="text" placeholder="Link a Twitter"></td>
                </tr>
                <tr class="user-first-name-wrap">
                    <th><label for="itg">Instagram:</label></th>
                    <td><input name="itg" id="itg" value="<?php echo get_option('itg', '');?>" class="regular-text" type="text" placeholder="Link a Instagram"></td>
                </tr>
            </tbody>
        </table>
        <h2>Contacto</h2>
        <table class="form-table">
            <tbody>
                <tr class="user-first-name-wrap">
                    <th><label for="contact_calle">Calle y Número:</label></th>
                    <td><input name="contact_calle" id="contact_calle" value="<?php echo get_option('contact_calle', '');?>" class="regular-text" type="text"></td>
                </tr>
                <tr class="user-first-name-wrap">
                    <th><label for="contact_colonia">Colonia:</label></th>
                    <td><input name="contact_colonia" id="contact_colonia" value="<?php echo get_option('contact_colonia', '');?>" class="regular-text" type="text"></td>
                </tr>
                <tr class="user-first-name-wrap">
                    <th><label for="contact_ciudad">Ciudad:</label></th>
                    <td><input name="contact_ciudad" id="contact_ciudad" value="<?php echo get_option('contact_ciudad', '');?>" class="regular-text" type="text"></td>
                </tr>
                <tr class="user-first-name-wrap">
                    <th><label for="contact_estado">Estado:</label></th>
                    <td><input name="contact_estado" id="contact_estado" value="<?php echo get_option('contact_estado', '');?>" class="regular-text" type="text"></td>
                </tr>
                <tr class="user-first-name-wrap">
                    <th><label for="contact_cp">C.P.:</label></th>
                    <td><input name="contact_cp" id="contact_cp" value="<?php echo get_option('contact_cp', '');?>" class="regular-text" type="text"></td>
                </tr>
                <tr class="user-last-name-wrap">
                    <th><label for="contact_phone">Teléfono:</label></th>
                    <td>
                        <input name="contact_phone" id="contact_phone" value="<?php echo get_option('contact_phone', '');?>" class="regular-text" type="text">
                    </td>
                </tr>
                <tr class="user-last-name-wrap">
                    <th><label for="contact_email">Correo Electrónico:</label></th>
                    <td>
                        <input name="contact_email" id="contact_email" value="<?php echo get_option('contact_email', '');?>" class="regular-text" type="text">
                    </td>
                </tr>
                <tr class="user-first-name-wrap">
                    <th><label for="location">Ubicación:</label></th>
                </tr>

                <?php
                    $lat = get_post_meta($post->ID, $field->id.'-lat', true);
                    $lng = get_post_meta($post->ID, $field->id.'-lng', true);
                    if( !$lat || !$lng ) {
                        $lat = get_option('contact_lat', '19.434070');
                        $lng = get_option('contact_lng', '-99.149115');
                        $zoom = '10';
                    } else {
                        $zoom = '16';
                    }
                ?>
                <tr>
                    <td>
                        <input type="hidden" name="contact_lat" id="contact_lat" value="<?php echo $lat;?>">
                        <input type="hidden" name="contact_lng" id="contact_lng" value="<?php echo $lng;?>">
                    </td>
                    <td colspan="">
                        <div id="map-contact" class="map" style="width:100%;height:50em;"></div>
                        <script type="text/javascript">
                            window.addEventListener('load', function(event) {
                                var lat = <?php echo $lat;?>;
                                var lng = <?php echo $lng;?>;
                                //Setting up map
                                var map = new L.Map('map-contact');
                                var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
                                var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
                                var osm = new L.TileLayer(osmUrl, {minZoom: 10, maxZoom: 18, attribution: osmAttrib});
                                map.setView(new L.LatLng(lat, lng), <?php echo $zoom;?>);
                                map.addLayer(osm);
                                //Creating default marker
                                var marker = L.marker([lat, lng]).addTo(map);
                                //Adding event to change marker location by clicking on the map
                                map.on('click', function(e) {
                                    marker.setLatLng(e.latlng);
                                    document.getElementById('contact_lat').value = e.latlng.lat;
                                    document.getElementById('contact_lng').value = e.latlng.lng;
                                });
                            }, false);
                        </script>
                    </td>

            </tbody>
        </table>

        <p class="submit"><input id="submit" class="button button-primary" value="Update Profile" type="submit"></p>
    </form>
</div>