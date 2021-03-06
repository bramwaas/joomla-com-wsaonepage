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
use Joomla\CMS\Factory;
use Joomla\Utilities\ArrayHelper;

JFormHelper::loadFieldClass('list');

/**
 * wsaonepage Form Field class for the WsaOnePage component
 *
 * @since  0.0.1
 */
class JFormFieldWsaOnePage extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var         string
	 */
	protected $type = 'WsaOnePage';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return  array  An array of JHtml options.
	 */
	protected function getOptions()
	{
 		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('id,menutype,title,description');
		$query->from('#__wsaonepage');
		$db->setQuery((string) $query);
		$wsaonepages = $db->loadObjectList();
		$options  = array();
 
		if ($wsaonepages)
		{
		    foreach ($wsaonepages as $wsaonepage)
			{
			    $options[] = JHtml::_('select.option', $wsaonepage->id,  $wsaonepage->title . ':' . $wsaonepage->description );
			}
		}

		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
}