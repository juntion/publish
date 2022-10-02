<?php 
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
define('ACCOUNT_SETTING','Configuración de cuenta');
define('FS_RETURN_ORDERS','Pedidos de devolución');
define('FS_MY_QUOTES','Mis cotizaciones');
define('FS_WISH_LIST','Lista de deseos');
define('FS_MY_CASES','Mis casos');
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
define("MANAGE_ORDER_UPLOAD_ERROR_NEW","Tipos de archivo permitidos: PDF, JPG, PNG. <br/>El tamaño de archivo máximo es 4MB.");
define("FS_UPLOAD_PO_FILE",'Subir archivo PO');

// 2018.12.7 fairy
define('F_RECEIPT_CONFIRMATION_SUCCESS_TIP','Gracias por sus compras en fiberstore, esperamos su próxima visita.');

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
define("FS_CHECKOUT_ERROR6", "Se requiere tu país.");
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
define('FS_ORDER_ALL','Todos los pedidios');
define('FS_ORDER_PENDING','Pendiente');
define('FS_ORDER_COMPLETED','Completo');
define('FS_ORDER_CANCELLED','Cancelado');
define('FS_ORDER_PURCHASE','Comprar');
define('FS_ORDER_PROGRESSING','En proceso');
define('FS_ORDER_RETURN_ITEM','Ítem de devolución');

define('FS_FILE_UPLOADED_SUCCESS_TXT','El documento se ha cargado correctamente.');