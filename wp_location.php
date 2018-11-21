<?php

trait Geolocation {
    //Public AJAX functions
    function getEventsNearBy() {
        global $wpdb;
        if(isset($_POST['lat']) && isset($_POST['lng'])) {
            $lat = $_POST['lat'];
            $lng = $_POST['lng'];
            $sql = 'select ( 6371 * ( 2*atan2(sqrt(a), sqrt(1-a)) ) ) as distance, post_id from ';
            $sql.= '(select ( (sin(dlat/2)*sin(dlat/2)) + cos(radians('.$lat.'))*cos(radians(lat))*(sin(dlng/2)*sin(dlng/2)) ) as a, dlt.post_id as post_id  from ';
            $sql.= "(select radians(meta_value-".$lat.") as dlat, meta_value as lat, post_id from ".$wpdb->prefix."postmeta where meta_key like '%location_lat%') as dlt, ";
            $sql.= "(select radians(meta_value-".$lng.") as dlng, meta_value as lng, post_id from ".$wpdb->prefix."postmeta where meta_key like '%location_lng%') as dln where dlt.post_id = dln.post_id) as a ";
            $sql.= 'order by distance ASC LIMIT 10';

            $results = $wpdb->get_results($sql);
            $locations = array();
            foreach ($results as $key => $value) {
                $locations[] = $value->post_id;
            }
            $query = new WP_Query(array(
                'post__in' => $locations,
                'post_type' => 'any',
                'posts_per_page' => -1
            ));

            $locations = array();
            foreach ($query->posts as $post) {
                $post->meta = get_post_meta($post->ID);
                $locations[] = $post;
            }
            if (count($locations) > 0) {
                header('HTTP/1.1 200 OK', true, 200);
                echo json_encode(array(
                    'query' => $sql,
                    'locations' => $locations,
                ));
            } else {
                header('HTTP/1.1 404 Not found', true, 404);
            }
        } else {
            header('HTTP/1.1 400 Bad Request', true, 400);
        }
        exit();
    }

    function getEventsInRadius() {
        global $wpdb;
        if( isset($_POST['lat']) && isset($_POST['lng']) && isset($_POST['radius']) ) {
            $lat = $_POST['lat'];
            $lng = $_POST['lng'];
            $radius = $_POST['radius'];

            $sql = 'select * from (';
            $sql.= 'select ( 6371 * ( 2*atan2(sqrt(a), sqrt(1-a)) ) ) as distance, post_id from ';
            $sql.= '(select ( (sin(dlat/2)*sin(dlat/2)) + cos(radians('.$lat.'))*cos(radians(lat))*(sin(dlng/2)*sin(dlng/2)) ) as a, dlt.post_id as post_id  from ';
            $sql.= "(select radians(meta_value-".$lat.") as dlat, meta_value as lat, post_id from ".$wpdb->prefix."postmeta where meta_key like '%location_lat%') as dlt, ";
            $sql.= "(select radians(meta_value-".$lng.") as dlng, meta_value as lng, post_id from ".$wpdb->prefix."postmeta where meta_key like '%location_lng%') as dln where dlt.post_id = dln.post_id) as a ";
            $sql.= ') as in_radius ';
            $sql.= 'where distance<='.$radius;

            $results = $wpdb->get_results($sql);
            $locations = array();
            foreach ($results as $key => $value) {
                $locations[] = $value->post_id;
            }
            $query = new WP_Query(array(
                'post__in' => $locations,
                'post_type' => 'any',
                'posts_per_page' => -1
            ));

            $locations = array();
            foreach ($query->posts as $post) {
                $post->meta = get_post_meta($post->ID);
                $locations[] = $post;
            }
            if (count($locations) > 0) {
                header('HTTP/1.1 200 OK', true, 200);
                echo json_encode(array(
                    'msg' => 'OK',
                    'query' => $sql,
                    'locations' => $locations,
                ));
            } else {
                header('HTTP/1.1 404 Not found', true, 404);
            }
        } else {
            header('HTTP/1.1 400 Bad Request', true, 400);
        }
        exit();
    }

    function getEventsInBounds() {
        global $wpdb;

        if( isset($_POST['west']) && isset($_POST['east']) && isset($_POST['north']) && isset($_POST['south']) ) {
            $lat_north = $_POST['north'];
            $lat_south = $_POST['south'];
            $lng_west = $_POST['west'];
            $lng_east = $_POST['east'];

            $sql = 'select lat.post_id from ';
            $sql.= '(select post_id, meta_value as lat from '.$wpdb->prefix.'postmeta where meta_key like "%location_lat%" and meta_value>='.$lat_south.' and meta_value<='.$lat_north.') as lat, ';
            $sql.= '(select post_id, meta_value as lng from '.$wpdb->prefix.'postmeta where meta_key like "%location_lng%" and meta_value>='.$lng_west.' and meta_value<='.$lng_east.') as lng ';
            $sql.= 'where lat.post_id = lng.post_id ';

            $results = $wpdb->get_results($sql);
            $locations = array();
            if( !empty($results) ) {
                foreach ($results as $key => $value) {
                    $locations[] = $value->post_id;
                }
                $query = new WP_Query(array(
                    'post__in' => $locations,
                    'post_type' => 'any',
                    'posts_per_page' => -1
                ));

                $locations = array();
                foreach ($query->posts as $post) {
                    $post->meta = get_post_meta($post->ID);
                    $locations[] = $post;
                }
                header('HTTP/1.1 200 OK', true, 200);
                echo json_encode(array(
                    'msg' => 'OK',
                    'query' => $sql,
                    'locations' => $locations,
                ));
            } else {
                header('HTTP/1.1 404 Not found', true, 404);
            }
        } else {
            header('HTTP/1.1 400 Bad Request', true, 400);
        }
        exit();
    }

    function getEvents() {
        if( isset($_POST) ) {
            $locations = array();
            $query = new WP_Query(array(
                'post_type' => 'sc-points-of-sale',
                'posts_per_page' => -1
            ));
            $locations = array();
            foreach ($query->posts as $post) {
                $post->meta = get_post_meta($post->ID);
                $locations[] = $post;
            }
            if (count($locations) > 0) {
                header('HTTP/1.1 200 OK', true, 200);
                echo json_encode(array(
                    'query' => $sql,
                    'locations' => $locations,
                ));
            } else {
                header('HTTP/1.1 404 Not found', true, 404);
            }
        } else {
            header('HTTP/1.1 400 Bad Request', true, 400);
        }
        exit();
    }
}