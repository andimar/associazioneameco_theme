<?php
function ameco_customize_register( $wp_customize ) {
   //All our sections, settings, and controls will be added here
   $wp_customize->add_section( 'ameco_home_section' , array(
       'title'      => __( 'Home', 'ameco' ),
       'priority'   => 30,
   ) );

   $wp_customize->add_setting( 'home_title' , array(
     'type'        => 'option',
     'default'     => '',
     'transport'   => 'postMessage',
   ));

   $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'home_title_ctl', array(
     'label'      => __( 'Titolo del testo in home', 'ameco' ),
     'section'    => 'ameco_home_section',
     'settings'   => 'home_title',
   ) ) );

   $wp_customize->add_setting( 'home_text' , array(
     'type'        => 'option',
     'default'     => '',
     'transport'   => 'postMessage',
   ));

   $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'home_text_ctl', array(
     'label'      => __( 'Testo in home', 'ameco' ),
     'section'    => 'ameco_home_section',
     'settings'   => 'home_text',
     "type"       => 'textarea',
   ) ) );

   $wp_customize->get_setting( 'home_text' )->transport = 'postMessage';
   $wp_customize->get_setting( 'home_title' )->transport = 'postMessage';
   $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
   $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
   $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
   $wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
}
add_action( 'customize_register', 'ameco_customize_register' );




function ameco_customizer_live_preview()
{
	wp_enqueue_script('ameco-themecustomizer', get_theme_file_uri( '_/js/theme-customizer.js' ), array( 'customize-preview' ), '', false );
}
add_action( 'customize_preview_init', 'ameco_customizer_live_preview' );

?>
