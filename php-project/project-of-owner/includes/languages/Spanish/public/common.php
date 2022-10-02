<?php
// 公共的语言包都放到这里

// classic/breadcrumb.php
define('FALLWIND','fallwind');


// classic/order.info.php
define('FIBERSTORE_ORDER_STATUS','Estado del pedido');
define('FIBERSTORE_VIEW_DETAILS','Ver detalles');
define('FIBERSTORE_ORDER_NUMBER','Número del pedido');
define('FIBERSTORE_ORDER_CUSTOMER_NAME','Nombre del cliente');
define('FIBERSTORE_ORDER_TOTAL','Precio total');
define('FIBERSTORE_ORDER_PAYMENT','pago');
define('FIBERSTORE_DASHBOARD_NO_ORDER','No tienes pedidos.');



// classic/show_dialog.php
//2017.5.26		ADD		ERY
define('FS_DIALOG_ASK','Hacer ');
define('FS_DIALOG_A','Haga una pregunta a');
define('FS_DIALOG_TITLE','Título');
define('FS_DIALOG_YOUR','El tema de la pregunta es obligatorio');
define('FS_DIALOG_CONTENT','Contenido');
define('FS_DIALOG_PLEASE','Por favor, escriba sus preguntas.');
define('FS_DIALOG_YOUR2','El contenido es obligatorio');
define('FS_DIALOG_PLEASE1',"No escribas más de 3,000 caractereres. ¡Gracias!");
define('FS_DIALOG_EMAIL','Correo electrónico');
define('FS_DIALOG_AGAIN','Este correo electrónico especificado no es válido, corríjalo e inténtelo de nuevo');
define('FS_DIALOG_COMMENTS','Comentarios/Preguntas');
define('FS_DIALOG_THIS','Este campo es obligatorio, escriba al menos 10 caracteres por favor.');


// common/account_left_slide.php
//Content in account left slide
//2016-9-8      add by Frankie
define('MY_ACCOUNT','Mi cuenta');
define('ORDER_CENTER','Centro de pedidos');
define('ALL_ORDER','Todos los pedidos');
define('PENDING_ORDER','Pedidos pendientes');
define('TRANSACTION','Pedidos completados');
define('CANCELED_ORDER','Pedidos cancelados');
define('EXCHANGE','Pedidos para reemplazo o devolución');
define('MY_ADDRESS','Mi dirección');
define('NEWSLETTER','Notificaciones');
define('CHANGE_PASSWORD','Cambiar mi contraseña');
define('MY_REVIEWS','Mis reseñas');
define('MY_QUESTION','Mis preguntas');
define('MY_SALES_REPRESENTIVE','Mi representante');
define('MY_CONTACT','Contactar con');
define('FS_CONTACT_HELP','¿En qué podemos ayudarte?');
define('FS_CONTACT_CHAT','Live Chat ahora');

//2017.5.12   add  by ery
define('ACCOUNT_LEFT_EDIT','Editar mi cuenta');
define('ACCOUNT_LEFT_ORDER','Historial de pedidos');
define('ACCOUNT_LEFT_ADDRESS','Dirección');
define('ACCOUNT_LEFT_QUESTION','Preguntas');
define('ACCOUNT_LEFT_MANAGE','Gestionar suscripciones');
define('ACCOUNT_LEFT_QUOTATION','Cotización Válida');
define('ACCOUNT_LEFT_QUOTATION_DETAIL','Detalles de Cotización Válida');
define('FS_CART_ORDER_PRICE','Precio del Pedido Válido');
define('FS_CART_QUOTATION_PRICE','Precio de Cotización Válida');
define('FS_REMOVED_QUOTATION','La oferta especial en el presupuesto será sustituida por el precio en línea debido a la eliminación.');


// 2018.11.29 fairy 个人中心改版
define('FS_MY_ACCOUNT','Mi cuenta');
define('ACCOUNT_SETTING','Configuración de la cuenta');
define('FS_RETURN_ORDERS','Pedidos de devolución');
define('FS_MY_QUOTES','Mis cotizaciones');
define('FS_WISH_LIST','Lista de deseos');
define('FS_ADDRESS_BOOK','Libreta de direcciones');

//列表页面为空跳转
define('FS_MEMBER_LIST_EMPTY_PAGE_JUMP','<span class="alone_Special">Regresar al</span> <a href="'.zen_href_link(FILENAME_DEFAULT,'','SSL').'">INICIO</a>');

// english.php
define("FS_COMMON_CONTINUE",'Continuar');
define("FS_COMMON_OPERATION",'Operación');
define('FS_COMMON_VIEW','Ver');
define('FS_PURCHASE_ORDER_NUMBER','Número de orden de compra');
define('FS_FILE_UPLOADED_SUCCESS','Archivo se ha subido con éxito');
define("MANAGE_ORDER_UPLOAD_FORMAT_ERROR","Tipos de archivo permitidos: PDF, JPG, PNG.");
define("MANAGE_ORDER_UPLOAD_ERROR_NEW","Formatos soportados: PDF, JPG, PNG.<br>Tamaño máximo: 4M.");
define("FS_UPLOAD_PO_FILE",'Subir archivo PO');

// 2018.12.7 fairy
define('F_RECEIPT_CONFIRMATION_SUCCESS_TIP','¡Gracias por tu compra en FS! Esperamos tu próxima visita.');

// 表单验证
define("ADDRESS_PLACE_HODLER","Calle y número, c/o");
define("ADDRESS_PLACE_HODLER2","Apartamento, unidad, edificio, piso, etc.");
define("FS_ZIP_CODE", "Código postal");
define("FS_ADDRESS", "Dirección");
define("FS_ADDRESS2", "Dirección 2");
define('FS_CHECK_COUNTRY_REGION', 'País/Región');
define("FS_CHECKOUT_ERROR1", "Se requiere tu nombre.");
define("FS_CHECKOUT_ERROR2", "Se requiere tu apellido.");
define("FS_CHECKOUT_ERROR3", "Se requiere tu dirección.");
define("FS_CHECKOUT_ERROR4", "Se requiere tu código postal.");
define("FS_CHECKOUT_ERROR5", "Se requiere tu ciudad o pueblo.");
define("FS_CHECKOUT_ERROR6", "Se requiere tu estado/provincia/región.");
define("FS_CHECKOUT_ERROR7", "Se requiere tu número de teléfono.");
define("FS_CHECKOUT_ERROR8", "Se requiere tu número de IVA.");
define("FS_CHECKOUT_ERROR9", "Se requiere tu estado.");
define("FS_CHECKOUT_ERROR10", "Se requiere tu nombre de compañía.");
define("FS_CHECKOUT_ERROR11", "Válido TAX/VAT eg:DE123456789");
define("FS_CHECKOUT_ERROR12", "La dirección de envío debe tener al menos 4 caracteres.");
define("FS_CHECKOUT_ERROR13", "Su nombre debe tener al menos 2 caracteres.");
define("FS_CHECKOUT_ERROR14", "Su apellido debe tener al menos 2 caracteres.");
define("FS_CHECKOUT_ERROR15", "Su código postal debe tener al menos 3 caracteres.");
define("FS_CHECKOUT_ERROR16", "No enviamos a PO Boxes");
define("FS_CHECKOUT_ERROR17", "Se requiere tu tipo de dirección.");
define("FS_CHECKOUT_ERROR28", "Por favor ingrese un código postal válido");
define("FS_ADDRESS_LINE_TWO_MIN_MAX_TIP","La línea de dirección 2 debe tener entre 4 y 35 caracteres.");
define("FS_CITY_MIN_MAX_TIP","La línea 2 de la dirección debe tener entre 1 y 50 caracteres.");

// 订单和退换货公共的导航
define('FS_ORDER_ALL','Todos los pedidos');
define('FS_ORDER_PENDING','Pendiente');
define('FS_ORDER_COMPLETED','Completo');
define('FS_ORDER_CANCELLED','Cancelado');
define('FS_ORDER_PURCHASE','Realizado con cuenta Net');
define('FS_ORDER_PROGRESSING','En proceso');
define('FS_ORDER_RETURN_ITEM','Devoluciones');

define('FS_FILE_UPLOADED_SUCCESS_TXT','El documento se ha cargado correctamente.');



// common_service.php
define('COMMON_SERVICE_01','Contáctanos');
define('COMMON_SERVICE_02','FS se concentra en las soluciones de centro de datos y de red de transmisión óptica para ayudarte a contruir exactamente lo que necesites.<br/> Ponte en contacto con nosotros. Estamos a tu disposición 24/7. ');
define('COMMON_SERVICE_03','Más formas de contacto');
define('COMMON_SERVICE_04','Chat en línea');
define('COMMON_SERVICE_05','Estamos a tu disposición 24/7. Déjanos un mensaje para una respuesta rápida.');
define('COMMON_SERVICE_06','LiveChat');
define('COMMON_SERVICE_07','Teléfono');
define('COMMON_SERVICE_08','Llámanos al ');
define('COMMON_SERVICE_09',' o completa el formulario y te llamamos.');
define('COMMON_SERVICE_10','Te llamamos');
define('COMMON_SERVICE_11','Email');
define('COMMON_SERVICE_12','Nuestro equipo de servicio al cliente te responderá lo antes posible.');
define('COMMON_SERVICE_13','Envíanos email');
define('COMMON_SERVICE_14','Soporte técnico');
define('COMMON_SERVICE_15','Obtén soporte gratuito o diseño de soluciones para tu proyecto.');
define('COMMON_SERVICE_16','Solicita asistencia');
define('COMMON_SERVICE_17','Nuestro excelente equipo de trabajo');
define('COMMON_SERVICE_18','FS nunca dice no a la buena inspiración de los empleados y siempre alienta a cada persona a expresar sus ideas. Esa es la razón');
define('COMMON_SERVICE_19','por la cual FS puede servir a nuestros clientes en todo el mundo cada vez mejor.');
define('COMMON_SERVICE_20','Conoce nuestro equipo');
define('FS_SHOP_CART_ALERT_JS_13','De*');
define('FS_SHOP_CART_ALERT_JS_14','Para*');
define('FS_SHOP_CART_ALERT_JS_15','Mensaje personal (opcional):');
//quote
define('FS_VIEW_QUOTE_SHEET','Ver hoja de cotización');
define('FS_PRODUCT_HAS_BEEN_ADDED','El producto ha sido añadido.');
define('FS_SAVE_CSRT_LIMIT_TIP','Por favor ingrese un nombre de la cesta menos de 50 palabras.');
define('FS_QUOTE','Cotización');
define('FS_SAVED_CART_EMAIL','Email');



// common/footer.php文件
/*底部共用文件*/
// fallwind	2016.8.24	add
// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 整理
// footer computer
define('FS_FOOTER_ABOUT_FS','Sobre nosotros');
define('FS_ABOUT_FS_COM','Sobre nosotros');
define('FS_FOOTER_WHY_US','¿Por qué nosotros?');
define('LATEST_NEWS','Notica');
define('FS_FOOTER_LATEST','Notica');
define('FS_FOOTER_CONTACT_US','Contacto');
// Frankie 2018.1.22
define('FS_IMPRINT','Aviso legal');

// footer Customer Service
define('FS_FOOTER_CUSTOMER_SERVICE','Servicios al cliente');
define('FS_FOOTER_OEM','OEM & Personalizado');
//fallwind	2017.5.10	tpl_footer.php
define('FS_OEM_AMP_CUSTOM','OEM y personalización');
define('FS_FOOTER_WARRANTY','Garantía');
define('FS_FOOTER_POLICY','Políticas de devolución');
define('FS_RETURN_POLICY','Política de devoluciones');
define('FS_FOOTER_QUALITY','Control de calidad');
define('FS_FOOTER_PARTNER','Cuenta empresarial');

// footer Payment & Shipping
define('FS_FOOTER_PAY_SHIP','Pago y envío');
define('FS_PAYMENT_METHODS','Métodos de pago');
define('FS_NET_AMP_W',"Orden de compra");
define('FS_FOOTER_DELIVERY','Envío y entrega');

// footer Quick Help
define('FS_FOOTER_QUICK_HELP','Ayuda rápida');
define('FS_FOOTER_PURCHASE_HELP','Ayuda de compras');
define('FS_FOOTER_FORGET_PASS','¿Has olvidado tu contraseña?');
define('FS_FOOTER_FAQ','FAQ');
define('FS_TRACK_YOUR_PACKAGE','Rastrea tu paquete');

// footer Questions? Aron 2017.8.6
define("FS_YAO1","Contáctanos");
define("FS_YAO2","Estamos aquí para ayudar 24/7");
define("FS_YAO3","Chat ahora");
define("FS_YAO4","Chatee con un representante en línea");

// Popular
define('FS_FOOTER_POPULAR_PAGES','Popular Pages:');    //小语种没有这个

define('FS_FOOTER_LEGAL','Legal');
define('FS_FOOTER_LEGAL_NOTICE','Aviso legal');
define('FS_FOOTER_PRIVACY_POLICY','Política de privacidad');
define('FS_FOOTER_TERMS_OF_USE','Términos y condiciones');

// 手机站切换版本
define('FS_FULL_SITE','Escríbenos');
define('FS_MOBILE_SITE','Versión de móvil');
define('FS_FOOTER_LIVE_CHAT','Chat ahora');

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 新版 新增
define("FS_HIGH_QUALITY","Alta calidad");
define("FS_SAFE_SHOPPING","Compras seguras");
define("FS_FAST_DELIVERY","Período de devolución en RETURN_DAYS días");

// 版权相关
define('FS_PRIVACY_AND_POLICY',"Privacidad y Cookies");
define('FS_TERMS_OF_USE',"Términos y condiciones");
define('FS_TERMS_OF_USE_DE',"Términos y Condiciones");
define('FS_SITE_MAP','Mapa del sitio');
define('FS_FOOTER_FEEDBACK','Déjanos tus comentarios');
// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 新版 新增
define("FS_FOOTER_COPYRIGHT","Copyright © 2009-YEAR ".FS_LOCAL_COMPANY_NAME." Todos los derechos reservados.");
define("FS_FOOTER_COPYRIGHT_M","Copyright © 2009-YEAR <span>".FS_LOCAL_COMPANY_NAME."</span> Todos los derechos reservados.");
define("FS_HLEP_CENTER","Soporte de FS");
define('FS_FOOTER_REQUEST_A_SAMPLE','Pedir muestra');

define("NEW_FOOTER_05",'Empresas de transporte aliadas:');
define("NEW_FOOTER_06",'Métodos de pago:');


define("FS_SUPPORT",'Servicios al cliente');



// common/header.php文件
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
define('FS_SIGN_IN','Inicia sesión');
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
define('FS_RELATED_INFO','Información técnica');
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
define('FS_MY_CASES','Centro de casos');
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

define('FS_TAGIMG_TITLE','Descubre soluciones');
define('FS_INDEX_CATE_PRODUCTS','PRODUCTOS');


// common/left_side_bar_for_tag.php
define('FIBERSTORE_TRANS1','Find by Network Device');
define('FIBERSTORE_TRANS2','Find by Orignal Model');
define('FIBERSTORE_CLEAR','Clear Selections');


// common/phone.php
//各国电话语言包 2017.8.18  ery

define('FS_PHONE_DE','+49 (0) 8165 80 90 517');		// Germany
define('FS_PHONE_HK','+(852) 8176 3606');		// Hong Kong
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
define('FS_PHONE_SG','+(65) 6443 7951');		// Singapore
define('FS_PHONE_TW','+886 (2) 5592 4011');		// Taiwan
define('FS_PHONE_IT','+44 (0) 121 716 1755');	// Italy
define('FS_PHONE_CH','+41 (43) 508 5909');		// Switzerland
define('FS_PHONE_DK','+45 7876 8321');			// Denmark
define('FS_PHONE_NZ','+64 (9) 985 3566');		// New Zealand
define('FS_PHONE_CN','+1 (877) 205 5306');		// China
define('FS_PHONE_WH','+86 (027) 87639823');     //wuhan
define('FS_PHONE_US_TWO','+1 (253) 277 3058');
define('FS_PHONE_JP','+81 345888332');			//japan

define('FS_PHONE_SITE_EU','+49 (0) 8165 80 90 517');
define('FS_PHONE_SITE_UK','+44 (0) 121 716 1755');
define('FS_PHONE_SITE_ES','+34 (91) 123 7299');
define('FS_PHONE_SITE_FR','+33 (1) 82 884 336');
define('FS_PHONE_SITE_RU','+7 (499) 643 4876');
define('FS_PHONE_SITE_MX','+52 (55) 3098 7566');
define('FS_PHONE_SITE_AU','+61 3 9693 3488');
define('FS_PHONE_SITE_JP','+1 (877) 205 5306');
define('FS_PHONE_SITE_SG','+(65) 6443 7951');
if(US_WAREHOUSE_UP){
    define('FS_PHONE_US','+1 (888) 468 7419');      // United States
    define('FS_PHONE_SITE_US','+1 (888) 468 7419');
    define('FS_PHONE_CHECKOUT_US','+1 (888) 468 7419');
}else{
    define('FS_PHONE_US','+1 (877) 205 5306');		// United States
    define('FS_PHONE_SITE_US','+1 (877) 205 5306 (PST) <br/> +1 (888) 468 7419 (EST)');
    define('FS_PHONE_CHECKOUT_US','+1 (877) 205 5306 (PST) / +1 (888) 468 7419 (EST)');
}
//美东电话
define('FS_PHONE_US_EAST','+1 (888) 468 7419');
//武汉仓电话
define('FS_PHONE_CN','+86 (027) 87639823');




// common/resources.php
//catalog
define('PRODCUT_CATALOGS_01','Catálogos de productos');
define('PRODCUT_CATALOGS_02','Base de conocimiento');
define('PRODCUT_CATALOGS_03','Soluciones');
define('TUTORIAL_ALL','Todos');
define('TUTORIAL_ALL_ATGS','Todas las etiquetas');
define('FS_LOAD_MORE','Leer más');
define('FS_SUPPORT_CASE','Estudios de caso');

//support
define('SUPPORT_SEC_01','Solución para interconexión');
define('SUPPORT_SEC_02','Solución para cableado');
define('SUPPORT_SEC_03','Solución para empresas');
define('SUPPORT_SEC_04','Solución para WDM');
define('SUPPORT_SEC_05','Solución para FTTX');


//knowledge
define('KNOWLEDGE_01','Fibra óptica');
define('KNOWLEDGE_02','Base de conocimientos para ayudar a los profesionales de TI a comenzar y desarrollar los negocios');
define('KNOWLEDGE_03','Relacionado');
define('KNOWLEDGE_04','Compartir en');
define('KNOWLEDGE_05','Artículos relacionados');
define('KNOWLEDGE_06','Temas');

define('PRODCUT_CATALOGS_04','Videos de productos');
define('PRODCUT_CATALOGS_05','Todo');
define('PRODCUT_CATALOGS_06','Redes');
define('PRODCUT_CATALOGS_07','Cableado');
define('PRODCUT_CATALOGS_08','WDM & FTTx');
define('PRODCUT_CATALOGS_09','Red empresarial');
define('PRODCUT_CATALOGS_10','Probadores & Herramientas');




// common/save_shopping_list.php
//2017.5.30		add		ery
define('FS_AJAX_PAST','¡Usted estaba haciendo compras en FS.COM y deseó guardar esta página y mensaje!');
define('FS_AJAX_THIS','Este correo electrónico fue enviado por su propio servicio de FS.COM Compartir con un amigo. Como resultado de recibir este mensaje, usted no recibirá ningún mensaje no solicitado de FS.COM, leer más sobre nuestra ');
define('FS_AJAX_PRIVACY','Política de privacidad');
define('FS_AJAX_WAS',' estaba de compras en FS.COM y quería compartir esta página y mensaje con usted');
define('FS_AJAX_SENT','Este correo electrónico fue enviado por tu amigo ');
define('FS_AJAX_USING',' Utilizando el servicio de FS.COM Compartir con un amigo. Como resultado de recibir este mensaje, usted no recibirá ningún mensaje no solicitado de FS.COM, leer más sobre nuestra ');




// functions/functions_shipping.php
define('FS_SHIP_IN_PERSON','Lo recogeré yo mismo ');



// functions/functions_tutorial.php
//fallwind	2016.8.22	fallwind_test	add
define('ABC','abcabc');


// functions/product_instock.php
define('FS_SHIP_PC',' pza');
define('FS_SHIP_PCS',' pzas');
define('FS_SHIP_ROLL',' Rollo');
define('FS_SHIP_ROLLS',' Rollos');
define('FS_SHIP_ROLL_1KM',' <em>(1Roll = 1KM)</em>');
define('FS_SHIP_ROLL_2KM',' <em>(1Roll = 2KM)</em>');
define('FS_SHIP_AVAI','Disponible');
define('FS_SHIP_STOCK',' en stock');
define('FS_SHIP_DEVE','Desarrollo');
define('FS_SHIP_ESTIMATED','Tiempo estimado de envío: ');
define('FS_SHIP_INVENTORY','Escasez de inventario, Envío disponible ');
define('FS_SHIP_TODAY_BEFOR','Escasez de inventario, Envío disponible ');

define('FS_SHIP_PLACE','El pedido realizado hoy se enviará dentro de ');
define('FS_SHIP_DAYS',' días laborales');


define("CREDIT_HOLDER_NAME_ERROR1","Se requiere el titular de la tarjeta.");
define("CREDIT_HOLDER_NAME_ERROR2","El titular de la tarjeta es incorrecto. Por favor ingréselo de nuevo.");
define("CREDIT_CARD_NUMBER_ERROR1","Se requiere el número de la tarjeta.");
define("CREDIT_CARD_NUMBER_ERROR2","Este número de tarjeta no existe. Por favor introduce un número válido.");
define("CREDIT_CARD_DATE_ERROR1","Se requiere la fecha de caducidad.");
define("CREDIT_CARD_DATE_ERROR2","La fecha de caducidad es incorrecta. Por favor ingrésela de nuevo.");
define("CREDIT_CARD_CODE_ERROR1","Se requiere el código de seguridad.");
define("CREDIT_CARD_CODE_ERROR2","El código de seguridad es incorrecto. Por favor ingréselo de nuevo.");
//Jeremy 2019.07.18 新版一级分类页底部
define('NEW_PATCH_PANEL_01', 'Sistema de prueba perfecto');
define('NEW_PATCH_PANEL_02', 'Todos los cables pasan el 100% de la prueba del canal Fluke.');
define('NEW_PATCH_PANEL_03', 'Certificacion de calidad');
define('NEW_PATCH_PANEL_04', 'Certificación de calidad garantizada CE, RoHS, ISO9001.');
define('NEW_PATCH_PANEL_05', 'Suficiente stock');
define('NEW_PATCH_PANEL_06', 'Suficiente stock para envío el mismo día.');
define('NEW_PATCH_PANEL_07', 'Negocio rentable');
define('NEW_PATCH_PANEL_08', 'Precios al por mayor de cables para reducir el presupuesto de tu proyecto.');

define('NEW_PATCH_PANEL_01_209', 'Sistema de prueba riguroso');
define('NEW_PATCH_PANEL_02_209', 'Inspección de la cara final y pérdida de IL y RL.');

define('NEW_PATCH_PANEL_01_1', 'Alta flexibilidad');
define('NEW_PATCH_PANEL_02_1', 'Admite múltiples interfaces para satisfacer diferentes necesidades de aplicaciones empresariales.');
define('NEW_PATCH_PANEL_04_1', 'Todos los productos han pasado por estrictas pruebas.');

define('NEW_PATCH_PANEL_01_911', 'Entrega rápida');
define('NEW_PATCH_PANEL_02_911', 'Los almacenes locales que cubren los mercados globales ahorran tu tiempo.');

define('NEW_PATCH_PANEL_01_9', 'Amplia compatibilidad');
define('NEW_PATCH_PANEL_02_9', 'Compatible con todos los principales proveedores y sistemas.');
define('NEW_PATCH_PANEL_04_9', 'Certificado de calidad bajo las normas CE, RoHS, IEC, FCC, ISO9001, FDA.');

define('NEW_PATCH_PANEL_02_4', '"Todos los productos se prueban para cumplir con el requisito estándar".');
define('NEW_PATCH_PANEL_08_4', 'Precio al por mayor ahorra en gran medida tu presupuestos de proyecto.');


//shopping_cart/save_cart/inquiry的email功能 ery 2019-08-12 add
define('FS_EMIAL_BOTTOM_MSG','<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr><td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 13px;color: #232323;line-height: 20px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
    Este correo electrónico ha sido enviado <a style="color: #232323;text-decoration: none;" href="javascript:;"></a>  a través de nuestra opción "Compartir". Este mensaje no implica que recibiras mensajes de <a style="color: #232323;text-decoration: none;" href="'.zen_href_link('index').'">FS</a>
                            que no has solicitado. Conoce más acerca de nuestra <a style="color: #232323;text-decoration: none;" href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">Política de privacidad</a>.
                        </td></tr>
                    </tbody>
                </table>');


//邮件
define('SAMPLE_EMAIL_DEAR','Hola ');
define('SAMPLE_EMAIL_01', 'Hemos recibido tu solicitud, y nos pondremos en contacto contigo lo antes posible.');
define('SAMPLE_EMAIL_02', 'Con tu número de caso <a style="color: #0070bc;text-decoration: none" href="javascript:;">###case_number###</a>, podrás consultar el estado de esta solucitud.');
define('SAMPLE_EMAIL_03', 'Información de contacto: ');
define('SAMPLE_EMAIL_04', 'Correo electrónico: ');
define('SAMPLE_EMAIL_05', 'País: ');
define('SAMPLE_EMAIL_06', 'Número de teléfono: ');
define('SAMPLE_EMAIL_07', 'Comentario adicional: ');
define('SAMPLE_EMAIL_08', 'Gracias');
define('SAMPLE_EMAIL_09', 'Equipo FS');
define('SAMPLE_EMAIL_30', 'Con tu número de caso <a style="color: #0070bc;text-decoration: none" href="$HREF">###case_number###</a>, podrás consultar el estado de este caso y nuestras respuestas en el <a style="color: #0070bc;text-decoration: none" href="$HREF">centro de casos online</a>.');

define('FS_CONTACT_GET_SUPPORT','Estamos a tu entera disposición para cualquier duda o consulta.');
define('FS_CONTACT_LEAVE','Déjanos un mensaje');
define('CUSTOMER_SERVICE_OTHERS_46', '¿Ya tienes una cuenta? <a style="color: #0070bc;" href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">Inicia sesión</a> o <a style="color: #0070bc;" href="'.zen_href_link(FILENAME_REGIST, '', 'SSL').'">Crea una cuenta</a>');
define('CUSTOMER_SERVICE_OTHERS_47', '<a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">Inicia sesión</a> o <a href="'.zen_href_link(FILENAME_REGIST, '', 'SSL').'">Crea una cuenta</a> para obtener servicios personalizados.');
define('CUSTOMER_SERVICE_OTHERS_48', '¿Ya tienes una cuenta? <a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">Inicia sesión</a> o <a href="'.zen_href_link(FILENAME_REGIST, '', 'SSL').'">regístrate</a>.');

//服务页面公用
define('FS_SUPPORT_FORM_TXT','Completa la siguiente información para comunicarnos contigo lo antes posible.');
define('FS_SUPPORT_FORM_PLACEHOLDER','Con tus comentarios te brindaremos una respuesta mucho más rápida y acertada.');
define('FS_PLEASE_ENTER_COMMENTS','Déjanos más información sobre tu solicitud.');
define('FS_COMMON_AT_LEAST','Por favor, escribe al menos 3 caracteres.');
define('FS_COMMON_AT_MOST','Se permite un máximo de 1000 caracteres.');
define("FS_SUPPORT_EMAIL","Correo electrónico");
define('FS_SUPPORT_PHONE','Teléfono');
define('FS_FIRST_NAME_PLEASE','Por favor, ingresa tu nombre.');
define('FS_LAST_NAME_PLEASE','Por favor, ingresa tu apellido.');
define('SOLUTION_SUPPORT_COMMENTS','Información sobre tu proyecto*');
define('FS_SUPPORT_COMMENTS','Comentarios');
define('FS_SUPPORT_FIRST_NAME','Nombre');
define('FS_SUPPORT_LAST_NAME','Apellido');
// 2019-8-7 potato 隐私政策
define('SOLUTION_PRIVACY_POLICY',' Acepto la <a href='.reset_url('policies/privacy_policy.html').' target="_blank" style=\'color: #232323\'>Política de privacidad</a> y los <a href='.reset_url('policies/terms_of_use.html').' target="_blank" style=\'color: #232323\'>Términos y condiciones</a> de FS.');
define('FS_SUPPORT_EMAIL_TOUCH_SOON','Hemos recibido tu solicitud de soporte. Nuestro equipo se pondrá en contacto contigo pronto.');

//shopping_cart save_items 页面的 meta标签 2019.12.23
define('META_TAGS_SHOPPING_CART_TITLE', 'Cesta de la compra');
define('META_TAGS_SHOPPING_CART_DESCRIPTION', 'Compra los mejores productos para tu centro de datos, red empresarial y acceso a Internet. Hacemos que los profesionales de TI realizan sus soluciones de una forma más eficiente y rentable.');
define('META_TAGS_SAVED_ITEMS_TITLE', 'Cestas guardadas');
define('META_TAGS_SAVED_ITEMS_DESCRIPTION', 'Después de añadir los productos a la cesta, puedes hacer clic en "Guardar la cesta" para guardar las colecciones de los artículos. Puedes crear tantas cestas guardadas como desees y utilizarlas para pedidos repetidos.');

//sfp_optical_module 页面的 meta标签 2020.08.05
define('META_TAGS_SFP_TITLE', 'Existencias de transceptores 10G SFP+ CWDM/DWDM');
define('META_TAGS_SFP_DESCRIPTION', 'Esta página te presenta las existencias de los transceptores 10G SFP+ CWDM/DWDM (DWDM SFP+ 80km/40km,CWDM SFP+ 80km/40km/20km/10km) y te ofrce ayuda en las soluciones de WDM.');

//sfp_optical_module 页面的 meta标签 2020.08.05
define('META_TAGS_SFP_TITLE', 'Список запасов 10G CWDM/DWDM SFP+');
define('META_TAGS_SFP_DESCRIPTION', 'Полный ассортимент товаров 10G CWDM/DWDM SFP модулей (DWDM SFP 80 км/40 км, CWDM SFP 80 км/40 км/20 км/10 км) дает краткий обзор инвентаря товаров и предоставляет помощь для решений WDM.');


//专题  walking_through   gr_series_cabinet   sfp_optical_module 语言包
define('FS_SPECIAL_GOALS','Descubre cómo cumplimos tus propósitos');
define('FS_SPECIAL_DESIGN_CENTER','Centro de Diseño');
define('FS_SPECIAL_DESIGN_CENTER_DES','Contamos con la experiencia necesaria para integrar los </br>diversos requerimientos y para ofrecer soluciones <br/> innovadoras, rentables y confiables.');
define('FS_SPECIAL_QUALITY','Centro de calidad');
define('FS_SPECIAL_QUALITY_DES','Ofrecemos productos de alta calidad sometidos a las </br> pruebas más exhaustivas y a las certificaciones <br/> industriales más exigentes.');
define('FS_SPECIAL_TEC','Soporte técnico');
define('FS_SPECIAL_TEC_SMALL','Pedir soporte');
define('FS_SPECIAL_TEC_DES','Obtén asistencia y asesoramiento gratuito en el diseño <br/>de soluciones para tu proyecto de forma virtual.');

define('FS_SUBMIT_SUCCESS','Tu solicitud ##number## se ha enviado.');
define('FS_SUBMIT_SUCCESS_TIP_TXT_SAMPLE','FS te responderá dentro de 1-3 horas por teléfono o correo electrónico durante la jornada laboral.');

define('SAMPLE_EMAIL_31', 'Dirección: ');
define('SAMPLE_EMAIL_32', 'Cantidad: ');
define('SAMPLE_EMAIL_33', 'Lista de muestra(s)');

define('FS_BROWSING_HISTORY','Productos vistos recientemente');

define('FS_PRODUCT_DOWNLOAD', 'Descargas');
define('FS_PRODUCT_MORE', 'Leer más');

//define('FS_PRODUCT_SUPPORT','Soporte técnico');

//结算页、订单确认成功页、银行转账邮件、订单详情
define("PAYMENT_BANK_ACH","Transferencia bancaria/ACH");
define("PAYMENT_BANK_ACH_CA","Transferencia bancaria");
define("PAYMENT_BANK_OF_US","Bank of America");
define("PAYMENT_BANK_VIA","Vía transferencia bancaria");
define("PAYMENT_BANK_ACCOUNT_NAME","FS COM INC");
define("PAYMENT_BANK_WIRE_ROUTING","Número de ruta:");
define("PAYMENT_BANK_SWIFT_CODE","Código Swift:");
define("PAYMENT_BANK_ACH_ROUTING","Número de ruta de ACH:");
define("PAYMENT_BANK_VIA_ACH","Vía ACH");

define("PAYMENT_BANK_ACCOUNT_NAME_COMMON",'Nombre del beneficiario:');
define("PAYMENT_BANK_ACCOUNT",FS_COMMON_HEADER_ACCOUNT.' #:');
define("PAYMENT_BANK_ADDRESS",'Dirección del banco:');

define('FS_PRODUCT_SUPPORT','Descargas');

// QV弹窗公用语言包
define('FS_COMMON_QTY_SMALL','Cantidad');
define('FS_QV_QUICK_VIEW','Vista rápida');
define('FS_SEE_FULL_DETAILS','Ver los detalles');
define('FS_CUSTOMIZED','Añadir a la cesta');
define('FS_PRODUCTS_INFORMATION','Información del producto');
define('FS_CUSTOMER_ALSO_VIEWED','Los clientes también han visto');

// fairy 2019.1.15 add 公共标题需要
define('FS_TITLE_COMPATIBLE','Compatible');

//ery 2020.05.25  buy more 功能相关语言包
define('FS_BUY_MORE_01', 'Comprar otra vez');
define('FS_BUY_MORE_02', 'El artículo que comprarás a través de nuestra opción "Comprar otra vez" será totalmente igual al de tu pedido %s.');	//%s会替换成订单号
define('FS_BUY_MORE_03', 'Artículo igual al de tu pedido anterior %s.');		//%s会替换成订单号


//头部下拉版块
define('FS_HEADER_SUPPORT','Soporte');
define('FS_HEADER_TEC_SUPPORT','Soporte técnico');
define('FS_HEADER_CUSTOMER_SUPPORT','Atención al cliente');
define('FS_HEADER_SERVICE_SUPPORT','Nuestras políticas');
define('FS_HEADER_TEC_DES','Accede a nuestra biblioteca de recursos para que disfrutes de nuestros artículos, casos de éxito, vídeos y mucho más. También te ofrecemos asistencia técnica para que puedas obtener soluciones a tu medida.');
define('FS_HEADER_TEC_URL_01','Documentos técnicos');
define('FS_HEADER_TEC_URL_02','Banco de pruebas');
define('FS_HEADER_TEC_URL_03','Descarga de software');
define('FS_HEADER_TEC_URL_04','Compromiso con la calidad');
define('FS_HEADER_TEC_URL_05','Casos de éxito');
define('FS_HEADER_TEC_URL_06','Garantía');
define('FS_HEADER_TEC_URL_07','Vídeos');
define('FS_HEADER_SUPPORT_RIGHT_DES','Servicio técnico especializado de FS');
define('FS_HEADER_SUPPORT_RIGHT_URL','Contáctanos');
define('FS_HEADER_CUSTOMER_DES','Obtén ayuda instantánea tanto antes como después de realizar tu compra: consulta información sobre tus pedidos, cómo hacerlos, cómo rastrearlos o sobre otros temas de tu interés.');
define('FS_HEADER_CUSTOMER_URL_01','Solicita una cotización');
define('FS_HEADER_CUSTOMER_URL_02','Solicita devolución/cambio');
define('FS_HEADER_CUSTOMER_URL_03','Pide una muestra');
define('FS_HEADER_CUSTOMER_URL_04','Cuenta Net');
define('FS_HEADER_CUSTOMER_URL_05','Envía tu PO');
define('FS_HEADER_CUSTOMER_URL_06','E-Rate');
define('FS_HEADER_CUSTOMER_URL_07','Rastrea tu paquete');
define('FS_HEADER_CUSTOMER_URL_08','Nuevos productos');
define('FS_HEADER_CUSTOMER_URL_09','Descuentos y ofertas');
define('FS_HEADER_CUSTOMER_URL_10','Autenticación de productos');
define('FS_HEADER_CUSTOMER_URL_11','Solicita Demo');
define('FS_HEADER_SERVICE_DES','Conoce nuestras políticas relacionadas con tu cuenta, envíos, devoluciones, etc. FS se compromete a brindarte una experiencia de compra simple y segura.');
define('FS_HEADER_SHIPPING_DELIVERY','Envíos y entregas');
define('FS_HEADER_RETURN_POLICY','Política de devoluciones');
define('FS_HEADER_PAYMENT','Métodos de pago');
define('FS_HEADER_HELP_CENTER','Soporte de FS');
define('FS_HEADER_COMPANY','Nuestra empresa');
define('FS_HEADER_ABOUT_US','¿Quiénes somos?');
define('FS_HEADER_CONTACT_US','Contáctanos');
define('FS_HEADER_NEWS','Nuestros socios');
define('FS_HEADER_ABOUT_DES','FS es líder mundial en el suministro de hardware de telecomunicaciones y en soluciones técnicas en materia de proyectos. Nos dedicamos a ayudarte a construir, conectar, proteger y optimizar tu infraestructura óptica.');
define('FS_HEADER_ABOUT_EXPLORE','Explora FS');
define('FS_HEADER_CONTACT_DES','Estamos a tu disposición. Ponte en contacto con nosotros en cualquier momento para que disfrutes del mejor servicio técnico profesional y de una atención especializada.');
define('FS_HEADER_LEARN_MORE','Leer más');
define('FS_HEADER_NEWS_DES','<dd>FS te ofrece soluciones personalizadas y rentables para tu negocio. A lo largo de nuestra trayectoria, nos hemos ganado la confianza de algunas de las corporaciones más influyentes del mundo, gracias a nuestros productos y servicios de la más alta calidad.</dd>');
define('FS_HEADER_NEWS_READ_MORE','<a class="home_solution_sub_level_right_dd_a" href="'.reset_url('company/fiberstore_with_partners.html').'"><span>Socios Internacionales de FS</span><i class="iconfont icon">&#xf089;</i></a>');
define('FS_HEADER_NEWS_RIGHT_DES','FS ha logrado una serie de certificaciones internacionales autorizadas');
define('FS_HEADER_NEWS_RIGHT_DATE','8 de junio de 2020');

define('FS_CUSTOMER_SUPPORT_TIP','El #XXX es un producto de personalización. Por favor, ponte en contacto con tu gerente de cuenta para más información.');
// 德国仓
define('FS_RMA_WAREHOUSE_EU','<dt>FS.COM GmbH </dt>
			<dd>NOVA Gewerbepark, Building 7, Am Gfild 7 85375, Neufahrn bei Munich Germany</dd>
			<dd>Tel: +49 (0) 8165 80 90 517</dd>');
define('FS_RMA_WAREHOUSE_US','<dt>FS.COM INC </dt>
			<dd>380 CENTERPOINT BLVD NEW CASTLE, DE 19720, United States</dd>
			<dd>Tel: +1 (888) 468 7419</dd>');
// 美东仓
define('FS_RMA_WAREHOUSE_US_EAST','<dt>A/A: FS.COM Inc.</dt>
					<dd>Dirección: 380 Centerpoint Blvd, New Castle, DE 19720, United States</dd>
					<dd>Teléfono: +1 (888) 468 7419</dd>');
// 澳洲仓
define('FS_RMA_WAREHOUSE_AU','<dt>FS.COM PTY LTD</dt>
				<dd>57-59 Edison Road, Dandenong South, VIC 3175, Australia</dd>
				<dd>Tel: +61 3 9693 3488</dd>
				<dd>ABN: 71 620 545 502</dd>');
// 新加坡仓
define('FS_RMA_WAREHOUSE_SG','<dt>A/A: FS Tech Pte Ltd.</dt>
				<dd>Dirección: 30A Kallang Place #11-10/11/12, Singapore 339213</dd>	
			    <dd>Teléfono: +(65) 6443 7951</dd>');
//俄罗斯仓
define('FS_RMA_WAREHOUSE_RU','<dt>《FiberStore.COM》Ltd.</dt>
           <dd> No.4062, d. 6, str. 16, Proektiruemyy proezd Moscow 115432, Russian Federation</dd>
            <dd>Tel: +7 (499) 643 4876</dd>');
define('FS_RMA_WAREHOUSE_CN','<dt>A/A: FS. COM LIMITED</dt>
			<dd>Dirección: A115 Jinhetian Business Centre No.329, Longhuan Third Rd Longhua District Shenzhen, 518109, China</dd>
			<dd>Teléfono: +86-0755-83571351</dd>');

//TW账户中心改版
define('FS_ACCOUNT_TW_QUOTE','Cotizaciones');
define('FS_ACCOUNT_TW_CREDIT','Cuenta Net');
define('FS_ACCOUNT_TW_CREDIT_DETAILS','Detalles de tu crédito');
define('FS_ACCOUNT_TW_USER','Información del usuario');
define('FS_ACCOUNT_TW_SUPPORT','Tus casos');
define('FS_ACCOUNT_TW_TAX','Solicita exención del impuesto');
define('FS_ACCOUNT_TW_USEFUL','Recursos útiles');
define('FS_ACCOUNT_TW_ACCOUNT','Información de la cuenta');
define('FS_ACCOUNT_TW_YOU','Tienes pedidos pendientes de pago.');
define('FS_ACCOUNT_TW_ORDERS','Pedidos');
define('FS_ACCOUNT_TW_MOST_ORDER','Pedido más reciente');
define('FS_ACCOUNT_TW_VIEW_ORDERS','Ver todos los pedidos');
define('FS_ACCOUNT_TW_ORDERS_SEARCH','Pedido #, PO #, Artículo #, P/N, Comentarios...');
define('FS_ACCOUNT_TW_PENDING_PAYMENT','Pendientes');
define('FS_ACCOUNT_TW_WAIT','En proceso');
define('FS_ACCOUNT_TW_TRANSIT','En tránsito');
define('FS_ACCOUNT_TW_DELIVERED','Entregados');
define('FS_ACCOUNT_TW_PENDING_REVIEW','Reseñas');
define('FS_ACCOUNT_TW_NO_ORDER','No se encuentra ningún pedido.');
define('FS_ACCOUNT_TW_VIEW_CART','Ver la cesta');
define('FS_ACCOUNT_TW_VIEW_TICKETS','Ver todos los casos');
define('FS_ACCOUNT_TW_CREATE_TICKET','Crear un nuevo caso');
define('FS_ACCOUNT_TW_SEARCH_TICKET','Caso #, contenido...');
define('FS_ACCOUNT_TW_TICKET','Caso #');
define('FS_ACCOUNT_TW_TICKET_TYPE','Tipo de soporte');
define('FS_ACCOUNT_TW_TICKET_COMMENT','Contenido');
define('FS_ACCOUNT_TW_TICKET_DATE','Fecha de solicitud');
define('FS_ACCOUNT_TW_TICKET_STATUS','Estado');
define('FS_ACCOUNT_TW_TICKET_ACTION','Actos');
define('FS_ACCOUNT_TW_NO_TICKET','No hay ningún caso.');
define('FS_ACCOUNT_TW_ORDER','Pedido #');
define('FS_ACCOUNT_TW_SPLIT_ORDER','Pedido dividido');
define('FS_ACCOUNT_TW_DELIVERY','Entrega');
define('FS_ACCOUNT_TW_DELIVERY_ON','Entragado en ');
define('FS_ACCOUNT_TW_THE','Los siguientes productos no se pueden volver a pedir directamente por el motivo específico que se indica a continuación. Haz clic en el botón "Saltar y continuar" para volver a añadir los otros productos a la cesta.');
define('FS_ACCOUNT_TW_THE_NO','Los siguientes productos no se pueden volver a pedir directamente por el motivo específico que se indica a continuación.');
define('FS_ACCOUNT_TW_ITEMS','El artículo que comprarás a través de nuestra opción "Comprar otra vez" será totalmente igual al de tu pedido #%s.');
define('FS_ACCOUNT_TW_YOU_CAN','Puedes usar este botón para volver a añadir todos los productos de este pedido a la cesta.');
define('FS_ACCOUNT_TW_ORDER_AGAIN','Comprar otra vez');
define('FS_ACCOUNT_TW_CREATE_TICKET','Crear un nuevo caso');
define('FS_ACCOUNT_TW_SUPPORT_TYPE','Tipo de soporte');
define('FS_ACCOUNT_TW_ATTACH_PO','Subir PO');
define('FS_ACCOUNT_TW_SHOW_MORE','Mostrar más');
define('FS_ACCOUNT_TW_BASIC_INFO','Información básica');
define('FS_ACCOUNT_TW_ADDRESS_INFO','Información de dirección');
define('FS_ACCOUNT_TW_QUOTES_LIST_TIPS','Añade el siguiente producto a la cesta de compra y crea una cotización.');
define('FS_ACCOUNT_TW_MOST_QUOTE','Cotización más reciente');
define('FS_ACCOUNT_TW_VIEW_QUOTES','Ver todas las cotizaciones');
define('FS_ACCOUNT_TW_NO_QUOTE','No se encuentra ninguna cotización.');
define('FS_ACCOUNT_TW_QUOTE_ITEM','Cotización #, artículo #');
define('FS_ACCOUNT_TW_QUOTE_AGAIN_TIPS1','No puedes solicitar cotización de nuevo del siguiente producto debibo al motivo específico presentado abajo.');
define('FS_ACCOUNT_TW_QUOTE_AGAIN_TIPS2','No puedes solicitar cotización de nuevo del siguiente producto debibo al motivo específico presentado abajo. Haz clic en "Soltar y continuar" para añadir otros productos a la cesta y crear una cotización.');

define('FS_FOOTER_EXPLORE','EXPLORAR');
define('FS_HEADER_NEW_PRODUCT','Nuevos productos');
define('FS_HEADER_CHANGE','Cambiar');
define('FS_COMMON_VIEW_MORE','Ver más');
define('FS_CART_EMPTY_TIP','Inicia sesión para ver si tienes artículos guardados. O sigue comprando.');
define('BIllS_TIPS1','Puedes consultar todas tus facturas aquí.');
define('BIllS_TIPS2','Puedes consultar el estado de tu cuenta Net y todas las facturas aquí.');
define('TIPS_BUTTON', 'OK');
define('TIPS_NEW', 'Nuevo');
define('FS_ATTRIBUTE_CUSTOMIZED','Personalizar');
//warranty 新增分类质保信息
define('FS_WARRANTY_YEARS',' años');
define('FS_WARRANTY_YEAR',' año');
define('FS_WARRANTY_DAYS',' días');
define('FS_WARRANTY_CONSUMABLE','Consumible');
define('FS_WARRANTY_UNAVAILABLE','No disponible');
define('FS_WARRANTY_SUB_CATEGORY','Subcategoría');
define('FS_WARRANTY_RETURN','Tiempo para<br>el reembolso');
define('FS_WARRANTY_CHANGE','Tiempo para <br>el cambio');
define('FS_WARRANTY_PERIOD','Período de<br>garantía');
define('FS_WARRANTY_NOTE','Observaciones');

define('ORDER_PAYMENT_TIPS','Por favor, asegúrate de que tu dirección de facturación coincida con la información de tu cuenta de tarjeta de crédito.');
define('ORDER_PAYMENT_SAFE','Pago seguro y encriptado');
define('ORDER_PAYMENT_TIPS_2','Tus datos se utilizarán solo para el procesamiento de tu pedido y no los almacenamos.');

