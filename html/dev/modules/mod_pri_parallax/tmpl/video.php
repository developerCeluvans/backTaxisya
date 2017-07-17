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
require_once JPATH_SITE . '/modules/' . $module_dir . '/libraries/Mobile_Detect.php';
$detect = new Mobile_Detect;
$document = JFactory::getDocument();
// Load videobackground only for desktop
if ($detect->isMobile() or $detect->isTablet()) { 
} else {
	$document->addScript(JURI::base() .'modules/mod_pri_parallax/assets/js/videobackground.min.js');
}
// CSS for video parallax
$document->addStyleDeclaration('
	#pri-parallax-'.$module_id.' {
		width:100%;
		background-color: '.$params->get('image_background_color').';
		position:relative;
		overflow:hidden;
	}
	#pri-parallax-video-'.$module_id.' {
		top:-'.$params->get('parallax_distance').'px;
		bottom:-'.$params->get('parallax_distance').'px;
		left:-'.$params->get('parallax_distance').'px;
		right:-'.$params->get('parallax_distance').'px;
		display:block;
		position: absolute !important;
		z-index: 1;
		background-image:url("'.JURI::base() .$params->get('video_background_poster').'") !important;
		background-size: cover;
	}
	#pri-parallax-content-'.$module_id.'{
		position:relative;
		z-index:2;
		padding:'.$params->get('content_padding').' !important;
	}
	#pri-parallax-video-player-'.$module_id.' {
		position:relative;
		height: 100%;
    	width: 100%;
	}
	#pri-parallax-video-player-'.$module_id.' video {
		min-height: 100%;
    	min-width: 100%;
	}
');
?>
<div id="pri-parallax-<?php echo $module_id; ?>"  class="pri-parallax">
    <div id="pri-parallax-video-<?php echo $module_id; ?>"  class="pri-parallax-background" 
	<?php echo ${"parallax". ucfirst($params->get('parallax_effect'))}; ?>>
    <div id="pri-parallax-video-player-<?php echo $module_id; ?>"></div>
    </div>
    <div id="pri-parallax-content-<?php echo $module_id; ?>" class="pri-parallax-content 
	<?php echo $params->get('content_class'); ?>" <?php echo ${"parallaxContent". ucfirst($params->get('parallax_content_effect'))}; ?> >
    <?php echo $module->content; ?>
    </div>
</div>
<?php if ($detect->isMobile() or $detect->isTablet()) { } else { ?>
	<script type="text/javascript">
	// JS only for desktop
        (function($){
                  $("#pri-parallax-video-player-<?php echo $module_id; ?>").videobackground({
                        videoSource:	[["<?php echo JURI::base() .''.$params->get('video_background_mp4'); ?>", "video/mp4"],
                                        ["<?php echo JURI::base() .''.$params->get('video_background_webm'); ?>", "video/webm"], 
                                        ["<?php echo JURI::base() .''.$params->get('video_background_ogg'); ?>", "video/ogg"]], 
                        poster: 		"<?php echo JURI::base() .''.$params->get('video_background_poster'); ?>",
                        loop:           <?php echo $params->get('video_background_loop'); ?>,
                        resizeTo:       'document',
                        resize:       	false
                    });
                    if('<?php echo $params->get('video_background_audio'); ?>' == 'mute'){
                        $(".video-parallax<?php echo $module_id; ?>").videobackground("<?php echo $params->get('video_parallax_video_audio'); ?>");
                    }
        })(jQuery);
    </script>
<?php }?>