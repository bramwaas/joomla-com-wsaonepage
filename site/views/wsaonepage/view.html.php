<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2020 - 2020 AHC Waasdorp. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * 20200810
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
     * array of counts of modules on a position
     */
    protected $countModules = array();
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
	    
	    $this->menutype = $item->menutype;
	    // Get the menuitems
	    $sitemenu = $app->getMenu();
	    $menuItems = $sitemenu->getItems(array('menutype', 'language'),array($item->menutype, array('*', $item->language)) );
	    $this->menuItems = $menuItems;
	   
	    $this->modules = $this->get('Modulelist', array_column($menuItems, 'id') );
	    echo '<!-- view.html.php this->modules:', PHP_EOL;
	    print_r( $this->modules);
	    echo '--> ', PHP_EOL;
	    
	    // Check for errors.
	    if (count($errors = $this->get('Errors')))
	    {
	        JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');
	        
	        return false;
	    }
	    
		// Display the view
		parent::display($tpl);
	}
	/**
	 * Loads counts and renders the modules on a position
	 *
	 * @param   string  $position  The position assigned to the module
	 * @param   string  $style     The style assigned to the module
	 *
	 * @return  mixed
	 *
	 * copied from plugins\content\loadmodule
	 */
	function wsaLoadModules($position, $style = 'none')
	{
	    
	    $this->modules[$position] = '';
	    $document = Factory::getDocument();
	    $renderer = $document->loadRenderer('module');
	    $wsaModules  = ModuleHelper::getModules($position);
	    $this->countModules[$position] = count($wsaModules);
	    $params   = array('style' => $style);
	    ob_start();
	    
	    foreach ($wsaModules as $module)
	    {
	        echo $renderer->render($module, $params);
	    }
	    
	    $this->modules[$position] = ob_get_clean();
	    
	    return $this->modules[$position];
	    
	}
	
}