<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_modules
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\Utilities\ArrayHelper;

/**
 * Modules list controller class.
 *
 * @since  1.6
 */
class ModulesControllerModules extends JControllerAdmin
{
	/**
	 * Method to clone an existing module.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	public function duplicate()
	{
		// Check for request forgeries
		$this->checkToken();

		$pks = $this->input->post->get('cid', array(), 'array');
		$pks = ArrayHelper::toInteger($pks);

		try
		{
			if (empty($pks))
			{
				throw new Exception(JText::_('COM_MODULES_ERROR_NO_MODULES_SELECTED'));
			}

			$model = $this->getModel();
			$model->duplicate($pks);
			$this->setMessage(JText::plural('COM_MODULES_N_MODULES_DUPLICATED', count($pks)));
		}
		catch (Exception $e)
		{
			JError::raiseWarning(500, $e->getMessage());
		}

		$this->setRedirect('index.php?option=com_modules&view=modules' . $this->getmoreurlreturn());
	}

	/**
	 * Method to get a model object, loading it if required.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  object  The model.
	 *
	 * @since   1.6
	 */
	public function getModel($name = 'Module', $prefix = 'ModulesModel', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, $config);
	}

	public function getmoreurlreturn() 
	{
		$tmpl = $this->input->get('tmpl', '', 'cmd');
		$templateStyle = $this->input->getInt('templateStyle',0);
		$roottemplate = $this->input->get('roottemplate', '', 'STRING');
		$urlreturn = ($tmpl ? '&tmpl=' . $tmpl : '');
		$urlreturn .= ($roottemplate ? '&roottemplate=' . $roottemplate : '');
		$urlreturn .= ($templateStyle ? '&templateStyle=' . $templateStyle : '');

		return $urlreturn;
	}

	
	public function publish()
	{
		// Check for request forgeries
		$this->checkToken();

		// Get items to publish from the request.
		$cid = $this->input->get('cid', array(), 'array');
		$data = array('publish' => 1, 'unpublish' => 0, 'archive' => 2, 'trash' => -2, 'report' => -3);
		$task = $this->getTask();
		$value = ArrayHelper::getValue($data, $task, 0, 'int');

		if (empty($cid))
		{
			\JLog::add(\JText::_($this->text_prefix . '_NO_ITEM_SELECTED'), \JLog::WARNING, 'jerror');
		}
		else
		{
			// Get the model.
			$model = $this->getModel();

			// Make sure the item ids are integers
			$cid = ArrayHelper::toInteger($cid);

			// Publish the items.
			try
			{
				$model->publish($cid, $value);
				$errors = $model->getErrors();
				$ntext = null;

				if ($value === 1)
				{
					if ($errors)
					{
						\JFactory::getApplication()->enqueueMessage(\JText::plural($this->text_prefix . '_N_ITEMS_FAILED_PUBLISHING', count($cid)), 'error');
					}
					else
					{
						$ntext = $this->text_prefix . '_N_ITEMS_PUBLISHED';
					}
				}
				elseif ($value === 0)
				{
					$ntext = $this->text_prefix . '_N_ITEMS_UNPUBLISHED';
				}
				elseif ($value === 2)
				{
					$ntext = $this->text_prefix . '_N_ITEMS_ARCHIVED';
				}
				else
				{
					$ntext = $this->text_prefix . '_N_ITEMS_TRASHED';
				}

				if ($ntext !== null)
				{
					$this->setMessage(\JText::plural($ntext, count($cid)));
				}
			}
			catch (\Exception $e)
			{
				$this->setMessage($e->getMessage(), 'error');
			}
		}

		$extension = $this->input->get('extension');
		$extensionURL = $extension ? '&extension=' . $extension : '';
		

		$this->setRedirect(\JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list . $extensionURL. $this->getmoreurlreturn(), false));
	}
}
