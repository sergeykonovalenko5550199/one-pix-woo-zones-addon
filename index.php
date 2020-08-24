<?php 
use Carbon_Fields\Container;
use Carbon_Fields\Field;
/*
 * Plugin Name: OnePix Zones Addon
 * Description: 
 * Version: 1.0.1
 * Author: OnePix Team
 * Author URI: https://one-pix.com/
 * Text Domain: onepix_zones
 */

class OnePixAddonZones {

  private static $_instance = null;

  private function __construct() {}

  protected function __clone() {}

 /**
  * @return OnePixAddonZones
  */
  static public function getInstance() {

    if ( is_null( self::$_instance ) ) {
      self::$_instance = new self();
    }

    return self::$_instance;
  }

  function init() {

      // add settings subpage
      add_action( 'onepix_add_theme_suboption', [$this, 'add_settings_subpage'] );
    
    return $this;
  }

  function add_settings_subpage( $main_page ) {

    $zones_labels = array(
      'plural_name'   => 'Zones',
      'singular_name' => 'Zone',
    );

    Container::make( 'theme_options', 'Zones Addon' )
      ->set_page_parent( $main_page ) // reference to a top level container
      ->add_tab( __('List of zones'), array(
        Field::make( 'complex', 'op_zones', 'Zones' )
          ->set_collapsed( true )
          ->set_layout( 'tabbed-horizontal' )
          ->setup_labels( $zones_labels )
          ->add_fields( array(
              Field::make( 'text', 'title_op_zones', __( 'Title' ) ),
              Field::make( 'text', 'slug_op_zones', __( 'Unique slug' ) )->set_required( true ),

              Field::make( 'complex', 'zip_op_zones', 'Zone Codes ZIP' )
                ->set_collapsed( true )
                ->set_layout( 'tabbed-vertical' )
                ->setup_labels( $zones_labels )
                ->add_fields( array(
                    Field::make( 'text', 'code_zip_op_zones', __( 'Code ZIP' ) )->set_attribute( 'type', 'number' ),
                ) )
                ->set_header_template( '
                  <% if (code_zip_op_zones) { %>
                    <%- code_zip_op_zones %>
                  <% } %>
                ' )

          ) )
          ->set_header_template( '
            <% if (title_op_zones) { %>
              <%- title_op_zones %> <%- slug_op_zones ? " (" + slug_op_zones + ")" : " (You must type slug)" %>
            <% } %>
          ' )
      ) );
  }

}