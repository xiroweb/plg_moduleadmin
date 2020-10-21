<?php
/**
 * @package    Joomla.Installation
 *
 * @copyright  Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Form Rule class for the Position.
 *
 * @since  3.9.4
 */
class JFormRulePositionrule extends JFormRule
{
	protected $regex = '^[a-z0-9_-]{1,50}$';
}
