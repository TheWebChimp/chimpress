<?php

	/*
	 * br.clear
	 */
	function wc_brclear() {
		return '<br class="clear">';
	}
	add_shortcode( 'br.clear', 'wc_brclear' );

	/*
	 * Boilerplate Row
	 */
	function wc_row( $atts , $content = null ) {

		extract( shortcode_atts(
			array(
				'classes' => ''
			), $atts ));

		return '<div class="row ' . $classes . '">' . do_shortcode($content) . '</div>';
	}
	add_shortcode( 'row', 'wc_row' );

	/*
	 * Boilerplate Col
	 */
	function wc_col( $atts , $content = null ) {

		extract( shortcode_atts(
			array(
				'classes' => '',
				'width' => 12
			), $atts ));

		return '<div class="col col-' . $width . ' ' . $classes . '">' . do_shortcode($content) . '</div>';
	}
	add_shortcode( 'col', 'wc_col' );
?>