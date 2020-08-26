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
	$htmlview = new HtmlView();
	$onclick   = $htmlview->escape($function);
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
		    background-color: transparent;
		    border-radius: 3px;
		    /* box-shadow: 0 -10px 20px rgba(0,0,0,.2) inset; */
		}
		.mod-preview-info span {
			font-weight: bold;
			color: #ccc;
		}
		.mod-preview-wrapper {
			margin-bottom: .5rem;
		}
		a.select-link {
		    color: #fff;
		    font-size: 18px;
		    border: 1px solid #bdbdbd;
		    border-radius: 6px;
		    padding: 10px;
		    display: block;
		    background: #0D47A1;
	        box-shadow: 0 3px 6px rgba(0,0,0,.16), 0 3px 6px rgba(0,0,0,.23);
		    transition: all ease-in-out 0.3s;
		    -moz-transition: all ease-in-out 0.3s;
		    -ms-transition: all ease-in-out 0.3s;
		    -o-transition: all ease-in-out 0.3s;
		    -webkit-transition: all ease-in-out 0.3s;
		}
		a.select-link:hover {
	      box-shadow: 0 14px 28px rgba(0,0,0,.25), 0 10px 10px rgba(0,0,0,.22);
		    transition: all ease-in-out 0.3s;
		    -moz-transition: all ease-in-out 0.3s;
		    -ms-transition: all ease-in-out 0.3s;
		    -o-transition: all ease-in-out 0.3s;
		    -webkit-transition: all ease-in-out 0.3s;
		}
		');
	}
	?>
	  <?php 
        $link = '';
        $attribs = 'data-function="' . $htmlview->escape($onclick) . '"'
		. ' data-id="' . $module->position. '"'
		. ' data-title="' .  $module->position . '"'
		. ' data-uri="' . $link . '"'
        ;
        ?>
	<div class="mod-preview">
		<div class="mod-preview-info">
			<div class="mod-preview-position">
				<a class="select-link" href="javascript:void(0)" <?php echo $attribs; ?>>
					<?php echo $module->position; ?>
                </a>
			</div>
		</div>
		<div class="mod-preview-wrapper">
			<?php echo $module->content; ?>
		</div>
	</div>


	<?php
}
