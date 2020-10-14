<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * WsaOnePages View
 *
 * @since  0.0.1
 */
class WsaOnePageViewWsaOnePages extends JViewLegacy
{
    /**
     * Display the WsaOnePage view
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     */
    function display($tpl = null)
    {
        
        // Get application
        $app = JFactory::getApplication();
        $context = "wsaonepage.list.admin.wsaonepage";
        
        // Get data from the model
        $this->items		= $this->get('Items');
        $this->pagination	= $this->get('Pagination');
        $this->state			= $this->get('State');
        //		$this->filter_order 	= $app->getUserStateFromRequest($context.'filter_order', 'filter_order', 'greeting', 'cmd'); // TODO find out correct use
        //		$this->filter_order_Dir = $app->getUserStateFromRequest($context.'filter_order_Dir', 'filter_order_Dir', 'asc', 'cmd');
        $this->filterForm    	= $this->get('FilterForm');
        $this->activeFilters 	= $this->get('ActiveFilters');
        
        
        // Check for errors.
        if (count($errors = $this->get('Errors')))
        {
            JError::raiseError(500, implode('<br />', $errors));
            
            return false;
        }
        // Set the toolbar and number of found items
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
        // TODO	    $canDo = JHelperContent::getActions('com_content', 'category', $this->state->get('filter.category_id'));
        
        // Hide Joomla Administrator Main menu TODO seems not a good idea because there is no other option to close this screen
        //	    $input->set('hidemainmenu', true);
        
        $isNew = ($this->item->id == 0);
        $title = JText::_('COM_WSAONEPAGE_MANAGER_WSAONEPAGES');
        
        if ($this->pagination->total)
        {
            $title .= "<span style='font-size: 0.5em; vertical-align: middle;'>(" . $this->pagination->total . ")</span>";
        }
        
        JToolBarHelper::title($title, 'wsaonepage');
        JToolBarHelper::addNew('wsaonepage.add');
        JToolBarHelper::editList('wsaonepage.edit');
        /* TODo werkt nog niet $cando
         if ($canDo->get('core.edit.state'))
         {
         JToolbarHelper::publish('wsaonepage.publish', 'JTOOLBAR_PUBLISH', true);
         JToolbarHelper::unpublish('wsaonepage.unpublish', 'JTOOLBAR_UNPUBLISH', true);
         }
         */
        JToolBarHelper::deleteList('', 'wsaonepages.delete');
        JToolBarHelper::preferences('com_wsaonepages');
        //	    JToolbarHelper::back( 'JTOOLBAR_CLOSE',  'javascript:history.back();');
        
    }
    /**
     * Method to set up the document properties
     *
     * @return void
     */
    /**
     * Returns an array of fields the table can be sorted by
     *
     * @return  array  Array containing the field name to sort by as the key and display text as value
     *
     * @since   3.0
     */
    protected function getSortFields()
    {
        return array(
            'a.ordering'     => JText::_('JGRID_HEADING_ORDERING'),
            //	        'a.state'        => JText::_('JSTATUS'),
            'a.title'        => JText::_('JGLOBAL_TITLE'),
            //	        'category_title' => JText::_('JCATEGORY'),
        //	        'access_level'   => JText::_('JGRID_HEADING_ACCESS'),
        //	        'a.created_by'   => JText::_('JAUTHOR'),
            'language'       => JText::_('JGRID_HEADING_LANGUAGE'),
            //	        'a.created'      => JText::_('JDATE'),
            'a.id'           => JText::_('JGRID_HEADING_ID'),
            //	        'a.featured'     => JText::_('JFEATURED')
        );
    }protected function setDocument()
    {
        $document = JFactory::getDocument();
        $document->setTitle(JText::_('COM_WSAONEPAGE_ADMINISTRATION'));
    }
    
    
}