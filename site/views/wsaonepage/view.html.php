<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2020 - 2020 AHC Waasdorp. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * 20200802
 */

use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;


// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * HTML View class for the HelloWorld Component
 *
 * @since  0.0.1
 */
class WsaOnePageViewWsaOnePage extends HtmlView
{
    /*
     * this wsaonepage item
     */
    protected $item;
    /*
     * the array of menuitems to display
     */
    protected $menuItems;
    /*
     * the array of modules on a position to display
     */
    protected $modules = array();
    /*
     * array of params
     */
    protected $params;
    
    protected $print;
    /*
     * state object
     */
    protected $state;
    /*
     * current user
     */
    protected $user;
    
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
	    $app=Factory::getApplication();
	    $user       = Factory::getUser();
        $item  = $this->get('Item');
	    $this->item  = $item;
//	    $this->print = $app->input->getBool('print');
	    $this->state = $this->get('State');
	    $this->user  = $user;
	    $this->menuItems = $this->get('Menuitems');
	    $this->modules = $this->get('Modulelist');
	    
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