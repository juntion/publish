<?php
/* tpl_header.php */
// Make by Frankie  2016-8-19
// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 整理

// 配置文件 start
define('FS_SITE_UNIQUE_LANGUAGE_ID','3');
// 配置文件 end

// 在线聊天html代码 - 旧，现在可能不用了
define('FS_CHAT_NOW','Chat en Ligne');
define('FS_ONLINE_CAHT','Online Chat');
define('FS_LIVE_CAHT','Chat en Ligne');
define('FS_PRE_SALE','Service Avant-Vente');
define('FS_CHAT_WITH','Dialoguer avec Ventes en Ligne pour plus d\'informations avant l\'achat !');
define('FS_STAR','Commencer à Dialoguer');
define('FS_AFTER_SALE','Service Après-Vente');
define('FS_PL_GO','Si vous avez effectué un achat, s\'il vous plaît aller à ');
define('FS_MY_ORDER','la page de Mes commandes');
define('FS_PAGE_TO','à demander de l\'Aide en Ligne pour des détails de la commande.');

//by add helun 2018 5 28 手机版 Hot Search
define('FS_HEADER_SEARCH','Rechercher');
define('FS_HEADER_01','Rechercher...');
define('FS_HEADER_02','Recherche Chaude');
define('FS_HEADER_03','Cisco 40G QSFP+');
define('FS_HEADER_04','100G QSFP28');
define('FS_HEADER_05','10G SFP+ DAC');
define('FS_HEADER_06','DWDM SFP+');
define('FS_HEADER_07','CWDM DWDM MUX');
define('FS_HEADER_08','Câbles MTP MPO');
define('FS_HEADER_09','Jarretières Optqiues LC');
define('FS_HEADER_10','Atténuateurs');
define('FS_HEADER_11','Historique de Recherche');
define('FS_HEADER_12','Effacer l\'historique');

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 新版
// top
define('FS_HELP_SUPPORT', 'Aide & Support');
define('FS_CALL_US', 'Appelez-nous au');
define('FS_SAVED_CARTS', 'Paniers Enregistrés');
// 用户相关
define('FS_ACCOUNT', 'Compte');
define('FS_SIGN_IN','Se connecter');
define('FS_NEW_CUSTOMER','Nouveau Client ?');
define('FS_REGISTER_ACCOUNT','Inscrivez-Vous');
define('FS_SIGN_OUT','Se Déconnecter');
define('FS_MY_ACCOUNT','Mon Compte');
define('FS_MY_ORDERS','Mes Commandes');
define('FS_MY_ORDER','Ma Commande');
define('FS_MY_ADDRESS','Mon Adresse');
define('FS_SOLUTIONS','Solutions');
define('FS_ALL_CATEGORIES','Catégories');
define('FS_PROJECT_INQUIRY','Consultez Nos Experts');
define('FS_SEE_ALL_OFFERINGS','Voir tous les produits');
define('FS_RESOURCES','Ressources');
define('FS_CONTACT_US','Contact');
// 国家选择
define('FS_PRODUCTS_DIFFERENT','Les prix et les disponibilités des produits peuvent varier selon le pays/la région.');
define('FS_NEW_LANGUAGE_CURRENCY','Langue/Monnaie');
define('FS_COUNTRY_REGION','Pays/Région');

//用户相关，新改版 2019/3/29 rebirth.ma
define('FS_MAIN_MENU','Menu');
define('FS_NETWORKING','Mise en Réseau');
define('FS_ORDER_HISTORY','Historique de Commandes');
define('FS_ADDRESS_BOOK',"Carnet d'Adresses");
define('FS_MY_CASES','Mes Cas');
define('FS_MY_QUOTES','Mes Devis');
define('FS_ACCOUNT_SETTING','Paramètres de Compte');
define('FS_VIEW_ALL','Voir Tout');

// 搜索
define('FS_SEARCH_PRODUCTS','Chercher les Produits');
define('FS_NEW_CHOOESE_CURRENCY','Sélectionnez la Monnaie');
// 2018.7.23 fairy help
define('FS_NEED_HELP','Besoin d\'Aide');
define('FS_NEED_HELP_BIG','Besoin d\'Aide');
define('FS_CHAT_LIVE_WITH_US','Chat en Ligne');
define('FS_SEND_US_A_MESSAGE','Envoyez-nous un message');
define('FS_E_MAIL_NOW','Écrivez-nous');
define("FS_LIVE_CHAT","Chat en Ligne");
define("FS_WANT_TO_CALL","Appelez-nous ? ");
define("HOT_PRODUCTS","Meilleures Ventes");
define("FS_BREADCRUMB_HOME","Accueil");

/*2018-9-22.顶部增加一个版块*/
define('FS_CHAT_LIVE_WITH_GET','Obtenir un support technique');
define('FS_CHAT_LIVE_WITH_GET_A','Demander à un expert');

// 2018.10.6  ery  头部左上角免运费政策弹窗
define('HEADER_FREE_SHIPPINH_01','Expédition Rapide et Retours Faciles');
define('HEADER_FREE_SHIPPINH_02','Livraison GRATUITE à partir de %s');//%s不用翻译替换的是价格,如US $79
define('HEADER_FREE_SHIPPINH_03','et plus d\'options d\'expédition pour s\'adapter à votre emploi du temps et à votre budget.');
define('HEADER_FREE_SHIPPINH_04','Expédition le Jour Même');
define('HEADER_FREE_SHIPPINH_05','avec des stocks importants basés sur notre système multi-entrepôts.');
define('HEADER_FREE_SHIPPINH_06','Retour de 30 Jours');
define('HEADER_FREE_SHIPPINH_07','pour la plupart des commandes s\'il existe des problèmes.');
define('HEADER_FREE_SHIPPINH_08','Tout article avec le message « Livraison Gratuite » sur la page du produit est éligible à la Livraison Gratuite. FS.COM se réserve le droit de modifier cette offre à tout moment. En savoir plus sur la <a href="'.zen_href_link('shipping_delivery').'">politique de livraison</a> ou la <a href="'.zen_href_link('day_return_policy').'">politique de retour</a>.');
define('HEADER_FREE_SHIPPINH_09','Expédition en dehors de votre pays ? Basculez vers le pays de destination sur notre site Web pour consulter les politiques appropriées.');
define('HEADER_FREE_SHIPPINH_10','Livraison Rapide et Retours Faciles');
define('HEADER_FREE_SHIPPINH_11','Livraison GRATUITE à partir de %s');//%s不用翻译替换的是价格,如79€ 
define('HEADER_FREE_SHIPPINH_12','et plus d\'options de livraison pour s\'adapter à votre emploi du temps et à votre budget.');
define('HEADER_FREE_SHIPPINH_13','Expédition le Jour Même');
define('HEADER_FREE_SHIPPINH_14','Tout article avec le message « Livraison Gratuite » sur la page du produit est éligible à la Livraison Gratuite. FS.COM se réserve le droit de modifier cette offre à tout moment. En savoir plus sur la <a href="'.zen_href_link('shipping_delivery').'">politique de livraison</a> ou la <a href="'.zen_href_link('day_return_policy').'">politique de retour</a>.');
define('HEADER_FREE_SHIPPINH_15','Livraison en dehors de votre pays ? Basculez vers le pays de destination sur notre site Web pour consulter les politiques appropriées.');
define('HEADER_FREE_SHIPPINH_16','Inventaire de 310,000+');
define('HEADER_FREE_SHIPPINH_17','articles optiques et du réseau pour satisfaire vos besoins');
define('HEADER_FREE_SHIPPINH_18','Le temps d\'expédition peut être influencé par les stocks. Pour en savoir plus, consultez la <a href="'.zen_href_link('shipping_delivery').'">politique de livraison</a> ou la <a href="'.zen_href_link('day_return_policy').'">politique de retour</a>.');
define('HEADER_FREE_SHIPPINH_19','Le temps d\'expédition peut être influencé par les stocks. Pour en savoir plus, consultez la <a href="'.zen_href_link('shipping_delivery').'">politique de livraison</a> ou la <a href="'.zen_href_link('day_return_policy').'">politique de retour</a>.');

//手机端侧边栏政策页
define('FS_PH_HELP_SETTING','Aide & Paramètres');

// 浏览器
define('FS_UPGRADE','MISE À NIVEAU DE VOTRE NAVIGATEUR');
define('FS_UPGRADE_TIP','Vous utilisez un navigateur ancien. Veuillez mettre à jour votre navigateur pour une meilleure expérience.');
define('BROWSER_CHROME','Chrome');
define('BROWSER_FIREFOX','Firefox');
define('BROWSER_IE','Internet Explorer');
define('BROWSER_EDGE','Edge');

define('FS_TAGIMG_TITLE','Découvrir les Solutions');
define('FS_INDEX_CATE_PRODUCTS','Produits');
?>