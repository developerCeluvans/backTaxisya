<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_pri_parallax
 * @version     1.0
 *
 * @copyright   Copyright (C) 2010 - 2014 Devpri. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
class JFormFieldSettings extends JFormField

{
	public $type = 'settings';

	public function __construct($form = null)
	{
		parent::__construct($form);
		JHtml::_('jquery.ui', array(
			'core'
		));
	}
	protected function getInput()
	{
		$document = JFactory::getDocument();
		$document->addStyleDeclaration('
		.pri-hide{
			display:none;
		}
		');
	$document->addScriptDeclaration('
		jQuery(document).ready(function($){
			//On Load
			$(window).load(function () {
        		$type = jQuery("#jform_params_parallax_type").find("option:selected").text();
				jQuery("#myTabTabs>li").each(function () {
				var target = jQuery(this).find(">a").prop("hash");
				if ($type == "Image") {
					if (target == "#attrib-image") {
						jQuery(this).find(">a").parent().removeClass("pri-hide");
					}
					if (target == "#attrib-video") {
						jQuery(this).find(">a").parent().addClass("pri-hide");
					}
				}
				if ($type == "Video") {
					if (target == "#attrib-image") {
						jQuery(this).find(">a").parent().addClass("pri-hide");
					}
					if (target == "#attrib-video") {
						jQuery(this).find(">a").parent().removeClass("pri-hide");
					}
				}
				});	
			});		
			
			//On Change
			jQuery("body").delegate("#jform_params_parallax_type", "change", function () {
        		$type = jQuery("#jform_params_parallax_type").find("option:selected").text();
				jQuery("#myTabTabs>li").each(function () {
				var target = jQuery(this).find(">a").prop("hash");
				if ($type == "Image") {
					if (target == "#attrib-image") {
						jQuery(this).find(">a").parent().removeClass("pri-hide");
					}
					if (target == "#attrib-video") {
						jQuery(this).find(">a").parent().addClass("pri-hide");
					}
				}
				if ($type == "Video") {
					if (target == "#attrib-image") {
						jQuery(this).find(">a").parent().addClass("pri-hide");
					}
					if (target == "#attrib-video") {
						jQuery(this).find(">a").parent().removeClass("pri-hide");
					}
				}
				});
			});
        });
	');
	}

}
