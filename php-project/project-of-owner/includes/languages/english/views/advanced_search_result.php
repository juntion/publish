<?php
define('NAVBAR_TITLE_1', 'Advanced Search');
define('NAVBAR_TITLE_2', 'Search Results');
define('HEADING_TITLE', 'Advanced Search');
define('HEADING_SEARCH_CRITERIA', 'Search Criteria');
define('FIBERSTORE_SEARCH_FOUND','we found');
define('FIBERSTORE_SEARCH_ITEM','item.');
define('FIBERSTORE_SEARCH_ITEMS','items.');

define('FIBERSTORE_SEARCH_RESULT','We were unable to find results for');
define('FIBERSTORE_SEARCH_TIPS','Search Tips');
define('FIBERSTORE_SEARCH_DOUBLE','Double check your spelling.');
define('FIBERSTORE_SEARCH_SINGLE','Try using single words .');
define('FIBERSTORE_SEARCH_SPECIFIC','Try searching for an item that is less specific.');
define('FIBERSTORE_SEARCH_ALWAYS','You can always narrow your search results later');
define('FIBERSTORE_SEARCH_NO_RESULT_01','Check your spelling');
define('FIBERSTORE_SEARCH_NO_RESULT_02','Try different or generic keywords.');
define('FIBERSTORE_SEARCH_NO_RESULT_03','Try entering a product ID or part number.');
define('FIBERSTORE_SEARCH_NO_RESULT_04','For further assistance,');
define('FIBERSTORE_SEARCH_NO_RESULT_05','live chat ');
define('FIBERSTORE_SEARCH_NO_RESULT_06','with us. ');
define('HOT_PRODUCTS','Hot Products');

define('RELATED_HOT_SEARCH_PRODUCTS','Related hot search products');
define('VIEW','View');
define('SEARCH_ADD','Add');

// 搜索产品id，结果为下线产品  2018.05.22 fairy add
define('SEARCH_RESULT_OFFLINE_PRODUCT','1 <span class="new_proList_proListNtit"> result for </span>"SEARCH_PRODUCT_ID"');
define('SEARCH_OFFLINE_PRODUCT_QUOTE_TIP','This product is no longer available online. If you do have a demand, you can get a Quote for help.');
define('SEARCH_OFFLINE_PRODUCT_SIMILAR_TIP','This product is no longer available online. We have similar products that might work for what you need.');
define('SEARCH_SIMILAR_RECOMMENDATION','Similar Product Recommendation');

//get a quote
define('GET_A_QUOTE_TIP','Please help to fill it out and submit, our service will reply to you as soon as possible.');
define('COMMENTS_OR_QUESTIONS','Comments/Questions');
define('FS_PRODUCTS_CHECK_BLACKLIST', 'Sorry,you have been added to the blacklist!');

// 面包屑
define('SEARCH_POPULAR','Popular');
define('SEARCH_RESULT_NUMBER','SEARCH_RESULT_NUMBER result');
define('SEARCH_RESULT_NUMBERS','SEARCH_RESULT_NUMBER results');
//2018.10.16
define('FS_CLEAR_SELECTIONS', 'Clear Selections');
define("FS_VIEW","View :");

// QV
define('FS_QV_QUICK_VIEW','Quickview');
define('FS_SEE_FULL_DETAILS','See Full Details');
define('FS_CUSTOMIZED','Add to Cart');
define('FS_PRODUCTS_INFORMATION','Products Information');
define('FS_CUSTOMER_ALSO_VIEWED','Customers Also Viewed');
define('FIBERSTORE_SEARCH_NO_RESULT_07','Can\'t find what you need? Contact us');

//add by liang.zhu 2019.11.08 这个记得要放一份到product_info.php中，因为里面也引入了tpl_advanced_search_offline_products.php
define('SEARCH_OFFLINE_PRODUCT_TIP_1', '"KEYWORD" has been upgraded to the new product "REPLACE_OFFLINE_PRODUCTS_ID" as below.');
define('SEARCH_OFFLINE_PRODUCT_TIP_2', '"KEYWORD" is no longer available online, but still supported by FS, please view the similar product "REPLACE_OFFLINE_PRODUCTS_ID" as below.');
define('SEARCH_OFFLINE_PRODUCT_TIP_3', '"KEYWORD" is no longer available online, but still supported by FS, please view the customized product "REPLACE_OFFLINE_PRODUCTS_ID" as below.');
define('SEARCH_OFFLINE_PRODUCT_TIP_4', '"KEYWORD" is no longer available online, but still supported by FS, please contact us for help.');
define('SEARCH_OFFLINE_PRODUCT_TIP_2_02', '"KEYWORD" is no longer available online, but still supported by FS. For more product information, please refer to the <a style="color:#0070bc;" target="_blank" href="'.reset_url('download.html?products_id=KEYWORD').'">download page</a>. <br/>The similar product "REPLACE_OFFLINE_PRODUCTS_ID" is recommended as below.');
define('SEARCH_OFFLINE_PRODUCT_TIP_3_02', '"KEYWORD" is no longer available online, but still supported by FS. For more product information, please refer to the <a style="color:#0070bc;" target="_blank" href="'.reset_url('download.html?products_id=KEYWORD').'">download page</a>. The customized product "REPLACE_OFFLINE_PRODUCTS_ID" is recommended as below.');
define('SEARCH_CANNOT_FIND_TIP', "Can't find what you need? Let us help.");
define('SEARCH_RESULT_OFFLINE_PRODUCT_ZERO','0 <span class="new_proList_proListNtit"> result for </span>"SEARCH_PRODUCT_ID"');
