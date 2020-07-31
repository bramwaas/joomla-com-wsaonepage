<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<h1><?php echo $this->menutype; ?></h1>
<?php 
foreach ($this->menuItems as $menuitem)
{
	echo "<p>Itemid: {$menuitem->id} title: {$menuitem->title} route: $menuitem->route link $menuitem->link</p>";
}
?>