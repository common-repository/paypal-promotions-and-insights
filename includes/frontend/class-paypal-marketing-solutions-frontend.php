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

if ( ! class_exists( 'Paypal_Marketing_Solutions_Frontend' ) ) {

    /**
     * Class which handles frontend output
     */
    class Paypal_Marketing_Solutions_Frontend
    {

        /**
         * Service environment 'sandbox'.
         * Considered as a default environment
         */
        const MODE_SANDBOX    = 0;

        /**
         * Service environment 'production'
         */
        const MODE_PRODUCTION = 1;

        /**
         * PayPal master js src
         */
        const PAYPAL_MASTER_JS_SRC = 'https://www.paypal.com/tagmanager/pptm.js';

        /**
         * Paypal_Marketing_Solutions_Frontend constructor
         */
        public function __construct()
        {
            add_action( 'wp_head', array( &$this, 'wp_head_callback' ) );
        }

        /**
         * WordPress wp_head action callback.
         * Used to add service's Javascript into the frontend pages
         */
        public function wp_head_callback()
        {
            $containerId = esc_attr( get_option( 'paypal_marketing_solutions_container_id' ) );
            if ($containerId) {
                $scriptSrc = $this->_get_script_src_url();
                $script = <<<EOD
<script>;(function(a,t,o,m,s){a[m]=a[m]||[];a[m].push({t:new Date().getTime(),event:'snippetRun'});var f=t.getElementsByTagName(o)[0],e=t.createElement(o),d=m!=='paypalDDL'?'&m='+m:'';e.async=!0;e.src='$scriptSrc?id='+s+d;f.parentNode.insertBefore(e,f);})(window,document,'script','paypalDDL','$containerId');</script>
EOD;
                echo $script;
            }
        }

        /**
         * Get script source url
         *
         * @return string
         */
        protected function _get_script_src_url()
        {
            return self::PAYPAL_MASTER_JS_SRC;
        }
    }

    new Paypal_Marketing_Solutions_Frontend();
}
