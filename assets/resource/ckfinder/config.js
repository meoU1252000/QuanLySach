/*
Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
For licensing, see license.txt or http://cksource.com/ckfinder/license
*/

CKFinder.customConfig = function (config) {
  // Define changes to default configuration here.
  // For the list of available options, check:
  // http://docs.cksource.com/ckfinder_2.x_api/symbols/CKFinder.config.html
  // Sample configuration options:
  // config.uiColor = '#BDE31E';
  // config.language = 'fr';
  // config.removePlugins = 'basket';
  config.filebrowserBrowseUrl = "../assets/resource/ckfinder/ckfinder.html";
  config.filebrowserImageBrowseUrl =
    "../assets/resource/ckfinder/ckfinder.html?type=Images";
  config.filebrowserFlashBrowseUrl =
    "../assets/resource/ckfinder/ckfinder.html?type=Flash";
  config.filebrowserUploadUrl =
    "../assets/resource/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files";
  config.filebrowserImageUploadUrl =
    "../assets/resource/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images";
  config.filebrowserFlashUploadUrl =
    "../assets/resource/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash";
};
