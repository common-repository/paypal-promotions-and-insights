<?php
/*
 * Plugin Name:       PayPal Marketing Solutions
 * Plugin URI:        TODO: WIP
 * Description:       PayPal Marketing Solutions Service Integration
 * Version:           1.2
 * Author:            iTechArt-Group
 * Author URI:        https://www.itechart.com/
 * Text Domain:       TODO: WIP
 * License:           GPL2
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 *
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

// If this file is called directly, abort.
if ( ! defined( 'WPINC') ) {
    die;
}

define( 'PAYPAL_MARKETING_SOLUTIONS__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PAYPAL_MARKETING_SOLUTIONS__PLUGIN', __FILE__ );

if ( is_admin() ) {
    require_once( PAYPAL_MARKETING_SOLUTIONS__PLUGIN_DIR . 'includes' . DIRECTORY_SEPARATOR . 'admin' .DIRECTORY_SEPARATOR .  'class-paypal-marketing-solutions-admin.php' );
} else {
    require_once( PAYPAL_MARKETING_SOLUTIONS__PLUGIN_DIR . 'includes' . DIRECTORY_SEPARATOR . 'frontend' .DIRECTORY_SEPARATOR .  'class-paypal-marketing-solutions-frontend.php' );
}
