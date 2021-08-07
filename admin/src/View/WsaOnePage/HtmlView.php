<?php

namespace WaasdorpSoekhan\Component\WsaOnePage\Administrator\View\WsaOnePage;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;

/**
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2021 A.H.C. Waasdorp. All rights reserved.
 * @license     GNU General Public License version 3; see LICENSE
 */

/**
 * Main "WsaOnePage" Admin View
 */
class HtmlView extends BaseHtmlView {
    
 
    /**
     * View form
     *
     * @var         form
     */
    protected $form = null;
    
    /**
     * Display the main "WsaOnePage" view
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     */
    public function display($tpl = null)
    {
        // Get the Data
        $this->form = $this->get('Form');
        $this->item = $this->get('Item');
        
        // Check for errors.
        if (count($errors = $this->get('Errors')))
        {
            JError::raiseError(500, implode('<br />', $errors));
            
            return false;
        }
        
        
        // Set the toolbar
        $this->addToolBar();
        
        // Display the template
        parent::display($tpl);
        
        // Set the document
        $this->setDocument();
    }
    
    /**
     * Add the page title and toolbar.
     *
     * @return  void
     *
     * @since   1.6
     */
    protected function addToolBar()
    {
        $input = JFactory::getApplication()->input;
        
        // Hide Joomla Administrator Main menu
        $input->set('hidemainmenu', true);
        
        $isNew = ($this->item->id == 0);
        
        if ($isNew)
        {
            $title = JText::_('COM_WSAONEPAGE_MANAGER_WSAONEPAGE_NEW');
        }
        else
        {
            $title = JText::_('COM_WSAONEPAGE_MANAGER_WSAONEPAGE_EDIT');
        }
        
        JToolbarHelper::title($title, 'wsaonepage');
        JToolbarHelper::save('wsaonepage.save');
        JToolbarHelper::cancel(
            'wsaonepage.cancel',
            $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE'
            );
    }
    /**
     * Method to set up the document properties
     *
     * @return void
     */
    protected function setDocument()
    {
        $isNew = ($this->item->id < 1);
        $document = JFactory::getDocument();
        $document->setTitle($isNew ? JText::_('COM_WSAONEPAGE_WSAONEPAGE_CREATING') :
            JText::_('COM_WSAONEPAGE_WSAONEPAGE_EDITING'));
    }
    

}