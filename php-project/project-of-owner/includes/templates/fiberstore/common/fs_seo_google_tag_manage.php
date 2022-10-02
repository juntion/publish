<?php
$userId = '';
if(!empty($_SESSION["customer_id"])){
    $customers_level = fs_get_data_from_db_fields('customers_level','customers','customers_id = "'.$_SESSION["customer_id"].'"','limit 1');
    $userId = $customers_level.$_SESSION["customer_id"];
}
if ($_GET['main_page'] == 'index' && empty($_GET['cPath'])) {
    ?>
    <!--		<link rel="amphtml" href="https://www.fs.com/amp/index.html">-->
    <script>
        dataLayer = [{
            'page_type': 'home',
            'userId': '<?php echo $userId; ?>',
        }]
    </script>
    <?php $true_or_false = 1;
} ?>

<?php if ($_GET['main_page'] == 'product_info') { ?>
	<?php 
	// if (is_array($wholesale_products) && sizeof($wholesale_products)) {

    //     if (!in_array($_GET['products_id'], $wholesale_products)) {
    //         $products_price = $currencies->new_value(get_customers_products_level_final_price(fs_get_product_wholesale_price_of_qty((int)$_GET['products_id'], (int)$_GET['cart_quantity'])));
    //     } else {
    //         $products_price = $currencies->value(get_customers_products_level_final_price(fs_get_product_wholesale_price_of_qty((int)$_GET['products_id'], (int)$_GET['cart_quantity'])));
    //     }

    // } else {
    //     $products_price = $currencies->new_value(get_customers_products_level_final_price(fs_get_product_wholesale_price_of_qty((int)$_GET['products_id'], (int)$_GET['cart_quantity'])));
    // }
	$products_id = $_GET["products_id"];
	$products_price = zen_get_products_final_price($products_id);
	if(get_price_vat_uk_show()){
		$products_price_tax = $products_price*1.20;
	}elseif($_SESSION['languages_code']=='au'){
		$products_price_tax = $products_price*1.10;
	}elseif(in_array($_SESSION['languages_code'],['de','dn'])){
		$products_price_tax = $products_price*1.19;
	}else{
		$products_price_tax = $products_price;
	}
    if((int)$products_id == 11555){
        $t = date(DATE_ISO8601,strtotime("2019-10-04"));
        echo '<script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "VideoObject",
                "name": "10GBASE-LR SFP+ Transceiver Module",
                "description": "10GBASE-LR SFP+ transceiver, designed with LC duplex interface, is applied for long distance data transmission at 10G data rate. Distance can reach up to 10 km over single-mode fiber (SMF) patch cable with the wavelength of 1310nm. FS.COM offers various brands of 10GBASE-LR SFP+ optical transceiver which can work well on original switches.",
                "thumbnailUrl": "https://img-en.fs.com/file/fs_scene_images/microdata/18.png",
                "uploadDate": "'.$t.'",
                "duration": "T00H00M32S",
                "contentUrl": "https://img-en.fs.com/video/sfp-10g-lr-optical-transceiver.mp4",
                "interactionStatistic":
                    {
                        "@type": "InteractionCounter",
                        "interactionType": { "@type": "http://schema.org/WatchAction" },
                        "userInteractionCount": 2455
                    }
            }
            </script>';
    }elseif((int)$products_id == 35334){
        echo '<script type="application/ld+json">
            {
              "@context": "http://schema.org",
              "@type": "VideoObject",
              "name": "What Is Fiber Optic Media Converter and How to Use It? | FS",
              "description": "This video shows what fiber optic media converters (https://goo.gl/oW8Jpb) can do by converting copper RJ45 port to fiber SFP port. And we simulate how to extend the distances to more than 100 meters between two gigabit Ethernet switches by using mini type fiber to Ethernet media converters. Also there’s a demonstration on the LEP function and the FX 100M function of the mini media converter’s DIP switches. Here’s the mini media converter used in this video: https://www.fs.com/products/35333.html  Other products used in this video: FS S2800-24T4F fanless gigabit Ethernet switch: https://www.fs.com/products/66144.html Cat6 slim Ethernet cable: https://www.fs.com/c/28awg-slim-patch-cables-613 Single mode fiber patch cable: https://www.fs.com/c/os2-9-125-single-mode-duplex-897 Cisco GLC-LH-SM compatible 1000BASE-LX/LH SFP 1310nm 10km transceiver module: https://www.fs.com/products/11775.html  There are also more media converter types for your different use: Mini 2*RJ45 to SFP media converter: https://www.fs.com/products/35334.html  Unmanaged RJ45 to SFP gigabit media converter: https://www.fs.com/products/17237.html  PoE media converter: https://www.fs.com/products/35155.html 10G RJ45 to SFP media converter: https://www.fs.com/products/35610.html",
              "thumbnailUrl": "https://i.ytimg.com/vi/BZ2kb312iQI/default.jpg",
              "uploadDate": "2018-07-05T10:00:03Z",
              "duration": "PT3M2S",
              "embedUrl": "https://www.youtube.com/embed/BZ2kb312iQI",
              "interactionCount": "109208"
            }
            </script>';
    }
    ?>
    <script>
        dataLayer = [{
            'product_ids': <?php echo $products_id; ?>,
            'page_type': 'product',
            'total_value': <?php echo round($products_price_tax, 2); ?>,
            'userId': '<?php echo $userId; ?>',
            'ecommerce': {
                'currencyCode': "<?php echo 'USD' ?>",
                "detail": {
                    "products": [{
                        'id': "<?php echo $products_id; ?>",
                        'name': "<?php echo _zen_get_products_name($products_id); ?>",
                        'price': "<?php echo sprintf("%.2f",$products_price_tax); ?>",
                        'brand': "FS.COM",
                        'category': "<?php echo get_google_products_categories_str($products_id); ?>",
                        'position': 0
                    }]
                }
            }
        }]

    </script>
    <?php $true_or_false = 1;
} ?>
<?php if ($_GET['main_page'] == 'fs_special_page' && $_GET['id']) {
    $id = (int)$_GET['id'];
    if($id == 86){
        echo '<script type="application/ld+json">{
  "@context": "http://schema.org",
  "@type": "VideoObject",
  "name": "How to Use SC/FC/ST/LSH Optical One-Push Pen Cleaner | FS",
  "description": "2.5mm Pen One-Push Cleaner (https://bit.ly/2MkbIGz) is designed for cleaning the ferrule & interface of SC/FC/ST/LSH connectors, with up to 750 cleanings. Simply pushing the cleaner, most contaminants in the connectors can be removed efficiently. This video shows how to use the cleaner to clean SC connector ferrule of a fiber cable, SC connector inside an adapter, and SC fiber optic interface inside a power meter.",
  "thumbnailUrl": "https://i.ytimg.com/vi/5Z8ugpRUcGY/default.jpg",
  "uploadDate": "2019-08-14T10:00:00Z",
  "duration": "PT58S",
  "embedUrl": "https://www.youtube.com/embed/5Z8ugpRUcGY",
  "interactionCount": "1432"
}</script>
<script type="application/ld+json">{
  "@context": "http://schema.org",
  "@type": "VideoObject",
  "name": "Cat5e/Cat6 Patch Panel and Blank Ethernet Patch Panel | FS",
  "description": "Choosing a right patch panel is essential for a nice cable management. This video introduces five basic Cat5e & Cat6 patch panel (https://goo.gl/ZYX19h) provided by FS.COM, and their common applications to help users choose a suitable patch panel for their network cabling, such as shielded or unshielded patch panel, 24-port or 48-port keystone patch panel, etc.   For more information, please visit: Patch panel: https://www.fs.com/c/patch-panels-accessories-1097 Cat5e & Cat6 patch cable: https://www.fs.com/c/cat5e-cat6-cat7-904",
  "thumbnailUrl": "https://i.ytimg.com/vi/iBE5l-mGeWM/default.jpg",
  "uploadDate": "2018-04-26T10:02:29Z",
  "duration": "PT1M41S",
  "embedUrl": "https://www.youtube.com/embed/iBE5l-mGeWM",
  "interactionCount": "54413"
}</script>
<script type="application/ld+json">{
  "@context": "http://schema.org",
  "@type": "VideoObject",
  "name": "How to Use Optical Light Source and Power Meter | FS",
  "description": "This video introduces how to operate the optical power meter (https://goo.gl/iPDhEZ) and optical light source (https://goo.gl/CNvq27), and shows how to test fiber insertion loss with the two fiber optic testers.    Optical power meter and optical light source are often used together to measure fiber optic loss, check fiber link continuity and quality. FS provides a series of optical powers and fiber optic light sources equipped with 2.5mm+FC+SC+ST adapters for convenient testing.",
  "thumbnailUrl": "https://i.ytimg.com/vi/aMn57mozMlA/default.jpg",
  "uploadDate": "2018-07-24T10:00:00Z",
  "duration": "PT2M",
  "embedUrl": "https://www.youtube.com/embed/aMn57mozMlA",
  "interactionCount": "32283"
}</script>';
    }
}?>
<?php if ($_GET['main_page'] == 'address_book_guest' || $_GET['main_page'] == 'shopping_cart') { ?>
    <?php if (!empty($_SESSION['cart'])) {
        $productsInfo = $productsInfo?$productsInfo:$_SESSION['cart']->get_products();

        foreach ($productsInfo as $v) {
            $attributeIds[] = $v['id'];
            $productsMoney += $v['products_price'] * $v['quantity'];
            if (!count($v['id']) > 8) {
                $productsInfoId .= "'" . $v['id'] . "'" . ',';
            } else {
                $arr = explode(':', $v['id']);
                $productsInfoId .= "'" . $arr[0] . "'" . ',';
            }
        }
        $productsInfoIds = substr($productsInfoId, 0, strlen($productsInfoId) - 1);
        ?>
        <script> dataLayer = [{
                'product_ids': [<?php echo $productsInfoIds;?>],
                'page_type': 'cart',
                'total_value': <?php echo round($productsMoney, 2) ? round($productsMoney, 2) : 0; ?>,
                'userId': '<?php echo $userId; ?>',
            }]</script>
        <?php $true_or_false = 1;
    } ?>
<?php } ?>
<?php if ($_GET['main_page'] == 'checkout' || $_GET['main_page'] == 'checkout_guest') { ?>
    <?php if (!empty($_SESSION['cart'])) {
        $productsInfo = $productsInfo?$productsInfo:$_SESSION['cart']->get_products();
        foreach ($productsInfo as $v) {
            $attributeIds[] = $v['id'];
            $productsMoney += $v['products_price'] * $v['quantity'];
            if (!count($v['id']) > 8) {
                $productsInfoId .= "'" . $v['id'] . "'" . ',';
            } else {
                $arr = explode(':', $v['id']);
                $productsInfoId .= "'" . $arr[0] . "'" . ',';
            }
        }
        $productsInfoIds = substr($productsInfoId, 0, strlen($productsInfoId) - 1);
        $product_info = array();
        foreach($productsInfo as $k => $v){
            //$categories = $db->getAll('select * from products_to_categories WHERE products_id='.$v['id']);
            //$cPath_array = (array_reverse(get_category_parent_id($v['category'],array())));
            $product_info[$k]['name'] = $v['name'];
            $product_info[$k]['id'] = $v['id'];
            $product_info[$k]['price'] = $v['price'];
            $product_info[$k]['brand'] = '';
            //只获取2级分类
            //$product_info[$k]['category'] = $cPath_array[1];
            $product_info[$k]['variant'] = '';
            $product_info[$k]['quantity'] = $v['quantity'];
        }
        ?>
        <script> dataLayer = [{
                'product_ids': [<?php echo $productsInfoIds;?>],
                'page_type': 'cart',
                'total_value': <?php echo round($productsMoney, 2); ?>,
                'userId': '<?php echo $userId; ?>',
                'event': 'checkout',
                'ecommerce': {
                    'currencyCode': 'USD',
                    'checkout': {
                        'actionField': {'step': 1},
                        'products': [
                            <?php foreach($product_info as $single_pro){
                            ?>
                            {'name': '<?php echo str_replace(["'","\""],['&quot;','&quot;'],$single_pro['name']);?>',
                                'id': '<?php echo $single_pro['id']?>',
                                'price': '<?php echo $single_pro['price'];?>',
                                'brand': 'FS.COM',
                                'category': '<?php echo get_google_products_categories_str($single_pro['id']);?>',
                                'quantity':  <?php echo $single_pro['quantity'] ? $single_pro['quantity'] : 0;?>,},
                            <?php } ?>
                        ]
                    }
                }
            }]
        </script>
        <?php $true_or_false = 1;
    } ?>
<?php } ?>
<?php if ($_GET['main_page'] == 'checkout_success') {
    $customer_id = 0;
    ?>
    <?php if ($order_summary_number) { ?>
        <?php if (!empty($_SESSION['customer_id'])) {
            $ordersInfo = $db->getAll("select orders_id,main_order_id,customers_id,currency,currency_value from orders where orders_number = '" . $order_summary_number . "'order by orders_id DESC limit 1 ");
            $customer_id = $userId;
        } else {
            if (!empty($_SESSION['customers_guest_id'])) {
                $ordersInfo = $db->getAll("select orders_id,main_order_id,customers_id,currency,currency_value from orders where orders_number = '" . $order_summary_number . "'order by orders_id DESC limit 1 ");
                $customer_id = 'g' . $_SESSION['customers_guest_id'];
            }

        }
        if ($ordersInfo[0]['main_order_id'] >= 1) {
			if($ordersInfo[0]['main_order_id'] == 1){
				$orders_id = $ordersInfo[0]['orders_id'];
			}else{
				$orders_id = $ordersInfo[0]['main_order_id'];
			}
            $main_order_id = 1;
            $list = $db->getAll("select orders_id FROM orders WHERE main_order_id = '" . $orders_id . "'");

            $orders_arr = array();
            if ($list) {
                foreach ($list as $v) {
                    $orders_arr[] = $v['orders_id'];
                }
            }
            if ($orders_arr) {
                $where = " WHERE orders_id IN (" . implode(',', $orders_arr) . ")";
            }

        } else {
            $orders_id = $ordersInfo[0]['orders_id'];
            $main_order_id = 0;
            $where = " WHERE  orders_id = '" . $orders_id . "'";
        }

        if (!empty($ordersInfo)) {

            $ordersProduct = $db->getAll("select `orders_id`,`final_price`,`products_quantity`,`products_id` from orders_products  " . $where);

            $ordersMoney = $db->getAll("select value from orders_total where orders_id = '" . $orders_id . "and title = Total:' order by orders_total_id DESC limit 1 ");
        }


        foreach ($ordersProduct as $v) {
            $attributeIds[] = $v['products_id'];
            if (!count($v['products_id']) > 8) {
                $productsInfoId .= $v['products_id'] . ',';
            } else {
                $arr = explode(':', $v['products_id']);
                $productsInfoId .= "'" . $arr[0] . "'" . ',';
            }
        }
        $productsInfoIds = substr($productsInfoId, 0, strlen($productsInfoId) - 1);
        $currency = $ordersInfo[0]['currency'];
        $currency_value = $ordersInfo[0]['currency_value'];

        $cost_data = zen_get_order_value_by_order($orders_id);
        ?>

        <script>
            dataLayer = [{
                'product_ids': [<?php echo $productsInfoIds; ?>],
                'page_type': 'purchase',
                'currency': '<?php echo 'USD'; ?>',
                'total_value': <?php echo zen_round(zen_get_customer_lasted_order_total_of_id($orders_id), 2) ? zen_round(zen_get_customer_lasted_order_total_of_id($orders_id) , 2) : 0;?>,
				'userId': '<?php echo $customer_id; ?>',
				'orderId': '<?php echo $orders_id; ?>',
                'website': '<?php echo $_SESSION['languages_code'] == 'en' ?  'us' : ($_SESSION['languages_code'] == 'dn' ? 'de-en' : $_SESSION['languages_code']); ?>',
                'ecommerce': {
                    'currencyCode':'<?php echo 'USD'; ?>',
                    'purchase': {
                        'actionField': {
                            'id': '<?php echo $orders_id; ?>',
                            'affiliation': 'Online Store',
                            'revenue': <?php echo zen_round(zen_get_customer_lasted_order_total_of_id($orders_id) , 2) ? zen_round(zen_get_customer_lasted_order_total_of_id($orders_id) , 2) : 0;?>,
                            'tax':  <?php echo $cost_data['ot_tax'] ? $cost_data['ot_tax'] : 0;?>,
                            'shipping': <?php echo zen_round(zen_get_orders_shipping_total($orders_id) , 2) ? zen_round(zen_get_orders_shipping_total($orders_id) , 2) : 0;  ?>,
                        },
                        'products': [
                            <?php
                            //$items = zen_get_order_products_of_id($orders_id);
                            $i = 0;
                            $size = count($ordersProduct);
                            foreach ($ordersProduct as $itemId => $item){
                            $i++;
                            $categories = $db->getAll('select * from products_to_categories WHERE products_id='.(int)$item['products_id']);
                            $current_categories = $categories[0]['categories_id'];
                            $cPath_array = (array_reverse(get_category_parent_id($current_categories,array())));
                            //二级分类
                            $categories_second = $cPath_array[1];
							$cate_name =  zen_get_category_name($categories_second,1);
							$product_query = "select products_name
							from  products_description
							where products_id = '" . $item['products_id'] . "'
							and language_id = 1 ";
							$product = $db->Execute($product_query);
							$products_name = $product->fields['products_name'];
                            ?>
                            {
                                'name': '<?php echo str_replace("'",'&quot;',$products_name);?>',
                                'id': '<?php echo $item['products_id'];?>',
                                'price': <?php echo round($item['final_price'] , 2) ? round($item['final_price'] , 2) : 0; ?>,
                                'brand': 'FS.COM',
                                'category': '<?php echo $cate_name;?>',
                                'quantity': <?php echo $item['products_quantity'] ? $item['products_quantity'] : 0; ?>,
                            }
                            <?php
                            if ($size != $i) {
                                echo ',';
                            }
                            }
                            ?>
                        ]
                    }

                }
            }]
        </script>

    <?php } ?>

    <?php
    $admitad_uid_status = false;
    if (isset($_COOKIE['admitad_uid']) && !empty($_COOKIE['admitad_uid']) && $admitad_uid_status == true) { ?>
        <script type="text/javascript">
            (function (d, w) {
                w._admitadPixel = {
                    response_type: 'img',     // 'script' or 'img'. Default: 'img'
                    action_code: '1',
                    campaign_code: '863557c804'
                };
                w._admitadPositions = w._admitadPositions || [];
                <?php $position_count = count($ordersProduct); ?>
                <?php foreach ($ordersProduct as $v){?>
                w._admitadPositions.push({
                    uid: '<?php echo $_COOKIE['admitad_uid'];?>',
                    tariff_code: '1',
                    order_id: '<?php echo $v['orders_id'];?>',
                    position_id: <?php echo $k += '1';?>,
                    currency_code: '<?php echo $_SESSION['currency']?>',
                    position_count: <?php echo $position_count; ?>,
                    price: '<?php echo $v['final_price']?>',
                    quantity: '<?php echo $v['products_quantity']?>',
                    product_id: '<?php echo $v['products_id']?>',
                    client_id: '<?php echo $ordersInfo[0]['customers_id']; ?>',
                    old_consumer: '1',
                    payment_type: 'sale'
                });
                <?php }?>

                var id = '_admitad-pixel';
                if (d.getElementById(id)) {
                    return;
                }
                var s = d.createElement('script');
                s.id = id;
                var r = (new Date).getTime();
                var protocol = (d.location.protocol === 'https:' ? 'https:' : 'http:');
                s.src = protocol + '//cdn.asbmit.com/static/js/npixel.js?r=' + r;
                var head = d.getElementsByTagName('head')[0];
                head.appendChild(s);
            })(document, window)
        </script>
        <noscript>
            <?php foreach ($ordersProduct as $k => $v) { ?>
                <img src="//ad.admitad.com/r?campaign_code=863557c804&action_code=1&old_consumer=1&client_id=<?php echo $ordersInfo[0]['customers_id']; ?>&payment_type=sale&response_type=img&uid=&tariff_code=1&order_id=<?php echo $v['orders_id']; ?>&position_id=<?php echo $k += '1'; ?>&currency_code=<?php echo $_SESSION['currency'] ?>&position_count=<?php echo $position_count; ?>&price=<?php echo $v['final_price'] ?>&quantity=<?php echo $v['products_quantity'] ?>&product_id=<?php echo $v['products_id'] ?>"
                     width="1" height="1" alt="">
            <?php } ?>
        </noscript>
    <?php } ?>
    <?php $true_or_false = 1;
} ?>
<?php if (!empty($_GET['cPath'])) { ?>
    <script>
        dataLayer = [{
            'page_type': 'category',
            'userId': '<?php echo $userId; ?>',
        }]
    </script>
    <?php $true_or_false = 1;
} ?>
<?php if ($_GET[main_page] == 'advanced_search_result') { ?>
    <script>
        dataLayer = [{
            'page_type': 'searchresults',
            'userId': '<?php echo $userId; ?>',
        }]
    </script>
    <?php $true_or_false = 1;
} ?>
<?php if (empty($true_or_false)) { ?>
    <script>
        dataLayer = [{
            'page_type': 'other',
            'userId': '<?php echo $userId; ?>',
        }]
    </script>
<?php } ?>

<?php if (!german_warehouse('country_code', $_SESSION['countries_iso_code']) || (!isset($_COOKIE['fs_google_analytics']) || $_COOKIE['fs_google_analytics'] != 'no')){?>
<?php //if($_SERVER['HTTP_HOST']=="www.fs.com"){  //只在线上加Google代码?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-PBGKN3');</script>
<!-- End Google Tag Manager -->
<?php //}?>
<?php }?>
<script>
    function setTab(e, t, n) {
        for (i = 1; i <= n; i++) {
            var r = document.getElementById(e + i);
            var s = document.getElementById("con_" + e + "_" + i);
            r.className = i == t ? "hover" : "";
            s.style.display = i == t ? "block" : "none"
        }
    }

    function checkEmailAddress(email) {
        return /^[0-9A-Za-z][\w\.\-\+]*\@[\w\.\-\+]+\.[\w\.\-]+[A-Za-z]$/.test(email.replace(/-|\//g, ''))
    };

    function isNumber(String) {
        var Letters = "1234567890-";
        var i, c;
        if (String.charAt(0) == '-') return false;
        if (String.charAt(String.length - 1) == '-') return false;
        for (i = 0; i < String.length; i++) {
            c = String.charAt(i);
            if (Letters.indexOf(c) < 0) return false
        }
        return true
    }

</script>

<?php if ($this_is_home_page) {
    $description = 'FS is a new brand in Data Center, Enterprise, Telecom Solutions. We make it easy and cost-effective for IT professionals to enable their business solutions.';
    switch ($_SESSION['languages_code']) {
        case 'sg':
            echo '
  <script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@id": "https://www.fs.com/#organization",
		"@type": "Organization",
		"name": "FS",
		"url": "https://www.fs.com/",
		"logo": "https://img-en.fs.com/includes/templates/fiberstore/images/new-pc-img/fs-logo-pc.png",
		"description": "'.$description.'",
		"contactPoint": [
			{
				"@type": "ContactPoint",
				"telephone": "+1-888-468-7419",
				"contactType": "customer service",
				"areaServed": "US"
			},
			{
				"@type": "ContactPoint",
				"telephone": "+1-647-243-6342",
				"contactType": "customer service",
				"areaServed": "CA"
			}
		],
		"sameAs": [
			"https://www.instagram.com/fscom_official/",
			"https://www.linkedin.com/company/fscomofficial/",
			"https://www.youtube.com/c/fscom_official/videos",
			"https://www.facebook.com/FSCOMofficial/",
			"https://twitter.com/FSCOM_official"
		]
	}
</script>
<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@id": "https://www.fs.com/sg/#webpage",
		"@type": "WebPage",
		"url": "https://www.fs.com/sg/",
		"name": "FS Singapore"
	}
</script>
    ';
            break;
        case 'au':
            echo '
   <script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@id": "https://www.fs.com/#organization",
		"@type": "Organization",
		"name": "FS",
		"url": "https://www.fs.com/",
		"logo": "https://img-en.fs.com/includes/templates/fiberstore/images/new-pc-img/fs-logo-pc.png",
		"description": "'.$description.'",
		"contactPoint": [
			{
				"@type": "ContactPoint",
				"telephone": "+1-888-468-7419",
				"contactType": "customer service",
				"areaServed": "US"
			},
			{
				"@type": "ContactPoint",
				"telephone": "+1-647-243-6342",
				"contactType": "customer service",
				"areaServed": "CA"
			}
		],
		"sameAs": [
			"https://www.instagram.com/fscom_official/",
			"https://www.linkedin.com/company/fscomofficial/",
			"https://www.youtube.com/c/fscom_official/videos",
			"https://www.facebook.com/FSCOMofficial/",
			"https://twitter.com/FSCOM_official"
		]
	}
</script>	
<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@id": "https://www.fs.com/au/#webpage",
		"@type": "WebPage",
		"url": "https://www.fs.com/au/",
		"name": "FS Australia"
	}
</script>';
            break;
        case 'uk':
            echo '
   <script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@id": "https://www.fs.com/#organization",
		"@type": "Organization",
		"name": "FS",
		"url": "https://www.fs.com/",
		"logo": "https://img-en.fs.com/includes/templates/fiberstore/images/new-pc-img/fs-logo-pc.png",
		"description": "'.$description.'",
		"contactPoint": [
			{
				"@type": "ContactPoint",
				"telephone": "+1-888-468-7419",
				"contactType": "customer service",
				"areaServed": "US"
			},
			{
				"@type": "ContactPoint",
				"telephone": "+1-647-243-6342",
				"contactType": "customer service",
				"areaServed": "CA"
			}
		],
		"sameAs": [
			"https://www.instagram.com/fscom_official/",
			"https://www.linkedin.com/company/fscomofficial/",
			"https://www.youtube.com/c/fscom_official/videos",
			"https://www.facebook.com/FSCOMofficial/",
			"https://twitter.com/FSCOM_official"
		]
	}
</script>
<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@id": "https://www.fs.com/uk/#webpage",
		"@type": "WebPage",
		"url": "https://www.fs.com/uk/",
		"name": "FS United Kingdom"
	}
</script>
    ';
            break;
        case 'fr':
            echo '
   <script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@id": "https://www.fs.com/#organization",
		"@type": "Organization",
		"name": "FS",
		"url": "https://www.fs.com/",
		"logo": "https://img-en.fs.com/includes/templates/fiberstore/images/new-pc-img/fs-logo-pc.png",
		"description": "'.$description.'",
		"contactPoint": [
			{
				"@type": "ContactPoint",
				"telephone": "+1-888-468-7419",
				"contactType": "customer service",
				"areaServed": "US"
			},
			{
				"@type": "ContactPoint",
				"telephone": "+1-647-243-6342",
				"contactType": "customer service",
				"areaServed": "CA"
			}
		],
		"sameAs": [
			"https://www.instagram.com/fscom_official/",
			"https://www.linkedin.com/company/fscomofficial/",
			"https://www.youtube.com/c/fscom_official/videos",
			"https://www.facebook.com/FSCOMofficial/",
			"https://twitter.com/FSCOM_official"
		]
	}
</script>
<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@id": "https://www.fs.com/fr/#webpage",
		"@type": "WebPage",
		"url": "https://www.fs.com/fr/",
		"name": "FS France"
	}
</script>
    ';
            break;
        case 'mx':
            echo '
   <script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@id": "https://www.fs.com/#organization",
		"@type": "Organization",
		"name": "FS",
		"url": "https://www.fs.com/",
		"logo": "https://img-en.fs.com/includes/templates/fiberstore/images/new-pc-img/fs-logo-pc.png",
		"description": "'.$description.'",
		"contactPoint": [
			{
				"@type": "ContactPoint",
				"telephone": "+1-888-468-7419",
				"contactType": "customer service",
				"areaServed": "US"
			},
			{
				"@type": "ContactPoint",
				"telephone": "+1-647-243-6342",
				"contactType": "customer service",
				"areaServed": "CA"
			}
		],
		"sameAs": [
			"https://www.instagram.com/fscom_official/",
			"https://www.linkedin.com/company/fscomofficial/",
			"https://www.youtube.com/c/fscom_official/videos",
			"https://www.facebook.com/FSCOMofficial/",
			"https://twitter.com/FSCOM_official"
		]
	}
</script>
	
	<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@id": "https://www.fs.com/mx/#webpage",
		"@type": "WebPage",
		"url": "https://www.fs.com/mx/",
		"name": "FS México"
	}
</script>
    ';
            break;
        case 'es':
            echo '
   <script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@id": "https://www.fs.com/#organization",
		"@type": "Organization",
		"name": "FS",
		"url": "https://www.fs.com/",
		"logo": "https://img-en.fs.com/includes/templates/fiberstore/images/new-pc-img/fs-logo-pc.png",
		"description": "'.$description.'",
		"contactPoint": [
			{
				"@type": "ContactPoint",
				"telephone": "+1-888-468-7419",
				"contactType": "customer service",
				"areaServed": "US"
			},
			{
				"@type": "ContactPoint",
				"telephone": "+1-647-243-6342",
				"contactType": "customer service",
				"areaServed": "CA"
			}
		],
		"sameAs": [
			"https://www.instagram.com/fscom_official/",
			"https://www.linkedin.com/company/fscomofficial/",
			"https://www.youtube.com/c/fscom_official/videos",
			"https://www.facebook.com/FSCOMofficial/",
			"https://twitter.com/FSCOM_official"
		]
	}
</script>	
<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@id": "https://www.fs.com/es/#webpage",
		"@type": "WebPage",
		"url": "https://www.fs.com/es/",
		"name": "FS España"
	}
</script>
    ';
            break;
        case 'jp':
            echo '
  <script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@id": "https://www.fs.com/#organization",
		"@type": "Organization",
		"name": "FS",
		"url": "https://www.fs.com/",
		"logo": "https://img-en.fs.com/includes/templates/fiberstore/images/new-pc-img/fs-logo-pc.png",
		"description": "'.$description.'",
		"contactPoint": [
			{
				"@type": "ContactPoint",
				"telephone": "+1-888-468-7419",
				"contactType": "customer service",
				"areaServed": "US"
			},
			{
				"@type": "ContactPoint",
				"telephone": "+1-647-243-6342",
				"contactType": "customer service",
				"areaServed": "CA"
			}
		],
		"sameAs": [
			"https://www.instagram.com/fscom_official/",
			"https://www.linkedin.com/company/fscomofficial/",
			"https://www.youtube.com/c/fscom_official/videos",
			"https://www.facebook.com/FSCOMofficial/",
			"https://twitter.com/FSCOM_official"
		]
	}
</script>
<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@id": "https://www.fs.com/jp/#webpage",
		"@type": "WebPage",
		"url": "https://www.fs.com/jp/",
		"name": "FS 日本"
	}
</script>';
            break;
        case 'ru':
            echo '
   <script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@id": "https://www.fs.com/#organization",
		"@type": "Organization",
		"name": "FS",
		"url": "https://www.fs.com/",
		"logo": "https://img-en.fs.com/includes/templates/fiberstore/images/new-pc-img/fs-logo-pc.png",
		"description": "'.$description.'",
		"contactPoint": [
			{
				"@type": "ContactPoint",
				"telephone": "+1-888-468-7419",
				"contactType": "customer service",
				"areaServed": "US"
			},
			{
				"@type": "ContactPoint",
				"telephone": "+1-647-243-6342",
				"contactType": "customer service",
				"areaServed": "CA"
			}
		],
		"sameAs": [
			"https://www.instagram.com/fscom_official/",
			"https://www.linkedin.com/company/fscomofficial/",
			"https://www.youtube.com/c/fscom_official/videos",
			"https://www.facebook.com/FSCOMofficial/",
			"https://twitter.com/FSCOM_official"
		]
	}
</script>
<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@id": "https://www.fs.com/ru/#webpage",
		"@type": "WebPage",
		"url": "https://www.fs.com/ru/",
		"name": "FS Россия"
	}
</script>';
            break;
        case 'de':
            echo '
            <script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@id": "https://www.fs.com/#organization",
		"@type": "Organization",
		"name": "FS",
		"url": "https://www.fs.com/",
		"logo": "https://img-en.fs.com/includes/templates/fiberstore/images/new-pc-img/fs-logo-pc.png",
		"description": "'.$description.'",
		"contactPoint": [
			{
				"@type": "ContactPoint",
				"telephone": "+1-888-468-7419",
				"contactType": "customer service",
				"areaServed": "US"
			},
			{
				"@type": "ContactPoint",
				"telephone": "+1-647-243-6342",
				"contactType": "customer service",
				"areaServed": "CA"
			}
		],
		"sameAs": [
			"https://www.instagram.com/fscom_official/",
			"https://www.linkedin.com/company/fscomofficial/",
			"https://www.youtube.com/c/fscom_official/videos",
			"https://www.facebook.com/FSCOMofficial/",
			"https://twitter.com/FSCOM_official"
		]
	}
</script>	
<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@id": "https://www.fs.com/de/#webpage",
		"@type": "WebPage",
		"url": "https://www.fs.com/de/",
		"name": "FS Deutschland"
	}
</script>
            ';
            break;
        case 'dn':
            echo '
            <script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@id": "https://www.fs.com/#organization",
		"@type": "Organization",
		"name": "FS",
		"url": "https://www.fs.com/",
		"logo": "https://img-en.fs.com/includes/templates/fiberstore/images/new-pc-img/fs-logo-pc.png",
		"description": "'.$description.'",
		"contactPoint": [
			{
				"@type": "ContactPoint",
				"telephone": "+1-888-468-7419",
				"contactType": "customer service",
				"areaServed": "US"
			},
			{
				"@type": "ContactPoint",
				"telephone": "+1-647-243-6342",
				"contactType": "customer service",
				"areaServed": "CA"
			}
		],
		"sameAs": [
			"https://www.instagram.com/fscom_official/",
			"https://www.linkedin.com/company/fscomofficial/",
			"https://www.youtube.com/c/fscom_official/videos",
			"https://www.facebook.com/FSCOMofficial/",
			"https://twitter.com/FSCOM_official"
		]
	}
</script>	
<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@id": "https://www.fs.com/de-en/#webpage",
		"@type": "WebPage",
		"url": "https://www.fs.com/de-en/",
		"name": "FS Germany"
	}
</script>
            ';
            break;
        default:
            echo '
   <script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@id": "https://www.fs.com/#organization",
		"@type": "Organization",
		"name": "FS",
		"url": "https://www.fs.com/",
		"logo": "https://img-en.fs.com/includes/templates/fiberstore/images/new-pc-img/fs-logo-pc.png",
		"description": "'.$description.'",
		"contactPoint": [
			{
				"@type": "ContactPoint",
				"telephone": "+1-888-468-7419",
				"contactType": "customer service",
				"areaServed": "US"
			},
			{
				"@type": "ContactPoint",
				"telephone": "+1-647-243-6342",
				"contactType": "customer service",
				"areaServed": "CA"
			}
		],
		"sameAs": [
			"https://www.instagram.com/fscom_official/",
			"https://www.linkedin.com/company/fscomofficial/",
			"https://www.youtube.com/c/fscom_official/videos",
			"https://www.facebook.com/FSCOMofficial/",
			"https://twitter.com/FSCOM_official"
		]
	}
</script>	
<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@id": "https://www.fs.com/#website",
		"@type": "WebSite",
		"url": "https://www.fs.com/",
		"name": "FS",
		"potentialAction": {
			"@type": "SearchAction",
			"target": "https://www.fs.com/?main_page=advanced_search_result&keyword={search_term}&source=ggl_sitelinks_searchbox",
			"query-input": "required name=search_term"
		}
	}
</script>
<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@id": "https://www.fs.com/#webpage",
		"@type": "WebPage",
		"url": "https://www.fs.com/",
		"name": "FS"
	}
</script>
    ';
            break;
    }

}?>