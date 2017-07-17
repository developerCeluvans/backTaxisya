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
$module_name = basename(dirname(__FILE__));
$module_dir = $module->module;
$module_id = $module->id;
$document->addStyleDeclaration(' '.$params->get('custom_css').'');

// Prepare content
if ($params->get('prepare_content') == '1') {
JPluginHelper::importPlugin('content');
$module->content = JHtml::_('content.prepare', $params->get('content_text'));
} else {
	$module->content = $params->get('content_text');
}
// Parallax Effects
$parallaxNone = ' ';

// Effect 1
$parallaxEffect1 = 'data-top-bottom="transform:translateY(-'.$params->get('parallax_distance').'px);" 
data-bottom-top="transform:translateY(0px);"';

// Effect 2
$parallaxEffect2 = 'data-top-bottom="transform:translateY('.$params->get('parallax_distance').'px);" 
data-bottom-top="transform:translateY(0px);"';

// Effect 3
$parallaxEffect3 = 'data-top-bottom="transform:translateX(-'.$params->get('parallax_distance').'px);" 
data-bottom-top="transform:translateX(0px);"';

// Effect 4
$parallaxEffect4 = 'data-top-bottom="transform:translateX('.$params->get('parallax_distance').'px);" 
data-bottom-top="transform:translateX(0px);"';

// Effect 5
$parallaxEffect5 = 'data-top-bottom="transform:translateY(-'.$params->get('parallax_distance').'px) 
translateX(-'.$params->get('parallax_distance').'px);" 
data-bottom-top="transform:translateY(0px) translateX(0px);"';

// Effect 6
$parallaxEffect6 = 'data-top-bottom="transform:translateY('.$params->get('parallax_distance').'px) 
translateX(-'.$params->get('parallax_distance').'px);" 
data-bottom-top="transform:translateY(0px) translateX(0px);"';

// Effect 7
$parallaxEffect7 = 'data-top-bottom="transform:translateY('.$params->get('parallax_distance').'px) 
translateX('.$params->get('parallax_distance').'px);" 
data-bottom-top="transform:translateY(0px) translateX(0px);"';

// Effect 8
$parallaxEffect8 = 'data-top-bottom="transform:translateY(-'.$params->get('parallax_distance').'px) 
translateX('.$params->get('parallax_distance').'px);" 
data-bottom-top="transform:translateY(0px) translateX(0px);"';// Effect 9

// Effect 9
$parallaxEffect9 = 'data-top-bottom="transform:scale(1.5);" 
data-bottom-top="transform:scale(1);"';

// Effect 10
$parallaxEffect10 = 'data-top-bottom="transform:scale(1);" 
data-bottom-top="transform:scale(1.5);"';

// Effect 11
$parallaxEffect11 = 'data-top-bottom="transform:scale(1);" 
data-center="transform:scale(1.5);" 
data-bottom-top="transform:scale(1);"';

// Effect 12
$parallaxEffect12 = 'data-top-bottom="transform:scale(1.5);" 
data-center="transform:scale(1);" 
data-bottom-top="transform:scale(1.5);"';

// Parallax Content Effects
$parallaxContentNone = ' ';

// Effect 1
$parallaxContentEffect1 = 'data-top-bottom="top:-'.$params->get('parallax_content_distance').'px; opacity:0;" 
data-top-top="top:0px; opacity:1;" data-bottom-bottom="top:0px; opacity:1;"
data-bottom-top="top:'.$params->get('parallax_content_distance').'px; opacity:0;"';

// Effect 2
$parallaxContentEffect2 = 'data-top-bottom="top:'.$params->get('parallax_content_distance').'px; opacity:0;" 
data-top-top="top:0px; opacity:1;" data-bottom-bottom="top:0px; opacity:1;"
data-bottom-top="top:-'.$params->get('parallax_content_distance').'px; opacity:0;"';

// Effect 3
$parallaxContentEffect3 = 'data-top-bottom="left:-'.$params->get('parallax_content_distance').'px; opacity:0;" 
data-top-top="left:0px; opacity:1;" data-bottom-bottom="left:0px; opacity:1;"
data-bottom-top="left:'.$params->get('parallax_content_distance').'px; opacity:0;"';

// Effect 4
$parallaxContentEffect4 = 'data-top-bottom="left:'.$params->get('parallax_content_distance').'px; opacity:0;" 
data-top-top="left:0px; opacity:1;" data-bottom-bottom="left:0px; opacity:1;"
data-bottom-top="left:-'.$params->get('parallax_content_distance').'px; opacity:0;"';

// Effect 5
$parallaxContentEffect5 = 'data-top-bottom="top:-'.$params->get('parallax_content_distance').'px; 
left:-'.$params->get('parallax_content_distance').'px; opacity:0;" data-top-top="top:0px; left:0px; opacity:1;" 
data-bottom-bottom="top:0px; left:0px; opacity:1;" data-bottom-top="top:'.$params->get('parallax_content_distance').'px; 
left:'.$params->get('parallax_content_distance').'px; opacity:0;"';

// Effect 6
$parallaxContentEffect6 = 'data-top-bottom="top:'.$params->get('parallax_content_distance').'px; 
left:-'.$params->get('parallax_content_distance').'px; opacity:0;" 
data-top-top="top:0px; left:0px; opacity:1;" data-bottom-bottom="top:0px; left:0px; opacity:1;"
data-bottom-top="top:-'.$params->get('parallax_content_distance').'px; 
left:'.$params->get('parallax_content_distance').'px; opacity:0;"';

// Effect 7
$parallaxContentEffect7 = 'data-top-bottom="top:'.$params->get('parallax_content_distance').'px; 
left:'.$params->get('parallax_content_distance').'px; opacity:0;" data-top-top="top:0px; left:0px; opacity:1;" 
data-bottom-bottom="top:0px; left:0px; opacity:1;" data-bottom-top="top:-'.$params->get('parallax_content_distance').'px; 
left:-'.$params->get('parallax_content_distance').'px; opacity:0;"';

// Effect 8
$parallaxContentEffect8 = 'data-top-bottom="top:-'.$params->get('parallax_content_distance').'px; 
left:'.$params->get('parallax_content_distance').'px; opacity:0;" 
data-top-top="top:0px; left:0px; opacity:1;" data-bottom-bottom="top:0px; left:0px; opacity:1;"
data-bottom-top="top:'.$params->get('parallax_content_distance').'px; 
left:-'.$params->get('parallax_content_distance').'px; opacity:0;"';

// Effect 9
$parallaxContentEffect9 = 'data-top-bottom="transform:scale(0.5); opacity:0;" 
data-top-top="transform:scale(1); opacity:1;" data-bottom-bottom="transform:scale(1); opacity:1;" 
data-bottom-top="transform:scale(0.5); opacity:0;"';

// Effect 10
$parallaxContentEffect10 = 'data-top-bottom="transform:scale(1.5); opacity:0;" 
data-top-top="transform:scale(1); opacity:1;" data-bottom-bottom="transform:scale(1); opacity:1;" 
data-bottom-top="transform:scale(1.5); opacity:0;"';

//Get tmpl
require JModuleHelper::getLayoutPath('mod_pri_parallax', $params->get('parallax_type'));
require_once JPATH_SITE . '/modules/' . $module_dir . '/helper.php';
?>
