<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2021 A.H.C. Waasdorp. All rights reserved.
 * @license     GNU General Public License version 3; see LICENSE
 * 16-8-2021
 */

namespace WaasdorpSoekhan\Component\Wsaonepage\Administrator\View\Wsaonepage;

\defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
//use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\GenericDataException; 
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;
use WaasdorpSoekhan\Component\Wsaonepage\Administrator\Model\WsaonepageModel;


/**
 * Main "Wsaonepage" Admin View
 */
class HtmlView extends BaseHtmlView
{
    /**
     * View form
     *
     * @var         Form
     */
    protected $form = null;
    /**
     * The active item
     *
     * @var    object
     * @since  0.6.1
     */
    protected $item;
    
    /**
     * The model state
     *
     * @var    object
     * @since  0.6.1
     */
    protected $state;
    
    /**
     * Display the main "Wsaonepage" view
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
	 *
	 * @throws  \Exception

     */
    public function display($tpl = null)
    {
        /** @var WsaonepageModel $model added after banner j.4*/
        $model       = $this->getModel();
        // Get the Data
        $this->form = $this->get('Form');
        $this->item = $this->get('Item');
        $this->state = $model->getState(); //added after banner j.4
        
        
        // Check for errors.
        if (count($errors = $this->get('Errors')))
        {
            throw new GenericDataException(500, implode('<br />', $errors));
            
            return false;
        }
        
        
        // Set the toolbar
        $this->addToolBar();
        
        // Display the template
        parent::display($tpl);
        
        // Set the document
        $this->setDocument(); //TODO is this necessary not found in any example banners etc.
    }
    
    /**
     * Add the page title and toolbar.
     *
     * @return  void
     *
     * @since   1.6
	 * @throws  \Exception
     */
    protected function addToolBar()
    {
        // Hide Joomla Administrator Main menu
        Factory::getApplication()->input->set('hidemainmenu', true);
        
//        $user       = Factory::getUser();
//        $userId     = $user->id;
        $isNew = ($this->item->id == 0);
//        $checkedOut = !(is_null($this->item->checked_out) || $this->item->checked_out == $userId);
        $checkedOut = FALSE;

        // Built the actions for new and existing records.
//        $canDo = $this->canDo; TODO from article
        
//        $toolbar = Toolbar::getInstance(); TODO from article
        
        
        ToolbarHelper::title($isNew ? Text::_('COM_WSAONEPAGE_MANAGER_WSAONEPAGE_NEW') : Text::_('COM_WSAONEPAGE_MANAGER_WSAONEPAGE_EDIT'), 'wsaonepage');

        // Build the actions for new and existing records. // TODO  from contact but validations are skipped for the start.
        if ($isNew)
        {
            // For new records, check the create permission.
//            if (count($user->getAuthorisedCategories('com_contact', 'core.create')) > 0)
//            {
                ToolbarHelper::apply('wsaonepage.apply');
                
                ToolbarHelper::saveGroup(
                    [
                        ['save', 'wsaonepage.save'],
                        ['save2new', 'wsaonepage.save2new']
                    ],
                    'btn-success'
                    );
//            }
            
            ToolbarHelper::cancel('wsaonepage.cancel');
            if (ComponentHelper::isEnabled('com_contenthistory') && $this->state->params->get('save_history', 0)
                //&& $canDo->get('core.edit')
                )
            {
                ToolbarHelper::versions('com_wsaonepage.wsaonepage', $this->item->id);
            }
            
        }
        else //(!$isNew)
        {
            // Since it's an existing record, check the edit permission, or fall back to edit own if the owner.
//            $itemEditable = $canDo->get('core.edit') || ($canDo->get('core.edit.own') && $this->item->created_by == $userId);
            $itemEditable = TRUE;
            
            $toolbarButtons = [];
            
            // Can't save the record if it's checked out and editable
            if (!$checkedOut && $itemEditable)
            {
                ToolbarHelper::apply('wsaonepage.apply');
                
                $toolbarButtons[] = ['save', 'wsaonepage.save'];
                
                // We can save this record, but check the create permission to see if we can return to make a new one.
//                if ($canDo->get('core.create'))
//                {
                    $toolbarButtons[] = ['save2new', 'wsaonepage.save2new'];
//                }
            }
            
            // If checked out, we can still save
//            if ($canDo->get('core.create'))
//            {
                $toolbarButtons[] = ['save2copy', 'wsaonepage.save2copy'];
//            }
            
            ToolbarHelper::saveGroup(
                $toolbarButtons,
                'btn-success'
                );
            
            ToolbarHelper::cancel('wsaonepage.cancel', 'JTOOLBAR_CLOSE');
            
        }
        
   }
    /**
     * Method to set up the document properties
     *
     * @return void
     */
    protected function setDocument()
    {
        $isNew = ($this->item->id < 1);
        $document = Factory::getDocument();
        $document->setTitle($isNew ? Text::_('COM_WSAONEPAGE_WSAONEPAGE_CREATING') :
            Text::_('COM_WSAONEPAGE_WSAONEPAGE_EDITING'));
    }
    

}