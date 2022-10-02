<?php 
//各国电话语言包 2017.8.18  ery
define('FS_PHONE_US','+61 3 9693 3488');		// United States
define('FS_PHONE_DE','+49 (0) 8165 80 90 517');		// Germany
define('FS_PHONE_HK','+(852) 5808 7203');		// Hong Kong
define('FS_PHONE_MX','+52 (55) 3098 7566');		// Mexico
define('FS_PHONE_CA','+1 (647) 243 6342');		// Canada
define('FS_PHONE_BR','+55 (11) 4349 6175');		// Brazil
define('FS_PHONE_AR','+54 (11) 5031 9542');		// Argentina
define('FS_PHONE_GB','+44 (0) 121 716 1755');	// United Kingdom
define('FS_PHONE_FR','+33 (1) 82 884 336');		// France
define('FS_PHONE_NL','+31 (20) 241 4029');		// Netherlands
define('FS_PHONE_AU','+61 3 9693 3488');		// Australia
define('FS_PHONE_ES','+34 (91) 123 7299');		// Spain
define('FS_PHONE_RU','+7 (499) 643 4876');		// Russian Federation
define('FS_PHONE_SG','+(65) 3163 0003');		// Singapore
define('FS_PHONE_TW','+886 (2) 5592 4011');		// Taiwan
define('FS_PHONE_IT','+39 (02) 8295 0086');		// Italy
define('FS_PHONE_CH','+41 (43) 508 5909');		// Switzerland
define('FS_PHONE_DK','+45 7876 8321');			// Denmark
define('FS_PHONE_NZ','+64 (9) 985 3566');		// New Zealand
define('FS_PHONE_WH','+86 (027) 87639823');         //wuhan
define('FS_PHONE_US_TWO','+1 (253) 277 3058');		// United States2
define('FS_PHONE_JP','+81 345888332');			//japan

define('FS_PHONE_SITE_EU','+49 (0) 8165 80 90 517');
define('FS_PHONE_SITE_UK','+44 (0) 121 716 1755');
define('FS_PHONE_SITE_ES','+34 (91) 123 7299');
define('FS_PHONE_SITE_FR','+33 (1) 82 884 336');
define('FS_PHONE_SITE_RU','+7 (499) 643 4876');
define('FS_PHONE_SITE_MX','+52 (55) 3098 7566');
define('FS_PHONE_SITE_AU','+61 3 9693 3488');
define('FS_PHONE_SITE_JP','+1 (877) 205 5306');
define('FS_PHONE_SITE_SG','+(65) 3163 0003');
if(US_WAREHOUSE_UP){
    define('FS_PHONE_SITE_US','+1 (888) 468 7419');
    define('FS_PHONE_CHECKOUT_US','+1 (888) 468 7419');
}else{
    define('FS_PHONE_SITE_US','+1 (877) 205 5306 (PST) <br/> +1 (888) 468 7419 (EST)');
    define('FS_PHONE_CHECKOUT_US','+1 (877) 205 5306 (PST) / +1 (888) 468 7419 (EST)');
}
define('FS_PHONE_PO_AU','+61 3 9693 3488');
if($_SESSION['languages_code']=='sg'){
    define('FS_COMMON_PHONE','+(65) 6443 7951');
}else{
    define('FS_COMMON_PHONE','+61 3 9693 3488');
}
define('FS_PHONE_US_EAST','+1(888) 468 7419');
?>
