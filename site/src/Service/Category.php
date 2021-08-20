<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2021 A.H.C. Waasdorp. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace  WaasdorpSoekhan\Component\Wsaonepage\Site\Service;

\defined('_JEXEC') or die;

use Joomla\CMS\Categories\Categories;

/**
 * Wsaonepage Component Category Tree
 *
 * @since  0.6.2
 */
class Category extends Categories
{
	/**
	 * Class constructor
	 *
	 * @param   array  $options  Array of options
	 *
	 * @since   1.6
	 */
	public function __construct($options = array())
	{
		$options['table']      = '#__wsaonepage';
		$options['extension']  = 'com_wsaonepage';
		$options['statefield'] = 'published';

		parent::__construct($options);
	}
}
