<?php
/**
 * Plugin Name:       Advanced Call Now Button
 * Plugin URI:        
 * Description:       Advanced call now button, website visitors on a mobile device can call your business with a single click.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.0
 * Author:            Panagiotis Spyropoulos
 * Author URI:        
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

 // Initialize the actions

 add_action( 'admin_menu', 'adcnb_add_admin_menu' );
 add_action( 'admin_init', 'adcnb_settings_init' );

 // Add to footer if enabled

 add_action( 'wp_footer', 'cadcnb_code' );

 // Add menu => Tools

 function adcnb_add_admin_menu( ) {

    add_submenu_page ( 
        'options-general.php', // Top level menu page
        'Advanced Call Now Button', // Title of the settings page
        'Advanced Call Now Button', // Title of the submenu
        'manage_options', // Capability of the user to see this page
        'advanced_call_now_button', // Slug of the settings page
        'adcnb_options_page' // Callback function to be called when rendering the page
    );
}

// Initialize settings

function adcnb_settings_init( ) {

    register_setting( 'adcnb_plugin_page', 'adcnb_settings' );

    add_settings_section(
        'adcnb_page_section', // Id of the section
        '', // Title to be displayed
        '', // Callback function to be called when opening section
        'adcnb_plugin_page' // Page on which to display the section, this should be the same as the slug used in add_submenu_page()
    );
    
    add_settings_field(
        'adcnb_enable', // Id of the settings field
        'Button status:', // Title
        'adcnb_enable_render', // Callback function
        'adcnb_plugin_page', // Page on which settings display
        'adcnb_page_section' // Section on which to show settings
    );
    
    add_settings_field(
        'adcnb_phone', // Id of the settings field
        'Phone number:', // Title
        'adcnb_phone_render', // Callback function
        'adcnb_plugin_page', // Page on which settings display
        'adcnb_page_section' // Section on which to show settings
    );
    
    add_settings_field(
        'adcnb_message', // Id of the settings field
        'Button text:', // Title
        'adcnb_message_render', // Callback function
        'adcnb_plugin_page', // Page on which settings display
        'adcnb_page_section' // Section on which to show settings
    );

    // Initialize week day's field's Week, Days:
    
}

// Initialize admin input's

function adcnb_enable_render( ) {
    
    $options = get_option ( 'adcnb_settings' );

    ?>

    <input name="adcnb_settings[adcnb_enable]" type="hidden" value="0" />
    <input name="adcnb_settings[adcnb_enable]" type="checkbox" value="1" <?php checked( '1', $options['adcnb_enable'] ); ?> />
    <label title="Enable" for="activated">Enabled</label>

    <?php

}

function adcnb_phone_render( ) {

    $options = get_option ( 'adcnb_settings' );

    ?>

    <input type='text' placeholder="+0030 0000000000" name='adcnb_settings[adcnb_phone]' value='<?php echo $options['adcnb_phone']; ?>'>
    <p class="description">Do not forget to dial the international dialing code “00” or “+” before the country code. <span class="whatsThis">(<a href="#" target="_blank">Find your code...</a>)</span></p>

    <?php

}

function adcnb_message_render( ) {

    $options = get_option ( 'adcnb_settings' );

    ?>

    <input type='text' placeholder="Call Now!" name='adcnb_settings[adcnb_message]' value='<?php echo $options['adcnb_message']; ?>'>
    <p class="description">Make sure to check on your phone if the text fits your button! <span class="whatsThis">(<a href="#" target="_blank">Learn why...</a>)</span></p>

    <?php

}

// Initialize week days input's


// Output Code If Enabled

function cadcnb_code( ) {
    
    $options = get_option( 'adcnb_settings' );

    if ($options['adcnb_enable'] == '1') {

        echo '<a href="tel:' . $options['adcnb_phone_render'] . '" id="adcnb_btn">' . $options['adcnb_message'] . '</a>';

        wp_enqueue_style('adcnb-styles', plugin_dir_url( __FILE__ ) . 'style.css' );
    }
}

// The function to be called to output the content for this page

function adcnb_options_page( ) {

// Check user capabilities

    if (!current_user_can('manage_options')) { return; }

    ?>

    <div style="max-width: 1050px;">

    <h1>Advanced Call Now Button <span style="font-weight:200;">v1.0.0</span><div style="width: 20px; height: 20px; border-radius: 20px; margin: 0; background: <?php  $options = get_option( 'adcnb_settings' ); if ($options['adcnb_enable'] == '1') { echo 'green';} else { echo 'red'; } ?>; display: inline; position: absolute; margin-left: 10px;"></div></h1>
    <h2 style="font-weight: 200;">With advanced call now button, website visitors on a mobile device can call your business with a single click.</h2>

    <form action='options.php' method='post'>

        <?php

    // Check what tab is active and change through them

            settings_fields( 'adcnb_plugin_page' );
            do_settings_sections( 'adcnb_plugin_page' );
            
            submit_button();

        ?>

    </form>

    <div class="feedback-collection">

        <hr>

            <div class="postbox cnb-alert-box cnb-center" style="margin-bottom: 0;padding-left:25px;padding-right: 25px;text-align: justify;">

                <h3>Get In Touch With Us</h3>

                <p>Whether you’re a WordPress newbie looking for help setting everything up or a seasoned pro who needs specialty expertise to grow, we all need a little help with our WordPress sites from time to time. And it’s important for you to understand where and how to hire WordPress developers before you start looking. After all, you don’t want to pay for disappointing work.</p>

                <p>We would love to hear from you.<br>
                Please <a href="#">contact us</a> at any time with questions or feedback.</p>

            </div>

        <hr>

    </div>

</div>

<?php

}

?>