<?php
$ihConf = [];
$ihConf['noresize_key']         = 'noresize';         //files which contain this string will not be resized
$ihConf['noresize_dirs']        = array('noresize', 'banners'); //images in directories with these names within the images directory will not be resized.
$ihConf['trans_threshold']      = '100%';              //this is where semitransparent pixels blend to transparent when rendering gifs with ImageMagick
$ihConf['im_convert']           = '';                 //if you want to use ImageMagick, you must specify the convert binary here (e.g. '/usr/bin/convert')
$ihConf['gdlib']                = 2;                  //the GDlib version (0, 1 or 2) 2 tries to autodetect
$ihConf['allow_mixed_case_ext'] = false;              //allow files with mixed case extensions like 'Jpeg'. This costs some time for every displayed image. It's better to just use lower case extensions
$ihConf['default']['bg']        = 'transparent 255:255:255';
$ihConf['default']['quality']   = 100;

$bmzConf = [];
$bmzConf['umask']       = 0111;              //set the umask for new files
$bmzConf['dmask']       = 0000;              //directory mask accordingly
//$bmzConf['cachetime']   = 60*60*24;         //maximum age for cachefile in seconds (defaults to a day)
$bmzConf['cachetime']   = 0;         //maximum age for cachefile in seconds (defaults to a day)
$bmzConf['cachedir']    = DIR_FS_CATALOG . 'imgCache';
$bmzConf['lockdir']     = DIR_FS_CATALOG . 'bmz_lock';

/* Safemode Hack */
$bmzConf['safemodehack'] = 0;               //read http://wiki.breakmyzencart.com/zen-cart:safemodehack !
$bmzConf['ftp']['host'] = 'localhost';
$bmzConf['ftp']['port'] = '21';
$bmzConf['ftp']['user'] = 'user';
$bmzConf['ftp']['pass'] = 'password';
$bmzConf['ftp']['root'] = DIR_FS_CATALOG;
