<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://ays-pro.com/
 * @since             3.0.0
 * @package           Google Maps Widget
 *
 * @wordpress-plugin
 * Plugin Name:       Simple Google Maps Widget
 * Plugin URI:        http://ays-pro.com/index.php/wordpress/simple-google-maps-widget
 * Description:       This plugin allows you to show your favorite or shop place in your website sidebar, via Google Maps.
 * Version:           1.0.1
 * Author:            Google Maps team
 * Author URI:        http://ays-pro.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       simple-google-maps-widget
 */


// Creating the widget
class WP_Maps_Widget_By_AYS extends WP_Widget {
    function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'map_styles_front'));
        add_action('admin_enqueue_scripts', array($this, 'map_styles_back'));
        parent::__construct(

        // Base ID of the widget
        'wp_maps_widget',

        // Widget name that will appear in UI
        __('Simple Google Map Widget', 'simple-google-maps-widget'),

        // Widget description
        array( 'description' => __( 'A simple yet cool and intuitive Google maps widget for your website', 'simple-google-maps-widget' ), )
        );
    }
    public function map_styles_front(){
        wp_enqueue_script('jquery');
        wp_enqueue_style('wp_maps_widget_map_style', plugin_dir_url(__FILE__) . 'css/map_style.css');
    }
    public function map_styles_back(){
        wp_enqueue_style( 'style.css', plugins_url( 'css/style.css', __FILE__ ) );
    }
    // Before and After Widget and Title Tags
    public $args = array(
        'before_title' => '<h4 class="map-widget-title">',
        'after_title' => '</h4>',
        'before_widget' => '<div class="map-widget-container">',
        'after_widget' => '</div>'
    );
    // Widget Front-End
    public function widget( $args, $instance ) {

        echo $args['before_widget'];

        $title = ( isset( $instance[ 'title' ] ) && $instance[ 'title' ] != '' )
            ? $instance[ 'title' ]
            :  __( 'Google LLC', 'simple-google-maps-widget' );

        $api_key = ( isset( $instance[ 'api_key' ] ) && $instance[ 'api_key' ] != '' )
            ? $instance[ 'api_key' ]
            :  'AIzaSyDfkwnhZH7ST2V7q9csteLW4nZtNrRwMmE';

        $latitude = ( isset( $instance[ 'latitude' ] ) && $instance[ 'latitude' ] != '' )
            ? $instance[ 'latitude' ]
            :  '37.4226231';

        $longitude = ( isset( $instance[ 'longitude' ] )  && $instance[ 'longitude' ] != '' )
            ? $instance[ 'longitude' ]
            :  '-122.0845839';

        $marker_title = ( isset( $instance[ 'marker_title' ] )  && $instance[ 'marker_title' ] != '' )
            ? $instance[ 'marker_title' ]
            :  __( 'Google LLC', 'simple-google-maps-widget' );

        $marker_description = ( isset( $instance['marker_description'] )  && $instance[ 'marker_description' ] != '' )
            ? ($instance['marker_description'])
            : __( 'Google LLC is an American multinational technology company that specializes in Internet-related services and products, which include online advertising technologies, search engine, cloud computing, software, and hardware. Google was founded in 1998 by Larry Page and Sergey Brin while they were Ph.D. students at Stanford University, California.', 'simple-google-maps-widget' );

        if ( ! empty( $title ) ) { echo $args['before_title'] . $title . $args['after_title']; }
        echo '<div id="map"></div>';
        ?>
        <!-- Map JS Scripts -->
        <script>
            // Initialize and add the map
            function initMap() {
                // The location (coordinates) of coord
                var coord = {lat: <?php echo $latitude; ?>, lng: <?php echo $longitude; ?>};
                // The map, centered at coord
                var map = new google.maps.Map(
                    document.getElementById('map'), {
                        zoom: 15,
                        center: coord
                    });
                // The marker, positioned at coord
                var marker = new google.maps.Marker({position: coord, map: map});

                // Open info window on marker click
                marker.addListener('click', function() {
                    let infoWindow = new google.maps.InfoWindow();
                    let iWC = "<div class='infoWD-content'>" +
                                "<h1><?php echo $marker_title; ?></h1>" +
                                "<div><?php echo str_replace('\'', '\\\'', $marker_description); ?></div>" +
                              "</div>";
                    infoWindow.setContent(iWC);
                    infoWindow.open(map, marker);
                });
            }
        </script>
        <!-- Google Maps API -->
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $api_key; ?>&libraries=places&callback=initMap"></script>
        <?php
        // Run the code
        echo $args['after_widget'];
    } // END Widget Front-End
    // Widget Back-End
    public function form( $instance ) {
        $title = ( isset( $instance[ 'title' ] ) && $instance[ 'title' ] != '' )
                        ? $instance[ 'title' ]
                        :  __( 'Google LLC', 'simple-google-maps-widget' );

        $api_key = ( isset( $instance[ 'api_key' ] ) && $instance[ 'api_key' ] != '' )
                        ? $instance[ 'api_key' ]
                        :  'AIzaSyDfkwnhZH7ST2V7q9csteLW4nZtNrRwMmE';

        $location = ( isset( $instance[ 'location' ] ) && $instance[ 'location' ] != '' )
                        ?  $instance[ 'location' ]
                        :  __( '1600 Amphitheatre Parkway, Mountain View, CA', 'simple-google-maps-widget' );

        $latitude = ( isset( $instance[ 'latitude' ] ) && $instance[ 'latitude' ] != '' )
                        ? $instance[ 'latitude' ]
                        :  '37.4226231';

        $longitude = ( isset( $instance[ 'longitude' ] )  && $instance[ 'longitude' ] != '' )
                        ? $instance[ 'longitude' ]
                        :  '-122.0845839';

        $marker_title = ( isset( $instance[ 'marker_title' ] )  && $instance[ 'marker_title' ] != '' )
                        ? $instance[ 'marker_title' ]
                        :  __( 'Google LLC', 'simple-google-maps-widget' );

        $marker_description = ( isset( $instance['marker_description'] )  && $instance[ 'marker_description' ] != '' )
                        ? ($instance['marker_description'])
                        : __( 'Google LLC is an American multinational technology company that specializes in Internet-related services and products, which include online advertising technologies, search engine, cloud computing, software, and hardware. Google was founded in 1998 by Larry Page and Sergey Brin while they were Ph.D. students at Stanford University, California.', 'simple-google-maps-widget' );

        // Widget Admin Options
        ?>
        <p class="map-field-section">
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="title" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p class="map-field-section">
            <label for="<?php echo $this->get_field_id( 'api_key' ); ?>"><?php _e( 'API Key:' ); ?></label>
            <input class="api-key" id="<?php echo $this->get_field_id( 'api_key' ); ?>" name="<?php echo $this->get_field_name( 'api_key' ); ?>" type="text" placeholder="<?php echo __( 'Insert a Google Maps API key here', 'simple-google-maps-widget' ); ?>" value="<?php echo esc_attr( $api_key ); ?>" />
            <span id="api-notice">For more info, check <a href="https://support.google.com/googleapi/answer/6158862?hl=en" target="_blank">this</a> article of how to set up an API Key.</span>
        </p>
        <p class="map-field-section">
            <label for="<?php echo $this->get_field_id( 'location' ); ?>"><?php _e( 'Location:' ); ?></label>
            <input class="location" id="<?php echo $this->get_field_id( 'location' ); ?>" name="<?php echo $this->get_field_name( 'location' ); ?>" type="text" value="<?php echo esc_attr( $location ); ?>" />
        </p>
        <p class="map-field-section">
            <label for="<?php echo $this->get_field_id( 'latitude' ); ?>"><?php _e( 'Latitude:' ); ?></label>
            <input class="latitude" id="<?php echo $this->get_field_id( 'latitude' ); ?>" name="<?php echo $this->get_field_name( 'latitude' ); ?>" type="text" value="<?php echo esc_attr( $latitude ); ?>" />
        </p>
        <p class="map-field-section">
            <label for="<?php echo $this->get_field_id( 'longitude' ); ?>"><?php _e( 'Longitude:' ); ?></label>
            <input class="longitude" id="<?php echo $this->get_field_id( 'longitude' ); ?>" name="<?php echo $this->get_field_name( 'longitude' ); ?>" type="text" value="<?php echo esc_attr( $longitude ); ?>" />
        </p>
        <p class="map-field-section">
            <label for="<?php echo $this->get_field_id( 'marker_title' ); ?>"><?php _e( 'Marker Title:' ); ?></label>
            <input class="longitude" id="<?php echo $this->get_field_id( 'marker_title' ); ?>" name="<?php echo $this->get_field_name( 'marker_title' ); ?>" type="text" value="<?php echo esc_attr( $marker_title ); ?>" />
        </p>
        <p class="map-field-section">
            <label for="<?php echo $this->get_field_id( 'marker_description' ); ?>"><?php _e( 'Marker Description:' ); ?></label>
            <textarea class="marker_description" id="<?php echo $this->get_field_id( 'marker_description' ); ?>" name="<?php echo $this->get_field_name( 'marker_description' ); ?>"><?php echo $marker_description; ?></textarea>
        </p>

        <script>
            var locationInput = document.getElementById('<?php echo $this->get_field_id( 'location' ); ?>');
            locationInput.oninput = function(){
                var locationInfoRequest = "https://maps.googleapis.com/maps/api/geocode/json?address='"+ this.value +"&key=AIzaSyDZRMUpuzrHE-CzQ6gbCqRpc0MhPugAIMw";
                $.getJSON(locationInfoRequest, function (data) {
                    document.getElementById('<?php echo $this->get_field_id( 'latitude' ); ?>').value = data.results[0].geometry.location.lat;
                    document.getElementById('<?php echo $this->get_field_id( 'longitude' ); ?>').value = data.results[0].geometry.location.lng;
                });
            }
        </script>
        <?php

    } // END Widget Back-End
    // Widget Update: Replace old instances with new ones
    public function update( $new_instance, $old_instance ) {

        $instance = array();

        $instance['title'] = ( isset( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['api_key'] = ( isset( $new_instance['api_key'] ) ) ? strip_tags( $new_instance['api_key'] ) : '';
        $instance['location'] = ( isset( $new_instance['location'] ) ) ? strip_tags( $new_instance['location'] ) : '';
        $instance['latitude'] = ( isset( $new_instance['latitude'] ) ) ? strip_tags( $new_instance['latitude'] ) : '';
        $instance['longitude'] = ( isset( $new_instance['longitude'] ) ) ? strip_tags( $new_instance['longitude'] ) : '';
        $instance['marker_title'] = ( isset( $new_instance['marker_title'] ) ) ? $new_instance['marker_title'] : '';
        $instance['marker_description'] = ( isset( $new_instance['marker_description'] ) ) ? $new_instance['marker_description'] : '';

        return $instance;

    } // END Widget Update
} // END Class wp_maps_widget

function load_maps_widget() {
    register_widget( 'WP_Maps_Widget_By_AYS' );
}
add_action( 'widgets_init', 'load_maps_widget' );