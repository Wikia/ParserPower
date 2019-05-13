<?php

/**
 * A collection of extended parser functions for MediaWiki, particularly including functions for dealing with lists of
 * values separated by a dynamically-specified delimiter.
 *
 * @addtogroup Extensions
 *
 * @link 
 *
 * @author Eyes <eyes@aeongarden.com>
 * @copyright Copyright � 2013 Eyes
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( function_exists( 'wfLoadExtension' ) ) {
	wfLoadExtension( 'ParserPower' );
	// Keep i18n globals so mergeMessageFileList.php doesn't break
	$wgMessagesDirs['ParserPower'] = __DIR__ . '/i18n';
	wfWarn(
		'Deprecated PHP entry point used for ParserPower extension. Please use wfLoadExtension instead, ' .
		'see https://www.mediawiki.org/wiki/Extension_registration for more details.'
	);
	return;
 } else {
	die( 'This version of the ParserPower extension requires MediaWiki 1.25+' );
}
