<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2021 -2023 A.H.C. Waasdorp. All rights reserved.
 * @license     GNU General Public License version 3; see LICENSE
 */

namespace WaasdorpSoekhan\Component\Wsaonepage\Site\View\Wsaonepage;

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;


/**
 * HTML View class for the Wsaonepage Component
 *
 * @since  0.0.1
 */
class HtmlView extends BaseHtmlView
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
    /*
     * array of Joomla\CMS\MVC\Factory\MVCFactory factories for different components (eg namespaces)
     * @var    Joomla\CMS\MVC\Factory\MVCFactory[]
     */
    protected $mifactories = array();
 
    /**
     * Display the wsaonepage view
     *
     * @param   string  $template  The name of the layout file to parse.
     * @return  void
     */
    public function display($template = null) {
        // Assign data to the view
        $app=Factory::getApplication();
        $this->user = $app->getIdentity();
        $this->item  = $this->get('Item');
        //	    $this->print = $app->input->getBool('print');
        $this->state = $this->get('State');
        $this->menuItems = $this->get('Menuitems');
        $this->modules = $this->get('Modulelist');
        
       // Check for errors.
        if (count($errors = $this->get('Errors')))
        {
            throw new GenericDataException(500, implode('<br />', $errors));
            
            return false;
        }
        
        // Call the parent display to display the layout file
        parent::display($template);
    }

}