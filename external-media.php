<?php

/*
Plugin Name: External Media
Plugin URI: 
Description: A plugin for sell media to reference external sites
Version: 0.0.2
Author: Harald Walker
Author URI: 
Author Email: walker@mediasculp.com
License: GPL
*/

if (!class_exists('externalMedia')) {
	class externalMedia {
		function externalMedia() {
			$this->version = "0.0.2";
		}
		
		function external_media_meta_box($fields=null) {
			global $post;
			
			if ( is_array( $fields ) ){
		        $my_fields = $fields;
		    } else {
		        global $sell_media_item_meta_fields;
		        $my_fields = $sell_media_item_meta_fields;
		    }		
		
			$not_for_sale = get_post_meta( $post->ID, 'external_media_disabled_sale', true );
			$sale_link = get_post_meta( $post->ID, 'external_media_sales_link', true );
			$sale_agency = get_post_meta( $post->ID, 'external_media_agency', true );
			include ("item-settings.php");
		}
		
		function external_media_save_custom_meta($post_id) {

			if ( isset( $_POST[ 'external_media_disabled_sale' ] ) ){
				update_post_meta( $post_id, 'external_media_disabled_sale', 1 );
			} else {
				delete_post_meta( $post_id, 'external_media_disabled_sale', 1 );
			}
			
			if ( isset( $_POST[ 'external_media_sales_link' ] ) ){
				$old = get_post_meta( $post_id, 'external_media_sales_link', true );
	            $new = $_POST[ 'external_media_sales_link' ];
				if ('' == $new) {
					delete_post_meta( $post_id, 'external_media_sales_link');
		        } elseif ( $new && $new != $old ) {
					update_post_meta( $post_id, 'external_media_sales_link', $new );
				} 
			}
			if ( isset( $_POST[ 'external_media_agency' ] ) ){
				$old = get_post_meta( $post_id, 'external_media_agency', true );
	            $new = $_POST[ 'external_media_agency' ];
				if ('' == $new) {
					delete_post_meta( $post_id, 'external_media_agency');
		        } elseif ( $new && $new != $old ) {
					update_post_meta( $post_id, 'external_media_agency', $new );
				}
			}
			
		}
		
		function external_media_item_header( $columns ){
		    $columns_local = array();        
			$columns_local['external_media_disabled_sale'] = "Disabled";
		    return array_merge( $columns_local, $columns );
		}
		
		function external_media_item_content( $column, $post_id ){
		    switch( $column ) {
		        case "external_media_disabled_sale":
		            $this->external_media_item_status( $post_id );
		            break;
		        default:
		            break;
		    }
		}

		function external_media_item_status($post_id) {
			$sale_disabled = get_post_meta( $post_id, 'external_media_disabled_sale', true );
			if ( $sale_disabled && $sale_disabled == '1' ) {
				$sale_link = get_post_meta( $post_id, 'external_media_sales_link', true );
				if ( !empty( $sale_link )) {
					echo '<a target="_blank" href="'.$sale_link.'">Link</a>';
				} else {
					echo "X";
				}
			}
		}
	}
}
		
/**
 * Print the buy button, depending on settings
 *
 * @access      public
 * @return      html
 */
function external_media_item_buy_button($post_id=null, $button=null, $text=null, $echo=true) {
	$prefix = 'sell_media';
	$sale_disabled = get_post_meta( $post_id, 'external_media_disabled_sale', true );
	if ( $sale_disabled && $sale_disabled == '1' ) {
		$sale_link = get_post_meta( $post_id, 'external_media_sales_link', true );
		if ( !empty( $sale_link )) {
			$agency = get_post_meta( $post_id, 'external_media_agency', true );
			$text = apply_filters('sell_media_purchase_text', __( $text,'sell_media' ), $post_id );
			if ( !empty( $agency )) {
				$text = $text.' from '.external_media_agency_list($agency, false);
			}
			$html = '<a target="_blank" href="'.$sale_link.'" class="sell-media-buy-' . $button . '">'.$text.'</a>';	
		} else {
			$html = '<div class="sell-media-buy-' . $button . '">not for sale</div>';
		}		
	} else {
	$html = sell_media_item_buy_button($post_id, $button, $text, $echo);
	}
	if ( $echo ) print $html; else return $html;
}

function external_media_agency_list( $current=null, $create_select=true ){
    $items = array(
		"AL" => "Alamy",
        "GY" => "Getty",
        "IS" => "iStock",
		"SY" => "Stocksy",
        "TS" => "Thinkstock",
        "CB" => "Corbis",
		"WE" => "Westend61"
        );
	if ( $create_select ) {
		sell_media_build_select( $items, array( 'name' => 'external_media_agency', 'required' => false, 'title' => 'Agency', 'current' => $current ) );   
	} else {
		return $items[$current];
	}
}



$externalMedia = new externalMedia();
add_filter( 'manage_edit-sell_media_item_columns', array(&$externalMedia,'external_media_item_header' ));
add_filter( 'manage_pages_custom_column', array(&$externalMedia,'external_media_item_content'), 10, 2 );
add_action( 'sell_media_additional_item_meta_section', array(&$externalMedia, 'external_media_meta_box' ));
add_action( 'save_post', array(&$externalMedia, 'external_media_save_custom_meta' ));
