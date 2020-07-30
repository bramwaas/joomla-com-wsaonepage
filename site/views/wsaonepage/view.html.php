<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2020 - 2020 AHC Waasdorp. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Factory;

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * HTML View class for the HelloWorld Component
 *
 * @since  0.0.1
 */
class WsaOnePageViewWsaOnePage extends HtmlView
{
	/**
	 * Display the One Page view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 */
	function display($tpl = null)
	{
		// Assign data to the view

//	    $this->menutype = $this->get('Menutype');
	    $item=$this->get('Item');
	    $this->menutype = $item->menutype;
	    // Get the menuitems
	    echo '<!-- view.html.php $item:', PHP_EOL;
	    print_r($item);
	    echo PHP_EOL, '-->'; 
	    $app=Factory::getApplication();
	    $sitemenu = $app->getMenu();
//	    $menuItems = $app->getMenu()->getItems(array('menutype', 'language'),array($item->menutype, array('*', $item->language)) );
//	    $menuItems = $app->getMenu()->getItems('menutype',$item->menutype);
	    
	    $menuItems = $sitemenu->getItems('menutype', 'mainmenu');
	    echo '<!-- view.html.php $menuItems:', PHP_EOL;
	    print_r($menuItems);
	    echo PHP_EOL, '-->';
	    
		
	    
	    // Check for errors.
	    if (count($errors = $this->get('Errors')))
	    {
	        JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');
	        
	        return false;
	    }
	    
	    
		// Display the view
		parent::display($tpl);
	}
}