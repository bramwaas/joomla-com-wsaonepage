<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2021 A.H.C. Waasdorp. All rights reserved.
 * @license     GNU General Public License version 3; see LICENSE
 */
namespace WaasdorpSoekhan\Component\Wsaonepage\Site\Factory;

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Factory\MVCFactory;


/**
 * Wsaonepage Factory
 * Factory to create MVC objects based on a variable namespace.
 * @since  0.8.3
 */
class OPFactory extends MVCFactory {
    /**
     * The namespace must be like:
     * Joomla\Component\Content
     *
     * @param   string  $namespace  The namespace
     *
     * @since   0.8.3
     */
    
    
    public function setNamespace($namespace) {        
        $this->namespace = $namespace;
    }
   
}