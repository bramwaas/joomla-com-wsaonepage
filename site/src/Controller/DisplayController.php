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
}