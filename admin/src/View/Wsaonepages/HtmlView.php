<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2021 A.H.C. Waasdorp. All rights reserved.
 * @license     GNU General Public License version 3; see LICENSE
 */
namespace WaasdorpSoekhan\Component\Wsaonepage\Administrator\View\Wsaonepages;

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Toolbar\ToolbarHelper;



/**
 * Main "Wsaonepages" Admin View
 */
class HtmlView extends BaseHtmlView {
 
    /**
     * Is this view an Empty State
     *
     * @var  boolean
     * @since 4.0.0
     */
    private $isEmptyState = false;
    
    /**
     * Display the Wsaonepage view
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     */
    function display($tpl = null)
    {
        
        // Get data from the model
        $this->items		= $this->get('Items');
        $this->pagination	= $this->get('Pagination');
        $this->state			= $this->get('State');
        //		$this->filter_order 	= $app->getUserStateFromRequest($context.'filter_order', 'filter_order', 'greeting', 'cmd'); // TODO find out correct use
        //		$this->filter_order_Dir = $app->getUserStateFromRequest($context.'filter_order_Dir', 'filter_order_Dir', 'asc', 'cmd');
        $this->filterForm    	= $this->get('FilterForm');
        $this->activeFilters 	= $this->get('ActiveFilters');

        if (!\count($this->items) && $this->isEmptyState = $this->get('IsEmptyState'))
        {
            $this->setLayout('emptystate');
        }
        
        // Check for errors.
        if (\count($errors = $this->get('Errors')))
        {
            throw new GenericDataException(implode("\n", $errors), 500);
        }
        
        
        // Set the toolbar and number of found items
        $this->addToolBar();
        
        // Display the template
        parent::display($tpl);
        
        // TODO Set the document removed for J4 but in examples also not avail in J3
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
        $input = Factory::getApplication()->input;
        // TODO	    $canDo = JHelperContent::getActions('com_content', 'category', $this->state->get('filter.category_id'));
        
        // Hide Joomla Administrator Main menu TODO seems not a good idea because there is no other option to close this screen
        //	    $input->set('hidemainmenu', true);
        
        $isNew = ($this->item->id == 0);

        // Get the toolbar object instance
        $toolbar = Toolbar::getInstance('toolbar');
        ToolbarHelper::title(Text::_('COM_WSAONEPAGE_MANAGER_WSAONEPAGES'), 'wsaonepage');
        $toolbar->addNew('wsaonepage.add');
        $toolbar->edit('wsaonepage.edit');
        $toolbar->delete('wsaonepages.trash')
        ->text('JTOOLBAR_TRASH') // JTRASH JACTION_DELETE
        ->listCheck(true);
        $toolbar->delete('wsaonepages.delete')
        ->text('JTOOLBAR_EMPTY_TRASH') // JTRASH JACTION_DELETE
        ->message('JGLOBAL_CONFIRM_DELETE')
        ->listCheck(true);
        $toolbar->preferences('com_wsaonepage');
        
        
 
         /* TODo werkt nog niet $cando
         if (!$this->isEmptyState && ($canDo->get('core.edit.state') || ($this->state->get('filter.published') == -2 && $canDo->get('core.delete'))))
         {
        $dropdown = $toolbar->dropdownButton('status-group')
        ->text('JTOOLBAR_CHANGE_STATUS')
        ->toggleSplit(false)
        ->icon('icon-ellipsis-h')
        ->buttonClass('btn btn-action')
        ->listCheck(true);
        
        $childBar = $dropdown->getChildToolbar();

         
			if ($canDo->get('core.edit.state'))
			{
				if ($this->state->get('filter.published') != 2)
				{
					$childBar->publish('banners.publish')->listCheck(true);

					$childBar->unpublish('banners.unpublish')->listCheck(true);
				}

				if ($this->state->get('filter.published') != -1)
				{
					if ($this->state->get('filter.published') != 2)
					{
						$childBar->archive('banners.archive')->listCheck(true);
					}
					elseif ($this->state->get('filter.published') == 2)
					{
						$childBar->publish('publish')->task('banners.publish')->listCheck(true);
					}
				}

				$childBar->checkin('banners.checkin')->listCheck(true);

				if ($this->state->get('filter.published') != -2)
				{
					$childBar->trash('banners.trash')->listCheck(true);
				}
			}
         }
         */
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
            'a.ordering'     => Text::_('JGRID_HEADING_ORDERING'),
            //	        'a.state'        => JText::_('JSTATUS'),
            'a.title'        => Text::_('JGLOBAL_TITLE'),
            //	        'category_title' => JText::_('JCATEGORY'),
            //	        'access_level'   => JText::_('JGRID_HEADING_ACCESS'),
            //	        'a.created_by'   => JText::_('JAUTHOR'),
            'language'       => Text::_('JGRID_HEADING_LANGUAGE'),
            //	        'a.created'      => JText::_('JDATE'),
            'a.id'           => Text::_('JGRID_HEADING_ID'),
            //	        'a.featured'     => JText::_('JFEATURED')
        );
    }protected function setDocument()
    {
        $document = Factory::getDocument();
        $document->setTitle(Text::_('COM_WSAONEPAGE_ADMINISTRATION'));
    }
    

}