<?php
/**
 * Homepage functions.
 *
 * @package ThinkUpThemes
 */

/* ----------------------------------------------------------------------------------
	ENABLE HOMEPAGE SLIDER
---------------------------------------------------------------------------------- */

// Add Slider - Homepage
function thinkup_input_sliderhome() {
global $thinkup_homepage_sliderswitch;
global $thinkup_homepage_slidername;
global $thinkup_homepage_sliderpreset;

$thinkup_class_fullwidth = NULL;
$slider_toggle           = NULL;

	if ( is_front_page() or thinkup_check_ishome() ) {

		// Check if any slides have been assigned to ThinkUpSlider
		if ( isset( $thinkup_homepage_sliderpreset ) and is_array( $thinkup_homepage_sliderpreset ) ) {
			foreach( $thinkup_homepage_sliderpreset as $slide ) {
				$slide_image_url = $slide['slide_image_url'];
				if( ! empty( $slide_image_url ) ) {
					$slider_toggle = '1';	
				}
			}
		}

		if ( empty( $thinkup_homepage_sliderswitch ) or $thinkup_homepage_sliderswitch == 'option1' ) {

			echo '<div id="slider"><div id="slider-core">',
			     '<div class="rslides-container"><div class="rslides-inner"><ul class="slides">';
				if ( empty( $slider_toggle ) ) {		 
					echo '<li><img src="' . esc_url( get_template_directory_uri() ) . '/images/transparent.png" style="background: url(' . esc_url( get_template_directory_uri() ) . '/images/slideshow/slide_demo1.png) no-repeat center; background-size: cover;" alt="Demo Image" /></li>';
					echo '<li><img src="' . esc_url( get_template_directory_uri() ) . '/images/transparent.png" style="background: url(' . esc_url( get_template_directory_uri() ) . '/images/slideshow/slide_demo2.png) no-repeat center; background-size: cover;" alt="Demo Image" /></li>';
					echo '<li><img src="' . esc_url( get_template_directory_uri() ) . '/images/transparent.png" style="background: url(' . esc_url( get_template_directory_uri() ) . '/images/slideshow/slide_demo3.png) no-repeat center; background-size: cover;" alt="Demo Image" /></li>';
				} else if (isset($thinkup_homepage_sliderpreset) && is_array($thinkup_homepage_sliderpreset)) {
					foreach ($thinkup_homepage_sliderpreset as $slide) {
						echo '<li>',
							 '<img src="' . esc_url( get_template_directory_uri() ) . '/images/transparent.png" style="background: url(' . esc_url( $slide['slide_image_url'] ) . ') no-repeat center; background-size: cover;" alt="' . esc_attr( $slide['slide_title'] ) . '" />',
							 '<div class="rslides-content">',
							 '<div class="wrap-safari">',
							 '<div class="rslides-content-inner">',
							 '<div class="featured">';
							 
								if ( ! empty( $slide['slide_title'] ) ) {
									echo '<div class="featured-title">',
										 '<span>' . esc_html( $slide['slide_title'] ) . '</span>',
										 '</div>';
								}
								if ( ! empty( $slide['slide_description'] ) ) {
									$slide_description = str_replace( '<p>', '<p><span>', wpautop( $slide['slide_description'] ));
									$slide_description = str_replace( '</p>', '</span></p>', $slide_description );
									echo '<div class="featured-excerpt">',
										 $slide_description,
										 '</div>';
								}
								if ( ! empty( $slide['slide_url'] ) ) {
									echo '<div class="featured-link">',
										 '<a href="' . esc_url( $slide['slide_url'] ) . '"><span>' . __( 'Read More', 'lan-thinkupthemes' ) . '</a></span>',
										 '</div>';
								}

						 echo '</div>',
							  '</div>',
							  '</div>',
							  '</div>',
							  '</li>';
					}
				}
			echo '</ul></div></div>',
			     '</div></div><div class="clearboth"></div>';
		} else if ( $thinkup_homepage_sliderswitch !== 'option2' or empty( $thinkup_homepage_slidername ) ) {
			echo '';
		} else {
			echo	'<div id="slider"><div id="slider-core">',
				do_shortcode( $thinkup_homepage_slidername ),
				'</div></div><div class="clearboth"></div>';
		}
	}
}

// Add ThinkUpSlider Height - Homepage
function thinkup_input_sliderhomeheight() {
global $thinkup_homepage_sliderswitch;
global $thinkup_homepage_sliderpresetheight;

	if ( empty( $thinkup_homepage_sliderpresetheight ) ) $thinkup_homepage_sliderpresetheight = '350';

	if ( is_front_page() or thinkup_check_ishome() ) {
		if ( empty( $thinkup_homepage_sliderswitch ) or $thinkup_homepage_sliderswitch == 'option1' ) {
		echo 	"\n" .'<style type="text/css">' . "\n",
			'#slider .rslides, #slider .rslides li { height: ' . esc_html( $thinkup_homepage_sliderpresetheight ) . 'px; max-height: ' . esc_html( $thinkup_homepage_sliderpresetheight ) . 'px; }' . "\n",
			'#slider .rslides img { height: 100%; max-height: ' . esc_html( $thinkup_homepage_sliderpresetheight ) . 'px; }' . "\n",
			'</style>' . "\n";
		}
	}
}
add_action( 'wp_head','thinkup_input_sliderhomeheight', '13' );

/* Add full width slider class to body */
function thinkup_input_sliderclass($classes){
global $thinkup_homepage_sliderswitch;
global $thinkup_homepage_sliderpresetwidth;

global $post;
$_thinkup_meta_slider     = get_post_meta( $post->ID, '_thinkup_meta_slider', true );
$_thinkup_meta_sliderpage = get_post_meta( $post->ID, '_thinkup_meta_sliderimages', true ); 

	if ( is_front_page() or thinkup_check_ishome() ) {
		if ( empty( $thinkup_homepage_sliderswitch ) or $thinkup_homepage_sliderswitch == 'option1' ) {
			if ( empty( $thinkup_homepage_sliderpresetwidth ) or $thinkup_homepage_sliderpresetwidth == '1' ) {
				$classes[] = 'slider-full';
			} else {
				$classes[] = 'slider-boxed';
			}
		}
	} else if ( ! is_front_page() and !thinkup_check_ishome() and !is_archive() and $_thinkup_meta_slider == 'on' ) {
		if ( $_thinkup_meta_sliderpage['full_width'] == 'on' ) {
			$classes[] = 'slider-full';
		} else {
			$classes[] = 'slider-boxed';
		}
	}
	return $classes;
}
add_action( 'body_class', 'thinkup_input_sliderclass');


//----------------------------------------------------------------------------------
//	ENABLE HOMEPAGE CONTENT
//----------------------------------------------------------------------------------

function thinkup_input_homepagesection() {
global $thinkup_homepage_sectionswitch;
global $thinkup_homepage_section1_image;
global $thinkup_homepage_section1_title;
global $thinkup_homepage_section1_desc;
global $thinkup_homepage_section1_link;
global $thinkup_homepage_section2_image;
global $thinkup_homepage_section2_title;
global $thinkup_homepage_section2_desc;
global $thinkup_homepage_section2_link;
global $thinkup_homepage_section3_image;
global $thinkup_homepage_section3_title;
global $thinkup_homepage_section3_desc;
global $thinkup_homepage_section3_link;

	// Set default values for images
	if ( ! empty( $thinkup_homepage_section1_image ) )
		$thinkup_homepage_section1_image = wp_get_attachment_image_src($thinkup_homepage_section1_image, 'column3-1/3');

	if ( ! empty( $thinkup_homepage_section2_image ) )
		$thinkup_homepage_section2_image = wp_get_attachment_image_src($thinkup_homepage_section2_image, 'column3-1/3');

	if ( ! empty( $thinkup_homepage_section3_image ) )
		$thinkup_homepage_section3_image = wp_get_attachment_image_src($thinkup_homepage_section3_image, 'column3-1/3');

	// Set default values for titles
	if ( empty( $thinkup_homepage_section1_title ) ) $thinkup_homepage_section1_title = __( 'Perfect For All', 'lan-thinkupthemes' );
	if ( empty( $thinkup_homepage_section2_title ) ) $thinkup_homepage_section2_title = __( '100% Responsive', 'lan-thinkupthemes' );
	if ( empty( $thinkup_homepage_section3_title ) ) $thinkup_homepage_section3_title = __( 'Powerful Framework', 'lan-thinkupthemes' );

	// Set default values for descriptions
	if ( empty( $thinkup_homepage_section1_desc ) ) 
	$thinkup_homepage_section1_desc = __( 'The modern design of Minamaze (Lite) makes it the perfect choice for any website. Business, charity, blog, well everything!', 'lan-thinkupthemes' );

	if ( empty( $thinkup_homepage_section2_desc ) ) 
	$thinkup_homepage_section2_desc = __( 'Minamaze (Lite) is 100% responsive. It looks great on all devices, from mobile to desktops and everything in between!', 'lan-thinkupthemes' );

	if ( empty( $thinkup_homepage_section3_desc ) ) 
	$thinkup_homepage_section3_desc = __( 'Get a taste of our awesome ThinkUpThemes Framework and make changes to your site easily, without touching any code at all!', 'lan-thinkupthemes' );

	// Get page names for links
	if ( !empty( $thinkup_homepage_section1_link ) ) $thinkup_homepage_section1_link = get_permalink( $thinkup_homepage_section1_link );
	if ( !empty( $thinkup_homepage_section2_link ) ) $thinkup_homepage_section2_link = get_permalink( $thinkup_homepage_section2_link );
	if ( !empty( $thinkup_homepage_section3_link ) ) $thinkup_homepage_section3_link = get_permalink( $thinkup_homepage_section3_link );


	if ( is_front_page() or thinkup_check_ishome() ) {
		if ( empty( $thinkup_homepage_sectionswitch ) or $thinkup_homepage_sectionswitch == '1' ) {

		echo '<div id="section-home"><div id="section-home-inner">';

			echo '<article class="section1 one_third">',
					'<div class="section">',
					'<div class="entry-header">';
					if ( empty( $thinkup_homepage_section1_image ) ) {
						echo '<img src="' . esc_url( get_template_directory_uri() ) . '/images/slideshow/featured1.png' . '" alt="" />';
					} else {
						echo '<img src="' . esc_url( $thinkup_homepage_section1_image[0] ) . '"  alt="" />';
					}
			echo	'</div>',
					'<div class="entry-content">',
					'<h3>' . esc_html( $thinkup_homepage_section1_title ) . '</h3>' . wpautop( do_shortcode ( esc_html( $thinkup_homepage_section1_desc ) ) ),
					'<p><a href="' . esc_url( $thinkup_homepage_section1_link ) . '" class="more-link themebutton">' . __( 'Read More', 'lan-thinkupthemes' ) . '</a></p>',
					'</div>',
					'</div>',
				'</article>';

			echo '<article class="section2 one_third">',
					'<div class="section">',
					'<div class="entry-header">';
					if ( empty( $thinkup_homepage_section2_image ) ) {
						echo '<img src="' . esc_url( get_template_directory_uri() ) . '/images/slideshow/featured2.png' . '"  alt="" />';
					} else {
						echo '<img src="' . esc_url( $thinkup_homepage_section2_image[0] ) . '"  alt="" />';
					}
			echo	'</div>',
					'<div class="entry-content">',
					'<h3>' . esc_html( $thinkup_homepage_section2_title ) . '</h3>' . wpautop( do_shortcode ( esc_html( $thinkup_homepage_section2_desc ) ) ),
					'<p><a href="' . esc_url( $thinkup_homepage_section2_link ) . '" class="more-link themebutton">' . __( 'Read More', 'lan-thinkupthemes' ) . '</a></p>',
					'</div>',
					'</div>',
				'</article>';

			echo '<article class="section3 one_third last">',
					'<div class="section">',
					'<div class="entry-header">';
					if ( empty( $thinkup_homepage_section3_image ) ) {
						echo '<img src="' . esc_url( get_template_directory_uri() ) . '/images/slideshow/featured3.png' . '"  alt="" />';
					} else {
						echo '<img src="' . esc_url( $thinkup_homepage_section3_image[0] ) . '"  alt="" />';
					}
			echo	'</div>',
					'<div class="entry-content">',
					'<h3>' . esc_html( $thinkup_homepage_section3_title ) . '</h3>' . wpautop( do_shortcode ( esc_html( $thinkup_homepage_section3_desc ) ) ),
					'<p><a href="' . esc_url( $thinkup_homepage_section3_link ) . '" class="more-link themebutton">' . __( 'Read More', 'lan-thinkupthemes' ) . '</a></p>',
					'</div>',
					'</div>',
				'</article>';

		echo '<div class="clearboth"></div></div></div>';
		}
	}
}


/* ----------------------------------------------------------------------------------
	CALL TO ACTION - INTRO
---------------------------------------------------------------------------------- */

function thinkup_input_ctaintro() {
global $thinkup_homepage_introswitch;
global $thinkup_homepage_introaction;
global $thinkup_homepage_introactionteaser;
global $thinkup_homepage_introactionbutton;
global $thinkup_homepage_introactionlink;
global $thinkup_homepage_introactionpage;
global $thinkup_homepage_introactioncustom;

	if ( $thinkup_homepage_introswitch == '1' and ( is_front_page() or thinkup_check_ishome() ) and ! empty( $thinkup_homepage_introaction ) ) {
		echo '<div id="introaction"><div id="introaction-core">';
		if (empty( $thinkup_homepage_introactionbutton ) ) {
			if ( empty( $thinkup_homepage_introactionteaser ) ) {
				echo	'<div class="action-text">
						<h3>' . esc_html( $thinkup_homepage_introaction ) . '</h3>
						</div>';
				} else {
				echo	'<div class="action-text action-teaser">
						<h3>' . esc_html( $thinkup_homepage_introaction ) . '</h3>
						<p>' . esc_html( $thinkup_homepage_introactionteaser ) . '</p>
						</div>';
				}
		} else if ( ! empty( $thinkup_homepage_introactionbutton ) ) {
			if ( empty( $thinkup_homepage_introactionteaser ) ) {
				echo	'<div class="action-text three_fourth">
						<h3>' . esc_html( $thinkup_homepage_introaction ) . '</h3>
						</div>';
				} else {
				echo	'<div class="action-text three_fourth action-teaser">
						<h3>' . esc_html( $thinkup_homepage_introaction ) . '</h3>
						<p>' . esc_html( $thinkup_homepage_introactionteaser ) . '</p>
						</div>';
				}
			if ( $thinkup_homepage_introactionlink == 'option1' ) {
				echo '<div class="action-button one_fourth last"><a href="' . esc_url( get_permalink( $thinkup_homepage_introactionpage ) ) . '"><h4 class="themebutton">';
				echo esc_html( $thinkup_homepage_introactionbutton );
				echo '</h4></a></div>';
			} else if ( $thinkup_homepage_introactionlink == 'option2' ) {
				echo '<div class="action-button one_fourth last"><a href="' . esc_url( $thinkup_homepage_introactioncustom ) . '"><h4 class="themebutton">';
				echo esc_html( $thinkup_homepage_introactionbutton );
				echo '</h4></a></div>';
			} else if ( $thinkup_homepage_introactionlink == 'option3' or empty( $thinkup_homepage_introactionlink ) ) {
				echo '<div class="action-button one_fourth last"><h4 class="themebutton">';
				echo esc_html( $thinkup_homepage_introactionbutton );
				echo '</h4></div>';
			}
		}
		echo '</div></div>';
	}
}


?>