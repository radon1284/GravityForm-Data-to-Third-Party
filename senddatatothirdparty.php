<?php
/*
Plugin Name: Gravity Form Addon Send Data to Third Party
Plugin URI: http://www.ezyva.com
Description: A simple add-on to Submit Latest Loan Lead
Version: 1.0
Author: Ruel Nopal
Author URI: http://www.radongrafix.com

------------------------------------------------------------------------
Copyright 2012-2013 Rocketgenius Inc.

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
*/


//------------------------------------------
if (class_exists("GFForms")) {
    GFForms::include_addon_framework();

    class GFloanlead extends GFAddOn {

        protected $_version = "1.0";
        protected $_min_gravityforms_version = "1.7.9999";
        protected $_slug = "loanlead";
        protected $_path = "aloanlead/aloanlead.php";
        protected $_full_path = __FILE__;
        protected $_title = "Gravity Forms Add-On for Submit Latest Loan Lead";
        protected $_short_title = "Loan Lead";

        public function init(){
            parent::init();
            add_filter("gform_submit_button", array($this, "form_submit_button"), 10, 2);
        }

        // Add the text in the plugin settings to the bottom of the form if enabled for this form
        function form_submit_button($button, $form){
            $settings = $this->get_form_settings($form);
            if(isset($settings["enabled"]) && true == $settings["enabled"]){
                $text = $this->get_plugin_setting("mytextbox");
                $button = "<div>{$text}</div>" . $button;
            }
            return $button;
        }


        public function plugin_page() {
            ?>
            This page appears in the Forms menu
        <?php
        }

        public function form_settings_fields($form) {
            return array(
                array(
                    "title"  => "Simple Form Settings",
                    "fields" => array(
                        array(
                            "label"   => "My checkbox",
                            "type"    => "checkbox",
                            "name"    => "enabled",
                            "tooltip" => "This is the tooltip",
                            "choices" => array(
                                array(
                                    "label" => "Enabled",
                                    "name"  => "enabled"
                                )
                            )
                        ),
                        array(
                            "label"   => "My checkboxes",
                            "type"    => "checkbox",
                            "name"    => "checkboxgroup",
                            "tooltip" => "This is the tooltip",
                            "choices" => array(
                                array(
                                    "label" => "First Choice",
                                    "name"  => "first"
                                ),
                                array(
                                    "label" => "Second Choice",
                                    "name"  => "second"
                                ),
                                array(
                                    "label" => "Third Choice",
                                    "name"  => "third"
                                )
                            )
                        ),
                        array(
                            "label"   => "My Radio Buttons",
                            "type"    => "radio",
                            "name"    => "myradiogroup",
                            "tooltip" => "This is the tooltip",
                            "choices" => array(
                                array(
                                    "label" => "First Choice"
                                ),
                                array(
                                    "label" => "Second Choice"
                                ),
                                array(
                                    "label" => "Third Choice"
                                )
                            )
                        ),
                        array(
                            "label"   => "My Horizontal Radio Buttons",
                            "type"    => "radio",
                            "horizontal" => true,
                            "name"    => "myradiogrouph",
                            "tooltip" => "This is the tooltip",
                            "choices" => array(
                                array(
                                    "label" => "First Choice"
                                ),
                                array(
                                    "label" => "Second Choice"
                                ),
                                array(
                                    "label" => "Third Choice"
                                )
                            )
                        ),
                        array(
                            "label"   => "My Dropdown",
                            "type"    => "select",
                            "name"    => "mydropdown",
                            "tooltip" => "This is the tooltip",
                            "choices" => array(
                                array(
                                    "label" => "First Choice",
                                    "value" => "first"
                                ),
                                array(
                                    "label" => "Second Choice",
                                    "value" => "second"
                                ),
                                array(
                                    "label" => "Third Choice",
                                    "value" => "third"
                                )
                            )
                        ),
                        array(
                            "label"   => "My Text Box",
                            "type"    => "text",
                            "name"    => "mytext",
                            "tooltip" => "This is the tooltip",
                            "class"   => "medium",
                            "feedback_callback" => array($this, "is_valid_setting")
                        ),
                        array(
                            "label"   => "My Text Area",
                            "type"    => "textarea",
                            "name"    => "mytextarea",
                            "tooltip" => "This is the tooltip",
                            "class"   => "medium merge-tag-support mt-position-right"
                        ),
                        array(
                            "label"   => "My Hidden Field",
                            "type"    => "hidden",
                            "name"    => "myhidden"
                        ),
                        array(
                            "label"   => "My Custom Field",
                            "type"    => "my_custom_field_type",
                            "name"    => "my_custom_field"
                        )
                    )
                )
            );
        }

        public function settings_my_custom_field_type(){
            ?>
            <div>
                My custom field contains a few settings:
            </div>
            <?php
                $this->settings_text(
                    array(
                        "label" => "A textbox sub-field",
                        "name" => "subtext",
                        "default_value" => "change me"
                    )
                );
                $this->settings_checkbox(
                    array(
                        "label" => "A checkbox sub-field",
                        "choices" => array(
                            array(
                                "label" => "Activate",
                                "name" => "subcheck",
                                "default_value" => true
                            )

                        )
                    )
                );
        }

        public function plugin_settings_fields() {
            return array(
                array(
                    "title"  => "Simple Add-On Settings",
                    "fields" => array(
                        array(
                            "name"    => "mytextbox",
                            "tooltip" => "This is the tooltip",
                            "label"   => "This is the label",
                            "type"    => "text",
                            "class"   => "small",
                            "feedback_callback" => array($this, "is_valid_setting")
                        )
                    )
                )
            );
        }

        public function is_valid_setting($value){
            return strlen($value) < 10;
        }

        public function scripts() {
            $scripts = array(
                array("handle"  => "my_script_js",
                      "src"     => $this->get_base_url() . "/js/my_script.js",
                      "version" => $this->_version,
                      "deps"    => array("jquery"),
                      "strings" => array(
                          'first'  => __("First Choice", "loanlead"),
                          'second' => __("Second Choice", "loanlead"),
                          'third'  => __("Third Choice", "loanlead")
                      ),
                      "enqueue" => array(
                          array(
                              "admin_page" => array("form_settings"),
                              "tab"        => "loanlead"
                          )
                      )
                ),

            );

            return array_merge(parent::scripts(), $scripts);
        }

        public function styles() {

            $styles = array(
                array("handle"  => "my_styles_css",
                      "src"     => $this->get_base_url() . "/css/my_styles.css",
                      "version" => $this->_version,
                      "enqueue" => array(
                          array("field_types" => array("poll"))
                      )
                )
            );

            return array_merge(parent::styles(), $styles);
        }



    }

    new GFloanlead();
}

/*
 * Add Custom Gravity form validaation - Ruel Nopal
 * 
 */
add_filter( 'gform_field_validation_1_4', 'validate_phone_1_4', 10, 4 );
function validate_phone_1_4( $result, $value, $form, $field ) {
    session_start();
    $pattern = "/^(\d{10})$/";
    if ( $field->type == 'phone' && phoneFormat != 'standard' && ! preg_match( $pattern, $value ) ) {
        $result['is_valid'] = false;
        $result['message']  = 'Please enter a valid phone number it must be 10 digit number';
    }

    return $result;
}

add_filter( 'gform_field_validation_1_5', 'validate_phone_1_5', 10, 4 );
function validate_phone_1_5( $result, $value, $form, $field ) {
    session_start();
    $pattern = "/^(\d{10})$/";
    if ( $field->type == 'phone' && phoneFormat != 'standard' && ! preg_match( $pattern, $value ) ) {
        $result['is_valid'] = false;
        $result['message']  = 'Please enter a valid work number it must be 10 digit number';
    }

    return $result;
}
add_filter( 'gform_field_validation_1_17', 'validate_phone_1_17', 10, 4 );
function validate_phone_1_17( $result, $value, $form, $field ) {
    session_start();
    $pattern = "/^(\d{13})$/";
    if ( $field->type == 'text' && ! preg_match( $pattern, $value ) ) {
        $result['is_valid'] = false;
        $result['message']  = 'Please enter a valid ID Number it must be 13 digit number';
    }

    return $result;
}

add_filter( 'gform_confirmation_1', 'post_to_lead_service', 10, 3 );
function post_to_lead_service( $confirmation, $form, $entry ) {

    $post_url = 'http://www.quickinsure.co.za/LeadService/Service.asmx/SubmitLatestLoanLead';
    $body     = array(
        'UserId' => rgar( $entry, '16' ),
        'Firstname' => rgar( $entry, '1' ),
        'Surname'  => rgar( $entry, '2' ),
        'Email'    => rgar( $entry, '3' ),
        'CellNo'    => rgar( $entry, '4' ),
        'WorkNo'    => rgar( $entry, '5' ),
        'IdNo'    => rgar( $entry, '17' ),
        'NetSalary'    => rgar( $entry, '18' ),
        'GrossSalary'    => rgar( $entry, '19' ),
        'LoanAmount'    => rgar( $entry, '20' ),
        'EmploymentTime'    => rgar( $entry, '11' ),
        'UnderDebtReview'    => rgar( $entry, '21' ),
        'Bank'    => rgar( $entry, '13' ),
        'SubId'    => rgar( $entry, '14' ),
        'TestMode'    => rgar( $entry, '15' ),
    );
    GFCommon::log_debug( 'gform_confirmation: body => ' . print_r( $body, true ) );

    $request  = new WP_Http();
    $response = $request->post( $post_url, array( 'body' => $body ) );
    GFCommon::log_debug( 'gform_confirmation_1: response => ' . print_r( $response, true ) );

    return $confirmation;
}