<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2020 - 2021 AHC Waasdorp. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 *  Modifications:
 * 20200803: first use of MenuItems to display components in component area. Copied from  menuoverride wsaonepagebs4.php in template wsaonepage (working theeir only correct in a content component here also not working correct yet.
 * 20200810: works als with com_content after adding addIncludePath for helpers
 * 20200810 create bookmark from route in accordance with template wsaonepage mod_menu wsaonepagebs4_component, removed unnecessary divs
 * 20200812 create bookmark before processing alias
 * 20200816 restore documentdata like title
 * 20200817 restore pathway and (maybe temporary) defaylts for open graph front end ready for the time being so a new version 0.1
 * 20210805 first adaptations for joomla 4.0
 */
// namespace WaasdorpSoekhan\Component\Wsaonepage\Site\View\Wsaonepage;
// part of WaasdorpSoekhan\Component\Wsaonepage\Site\View\Wsaonepage\HtmlView

// No direct access to this file
\defined('_JEXEC') or die('Restricted access');
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
use Joomla\CMS\Table\Table;
use Joomla\CMS\Uri\Uri;
/*
 * secure variables of app page and page component
 */
$app = Factory::getApplication();
$document = $app->getDocument();
$renderer = $document->loadRenderer('module');
$sitename = $app->get('sitename'); 
$input = $app->input;
$wsaOrgAppParams = clone $app->getParams();
$wsaOrgInput = clone $input;
$wsaOrgActiveMenuItem = $app->getMenu()->getActive();
$wsaOrgDocumentViewType = $document->getType(); // = html is always ok
$wsaSiteRouter = $app->getRouter('site');
$wsaOrgRouterVars = $wsaSiteRouter->getVars();
$wsaIsAlias = FALSE;
$wsaAliasBookmark = NULL;
$params  = $this->item->params;
echo '<!-- Start default.php  <![CDATA[';
//           print_r($document);
echo ' ]]> -->', PHP_EOL;

if ($controller = $this->get('wsacontroller')) {
//if ($controller = BaseController::getInstance(substr($wsaOrgActiveMenuItem->query['option'], 4))) {
    $wsaOrgControllerVars = $controller->getProperties(FALSE);
    $wsaOrgDocumentVars['title'] = $document->getTitle();
    $wsaOrgDocumentVars['description'] = $document->getDescription();
    $wsaOrgDocumentMetaName['title'] = $document->getMetaData('title') ?: $wsaOrgDocumentVars['title'] ;
    $wsaOrgDocumentMetaName['keywords'] = $document->getMetaData('keywords');
    $wsaOrgPathway = $app->getPathway()->getPathway();
    $pathway = $app->getPathway();
    $wsaOrgPathway = $pathway->getPathway();
    
/*
 * Title for this component
 */    
if ($params->get('show_title') || $params->get('show_author')) : ?>
	<div class="page-header">
		<?php if ($params->get('show_title')) : ?>
			<h2 itemprop="headline">
				<?php echo $this->escape($this->item->title); ?>
			</h2>
		<?php endif; ?>
		<?php if ($this->item->state == 0) : ?>
			<span class="label label-warning"><?php echo Text::_('JUNPUBLISHED'); ?></span>
		<?php endif; ?>
		<?php if (strtotime($this->item->publish_up) > strtotime(Factory::getDate())) : ?>
			<span class="label label-warning"><?php echo Text::_('JNOTPUBLISHEDYET'); ?></span>
		<?php endif; ?>
		<?php if ((strtotime($this->item->publish_down) < strtotime(Factory::getDate())) && $this->item->publish_down != Factory::getDbo()->getNullDate()) : ?>
			<span class="label label-warning"><?php echo Text::_('JEXPIRED'); ?></span>
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

foreach ($this->menuItems as $i => &$mItm) { // note pointer used, so that changes in $mItm like adding bookmark are available in modules
        try {
            // TODO juiste selectie voor menuitems
            if (stripos($mItm->note, '#op#') !== false) { // new code for one page when #op# is in $mItm-note
                //  create bookmark from route before processing alias in accordance with template wsaonepage mod_menu wsaonepagebs4_component
                $mItm->bookmark = ($mItm->route == '/') ? 'home' : ltrim(str_ireplace(array('/', '\\', '.html'), array('-', '-', ''), $mItm->route), '-#') ;
                if ($mItm->type === 'alias')
                {
                    $wsaIsAlias = TRUE;
                    $tmp =$mItm->bookmark;
                    $aliasToId = $mItm->params->get('aliasoptions');
                    $mItm = $app->getMenu()->getItem($aliasToId);
                    $wsaAliasBookmark = (isset($mItm->bookmark)) ? $mItm->bookmark : NULL;
                    $mItm->bookmark = $tmp; 
                }
                /*
                 * actions for all kind of components (option) / views (view)
                 * start with overwrite app values with values of this menu option.
                 */

                // modified version of componentpath and the like in variables instead of constants
                $wsaOption = preg_replace('/[^A-Z0-9_\.-]/i', '', $mItm->query['option']);
                $wsaComponent = ucfirst(substr($wsaOption, 4));
                $wsaJPATH_COMPONENT = JPATH_BASE . '/components/' . $wsaOption;
                $wsaJPATH_COMPONENT_SITE = JPATH_SITE . '/components/' . $wsaOption;
                $wsaJPATH_COMPONENT_ADMINISTRATOR = JPATH_ADMINISTRATOR . '/components/' . $wsaOption;
                // replace input values by values from menuitem query
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
                // find component params
                $wsaComponentParams = $app->getParams($mItm->query['option']);
                // find menu params and merge with component params (menu params overwrite component params if both are available) and replace app params
                $wsaMenuParams = new Registry($mItm->params);
                $wsaComponentParams->merge($wsaMenuParams);
                $tmp = $app->getParams()->flatten();
                foreach ($tmp as $tmpKey => $tmpVal) {
                    $app->getParams()->remove($tmpKey);
                }
                $app->getParams()->merge($wsaComponentParams);
                echo '<!-- Start with menuid =', $mItm->id, ' option :', $mItm->query['option'], ' <![CDATA[';
                //              print_r(ModuleHelper::getModuleList());
                echo ' ]]> -->', PHP_EOL;
                // add helper file include path for this component. from default article
                if ($mItm->query['option'] == 'com_content') {
                    HTMLHelper::addIncludePath($wsaJPATH_COMPONENT . '/helpers'); 
                }
                if ($mItm->query['option'] == 'com_contact') {
                    // add formpaths relative to variable active component path
                    Form::addFormPath($wsaJPATH_COMPONENT . '/models/forms');
                    Form::addFieldPath($wsaJPATH_COMPONENT . '/models/fields');
                    Form::addFormPath($wsaJPATH_COMPONENT . '/model/form');
                    Form::addFieldPath($wsaJPATH_COMPONENT . '/model/field');
                }
                // from newsfeeds.php
                Table::addIncludePath($wsaJPATH_COMPONENT_ADMINISTRATOR . '/tables');
                // from content.php
                JLoader::register($wsaComponent . 'HelperQuery', $wsaJPATH_COMPONENT . '/helpers/query.php');
                JLoader::register($wsaComponent . 'HelperAssociation', $wsaJPATH_COMPONENT . '/helpers/association.php');
                // ende from content.php
                // from newsfeeds.php
                JLoader::register($wsaComponent . 'HelperRoute', $wsaJPATH_COMPONENT . '/helpers/route.php');
                // load default language file for this component to translate labels of form but maybe also other labes
                Factory::getLanguage()->load($mItm->query['option']);
                // replace wrong settings in Controller
                $controller->set('name', $wsaComponent);
                $controller->set('basePath', $wsaJPATH_COMPONENT);
                $controller->set('paths', array('view' => $wsaJPATH_COMPONENT . '/views/' ));
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
                /*
                 * section header html for each item
                 */
                echo '<section id="', $mItm->bookmark, '" class="row section component " >', PHP_EOL;
                // Find modules for Aside and Adjusting content width according to that
                if (count($this->modules[$mItm->id]['position-7']) && count($this->modules[$mItm->id]['position-8']))
                {
                    $spanc = "col-md-6 " ;
                }
                elseif (!count($this->modules[$mItm->id]['position-7']) && !count($this->modules[$mItm->id]['position-8']))
                
                {
                    $spanc = "";
                }
                else
                {
                    $spanc = "col-md-8 ";
                }
                if (count($this->modules[$mItm->id]['position-8']))
                {
                    echo '<aside class="col-12 col-md">', PHP_EOL;
                    foreach ($this->modules[$mItm->id]['position-8'] as $module)
                    {
                        echo $renderer->render($module, array('style' => 'none'));
                    }
                    echo '</aside>', PHP_EOL;
                }
                echo '<div class="col-12 ', $spanc, '" >', PHP_EOL;
                // end section header html
                $controller->display();
                
                /*
                 * closing html (section) for this menuitem
                 */
                echo '</div>', PHP_EOL;
                if (count($this->modules[$mItm->id]['position-7']))
                {
                    echo '<aside class="col-12 col-md">', PHP_EOL;
                    foreach ($this->modules[$mItm->id]['position-7'] as $module)
                    {
                        echo $renderer->render($module, array('style' => 'none'));
                    }
                    echo '</aside>', PHP_EOL;
                }
                echo '</section>', PHP_EOL;
                // end closing html
                if ($wsaIsAlias)
                {
                    $wsaIsAlias = FALSE;
                    $mItm->bookmark  = (isset($wsaAliasBookmark)) ? $wsaAliasBookmark : NULL;
                }
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
    unset($mItm);
    /*
     * end list of sections.
     */
    // restore $app->params()
    $tmp = $app->getParams()->flatten();
    foreach ($tmp as $tmpKey => $tmpVal) {
        $app->getParams()->remove($tmpKey);
    }
    $app->getParams()->merge($wsaOrgAppParams);
    // restore controller vars
    $controller->setProperties( $wsaOrgControllerVars);
    // restore Document
    $document->setTitle($wsaOrgDocumentVars['title']);
    $document->setDescription($wsaOrgDocumentVars['description']);
    $document->setMetaData('title', $wsaOrgDocumentMetaName['title']);
    $document->setMetaData('keywords', $wsaOrgDocumentMetaName['keywords']);
   // restore active menu
    if ($wsaOrgActiveMenuItem->id > 0) {
        $app->getMenu()->setActive($wsaOrgActiveMenuItem->id);
        echo '<!-- herstelde actief menu id :', $app->getMenu()->getActive()->id, ' -->';
    }
    // restore Router vars
    $wsaSiteRouter->setVars($wsaOrgRouterVars);
    // restore pathway (breadcrumb)
    $pathway->setPathway($wsaOrgPathway);
    // set defaults fore some open graph  meta properties TODO maybe not the best place
    $document->setMetaData('og:url', Uri::base(), 'property');
    $document->setMetaData('og:title', $wsaOrgDocumentVars['title'], 'property');
    $document->setMetaData('og:description', $wsaOrgDocumentVars['description'], 'property'); 
    $document->setMetaData('og:site_name', $sitename, 'property');
    
} else {
    echo '<!-- ' . PHP_EOL;
    echo 'Controller not instanciated:', substr($wsaOrgActiveMenuItem->query['option'], 4), PHP_EOL;
    echo ' -->', PHP_EOL;
}
echo '<!-- einde onepage sections uit menu -->' . PHP_EOL;

?>