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
$document = JFactory::getDocument();
$document->addStyleDeclaration('
	#pri-parallax-'.$module_id.' {
		width:100%;
		background-color: '.$params->get('image_background_color').';
		position:relative;
		overflow:hidden;
	}
	#pri-parallax-image-'.$module_id.' {
		top:-'.$params->get('parallax_distance').'px;
		bottom:-'.$params->get('parallax_distance').'px;
		left:-'.$params->get('parallax_distance').'px;
		right:-'.$params->get('parallax_distance').'px;
		display:block;
		position: absolute !important;
		z-index: 1;
		-webkit-transform: translateZ(0);
		background-image:url("'.JURI::base() .$params->get('image_url').'") !important;
		background-position: '.$params->get('image_background_position').';
		background-repeat: '.$params->get('image_background_repeat').';
		background-size: '.$params->get('image_background_size').';
	}
	#pri-parallax-content-'.$module_id.'{
		position:relative;
		z-index:2;
		-webkit-transform: translateZ(0);
		padding:'.$params->get('content_padding').' !important;
	}
');

?>
<div id="pri-parallax-<?php echo $module_id; ?>"  class="pri-parallax">
    <div id="pri-parallax-image-<?php echo $module_id; ?>"  class="pri-parallax-background" 
	<?php echo ${"parallax". ucfirst($params->get('parallax_effect'))}; ?>>
    </div>
    <div id="pri-parallax-content-<?php echo $module_id; ?>" class="pri-parallax-content 
	<?php echo $params->get('content_class'); ?>" 
	<?php echo ${"parallaxContent". ucfirst($params->get('parallax_content_effect'))}; ?> >
    <?php echo $module->content; ?>
    </div>
</div>
