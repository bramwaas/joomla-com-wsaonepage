<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace WaasdorpSoekhan\Component\Wsaonepage\Administrator\Controller;
// No direct access to this file
\defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\Versioning\VersionableControllerTrait;


/**
 * Wsaonepage Controller
 *
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 * @since       0.5.7
 */
class WsaonepageController extends FormController
{
    use VersionableControllerTrait;
    /**
     * Method to check if you can add a new record.
     *
     * @param   array  $data  An array of input data.
     *
     * @return  boolean
     *
     * @since   3.1
     */
    protected function allowAdd($data = array())
    {
        return $this->app->getIdentity()->authorise('core.create', 'com_wsaonepage');
    }
    
    /**
     * Method to check if you can edit a record.
     *
     * @param   array   $data  An array of input data.
     * @param   string  $key   The name of the key for the primary key.
     *
     * @return  boolean
     *
     * @since   3.1
     */
    protected function allowEdit($data = array(), $key = 'id')
    {
        // Since there is no asset tracking and no categories, revert to the component permissions.
        return parent::allowEdit($data, $key);
    }
    
}