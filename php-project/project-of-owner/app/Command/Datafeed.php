<?php
require_once 'CommandBaseRequired.php';
require_once './includes/application_top.php';

use App\Models\Product as ProductsModel;

$ProductsModel = new ProductsModel();
if (time() > 1609455599){ //柏林2020-12-31 23：59：59时间戳
    $vax_num = 0.19;
} else {
    $vax_num = 0.16;
}
$countries_iso_code = array(
    array('country' => 'US','file_name' => 'us', 'vat' => 0, 'currency' => 'USD'),
    array('country' => 'CA','file_name' => 'ca', 'vat' => 0, 'currency' => 'CAD'),
    array('country' => 'MX','file_name' => 'mx', 'vat' => 0, 'currency' => 'MXN'),
    //相同文件的，则只抄一个就行了。
    array('country' => 'DE','file_name' => 'de-in', 'vat' => $vax_num, 'currency' => 'EUR'),
    array('country' => 'CH','file_name' => 'ch', 'vat' => 0, 'currency' => 'CHF'),
    array('country' => 'FR','file_name' => 'fr', 'vat' => 0.2, 'currency' => 'EUR'),
    array('country' => 'NO','file_name' =>'no', 'vat' => 0, 'currency' => 'NOK'),
    array('country' => 'UK','file_name' => 'uk', 'vat' => 0.20, 'currency' => 'GBP'),
    array('country' => 'SE','file_name' => 'se', 'vat' => 0.25, 'currency' => 'SEK'),
    array('country' => 'IT','file_name' => 'it', 'vat' => 0.22, 'currency' => 'EUR'),
    array('country' => 'NL','file_name' => 'nl','vat' => 0.21, 'currency' => 'EUR'),
    array('country' => 'DK','file_name' => 'dk', 'vat' => 0.25, 'currency' => 'DKK'),
    array('country' => 'SG','file_name' => 'sg-in', 'vat' => 0.07, 'currency' => 'SGD'),
    array('country' => 'MY','file_name' => 'my', 'vat' => 0, 'currency' => 'MYR'),
    array('country' => 'ID','file_name' => 'sg-ex', 'vat' => 0, 'currency' => 'USD'),
    array('country' => 'IN','file_name' => 'asia', 'vat' => 0, 'currency' => 'USD'),
    array('country' => 'HK','file_name' => 'hk', 'vat' => 0, 'currency' => 'HKD'),
    array('country' => 'BR','file_name' => 'br', 'vat' => 0, 'currency' => 'BRL'),
    array('country' => 'JP','file_name' => 'jp', 'vat' => 0, 'currency' => 'JPY'),
    array('country' => 'RU','file_name' => 'ru', 'vat' => 0.20, 'currency' => 'RUB'),
    array('country' => 'AU','file_name' => 'au','vat' => 0.10, 'currency' => 'AUD'),
    array('country' => 'NZ','file_name' =>'nz', 'vat' => 0, 'currency' => 'NZD'),

);


$products = $ProductsModel->where('products_type', '!=', 4)->where('products_type', '!=', 5)->where('show_type', '=', 0)->where('products_status', '=', 1)->select(['products_id', 'products_image', 'products_price', 'de_status', 'cn_status', 'sg_status', 'ru_status', 'au_status', 'us_status'])->get()->toArray();

foreach ($countries_iso_code as $key => $value) {
    $warehouse = get_warehouse_by_code($value['country']);

    switch ($warehouse) {
        case 'de':
            $status = 'de_status';
            break;
        case 'cn':
            $status = 'cn_status';
            break;
        case 'au':
            $status = 'au_status';
            break;
        case 'sg':
            $status = 'sg_status';
            break;
        case 'ru':
            $status = 'ru_status';
            break;
        case 'us':
            $status = 'us_status';
            break;
    }

    $temp_products = [];
    if (isset($status) && $status) {
        foreach ($products as $k => $product) {
            if ($product[$status] == 1) {
                $temp_products[] = array(
                    'id'  => $product['products_id'],
                    'price' => $product['products_price'],
                    'products_image' => $product['products_image']
                );
            }
        }
    }
    $value['products'] = $temp_products;
    $countries_iso_code[$key] = $value;
}

$currencies = new \currencies();
foreach ($countries_iso_code as $key => $value) {
    $dom = new \DOMDocument('1.0', 'utf-8');//建立DOM对象
    $no1 = $dom->createElement('rss');//创建普通节点：rss
    $dom->appendChild($no1);
    $no2 = $dom->createAttribute('xmlns:g');
    $no2->value = 'http://base.google.com/ns/1.0';
    $no1->appendChild($no2);
    $no55 = $dom->createAttribute('version');
    $no55->value = '2.0';
    $no1->appendChild($no55);


    $no3 = $dom->createElement('channel');//创建普通节点：channel
    $no1->appendChild($no3);//把channel节点加入到DOM文档中

    $no4 = $dom->createElement('title');
    $no3->appendChild($no4);
    $no5 = $dom->createTextNode($title_name);
    $no4->appendChild($no5);

    $no6 = $dom->createElement('link');
    $no3->appendChild($no6);
    $no7 = $dom->createTextNode('http://www.fs.com');
    $no6->appendChild($no7);


    $currency = $value['currency'];


    //每个产品的信息
    foreach ($value['products'] as $k => $product) {
        if ($product['products_image']) {
            $images = "https://img-en.fs.com/images/".$product['products_image'];
            $images = str_replace([','], ['%2C'], $images);
        } else {
            $images = "";
        }

        //同步详情页中产品价格
        $options_value = [];
        if ($countries_iso_code == 'UK' || $currency == 'GBP') {
            $_SESSION['languages_code'] = 'uk';
        }

        $product_price = zen_get_products_final_price((int)$product['id'], $currency, $options_value, false);

        $taxPriceText = $product_price * (1 + $value['vat']);

        $taxPriceText = $currencies->total_format($taxPriceText, true, $currency);

        $taxPriceText = str_replace(['&nbsp;', '₽', '€', '円'], [' ', 'RUB', 'EUR', ' JPY'], $taxPriceText);
        if ($value['country'] == 'FI') {
            $taxPriceText = str_replace(['.'], [''], $taxPriceText);
        } else {
            if (($value['country'] == 'RU') && substr_count($taxPriceText, ' ') > 1) {
                $taxPriceText = preg_replace('/\s/', '', $taxPriceText, 1);
            }
        }

        switch ($value['country']) {
            case 'US':
                $taxPriceText = preg_replace('/(US\$)\s?([\d,\.]+)/', '$2 '.$currency, $taxPriceText);
                $taxPriceText = str_replace(',', '', $taxPriceText);
                break;
            case 'CA':
                $taxPriceText = preg_replace('/(C\$)\s?([\d,\.]+)/', '$2 '.$currency, $taxPriceText);
                $taxPriceText = str_replace(',', '', $taxPriceText);

                break;
            case 'MX':
                $taxPriceText = preg_replace('/(MXN\$)\s?([\d,\.]+)/', '$2 '.$currency, $taxPriceText);
                $taxPriceText = str_replace(',', '', $taxPriceText);
                break;

            case 'CH':
                $taxPriceText = preg_replace('/(CHF)\s?([\d,\.]+)/', '$2 '.$currency, $taxPriceText);
                $taxPriceText = str_replace(',', '', $taxPriceText);

                break;

            case 'FR':
            case 'ES':
            case 'PT':
                //$taxPriceText = preg_replace('/(CHF)\s?([\d,\.]+)/', '$2 '.$currency, $taxPriceText);
                break;
            case 'NO':
                //$taxPriceText = preg_replace('/(&pound;)\s?([\d,\.]+)/', '$2 '.$currency, $taxPriceText);
                $taxPriceText = str_replace(',', '', $taxPriceText);
                break;
            case 'DK':
                $taxPriceText = str_replace(',', '', $taxPriceText);
                break;
            case 'JP':
                $taxPriceText = str_replace(',', '', $taxPriceText);
                break;
            case 'SE':
                $taxPriceText = str_replace(',', '', $taxPriceText);
                break;
            case 'UK':
                $taxPriceText = preg_replace('/(&pound;)\s?([\d,\.]+)/', '$2 '.$currency, $taxPriceText);
                $taxPriceText = str_replace(',', '', $taxPriceText);

                break;

            case 'SG':
                $taxPriceText = preg_replace('/(S\$)\s?([\d,\.]+)/', '$2 '.$currency, $taxPriceText);
                $taxPriceText = str_replace(',', '', $taxPriceText);

                break;

            case 'MY':
                $taxPriceText = preg_replace('/(RM)\s?([\d,\.]+)/', '$2 '.$currency, $taxPriceText);
                $taxPriceText = str_replace(',', '', $taxPriceText);

                break;
            case 'ID':
            case 'VN':
            case 'TH':
            case 'IN':
            case 'AE':
            case 'ZA':
            case 'TW':
                $taxPriceText = preg_replace('/(US\$)\s?([\d,\.]+)/', '$2 '.$currency, $taxPriceText);
                $taxPriceText = str_replace(',', '', $taxPriceText);
                break;
            case 'HK':
                $taxPriceText = preg_replace('/(HK\$)\s?([\d,\.]+)/', '$2 '.$currency, $taxPriceText);
                $taxPriceText = str_replace(',', '', $taxPriceText);

                break;
            case 'BR':
                $taxPriceText = preg_replace('/(R\$)\s?([\d,\.]+)/', '$2 '.$currency, $taxPriceText);
                $taxPriceText = str_replace(',', '', $taxPriceText);

                break;
            case 'AU':
                $taxPriceText = preg_replace('/(A\$)\s?([\d,\.]+)/', '$2 '.$currency, $taxPriceText);
                $taxPriceText = str_replace(',', '', $taxPriceText);

                break;
            case 'NZ':
                $taxPriceText = preg_replace('/(NZ\$)\s?([\d,\.]+)/', '$2 '.$currency, $taxPriceText);
                $taxPriceText = str_replace(',', '', $taxPriceText);

                break;
        }
        if ($currency == 'EUR') {
            $taxPriceText = str_replace('.', '', $taxPriceText);
        }


        $no8 = $dom->createElement('item');
        $no3->appendChild($no8);

        $no9 = $dom->createElement('g:id');
        $no8->appendChild($no9);
        $no10 = $dom->createTextNode($product['id']);
        $no9->appendChild($no10);

        $no11 = $dom->createElement('g:price');
        $no12 = $dom->createTextNode($taxPriceText);
        $no11->appendChild($no12);
        $no8->appendChild($no11);


        $no13 = $dom->createElement('g:image_link');
        $no14 = $dom->createTextNode($images);
        $no13->appendChild($no14);
        $no8->appendChild($no13);
    }
    header('Content-type:text/xml;charset=utf-8');



    $file_name = $value['file_name'].'.xml';

    $save_path = DIR_FS_CATALOG.'datafeed/';
    if (!is_dir($save_path)) {
        mkdir($save_path, 0777, true);
    }
    if (file_exists($save_path.$file_name)) {
    } else {
        $ch = fopen($save_path.$file_name, 'w+');
        fclose($ch);
    }
    $result = $dom->save($save_path.$file_name);
}
