<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2021 A.H.C. Waasdorp. All rights reserved.
 * @license     GNU General Public License version 3; see LICENSE
 */
namespace WaasdorpSoekhan\Component\Wsaonepage\Site\Controller;

\defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Factory;


/**
 * Wsaonepage Component Controller
 * @since  0.5.0
 */
class DisplayController extends BaseController {
    
    public function display($cachable = false, $urlparams = array()) {        
        $document = Factory::getDocument();
        $viewName = $this->input->getCmd('view', 'login');
        $viewFormat = $document->getType();
        
        $view = $this->getView($viewName, $viewFormat);
        $view->setModel($this->getModel('Wsaonepage'), true);
        
        $view->document = $document;
        $view->set('wsacontroller', $this);
        $view->display();
    }
    /**
     * Returns an associative array of object properties.
     *
     * @param   boolean  $public  If true, returns only the public properties.
     *
     * @return  array
     *
     * @since   1.7.0
     *
     * see     Joomla\CMS\Object\CMSObject::get()
     */
    public function getProperties($public = true)
    {
        $vars = get_object_vars($this);
        
        if ($public)
        {
            foreach ($vars as $key => $value)
            {
                if ('_' == substr($key, 0, 1))
                {
                    unset($vars[$key]);
                }
            }
        }
        
        return $vars;
    }
    
    /**
     * Set the object properties based on a named array/hash.
     *
     * @param   mixed  $properties  Either an associative array or another object.
     *
     * @return  boolean
     *
     * @since   0.8.1
     *
     * see     CMSObject->setProperties
     */
    public function setProperties($properties)
    {
        if (\is_array($properties) || \is_object($properties))
        {
            foreach ((array) $properties as $k => $v)
            {
                
                $this->$k = $v;
            }
            
            return true;
        }
        
        return false;
    }
    
    
}