<?php
/**
 * Plugin Name: Portfolio Manager - Powered By Behance
 * Text Domain: eds-bpm
 * Domain Path: /translations
 * Plugin URI: http://www.eleopard.in
 * Description: Portfolio Manager helps in reducing the efforts required in project management by picking up the project details from Behance server so that users can manage all their projects at a centralized location in Behance and present them on their websites using beautiful styles and views.
 * Version: 1.6.4
 * Author: eLEOPARD Design Studios
 * Author URI: http://www.eleopard.in
 * License: GNU General Public License version 2 or later; see LICENSE.txt
 *  http://www.gnu.org/copyleft/gpl.html GNU/GPL
    (C) 2014 eLEOPARD Design Studios Pvt Ltd. All rights reserved
   
   	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
	
	or see <http://www.gnu.org/licenses/>.
	* For any other query please contact us at contact[at]eleopard[dot]in
*/

if ( ! defined( 'WPINC' ) ) {
	die;     
}    
        
global $bpm_db_version; 
$bpm_db_version = "1.1";  
  
require_once dirname(__FILE__) . '/classes/eds-bpm-loader.php';

//instantiate the loader
$plugin_init = new EDS_BPM_Loader(__FILE__, null);

$plugin_init->load();