<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 */
namespace WaasdorpSoekhan\Component\Wsaonepage\Administrator\Controller;
// No direct access to this file
\defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\MVC\Controller\AdminController;


/**
 * Wsaonepages Controller
 *
 * @since  0.5.7
 */
class WsaonepagesController extends AdminController
{
	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  object  The model. \Joomla\CMS\MVC\Model\BaseDatabaseModel
	 *
	 * @since   1.6
	 */
	public function getModel($name = 'Wsaonepage', $prefix = 'Administrator', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}
}