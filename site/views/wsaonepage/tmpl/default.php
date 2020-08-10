<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2020 - 2020 AHC Waasdorp. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 *  Modifications:
 * 20200803: first use of MenuItems to display components in component area. Copied from  menuoverride wsaonepagebs4.php in template wsaonepage (working theeir only correct in a content component here also not working correct yet.
 * 20200810: works als with com_content after adding addIncludePath for helpers
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// TODO alle uses nodig?
use Joomla\CMS\Factory;   // this is the same as use Joomla\CMS\Factory as Factory
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\Registry\Registry; // for new Registry en params object
use Joomla\CMS\MVC\Model\BaseDatabaseModel;  // JModelLegacy
use Joomla\CMS\Form\Form;
use Joomla\CMS\Language\Text;

use Joomla\CMS\Component\ComponentHelper;  //tbv algemene renderComponent
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\HTML\HTMLHelper;

/*
 * secure variables of app page and page component
 */
$app = Factory::getApplication();
$document = Factory::getDocument();
$sitename = $app->get('sitename');  // TODO nodig?
$itemid   = $app->input->getCmd('Itemid', ''); // TODO nodig?
$input = $app->input;
$wsaOrgAppParams = clone $app->getParams();
$wsaOrgInput = clone $input;
$wsaOrgActiveMenuItem = $app->getMenu()->getActive();
$wsaOrgDocumentViewType = $document->getType(); // = html is always ok
$wsaSiteRouter = $app->getRouter('site');
$wsaOrgRouterVars = $wsaSiteRouter->getVars();

if ($controller = BaseController::getInstance(substr($wsaOrgActiveMenuItem->query['option'], 4))) {
    $wsaOrgControllerVars = $controller->getProperties(FALSE);
    // [Itemid] => 299
    // [option] => com_content
    // [view] => article
    // [id] => 143
/*
 * Title for yhis component
 */    
if ($params->get('show_title') || $params->get('show_author')) : ?>
	<div class="page-header">
		<?php if ($params->get('show_title')) : ?>
			<h2 itemprop="headline">
				<?php echo $this->escape($this->item->title); ?>
			</h2>
		<?php endif; ?>
		<?php if ($this->item->state == 0) : ?>
			<span class="label label-warning"><?php echo JText::_('JUNPUBLISHED'); ?></span>
		<?php endif; ?>
		<?php if (strtotime($this->item->publish_up) > strtotime(JFactory::getDate())) : ?>
			<span class="label label-warning"><?php echo JText::_('JNOTPUBLISHEDYET'); ?></span>
		<?php endif; ?>
		<?php if ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != JFactory::getDbo()->getNullDate()) : ?>
			<span class="label label-warning"><?php echo JText::_('JEXPIRED'); ?></span>
		<?php endif; ?>
	</div>
	<?php endif; ?>

<?php 
/*
 * List of sections with a component for each menu-item on this page.
 *
 * By default, joomla only has one component per page, so a component often stores and uses general variables.
 * We sometimes have to override those in the list of menu components,
 * so first secure the variables of the component page and restore them after processing the component list.
 */
echo '<!-- onepage Component Sections from menu -->' . PHP_EOL;
    
    foreach ($this->menuItems as $i => &$mItm) {
        try {
            // TODO juiste selectie voor menuitems
            if (stripos($mItm->note, '#op#') !== false) { // new code for one page when #op# is in $mItm-note
                /*
                 * actions for all kind of components (option) / views (view)
                 * start with overwrite app values with values of this menu option.
                 */
                // aangepaste versie van componentpath ed in variabelen in plaats van constantes.
                $wsaOption = preg_replace('/[^A-Z0-9_\.-]/i', '', $mItm->query['option']);
                $wsaComponent = ucfirst(substr($wsaOption, 4));
                $wsaJPATH_COMPONENT = JPATH_BASE . '/components/' . $wsaOption;
                $wsaJPATH_COMPONENT_SITE = JPATH_SITE . '/components/' . $wsaOption;
                $wsaJPATH_COMPONENT_ADMINISTRATOR = JPATH_ADMINISTRATOR . '/components/' . $wsaOption;
                foreach ($wsaOrgActiveMenuItem->query as $tmpKey => $tmpVal) {
                    $app->input->set($tmpKey, NULL);
                }
                foreach ($mItm->query as $tmpKey => $tmpVal) {
                    $app->input->set($tmpKey, $tmpVal);
                }
                $app->getMenu()->setActive($mItm->id > 0 ? $mItm->id : $wsaOrgActiveMenuItem->id);
                // set Router vars to values of this menuitem
                $wsaSiteRouter->setVars(array(
                    'Itemid' => $mItm->id,
                    'option' => $mItm->query['option']
                ));
                // zoek component params
                $wsaComponentParams = $app->getParams($mItm->query['option']);
                // zoek menuparams en voeg ze samen met componentparams (menu overschrijft component)
                $wsaMenuParams = new Registry($mItm->params);
                $wsaComponentParams->merge($wsaMenuParams);
                // zet samengestelde component menu parameters in app params.
                $tmp = $app->getParams()->flatten();
                foreach ($tmp as $tmpKey => $tmpVal) {
                    $app->getParams()->remove($tmpKey);
                }
                $app->getParams()->merge($wsaComponentParams);
                echo '<!-- Start with menuid $mItm->id=', $mItm->id, ' $app->getMenu()->getActive()->id :', $app->getMenu()->getActive()->id, PHP_EOL;
                // // print_r($mItm);
                echo ' -->', PHP_EOL;
                //
                /*
                 * section header html for each item
                 */
                echo '<section id="', $mItm->bookmark, '" class="container" >', PHP_EOL;
                echo '<div class="container"><div class="row"><div class="col-lg-8 mx-auto">', PHP_EOL;
                // end section header html
                // add helper file include path for this component. from default article
                if ($mItm->query['option'] == 'com_content') {
                    HTMLHelper::addIncludePath($wsaJPATH_COMPONENT . '/helpers'); 
                }
                // from content.php
                JLoader::register($wsaComponent . 'HelperQuery', $wsaJPATH_COMPONENT . '/helpers/query.php');
                JLoader::register($wsaComponent . 'HelperAssociation', $wsaJPATH_COMPONENT . '/helpers/association.php');
                // ende from content.php
                // from newsfeeds.php
                JLoader::register($wsaComponent . 'HelperRoute', $wsaJPATH_COMPONENT . '/helpers/route.php');
                JTable::addIncludePath($wsaJPATH_COMPONENT_ADMINISTRATOR . '/tables');
                // load default language file for this component to translate labels of form but maybe also other labes
                Factory::getLanguage()->load($mItm->query['option']);
                // instantiate controller, propbably that of page component because it will only be instanciated once, but methods are available this way.
//                $controller = BaseController::getInstance($wsaComponent);
                //
                if ($mItm->query['option'] == 'com_contact') {
                    // add formpaths relative to varible active component path
                    Form::addFormPath($wsaJPATH_COMPONENT . '/models/forms');
                    Form::addFieldPath($wsaJPATH_COMPONENT . '/models/fields');
                    Form::addFormPath($wsaJPATH_COMPONENT . '/model/form');
                    Form::addFieldPath($wsaJPATH_COMPONENT . '/model/field');
                }
                // extra om foute instellingen te overschrijven.
                $controller->set('name', $wsaComponent);
                $controller->set('basePath', $wsaJPATH_COMPONENT);
                $controller->set('paths', array(
                    'view' => $wsaJPATH_COMPONENT . '/views/'
                ));
                $controller->set('model_prefix', $wsaComponent . 'Model');
                $controller->addModelPath($wsaJPATH_COMPONENT . '/models', $wsaComponent . 'Model');
                // get the view before display to overwrite the layout value of the previous iteration and the override paths for the lay-out file
                $view = $controller->getView($mItm->query['view'], 'html', $wsaComponent . 'View', array(
                    'base_path' => $wsaJPATH_COMPONENT,
                    'layout' => 'default'
                ));
                $view->setLayout(($mItm->query['layout'] > ' ') ? $mItm->query['layout'] : 'default');
                $view->addTemplatePath(array(
                    $wsaJPATH_COMPONENT . '/views/' . $mItm->query['view'] . '/tmpl/',
                    JPATH_THEMES . '/' . $app->getTemplate() . '/html/' . $wsaOption . '/' . $mItm->query['view']
                ));
                $controller->display();
                
/*
 * closing html (section) for this menuitem
 */
                echo '</div></div></div>', PHP_EOL;
                echo '</section>', PHP_EOL;
                // end closing html
                // restore input
                foreach ($mItm->query as $tmpKey => $tmpVal) {
                    $app->input->set($tmpKey, NULL);
                }
                foreach ($wsaOrgActiveMenuItem->query as $tmpKey => $tmpVal) {
                    $app->input->set($tmpKey, $tmpVal);
                }
            } // end if
        } catch (Exception $e) {
            echo '<!-- ' . PHP_EOL;
            echo 'Caught exception: ', $e->getMessage(), PHP_EOL;
            echo ' -->', PHP_EOL;
            Factory::getApplication()->enqueueMessage(Text::_('Caught exception: ' . $e->getMessage()), 'warning');
        }
    } // end foreach
    /*
     * end list of sections.
     */
    // restore $app->params()
    $tmp = $app->getParams()->flatten();
    foreach ($tmp as $tmpKey => $tmpVal) {
        $app->getParams()->remove($tmpKey);
    }
    $app->getParams()->merge($wsaOrgAppParams);
    // restor controller vars
    $controller->set('basePath', $wsaOrgControllerVars['basePath']);
    $controller->set('paths', $wsaOrgControllerVars['paths']);
    $controller->set('name', $wsaOrgControllerVars['name']);
    $controller->set('model_prefix', $wsaOrgControllerVars['model_prefix']);
    // restore active menu
    if ($wsaOrgActiveMenuItem->id > 0) {
        $app->getMenu()->setActive($wsaOrgActiveMenuItem->id);
        echo '<!-- herstelde actief menu id :', $app->getMenu()->getActive()->id, ' -->';
    }
    // restore Router vars
    $wsaSiteRouter->setVars($wsaOrgRouterVars);
} else {
    echo '<!-- ' . PHP_EOL;
    echo 'Controller not instanciated:', substr($wsaOrgActiveMenuItem->query['option'], 4), PHP_EOL;
    echo ' -->', PHP_EOL;
}
echo '<!-- einde onepage sections uit menu -->' . PHP_EOL;

?>