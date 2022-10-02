<?php
/* tpl_header.php */
//Make by Frankie  2016-8-30
// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 整理

// 配置文件 start
if($_SESSION['languages_code']=='mx'){
	define('FS_SITE_UNIQUE_LANGUAGE_ID','12');
}else{
	define('FS_SITE_UNIQUE_LANGUAGE_ID','2');
}
define('FS_IS_OPEN_CACHE',true);
// 配置文件 end

// 在线聊天html代码 - 旧，现在可能不用了
define('FS_CHAT_NOW','Chat ahora');
define('FS_ONLINE_CAHT','Chat ahora');
define('FS_LIVE_CAHT','Contacta ahora');
define('FS_PRE_SALE','Servicio preventa');
define('FS_CHAT_WITH','¡Contacta con el representante en línea para obtener más información!');
define('FS_STAR','Iniciar una conversación');
define('FS_AFTER_SALE','Servicio postventa');
define('FS_PL_GO','Si has hecho compras, por favor visita ');
define('FS_MY_ORDER','Mis pedidos');
define('FS_PAGE_TO','página de solicitar ayuda en línea para obtener información de pedidos.');

//by add helun 2018 5 28 手机版 Hot Search
define('FS_HEADER_SEARCH','Buscar');
define('FS_HEADER_01','Buscando...');
define('FS_HEADER_02','Búsqueda caliente');
define('FS_HEADER_03','Cisco 40G QSFP+');
define('FS_HEADER_04','100G QSFP28');
define('FS_HEADER_05','10G SFP+ DAC');
define('FS_HEADER_06','DWDM SFP+');
define('FS_HEADER_07','CWDM DWDM MUX');
define('FS_HEADER_08','Cables de MTP/MPO');
define('FS_HEADER_09','Cables de Parche LC');
define('FS_HEADER_10','Atenuadores');
define('FS_HEADER_11','Historial de Búsqueda');
define('FS_HEADER_12','Borrar la Historia');

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 新版
// top
define('FS_HELP_SUPPORT', 'Ayuda & Soporte');
define('FS_CALL_US', 'Llámenos');
define('FS_SAVED_CARTS', 'Cesta guardada');
// 用户相关
define('FS_ACCOUNT', 'Cuenta');
define('FS_SIGN_IN','Iniciar sesión');
define('FS_SIGN_IN_A', 'Identifícate');
define('FS_NEW_CUSTOMER','¿Eres cliente nuevo?');
define('FS_REGISTER_ACCOUNT','Crea tu cuenta');
define('FS_SIGN_OUT','Cerrar sesión');
define('FS_MY_ACCOUNT','Mi cuenta');
define('FS_MY_ORDERS','Mi pedido');
define('FS_MY_ORDER','Mi pedido');
define('FS_MY_ADDRESS','Mi dirección');
define('FS_SOLUTIONS','Soluciones');
define('FS_ALL_CATEGORIES','CATEGORIAS');
define('FS_PROJECT_INQUIRY','Consúltanos');
define('FS_SEE_ALL_OFFERINGS','Ver todas las ofertas');
define('FS_RESOURCES','Recursos');
define('FS_CONTACT_US','Contacto');
// 国家选择
define('FS_PRODUCTS_DIFFERENT','Los productos pueden tener diferentes precios y disponibilidad según el país/región.');
define('FS_NEW_LANGUAGE_CURRENCY','Idioma/Moneda');
define('FS_COUNTRY_REGION','País/Región');

//用户相关，新改版 2019/3/29 rebirth.ma
define('FS_MAIN_MENU','Menú principal');
define('FS_NETWORKING','Networking');
define('FS_ORDER_HISTORY','Mis pedidos');
define('FS_ADDRESS_BOOK','Mi libreta de dirección');
define('FS_MY_CASES','Mis casos');
define('FS_MY_QUOTES','Mis cotizaciones');
define('FS_ACCOUNT_SETTING','Configuración de cuenta');
define('FS_VIEW_ALL','Ver todo');

// 搜索
define('FS_SEARCH_PRODUCTS','¿Qué estás buscando?');
define('FS_NEW_CHOOESE_CURRENCY','Elegir Moneda');
// 2018.7.23 fairy help
define('FS_NEED_HELP','¿Necesitas ayuda?');
define('FS_NEED_HELP_BIG','¿Necesitas ayuda?');
define('FS_CHAT_LIVE_WITH_US','Chatea con nosotros');
define('FS_SEND_US_A_MESSAGE','Envíanos un mensaje');
define('FS_E_MAIL_NOW','E-mail ahora');
define("FS_LIVE_CHAT","Live Chat");
define("FS_WANT_TO_CALL","Llámanos");
define("FS_BREADCRUMB_HOME","INICIO");

/*2018-9-22.顶部增加一个版块*/
define('FS_CHAT_LIVE_WITH_GET','Soporte técnico');
define('FS_CHAT_LIVE_WITH_GET_A','Pregúntale a un experto');

// 2018.10.6  ery  头部左上角免运费政策弹窗
define('HEADER_FREE_SHIPPINH_01','Envío rápido & Devoluciones fáciles');
define('HEADER_FREE_SHIPPINH_02','Envío gratis de más de<br> %s');//%s不用翻译替换的是价格,如US $79
define('HEADER_FREE_SHIPPINH_03','y más opciones de envío se adaptan a su horario y presupuesto.');
define('HEADER_FREE_SHIPPINH_04','Envío el mismo día');
define('HEADER_FREE_SHIPPINH_05','con grandes inventarios basados en nuestro sistema multi-almacenes.');
define('HEADER_FREE_SHIPPINH_06','Devolución de 30 días');
define('HEADER_FREE_SHIPPINH_07','en la mayoría de los pedidos si algo no está bien.');
define('HEADER_FREE_SHIPPINH_08','Cualquier artículo con el mensaje “Envío gratuito” en la página del producto es elegible para envío gratuito. FS.COM se reserva el derecho de cambiar esta oferta en cualquier momento. Lea más sobre la <a href="'.zen_href_link('shipping_delivery').'">política de envío</a> o <a href="'.zen_href_link('day_return_policy').'">política de devolución</a>.');
define('HEADER_FREE_SHIPPINH_09','¿El envío es fuera de su país? Cambie al país de destino en el sitio web para ver las políticas adecuadas.');
define('HEADER_FREE_SHIPPINH_10','Envío rápido & Devoluciones fáciles');
define('HEADER_FREE_SHIPPINH_11','Envío gratis de más de<br> %s');//%s不用翻译替换的是价格,如79€ 
define('HEADER_FREE_SHIPPINH_12','y más opciones de envío se adaptan a su horario y presupuesto.');
define('HEADER_FREE_SHIPPINH_13','Envío el mismo día');
define('HEADER_FREE_SHIPPINH_14','Cualquier artículo con el mensaje de "Envío gratuito" en la página del producto es elegible para la entrega gratuita. FS.COM se reserva el derecho de cambiar esta oferta en cualquier momento. Lea más sobre la <a href="'.zen_href_link('shipping_delivery').'">política de envío</a> o <a href="'.zen_href_link('day_return_policy').'">política de devolución</a>.');
define('HEADER_FREE_SHIPPINH_15','¿El envío es fuera de su país? Cambie al país de destino en el sitio web para ver las políticas adecuadas.');
define('HEADER_FREE_SHIPPINH_16','Inventario de 310,000+');
define('HEADER_FREE_SHIPPINH_17','para productos ópticos y de red para satisfacer sus necesidades.');
define('HEADER_FREE_SHIPPINH_18','El tiempo de envío puede estar influenciado por los inventarios. Lea más sobre la <a href="'.zen_href_link('shipping_delivery').'">política de envío</a> o <a href="'.zen_href_link('day_return_policy').'">política de devolución</a>.');
define('HEADER_FREE_SHIPPINH_19','El tiempo de envío puede estar influenciado por los inventarios. Lea más sobre la <a href="'.zen_href_link('shipping_delivery').'">política de envío</a> o <a href="'.zen_href_link('day_return_policy').'">política de devolución</a>.');

//手机端侧边栏政策页
define('FS_PH_HELP_SETTING','Ayuda & Configuración');

// 浏览器
define('FS_UPGRADE','ACTUALICE SU NAVEGADOR');
define('FS_UPGRADE_TIP','Está utilizando una versión antigua del navegador. Por favor, actualice su navegador para una mejor experiencia.');
define('BROWSER_CHROME','Chrome');
define('BROWSER_FIREFOX','Firefox');
define('BROWSER_IE','Internet Explorer');
define('BROWSER_EDGE','Edge');

define('FS_TAGIMG_TITLE','Portafolio de producto');
define('FS_INDEX_CATE_PRODUCTS','PRODUCTOS');
?>