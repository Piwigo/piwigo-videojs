<?php
/***********************************************
* File      :   admin_tech.php
* Project   :   piwigo-videojs
* Descr     :   Generate the admin tech panel
*
* Created   :   4.06.2013
*
* Copyright 2012-2018 <xbgmsharp@gmail.com>
*
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
************************************************/

// Check whether we are indeed included by Piwigo.
if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

// categories
$query = 'SELECT id,name,uppercats,global_rank FROM '.CATEGORIES_TABLE.';';
display_select_cat_wrapper($query, array(), 'category_parent_options');


?>
