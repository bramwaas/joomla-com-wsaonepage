<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2005 - 2021 A.H.C. Waasdorp. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * 8-8-2021
 */
namespace WaasdorpSoekhan\Component\Wsaonepage\Administrator\Model;
// No direct access to this file
\defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\Table\Table;
use Joomla\Registry\Registry;

/**
 * Wsaonepage Model
 *
 * @since  0.0.1
 */
class WsaonepageModel extends AdminModel
{
    /**
     * Name of the form
     *
     * @var string
     * @since  4.0.0
     */
    protected $formName = 'wsaonepage';
    /**
     * The type alias for this content type.
     *
     * @var    string
     * @since  0.9.3 (joomla 3.2)
     */
    public $typeAlias = 'com_wsaonepage.wsaonepage';
    
    /**
     * Method to get a table object, load it if necessary.
     *
     * @param   string  $name    The table name. Optional.
     * @param   string  $prefix  The class prefix. Optional.
     * @param   array   $config  Configuration array for model. Optional.
     *
     * @return  Table  A Table object
     * TODO probably unnecessary
     * @since   1.6
     */
    /*
    public function getTable($name = 'Wsaonepage', $prefix = 'Administrator', $config = array())
    {
        return $this->_createTable($name, $prefix, $config);
       
    }
    */
    
    /**
     * Method to get the record form.
     *
     * @param   array    $data      Data for the form.
     * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
     *
     * @return  mixed    A JForm object on success, false on failure
     *
     * @since   1.6
     */
    public function getForm($data = array(), $loadData = true)
    {
        // Get the form.
        $form = $this->loadForm(
            'com_wsaonepage.wsaonepage',
            'wsaonepage',
            array(
                'control' => 'jform',
                'load_data' => $loadData
            )
            );
        
        if (empty($form))
        {
            return false;
        }
        // Determine correct permissions to check.
        if ($this->getState('wsaonepage.id'))
        {
            // Existing record. Can only edit in selected categories.
            $form->setFieldAttribute('catid', 'action', 'core.edit');
        }
        else
        {
            // New record. Can only create in selected categories.
            $form->setFieldAttribute('catid', 'action', 'core.create');
        }
        
        // Modify the form based on access controls.
        if (!$this->canEditState((object) $data))
        {
            // Disable fields for display.
            $form->setFieldAttribute('ordering', 'disabled', 'true');
            $form->setFieldAttribute('publish_up', 'disabled', 'true');
            $form->setFieldAttribute('publish_down', 'disabled', 'true');
            $form->setFieldAttribute('published', 'disabled', 'true');
            $form->setFieldAttribute('sticky', 'disabled', 'true');
            
            // Disable fields while saving.
            // The controller has already verified this is a record you can edit.
            $form->setFieldAttribute('ordering', 'filter', 'unset');
            $form->setFieldAttribute('publish_up', 'filter', 'unset');
            $form->setFieldAttribute('publish_down', 'filter', 'unset');
            $form->setFieldAttribute('published', 'filter', 'unset');
            $form->setFieldAttribute('sticky', 'filter', 'unset');
        }
        
        
        
        return $form;
    }
    
    /**
     * Method to get the data that should be injected in the form.
     *
     * @return  mixed  The data for the form.
     *
     * @since   1.6
     */
    protected function loadFormData()
    {
        // Check the session for previously entered form data.
        $data = Factory::getApplication()->getUserState(
            'com_wsaonepage.edit.wsaonepage.data',
            array()
            );
        
        if (empty($data))
        {
            $data = $this->getItem();
            
        }
        // If there are params fieldsets in the form it will fail with a registry object
        if (isset($data->params) && $data->params instanceof Registry)
        {
            $data->params = $data->params->toArray();
        }
        return $data;
    }
}