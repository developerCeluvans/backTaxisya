<?php

/**
 * CKEditor for generating TinyMCE rich text editors.
 *
 * @package     Bundles
 * @subpackage  CKEditor
 * @author      Fabiano de Paula Martins
 *
 * @see http://ckeditor.com/ph
 */

Autoloader::map(array(
	'Export\\ExportDataExcel'               => __DIR__.'/php-export-data.class.php',
	'Export\\ExportDataCSV'               => __DIR__.'/php-export-data.class.php',
));
