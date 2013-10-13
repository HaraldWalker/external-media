<?php

/*
Plugin Name: External Media
Plugin URI: 
Description: A plugin for sell media to reference external sites
Version: 0.0.1
Author: Harald Walker
Author URI: 
Author Email: walker@mediasculp.com
License: GPL
*/

if (!class_exists('externalMedia')) {
	class externalMedia {
		function externalMedia() {
			$this->version = "0.0.1";
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
			echo "Sales link: ".$sale_link;
			$text = apply_filters('sell_media_purchase_text', __( $text,'sell_media' ), $post_id );
			$html = '<a href="'.$sale_link.'" class="sell-media-buy-' . $button . '">'.$text.'</a>';	
		} else {
			$html = '<div class="sell-media-buy-' . $button . '">not for sale</div>';
		}		
	} else {
	$html = sell_media_item_buy_button($post_id, $button, $text, $echo);
	}
	if ( $echo ) print $html; else return $html;
}

$externalMedia = new externalMedia();
add_action('sell_media_additional_item_meta_section', array(&$externalMedia, 'external_media_meta_box'));
add_action('save_post', array(&$externalMedia, 'external_media_save_custom_meta'));