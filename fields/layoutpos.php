<?php

/**
 * @copyright	Copyright (C) 2020 by XiroWeb
 * @license		GNU/GPL
 * */
// no direct access
defined('_JEXEC') or die('Restricted access');


class JFormFieldLayoutpos extends JFormField {

	protected $type = 'layoutpos';

	protected function getInput() {

		$app = JFactory::getApplication();

		JFactory::getLanguage()->load('plg_system_moduleadmin',JPATH_SITE);

		// $this->value is set if there's a default id specified in the xml file
		$value = empty($this->value) ? '' : $this->value;
        
		$modalId = 'Moduleadmin_' . $this->id;

		// Add the modal field script to the document head.
		JHtml::_('jquery.framework');
		JHtml::_('script', 'system/modal-fields.js', array('version' => 'auto', 'relative' => true));

		// our callback function from the modal to the main window:
		JFactory::getDocument()->addScriptDeclaration("
			function jSelectModuleadmin_" . $this->id . "(id, title, catid, object, url, language) {
				window.processModalSelect('Moduleadmin', '" . $this->id . "', id, title, catid, object, url, language);
			}
			");

		$title = empty($value) ? '' : htmlspecialchars($value, ENT_QUOTES, 'UTF-8');	
		$html  = '<span class="input-append">';
		$html .= '<input class="input-medium" id="' . $this->id . '_name" type="hidden" value="' . $title . '" disabled="disabled" size="35" />';

		// html for the Select button
		$html .= '<a'
			. ' class="btn hasTooltip' . ($value ? ' hidden' : '') . '"'
			. ' id="' . $this->id . '_select"'
			. ' data-toggle="modal"'
			. ' role="button"'
			. ' href="#ModalSelect' . $modalId . '"'
			. ' title="' . JHtml::tooltipText('PLG_SYSTEM_MODULEADMIN_FIELD_POSITION_SELECT_BUTTON_TOOLTIP') . '">'
			. '<span class="icon-file" aria-hidden="true"></span> ' . JText::_('PLG_SYSTEM_MODULEADMIN_JSELECT')
			. '</a>';

		// html for the Clear button
		$html .= '<a'
			. ' class="btn' . ($value ? '' : ' hidden') . '"'
			. ' id="' . $this->id . '_clear"'
			. ' href="#"'
			. ' onclick="window.processModalParent(\'' . $this->id . '\'); return false;">'
			. '<span class="icon-remove" aria-hidden="true"></span>' . JText::_('PLG_SYSTEM_MODULEADMIN_JCLEAR')
			. '</a>';

		$html .= '</span>';

		// url for the iframe
		$linkModuleadmins = JUri::root().'index.php?tp=1&positionmodal=1&amp;' . JSession::getFormToken() . '=1';

		$templatestyle = $app->getUserState('com_modules.edit.module.templatestyle', 0);
		if ($templatestyle) {
			$linkModuleadmins .= '&templateStyle=' . $templatestyle;
		}

		$urlSelect = $linkModuleadmins . '&amp;function=jSelectModuleadmin_' . $this->id;
        
		// title to go in the modal header
		$modalTitle    = JText::_('PLG_SYSTEM_MODULEADMIN_SELECT_MODAL_TITLE');
        
		// html to set up the modal iframe
		$html .= JHtml::_(
			'bootstrap.renderModal',
			'ModalSelect' . $modalId,
			array(
				'title'       => $modalTitle,
				'url'         => $urlSelect,
				'height'      => '400px',
				'width'       => '800px',
				'bodyHeight'  => '70',
				'modalWidth'  => '80',
				'footer'      => '<a role="button" class="btn" data-dismiss="modal" aria-hidden="true">' . JText::_('JLIB_HTML_BEHAVIOR_CLOSE') . '</a>',
			)
		);

		
		$class = $this->required ? ' class="required modal-value"' : '';

		
		$html .= '<input type="text" id="' . $this->id . '_id" ' . $class 
			. ' data-required="' . (int) $this->required . '" name="' . $this->name
			. '" value="' . $value . '" />';

		return $html;
	}

	protected function getLabel() {
		return str_replace($this->id, $this->id . '_id', parent::getLabel());
	}
}
