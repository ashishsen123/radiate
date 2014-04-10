<?php
/**
 * Radiate Theme Customizer
 *
 * @package ThemeGrill
 * @subpackage Radiate
 * @since Radiate 1.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function radiate_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'radiate_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function radiate_customize_preview_js() {
	wp_enqueue_script( 'radiate_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'radiate_customize_preview_js' );

/*****************************************************************************************/

function radiate_register_theme_customizer( $wp_customize ) {
	// remove control
	$wp_customize->remove_control('blogdescription');
	 
	// rename existing section
	$wp_customize->add_section( 'title_tagline' , array(
		'title' => __('Site Title', 'radiate' ),
		'priority' => 20
	) );

	class RADIATE_ADDITIONAL_Control extends WP_Customize_Control {
		public $type = 'textarea';

		public function render_content() {
			?>
			<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			</label>
			<?php
		}
	}

	$wp_customize->add_setting(
		'radiate_color_scheme',
			array(
				'default'     	=> '#632E9B',
				'sanitize_callback' => 'radiate_sanitize_hex_color',
				'sanitize_js_callback' => 'radiate_sanitize_escaping'	
			)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'color_scheme',
			array(
				'label'      	=> __( 'Primary Color', 'radiate' ),
				'section'    	=> 'colors',
				'settings'   	=> 'radiate_color_scheme'
			)
		)
	);

	$wp_customize->add_section(
		'radiate_custom_css_section',
		array(
			'title'     => __( 'Custom CSS', 'radiate' ),
			'priority'  => 200
		)
	);

	$wp_customize->add_setting(
		'radiate_custom_css',
		array(
		'default'    =>  '',
		'sanitize_callback' => 'radiate_sanitize_custom_css',
		'sanitize_js_callback' => 'radiate_sanitize_escaping'
		)
	);

	$wp_customize->add_control(
		new RADIATE_ADDITIONAL_Control (
			$wp_customize,
			'radiate_custom_css',			
			array(				
				'label'    	=> __( 'Add your custom css here and design live! (for advanced users)' , 'radiate' ),
				'section'   => 'radiate_custom_css_section',
				'settings'  => 'radiate_custom_css'
			)
		)
	);

	$wp_customize->add_section(
		'radiate_featured_section',
		array(
			'title'     => __( 'Front Page Featured Section', 'radiate' ),
			'priority'  => 220
		)
	);

	$wp_customize->add_setting(
		'page-setting-one',
		array(
			'sanitize_callback' => 'radiate_sanitize_integer'
		)
	);
	$wp_customize->add_setting(
		'page-setting-two',
		array(
			'sanitize_callback' => 'radiate_sanitize_integer'
		)
	);
	$wp_customize->add_setting(
		'page-setting-three',
		array(
			'sanitize_callback' => 'radiate_sanitize_integer'
		)
	);

	$wp_customize->add_control(
		'page-setting-one',
			array(
			'type' => 'dropdown-pages',
			'label' => __( 'First featured page', 'radiate' ),
			'section' => 'radiate_featured_section',
		)
	);
	$wp_customize->add_control(
		'page-setting-two',
			array(
			'type' => 'dropdown-pages',
			'label' => __( 'Second featured page', 'radiate' ),
			'section' => 'radiate_featured_section',
		)
	);
	$wp_customize->add_control(
		'page-setting-three',
			array(
			'type' => 'dropdown-pages',
			'label' => __( 'Third featured page', 'radiate' ),
			'section' => 'radiate_featured_section',
		)
	);
 $wp_customize->add_section( 'radiate_color_scheme_settings', array(
		'title'       => __( 'Color Scheme', 'radiate' ),
		'priority'    => 30,
		'description' => 'Select your color scheme',
	) );

	$wp_customize->add_setting( 'radiate_color_scheme', array(
		'default'        => 'red',
	) );

	$wp_customize->add_control( 'radiate_color_scheme', array(
		'label'   => 'Choose your color scheme',
		'section' => 'radiate_color_scheme_settings',
		'default'        => 'red',
		'type'       => 'radio',
		'choices'    => array(
			__( 'Blue', 'locale' ) => 'blue',
			__( 'Red', 'locale' ) => 'red',
			__( 'Green', 'locale' ) => 'green',
			__( 'Gray', 'locale' ) => 'gray',
		),
	) );

	function radiate_sanitize_hex_color( $color ) {
		if ( $unhashed = sanitize_hex_color_no_hash( $color ) )
			return '#' . $unhashed;

		return $color;
	}

	function radiate_sanitize_custom_css( $input) {
		$input = wp_kses_stripslashes( $input);
		return $input;
	}	

	function radiate_sanitize_integer( $input ) {
    	if( is_numeric( $input ) ) {
        return intval( $input );
   	}
	}

	function radiate_sanitize_escaping( $input) {
		$input = esc_attr( $input);
		return $input;
	}

}
add_action( 'customize_register', 'radiate_register_theme_customizer' );


