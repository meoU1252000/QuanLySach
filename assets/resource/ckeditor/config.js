/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
//	config.extraPlugins = 'eqneditor';
	config.filebrowserBrowseUrl = '../assets/resource/ckfinder/ckfinder.html';
	config.filebrowserImageBrowseUrl = '../assets/resource/ckfinder/ckfinder.html?type=Images';
	config.filebrowserFlashBrowseUrl = '../assets/resource/ckfinder/ckfinder.html?type=Flash';
	config.filebrowserUploadUrl = '../assets/resource/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
	config.filebrowserImageUploadUrl = '../assets/resource/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
	config.filebrowserFlashUploadUrl = '../assets/resource/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
};
