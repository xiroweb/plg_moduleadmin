<?php
/**
 * @package     Joomla.Site
 * @subpackage  Template.system
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView;

/*
 * Module chrome that add preview information to the module
 */
function modChrome_outlinemodal($module, &$params, &$attribs)
{
	
	JHtml::_('behavior.core');
	JHtml::_('script', 'plg_system_moduleadmin/moduleadmin-modal.js', array('version' => 'auto', 'relative' => true));

	$app = JFactory::getApplication();
	$function  = $app->input->getCmd('function', 'jSelectModuleadmin');
	//$onclick   = $this->escape($function);
	$morexx = new HtmlView();
	$onclick   = $morexx->escape($function);
	static $css = false;

	if (!$css)
	{
		$css = true;
		$doc = JFactory::getDocument();

		$doc->addStyleDeclaration('
		.mod-preview {
			background: rgba(100,100,100,.08);
			box-shadow: 0 0 0 4px #f4f4f4, 0 0 0 5px rgba(100,100,100,.2);
			border-radius: 1px;
			margin: 8px 0;
		}
		.mod-preview-info {
			padding: 4px 6px;
			margin-bottom: 5px;
			font-family: Arial, sans-serif;
			font-size: .75rem;
			line-height: 1rem;
			color: white;
			background-color: #33373f;
			border-radius: 3px;
			box-shadow: 0 -10px 20px rgba(0,0,0,.2) inset;
		}
		.mod-preview-info span {
			font-weight: bold;
			color: #ccc;
		}
		.mod-preview-wrapper {
			margin-bottom: .5rem;
		}
		');
	}
	?>
	  <?php 
                                $link = '';
                                $attribs = 'data-function="' . $morexx->escape($onclick) . '"'
								. ' data-id="' . $module->position. '"'
								. ' data-title="' .  $module->position . '"'
								. ' data-uri="' . $link . '"'
                                ;
                                ?>

	<div class="mod-preview">
		<div class="mod-preview-info">
			<div class="mod-preview-position aah hah yeah"> aaaa v
					<a class="select-link" href="javascript:void(0)" <?php echo $attribs; ?>>
							<?php echo $module->position; ?>
                                </a>
				<?php echo JText::sprintf('JGLOBAL_PREVIEW_POSITION', $module->position); ?>
			</div>
			<div class="mod-preview-style">
				<?php echo JText::sprintf('JGLOBAL_PREVIEW_STYLE', $module->style); ?>
			</div>
		</div>
		<div class="mod-preview-wrapper">
			<?php echo $module->content; ?>
		</div>
	</div>


	<?php
}
