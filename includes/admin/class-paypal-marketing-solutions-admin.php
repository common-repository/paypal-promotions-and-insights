<?php
/**
 * :iTechArt-Group
 *
 * NOTICE OF LICENSE
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * @author     Komrakov Andrei <andrei.komrakov@itechart-group.com>
 * @copyright  Copyright (c) 2002-2017 :iTechArt-Group (https://www.itechart.com/)
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2, June 1991  (GNU GPL v2.0)
 */

if ( ! class_exists( 'Paypal_Marketing_Solutions_Admin' ) )
{

    /**
     * Class which handles admin output and settings
     */
    class Paypal_Marketing_Solutions_Admin
    {

        /**
         * PayPal Marketing Solutions submenu slug for WordPress admin menu
         */
        const SUBMENU_PAGE_ID      = 'paypal-marketing-solutions.php';

        /**
         * PayPal Marketing Solutions settings section identifier
         */
        const SETTINGS_SECTION_ID  = 'paypal-marketing-solutions-general-section';

        /**
         * Paypal Marketing Solutions Bundle Js source
         */
        const PAYPAL_BUNDLE_JS_SRC = 'https://www.paypalobjects.com/muse/partners/muse-button-bundle.js';

        /**
         * Data for WordPress settings
         *
         * @var array
         */
        protected $_settings      = array();


        /**
         * Paypal_Marketing_Solutions_Admin constructor.
         */
        public function __construct()
        {
            // Populate default settings data
            $this->_settings = $this->_get_default_settings_data();

            // Add submenu
            add_action( 'admin_menu', array( &$this, 'add_submenu_page' ) );

            // Add wp settings and wp settings renderers
            add_action( 'admin_init', array( &$this, 'add_settings_renderers' ) );

            // Add ajax action handler for saving container id
            add_action( 'wp_ajax_paypal_marketing_solutions_ajax_save_container_id', array( &$this, 'ajax_save_container_id' ) );

            // Add styles
            add_action( 'admin_enqueue_scripts', array( &$this, 'callback_for_setting_up_admin_scripts' ) );
        }

        /**
         * WordPress wp_enqueue_scripts action callback.
         * Add styles
         */
        public function callback_for_setting_up_admin_scripts()
        {
            wp_register_style( 'pppi_styles', plugins_url( 'assets/css/pppi.css', PAYPAL_MARKETING_SOLUTIONS__PLUGIN ) );

            wp_enqueue_style( 'pppi_styles' );
        }

        /**
         * Ajax action handler for saving container id
         */
        public function ajax_save_container_id()
        {
            if ( ! empty( $_POST['container_id'] ) ) {
                $cid = sanitize_text_field( $_POST['container_id'] );
                if ( $cid ) {
                    update_option( 'paypal_marketing_solutions_container_id', $cid );
                }
            }

            wp_die();
        }

        /**
         * WordPress admin_menu action callback.
         * Adds PayPal Marketing Solutions submenu item to WP Settings Top-Level menu
         */
        public function add_submenu_page()
        {
            add_submenu_page(
                'options-general.php',
                __( 'PayPal Marketing Solutions' ),
                __( 'PayPal Marketing Solutions' ),
                'manage_options',
                self::SUBMENU_PAGE_ID,
                array( &$this, 'submenu_page_callback' )
            );
        }

        /**
         * WordPress add_submenu_page callback.
         * Renders settings and adds PayPal js integration
         */
        public function submenu_page_callback()
        {
            // check user capabilities
            if ( ! current_user_can( 'manage_options' ) ) {
                return;
            }

            ?>

            <div class="wrap bootstrap-wrapper">
                <style>
                    .paypal_promotions_container__header-banner {
                        background: url( "<?php echo plugins_url( 'assets/img/header-image.png', PAYPAL_MARKETING_SOLUTIONS__PLUGIN ) ?>" ) no-repeat;
                        height: 200px;
                        margin: 0 auto;
                        max-width: 750px;
                    }

                    .paypal_promotions_container__row .item__image-first {
                        background: url( "<?php echo plugins_url( 'assets/img/icon-1.png', PAYPAL_MARKETING_SOLUTIONS__PLUGIN ) ?>" ) no-repeat;
                        position: relative;
                    }

                    .paypal_promotions_container__row .item__image-second {
                        background: url( "<?php echo plugins_url( 'assets/img/icon-2.png', PAYPAL_MARKETING_SOLUTIONS__PLUGIN ) ?>" ) no-repeat;
                    }

                    .paypal_promotions_container__row .item__image-third {
                        background: url( "<?php echo plugins_url( 'assets/img/icon-3.png', PAYPAL_MARKETING_SOLUTIONS__PLUGIN ) ?>" ) no-repeat;
                    }

                    div.maccordion {
                        border: solid 1px #e4e7ee;
                        cursor: pointer;
                        padding: 13px 18px 12px 52px;
                        width: 100%;
                        text-align: left;
                        outline: none;
                        transition: 0.4s;
                        line-height: 1.79;
                        color: #227bc0;
                        vertical-align: middle;
                        font-family: 'PayPal-Sans', sans-serif;
                        display: inline-block;
                        background: url(" <?php echo plugins_url( 'assets/img/arrow.png', PAYPAL_MARKETING_SOLUTIONS__PLUGIN ) ?>" ) no-repeat;
                        background-position-x: 30px;
                        background-position-y: center;
                        background-color: #fff;
                        background-size: 8px;
                        font-size: 16px;
                    }

                    div.maccordion.active {
                        background: url(" <?php echo plugins_url( 'assets/img/arrow-down.png', PAYPAL_MARKETING_SOLUTIONS__PLUGIN ) ?>" ) no-repeat;
                        background-position-x: 27px;
                        background-position-y: center;
                        background-color: #fff;
                        background-size: 13px;
                    }
                </style>
                <div class="paypal_promotions_container">
                    <div class="paypal_promotions_container__box">
                        <div class="paypal_promotions_container__header-banner"></div>
                        <div class="paypal_promotions_container__header-text">
                            <h2 class="paypal_big_header">
                                Help increase sales through the power of PayPal shopping data with targeted promotions
                            </h2>
                        </div>
                        <div class="paypal_promotions_container__content">
            <span>
                PayPal for Marketing - a suite of marketing solutions to help businesses increase sales through greater visibility into the marketing funnel and actionable promotional messages at every step in the customer journey.
            </span>
                        </div>
                        <div class="paypal_promotions_container__action-btn">
                            <div id='muse-activate-managesettings-button'></div>
                        </div>
                        <div class="paypal_promotions_container__row">
                            <div class="row__item">
                                <div class="item__image item__image-first">
                                    <div>68%</div>
                                </div>
                                <div class="item__text">
                                    Merchants like you have increased their average order value (AOV) by <b>up to 68%*</b>
                                </div>
                            </div>
                            <div class="row__item">
                                <div class="item__image item__image-second"></div>
                                <div class="item__text">
                                    Join <b>20,000 merchants</b> who are promoting financing options on their site to boost sales
                                </div>
                            </div>
                            <div class="row__item">
                                <div class="item__image item__image-third"></div>
                                <div class="item__text">
                                    <b>Get insights</b> about your visitors and how they shop on your site
                                </div>
                            </div>
                        </div>
                        <div class="box__footer">
                            * As reported in Nielsen’s PayPal Credit Average Order Value Study for activity occurring from April 2015 to March 2016 (small merchants) and October 2015 to March 2016 (midsize merchants), which compared PayPal Credit transactions to credit and debit card transactions on websites that offer PayPal Credit as a payment option or within the PayPal Wallet. Nielsen measured 284890 transactions across 27 mid and small merchants. Copyright Nielsen 2016.
                        </div>
                    </div>

                    <div class="paypal_promotions__maccordion_wrapper">
                        <div class="maccordion">How do I enable Marketing Solutions?</div>
                        <div class="mpanel">
                            <ol>
                                <li>Click on "Activate PayPal Insights"</li>
                                <li>Login to PayPal with your PayPal Business Account. This account will get valuable insights from data gathered about PayPal shoppers browsing your site.</li>
                                <li>Enter your Website URL and click on Agree and Continue. On the next screen, click Done.</li>
                                <li>PayPal Marketing Solutions is now enabled on your storefront.</li>
                            </ol>
                            <div class="faq__info">
                                Note:
                            </div>
                            <ul>
                                <li>Your customers will see a one-line message at the bottom of the screen reminding them they can have more time to pay with PayPal Credit</li>
                                <li>The message can be dismissed in one click, and only shows up to 3 times per user session.</li>
                                <li>If the message has been dismissed and has to be viewed again, clear the browser's cache and cookies and reload the page.</li>
                                <li>Once you’ve connected your PayPal Business account, you will not be able to change the account. You will have to uninstall and reinstall the app to connect a new PayPal account.</li>
                            </ul>
                        </div>

                        <div class="maccordion">How do I disable Marketing Solutions and update my settings?</div>
                        <div class="mpanel">
                            <ol>
                                <li>Click on "Manage Settings".</li>
                                <li>Login to PayPal with your PayPal Business Account.</li>
                                <li>Here you will be able to disable Shopper Marketing Solutions.</li>
                            </ol>
                        </div>

                        <div class="maccordion">How do I uninstall the Marketing Solutions App?</div>
                        <div class="mpanel">
                            <ol>
                                <li>Go to the "My addons" page.</li>
                                <li>Find PayPal Marketing Solutions module and click uninstall.</li>
                            </ol>
                        </div>

                        <div class="maccordion">Who can help if I have questions?</div>
                        <div class="mpanel">
                            <div class="faq__info">
                                Please contact PayPal by following this <a href="https://www.paypal.com/us/selfhelp/home">link</a>.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script src='<?php echo self::PAYPAL_BUNDLE_JS_SRC; ?>'></script>
            <script>
                jQuery( document ).ready(function($) {
                    var muse_options = {
                        onContainerCreate: callback_onsuccess,
                        hn: "<?php echo get_site_url(); ?>",
                        partner_name: "WordPress",
                        bn_code: "ITECHART_WORDPRESS",
                        env: "production",
                        cid: "<?php echo esc_attr( get_option( 'paypal_marketing_solutions_container_id' ) ); ?>"
                    };

                    function callback_onsuccess( containerId ) {
                        muse_options.cid = containerId;
                        var data = {
                            'action': 'paypal_marketing_solutions_ajax_save_container_id',
                            'container_id': containerId
                        };

                        jQuery.post( ajaxurl, data );
                    }

                    MUSEButton( 'muse-activate-managesettings-button', muse_options );
                });
            </script>

            <script>
                var acc = document.getElementsByClassName( "maccordion" );
                var i;
                for ( i = 0; i < acc.length; i++ ) {
                    acc[i].onclick = function() {
                        /* Toggle between adding and removing the "active" class,
                        to highlight the button that controls the mpanel */
                        this.classList.toggle( "active" );
                        /* Toggle between hiding and showing the active mpanel */
                        var panel = this.nextElementSibling;
                        if ( panel.style.display === "block" ) {
                            panel.style.display = "none";
                        } else {
                            panel.style.display = "block";
                        }
                    }
                }
            </script>
            <?php
        }

        /**
         * WordPress admin_init callback.
         * Calls methods to register settings, sections and fields
         */
        public function add_settings_renderers()
        {
            // register settings
            $this->_register_settings();

            if ( ! esc_attr( get_option( 'paypal_marketing_solutions_container_id' ) ) ) {
                if ( $containerId = esc_attr( get_option ( 'paypal_promotions_and_insights_container_id' ) ) ) {
                    update_option( 'paypal_marketing_solutions_container_id', $containerId );
                }
            }
        }

        /**
         * WordPress add_settings_section callback
         */
        public function _add_settings_section_callback() {}

        /**
         * Register WordPress settings.
         * Should be called inside admin_init action callback
         */
        protected function _register_settings()
        {
            foreach ( $this->_settings as $groupName => $groupData ) {
                foreach ( $groupData as $optionName => $optionData ) {
                    $this->_register_setting( $groupName, $optionName, $optionData );
                }
            }
        }

        /**
         * Get default data for wp settings
         *
         * @return array
         */
        protected function _get_default_settings_data()
        {
            return array(
                'paypal_marketing_solutions' => array(
                    'paypal_promotions_and_insights_container_id' => array(
                        'type'              => 'string',
                        'group'             => 'paypal_marketing_solutions',
                        'description'       => __( 'Container ID' ),
                        'sanitize_callback' => 'sanitize_text_field',
                        'show_in_rest'      => false,
                    ), 'paypal_marketing_solutions_container_id' => array(
                        'type'              => 'string',
                        'group'             => 'paypal_marketing_solutions',
                        'description'       => __( 'Container ID' ),
                        'sanitize_callback' => 'sanitize_text_field',
                        'show_in_rest'      => false,
                    )
                )
            );
        }

        /**
         * Starting from 4.7.0 WordPress register_settings function accepts array of data.
         * Before that, only sanitize function callback
         *
         * @param  string  $groupName   Option's group name
         * @param  string  $optionName  Option's name
         * @param  array   $extraData   Option's extra data
         */
        protected function _register_setting( $groupName, $optionName, $extraData )
        {
            global $wp_version;

            if ( version_compare( $wp_version, '4.7.0', '>=' ) ) {
                register_setting( $groupName, $optionName, $extraData );
            } else {
                register_setting( $groupName, $optionName, $extraData['sanitize_callback'] );
            }
        }
    }

    new Paypal_Marketing_Solutions_Admin();
}
