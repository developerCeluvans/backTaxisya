<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_pri_portfolio
 * @version     1.0
 *
 * @copyright   Copyright (C) 2010 - 2014 Devpri. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
// Mobile Detect
require_once JPATH_SITE . '/modules/' . $module_dir . '/libraries/Mobile_Detect.php';
$detect = new Mobile_Detect;
//Load skrollr
if ($params->get('disable_parallax_on_mobile')=="1") {
	if ($detect->isMobile() or $detect->isTablet()) { 
	} else {
		$document->addScript(JURI::base() .'modules/mod_pri_parallax/assets/js/skrollr.min.js');	
    }
} else {
	$document->addScript(JURI::base() .'modules/mod_pri_parallax/assets/js/skrollr.min.js');
}

class modPRIParallaxHelper {
	
}
?>
<?php if ($params->get('disable_parallax_on_mobile')=="1") { ?>
	<?php if ($detect->isMobile() or $detect->isTablet()) { } else {?>
		<script type="text/javascript">
			(function($) {
				$(document).ready(function() {
					var s = skrollr.init({
						forceHeight: false,
						mobileDeceleration: 1,
						smoothScrolling: false
					});
				});
			})(jQuery);
        </script>
    <?php }?>
<?php } else {?>
	<script type="text/javascript">
        (function($) {
            $(document).ready(function() {
                $("body").wrapInner( "<div id=skrollr-body></div>");
                var s = skrollr.init({
                    forceHeight: false,
                    mobileDeceleration: 0.004
                });
            });
        })(jQuery);
	</script>
<?php }?>