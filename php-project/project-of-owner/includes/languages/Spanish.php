<?php

  define('FOOTER_TEXT_BODY', 'Copyright &copy; 2009-' . date('Y') . ' <a href="' . zen_href_link(FILENAME_DEFAULT) . '" target="_blank">' . FS.COM . '</a>. All Rights Reserved.   Privacy   Terms of use');


  define('F_BODY_HEADER_ITEM','artículo');
  /*bof language for my_account*/
  //define('FIBERSTORE_CDN_IMAGES','https://d2gwt4r5cjfqmi.cloudfront.net/');
  define('FIBERSTORE_CDN_IMAGES','/images/');

  define('FIBERSTORE_SHIP_TIP','Los pedidos recibidos antes de la 1:00 PM por PST (hora estándar del Pacífico) de lunes a viernes (excepto días festivos) serían enviados el siguiente día laboral.');
  define('FIEBRSTORE_SHIP_TIME','Puede haber alguna diferencia entre el tiempo estimado y el tiempo real.');

  //夏令时--冬令时
  define('SUMMER_TIME',true);
  if(SUMMER_TIME){
      define('FS_SUMMER_OR_WINTER_TIME','3:30pm (UTC/GMT+2)');
      define('FS_CHECKOUT_TIME','4:30pm UTC/GMT+2');
  }else{
      define('FS_SUMMER_OR_WINTER_TIME','3:00pm (UTC/GMT)');
      define('FS_CHECKOUT_TIME','4:30pm UTC/GMT+1');
  }

  //装箱页面新增
  define("FS_PRODUCT_INFO_SIZE","Paquete:");
  define("FS_PRODUCT_INFO_PIECE","1 pieza");
  define("FS_PRODUCT_INFO_CASE","Ordenar por caja(");
  define("FS_PRODUCT_INFO_PIS","pzs/caja");
  define("FS_PRODUCT_INFO_PIS_1","pzs/");

  //******************body box menu***********************/
  define('F_BODY_HEADER_BACK','Volver a la página de inicio de Fiberstore');
  define('F_BODY_HEADER_GS','Envíos<br>global');
  define('F_BODY_HEADER_ITEM_TWO','artículos');
  define('F_BODY_HEADER_ITEMS','artículos');
  define('F_BODY_MENU_CATEG','Todas las categorías');
  define('F_BODY_MENU_HOME','Inicio');
  define('F_BODY_MENU_WHOLESALES','Venta al por mayor');
  define('F_BODY_MENU_PROD','Soporte');
  define('F_BODY_MENU_TUTORIAL','Tutorial');
  define('F_BODY_MENU_ABOUT','Sobre nosotros');
  define('F_BODY_MENU_SUPP','Servicio');
  define('F_BODY_MENU_CONTANT','Contacto');
  define('FS_EMAIL_FSCOM',zen_href_link('index'));
  //******************Product List************************/
  define('F_PRODUCT_IMAGES','Imágenes');
  define('F_PRODUCT_STATUS','Estado');
  define('F_PRODUCT_WAVELENGTH','Longitud de onda');
  define('F_PRODUCT_DISTANCE','Distancia');
  define('F_PRODUCT_DATERATE','Fecha');
  define('F_PRODUCT_SHIPDATE','Fecha de envío');
  define('F_VOLUME_PRICE','Precio por volumen');
  define('F_VOLUME_PRICE_GET','Si necesitas un gran volumen de pedio, puedes solicitar una <a href="<?php echo $href;?>" target="_blank">cuenta de negocio</a> or <a href="<?php echo zen_href_link(FILENAME_CONTACT_US)?>" target="_blank">contact us</a> para obtener precios preferenciales.');
  define('F_OPTION_ARRAY1','Precio de más alto a más bajo');
  define('F_OPTION_ARRAY2','Precio de más bajo a más alto');
  define('F_OPTION_ARRAY3','Popularidad');
  define('F_OPTION_ARRAY4','Valoración media de los clientes');
  define('F_OPTION_ARRAY5','Lo más nuevo');

  define('F_PRODUCT_RECOMMEND','Productos Recomendados');
  define('F_PRODUCT_RESULTS','<div class="results_font">¡Lo sentimos, encontramos <s>0</s> resultados!  <a href="'.zen_href_link(FILENAME_DEFAULT, 'cPath='.(int)$current_category_id).'">Buscar otros productos</a>.</div>');
  define('F_PRODUCT_REVIEWS','reseñas');
//******************LEFT_sidebar************************/

  define('FS_MY_SALES_REPRESENT','Mi representante de venta');
  define('FS_MY_CONTACT','Contacto');
  define('FS_TITLE','Título');
  define('FS_CONTENT','Contenido');
  define('FS_ASK_QUESTION','Haz una pregunta a');
  define('FS_QUESTION','Por favor introduce tus preguntas');
  define('FS_SUBMIT','Enviar');
  define('FS_CANCEL','Cancelar');

/* 购物车层 */
define('FIBERSTORE_REMOVE','Eliminar');
define('FIBERSTORE_CART_TOTAL','Total de la cesta:');
define('FIBERSTORE_EDITE_ORDER','Editar mi pedido');
define('FIBERSTORE_CHECK_YOU_ORDER','Tramitar pedido');
define('FIBERSTORE_SHOPPING_HELP','Tu cesta está vacía.');

define('FS_FILTER', 'Filtro');
define('FS_PROCEED_TO_CHECKOUT','PROCEDER A PAGAR');
define('FS_ITEMS','Artículos');
define('FS_CART','Cesta');
define('FS_VIEW_ALL','Ver todo');
/*******************Checkout***********************************/
  define('NAVBAR_TITLE_1','Tramitar pedido');
  define('F_SHIPPING_ADDRESS','Dirección de envío');
  define('F_M_BILLING_ADDRESS','Gestionar tu dirección de facturación');
  define('F_NEW_SHIPPING_ADDRESS','Añadir una nueva dirección de envío');
  define('F_SHIPPING_METHOD','Método de envío');
  define('F_CART','Cesta');
  define('F_SUCCESS','Pago con éxito');
  define('F_SHIPPINGTIME_COST','<th width="500">Método de envío
                      </th>
                    <th width="230">Fecha de envío estimada
                      </th>
                    <th width="118">Importe
                      </th>');
  define('F_FEDEX_IP','FedEx IP');
  define('F_PRIORITY','Prioridad');
  define('F_FREIGHT_COLLECT','Facturación por cobrar');
  define('F_WARNING','Si prefieres usar tu propia cuenta de envío, por favor provee el número de cuenta, y Fiberstore no cobrará el pago del flete.');
  define('F_SHIPPING_METHOD','Método de envío: ');
  define('F_EXPRESS_ACCOUNT','Cuenta de envío: ');
  define('F_NO_SHIPPING','No hay envío disponible para este pais, para obtener más detalles, por favor');
  define('F_CONTACT_US','contacta con nosotros');
  define('F_TIPS','Consejos');
  define('F_TIPS_MSG','Por favor introduce tu dirección de envío por arriba, el sistema de Fiberstore te mostrará todos los métodos de envío para tu país');
  define('F_WHEN_ORDER_ARRIVE','¿Cuándo llegará mi pedido? ');
  define('F_PROCESSING','Tiempo de procesamiento y de envío');
  define('F_MORE_INFORMATION','Más información');
  define('F_PROCESSING_TIME','Tiempo de procesamiento:');
  define('F_ALL_PRODUCTS','Todos los productos se requiere el procesamiento antes de enviarlos. El procesamiento incluye la selección de los productos, las comprobaciones del aseguramiento de la calidad y el embalaje para el envío.<br />
                <b>El tiempo medio de procesamiento:</b> con un promedio de 2 a 5 días<br />
                <b>Excepciones:</b> Depende. Por favor contacta con nuestro representante de ventas para obtener más información.<br />
                <br />
                <span>Entrega:</span><br />
                El plazo de entrega depende del método de envío:<br />
                <b>Entrega rápida:</b> 1 a 4 días laborales<br />
                <b>Entrega estándar:</b> 2 a 6 días laborales<br />
                <b>Entrega económica:</b> 10 a 30 días laborales <br />
                FiberStore.com elige el mejor transportista según los requisitos de tu pedido y el destino de envío. En algunas circunstancias especiales, contactarémos contigo.<br />');
  define('F_PAYMENT_METHOD','Método de pago');
  define('F_WE_CURRENTLY','Ahora aceptamos transferencias bancarias para todos los pedidos. También tomamos muy en serio la seguridad , así que tus datos están seguros');
  define('F_CART_SUMMARY','Resumen de la cesta');
  define('F_ITTEM','Artículo');
  define('F_QTY','Cantidad');
  define('F_WEIGHT','Peso');
  define('F_PRICE','Precio');
  define('F_TOTA_AMOUNT','Importe total');
  define('F_UNIT_PRICE','Precio unitario');
  define('F_TOTAL','Total:');
  define('F_SHIPPING_COST','(+)Cargos de envío:');
  define('F_EXCLUDING_TAXES','¿Sin impuestos?');
  define('F_PO','Ingresa el número del pedido');
  define('FIBERSTORE_WAIT_PROCESSING','Procesamiento');
  define('DISCLAIMER_ORDERS','Descargo de responsabilidad de envíos internacionales');
  define('DISCLAIMER_ORDERS_CONMENT','Los aranceles de importación, los impuestos y los honorarios de corretaje no se incluyen en el precio del producto ni en los cargos de envío y manejo, y serán cargados por el transportista para algunos paquetes. Como la oficina de aduanas aplica cargos de aduana aleatoriamente sobre los paquetes llegados, no podemos preverlo por nuestra parte.<br />
            <br />
            El receptor debe pagar dichos cargos porque sólo cobramos los gastos de transportación para los paquetes. Puedes comprobarlo con la oficina de aduanas de tu país para confirmar los cargos adicionales.');

  define('FS_CHECK_PAYTIT','Ahora aceptamos PayPal, tarjetas de crédito/débito y transferencia bancaria para todos los pedidos. También tomamos muy en serio la seguridad , así que tus datos están seguros');
define('FS_CHECK_PAY1','Tarjetas de crédito/débito');
define('FS_CHECK_PAY2','Transferencia bancaria');
define('FS_CHECK_NOTE','Aviso');
define('CHECK_PAY1_TIT','Los usuarios existentes de PayPal pueden realizar el pago usando la cuenta de PayPal');
define('CHECK_PAY1_CON','Nuevos usuarios pueden registrar una cuenta de PayPal, y luego pagar en el sitio web de PayPal.');
define('CHECK_PAY1_FOT','Puedes enviarnos el dinero directamente a nuestra cuenta de Paypal, nuestra cuenta es:');
define('CHECK_PAY2_TIT','Aceptamos las siguientes tarjetas:');
define('CHECK_PAY2_CON','Para asegurar la seguridad, no guardaremos tus datos de tarjetas.');
define('CHECK_PAY3_TIT','Información sobre los beneficiarios de transferencia bancaria:');
define('CHECK_PAY3_ADD1','Nombre del Banco Beneficiario:');
define('CHECK_PAY3_ADD2','Nombre de cuenta del Beneficiario:');
define('CHECK_PAY3_ADD3','Número de cuenta del Beneficiario:');
define('CHECK_PAY3_ADD4','Código SWIFT:');
define('CHECK_PAY3_ADD5','Dirección del Banco Beneficiario:');
define('CHECK_PAY3_ADD6','Dirección de nuestra Empresa:');
define('CHECK_PAY3_ADD7','Eastern Side, Second Floor, Science & Technology Park, No.6, Keyuan Road, Nanshan District, Shenzhen, China');
define('CHECK_PAY3_CON','El comprador debe pagar todos los gastos (pagador y beneficiario) generados por la transferencia bancaria. Si no, la tarifa será cargada del pago que recibimos.');
define('FS_CHECK_TOTAL','<b>Descargo de responsabilidad de envíos internacionales</b><br /><br />

Los aranceles de importación, los impuestos y los honorarios de corretaje no se incluyen en el precio del producto ni en los cargos de envío y manejo, y serán cargados por el transportista para algunos paquetes. Como la oficina de aduanas aplica cargos de aduana aleatoriamente sobre los paquetes llegados, no podemos preverlo por nuestra parte.<br /><br />

El receptor debe pagar dichos cargos porque sólo cobramos los gastos de transportación para los paquetes. Puedes comprobarlo con la oficina de aduanas de tu país para confirmar los cargos adicionales.');
define('FS_CHECK_EDIT','Editar mi pedido');
define('FS_CHECK_SUB1','Pagar con Paypal');
define('FS_CHECK_SUB2','Enviar pedido');
define('FS_ADDRESS_TIT','Indica los campos obligatorios.');
define('FS_ADDRESS_TIT1','Dirección de facturación');
define('FS_ADDRESS_TIT2','Añadir una nueva dirección de facturación');
define('FS_ADDRESS_LI1','Nombre:');
define('FS_ADDRESS_LI2','Apellido:');
define('FS_ADDRESS_LI3','Línea de dirección:');
define('FS_ADDRESS_LI4','Ciudad:');
define('FS_ADDRESS_LI5','País:');
define('FS_ADDRESS_LI6','Por favor elige');
define('FS_ADDRESS_LI7','Estado / Provincia / Región:');
define('FS_ADDRESS_LI8','ZIP / Código postal:');
define('FS_ADDRESS_LI9','Número de teléfono:');
define('FS_ADDRESS_LI10','Guardar');
define('FS_ADDRESS_LI11','Cancelar');
define('FS_ADDRESS_LI12','Procesando ...');
define('FS_CHECK_COLLECT','Facturación por cobrar');
define('FS_COLLECT_TIT','Método de envío:');
define('FS_COLLECT_TIT1','Cuenta de envío:');
 /************************end_checkout******************************/

  define('FIBERSTORE_SELECT','Por favor elige...');

define('EMAIL_HEADER_INFO', '
	<!-- 2018.6.26头部-->
			<div class="em_img" style="text-align: center;margin-top: 20px;margin-bottom: 8px;">
				<a href="'.zen_href_link('index').'">
					<img style="display: inline-block;" width="150" src="https://www.fs.com/images/email-logo.png"/>
				</a>		
			</div>
			<div class="em_a" style="text-align: center;margin-bottom: 20px;">
				<a style="display: inline-block;font-size: 12px;color: #232323;line-height: 20px;text-decoration: none;" href="'.HTTPS_SERVER.reset_url('support/Data-Center-Products.html').'">Centro de Datos</a>
				<em class="em_em" style="display: inline-block;margin-left: 5px;margin-right: 5px;height: 10px;width: 1px;background: #616265;"></em>
				<a style="display: inline-block;font-size: 12px;color: #232323;line-height: 20px;text-decoration: none;" href="'.HTTPS_SERVER.reset_url('support/Enterprise-Small-Business.html').'">Red Empresarial</a>
				<em class="em_em" style="display: inline-block;margin-left: 5px;margin-right: 5px;height: 10px;width: 1px;background: #616265;"></em>
				<a style="display: inline-block;font-size: 12px;color: #232323;line-height: 20px;text-decoration: none;" href="'.HTTPS_SERVER.reset_url('support/ISP-Networks.html').'">Red de Transporte Óptico</a>
			</div>');

define('EMAIL_FOOTER_INFO','
			<hr class="em_hr" style="border:none;border-top: 1px solid #e5e5e5;" />
			<div class="em_p" style="margin-top: 36px;margin-bottom: 26px;text-align: center;font-size: 12px;">Comparte tu experiencia de servicio <a style="text-decoration: none;font-size: 12px;line-height: 20px;color: #232323;text-align: center;padding-bottom: 10px;margin-bottom: 20px;" href="'.zen_href_link('index').'">#FS.COM</a></div>
			<div class="em_icon" style="text-align: center;">
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: 0 0;" href="'.sourceHtml('linkedin', false).'"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -20px 0;" href="'.sourceHtml('youtube', false).'"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -40px 0;" href="'.sourceHtml('facebook', false).'"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -60px 0;" href="'.sourceHtml('twitter', false).'"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -80px 0;" href="https://www.pinterest.co.uk/?show_error=true"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -100px 0;" href="'.sourceHtml('instagram', false).'"></a>
			</div>
			<div class="em_a01" style="text-align: center;margin-top: 18px;margin-bottom: 14px;">
				<a style="text-decoration: none;font-size: 12px;color: #232323;line-height: 20px;display: inline-block;margin: 0 6px;" href="'.zen_href_link('contact_us').'">Contáctenos</a>
				<a style="text-decoration: none;font-size: 12px;color: #232323;line-height: 20px;display: inline-block;margin: 0 6px;" href="'.zen_href_link('account_newsletters').'">Mi Cuenta</a>
				<a style="text-decoration: none;font-size: 12px;color: #232323;line-height: 20px;display: inline-block;margin: 0 6px;" href="'.zen_href_link('shipping_delivery').'">Envío & Entrega</a>
				<a style="text-decoration: none;font-size: 12px;color: #232323;line-height: 20px;display: inline-block;margin: 0 6px;" href="'.HTTPS_SERVER.reset_url('policies/day_return_policy.html').'">Política de Devolución</a>
			</div>
			<div class="em_p01" style="font-size: 12px;line-height: 20px;color: #232323;text-align: center;">Está suscrito a este email como $user_email.</div>
			<div class="em_p01" style="font-size: 12px;line-height: 20px;color: #232323;text-align: center;">
				<a style="text-decoration: none;font-size: 12px;line-height: 20px;color: #232323;text-align: center;" href="'.zen_href_link('account_newsletters').'">Haga clic aquí para modificar sus preferencias o darse de baja.</a>
			</div>');



/* 产品、分类公用 */
define('FS_CUSTOMILIZED_ADD_TO_CART','Añadir a la cesta');
define('FS_ADD_TO_CART', 'Añadir a la cesta');
define('FS_ADD','Añadir');
define('CATEGORIES_HEADING_DETAILS','Ver detalles');
define('FS_VIEW_CART', 'Ver la cesta');
define('FS_REVIEWS', 'Comentarios');
define('FS_REVIEWS_SMALL', 'comentarios');
define('FS_REVIEW','comentario');
define('FS_SHARE', 'Compartir');
define('FS_NEED_HELP', 'Contacto');
define('FS_COMPATIBLE', 'Compatible');
define('FS_LENGTH', 'Longitud');
define('FS_TOTAL_LENGTH', 'Longitud total');
define('FS_CUSTOM_LENGTH', 'Longitud personalizada');
define('FS_CUSTOM','Personalizar');
define('FS_SHIPPING_COST', 'Costo de envío');
define('FS_SHIP_SAME_DAY', 'Se enviará el mismo día.');
define('FS_SHIP_NEXT_DAY', 'Estimado el día siguiente');
define('FS_OUT_OF_STOCK', 'Agotado');
define('FS_DELETE_PRODUCT', 'Eliminar el producto');
define('FS_AVAILABILTY', 'Disponibilidad');
define('FS_PRODUCTS_ORDERS_RECEIVED','Las órdenes recibidas antes de la 1:00 PM por PST (hora estándar del Pacífico) de lunes a viernes (excepto días festivales) serían enviadas en el siguiente día laboral.');
define('FS_PRODUCTS_ACTUAL_TIME','Puede haber diferencia entre el tiempo estimado y el tiempo real.');
define('PRODUCT_INFO_ADD','Añadir');
define('PRODUCT_INFO_ADDED','Añadido');
define('FS_PRODUCT_DETAILS','Detalles del producto');
/* 产品、分类公用 */
define('FS_TRANSCEIVER_TYPE','Tipo de transceptor');

 define('ACCOUNT_FOOTER_TITLE','Comprar en confianza');

 define('ACCOUNT_FOOTER_SHOPPING','Comprar en fs.com ');

 define('ACCOUNT_FOOTER_SECURE','Es seguro y confiable.');

 define('TEXT_LOGIN_GUARANTEED','¡Garantizado!');

 define('ACCOUNT_FOOTER_PAY','No debes pagar nada si se aplican cargos no autorizados a tu tarjeta por compras hechas en fs.com.');

 define('ACCOUNT_FOOTER_SAFE','Garantía de compras seguras');

 define('ACCOUNT_FOOTER_INFORMATION','Toda la información es encriptada y transmitida sin riesgos utilizando el protocolo de Secure Sockets Layer (SSL).');

 define('ACCOUNT_FOOTER_HOW','¿Cómo protegemos tus datos personales?');

 define('ACCOUNT_FOOTER_FREE','Envío y devolución gratis');

 define('ACCOUNT_FOOTER_SHOP','Si no estás satisfecho con tus compras en FiberStore, ¡puedes devolver los productos a su estado original dentro de un plazo de 7 días para obtener un reembolso!');

 define('ACCOUNT_FOOTER_DELIVER','Con el objetivo de operar sin preocupación y reducir el coste relacionado con las reparaciones, FiberStore ofrece una garantía de por vida como característica estándar de casi todas las gamas de productos.');

 define('ACCOUNT_FOOTER_LEARN','Leer más');

 define('TEXT_FIBERSTORE_REGIST_RESPECTS','fs.com respeta tu privacidad. No alquilaremos ni vendremos tu información personal a ninguna parte.');

define('TEXT_FIBERSTORE_REGIST_PRIVACY','Políticas de privacidad.');

////
// Return date in raw format
// $date should be in format mm/dd/yyyy
// raw date is in format YYYYMMDD, or DDMMYYYY
  if (!function_exists('zen_date_raw')) {
    function zen_date_raw($date, $reverse = false) {
      if ($reverse) {
        return substr($date, 3, 2) . substr($date, 0, 2) . substr($date, 6, 4);
      } else {
        return substr($date, 6, 4) . substr($date, 0, 2) . substr($date, 3, 2);
      }
    }
  }

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
  define('LANGUAGE_CURRENCY', 'USD');

// Global entries for the <html> tag
  define('HTML_PARAMS','dir="ltr" lang="en"');

// charset for web pages and emails
  define('CHARSET', 'UTF-8');

// footer text in includes/footer.php
  define('FOOTER_TEXT_REQUESTS_SINCE', 'requests since');

// Define the name of your Gift Certificate as Gift Voucher, Gift Certificate, Zen Cart Dollars, etc. here for use through out the shop
  define('TEXT_GV_NAME','Certificado de regalo');
  define('TEXT_GV_NAMES','Certificados de regalo');

// used for redeem code, redemption code, or redemption id
  define('TEXT_GV_REDEEM','Código de Canje');

// used for redeem code sidebox
  define('BOX_HEADING_GV_REDEEM', TEXT_GV_NAME);
  define('BOX_GV_REDEEM_INFO', 'Código de Canje: ');

// text for gender
  define('MALE', 'Señor');
  define('FEMALE', 'Señora');
  define('MALE_ADDRESS', 'Señor');
  define('FEMALE_ADDRESS', 'Señora');

// text for date of birth example
  define('DOB_FORMAT_STRING', 'dd/mm/aaaa');

//text for sidebox heading links
  define('BOX_HEADING_LINKS', '&nbsp;&nbsp;[more]');

// categories box text in sideboxes/categories.php
  define('BOX_HEADING_CATEGORIES', 'Categorías');

// manufacturers box text in sideboxes/manufacturers.php
  define('BOX_HEADING_MANUFACTURERS', 'Fabricantes');

// whats_new box text in sideboxes/whats_new.php
  define('BOX_HEADING_WHATS_NEW', 'Nuevos productos');
  define('CATEGORIES_BOX_HEADING_WHATS_NEW', 'Nuevos productos ...');

  define('BOX_HEADING_FEATURED_PRODUCTS', 'Destacados');
  define('CATEGORIES_BOX_HEADING_FEATURED_PRODUCTS', 'Productos destacados ...');
  define('TEXT_NO_FEATURED_PRODUCTS', 'Proveeremos más productos destacados. Por favor compruébalo más adelante.');

  define('TEXT_NO_ALL_PRODUCTS', 'Proveeremos más productos destacados. Por favor compruébalo más adelante.');
  define('CATEGORIES_BOX_HEADING_PRODUCTS_ALL', 'Todos los productos ...');

// quick_find box text in sideboxes/quick_find.php
  define('BOX_HEADING_SEARCH', 'Buscar');
  define('BOX_SEARCH_ADVANCED_SEARCH', 'Búsqueda avanzada');
   define('HEADING_SEARCH_KEYWORDS_DEFAULT', 'Introduce las palabras de búsqueda aquí ...');
// specials box text in sideboxes/specials.php
  define('BOX_HEADING_SPECIALS', 'Especiales');
  define('CATEGORIES_BOX_HEADING_SPECIALS','Especiales ...');

// reviews box text in sideboxes/reviews.php
  define('BOX_HEADING_REVIEWS', 'Reseñas');
  define('BOX_REVIEWS_WRITE_REVIEW', 'Escribe una reseña sobre el producto.');
  define('BOX_REVIEWS_NO_REVIEWS', 'Todavía no hay reseñas.');
  define('BOX_REVIEWS_TEXT_OF_5_STARS', '%s de 5 estrellas!');

// shopping_cart box text in sideboxes/shopping_cart.php
  define('BOX_HEADING_SHOPPING_CART', 'Cesta');
  define('FS_SAVED_ITEMS', 'Productos guardados');
  define('BOX_SHOPPING_CART_EMPTY', 'Tu cesta está vacía.');
  define('BOX_SHOPPING_CART_DIVIDER', 'ea.-&nbsp;');

// order_history box text in sideboxes/order_history.php
  define('BOX_HEADING_CUSTOMER_ORDERS', 'Pedirlo de nuevo');

// best_sellers box text in sideboxes/best_sellers.php
  define('BOX_HEADING_BESTSELLERS', 'Los más vendidos');
  define('BOX_HEADING_BESTSELLERS_IN', 'Los más vendidos en<br />&nbsp;&nbsp;');

// notifications box text in sideboxes/products_notifications.php
  define('BOX_HEADING_NOTIFICATIONS', 'Notificaciones');
  define('BOX_NOTIFICATIONS_NOTIFY', 'Avísame de las novedades de <strong>%s</strong>');
  define('BOX_NOTIFICATIONS_NOTIFY_REMOVE', 'No avísame de las novedades de <strong>%s</strong>');

// manufacturer box text
  define('BOX_HEADING_MANUFACTURER_INFO', 'Información de fabricante');
  define('BOX_MANUFACTURER_INFO_HOMEPAGE', '%s Inicio');
  define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', 'Otros productos');

// languages box text in sideboxes/languages.php


// currencies box text in sideboxes/currencies.php
  define('BOX_HEADING_CURRENCIES', 'Monedas');

// information box text in sideboxes/information.php
  define('BOX_HEADING_INFORMATION', 'Información');
  define('BOX_INFORMATION_PRIVACY', 'Aviso de privacidad');
  define('BOX_INFORMATION_CONDITIONS', 'Condiciones de uso');
  define('BOX_INFORMATION_SHIPPING', 'envíos &amp; Devoluciones');
  define('BOX_INFORMATION_CONTACT', 'Contáctenos');
  define('BOX_BBINDEX', 'Foro');
  define('BOX_INFORMATION_UNSUBSCRIBE', 'Cancelar suscripción al boletín');

  define('BOX_INFORMATION_SITE_MAP', 'Mapa de sitio');

// information box text in sideboxes/more_information.php - were TUTORIAL_
  define('BOX_HEADING_MORE_INFORMATION', 'Más información');
  define('BOX_INFORMATION_PAGE_2', 'Página 2');
  define('BOX_INFORMATION_PAGE_3', 'Página 3');
  define('BOX_INFORMATION_PAGE_4', 'Página 4');

// tell a friend box text in sideboxes/tell_a_friend.php
  define('BOX_HEADING_TELL_A_FRIEND', 'Dile a un amigo');
  define('BOX_TELL_A_FRIEND_TEXT', 'Recomienda este producto a un conocido.');

// wishlist box text in includes/boxes/wishlist.php
  define('BOX_HEADING_CUSTOMER_WISHLIST', 'Mi lista de deseos');
  define('BOX_WISHLIST_EMPTY', 'No hay artículos en tu lista de deseos');
  define('IMAGE_BUTTON_ADD_WISHLIST', 'Añadir a mi lista de deseos');
  define('TEXT_WISHLIST_COUNT', 'Actualmente los artículos %s están en tu lista de deseos.');
  define('TEXT_DISPLAY_NUMBER_OF_WISHLIST', 'Mostrar <strong>%d</strong> a <strong>%d</strong> (de los artículos <strong>%d</strong> en tu lista de deseos)');

//New billing address text
  define('SET_AS_PRIMARY' , 'Establecer como dirección principal');
  define('NEW_ADDRESS_TITLE', 'Dirección de facturación');

// javascript messages
  define('JS_ERROR', 'Se han producido errores durante el proceso de tu formulario.\n\nPor favor realiza las siguientes correcciones :\n\n');

  define('JS_REVIEW_TEXT', '* Por favor añade más palabras al comentario. La reseña debe tener por lo menos ' . REVIEW_TEXT_MIN_LENGTH . ' caracteres.');
  define('JS_REVIEW_RATING', '* Por favor valora este artículo.');

  define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* Por favor selecciona un método de pago para el pedido.');

  define('JS_ERROR_SUBMITTED', 'El formulario ha sido enviado. Por favor pulsa OK y espera a que termine el proceso.');

  define('ERROR_NO_PAYMENT_MODULE_SELECTED', 'Por favor selecciona un método de pago para el pedido.');
  define('ERROR_CONDITIONS_NOT_ACCEPTED', 'Por favor acepta los términos y las condiciones sobre este pedido marcando la casilla debajo.');
  define('ERROR_PRIVACY_STATEMENT_NOT_ACCEPTED', 'Por favor acepta la declaración de privacidad marcando la casilla debajo.');

  define('CATEGORY_COMPANY', 'Detalles de empresa');
  define('CATEGORY_PERSONAL', 'Tus datos personales');
  define('CATEGORY_ADDRESS', 'Tu dirección');
  define('CATEGORY_CONTACT', 'Tu información de contacto');
  define('CATEGORY_OPTIONS', 'Opciones');
  define('CATEGORY_PASSWORD', 'Tu contraseña');
  define('CATEGORY_LOGIN', 'Iniciar sesión');
  define('PULL_DOWN_DEFAULT', 'Por favor elige tu país');
  define('PLEASE_SELECT', 'Por favor elige ...');
  define('TYPE_BELOW', 'Escribe una opción de bajo ...');

  define('ENTRY_COMPANY', 'Nombre de empresa:');
  define('ENTRY_COMPANY_ERROR', 'Por favor introduce un nombre de empresa.');
  define('ENTRY_COMPANY_TEXT', '');
  define('ENTRY_GENDER', 'Saluda:');
  define('ENTRY_GENDER_ERROR', 'Por favor elige una saluda.');
  define('ENTRY_GENDER_TEXT', '*');
  define('ENTRY_FIRST_NAME', 'Nombre:');
  define('ENTRY_FIRST_NAME_ERROR', '¿Tu nombre es correcto? El sistema requiere un mínimo de ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' caracteres. Vuelve a intentarlo.');
  define('ENTRY_FIRST_NAME_TEXT', '*');
  define('ENTRY_LAST_NAME', 'Apellido:');
  define('ENTRY_LAST_NAME_ERROR', '¿Tu apellido es correcto? El sistema requiere un mínimo de ' . ENTRY_LAST_NAME_MIN_LENGTH . ' caracteres. Vuelve a intentarlo.');
  define('ENTRY_LAST_NAME_TEXT', '*');
  define('ENTRY_DATE_OF_BIRTH', 'Fecha de nacimiento:');
  define('ENTRY_DATE_OF_BIRTH_ERROR', '¿Tu fecha de nacimiento es correcta? El sistema requiere la fecha en este formato: DD/MM/AAAA (ejemplo: 21/05/1970)');
  define('ENTRY_DATE_OF_BIRTH_TEXT', '* (ejemplo: 21/05/1970)');
  define('ENTRY_EMAIL_ADDRESS', 'Dirección de correo electrónico:');
  define('ENTRY_EMAIL_ADDRESS_ERROR', '¿Tu dirección de correo electrónico es correcta? Debe tener por lo menos ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' caracteres. Vuelve a intentarlo.');
  define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'Lo sentimos, el sistema no entiende la dirección de correo electrónico. Vuelve a intentarlo.');
 // define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Este correo electrónico ya existe en nuestra base de datos - por favor, entra con otro correo electrónico o crea otra cuenta con una dirección de correo electrónico diferente.');
  define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Este correo electrónico ya existe en nuestra base de datos - por favor, entra con esta dirección de correo electrónico. Si ya no la utilizas, puedes corregirla en la sección de Mi cuenta.');

  define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
  define('ENTRY_NICK', 'Nombre del foro:');
  define('ENTRY_NICK_TEXT', '*'); // note to display beside nickname input field
  define('ENTRY_NICK_DUPLICATE_ERROR', 'El nombre del foro ya existe. Por favor prueba un nuevo.');
  define('ENTRY_NICK_LENGTH_ERROR', 'Por favor vuelve a intentarlo. Tu nombre debe tener por lo menos ' . ENTRY_NICK_MIN_LENGTH . ' caracteres.');
  define('ENTRY_STREET_ADDRESS', 'Dirección detallada:');
  define('ENTRY_STREET_ADDRESS_ERROR', 'Tu dirección debe tener por lo menos ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' caracteres.');
  define('ENTRY_STREET_ADDRESS_TEXT', '*');
  define('ENTRY_SUBURB', 'Línea de dirección 2:');
  define('ENTRY_SUBURB_ERROR', '');
  define('ENTRY_SUBURB_TEXT', '');
  define('ENTRY_POST_CODE', 'Código postal/Zip:');
  define('ENTRY_POST_CODE_ERROR', 'Tu código postal debe tener por lo menos ' . ENTRY_POSTCODE_MIN_LENGTH . ' caracteres.');
  define('ENTRY_POST_CODE_TEXT', '*');
  define('ENTRY_CITY', 'Ciudad:');
  define('ENTRY_CUSTOMERS_REFERRAL', 'Código de referencia:');

  define('ENTRY_CITY_ERROR', 'Tu ciudad debe tener por lo menos ' . ENTRY_CITY_MIN_LENGTH . ' caracteres.');
  define('ENTRY_CITY_TEXT', '*');
  define('ENTRY_STATE', 'Estado/Provincia');
  define('ENTRY_STATE_ERROR', 'Tu estado debe tener por lo menos ' . ENTRY_STATE_MIN_LENGTH . ' caracteres.');
  define('ENTRY_STATE_ERROR_SELECT', 'Por favor elige un estado del menú desplegable.');
  define('ENTRY_STATE_TEXT', '*');
  define('JS_STATE_SELECT', '-- Por favor elige --');
  define('ENTRY_COUNTRY', 'País');
  define('ENTRY_COUNTRY_ERROR', 'Tienes que elegir un país del menú desplegable.');
  define('ENTRY_COUNTRY_TEXT', '*');
  define('ENTRY_TELEPHONE_NUMBER', 'Número de teléfono:');
  define('ENTRY_TELEPHONE_NUMBER_ERROR', 'Tu número de teléfono debe tener por lo menos ' . ENTRY_TELEPHONE_MIN_LENGTH . ' caracteres.');
  define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
  define('ENTRY_FAX_NUMBER', 'Fax:');
  define('ENTRY_FAX_NUMBER_ERROR', '');
  define('ENTRY_FAX_NUMBER_TEXT', '');
  define('ENTRY_NEWSLETTER', 'Suscribirse a los boletines.');
  define('ENTRY_NEWSLETTER_TEXT', '');
  define('ENTRY_NEWSLETTER_YES', 'Suscrito');
  define('ENTRY_NEWSLETTER_NO', 'no suscrito');
  define('ENTRY_NEWSLETTER_ERROR', '');
  define('ENTRY_PASSWORD', 'Contraseña:');
  define('ENTRY_PASSWORD_ERROR', 'Tu contraseña debe tener por lo menos ' . ENTRY_PASSWORD_MIN_LENGTH . ' caracteres.');
  define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'La contraseña debe coincidir con tu contraseña válida.');
  define('ENTRY_PASSWORD_TEXT', '* (por lo menos ' . ENTRY_PASSWORD_MIN_LENGTH . ' caracteres)');
  define('ENTRY_PASSWORD_CONFIRMATION', 'Confirmar la contraseña:');
  define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
  define('ENTRY_PASSWORD_CURRENT', 'Contraseña actual:');
  define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
  define('ENTRY_PASSWORD_CURRENT_ERROR', 'Tu contraseña debe tener por lo menos ' . ENTRY_PASSWORD_MIN_LENGTH . ' caracteres.');
  define('ENTRY_PASSWORD_NEW', 'Nueva contraseña:');
  define('ENTRY_PASSWORD_NEW_TEXT', '*');
  define('ENTRY_PASSWORD_NEW_ERROR', 'Tu nueva contraseña debe tener por lo menos ' . ENTRY_PASSWORD_MIN_LENGTH . ' caracteres.');
  define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'La contraseña debe coincidir con tu contraseña válida.');
  define('PASSWORD_HIDDEN', '--HIDDEN--');

  define('FORM_REQUIRED_INFORMATION', '* Información requerida');
  define('ENTRY_REQUIRED_SYMBOL', '*');

  define('FIBERSTORE_CONTINUE_TO_PAYMENT','Proceder a pagar');

  // constants for use in zen_prev_next_display function
  define('TEXT_RESULT_PAGE', '');
  define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Total: <strong>%d</strong> artículos &nbsp;&nbsp; <strong>%d</strong> / %d');

  define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Mostrar <strong>%d</strong> a <strong>%d</strong> (de <strong>%d</strong> productos)');
  define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Mostrar <strong>%d</strong> a <strong>%d</strong> (de <strong>%d</strong> pedidos)');
  define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Mostrar <strong>%d</strong> a <strong>%d</strong> (de <strong>%d</strong> reseñas)');
  define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', 'Mostrar <strong>%d</strong> a <strong>%d</strong> (de <strong>%d</strong> nuevos productos)');
  define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Mostrar <strong>%d</strong> a <strong>%d</strong> (de <strong>%d</strong> especiales)');
  define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_FEATURED_PRODUCTS', 'Mostrar <strong>%d</strong> a <strong>%d</strong> (de <strong>%d</strong> productos destacados)');
  define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_ALL', 'Mostrar <strong>%d</strong> a <strong>%d</strong> (de <strong>%d</strong> productos)');
  define('TEXT_TOTAL_NUMBER_OF_REVIEWS','(<strong>%d</strong>)');


  define('PREVNEXT_TITLE_FIRST_PAGE', 'Primera página');
  define('PREVNEXT_TITLE_PREVIOUS_PAGE', 'Página anterior');
  define('PREVNEXT_TITLE_NEXT_PAGE', 'Próxima página');
  define('PREVNEXT_TITLE_LAST_PAGE', 'Última página');
  define('PREVNEXT_TITLE_PAGE_NO', 'Página %d');
  define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'Conjunto anterior de %d Páginas');
  define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'Próximo conjunto de %d Páginas');
  define('PREVNEXT_BUTTON_FIRST', 'Primera');
  define('PREVNEXT_BUTTON_PREV', 'Anterior  ');
  define('PREVNEXT_BUTTON_NEXT', '  Siguiente');
  define('PREVNEXT_BUTTON_LAST', 'Última');

  define('TEXT_BASE_PRICE','Empieza en: ');

  define('TEXT_CLICK_TO_ENLARGE', 'imagen más grande');

  define('TEXT_SORT_PRODUCTS', 'Ordenar Productos ');
  define('TEXT_DESCENDINGLY', 'descendente');
  define('TEXT_ASCENDINGLY', 'ascendente');
  define('TEXT_BY', ' por ');

  define('TEXT_REVIEW_BY', 'por %s');
  define('TEXT_REVIEW_WORD_COUNT', '%s palabras');
  define('TEXT_REVIEW_RATING', 'Valoración: %s [%s]');
  define('TEXT_REVIEW_DATE_ADDED', 'Novedades: %s');
  define('TEXT_NO_REVIEWS', 'No hay reseñas actualmente.');

  define('TEXT_NO_NEW_PRODUCTS', 'Proveeremos más productos destacados. Por favor compruébalo más adelante.');

  define('TEXT_UNKNOWN_TAX_RATE', 'Impuesto sobre las ventas');

  define('TEXT_REQUIRED', '<span class="errorText">Requeridos</span>');

  define('WARNING_INSTALL_DIRECTORY_EXISTS', 'Warning: Installation directory exists at: %s. Please remove this directory for security reasons.');
  define('WARNING_CONFIG_FILE_WRITEABLE', 'Warning: I am able to write to the configuration file: %s. This is a potential security risk - please set the right user permissions on this file (read-only, CHMOD 644 or 444 are typical). You may need to use your webhost control panel/file-manager to change the permissions effectively. Contact your webhost for assistance. <a href="http://tutorials.zen-cart.com/index.php?article=90" target="_blank">See this FAQ</a>');
  define('ERROR_FILE_NOT_REMOVEABLE', 'Error: Could not remove the file specified. You may have to use FTP to remove the file, due to a server-permissions configuration limitation.');
  define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'Warning: The sessions directory does not exist: ' . zen_session_save_path() . '. Sessions will not work until this directory is created.');
  define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'Warning: I am not able to write to the sessions directory: ' . zen_session_save_path() . '. Sessions will not work until the right user permissions are set.');
  define('WARNING_SESSION_AUTO_START', 'Warning: session.auto_start is enabled - please disable this PHP feature in php.ini and restart the web server.');
  define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'Warning: The downloadable products directory does not exist: ' . DIR_FS_DOWNLOAD . '. Downloadable products will not work until this directory is valid.');
  define('WARNING_SQL_CACHE_DIRECTORY_NON_EXISTENT', 'Warning: The SQL cache directory does not exist: ' . DIR_FS_SQL_CACHE . '. SQL caching will not work until this directory is created.');
  define('WARNING_SQL_CACHE_DIRECTORY_NOT_WRITEABLE', 'Warning: I am not able to write to the SQL cache directory: ' . DIR_FS_SQL_CACHE . '. SQL caching will not work until the right user permissions are set.');
  define('WARNING_DATABASE_VERSION_OUT_OF_DATE', 'Your database appears to need patching to a higher level. See Admin->Tools->Server Information to review patch levels.');
  define('WARNING_COULD_NOT_LOCATE_LANG_FILE', 'WARNING: Could not locate language file: ');

  define('TEXT_CCVAL_ERROR_INVALID_DATE', 'La fecha de caducidad introducida para la tarjeta de crédito no es válida. Por favor vuelve a intentarlo.');
  define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'El número de tarjeta de crédito introducido no es válido. Por favor vuelve a intentarlo.');
  define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'El número de la tarjeta de crédito empezando por %s no se introduce correctamente, o no aceptamos este tipo de tarjeta. Por favor vuelve a intentarlo o usa otra tarjeta.');

  define('BOX_INFORMATION_DISCOUNT_COUPONS', 'Cupones descuento');
  define('BOX_INFORMATION_GV', TEXT_GV_NAME . ' FAQ');
  define('VOUCHER_BALANCE', TEXT_GV_NAME . ' Saldo de ');
  define('BOX_HEADING_GIFT_VOUCHER', TEXT_GV_NAME . ' cuenta');
  define('GV_FAQ', TEXT_GV_NAME . ' FAQ');
  define('ERROR_REDEEMED_AMOUNT', 'Enhorabuna, has redimido ');
  define('ERROR_NO_REDEEM_CODE', 'No introduciste un ' . TEXT_GV_REDEEM . '.');
  define('ERROR_NO_INVALID_REDEEM_GV', 'Inválido ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM);
  define('TABLE_HEADING_CREDIT', 'Créditos disponibles');
  define('GV_HAS_VOUCHERA', 'Tienes fondos en tu ' . TEXT_GV_NAME . ' cuenta. Si quieres <br />
                           puedes enviarlos por <a class="pageResults" href="');

  define('GV_HAS_VOUCHERB', '"><strong>correo electrónico</strong></a> a alguien');
  define('ENTRY_AMOUNT_CHECK_ERROR', 'No tienes fondos suficientes para enviarlos.');
  define('BOX_SEND_TO_FRIEND', 'Enviar ' . TEXT_GV_NAME . ' ');

  define('VOUCHER_REDEEMED',  TEXT_GV_NAME . ' Redimido');
  define('CART_COUPON', 'Cupón:');
  define('CART_COUPON_INFO', 'más información');
  define('TEXT_SEND_OR_SPEND','Tienes un saldo en tu ' . TEXT_GV_NAME . ' cuenta. Puedes gastarlo o enviarlo a otra persona. para enviar haz clic en el botón debajo.');
  define('TEXT_BALANCE_IS', 'Tu ' . TEXT_GV_NAME . ' saldo es: ');
  define('TEXT_AVAILABLE_BALANCE', 'Tu ' . TEXT_GV_NAME . ' cuenta');

// payment method is GV/Discount
  define('PAYMENT_METHOD_GV', 'Certificado de regalo/Cupón');
  define('PAYMENT_MODULE_GV', 'GV/DC');

  define('TABLE_HEADING_CREDIT_PAYMENT', 'Créditos disponibles');

  define('TEXT_INVALID_REDEEM_COUPON', 'Código de cupón inválido');
  define('TEXT_INVALID_REDEEM_COUPON_MINIMUM', 'Tienes que gastar por lo menos %s para redimir el cupón');
  define('TEXT_INVALID_STARTDATE_COUPON', 'Todavía el cupón no está disponible');
  define('TEXT_INVALID_FINISHDATE_COUPON', 'El cupón ha caducado');
  define('TEXT_INVALID_USES_COUPON', 'Sólo puedes usar el cupón ');
  define('TIMES', ' veces.');
  define('TIME', ' una vez.');
  define('TEXT_INVALID_USES_USER_COUPON', 'Has usado el código de cupón: %s  la cantidad máxima de veces permitidas por cliente. ');
  define('REDEEMED_COUPON', 'un cupón vale ');
  define('REDEEMED_MIN_ORDER', 'en pedidos más de ');
  define('REDEEMED_RESTRICTIONS', ' [Product-Category restrictions apply]');
  define('TEXT_ERROR', 'Se ha producido un error');
  define('TEXT_INVALID_COUPON_PRODUCT', 'El código de cupón no es válido para ningún producto en tu cesta.');
  define('TEXT_VALID_COUPON', '¡Enhorabuna has redimido el cupón de descuento!');
  define('TEXT_REMOVE_REDEEM_COUPON_ZONE', 'El código de cupón introducido no es válido para la dirección elegida.');

// more info in place of buy now
  define('MORE_INFO_TEXT','... más información');

// IP Address
  define('TEXT_YOUR_IP_ADDRESS','Tu dirección de IP es: ');

//Generic Address Heading
  define('HEADING_ADDRESS_INFORMATION','Información de dirección');

// cart contents
  define('PRODUCTS_ORDER_QTY_TEXT_IN_CART','Cantidad en la cesta: ');
  define('PRODUCTS_ORDER_QTY_TEXT','Añadir a la cesta: ');

// success messages for added to cart when display cart is off
// set to blank for no messages
// for all pages except where multiple add to cart is used:
  define('SUCCESS_ADDED_TO_CART_PRODUCT', 'Has añadido los productos elegidos a la cesta ...');
// only for where multiple add to cart is used:
  define('SUCCESS_ADDED_TO_CART_PRODUCTS', 'Has añadido los productos elegidos a la cesta ...');

  define('TEXT_PRODUCT_WEIGHT_UNIT','kg');

// Shipping
  define('TEXT_SHIPPING_WEIGHT','kg');
  define('TEXT_SHIPPING_BOXES', 'Cajas');

// Discount Savings
  define('PRODUCT_PRICE_DISCOUNT_PREFIX_1','Guardar &nbsp;');
  define('PRODUCT_PRICE_DISCOUNT_PREFIX','Guardar:&nbsp;');
  define('PRODUCT_PRICE_DISCOUNT_PERCENTAGE','% cerrar');
  define('PRODUCT_PRICE_DISCOUNT_AMOUNT','&nbsp;cerrar');

// Sale Maker Sale Price
  define('PRODUCT_PRICE_SALE','Venta:&nbsp;');

//universal symbols
  define('TEXT_NUMBER_SYMBOL', '# ');

// banner_box
  define('BOX_HEADING_BANNER_BOX','Patrocinadores ');
  define('TEXT_BANNER_BOX','Por favor ve nuestros patrocinadores ...');

// banner box 2
  define('BOX_HEADING_BANNER_BOX2','¿Has visto ...');
  define('TEXT_BANNER_BOX2','¡Comprarlo ahora!');

// banner_box - all
  define('BOX_HEADING_BANNER_BOX_ALL','Patrocinadores');
  define('TEXT_BANNER_BOX_ALL','Por favor ve nuestros patrocinadores  ...');

// boxes defines
  define('PULL_DOWN_ALL','Por favor elige');
  define('PULL_DOWN_MANUFACTURERS','- Reajustar -');
// shipping estimator
  define('PULL_DOWN_SHIPPING_ESTIMATOR_SELECT', 'Por favor elige');

// general Sort By
  define('TEXT_INFO_SORT_BY','Ordenar por: ');

// close window image popups
  define('TEXT_CLOSE_WINDOW',' - Haz clic la imagen para cerrar');
// close popups
  define('TEXT_CURRENT_CLOSE_WINDOW','[ Cerrar ventana ]');

// iii 031104 added:  File upload error strings
  define('ERROR_FILETYPE_NOT_ALLOWED', 'Error:  No se permite el tipo de fichero.');
  define('WARNING_NO_FILE_UPLOADED', 'Aviso: El fichero no se ha cargado.');
  define('SUCCESS_FILE_SAVED_SUCCESSFULLY', 'Con éxito: El fichero guardado con éxito.');
  define('ERROR_FILE_NOT_SAVED', 'Error: El fichero no se ha guardado.');
  define('ERROR_DESTINATION_NOT_WRITEABLE', 'Error:  El destino no permita la escritura.');
  define('ERROR_DESTINATION_DOES_NOT_EXIST', 'Error: El destino no existe.');
  define('ERROR_FILE_TOO_BIG', 'Aviso: ¡El fichero era demasiado grande para cargar!<br />Puedes realizar el pedido pero necesitas contactar con nosotros para que te ayudemos a cargar');
// End iii added

  define('TEXT_BEFORE_DOWN_FOR_MAINTENANCE', 'Aviso: Este sitio web no estará disponible por mantenimiento: ');
  define('TEXT_ADMIN_DOWN_FOR_MAINTENANCE', 'Aviso: Este sitio web actualmente no está disponible por mantenimiento');

  define('PRODUCTS_PRICE_IS_FREE_TEXT','¡Es gratis!');
  define('PRODUCTS_PRICE_IS_CALL_FOR_PRICE_TEXT','Contactar para el precio');
  define('TEXT_CALL_FOR_PRICE','Contactar para el precio');

  define('TEXT_INVALID_SELECTION','Has realizado una selección no válida: ');
  define('TEXT_ERROR_OPTION_FOR',' En la opción para: ');
  define('TEXT_INVALID_USER_INPUT', 'Ninguna entrada del usuario es requerida<br />');

// product_listing
  define('PRODUCTS_QUANTITY_MIN_TEXT_LISTING','Mínimo: ');
  define('PRODUCTS_QUANTITY_UNIT_TEXT_LISTING','Unidades: ');
  define('PRODUCTS_QUANTITY_IN_CART_LISTING','En cesta:');
  define('PRODUCTS_QUANTITY_ADD_ADDITIONAL_LISTING','Añadir más:');

  define('PRODUCTS_QUANTITY_MAX_TEXT_LISTING','Máximo:');

  define('TEXT_PRODUCTS_MIX_OFF','*Mezclar NO ');
  define('TEXT_PRODUCTS_MIX_ON','*Mezclar SÍ');

  define('TEXT_PRODUCTS_MIX_OFF_SHOPPING_CART','<br />*No puedes mezclar las opciones sobre el artículo para cumplir el requisito de la cantidad mínima de pedido.*<br />');
  define('TEXT_PRODUCTS_MIX_ON_SHOPPING_CART','*La opción de valores mixtos está confirmada<br />');

  define('ERROR_MAXIMUM_QTY','La cantidad añadida a tu cesta se ha ajustada por la limitación de cantidad máxima permitida. Ver el artículo: ');
  define('ERROR_CORRECTIONS_HEADING','Por favor corrige el siguiente: <br />');
  define('ERROR_QUANTITY_ADJUSTED', 'La cantidad añadida a tu cesta se ha ajustada. El artículo no está disponible en cantidades fraccionales. La cantidad del artículo: ');
  define('ERROR_QUANTITY_CHANGED_FROM', ', se ha modificado de: ');
  define('ERROR_QUANTITY_CHANGED_TO', ' a ');

// Downloads Controller
  define('DOWNLOADS_CONTROLLER_ON_HOLD_MSG','Aviso: No se permiten las descargas hasta que el pago sea confirmado');
  define('TEXT_FILESIZE_BYTES', ' bytes');
  define('TEXT_FILESIZE_MEGS', ' MB');

// shopping cart errors
  define('ERROR_PRODUCT','El artículo: ');
  // define('ERROR_PRODUCT_STATUS_SHOPPING_CART','<br />Lo sentimos, pero el producto se ha eliminado de nuestro inventario.<br /> El producto se ha eliminado de tu cesta.');
  define('ERROR_PRODUCT_QUANTITY_MIN',',  ... Errores de cantidad mínima - ');
  define('ERROR_PRODUCT_QUANTITY_UNITS',' ... Errores de unidades- ');
  define('ERROR_PRODUCT_OPTION_SELECTION','<br /> ... Opción de valores elegida no válida ');
  define('ERROR_PRODUCT_QUANTITY_ORDERED','<br /> Has pedido un total de: ');
  define('ERROR_PRODUCT_QUANTITY_MAX',' ... Errores de cantidad máxima - ');
  define('ERROR_PRODUCT_QUANTITY_MIN_SHOPPING_CART',', Hay una limitación de cantidad mínima. ');
  define('ERROR_PRODUCT_QUANTITY_UNITS_SHOPPING_CART',' ... Errores de unidades - ');
  define('ERROR_PRODUCT_QUANTITY_MAX_SHOPPING_CART',' ... Errores de cantidad máxima - ');

  define('WARNING_SHOPPING_CART_COMBINED', 'Aviso: Para tu comodidad, tu cesta actual se ha combinado con tu cesta desde tu última visita. Por favor comprueba tu cesta antes de tramitar pedido.');

// error on checkout when $_SESSION['customers_id' does not exist in customers table
  define('ERROR_CUSTOMERS_ID_INVALID', 'La información de cliente no se puede validarse!<br />Por favor inicia sesión o vuelve a crear una cuenta ...');
  define('HOT_PRODUCTS','Productos de mayor venta');
  define('TABLE_HEADING_FEATURED_PRODUCTS','Productos destacados');

  define('TABLE_HEADING_NEW_PRODUCTS', 'Nuevos productos para %s');
  define('TABLE_HEADING_UPCOMING_PRODUCTS', 'Productos de próximo lanzamiento');
  define('TABLE_HEADING_DATE_EXPECTED', 'Fecha estimada');
  define('TABLE_HEADING_SPECIALS_INDEX', 'Especiales mensualmente para %s');

  define('CAPTION_UPCOMING_PRODUCTS','Estos artículos estarán en stock pronto');
  define('SUMMARY_TABLE_UPCOMING_PRODUCTS','Una lista de productos estarán en stock pronto.');

// meta tags special defines
  define('META_TAG_PRODUCTS_PRICE_IS_FREE_TEXT','¡Es gratis!');
 //meta_tags  新模板 2016-9-26 frankie
//模块
define('MODEL_META_DES_01','Comprar por');
define('MODEL_META_DES_02','Comprar');
define('MODEL_META_DES_03','rentables en FS.COM. Garantía de por vida, cumple con ROHS, y 100% de prueba garantizada. Pedidos OEM/ODM están disponibles.');

//跳线
define('FIBER_META_DES_01','Amplia selección de');
define('FIBER_META_DES_02','para satisfacer tu necesidad. 100% de prueba antes de envío con garantía de por vida. Servicios personalizados están disponibles.');

//其他
define('OTHER_META_DES_01','Envío internacional para');
define('MODEL_META_DES_02','Comprar');
define('OTHER_META_DES_02','rentables en FS.COM, y disfrutar de los mejores precios y servicios.');
// customer login
  define('TEXT_SHOWCASE_ONLY','Contacta con nosotros');
// set for login for prices
  define('TEXT_LOGIN_FOR_PRICE_PRICE','Precio indisponible');
  define('TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE','Iniciar sesión para consultar precios');
// set for show room only
  define('TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM', ''); // blank for prices or enter your own text
  define('TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE_SHOWROOM','Sólo para exposición');

// authorization pending
  define('TEXT_AUTHORIZATION_PENDING_PRICE', 'Precio indisponible');
  define('TEXT_AUTHORIZATION_PENDING_BUTTON_REPLACE', 'Pendiente de aprobación');
  define('TEXT_LOGIN_TO_SHOP_BUTTON_REPLACE','Iniciar sesión para comprar');

// text pricing
  define('TEXT_CHARGES_WORD','Cargo calculado:');
  define('TEXT_PER_WORD','<br />Precio por palabra: ');
  define('TEXT_WORDS_FREE',' Palabra(s) gratis ');
  define('TEXT_CHARGES_LETTERS','Cargo calculado:');
  define('TEXT_PER_LETTER','<br />Precio por letra: ');
  define('TEXT_LETTERS_FREE',' Letra(s) gratis ');
  define('TEXT_ONETIME_CHARGES','*pagos únicos = ');
  define('TEXT_ONETIME_CHARGES_EMAIL',"\t" . '*pagos únicos = ');
  define('TEXT_ATTRIBUTES_QTY_PRICES_HELP', 'Opción de descuentos por cantidad');
  define('TABLE_ATTRIBUTES_QTY_PRICE_QTY','Cantidad');
  define('TABLE_ATTRIBUTES_QTY_PRICE_PRICE','Precio');
  define('TEXT_ATTRIBUTES_QTY_PRICES_ONETIME_HELP', 'Opción de descuentos por cantidad y pagos únicos');

// textarea attribute input fields
  define('TEXT_MAXIMUM_CHARACTERS_ALLOWED',' El número máximo de caracteres permitido');
  define('TEXT_REMAINING','restante');

// Shipping Estimator
  define('CART_SHIPPING_OPTIONS', 'Gastos de envío estimado');
  define('CART_SHIPPING_OPTIONS_LOGIN', 'Por favor <a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '"><span class="pseudolink">inicia sesión</span></a> para mirar tus gastos de envío personales.');
  define('CART_SHIPPING_METHOD_TEXT', 'Métodos de envío disponibles');
  define('CART_SHIPPING_METHOD_RATES', 'Valoración');
  define('CART_SHIPPING_METHOD_TO','Enviar a: ');
  define('CART_SHIPPING_METHOD_TO_NOLOGIN', 'Enviar a: <a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '"><span class="pseudolink">Iniciar sesión</span></a>');
  define('CART_SHIPPING_METHOD_FREE_TEXT','Envío gratis');
  define('CART_SHIPPING_METHOD_ALL_DOWNLOADS','- Descargas');
  define('CART_SHIPPING_METHOD_RECALCULATE','Recalcular');
  define('CART_SHIPPING_METHOD_ZIP_REQUIRED','verdadero');
  define('CART_SHIPPING_METHOD_ADDRESS','Dirección:');
  define('CART_OT','Coste total estimado:');
  define('CART_OT_SHOW','true'); // set to false if you don't want order totals
  define('CART_ITEMS','Artículos en cesta: ');
  define('CART_SELECT','Seleccionar');
  define('ERROR_CART_UPDATE', '<strong>Por favor actualiza tu cesta.</strong> ');
  define('IMAGE_BUTTON_UPDATE_CART', 'Por actualizar');
  define('EMPTY_CART_TEXT_NO_QUOTE', 'Tu sesión no está activa o ha expirado... Por favor actualiza tu cesta para obetener el presupuesto de envío  ...');
  define('CART_SHIPPING_QUOTE_CRITERIA', 'El presupuesto de envío se basa en la información de la dirección seleccionada:');

// multiple product add to cart
  define('TEXT_PRODUCT_LISTING_MULTIPLE_ADD_TO_CART', 'Añadir: ');
  define('TEXT_PRODUCT_ALL_LISTING_MULTIPLE_ADD_TO_CART', 'Añadir: ');
  define('TEXT_PRODUCT_FEATURED_LISTING_MULTIPLE_ADD_TO_CART', 'Añadir: ');
  define('TEXT_PRODUCT_NEW_LISTING_MULTIPLE_ADD_TO_CART', 'Añadir: ');
  //moved SUBMIT_BUTTON_ADD_PRODUCTS_TO_CART to button_names.php as BUTTON_ADD_PRODUCTS_TO_CART_ALT

// discount qty table
  define('TEXT_HEADER_DISCOUNT_PRICES_PERCENTAGE', 'Precio sin descuentos por cantidad');
  define('TEXT_HEADER_DISCOUNT_PRICES_ACTUAL_PRICE', 'Precio nuevo con descuentos por cantidad');
  define('TEXT_HEADER_DISCOUNT_PRICES_AMOUNT_OFF', 'Precio sin descuentos por cantidad');
  define('TEXT_FOOTER_DISCOUNT_QUANTITIES', '* Descuentos pueden variar según las opciones de arriba');
  define('TEXT_HEADER_DISCOUNTS_OFF', 'Descuentos por cantidad indisponible...');

// sort order titles for dropdowns
  define('PULL_DOWN_ALL_RESET','- RESET - ');
  define('TEXT_INFO_SORT_BY_PRODUCTS_NAME', 'Nombre de la A-Z');
  define('TEXT_INFO_SORT_BY_PRODUCTS_NAME_DESC', 'Nombre de la A-Z - descuento');
  define('TEXT_INFO_SORT_BY_PRODUCTS_PRICE', 'Precio - de más bajo a más alto');
  define('TEXT_INFO_SORT_BY_PRODUCTS_PRICE_DESC', 'Precio - de más alto a más bajo');
  define('TEXT_INFO_SORT_BY_PRODUCTS_MODEL', 'Modelo');
  define('TEXT_INFO_SORT_BY_PRODUCTS_DATE_DESC', 'Novedades - de más antiguo a más nuevo');
  define('TEXT_INFO_SORT_BY_PRODUCTS_DATE', 'Novedades - de más nuevo a más antiguo');
  define('TEXT_INFO_SORT_BY_PRODUCTS_SORT_ORDER', 'Visualización propuesta');

// downloads module defines
  define('TABLE_HEADING_DOWNLOAD_DATE', 'El enlace ha expirado');
  define('TABLE_HEADING_DOWNLOAD_COUNT', 'Restante');
  define('HEADING_DOWNLOAD', 'Para descargar los ficheros haz clic el botón de "descargar" y elige "Guardar en disco" desde el menú que aparece.');
  define('TABLE_HEADING_DOWNLOAD_FILENAME','Nombre del fichero');
  define('TABLE_HEADING_PRODUCT_NAME','Nombre del artículo');
  define('TABLE_HEADING_BYTE_SIZE','Tamaño del fichero');
  define('TEXT_DOWNLOADS_UNLIMITED', 'Ilimitado');
  define('TEXT_DOWNLOADS_UNLIMITED_COUNT', '--- *** ---');

// misc
  define('COLON_SPACER', ':&nbsp;&nbsp;');

// table headings for cart display and upcoming products
  define('TABLE_HEADING_QUANTITY', 'Cantidad');
  define('TABLE_HEADING_PRODUCTS', 'Nombre del artículo');
  define('TABLE_HEADING_TOTAL', 'Total');

// create account - login shared
  define('TABLE_HEADING_PRIVACY_CONDITIONS', 'Declaración de privacidad');
  define('TEXT_PRIVACY_CONDITIONS_DESCRIPTION', 'Por favor, acepte nuestra declaración de privacidad marcando el siguiente casillero. Puedes leer la declaración de privacidad <a href="' . zen_href_link(FILENAME_PRIVACY, '', 'SSL') . '"><span class="pseudolink">here</span></a>.');
  define('TEXT_PRIVACY_CONDITIONS_CONFIRM', 'He leído y estoy de acuerdo con su declaración de privacidad.');
  define('TABLE_HEADING_ADDRESS_DETAILS', 'Detalle de la dirección');
  define('TABLE_HEADING_PHONE_FAX_DETAILS', 'Detalles de contactos adicionales');
  define('TABLE_HEADING_DATE_OF_BIRTH', 'Verificar tu edad');
  define('TABLE_HEADING_LOGIN_DETAILS', 'Datos de acceso');
  define('TABLE_HEADING_REFERRAL_DETAILS', '¿Nos refieres?');

  define('ENTRY_EMAIL_PREFERENCE','Detalles del boletín y correo electrónico');
  define('ENTRY_EMAIL_HTML_DISPLAY','HTML');
  define('ENTRY_EMAIL_TEXT_DISPLAY','Sólo texto');
  define('EMAIL_SEND_FAILED','ERROR: Error de envíar correo electrónico a: "%s" <%s> with subject: "%s"');

  define('DB_ERROR_NOT_CONNECTED', 'Error - no se pudo conectar a la base de datos');

  // EZ-PAGES Alerts
  define('TEXT_EZPAGES_STATUS_HEADER_ADMIN', 'WARNING: EZ-PAGES HEADER - On for Admin IP Only');
  define('TEXT_EZPAGES_STATUS_FOOTER_ADMIN', 'WARNING: EZ-PAGES FOOTER - On for Admin IP Only');
  define('TEXT_EZPAGES_STATUS_SIDEBOX_ADMIN', 'WARNING: EZ-PAGES SIDEBOX - On for Admin IP Only');

// extra product listing sorter
  define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER', '');
  define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER_NAMES', 'Artículos que empiezan por  ...');
  define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER_NAMES_RESET', '-- Reajustar  --');

///////////////////////////////////////////////////////////
// include email extras
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_EMAIL_EXTRAS)) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_EMAIL_EXTRAS);

// include template specific header defines
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_HEADER)) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_HEADER);

// include template specific button name defines
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_BUTTON_NAMES)) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_BUTTON_NAMES);

// include template specific icon name defines
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_ICON_NAMES)) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_ICON_NAMES);

// include template specific other image name defines
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_OTHER_IMAGES_NAMES)) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_OTHER_IMAGES_NAMES);

// credit cards
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_CREDIT_CARDS)) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select. FILENAME_CREDIT_CARDS);

// include template specific whos_online sidebox defines
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_WHOS_ONLINE . '.php')) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_WHOS_ONLINE . '.php');

// include template specific meta tags defines
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/meta_tags.php')) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . 'meta_tags.php');

// END OF EXTERNAL LANGUAGE LINKS

  define('FIBERSTORE_VIEW_MORE', 'Más artículos en la cesta...');
  define('FIBERSTORE_WISHLIST_ADD_TO_CART','Añadir a la cesta');
  define('FIBERSTORE_MESSAGE_ADD_TO_WISHLIST_SUCCESS','Añadido a la lista de deseos con éxito');
  define('FIBERSTORE_DELETE','Eliminar');
  define('FIBERSTORE_PRICE','Precio');
  define('FIBERSTORE_VIEW_MORE_ORDERS','Ver todos los pedidos »');
  define('FIBERSTORE_ORDER_IMAGE','Imagen de productos');
  define('FIBERSTORE_POST','Apostar');
  define('FIBERSTORE_CANCEL_ORDER','Cancelar el pedido');
  define('FIBERSTORE_PRODTCTS_DETAILS','Detalles de productos');

  define('FIBERSTORE_OEM_CUSTOM','OEM y personalización');
  define('FIBERSTORE_ANY_TYPE','Cualquier tipo');
  define('FIBERSTORE_ANY_LENGTH','Cualquier longitud');
  define('FIBERSTORE_ANY_COLOR','Cualquier Color');
  define('FIBERSTORE_WORK_PROJECT','Trabajaremos contigo para tus productos personalizados');

  define('TEXT_OPTION_DIVIDER', '&nbsp;-&nbsp;');
  define('TEXT_PREFIX','text_prefix_');
   // LANGUAGE FOR COMMON FOOTER
  define('FOOTER_TIT_FIR','Soporte de Fiberstore');
  define('FOOTER_FILENAME_SUPPORT','Ver todo »');
  define('FOOTER_MTP_HREF','Los componentes de conexión MTP/MPO');
  define('FOOTER_MTP_CON','Los sistemas de fibra MTP/MPO son un grupo de productos innovados como ...');
  define('FOOTER_TIT_SEC','Opinión del cliente');
  define('FOOTER_CON_SEC','We have several mux\'s and dwdm xfps and some sfps from them and they work just fine. I know a lot of ISPS that use their gear as well.<i></i><b>-- Angryceo</b>');
  define('FOOTER_TIT_TIR','Últimas noticias');
  define('FOOTER_PAGE_SEA','Páginas más visitadas:');
  define('FOOTER_SHARE_TIT','Te damos la bienvenida a nuestra Comunidad:');
  define('FOOTER_RIGHT_CON','<span>¿En qué podemos ayudarte?</span><br>
        <p>Servicios y soporte profesionales están disponibles de 3 maneras diferentes</p>');
  define('FOOTER_RIGHT_IMG','Live Chat ahora');
  define('FOOTER_ABOUT_FIR','<span>Sobre nosotros</span><br>
        <a itemprop="url"  href='. HTTPS_SERVER.reset_url('company/about_us.html').'>Acerca de nosotros</a><br>
        <a rel="nofollow" itemprop="url"  href='.  zen_href_link(FILENAME_WHY_US).'>¿Por qué nosotros?</a><br>
        <!--  
        <a itemprop="url"  href='. zen_href_link(FILENAME_PRIVACY_POLICY).'>Políticas de privacidad</a><br>
        -->
        <a itemprop="url" href='. zen_href_link(FILENAME_SITE_MAP).'>Mapa del sitio</a><br>
        <a itemprop="url" href="http://www.fs.com/news.html" target="_blank">Últimas noticias</a><br>
        <a itemprop="url" href="http://www.fs.com/blog/">Fiberstore Blog</a>');
  define('FOOTER_ABOUT_SEC','<span>Servicios al cliente</span><br>
       
        <a rel="nofollow" itemprop="url"  href='.zen_href_link(FILENAME_OEM).'>OEM y personalización</a><br>
        <a rel="nofollow" itemprop="url"  href='.zen_href_link(FILENAME_RMA_SOLUTION).'>Solución de RMA</a><br>
		<a rel="nofollow" itemprop="url"  href='.zen_href_link(FILENAME_DAY_RETURN_POLICY).'>Políticas de devolución</a><br>
		<a rel="nofollow" itemprop="url"  href='.zen_href_link(FILENAME_WARRANTY).'>Garantía</a><br>
		<a rel="nofollow" itemprop="url"  href='.zen_href_link(FILENAME_ISO_STANDARD).'>Estándar ISO</a><br>');
  define('FOOTER_ABOUT_TIR','<span>Pago y envío</span><br>
        <a rel="nofollow" itemprop="url"  href='.zen_href_link(FILENAME_PAYMENT_METHODS).'>Métodos de pago</a><br>
        <a rel="nofollow" itemprop="url"  href='.zen_href_link("net_30").'>Net 30 y W9</a><br>
        <a rel="nofollow" itemprop="url"  href='.zen_href_link(FILENAME_GLOBAL_SHIPPING).'>Guía de envío</a><br>
        <a itemprop="url"  href='.zen_href_link(FILENAME_ESTIMATED_TIME).'>Envío y entrega</a><br>
      </div>
      <div class="footer_04"> <span>Ayuda rápida</span><br>
        <a rel="nofollow" itemprop="url"  href='.zen_href_link(FILENAME_CONTACT_US).'>Contáctanos</a><br>
        <a rel="nofollow" itemprop="url"  href='.zen_href_link(FILENAME_HOW_TO_BUY).'>Ayuda de compras</a><br>');
  define('FOOTER_ABOUT_TIR1','<a rel="nofollow" itemprop="url"  href='.zen_href_link(FILENAME_PASSWORD_FORGOTTEN).'>¿Has olvidado tu contraseña?</a><br>') ;
  define('FOOTER_ABOUT_TIR2',' <a  itemprop="url"  href='.zen_href_link(FILENAME_CHANGE_PASSWORD).'>¿Has olvidado tu contraseña?</a><br>');
  define('FOOTER_ABOUT_TIR3','<a rel="nofollow" itemprop="url"  href='.reset_url('service/fs_support.html').'>Live Chat</a><br>
        <a rel="nofollow" itemprop="url"  href='.zen_href_link(FILENAME_FAQ).'>FAQ</a><br>');
  define('FOOTER_ABOUT_TIR4','Todos los derechos reservados.');
  define('FOOTER_ABOUT_TIR5','Privacidad');
  define('FOOTER_ABOUT_TIR6','Uso de términos');
  //FOOTER END

  define('LEFT_SLIDE_TIT1','Sobre nosotros');
  define('LEFT_SLIDE_TIT2','Atención al cliente');
  define('LEFT_SLIDE_TIT3','Pago y envío');
  define('LEFT_SLIDE_TIT4','Ayuda rápida');
  define('LEFT_SLIDE_CON1','Contacta con nosotros');
  define('LEFT_SLIDE_CON2','Sobre nosotros');
  define('LEFT_SLIDE_CON3','¿Por qué nosotros?');
  define('LEFT_SLIDE_CON4','Noticias');
  define('LEFT_SLIDE_CON5','Cuenta de negocio');

  define('LEFT_SLIDE_CON7','OEM y personalización');
  define('LEFT_SLIDE_CON8','Control de calidad');
  define('LEFT_SLIDE_CON9','Estándar ISO');
  define('LEFT_SLIDE_CON10','Garantía');
  define('LEFT_SLIDE_CON11','Solución de RMA');
  define('LEFT_SLIDE_CON12','Políticas de devolución');
  define('LEFT_SLIDE_CON13','Garantía de reembolso');
  define('LEFT_SLIDE_CON14','Métodos de pago');
  define('LEFT_SLIDE_CON15','Net 30 y W9');
  define('LEFT_SLIDE_CON16','Guía de envío');
  define('LEFT_SLIDE_CON17','Envío y entrega');
  define('LEFT_SLIDE_CON18','Ayuda de compras');
  define('LEFT_SLIDE_CON19','FAQ');
  //HEADER LIVE
  define('HEADER_LIVE_TIT','Contacta ahora');






  //HEADER END
  define('FOOTER_ABOUT_TIR4','Все права защищены.');
  define('FOOTER_ABOUT_TIR5','Конфиденциальность.');
  define('FOOTER_ABOUT_TIR6','Условия использования.');
  //TPL INDEX
  define('FIBERSTORE_SHOPPING_HELP','Tu cesta está vacía.');
  define('FIBERSTORE_INDEX_HELP','<dd><b>¿Qué podemos <br />ayudarte?</b><i>Live Chat ahora</i></dd>');
  define('FIBERSTORE_INDEX_SIDER','<p class="sidebar_03_02 "><b>El programa de socios</b> hacer crecer tu negocio</p>');
  define('FIBERSTORE_INDEX_SIDER1','<p class="sidebar_03_02 "><b>Envíos global</b> 2 a 3 días a todo el mundo</p>');
  define('FIBERSTORE_INDEX_SIDER2','<p class="sidebar_03_02"><b>Estándar ISO</b> se concentra en la calidad y precisión</p>');
  define('FIBERSTORE_INDEX_SIDER3','<p class="sidebar_03_02"><b>Método de pago</b> Pago seguro</p>');
  define('FIBERSTORE_INDEX_SIDER4','<p class="sidebar_03_02"><b>Garantía de por vida </b> de uso normal </p>');
  define('FIBERSTORE_INDEX_OEM','<span class="oem_02">OEM yamp; productos personalizados</span> <span class="oem_03 "><ul><li>Cualquier producto </li><li>Cualquier tamaño</li><li>Cualquier tipo</li><li>Cualquier color</li></ul></span> <span class="oem_03 oem_04">Excelente calidad y servicios para satisfacer todas las necesidades de nuestros clientes</span>');
  define('FIBERSTORE_WHOLESALES_TAPS','Menor requisito de cantidad mínima con precios al por mayor</span><br />
        Fabricar para pedidos pequeños y medianos.</li>
      <li class="wholesale_ad03_02"><span>Transacciones en línea seguras</span><br />
        Varios métodos de pago en línea para tí.</li>
      <li class="wholesale_ad03_03"><span>Comprar ahora para entrega rápida</span><br />
        Artículos en stock pueden ser enviados el mismo día.');
  define('FS_ADD_TO_CART','Add to Cart');
  //INDEX END
  //2016-5-19购物车结账页面
define('F_EDIT','Editar');
define('F_PROCEED_TO_PAYPAL','Proceder a Paypal');
define('F_CONFIRM_TO_PAYMENT','Confirmar el pago');
define('F_SUBMIT_ORDER','Confirmar el pedido');
define('F_SHIP_SAME_DAY','Enviar el mismo día');
define('F_SHIP_NEXT_DAY','Enviar el siguiente día');
define('F_SHIP_TIME','Fecha de entrega estimada');
define('F_WENHAO','Puede haber diferencias entre la fecha de entrega estimada y la actual');
define('F_CHAT_NOW','chat ahora');
define('F_PLEASE_SELECT','por favor elige');
define('F_PLEASE_ENTER_FIRST_NAME','Por favor introduce tu nombre');
define('F_PLEASE_ENTER_LAST_NAME','Por favor introduce tu apellido');
define('F_PLEASE_ENTER_STREET_ADDRESS','Por favor introduce la dirección de envío');
define('F_PLEASE_ENTER_CITY','Por favor introduce la ciudad');
define('F_PLEASE_ENTER_POSTAL_CODE','Por favor introduce el código postal');
define('F_PLEASE_ENTER_COUNTRY','Por favor introduce el país');
define('F_PLEASE_ENTER_STATE','Por favor introduce el estado / provincia/ región');
define('F_PLEASE_ENTER_TELEPHONE_NUMBER','Por favor introduce tu número de teléfono');
define('FIBERSTORE_SHOP_CART_BUTTON1','Comprar en confianza</b>
      <dt>Comprar en FS.COM es seguro y confiable. ¡Garantizado!<br />No debes pagar nada si se aplican cargos no autorizados a tu tarjeta por compras hechas en FS.COM.</dt>
      <div class="ccc"></div>
       <b>Envío y devolución gratis</b>
      <dt>Con el objetivo de operar sin preocupación y reducir el coste relacionado con las reparaciones, FiberStore ofrece una garantía de por vida como característica estándar de casi todas las gamas de productos.');
define('FIBERSTORE_SHOP_CART_BUTTON2','FS.COM ha sido acreditado por la BBB</b><dt><i class="login_018"></i>
FS.COM se basa en la calidad superior y el estándar estricto . Nos esforzamos en proveer productos y servicios excelentes a nuestros clientes desde el día de la fundación.
 </dt></li>
      <li><b>Garantía de compras seguras</b>
      <dd><i class="login_016" style=" height:68px; margin-bottom:5px;"></i>Toda la información es encriptada y transmitida sin riesgos utilizando el protocolo de Secure Sockets Layer (SSL).');

//支付页面
define('F_USE_CREDIT','Tu pago fue denegado. Por favor usa otra tarjeta de crédito o cambia el método de pago a PayPal o transferencia bancaria para pagar un pedido');
define('F_MAKE_SURE','Por favor asegúrate de que la dirección de facturación rellenada coincide con el nombre y la dirección asociados con la tarjeta de crédito que utilizas para pagar. Por favor ten en cuenta que el país de tu dirección de envío y de facturación deben ser el mismo');
define('F_COUNTRY','País receptor');
define('F_ZIP','ZIP');
define('F_ORDER_SUMMARY','Resumen del pedido');
define('F_ORDER_NUMBER','Número del pedido');
define('F_TOTAL_AMOUNT','Importe total');
define('F_CREDIT','Tarjeta de crédito');
define('F_DEBIT','Centro de pago con tarjetas de débito');
define('F_ACCEPT','Aceptamos las siguientes tarjetas de crédito/débito');
define('F_SELECT_CARD_TYPE','Por favor elige un tipo de tarjeta, completa la información debajo y haz clic en Continuar');
define('F_NOTE','Aviso: Por motivos de seguridad, no guardaremos ningún dato de tu tarjeta de crédito');
define('F_SELECT_SELECT_CREDIT','Elegir la tarjeta de crédito');
define('F_DEBIT_CARD','tarjeta de débito');
define('F_CARD_NUMBER','Número de tarjeta');
define('F_EXPIRATION_DATE','Fecha de vencimiento ');
define('F_MONTH','Mes');
define('F_YEAR','año');
define('F_SECURITY_CODE','Código de seguridad');
define('F_LOADING','cargando');

//列表页
define('FIBERSTORE_SHOW_RESULTS','<b>Mostrar resultados de</b>');
define('FIBERSTORE_SHOW_BRANDS','Mostrar más marcas');
define('FIBERSOTER_SHOW_MORE_BRANDS','Mostrar más marcas');
define('FIBERSOTER_COMPATIBLE_BRANDS','Marcas compatibles');
define('FIBERSOTER_SHOW_LESS_BRANDS','Mostrar menos marcas');





define('FIBERSTORE_QUICKFINDER','Quickfinder');
define('FIBERSTORE_PAGE','página');


define('FIBERSTORE_REVIEWS_ALL','reseñas');
define('FIBERSTORE_P_LOW_TO_HIGH','Precio: de más bajo a más alto');
define('FIBERSTORE_P_HIGH_TO_LOW','Precio: de más alto a más bajo');
define('FIBERSTORE_R_HIGH_TO_LOW','Valoración media de los clientes');
define('FIBERSTORE_NEWEST_F','Lo más nuevo');
define('FIBERSTORE_POPU','Popularidad');
define('LET_US_HELP_YOU','12.Podemos ayudarte');
define('CHAT_WITH_US_NOW','chateemos ahora');
define('CATR_TOTAL','15.Total de la cesta');
define('THE_MQQ','MOQ (La MOQ (limitación de cantidad mínima) del cable es 1 km. Por favor confirma el pedido después de incrementar la longitud total. Si tienes dudas, puedes enviar un correo electrónico a Sales@fs.com');
//产品详情页

//写产品评论页面
define('FIBERSTORE_REQUIRED_QUESTION','Información requerida');
define('FIBERSTORE_REVIEW_HEADLINE','Título de la reseña');
define('FIBERSTORE_EXAMPLE','Título *');
define('FIBERSTORE_REVIEWS_ATTACH','Adjuntar una imagen +');
define('FIBERSTORE_REVIEWS_SUBMIT_REVIEW','Enviar la reseña');
//推广文章页面


//客户中心页面





define('FIBERSTORE_SALES_MESSAGES','1. Sólo puedes solicitar el servicio de postventa después de completar el pedido. Por favor haz clic en la "Confirmación del recibo" en la página de los detalles del pedido para completarlo.<br>
2. Por favor solicita el servicio de postventa en la página de los detalles del pedido completado.');

//2016-5-19新增一级分类
  define('FIBERSTORE_TRANS1','Buscar por dispositivo de red');
define('FIBERSTORE_TRANS2','Buscar por módulo original');
define('FIBERSTORE_TRANS3','Cables de interconexión de fibra óptica</h1>
      </div>
      <div class="title_small">FS.COM ofrece montajes de cables de fibra óptica de alta calidad, tales como los cables de interconexión, pigtails, MCPs, cables Breakout, etc. Todos los cables de fibra óptica se pueden pedir como fibras monomodo 9/125, multimodo 62.5/125 OM1, multimodo 50/125 OM2 y multimodo 10 Gig 50/125 OM3/OM4. </div>
      
      <div class="sidebar_find">
          <span>Cables de fibra óptica populares');
define('FIBERSTORE_TRANS4','Comprar por Conectores');
define('FIBERSTORE_TRANS5','Todos los montajes de cables de fibra óptica');
define('FIBERSTORE_TRANS6','Comprar por Categoría');
define('FIBERSTORE_TRANS7','Cables de interconexión de fibra óptica');
define('FIBERSTORE_TRANS8','FS.COM ofrece montajes de cables de fibra óptica de alta calidad, tales como los cables de interconexión, pigtails, MCPs, cables Breakout, etc. Todos los cables de fibra óptica se pueden pedir como fibras monomodo 9/125, multimodo 62.5/125 OM1, multimodo 50/125 OM2 y multimodo 10 Gig 50/125 OM3/OM4. ');
define('FIBERSTORE_TRANS9','Cables de fibra óptica populares');
//2016-7-1 checkout页面
define('FS_CHECKOUT_ORDER_REMARKS','Reseñas de pedido');
define('FS_CHECKOUT_ORDER_ADVISE','Por favor, dinos el número de modelo de tu equipo para asegurar la compatibilidad.');
define('FS_CHECKOUT_REMARKS','Para cualquier requisito adicional sobre el envío del pedido, el paquete u otra información, por favor escríbelos en observaciones, que será importante para el procesamiento de pedidos. ¡Gracias!');

 //首页banner(注：首页的轮播图里面的文字暂时是放在图片里的)
define('FS_INDEX_OPTICS','10G QSFP28 SR ópticos de alta velocidad');
define('FS_INDEX_STOCK','En Stock');
define('FS_ORDER_NOW','Pedir ahora');

define('FS_index_solution','Solución de cable de multi-fibra preterminado MTP/MPO');
define('FS_INDEX_HELP','Ayudar a sus iniciativas de transmisión de datos para mantenerse a prueba de futuro');

define('FS_INDEX_TEST','Programa garantizado por prueba');
define('FS_INDEX_RESPEON','Nos esforzamos por lograr la confianza de nuestros clientes en cada prodcuto de fibra óptica');

define('FS_INDEX_DENSITY','Solución personalizada de conexión de alta densidad');
define('FS_TYPE','Cualquier tipo');
define('FS_SIZE','Cualquier tamaño');
define('FS_COLOR','Cualquier color');

define('FS_WITH_OUR','Con nuestro selector de cables de conexión de fibra');
define('FS_QUICKER_AND_EASIER','Localizar el más adecuado para su proyecto más rápido y fácil');
define('FS_TRY_IT','Probarlo ahora');

define('TEXT_HEADING_CAROUSEL_EXPAND_FIBER' , 'Ampliar las capacidades de fibra con la solución WDM en FS.COM');
define('TEXT_HEADING_CAROUSEL_HIGHLY_RECOMMEND' , '18-CH CWDM & 40-CH DWDM Mux/DeMux muy recomendables');
define('TEXT_HEADING_CAROUSEL_MOST_CHOICE' , '¡Siempre la opción más rentable para usted!');
define('FS_LEARN_MORE','Leer más');

define('FS_DATA_CENTER','Solución de centro de datos en FS.COM');
define('FS_DATA_TRANSPORT','para el transporte de datos de alta velocidad');


//test-assured-program
define('FS_OEM_DOMINANCE','Fiberstore está desafiando el dominio del OEM para convertirse en el proveedor líder de terceros en el mercado de productos ópticos a nivel mundial. El éxito de la empresa se basa en la calidad y la fiabilidad. En el proceso de fabricación de las soluciones ópticas, Fiberstore colabora exclusivamente con los líderes del mercado en el campo de la optoelectrónica como Mitsubishi Electric, CyOptics, Maxim Integrated, etc., y cumple con los requisitos más estrictos de productos.');

define('FS_QUALITY_CONTROL','Control de calidad');
define('FS_PRODUCTION_OF_TRANSCEIVER_OPTICS','La producción de los transceptores ópticos se realiza según la respectiva norma MSA actual. Todos los módulos también cumplen con las reglas y normas más importantes para los productos electrónicos. El control continuo de la calidad del producto antes de, durante y después del proceso de fabricación es la máxima prioridad. Cada lote producido está programado con los procedimientos normalizados de garantía de calidad, y el proceso de producción está controlado y supervisado constantemente.
');

define('FS_OPTICAL_TRANSCEIVERS','Transceptores ópticos');
define('FS_BEFORE_ENVIRONMENT_CHAMBER','Prueba de láser y de fotodiodo antes de la cámara de ambiente');
define('FS_SAMPLE_TEST','Prueba de muestra fiable en la cámara ambiental en 48 horas');
define('FS_AFTER_ENVIRONMENT_CHAMBER','Prueba de láser y de fotodiodo después de la cámara de ambiente');
define('FS_APPLICATION_TEST','Prueba de compatibilidad y de aplicaciones');
define('FS_FINAL_TEST_TRANSFER','Prueba final: la transferencia por la fibra verdadera');


define('FS_DIRECT_ATTACH_CABLES','Cables de conexión directa');
define('FS_TRANSMISSION_TEST_BEFORE','Prueba de transmisión antes de la cámara de ambiente');
define('FS_CHAMBER_RELIABLE_SAMPLE_TEST','Prueba de muestra fiable de la cámara ambiental en 48 horas ');
define('FS_MECHANICAL_LOAD','Prueba de carga mecánica');
define('FS_TRANSMISSION_TEST_AFTER','Prueba de transmisión después de la cámara ambiental');
define('FS_AND_APPLICATION_TEST','Prueba de compatibilidad y aplicación');
define('FS_FINAL_TEST_TRANSMISSION','Prueba final: la transmisión de la configuración de prueba');

define('FS_OUR_ADVANTAGES','Nuestras ventajas');

define('FS_WIDE_COMPATIBILITY','Alta compatibilidad');
define('FS_MAJOR_VENDORS_SYSTEMS','100% compatible con todos los sistemas principales');

define('FS_ABSOLUTE_GUARANTEE_QUALITY','Garantía de calidad absoluta');
define('FS_IN_YOUR_NETWORK','Siempre garantiza un rendimiento perfecto en la red');

define('FS_INDUSTRY_LEADING','Líder en garantías en la industria');
define('FS_LIFETIME','Garantías de por vida de todas las ópticas de Fiberstore');

define('SINCERE_SERVICE','Servicio sincero');
define('FS_WE_INSIST','Insistimos en el servicio sincero, receptivo y bien informado a cada cliente');

define('FS_FAST_GLOABL_DELIVERY','Entrega global rápido');
define('FS_COOPERATION_WITH_THE_FAMOUS','La cooperación con las famosas empresas de logística internacional garantiza el envío rápido a países de todo el mundo');

define('FS_GOOD_REPUTATION','Buena reputación');
define('FS_LONG_TERM','La cooperación a largo plazo con muchas empresas de telecomunicaciones e ISPs famosos');

define('FS_STRONG_STORAGE_SUPPORT','Soporte de almacenaje fuerte');
define('FS_A_LARGE_STOCK','Un gran stock de fibra óptica garantiza el suministro oportuno, apoyando envío en el mismo día');

define('COST_EFFECTIVE','Económico');
define('FS_DEFINITELY_SAVE','Definitivamente ahorra el presupuesto en la fibra óptica hasta un 70% de descuento, expandiendo los beneficios de todo el proyecto de fibra');

define('FS_TEST_ASSURED_PROGRAM','Programa garantizado por prueba');
define('FS_FIBERSTORE_TRULY','Fiberstore realmente entiende el valor de la compatibilidad e interoperabilidad a cada producto óptico. Cada módulo que proporciona Fiberstore debe ejecutar a través de la programación y una extensa serie de pruebas de diagnóstico de plataforma para probar el rendimiento y compatibilidad. En nuestro centro de pruebas, nos preocupamos por cada detalle del personal a las instalaciones de forma profesional, instalaciones de prueba avanzadas e interruptores integrales de marca original, para asegurar que nuestros clientes reciban la óptica de calidad superior.');

define('FS_SMART_DATA_SYSTEM','Sistema inteligente de datos');
define('FS_OUR_SMART_DATA','Nuestro sistema inteligente de datos permite una gestión eficaz del producto y control de calidad de acuerdo con el número de serie único, adecuadamente trazando el pedido, envío y cada parte.
');

define('FS_IN_HOUSE_CODING','Codificación propia');
define('FS_OUR_IN_HOUSE_CODING','Nuestras instalaciones de codificación programa todas las partes a las especificaciones OEM estándar para la compatibilidad con los principales proveedores y sistemas como Cisco, Juniper, Brocade, HP, Dell, Arista, etc.
');

define('FS_PERFORMANCE_TESTING','Pruebas de rendimiento');
define('FS_WITH_A_COMPREHENSIVE','Con una gama completa de switches de marca original, podemos crear un entorno y probar cada producto óptico de aplicación práctica para asegurar la calidad y la distancia.
');

define('FS_PACKAGING','Detección de integridad de embalaje');
define('FS_THE_LAST_TEST_ASSURED','La última etapa de la prueba para asegurar que nuestros productos sean enviados con el embalaje perfecto.');

define('FS_OUR_TEST_CENTER','Nuestro centro de pruebas');
define('FS_FEW_THIRD_PARTY','Pocos proveedores de terceros pueden ofrecer módulos 100% compatibles mientras que Fiberstore lo puede apoyar. Sólo cuando la calidad y el 100% de compatibilidad sean verificados y aprobados, nuestros módulos van a entrar en el mercado. Esto depende del centro de pruebas de Fiberstore que es apoyado por una variedad de switches principales de marca original. Estamos orgullosos de este centro de pruebas y creemos que todos los dispositivos valen las inversiones, ya que trae lo mejor a nuestros clientes.');

define('FS_OUR_OPTICS_TEST_SHOW','Fotos de nuestra prueba óptica');


//2016-07-13 by frankie

define('LIVE_CHAT_ONLINE','en línea');
define('LIVE_CHAT_TIT','Obtener todo el apoyo sobre la compra');
define('LIVE_CHAT_TIT1','Servicio profesional & soporte están disponibles en tres formas diferentes');
define('LIVE_CHAT_TIT2','Su mensaje se ha enviado a Fiberstore con éxito , ¡gracias!');
define('LIVE_CHAT_CON1','Charle en vivo con Fiberstore');
define('LIVE_CHAT_CON2','Hable con nosotros y obtenga la información relacionada inmediatamente.');
define('LIVE_CHAT_CON3','8 am. a medianoche PST lun. a vie.');
define('LIVE_CHAT_CON4','Por favor,déjenos un mensaje, nosotros\ vamos a responderle cuanto antes.');
define('LIVE_CHAT_CON5','Dejar mensajes');
define('LIVE_CHAT_CON6','Email a Fiberstore');
define('LIVE_CHAT_CON7','Respuesta en 12 horas');
define('LIVE_CHAT_CON8','Enviar una solicitud de consulta y obtener una rápida respuesta desde Fiberstore.');
define('LIVE_CHAT_CON9','E-mail ahora mismo');
define('LIVE_CHAT_CON10','Disponible');
define('LIVE_CHAT_CON11','Indisponible');
define('LIVE_CHAT_CON12','Hacer una llamada');
define('LIVE_HEAD_CON1','O haga clic en el botón de abajo para que nosotros le llamemos.<br /> 8 am.- 5 pm. CEDT.  lun. a vie.');
define('LIVE_HEAD_CON2','O haga clic en el botón de abajo para que nosotros le llamemos.<br /> 8 am.- 5 pm. EST.  lun. a vie.');
define('LIVE_HEAD_CON3','O haga clic en el botón de abajo para que nosotros le llamemos.<br /> 8 am.- 5 pm. BST.  lun. a vie.');
define('LIVE_HEAD_CON4','O haga clic en el botón de abajo para que nosotros le llamemos.<br />8 am.- 5 pm. PST.  lun. a vie.');
define('LIVE_BUTTON_HTML','Charlar ahora mismo');

define('LIVE_CHAT_MAIL','Obtener una cotización');
define('LIVE_CHAT_MAIL1','Para ayudar a servirle de forma rápida, por favor complete y envíe la siguiente información para que su pregunta/problema puede ser abordado por el departamento adecuado.');
define('LIVE_CHAT_MAIL2','Por favor, amablemente llene los campos solicitados a continuación y nuestros representantes de ventas profesionales se comunicarán con usted  en breve plazo de 12 horas.');
define('LIVE_CHAT_MAIL3','Introduzca su nombre:');
define('LIVE_CHAT_MAIL4','La dirección de su Email:');
define('LIVE_CHAT_MAIL5','Su país:');
define('LIVE_CHAT_MAIL6','En cuanto a:');
define('LIVE_CHAT_MAIL7','Número de telefono:');
define('LIVE_CHAT_MAIL8','Asunto del mensaje:');
define('LIVE_CHAT_MAIL9','Comentarios/Pregunta:');
define('LIVE_CHAT_MAIL10','Por favor seleccione uno');
define('LIVE_CHAT_MAIL11','Órdenes');
define('LIVE_CHAT_MAIL12','Precio al por mayor');
define('LIVE_CHAT_MAIL13','Pago');
define('LIVE_CHAT_MAIL14','Plazo de entrega');
define('LIVE_CHAT_MAIL15','Garantía');
define('LIVE_CHAT_MAIL16','Post-venta');
define('LIVE_CHAT_MAIL17','Solución tecnológica');
define('LIVE_CHAT_MAIL18','Información de productos');
define('LIVE_CHAT_MAIL19','Información general');

define('LIVE_CHAT_PHONE','Fiberstore le devuelve la llamada');
define('LIVE_CHAT_PHONE1','Por favor llame +1-425-226-2035 o deje su información de contacto abajo, y vamos a llamarle durante 8 a.m.– 5 p.m PST desde lunes a viernes.');
define('LIVE_CHAT_PHONE3','Introduzca su nombre:');
define('LIVE_CHAT_BACK','Atrás');
define('LIVE_CHAT_PHONE5','Su dirección de correo:');
define('LIVE_CHAT_PHONE7','El nombre de su empresa:');
define('LIVE_CHAT_PHONE8','Su país:');
define('LIVE_CHAT_PHONE10','Su teléfono:');
define('LIVE_CHAT_PHONE13','La mejor hora de devolver la llamada:');
define('LIVE_CHAT_SUBMIT','Enviar');

//tpl_modules_index_product_list_old_style.php
define('FS_FILTER','Filtro');
define('FS_VIEW_ALL','Ver todo');
//快递 优化

//2016-8-15 by buck
define('FS_GET_QUOTE1','Consigue una cotización');
define('FS_GET_QUOTE2','Para servirle de forma rápida, por favor complete y envíe la siguiente información para que su pregunta/problema pueda ser abordado por el departamento adecuado.');
define('FS_GET_QUOTE3','Por favor, rellene los espacios solicitados de abajo y nuestros profesionales de ventas se comunicará con usted en breve plazo de 12 horas siguientes.');
define('FS_GET_QUOTE4','Introduzca su nombre:');
define('FS_GET_QUOTE5','Dirección de email:');
define('FS_GET_QUOTE6','Su país:');
define('FS_GET_QUOTE7','Tema :');

define('FS_REGARDING1','Número de telefono');
define('FS_REGARDING2','Número de mensaje');
define('FS_REGARDING3','Precio al por mayor');
define('FS_REGARDING4','Pago');
define('FS_REGARDING5','Fecha de envío estimada');
define('FS_REGARDING6','Garantía');
define('FS_REGARDING7','Servicio posventa');
define('FS_REGARDING8','Solución tecnológica');
define('FS_REGARDING9','Información de productos');
define('FS_REGARDING10','Información general');

define('FS_GET_QUOTE8','Número de mensaje:');
define('FS_GET_QUOTE9','Asunto de mensaje:');
define('FS_GET_QUOTE20','Comentarios / Preguntas');
define('FS_GET_QUOTE10','Enviar');

define('FS_GET_QUOTE11','Por favor, asegúrese de que rellenó usted su nombre.');
define('FS_GET_QUOTE12','La dirección del correo electrónico que ha enviado no es reconocido.(Ejemplo: someone@example.com).');
define('FS_GET_QUOTE13','Por favor, introduzca un número de teléfono válido.');
define('FS_GET_QUOTE14','Por favor, introduzca una pregunta.');
define('FS_GET_QUOTE15','Envió su mensaje a Fiberstore con éxito, ¡gracias!');
define('FS_GET_QUOTE16','Lo siento, usted ha sido añadido a la lista negra!');

define('FS_GET_QUOTE17','Por favor, asegúrese de seleccionar su país.');
define('FS_GET_QUOTE18','El número de su teléfono debe ser 7 dígitos por lo menos.');
define('FS_GET_QUOTE19','Procesando');


//Content  in  order  page
// 2016-9-8 add by  frankie
define('ALL_ORDER','Todos los pedidos');
define('UNPAID_ORDER','Pedidos pendientes');
define('TRADING_ORDERS','Pedidos completados');
define('CLOSED_ORDERS','Pedidos cancelados');

define('FIBERSTORE_QUESTION','La pregunta se ha enviado con éxito');
define('FIBERSTORE_ORDER_PRIVATE','Pedidos privados');
define('FIBERSTORE_ORDER_COMPANY','Todos los pedidos para la empresa');
define('FIBERSTORE_ORDER_SELECT','Seleccionar por fecha de pedido');
define('PLEASE','Por favor elige');
define('WEEK','La última semana');
define('MONTH','El último mes');
define('THREE_MONTH','Los últimos tres meses');
define('FIBERSTORE_ORDER_ENTER','Introduce tu número de pedido');
define('FIBERSTORE_ORDER_NO','Número de pedido');
define('SEARCH','Buscar');
define('FIBERSTORE_ORDER_PROMT','No se encuentra ningún pedido.');
define('FIBERSTORE_ORDER_PICTURE','Imagen de producto');
define('FIBERSTORE_ORDER_DATE','Fecha de pedido');
define('CANCELED','Cancelado');
define('FIBERSTORE_ORDER_OPERATE','Operar');
define('FIBERSTORE_VIEW_DETAILS','Ver detalles');
define('PREVIOUS','Previo');
define('NEXT','Siguiente');
define('PAYMENT','Pago');
define('FIBERSTORE_ORDER_PAGE','Página');
define('FIBERSTORE_ORDER_OF','de');
define('CONNECTING_PAYPAL','Conectar a Paypal');
define('ARE_YOU_SURE','¿Estás seguro de que deseas cancelar el pedido?');
define('ONCE_YOU_DO','Una vez que lo hagas, no se podrá recuperarse.');
define('HOWEVER','Sin embargo, si realmente quieres cancelarlo, por favor cuéntanos la razón');
define('EXPENSIVE','Gastos de envío muy caros');
define('DUPLICATE','Se ha duplicado el pedido');
define('FAILING','Ha fallado el pago');
define('WRONG','Información incorrecta');
define('OUT','No están en stock');
define('NO_NEED','No lo necesito');
define('OFFLINE','Pedido offline');
define('FIBERSTORE_ORDER_CONFIRM','Confirmar');
define('OTHERS','Otros');
define('BEFORE_SUBMITTING','Antes de enviar,por favor cuéntanos la razón de cancelar el pedido');
define('CANCEL','Cancelar');

//fallwind	2016.9.9   add
define('FIBERSTORE_LIVE_CHAT','Live chat');
define('FIBERSTORE_EDIT_CART','Editar la cesta');
define('FIBERSTORE_PROCESSING','Procesando');
define('FIBERSTORE_ALL_RIGHTS_RESERVED','Todos los derechos reservados');
//分类 搜索公用 公用常量不要随意删除
define('FIBERSTORE_IMAGES','Imágenes');
define('FIBERSTORE_DETAILS','Detalles');
define('FIBERSTORE_SHOWING','Mostrando');
define('FIBERSTORE_OF','');
define('FIBERSTORE_RESULTS_BY',' resultados por ');
define('FIBERSTORE_YOUR_PRICE','Precio');
define('FIBERSTORE_QUANTITY','Cantidad');
define('FIBERSTORE_ADD_TO_CART','Añadir a la cesta');
define('FS_COMMON_CLEAR','Borrar selecciones');
define('FS_COMMON_COMPLIANT','Cumple con el estándar IEEE 802.3 que es  para aplicaciones de Fast Ethernet y Gigabit Ethernet');
define('FS_COMMON_ADD','Añadir');
define('FS_COMMON_ADDED','Añadido');
define('FS_COMMON_PROCESSING','En proceso');
define('FS_COMMON_PLEASE_WAIT','Please wait');
define('FS_COMMON_PRODUCT','Sehen das Produkt schnell');
define('FS_COMMON_NEXT','Siguiente');
define('FS_COMMON_PREVIOUS','Anterior');
define('FS_PRICE_LOW_HIGH', 'Precio ascendente');
define('FS_PRICE_HIGH_LOW', 'Precio descendente');

//define('FS_RATE_HOGH', 'Valoración descendente');
//define('FS_NEWEST_FIRST', 'Lo más nuevo');
//define('FS_POPULARITY', 'Popularidad');
define('FS_RATE_HOGH', 'Valoraciones');
define('FS_NEWEST_FIRST', 'Novedades');
define('FS_POPULARITY', 'Más vendidos');
//update 2016.10.27 frankie
define('FS_QUICK_VIEW', 'Vista rápida de producto');
define('FS_WAIT', 'Un momento por favor');
//update 2016.12.5 frankie
define('FS_VERIFIED_PUR','Compra verificada');
define('FS_COMMENTS','Comentar');
define('FS_SUBMIT','Enviar');
define('FS_REVIEWS9','Por ');
define('FS_REVIEWS26',' el');
define('FS_REVIEWS10','Compartir');
define('FS_REVIEWS11','Comentar');
define('FS_DELETE','Eliminar');
/****************end 公用常量****************/


//module shipping   运费模块
define('FS_SHIP_ORDER','Enviar a ');
define('FS_CHOOSE_SHIP','Elegir el método de envío ');
define('FS_COMPANY','Empresa de transporte');
define('FS_TIME','Tiempo de envío');
define('FS_COST','Cargos de envío');
define('FS_TO','a');
define('FS_VIA','por');
define('FS_FREE_SHIP','Envío gratis');
define('FS_PREFER','Si prefieres utilizar tu propia cuenta de Express, por favor indica el número de cuenta, y Fiberstore no cobrará el flete.');
define('FS_METHOD','Método de envío');
define('FS_ACCOUNt','Cuenta de Express');
define('FS_NO_SHIPPING','No hay envío disponible para el país seleccionado');
define('FS_BUSINESS_DAYS','días laborales');
define('FS_BUSINESS_DAY','día laboral');
define('FS_SHIP_CONFIRM','Confirmar');
define('FS_WORK_DAYS_SERVICE', 'días hábiles');

//ery	2016.9.22   checkout系列页面
define('FIBERSTORE_CART','Cesta');
define('FIBERSTORE_CHECKOUT','Confirmar el pago');
define('FIBERSTORE_SUCCESS','con éxito');
define('FIBERSTORE_BILLING_ADDRESS','Dirección de facturación');
define('FIBERSTORE_FIRST_NAME','Nombre');
define('FIBERSTORE_LAST_NAME','Apellido');
define('FIBERSTORE_POSTAL_CODE','Código postal');
define('FIBERSTORE_CITY','Ciudad');
define('FIBERSTORE_STATE','Estado');
define('FIBERSTORE_PROVINCE','Provincia');
define('FIBERSTORE_REGION','Región');
define('FIBERSTORE_TELEPHONE_NUMBER','Número de teléfono');
define('F_CREDIT_OR_DEBIT','Tarjetas de crédito/débito');
define('F_SELECT_CREDIT','Elegir la tarjeta de crédito');
define('F_CONTINUE','Continuar');


//frankie  stock_list
define('STOCK_LIST_01','Gran stock de FS.COM');
define('STOCK_LIST_02','Amplia selección');
define('STOCK_LIST_03','Stock adecuado');
define('STOCK_LIST_04','Se envían al mismo día');
define('STOCK_LIST_FILTER','Filtro');
define('STOCK_LIST_MODEL','Modelo');
define('STOCK_LIST_DESCRIPTION','Descripción');
define('STOCK_LIST_PRICE','Precio');
define('STOCK_LIST_WUHAN','Stock');
define('STOCK_LIST_QUANTITY','Cantidad');
define('STOCK_LIST_01','FS.COM Seattle Stock List');
define('STOCK_LIST_02','Wide Selection');
define('STOCK_LIST_03','Adequate Stock');
define('STOCK_LIST_04','Same Day Shipping');
//评论相关页面编辑头像 2017.4.10  ery
define('FS_ADAPTER_TYPE', 'Tipo de adaptador');
define('FS_TRANS_RELATED', 'Type');

define('FS_REVIEWS_REPLACE','Reemplaza avatar');
define('FS_REVIEWS_EDIT','Edit Your Profile');
define('FS_REVIEWS_RECOMMENDED','Foto de perfil recomendado');
define('FS_REVIEWS_LOCAL','Carga local');
define('FS_REVIEWS_ONLY','Sólo soporta JPG, GIF, PNG, JPEG, BMP formato, el archivo es menos de 300KB');
define('FS_REVIEWS_SAVE','Guardar');

//账户中心相关页面公用向量   2017.5.12  ery  add
/*edit_my_account页面*/
define('ACCOUNT_MY_ACCOUNT','Mi cuenta');
define('ACCOUNT_EDIT_ACCOUNT','Configuración de la cuenta');
define('ACCOUNT_EDIT_BELOW','Edita tu información, luego haz clic en el botón <b>Actualizar </b> para realizar los cambios.');
define('ACCOUNT_EDIT_FOLLOW','Verifica lo siguiente…');
define('ACCOUNT_EDIT_ACCOUNT_INFO','Información de cuenta');
define('ACCOUNT_EDIT_UPDATE','Guardar');
define('ACCOUNT_EDIT_EMAIL','Dirección de correo electrónico');
define('ACCOUNT_EDIT_NEW','Nueva contraseña');
define('ACCOUNT_EDIT_REENTER','Repite la contraseña');
define('ACCOUNT_EDIT_ADDRESS','Información de dirección');
define('ACCOUNT_EDIT_FIRST','Nombre');
define('ACCOUNT_EDIT_LAST','Apellido');
define('ACCOUNT_EDIT_COMPANY','Nombre de la empresa');
define('ACCOUNT_EDIT_STREET','Dirección física');
define('ACCOUNT_EDIT_LINE','Línea 2 de dirección');
define('ACCOUNT_EDIT_POSTAL','Código postal');
define('ACCOUNT_EDIT_CITY','Ciudad');
define('ACCOUNT_EDIT_COUNTRY','País/Región');
define('ACCOUNT_EDIT_STATE','Estado / Provincia / Región');
define('ACCOUNT_EDIT_PHONE','Número de teléfono');
define('ACCOUNT_EDIT_EMIAL_MSG','La dirección de correo electrónico que enviaste no está reconocida.(ejemplo:alguien@ejemplo.com).');
define('ACCOUNT_EDIT_PASS_MSG','Tu contraseña debe tener al menos 7 caracteres.');
define('ACCOUNT_EDIT_CONFIRM_MSG',"La contraseña de confirmación no coincide con la nueva contraseña. Deben ser idénticos.");
define('ACCOUNT_EDIT_FIRST_MSG','Introduce tu nombre.');
define('ACCOUNT_EDIT_LAST_MSG','Introduce tu apellido.');
define('ACCOUNT_EDIT_STREET_MSG','Introduce tu dirección física.');
define('ACCOUNT_EDIT_POSTAL_MSG','Introduce tu código postal.');
define('ACCOUNT_EDIT_CITY_MSG','Por favor, introduce tu ciudad.');
define('ACCOUNT_EDIT_COUNTRY_MSG','Introduce tu país.');
define('ACCOUNT_EDIT_STATE_MSG','Introduce tu estado / provincia / región.');
define('ACCOUNT_EDIT_PHONE_MSG','Introduce tu número de teléfono.');
define('ACCOUNT_EDIT_HEADER_OUR','Dirección de correo electrónico ya está registrada.');
define('ACCOUNT_EDIT_HEADER_EDIT','Ha editado el apodo con éxito.');
define('ACCOUNT_EDIT_HEADER_FILE','¡El archivo es demasiado grande!');
define('ACCOUNT_EDIT_HEADER_CUSTOMER','¡Has cambiado tu foto de perfil con éxito!');
define('ACCOUNT_EDIT_HEADER_THANKS','¡Gracias!');
define('ACCOUNT_EDIT_HEADER_FS','Servicio al cliente de FS.COM');
define('ACCOUNT_EDIT_HEADER_INFO','FS.COM: Actualizar la información de cuenta');
define('ACCOUNT_EDIT_HEADER_YOUR','Se guardó la información de la cuenta. Por favor revisa a continuación para verificar la información de tu cuenta');

/*my_questions和my_questions_details页面*/
define('FS_QUSTION','preguntas');
define('FS_QUSTI','pregunta');
define('FS_QUSTION_TELL','Cuéntanos tus problemas, entonces haremos todo lo posible para ayudarte.');
define('FS_QUSTION_ASK','Hacer una pregunta');
define('FS_QUSTION_DATE','Fecha');
define('FS_QUSTION_STATUS','Estado');
define('FS_QUSTION_VIEW','Ver');
define('FS_QUSTION_REMOVE','Retirar');
define('FS_QUSTION_ENTRIES','Entradas');
define('FS_QUSTION_NO','No has hecho ninguna pregunta.');
define('FS_QUSTION_ANSWERS','Contestas');
define('FS_QUSTION_REPLY','Las preguntas estaban en el proceso.');
define('FS_QUSTION_JS','¿Eliminar esta información?');
/*manage_address页面*/
define('FS_ADDRESS_BOOK','Mi dirección');
define('FS_ADDRESS_NAME','Nombre');
define('FS_ADDRESS_COMPANY','Empresa');
define('FS_ADDRESS_ADDRESS','Dirección');
define('FS_ADDRESS_NO','No se ha podido encontrar la dirección');
define('FS_ADDRESS_DEFAULT','Por defecto');
define('FS_ADDRESS_SET','Ajustar por defecto');
define('FS_ADDRESS_EDIT','Editar');
define('FS_ADDRESS_CREATE','Crear dirección');
define('FS_ADDRESS_UPDATE','Actualizar entrada de dirección');
define('FS_ADDRESS_PLEASE','Completa este formulario para editar la dirección, luego haz clic en el botón Actualizar.');

define('FS_ADDRESS_FIRST_REQUIRED_TIP','Tu nombre no puede estar vacío.');
define('FS_ADDRESS_FIRST_MSG','El nombre debe tener al menos 2 caracteres.');

define('FS_ADDRESS_LAST_REQUIRED_TIP','Su apellido no puede estar vacío.');
define('FS_ADDRESS_LAST_MSG','El apellido debe tener al menos 2 caracteres.');

define('FS_ADDRESS_SORRY','Por favor, introduce la dirección de entrega.');
define('FS_ADDRESS_STREET_FORMAT_TIP','La línea 1 de dirección  debe contener entre 4 y 35 caracteres.');
define("FS_ADDRESS_STREET_PO_BOX_TIP","No se realizan envíos a apartados postales");

define('FS_ADDRESS_POSTAL_REQUIRED_TIP','Tu ZIP/postal no puede estar vacío.');
define('FS_ADDRESS_POSTAL_MSG','El código postaldebe tener al menos 3 caracteres.');

define('FS_ADDRESS_COUNTRY_MSG','Falta el país.');
define('FS_ADDRESS_STATE_MSG','Falta el estado.');

define('FS_ADDRESS_PHONE_REQUIRED_TIP','Su número de teléfono no puede estar vacío.');
define('FS_ADDRESS_PHONE_MSG','Tu número de teléfono debe tener al menos 6 dígitos.');

define('FS_ADDRESS_UP_ADDRESS','Actualizar dirección');
define('FS_ADDRESS_NEW','Nueva direccion');
define('FS_ADDRESS_NEW_PLEASE','Completa este formulario para añadir una nueva dirección, luego haz clic en el botón añadir.');
define('FS_ADDRESS_ADD','Añadir dirección');
define('FS_ADDRESS_DELETE','¡Has eliminado la dirección con éxito!');
define('FS_ADDRESS_SET_SUCCESS','¡Has ajustado la dirección por defecto!');
define('FS_ADDRESS_UP_SUCCESS','Se guardó la información de la cuenta.');
define('FS_ADDRESS_ADD_SUCCESS','Has añadido la dirección con éxito');
/*manage_order相关页面*/
define('MANAGE_ORDER_STATUS','Estado del pedido');
define('MANAGE_ORDER_ORDER','Pedido #:');
define('MANAGE_ORDER_SHIPMENT','Envío');
define('MANAGE_ORDER_INFORMATION','Información del pedido');
define('MANAGE_ORDER_DATE','Fecha del pedido');
define('MANAGE_ORDER_PAYMENT','Método de pago');
define('MANAGE_ORDER_SEE','Ver todo');
define('MANAGE_ORDER_PO','No. de PO');
define('MANAGE_ORDER_RMA_NO','RMA NO.');
define('MANAGE_ORDER_TEL','tel');
define('MANAGE_ORDER_NOT','Aún no configurado');
define('MANAGE_ORDER_SHIPPING','Información de envío');
define('MANAGE_ORDER_PRODUCT','Producto');
define('MANAGE_ORDER_ITEM','Precio unitario');
define('MANAGE_ORDER_QUANTITY','Cantidad');
define('MANAGE_ORDER_TOTAL','Total');
define('MANAGE_ORDER_QTY','pza(s)');
define('MANAGE_ORDER_WRITE','Escribir una reseña');
define('MANAGE_ORDER_PRINT','Imprimir facturas');
define('MANAGE_ORDER_REORDER','Reordenar');
define('MANAGE_ORDER_TIME','Tiempo de procesamiento');
define('MANAGE_ORDER_INFO','Información de procesamiento');
define('MANAGE_ORDER_OPERATOR','Operador de procesamiento');
define('MANAGE_ORDER_COMMODITY','Procesamiento de productos');
define('MANAGE_ORDER_MSG','¡Has cancelado el pedido con éxito!');
define('MANAGE_ORDER_ALL','Todos los pedidos');
define('MANAGE_ORDER_PENDING','Pedidos pendientes');
define('MANAGE_ORDER_COMPLETED','Pedidos completados');
define('MANAGE_ORDER_CANCELLED','Pedidos cancelados');
define('MANAGE_ORDER_RMA','RMA');
define('MANAGE_ORDER_PLACED','Fecha de pedido');
define('MANAGE_ORDER_SHIPING','Enviar a');
define('MANAGE_ORDER_DETAILS','Detalles del pedido');
define('MANAGE_ORDER_INVOICE','Factura');
define('MANAGE_ORDER_DOWNLOAD_INVOICE','Descargar factura');
define('MANAGE_ORDER_BUY','Comprar otra vez');
define('MANAGE_ORDER_VIEW','Ver más artículos en el pedido');
define('MANAGE_ORDER_PAY','Pagar ahora');
define('MANAGE_ORDER_CANCEL','Cancelar el pedido');
define('MANAGE_ORDER_RETURN','Devoluciones');
define('MANAGE_ORDER_RESTORE','Restaurar el pedido cancelado');
define('MANAGE_ORDER_MONTH','Último mes');
define('MANAGE_ORDER_THREE_MONTHS','Últimos tres meses');
define('MANAGE_ORDER_YEAR','Último año');
define('MANAGE_ORDER_YEAR_AGO','Hace un año');
define('MANAGE_ORDER_NO','Número de pedido.');
define('MANAGE_ORDER_SEARCH_NO','No. de pedido/PO');
define('MANAGE_ORDER_HEADER','Petición de cancelar el pedido se ha enviado con éxito, espera por favor');
define('MANAGE_ORDER_EA','/ud.');
define('FIBERSTORE_ORDER_PROMT2','No ha realizado ningún pedido.');
/*sales_service页面*/
define('FS_SALES_CHOOSE','Elegir artículos para devolver');
define('FS_SALES_ALL','Todo');
define('FS_SALES_RETURN','Devolver');
define('FS_SALES_CONTINUE','Continuar');
define('FS_SALES_SELECT','Seleccionar tus productos');
define('FS_SALES_CONFIRM','¿Cancelar esta Orden?');
/*sales_service_info页面*/
define('FS_SALES_REASONS','RMA Confirmación');
define('FS_SALES_PLEASE','Selecciona el tipo de servicio.');
define('FS_SALES_REFUND','devolución y reembolso');
define('FS_SALES_REPLACE','cambio');
define('FS_SALES_MAINTENANCE','reparación');
define('FS_SALES_WHY','¿Por qué devuelve esto?');
define('FS_SALES_NO','Ya no es necesario');
define('FS_SALES_INCORRECT','Producto o tamaño incorrecto');
define('FS_SALES_MATCH',"No coincide con la descripción");
define('FS_SALES_DAMAGED','Llegó dañado');
define('FS_SALES_RECEIVED','Recibo un artículo equivocado');
define('FS_SALES_NOT','No cumple con mi necesidad');
define('FS_SALES_NO_REASON','Sin razón');
define('FS_SALES_OTHER','Otro');
define('FS_SALES_COMMENTS','Comentarios (obligatorio)');
define('FS_SALES_NOTE','NOTA');
define('FS_SALES_WE',"No podemos ofrecer excepciones de política en respuesta a comentarios");
define('FS_SALES_WRITE','Escribe tu problema.');
define('FS_SALES_SUCCESSFUL','Con éxito');
define('RMA_TRACK_STATUS','Estado de la pista');
define('RMA_SERVICE_TYPE','Tipo de servicio');
define('RMA_REASON','Razones para el servicio');
/*sales_service_details*/
define('SALES_DETAILS_CONFIRM','Confirmar recibo');
define('SALES_DETAILS_RECEIPT','Confirmación de recepción');
define('SALES_DETAILS_SUBMIT','Enviar solicitud de RMB');
define('SALES_DETAILS_REJECT','Rechazado');
define('SALES_DETAILS_APPROVED','Aprobado');
define('SALES_DETAILS_RETURN','Reemplazar');
define('SALES_DETAILS_RMA','RMA recibido');
define('SALES_DETAILS_NEW','Nuevo envío');
define('SALES_DETAILS_REFUND','Devolver');
define('SALES_DETAILS_COMPLETE','Completar');
define('SALES_DETAILS_SEND','¿Cómo enviar de vuelta?');
define('SALES_DETAILS_SEND_MSG',' Sigue por favor el diagrama de flujo siguiente para volver artículos, Acerca de "crear etiqueta de envío", puede hacerlo en el sitio web de una empresa Express o obtenerlo de la ubicación de un mensajero. Si cree que la etiqueta de envío debe ser creada y pagada por FS.COM, por favor llama a +1 253 2773058 o envia correos a service.us@fs.com.');
define('SALES_DETAILS_FROM','Devuelto por');
define('SALES_DETAILS_EDIT','Editar');
define('SALES_DETAILS_DELIVER','Enviado a');
define('SALES_DETAILS_FILL','Rellenar el Awb');
define('SALES_DETAILS_AWB','Por favor, rellene el AWB para que nuestra pista logística devuelva la(s) parcela(s), una vez que la recibamos, el reemplazo, el reembolso o el mantenimiento serán procesados pronto.');
define('SALES_DETAILS_TRACKING','Número de seguimiento');
define('SALES_DETAILS_PLEASE','Anota el número de seguimiento.');
define('SALES_DETAILS_PRINT','Imprimir RMA');
define('SALES_DETAILS_PRINT_MSG','RMA puede ayudarnos a distinguir su(s) paquete(s) para procesar su solicitud de RMA al siguiente paso más rápidamente. Por favor imprímalo y adjúntelo con lo(s) paquete(s) devuelta(s).');
define('SALES_DETAILS_STEP_CONFIRM','Confirmar la dirección');
define('SALES_DETAILS_STEP_PRINT','Imprimir formulario RMA');
define('SALES_DETAILS_STEP_ATTACH','Adjunta al formulario RMA');
define('SALES_DETAILS_STEP_CREATE','Crear una etiqueta de envío');
define('SALES_DETAILS_STEP_SHIP','Enviar');
define('SALES_DETAILS_CANCEL','Cancelado');

/*售后流程状态提示*/
define('SALES_MSG_APPROVED','Tu solicitud de RMA ha sido aprobada, por favor devuelve el paquete a nosotros.');
define('SALES_MSG_SUBMIT','Tu solicitud de RMA ha sido enviada, por favor espera el resultado.');
define('SALES_MSG_RETURN','Gracias por devolvernos paquetes, nuestro departamento de logística prestará atención al estado de envío.');
define('SALES_MSG_COMPLETE','La RMA se ha completado.');

//request a  quote
define('FS_PANEL_REQUEST','Solicitar una cotización');
define('FS_PANEL_YOUR','Tu nombre');
define('FS_PANEL_PHONE','Número de teléfono');
define('FS_PANEL_COUNTRY','Tu país');
define('FS_PANEL_SEARCH','Busca tu país');
define('FS_PANEL_EMAIL','Tu correo electrónico');
define('FS_PANEL_COMMENTS','Comentario/Pregunta');
define('FS_PANEL_UPLOAD','Subir archivos');
define('FS_PANEL_COMPLETE','Carga completado!');
define('FS_PANEL_PLEASE','Por favor, rellena la información correcta!');

//2017.6.6		add		ery   manage_orders & account_history_info
define('F_RECEIPT_CONFIRMATION','Confirmar la recepción');
define('F_REFUNDED_PROCESSING','Proceso de reembolso');
define('MANAGE_ORDER_ARE','¿Has recibido el/los producto(s)?');
define('MANAGE_ORDER_YES','Sí');
define('MANAGE_ORDER_JS_NO','No');
define('FIBERSTORE_REFUND','Confirmación de reembolso');
define('FIBERSTORE_ONCE_RECOVERED','Una vez confirmado, no se recuperará más.');
define('FIBERSTORE_PLEASE_KINDLY','Por favor, rellena los motivos de la cancelación del pedido si usted insista en ella.');

//2017.6.8 add frnakie
define('FS_THEA_CTUAL_SHIPPING_TIME','Siempre nos dedicamos a ofrecer el envío más rápido con un sistema de almacenes múltiples. Conocer más sobre nuestra <ahref="'.zen_href_link('shipping_delivery').'">política de envío</a>.');
//manage_orders & sales_service_list  2017.6.10		add 	ery
define('MANAGE_ORDER_SEARCH','Buscar todos los pedidos');
define('MANAGE_ORDER_FILTER','Filtrado de pedidos');
define('MANAGE_ORDER_BACK','Volver');
define('MANAGE_ORDER_APPLY','Aplicar');
define('MANAGE_ORDER_TYPE','Tipo de pedido');
define('MANAGE_ORDER_TIME_FILTER','Filtrado de tiempo');
define('FS_PLEASE_W_REVIEW','Escribe un comentario...');
define('FS_REVIEWS_COMMENT_DEACRIPTION','Necesita iniciar o crear una cuenta antes de escribir comentarios');

//2017.7.5 add by frankie
define('ACCOUNT_EDIT_SUCCESS','Exitoso');
define('FS_REMOVED_CART','Se ha eliminado correctamente de su cesta');
define('FS_UPDATE','actualizar');

//2017.7.11. add by frankie
define('PATCH_PANEL_01','¿Cómo obtener más apoyo?');
define('PATCH_PANEL_02','FS se concentra en el centro de datos, la empresa y la solución de red de transmisión óptica para ayudarte a construir exactamente lo que necesitas.');
define('PATCH_PANEL_03','Ponte en contacto con soporte técnico:');
define('PATCH_PANEL_04','o nuestro equipo de ventas:');

//2017.7.11  add by frankie
define('ACCOUNT_TOTAL','Subtotal');
define('ACCOUNT_OF_SHIPPING','(+) Costo de envío:');
define('ACCOUNT_OF_TOTAL','Total:');
define('ACCOUNT_OF_GSP_TOTAL_AU','Total (GST incluido)');
define('FS_ORDERS_DETAILS_TAX_AU','Importe de GST');

//2017.8.3 add by frankie
define('TITLE_RELARED_DES',"Cada transceptor se prueba individualmente en el equipo correspondiente como Cisco, Arista, Juniper, Dell, Brocade y otras marcas, pasó la supervisión del sistema de control de calidad inteligente de Fiberstore.");
define('TITLE_RELARED_01','40GBASE-SR4 QSFP+ 850nm 150m MTP/MPO transceptor para MMF');
define('TITLE_RELARED_02','QSFP28 100GBASE-SR4 850nm 100m transceptor');
define('TITLE_RELARED_03','40GBASE-LR4 y OTU3 QSFP+ 1310nm 10km LC transceptor para SMF');
define('TITLE_RELARED_04','QSFP28 100GBASE-LR4 1310nm 10km transceptor');
define('TITLE_RELARED_05','Marca compatible');

//checkout 运输方式
define('FS_CHECK_OTHERS','Otros');
//2017.8.15 add  全站通用常量
define('FS_SER_COMMON_EMALl','Sales@fs.com');
if($_SESSION['languages_code'] == 'es'){
    define('FS_EMAIL','es@fs.com');
}elseif($_SESSION['languages_code'] == 'mx'){
    define('FS_EMAIL','mx@fs.com');
}
define("MANAGE_ORDER_VIEW_PO","Ver mi PO");
define("MANAGE_PO_NUMBER","PO#");
//2017.8.9 		add 	ery  税号
define('FS_VAT_PLEASE','Favor de ingresar un código impuesto/número de IVA válido. (ES+ número)');
define('FS_VAT_NO','Sin número de identificación de IVA');
define('FS_CHECK_OUT_STATE','Municipio');
define('FS_CHECK_OUT_PLEASE','Ciudad');
define('FS_CHECK_OUT_INVALID','Favor de ingresar un teléfono válido, inténtelo de nuevo.');
define('FS_CHECK_OUT_NEED','Ayuda');
define('FS_CHECK_OUT_LIVE','Live Chat');
define('FS_CHECK_OUT_EMAIL','Email');
define('FS_CHECK_OUT_TAX','Impuesto');
define('FS_CHECK_OUT_TAX_RU','Impuesto');
define('FS_CHECK_OUT_TAX_CN','Impuesto');
define('FS_CHECK_OUT_ORDER','Resumen del pedido');
define('FS_CHECK_OUT_REMARKS','Añadir comentarios de pedido');
define('FS_CHECK_OUT_CHANGE','Cambiar');
define('FS_CHECK_OUT_ADD','Añadir una dirección nueva');
define('FS_CHECK_OUT_REVIEW','Confirmación de artículos y opciones de envío');
define('FS_CHECK_OUT_YOUR','Tus artículos');
define('FS_CHECK_OUT_ADDRESS','Tus direcciones');
define('EMAIL_CHECKOUT_COMMON_VAT_COST','IVA');
define('EMAIL_CHECKOUT_COMMON_VAT_COST2','IVA');
define('EMAIL_CHECKOUT_COMMON_VAT_COST_FR','IVA');
define('FS_CHECK_OUT_INCLUDEING','(IVA incluido)');
define('FS_CHECK_OUT_EXCLUDING','(Impuestos excluidos)');
define('FS_CHECK_OUT_TAX_DE', 'IVA');

define('FS_CHECK_OUT_EXCLUDING_CA','(Este precio no incluye ningún <a href="javascript:void(0);" onclick="show_taxes()" class=" checkout_Npro_priceLiL tax_content tax_color">impuesto</a>)');

define('FS_CHECK_OUT_EXCLUDING_RU_NATURE','(Impuestos excluidos)');

define('FS_ADDRESS_INVOCE','Me gustaría recibir la factura del pedido por correo electrónico.');
define ('FS_CHECK_ADDRESS_TYPE', "Tipo de dirección");
define ('FS_CHECK_OUT_ADTYPE_TIT', "El tipo de dirección no puede estar vacío");
define ('FS_CHECK_OUT_COMPANY_TIT', "El nombre de la compañía no puede estar vacío");

// add by aron 2017.7.17
define("MANAGE_ORDER_PURCHASE_ORDER",'Orden de compra');
define("MANAGE_ORDER_UPLOAD_PO_FILE",'Subir el PO');
define("MANAGE_ORDER_UPLOAD_PURCHASE_ORDER",'Subir el PO');
define("MANAGE_ORDER_UPLOAD_MESAAGE",'No se enviará hasta que el PO se reciba. El PO debe ser recibido dentro de 5 días. IEl número de orden debe ser incluido en el PO.');
define("MANAGE_ORDER_UPLOAD_FILE_TEXT",' Seleccionar archivo ');
define("MANAGE_ORDER_UPLOAD_ERROR","Permite los archivos PDF, JPG, PNG. Tamaño máximo de archivo:4MB");
define("MANAGE_ORDER_UPLOAD_SUBMIT","Subir");
define("MANAGE_ORDER_UPLOAD_LABEL",'Subir el archivo');

define('FS_DHLG','DHL Express Domestic');
define('FS_DHLE','DHL Economy');
define('FS_DHLEE','DHL Express Worldwide');
// add by Frankie 2017.9.8
define('FS_WAREHOSE_CA_TIP',' en pedidos superiores a $ 79 enviados desde el almacén de EE. UU.');
define('FS_WAREHOSE_EU_TIP','Envío gratis en pedidos de más de 79 € enviados desde el almacén de la UE (Alemania)');
define('FS_WAREHOSE_OTHER_TIP','El sistema de almacenamiento múltiple de FS.COM asegura la entrega más rápida a AU');
define('FS_USMX_SHIPPING_TIP',' en pedidos superiores a MXN$ 1,600 enviados desde el almacén de EE. UU.');
define('FS_DEMX_SHIPPING_TIP','Envío gratis en pedidos de más de MXN$ 1,600 enviados desde el almacén de la UE (Alemania)');

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 免运费提示信息（每个站点显示不一样。不是直接翻译的）
//define('FS_HEADER_FREE_SHIPPING_US_TIP','Envío Gratuito en Pedidos de artículos elegibles Superiores a US$ 79/MXN$1,506');
define('FS_HEADER_FREE_SHIPPING_US_TIP','Envío gratuito para pedidos superiores a US$ 79.*');
define('FS_FOOTER_FREE_SHIPPING_US_TIP','Envío gratuito');
//define('FS_HEADER_FREE_SHIPPING_DE_TIP','Envío gratuito para pedidos superiores a $MONEY.*');
define('FS_HEADER_FREE_SHIPPING_DE_TIP','Envío gratuito para los pedidos de productos seleccionados superiores a $MONEY *');
define('FS_FOOTER_FREE_SHIPPING_DE_TIP','Envío gratuito');
define('FS_HEADER_FREE_SHIPPING_AU_TIP','Envío Gratuito en Pedidos de artículos elegibles Superiores a A$99');
define('FS_FOOTER_FREE_SHIPPING_AU_TIP','Envío gratuito');
define('FS_HEADER_FREE_SHIPPING_OTHER_TIP','Envío el mismo día en una amplia selección de artículos en existencia');
define('FS_FOOTER_FREE_SHIPPING_OTHER_TIP','Envío el mismo día');
define('FS_HEADER_FREE_SHIPPING_USMX_MX','Envío gratuito para los pedidos de productos seleccionados superiores a MXN$ 1,600 *');
define('FS_FOOTER_FREE_SHIPPING_USMX_MX','Envío gratuito');

define('FS_M_FREE_SHIPPING_USMX_MX','Envío gratis a partir de MXN$ 1,600');
define('FS_M_FREE_SHIPPING_DE_TIP','Envío gratis a patir de $MONEY');
define('FS_M_FREE_SHIPPING_AU_TIP','Envío gratis a patir de A$99');
define('FS_M_FREE_SHIPPING_FAST_SHIPPING','Envío rápido a');
define('FS_M_SHIPPING_US_TIP','Envío gratis a partir de US$ 79');

//update  by frankie 2017.9.27
define('FIBER_CHECK_CART','Cesta');
define('FIBER_CHECK_CHECKOUT','Revisa');
define('FIBER_CHECK_SUCCESS','Con éxito');
define('FIBER_CHECK_EDIT_CART','Editar la cesta');
define("FS_CHECK_OUT_SELECT","Favor de elegir");
define("FS_CHECK_OUT_BUSINESS","Tipo empresarial");
define("FS_CHECK_OUT_INDIVIDUAL","Residencial");
define("CHECKOUT_JS_TIT1","Favor de ingresar la dirección.");
define("CHECKOUT_JS_TIT2","Favor de elegir una dirección.");
define("CHECKOUT_JS_TIT3","Favor de ingresar el número de teléfono");
define("CHECKOUT_JS_TIT4","Favor de actualizar el tipo de dirección y VAT. ");
define("CHECKOUT_JS_TIT5","Favor de ingresar el país");
define("ADDRESSTYPE","Tipo de dirección");
define("ADDRESS_TYPE_TIT1","Favor de elegir el tipo de dirección.");
define("ADDRESS_TYPE_TIT2","Favor de ingresar el nombre empresarial.");
define('FIBER_CHECK_PAYMENT','Método de pago');
define('FIBERSTORE_ADDRESS_LINE','Dirección Línea 2');
define('FIBER_CHECK_CREDIT','Tarjeta de crédito/débito');
define('FIBER_CHECK_MAKE','Recuerde que usted será redirigido a PayPal después de que haga su pedido.');
define('FIBER_CHECK_NOTE','Nota:');
define('FIBER_CHECK_OUR','Nuestra cuenta paypal es PAYPAL@FS.COM.');
define('FIBER_CHECK_WE','Aceptamos las siguientes tarjetas de crédito y débito');
define('FIBER_CHECK_FOR','Por razones de seguridad no guardaremos ninguna información de su tarjeta de crédito');
define('FIBER_CHECK_TELE','Teléfono e Internet Banking-BPAY');
define('FIBER_CHECK_CONTACT','Póngase en contacto con su banco o institución financiera para realizar este pago de cheques, ahorros, débitos, tarjetas de crédito o su cuenta de transaciones.');
define('FIBER_CHECK_OFFERS','Le ofrecemos un método de pago en tiempo real para aceptar pagos por Internet.');
define('FIBER_CHECK_HSBC','Cuenta bancaria de HSBC');
define('FIBER_CHECK_BANK_NAME','Nombre del Banco Beneficiario:');
define('FIBER_CHECK_AC_NAME','Nombre del beneficiario:');
define('FIBER_CHECK_AC_NO','Número de la cuenta beneficiaria:');
define('FIBER_CHECK_SWIFT','Código SWIFT:');
define('FIBER_CHECK_BANK_ADDRESS','Dirección del banco beneficiario:');
define('FIBER_CHECK_ADDRESS','Información de dirección');
define('FIBER_CHECK_EDIT','Editar');
define('FIBER_CHECK_WIRE','Transferencia bancaria ');
define('FIBER_CHECK_COST','Costo de envío');
define('FIBER_CHECK_SUB','Subtotal');
define('FIBER_CHECK_TOTAL','Total');
define('FIBER_CHECK_PAYPAL','Ir a Paypal');
define('FIBER_CHECK_BPAY','Ir a BPAY');
define('FIBER_CHECK_ENETS','Ir a eNETS');
define('FIBER_CHECK_IDEAL','Ir a iDEAL');
define('FIBER_CHECK_SOFORT','Ir a SOFORT');
define('FIBER_CHECK_CONFIRM','Confirmar para pagar');
define('FIBER_CHECK_SUBMIT','Envío');
define('FIBER_CHECK_USE','Usar mi propia cuenta de envío');
define('FIBER_CHECK_EXPRESS','Cuenta Express');
define('FIBER_CHECK_MORE',' Mostrar todo');
define('FIBER_CHECK_LESS','Contraer todos');
define('FIBER_CHECK_FREE','Gratis');
define('FIBER_CHECK_FREE_SHIPPING','Gratis');
define('FIBER_CHECK_PO','P.O. No.');
define('FIBER_CHECK_CUSTOMER','Comentarios del cliente');
define('FIBER_CHECK_REMARK','Comentarios sobre el envío, paquete u otra información será útil para el procesamiento de pedidos.');

//checkout快递类型
define('FS_CHECKOUT_UPS_PLUS','UPS Express Plus Next Day 9:00');
define('FS_CHECKOUT_UPS','UPS Express Next Day 12:00');
//2017-9-12  ery   add 层级属性定制提示语
define('PROINFO_CUSTOM_WAVE','Anote otra longitud de onda según sus necesidades.');
define('PROINFO_CUSTOM_GRID','Anote otro canal de grid según sus necesidades.');
define('PROINFO_CUSTOM_RATIO','Anote otro ratio de acoplamiento según sus necesidades.');
//产品详情页stock list板块
define('FS_STOCK_LIST_OTHER_ID','ID');
define('FS_STOCK_LIST_CENTER','Longitud de onda central (nm)');
define('FS_STOCK_LIST_CHANNEL','Canal');
define('FS_STOCK_LIST_CWDM','CWDM SFP/SFP+');
define('FS_STOCK_LIST_DWDM','10G DWDM SFP+ 80km');
define('FS_DOWNLOAD','Descargas');
define('FS_DOWNLOADS', 'Descargas');
define('FS_STOCK_LIST','Lista de stock');
define('FS_STOCK_LIST_RECOM','Productos compatibles');
define('FS_STOCK_LIST_ADD_TO_CART','Añadir a la cesta');
define('FS_STOCK_LIST_PIC','Imágenes');
define('FS_STOCK_LIST_ID','ID#');
define('FS_STOCK_LIST_DESC','Descripción');
define('FS_STOCK_LIST_PRICE','Precio');
define('FS_STOCK_LIST_STOCK','Stock');
define('FS_STOCK_OPTION','Opción');

//2018.4.17  ternence solution留言板
define('MY_CASE_UPLOAD_1','Su solicitud de solución ');
define('MY_CASE_UPLOAD_2',' ha sido enviada.');
define('MY_CASE_UPLOAD_3','Hola ');
define('MY_CASE_UPLOAD_4','Gracias por ponerse en contacto con el soporte de soluciones de FS.COM, acabamos de recibir su solicitud y creamos el caso ');
define('MY_CASE_UPLOAD_5',' para su solicitud de solución.');
define('MY_CASE_UPLOAD_6','Estaremos en contacto dentro de 24 horas, por favor revise su correo electrónico.');
define('MY_CASE_UPLOAD_7','Mientras tanto, es posible que encuentre estos recursos útiles: ');
define('MY_CASE_UPLOAD_8','https://www.fs.com/es/Data-Center-Cabling.html');
define('MY_CASE_UPLOAD_9','https://www.fs.com/es/Enterprise-Networks.html');
define('MY_CASE_UPLOAD_10','https://www.fs.com/es/Long-haul-Transmission.html');
define('MY_CASE_UPLOAD_11','https://www.fs.com/es/Optic-OEM-Solution.html');
define('MY_CASE_UPLOAD_12','Cableado del centro de datos');
define('MY_CASE_UPLOAD_14','Transmisión de larga distancia');
define('MY_CASE_UPLOAD_13','Red Empresarial');
define('MY_CASE_UPLOAD_15','Solución Óptica OEM');
define('MY_CASE_UPLOAD_16','Sinceramente,');
define('MY_CASE_UPLOAD_17','https://www.fs.com/es');
define('MY_CASE_UPLOAD_18','FS.COM');
define('MY_CASE_UPLOAD_19',' Soporte de soluciones');
define('MY_CASE_UPLOAD_20','FS.COM - Solicitud de solución y número de caso: ');

//2017.10.12. add by frankie 自提
define("CHECKOUT_ONESELF_PICH","Recogerlo yo mismo");

//2017-10.12  dylan 产品详情页installation属性
define('FS_PRODUCT_INSTALLATION','Instalación:');
define('FS_PRODUCT_INSTALLATION_TEXT','Ajusta en el chasis FMU-1UFMX-N que se montará en un bastidor');
define('FS_PRODUCT_INSTALLATION_TEXT2','Ajusta en el chasis ');
define('FS_PRODUCT_INSTALLATION_TEXT3','FMT04-CH1U');
define('FS_PRODUCT_INSTALLATION_TEXT4',' que se montará en un bastidor');
define('FS_PRODUCT_INSTALLATION_TEXT5','El casete LGX cabe en el chasis <a href="'.zen_href_link('product_info','products_id=51608','SSL').'" style="color: #0070BC;">FLG-1UFMX-N</a> que se puede montar en un rack');
define('FS_PRODUCT_INFO_STEP','Paso');

//dylan 2019.7.26
define('FS_PRODUCT_INSTALLATION_TEXT_5','Compatible con los gabinetes para servidores y redes del modelo <a href="'.zen_href_link('product_info','products_id=73579','SSL').'" style="color: #0070BC;">GR800</a> y del <a href="'.zen_href_link('product_info','products_id=79273','SSL').'" style="color: #0070BC;">HR800</a>');
define('FS_PRODUCT_INSTALLATION_TEXT_6','Compatible con los gabinetes para servidores del modelo <a href="'.zen_href_link('product_info','products_id=73958','SSL').'" style="color: #0070BC;">GR600</a> y del <a href="'.zen_href_link('product_info','products_id=79272','SSL').'" style="color: #0070BC;">HR600</a>');
define('FS_PRODUCT_INSTALLATION_TEXT_7','Compatible con los gabinetes del modelo <a href="'.zen_href_link('product_info','products_id=73579','SSL').'" style="color: #0070BC;">GR800</a> y del <a href="'.zen_href_link('product_info','products_id=73958','SSL').'" style="color: #0070BC;">GR600</a>');
define('FS_PRODUCT_INSTALLATION_TEXT_8','Compatible con los gabinetes para servidores y redes del modelo <a href="'.zen_href_link('product_info','products_id=73579','SSL').'" style="color: #0070BC;">GR800</a>');
define('FS_PRODUCT_INSTALLATION_TEXT_9','El módulo FMX 100G es compatible con el chasis <a href="'.zen_href_link(FILENAME_PRODUCT_INFO,'products_id=96454','SSL').'" style="color: #0070BC;">FMX-100G-CH2U</a> que se puede montar en rack.');

//2019.1.10 详情页评论
define('FS_REVIEWS34',' Votos útiles');
define('FS_REVIEWS35',' Voto útil');
define('FS_REVIEW_REPORT','Reportar');
define('FS_REVIEWS31','Mostrar');
define('FS_REVIEWS32','comentario');
define('FS_BY','Por');
define('FS_REVIEWS36','comentarios');
define('FS_REVIEWS_STARS_TITLE','de un máximo de 5 estrellas');
define('FS_MOBILE_CLOSE','Cerrar');
define('FS_READ_MORE','Leer más');
define('FS_SEE_LESS','Leer menos');

//define('FS_PRODUCT_CUSTOMIZATION','Nota:');
//define('FS_PRODUCT_CUSTOMIZATION_TEXT','Potencia de entrada típica = Ganancia de potencia de salida');
define('FS_PRODUCT_CUSTOMIZATION_TEXT','Para FMU módulo plug-in ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT1','FMT-CH');
define('FS_PRODUCT_CUSTOMIZATION_TEXT2','El tipo de tarjeta enchufable encaja en ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT3','Para FUD módulo plug-in ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT4','FMU-1UFMX-N');
define('FS_PRODUCT_CUSTOMIZATION_TEXT5',' chasis que puede ser montado en un rack');
define('FS_PRODUCT_CUSTOMIZATION_TEXT6','FUD-1UFMX-N');
define('FS_PRODUCT_CUSTOMIZATION_TEXT7','Tipo Plug-in se ajusta a ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT8','FS-2U-RC001');
define('FS_PRODUCT_ITEM','Ítem ID: ');
//2017-11-2   add  ery  国家下拉框搜索提示语
define('FS_SEARCH_YOUR_COUNTRY','Selecciona tu país/región');
define('FS_COUNTRY_SEARCH','Ingresa país/región');

//2017.11.28 dylan 产品详情页图标描述
define('PRO_AUTHENTICATION_ICON_PLEASE','Por favor <a href="'.zen_href_link('contact_us').'" target="_blank">contáctanos</a> para más información.');
define('PRO_AUTHENTICATION_ICON_01','Este producto cumple con los requerimientos vigentes de la Directiva (EU) 2015/863 de RoHS, que restringe el uso de diez materiales peligrosos en la fabricación de varios tipos de equipos electrónicos y eléctricos: plomo, mercurio, cadmio, cromo hexavalente, bifenilos polibromados, éteres de difenilo polibromados y cuatro tipos de ftalatos diferentes. Por favor, ponte en contacto con nosotros para obtener más información. ');
define('PRO_AUTHENTICATION_ICON_02','Este producto proporciona la garantía de por vida, que tiene como objetivo reflejar nuestra mayor sinceridad. ');
define('PRO_AUTHENTICATION_ICON_03','Este producto está en conformidad con ISO 9001. Este sistema es válido para una empresa dedicada al desarrollo, producción y servicio de suministro de productos de fibra óptica. ');
define('PRO_AUTHENTICATION_ICON_04','Este producto fue producido bajo los requisitos de CE para indicar la conformidad con la salud y seguridad esenciales. ');
define('PRO_AUTHENTICATION_ICON_05','Este producto está totalmente de acuerdo con la FCC, que tiene como objetivo gestionar la onda de radio y los campos magnéticos de forma más razonable. ');
define('PRO_AUTHENTICATION_ICON_06','La FDA es responsable de regular los productos electrónicos emisores de radiación. Para proteger al público de la exposición peligrosa e innecesaria a la radiación de productos electrónicos. ');
define('PRO_AUTHENTICATION_LEARN','para conocer más.');
//new
define('PRO_AUTHENTICATION_ICON_07','Este producto cumple totalmente con los estándares de ETL, que indica el cumplimiento de las normas industriales de los productos eléctricos o mecánicos. ');
define('PRO_AUTHENTICATION_ICON_08','Este producto se produce bajo los requerimientos de UL, que es una consultoría de seguridad global y una certificación de productos. ');
define('PRO_AUTHENTICATION_ICON_09','CB es un sistema internacional operado por IECEE. Este producto se produce basando en las normas IEC para probar el rendimiento de seguridad de los productos eléctricos. ');
//
define('PRO_AUTHENTICATION_ICON_10','REACH es un reglamento de la Unión Europea, adoptado para mejorar la protección de la salud humana y el medio ambiente a través de la identificación temprana y mejor de las propiedades intrínsecas de las sustancias químicas. ');
define('PRO_AUTHENTICATION_ICON_11','Este producto está de conformidad con RCM, que indica el cumplimiento de le seguridad eléctrica, EMC, EME y los requisitos legislativos de telecomunicaciones. ');
define('PRO_AUTHENTICATION_ICON_12','Este producto cumple totalmente con los WEEE, que es una regulación ambiental de la Unión Europea y tiene como objetivo mejorar la recolección, el tratamiento y el reciclaje de productos. ');
define('PRO_AUTHENTICATION_ICON_13','Este producto cumple con la certificación 3C, creada por el gobierno chino para proteger la seguridad personal de los consumidores y la seguridad nacional, mejorar la gestión de la calidad del producto y implementar un sistema de evaluación de la conformidad del producto de acuerdo con las leyes y regulaciones. ');
define('PRO_AUTHENTICATION_ICON_14','El Consejo de Control Voluntario de Interferencias (VCCI, por sus siglas en inglés) es el organismo regulador de las emisiones electromagnéticas en Japón, especialmente para equipos de TI, control de lanzamiento electromagnético, que es la certificación EMC del producto. Este producto está totalmente de acuerdo con la certificación VCCI. ');
define('PRO_AUTHENTICATION_ICON_15','TELEC es una certificación obligatoria de productos inalámbricos en Japón, también llamada certificación MIC. Este producto cumple con la certificación TELEC requerida para productos inalámbricos (productos Bluetooth, teléfonos móviles, enrutadores WIFI, drones, etc.) exportados a Japón. ');
define('PRO_AUTHENTICATION_ICON_16', 'Este producto está de conformidad con la norma ISO14001. Se aplica por las organizaciones que buscan gestionar sus responsabilidades medioambientales de manera sistemática, contribuyendo a la sostenibilidad ambiental. ');
define('PRO_AUTHENTICATION_ICON_17', 'Este producto está totalmente de acuerdo con el certificado TR CU de Rusia (Certificado EAC), lo que significa que cumple con los estándares de los países miembros de la Unión Aduanera, así como los requisitos de calidad y de seguridad. ');
define('PRO_AUTHENTICATION_ICON_18', 'Este producto está totalmente de acuerdo con las normas establecidas por UL (Underwriters Laboratories Inc.). ');

//2017-12-5   ery
define('MY_ORDER_SUCCESSFULLY','Pedido enviado con éxito, esperando su pago.');
define('MY_ORDER_WAIT','Usted ha pagado con éxito, espere por favor para el envío.');
define('FIBERSTORE_SESTEM','Sistema de Fiberstore');

define("QTY_SHOW_ZERO","pza en");
define("QTY_SHOW_MORE","pzas en");

define('FS_SUCCESS_METHOD','Método de envío');
define('FS_SUCCESS_DELIVERY','Entrega esperada');
define('FS_SUCCESS_SHIP_FROM','Enviar desde');
define('FS_SUCCESS_ORDER_DINGDAN','Pedido #');
define('FS_SUCCESS_ORDER_QUESTION','Si tiene alguna pregunta, llámenos al +1 (877) 205 5306 o envíenos un correo electrónico');

//2018.9.6 Yoyo  add 产品详情  shipping&returns
define('FS_ASK_EXPERT','Pregunte al experto:');
define('FS_ASK_EXPERT_1','Consulte');
define('SOLUTION_SUB_PAGE_05','Consulta');


define("FS_WAREHOUSE_EU","almacén DE");
define("FS_WAREHOUSE_US","almacén EE.UU.");
define("FS_WAREHOUSE_CN","Almacén de China");
define("FS_IN_STOCK","En Stock");
define("QTY_SHOW_ZERO_STOCK","pieza");
define("QTY_SHOW_MORE_STOCK","pzs");
define("QTY_SHOW_ZERO_STOCK_1"," en stock");
define("QTY_SHOW_MORE_STOCK_2"," en stock");
define("QTY_SHOW_AVAILABLE","Disponible");
define("QTY_SHOW_ZERO3","pzs en");
//add by quest 2019-03-08
define("QTY_SHOW_AVAILABLE_NEW_INFO","en tránsito");
define("QTY_SHOW_AVAILABLE_TAG_NEW_INFO","necesita tránsito");
define('QTY_SHOW_IN_CN_STOCK_1','En stock');

//add by aron
define("EMAIL_CHECKOUT_WAREHOUSE_THANK","Gracias por comprar en");
define("EMAIL_CHECKOUT_WAREHOUSE_LIVE","Live Chat");
define("EMAIL_CHECKOUT_WAREHOUSE_WITH","con un experto");
define("EMAIL_CHECKOUT_WAREHOUSE_SIN","Sinceramente,");
define("EMAIL_CHECKOUT_WAREHOUSE_DEAR","Hola");
define("EMAIL_CHECKOUT_WAREHOUSE_TEAM","Equipo de Servicio al Cliente ");
define("EMAIL_CHECKOUT_WAREHOUSE_SHPPING","Dirección de Envío: ");
define("EMAIL_CHECKOUT_WAREHOUSE_TIT","Si tiene más preguntas con respecto a su pedido, siéntase libre de ");
define("EMAIL_CHECKOUT_WAREHOUSE_YOUR","Su PO#");
define("EMAIL_CHECKOUT_WAREHOUSE_UP","ha sido cargado exitosamente.");
define("EMAIL_CHECKOUT_WAREHOUSE_INVOICE","Gracias por los documentos de PO, ahora puede ver el PO e imprimir la factura a través de");
define("EMAIL_CHECKOUT_WAREHOUSE_ORDERS","Mis pedidos");
define("EMAIL_CHECKOUT_WAREHOUSE_NOW","ahora.");
define("EMAIL_CHECKOUT_WAREHOUSE_CHARGES","Costes de envío");
define("EMAIL_CHECKOUT_WAREHOUSE_TOTAL","Suma total");
define("EMAIL_CHECKOUT_WAREHOUSE_SUBTOTAL","Subtotal");
define("EMAIL_CHECKOUT_WAREHOUSE_PROCESS","Su pedido será procesado pronto, si tiene más preguntas con respecto a su pedido, no dude en");

//checkout_payment_success
define('EMAIL_CHECKOUT_SUCCESS_YOUR','Su pago del pedido se confirma aquí.');
define('EMAIL_CHECKOUT_SUCCESS_WE','Hemos recibido su pago de los pedidios ');
define('EMAIL_CHECKOUT_SUCCESS_THANK',', gracias por su gran apoyo.');



define('FIBER_CHECK_TWO', 'UPS 2nd Day Air® servicio');
define('FIBER_CHECK_TWO_AM','UPS 2nd Day A.M.® servicio');
define('FIBER_CHECK_STAND','UPS Ground® servicio');
define('FIBER_CHECK_ONE', 'UPS Next Day-Early®');

define('FIBER_FEDEX_CHECK_OVER','FedEX Overnight® servicio');
define('FIBER_FEDEX_CHECK_TWO','FedEX 2Day® servicio');
define('FIBER_FEDEX_CHECK_GROUND','FedEX Ground® servicio');
define('FIBER_CHECK_USE','Usar mi propia cuenta de envío');




define("FS_WAREHOUSE_AREA_32","¡Gracias por tu pedido! Aquí están los detalles de su pedido. Está esperando la confirmación del pedido ahora.");


define('EMAIL_CHECKOUT_PAYPAL_TEXT1','Pedido recibido, en espera de confirmación de pago');
define('EMAIL_CHECKOUT_PAYPAL_TEXT2','¡Gracias por comprar en ');
define('EMAIL_CHECKOUT_PAYPAL_TEXT3','FS.COM');
define('EMAIL_CHECKOUT_PAYPAL_TEXT4','! A continuación se muestra un resumen de su última orden abierta. Solo un último paso para finalizar el pago.');
define('EMAIL_CHECKOUT_PAYPAL_TEXT4_1','! A continuación se muestra un resumen de su última orden abierta. Solo un último paso para finalizar el pago.');
define('EMAIL_CHECKOUT_PAYPAL_TEXT5','Entrega esperada');
define('EMAIL_CHECKOUT_PAYPAL_TEXT6','Si tiene más preguntas con respecto a su pedido, no dude en ');
define('EMAIL_CHECKOUT_PAYPAL_TEXT7','<a href="'.zen_href_link('contact_us').'">contactarnos</a>');
define('EMAIL_CHECKOUT_PAYPAL_TEXT8',' Equipo de atención al cliente ');

define('EMAIL_CHECKOUT_COMMON_SUCCESS_TITLE','FS.COM - Pedido %s recibido, por favor, complete el pago');
define('EMAIL_CHECKOUT_COMMON_SUCCESS_TITLE_PO','FS.COM - Pedido %s recibido, a la espera de la confirmación del pedido de compra (PO)');
define('EMAIL_CHECKOUT_PAYMENT_SUCCESS_TITLE','FS.COM - Pago del pedido %s recibido');
define('EMAIL_CHECKOUT_PO','cargado con éxito');
define("FS_MANAGE_ORDERS_FILE","Por favor sube el archivo PO.");

define("FS_WAREHOUSE_AREA_SG","Enviar desde el almacén en SG");
define("FS_WAREHOUSE_AREA_PR",'enviado desde FS EE.UU.');
//分仓分库语言包
define("FS_WAREHOUSE_AREA_1","Enviar desde el almacén en CN");
define("FS_WAREHOUSE_AREA_2","Enviar desde el almacén en EE.UU.");
define("FS_WAREHOUSE_AREA_3","Se enviará desde el almacén en DE.");
define("FS_WAREHOUSE_AREA_4","- Disponible para envío inmediato.");
define("FS_WAREHOUSE_AREA_5","- Tiempo estimado de envío sería el ");
define("FS_WAREHOUSE_AREA_6","Los artículos serán entregados en ");
define("FS_WAREHOUSE_AREA_7","paquetes separados. ");
define("FS_WAREHOUSE_AREA_8","Artículo");
define("FS_WAREHOUSE_AREA_9","Precio del artículo");
define("FS_WAREHOUSE_AREA_10","Cantidad");
define("FS_WAREHOUSE_AREA_11","Precio");
define("FS_WAREHOUSE_AREA_12","Por favor vaya a '");
define("FS_WAREHOUSE_AREA_13","Mis pedidos");
define("FS_WAREHOUSE_AREA_14","' página para cargar el archivo PO si aún no lo ha hecho. No podemos procesar su pedido hasta que su pedido haya sido confirmado.");
define("FS_WAREHOUSE_AREA_15","¡Gracias por comprar en ");
define("FS_WAREHOUSE_AREA_16","! A continuación se muestra un resumen de su último pedido abierto. Solo un último paso para finalizar el pago, todo será suyo.");
define("FS_WAREHOUSE_AREA_17","¡Gracias por pedir en FiberStore! Hemos recibido su pedido y estamos a la espera del procesamiento. ");
define("FS_WAREHOUSE_AREA_18","Gracias por comprar en FiberStore. Su pedido #");
define("FS_WAREHOUSE_AREA_19"," colocado en ");
define("FS_WAREHOUSE_AREA_20"," ha sido recibido. Sin embargo, aún no ha sido pagado. Si aún necesita los artículos, puede enviar el pago a la cuenta de paypal de nuestra compañía directamente: paypal@fs.com.");
define("FS_WAREHOUSE_AREA_21","Si hay algún problema o pregunta con el pago de PayPal, no dude en contactarnos en ");
define("FS_WAREHOUSE_AREA_22","Aún no establecido");
define("FS_WAREHOUSE_AREA_23","Pedido recibido, en espera de procesamiento");
define("FS_WAREHOUSE_AREA_24","ha sido recibido. Sin embargo, aún no se ha pagado.");
define("FS_WAREHOUSE_AREA_25","Si hay algún problema o pregunta con el pago con tarjeta de crédito/débito, no dude en contactarnos en");
define("FS_WAREHOUSE_AREA_26","Pedido recibido, pendiente");
define("FS_WAREHOUSE_AREA_27","Si hay algún problema o pregunta con el");
define("FS_WAREHOUSE_AREA_28","por favor no dude en contactarnos en");
define("FS_WAREHOUSE_AREA_29","N º de pedido:");
define("FS_WAREHOUSE_AREA_30","Se envía por:");
define("FS_WAREHOUSE_AREA_31","ordenar en fibertore ...");

/*结算页交期气泡提示语*/
define("FS_WAREHOUSE_AREA_TIME_36","Se retrasó el envío debido al festival en los EE.UU.");
define("FS_WAREHOUSE_AREA_TIME_37","Se retrasó el envío debido al festival en Australia.");
define("FS_WAREHOUSE_AREA_TIME_38","Se retrasó el envío debido al festival en Alemania.");
define("FS_WAREHOUSE_AREA_TIME_39","Se retrasó el envío debido al festival en Singapur.");
define("FS_WAREHOUSE_AREA_TIME_42","Se retrasó el envío debido al festival en China.");
define("FS_WAREHOUSE_AREA_TIME_40","Se retrasó el envío debido a los fines de semana.");
define("FS_WAREHOUSE_AREA_TIME_41",'<div class="track_orders_wenhao shipping_notice m_track_orders_wenhao m-track-alert" style=""><i class="iconfont icon">&#xf071;</i><p></p><div class="new_m_bg1"></div><div class="new_m_bg_wap"><div class="question_text_01 leftjt"><div class="arrow"></div><div class="popover-content">$TIME_TIPS</div><div class="new__mdiv_block"><span class="new_m_icon_Close">Cerrar</span></div></div></div></div>');
define("FS_WAREHOUSE_AREA_TIME_43","Recoge tu pedido en nuestro almacén en EE.UU. a la hora que te convenga");
define("FS_WAREHOUSE_AREA_TIME_44","Recoge tu pedido en nuestro almacén en DE a la hora que te convenga");
define("FS_WAREHOUSE_AREA_TIME_45","Recoge tu pedido en nuestro almacén en AU a la hora que te convenga");
define("FS_WAREHOUSE_AREA_TIME_46","Recoge tu pedido en nuestro almacén en Asia a la hora que te convenga");
define("FS_WAREHOUSE_AREA_TIME_47","Recoge tu pedido en nuestro almacén en SG a la hora que te convenga");
define("FS_WAREHOUSE_AREA_SHIP_CN"," desde el almacén en Asia");
define("FS_WAREHOUSE_AREA_SHIP_US"," desde el almacén en EE.UU.");
define("FS_WAREHOUSE_AREA_SHIP_AU"," desde el almacén en AU");
define("FS_WAREHOUSE_AREA_SHIP_DE"," desde el almacén en DE");
define("FS_WAREHOUSE_AREA_SHIP_SG"," desde el almacén en SG");
define("FS_PICK_UP_WAREHOUSE", "Recoger en el almacén");

//2017-12-2  add   ery  产品无库存是的提示语
define('FS_PRODUCTS_CUSTOMIZED','Disponible');
define('FS_COMMON_LEVEL_WAS','Fue');
//2017-12-13  add  ery 公用的tt账号语言包
define('FS_COMMON_TT_BANK','<table cellspacing="0" cellpadding="5" border="0" class="m_yh_information">
						  <tr>
							<td>Nombre del banco beneficiario: </td>
							<td><b>HSBC Hong Kong</b></td>
						  </tr>
						  <tr>
							<td>Nombre de cuenta del beneficiario: </td>
							<td><b>FS.COM LIMITED</b></td>
						  </tr>
						  <tr>
							<td>Número de cuenta del beneficiario: </td>
							<td><b>817-888472-838</b></td>
						  </tr>
						  <tr>
							<td>Código de SWIFT: </td>
							<td><b>HSBCHKHHHKH</b></td>
						  </tr>
						  <tr>
							<td>Dirección del banco beneficiario: </td>
							<td><b>1 Queen\'s Road Central, Hong Kong</b></td>
						  </tr>
					  </table>');
//2017-12-14  ery  add  manage_orders和account_history_info页面reorder提示语
define('FS_COMMON_REORDER_CLOSE','Lo sentimos, es posible que los siguientes artículos se hayan eliminado y ya no estén disponibles.');
define('FS_COMMON_REORDER_CUSTOM','A continuación se muestra el producto(s) personalizado(s), por favor vuelva a elegir los caracteres en la introducción del producto.');
define('FS_COMMON_REORDER_SKIP','Saltar y continuar');

define("FS_POPUP_TIT_ALERT","Se requiere una firma para la entrega.No se realizan envíos a apartados postales.");
define("FS_POPUP_TIT_ALERT_NOT_PO","Se requiere una firma para la entrega.");
define("FS_POPUP_TIT_ALERT2","No se realizan envíos a apartados postales");
//2017-12-15  ery  add  前台相关打印发票页面的公司地址
// 武汉仓
define('FS_COMMON_WAREHOUSE_CN','A/A: FS. COM LIMITED<br> 
			Dirección: A115 Jinhetian Business Centre No.329,<br> 
			Longhuan Third Rd<br> 
			Longhua District<br> 
			Shenzhen, 518109, China<br>
			Teléfono: +86-0755-83571351');
define('FS_COMMON_WAREHOUSE_CN_NEW','FS.COM LIMITED<br> 
			Unit 1, Warehouse No. 7 <br> 
			South China International Logistics Center <br> 
			Longhua District <br>
			Shenzhen, 518109 <br> China');
// 德国仓
define('FS_COMMON_WAREHOUSE_EU','FS.COM GmbH<br> 
			NOVA Gewerbepark, Building 7,<br>
			Am Gfild 7<br>
			85375, Neufahrn bei Munich<br>
			Germany<br>
			Tel: +49 (0) 8165 80 90 517');
define('FS_COMMON_WAREHOUSE_US','FS.COM INC <br>
			380 CENTERPOINT BLVD<br>
			NEW CASTLE, DE 19720<br>
			United States <br>
			Tel: +1 (888) 468 7419');
// 美东仓
define('FS_COMMON_WAREHOUSE_US_EAST','A/A: FS.COM Inc.<br>
					Dirección: 380 Centerpoint Blvd,<br>
					New Castle, DE 19720,<br>
					United States<br>
					Teléfono: +1 (888) 468 7419');
// 澳洲仓
define('FS_COMMON_WAREHOUSE_AU','FS.COM PTY LTD<br>
				57-59 Edison Road<br>
				Dandenong South<br>
				VIC 3175<br>
				Australia<br>
				Tel: +61 3 9693 3488<br>
				ABN: 71 620 545 502');
define('FS_COMMON_WAREHOUSE_SG','FS TECH PTE. LTD<br>
				30A Kallang Place #11-10/11/12<br>
				Singapore 339213<br>
				Singapore<br>
				Tel: (65) 6443 7951<br>
				GST Reg No.: 201818919D');
// 新加坡仓
define('FS_COMMON_WAREHOUSE_DELIVER_TO_SG','A/A: FS Tech Pte Ltd.<br>
				Dirección: 30A Kallang Place #11-10/11/12<br>
				Singapore 339213<br>
				Singapore<br>
				Teléfono: +(65) 6443 7951');
define("QTY_SHOW_ZERO_STOCK","pieza");
define("QTY_SHOW_MORE_STOCK","piezas");

define("CHECKOUT_EIDT_TIT_FS","* por favor edite y actualice su dirección");
define("CHECKOUT_EIDT_TIT_FS1","Edite su dirección de envío");
define("CHECKOUT_EIDT_TIT_FS2","Edite su dirección de facturación");
define("CHECKOUT_EIDT_TIT_FS3","* Edite y actualice su dirección de facturación");
define("FS_ITEMS_CK","Su(s) artículo(s)");
define('FS_SUCCESS_PURCHASE','Su pedido se ha dividido en');
define('FS_SUCCESS_ORDER_01','pedidos');
define('FIBERSTORE_FS_COM','Sistema de FS.COM');
//付款成功页面公共
/**************************html_checkout_payment_against_paypal.php**************************/
define('FS_AGAINST_PROCEED','Continúe a Paypal');
/************************** add by Aron html_checkout_gloabal**************************/
define("GLOBAL_FIRSTNAME","Nombre");
define("GLOBAL_LASTNAME","Apellido");
define("GLOBAL_ADDRESS1","Línea 1 de dirección");
define("GLOBAL_ADDRESS2","Línea 2 de dirección (opcional)");
define("GLOBAL_POSTAL","Código postal");
define("GLOBAL_CITY","Ciudad");
define("GLOBAL_COUNTRY","País/Región");
define("GLOBAL_PHONE","Número de teléfono");
define("GLOBAL_STATE","Estado / Provincia / Región");
define("GLOABL_VAT","Número de IVA de la UE");
define("GLOABL_COMPANY","Nombre de la compañía");
define("GLOABL_ADRESSTYPE","Tipo de dirección");
define("GLOABL_CART","Carrito");
define("GLOABL_EDIT_BILLING","Edite su dirección de facturación");
define("GLOABL_CHECK_FOLLOWING","Por favor, compruebe lo siguiente ...");
define("GLOABL_CHECKETOUT","Comprar");
define("GLOABL_SUCCESS","Con éxito");
define("GLOABL_LIVECHAT","Chat en vivo");
define("GLOBAL_TEXT1","Comuníquese con su representante de ventas si tiene alguna pregunta sobre el estado de pago. ");
define("GLOBAL_TEXT2","El pago fue rechazado. Utilice otra tarjeta de crédito o cambie el método de pago en PayPal o transferencia bancaria en su pedido pendiente.");
define("GLOBAL_TEXT3","Asegúrese de que la dirección de facturación que ingrese a continuación coincida con el nombre y la dirección asociados con la tarjeta de crédito que está utilizando para esta compra. Tenga en cuenta que su dirección de facturación y país de la dirección de envío deben ser iguales. ");

define("GLOBAL_TEXT4","Centro de pago con tarjeta de crédito/débito");
define("GLOBAL_TEXT5","Aceptamos las siguientes tarjetas de crédito/débito. Seleccione un tipo de tarjeta, complete la información
         a continuación, y haga clic en Continuar. (Nota: Por motivos de seguridad, no guardaremos ninguno de los datos de su tarjeta de crédito.)");

define("GLOBAL_TEXT6","Seleccione tarjeta de crédito/débito:");

define("GLOBAL_TEXT7","Subtotal del pedido");
define("GLOBAL_TEXT8","Número de pedido:");
define("GLOBAL_TEXT9","¿Necesita ayuda? ");
define("GLOBAL_TEXT10"," Consulte nuestras páginas de Ayuda o  ");
define("GLOBAL_TEXT11"," Dirección de facturación  ");
define("GLOBAL_TEXT12","Editar");
define("GLOBAL_TEXT13","Número de tarjeta");
define("GLOBAL_TEXT14","Fecha de caducidad");
define("GLOBAL_TEXT15","Mes");
define("GLOBAL_TEXT16","Año");
define("GLOBAL_TEXT17","Código de Seguridad");
define("ADDRESS_TYPE1","Tipo de negocio");
define("ADDRESS_TYPE2","Tipo individual");
define("CHECKOUT_PLEASE1","por favor seleccione");
define("GLOABL_VAT_PLEASE2","TAX/VAT válido por ejemplo: DE123456789");
define("ADDRESS_TYPE_TIT1","El tipo de dirección no puede estar vacío");
define("ADDRESS_TYPE_TIT2","El nombre de la compañía no puede estar vacío");
define('FS_SUCCESS_ORDER_DINGDAN','Pedido #');
define("FS_QUESTION","Si tiene alguna pregunta, por favor llámenos");
define("FS_EMAIL_US","o envienos un correo");
define("FS_NOT_NULL","El número de pedido de compra no puede estar vacío");
define("FS_SYSTEM_ERROR_TIT","Comuníquese con su representante de ventas si tiene alguna pregunta sobre el estado de pago.");
define('EMAIL_CHECKOUT_SUCCESS_YOUR',' Su pago del pedido confirmado.');
define('EMAIL_CHECKOUT_SUCCESS_WE','Hemos recibido su pago para el pedido ');
define('EMAIL_CHECKOUT_SUCCESS_THANK',' ¡Gracias por su gran apoyo!');
//add by frankie  询价按钮
define('GET_A_QUOTE','Obtener cotización');


//2018 1-9.aRON 游客邮件
define("FS_GUEST_EMAIL_THANK","Como un visitante");
define("FS_GUEST_EMAIL_CONTACT","Le informaremos sobre el estado del pedido con esta dirección de correo electrónico. Si tiene más preguntas con respecto a su pedido, siéntase libre de ");

define("CHECKOUT_TAXE_US_TIT","Sobre Impuesto a Ventas & de Aduanas");
define("CHECKOUT_TAXE_US_FRONT","Si los artículos se envían desde nuestro almacén de EE.UU. a una dirección dentro del estado de Washington, se cobrará un impuesto a las ventas del 10% de acuerdo con las leyes fiscales del estado de Washington. Sin embargo, si puede proporcionar un certificado de exención de impuesto válido para los estados en que se encuentra, no se cobrará ningún impuesto a las ventas. Los artículos enviados a Canadá y México están libres de impuestos a las ventas, pero el comprador será responsable del despacho de aduana y del impuesto de aduana. Al realizar el pedido en línea, solo le cobraremos el costo de envío y excluiremos cualquier costo del pedido total (FS.COM predeterminado). Si es necesario, FS.COM puede ayudar a organizar el pago anticipado del IMPUESTO de ADUANA.");
define("CHECKOUT_TAXE_US_BACK","Para el envío desde el almacén de China, FS.COM solo cobrará los artículos y el coste de envío al realizar un pedido. Sin embargo, estos paquetes pueden tener tarifas de importación o de aduana, según las leyes de los países en particular. Todos los derechos de aduana o importación se cobran una vez que el paquete llega al país de destino. Los cargos adicionales por el despacho de aduana tendrían que ser asumidos por el destinatario; no tenemos control sobre estos cargos y no podemos predecir cuáles podrían ser. Dado que las políticas de aduanas varían mucho de un país a otro, puede ponerse en contacto con su oficina de aduanas local para obtener más información. Si es necesario, FS.COM puede ayudar a organizar el prepago del impuesto.");

define("CHECKOUT_TAXE_CN_TIT","Sobre Aranceles e Impuestos");
define("CHECKOUT_TAXE_CN_TIT1","Sobre impuestos y aranceles");
define("CHECKOUT_TAXE_CN_FRONT","Para el envío desde el almacén de China, FS.COM solo cobrará los artículos y el coste de envío al realizar un pedido. Sin embargo, estos paquetes pueden tener tarifas de importación o de aduana, según las leyes de los países en particular. Todos los derechos de aduana o importación se cobran una vez que el paquete llega al país de destino. <b>Los cargos adicionales por el despacho de aduana tendrían que ser asumidos por el destinatario;</b> no tenemos control sobre estos cargos y no podemos predecir cuáles podrían ser. Dado que las políticas de aduanas varían mucho de un país a otro, puede ponerse en contacto con su oficina de aduanas local para obtener más información. Si es necesario, FS.COM puede ayudar a organizar el prepago del impuesto.");

define("CHECKOUT_TAXE_DE_TIT","Sobre IVA e impuestos aduaneros");
define("CHECKOUT_TAXE_DE_FRONT","Todos los artículos se enviarán desde nuestro almacén en Alemania. De conformidad con las leyes que rigen a los miembros de la Unión Europea, FS.COM GmbH está obligado a cobrar el IVA en todos los pedidos entregados a los destinos de los países miembros de la UE.");
define("CHECKOUT_TAXE_DE_BACK","<div class=\"help-center-table\"><div class=\"help-center-taHead help-center-taTr\"><div>País destinatario</div><div>IVA e impuestos aduaneros</div></div><div class=\"help-center-taTr\"><div>Alemania</div><div>Cobraremos el 19% de IVA.</div></div><div class=\"help-center-taTr\"><div>Francia y Mónaco</div><div>Cobraremos el 20% de IVA, pero si el cliente nos ofrece un número de identificación de IVA intracomunitario válido, el IVA no se cobrará.</div></div><div class=\"help-center-taTr\"><div>Holanda, España, Bélgica</div><div>Cobraremos el 21% de IVA, pero si el cliente nos ofrece un número de identificación de IVA intracomunitario válido, el IVA no se cobrará.</div></div><div class=\"help-center-taTr\"><div>Italia</div><div>Cobraremos el 22% de IVA, pero si el cliente nos ofrece un número de identificación de IVA intracomunitario válido, el IVA no se cobrará.
</div></div><div class=\"help-center-taTr\"><div>Suecia</div><div>Cobraremos el 25% de IVA, pero si el cliente nos ofrece un número de identificación de IVA intracomunitario válido, el IVA no se cobrará.</div></div><div class=\"help-center-taTr\"><div>Otros países de la UE</div><div>Cobraremos el 19% de IVA, pero si el cliente nos ofrece un número de identificación de IVA intracomunitario válido, el IVA no se cobrará.</div></div><div class=\"help-center-taTr\"><div>Países fuera de la UE</div><div>No se aplicará el IVA, pero el cliente tendría que pagar los cargos adicionales por el despacho de aduana. </div></div></div>");
define("CHECKOUT_TAXE_NEW_CN_CONTENT","Los productos en stock en nuestro almacén de Estados Unidos se enviarán directamente desde Delaware a cualquier destino en el país. FS.COM SOLAMENTE cobrará el valor del producto y las tarifas de envío. No se cobrará ningún impuesto a las ventas.<br/><br/>Si los pedidos contienen artículos que están temporalmente agotados en el almacén de EE. UU., Se los enviaremos directamente desde nuestro Almacén de Asia para acelerar el envío. Si el producto tiene el mensaje \"Envío gratuito\" en la página del producto, FS.COM asumirá todos los derechos y aranceles posibles causados ​​por el despacho de importación. <br/><br/>Para los productos que NO tienen el mensaje \"Envío gratuito\" en la página del producto, son artículos pesados ​​o de gran tamaño. Se enviarán directamente desde el almacén de Asia y no podrán recibir el servicio de envío gratuito. Y cualquier posible cargo causado por el despacho de aduana debe ser asumido por usted mismo.");
define("CHECKOUT_TAXE_NEW_CA_CONTENT","Los productos en stock en nuestro almacén de Estados Unidos se enviarán directamente desde Delaware a cualquier destino en Canadá.<br/><br/>Si los pedidos contienen artículos que están temporalmente agotados en el almacén de EE. UU., Se los enviaremos directamente desde nuestro Almacén de Asia para acelerar el envío. <br/><br/>Cuando realice el pedido en línea, FS.COM SOLAMENTE cobrará el valor del producto y las tarifas de envío. Todos los posibles derechos y aranceles causados ​​por el despacho de aduana deben ser asumidos por usted mismo.");
define("CHECKOUT_TAXE_NEW_MX_CONTENT","Los productos en stock en nuestro almacén de Estados Unidos se enviarán directamente desde Delaware a cualquier destino en México.<br/><br/>Si los pedidos contienen artículos que están temporalmente agotados en el almacén de EE. UU., Se los enviaremos directamente desde nuestro Almacén de Asia para acelerar el envío.  <br/><br/>Cuando realices el pedido en línea, FS.COM SOLAMENTE cobrará el valor del producto y las tarifas de envío. Todos los posibles derechos y aranceles causados ​​por el despacho de aduana deben ser asumidos por el destinatario.");


//游客页面注册
define("REGITS_FROM_GUEST_EMAIL_ERROR1","Se requiere Dirección de correo electrónico.");
define("REGITS_FROM_GUEST_EMAIL_ERROR2","Escribe una dirección válida. <br>(ej: someone@gmail.com)");
define("REGITS_FROM_GUEST_PASSWORD_ERROR1","6 caracteres como mínimo; al menos una letra y un número");
define("REGITS_FROM_GUEST_PASSWORD_ERROR2","Las contraseñas no coinciden.");
define("REGITS_FROM_GUEST_ASK","¿Le gustaría crear una cuenta ahora?");
define("REGITS_FROM_GUEST_CAN","Solo un paso más para obtener un mejor servicio. Con una cuenta de FS, puede:");
define("REGITS_FROM_GUEST_EASY","Seguir su pedido fácil a través de su historial de pedidos");
define("REGITS_FROM_GUEST_FASTER","Realizar el pago más rápido con una libreta de direcciones");
define("REGITS_FROM_GUEST_NO","No, gracias.");
define("REGITS_FROM_GUEST_YES","Sí, Me gustaría crear una cuenta.");
define("REGITS_FROM_GUEST_USE","Utilizar mi correo electrónico de pago");
define("REGITS_FROM_GUEST_OR","o");
define("REGITS_FROM_GUEST_HISTORY","Si el pago y las direcciones de correo electrónico registradas son diferentes, se asociarán automáticamente para brindarle un mejor servicio. Los correos electrónicos de confirmación de pedido se enviarán a la dirección de correo electrónico registrada, y con esta dirección de correo electrónico registrada, puede iniciar sesión en su cuenta FS.COM para administrar y rastrear pedidos en cualquier momento.");
define("REGITS_FROM_GUEST_PASWORD","Contraseña");
define("REGITS_FROM_GUEST_CPASWORD","Confirmar contraseña");
define("REGITS_FROM_GUEST_NOTE",'Nota: Su número de teléfono solo se usa para contactarlo en el momento de la entrega, así como su dirección de correo electrónico para actualizar el estado del pedido.<br>Puedes visitar <a href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">Política de privacidad y cookies</a> para más información.');
define("REGITS_FROM_GUEST_EXSIT1","La dirección de correo electrónico existe en nuestro sistema, por favor inicie sesión directamente. &nbsp;&nbsp;&nbsp;&nbsp;");
define("REGITS_FROM_GUEST_EXSIT2","Entrar en »");
define("REGIST_NUM_LENGTH","Mínimo de 6 caracteres");
define("REGIST_NUM_LEAST","6 Debe tener por lo menos 6 caracteres. Al menos una letra y un número.");

//2017-1-24   add    ery   产品详情页属性未勾选加入购物车提示语
define('FS_PRODUCT_INFO_ATTR_PLEASE','Por favor selecciona una opción para cada atributo.');
//产品详情页长度定制框语言包
define('FS_LENGTH_CUSTOM_FEET','Feet Or');
define('FS_LENGTH_CUSTOM_METER','Meter');
define('FS_PRODUCTS_AOC_LENGTH_ERROR','La longitud personalizada de este cable puede ser entre 0,5m y 100m (1,64ft y 328,084ft).');
define('FIBER_CHECK_EXCLUDE1','Sin impuestos');
define('FIBER_CHECK_DIS1','RENUNCIA para pedidos internacionales');
define('FIBER_CHECK_IMPORT1','Tasas de importación, impuestos, y gastos de comisión no están incluidos en el precio del producto ni en los gastos de envío y manipulación y se recogerá a la entrega de los transportistas para ciertos paquetes. Como la oficina de aduanas aplica los aranceles aduaneros al azar en los paquetes que llegan, no podemos predecirlo a nuestro fin.');

define("FS_IS_SPRING",0);
define("CN_SPRING_WAREHOUSE_MESSAGE","Los artículos del almacén CN no se enviarán hasta que termine la Fiesta de Primavera (Feb.10, 2018 - Feb.20, 2018)");
define("FS_EMPTY_COST","Lamentamos que las mensajerías UPS y DHL no ofrezcan servicios de envío a su destinatario en este momento; utilice su propia cuenta de envío para pagar el costo de envío. También podemos ayudarle a consultar el costo de envío en tiempo real de otras terceras agencias, si tiene interés, por favor <a href='https://www.fs.com/es/contact_us.html'>contáctenos</a>.");
define("CN_SPRING_WAREHOUSE_MESSAGE1","Nota: El pedido ");
define("CN_SPRING_WAREHOUSE_MESSAGE2","enviado desde el almacén CN no se enviará hasta que termine el Festival de Primavera Chino (los días 6~20 de febrero de 2018).");

define("FS_QTY_CHANGED","Realice su pago lo antes posible para que su pedido pueda ser manejado enseguida. De lo contrario, su pedido podría retrasarse en la entrega debido al cambio de almacenamiento.");

//helun 客户提出问提成功
define('FS_MODIFY_EMAIL_MY_CASE_01','Su caso');
define('FS_MODIFY_EMAIL_MY_CASE_02','ha confirmado aquí.');
define('FS_MODIFY_EMAIL_MY_CASE_03','Gracias por ponerse en contacto con <a href="'.HTTPS_SERVER.'/" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a>, este es un correo electrónico de confirmación para informarle que su solicitud de asistencia se ha recibido en el caso');
define('FS_MODIFY_EMAIL_MY_CASE_04','Nuestro <a href="'.HTTPS_SERVER.'/" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> equipo de ventas revisará su caso y le responderá dentro de las 12 horas.');
define('FS_MODIFY_EMAIL_MY_CASE_05','Si necesita atenciones inmediatas, llámenos al <a href="tel:+1 (888) 468 7419" style="color:#232323; text-decoration:none;">+1 (888) 468 7419</a> (EE.UU.), o <a href="tel:+49 (0) 89 414176412" style="color:#232323; text-decoration:none;">+49 (0) 89 414176412</a> (Alemania). También podría chatear en línea para obtener una respuesta rápida.');
define('FS_MODIFY_EMAIL_MY_CASE_06','Sinceramente,');
define('FS_MODIFY_EMAIL_MY_CASE_07','<a href="'.HTTPS_SERVER.'/" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> Equipo de Servicio al Cliente ');
define('FS_MODIFY_EMAIL_MY_CASE_08','Hola');
define('FS_MODIFY_EMAIL_MY_CASE_09','FS.COM - Número de caso: ');
define('FS_WRITE_OTHER_DEVICES','ej: Cisco N9K-C9396PX');
define('HPE_LIMIT', 'Por favor, elige la compatibilidad "VAL_XXX" para tu pedido debido a su material especial, y luego escribe el número del modelo.');
define('HPE_LIMIT2', 'La compatibilidad de "VAL_XXX" no está disponible debido a su material especial.');
define('model_number_empty','Por favor ingrese el nombre de modelo de su dispositivo.');

//客户追问成功
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_01','Nueva respuesta de');
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_02','para caso');
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_03','Hola a todos,');
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_04','Cliente');
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_05','ha respondido el caso de la siguiente manera:');
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_06','-Representante de ventas:');
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_07','-Ingeniero:');
define('FS_CHECKOUT_MONDAY_TO_FRIDAY', ' | lun.-vier.');
define("FS_JS_TIT_CHECK1","</br>Tiempo de recogida: ");
define("FS_JS_TIT_CHECK2","Hora del Pacífico：");
define("FS_JS_TIT_CHECK3","Lunes-Viernes");
define("FS_JS_TIT_CHECK4","10:00am - 12:00am ");
define("FS_JS_TIT_CHECK5",", 2:00pm - 5:30am ");
define("FS_JS_TIT_CHECK_US","9:30am - 5:30pm");
define("FS_JS_TIT_CHECK6","Nombre en la id con foto");
define("FS_JS_TIT_CHECK7","Correo electrónico");
define("FS_JS_TIT_CHECK8","Número de teléfono");
define("FS_JS_TIT_CHECK9","Hora de recogida");
define("FS_TIME_ZONE_RULE_AU","(AEST)");
define("FS_JS_TIT_CHECK_AU","9:30am - 5pm ");
define("PICK_UP_ALERT1",'Se requiere el nombre en la id con foto.');
define("PICK_UP_ALERT2",'Se requiere el número de teléfono.');
define("PICK_UP_ALERT4",'Ingrese la hora de recogida.');
define("REGITS_FROM_GUEST_EMAIL_ERROR3","Favor de ingresar el correo electrónico válido.");

//request_stock
define("FS_EMAIL_REQUEST_STOCK_01","FS.COM - Solicitar inventario & Número de caso: ");
define("FS_EMAIL_REQUEST_STOCK_02","Solicita de más inventario de artículo #");
define('FS_EMAIL_REQUEST_STOCK_11',' ha sido recibido.<br />
									No. de caso :');
define("FS_EMAIL_REQUEST_STOCK_03","Hola ");
define("FS_EMAIL_REQUEST_STOCK_04","Gracias por solicitar inventario. Su demanda de inventario es muy importante para nosotros. Su representante de ventas se pondrá en contacto con usted para seguir sus demandas con detalles. mientras tanto, ");
define("FS_EMAIL_REQUEST_STOCK_05"," el equipo de administración de inventarios se referirá a sus necesidades de stock y optimizará nuestro plan de inventario. ");
define('FS_EMAIL_REQUEST_STOCK_06','Si necesita atenciones inmediatas, llámenos al <a href="tel:+1 (888) 468 7419" style="color:#232323; text-decoration:none;">+1 (877) 205 5306</a> (EE.UU.), o <a href="tel:+49 (0) 89 414176412" style="color:#232323; text-decoration:none;">+49 (0) 89 414176412</a> (Europa). También puede chatear en línea para obtener una respuesta rápida.');
define('FS_EMAIL_REQUEST_STOCK_07','Sinceramente,');
define('FS_EMAIL_REQUEST_STOCK_08','<a href="'.zen_href_link('index').'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> Equipo de Servicio al Cliente');
define('FS_EMAIL_REQUEST_STOCK_09','Estimado/a');
define('FS_EMAIL_REQUEST_STOCK_10','FS.COM - Número de caso: ');


//2017-12-29   ery  add  sales_service_details退换货流程
define('SALES_DETAILS_PRINT_LABEL','Imprimir etiqueta de envío prepagada');
define('SALES_DETAILS_LABEL_MSG','FS.COM le permite imprimir etiquetas de envío prepagas para envíos desde la comodidad de cualquier computadora con acceso a Internet. 
Incluya la etiqueta en el paquete original y déjela en un buzón de UPS cerca de usted.');
define('SALES_DETAILS_PSL','Imprimir etiqueta de envío');
define('FS_SALES_DETAILS_COMMENT','Comentarios (requeridos)');
define('FS_SALES_DETAILS_REVIEW','Revisión de Devolver/Reemplazar');
define('FS_SALES_DETAILS_NO','NO. de RMA');
define('FS_SALES_DETAILS_STATUS','Estado de RMA');
define('FS_SALES_DETAILS_AMOUNT','Cantidad');
define('FS_SALES_DETAILS_RPI','Información de pago por intorno');
define('FS_SALES_DETAILS_RA','Cantidad devuelta');
define('FS_SALES_DETAILS_RM','Método de reembolso');
define('FS_SALES_DETAILS_SAME','Mismo método de pago');
define('FS_SALES_DETAILS_NOTE','Tenga en cuenta: el importe del reembolso final estará en su correo electrónico de confirmación de devolución.');
define('FS_SALES_DETAILS_PROCESS','Proceso de RMA');
define('FS_SALES_DETAILS_AWB','Actualizar AWB');
define('FS_SALES_DETAILS_ADDRESS','Confirmar la dirección');
//2017-12-30  ery    add
define('FS_SALES_INFO_REQUEST','Solicitdu de RMA');
define('FS_SALES_INFO_A','Una solicitud de devolución no garantiza un número de autorización, ya que algunos artículos no se pueden devolver y deben verificarse.');
define('FS_SALES_INFO_PLEASE','Por favor revise los términos y condiciones de venta para nuestra política de devolución. Se le notificará dentro de las 24 horas si su declaración ha sido aprobada o denegada.');
define('FS_SALES_INFO_YOU','Puede enviar hasta ');
define('FS_SALES_INFO_WHAT','¿Cuál es el motivo del regreso?');
define('FS_SALES_INFO_QI','Problemas de calidad');
define('FS_SALES_INFO_SI','Problemas de servicio');
define('FS_SALES_INFO_OI','Otros asuntos');
define('FS_SALES_INFO_WE',"No podemos ofrecer excepciones de política en respuesta a los comentarios");
define('FS_SALES_INFO_ATTA','Anexo');
define('FS_SALES_INFO_ALLOW','Permitir archivos de tipo PDF, JPG, PNG.');
define('FS_SALES_INFO_ADD','Añadir foto');
define('FS_SALES_INFO_VERIFY','Verificar la dirección RMA');
define('FS_SALES_INFO_KIND','Recordatorio amistoso');
define('FS_SALES_INFO_OUR','Nuestro centro de postventa puede llamarle, mantenga su teléfono desbloqueado.');
define('FS_SALES_INFO_I','Estoy de acuerdo con ');
define('FS_SALES_INFO_RP','Política de devolución');
define('FS_SALES_INFO_PLEASE_AGREE','Por favor acepte la política de devoluciones para continuar.');
define('FS_SALES_INFO_PLEASE_WRITE','Por favor escribe tu problema.');
define('FS_SALES_INFO_ITEMS','Los artículos no funcionaron correctamente');
define('FS_SALES_INFO_MIS','No coinciden en tamaño');
define('FS_SALES_INFO_DID','No coincide con la descripción');
define('FS_SALES_INFO_RE','Artículos incorrectos recibidos');
define('FS_SALES_INFO_UN','No se puede enviar cuando los necesito');
define('FS_SALES_INFO_DA','Dañado a la llegada');
define('FS_SALES_INFO_NO','Ya no es necesario');
define('FS_SALES_INFO_NOT','No como se esperaba');
define('FS_SALES_INFO_WRONG','Ordene artículos incorrectos');
define('FS_MANAGE_ORDERS_PO','No. de PO');
define('FS_MANAGE_ORDERS_RE','Revisado');
define('FS_MANAGE_ORDERS_TN','Número de seguimiento');
define('FS_MANAGE_ORDERS_MORE','Más');
define('FS_MANAGE_ORDERS_RECORDA','Registros por página');
define('FS_MANAGE_ORDERS_PURCHASE',"El número de orden de compra no puede estar vacío");
define('FS_MANAGE_ORDERS_OC',"Comentarios del pedido");
define("FS_MANAGE_ORDERS_FILE","Please upload your PO file.");
//2018-1-3   ery    add
define('FS_SALES_DETAILS_RAE','Las devoluciones son fáciles');
define('FS_SALES_DETAILS_NO_LABEL','Por favor, siga el diagrama de flujo a continuación para devolver los artículos. Le proporcionamos una dirección de envío de devolución, y usted proporciona y paga su propia etiqueta de correo utilizando el proveedor de su elección. Por favor, actualice su número de seguimiento para nosotros. Si tiene alguna pregunta, comuníquese con nosotros para obtener ayuda inmediata.');
define('FS_SALES_DETAILS_LABEL','Por favor, siga el diagrama de flujo a continuación para devolver los artículos. Le proporcionamos una etiqueta de envío prepago para su paquete de devolución y la llevamos a un lugar de envío autorizado de UPS, esta opción le permite rastrear su paquete en el camino de regreso a nosotros.');
define('FS_SALES_DETAILS_CR','Cancelar RMA');
//2018-1-22    ery  add   sales_service_info页面
define('FS_SALES_INFO_NUMBER','Número de serie');
define('FS_SALES_INFO_FOR','Para transceptores,&nbsp;proporcione el número de serie, para que podamos identificar y resolver más rápido el problema.');
define('FS_SALES_INFO_BRIEFLY','Explique brevemente el problema');
define('FS_REFUND_PROCESSING','Procesamiento de reembolso');
define('FS_REFUND_APPLICATION','Solicitud de reembolso');
define('FS_REFUND_SUCCESS_MSG','Reembolso con éxito, verifique el estado de cuenta de su cuenta de pago.');
define('FS_REFUND_FAIL_MSG','Lo sentimos, su solicitud de reembolso es rechazada. Si tiene alguna pregunta, por favor contáctenos.');
define('FS_REFUND_APPMSG','Su solicitud de reembolso está en progreso, el resultado será actualizado aquí pronto.');

//2018-3-19  add   ery  产品详情页Compatible Brands属性未勾选的提示语
define('FS_PRODUCT_INFO_BRAND_PLEASE','Por favor elija una marca.');
define('FS_PRODUCT_INFO_BRAND_CHOOSE','Elegir una marca');

//fairy 整理公共的
// 公共表单
define('FS_TAX_ERROR_EMPTY','Por favor, introduzca un número de CIF/VAT válido.');
define('FS_SECURITY_ERROR', 'Hubo un error de seguridad.');  // token验证不正确
define('FS_SYSTME_BUSY', 'Error: sistema ocupado, por favor intente más tarde.'); // 异步提交，连接服务器出现error情况
define('FS_ACCESS_DENIED', 'Error: Acceso denegado.');//没有权限访问
define('FS_ACCESS_DENIED_1', 'Error: código 999.');
define('FS_FORM_REQUEST_ERROR','El sistema está ocupado. Inténtelo de nuevo más tarde.');
define('FS_NON_MANDAROTY',"No obligatorio");
define('FS_COMMON_SAVE',"Confirmar");
define('FS_COMMON_CANCEL',"Cancelar");
define('FS_COMMON_YES',"Sí");
define('FS_COMMON_NO',"No");
define('FS_COMMON_SUBMIT',"Enviar");
define('FS_COMMON_PROCESSING',"Tratamiento");
define('FS_COMMON_EDIT','Editar');
define('FS_COMMON_LESS',"Menos");
define('FS_CONFIRM','Confirmar');
define("FS_PLEASE_CHOOSE_ONE",'Por favor elige uno...');

//验证码 start
define('FS_ENTER_CHARACTER',"Ingresa los caracteres que ves.");
define('FS_IMAGE_REQUIRED_TIP',"Por favor ingresa los caracteres en la imagen.");
//验证码-服务器端的验证
define('FS_IMAGE_ERROR_TIP',"Los caracteres son incorrectos, por favor inténtalo otra vez.");
define('FS_IMAGE_EXPIRE_TIP',"Debido a largo tiempo no hay operación, por favor actualice los caracteres y vuelva a entrar.");
define('FS_IMAGE_FIRST_SHOW_PWD_ERROR_TIP',"Para proteger mejor tu cuenta, por favor ingresa tu contraseña otra vez y luego los caracteres como se muestran en la imagen de abajo.");
define('FS_IMAGE_FIRST_SHOW_EMAIL_ERROR_TIP',"Para proteger mejor su cuenta, por favor ingrese su correo electrónico y luego los caracteres como se muestran en la imagen de abajo.");
//验证码 end

// 公共的
define('FS_USERNAME','Nombre de usuario');
define('FS_FIRST_NAME',"Nombre");
define('FS_LAST_NAME',"Apellido");
define('FS_PASSWORD',"Contraseña");
define('FS_EMAIL_ADDRESS',"Correo electrónico");
define('FS_EMAIL_ADDRESS1',"Correo electrónico");
define('FS_EMAIL_ADDRESS2',"CORREO ELECTRÓNICO");
define('FS_COMPANY_WEBSITE',"Página Web de la compañía");
define('FS_INDUSTRY',"Sector");
define('FS_COMPANY_NAME',"Nombre de empresa");
define('FS_FOOTER_COMPANY_INFO',"Nombre de empresa");
define('FS_ENTERPRISE_OWNER_NAME',"Nombre del propietario de la empresa");
define('FS_YOUR_COUNTRY',"País/Región");
define('FS_COUNTRY',"País/Región");
define('FS_SELECT_YOUR_COUNTRY_REGION','Seleccione Tu País/Región');
define('FS_SELECT_COUNTRY_REGION','Selecciona país/región');
define('FS_COMMON_COUNTRY_REGION','País/Región');
define('CURRENT','actual');
define('MAIN_MENU','Inicio');
define('FS_SELECT_CURRENCY','Elegir idioma/moneda');
define('FS_LANGUAGE_CURRENCY','Idioma/Moneda');
define('FS_OTHER_COUNTRIES','Otros regiones');
define('FS_VAT_NUMBER',"Número de IVA intracomunitario");
define('FS_PHONE_NUMBER',"Número de teléfono");
define('FS_COMMON_COMPANY','Empresa');
define('FS_FOOTER_COMPANY_INFO',"Empresa");
define('FS_QTY','Cantidad');
define('FS_OPTIONAL_COMPANY',' (opcional)');
// 公共的
define('FS_OR', 'o');
define('FS_OTHERS','Otros');
define('FS_LOADING',"Esperando");
define('FS_SHOW',"mostrar");
define('FS_HIDE',"ocultar");
define('FS_HELLO','Hola');
define('FS_COMMON_MORE','Más');
define('FS_COMMON_CUSTOMIZED','Personalizado');
// 公共的
define('FS_COPY',"Copyright");
define('FS_RIGHTS',"Todos los derechos reservados");
define('FS_TERMS_OF_USE',"Términos de uso");
define('FS_POLICY',"Política de privacidad");
define('FS_AGREE_POLICY','Al hacer clic en el botón de abajo, aceptas <a href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'" target="_blank">Privacidad y Cookies</a> y <a href="'.HTTPS_SERVER.reset_url('policies/terms_of_use.html').'" target="_blank">Términos de Uso</a>.');
define('FS_FOOTER_COOKIE_TIP','Usamos cookies para garantizar que le brindemos la mejor experiencia en nuestro sitio web. Al continuar utilizando este sitio, acepte nuestro uso de cookies de acuerdo con nuestro <a href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">Política de Cookies</a>.');
define('FS_FOOTER_COOKIE_MOBILE_TIP','Utilizamos cookies para ofrecerle la mejor experiencia de compra. Lea <a href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">Poítica de Cookies</a>.');
define('FS_I_ACCEPT','De acuerdo');

define("FS_WAREHOUSE_EU","almacén DE");
define("FS_WAREHOUSE_US","Almacén de EE. UU.");
define("FS_WAREHOUSE_CN","Almacén de China");
define("FS_WAREHOUSE_SG","almacén SG");
define("FS_WAREHOUSE_RU","almacén RU");
//公用头部账户板块
define('FS_COMMON_HEADER_ACCOUNT','Cuenta');
define('FS_COMMON_HEADER_ACCOUNT_NEW','Núm. de cuenta');
define('FS_COMMON_HEADER_CASES','Casos');
define('FS_COMMON_HEADER_NOT','No es usted? ');
define('FS_COMMON_HEADER_OUT','Cerrar sesión');
define('MANAGE_ORDER_HISTORY','Pedidos');
define('FS_ACCOUNT_NO','No. ');

// 2018.4.3 fairy 报价
define('FS_GET_A_QUOTE_BIG', 'Obtener cotización');
define('FS_GET_A_QUOTE_FREE', 'Solicitar una Caja');
define('FS_GET_A_QUOTE', 'Obtener presupuesto');
define('FS_REQUEST_DEADLINE','La solicitud se cerró según lo planificado. Una versión actualizada estará disponible pronto, por favor estén atentos.');


//运费
define("FS_SHIPPING_AREA_BY_WAREHOUSE_CN","Disponible para envío inmediato desde el almacén de China");
define("FS_SHIPPING_AREA_BY_WAREHOUSE_US","Disponible para envío inmediato desde el almacén de EE.UU.");
define("FS_SHIPPING_AREA_BY_WAREHOUSE_EU","Disponible para envío inmediato desde el almacén de la UE");
define("FS_SHIPPING_AREA_BY_WAREHOUSE_SHORT_CN","de almacén de China");
define("FS_SHIPPING_AREA_BY_WAREHOUSE_SHORT_US","de almacén de EE.UU.");
define("FS_SHIPPING_AREA_BY_WAREHOUSE_SHORT_EU","de almacén de la UE");
define("FS_BULK_WAREHOUSE","Envío desde China estimado en");
define("FS_TIME_ZONE_RULE_US","(UTC/GMT+1)");
if(SUMMER_TIME){
    define("FS_TIME_ZONE_RULE_EU"," (UTC/GMT+2)");
}else{
    define("FS_TIME_ZONE_RULE_EU"," (UTC/GMT+1)");
}

define("FREE_SHIPPING_TEXT1","Envío gratis para pedidos superiores a 79€ (artículos de gran dimensión excluidos).");
define("FREE_SHIPPING_TEXT2","Envío gratis para pedidos superiores a US$79 (artículos de gran dimensión excluidos).");
define('FS_LIMIT_MONEY',"El volumen total excede la limitación. ¡Por favor divida el pedido o elija otro método de pago!");
define('FS_LIMIT_MONEY_15000','¡El monto ha superado el límite (15000 €), divida el pedido o elija otro método de pago por favor!');
define('FS_LIMIT_MONEY_10000','¡El monto ha superado el límite (10000 €), divida el pedido o elija otro método de pago por favor!');

//2018-3-15  ery  add  订单上传logo
define('FS_ATTRIBUTE_OEM','Servicio OEM/ODM');
define('NEWS_FS_ATTRIBUTE_OEM','Servicio etiquetado');
define('FS_ATTRIBUTE_NONE','Nada');
define('FS_ATTRIBUTE_DESIGN','Etiqueta Diseñada');

define('FS_ORDER_LOGO_DESIGN',"Cargar el logo de etiqueta diseñada");
define('FS_ORDER_LOGO_YOUR',"Cargue su logo de etiqueta diseñada o su Nombre de Vendedor & Número de Modelo específicos para referencia.");
define('FS_ORDER_LOGO_WE',"Confirmaremos la etiqueta con usted y procesaremos su orden. También puede enviarnos su logo por email.");
define('FS_ORDER_LOGO_UPLOAD',"Cargar Logo");
define('FS_ORDER_LOGO_DELETE',"¿Borrar la imagen?");
define('FS_ORDER_LOGO_UP_SUCCESS','¡Archivo de logo cargado con éxito!');
define('FS_ORDER_LOGO_DEL_SUCCESS','¡Imagen borrada con éxito!');
//产品详情页
define("FS_FOR_FREE_SHIPPING","Envío gratuito ");
define("FS_SG_FREE_SHIPPING","Envío e instalación gratuitos ");
define("FS_SG_NO_FREE_SHIPPING","Instalación gratuita ");
define("FS_FOR_FREE_SHIPPING_US",'para pedidos superiores a $MONEY');
define("FS_FOR_FREE_SHIPPING_US_MX","para pedidos superiores a MXN$ 1,600");
define("FS_FOR_FREES_SHIPPING_ONE","¿Lo necesita mañana ");
define("FS_FOR_FREES_SHIPPING_TWO","Haga pedido antes de ");
define("FS_FOR_FREES_SHIPPING_TIME","4pm (PST)");
define("FS_FOR_FREES_SHIPPING_TIME_UP","4pm (PST)");
define("FS_FOR_FREES_SHIPPING_THREE","y elija el Overnight Shipping al finalizar la compra");
define("FS_FOR_FREES_SHIPPING_FOUR","El envío:");
define("FS_FOR_FREES_SHIPPING_FIVE","Obténgalo dentro de 1-3 días hábiles cuando haga pedido antes de <span>4pm(PST)</span>.");
define("FS_FOR_FREES_SHIPPING_FIVE_CA_UP","Obténgalo dentro de 1-3 días hábiles cuando haga pedido antes de <span>4pm(PST)</span>.");
define("FS_FOR_FREES_SHIPPING_FIVE_MX_UP","Obténgalo dentro de 1-3 días hábiles cuando haga pedido antes de <span>4pm(PST)</span>.");
define("FS_FOR_FREES_SHIPPING_SIX","¿Lo necesita el martes? Elija el Overnight Shipping al finalizar la compra.");
define("FS_FOR_FREE_SHIPPING_DE","Envío gratuito ");
define("FS_FOR_FREE_SHIPPING_DE_MONEY",' para pedidos superiores a $MONEY');
define("FS_FOR_FREES_SHIPPING_FIVE_DE1"," <span>4pm (UTC/GMT +2)</span> y elija DHL Express al finalizar la compra.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE2"," <span>4pm (UTC/GMT +1)</span> y elija UPS Express Saver al finalizar la compra.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE3","Quiere que la entrega sea más rápida? Haga pedido antes de <span>5pm (UTC/GMT +2)</span> y elija UPS Express Saver al finalizar la compra.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE4"," <span>3pm (UTC/GMT +1)</span> y elija UPS Express Saver al finalizar la compra.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE5"," <span>3:00 pm (UTC/GMT +1)</span> y elija UPS Express Saver al finalizar la compra.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE6","Quiere que la entrega sea más rápida? Haga pedido antes de <span>11:00am (UTC/GMT -3)</span> y elija UPS Express Saver al finalizar la compra.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE7","Quiere que la entrega sea más rápida? Haga pedido antes de <span>6:00 pm (UTC/GMT +4)</span> y elija UPS Express Saver al finalizar la compra.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE8","Quiere que la entrega sea más rápida? Haga pedido antes de <span>3:00 pm (UTC/GMT +1)</span> y elija UPS Express Saver al finalizar la compra.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE9","Quiere que la entrega sea más rápida? Haga pedido antes de <span>5:00 pm (UTC/GMT +3)</span> y elija UPS Express Saver al finalizar la compra.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE10","<span>4pm (UTC/GMT +3)</span> y Haga UPS Express Saver al finalizar la compra.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE11","Quiere que la entrega sea más rápida? Haga pedido antes de <span>12:00am (UTC/GMT -2)</span> y elija DHL Express al finalizar la compra.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE12","Se envian el martes y Obténgalo dentro de 1-3 días hábiles.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE13","¿Lo necesita el martes? Elija DHL Express al finalizar la compra.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE14","¿Lo necesita el martes? Elija UPS Express Saver al finalizar la compra.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE15","¿Quiere que se entregue más rápido? Elija UPS Express Saver al finalizar la compra.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE16","¿Quiere que se entregue más rápido? Elija DHL Express al finalizar la compra.");
define("FS_FOR_FREE_SHIPPING_GB1","Envío gratuito en UK");
define("FS_FOR_FREE_SHIPPING_GB3","para pedidos superiores a £79");
define("FS_FOR_FREE_SHIPPING_GB4","en UK");
define('FS_ITEM_LOCATION','Ubicación:');
define('FS_SEATTLE_WASHINGTON','Seattle, Estados Unidos');
define('FS_SEATTLE_EU','Munich, Alemania');
define('FS_SEATTLE_CN','Wuhan, China');

//详情页Compatible Brands提示 dylan 2019.11.18
define('FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_01','ej: Cisco N9K-C9396PX a Juniper MX960');
define('FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_02','ej: Cisco N9K-C9396PX QSFP+ a Juniper MX960 SFP+');
define('FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_03','ej: Cisco N9K-C9396PX QSFP+ a Juniper EX4200 XFP');
define('FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_04','ej: Cisco N9K-C9396PX QSFP28 a Juniper QFX5200 SFP28');
define('FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_05','ej: Cisco Nexus 5696Q CXP a Juniper MX960 QSFP+');

//定制产品属性类型选择
define('FS_SELECT_TYPE','Las especificaciones más comunes que eligen nuestros clientes.');
define('FSCHOOSE_SPECI','Elige especificaciones:');
define('FS_SELECT_DEFAULT','Por defecto');
define('FS_SELECT_CUSTOMIZE','Personalizado');

//add by quest 2019-03-11  // 2019 3.18 po产品 shipping弹窗 pico
define("FS_FOR_FREE_SHIPPING_PRE_ORDER","en pedidos superiores a MONEY");

if (get_warehouse_by_code($_SESSION['countries_iso_code']) == 'us') {
    define('FS_PRE_PRODUCTS_SHIPPING_WD_TITLE',"Envío gratuito en pedidos de Pre-Order superiores a MONEY");
    define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO', "Por favor agregue al menos artículos de Pre-Order de MONEY a su cesta para el envío gratuito. Cualquier artículo de Pre-order con “Envío gratuito” en esta página es elegible y contribuye al precio mínimo para envío gratuito.");
    define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO_03', "El tiempo de procesamiento de los artículos de Pre-Order es aproximadamente de 15 días hábiles. Los enviaremos después de la producción y las pruebas exhaustivas. La velocidad de envío dependerá del método de envío que elija durante la compra.");
    define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO_04', "El servicio de Pre-Order puede ayudarle a planificar sus proyectos de una manera más flexible y libre. Obtener más informaciones sobre e <a href ='".zen_href_link('index')."specials/pre-order-service-71.html' target='_blank'>servicio de Pre-Order</a>.");
}elseif(get_warehouse_by_code($_SESSION['countries_iso_code']) == 'de') {
    define('FS_PRE_PRODUCTS_SHIPPING_WD_TITLE', "Envío gratuito en pedidos de Pre-Order superiores a MONEY");
    define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO', "Por favor agregue al menos artículos de Pre-Order de MONEY a su cesta para el envío gratuito. Cualquier artículo de Pre-order con “Envío gratuito” en esta página es elegible y contribuye al precio mínimo para envío gratuito.");
    define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO_03', "El tiempo de procesamiento de los artículos de Pre-Order es aproximadamente de 15 días hábiles. Los enviaremos después de la producción y las pruebas exhaustivas. La velocidad de envío dependerá del método de envío que elija durante la compra.");
    define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO_04', "El servicio de Pre-Order puede ayudarle a planificar sus proyectos de una manera más flexible y libre. Obtener más informaciones sobre e <a href ='".zen_href_link('index')."specials/pre-order-service-71.html' target='_blank'>servicio de Pre-Order</a>.");
}else{
    define('FS_PRE_PRODUCTS_SHIPPING_WD_TITLE', "Servicio de Pre-Order, suministro masivo y ahorro de presupuesto");
    define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO', "Para ofrecer un mejor servicio a las Pymes y las grandes empresas, FS ha invertido en un fabricante con una área de producción de 10.000 metros cuadrados, y agregamos nuevas líneas de producción oriendadas por el servicio de Pre-Order, lo cual puede ayudar a los clientes en el ahorro de presupuesto por producción masivo y también en la preparación anticipada para sus proyectos.");
    define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO_03', "El tiempo de procesamiento de los artículos Pre-Order es aproximadamente de 15 días hábiles. Por lo tanto, los clientes pueden organizar sus planes de compra de antemano para proyectos planificados.");
    define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO_04', "Enviaremos los artículos después de la producción y las pruebas exhaustivas. La velocidad de envío dependerá del método de envío que elija durante el proceso de pago.<br><br>Conocer más detalles sobre el <a href ='".zen_href_link('index')."specials/pre-order-service-71.html' target='_blank'>servicio de Pre-Order</a>.");
}

//Delivery & Return Dylan 2019.8.7
define('FS_DELIVERY_RETURN','Garantía y devoluciones');
define('FS_FAST_SHIPPING_SOUTH_EAST_ASIA','Envío rápido a Sureste Asiático');
define('FS_DELIVERY_FREE_RETURNS_CONTENT','<p>Si el producto no funciona como se esperaba, FS garantía permite que devuelvas el artículo, lo cambies, o lo reparemos.</p><br/>
<p>Ofrecemos el servicio de devolución y de cambio para la mayoría de los productos en stock dentro de un plazo de 30 días. Y durante el período de garantía, también ofrecemos el servicio de reparación gratuito.</p><br/>
<p>Para los productos consumibles, no hay período de garantía y no ofrecemos el servicio de reparación gratuito. Si hay cualquier problema de calidad después de la entrega, no dudes en ponerte en contacto con nosotros. Lo resolveremos a tiempo. Consulta <a href="'.reset_url("/policies/day_return_policy.html ").'" target="_blank">Poítica de devoluciones</a> y <a href="'.reset_url("/policies/warranty.html").'" target="_blank">Garantía</a> para más información.</p>');
define('FS_SHIPPING_INFO_DETAIL_FREE_SHIPPING_STANDARD','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">Los pedidos superiores a $MONEY (excepto los artículos pesados, de tamaño grande y de Pre-Order) podrán disfrutar del servicio de envío gratuito. Para más información, consulta <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Envíos y entregas</a>.</div>');
define('FS_SHIPPING_INFO_DETAIL_FAST_SHIPPING_BUCK','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">FS ofrece varias opciones de envío y puedes elegir el servicio de envío que más te convenga según el tiempo de envío y los costos. Los pedidos con stock se enviarán dentro de 24 horas tras la realización de los pedidos. Para más información, consulta <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Envíos y entregas</a>.</div>');
define('FS_SHIPPING_INFO_DETAIL_FAST_SHIPPING_PRE','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">Los artículos Pre-Order sólo podrán disfrutar del servicio de envío gratuito siempre y cuando el valor del pedido supere $MONEY. Para más información, consulta <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Envíos y entregas</a>.</div>');


define("FS_SHIPPING_POLICY_US","La fecha de entrega se aplica a los pedidos con existencias disponibles solicitados antes de las 5pm EST en días hábiles. Los pedidos realizados después se enviarán el próximo día hábil. Si la cantidad que compras excede nuestro inventario, el pedido se dividirá en diferentes envíos sin costo adicional. Para más detalles, consulta la página de pago.");
define("FS_SHIPPING_POLICY_CA","La fecha de entrega se aplica a los pedidos con existencias disponibles solicitados antes de las 5pm en días hábiles. Los pedidos realizados después se enviarán el próximo día hábil. Si la cantidad que compras excede nuestro inventario, el pedido se dividirá en diferentes envíos sin costo adicional. Para más detalles, consulta la página de pago.");
define("FS_SHIPPING_POLICY_MX","La fecha de entrega se aplica a los pedidos con existencias disponibles solicitados antes de las 4pm en días hábiles. Los pedidos realizados después se enviarán el próximo día hábil. Si la cantidad que compras excede nuestro inventario, el pedido se dividirá en diferentes envíos sin costo adicional. Para más detalles, consulta la página de pago.");
define("FS_SHIPPING_POLICY_NZ","La fecha de entrega se aplica a los pedidos con existencias disponibles solicitados antes de las 3:00pm (AEST/AEDT) en días hábiles. Los pedidos realizados después se enviarán el próximo día hábil. Si la cantidad que compras excede nuestro inventario, el pedido se dividirá en diferentes envíos sin costo adicional. Para más detalles, consulta la página de pago.");
define("FS_SHIPPING_POLICY_AU","La fecha de entrega se aplica a los pedidos con existencias disponibles solicitados antes de las 3:00pm (AEST/AEDT) en días hábiles. Los pedidos realizados después se enviarán el próximo día hábil. Si la cantidad que compras excede nuestro inventario, el pedido se dividirá en diferentes envíos sin costo adicional. Para más detalles, consulta la página de pago.");
define("FS_SHIPPING_POLICY_GB","La fecha de entrega se aplica a los pedidos con existencias disponibles solicitados antes de las ".FS_SUMMER_OR_WINTER_TIME." en días hábiles. Los pedidos realizados después se enviarán el próximo día hábil. Si la cantidad que compras excede nuestro inventario, el pedido se dividirá en diferentes envíos sin costo adicional. Para más detalles, consulta la página de pago.");
define("FS_SHIPPING_POLICY_DE","La fecha de entrega se aplica a los pedidos con existencias disponibles solicitados antes de las ".(SUMMER_TIME ? '4:30pm (UTC/GMT+2)' : '4:30pm (UTC/GMT+1)')." en días hábiles. Los pedidos realizados después se enviarán el próximo día hábil. Si la cantidad que compras excede nuestro inventario, el pedido se dividirá en diferentes envíos sin costo adicional. Para más detalles, consulta la página de pago.");
define("FS_SHIPPING_POLICY_CN","La fecha de envío es para los pedidos de artículos en stock realizados antes de las 3:30pm (GMT+8) en días hábiles. Si la cantidad que necesita supera la en stock, el pedido se dividirá en diferentes envíos sin costo adicional. Si quiere conocer más detalles, por favor siga su compra y consulte la página de pago.");
define("FS_SHIPPING_POLICY_SG","La fecha de entrega se aplica a los pedidos con existencias disponibles solicitados antes de las 3:30pm (GMT+8) en días hábiles. Los pedidos realizados después se enviarán el próximo día hábil. Si la cantidad que compras excede nuestro inventario, el pedido se dividirá en diferentes envíos sin costo adicional. Para más detalles, consulta la página de pago.");
define("FS_SHIPPING_POLICY_RU","La fecha de envío es para los pedidos de artículos en stock realizados antes de las 10:30am (UTC/GMT+3) en días hábiles. Si la cantidad que necesita supera la en stock, el pedido se dividirá en diferentes envíos sin costo adicional. Si quiere conocer más detalles, por favor siga su compra y consulte la página de pago.");

define("FS_FESTIVAL1","Nuestra sede en Alemania no prestará servicio al público el día festivo");
define("FS_FESTIVAL2"," FS.COM GmBH volverá el ");
define("FS_FESTIVAL3"," Agradecemos tu comprensión.");
define("FS_FESTIVAL4","de");
define("FS_FESTIVAL5","nd");
define("FS_FESTIVAL6","Nuestra sede en EE.UU. no prestará servicio al público el día festivo ");
define("FS_FESTIVAL7"," Agradecemos tu comprensión.");
define("FS_FESTIVAL8"," Procesaremos tus pedidos a partir del día ");
define("FS_FESTIVAL8_01"," Procesaremos tus pedidos a partir del día ");
/******meta标签语言包*****/
define("FS_META_PRO_01","Compre ");
define("FS_META_PRO_02"," al mejor precio desde el fabricante de soluciones de red ISP, el centro de datos y la empresa.");
/******end*****/

define('FS_CHECK_OUT_TAX_SG','GST');
define('FS_CHECK_OUT_INCLUDING_SG','(Incluyendo GST)');

//新增加
define('FS_CHECK_OUT_TAX_AU','GST');
define('FS_CHECK_OUT_EXCLUDING_AU','(Excluyendo GST)');
define('FS_CHECK_OUT_INCLUDING_AU','(Incluyendo GST)');
define("FS_WAREHOUSE_AREA_AU","Enviar desde almacén de Au");
define("CHECKOUT_TAXE_AU_TIT","Sobre GST y Tarifa");
define("CHECKOUT_TAXE_AU_CONTENT", "De conformidad con la <em class='alone_font_italic'>Ley de un nuevo sistema fiscal (impuesto sobre bienes y servicios) de 1999</em>, para envíos desde el almacén en Melbourne, FS.COM PTY LTD está obligado a cobrar GST en todos los pedidos entregados en ubicaciones dentro de Australia. Todos los artículos en nuestra categoría están sujetos a un GST regular del 10%. Después de completar la información del pedido, podrás ver el precio total que incluye el GST en el resumen del pedido.</br></br>Para los pedidos de artículos sin existencias en el almacén en Melbourne, los enviaremos cuando lleguen a Melbourne tras el tránsito desde nuestro almacén en Asia.</br></br>Para los pedidos que contengan artículos pesados o de gran tamaño, los enviaremos directamente desde nustro almacén en Asia. En este caso, no cobraremos GST cuando realices el pedido. Sin embargo, estos paquetes pueden tener tarifas de importación o de aduana según las leyes de los países correspondientes. Los cargos adicionales por el despacho de aduana tendrían que ser asumidos por el destinatario.");
define("FREE_SHIPPING_TEXT3","Entrega gratuita en pedidos superiores a AU $99.");
define("FS_WAREHOUSE_AU","almacén AU");
define('EMAIL_CHECKOUT_COMMON_VAT_COST_AU','GST');
define('PRODUCTS_SHIP_TODAY','Enviar hoy');
define('ITEM_LOCATION_AU','Melbourne, Australia ');
define('FS_COMMON_WAREHOUSE_AU','FS.COM Pty Ltd<br>
			ABN 71 620 545 502 <br>
			57-59 Edison Rd,<br>
			Dandenong South,<br>
			VIC 3175,<br>
			Australia
			Tel: +61 (2) 8317 1119');
define("FS_ADDRESS_PO","PO");

// 2018.7.23 fairy 底部反馈弹窗
define('FS_GIVE_FEEDBACK','Déjanos tus comentarios');
define('FS_GIVE_FEEDBACK_TIP','Gracias por visitar FS. Tu comentario nos ayuda a mejorar y ofrecer una mejor experiencia a los clientes.');
define('FS_RATE_THIS_PAGE','Califica tu experiencia en FS*');
define('FS_NOT_LIKELY','Malo');
define('FS_VERY_LIKELY','Perfecto');
define('FS_TELL_US_SUGGESTIONS','Por favor selecciona un tema para tu comentario.*');
define('FS_ENTER_COMMENTS','Dinos lo que piensas.');
define('FS_PROVIDE_EMAIL','Si quieres recibir una respuesta, por favor deja tu información de contacto.');
define('FS_PROVIDE_EMAIL_TIP','Nota: Esta información NO se usará para ningún otro propósito. Valoramos su privacidad.');
define('FS_FEEDBACK_THANKYOU','Has compartido este producto por correo electrónico correctamente.');
define('FS_PRO_SHARE_EMAIL','Tu mensaje se ha enviado.');
define('FS_FEEDBACK_THANKYOU_TIP_01','Nos importa tu opinión. Verificaremos tu feedback y lo tomaremos en consideración para mejorar nuestro sitio web.');
define('FS_FEEDBACK_THANKYOU_TIP_02','Tu satisfacción es nuestra prioridad. Seguiremos ofreciéndote un mejor servicio y una buena experiencia de compra.');
define("FS_ADDRESS_MESSAGE3","Dirección, c/o");
define("FS_ADDRESS_MESSAGE4","Apartamento, suite, unidad, edificio, piso, etc.");define("CHECKOUT_TAXE_CN_FRONT1","Todos los pedidos enviados desde nuestro Almacén CN a China continental, Hong Kong, Macao y Taiwán pueden disfrutar de ENVÍO GRATUITO (a China continental, por defecto SF Express y Fedex IE por defecto a Hong Kong, Macao y Taiwán).");
define("CHECKOUT_TAXE_CN_FRONT2","Al mismo tiempo, según la Ley de la República Popular de China sobre la administración de la recaudación de impuestos (en adelante, LATC), FS.COM está obligado a cobrar el 13% de IVA en todos los pedidos entregados a China continental. Y para los pedidos enviados a HK, Macao y Taiwán, no se cobra IVA, pero estos paquetes pueden ser gravados con aranceles de importación o aduanas, dependiendo de las leyes/regulaciones de los destinos particulares. Los cargos adicionales por despacho de aduana deben ser originados por el destinatario.");
define('FS_CHOOSE_ONE','Por favor elija uno');
define('FS_WEB_ERROR','Error en página web');
define('FS_FEEDBACK_PRODUCT','Producto');
define('FS_ORDER_SUPPORT','Tratamiento de pedidos');
define('FS_TECH_SUPPORT','Soporte técnico');
define('FS_SITE_SEARCH','Búsqueda de productos');
define('FS_FEEDBACK_OTHER','Otro');
define('FS_FEEDBACK_NAME','Nombre');
define('FS_FEEDBACK_EMAIL','Dirección de correo electrónico');

define("CHECK_SEARCH","Ingresar");
define("FS_CHECKOUT_ERROR35","Por favor edite su dirección (seleccione el país válido).");
define("FS_CHECKOUT_ERROR29","Por favor edite su dirección (ingrese el código postal válido).");
define("FS_HSBC_INFO1","Banco beneficiario");
define("FS_HSBC_INFO2","Nombre del A/C del Beneficiario");
define("FS_HSBC_INFO3","IBAN:");
define("FS_HSBC_INFO4","BIC:");
define("FS_HSBC_INFO5","Número de cuenta:");
define("FS_HSBC_INFO6","Dirección del banco:");
define("FS_SET_DEFAULT","Por defecto");
//add by helun
define('FS_AGAINST_BPAY_01','Fecha de pedido:');
define('FS_AGAINST_BPAY_02','Precio total:');
define('FS_AGAINST_BPAY_03','Su compra se ha dividido en');
define('FS_AGAINST_BPAY_04','pedidos.');
define('FS_AGAINST_BPAY_05','Entrega estimada');
define('FS_AGAINST_BPAY_06','Enviar desde');
define('FS_AGAINST_BPAY_07','Pedido');
define('FS_AGAINST_BPAY_08','de');
define('FS_AGAINST_BPAY_09','Proceder a ');
define('FS_AGAINST_BPAY_10','Sparkasse Freising');
define('FS_AGAINST_BPAY_11','FS.COM GmbH');
define('FS_AGAINST_BPAY_12','DE16 7005 1003 0025 6748 88');
define('FS_AGAINST_BPAY_13','BYLADEM1FSI');
define('FS_AGAINST_BPAY_14','25674888');
define('FS_AGAINST_BPAY_15','Untere Hauptstr.29, 85354, Freising');
define('FS_AGAINST_BPAY_16','817-888472-838');
define('FS_AGAINST_BPAY_17','HSBCHKHHHKH');
define("FS_COMMON_CHECKOUT_HSBC","Generalmente recibimos los pagos entre 1 y 3 días hábiles. Procesaremos tu pedido una vez se confirme la transferencia.");
define("FS_COMMON_CHECKOUT_SUCCESS_ORDER_HSBC","Por favor, anota tu número de pedido de FS cuando realices el pago para que procesemos tu pedido a tiempo. Generalmente recibimos los pagos entre 1 y 3 días hábiles. Procesaremos tu pedido una vez se confirme la transferencia.");

//add by Aron 2017.7.25
define("FS_UPLOAD_TITLE","Subir la orden de compra");
define("FS_UPLOAD_TEXT","Sube tu orden de compra para acelerar el procedimiento. Procesaremos tu pedido tan pronto como recibamos el archivo PO. Por favor, proporciónanos todas las firmas e informaciones necesarias.");
//add by aron 2017.11.18
define("FS_SUCCESS_GLOABL_THANK","¡El pago es exitoso! Su pedido está en proceso.");
//add by frankie 2018.1.2.
define("FS_SUCCESS_PURCHASE_ADDRESS_NOTE","La dirección de envío no coincide con las direcciones en su formulario de solicitud de crédito. Revisaremos el pedido y le enviaremos el resultado por correo electrónico dentro de las 12 horas. Suba el documento de PO en 7 días labolares, o el pedido se cancelará automáticamente debido al cambio de inventario de artículos.");
define("FS_SUCCESS_PURCHASE_MONEY_NOTE","Su crédito disponible ha sido excedido. Para que este pedido sea procesado rápidamente, cancele los pedidos anteriores para recuperar el crédito, o puede ir a <a href ='".zen_href_link('my_dashboard')."'>”Mi crédito”</a> para solicitar el aumento del límite de crédito. Suba el documento de PO en 7 días labolares, o el pedido se cancelará automáticamente debido al cambio de inventario de artículos.");
define("FS_SUCCESS_PURCHASE_DOUBLE_NOTE","La dirección de envío no coincide con las direcciones en su formulario de solicitud de crédito y su crédito disponible también se ha excedido. Para que este pedido sea procesado rápidamente, cancele los pedidos anteriores para recuperar el crédito o puede ir a <a href ='".zen_href_link('my_dashboard')."'>”Mi crédito”</a> para solicitar el aumento del límite de crédito. Revisaremos el pedido y le enviaremos el resultado por correo electrónico en un plazo de 12 horas. Suba el documento de PO en 7 días labolares, o el pedido se cancelará automáticamente debido al cambio de inventario de artículos.");
define("FS_SUCCESS_PURCHASE_MONEY_NOTE_1","Suba el archivo de su pedido de compra en 7 días labolares, de lo contrario, el pedido se cancelará automáticamente debido al cambio en el inventario de los artículos.");
//po相关语言包
define("FS_PO_ADDRESS_01",'¿Presentará esta dirección como su dirección de PO?');
define("FS_PO_ADDRESS_02",'Su solicitud se ha presentado con éxito, por favor espere el aviso');
define("FS_PO_ADDRESS_03",'Nota');
define("FS_PO_ADDRESS_04",'Después de realizar con éxito este pedido, será necesario revisar la seguridad de su pedido, ya que la dirección de envío no es la de "PO".');
define("FS_PO_ADDRESS_05",'confirmar la dirección');
define("FS_PO_ADDRESS_06",'volver a seleccionar la dirección');
define("FS_PO_ADDRESS_07",'Editar el límite de crédito');
define("FS_PO_ADDRESS_08",'Aumenta la cantidad');
define("FS_PO_ADDRESS_09",'Sí');
define("FS_PO_ADDRESS_10",'No');
define("FS_PO_ADDRESS_11",'Su crédito restante es insuficiente, ¿le gustaría aumentar el límite de crédito?');
define('FS_ADDRESS_SET_PO_SUCCESS','Su dirección de PO se ha enviado, espere la aprobación por favor');
define('FS_ADDRESS_SET_PO_SUCCESS','Su dirección de PO se ha enviado, espere la aprobación por favor');


define('FS_SHARE_CART_06','Gerente de cuenta. ');
//add ternence 2018-7-9
define('FS_SHOP_CART_ALERT_JS_50','Artículo(s)');
define('FS_SHOP_CART_ALERT_JS_51','Subtotal (');
define('FS_SHOP_CART_ALERT_JS_52','):');
define('FS_SHOP_CART_ALERT_JS_53','Resumen de cesta');
define('FS_SHOP_CART_ALERT_JS_54','( impuestos y costos de envío excluidos )');
define('FS_SHOP_CART_ALERT_JS_55','Su nombre');
define('FS_SHOP_CART_ALERT_JS_55_1','Nombre del recipiente');
define('FS_SHOP_CART_ALERT_JS_56','Tu email');
define ('FS_SHOP_CART_ALERT_JS_56_1', "Separa los diferentes destinatarios con punto y coma ';'");
define('FS_SHOP_CART_ALERT_JS_57','Se permite un máximo de 500 caracteres.');
define('FS_SHOP_CART_ALERT_JS_58','Cesta guardada');
define('FS_SHOP_CART_ALERT_JS_59','Su pedido califica para el envío GRATIS ');
define('FS_SHOP_CART_ALERT_JS_60','Entregar a');
define('FS_SHOP_CART_ALERT_JS_61','Para todos los pedidos superiores a US$ 79 de artículos elegibles en cualquier categoría de producto se aplican el servicio de envío GRATIS.');
define('FS_SHOP_CART_ALERT_JS_61_MX','Para todos los pedidos superiores a MXN $1600 de artículos elegibles en cualquier categoría de producto se aplican el servicio de envío GRATIS.');
define('FS_SHOP_CART_ALERT_JS_62','Para calificar para envío GRATIS, agregue ');
define('FS_SHOP_CART_ALERT_JS_63',' los artículos elegibles. ');
define('FS_SHOP_CART_ALERT_JS_64','Su pedido califica para envío GRATUITO');
define('FS_SHOP_CART_ALERT_JS_65','Para todos los pedidos superiores a €79 de artículos elegibles en cualquier categoría de producto se aplican el servicio de envío GRATUITO.');
define('FS_SHOP_CART_ALERT_JS_66','Para todos los pedidos superiores a £79 de artículos elegibles en cualquier categoría de producto se aplican el servicio de envío GRATUITO.');
define('FS_SHOP_CART_ALERT_JS_67','Para todos los pedidos superiores a €79 de artículos elegibles en cualquier categoría de producto se aplican el servicio de envío GRATIS.');
define('FS_SHOP_CART_ALERT_JS_68','Para todos los pedidos superiores a £79 de artículos elegibles en cualquier categoría de producto se aplican el servicio de envío GRATIS.');
define('FS_SHOP_CART_ALERT_JS_69','Pago seguro');
define('FS_SHOP_CART_ALERT_JS_70','Empieza a comprar');
define('FS_SHOP_CART_ALERT_JS_71','Para todos los pedidos superiores a AUD$79 de artículos elegibles en cualquier categoría de producto se aplican el servicio de envío GRATUITO.');
define('FS_SHOP_CART_ALERT_JS_72','Guardar la cesta');
define('FS_SHOP_CART_ALERT_JS_72_1','Guardar la cesta');
define('FS_SHOP_CART_ALERT_JS_73','Compartir por email');
define('FS_SHOP_CART_ALERT_JS_74','Imprimir');
define("FS_SHOP_CART_ALERT_JS_76_1","Enviar email");
define("FS_SHOP_CART_ALERT_JS_77","Ver la cesta");
define("FS_AJAX_DELETE1","ha sido eliminado con éxito de tu cesta.");
define("FS_AJAX_DELETE2"," Recuperar");
define('FS_SHOP_CART_WAS_ACCOUNT','Fue');
define('FS_CART_ITEM','Artículo)');
define('FS_CART_ITEMS','Artículos)');
define('FS_SHOP_CART_ALERT_JS_43_1','Correo electrónico');

define('FS_TOTAL_SAVINGS','Ahorró');

//2018-8-29  credit付款页面
define('FS_CREDIT_CARD_NUMBER','Número de tarjeta');
define('FS_CREDIT_EXPIRY_DATE',"Fecha límite");
define('FS_CREDIT_CONTINUE','Continuar');

define("FIBERSTORE_PRODUCTS","productos");
define("FIBERSTORE_PRODUCT","producto");
define("FIBERSTORE_RESULTS_BY01","Ordenar por:");
define("FIBERSTORE_RESULTS_VIEW","Leer:");
define("FS_FESTIVAL8","FS.COM estará de vuelta");
define("FS_FESTIVAL9","th");
define("FS_FESTIVAL10","rd");
define('FS_CHOOSE_LENGTH','Longitud');
define('FS_LENGTH_NAME','Longitud');
define('FS_OPTION_NAME','Número de modelo');
define("FS_PRODUCTS_SHIPPING_CHANGE17","Enviar");

//add by helun
define('FS_AGAINST_BPAY_01','Fecha de pedido:');
define('FS_AGAINST_BPAY_02','Precio total:');
define('FS_AGAINST_BPAY_03','Su compra se ha dividido en');
define('FS_AGAINST_BPAY_04','pedidos.');
define('FS_AGAINST_BPAY_05','Entrega estimada');
define('FS_AGAINST_BPAY_06','Enviar desde');
define('FS_AGAINST_BPAY_07','Pedido');
define('FS_AGAINST_BPAY_08','de');
define('FS_AGAINST_BPAY_09','Proceder a ');
define('FS_AGAINST_BPAY_10','Sparkasse Freising');
define('FS_AGAINST_BPAY_11','FS.COM GmbH');
define('FS_AGAINST_BPAY_12','DE16 7005 1003 0025 6748 88');
define('FS_AGAINST_BPAY_13','BYLADEM1FSI');
define('FS_AGAINST_BPAY_14','25674888');
define('FS_AGAINST_BPAY_15','Untere Hauptstr.29, 85354, Freising');
define('FS_AGAINST_BPAY_16','817-888472-838');
define('FS_AGAINST_BPAY_17','HSBCHKHHHKH');

define("FS_COMMON_CHECKOUT_HSBC","Generalmente recibimos los pagos entre 1 y 3 días hábiles. Procesaremos tu pedido una vez se confirme la transferencia.");
define("FS_WAREHOUSE_SEA","Almacén de Seattle");
define("FS_WAREHOUSE_DEL","Almacén de Delaware");
define("FS_WAREHOUSE_AREA_36","Enviar desde el almacén de Seattle");
define("FS_WAREHOUSE_AREA_37","Enviar desde el almacén de Delaware");
define("FS_LIVE_CHAT_CHECKOUT","Obtén ayuda para comprar.  <a  href='javascript:;' onclick='LC_API.open_chat_window();return false;'>Chatea en línea con nosotros,</a>  o llámanos");

//2018-8-31   shoppint_cart 页面分享
define('FS_SHARE_AGAIN','Compartir otra vez');
define('HEADER_TITLE_CLEARANCE','Gran Promoción');

/*
 * 产品详情页 客户分享产品邮件
 */
define('FS_EMAIL_PRODUCT_SHARE1','Su amigo sólo comparte este artículo con usted a través de ');
define('FS_EMAIL_PRODUCT_SHARE2','FS.COM.');
define('FS_EMAIL_PRODUCT_SHARE3','Pensé que podría interesarse por esta página de ');
define('FS_EMAIL_PRODUCT_SHARE4','Leer más');
define('FS_EMAIL_PRODUCT_SHARE5','Sinceramente,');
define('FS_EMAIL_PRODUCT_SHARE6','FS.COM');
define('FS_EMAIL_PRODUCT_SHARE7',' Equipo de servicio al cliente ');
define('FS_EMAIL_PRODUCT_SHARE8','Este correo electrónico fue enviado por ');
define('FS_EMAIL_PRODUCT_SHARE9','utilizando el servicio Compartir Con Un Amigo de . Como resultado de recibir este mensaje, no recibirá ningún mensaje no solicitado de ');
define('FS_EMAIL_PRODUCT_SHARE10',zen_href_link('index'));
define('FS_EMAIL_SHARE_TITLE_ONE','FS.COM - Su amigo ');
define('FS_EMAIL_SHARE_TITLE_TWO',' quiere que usted vea este artículo.');
define('FS_EMAIL_PRODUCT_SHARE11','Mensaje de ');
define('FS_EMAIL_PRODUCT_SHARE13',',learn more about our ');
define('FS_EMAIL_POLICY_2',"");
define('FS_EMAIL_PRODUCT_USING',' using ');

//站点融合整理 邮件标点符号整理成常量
define('FS_EMAIL_COMMA',',');   //逗号
define('FS_EMAIL_POINT','.'); //句号
define('FS_EMAIL_PERIOD','.');
define('FS_EMAIL_MARK','!');//感叹号
define('FS_EMAIL_PAUSE',',&nbsp;');  //日语中的逗号有时是顿号，其他语种是逗号

define("FS_WAREHOUSE_AREA_35",'?Gracias por su pedido de compra! Aquí están los detalles de su pedido.</br>Nota: El importe del pedido excede su límite de crédito en FS.COM. Para que este pedido se procese rápidamente, pague los pedidos anteriores para girar el límite de crédito, o puede ir a "Mi cuenta" y hacer clic en "Pedido de compra" para solicitar el aumento de su límite de crédito. Le enviaremos el resultado después de revisarlo.');
//产品详情页加入购物车后弹出框
define('FS_CUSTOMERS_ALSO','Los clientes también compraron estos productos.');

//au单独的RMA地址
define('FIBER_CHECK_ANZ','Cuenta bancaria de ANZ:');
define('FIBER_CHECK_ACCOUNT','Nombre del beneficiario:');
define('FIBER_CHECK_PTY','FS.COM Pty Ltd');
define('FIBER_CHECK_BSB','BSB:');
define('FIBER_CHECK_013','013160');
define('FIBER_CHECK_ACCOUNT_NO','Número de cuenta:');
define('FIBER_CHECK_4167','416794959');
define('FIBER_CHECK_SWIFT_CODE','Código SWIFT:');
define('FIBER_CHECK_ANZBAU3M','ANZBAU3M');
define('FIBER_CHECK_BANK','Dirección del banco beneficiario:');
define('FIBER_CHECK_ST_VIC','230 Swanston St, Melbourne, VIC, 3000');
define('FIBER_CHECK_TITLE_AU','To pay via direct deposit, please use the following bank account information:');


define("FS_PICK_UP_AT_WAREHOUSE","Recoger en el almacén ");
define("FS_TIME_ZONE_RULE_US_ES"," (ET)");
define("FS_TIME_ZONE_ADDRESS_US","<span>Ubicación del almacén:</span> 820 SW 34th Street Bldg W7 Suite H Renton, WA 98057, United States | +1 (877) 205 5306 ");
define("FS_TIME_ZONE_ADDRESS_DE","<span>Ubicación del almacén:</span> NOVA Gewerbepark Building 7, Am Gfild 7, 85375 Neufahrn Germany | +49 (0) 8165 80 90 517 ");
define("FS_TIME_ZONE_ADDRESS_US_ES","<span>Ubicación del almacén:</span> 380 Centerpoint Blvd, New Castle, DE 19720, United States | +1 (425) 326 8461 ");



//产品详情页加入购物车后弹出框
define('FS_CONTINUE_SHOPPING','Seguir comprando');
//产品详情页产品加入购物车后的弹出框信息
define('FS_JUST_ADDED','Usted acaba de añadir ');
define('FS_JUST_ITEM',' artículo(s)');
define('FS_JUST_ITEMS',' artículo(s)');
define('FS_CART_QTY','Cant:');
define('FS_SHOPPING_CART_NEW_SHARE_CART', 'Compartir la cesta');
define('FS_SHOPPING_CART_NEW_PRINT_CART', 'Imprimir la cesta');

//hsbc
define('FS_SUCCESS_YOUR_NEXT','El próximo paso es completar tu pago de transferencia bancaria y enviar los datos de pago.');
define('FS_SUCCESS_WIRE','Transferencia bancaria');
define('FS_SUCCESS_ORDER','Imprimir el pedido');
define('FS_SUCCESS_DETAIL','Detalles del beneficiario de transferencia bancaria');
define('FS_SUCCESS_BANK_NAME','Banco beneficiario:');
define('FS_SUCCESS_HSBC','HSBC Hong Kong');
define('FS_SUCCESS_AC_NAME','Nombre del beneficiario:');
define('FS_SUCCESS_CO','FS.COM LIMITED');
define('FS_SUCCESS_AC_NO','Número de cuenta:');
define('FS_SUCCESS_TEL','817-888472-838');
define('FS_SUCCESS_SWIFT','Código SWIFT:');
define('FS_SUCCESS_HK','HSBCHKHHHKH');
define('FS_SUCCESS_BANK_ADRESS','Dirección del banco:');
define('FS_SUCCESS_ROAD','1 Queen\'s Road Central, Hong Kong');
//UK
define('FIBERSTORE_INFO_WIRE_DE','Cuenta bancaria de Sparkasse');
define('FIBER_CHECK_ANZ_UK','HSBC Bank Account');
define('FS_SUCCESS_BANK_NAME_UK','Beneficiary Bank Name');
define('FS_SUCCESS_HSBC_UK','HSBC Hong Kong');
define('FS_SUCCESS_AC_NAME_UK','Beneficiary A/C Name');
define('FS_SUCCESS_CO_UK','FS.COM LIMITED');
define('FS_SUCCESS_AC_NO_UK','Beneficiary A/C NO');
define('FS_SUCCESS_TEL_UK','817-888472-838');
define('FS_SUCCESS_SWIFT_UK','SWIFT Address');
define('FS_SUCCESS_HK_UK','HSBCHKHHHKH');
define('FS_SUCCESS_BANK_ADRESS_UK','Beneficiary Bank Address');
define('FS_SUCCESS_ROAD_UK','1 Queen\'s Road Central, Hong Kong');
define('FS_SUCCESS_OUR','Dirección de Nuestra Empresa');
define('FS_SUCCESS_NO','Eastern Side, Second Floor, Science &amp; Technology Park, No.6, Keyuan Road, Nanshan District, Shenzhen, China');

//2018-9-15  add  ery  游客结算页面账号已存在提示语
define('FS_CHECKOUT_GUEST_LOG_MSG','Este email ya está registrado. Inicie sesión directamente.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    <a href="'.zen_href_link('login').'">Iniciar sesión »</a>');
//产品详情货币单位
define('FS_PRODUCT_PRICE_EA','/unidad');
//产品详情页 选择产品属性
define('PLEASE_SELECT', 'Please select ...');

//2018-9-11
define('EMAIL_OVER79_FREE_DELIVERY','<tr><td style="font-size:12px;font-weight: 400;padding-top: 35px;">Los pedidos de artículos elegibles superiores a %s pueden disfrutar de envío gratis. Espero verle de nuevo.</td></tr>');
define('FS_TRACK_ORDER','Puede seguir el estado de su pedido haciendo clic en ');
define('FS_TRACK_MY_ORDERS','Mis pedidos');
define('FS_ORDER_COMMENTS','Comentarios del pedido: ');
define('FS_TRACK_PO_ORDER','Puede seguir su estado en el ');
define('FS_TRACK_ACCOUNT_CENTER','centro de cuenta');
//推荐版块
define('FS_PRODUCT_RELATED','Productos a juego');

//print_order & print_main_order
define('FS_PRINT_ORDER_TEL','Teléfono : ');
define('FS_PRINT_ORDER_NUM','Número de IVA: ');
define('FS_PRINT_ORDER_CREDIT','Tarjeta de crédito/débito');
define('FS_PRINT_ORDER_PURCHASE','Orden de compra');
define('FS_PRINT_ORDER_BANK','Transferencia bancaria');
define('FS_PRINT_ORDER_WESTERN','Western Union');
define('FS_PAY_WAY_PAYPAL','Paypal');
define('FS_PAY_WAY_PAYEEZY','payeezy');
define("FS_CHECKOUT_NEW42", "Electronic Check ");
define('FS_PRINT_ORDER_FREE','Gratis');

/**
 *评论邮件
 */
define('FS_EMAIL_TO_US_DEAR','Hola ');
define('EMAIL_MESSAGE_TITLE_REVIEWS',' Feedback recibido');
define('FS_PRODUCT_REVIEW_SUBJECT_TITLE','FS - Gracias por tu feedback');
define('FS_EMAIL_REVIEWS_WELL_CONTENT','Te agradecemos por tus amables palabras. Y nos alegramos que tuviste una experiencia tan excelente al interactuar con nuestro equipo.');
define('FS_EMAIL_REVIEWS_WELL_FEEDBACK','Tu feedback nos ayudará a mejorar constantemente la experiencia de compra de nuestros clientes, y nos deja saber lo que hecemos bien, y en qué tenemos que esforzarnos más.');
define('FS_EMAIL_REVIEWS_BAD_CONTENT','Lamentamos que tu experiencia no cumplió tus expectativas. Fue un caso poco común, y lo haremos mejor.');
define('FS_EMAIL_REVIEWS_BAD_FEEDBACK','Tu gerente de cuente se pondrá en contacto contigo dentro de 48 horas. Esperamos sinceramente trabajar contigo para resolver el problema lo más rápido posible.');
define('FS_EMAIL_REVIEWS_THANKS','Gracias');
define('FS_EMAIL_REVIEWS_TEAM','Equipo FS');
define('FS_EMAIL_REVIEWS_WELL_HEADER','Gracias por tu comentario. Seguiremos ofreciéndote los mejores productos y servicios.');
define('FS_EMAIL_REVIEWS_BAD_HEADER','Gracias por tu comentario. Te ayudaremos a resolver el problema lo antes posible.');

//客户取消订单邮件
define('FS_CANCEL_ORDER',"Tu pedido #");
define('FS_CANCEL_ORDER_1',"ha sido cancelado");
define('FS_CANCEL_ORDER_2',"Como solicita usted, ya cancelamos su pedido reservado# ");
define('FS_CANCEL_ORDER_3',". Lamentamos que no funcionó y esperamos que vuelva a comprar con nosotros pronto.");
define('FS_CANCEL_ORDER_4',"Si tiene alguna pregunta, por favor <a href='contact_us.html'>contáctenos</a>. ¡Esperamos verle de nuevo pronto!");
define('FS_CANCEL_ORDER_5',"Dirección de email del cliente:");
define('FS_CANCEL_ORDER_6',"Número de pedido: ");
define('FS_CANCEL_ORDER_7',"Razón:");
define('FS_CANCEL_ORDER_8','Pedido# ');

//live chat留言邮件
define('FS_LIVE_CHAT_MAIL','Gracias por contactarse con <a href="'.zen_href_link('index','','SSL').'">FS.COM</a>, este es un correo electrónico de confirmación para informarle de que su solicitud de asistencia ha sido recibida. Revisaremos su mensaje y le responderemos dentro de 12 horas.');
define('FS_LIVE_CHAT_MAIL_1','FS.COM-Confirmación de correo electrónico ');
define('FS_LIVE_CHAT_MAIL_2','Su tipo de servicio:');
define('FS_LIVE_CHAT_MAIL_3','Su mensaje:');

//专题页面加购弹窗语言包翻译
define('FS_SUPPORT_ADD','Añadir...');
define('FS_SUPPORT_ADDED','Añadido');
define("FS_OVERNIGHT_TITLE","Si recibimos tu pago después de la hora límite (5:00pm EST), tu pedido se enviará el siguiente día hábil. La entrega se realiza solo en días hábiles.");
define("FS_OVERNIGHT_TITLE_UP","Si recibimos tu pago después de la hora límite (5:00pm EST), tu pedido se enviará el siguiente día hábil. La entrega se realiza solo en días hábiles.");

define("FS_ECHECK_NOTICE","* Sólo aceptamos los cheques electrónicos emitidos por los bancos estadounidenses. Y necesitaremos 1-2 días hábiles para procesar tu pago.");
define("FS_ECHECK_BANK_ACCOUNT","Nombre de la cuenta bancaria");
define("FS_ECHECK_BANK_ACCOUNT_NUMBER","Número de la cuenta bancaria");
define("FS_ECHECK_BANK_ACCOUNT_TYPE","Tipo de cuenta");
define("FS_ECHECK_BANK_ACCOUNT_CHECK","Verificando");
define("FS_ECHECK_BANK_ACCOUNT_SAVE","Guardando");
define("FS_ECHECK_BANK_ACCOUNT_CONFIRM","Confirmar número de la cuenta bancaria");
define("FS_ECHECK_BANK_ACCOUNT_ROUTE","Número de ruta ABA/ACH");
define("FS_ECHECK_ERROR_1","Se requiere el nombre de la cuenta bancaria.");
define("FS_ECHECK_ERROR_2","Se requiere el número de cuenta bancaria.");
define("FS_ECHECK_ERROR_3","Se requiere el tipo de cuenta.");
define("FS_ECHECK_ERROR_4","Se requiere confirmar el número de cuenta bancaria.");
define("FS_ECHECK_ERROR_5","Se requiere el número de ruta ABA/ACH.");

define("CHECKOUT_TAX_NZ_CONTENT","Para los pedidos enviados a destinos fuera de Australia, FS.COM solo cobrará la tarifa de los artículos y del envío. Sin embargo, según las leyes de los países de destino, estos paquetes pueden cobrarse tarifas de importación o de aduana.<br/><br/> Los derechos de aduanas o importación se cobrarán una vez que el paquete llega al país de destino. Los costos adicionales del despacho de aduanas deben ser a cargo de usted.");
define("FS_TIME_ZONE_ADDRESS_AU","<span>Almacén de Melbourne de FS:</span> 57-59 Edison Rd, Dandenong South, VIC 3175, Australia | +61 3 9693 3488 ");
define('FS_PURCHASE_NUMBER','El número de PO');


//购物车分享相关 移动到公共语言包部分
define('FS_SHOP_CART_ALERT_JS_43','Se requiere tu nombre.');
define('FS_SHOP_CART_ALERT_JS_43_01',"Se requiere el nombre del recipiente.");
define('FS_SHOP_CART_ALERT_JS_44','Se requiere tu email.');
define('FS_SHOP_CART_ALERT_JS_44_01',"Se requiere el email del destinatario.");
define('FS_SHOP_CART_ALERT_JS_45','Por favor, ingresa una dirección de correo electrónico válida.');
define('FS_SHOP_CART_ALERT_JS_46','Enviar al gerente de cuenta');
//移动到公共文件 checkout,ccheckout_guest,邮件共用
define("FS_CHECKOUT_NEW31","PayPal");
define("FS_CHECKOUT_NEW32","Tarjeta de crédito/debito");
define("FS_CHECKOUT_NEW33","Transferencia bancaria");
define("FS_CHECKOUT_NEW34","Crédito comercial");
define("FS_CHECKOUT_NEW35"," BPAY");
define("FS_CHECKOUT_NEW36"," eNETS");
define("FS_CHECKOUT_NEW37","YANDEX");
define("FS_CHECKOUT_NEW38","WEBMONEY");
define("FS_CHECKOUT_NEW39","iDEAL");
define("FS_CHECKOUT_NEW40","SOFORT");
//第三方登录提示语
define("REDIRECT_DEAR","Estimado ");
define("REDIRECT_USER"," usuario ");
define("REDIRECT_WELCOME"," bienvenido");
define("REDIRECT_NOTICE","Usted ha creado una cuenta de FS con esta dirección <br>de correo electrónico. Para que le ofrezcamos una mejor experiencia sobre la administración de cuenta, por favor, inicie sesión <br>con su cuenta de FS. Si no conoce esta cuenta, póngase en contacto con nosotros.");
define("REDIRECT_ACCOUNT","Redirigir en ");

// 税号模板 start
//新增结账税号验证
define("FS_CHECKOUT_VAX_CH","Por favor ingresa un número de CIF/VAT válido, p.ej: 00.000.000-0.");
define("FS_CHECKOUT_VAX_AR","Por favor ingrese un número de CIF/VAT válido, p.ej: 00-00000000-0.");
define("FS_CHECKOUT_VAX_BR_BS","Por favor ingrese un número de CIF/VAT válido, p.ej: 000.000.000/00.");
define("FS_CHECKOUT_VAX_BR_IN","Por favor ingrese un número de CIF/VAT válido, p.ej: 000.000.000/00.");
define("FS_TAXT_TITLE_NOTICE","Su pedido puede estar exento del impuesto sobre el IVA al proporcionar un número de VAT correcto y válido.");
define("FS_TAXT_TITLE_NOTICE_OTHER","Para acelerar la aclaración de aduana, ingresa un número de identificaón fiscal válido.");
// 税号模块 end

define("FS_LOGIN_POPUP7","¿Olvidas la contraseña?");

//manage_orders
define('FS_MANAGE_ORDERS_PUR','Номер заказа на покупку');

define("FS_NO_FREE_SHIPPING_US_HEAVY","Los pedidos que contienen artículos pesados o grandes no pueden disfrutar del envío gratis.");
define("FS_NO_FREE_SHIPPING_DEAU_HEAVY","Los pedidos que contienen artículos pesados o grandes no pueden disfrutar del envío gratis.");
define("FS_NO_FREE_SHIPPING_AU_REMOTE","Debido a que este pedido se entrega a un distrito remoto, se generará un costo de envío.");

//产品详情404
define('FS_404_HOT_PRODUCTS','Productos bien vendidios');
define('SEARCH_OFFINE_1','Lo sentimos, este artículo ya no está disponible en línea.');
define('SEARCH_OFFINE_2','Puede obtener una cotización por hacer consultas fuera de línea.');
define('SEARCH_OFFINE_3','obtener una cotización');
define('SEARCH_OFFINE_4','¿Necesita más ayuda? Visite ');
define('SEARCH_OFFINE_5','Centro de ayuda');
define('SEARCH_OFFINE_6',' para obtener más asistencia.');
define('SEARCH_OFFINE_7','Esta página web no está disponible.');
define('SEARCH_OFFINE_8','Esto puede ser debibo a que:');
define('SEARCH_OFFINE_9','La página web ha sido movida a otra dirección.');
define('SEARCH_OFFINE_10','La dirección web es incorrecta.');
define('SEARCH_OFFINE_11','Comprueba la dirección web (URL), o vuelve al <a href="'.zen_href_link(FILENAME_DEFAULT,'','NONSSL').'">inicio</a>.');
define('SEARCH_OFFINE_12','página principal.');
define('FS_OUTDATED_LINK','El enlace que te trae aquí es obsoleto.');

//faq问题汇总
define('FS_FAQ_HELPFUL_01',"¿Te resulta útil esta respuesta?");
define('FS_FAQ_HELPFUL_02',"Sí");
define('FS_FAQ_HELPFUL_03',"No");
define('FS_FAQ_HELPFUL_04',"¡Gracias por su comentario!");
define('FS_FAQ_HELPFUL_05',"¿En qué podemos mejorarnos?");
define('FS_FAQ_HELPFUL_06',"Esto ha sido confuso");
define('FS_FAQ_HELPFUL_07',"Esto no ha respondido mi pregunta");
define('FS_FAQ_HELPFUL_08',"No me gusta su política");
define('FS_FAQ_HELPFUL_09',"Enviar");


//产品详情页新增弹窗语言包
define("FS_PRODUCTS_REORDERING","Reordering");
define("FS_FOR_FREE_SHIPPING_GET_AROUND","Get it around");
define("FS_CHOOSE_LOCATION","Selecciona tu dirección");
define("FS_DELIVERY_OPTION","Las opciones de servicio de envío y los plazos de entrega varían de acuerdo con diferentes direcciones.");
define("FS_SHIP_OUTSIDE","Enviar fuera");
define("FS_SHIP_CONTINUE_SEE","Puedes consultar los costos de envío y la fecha de entrega en la página de pago.");
define("FS_SHIP_DONE","Listo");
define("FS_REDIRECT_PART1","Continuar comprando en ");
define("FS_REDIRECT_PART2"," y consultar el contenido específico con precio local y entrega?");
define("FS_SHIP_TO","Enviar a");
define("FS_SHIP_CHANGE","Cambiar");
define("FS_SHIP_OR","o");
define("FS_SHIP_OR_OTHER","o elegir otro país");
define("FS_SHIP_ENTER","o ingresar a ");
define("FS_SHIP_ZIP_CODE"," código postal");
define("FS_SHIP_APPLY"," Aplicar");
define("FS_SHIP_ADD_NEW_ADDRESS","Añadir una nueva dirección");
define("FS_SHIP_SIGN_IN",'<a href="'.zen_href_link("login","","SSL").'"> Inicia sesión</a> para ver tus direcciones.');
define("FS_SHIP_MANAGE","Gestiona tu libreta de direcciones");
define("FS_SHIP_TODAY","Se enviará hoy");
define("FS_SHIP_GET_TODAY","recíbelo al final de hoy.");
define("FS_PRODUCTS_POST_CODE_EMPTY_INVALID","Por favor ingrese un código postal válido");
define('FS_PRODUCTS_CUSTOMIZE','Personalizar');

define("FS_SHIP_LIST_COUNTRY","País/Región");
define("FS_SHIP_LIST_POST","Código postal");
define("FS_SHIP_DELIVEY_TO","Enviar a");

define("FS_CN_HUBEI","Wuhan, Hubei");
define("FS_CN_APAC","almacén Asia");
define("FS_DE_MUNICH","Munich, baviera");
define("FS_AU_VIC","Melbourne, Victoria");
define("FS_US_WA","Washington/Delaware");
//define("FS_FOR_FREE_SHIPPING_GET_ARRIVE","Recíbelo para el");
define("FS_FOR_FREE_SHIPPING_GET_ARRIVE","Recibe tu pedido el");
define("FS_APAC_NOTICE","El almacén de FS de Asia ofrece envíos globales rápidos en el mismo día a Sudamérica, África, Asia Pacífico y otras áreas. <a  target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leer más</a>");
define("FS_US_NOTICE","Nuestro almacén en EE.UU. ubicado en Delaware ofrece el servicio de envío el mismo día. <a  target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leer más</a>");
define("FS_US_UP_NOTICE","Los almacenes de de FS en EE.UU., ubicados en Seattle y Delaware respectivamente, soprtan los envíos nacionales en el mismo día dentro de Estados Unidos contiguos, Alaska, Hawaii, direcciones militares APO/FPO y Puerto Rico, etc, y los envíos internacionales a Canadá, México.  <a  target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leer más</a>");
define("FS_US_OTHER_NOTICE","Los almacenes de FS en EE.UU., ubicados en Seattle y Delaware respectivamente, soportan los envíos rápidos en el mismo día a Estados Unidos, Canadá y México.  <a  target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leer más</a>");
define("FS_US_UP_OTHER_NOTICE","Los almacenes de FS en EE.UU., ubicados en Seattle y Delaware respectivamente, soportan los envíos rápidos en el mismo día a Estados Unidos, Canadá y México.  <a  target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leer más</a>");
define("FS_DE_NOTICE","FS almacén en DE ubicado en Munich ofrece el servicio de envío rápido. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leer más</a>");
define("FS_DE_OTHER_NOTICE","El almacén de FS en DE, ubicado en Munich, Baviera, soporta los envíos globales a Reino Unido, UE y otros países europeos. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leer más</a>");
define("FS_AU_OTHER_NOTICE","El almacén de FS en AU, ubicado en Melbourne, Victoria, soporta los envíos nacionales rápidos en el mismo día dentro de Australia y envíos internacionales a Nueva Zelanda.");
define("FS_NZ_OTHER_NOTICE","El almacén de FS en AU, ubicado en Melbourne, Victoria, soporta los envíos rápidos en el mismo día a Nueva Zelanda. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leer más</a>");
define("FS_CN_NOTICE","Nuestro almacén en Asia ofrece el servicio de envío el mismo día. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leer más</a>");

//dylan 2019.8.28 add
define('FS_CUSTOM_NOTICE',"Los artículos se enviarán una vez preparados. Habría un plazo de fabricación. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leer más</a>");
define('FS_INSTOCK_NOTICE',"<p class='pro_font_w'>Disponible, en tránsito</p> Los artículos están en camino a nuestro almacén y se enviarán una vez que lleguen. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leer más</a>");
define('FS_TRANSIT_NOTICE',"<p class='pro_font_w'>Disponible, necesita tránsito</p> Los artículos serán enviados una vez preparados. Habría un plazo de fabricación. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leer más</a>");
define('FS_AU_NOTICE',"Nuestro almacén de Australia ubicado en Melbourne, ofrece el servicio de envío el mismo día. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leer más</a>");
define('FS_BUCK_NOTICE',"Los artículos pesados ​​o de gran tamaño se enviarán desde nuestro almacén en Asia.");
define('FS_SG_NOTICE',"Nuestro almacén ubicado en Singapur ofrece el servicio de envío el mismo día. <a target='_blank' href='".zen_href_link("shipping_delivery","","SSL")."'>Leer más</a>");
define('FS_RU_NOTICE',"FS almacén en RU ubicado en Moscú ofrece el servicio de envío rápido al mismo día. <a target='_blank' href='".zen_href_link("shipping_delivery","","SSL")."'>Leer más</a>");

//add by quest 2019-03-08
define("FS_NO_QTY_NOTICE","Los artículos se aceleran para transitar desde el almacén global.");
define("FS_NO_QTY_TAG_NOTICE","Los artículos se están preparando para el tránsito desde el almacén global.");
define("FS_NO_QTY_TAG_NOTICE_NEW","Los artículos se están preparando para el tránsito desde el almacén en Asia.");
define("FS_NO_QTY_NOTICE_NEW","Estos artículos se transportan desde el almacén en Asia.");

define("FS_SURBSTREET_MAXLENGTH_ERROR","La línea 2 de la dirección no debe contener más de 35 caracteres.");
define("FS_TELEPHONE_MAXLENGTH_ERROR","El número de teléfono no debe contener más de 15 caracteres.");
define("FS_COMPANY_MAXLENGTH_ERROR","El nombre de la empresa debe tener entre 1 y 100 caracteres.");
define("FS_FIRSTNAME_MAXLENGTH_ERROR","El nombre no debe contener más de 35 caracteres.");
define("FS_LASTNAME_MAXLENGTH_ERROR","El apellido no debe contener más de 35 caracteres.");
define("FS_CHECKOUT_ERROR12","La línea 1 de dirección  debe contener entre 4 y 300 caracteres.");
define("FS_PRODUCTS_POST_CODE_EMPTY_ERROR","Se requiere tu código postal.");
define('FAIL_TO_OPEN_SOURCE','Error al abrir la imagen');
define('FAIL_TO_CONNECT_FTP','Error al conectar el servidor');
//超时取消订单
define('MANAGE_ORDER_RESTORE_1','Cerrará en Oh.');
define('MANAGE_ORDER_RESTORE_2','Cerrará en. ');
define('MANAGE_ORDER_RESTORE_3','Por favor complete el pago en 30 minutos, de lo contrario, el pedido se cancelará automáticamente debido al cambio de inventario de artículos.');
define('MANAGE_ORDER_RESTORE_4','Comprar otra vez');
define('MANAGE_ORDER_RESTORE_5','Suba el archivo de su pedido de compra en 7 días; de lo contrario, el pedido se cancelará automáticamente debido al cambio de inventario de artículos.');
define('MANAGE_ORDER_RESTORE_6','Por favor complete el pago en 2 días; de lo contrario, el pedido se cancelará automáticamente debido al cambio de inventario de artículos.');
define('MANAGE_ORDER_RESTORE_7','Por favor complete el pago en 7 días; de lo contrario, el pedido se cancelará automáticamente debido al cambio de inventario de artículos.');
define("FS_INQUIRY_CANCELED",'Cancelado');
define("FS_INQUIRY_SUBMITED",'Presentada');
define("FS_INQUIRY_QUOTED",'Cotizada');
define("FS_INQUIRY_DEALED",'Gestionado');
define("FS_INQUIRY_REVIEWING",'En proceso');

// 个人中心详情页面
define("FS_INQUIRY_SUBTOTAL",'Subtotal');
define("FS_INQUIRY_CHECKOUT",'Comprar');
define("FS_INQUIRY_ADD_FILE",'Agregar un archivo');
define("FS_INQUIRY_CANCEL_SUCCESS",'Cancelar con éxito');
define("FS_NOTES",'Nota');

// 个人中心列表页面
define("FS_INQUIRY_TOTAL_QUOTE_NUMBER",'QUOTE_NUMBER solicitudes totales para cotización');
define("FS_INQUIRY_ONE_TOTAL_QUOTE_NUMBER",'QUOTE_NUMBER solicitud total para cotización');
define("FS_INQUIRY_VIEW",'Ver');
define("FS_INQUIRY_CANCEL_THIS_QUOTE",'¿Cancelar la cotización?');
define("FS_INQUIRY_CANCEL_QUOTE_TIP1",'Una vez que lo haga, no podrá ser recuperado.');
define("FS_INQUIRY_CANCEL_QUOTE_TIP2",'Sin embargo, si realmente lo quiere hacer, por favor, nos proporciona un motivo(s) para cancelar.: ');
define("FS_INQUIRY_CANCEL_REASON1",'Ha comprado de otros');
define("FS_INQUIRY_CANCEL_REASON2",'Cotización duplicada');
define("FS_INQUIRY_CANCEL_REASON3",'No es el producto que necesito');
define("FS_INQUIRY_CANCEL_REASON4",'Problema de garantía');
define("FS_INQUIRY_CANCEL_REASON5",'Largo tiempo de entregar');
define("FS_INQUIRY_CANCEL_REASON6",'Muy caro');
define("FS_INQUIRY_CANCEL_REASON7",'No es necesario');
define("FS_INQUIRY_CANCEL_REQUIRED_TIP",'Antes de enviar, complete los motivos para cancelar la cotización.');
define('FS_INQUIRY_EMPTY_PAGE_TIP','No hay una solicitud de cotización todavía. Obtenga una cotización en la página del producto.');
define('FS_INQUIRY_LIST_TIP','Verifique el estado de sus cotizaciones y compre directamente con los precios preferenciales.');
define('FS_CANCEL_QUOTE','Cancelar la cotización');

define("FS_FORWARD_SHIPPING","Agente de transporte (con aranceles e impuestos prepagados)");
define("FS_FORWARD_SHIPPING_NOTICE","Este precio incluye los costos de envío y los posibles tarifas e impuestos de aduana. Se cobrará también un seguro necesario, que se muestra en el resumen del pedido, calculado de acuerdo con el precio subtotal de los productos.");
define('FS_CHECK_OUT_INSURANCE','Seguro');
//产品详情页产品树收起提示语
define('FS_COMMON_CLOSE','Cerrar');
define('FS_COMMON_FS_PN', 'FS P/N: ');


//新版邮件
define("SEND_MAIL_1","Entrega GRATIS más de £79");
define("SEND_MAIL_2","Fiberstore Ltd, Part 7th Floor, 45 CHURCH STREET, Birmingham, B3 2RT");
define("SEND_MAIL_3","Entrega GRATIS más de $79");
define("SEND_MAIL_4","<a href='".zen_href_link('index')."' style='text-decoration:none;color: #232323;'>FS.COM</a> INC, 380 CENTERPOINT BLVD, NEW CASTLE, DE 19720");
define("SEND_MAIL_5","Envío GRATIS más de €79");
define("SEND_MAIL_6","GmbH, NOVA Gewerbepark, Building 7, Am Gfild 7, 85375 Neufahrn, Germany");
define("SEND_MAIL_7","Entrega GRATIS más de A$99");
define("SEND_MAIL_8","<a href='".zen_href_link('index')."' style='text-decoration:none;color: #232323;'>FS.COM</a> Pty Ltd, ABN 71 620 545 502,57-59 Edison Rd, Dandenong South, VIC 3175, Australia");
define("SEND_MAIL_9","Envío el Mismo Día para Artículos en Stock");
define("SEND_MAIL_10","<a href='".zen_href_link('index')."' style='text-decoration:none;color: #232323;'>FS.COM</a> Limited Room 2702, 27 Floor Yisibo Software Building, Haitian Second Road, Yuehai Street Nanshan District, Shenzhen, 518054, China");
//Postbank账户
define('FIBER_CHECK_COMMON_ACCOUNT','Número de cuenta:');
define('FIBER_CHECK_COMMON_CODE','Código bancario:');
define('FIBER_CHECK_COMMON_IBAN','IBAN:');
define('FIBER_CHECK_COMMON_BIC','BIC:');

define('FIBER_CHECK_DO_TITLE','cuenta de US-$');
define('FIBER_CHECK_DO_ACCOUNT_VALUE','0902543668');
define('FIBER_CHECK_DO_CODE_VALUE','590 100 66');
define('FIBER_CHECK_DO_IBAN_VALUE','DE98 5901 0066 0902 5436 68');
define('FIBER_CHECK_DO_BIC_VALUE','PBNKDEFF590');

define('FIBER_CHECK_GB_TITLE','Libra esterlina GBP');
define('FIBER_CHECK_GB_ACCOUNT_VALUE','0902544661');
define('FIBER_CHECK_GB_CODE_VALUE','590 100 66');
define('FIBER_CHECK_GB_IBAN_VALUE','DE59 5901 0066 0902 5446 61');
define('FIBER_CHECK_GB_BIC_VALUE','PBNKDEFF590');

define('FIBER_CHECK_CH_TITLE','Franco suizo CHF');
define('FIBER_CHECK_CH_ACCOUNT_VALUE','0902545664');
define('FIBER_CHECK_CH_CODE_VALUE','590 100 66');
define('FIBER_CHECK_CH_IBAN_VALUE','DE41 5901 0066 0902 5456 64');
define('FIBER_CHECK_CH_BIC_VALUE','PBNKDEFF590');

define('FIBER_CHECK_POST_TITLE','Cuenta de postbank');
define('FIBER_CHECK_COMMON_ACCOUNT_NAME','Nombre de la cuenta:');
define('FIBER_CHECK_COMMON_BANK','Nombre del banco:');
define('FIBER_CHECK_COMMON_ADDRESS','Dirección del banco:');

define('FIBER_CHECK_SG_TITLE','Cuenta bancaria de OCBC');
define('FIBER_CHECK_SG_OCBC_USD','Cuenta beneficiaria OCBC USD:');
define('FIBER_CHECK_SG_OCBC_SGD','Cuenta beneficiaria OCBC SGD:');
define('FIBER_CHECK_SG_INT_BANK','Banco intermediario (para TT en USD)');
define('FIBER_CHECK_SG_SWIFT','Código SWIFT:');
define('FIBER_CHECK_SG_BANK_CODE','Código del banco:');
define('FIBER_CHECK_SG_BRANCH_CODE','Código de la sucursal:');
define('FIBER_CHECK_SG_BRANCH_CODE_CONTENT','Los primeros 3 números de tu número de cuenta');
define('FIBER_CHECK_SG_BRANCH_NAME','Nombre de la sucursal:');
define('FIBER_CHECK_SG_BRANCH_NAME_CONTENT','NORTH Branch');
define('FIBER_CHECK_SG_BANK_ADDRESS','Dirección del banco beneficiario:');
define('FIBER_CHECK_SG_BANK_ADDRESS_CONTENT','65 Chulia Street, OCBC Centre, Singapore 049513');

define('FIBER_CHECK_COMMON_ACCOUNT_NAME_VALUE','FS.COM GmbH');
define('FIBER_CHECK_COMMON_BANK_VALUE','Postbank');
define('FIBER_CHECK_COMMON_CODE_ADDRESS_VALUE','Eckenheimer Landstr.242 60320 Frankfurt');
//add by helun 2018.5.15
define('FS_CHECKOUT_SUCCESS_01','pedidos.');
define('FS_CHECKOUT_SUCCESS_02','Pedido de impresión');
define('FS_CHECKOUT_SUCCESS_03','Pedido');
define('FS_CHECKOUT_SUCCESS_04','de');
define('FS_CHECKOUT_SUCCESS_06','Sparkasse Freising');
define('FS_CHECKOUT_SUCCESS_07','FS.COM GmbH');
define('FS_CHECKOUT_SUCCESS_08','DE16 7005 1003 0025 6748 88');
define('FS_CHECKOUT_SUCCESS_09','BYLADEM1FSI');
define('FS_CHECKOUT_SUCCESS_10','25674888');
define('FS_CHECKOUT_SUCCESS_11','Untere Hauptstr.29, 85354, Freising');
define('FS_CHECKOUT_SUCCESS_12','Pedido de compra');
define('FS_CHECKOUT_SUCCESS_13','Días');
define('FS_CHECKOUT_SUCCESS_14','Subir archivo PO');
//new_cart
define('FS_NEW_SHIPPING_FREE','¡Este pedido cumple con los requisitos para envío gratuito!');
define('FS_GO_SHOPPING','Empieza a comprar');
define('FS_ENTERPRISE_NETWORK','Red empresarial');
define('FS_OTN_SOLUTION',' Solución de OTN ');
define('FS_DATA_CENTER_SOLUTION','Solución de centro de datos');
define('FS_OEM_SOLUTION',' Solución de OEM');
define('FS_RECENTLY_VIEWED','Productos vistos recientemente');
define('FS_CART_TIP','¿Tienes una cuenta de FS? <a target="_blank" href="'.zen_href_link('login','','SSL').'" class="cart_no_23Link">Inicia sesión</a> para ver tu cesta de compra o añadir nuevos artículos.');
define('FS_ADDED_TO_CART','Añadido a la cesta');
define('FS_REMOVED','Eliminar');
define('FS_SHOP_CART_MOVE','Mover a la cesta');
define('FS_SHOP_CART_SAVE','Guardar');
define('FS_SHOP_CART_SIMILAR','Ver productos similares');
define('FS_SHOP_CART_SAVED','Artículo');
define('FS_SHOP_CART_SAVED_WORD',' guardado');
define('FS_SHOP_CART_SAVED_WORDS','s guardados');
define('FS_CART_EMPTY','Tu cesta está vacía.');
define('FS_SVAE_FOR_LATER_TIP',' se ha guardado para más tarde.');
define('FS_MOVE_TO_CART_TIP',' se ha movido a tu cesta.');
define('FS_DELETE_FOR_LATER','Eliminar productos guardados');
define('FS_DELETE_SURE_SAVE','¿Está seguro de que desea eliminar los productos guardados?');
define('FS_DELETE_SURE','¿Estás seguro que quieres eliminar ');
define('FS_DELETE_CART_TITLE','Eliminar cesta guardada');
define('FS_SYMBOL',',');

//下架产品气泡，提示`
define('FS_PRODUCT_OFF_TEXT','Lo sentimos, el artículo ha sido quitado y no está disponible para la compra en línea.');
define('FS_PRODUCT_OFF_TEXT_2','Lo sentimos, el siguiente artículo puede haber sido eliminado y ya no está disponible para su compra en FS.COM.');
define('FS_PRODUCT_OFF_TEXT_3','Seleccionar atributos');
define('FS_PRODUCT_OFF_TEXT_4','Los atributos de los siguientes artículos personalizados han cambiado, por favor entre en la página de detalles del producto para seleccionar atributos.');
define('FS_PRODUCT_OFF_TEXT_5','*Algunos de los artículos en este pedido no se pueden agregar a la cesta.');
define('FS_PRODUCT_OFF_TEXT_6','Su pedido contiene artículo(s) no disponible(s), omita y continúe cargando el archivo PO.');
define('FS_PRODUCT_OFF_TEXT_7','El siguiente artículo ya no está disponible y no se calculará en el precio total al momento de realizar el pago.');
define('FS_PRODUCT_OFF_TEXT_8','Un artículo en tu cesta ya no está disponible. No aparecerá en la página de pago.');
define('FS_PRODUCT_OFF_TEXT_9','Estos artículos en tu cesta ya no están disponibles. No aparecerán en la página de pago.');
define('FS_PRODUCT_CLEARANCE_TEXT','El siguiente producto ya está fuera de stock. Por favor, ponte en contacto con tu gerente de cuenta para la disponibilidad.');
define('FS_PRODUCT_CLEARANCE_TEXT_1','La cantidad que necesitas excede nuestro inventario disponible, y el número ha sido ajustado en consecuencia. Por favor, ponte en contacto con tu gerente de cuenta para obtener una cantidad adicional.');

// 添加购物车成功弹窗
define('FS_ADDED_ONE_ITEM','Usted acaba de agregar [ADDITEM] artículo.');
define('FS_ADDED_MORE_ITEM','Usted acaba de agregar [ADDITEM] artículos.');

//四级分类名称
define('FS_CATEGORIES_01','Tipo de producto');
define('FS_CATEGORIES_02','Clasificación del producto');
define('FS_CATEGORIES_03','Tipo de herramienta');
define('FS_CATEGORIES_04','Tipo de conversores de medios');
define('FS_CATEGORIES_05','Tipo de cable');
define('FS_CATEGORIES_06','Tipo de switches KVM');
define('FS_CATEGORIES_07','Tipo de conversores de vídeos');
define('FS_CATEGORIES_08','Aplicación');
define('FS_PRODUCTS_JS_MOQ','La MOQ del producto es');
define('FS_PRODUCTS_JS_UPPER','No hay límite superior');

define("FS_PRODUCTS_PICK_UP","Recogida gratis, de lun. a vier. ");
define("FS_PRODUCTS_VIA","por");


//fairy 2019.1.15 add
define('FS_COLOR_RED','Rojo');
define('FS_COLOR_BLUR','Azul');
define('FS_COLOR_GREEN','Verde');

//账户中心
define('FS_MANAGE_ORDERS_1','Las siguientes informaciones son todas para el usuario final o el operador de switch. Es imprescindible para proporcionar servicios de apoyo técnico. Por favor, asegúrese de que todas las informaciones son verdaderas y efectivas.');
define('FS_MANAGE_ORDERS_2','Solicitud enviada');
define('FS_MANAGE_ORDERS_3','Clave de licencia: ');
define('FS_MANAGE_ORDERS_4','Procedimiento: ');
define('FS_MANAGE_ORDERS_5','Clave de licencia recibida');
define('FS_MANAGE_ORDERS_6','Activación completada');
define('FS_MANAGE_ORDERS_7','Información enviada con éxito. Le enviaremos un correo electrónico con la clave de licencia para activar el switch pronto.');
define('FS_MANAGE_ORDERS_8','Switches de la gama N + Cumulus Linux');
define('FS_MANAGE_ORDERS_9','Clave de licencia de switches + Cumulus Linux');
define('FS_MANAGE_ORDERS_10','Estimado(a)');
define('FS_MANAGE_ORDERS_11','Su clave de licencia es');
define('FS_MANAGE_ORDERS_12','Nota: se tardará unos 3 días en verificar la clave de licencia. Una vez completada la verificación, puede importarla en el switch.');
define('FS_MANAGE_ORDERS_13','1. Uso de la licencia y restricciones');
define('FS_MANAGE_ORDERS_14','La clave de licencia será a largo plazo y efectiva.');
define('FS_MANAGE_ORDERS_15','Puede disfrutar del servicio de asistencia técnica de 1 año y 45 días a partir de la fecha de activación. (El servicio gratuito adicional se retrasaría si no lo utiliza dentro de los 45 días).');
define('FS_MANAGE_ORDERS_16','Una vez que caduque el servicio, podrá continuar comprando el servicio si desea.');
define('FS_MANAGE_ORDERS_17','2. Proceso de importación de clave de licencia');
define('FS_MANAGE_ORDERS_18','Por favor revise los siguientes recursos para importar la licencia:');
define('FS_MANAGE_ORDERS_19','Le damos la bienvenida a cualquier pregunta durante la operación de la licencia o el deseo de ampliar los servicios de soporte técnico. Nuestra información de contacto es la siguiente:');
define('FS_MANAGE_ORDERS_20','Email: ');
define('FS_MANAGE_ORDERS_21','Teléfono: +1 (877) 205 5306 (PST)');
define('FS_MANAGE_ORDERS_22','+1 (888) 468 7419 (EST)');
define('FS_MANAGE_ORDERS_23','Asegúrese de que esta clave de licencia permanezca segura e impórtela al switch cuando lo necesite.');
define('FS_MANAGE_ORDERS_24','Sinceramente,');
define('FS_MANAGE_ORDERS_25','Equipo técnico de FS.COM');
define('FS_MANAGE_ORDERS_26','Vídeo: ');
define('FS_MANAGE_ORDERS_26_1','Vídeo');
define('FS_MANAGE_ORDERS_27','PDF: ');
define('FS_MANAGE_ORDERS_28','Teléfono: ');
define('FS_MANAGE_ORDERS_29','Envío gratuito para pedidos superiores a 79 €');
define('FS_MANAGE_ORDERS_30','Obtener clave de licencia');
define('FS_MANAGE_ORDERS_31','Estimado(a) ');
define('FS_MANAGE_ORDERS_32','Aquí está su clave de licencia: ');
define('FS_MANAGE_ORDERS_33','Leaf(10G/25G): 556688 <br />Spine(40G/100G): 335521');
define('FS_MANAGE_ORDERS_34','Nota: ');
define('FS_MANAGE_ORDERS_35','1. La clave de licencia será a largo plazo y efectiva. Por favor, asegúrese de que esta clave de licencia permanezca seguro. Tomará alrededor de 3 días verificar la clave de licencia.');
define('FS_MANAGE_ORDERS_36','2. Una vez completado, puede importarlo en el switch. Puede disfrutar de un servicio de asistencia técnica de 1 año y 45 días, el servicio gratuito adicional no sería válido si no lo utiliza dentro de los 45 días. Una vez que el servicio caduque, se le permite continuar comprando el servicio si desea.');
define('FS_MANAGE_ORDERS_37','la clave de licencia');
define('FS_MANAGE_ORDERS_38','Por favor revise los siguientes recursos:');
define('FS_MANAGE_ORDERS_39','Le damos la bienvenida a cualquier pregunta durante la operación de la licencia o el deseo de ampliar los servicios de soporte técnico. Nuestra información de contacto es la siguiente:');
define('FS_MANAGE_ORDERS_40','Correo electrónico: <a style="text-decoration: none;color: #232323;">tech@fs.com</a> <br />Teléfono: +34 (91) 123 7299');
define('FS_MANAGE_ORDERS_41','Sinceramente,');
define('FS_MANAGE_ORDERS_42','Equipo Técnico de FS.COM');
define('FS_MANAGE_ORDERS_43','Ingrese el nombre de su empresa');
define('FS_MANAGE_ORDERS_44','Ingrese su nombre');
define('FS_MANAGE_ORDERS_45','Ingrese su número de teléfono');
define('FS_MANAGE_ORDERS_46','Se requiere su dirección de correo electrónico');
define('FS_MANAGE_ORDERS_47','La dirección de correo electrónico que ha enviado no se reconoce.(p.ej: someone@example.com).');
define('FS_MANAGE_ORDERS_48','Por favor, haga clic en el botón de acuerdo EULA');
define('FS_MANAGE_ORDERS_49','Se requiere su dirección de web');
define('FS_MANAGE_ORDERS_50','Este mensaje fue enviado a ');
define('FS_MANAGE_ORDERS_51','Envío gratis: aplican algunas exclusiones.');
define('FS_MANAGE_ORDERS_52','Leer más sobre nuestro ');
define('FS_MANAGE_ORDERS_53','política de envío');
define('FS_MANAGE_ORDERS_54','FS.COM Inc.');
define("CULUMS_OFF1","Solicitar la activación");
define("CULUMS_OFF2","Las informaciones siguientes son todas para el usuario final o el operador del switch. Son esenciales para proporcionar servicios de apoyo técnico. Por favor, asegúrese de que todas las informaciones son verdaderas y efectivas. ");
define("CULUMS_OFF3","Nombre de la empresa");
define("CULUMS_OFF4","Nombre de usuario");
define("CULUMS_OFF5","Teléfono");
define("CULUMS_OFF6","Dirección de correo electrónico");
define("CULUMS_OFF7","Dirección web");
define("CULUMS_OFF8","Acuerdo de EULA.");
define("CULUMS_OFF9","Cumulus Networks®");
define("CULUMS_OFF10","Solicitar la activación");
define("CULUMS_OFF11","Acuerdo de licencia de software de usuario final");
define("CULUMS_OFF12","Estos términos de licencia, junto con la Confirmación de Pedido entregada a usted (Licenciatario) por Cumulus Networks, Inc. (Cumulus) o un revendedor autorizado por Cumulus para distribuir el software de Cumulus (Revendedor autorizado) un acuerdo entre Cumulus y usted. Estos términos se aplican al software con el que se distribuyen, incluyendo los medios en los que lo recibió, si corresponden. Los términos también se aplican a todas las actualizaciones, suplementos y servicios de soporte de Cumulus para el software que Cumulus puede suministrarle, a menos que otros términos acompañen a esos artículos. Si es así, se aplican esas condiciones.  Al utilizar el software, usted confirma que tiene una confirmación de pedido válida con respecto a cada copia del software que utiliza y que acepta estos términos en relación con cada copia.");
define("CULUMS_OFF13","SI NO ACEPTA ESTOS TÉRMINOS, NO USE EL SOFTWARE. AL UTILIZAR EL SOFTWARE, USTED ACEPTA Y ESTÁ ACUERDO CON ESTE ACUERDO DE LICENCIA DE SOFTWARE (Acuerdo).");
define("CULUMS_OFF14","LICENCIAS DE EVALUACIÓN, BETA Y NFR. Si recibe una licencia para el Producto que Cumulus lo identifica como una licencia de evaluación o una licencia Beta, las siguientes limitaciones adicionales se aplican a su licencia: a menos que Cumulus lo autorice por escrito, su uso del producto (i) solo está permitido durante un período de treinta días en un entorno interno no productivo (solo pruebas y evaluación); y se (ii) limita a no más de cinco instancias simultáneas del producto, que se ejecutan únicamente en el hardware que posee o que usted solo controla, salvo que Cumulus lo autorice. Si recibe una licencia para el producto que Cumulus ha identificado como una licencia de no reventa (NFR), las siguientes limitaciones adicionales se aplican a su licencia: su uso del producto (i) solo se permite por un tiempo en hardware que sea de su propiedad o que solo usted controle, mientras que usted es un socio con buena reputación bajo el programa de socios Cumulus correspondiente que lo hizo elegible para recibir la licencia NFR, (ii) limitado a demostraciones de productos, pruebas y capacitación solamente (no se permite producción, procesamiento de información ni uso de infraestructura). Sin perjuicio de lo contrario, la evaluación, la licencia Beta, los productos con licencia de NFR y cualquier producto (o parte de los mismos) identificados por Cumulus como acceso temprano se proporcionan TAL CUAL no se otorga ninguna indemnización, soporte o garantía de ningún tipo, expresa o implícita. Usted asume todos los riesgos asociados con cualquier uso de la evaluación, la licencia beta y los productos con licencia NFR. ESTE ACUERDO SÓLO PUEDE SER SUPERTO POR UN ACUERDO ESCRITO, ESCRITO Y FIRMADO CON CUMULUS NETWORKS, INC. QUE SE REFIERE EXPRESAMENTE Y SUSTITUYE ESTE ACUERDO (UN ACUERDO SUPERPUESTO).");
define("CULUMS_OFF15","Las partes acuerdan como lo siguiente:");
define("CULUMS_OFF16","1.Definiciones");
define("CULUMS_OFF17","a. Producto significará la(s) versión(es) ejecutable(es) del software de red disponible por Cumulus como se define explícitamente en la(s) confirmación(es) de la orden(como se define en la sección 3(a)) que se rige por este acuerdo y se pone a disposición del licenciatario. Incluyendo todas las actualizaciones y nuevas versiones del Producto que están disponibles para el licenciatario en virtud de este acuerdo y la documentación del usuario final correspondiente.");
define("CULUMS_OFF18","b. Información propietaria significa todas las invenciones, algoritmos, conocimientos e ideas y cualquier otra información comercial, técnica y financiera que una parte obtenga de la otra parte si: a)identificada como confidencial o propietaria en o antes de la divulgación, o b)un persona razonable presumiría que dicha información era confidencial, dado el contenido o las circunstancias de la divulgación.");
define("CULUMS_OFF19","c. Derechos de propiedad significa los derechos de patente, derechos de autor, derechos de secreto comercial, derechos de base de datos únicos y todos los demás derechos de propiedad intelectual e industrial de cualquier tipo.");
define("CULUMS_OFF20","2.Licencia otorgada");
define("CULUMS_OFF21","a. Sujeto al pago completo conforme a la sección 3 y al cumplimiento del licenciatario de los demás términos y condiciones de este acuerdo, Cumulus otorga al licenciatario, y solo al licenciatario, de acuerdo con todos los Derechos de propiedad de Cumulus, una licencia limitada, no exclusiva y totalmente pagada para reproducir y utilizar internamente para beneficio del Licenciatario la cantidad de licencias adquiridas del Producto solo por el término de la licencia aplicable(el término de la licencia), solo en el conmutador de silicio aplicable, y solo hasta las velocidades de puerto máximas especificadas en cada Confirmación de pedido (como se define en la Sección 3(a)).");
define("CULUMS_OFF22","b. La licencia anterior no permite ninguna sublicencia, distribución o divulgación del Producto a terceros y el licenciatario acepta que no participará en dicha sublicencia, divulgación o distribución.");
define("CULUMS_OFF23","c. El licenciatario no deberá (y no permitirá que su personal o cualquier tercero): (i) modificar o crear trabajos derivados del producto; (ii) aplicar ingeniería inversa o intentar descubrir cualquier código fuente o ideas subyacentes o algoritmos del producto (excepto en la medida en que la ley aplicable prohíba las restricciones de ingeniería inversa), (iii) eliminar o alterar cualquier identificación del producto, marca registrada, derechos de autor u otros avisos incluidos o que aparezcan en o dentro del producto; o (iv) publicar o distribuir de otro modo los resultados de estudios comparativos o de rendimiento a terceros sin el consentimiento previo por escrito de Cumulus. El licenciatario será el único responsable de la observancia y el cumplimiento de todos los términos y condiciones que figuran a continuación por parte de sus empleados, contratistas, proveedores de servicios y agentes, y cualquier otro tercero al que se haya permitido el acceso al producto como resultado de la acción o inacción del Licenciatario. El titular de la licencia deberá indemnizar, eximir de responsabilidad y defender a Cumulus y sus otorgantes de licencias de cualquier reclamo o demanda, incluidos los honorarios y gastos de abogados, que surjan o resulten de cualquier uso o distribución no autorizada o ilegal del producto.");
define("CULUMS_OFF24","d. El producto incluye paquetes de software de código abierto (en conjunto, el Software de código abierto). Cada paquete de software de código abierto incluido en el producto se pone a disposición del licenciatario de acuerdo con su licencia de paquete de software de código abierto aplicable. En caso de conflicto entre la licencia de un paquete de software de código abierto y el texto de este acuerdo, la licencia del paquete de software de código abierto solo controlará con respecto a ese paquete de código abierto específico.");
define("CULUMS_OFF25","e. El Producto se rige por las leyes, restricciones y regulaciones de exportación de los Estados Unidos. El licenciatario no exportará ni reexportará, ni permitirá la exportación o reexportación del Producto en violación de tales leyes, restricciones o regulaciones.");
define("CULUMS_OFF26","f. El producto(i) se desarrolló a expensas privadas e incluye secretos comerciales e información confidencial; (ii) es un artículo comercial que consiste en Software de computadora comercial y Documentación de Software de computadora comercial regulado en la sección 227.7202 de DFARS y en la sección 12.212 de FAR, y no se considerará que sea una Software de computación no comercial o documentación de Software de computación no comercial bajo ninguna disposición de DFARS; y (iii) NO se ofrece a las agencias del Gobierno de los EE.UU. bajo la licencia de software de computadora comercial establecida en FAR 52.227-19. De acuerdo con 48 CFR 12,212 y 48 CFR 227,7202 según corresponda, el producto tiene licencia para los usuarios finales del gobierno únicamente como un artículo comercial y con sólo los derechos que se conceden a otros usuarios finales bajo los términos de este contrato. Esta sección 2 (f) reemplaza y reemplaza a cualquier cláusula de FAR, DFAR u otras cláusulas complementarias de FAR. Derechos no publicados reservados bajo las leyes de derechos de autor de los Estados Unidos.");
define("CULUMS_OFF27","3.Precio; Pago; Archivos.");
define("CULUMS_OFF28","a. Durante la vigencia de este acuerdo, el licenciatario puede realizar solicitudes de licencias adquiridas adicionales mediante el envío de pedidos a Cumulus oa un Revendedor autorizado. Cumulus o el distribuidor autorizado responderán con un pedido formalizado y aceptado que confirme el número de licencias adquiridas, el plazo de la licencia, el precio total, los impuestos adeudados y los términos y condiciones adicionales con respecto a las licencias adquiridas (cada uno de estos formularios, un  Confirmación del pedido). Cada confirmación de pedido se incorpora a este Acuerdo en su totalidad. Cada licencia adquirida establecida en una confirmación de pedido permitirá al licenciatario crear una copia única del producto y utilizar la copia del producto de acuerdo con la concesión de licencia establecida en la Sección 2.");
define("CULUMS_OFF29","b. Durante la vigencia de este acuerdo, el licenciatario tendrá derecho a comprar licencias compradas de acuerdo con las confirmaciones de pedido entregadas por Cumulus al licenciatario (excluyendo impuestos, si corresponde).  Si así se especifica en la confirmación de pedido correspondiente, las licencias adquiridas previamente terminarán de inmediato según lo establecido en dicha confirmación de pedido y serán reemplazadas por nuevas Licencias adquiridas (dicho reemplazo, la conversión). Los términos aplicables a las conversiones se especificarán en la confirmación de pedido correspondiente y/o en un programa que describa los detalles específicos de dicha conversión (dicho programa, el Aviso de Conversión).");
define("CULUMS_OFF30","c. El licenciatario pagará a Cumulus (o a un revendedor autorizado) todas las tarifas aplicables establecidas en cada confirmación de pedido (las “Tarifas”) dentro de los treinta(30) días posteriores a la recepción de cada confirmación de pedido, o según lo acordado entre el licenciatario y un revendedor autorizado. La moneda aplicable se indicará en la confirmación del pedido; De lo contrario se trata de dólares estadounidenses. Las tarifas no son reembolsables. A menos que se identifique explícitamente como impuestos en la confirmación de pedido, todos los montos adeudados son exclusivos de impuestos, retenciones, aranceles y otros cargos gubernamentales (incluido, sin limitación, IVA), excluidos los impuestos sobre el ingreso neto de Cumulus (colectivamente, “Impuestos” ), y el licenciatario es responsable del pago de todos los Impuestos. Las partes cooperarán razonablemente para minimizar legalmente los impuestos. En el caso de que el licenciatario no le pague a Cumulus o a un revendedor autorizado ninguna parte de las Tarifas a su vencimiento, el licenciatario también le pagará a Cumulus o al distribuidor autorizado una tarifa por pago atrasado en la cantidad del 1,5% del monto total pendiente por mes durante el período dichos cargos son morosos, a menos que se acuerde lo contrario entre el licenciatario y el distribuidor autorizado.");
define("CULUMS_OFF31","d. Durante la vigencia de este acuerdo y por un(1) año después de su finalización, el licenciatario creará y mantendrá registros con respecto al uso del producto por parte del licenciatario, cuyos registros incluirán, sin limitación, cada instalación de una copia del producto y un identificador único para el hardware donde está instalado (colectivamente, 'Registros'). A solicitud de Cumulus, el licenciatario proporcionará rápidamente dichos registros a Cumulus con el fin de verificar el cumplimiento de este acuerdo. En el caso de que el licenciatario no cree, mantenga o entregue los registros como se requiere en esta sección o en el caso de cualquier disputa sobre la exactitud de dichos registros, Cumulus puede auditar el uso del producto por parte del licenciatario (por ejemplo, mediante la revisión de copias de archivos de registro, etc.), en cualquier ubicación en la que el licenciatario haya instalado o utilizado el producto.");
define("CULUMS_OFF32","4.Entrega y soporte.");
define("CULUMS_OFF33","a. Después de la entrega de la primera confirmación de pedido en virtud de este acuerdo, Cumulus entregará rápidamente al licenciatario una copia del producto en forma ejecutable.");
define("CULUMS_OFF34","b. El licenciatario puede solicitar servicios de soporte de Cumulus según lo establecido en la confirmación de pedido correspondiente, y sujeto al pago por parte del licenciatario de las tarifas de soporte aplicables.  El licenciatario reconoce y acepta que el soporte de Cumulus está sujeto a los términos y condiciones establecidos en la siguiente URL: <a href='javascript:;'>https://cumulusnetworks.com/support/overview/</a> ( El “programa de apoyo de Cumulus”).");
define("CULUMS_OFF35","c. A menos que se lo prohíba de manera contractual o legal, Cumulus proporcionará actualizaciones del licenciatario y nuevas versiones del Producto que generalmente está disponible comercialmente para los clientes de Cumulus, siempre que el licenciatario tenga una o más licencias compradas que cumplan con este acuerdo, y el licenciatario ordenado y pagado por el programa de asistencia de Cumulus como se especifica en la confirmación de pedido correspondiente.");
define("CULUMS_OFF36","5.Publicidad; Divulgación del Acuerdo; Marcas comerciales.");
define("CULUMS_OFF37","a. Cumulus tendrá el derecho de hacer referencia al Licenciatario como cliente sin revelar los términos de este acuerdo. Excepto según lo exija la ley o lo estipulado en este acuerdo, todos los anuncios públicos relacionados con los términos de este acuerdo se coordinarán entre Cumulus y el licenciatario mediante acuerdo mutuo.");
define("CULUMS_OFF38","b. Salvo que se especifique lo contrario en este documento, ninguna de las partes puede utilizar ninguna de las marcas registradas y marcas de servicio de la otra parte (Marcas), excepto de conformidad con la aprobación escrita (incluidas las comunicaciones electrónicas) de la otra parte. El licenciatario otorga a Cumulus una licencia limitada para usar las marcas del licenciatario de acuerdo con las pautas de uso de marcas del licenciatario con el único propósito de identificar al licenciatario como cliente. De lo contrario, las partes no utilizarán ni registrarán (ni realizarán ninguna presentación con respecto a) las marcas de la otra parte en ningún lugar del mundo. Ninguna de las partes impugnará en ningún lugar del mundo el uso o la autorización de la otra parte de cualquiera de las marcas de dicha parte. No se otorga ningún otro derecho o licencia con respecto a ninguna marca registrada, nombre comercial u otra designación bajo este acuerdo.");
define("CULUMS_OFF39","6.Prohibición contra la asignación. Ninguna de las partes puede ceder este contrato ni ningún derecho, licencia u obligación, sin la aprobación previa por escrito de la parte no asignada; Cualquier asignación supuestamente prohibida será nula. No obstante lo anterior, cualquiera de las partes puede ceder este acuerdo o delegar sus derechos y obligaciones a cualquier adquirente de todos o sustancialmente todos los activos o negocios o valores de capital de dicha parte relacionados con el objeto de este acuerdo, siempre que de cualquier asignación de este tipo, una vez recibida la notificación de asignación, la parte no asignada tendrá un plazo de treinta días para terminar este acuerdo mediante notificación por escrito.");
define("CULUMS_OFF40","7.Término del Acuerdo. El término de este Contrato se extenderá hasta el final del último para que caduque. Este Acuerdo terminará automáticamente, incluidas las concesiones de Licencia en la sección 2 si el Licenciatario no cumple con alguna de las condiciones de la sección 2. Este acuerdo puede ser rescindido si cualquiera de las partes falla materialmente en cumplir o cumplir con este Acuerdo o cualquier disposición material del mismo. La terminación será efectiva treinta(30) días después de la notificación de la terminación a la parte incumplidora si los incumplimientos no se han curado dentro de dicho período de treinta(30) días.");
define("CULUMS_OFF41","8.Supervivencia. Derechos de pago, Secciones 1, 2(b-e), 3(b), 6, 7, 8, 9, 10, 11, 12, 13 (b-d), y 14 y, a menos que se indique expresamente lo contrario en este documento, cualquier derecho de acción por incumplimiento de este acuerdo antes de la terminación sobrevivirá a la terminación de este acuerdo. En caso de terminación por incumplimiento de Cumulus, todas las licencias compradas sobrevivirán a la terminación hasta el final del Plazo de licencia aplicable. En caso de rescisión por incumplimiento del licenciatario, todas las licencias adquiridas terminarán de inmediato.");
define("CULUMS_OFF42","9.Avisos y solicitudes. Todos los avisos, consentimientos, autorizaciones y solicitudes en relación con este acuerdo se considerarán entregados inmediatamente después de ser enviados por correo urgente por mensajería, cargos prepagos; y dirigida con atención al departamento legal a la dirección correspondiente establecida en la confirmación de pedido más reciente que se rige por este acuerdo o a otra dirección como la parte que recibirá la notificación o solicitud, así lo designe mediante notificación escrita bajo esta sección 9 a la otra.");
define("CULUMS_OFF43","10.Ley de Control; Honorarios de abogados. Este acuerdo se regirá por y sobre las leyes del Estado de California y los Estados Unidos sin tener en cuenta sus disposiciones relativas a conflictos de leyes y sin tener en cuenta UCITA o la convención de las Naciones Unidas sobre contratos para la venta internacional de bienes. La única jurisdicción y el lugar para las acciones relacionadas con el tema aquí mencionado serán los tribunales estatales y federales de los Estados Unidos de California en el Condado de Santa Clara, California. Ambas partes aceptan la jurisdicción y el lugar de dichos tribunales y acuerdan que el proceso se puede llevar a cabo de la manera que aquí se proporciona para dar avisos o de otro modo según lo permita la ley de California o federal. La parte que prevalece en cualquier disputa tendrá derecho a recuperar los costos razonables de los honorarios de los abogados y otros gastos.");
define("CULUMS_OFF44","11.Confidencialidad");
define("CULUMS_OFF45","Los términos de precios de este acuerdo, el producto y los inventos subyacentes, los algoritmos, los conocimientos técnicos y las ideas son información de propiedad de Cumulus. Excepto que se permita expresamente y sin ambigüedades en este documento, el licenciatario se mantendrá en confianza y no utilizará ni divulgará ninguna información de propiedad exclusiva, y sus empleados y contratistas estarán igualmente vinculados por escrito. Nada en el presente documento permitirá a la parte receptora divulgar o utilizar, excepto como se permite explícitamente en otro lugar de este acuerdo, información confidencial de la parte reveladora y luego solo en forma según sea necesario para los fines de este acuerdo. Tras la finalización de este acuerdo, el licenciatario devolverá o destruirá rápidamente cualquier información de propiedad exclusiva y cualquier copia, extracto y derivado de la misma, excepto que se establezca lo contrario en este acuerdo. Además, el licenciatario eliminará sin demora todas y cada una de las copias del producto i) tan pronto como la licencia adquirida correspondiente caduque con respecto a esa copia del producto; y ii) antes de cualquier distribución de hardware donde se instale el producto a un tercero, incluido un distribuidor o fabricante de hardware. Cada parte reconoce que el incumplimiento de esta sección 11 causaría un daño irreparable a la otra por la cual los daños monetarios no son un remedio adecuado. En consecuencia, una parte tendrá derecho a solicitar medidas cautelares y otros recursos equitativos en caso de que la otra parte infrinja.");
define("CULUMS_OFF46","12.De responsabilidad limitada. A MENOS QUE SE INDIQUE LO CONTRARIO A CONTINUACIÓN, Y NO OBSTANTE CUALQUIER OTRA COSA EN ESTE ACUERDO O DE OTRA MANERA, NINGUNA DE LAS PARTES SERÁ RESPONSABLE U OBLIGADA EN VIRTUD DE NINGUNA SECCIÓN DE ESTE ACUERDO O BAJO CONTRATO, NEGLIGENCIA, RESPONSABILIDAD ESTRICTA U OTRA TEORÍA LEGAL O EQUITATIVA (A) POR CUALQUIER MONTO EN EXCEDENTE DEL TOTAL DE LOS DERECHOS DE LICENCIA QUE SE LE PAGARON(EN EL CASO DE UN CÚMULO) O (EN EL CASO DEL TITULAR DE LA LICENCIA) PAGADOS O ADEUDADOS POR EL PRESENTE DOCUMENTO, O (B) CUALQUIER DAÑO INCIDENTAL O CONSECUENTE, PÉRDIDA DE BENEFICIOS(EXCEPTO LAS CANTIDADES PAGADERAS EN VIRTUD DE SECCIÓN 3) O DATOS PERDIDOS O DAÑADOS O USO INTERRUMPIDO O (C) COSTO DE ADQUISICIÓN DE BIENES, TECNOLOGÍA O SERVICIOS SUSTITUTOS. LAS LIMITACIONES EN ESTA SECCIÓN 12 NO SE APLICARÁN A LAS INFRACCIONES DE LAS SECCIONES 2(B-E) Y 11 NI A LAS ACCIONES DEL TITULAR DE LA LICENCIA MÁS ALLÁ DEL ALCANCE DE LA CONCESIÓN DE LA LICENCIA QUE FIGURA A CONTINUACIÓN.");
define("CULUMS_OFF47","13.Garantía.");
define("CULUMS_OFF48","a. Cumulus garantiza al licenciatario que el producto será de buena calidad y se desarrollará utilizando una buena mano de obra de acuerdo con los más altos estándares profesionales. El único recurso del licenciatario por el incumplimiento de esta garantía o por defectos del producto son sus derechos en virtud de la sección 4 (b).Cumulus no ofrece ninguna garantía respecto a la ausencia de errores o el uso ininterrumpido.");
define("CULUMS_OFF49",". El Producto no está diseñado, destinado o certificado para su uso en componentes o sistemas destinados a la operación de sistemas o aplicaciones peligrosas (por ejemplo, armas, sistemas de armas, instalaciones nucleares, medios de transporte masivo, aviación, computadoras o equipos de soporte vital(incluida la reanimación equipos e implantes quirúrgicos), control de la contaminación, manejo de sustancias peligrosas o para cualquier otra aplicación peligrosa en las que la falla del producto podría crear una situación en la que podrían producirse lesiones personales o la muerte. El licenciatario entiende que el uso del producto en dichas aplicaciones es totalmente riesgo del licenciatario, y el licenciatario asume todos estos riesgos.");
define("CULUMS_OFF50","c. A EXCEPCIÓN DE LO EXPRESADO ANTERIORMENTE, CUMULUS NO OFRECE GARANTÍAS A NINGUNA PERSONA O ENTIDAD CON RESPECTO AL PRODUCTO Y RECHAZA TODAS LAS GARANTÍAS IMPLÍCITAS, INCLUIDAS, SIN LIMITACIÓN, LAS GARANTÍAS DE COMERCIALIZACIÓN Y COMODIDAD PARA UN PARTICULAR.");
define("CULUMS_OFF51","d. CADA PARTE RECONOCE Y ACEPTA QUE LAS GARANTÍAS Y RENUNCIAS DE RESPONSABILIDAD Y LIMITACIONES DE RECURSO DE ESTE ACUERDO SON OBLIGACIONES DE BASE DE ESTE ACUERDO Y QUE EL PLAN DE ENCUENTRO EN EL CONJUNTO DE LAS INSTRUCCIONES EN EL CONJUNTO DE INSPECTIVOS EN EL CONJUNTO DE INSTRUCCIONES LA DECISIÓN DE CADA PARTE DE ENTRAR EN EL PRESENTE ACUERDO.");
define("CULUMS_OFF52","14.General. Este acuerdo constituye el acuerdo completo entre las partes con respecto al objeto del presente documento y combina todas las comunicaciones anteriores y contemporáneas. No se modificará, excepto por un acuerdo escrito con fecha posterior a la fecha de este acuerdo y firmado en nombre del licenciatario y Cumulus por sus representantes debidamente autorizados. Si alguna disposición de este acuerdo debe ser considerada ilegal, inválida o inejecutable por un tribunal de jurisdicción competente, dicha disposición se limitará o eliminará en la medida mínima necesaria para que este acuerdo permanezca en pleno vigor, efecto y exigibilidad. Ninguna renuncia de cualquier incumplimiento de cualquier disposición de este acuerdo constituirá una renuncia de cualquier incumplimiento anterior, concurrente o posterior de la misma o de cualquier otra disposición de este documento, y ninguna renuncia será efectiva a menos que se realice por escrito y esté firmada por un representante autorizado de la fiesta de renuncia.");
define("CULUMS_OFF53","Enviar");
define("CULUMS_OFF54","Copyright &copy; 2009-".date('Y',time())." FS.COM GmbH Todos los derechos reservados.");
define("CULUMS_OFF55","Política de privacidad");
define("CULUMS_OFF56","Información enviada con éxito. Le enviaremos un correo electrónico con el código de licencia para activar el switch en un plazo de 10 minutos.");
define("CULUMS_OFF57","Ingrese el nombre de su empresa");
define("CULUMS_OFF58","Ingrese su número de teléfono");
define("CULUMS_OFF59","Ingrese su dirección de correo electrónico");
define("CULUMS_OFF60","No se reconoce la dirección de correo electrónico.(ejemplo: someone@ejemplo.com).");
define("CULUMS_OFF61","Por favor, marque el botón de acuerdo EULA");
define("CULUMS_OFF62","Ingrese su dirección web");
define("CULUMS_OFF63","Usted ha enviado la información de verificación, por favor no vuelva a enviar.");
define("CULUMS_OFF64","La información enviada correctamente ya no es necesario que la envíe otra vez.");
define("CULUMS_OFF65","Información del ítem");
define("CULUMS_OFF66","Comparta su experiencia de uso ");

//2019-01-07 继续付款，再次付款，付款成功
define('FS_PAYMENT_CONFIRM','Confirmar');
define('PAYMENT_AGAINST_PAYPAL_SECURITY','Se le dirigirá a la cuenta paypal para realizar este pedido.');
define('PAYMENT_AGAINST_BANK_SENTENCE01','Por lo general, los fondos se recibirán dentro de 1-3 días hábiles. Procesaremos el pedido una vez confirmada la remesa.');
define('PAYMENT_AGAINST_BANK_SENTENCE02','Avísenos cuando esté listo para realizar el pago para que podamos verificar su pago y procesar su pedido a tiempo.');
define('PAYMENT_AGAINST_BANK_FILL','Complete su información de transferencia bancaria');
define('PAYMENT_AGAINST_PAYPAL','PayPal');
define('PAYMENT_AGAINST_BANK','Transferencia bancaria');
define('PAYMENT_AGAINST_EDIT','Editar');
define('PAYMENT_AGAINST_BANK_EMAIL','Dirección de correo electrónico del pagador');

define('FS_ORDER_UPLOAD_PO_PURCHASE_ERROR_TIP','El número de orden de compra no puede estar vacío.');
define("FS_ORDER_UPLOAD_PO_MESSAGE",'Tu pedido no se enviará hasta que se reciba un documento de PO válido dentro de 7 días hábiles.');

define('FS_AGAINST_PAYER','Nombre del pagador');
define('FS_AGAINST_PAY_TIME','Tiempo de pago');
define('FS_AGAINST_PAY_AMOUNT','Monto del pago');
define('FS_AGAINST_COUNTRY','País');
define('FS_AGAINST_PHONE','Número de teléfono del pagador');
define('FS_AGAINST_OR','Por favor ingrese el nombre completo que usa para hacer la transferencia bancaria, ya sea individual o por compañía');
define('FS_AGAINST_YOUR','El tiempo de pago es obligatorio(ej: 26/01/2019)');
define('FS_AGAINST_MUST','Debe ser un número de teléfono válido, con lo cual podamos comunicarnos con usted si es necesario');

define('FS_BT_SUCCESSFULLY','¡Actualizado correctamente!');
define('FS_BT_SUCCESSFULLY_SENTENCE_01','Por lo general, los fondos se recibirán entre 1-3 días hábiles. Nos ocuparemos de ello lo antes posible. Haga clic en');
define('FS_BT_SUCCESSFULLY_SENTENCE_02',' Historial de pedidos ');
define('FS_BT_SUCCESSFULLY_SENTENCE_03','para ver el pedido.');

define("FS_CHECKOUT_NEW28","Copyright © 2009-".date('Y', time())." FS.COM GmbH Todos los derechos reservados.");

define('GLOBAL_GS_SENTENCE1','Nota: Por motivos de seguridad, no almacenamos ninguna información sobre tu tarjeta.');
define('GLOBAL_GS_SENTENCE2','Aceptamos las siguientes tarjetas de crédito/débito, así como P-Card emitida por estas compañías. Por favor, elige un tipo de tarjeta, completa la información y haz clic en Confirmar.');
define('GLOBAL_GS_SENTENCE3','Aceptamos las siguientes tarjetas de crédito/débito. Por motivos de seguridad, no almacenamos ninguna información sobre tu tarjeta.');
define('FS_AGAINST_WE','Aceptamos las siguientes tarjetas de crédito/débito, así como P-Card emitida por estas compañías. Por favor, elige un tipo de tarjeta, completa la información y haz clic en Confirmar.');
define("GLOBAL_GC_TEXT6","Tipo de trajeta:");
define("GLOBAL_GC_TEXT7","Resumen del pedido");
define("GLOBAL_GC_TEXT8","Número de pedido");
define("GLOBAL_GC_TEXT11","Dirección de facturación");
define("GLOABL_GC_LIVECHAT","Live Chat");
define("GLOABL_CART","Cesta");
define("GLOABL_CHECKETOUT","Pago");
define("GLOABL_SUCCESS","Con éxito");
define("GLOBAL_EXPECTED_SHIPPING","Envío estimado");
define("GLOBAL_EXPECTED_DELIVERY","Entrega estimada");
define('FS_ALLOWED_FILE_TYPES','Formatos soportados: ');
define('CHECKOUT_BILLING_CREDIT','Centro de pago con tarjeta de crédito/débito');
define('FS_GC_TIPS_01','Lo sentimos. Su solicitud ha sido denegada por los siguientes motivos. Por favor, revíselos e intente nuevamente, o elija otra forma de pago.');
define('FS_GC_TIPS_02','1. El importe total supera el límite (15000€).;');
define('FS_GC_TIPS_03','2. Su tarjeta no admite pagos en esta moneda.;');
define('FS_GC_TIPS_04','3. Error de red. Por favor, vuelva a intentarlo más tarde.');

//加购弹窗
define('FS_ADD_CART_PROCHUSE','Subtotal de la cesta');

//地址模块 start
define("FS_ADD_NEW_ADDRESS", "Añadir una nueva dirección");
define('FS_ADD_SHIPPING_ADDRESSES','Añadir una nueva dirección');
define('FS_ADD_BILLING_ADDRESS','Añadir una nueva dirección de facturación');
//地址模块 end
define('FS_REGIST','Registrar');

//询价弹窗
define("FS_INQUIRY_YOUR_ITEM",'Artículo');

define('FS_SAMPLE_APPLICATION_SUBMIT','Enviar...');
define("CHECKOUT_TAXE_CLEARANCE_CN_FRONT",'Para pedidos enviados desde nuestro almacén de China, SOLAMENTE cobraremos el valor del producto y los gastos de envío. No se cobrará impuesto a las ventas (ex. IVA o GST). Sin embargo, los paquetes pueden ser evaluados de importación o derechos de aduana, dependiendo de las leyes/regulaciones de los países en particular. Cualquier arancel o derechos de importación causados por el despacho de aduana deben ser declarados y pagados por el receptor. Para los pedidos enviados a Malasia, Indonesia y Filipinas, ahora proporcionamos el "Envío de transportador" como método de envío para ayudar a los clientes a pagar en línea por adelantado los impuestos y aranceles generados en el despacho de aduanas. Para clientes de otras áreas, comuníquese con nosotros si necesita ayuda para pagar el arancel aduanero.');

// 上传 start
//2018-9-20  ery  add  上传文件公用常量
define('FS_COMMON_FILE','Archivo');
//服务器端的提示
define("FS_UPLOAD_ERROR1",'El error del primero archivo adjunto: ');
define("FS_UPLOAD_ERROR2",'El error del segundo archivo adjunto: ');
define("FS_UPLOAD_ERROR3",'El error del tercer archivo adjunto: ');
define("FS_UPLOAD_ERROR4",'El error del cuarto archivo adjunto: ');
define("FS_UPLOAD_ERROR5",'El error del quinto archivo adjunto: ');
// 2019.2.26 fairy add
define("FS_UPLOAD_FORMAT_TIP",'Permitir archivos con tipo de $FILE_TYPE');
define("FS_UPLOAD_SIZE_DEFAULT_TIP",'El tamaño máximo de archivo es de 5M.');
// 上传 end

//信用卡新加坡渠道弹窗
define("GLOABL_TEXT_DECLINED_1","Lo sentimos que su tarjeta fue rechazada por uno de los siguientes motivos:");
define("GLOABL_TEXT_DECLINED_2","1.Por favor asegúrese de que no aparezcan más de 2 direcciones de facturación únicas por número de tarjeta o por dirección de correo electrónico en 30 días.");
define("GLOABL_TEXT_DECLINED_3","2.Por favor asegúrese de que el país de la tarjeta es igual que el de la dirección de envío en el pedido.");
define("GLOABL_TEXT_DECLINED_8","3.Por favor asegúrese de que la dirección de facturación en el pedido sea exactamente como aparece en el extracto de su tarjeta de crédito.");
define("GLOABL_TEXT_DECLINED_4","Puede comunicarse con su banco de tarjetas por razones al principio, y si el problema de su tarjeta no se puede resolver en breve, le sugerimos cambiar otra tarjeta o cambiar a Paypal, transferencia bancaria o cheque para pagar la orden.");
define("GLOABL_TEXT_DECLINED_5","Su tarjeta fue rechazada por el banco emisor");
define("GLOABL_TEXT_DECLINED_6","Su tarjeta puede haber sido rechazada por una variedad de razones, razones comunes incluyen:");

define("GLOABL_TEXT_DECLINED_7","Comuníquese con el emisor de su banco o tarjeta para conocer el motivo específico, ya que son ellos quienes declinan la transacción. O puede usar otra tarjeta de crédito o cambiar el método de pago en PayPal o transferencia bancaria para pagar la orden.");
define("GLOABL_TEXT_DECLINED_9","Haga clic aquí para pagar con otro método de pago.");
define("GLOABL_TEXT_DECLINED_10","Divida la orden si la cantidad total es superior a € 15000.00, o");
define("GLOABL_TEXT_DECLINED_11"," haga clic aquí ");
define("GLOABL_TEXT_DECLINED_12","pagar con otro método de pago.");

define('FS_CLEARACNE_05','Ver todo');
define('FS_CLEARACNE_06','Más');

//退换货提示
define('FS_ACCOUNT_HISTORY_1','Por favor, confirme la recepción del paquete, la devolución &amp; el reemplazo será activado.');

//详情页定制产品加购弹窗
define('FS_CUSTOMIZED_INFORMATION','Información de la personalización');
define('FS_CUSTOMIZED','Personalización');
define('FS_PROCESSING','En proceso');
define('FS_SHIPPING','Envío');
define('FS_DELIVERED','Entrega');
define('FS_PROCESSING_EST','Procesar: ');
define('FS_SHIPPING_EST','Enviar: ');
define('FS_DELIVERED_EST','Entregar: ');
define('FS_BUSINESS_DAYS_ADD',' días hábiles');
define('FS_BUSINESS_DAYS_DELIVER_TO',' días hábiles, se enviará a ');
define('FS_EST','Aprox. ');
define('FS_CUSTOMIZED_ADD_TO_CART','Confirmar');
define('FS_KEEP_SHOPPING','Seguir comprando');
define('FS_CONTINUE_TO_CART','A la cesta');


define("GLOBAL_GC_TEXT13","Número de tarjeta");
define("GLOBAL_GC_TEXT14","Fecha de vencimiento");
define("GLOBAL_GC_TEXT17","Código de seguridad");
define('FS_PRODCUTS_INFO_VIEW','Más detalles:');
define('FS_PRODUCTS_INFO_VIEW_NEW','Más');

//新版邮件公共头尾语言包
define('EMAIL_COMMON_FOOTER_NEW_01',"Comparte tu experiencia de servicio #");
define('EMAIL_COMMON_FOOTER_NEW_02',"Te has suscrito como ");
define('EMAIL_COMMON_FOOTER_NEW_03',"Modifica tus preferencias o date de baja.");
define('EMAIL_COMMON_FOOTER_NEW_04',"FS.COM Inc, 380 Centerpoint Blvd, New Castle, DE 19720");
define('EMAIL_COMMON_FOOTER_NEW_05',"Contáctanos");
define('EMAIL_COMMON_FOOTER_NEW_06',"Mi cuenta");
define('EMAIL_COMMON_FOOTER_NEW_07',"Envíos y entregas");
define('EMAIL_COMMON_FOOTER_NEW_08',"Política de devoluciones");
define('EMAIL_COMMON_FOOTER_NEW_09'," Todos los derechos reservados.");
define('EMAIL_COMMON_FOOTER_NEW_10',"Copyright &copy; ");

//密码重置成功之后的邮件
define('RESET_PASS_SUCCESS_01',"Has restablecido tu contraseña exitosamente y la puedes usar ahora mismo.");
define('RESET_PASS_SUCCESS_02','Inicia sesión en tu cuenta');
define('RESET_PASS_SUCCESS_03',"Si no solicitaste el restablecimiento de tu contraseña, por favor respóndenos a través de este correo o llámanos al +52 (55) 30987566 inmediatamente.");
define('RESET_PASS_SUCCESS_04','Gracias<br>Equipo FS');
define('RESET_PASS_SUCCESS_05','Hola');
define('RESET_PASS_SUCCESS_TITLE','Actualización de contraseña');
define('RESET_PASS_SUCCESS_THEME','Tu contraseña ha sido actualizada');

//发送重置密码的邮件
define('RESET_PASS_SEND_01',"Hemos recibido una solicitud de restablecimiento. Ingresa al siguiente enlace: Restablece tu contraseña para cambiar tu contraseña de forma rápida y segura. Si no lo solicitaste, haz caso omiso a este mensaje.");
define('RESET_PASS_SEND_02',"Restablece tu contraseña");
define('RESET_PASS_SEND_03',"Nota: Si hay problema en el botón de restablecimiento, podrás copiar y pegar el siguiente código en la página de restablecimiento de contraseña.");
define('RESET_PASS_SEND_04',"Gracias<br>El equipo FS");
define('RESET_PASS_SEND_05',"Hola");
define('RESET_PASS_SEND_06',"¿Sin contraseña? No hay problema. Le ayudaremos a restablecerlo.");
define('RESET_PASS_SEND_TITLE','Restablecer contraseña'); // Restablece tu contraseña
define('RESET_PASS_SEND_THEME','Instrucciones de restablecimiento de contraseña'); // Restablecer contraseña
define('RESET_PASS_EXPIRE_TIME','El código de restablecimiento expirará en 4 horas. Para obtener un nuevo enlace de restablecimiento, consulta <a style="color: #0070BC;text-decoration: none" href="'.zen_href_link(FILENAME_LOGIN).'">'.zen_href_link(FILENAME_LOGIN).'</a>.');
//修改邮箱成功之后的邮件
define('RESET_EMAIL_SUCCESS_01',"La nueva dirección de correo eléctronico que has ingresado es: ");
define('RESET_EMAIL_SUCCESS_02','Hola');
define('RESET_EMAIL_SUCCESS_03','Ahora la podras utilizar para acceder a ');
define('RESET_EMAIL_SUCCESS_04',"Mi cuenta");
define('RESET_EMAIL_SUCCESS_05',".");
define('RESET_EMAIL_SUCCESS_06',"Si no has actualizado tu correo electrónico, por favor ingresa a ");
define('RESET_EMAIL_SUCCESS_07',"Gracias<br>El equipo FS");
define('RESET_EMAIL_SUCCESS_TITLE','Dirección de correo electrónico actualizada');
define('RESET_EMAIL_SUCCESS_THEME','FS - Tu dirección de correo electrónico se ha actualizado');

//个人用户注册
define('REGIST_EMAIL_SEND_01',"Ha creado su cuenta con éxito. Ahora puede iniciar sesión con su email y contraseña.");
define('REGIST_EMAIL_SEND_02',"Estimado(a)");
define('REGIST_EMAIL_SEND_03',"Ha creado su cuenta con éxito. Ahora puede ");
define('REGIST_EMAIL_SEND_04',"iniciar sesión");
define('REGIST_EMAIL_SEND_05'," con tu e-mail y contraseña.");
define('REGIST_EMAIL_SEND_06',"Una vez que inicies sesión podrás:");
define('REGIST_EMAIL_SEND_07',"Administrar tu ");
define('REGIST_EMAIL_SEND_08',"perfil de cuenta de FS");
define('REGIST_EMAIL_SEND_09'," y solicitar acceso a servicios de FS fácilmente.");
define('REGIST_EMAIL_SEND_10',"Solicitar ");
define('REGIST_EMAIL_SEND_11',"soporte técnico");
define('REGIST_EMAIL_SEND_12'," y obtener respuesta inmediata sin ningún costo.");
define('REGIST_EMAIL_SEND_13',"Comprar en línea y rastrear tu pedido cuando lo desees. ");
define('REGIST_EMAIL_SEND_14',"Gracias<br>El equipo FS");
define('REGIST_EMAIL_SEND_15',"¡Gracias por registrarte en FS.COM! Tu cuenta ha sido creada exitosamente.  Tu número de cuenta es ");
define('REGIST_EMAIL_SEND_16',". Ahora podrás ");
define('REGIST_EMAIL_SEND_TITLE','Te damos la bienvenida a FS');
define('REGIST_EMAIL_SEND_THEME','Empieza a comprar con tu nueva cuenta de FS');

//企业用户注册(新用户注册)
define('REGIST_COM_EMAIL_SEND_01','Hemos recibido su solicitud de cuenta de negocios. Actualmente se encuentra en revisión y este proceso puede demorar entre 1 y 3 días hábiles.');
define('REGIST_COM_EMAIL_SEND_03','Hemos recibido su solicitud de cuenta de negocios. Actualmente se encuentra en revisión y este proceso puede demorar entre 1 y 3 días hábiles.
Cuando se haya tomado una decisión, se le notificará oportunamente por correo de FS.');
define('REGIST_COM_EMAIL_SEND_02','Estimado(a)');
define('REGIST_COM_EMAIL_SEND_04','Antes de ser aprobado, puede ');
define('REGIST_COM_EMAIL_SEND_05','iniciar sesión');
define('REGIST_COM_EMAIL_SEND_06',' con su correo electrónico y contraseña y disfrutar de los servicios de cuenta estándar.');
define('REGIST_COM_EMAIL_SEND_07','Después de iniciar sesión, puede:');
define('REGIST_COM_EMAIL_SEND_08','Administrar ');
define('REGIST_COM_EMAIL_SEND_09','tu perfil');
define('REGIST_COM_EMAIL_SEND_10',' y acceder nuestros servicios de forma rápida;');
define('REGIST_COM_EMAIL_SEND_11','Solicitar ');
define('REGIST_COM_EMAIL_SEND_12','soporte técnico');
define('REGIST_COM_EMAIL_SEND_13',' Comprar en línea y rastrear tu pedido cuando lo desees.');
define('REGIST_COM_EMAIL_SEND_14','Realizar una compra en línea y seguir el estado de su pedido en cualquier momento.');
define('REGIST_COM_EMAIL_SEND_15','Gracias<br>El equipo FS');
define('REGIST_COM_EMAIL_SEND_TITLE','Solicitud recibida');
define('REGIST_COM_EMAIL_SEND_THEME','FS - Su solicitud de cuenta empresarial recibida');

//新注册邮件语言包
define('REGIST_EMAIL_SEND_NEW_01',"Cuenta creada");
define('REGIST_EMAIL_SEND_NEW_02',"Bienvenido/a a FS");
define('REGIST_EMAIL_SEND_NEW_03',"Proveedor líder de equipos y soluciones para comunicaciones de red a nivel global");
define('REGIST_EMAIL_SEND_NEW_04',"Compromiso con la calidad");
define('REGIST_EMAIL_SEND_NEW_05',"Garantía de calidad, orientación al cliente y gestión sostenible.");
define('REGIST_EMAIL_SEND_NEW_06',"Soluciones personalizadas");
define('REGIST_EMAIL_SEND_NEW_07',"Ofrecemos soluciones integrales innovadores, rentables y confiables.");
define('REGIST_EMAIL_SEND_NEW_08',"Entrega rápida");
define('REGIST_EMAIL_SEND_NEW_09',"Almacenes locales, suficientes existencias y política de envío gratuito.");
define('REGIST_EMAIL_SEND_NEW_10',"Te responderemos de forma rápida <br> proporcionando experiencia y soporte <br> técnico para tu negocio.");
define('REGIST_EMAIL_SEND_NEW_11',"Consulta nuestros blog, wiki, <br> casos de éxito y anuncios para <br> descubrir las soluciones.");
define('REGIST_EMAIL_SEND_NEW_12',"Inicia sesión");
define('REGIST_EMAIL_SEND_NEW_13',"FS soporte técnico");
define('REGIST_EMAIL_SEND_NEW_14',"FS comunidad");

//老用户升级
define('REGIST_COM_EMAIL_UPGRADE_01','Hemos recibido su solicitud de cuenta de negocios. Actualmente se encuentra en revisión y este proceso puede demorar entre 1 y 3 días hábiles.');
define('REGIST_COM_EMAIL_UPGRADE_02','Estimado(a)');
define('REGIST_COM_EMAIL_UPGRADE_03','Hemos recibido su solicitud de actualizar la cuenta. Actualmente se encuentra en revisión y este proceso puede demorar entre 1 y 3 días hábiles. Cuando se haya tomado una decisión, se le notificará oportunamente por correo de FS.');
define('REGIST_COM_EMAIL_UPGRADE_04','Gracias<br>El equipo FS');
define('REGIST_COM_EMAIL_UPGRADE_TITLE','Solicitud recibida');
define('REGIST_COM_EMAIL_UPGRADE_THEME','FS - Su solicitud de cuenta empresarial recibida');

//订单邮件语言包
define('FS_ORDER_EMAIL_01','Gracias por elegir FS. Hemos recibido tu pedido pendiente ');
define('FS_ORDER_EMAIL_02','. Una vez que completes tu pago, tramitaremos tu pedido lo antes posible.');
define('FS_ORDER_EMAIL_03','¡Gracias por elegirnos! A continuación, encontrarás los detalles de tu pedido ');
define('FS_ORDER_EMAIL_04',' Nos estaremos comunicando por correo electrónico para informate sobre cualquier novedad.');
define('FS_ORDER_EMAIL_05','Los detalles de su pedido ');
define('FS_ORDER_EMAIL_06','están abajo. Como usted ha elegido "Recoger en el almacén", le enviaremos un email sobre las instrucciones de recogida una vez que su pedido esté listo.');
define('FS_ORDER_EMAIL_07','Gracias por elegir FS. Hemos recibido tu pedido pendiente. Complete el pago y su pedido puede entrar en el proceso lo antes posible.');
define('FS_ORDER_EMAIL_08','Los detalles de su pedido están abajo. Como usted ha elegido "Recoger en el almacén", le enviaremos un email sobre las instrucciones de recogida una vez que su pedido esté listo.');
define('FS_ORDER_EMAIL_09','¡Gracias por comprar con nosotros! Los detalles de su pedido están abajo. Le enviaremos la información de seguimiento tan pronto como se envíe el artículo de su pedido.');
define('FS_ORDER_EMAIL_10','Pedido');
define('FS_ORDER_EMAIL_11','Sus compras se han dividido en ');
define('FS_ORDER_EMAIL_12',' pedidos.');
define('FS_ORDER_EMAIL_13','Gestionar pedidos');
define('FS_ORDER_EMAIL_14','Pedido');
define('FS_ORDER_EMAIL_15','Comprado');
define('FS_ORDER_EMAIL_16','Envío previsto');
define('FS_ORDER_EMAIL_17','Entrega esperada');
define('FS_ORDER_EMAIL_18','No te preocupes. Te informaremos tan pronto como se envíen tus artículos. Si quieres saber el estado de tu pedido en tiempo real, por favor consulta ');
define('FS_ORDER_EMAIL_19','Mi cuenta');
define('FS_ORDER_EMAIL_20',' cuando lo requieras.');
define('FS_ORDER_EMAIL_21','Si necesitas cambiar o cancelar tu pedido, visita ');
define('FS_ORDER_EMAIL_22','. Recuerda que no podrás hacer cambios una vez que se envíen tus artículos.');
define('FS_ORDER_EMAIL_23','No se preocupe. Le informaremos tan pronto como se envíen sus artículos. Para saber el estado actualizado de su pedido, puede contactarnos en cualquier momento.');
define('FS_ORDER_EMAIL_24','Si necesita cambiar o cancelar su pedido, por favor póngase en contacto con su especialista de ventas. Tenga en cuenta que no podrá hacer cambios una vez que se envién sus artículos.');
define('FS_ORDER_EMAIL_25','Complete el pago y su pedido puede entrar en el proceso lo antes posible.');
define('FS_ORDER_EMAIL_26','Pedido recibido');
define('FS_ORDER_EMAIL_27','Pedido en tratamiento');
define('FS_ORDER_EMAIL_28','Hola ');
define('FS_ORDER_EMAIL_29','Detalles de entrega');
define('FS_ORDER_EMAIL_30','Enviar a');
define('FS_ORDER_EMAIL_31','Información de contacto');
define('FS_ORDER_EMAIL_32','Preguntas frecuentes');
define('FS_ORDER_EMAIL_33','¿Donde está mi producto?');
define('FS_ORDER_EMAIL_34','¿Cómo puedo cambiar mi pedido?');
define('FS_ORDER_EMAIL_35','Detalles del pago');
define('FS_ORDER_EMAIL_36','Subtotal:');
define('FS_ORDER_EMAIL_37','Envío:');
define('FS_ORDER_EMAIL_38','Coste total:');
define('FS_ORDER_EMAIL_39','Método de pago:');
define('FS_ORDER_EMAIL_40','Todos los cargos aparecerán con <a style="color: #0070BC;text-decoration: none" href="javascript:;">FS COM</a>.');
define('FS_ORDER_EMAIL_41','Dirección de facturación');
define('FS_ORDER_EMAIL_42','Gracias por su pedido. Vea en el interior los detalles de su pedido.');
define('FS_ORDER_EMAIL_43','FS - Hemos recibido tu pedido pendiente %s');
define('FS_ORDER_EMAIL_44','Dirección de recogida');
define('FS_ORDER_EMAIL_45','Persona para recogida');
define('FS_ORDER_EMAIL_46','. Sube el archivo PO (orden de compra) y tramitaremos tu pedido lo antes posible.');
define('FS_ORDER_EMAIL_47','FS - Gracias por tu pedido %s');
define('FS_ORDER_EMAIL_48','Orden de compra');
define('FS_ORDER_EMAIL_49','Listo');
define('FS_ORDER_EMAIL_50','Recogida');
//2019.4.9 新增俄罗斯对公支付 邮件语言包 [ORDERNUMBER]不需要翻译保留即可，只有一单时会替换成对应的订单号，多单时会替换为空
define('FS_ORDER_EMAIL_51', "Gracias por elegir FS. Hemos recibido tu pedido pendiente[ORDERNUMBER]. Nuestro gerente de cuenta enviará la factura a su correo electrónico lo antes posible.");
define('FS_ORDER_EMAIL_52','Por favor verifique los detalles de su pago:');
define('FS_ORDER_EMAIL_53','Persona de contacto');
define('FS_ORDER_EMAIL_54','Número de teléfono*');
define('FS_ORDER_EMAIL_55','E-mail*');
define('FS_ORDER_EMAIL_56','Nombre de la organización*');
define('FS_ORDER_EMAIL_57','INN*');
define('FS_ORDER_EMAIL_58','KPP*');
define('FS_ORDER_EMAIL_59','OKPO');
define('FS_ORDER_EMAIL_60','BIC*');
define('FS_ORDER_EMAIL_61','Dirección legal*');
define('FS_ORDER_EMAIL_62','Dirección postal');
define('FS_ORDER_EMAIL_63','Cuenta correspondiente');
define('FS_ORDER_EMAIL_64','Nombre del banco*');
define('FS_ORDER_EMAIL_65','Cuenta de liquidación*');
define('FS_ORDER_EMAIL_66','Nombre completo del titular');
define('FS_ORDER_EMAIL_67','Información de pago');
define('FS_ORDER_EMAIL_68','Longitud');
define('FS_ORDER_EMAIL_09_1','Tu compra se ha dividido en 2 pedidos ');
define('FS_ORDER_EMAIL_09_2','Se presentan a continuación los detalles. Te enviaremos un email una vez que el estado de tu pedido cambie.');
define('FS_ORDER_EMAIL_69','Si deseas conocer el estado de tu pedido, por favor inicia sesión en tu cuenta y consulta la sección ');
define('FS_ORDER_EMAIL_70','Historial de pedidos');
define('FS_ORDER_EMAIL_71','.');
define('FS_ORDER_EMAIL_72','Pago recibido');
define('FS_ORDER_EMAIL_73','En proceso');
define('FS_ORDER_EMAIL_74','Enviado');
define('FS_ORDER_EMAIL_75','Entregado');
define('FS_ORDER_EMAIL_76','PO confirmado');
//邮件系统改版语言包
//在线询价(A)
define('FS_SEND_EMAIL','FS - Hemos recibido tu solicitud de presupuesto ');
define('FS_SEND_EMAIL_1',"Gracias por ponerte en contacto con nosotros. Hemos recibido tu solicitud de cotización ");
define('FS_SEND_EMAIL_2'," la responderemos dentro de un día laboral.");
define('FS_SEND_EMAIL_3',"Solicitud recibida");
define('FS_SEND_EMAIL_3_1','Hemos recibido tu solicitud de muestra $CASENUMBER');
define('FS_SEND_EMAIL_4'," y la responderemos dentro de un día laboral.");
define('FS_SEND_EMAIL_5',"Su mensaje");
define('FS_SEND_EMAIL_6',"Tu lista de cotización");
define('FS_SEND_EMAIL_7',"Mensaje adicional");
define('FS_SEND_EMAIL_8',"Cant.: ");
//在线技术咨询A
define('FS_SEND_EMAIL_8_1','FS - Hemos recibido tu solicitud de soporte ');
define('FS_SEND_EMAIL_8_2', 'FS - Hemos recibido tu solicitud de asistencia técnica ');//product_support页面，发送邮件
define('FS_SEND_EMAIL_9',"Gracias por contactar a FS y tu número de caso es ");
define('FS_SEND_EMAIL_10',". Nuestro equipo de soporte técnico le responderá dentro de 6-18 horas.");
define('FS_SEND_EMAIL_10_1',". Te responderemos dentro de 6-18 horas.");//product_support页面，发送邮件
//产品QA邮件
define('FS_SEND_EMAIL_11',"FS - Hemos recibido su pregunta sobre el artículo #");
define('FS_SEND_EMAIL_12',"Pregunta recibida");
define('FS_SEND_EMAIL_12_1',"Hemos recibido su pregunta sobre el artículo #");
define('FS_SEND_EMAIL_13'," y le responderemos dentro de 24 horas.");
define('FS_SEND_EMAIL_14',"Hemos recibido su pregunta sobre el artículo ");
define('FS_SEND_EMAIL_15'," y le responderemos dentro de 24 horas.");
//退换货all
define('FS_SEND_EMAIL_16',"Estamos aquí para usted");
define('FS_SEND_EMAIL_17',"Hemos recibido su solicitud sobre sus problemas con el pedido ");
define('FS_SEND_EMAIL_18',"¡Gracias por dejarnos ayudarle en eso!");
define('FS_SEND_EMAIL_19',"FS - Hemos recibido su solicitud de soporte ");
define('FS_SEND_EMAIL_20',"Gracias por contactar a FS. Hemos recibido su solicitud de soporte y le responderemos dentro de 24 horas.");
define('FS_SEND_EMAIL_21',"Gracias por contactar a FS. Hemos recibido su solicitud de soporte y le responderemos dentro de 24 horas. Y su número de caso es");
define('FS_SEND_EMAIL_22',"Hemos recibido su solicitud de inventario sobre el artículo #");
define('FS_SEND_EMAIL_23'," y nos pondremos en contacto con usted dentro de 24 horas.");
define('FS_SEND_EMAIL_24',"Hemos recibido su solicitud de inventario sobre el artículo ");
define('FS_SEND_EMAIL_25'," y contactaremos con usted dentro de 24 horas. Y aquí tiene su número de caso ");
define('FS_SEND_EMAIL_26',". Puede consultar este número en todas las comunicaciones siguientes sobre esta solicitud.");
define('FS_SEND_EMAIL_27',"Artículo");
define('FS_SEND_EMAIL_28',"Mensaje adicional");
define('FS_SEND_EMAIL_29',"Cant. de solicitud: ");
define('FS_SEND_EMAIL_30'," Fecha de entrega requerida: ");
define('FS_SEND_EMAIL_31',"FS - Hemos recibido su solicitud de inventario ");
define('FS_SEND_EMAIL_32',"FS - Hemos recibido su solicitud de devolución");
define('FS_SEND_EMAIL_33',"Hemos recibido su solicitud de devolución y le enviaremos un email con más informaciones dentro de 24 horas.");
define('FS_SEND_EMAIL_34',"FS - Hemos recibido su solicitud de reemplazo");
define('FS_SEND_EMAIL_35',"Hemos recibido su solicitud de reemplazo y le enviaremos un email con más informaciones dentro de 24 horas.");
define('FS_SEND_EMAIL_36',"FS - Hemos recibido su solicitud de mantenimiento");
define('FS_SEND_EMAIL_37',"Hemos recibido su solicitud de mantenimiento y le enviaremos un email con más informaciones dentro de 24 horas.");
define('FS_SEND_EMAIL_38'," Instrucciones para su devolución de FS");
define('FS_SEND_EMAIL_39',"Siga estos pasos para completar su devolución de su pedido #");
define('FS_SEND_EMAIL_40',"Pedido de devolución");
define('FS_SEND_EMAIL_41'," y le enviaremos un email con más informaciones sobre los artículos de devolución dentro de 24 horas.");
define('FS_SEND_EMAIL_42'," y le enviaremos un email con más informaciones sobre los artículos de reemplazo dentro de 24 horas.");
define('FS_SEND_EMAIL_43'," y le enviaremos un email con más informaciones sobre los artículos de mantenimiento dentro de 24 horas.");
define('FS_SEND_EMAIL_44',"Artículos de devolución");
define('FS_SEND_EMAIL_45',"Artículos de reemplazo");
define('FS_SEND_EMAIL_46',"Artículos de mantenimiento");
define('FS_SEND_EMAIL_47',"Devolución");
define('FS_SEND_EMAIL_48',"Lamentamos que los artículos de su pedido");
define('FS_SEND_EMAIL_49'," no sean adecuados para usted. Para completar su devolución, siga estos sencillos pasos:");
define('FS_SEND_EMAIL_50',"Al recibir los artículos devueltos, emitiremos un reembolso de ");
define('FS_SEND_EMAIL_51'," a su método de pago original dentro de 1 día hábil. El dinero será acreditado a su cuenta en una semana");
define('FS_SEND_EMAIL_52'," Resumen");
define('FS_SEND_EMAIL_53',"Costo de crédito de artículo(s):");
define('FS_SEND_EMAIL_54',"Costo de envío de devolución:");
define('FS_SEND_EMAIL_55',"Reembolso de devolución total:");
define('FS_SEND_EMAIL_56',"Método de devolución:");
define('FS_SEND_EMAIL_57',"Método de pago original ");
define('FS_SEND_EMAIL_58',"Para obtener información sobre nuestra política de devoluciones, ");
define('FS_SEND_EMAIL_59',"haga clic aquí");
define('FS_SEND_EMAIL_60',"Reemplazo");
define('FS_SEND_EMAIL_61',"Lamentamos que haya tenido problemas con su pedido");
define('FS_SEND_EMAIL_62'," Para completar su reemplazo, siga estos sencillos pasos:");
define('FS_SEND_EMAIL_63',"Después de recibir los artículos devueltos, arreglaremos el envío del pedido de reemplazo lo antes posible y le enviaremos la información de seguimiento cuando esté disponible.");
define('FS_SEND_EMAIL_64',"Mantenimiento");
define('FS_SEND_EMAIL_67',"Después de recibir los artículos devueltos, arreglaremos el envío del pedido de mantenimiento lo antes posible y le enviaremos la información de seguimiento cuando esté disponible.");
define('FS_SEND_EMAIL_68',"Resumen");
define('FS_SEND_EMAIL_69',"Envío a");
define('FS_SEND_EMAIL_70',"Información de contacto");
define('FS_SEND_EMAIL_71',"Ref: PO#");
define('FS_SEND_EMAIL_83',"Precio: ");
//样品申请邮件
define('FS_SEND_EMAIL_84',"Hemos recibido su solicitud de muestra y le actualizaremos los resultados dentro de 24 horas.");
define('FS_SEND_EMAIL_85',"Hemos recibido su solicitud de muestra y Un gerente  profesional de nuestro equipo estarán en contacto pronto. Y aquí está su número de caso ");
define('FS_SEND_EMAIL_86',". Puede consultar este número en todas las comunicaciones de seguimiento sobre esta solicitud.");
define('FS_SEND_EMAIL_87',"Lista de muestra");
define('FS_SEND_EMAIL_88',"Cant. de solicitud: ");
define('FS_SEND_EMAIL_89',"Sus notas adicionales");
define('FS_SEND_EMAIL_90',"FS - Hemos recibido tu solicitud de muestra ");
//cumlums交换机发送激活码邮件
define('FS_SEND_EMAIL_91',"Clave de licencia");
define('FS_SEND_EMAIL_92',"Su información de activación se ha enviado con éxito.");
define('FS_SEND_EMAIL_94',"Su clave de licencia y detalles de pedido son los siguientes. Usted tendrá que instalar esta clave de licencia en el switch para activar el software. Esta clave de licencia es exclusiva de su cuenta. Tomaremos alrededor de 3 días para ayudarle a activarlo. Por favor, copie y pegue el texto de la clave de licencia en el momento adecuado durante el proceso de instalación de la licencia.");
define('FS_SEND_EMAIL_95',"Tenga en cuenta: La clave de licencia será a largo plazo y válida. El servicio de soporte técnico es de 1 año, pero si lo instala dentro de 45 días, puede disfrutar de un extra de 45 días gratis.");
define('FS_SEND_EMAIL_96',"Si tiene cualquier pregunta o necesita ayuda, contáctenos por favor en ");
define('FS_SEND_EMAIL_97',"Clave de licencia");
define('FS_SEND_EMAIL_98',"Para Cumulus Linux 2.5.3 o versiones superiores:");
define('FS_SEND_EMAIL_99',"No. de pedido: ");
define('FS_SEND_EMAIL_100',"Fecha: ");
define('FS_SEND_EMAIL_101',"Ver más");
define('FS_SEND_EMAIL_102',"FS - Clave de licencia");
//付款链接
define('FS_SEND_EMAIL_103',"<br>Comentario:");
define('FS_SEND_EMAIL_104'," le envió una solicitud de pago");
define('FS_SEND_EMAIL_105',"No. de factura: ");
define('FS_SEND_EMAIL_106',"Pagar ahora");
define('FS_SEND_EMAIL_107',"FS - Tiene una solicitud de pago de ");
//分享购物车
define('FS_SEND_EMAIL_108',"Comparte la cesta de compras");
define('FS_SEND_EMAIL_109',"Tu amigo(a) ");
define('FS_SEND_EMAIL_110'," le compartió una lista de cesta con usted.");
define('FS_SEND_EMAIL_111',"Tu amigo(a) ");
define('FS_SEND_EMAIL_112'," te compartió una cesta de compras. Por favor ingresa a Añadir a la cesta, para que puedas ver más detalles sobre el/los producto(s) y para que los incluyas en tu propia cesta.");
define('FS_SEND_EMAIL_113',"Cesta de compras");
define('FS_SEND_EMAIL_115',"Este correo electrónico ha sido envíado por ");
define('FS_SEND_EMAIL_116'," a través de nuestra opción \"Compartir\". ");
define('FS_SEND_EMAIL_117'," con un amigo de FS.");
define('FS_SEND_EMAIL_118'," Este mensaje no implica que recibiras mensajes de ");
define('FS_SEND_EMAIL_119'," que no has solicitado. Conoce más acerca de nuestra ");
define('FS_SEND_EMAIL_120',"Política de privacidad");
define('FS_SEND_EMAIL_121',"FS - Tu amigo(a) ");
define('FS_SEND_EMAIL_122'," te compartió una cesta de compras");
//分享产品
define('FS_SEND_EMAIL_123',"Comparte tu artículo");
define('FS_SEND_EMAIL_124',"Es posible que le interese este artículo");
define('FS_SEND_EMAIL_125',"Más detalles");
define('FS_SEND_EMAIL_126'," Como resultado de recibir este mensaje, no recibirá ningún mensaje no solicitado de ");
define('FS_SEND_EMAIL_127'," Conocer más sobre nuestra ");
define('FS_SEND_EMAIL_129'," te compartió un artículo");
//RMA取消订单邮件
define('FS_SEND_EMAIL_130',"Actualización de RMA");
define('FS_SEND_EMAIL_131',"Su solicitud de RMA para el pedido# ");
define('FS_SEND_EMAIL_132'," ha sido cancelado. Estamos aquí para resolver su cualquier problema.");
define('FS_SEND_EMAIL_133',"RMA cancelado");
define('FS_SEND_EMAIL_135'," ha sido cancelado. Lamentamos cualquier tipo de incoveniencia.");
define('FS_SEND_EMAIL_136',"Estamos aquí para resolver su cualquier problema.");
define('FS_SEND_EMAIL_137',"Artículo de RMA");
//订单评价成功邮件
define('FS_SEND_EMAIL_138'," le envió una solicitud de pago.");
define('FS_SEND_EMAIL_139',"Pedido actualizado");
define('FS_SEND_EMAIL_140',"Su pedido #");
define('FS_SEND_EMAIL_141',"Pedido cancelado");
define('FS_SEND_EMAIL_142',"Te agradecemos por comprar nuestros productos. Esperamos volver a servirte próximamente.");
define('FS_SEND_EMAIL_143',"Detalles del pedido");
//留言入口客户调查问卷
define('FS_SEND_EMAIL_144',"Compartir comentarios");
define('FS_SEND_EMAIL_145',"¿Es posible que recomiende FS a sus amigos o colegas?");
define('FS_SEND_EMAIL_146',"Para garantizar que disfrute de la mejor experiencia de compra posible,<br>por favor conteste la pregunta arriba. Cuando responda, se le pedirá que proporcione una breve explicación de calificación. Todos los comentarios son muy útiles.");
//live_chat留言
define('FS_SEND_EMAIL_147',"Tema del comentario");
define('FS_SEND_EMAIL_148',"Gracias por contactar a FS. Hemos recibido su correo electrónico y le responderemos dentro de 12 horas.\"");
define('FS_SEND_EMAIL_149',"FS - Hemos recibido su mensaje de correo electrónico");
define('FS_SEND_EMAIL_150',"Gracias por contactar a FS. Hemos recibido su correo electrónico y le responderemos dentro de 12 horas. Y su número de caso es ");
define('FS_SEND_EMAIL_151',"Compartir el artículo");
define('FS_SEND_EMAIL_152',"Es posible que le interese este artículo");
define('FS_SEND_EMAIL_153',"Tu amigo(a) ");
define('FS_SEND_EMAIL_154'," Este correo electrónico fue enviado por ");
define('FS_SEND_EMAIL_155'," compartió este artículo contigo a través de ");
define('FS_SEND_EMAIL_156',"FS - Su RMA ha sido cancelado");
define('FS_SEND_EMAIL_157',"FS - Hemos recibido su solicitud de presupuesto");
define('FS_SEND_EMAIL_158',"Mensaje de");
define('FS_SEND_EMAIL_159',"Añadir a la cesta");
//退换货
define('FS_SEND_EMAIL_160',"Tu pedido #");
define('FS_SEND_EMAIL_160_01',"FS - Tu pedido #");
define('FS_SEND_EMAIL_161',"FS - Su pedido FS");
define('FS_SEND_EMAIL_162',"Instrucción de devolución");
define('FS_SEND_EMAIL_163',"1. Imprimir RMA");
define('FS_SEND_EMAIL_164',"RMA puede ayudarnos a distinguir su paquete. Imprima el formulario de RMA y adjúntelo al paquete.");
define('FS_SEND_EMAIL_165',"2. Embalar artículo");
define('FS_SEND_EMAIL_166',"Quite las etiquetas anteriores si utiliza la caja original con RMA,");
define('FS_SEND_EMAIL_167',"3. Enviar el paguete");
define('FS_SEND_EMAIL_168',"Nos devuelva el paquete");
define('FS_SEND_EMAIL_169',"4. Le devolveremos su ");
define('FS_SEND_EMAIL_170',"Gracias por contactar con FS. Hemos recibido su solicitud de llamada y nos pondremos en contacto con usted lo antes posible.");
define('FS_SEND_EMAIL_171',"FS - Hemos recibido su solicitud de llamada");
define('FS_SEND_EMAIL_3_1',"Demande de Paiement");
define('FS_PRE_ORDER','Pre-order');
define('FS_DAY_PROCESSING','<span class="process_time_dylan">$DAYNUMBER</span> días para preparar');
define('FS_DAY_PROCESSING_SEARCH','<span class="process_time_dylan">$DAYNUMBER</span> días para preparar');
define("PREORDER_DESPRCTION","Pre-order es la línea de ensamble especializada en I&D y orientada al cliente basada en la consecución de economías de escala y fabricación automatizada, nos permite ofrecer compras a granel y garantizar proyectos de clientes cuyo presupuesto es estrictamente controlado, productos rentables, así como garantizar una entrega mucho más rápida que otros proveedores.");
define("PRERDER_PROCESSIONG","<i class='popover_i'></i>El tiempo de procesamiento de los artículos de Pre-Order se refiere a día hábil, incluyendo la producción y la prueba, excepto el envío, ya que está determinado por la velocidad de envío que haya elegido.");
define("PRERER_SAVE"," para ahorrar el presupuesto de su proyecto");

//quest add 2019-03-01
define('CHECKOUT_CUSTOMER_ACCOUNT1','Por favor, introduzca una cuenta válida compuesta por 9 números');
define('CHECKOUT_CUSTOMER_ACCOUNT2','Por favor, introduzca una cuenta válida compuesta por 6 caracteres');


// fairy 2019.1.17 组合子产品
define("FS_ITEM_INCLUDES_PRODUCTS","Este artículo incluye los siguientes accesorios");



define('MODULE_ORDER_TOTAL_TAX_TITLE', 'Tax');
define('MODULE_ORDER_TOTAL_TAX_DESCRIPTION', 'Order Tax');

define('MODULE_ORDER_TOTAL_TOTAL_TITLE', 'Total general');
define('MODULE_ORDER_TOTAL_TOTAL_DESCRIPTION', 'Order Total');

define('MODULE_ORDER_TOTAL_SHIPPING_TITLE', '(+)Shipping Cost:');
define('MODULE_ORDER_TOTAL_SHIPPING_DESCRIPTION', 'Order Shipping Cost');

define('MODULE_ORDER_TOTAL_SUBTOTAL_TITLE', 'Total');
define('MODULE_ORDER_TOTAL_SUBTOTAL_DESCRIPTION', 'Order Sub-Total');

//2019.3.9   ery  add 专题询价板块
define('FS_SPECILA_INQUIRY_QUESTION', '¿Preguntas? Respondemos de forma rápida');
define('FS_SPECILA_INQUIRY_ASK', 'Pregúntanos sobre el precio, la entrega o cualquier otra cosa. Nuestro gerente de cuenta está a tu disposición.');

//rebirth.ma  2019.03.12  上传错误定义
define("FS_FILE_TOO_LARGE","Este archivo es demasiado grande para poder subirlo.");

define('FIBERSTORE_PRODUCT_DETAIL','Detalles del producto');

//rebirth.ma  2019.03.22  购物车样式调整
define("FS_Summary","Resumen");


//liang.zhu 2019.04.02 定义tpl_modules_index_product_list_old_style.php
define('TPL_MODULES_INDEX_PRODUCT_LIST_OLD_STYLE_GRID', 'Cuadrícula');
define('TPL_MODULES_INDEX_PRODUCT_LIST_OLD_STYLE_LIST', 'Lista');
define('TPL_MODULES_INDEX_PRODUCT_LIST_OLD_STYLE_QUICKFINDER', 'Búsqueda rápida');

//2019.4.4  ery  ADD俄罗斯对公支付方式名
define("FS_CHECKOUT_NEW_CASHLESS","Pago sin efectivo");
define("SHIPPING_COURIER_DELIVERY","Courier delivery");
define("SHIPPING_DELIVERY","Forma de envío");
define("SHIPPING_COURIER_DELIVERY_01"," para personas naturales");
//2019.4.11  ery add  俄罗斯对公支付收税政策文字表达优化
define('CHECKOUT_TAXE_RU_TIT', 'De acuerdo con el capítulo 21 de la Ley Federal de Impuestos de Rusia, FS.COM Ltd está obligada a cobrar el IVA en todos los pedidos entregados a Rusia. Todos los productos de nuestro catálogo están sujetos a un IVA estándar del 20% del costo de acuerdo con la Ley General de Impuestos de Rusia. Conocerá el importe total incluido el IVA antes de realizar el pago si rellena toda la información necesaria sobre el pedido (Incluye el tipo de negocio y la dirección de envío).');
define("CHECKOUT_TAXE_RU_TIT_FOR_NATURAL","Para pedidos de personas físicas y enviados desde nuestro almacén internacional, SOLO cobraremos el valor de los productos y los costos de envío. Cualquier arancel o tarifa de importación causado por el despacho de aduana debe ser asumido por el destinatario. Desde el día 1 de enero de 2020, el umbral para compras libres de impuestos se ha reducido a 200 € y hasta 31kg por paquete. Si estás interesado/a en otros métodos de entrega o deseas pagar mediante cashless, ponte en contacto con tu gerente de cuenta.");
define("FS_EMAIL_ERROR","Ingrese una dirección válida de correo electrónico");
define("FS_CREDIT_CARD_NOTICE","Por favor ingrese su dirección de factura para realizar su pago");

//Jeremy.Wu 2019.4.17 定义本地取货
define('FS_LOCAL_PICKUP','Recoger en el almacén');

//报价改版 ternence 2019.04.17
define("FS_INQUIRY_INFO","Hoja de presupuesto");
define("FS_INQUIRY_INFO_1","Añadir productos");
define("FS_INQUIRY_INFO_2","Añadir");
define("FS_INQUIRY_INFO_3","Por favor, introduce el ID del producto en línea.");
define("FS_INQUIRY_INFO_4","Precio unitario");
define("FS_INQUIRY_INFO_5"," Tomar nota");
define("FS_INQUIRY_INFO_6","Editar");
define("FS_INQUIRY_INFO_7","¿Ya tienes una cuenta?");
define("FS_INQUIRY_INFO_8","Inicia sesión</a> o ");
define("FS_INQUIRY_INFO_9","Regístrate");
define("FS_INQUIRY_INFO_10","  para el seguimiento de tus solicitudes en línea.");
define("FS_INQUIRY_INFO_11","Informaciones que te podrían interesar");
define("FS_INQUIRY_INFO_12","Logotipo");
define("FS_INQUIRY_INFO_13","Garantía");
define("FS_INQUIRY_INFO_14","Plazo de entrega");
define("FS_INQUIRY_INFO_15","Descuento");
define("FS_INQUIRY_INFO_16","Orden de compra");
define("FS_INQUIRY_INFO_17","Comentarios adicionales");
define("FS_INQUIRY_INFO_18","Archivo");
define("FS_INQUIRY_INFO_19","Se permiten archivos con tipo de JPG, PDF, PNG, XLS, XLSX <br> El tamaño máximo de archivo es de 5M");
define("FS_INQUIRY_INFO_20","Enviar");
define("FS_INQUIRY_INFO_21","No hay ninguna solicitud.");
define("FS_INQUIRY_INFO_22","Seguir comprando");
define("FS_INQUIRY_INFO_24","La revisión dura aproximadamente 12 horas.");
define("FS_INQUIRY_INFO_25","Solicita presupuesto");
define("FS_INQUIRY_INFO_26","Éste es un producto personalizado. Por favor consulta la página del producto para elegir las especificaciones y luego añádelo a la lista.");
define("FS_INQUIRY_INFO_26_2","Este ID del producto");
define("FS_INQUIRY_INFO_26_3","no se encuentra en nuestra página web.");
define("FS_INQUIRY_INFO_27","Tu solicitud de presupuesto No.");
define("FS_INQUIRY_INFO_28"," se ha enviado.");
define("FS_INQUIRY_INFO_29","Procesaremos la cotización y te responderemos dentro de 12-24 horas. Podrás consultar el estado de tu cotización en <b>Mi cuenta</b> > <b>Historial de cotizaciones</b>. ");
define("FS_INQUIRY_INFO_30","¡Bienvenido! ");
define("FS_INQUIRY_INFO_30_1","Elegir atributos");
define("FS_INQUIRY_INFO_31","Crea una cuenta, y podrás consultar fácilmente las cotizaciones en tu centro de cuenta y disfrutar de más ventajas:");
define("FS_INQUIRY_INFO_32","- Seguimiento del estado de tu pedido en el historial de pedidos");
define("FS_INQUIRY_INFO_33","- Pago más rápido con una libreta de direcciones");
define("FS_INQUIRY_INFO_34","¿Quieres crear una cuenta ahora?");
define("FS_INQUIRY_INFO_35","No, gracias. (Te enviaremos la cotización por correo electrónico.)");
define("FS_INQUIRY_INFO_36","Sí, quiero crear una cuenta ahora.");

define("FS_INQUIRY_INFO_37","Historial de cotizaciones");
define("FS_INQUIRY_INFO_38","Confirma el estado de tu solicitud de cotización y compra directamente a precio preferencial. ");
define("FS_INQUIRY_INFO_39","Contactar con el servicio al cliente.");
define("FS_INQUIRY_INFO_40","Fecha de solicitud");
define("FS_INQUIRY_INFO_41","Cotización #");
define("FS_INQUIRY_INFO_42","Total");
define("FS_INQUIRY_INFO_43","Nombre de la cotización");
define("FS_INQUIRY_INFO_43_1","Ver más");
define("FS_INQUIRY_INFO_43_2","Cancelar");


define("FS_INQUIRY_INFO_44","Añadido a la lista de presupuesto");

define("FS_INQUIRY_INFO_45","Cantidad");
define("FS_INQUIRY_INFO_46","Ir a la lista");
define("FS_INQUIRY_INFO_47","Solicitud de presupuesto");
define("FS_INQUIRY_INFO_48","Lista de productos deseados");
define("FS_INQUIRY_INFO_23","Tu solicitud de cotización ");
define("FS_INQUIRY_INFO_23_1"," se ha enviado.");
define("FS_INQUIRY_INFO_49","Nombre de la cotización:");
define("FS_INQUIRY_INFO_50","Este presupuesto expirará después de X días. Por favor pague lo antes posible.");
define("FS_INQUIRY_INFO_51","Su presupuesto se ha expirado.");
define("FS_INQUIRY_INFO_52","Nota");
define("FS_INQUIRY_INFO_54","ID de producto#");
define("FS_INQUIRY_INFO_55","Se requiere el ID del producto online.");
define("FS_INQUIRY_INFO_56","Nombre completo*");
define("FS_INQUIRY_INFO_57","Dirección de correo electrónico*");
define("FS_INQUIRY_INFO_58","Número de teléfono*");
define("FS_INQUIRY_INFO_59","El producto ID ");
define("FS_INQUIRY_INFO_60"," no se encuentra en nuestra página web.");
define("FS_INQUIRY_INFO_61","Denomina esta cotización");
define("FS_INQUIRY_INFO_62","No. de cotización");
define("FS_INQUIRY_INFO_63","Por favor seleccione una opción para cada atributo.");
define("FS_INQUIRY_BUY_TIP",'Esta cotización solo es válida por 15 días, y la cantidad de pedidos debe ser igual o mayor que la de consultas, pague lo antes posible por favor.');
define("FS_INQUIRY_INFO_53","Lista de solicitud de cotización");
define("FS_INQUIRY_INFO_64","Todas las cotizaciones");
define("FS_INQUIRY_INFO_65","Esta cotización es válida solo por 15 días. Por favor, paga tu pedido lo antes posible.");
define("FS_INQUIRY_INFO_66","Tu cotización ha caducado.");

define('FS_INQUIRY_EMPTY_TXT','La solicitud de cotización está vacía.');
define('FS_INQUIRY_EMPTY_TXT_01','Solicita presupuesto en la página de producto, o introduce directamente un número de producto online.');
define('FS_INQUIRY_EMPTY_TXT_A','<p class="empty_txt">Si ya tienes una cuenta de FS, <a href="'.zen_href_link('login','','SSL').'">inicia sesión</a> para ver tus solicitudes de cotización.</p>');
define('FS_CREDIT','Mi cuenta de crédito');


//2019.7.29 helun add 新版账户中心首页语言包
define('FS_ACCOUNT_NEW_01','¿Necesitas ayuda?');
define('FS_ACCOUNT_NEW_02','lun.-vier.');
define('FS_ACCOUNT_NEW_03','Pedidos');
define('FS_ACCOUNT_NEW_04','Mis pedidos');
define('FS_ACCOUNT_NEW_05','Devoluciones');
define('FS_ACCOUNT_NEW_06','Crédito disponible:');
define('FS_ACCOUNT_NEW_07','Pedido reciente');
define('FS_ACCOUNT_NEW_08','Ver mis pedidos');
define('FS_ACCOUNT_NEW_09','No has realizado pedidos en mucho tiempo.');
define('FS_ACCOUNT_NEW_10','Productos vistos recientemente');
define('FS_ACCOUNT_NEW_11','Cotización reciente');
define('FS_ACCOUNT_NEW_12','Ver mis cotizaciones');
define('FS_ACCOUNT_NEW_13','No has solicitado ningún presupuesto.');

//2019.5.3 pico 企业账号注册

define("FS_BUSINESS_ACCOUNT_01","Beneficios con tu cuenta empresarial");
define("FS_BUSINESS_ACCOUNT_02","Cree una cuenta de empresa de FS hoy y disfrute de un 2% de descuento en productos seleccionados y servicios, entre otros beneficios.");
define("FS_BUSINESS_ACCOUNT_03","Precio preferencial");
define("FS_BUSINESS_ACCOUNT_04","Entrega rápida");
define("FS_BUSINESS_ACCOUNT_05","Cotización simple online");
define("FS_BUSINESS_ACCOUNT_06","Personalización profesional");
define("FS_BUSINESS_ACCOUNT_07",'¿Ya tienes cuenta? <a class="lr_right_href" href="' . zen_href_link('partner_update') . '">Actualizar la cuenta</a>');
define("FS_BUSINESS_ACCOUNT_08",'¿Necesitas ayuda? Estamos a tu disposición 24/7');
define("FS_BUSINESS_ACCOUNT_09",'Live Chat');
if ($_SESSION['languages_code'] == 'mx'){
    define("FS_BUSINESS_ACCOUNT_10",'+52 (55) 3098 7566');
    define("FS_BUSINESS_ACCOUNT_11",'mx@fs.com');
}else{
    define("FS_BUSINESS_ACCOUNT_10",'+34 (91) 123 7299');
    define("FS_BUSINESS_ACCOUNT_11",'es@fs.com');
}
define("FS_BUSINESS_ACCOUNT_12",'Tu solicitud de cuenta empresarial se ha enviado.');
define("FS_BUSINESS_ACCOUNT_13",'Bienvenido/a a unirse a FS. Su solicitud ha sido recibida, y su gerente de cuenta actualizará la cuenta a una empresarial lo antes posible.');
define("FS_BUSINESS_ACCOUNT_14",'Hemos recibido tu solicitud. Por favor, espera el resultado de nuestra verificación.');
define("FS_BUSINESS_ACCOUNT_15",'Haz clic aquí para entrar en el centro de cuenta.');
define("FS_BUSINESS_ACCOUNT_16",'Tu solicitud de cuenta empresarial está pendiente de verificación.');
define("FS_BUSINESS_ACCOUNT_17",'¿No tiene una cuenta? <a class="lr_right_href" href="' . zen_href_link('partner_submit') . '">  Registrar una cuenta de empresa</a>');
define("FS_BUSINESS_ACCOUNT_18",'Crear una cuenta de empresa');
define("FS_BUSINESS_ACCOUNT_19",'Actualizar la cuenta');
define("FS_BUSINESS_ACCOUNT_20",'Tu solicitud de cuenta empresarial está pendiente de verificación.');
//add by rebirth  结算页超重超大标签
define('FS_HEAVY','Pesado');
define('FS_OVERSIZED','Sobredimensionado');
//2019 5 3 定义武汉仓发货的文案优化
define('FS_HEADER_FREE_SHIPPING_CNMX_TIP','Envío rápido a');
define('FS_FOOTER_FREE_SHIPPING_CNMX_TIP','Envío mismo día');
define('FS_BANNER_FREE_SHIPPING_CNMX_TIP','Envío a');
define('FS_BANNER_FREE_SHIPPING_CNMX_TIP_END','el mismo día');

//add by jeremy 各语种公司名称
define('FS_LOCAL_COMPANY_NAME','FS.COM GmbH');
define('FS_US_COMPANY_NAME','FS.COM Inc.');
define('FS_DE_COMPANY_NAME','FS.COM GmbH');
define('FS_UK_COMPANY_NAME','FIBERSTORE Ltd.');
define('FS_AU_COMPANY_NAME','FS.COM Pty Ltd');
define('FS_SG_COMPANY_NAME','FS Tech Pte Ltd.');
define('FS_RU_COMPANY_NAME','FS.COM Ltd.');
define('FS_CN_COMPANY_NAME','FS.COM LIMITED');

//amp语言包
//十个专题模块
define('FS_AMP_CATE_01','25G/100G');
define('FS_AMP_CATE_02','40G');
define('FS_AMP_CATE_03','10G');
define('FS_AMP_CATE_04','DAC/AOC');
define('FS_AMP_CATE_05','Switches');
define('FS_AMP_CATE_06','WDM<br>MUX');
define('FS_AMP_CATE_07','Cable  <br>de fibra');
define('FS_AMP_CATE_08','Cables  <br>MTP/MPO');
define('FS_AMP_CATE_09','Cableado  <br>modular');
define('FS_AMP_CATE_10','Red  <br>de cobre');
//Interconnection产品模块
define('FS_AMP_INTERCONNECT_01','Interconexión');
//Optical Transport Network产品模块
define('FS_AMP_OPTICAL_TRANS_01','Red de Transporte Óptico');
//Network Cable Assemblies产品模块
define('FS_AMP_NETWORK_CABLE_01','Conjuntos de Cables de Red');
//Space Management产品模块
define('FS_AMP_SPACE_MANAGE_01','Administración de Espacio');
//Solution模块
define('FS_AMP_SOLUTION_01','Soluciones');
//公共底部模块
define('FS_AMP_FOOTER_01','Envíanos email');
define('FS_AMP_FOOTER_02','Live Chat');
define('FS_AMP_FOOTER_03','Live ChaSupport');
define('FS_AMP_FOOTER_04','Company');
define('FS_AMP_FOOTER_05','Quick Access');
define('FS_AMP_FOOTER_06','Copyright © 2009-2019 FS.COM Inc All Rights Reserved.');
define('FS_AMP_FOOTER_07','Privacy policy');
define('FS_AMP_FOOTER_08','Terms of use');
//第一级侧边栏
define('FS_AMP_FIRST_SIDEBAR_01','Cuenta / Iniciar sesión');
define('FS_AMP_FIRST_SIDEBAR_02','CATEGORIAS');
define('FS_AMP_FIRST_SIDEBAR_03','Red Empresarial');
define('FS_AMP_FIRST_SIDEBAR_04','Módulo Transceptor Óptico');
define('FS_AMP_FIRST_SIDEBAR_05','Cable Fibra Óptica');
define('FS_AMP_FIRST_SIDEBAR_06','Racks y Gabinetes');
define('FS_AMP_FIRST_SIDEBAR_07','WDM y Acceso Óptico');
define('FS_AMP_FIRST_SIDEBAR_08','Cable de Red y Accesorios');
define('FS_AMP_FIRST_SIDEBAR_09','Probadores y Herramientas');
define('FS_AMP_FIRST_SIDEBAR_10','Support');
define('FS_AMP_FIRST_SIDEBAR_11','Company');
define('FS_AMP_FIRST_SIDEBAR_12','Quick Access');
define('FS_AMP_FIRST_SIDEBAR_13','Ayuda & Configuración');
//所有二级分类侧边栏
define('FS_AMP_SECOND_SIDEBAR_01','Menú principal');
define('FS_AMP_SECOND_SIDEBAR_02','Red Empresarial');
define('FS_AMP_SECOND_SIDEBAR_03','Switches de Red');
define('FS_AMP_SECOND_SIDEBAR_04','Switches en Centro de Datos');
define('FS_AMP_SECOND_SIDEBAR_05','PDU, UPS, Sistema de Potencia');
define('FS_AMP_SECOND_SIDEBAR_06','Adaptadores de Red');
define('FS_AMP_SECOND_SIDEBAR_07','Routers, Servidores');
define('FS_AMP_SECOND_SIDEBAR_08','Conversores de Medios, KVM, TAP');
define('FS_AMP_SECOND_SIDEBAR_09','Módulo Transceptor Óptico');
define('FS_AMP_SECOND_SIDEBAR_10','Transceptores 40G/100G');
define('FS_AMP_SECOND_SIDEBAR_11','Transceptores SFP+');
define('FS_AMP_SECOND_SIDEBAR_12','Transceptores SFP');
define('FS_AMP_SECOND_SIDEBAR_13','Cables de Conexión Directa');
define('FS_AMP_SECOND_SIDEBAR_14','Cables Ópticos Activos');
define('FS_AMP_SECOND_SIDEBAR_15','Transceptores XFP');
define('FS_AMP_SECOND_SIDEBAR_16','Transceptores de Vídeo Digital');
define('FS_AMP_SECOND_SIDEBAR_17','Otros Transceptores');
define('FS_AMP_SECOND_SIDEBAR_18','FS Box');
define('FS_AMP_SECOND_SIDEBAR_19','Cable Fibra Óptica');
define('FS_AMP_SECOND_SIDEBAR_20','Cables Fibra Óptica MTP');
define('FS_AMP_SECOND_SIDEBAR_21','Latiguillos Fibra Óptica');
define('FS_AMP_SECOND_SIDEBAR_22','Cables Resistentes');
define('FS_AMP_SECOND_SIDEBAR_23','Cables Fibra Óptica MPO');
define('FS_AMP_SECOND_SIDEBAR_24','Cables Fibra Óptica Ultra HD');
define('FS_AMP_SECOND_SIDEBAR_25','Cables Multifibra Pre-terminados');
define('FS_AMP_SECOND_SIDEBAR_26','Pigtails Fibra Óptica');
define('FS_AMP_SECOND_SIDEBAR_27','Adaptadores y Conectores de FO');
define('FS_AMP_SECOND_SIDEBAR_28','Bobinas de Cable');
define('FS_AMP_SECOND_SIDEBAR_29','Racks y Gabinetes');
define('FS_AMP_SECOND_SIDEBAR_30','Racks y Gabinetes');
define('FS_AMP_SECOND_SIDEBAR_31','Distribuidores de Fibra Óptica');
define('FS_AMP_SECOND_SIDEBAR_32','Paneles de Adaptadores');
define('FS_AMP_SECOND_SIDEBAR_33','Paneles de Adaptadores');
define('FS_AMP_SECOND_SIDEBAR_34','Casetes de Fibra Óptica MPO');
define('FS_AMP_SECOND_SIDEBAR_35','Casetes de Fibra Óptica');

define('FS_AMP_SECOND_SIDEBAR_57','Paneles Breakout MTP-LC');
define('FS_AMP_SECOND_SIDEBAR_58','Gestión de Cables');
define('FS_AMP_SECOND_SIDEBAR_59','Sistema de Canalización');

define('FS_AMP_SECOND_SIDEBAR_36','WDM y Acceso Óptico');
define('FS_AMP_SECOND_SIDEBAR_37','Mux Demux y OADM');
define('FS_AMP_SECOND_SIDEBAR_38','Componentes Pasivos');
define('FS_AMP_SECOND_SIDEBAR_39','Terminación de Fibra');
define('FS_AMP_SECOND_SIDEBAR_40','FMT WDM Plataforma de Transporte');
define('FS_AMP_SECOND_SIDEBAR_41','Módulos de Infraestructura FMT');
define('FS_AMP_SECOND_SIDEBAR_42','Limpiadores y Probadores');
define('FS_AMP_SECOND_SIDEBAR_43','Cable de Red y Accesorios');
define('FS_AMP_SECOND_SIDEBAR_44','Cables de Red');
define('FS_AMP_SECOND_SIDEBAR_45','Cables Troncales Pre-terminados');
define('FS_AMP_SECOND_SIDEBAR_46','Bobinas de Cable');
define('FS_AMP_SECOND_SIDEBAR_47','Paneles de Conexión');
define('FS_AMP_SECOND_SIDEBAR_48','Gestión de Cables');
define('FS_AMP_SECOND_SIDEBAR_49','Herramientas y Probadores de Cobre');
define('FS_AMP_SECOND_SIDEBAR_50','Probadores y Herramientas');
define('FS_AMP_SECOND_SIDEBAR_51','Limpiadores de Fibra Óptica');
define('FS_AMP_SECOND_SIDEBAR_52','Probadores Básicos');
define('FS_AMP_SECOND_SIDEBAR_53','Probadores Avanzados');
define('FS_AMP_SECOND_SIDEBAR_54','Pulido y Empalme de Fibra');
define('FS_AMP_SECOND_SIDEBAR_55','Herramientas de Fibra Óptica');
define('FS_AMP_SECOND_SIDEBAR_56','Herramientas y Probadores de Cobre');
//三级分类侧边栏
define('FS_AMP_THIRD_SIDEBAR_01','Go back');
//登陆后侧边栏
define('FS_AMP_LOGIN_SIDEBAR_01','My Account');
define('FS_AMP_LOGIN_SIDEBAR_02','Account Setting');
define('FS_AMP_LOGIN_SIDEBAR_03','Order History');
define('FS_AMP_LOGIN_SIDEBAR_04','Address Book');
define('FS_AMP_LOGIN_SIDEBAR_05','My Cases');
define('FS_AMP_LOGIN_SIDEBAR_06','My Quotes');
define('FS_AMP_LOGIN_SIDEBAR_07','Sign out');
//搜索侧边栏
define('FS_AMP_SEARCH_01','Búsqueda caliente');
//语言选择
define('FS_AMP_SELECT_LANG_01','Seleccione país/región');
define('FS_AMP_SELECT_LANG_02','Guardar');
//订阅功能语言包(单页面，账户中心)
define('FS_EMAIL_SUBSCRIPTION_01','Suscripción por email');
define('FS_EMAIL_SUBSCRIPTION_02','Gestiona tus preferencias de suscripción por email y obtén las últimas noticias de FS.');
define('FS_EMAIL_SUBSCRIPTION_03','Suscripción por email');
define('FS_EMAIL_SUBSCRIPTION_04','Confirma el email por el que quieres gestionar tu suscripción.');
define('FS_EMAIL_SUBSCRIPTION_05','Suscríbete en FS para conocer más sobre las últimas políticas preferenciales, noticias de inventario, soporte técnico entre otros. Los emails de FS te mantendrán informado tanto de los nuevos productos como sobre las soluciones de centro de datos que tal vez no conozcas.');
define('FS_EMAIL_SUBSCRIPTION_06','Emails sobre tu cuenta y tus pedidos son importantes. Te enviaremos estos emails aunque hayas cancelado la recepción de marketing emails.');
define('FS_EMAIL_SUBSCRIPTION_07','Por favor ten en cuenta: Cualquier cambio puede tardar a lo más 48 horas en la realización. Seguirás recibiendo emails sobre pedidos, políticas preferenciales, noticias de inventario y soporte técnico durante este período.');
define('FS_EMAIL_SUBSCRIPTION_08','¿Con qué frecuencia quieres recibir promociones?');
define('FS_EMAIL_SUBSCRIPTION_09','Regular');
define('FS_EMAIL_SUBSCRIPTION_10','No más de una vez por semana');
define('FS_EMAIL_SUBSCRIPTION_11','No más de una vez por mes');
define('FS_EMAIL_SUBSCRIPTION_12','Nunca');
define('FS_EMAIL_SUBSCRIPTION_13','Guardar');
define('FS_EMAIL_SUBSCRIPTION_14','Cancelar');
define('FS_EMAIL_SUBSCRIPTION_15','¡Su solicitud ha sido enviada con éxito!');
define('FS_EMAIL_SUBSCRIPTION_16','Le responderemos dentro de 24 horas.');
define('FS_EMAIL_SUBSCRIPTION_17','Por favor, introduce tu propia dirección de correo electrónico.');
define('FS_EMAIL_SUBSCRIPTION_18','Ver, cambiar, o cancelar tu suscripción.');
define('FS_EMAIL_SUBSCRIPTION_19','<span class="iconfont icon">&#xf158;</span>Has cancelado la suscripción con éxito.');
define('FS_EMAIL_SUBSCRIPTION_20','No recibirás ningún email promocional de FS.');
define('FS_EMAIL_SUBSCRIPTION_21','<span class="iconfont icon">&#xf158;</span>Te has suscrito con éxito.');
define('FS_EMAIL_SUBSCRIPTION_22','Gracias por suscribirte a los emails de FS.');
define('FS_EMAIL_SUBSCRIPTION_23','Envíame las noticias de FS por correo electrónico una vez al mes.');
define('FS_EMAIL_SUBSCRIPTION_24','No recibirás correos electrónicos de invitación de comentarios de FS.');
define('FS_EMAIL_SUBSCRIPTION_25','No recibirás correos electrónicos de promoción y de invitación de comentarios de FS.');

//底部订阅语言包
define('FS_EMAIL_SUBSCRIPTION_FOOTER_01','Newsletter');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_02','Suscríbete y recibe noticias de ofertas y promociones.');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_03','Tu email');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_04','Por favor, introduce tu dirección de correo electrónico.');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_05','Por favor introduce una dirección de correo electrónico válida.');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_06','¡Gracias por tu suscripción!');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_07','Aplicación móvil');
//2019.5.27 新政策弹窗 pico
define('FS_SHIPPING_RETURNS','<a class="info_returns" href="javascript:;">'.FS_DELIVERY_RETURN.'</a>');
define('FS_SHIPPING_WARRANTY','<a class="info_warranty" href="javascript:;">Garantía</a>');
define('FS_SHIPPING_SUPPORT','<a class="" href="'.reset_url('product_support.html?products_id=###').'" target="_blank">Soporte de productos</a>');
define('FS_SHIPPING_RETURNS_TITLE','Devolución de 30 días');
define('FS_SHIPPING_RETURNS_PART',"FS ofrece el servicio de devolución y cambio en un plazo de 30 días para garantizar una buena experiencia de compra sin preocupaciones. Si la devolución o cambio se debe a nuestros fallos, nos encargaremos de todos los gastos de envío e impuestos generados. Consulte <a href ='".zen_href_link('index')."policies/day_return_policy.html' target='_blank'>Política de devolución</a> para conocer detalles sobre diferentes productos.");
define('FS_SHIPPING_WARRANTY_TITLE','Garantía de todo tipo de productos');
define('FS_SHIPPING_WARRANTY_PART',"Si algo sale mal, pero el producto ha superado el plazo de devolución, no se preocupe. Puede disfrutar del servicio de mantenimiento con tal que el producto esté dentro del período de garantía. Consulte el período de garantía particular de los productos en <a href ='".zen_href_link('index')."policies/warranty.html' target='_blank'>Política de garantía</a>.");
define('FS_SHIPPING_SUPPORT_TITLE','Soporte técnico gratuito');
define('FS_SHIPPING_SUPPORT_PART',"FS se dedica a hacerse un proveedor confiable de nuestros clientes y ofrecer un portafolio completo de productos de infraestructura digital y soluciones digitales integrales.");
define('FS_SHIPPING_SUPPORT_PART_BR',"Puedes <a href='".reset_url('solution_support.html')."' target='_blank'>solicitar soporte técnico</a> para cualquier pregunta sobre los productos o diseño gratuito de solución para la conectividad.");

//add by ternence 询价产品弹窗
define('FS_PRODUCT_INQUIRY_3','Su solicitud de cotización ha sido recibida por FS, y le responderemos lo antes posible.');
define('FS_PRODUCT_INQUIRY_1','Le responderemos dentro de 24 horas.');
define('FS_PRODUCT_INQUIRY_2','Al hacer clic en el botón de abajo, usted aceptará <a href="javascript:;" class=""> la Política de privacidad y cookies</a> y <a href="javascript:;">los Términos de uso</a> de FS.');


//add by ternence 结算页面地址提示
define('FS_SALES_INFO_MODAL_ZIP_CODE','Código postal*');
//退换货指引入口
define('FS_RETURN_BUTTON','Devolver un artículo');

//登陆超时
define('LOING_TIMEOUT','Tu sesión ha caducado por razones de seguridad. Por favor, Inicia sesión de nuevo.');
//产品详情AOC
define('PRODUCT_AOC','La longitud de cable personalizada puede ser de 1m a 300m (3ft a 984,252ft) según su necesidad.');
define('PRODUCT_AOC_1','La longitud de cable personalizada puede ser de 1m a 30m (3ft a 98,43ft) según su necesidad.');
//报价列表
define('QUOTE_EMPTY_1','Usted no ha solicitado ningún cotización.');
define('QUOTE_EMPTY_2','Empezar a comprar');
define('QUOTE_EMPTY_3','No se encuentran sus solicitudes de cotización.');

define("ATTRIBUTE_MESSAGE",'Compatible plenamente con switches de Cisco. Por favor, <a target="_blank" href="https://tmgmatrix.cisco.com"> haz clic aquí</a> para ver la matriz de compatibilidad.');

//首页cart sign in翻译
define('FILENAME_SIGN_IN','Identifícate');
define('FILENAME_HOME_CART','Cesta');

//购物车登陆且为空的状态 添加save cart入口
define('FS_SAVE_CART_ENTRANCE','Empieza a comprar en FS o visita tus <a target="_blank" href="'.zen_href_link('saved_items','type=saved_carts','SSL').'">cestas guardadas</a>.');
//报价添加打印
define('INQUIRY_GET_A_QUOTE','¿Necesitas ayuda con tu compra?');
define('INQUIRY_GET_A_QUOTE_1',"Siempre estamos dedicados a ofrecerte productos de alta calidad, precios favorables y procesamiento rápido de tu pedido. Llámanos al ");
define('INQUIRY_GET_A_QUOTE_2',' o escríbenos a ');
define('INQUIRY_GET_A_QUOTE_3','Imprimir');
define('INQUIRY_GET_A_QUOTE_4','DETALLES DE LA COTIZACIÓN');
define('INQUIRY_GET_A_QUOTE_5','Cant.');
define('INQUIRY_GET_A_QUOTE_6','Precio de cotización');


//add by liang.zhu 2019.07.04 functions_shippgin.php中的 zen_get_order_shipping_method_by_code函数使用
define('FS_CUSTOMER_ACCOUNT', 'Cuenta de cliente');

//qv库存提示
define('QV_SHOW_AVAILABLE_01', 'Disponible, necesita tránsito');
define('QV_SHOW_AVAILABLE_02', 'Disponible, en tránsito');

//清仓产品加购限制 Dylan 2019.8.27
define('FS_CLEARANCE_TIPS_TITLE','Existencias insuficientes');
define('FS_CLEARANCE_TIPS_CONTENT','La cantidad que necesitas excede nuestro inventario disponible <span class="clearance_total_qty">$QTY</span> pza(s). Por favor, ponte en contacto con tu gerente de cuenta para obtener una cantidad adicional.');
define('QV_CLEARANCE_TIPS','La cantidad que necesitas excede nuestro inventario disponible <span class="clearance_total_qty">$QTY</span> pza(s).');
define('QV_CLEARANCE_EMPTY_QTY_TIPS','Este producto ya está agotado. Ponte en contacto con tu gerente de cuenta para la disponibilidad.');

//文章分类
define('CASE_STUDIES_01','Región');
define('CASE_STUDIES_02','Norteamérica');
define('CASE_STUDIES_03','Latinoamérica');
define('CASE_STUDIES_04','Europa');
define('CASE_STUDIES_05','Oceanía');
define('CASE_STUDIES_06','África');
define('CASE_STUDIES_07','Medio Oriente');
define('CASE_STUDIES_08','Asia');
define('CASE_STUDIES_09','Tipo de caso');
define('CASE_STUDIES_10','OTN');
define('CASE_STUDIES_11','Red empresarial');
define('CASE_STUDIES_12','Cableado estructurado');
define('CASE_STUDIES_13','Sector');
define('CASE_STUDIES_14','Finanzas');
define('CASE_STUDIES_15','Educación');
define('CASE_STUDIES_16','Salud y medicina');
define('CASE_STUDIES_17','ISP');
define('CASE_STUDIES_18','Manufactura');
define('CASE_STUDIES_19','Transporte');
define('CASE_STUDIES_20','Minorista');
define('CASE_CLEAR_ALL','Borrar todos');
define("FS_PRODUCTS","resultados");
define("FS_PRODUCT","resultado");
define('CASE_CATEGORY_MENU_CASE_STUDIES','Casos de éxito');

define('FS_TEST_TOOL','Herramientas de prueba');
define('FS_ADDRESS_PO','PO');


// add yang
define('FS_PRODUCT_INSTALLATION_TEXT_1','Compatible con distribuidor fibra óptica FHD montaje<a href="es/c/fhd-rack-mount-45" style="color: #0070BC;"> en rack</a> y <a href="es/c/fhd-wall-mount-3358" style="color: #0070BC;">en pared</a>');
define('FS_PRODUCT_INSTALLATION_TEXT_2','Compatible con distribuidor fibra óptica <a href="'.zen_href_link('product_info','products_id=68911','SSL').'" style="color: #0070BC;">FHX-1UFSP</a>, que se puede montar en rack 19"');
define('FS_PRODUCT_INSTALLATION_TEXT_3','Compatible con distribuidor fibra óptica <a href="'.zen_href_link('product_info','products_id=72772','SSL').'" style="color: #0070BC;">FHX-1UFSP</a>, que se puede montar en rack 19"');
define('FS_PRODUCT_INSTALLATION_TEXT_4','Compatible con distribuidor fibra óptica <a href="'.zen_href_link('product_info','products_id=74183','SSL').'" style="color: #0070BC;">FHZ-1UFSP</a>, que se puede montar en rack 19"');
define('FS_ADDRESS_PO','PO');

// add by pico
define('CHECKOUT_ERROR_01', 'Por favor, elige el tipo de pago.');
define('CHECKOUT_ERROR_02', 'Se requiere el nombre del titular.');
define('CHECKOUT_ERROR_03', 'Se requiere el número de la tarjeta.');
define('CHECKOUT_ERROR_04', 'Se requiere el código de seguridad.');

//add by Jeremy 新版一級分類頁
define('FS_IDEAS_ADVICE', 'Descubre soluciones');
define('FS_BEST_SELLERS', 'Destacados');
define('FS_CASE_STUDIES', 'Estudio de casos');


//add ternence
define('INQUIRY_TITLE','Envía tu lista de solicitud de cotización');
define('INQUIRY_TITLE_1','Tu lista de cotización compartida');
define('INQUIRY_TITLE_2','La compartiste con éxito');
define('INQUIRY_TITLE_3','¡Éxito! Tu solicitud de cotización ha sido enviada a los destinatarios.');
define('INQUIRY_TITLE_4','Volver a la lista');
define('INQUIRY_TITLE_5','Correo electrónico enviado con éxito');
define('INQUIRY_TITLE_6','¡Alguien creó una lista de cotización para que tengas el acceso! Si necesitas más ayuda, puedes');
define('INQUIRY_TITLE_7','Añadir para la cotización');
define('INQUIRY_TITLE_8',' abajo para agregar lo que ves en esta página a tu cotización.');
define('INQUIRY_TITLE_9','Comparte lista de cotización');
define('INQUIRY_TITLE_10','Lista de cotización');
define('INQUIRY_TITLE_11',' te compartió una lista de solicitud de cotización. Puedes hacer clic en el botón abajo para ver los detalles completos y agregarlos a tu propia lista de cotizaciones.');
define('INQUIRY_TITLE_12',' te compartió una lista de cotización');
define('INQUIRY_TITLE_13','Añadir para la cotización');
define("FS_INQUIRY_INFO_67",'No hay ninguna solicitud. Si tienes una cuenta de FS, <a class="quote_sing" target="_blank" href="'.zen_href_link('login','','SSL').'">inicia sesión</a> para ver tus cotizaciones.');
define("FS_INQUIRY_INFO_68",'Email');
define("FS_INQUIRY_INFO_69",'Cant.');


//checkout 修改地址印度税号框提示
define('CHECKOUT_TAX_1','Número de IVA');
define('CHECKOUT_TAX_2','Si tienes un número de identificación de IVA válido, el IVA no se cobrará.');

// 2019-7-4 potato 登录注册need help
define('FS_SIGN_IN_NEED_HTLP',"¿Necesitas ayuda?");
define('FS_SIGN_IN_CONTACT_CUSTOMER_SUPPORT',"Ponte en contacto con el centro de atención al cliente.");


//ery  add 2019.7.15  赠品提示语
define('FS_GIFT_TITLE_IS','El siguiente artículo es un regalo gratuito y no se calculará en el precio total cuando pagues.');
define('FS_GIFT_TITLE_ARE','Los siguientes artículos son regalos gratuitos y no se calcularán en el precio total cuando pagues.');
define('FS_GIFT_TITLE_FREE','<div class="addCrat_item_giftBox after"><span class="iconfont icon"></span><div class="addCrat_item_giftTxt1">Regalo gratuito</div></div>');
define('FS_GIFT_CHECK_TITLE','El regalo gratuito no está disponible para esta dirección de entrega. Por favor, elige herramientas de prueba en la página del producto si las necesitas.');
define('FS_GIFT_TITLE_FREE_EMAIL','<div style="background: #ebf8e7;border-radius: 2px;display: inline-block;padding: 3px 10px;margin-bottom: 8px;line-height: 20px;"><span style="font-size: 16px;float: left;color: #18a109;"><img src="https://img-en.fs.com/includes/templates/fiberstore/images/pro-gift.png"></span><div style="padding-left: 21px;color: #18a109;">Regalo gratuito</div></div>');

// 2019-8-7 potato 隐私政策
define('FS_COMMON_PRIVACY_POLICY',' Acepto la <a href='.HTTPS_SERVER.reset_url('policies/privacy_policy.html').' target="_blank">Política de privacidad</a> y los <a href='.HTTPS_SERVER.reset_url('policies/terms_of_use.html').' target="_blank">Términos y condiciones</a> de FS.');
define('FS_COMMON_PRIVACY_POLICY_ERROR','Asegúrate de que aceptas nuestra Política de privacidad y los Términos y condiciones.');

define('NEW_PRODUCTS_TAG','Nuevo');

define('HOT_PRODUCTS_TAG','Destacado');


define("INVALID_CVV_ERROR",'El código de seguridad es incorrecto. Por favor introduce el código correcto e inténtalo de nuevo.');

define('FS_ACCOUNT_CODING_REQUESTS','Solicitudes de codificación');
define('FS_ACCOUNT_MY_CODING_REQUESTS','Mis solicitudes de codificación');
define('FS_ACCOUNT_CODING_REQUEST_BTN','Solicitar codificación');
define('CODING_REQUESTS_LIST','Lista de solicitudes de codificación');
define('CODING_REQUESTS_CODING_DETAILS','Detalles de la solicitud de codificación');

// 2019-7-19 potato 地址编辑提示修改
define("FS_POST_CODE_TITLE_ERROR","Se requiere el código postal.");
define("FS_CITY_TITLE_ERROR","Se requiere tu suburbio.");
define("FS_CHECKOUT_ERROR28_AU","Por favor, introduce un código postal válido.");
define("ACCOUNT_EDIT_CITY_AU","Suburbio");
define("ACCOUNT_EDIT_STATE_AU","Estado");
define("FS_ZIP_CODE_AU_NEW","Código postal");


//add by liang.zhu 2019.09.02
define('FS_COMMON_LEARN_MORE', 'Leer más');
define('FS_COMMON_SEE_MORE', 'Más');
define('FS_COMMON_SEE_LESS', 'Menos');

//模块标签属性
define('FS_PLACEHOLDER_EG','ej: ');
define('FS_OPTIONAL',' (opcional)');

// 2019-9-2 potato 俄罗斯的税号
define('FS_CHECK_OUT_TAX_NEW_RU','IVA');
define('FS_CHECK_OUT_INCLUDEING_RU','(IVA incluido)');
define('FS_CHECK_OUT_EXCLUDING_RU','(IVA excluido)');


//2019-9-7 Jeremy 购物车改版
define("FS_CART_ITEM_TOTAL","Total");
define("FS_CART_ATTR_BTN","Elegir atributos");
define("FS_CART_ATTR_CONTENT","Éste es un producto personalizado. Por favor, elige los atributos primero.");

// 表单提交次数频繁
define('FS_SUBMIT_TOO_OFTEN','Lo intentas con demasiada frecuencia. Por favor inténtalo de nuevo más tarde.');
define('FS_ROBOT_VERIFY_PROMOPT','Por favor sigue las indicaciones para completar la verificación.');

//2019-09-17 liang.zhu
define("CHECKOUT_TAXE_SG_TIT", "Sobre GST e impuestos aduaneros");
define("CHECKOUT_TAXE_SG_FRONT", "Para pedidos enviados desde nuestro almacén en Singapur a destinos en dicho país, FS está obligado a cobrar el GST a una tasa del 7% en los productos y el servicio de envío.<br/><br/> Si los artículos de tu pedido no están disponibles en el almacén en Singapur, los enviaremos directamente desde nuestro almcén en China, y no cobraremos el GST. Sin embargo, estos paquetes pueden tener tarifas de importación o de aduana. Los cargos adicionales por el despacho de aduana tendrían que ser asumidos por el destinatario.");
//新加坡其他10国家
define("CHECKOUT_TAXE_SG_OTHERS_TIT", "Sobre impuestos");
define("CHECKOUT_TAXE_SG_OTHERS_FRONT", "Para pedidos enviados a destinos fuera de Singapur, solo necesitas pagar los productos y los gastos de envío. No cobraremos el IVA o el GST. Sin embargo, estos paquetes pueden tener tarifas de importación o de aduana según las leyes de los países correspondientes. Los cargos adicionales por el despacho de aduana tendrían que ser asumidos por el destinatario.");

//mtp退货货提示语
define('FS_RETURN_ALL_MTP_PRODUCTS','Por favor, devuélvenos todos los accesorios.');

//2019-09-17 liang.zhu 国家所属于的洲
//北美洲
define('FS_STATE_NORTH_AMERICA', 'Norteamérica');
//澳洲
define('FS_STATE_OCEANIA', 'Oceanía');
//亚洲
define('FS_STATE_ASIA', ' Asia');
//欧洲
define('FS_STATE_EUROPE', 'Europa');
define('FS_PORTFOLIOS','portafolios');
define('FS_ORDER_LINK_REMARK','Nota');
define('FS_VIEW_INVOICE_BUBBLE','Por favor, ponte en contacto con tu gerente de cuenta para la nueva factura de este pedido.');

define("FS_TIME_ZONE_RULE_SG","(GMT+8)");
define("FS_JS_TIT_CHECK_SG","9:00am - 5:00pm ");
define("FS_SHIPPING_SG_GRAB_TIPS","Este servicio es disponible para pedidos de un solo envío enviados directamente desde nuestro almacén en Singapur y pagados antes de las 3:00pm en los días laborales.");
define("FS_TIME_ZONE_ADDRESS_SG","<span>FS almacén en Singapur:</span> 30A Kallang Pl, #11-10/11/12, Singapore 339213 | +65 6443 7951");

define('FS_SG_VAT_NUMBER',"Número de registro de GST");

//无时差报价
define('FS_SHOP_CART_ALERT_JS_121','Enviar tu cotización por correo electrónico');
define("FS_INQUIRY_REVIEWING_1",'Presentada');
define("FS_INQUIRY_QUOTED_1",'Cotizada');
define('FS_QUOTE_INFO_1','Detalles');
define("FS_INQUIRY_CANCELED_1",'Expirada');
define('FS_QUOTE_INFO_2','Precio unitario');
define('FS_QUOTE_INFO_3','Precio objetivo');
define('FS_QUOTE_INFO_4','Precio cotizado');
define('FS_QUOTE_INFO_5','(Precio excluidos impuestos y costos de envío)');
define('FS_QUOTE_INFO_6','Todos');
define('FS_QUOTE_INFO_8','Por favor, selecciona producto primero.');
define('FS_QUOTE_INFO_9','Gracias. Hemos enviado tu cotización al destinatario.');
define('FS_QUOTE_INFO_10','Volver');
define('FS_QUOTE_INFO_11','Solicitar otra vez');
define('FS_QUOTE_INFO_12','Solicita presupuesto');
define('FS_QUOTE_INFO_13','Resumen ( ');
define('FS_QUOTE_INFO_14',' artículo(s) ');
define('FS_QUOTE_INFO_15','Objetivo:');
define('FS_QUOTE_INFO_16','Precio excluidos impuestos y costos de envío');
define('FS_QUOTE_INFO_17','Esta cotización se hace basando en la lista completa de los productos. Si solo compras una parte de ellos, el descuento será inválido.');
define('FS_QUOTE_INFO_18','Esta cotización contiene varios descuentos de acuerdo con la cantidad de cada producto. Si reduces la cantidad de los productos que vas a comprar, el descuento de los productos seleccionados será inválido.');
define('FS_SEND_EMAIL_2019_1',"Hemos recibido tu solicitud de cotización ");
define('FS_SEND_EMAIL_2019_2',". Tu gerente de cuenta te dará una cotización en 30 minutos. Podrías encontrarlo en ");
define('FS_SEND_EMAIL_2019_3',"Mis cotizaciones");
define('FS_SEND_EMAIL_2019_4'," más tarde.");
define('FS_SEND_EMAIL_2019_5',"Tu cliente ");
define('FS_SEND_EMAIL_2019_6',"Solicitud de cotización");
define('FS_SEND_EMAIL_2019_7',"Producto");
define('FS_SEND_EMAIL_2019_8',"Cant.: ");
define('FS_SEND_EMAIL_2019_9',"Producto");
define('FS_SEND_EMAIL_2019_10',"Cant.");
define('FS_SEND_EMAIL_2019_11',"precio objetivo");
define('FS_SEND_EMAIL_2019_12',"Precio unitario");
define('FS_SEND_EMAIL_2019_13',"Subtotal:");
define('FS_SEND_EMAIL_2019_14',"Objetivo:");
define('FS_SEND_EMAIL_2019_15',"Hacer cotización");
define('FS_QUOTE_INFO_19','Fecha');
define("FS_INQUIRY_INFO_65_1"," Esta cotización es válida por 15 días, y expirará el ");
define("FS_INQUIRY_INFO_65_2",", caducará el ");
define("FS_INQUIRY_INFO_64_1","Todas");
define("FS_INQUIRY_INFO_65_3","Total:");

// rebirth  2019.08.16  订单支付超时提示语
define('FS_ORDERS_OVERTIMES_01','Por favor completa el pago dentro de ');
define('FS_ORDERS_OVERTIMES_02','');
define('FS_ORDERS_OVERTIMES_03','');
define('FS_ORDERS_OVERTIMES_02_PO','');//德语的在po方面有语法区别
define('FS_ORDERS_OVERTIMES_03_PO','');//德语的在po方面有语法区别
define('FS_ORDERS_OVERTIMES_04','De lo contrario, el pedido será cancelado automáticamente debido al cambio de inventario de productos.');
define('FS_ORDERS_OVERTIMES_05','Por favor sube el documento PO dentro de ');
define('FS_ORDERS_OVERTIMES_06','Nota: Escribe tu número de pedido cuando realices la transferencia bancaria para que procesemos tu pedido a tiempo. Por lo general, recibiremos tu pago dentro de 1-3 días hábiles.');
define('FS_ORDERS_OVERTIMES_07','Necesitamos verificar tu pedido debido a los siguientes motivos:');
define('FS_ORDERS_OVERTIMES_08','La dirección de entrega no coincide con las direcciones en tu formulario de solicitud de crédito');
define('FS_ORDERS_OVERTIMES_09','Tu crédito disponible se ha agotado.');
define('FS_ORDERS_OVERTIMES_10','Por favor paga los pedidos anteriores para recuperar tu crédito, o consulta "Mi crédito" para solicitar un aumento del límite de crédito. Verificaremos tu pedido y te enviaremos el resultado por correo electrónico.');
define('FS_ORDERS_OVERTIMES_11','Verificaremos tu pedido y te enviaremos el resultado por correo electrónico dentro de 12 horas.');
define('FS_ORDERS_OVERTIMES_12','Con el fin de que procesemos este pedido rápidamente, por favor paga los pedidos anteriores para recuperar tu crédito, o consulta "Mi crédito" para solicitar un aumento del límite de crédito.');
define('FS_ORDERS_OVERTIMES_13','Quedan');
define('FS_ORDERS_OVERTIMES_14','d'); //天  这三个是英文的 day  hour minute 首字母缩写
define('FS_ORDERS_OVERTIMES_15','h'); //时
define('FS_ORDERS_OVERTIMES_16','m'); //分
define('FS_ORDERS_OVERTIMES_17','Lo sentimos. Tu pedido está cerrado porque se ha pasado el plazo de pago.');
define('FS_ORDERS_OVERTIMES_18','Puedes encontrarlo en "Mis pedidos" y hacer clic en "Comprar otra vez" para realizar otro pedido.');
define('FS_ORDERS_OVERTIMES_19','Algo salió mal con tu pedido...');
define('FS_ORDERS_OVERTIMES_20','Hemos recibido tu pago de');
define('FS_ORDERS_OVERTIMES_21','Sin embargo, el pedido ya está cerrado porque se ha pasado el plazo (presentado en el pedido pendiente) de pago. Por favor ponte en contacto con tu gerente de cuenta para restablecer el pedido. Disculpa las molestias.');
define('FS_ORDERS_OVERTIMES_22','Hay pagos atrasados de tu cuenta Net 30. Por favor, paga los pedidos anteriores. O tu gerente de cuenta se pondrá en contacto contigo y te pedirá documentos adicionales para la revisión.');
// rebirth  2019.09.06  订单支付超时  提醒邮件语言包
define('FS_ORDERS_OVERTIMES_36','FS recordatorio de pago - Pago pendiente ');
define('FS_ORDERS_OVERTIMES_23','Recordatorio de pago');
define('FS_ORDERS_OVERTIMES_24','¡Gracias por elegir FS! No olvides completar tu pedido <b style="font-weight: 600;">');
define('FS_ORDERS_OVERTIMES_25','<b style="font-weight: 600;">Nota</b>:  En caso de que hayas realizado el pago, haz caso omiso a este mensaje, pues procesaremos tu pedido de inmediato. Si no deseas más tu pedido, por favor ignora este correo. Recuerda que al no completar tu pedido dentro del primer día hábil, tu pedido se anulará.');
define('FS_ORDERS_OVERTIMES_26','Cordialmente,');
define('FS_ORDERS_OVERTIMES_27','</b> será cancelado automáticamente dentro de ');
define('FS_ORDERS_OVERTIMES_28','</b>, <a style="color: #0070bc;text-decoration:none;" href="');
define('FS_ORDERS_OVERTIMES_29','">haciendo click aquí</a>. Una vez que realices el pago, procesaremos tu pedido de inmediato. Te recordamos que, de no procesar tu compra, tu pedido será anulado en ');



//by rebirth 2019.10.18 新版上传提示 西语
define("FS_UPLOAD_NEW_NOTICE_ONE","Por favor, sube un archivo PDF, JPG, PNG, DOC, DOCX, XLS, XLSX o TXT.");
define("FS_UPLOAD_NEW_NOTICE_TWO","Por favor, sube un archivo JPG, GIF, PNG, JPEG o BMP.");
define("FS_UPLOAD_NEW_NOTICE_THREE","Tamaño máximo: 5M.");
define("FS_UPLOAD_NEW_NOTICE_FOUR","Tamaño máximo: 300KB.");
define("FS_UPLOAD_NEW_ERROR_1","No se permite este archivo."); //该文件不允许上传
define("FS_UPLOAD_NEW_ERROR_2","Este archivo ya existe");  //文件已存在
define("FS_UPLOAD_NEW_ERROR_3","Error en la carga de archivos al servidor en la nube."); //文件上传云服务器失败
define('FS_UPLOAD_NEW_ERROR_4', 'El archivo subido excede el tamaño máximo de carga.');//文件大小超过php.ini的限制
define('FS_SHOP_CART_SG_INSTALL','Servicio de instalación gratuito disponible para productos en el almacén SG. Paga tu pedido para más información.');

define('FS_CHECKOUT_SGINSTALL_CC','Has elegido el servicio de instalación. Por favor, asegúrate de haber completado el pago antes de la fecha establecida para la instalación, o el servicio se retrasará.');
define('FS_SG_DELIVERY_FREE_RETURNS_CONTENT','El servicio de instalación gratuito está disponible para todos los productos en stock. Puedes elegir este servicio en la página de pago.');
define('FS_SG_DELIVERY_RETURN','Instalación gratuita');

define('FS_CHECKOUT_SGINSTALL_SUCCESS_1','Has elegido el servicio de instalación. Cuando tu pedido esté preparado para el envío, nuestro especialista técnico se pondrá en contacto contigo antes de dirigirse a tu lugar.');
define('FS_CHECKOUT_SGINSTALL_SUCCESS_2','Has elegido el servicio de instalación. Por favor, asegúrate de haber completado el pago antes de la fecha establecida para la instalación, o el servicio se retrasará.');
define('FS_CHECKOUT_SGINSTALL_SUCCESS_3','Has elegido el servicio de instalación. Por favor, asegúrate de haber subido el archivo PO antes de la fecha establecida para la instalación, o el servicio se retrasará.');

define('FS_SG_CALENDAR_1',"Elige el tiempo de instalación");
define('FS_SG_CALENDAR_2',"Elige tiempo disponible para la instalación");
define('FS_SG_CALENDAR_3',"Por favor, elige FS entrega e instalación.");
define('FS_SG_CALENDAR_4',"Elige tu tiempo preferido para la instalación.");
define("FS_SG_CALENDAR_5","Instalación in situ");
define("FS_SG_CALENDAR_6",'Cambio de entrega');
define("FS_SG_CALENDAR_7","Has cancelado todas las solicitudes de instalación. Arreglaremos el envío de tu pedido.");
define("FS_SG_CALENDAR_8","Cancelar");
define("FS_SG_CALENDAR_9","Confirmar");
define("FS_SG_CALENDAR_10",'Solo los productos marcados serán instalados después de la entrega.');
define("FS_SG_CALENDAR_11",'* El servicio de instalación está disponible actualmente para el/los producto(s) enviado(s) desde nuestro almacén SG. Disculpa las molestias.');
//rebirth 2019.10.25 新加坡上门服务-账户中心
define("FS_SG_CALENDAR_100","Solicitar instalación");
define("FS_SG_CALENDAR_101","Elige el tipo de servicio");
define("FS_SG_CALENDAR_102","Por favor selecciona");
define("FS_SG_CALENDAR_103","Soporte de proyecto");
define("FS_SG_CALENDAR_104","Solución de problemas y reparación");
define("FS_SG_CALENDAR_105","Por favor, elige el tipo de servicio.");
define("FS_SG_CALENDAR_106","Escribe los detalles sobre tu solicitud*");
define("FS_SG_CALENDAR_107","Por favor, describe tu solicitud.");
define("FS_SG_CALENDAR_108","Escribe al menos 4 caracteres.");
define("FS_SG_CALENDAR_109","Se permite un máximo de 500 caracteres.");
define("FS_SG_CALENDAR_110","Solicitud de instalación");
define("FS_SG_CALENDAR_111","Tipo de servicio");
define("FS_SG_CALENDAR_112","Hora programada");
define("FS_SG_CALENDAR_113","Detalles");
define("FS_SG_CALENDAR_114","Instalación programada");
define("FS_SG_CALENDAR_115","Hemos recibido tu solicitud de instalación.");
define("FS_SG_CALENDAR_116","Nuestro especialista técnico se pondrá en contacto contigo antes de dirigirse a tu dirección.");

define('FS_FESTIVAL16','Día festivo en Singapur');
define('FS_FESTIVAL17',' en almacén SG.');

//ternence 新加坡上门服务邮件
define("FS_SG_EMAIL","Gracias por elegir FS Singapur. Hemos recibido tu pedido pendiente ");
define("FS_SG_EMAIL_1","Completa el pago, y nos pondremos en contacto contigo una vez que tu pedido esté programado para la instalación gratuita.");
define("FS_SG_EMAIL_2","Algunos productos están disponibles para la instalación gratuita. Puedes <a href=".zen_href_link('manage_orders')." style=\"color: #0070BC;text-decoration: none\" target=\"_blank\">solicitar el servicio de instalación gratis</a> si lo necesitas. Paga tu pedido y nos pondremos en contacto contigo.");
define("FS_SG_EMAIL_3","Has elegido el servicio de instalación para tu pedido ");
define("FS_SG_EMAIL_4"," Te contactaremos cuando nuestro especialista técnico se dirija a tu lugar.");
define("FS_SG_EMAIL_5","Por favor, sigue el estado de tu pedido a través de iniciar sesión y consultar ");
define("FS_SG_EMAIL_6","Los detalles de tu pedido ");
define("FS_SG_EMAIL_7"," están a continuación. Te enviaremos un correo electrónico tan pronto como el estado de tu pedido cambie.");
define("FS_SG_EMAIL_8","Puedes seguir tu pedido a través de iniciar sesión y consultar ");
define("FS_SG_EMAIL_9"," Ten en cuenta que el servicio de instalación gratuito está disponible para este pedido. Puedes elegir un tiempo apropiado <a href=".zen_href_link('manage_orders')." style=\"color: #0070BC;text-decoration: none\" target=\"_blank\">aquí</a>.");
define("FS_SG_EMAIL_10","Tu pedido ");
define("FS_SG_EMAIL_11"," está preparado para la instalación. Nuestro especialista técnico se dirigirá a tu dirección a tiempo.");
define("FS_SG_EMAIL_12","Si hay cualquier cambio, por favor llámanos al <a style=\"color: #0070bc;text-decoration: none\" href=\"tel:+(65) 6443 7951\">+(65) 6443 7951</a> o envíanos email a <a style=\"color: #0070bc;text-decoration: none\" href=\"mailto:sg@fs.com\">sg@fs.com</a>.");
define("FS_SG_EMAIL_13","Gracias");
define("FS_SG_EMAIL_14","Equipo de FS");
define("FS_SG_EMAIL_15","Informaciones de contacto:");
define("FS_SG_EMAIL_16","Teléfono:");
define("FS_SG_EMAIL_17","Dirección:");
define("FS_SG_EMAIL_18","Hora programada:");
define("FS_SG_EMAIL_19","FS pedido ");
define("FS_SG_EMAIL_20"," - Recordatorio de instalación");
define("FS_SG_EMAIL_21","Gracias por elegir FS Singapur. Notamos que dejaste un pedido sin pagar ");
define("FS_SG_EMAIL_22"," con el servicio de instalación gratuito. Y sentimos que el servicio ha sido cancelado.");
define("FS_SG_EMAIL_23","<a href=".zen_href_link('manage_orders')." style=\"color: #0070BC;text-decoration: none\" target=\"_blank\">Haz clic aquí</a> para completar tu compra, y podrás elegir de nuevo un tiempo adecuado para el servicio de instalación en Mi cuenta.");
define("FS_SG_EMAIL_24","Tu FS pedido #");
define("FS_SG_EMAIL_25"," se ha enviado");
define("FS_SG_EMAIL_26","Recordatorio de instalación");
define("FS_SG_EMAIL_27","Instalación cancelada");
define("FS_SG_EMAIL_28","Recordatorio de pago");

define('FS_SHIPPING_SG_INSTALL_TIPS','Si eliges esta opción de envío, podrás seleccionar tu tiempo preferido para la instalación. El servicio de instalación solo está disponible para FS entrega e instalación gratuita.');

define('FS_SG_DELIVERY_INSTALLATION', 'FS entrega e instalación gratuita');
define('FS_SG_NEXT_WORKING_DAY', 'FS entrega el próximo día laboral');
define('FS_SG_SAME_WORKING_DAY', 'FS entrega el mismo día laboral');
define('FS_ACCOUNT_DETELE','Esta cuenta ha sido eliminada.');
define('FS_SG_SIMPLYPOST_SHIPPING', 'SimplyPost 1-3 días laborales');

//rebirth 2019.10.17 订单超时,分钟,工作日的单复数处理
define('FS_ORDERS_OVERTIMES_30','minuto');
define('FS_ORDERS_OVERTIMES_31','minutos');
define('FS_ORDERS_OVERTIMES_32','día hábil');
define('FS_ORDERS_OVERTIMES_33','días hábiles');
define('FS_ORDERS_OVERTIMES_34','');
define('FS_ORDERS_OVERTIMES_35','');

//liang.zhu 2019.10.31 product_support页面的service type, 同时也在my_case_details页面上使用
define('PRODUCT_SUPPORT_SERVICE_TYPE', 'Tipo de servicio');
define('PRODUCT_SUPPORT_SERVICE_TYPE_01', 'Uso de producto');
define('PRODUCT_SUPPORT_SERVICE_TYPE_02', 'Conectividad de enlace');
define('PRODUCT_SUPPORT_SERVICE_TYPE_03', 'Instalación y configuración');
define('PRODUCT_SUPPORT_SERVICE_TYPE_04', 'Otros');

//邀请评论
define("EMAIL_MESSAGE_TITTLE","Comparte tu experiencia");
define("EMAIL_MESSAGE_01","¿Como lo hicimos?");
define("EMAIL_MESSAGE_02","Déjanos tu opinión");
define('EMAIL_MESSAGE_CONTENT', 'Te agradeceremos mucho si puedes ayudarnos a mejorar y dejar referencias a otros clientes a través de escribir tus comentarios sobre tu recién pedido <a style="color: #0070bc;text-decoration: none;" href="javascript:;">#ORDER_NUMBER</a>. Sólo tomará un minuto, pero sería muy útil. Haz clic en el botón para dejarnos tu opinión.');
define('EMAIL_MESSAGE_SUBTITLE', '¿Necesitas ayuda sobre tu pedido?');
define('EMAIL_MESSAGE_SUB_CONTENT', 'Estamos a tu entera disposición para cualquier duda o consulta. Por favor, dirígete a <a style="color: #0070bc;text-decoration: none;" href="javascript:;">Centro de asistencia</a> para obtener ayuda rápida y profesional.');
define('EMAIL_TO_LICENSE_5','Ver más');
define('EMAIL_TO_LICENSE_6','Tienes un nuevo producto que queda por comentar en FS.COM');


//针对4，5星评论给客户发送第二封邮件
define('EMAIL_REVIEWS_FOUR_FIVE_01', 'Gracias por tu apoyo');
define('EMAIL_REVIEWS_FOUR_FIVE_02', 'Nos encantaría que puedas compartir tu experiencia de compra en el sitio web Trustpilot. Por favor, toma un momento para evaluar FS.');
define('EMAIL_REVIEWS_FOUR_FIVE_03', 'Tu calificación');
define('EMAIL_REVIEWS_FOUR_FIVE_04', 'Tu opinión (sea buena o mala) se publicará en Trustpilot.com de inmediato para ayudar a otras personas a tomar decisiones mejor informadas.');
define('EMAIL_REVIEWS_FOUR_FIVE_05', 'Gracias por tu tiempo. Esperamos volver a servirte pronto.<br>El equipo FS');
define('EMAIL_REVIEWS_FOUR_FIVE_06', 'Califícanos');
define('EMAIL_REVIEWS_FOUR_FIVE_07', 'Tu opinión nos importa - Gracias por compartir');


//表达修改 by rebirth  2019/11/13
define('FS_TECHNICAL_SUPPORT','Soporte técnico');
define('FS_REQUEST_SUPPORT','Consúltanos');

//账户中心报价改版2019/11/20
define("FS_INQUIRY_LIST_1",'Estado de cotización');
define("FS_INQUIRY_LIST_2",'Cotizaciones válidas');
define("FS_INQUIRY_LIST_3",'Contacta servicio al cliente');
define("FS_INQUIRY_LIST_4",'Buscar cotización:');
define("FS_INQUIRY_LIST_5",'Cotización #');
define("FS_INQUIRY_LIST_6",'Buscar');
define("FS_INQUIRY_LIST_7",'Fecha de solicitud:');
define("FS_INQUIRY_LIST_8",'Precio total');
define("FS_INQUIRY_LIST_9",'Cantidad:');
define("FS_INQUIRY_LIST_10",'Leer más...');
define("FS_INQUIRY_LIST_11",'Esta cotización es válida hasta ');
define("FS_INQUIRY_LIST_12",'Esta cotización ha expirado en ');
define("FS_INQUIRY_LIST_13",'No se encuentra ninguna cotización.');
define("FS_INQUIRY_LIST_14",'Empezar a comprar');
define("FS_INQUIRY_LIST_15",'Si no encuentras la cotización, intenta hacer un filtro con diferentes formas.');
define("FS_INQUIRY_LIST_16",'Detalles de la solicitud de cotización');
define("FS_INQUIRY_LIST_17",'Nombre de cotización:');
define("FS_INQUIRY_LIST_18",'Cotizar otra vez');
define("FS_INQUIRY_LIST_19",'Añadir a la cesta');
define("FS_INQUIRY_LIST_20",'Imprimir');
define("FS_INQUIRY_LIST_21",'SOLICITUD DE COTIZACIÓN');
define("FS_INQUIRY_LIST_22",'Producto');
define("FS_INQUIRY_LIST_23",'Precio del producto');
define("FS_INQUIRY_LIST_24",'Cantidad');
define("FS_INQUIRY_LIST_25",'Precio cotizado');
define("FS_INQUIRY_LIST_26",'ID de cliente:');
define("FS_INQUIRY_LIST_28",'Teléfono #:');
define("FS_INQUIRY_LIST_29",'Precio total cotizado:');
define("FS_INQUIRY_LIST_30",'La solicitud de cotización se ha enviado. Tu gerente de cuenta te responderá dentro de 24 horas.');
define("FS_INQUIRY_LIST_30_1",'La cotización está en proceso. Tu gerente de cuenta te responderá dentro de 24 horas.');
define("FS_INQUIRY_LIST_31",'Tu solicitud de cotización está en proceso. Te responderemos dentro de 24 horas.');
define("FS_INQUIRY_LIST_32",'A continuación se presentan los detalles de la cotización. Esta cotización es válida hasta ');
define("FS_INQUIRY_LIST_33",'Esta cotización ha expirado en ');
define("FS_INQUIRY_LIST_34",'. Puedes solicitar presupuesto otra vez si es necesario.');

define("FS_INQUIRY_LIST_35",'Cotización #');
define("FS_INQUIRY_LIST_36",'Fecha de solicitud:');
define("FS_INQUIRY_LIST_37",'Quote #:');
define("FS_INQUIRY_LIST_38",'Item: #');
define("FS_INQUIRY_LIST_38_1",'Producto#: ');
define("FS_INQUIRY_LIST_39",'Below is the sales quote you have requested.');
define("FS_INQUIRY_LIST_40",'REFRENCE');
define("FS_INQUIRY_LIST_41",'Imprimir');
define("FS_INQUIRY_LIST_42",'Fecha de cotización:');
// manage address
define("FS_CREATE_NEW_ADDRESS", 'Añadir una nueva dirección');
define("FS_DEFAULT", 'Por defecto');
define("FS_SAVE_ADDRESSES", 'Direcciones guardadas');
define("FS_EDIT_REMOVE", 'Editar/Eliminar');
define("FS_EDIT", 'Editar');
define("FS_REMOVE", 'Eliminar');
define("FS_NO_SHIPPING_ADDRESS_HISTORY", 'No hay dirección de entrega.');
define("FS_NO_BILLING_ADDRESS_HISTORY", 'No hay dirección de facturación.');

//2019.11.22 ery  add 账户中心订单产品加购提示语
define('FS_MANAGE_CUSTOM_TIP', 'Éste es un producto personalizado. Consulta la página del producto para seleccionar atributos y características.');
define('FS_MANAGE_CLOSE_TIP', 'Este producto ya no está disponible en línea. Ponte en contacto con tu gerente de cuenta para más información. O también puedes ver el producto similar online.');

/**
 * by  rebirth   账户中心改版——my_credit页面
 */
define('FS_NEW_ACCOUNT_MY_CREDIT_01','Tu cuenta');
define('FS_NEW_ACCOUNT_MY_CREDIT_02','');
define('FS_NEW_ACCOUNT_MY_CREDIT_03','Crédito utilizado');
define('FS_NEW_ACCOUNT_MY_CREDIT_04','Límite de crédito');
define('FS_NEW_ACCOUNT_MY_CREDIT_05','Solicita un aumento');
define('FS_NEW_ACCOUNT_MY_CREDIT_06','Busca tu pedido');
define('FS_NEW_ACCOUNT_MY_CREDIT_07','PO #, pedido#');
define('FS_NEW_ACCOUNT_MY_CREDIT_08','Fecha');
define('FS_NEW_ACCOUNT_MY_CREDIT_09','No hay historial de orden de compra.');
define('FS_NEW_ACCOUNT_MY_CREDIT_10','Empezar a comprar');
define('FS_NEW_ACCOUNT_MY_CREDIT_11','No se encuentra ninguna orden de compra.');
define('FS_NEW_ACCOUNT_MY_CREDIT_12','Buscar');


// 账户中心首页
define("FS_ACCOUNT_ADMINISTRATOR",'Administrador de cuenta:');
define("FS_ACCOUNT_NEW",'Cuenta #:');
define("FS_NAME",'Nombre');
define("FS_ACCOUNT_MANAGE_CONTACT",'Tu gerente de cuenta designado:');
define("FS_ACCOUNT_PHONE",'Teléfono:');
define("FS_ACCOUNT_ORDERS_PENDING",'Pendiente(s)');
define("FS_ACCOUNT_ORDERS_PROGRESSING",'En proceso');
define("FS_ACCOUNT_ORDERS_COMPLETED",'Completo');
define("FS_ACCOUNT_ORDERS_ACTIVE_QUOTE",'Estado de cotización');
define("FS_ACCOUNT_ORDERS_RMA",'RMA');
define("FS_ACCOUNT_ORDERS",'PEDIDOS');
define("FS_ACCOUNT_VIEW_TRACK_ORDERS",'Revisa el estado actual de tus pedidos');
define("FS_ACCOUNT_HISTORY",'Historial de pedidos');
define("FS_ACCOUNT_NEW_QUOTE_REQUEST",'Solicita presupuesto');
define("FS_ACCOUNT_QUOTE_STATUS",'Historial/Estado de cotización');
define("FS_ACCOUNT_NEW_RMA_REQUEST",'Solicita RMA');
define("FS_ACCOUNT_RMA_STATUS",'Historial/Estado de RMA');
define("FS_ACCOUNT_REVIEW_PURCHASES",'Califica tus pedidos');
define("FS_ACCOUNT_QUOTE_STATUS_TRACKING",'Consulta el estado de tu pedido y rastrea el envío');
define("FS_ACCOUNT_VIEW_ORDERS",'Mis pedidos');
define("FS_ACCOUNT_SEARCH_ORDERS",'Busca tu pedido:');
define("FS_ACCOUNT_PO_ORDER_ID",'PO #, pedido #, ID de producto');
define("FS_ACCOUNT_SEARCH",'Buscar');
define("FS_ACCOUNT_NET_TERMS",'CUENTA DE CRÉDITO');
define("FS_ACCOUNT_BUY_NOW_PAY_LATER",'Compra ya y paga después');
define("FS_ACCOUNT_CURRENT_BALANCE",'Crédito utilizado');
define("FS_ACCOUNT_VIEW_CREDIT_DETAILS",'Ver detalles de tu crédito');
define("FS_ACCOUNT_NACCOUNT_SETTINGS",'CONFIGURACIÓN DE LA CUENTA');
define("FS_ACCOUNT_PASSWORD_MAIL",'Contraseña y correo electrónico');
define("FS_ACCOUNT_USER_PHOTO",'Foto de perfil');
define("FS_ACCOUNT_USER_NAME",'Nombre de usuario');
define("FS_ACCOUNT_EMAIL_ADDRESS",'Dirección de correo electrónico');
define("FS_ACCOUNT_EMAIL_PASSWORD",'Contraseña');
define("FS_ACCOUNT_EMAIL_PREFERENCES",'Opciones de suscripción por correo electrónico');
define("FS_ACCOUNT_SHOPPING_TOOLS",'HERRAMIENTAS ÚTILES');
define("FS_ACCOUNT_USEFUL_SHOPPING",'Soporte y feedback');
define("FS_ACCOUNT_REQUEST_SAMPLE",'Pide una muestra');
define("FS_ACCOUNT_WRITE_REVIEW",'Déjanos tu opinión');
define("FS_ACCOUNT_USER_INFORMATION",'INFORMACIÓN DEL USUARIO');
define("FS_ACCOUNT_CASES_AND_ADDRESSES",'Centro de casos y direcciones');
define("FS_ACCOUNT_ADDRESS_BOOK",'Libreta de direcciones');
define("FS_ACCOUNT_CASE_CENTER",'Centro de casos');
define("FS_ACCOUNT_CASE_E_MAIL",'Email:');
define("FS_CREATE_SHIPPING_ADDRESS",'Añadir una nueva dirección de entrega');
define("FS_CREATE_BILLING_ADDRESS",'Añadir una nueva dirección de facturación');
define("FS_EDIT_SHIPPING_ADDRESS",'Editar tu dirección de entrega');
define("FS_EDIT_BILLING_ADDRESS",'Editar tu dirección de facturación');
define("FS_CONFIRMATION",'Confirmar la eliminación');
define("FS_DELETE_THIS_ADDRESS",'La eliminación de esta dirección no afectará ningún pedido pendiente que se entregará a esta dirección.');
define("FS_SAVED_ADDRESSES",'Direcciones guardadas');
define("FS_SAVE_AS_DEFAULT",'Predeterminada');
define("FS_ACCOUNT_TAX_EXEMPTION",'FS.COM INC charges tax on orders shipping to a number of states where FS is required to collect tax. If you are a  tax-exemption organization, you may click "<a class="alone_a" href="'.zen_href_link('tax_exemption','','SSL').'">Apply for Tax Exemption</a>" for tax exempted.');

define('FS_SALES_INFO_MODAL_TITLE','A?adir una nueva dirección');
define('FS_SALES_INFO_MODAL_FNAME','Nombre');
define('FS_SALES_INFO_MODAL_LNAME','Apellido');
define('FS_SALES_INFO_MODAL_COUNTRY','País/Región');
define('FS_SALES_INFO_MODAL_ADS_TYPE','Tipo de dirección');
define('FS_SALES_INFO_MODAL_COMPANT','Nombre de empresa');
define('FS_SALES_INFO_MODAL_VAT','Número de VAT/TAX');
define('FS_SALES_INFO_MODAL_ADS1','Dirección');
define('FS_SALES_INFO_MODAL_ADS2','Dirección 2');
define('FS_SALES_INFO_MODAL_CITY','Ciudad/pueblo');
define('FS_SALES_INFO_MODAL_SPR','Estado/Provincia/Región');
define('FS_SALES_INFO_MODAL_STATE','Por favor seleccione estado');
define('FS_SALES_INFO_MODAL_ZIP_CODE_NEW','Código postal');
define('FS_SALES_INFO_MODAL_PHONE_NUM','Número de teléfono');
define('FS_SALES_INFO_MODAL_BTN_CANCEL','Cancelar');
define('FS_SALES_INFO_MODAL_BTN_SAVE','Conservar');
define('FS_SALES_INFO_MODAL_ADS1_HOLDER','Calle');
define('FS_SALES_INFO_MODAL_ADS2_HOLDER','Edificio, piso, puerta, etc.');

define('FS_SALES_DETILS_TYPE1','Reembolso');
define('FS_SALES_DETILS_TYPE2','Cambio');
define('FS_SALES_DETILS_TYPE3','Reparación');
define('FS_RMA_NAVI1','Confirmación de RMA');
define('FS_RMA_NAVI2','Historial de RMA');
define('FS_RMA_NAVI3','Detalles de la RMA');
define('FS_RMA_NAVI4','RMA');
define('FS_RMA_NAVI5','Solicita RMA');
define('FS_RMA_DETAILS_NAVI1','Detalles de la devolución y del reembolso');
define('FS_RMA_DETAILS_NAVI2','Detalles del cambio');
define('FS_RMA_DETAILS_NAVI3','Detalles de la reparación');

//2019.11.26 再次付款页面提示语
define('FS_CHECKOUT_AGAINST_TRANSFER_PLEASE', 'Por favor, realiza la transferencia a la siguiente cuenta.');


define('FS_RMA_SEARCH_TIPS','Todas las RMAs');

define("FS_ACCOUNT_REQUEST_A_SAMPLE",'Pide una muestra');
define("FS_ACCOUNT_USEFUL_TOOLS",'RECURSOS ÚTILES');
define("FS_ACCOUNT_SUPPORT_FEEDBACK",'Soporte y feedback');
define("FS_ACCOUNT_CANCEL",'Eliminar');
define("FS_ACCOUNT_SHIPPING_ADDRESS",'Dirección de entrega');
define("FS_ACCOUNT_BILLING_ADDRESS",'Dirección de facturación');
define('ACCOUNT_MY_HOME','Inicio');
define("FS_REVIEW_PURCHASE_10",'Pedido #, producto #');

define('FS_INDEX_FPE_TITLE','Productos destacados');
define('FS_INDEX_ETN_TITLE','Exploración de la red');
define('FS_INDEX_SERVICE_TITLE','Servicios');
define('FS_ACCOUNT_TITLE','Estado de pedido');
define('FS_ACCOUNT_BTN','Rastrea mi pedido');
define('FS_ACCOUNT_CONTENT','Rastrea tu paquete para obtener la información de envío y la fecha estimada de entrega.');
define('FS_ACCOUNT_TITLE_REGISTER','Crea una cuenta');

define('FIBER_SPARKASSE_BANK_NAME','Nombre del banco beneficiario:');

//订单详情
define('FS_PRINT_QTY','Cantidad');
define('FS_PRINT_UNIT_PRICE','Precio unitario');
define('FS_PRINT_TOTAL','Total');
define('FS_PRINT_SHIPMENT','Envío');
define('FS_PRINT_SUBTOTAL','Subtotal:');
define('FS_PRINT_SHIPPING_COST','Costo de envío:');
define('FS_PRINT_SHIPPING_TAX','IVA/TAX:');
define('FS_PRINT_TOTAL_WIDTH_COLON','Total:');
define('FS_PRINT_ITEM','Artículo');

//税后价公用语言包 add dylan 2020.5.13
define('FS_BLANKET_32','Costo de envío');
define('FS_BLANKET_33','Importe de GST');
define('FS_BLANKET_34','Total');
define('FS_BLANKET_35','GST incluido');

define('ACCOUNT_EDIT_CITY_FROMAT_TIP','Escribe al menos 2 caracteres.');
define('ACCOUNT_EDIT_SUBCITY_FROMAT_TIP','Escribe al menos 2 caracteres.');

//报价相关
define('INQUIRY_QUOTE_LIST_1','Solicita cotización');
define('INQUIRY_QUOTE_LIST_2','Historial de cotizaciones');

define('FS_CHECKOUT_ERROR_VAT','Introduce un número de IVA válido. ej: $VAT');
define('FS_CHECKOUT_POPUP_TIPS','¿Quieres volver a tu cesta de compra?');
define('FS_CHECKOUT_POPUP_TIPS_QUOTE','¿Quieres volver a la cotización?');
define('FS_CHECKOUT_POPUP_BUTTON1','No, pago ahora');
define('FS_CHECKOUT_POPUP_BUTTON2','Sí');
define('FS_CHECKOUT_PAYMENT','Pago');
define('FS_CHECKOUT_PAYMENT_PO','Subir PO');


// MUX流程轴节点
define('FS_ORDER_CUSTOMIZED','Personalizar');
define('FS_ORDER_MANUFACTURING','Producir');
define('FS_ORDER_TEST_PASS','Probar');
define('FS_ORDER_SHIPPED','Enviado');
define('FS_ORDER_TEST_REPORT','Informe de prueba');
//报价语言包
define('INQUIRY_LISTS_1','Todas las cotizaciones');
define('INQUIRY_LISTS_2','Válida');
define('INQUIRY_LISTS_3','Aceptada');
define('INQUIRY_LISTS_4','Has realizado pedido con esta cotización con éxito.');
define('INQUIRY_LISTS_5','REFERENCIA');
define('INQUIRY_LISTS_6','Detalles de la cotización');
define('FS_INQUIRY_INFO_66_1','Esta solicitud de cotización ha expirado en ');
define('FS_INQUIRY_INFO_66_6','Esta solicitud de cotización ha expirado en ');
define('FS_INQUIRY_INFO_66_2',' Puedes solicitar otra vez si es necesario.');
define('FS_INQUIRY_INFO_66_3','Esta cotización ha expirado en ');
define('FS_INQUIRY_INFO_66_7','Esta cotización ha expirado en ');
define('FS_INQUIRY_INFO_66_4','Esta cotización es válida hasta ');
define("FS_INQUIRY_LIST_27",'Gerente de cuenta:');
define('FS_INQUIRY_INFO_66_5','Puedes pagar los productos directamente después de obtener la cotización de tu gerente de cuenta.');
define('FS_QUOTE','Cotización');
define('INQUIRY_LISTS_7','Todo el tiempo');
define('INQUIRY_LISTS_8','Historial de cotizaciones');
define('INQUIRY_LISTS_9','Historial de cotización');
define('INQUIRY_LISTS_10','Solicitud de cotización');
define('INQUIRY_LISTS_11','Solicitud de cotización');

define('FS_PRODUCTS_INFO_NOTE_TITLE','Nota: ');
define('FS_PRODUCTS_INFO_NOTE_TIPS','El transceptor CFP coherente no se vende por separado.');


/**
 *   po 暂停授信提示语 add by rebirth  2020/01.07
 */
define('FS_PO_FORZEN_NOTICE_01','Tu cuenta de crédito está en el estado de "Suspensión de crédito" y la opción de pago con crédito comercial ya no está disponible. Por favor <a href="'.zen_href_link('manage_orders','','SSL').'" target="_blank">paga los pedidos anteriores</a> o elige otro método de pago.');
define('FS_PO_FORZEN_NOTICE_02','Tu cuenta de crédito está en el estado de "Suspensión de crédito". Conoce más información en la página de los detalles.');

define('FS_PO_FORZEN_NOTICE_03','Tu cuenta de crédito está en el estado de "Suspensión de crédito". Por favor <a href="'.zen_href_link('manage_orders','','SSL').'">paga los pedidos anteriores</a> o ponte en contacto con tu gerente de cuenta para más información.');


define("FS_ACCOUNT_RMA_ORDERS",'Pedidos RMA');
define("FS_ACCOUNT_PO_NUMBER",'PO #');
define("FS_ACCOUNT_REQUEST_RMA",'Solicita RMA');
define("FS_ACCOUNT_RMA_HISTORY",'Historial de RMA');
define("FS_ACCOUNT_PO_ORDER",'Envía/Consulta PO');
define("FS_ACCOUNT_REVIEW_YOUR_ORDER",'Escribe tu reseña de pedido');
define("FS_ACCOUNT_QUOTES",'COTIZACIONES');
define("FS_ACCOUNT_QUICK_QUOTE",'Solicita un presupuesto y consulta el estado de tu cotización');
define("FS_ACCOUNT_ACTIVE",'Cotización válida');
define("FS_ACCOUNT_QUOTE_HISTORY",'Historial de cotizaciones');
define("FS_ACCOUNT_REQUEST_QUOTE",'Solicita cotización');
define("FS_ACCOUNT_ORDER_PENDING",'Pedidos pendientes');
define("FS_ACCOUNT_ORDER_PROGRESSING",'Pedidos en proceso');
define("FS_ACCOUNT_ORDER_COMMENTS",'Observaciones:');
define('INQUIRY_LISTS_12','Expira en: ');
define('INQUIRY_LISTS_13','Creada por: ');
define('INQUIRY_LISTS_14','Gerente de cuenta: ');


//support
define("SUPPORT_PAGE","Bienvenido/a a FS soporte al cliente. ¿En qué podemos ayudar?");
define("SUPPORT_PAGE_1","Ayuda instantánea");
define("SUPPORT_PAGE_2","Live Chat");
define("SUPPORT_PAGE_3","Descargas");
define("SUPPORT_PAGE_4","Leer más");
define("SUPPORT_PAGE_5","Soporte técnico");
define("SUPPORT_PAGE_6","Solicita presupuesto");
define("SUPPORT_PAGE_7","Casos de éxito");
define("SUPPORT_PAGE_8","Vídeos");
define("SUPPORT_PAGE_9","Comunidad");
define("SUPPORT_PAGE_10","Información de interés");
define("SUPPORT_PAGE_11","Política de devoluciones");
define("SUPPORT_PAGE_12","Rastrea tu paquete");
define("SUPPORT_PAGE_13","Pide una muestra");
define("SUPPORT_PAGE_14","Centro de asistencia");
define('FS_SUPPORT','Solicita soporte');

define('FS_BY_CLICKING','Al hacer clic en \'Confirmar el pedido\', aceptas nuestros');
define('FS_TERMS_AND_CONDITIONS','Términos y condiciones');
define('FS_CHECKOUT_AND',' y  ');
define('FS_PRIVACY_AND_COOKIES',' Privacidad y cookies');
define('FS_AND_RIGHT_OF_WITHDRAWL',' y derecho de retractación.');
define('FS_SEND_EMAIL_PAYMENT',"Demande de Paiement");
define("FS_ZIP_CODE_EU","Código postal");
define("FS_ADDRESS_EU","Dirección");
define("FS_ADDRESS2_EU","Dirección 2");
define('ACCOUNT_EDIT_CITY_EU','Ciudad');


//feedback select 2020-03-02 jay
define('FS_GIVE_FEEDBACK_TIP_1','Gracias por visitar FS. Para obtener asistencia inmediata, por favor consulta nuestro');
define('FS_GIVE_FEEDBACK_TIP_2','Soporte de FS');//链接
define('FS_GIVE_FEEDBACK_TIP_3','o inicia sesión en');
define('FS_GIVE_FEEDBACK_TIP_4','Live Chat');//链接
define('FS_GIVE_FEEDBACK_TIP_5','.');
define('FS_FEEDBACK_SELECT_1', 'Diseño de sitio web');
define('FS_FEEDBACK_SELECT_2', 'Búsqueda y navegación');
define('FS_FEEDBACK_SELECT_3', 'Producto');
define('FS_FEEDBACK_SELECT_4', 'Gestión de pedido y pago');
define('FS_FEEDBACK_SELECT_5', 'Envío y entrega');
define('FS_FEEDBACK_SELECT_6', 'Devolución y cambio');
define('FS_FEEDBACK_SELECT_7', 'Servicio y soporte');
define('FS_FEEDBACK_SELECT_8', 'Sugerencia para sitio web');

define('FS_AND',' y ');
define('FS_RIGHT_OF_WITHDRAWL','Derecho de retirada');
define('FS_RIGHT_OF_WITHDRAWL_01','');
define('FS_CHECKOUT_ERROR3_EU','Se requiere tu dirección.');
define('INQUIRY_LISTS_15','Sí');


// 2020-03-16  e-rate   rebirth
define('FS_ERate_01','E-rate');
define('FS_ERate_02','E-rate para educación y aprendizaje');
define('FS_ERate_03','Sala de servidores');
define('FS_ERate_04','Aula');
define('FS_ERate_05','Sala de conferencias');
define('FS_ERate_06','Laboratorio');
define('FS_ERate_07','Ponte en contacto con un especialista de EDU');
define('FS_ERate_08','lun. - vier. 9:00 a.m. - 5:00 p.m. EST');
define('FS_ERate_09','+1 (888) 468 7419');
define('FS_ERate_10','Descuentos E-Rate');
define('FS_ERate_11','Aprovecha los fondos del programa E-Rate obteniendo descuentos en telecomunicaciones. Este programa está disponible para la mayoría de los colegios y las bibliotecas públicos y privados de Estados Unidos. Es nuestro honor servirte y te proporcionaremos las mejores soluciones de acuerdo con tu específica necesidad.');
define('FS_ERate_12','FS SPIN (498 ID): 143051712');
define('FS_ERate_13','Consulta E-rate');
define('FS_ERate_14','Déjanos tu email o llámanos');
define('FS_ERate_15','Por favor, escribe tu dirección de correo electrónico.');
define('FS_ERate_16','Por favor, escribe una dirección de correo electrónico válida.');
define('FS_ERate_17','¡Gracias! Nos pondremos en contacto contigo lo antes posible.');
define('FS_ERate_18','Interconexiones DWDM 10G 120km en una red de campus');
define('FS_ERate_19','FS FMU DWDM y los dispositivos del modelo FMT ofrecen una transmisión de alta calidad a larga distancia de una simple manera.');
define('FS_ERate_20','Leer más');
define('FS_ERate_21','señor/señora');
define('FS_ERate_22','Hemos recibido tu solicitud de E-Rate, y nos pondremos en contacto contigo lo antes posible. Con tu número de caso $CNxxxxxxx podrás consultar todas las novedades concernientes a tu solicitud.');
define('FS_ERate_23','FS - Hemos recibido tu solicitud de E-Rate ');
define('FS_ERate_24','Casos de éxito');
define('FS_ERate_25','Laboratorio');
define('FS_ERate_26','Dirección de correo electrónico');
define('FS_ERate_27','E-Rate para educación ');
define('FS_ERate_28','Soporte E-Rate');
define('FS_ERate_29','Obtén descuentos con fundos E-Rate');

define('CART_SHIPPING_METHOD_CHECKOUT_PRE','Envío:');
define('CART_SHIPPING_METHOD_CHECKOUT_TEXT','Calculado en el pago');
define('FS_COMMON_GSP_1','enviado desde y vendido por FS Asia');
define('FS_COMMON_GSP_2','Derechos de importación');
define('FS_COMMON_GSP_3','incluidos');
define('FS_COMMON_GSP_4','Los derechos de importación y la tarifa por presentación a la aduana están incluidos.');
define('FS_COMMON_5','Cerrar');


define("FS_SHOP_CART_LIST_SUB","Subtotal");


//详情页定制弹窗文字优化 2020.3.19  ery
define('FS_DETAIL_CUSTOM_1', 'Personalización');
define('FS_DETAIL_CUSTOM_2', 'Producción');
define('FS_DETAIL_CUSTOM_3', 'Envío');
define('FS_DETAIL_CUSTOM_4', 'Entrega');
define('FS_DETAIL_CUSTOM_5', 'Tiempo estimado de producción: ');
define('FS_DETAIL_CUSTOM_6', 'Tiempo estimado de envío: ');
define('FS_DETAIL_CUSTOM_7', 'Tiempo estimado de entrega: ');

//GSP库存展示相关文字 2020.0.20 ery
define('FS_GSP_STOCK_1', 'Personalizado');
define('FS_GSP_STOCK_2', 'producto internacional');
define('FS_GSP_STOCK_3', 'enviado desde ');
define('FS_GSP_STOCK_4', 'FS Asia');
define('FS_GSP_STOCK_5', 'Depósito de los derechos de importación');
define('FS_GSP_STOCK_6', 'incluidos');
define('FS_GSP_STOCK_7', 'El artículo se enviará desde nuetro almacén en Asia de acuerdo con el <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">Programa de envíos globales (GSP)</a>. FS ayudará en la declaración aduanera y en el pago de los impuestos de importación. <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">Leer más</a>');
define('FS_GSP_STOCK_8', 'Cerrar');
define('FS_GSP_STOCK_9', 'Este artículo se enviará desde nuetro almacén en Asia de acuerdo con el <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">Programa de envíos globales (GSP)</a>. FS ayudará en la declaración aduanera y en el pago de los impuestos de importación. El impuesto de ventas se incluirá en la página de pago. <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">Leer más</a>');
define('FS_AVAILABLE', 'Disponible');
define('FS_LOACAL_EMPTY_INSTOCK_SHOW','Este artículo se enviará desde nuestro almacén global en Asia.');

define('FS_OUTBREAK_NOTICE', 'Estamos a tu disposición - Una carta de FS sobre COVID-19');
define('FS_OUTBREAK_NOTICE_M', 'Una carta de FS sobre COVID-19');
define('FS_OUTBREAK_READ_MORE', 'Leer más');


//subtotal(有税收的带上税收)
define('FS_SHOP_CART_EXCL_VAT','IVA ($VAT)');
define('FS_SHOP_CART_EXCL_SG_VAT','GST (7%)');
define('FS_SHOP_CART_EXCL_AU_VAT','GST en Austraria (10%)');
define('FS_SHOP_CART_EXCL_DE_VAT','IVA en Alemania ($VAT)');

//详情页交期提示语
define('FS_GSP_LOCAL_STOCK_DELIVERY_TIPS','La fecha de entrega se aplica a los pedidos con existencias disponibles solicitados antes de las 5pm EST en días hábiles. Los pedidos realizados después se enviarán el próximo día hábil. Si la cantidad que compras excede nuestro inventario, el pedido se enviará desde nuestro almacén en Asia de acuerdo con el <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">Programa de envío global (GSP)</a>.');
define('FS_GSP_COVID_TIPS','Además, debido a la situación provocada por la COVID-19, habría un retraso en el servicio de entrega. Por favor, rastrea tu paquete consultando <a href="'.reset_url('/login.html').'" target="_blank">Mi cuenta</a>. ');


define('PRODUCTS_WARRANTY','transceptores');
define('PRODUCTS_WARRANTY_1','Programa de ');
define('PRODUCTS_WARRANTY_2','pruebas de calidad');
define('PRODUCTS_WARRANTY_3',' para ');
define('PRODUCTS_WARRANTY_4','Envíos y entregas');
define('PRODUCTS_WARRANTY_5','WARRANTY_YEARS años de garantía');
define('PRODUCTS_WARRANTY_5_1','WARRANTY_YEARS años de garantía');
define('PRODUCTS_WARRANTY_6','Garantía de por vida');
define('PRODUCTS_WARRANTY_7','Devoluciones gratuitas');

//打印发票 VAT No 本地化
define('FS_VAT_NO_EU','N° de IVA: ');
define('FS_VAT_NO_AU','ABN : ');
define('FS_VAT_NO_SG','GST Reg No. : ');
define('FS_VAT_NO_BR','CNPJ : ');
define('FS_VAT_NO_CL','RUT : ');
define('FS_VAT_NO_AR','CUIT : ');
define('FS_VAT_NO_DEFAULT','Tax No.: ');

//购物车saved_items、saved_cart_details
define('FS_SAVED_CARTS','Cestas guardadas');
define('FS_ALL_SAVED_CARTS','Todas las cestas guardadas');
define('FS_ADD_ALL_TO_CARTS','Añadir todo');
define('FS_GO','Ir');
define('FS_SHOW_CART','Mostrar');
define('FS_SEARCH','Buscar');
define('FS_CART_NAME','Nombre de la cesta');
define('FS_SEARCH_SAVED_CARTS','Buscar cesta guardada');
define('FS_DATE_SAVED','Fecha');
define('FS_CUSTOMER_ID','ID del cliente');
define('FS_ACCOUNT_MANAGER','Gerente de cuenta');
define('FS_PHONE','Teléfono#');
define('FS_SUBTOTAL','Subtotal');
define('FS_VIEW_SHIPPING_CART','Ver cesta de compra');
define('FS_SAVE_CART_CONDITIONS','Si no puedes localizar tu cesta guardada, intenta seleccionar diferentes condiciones de filtro.');
define('FS_NO_SAVED_CART_FOUND','NO SE ENCUENTRA NINGUNA CESTA GUARDADA.');
define('FS_CRET_REFERENCE','Producto(s)');
define('FS_CART_DELETE','Eliminar');
define('FS_CART_NEW_ITEMS','Nuevo(s) producto(s) han sido añadido a tu');
define('FS_CART_SUCCESSFULLY_UPDATED','Tu cesta se ha actualizado con éxito.');
define('FS_CART_SAVED_CART_NAME','Nombre de la cesta guardada');
define('FS_CART_NEW_CART_CREATE','Nueva cesta guardada se ha creado.');
define('FS_CART_HAS_BEEN_ADD','ha sido añadido a tus cestas guardadas.');
define('FS_CART_NAME_ALREADY_EXISTED','Este nombre ya existe. Por favor, utiliza otro diferente.');
define('FS_ADD_TO_SAVED_CART','Añadir');
define('FS_SAVE_CART_SELECT','Elige una cesta guardada');
define('FS_ADD_THE_ITEMS','O añade el/los producto(s) a una cesta guardada existente.');
define('FS_NAME_YOUR_SAVED_CART','Denomina la cesta guardada');
define('FS_ADD_TO_CART','Añadir a la cesta ');
define('FS_EMIAL_YOUR_CART','Compartir');
define('FS_PRINT_THIS_PAGE','Imprimir');
define('FS_SAVED_CART_DETAILS','Detalles de la cesta guardada');
define('FS_BELOW_IS_THE_CART','A continuación se presentan los detalles de la cesta guardada.');
define('FS_CART_CONTACT_CUSTOMER_SERVICE', 'Contactar el servicio al cliente');
define('FS_UPDATED_SUCCESSFULLY', 'Tu cesta se ha actualizado correctamente.');
define('FS_NEW_ITEM_CART', 'Se ha(n) añadido nuevo(s) artículo(s) a tu cesta guardada ');
define('FS_CART_ALL_ITEMS', 'Todos los artículos en esta cesta ya no están disponibles para la compra. Por favor, ponte en contacto con tu gerente de cuenta para la disponibilidad.');
define('FS_CART_SOME_CUSTOMIZED', 'Algunos artículos personalizados en esta cesta han cambiado. Por favor, consulta la página de los detalles del producto y selecciona los atributos.');
define('FS_CART_ALL_CUSTOMEIZED_ITEMS', 'Todos los artículos en esta cesta han cambiado. Por favor, consulta la página de los detalles del producto y selecciona los atributos.');
define('FS_CART_THE_QUANTITY', 'La cantidad que necesitas excede nuestro inventario disponible y ha sido regulado por consiguiente. Por favor, ponte en contacto con tu gerente de cuenta para obtener una cantidad adicional.');
define('FS_CART_SHOPPING_CART_DIRECTLY', 'Algunos artículos en esta cesta ya no están disponibles para la compra en línea. Por favor, ponte en contacto con tu gerente de cuenta para la disponibilidad. Mientras tanto los artículos disponibles se han trasladado directamente a la cesta de compra.');
define('FS_CART_QUANTITY_ADDITIONAL', 'La cantidad que necesitas excede nuestro inventario disponible y ha sido regulado por consiguiente. Por favor, ponte en contacto con tu gerente de cuenta para obtener una cantidad adicional.');
define('FS_CART_CUSTOMIZED_SHOPPING_CART', 'Algunos artículos personalizados en esta cesta han cambiado. Por favor, consulta la página de los detalles del producto y selecciona los atributos. Mientras tanto los artículos disponibles se han trasladado directamente a la cesta de compra.');
define('FS_SAVE_CSRT_LIMIT_TIP_CART','Por favor ingrese un nombre de la cesta menos de 150 palabras.');
define('FS_FROM','De');
define('FS_TO_EMAIL','Para');
define('FS_SELECT_SAVE_CART','Por favor, elige una cesta guardada.');


define('FS_NOTICE_FREE_SHIPPING','Envío gratuito a partir de $MONEY');
define('FS_NOTICE_FREE_DELIVERY','Envío gratuito a partir de $MONEY');
define('FS_NOTICE_FAST_SHIPPING','Envío rápido a $COUNTRY');
define('FS_NOTICE_HEADER_COMMON_TIPS',' Debido al COVID-19, es posible que la entrega se retrase.');

define('DHL_EXPRESS_WORLDWIDE_1_2_BUSINESS_DAY', 'DHL Express Worldwide® 1-2 días laborales');
define('UPS_NEXT_DAY_AIR_EARLY', 'UPS Next Day-Early®');
define('FS_SERVICE_WORD', '');

// add by rebirth  2020.04.09  下单付款邮件优化
define('FS_EMAIL_OPTIMIZE_01', 'Realiza el pago');
define('FS_EMAIL_OPTIMIZE_02', 'Nota: En caso de que hayas realizado el pago, por favor, haz caso omiso a este mensaje, gracias.');
define('FS_EMAIL_OPTIMIZE_03', 'Estamos en ello');
define('FS_EMAIL_OPTIMIZE_04', 'A continuación, encontrarás los detalles de tu pedido #ORDER_NUMBER. Te enviaremos la información de seguimiento cuando haya actualización de tu pedido.');
define('FS_EMAIL_OPTIMIZE_05', 'Ver el pedido');
define('FS_EMAIL_OPTIMIZE_06', 'Nota: En caso de que hayas subido el archivo PO, por favor, haz caso omiso a este mensaje, gracias.');
define('FS_EMAIL_OPTIMIZE_07', 'Gracias por tu pedido');
define('FS_EMAIL_OPTIMIZE_08', 'Por favor, completa el pago dentro de 7 días hábiles. De lo contrario, el pedido será cancelado debibo al cambio de inventario de productos. Después de realizar el pago, recibirás una notificación donde se te informará la confirmación de tu pedido.');
define('FS_EMAIL_OPTIMIZE_09', 'Instrucciones de pago');
define('FS_EMAIL_OPTIMIZE_10', 'Una vez que hayas realizado el pago, por favor, envía el comprobante bancario a $FS_EMAIL. o a tu gerente de cuenta. De este modo, procesaremos tu pedido lo antes posible evitando que el pedido sea cancelado. Por favor, realiza el pago a la siguiente cuenta.');
define('FS_EMAIL_OPTIMIZE_11', 'Nota: Por favor, incluye el número del pedido $ORDER_NUMBER y tu dirección de correo electrónico en el campo observaciones.');
define('FS_EMAIL_OPTIMIZE_12', 'Política de entrega');
define('FS_EMAIL_OPTIMIZE_13', 'El tiempo estimado de entrega comienza a partir de que hayamos recibido tu pago.');
define('FS_EMAIL_OPTIMIZE_14', 'Tu pedido se entregará entre 9am y 5pm, de lunes a viernes (excepto los festivos). Alguien deberá estar en la dirección y firmar la entrega.');

define('FS_PLEASE_CHECK_THE_URL','Por favor, comprueba la URL, o vuelve al ');
define('FS_HOMEPAGE','Inicio');
define('FS_GO_TO_HOMEPAGE','Volver al Inicio');

define('STARTRACK_PREMIUM_EXPRESS', 'StarTrack Premium 1-3 días laborales');
define('TNT_ROAD_EXPRESS_1_4', 'TNT Road Express 1-4 días laborales');
define('DHL_EXPRESS_1_3', 'DHL Express 1-3 días laborales');


define("FS_WORD_CLOSE", 'Cerrar');


//报价购物车
define('FS_NEW_OTHER_LENGTH','Otra longitud');
define('FS_INQUIRY_CART_1',"Solicita cotización");
define('FS_INQUIRY_CART_2',"Información de contacto");
define('FS_INQUIRY_CART_3',"Nombre*");
define('FS_INQUIRY_CART_4',"Apellido*");
define('FS_INQUIRY_CART_5',"Email*");
define('FS_INQUIRY_CART_6',"Teléfono");
define('FS_INQUIRY_CART_7',"Comentarios");
define('FS_INQUIRY_CART_8',"Subir archivo");
define('FS_INQUIRY_CART_9',"Formatos soportados: PDF, JPG, PNG.<br>Tamaño máximo: 5M.");
define('FS_INQUIRY_CART_10',"Introduce el ID del producto y la cantidad para añadir nuevo artículo de cotización.");
define('FS_INQUIRY_CART_11',"Añadir");
define('FS_INQUIRY_CART_12',"Solicita cotización");
define('FS_INQUIRY_CART_13',"Déjanos un mensaje si tienes alguna petición.");
define('FS_INQUIRY_CART_14',"Introduce el ID del producto");
define('FS_INQUIRY_CART_15',"Por favor, introduce el ID del producto.");



define('FS_BLANK', '');

define('UPS_EXPRESS_NEXT_DAY_SERVICE', 'UPS Express Saver® Next Day Service');
define("FS_BLANK", ' ');

// 结算页美国、澳大利亚跳转
define('AUSTRALIA_HREF_1',"Pedidos en este sitio web no se pueden enviar a Australia. Por favor, dirígete a ");
define('FS_AUSTRALIA_CHECKOUT',"FS Australia");
define('AUSTRALIA_HREF_2'," si deseas que tu pedido se envíe a Australia.");
define('UNITED_STATES_SITE_HREF_1',"Pedidos en este sitio web no se pueden enviar a Estados Unidos. Por favor, dirígete a ");
define('FS_UNITED_STATES_SITE',"FS Estados Unidos");
define('UNITED_STATES_SITE_HREF_2'," si deseas que tu pedido se envíe a los EE.UU.");
define('RUSSIAN_SITE_HREF_1',"Si eliges \"Persona jurítica\", el pedido debe ser pagado por Cashless en rublos. Por favor, dirígete a ");
define('FS_RUSSIAN_SITE',"FS Rusia");
define('RUSSIAN_SITE_HREF_2'," si deseas realizar este pedido.");


//头部购物车loading板块提示语
define('FS_TOP_CART_LOAD_TITLE', 'Cargando');


define('FS_VAX_TITLE_US','Impuesto de ventas estimado');
define('FS_VAX_TITLE_US_TAX','Impuesto de ventas');

define('FS_VAX_US_TIPS','De acuerdo con las leyes fiscales estatales, FS debe cobrar el impuesto sobre las ventas a las partes no exentas. <a href="https://www.fs.com/service/sales_tax.html" target="_blank">Leer más</a>');

//账户中添加查看评论入口
define('FS_ACCOUNT_VIEW_REVIEWS', "Tus comentarios");
define('FS_VIEW_REVIEWS_WRITE_A_REVIEW', "Escribe un comentario");
define('FS_VIEW_REVIEWS_SEARCH', "Buscar");
define('FS_VIEW_REVIEWS_SEARCH_REVIEWS', "Buscar comentarios:");
define('FS_VIEW_REVIEWS_ITEM', "Artículo #");
define('FS_VIEW_REVIEWS_1', "No se encuentra ningún comentario.");
define('FS_VIEW_REVIEWS_2', "Busca tu pedido y comparte tu comentario.");
define('FS_VIEW_REVIEWS_REVIEWED_ON', "Fecha: ");
define('FS_VIEW_REVIEWS_VERY_SATISFIED', "Perfecto");
define('FS_VIEW_REVIEWS_READ_MORE', "Leer más");
define('FS_VIEW_REVIEWS_MORE', "Más");
define('FS_VIEW_REVIEWS_SHOW', "Mostrar");
define('FS_VIEW_REVIEWS_COMMENTS', "comentarios");


define('FS_SRVICE_WORD', "");


define('FS_PRODUCT_MATERIAL_M','m');
define('FS_PRODUCT_MATERIAL_CABLE',' material de cable');
define('FS_PRODUCT_MATERIAL_TIP','El plazo de entrega será un poco más largo debido a que la cantidad de compra excede nuestro inventario. Por favor, ponte en contacto con tu gerente de cuenta si deseas que los artículos con existencias de tu pedido se envíen por separado.');


define('FS_INQUIRY_PRODUCTS_NUM','Por favor, revisa la información del producto en la parte "Detalles" de tu cotización.');

//前台账期申请  rebirth.ma   2020.05.22
define('FS_NET_30_01', 'Por favor, introduce tu nombre y apellido.');
define('FS_NET_30_02', 'Por favor, sube tu formulario de solicitud.');
define('FS_NET_30_03', 'Cuenta Net ya existe.');
define('FS_NET_30_04', 'FS - Tu solicitud de cuenta Net ha sido recibida');
define('FS_NET_30_05', 'Hemos recibido tu solicitud de cuanta Net. Necesitamos 2-3 días hábiles para la revisión. Nos estaremos comunicando por correo electrónico para informarte sobre cualquier novedad.');
define('FS_NET_30_06', 'Estado');
define('FS_NET_30_07', 'Enviado');
define('FS_NET_30_08', 'En revisión');
define('FS_NET_30_09', 'Aprobado');
define('FS_NET_30_10', 'Denegado');
define('FS_NET_30_11', 'Envía formulario de solicitud');
define('FS_NET_30_12', 'Nombre y apellido');
define('FS_NET_30_13', 'Correo electrónico');
define('FS_NET_30_14', 'Teléfono');
define('FS_NET_30_15', 'Subir archivos');
define('FS_NET_30_16', 'Elige archivo');
define('FS_NET_30_17', 'Tu formulario de solicitud se ha enviado correctamente.');
define('FS_NET_30_18', 'Te enviaremos el resultado de revisión por correo electrónico dentro de 2-3 días hábiles. También podrás seguir las actulizaciones en “#CASE_CENTER” con tu cuenta de FS.');
define('FS_NET_30_19', '¡Gracias! Tu formulario de solicitud de crédito ha sido enviado correctamente.');
define('FS_NET_30_20', 'Tu solicitud de cuenta Net está en proceso de revisión. Por favor, espera 2-3 días hábiles para el resultado.');
define('FS_NET_30_21', 'Nos complace informarte que tu solicitud de cuenta Net ha sido aprobada. Desde ahora podrás realizar pedido en FS con tu cuenta Net.');
define('FS_NET_30_22', 'Consulta los detalles de tu crédito en “#FS_CREDIT”.');
define('FS_NET_30_23', 'Lamentamos que tu solicitud de cuenta Net ha sido denegada. ');//与后面还有一句话，注意本句话最后面的空格
define('FS_NET_30_24', '¿Deseas solicitar otra vez una cuenta Net?');
define('FS_NET_30_25', 'Completa y envía el formulario de solicitud de crédito visitando la página “#NET_TERMS”.');
define('FS_NET_30_26', 'Si tienes alguna duda o iquietud, por favor, no dudes en ponerte en contacto con tu gerente de cuenta: #ACCOUNT_MANAGER.');
define('FS_NET_30_27', 'País/Región');
define('FS_NET_30_28', 'Observaciones');
define('FS_NET_30_29', 'Enviar');
define('FS_NET_30_30','Gracias<br>El equipo FS');
define('FS_NET_30_31','Solicitud recibida');
define('FS_NET_30_32','Crédito comercial');

//new-product
define('FS_NEW_PRODUCT_EXPLORE','Descubre las últimas innovaciones');

//取消订阅
define('FS_UNSUBSCRIBE_MAIL_1','FS Newsletter');
define('FS_UNSUBSCRIBE_MAIL_2','Suscríbete en FS para obtener más información sobre las últimas políticas preferenciales, noticias de inventario, soporte técnico, entre otros.');
define('FS_UNSUBSCRIBE_MAIL_3','Emails de invitación a comentarios');
define('FS_UNSUBSCRIBE_MAIL_4','Los correos electrónicos de invitación a comentarios se enviarán en siete días después de la entrega de tu pedido.');
define('FS_UNSUBSCRIBE_MAIL_5','Gestiona tu preferencia de suscripción por email para recibir informaciones de FS.');
define('FS_UNSUBSCRIBE_MAIL_6','Los correos electrónicos sobre tu cuenta y tus pedidos son importantes. Te los enviaremos aunque hayas cancelado las siguientes suscripciones.');

//账户中心添加关于俄罗斯对公支付
define('FS_ACCOUNT_MY_COMPANIES', 'Compañías');

/*wdm库存展示版块语言包*/
define('FS_WDM_WAVELENGTH_NM','Longitud de onda (nm)');

//100G产品提示语
define("FS_COHERENT_CFP","El CFP coherente no se venta por separado.");

//checkout 账单地址邮编验证提示
define('FS_ZIP_VALID_1','La dirección que escribes no coincide con el código postal. Por favor, revísalo de nuevo.');
define('FS_ZIP_VALID_2','Por favor, introduce un código postal válido.');


define("FS_SOLUTION_CLICK_OPEN_VIEW","Haz clic para ampliar la imagen");
define("FS_CUSTOMIZE_YOUR_SOLUTION","Elige y personaliza tu solución");
define("FS_TECH_SPEC_CUSTOMOZATION","Especificaciones técnicas");
define("FS_SOLUTION_OVERVIEW",'Descripción');
define("FS_SOLUTION_CUSTOMIZED",'Añadir a la cesta');
define("FS_SOLUTION_EDIT",'Editar');
define("FS_SOLUTION_CONFIGURATION",'Configuración de la solución');
define("FS_SOLUTION_MORE",'Más');
define('FS_SOLUTION_LESS','Menos');
define("FS_SOLUTION_DEVICES",'Dispositivos');
define("FS_SOLUTION_TRANSCEIVER",'Transceptores');
define("FS_SOLUTION_WAVE_COM_BAR",'Longitud de onda y marca compatible');
define("FS_SOLUTION_ACCESSORIES",'Accesorios');
define("FS_SOLUTION_CHOOSE_LENGTH",'Longitud');
define("FS_SOLUTION_INFO",'Información de la solución');

define('FS_SOLUTION_PERSONALIZATION','Personalización');
define('FS_SOLUTION_MANUFACTURING','Producción');
define('FS_SOLUTION_SHIPPED','Envío');
define('FS_SOLUTION_ARRIVED','Entrega');
define('FS_SOLUTION_CON_LIST','Lista de productos');
define('FS_SOLUTION_QUANTITY','Cantidad');
define('FS_SOLUTION_TOTAL','Total');

define('FS_SOLUTION_SITEA','Sitio A');
define('FS_SOLUTION_SITEB','Sitio B');

define('FS_SOLUTION_NAV_01','Red de transporte óptico');
define('FS_SOLUTION_NAV_02','Red de campus');
define('FS_SOLUTION_NAV_03','Centro de datos');
define('FS_SOLUTION_NAV_04','Cableado estructurado');
define('FS_SOLUTION_NAV_05','Por aplicación');
define('FS_SOLUTION_NAV_06','Red CWDM de dos fibras 10G');
define('FS_SOLUTION_NAV_07','Red CWDM de una sola fibra 10G');
define('FS_SOLUTION_NAV_08','Red DWDM de dos fibras 10G');
define('FS_SOLUTION_NAV_09','Red DWDM de una sola fibra 10G');
define('FS_SOLUTION_NAV_10','Red DWDM de dos fibras 25G');
define('FS_SOLUTION_NAV_11','Red DWDM de una sola fibra 25G');
define('FS_SOLUTION_NAV_12','Red coherente 40/100G');
define('FS_SOLUTION_NAV_13','Red empresarial');
define('FS_SOLUTION_NAV_14','Red inalámbrica y movilidad');
define('FS_SOLUTION_NAV_15','Red de varias sucursales');
define('FS_SOLUTION_NAV_16','Redes gestionadas en la nube');
define('FS_SOLUTION_NAV_17','Cableado estructurado en centro de datos');
define('FS_SOLUTION_NAV_18','Cableado MTP®/MPO de alta densidad');
define('FS_SOLUTION_NAV_19','Migración 40G / 100G');
define('FS_SOLUTION_NAV_20','Cableado de cobre preterminado');
define('FS_SOLUTION_NAV_21','Solución CWDM multiservicios');
define('FS_SOLUTION_NAV_22','Transporte DWDM 10G de larga distancia');
define('FS_SOLUTION_NAV_23','WDM 25G para 5G fronthaul');
define('FS_SOLUTION_NAV_24','Solución coherente DWDM 100G');
define('FS_SOLUTION_NAV_25','Optimización de red de MLAG');
define('FS_SOLUTION_NAV_26','Conmutación de red central en centro de datos');
define('FS_SOLUTION_NAV_27','Solución de alimentación a través de Ethernet');
define('FS_SOLUTION_NAV_28','Solución inalámbrica segura');
define('FS_SOLUTION_NAV_29','Cableado estructurado en centro de datos');
define('FS_SOLUTION_NAV_30','Cableado MTP®/MPO de alta densidad');
define('FS_SOLUTION_NAV_31','Migración 40G/100G');
define('FS_SOLUTION_NAV_32','Cableado de cobre preterminado');
define('FS_SOLUTION_NAV_33','Soporte técnico profesional');
define('FS_SOLUTION_NAV_34','Centro de datos empresarial');
define('FS_SOLUTION_NAV_35','Centro de datos de proveedor de servicios');
define('FS_SOLUTION_NAV_36','Centro de datos de hiperescala y nube');
define('FS_SOLUTION_NAV_37','Centro de datos de múltiples inquilinos');
//solutions 版块新增专题
define('FS_SOLUTION_NAV_M6200','Serie M6200 de DWDM de larga distancia de 10G');
define('FS_SOLUTION_NAV_M6500','Serie M6500 de ancho de banda alto de 100G/200G');
define('FS_SOLUTION_NAV_M6800','Serie M6800 de solución para DCI de 1,6T');
define('FS_SOLUTION_NAV_WiFi6','Soluciones de red de Wi-Fi 6');
/**
 * 新加坡
 */
define("FS_CHECKOUT_ERROR_SG_01","Se requiere tu dirección 2.");
define("FS_CHECKOUT_ERROR_SG_02","Apartamento, edificio, piso, puerta");
define("FS_CHECKOUT_ERROR_SG_03","Boleto de envío");
define("FS_CHECKOUT_ERROR_SG_04","Con el fin de garantizar una entrega sin problemas, por favor, proporciona el número del boleto de envío para los paquetes enviados a Equinix.");
define("FS_CHECKOUT_ERROR_SG_05","*Durante el período de administración especial por la COVID-19, se recomienda escribir tu dirección residencial para que recibas tu paquete oportunamente.");
define("FS_CHECKOUT_ERROR_SG_06","Por favor, escribe tu dirección de entraga completamente.");

define('FS_CHECKOUT_ERROR_001',"La cantidad de los transceptores que has elegido ha alcanzado el límite.");
define('FS_CHECKOUT_ERROR_002','Por favor, selecciona <span>4</span> canales diferentes.');

define("FS_SEE_ALL_RESULTS","Ver todos los resultados");

//账户中心展示交换机软件更新
define('FS_SOFTWARE_DOWNLOAD',"Descarga software");
define('FS_CHECK',"Consulta la última versión de software de los switches que has comprado.");
define('FS_SOFWARE','Descarga software');
define('FS_SOFWARE_1','Contacta servicio al cliente');
define('FS_SOFWARE_2','Consulta la última versión de software de los switches que has comprado. Para más lanzamiento de software, por favor, dirígete a ');
define('FS_SOFWARE_4','Centro de descargas');
define('FS_SOFWARE_5','Mostrar:');
define('FS_SOFWARE_6','Switches de red');
define('FS_SOFWARE_7','Switches 1G/10G');
define('FS_SOFWARE_8','Switches 25G');
define('FS_SOFWARE_9','Switches 40G');
define('FS_SOFWARE_10','Switches 100G');
define('FS_SOFWARE_11','Switches 400G ');
define('FS_SOFWARE_12','Buscar producto:');
define('FS_SOFWARE_13','Buscar');
define('FS_SOFWARE_14','Información reciente');
define('FS_SOFWARE_15','ID de producto');
define('FS_SOFWARE_16','Fecha de lanzamiento');
define('FS_SOFWARE_17','Tamaño');
define('FS_SOFWARE_18','Software');
define('FS_SOFWARE_19','Notificación');
define('FS_SOFWARE_20','Información reciente');
define('FS_SOFWARE_22','Notas de la versión');
define('FS_SOFWARE_23','Versión');
define('FS_SOFWARE_24','Software');
define('FS_SOFWARE_25','Descargar');
define('FS_SOFWARE_26','Notificación');
define('FS_SOFWARE_27','Darte de baja');
define('FS_SOFWARE_28','Suscribirte');
define('FS_SOFWARE_29','¿Deseas darte de baja del servicio?');
define('FS_SOFWARE_30','¿Deseas suscribirte y recibir notificaciones?');
define('FS_SOFWARE_31','Si no puedes localizar tu software, intenta seleccionar diferentes condiciones de filtro.');
define('FS_SOFWARE_32','No has comprado ningún FS switch. ¡Compra FS switch ahora!');
define('FS_SOFWARE_33','Empieza a comprar');
define('FS_SOFWARE_34','Te has suscrito correctamente.');
define('FS_SOFWARE_35','Recibirás notificaciones por correo electrónico sobre la última versión de software.');
define('FS_SOFWARE_36','Te has suscrito correctamente.');
define('FS_SOFWARE_37','Ya te has dado de baja.');
define('FS_SOFWARE_38','No recibirás más notificaciones por correo electrónico sobre la última versión de software.');
define('FS_SOFWARE_39','ID de producto');
define('FS_SOFWARE_40','NO SE ENCUENTRA NINGÚN SOFTWARE.');
define('FS_SOFWARE_41','Suscripción comfirmada');
define('FS_SOFWARE_42','Te has suscrito correctamente a las actualizaciones de software para el siguiente switch. Te enviaremos por correo electrónico notificaciones una vez que se lance la última versión.');
define('FS_SOFWARE_43','Podrías interesarte en...');
define('FS_SOFWARE_44','Explora qué hemos ofrecido a nuestros clientes<br> de todo el mundo.');
define('FS_SOFWARE_45','Consulta los últimos productos innovadores y<br> las noticias de FS.');
define('FS_SOFWARE_46','FS - Suscripción a las actualizaciones de software');
define('FS_SOFWARE_47','Ya te has dado de baja');
define('FS_SOFWARE_48','No recibirás más notificaciones de las actualizaciones de software para el siguiente switch.');
define('FS_SOFWARE_49','Si hay algún error, suscríbete de nuevo haciendo clic en el botón.');
define('FS_SOFWARE_50','Suscribirte de nuevo');
define('FS_SOFWARE_51','Mantengámonos en contacto');
define('FS_SOFWARE_52','Suscripción de software');
define('FS_SOFWARE_53','Casos de éxito');
define('FS_SOFWARE_54','Noticias de FS');


define('FS_CHECKOUT_SPEC_PRODUCTS_DOUBT','¿No encuentras las opciones de envío?');
define('FS_CHECKOUT_SPEC_PRODUCTS_TIPS','Debido a la restricción de dimensiones de las empresas transportistas, los pedidos que incluyen #73579/#73958 no se pueden enviar de forma normal. Podrías utilizar tu propio transportista, o ponerte en contacto con tu gerente de cuenta para resolver este problema. Disculpa la inconveniencia.');

//checkout_footer_new
define('FS_CHECKOUT_FOOTER_NEW_01', 'Danos tu feedback');
define('FS_CHECKOUT_FOOTER_NEW_02', '<a href="' . reset_url('service/fs_support.html'). '" target="_blank" >Centro de asistencia</a> o <a target="_blank" href="' . reset_url('contact_us.html') . '">Contáctanos</a>.');
define('FS_CHECKOUT_FOOTER_NEW_03', 'Para obtener ayuda de forma rápida, por favor, consulta nuestro ');
define('FS_CHECKOUT_FOOTER_NEW_04', 'Elige un tema*');
define('FS_CHECKOUT_FOOTER_NEW_05', 'Por favor, elige... ');
define('FS_CHECKOUT_FOOTER_NEW_06', 'Iniciar sesión/Crear una cuenta');
define('FS_CHECKOUT_FOOTER_NEW_07', 'Cesta de compra');
define('FS_CHECKOUT_FOOTER_NEW_08', 'Impuestos');
define('FS_CHECKOUT_FOOTER_NEW_09', 'Dirección de entrega y de facturación');
define('FS_CHECKOUT_FOOTER_NEW_10', 'Envío');
define('FS_CHECKOUT_FOOTER_NEW_11', 'Pago');
define('FS_CHECKOUT_FOOTER_NEW_12', 'Otros');
define('FS_CHECKOUT_FOOTER_NEW_13', 'Por favor, selecciona un tema.');
define('FS_CHECKOUT_FOOTER_NEW_14', '¿Qué podemos hacer para mejorar tu experiencia?');
define('FS_CHECKOUT_FOOTER_NEW_15', 'Con tus comentarios te brindaremos una respuesta mucho más rápida y acertada.');
define('FS_CHECKOUT_FOOTER_NEW_16', 'Por favor, escribe al menos 10 caracteres.');
define('FS_CHECKOUT_FOOTER_NEW_17', 'Enviar');
define('FS_CHECKOUT_FOOTER_NEW_18', 'Gracias por tu feedback.');
define('FS_CHECKOUT_FOOTER_NEW_19', 'Revisaremos tus comentarios y los usaremos para mejorar nuestro sitio web.');
define('FS_CHECKOUT_SUCCESS_EMAIL_01', 'Has recibido un nuevo feedback');
define('FS_CHECKOUT_SUCCESS_EMAIL_02', 'Tu cliente envió la siguiente información en la página de pago con éxito. Por favor, síguelo y respóndelo si es necesario.');
define('FS_CHECKOUT_SUCCESS_EMAIL_03', 'Nombre del cliente:');
define('FS_CHECKOUT_SUCCESS_EMAIL_04', 'Email del cliente:');
define('FS_CHECKOUT_SUCCESS_EMAIL_05', 'Número del pedido:');
define('FS_CHECKOUT_SUCCESS_EMAIL_06', 'Tema del feedback:');
define('FS_CHECKOUT_SUCCESS_EMAIL_07', 'Comentarios adicionales:');
define('FS_CHECKOUT_SUCCESS_EMAIL_08', 'Nuevo feedback');

define('FS_PRINT',"Para proteger la privacidad de los clientes, por favor, introduce la FS cuenta de usuario con que se realizó este pedido para consultar los detalles:");
define('FS_PRINT_1',"Confirmar");
define('FS_PRINT_2',"La dirección de correo electrónico que escribes no coincide con la información del pedido. Por favor, revisa la dirección e inténtalo de nuevo.");
define('FS_PRINT_3',"Por favor, introduce la dirección de correo electrónico.");

//评论改版
define('FS_REVIEW_07','Modelo de tu equipo');
define('FS_REVIEW_08','Incluye el modelo de tu equipo para proporcionar referencias a otros clientes.');
define('FS_REVIEW_09','Formatos soportados: JPG y JPEG y PNG. Tamaño máximo: 5MB');
define('FS_REVIEW_11','Opcional');

define('FS_REVIEW_ATTRIBUTE_CONTENT', 'Compatibilidad');


//liang.zhu
define('FS_CLEARANCE_TIP_01_01', 'Sólo queda(n) $QTY unidad(s). Este producto será quitado desde nuestro sitio web una vez que se agoten las existencias.');
define('FS_CLEARANCE_TIP_01_02', 'Si quieres comprar más, te recomendamos el producto alternativo "<a style="color:#0070BC;" target="_blank" href="'.reset_url('/products/$PRODUCTS_ID.html').'">$PRODUCTS_ID</a>".');
define('FS_CLEARANCE_TIP_02_01', 'Este producto promocional ya no tiene existencia disponible y será quitado desde nuestro sitio web pronto.');
define('FS_CLEARANCE_TIP_02_02', 'Te recomendamos el producto alternativo "<a style="color:#0070BC;" target="_blank" href="'.reset_url('/products/$PRODUCTS_ID.html').'">$PRODUCTS_ID</a>".');
define('FS_CLEARANCE_TIP_03_01', 'Sólo queda(n) $QTY unidad(s). Este producto será quitado desde nuestro sitio web una vez que se agoten las existencias.');
define('FS_CLEARANCE_TIP_03_02', 'Si quieres comprar más, podrás ponerte en contacto con tu gerente de cuenta.');
define('FS_CLEARANCE_TIP_04_01', 'Este producto promocional ya no tiene existencia disponible y será quitado desde nuestro sitio web pronto.');
define('FS_CLEARANCE_TIP_04_02', 'Si quieres comprarlo, podrás ponerte en contacto con tu gerente de cuenta.');


define('CHECKOUT_COMPANY_TYPE', 'El tipo de dirección es incorrecto.');

## 添加 Delivery Instructions信息
define("FS_DELIVERY_TITLE", "Instrucciones para la entrega (opcional)");
define("FS_DELIVERY_TICKET_NUMBER", "Boleto de envío, código de seguridad, etc.");
define("FS_DELIVERY_OTHER_INFO", "Tiempo de entrega u otras instrucciones para la entrega");
define("FS_DELIVERY_PROMPT", "Tus instrucciones nos ayudará a entregar tu paquete de forma oportuna.");
define('FS_DELIVERY_INSTRUCTIONS', 'Instrucciones para la entrega');


//PO
define('FS_CHECKOUT_SUCCESS_PURCHASE_03', ' está confirmado. Por favor, sube el archivo PO (orden de compra) dentro de 7 días hábiles. De lo contrario, el pedido será cancelado automáticamente debido al cambio de inventario de productos.');
define('FS_CHECKOUT_SUCCESS_PURCHASE_04', 'Subir el archivo PO');
define('FS_CHECKOUT_SUCCESS_PURCHASE_04_1', '¿En qué consiste un archivo PO?');
define('FS_PO_FILE','ORDEN DE COMPRA');
define('FS_PO_FILE_1','FS.COM Inc.');
define('FS_PO_FILE_2','380 Centerpoint Blvd, New Castle,<br /> DE 19720, United States');
define('FS_PO_FILE_3','Orden de compra');
define('FS_PO_FILE_4','Fecha: 08/08/2020<br />PO #: PO0001');
define('FS_PO_FILE_5','Proveedor');
define('FS_PO_FILE_6','Dirección de entrega');
define('FS_PO_FILE_7','Dirección de facturación');
define('FS_PO_FILE_8','FS.COM Pty Ltd');
define('FS_PO_FILE_9','57-59 Edison Rd, Dandenong South, <br />VIC 3175, Australia <br />ABN 71 620 545 502');
define('FS_PO_FILE_10','Gerente de cuenta: ');
define('FS_PO_FILE_11','Ann.Smith');
define('FS_PO_FILE_12','Correo electrónico: ');
define('FS_PO_FILE_13','Ann.Smith@fs.com');
define('FS_PO_FILE_14','FS.COM Pty Ltd');
define('FS_PO_FILE_15','380 Centerpoint Blvd <br />New Castle, <br />DE 19720');
define('FS_PO_FILE_16','Número de teléfono: ');
define('FS_PO_FILE_17','+1 (888) 468 7419');
define('FS_PO_FILE_18','A/A: ');
define('FS_PO_FILE_19','Steven');
define('FS_PO_FILE_20','FS.COM Inc.');
define('FS_PO_FILE_21','380 Centerpoint Blvd <br />New Castle, <br />DE 19720');
define('FS_PO_FILE_22','Número de teléfono: ');
define('FS_PO_FILE_23','+1 (888) 468 7419');
define('FS_PO_FILE_24','A/A: ');
define('FS_PO_FILE_25','Steven');
define('FS_PO_FILE_26','Método de pago');
define('FS_PO_FILE_27','Solicitado por');
define('FS_PO_FILE_28','Departamento');
define('FS_PO_FILE_29','Transferencia bancaria');
define('FS_PO_FILE_30','Steven Jones');
define('FS_PO_FILE_31','Depto. de Compras');
define('FS_PO_FILE_32','FS RQC #: RQC2008010003');
define('FS_PO_FILE_33','<th>Descripción del artículo</th><th>ID del artículo</th><th>Cantidad</th><th>Precio unitario</th><th>Total</th>');
define('FS_PO_FILE_36','SUBTOTAL:');
define('FS_PO_FILE_38','COSTO DE ENVÍO:');
define('FS_PO_FILE_39','IVA:');
define('FS_PO_FILE_40','TOTAL:');
define('FS_PO_FILE_41',"¿En qué consiste un archivo PO?");
define('FS_PO_FILE_42',"Una orden de compra (PO) es un documento emitido por el comprador para solicitar mercancías al vendedor, y siempre incluye la siguinete información: ");
define('FS_PO_FILE_43',"Fecha de emisión y número de la orden de compra;");
define('FS_PO_FILE_44',"Datos del cliente y del vendedor;");
define('FS_PO_FILE_45',"Dirección de entrega y de facturación; forma de pago;");
define('FS_PO_FILE_46',"Información y precio de los artículos.");
define('FS_PO_FILE_47',"Ver ejemplo de PO");

define('FS_OFFLINE_ORDERS','Pedidos offline');
define('FS_OFFLINE_COMBINED_SHIPMENT','Envío combinado');
define('FS_OFFLINE_COMBINED_SHIPMENT_DETAILAS','Con el fin de reducir la cantidad de los paquetes y de proteger el medio ambiente, FS te enviará los siguientes pedidos juntos. Haz clic en el número del pedido para consultar los detalles.');
define('FS_OFFLINE_TRACK_YOUR_PACKAGE_01','Si no se ha actualizado el estado de tu pedido, por favor, ponte en contacto con tu gernete de cuenta. Encontrarás el pedido en "');
define('FS_OFFLINE_TRACK_YOUR_PACKAGE_02','" después de que se envíe.');

//线下订单列表
define('FS_OFFLINE_01','Descargar la factura');
define('FS_OFFLINE_02','Fecha de pedido: ');
define('FS_OFFLINE_03','Pedido #: ');
define('FS_OFFLINE_04','Precio subtotal: ');
define('FS_OFFLINE_05','Costo de envío: ');
define('FS_OFFLINE_06','GST: ');
define('FS_OFFLINE_07','Seguro: ');
define('FS_OFFLINE_08','TOTAL: ');
define('FS_OFFLINE_09','Tu pedido se ha enviado por el método de envío que elegiste en la página de pago. Podrás rastrear tu pedido haciendo clic en el siguiente número de seguimiento, o a través de consultar el email de notificación. No obstante, algunos transportistas no actualizan la información oportunadamente, por lo tanto, el estado de tu pedido puede diferirse.');
define('FS_OFFLINE_10','Este pedido ha sido reemplazado por el nuevo ');
define('FS_OFFLINE_11','Main advantages are its passive nature – no power supply or cooling  necessary, and robustness – no special microclimate requirements, Main advantages are its passive nature – no power supply or cooling  necessary, and robustness – no special microclimate requirements,Main advantages Main advantages are its passive nature – no power supply or cooling  necessary, and robustness – no special microclimate requirements, Main advantages are its passive nature – no power supply or cooling  necessary, and robustness – no special microclimate requirements,Main advantages are its passive nature – no power supply or cooling  necessary, and robustness – no special microclimate requirements, Main advantages are its passive nature – no power ');
define('FS_OFFLINE_12','Confirmar la recepción');
define('FS_OFFLINE_13','El envío de este pedido ha sido cancelado. Si tienes alguna duda, por favor, ponte en contacto con tu gerente de cuenta.');
define('FS_OFFLINE_14','Ver ');
define('FS_OFFLINE_15','todos los envíos');
define('FS_OFFLINE_16',' de este pedido.');
define('FS_OFFLINE_17','En proceso');
define('FS_OFFLINE_18','OK');
define('FS_OFFLINE_19','Pedido # ');
define('FS_OFFLINE_20','(pedido actual)');
define('FS_OFFLINE_21','NO SE ENCUENTRA NINGÚN PEDIDO.');
define('FS_OFFLINE_22','Si no encuentras tu pedido, intenta hacer un filtro con diferentes formas o revisa el número del pedido.<br/>Los pedidos offline se pueden encontrar sólo después del envío. Podrás ponerte en contacto con tu gerente de cuenta si quieres saber el estado de tu padido antes del envío.');
//线下订单订单详情
define('FS_OFFLINE_ORDERS','Pedidos offline');
define('FS_OFFLINE_COMBINED_SHIPMENT','Envío combinado');
define('FS_OFFLINE_COMBINED_SHIPMENT_DETAILAS','Con el fin de reducir la cantidad de los paquetes y de proteger el medio ambiente, FS te enviará los siguientes pedidos juntos. Haz clic en el número del pedido para consultar los detalles.');
define('FS_OFFLINE_TRACK_YOUR_PACKAGE_01','Si no se ha actualizado el estado de tu pedido, por favor, ponte en contacto con tu gernete de cuenta. Encontrarás el pedido en "');
define('FS_OFFLINE_TRACK_YOUR_PACKAGE_02','" después de que se envíe.');

define('FS_OFFINE_TRANSACTION_1','El envío de este pedido ha sido cancelado. Si tienes alguna duda, por favor, ponte en contacto con tu gerente de cuenta.');
define('FS_OFFLINE_POPUP','Hay otros pedidos combinados en este envío.');
define('FS_OFFINE_TRANSACTION','Transacción offline');
define('FS_OFFINE_TRANSACTION_2','Consulta la información en los siguientes envíos');
define('FS_OFFINE_TRANSACTION_4','Tu pedido está en proceso.');
//my credit orders 页面
define('FS_VIEW_CONTENT','Este pedido ha sido dividido en varios envíos, y cada envío tiene una factura correspondiente. Podrás encontrar todas la facturas en la página de los detalles del pedido haciendo clic ');
define('FS_VIEW_LINK','aquí.');
define('FS_MY_CREDIT_01','Mostrar:');
define('FS_MY_CREDIT_02','Pedidos online');
define('FS_MY_CREDIT_03','Pedidos offline');
define('FS_MY_CREDIT_04','Ir');
define('FS_OFFINE_TRACK_INFO_1','Si no se ha actualizado el estado de tu pedido, por favor, ponte en contacto con tu gernete de cuenta. Encontrarás el pedido en el "<a class="new_alone_a" href="'.zen_href_link('manage_orders').'">Historial de pedidos</a>" después de que se envíe.');

define('FS_PRINT_AVE_1','FS.COM LIMITED</br>Unit 1, Warehouse No. 7</br>South China International Logistics Center</br>Longhua District</br>Shenzhen, 518109');
define('FS_PRINT_US_1','China');
//结算页
define('FS_CHECK_OUT_EXCLUDING1','No incluye derechos e impuestos');

//搜索V2版本
define('FS_SEARCH_NEW','Resultados de búsqueda de ');
define('FS_SEARCH_NEW_1','Productos');
define('FS_SEARCH_NEW_2','Documentos y recursos');
define('FS_SEARCH_NEW_3','Soluciones');
define('FS_SEARCH_NEW_4','Casos de éxito');
define('FS_SEARCH_NEW_5','Descargas');
define('FS_SEARCH_NEW_6','Eliminar todo');
define('FS_SEARCH_NEW_7','Soluciones');
define('FS_SEARCH_NEW_8','Casos de éxito');
define('FS_SEARCH_NEW_9','Nombre');
define('FS_SEARCH_NEW_10','Tipo');
define('FS_SEARCH_NEW_11','Fecha');
define('FS_SEARCH_NEW_12','Descargar');
define('FS_SEARCH_NEW_13','Noticias');
define('FS_SEARCH_NEW_14',' ya no es disponible en línea. Te recomendamos el siguiente producto similar ');
define('FS_SEARCH_NEW_15',' .');
define('FS_SEARCH_NEW_16',' ya no es disponible en línea. Por favor, solicita una cotización para obtener ayuda.');

define('FS_ACCOUNT_SEARCH_ALL_TIMES', 'Todo el tiempo');

define('FS_MY_SHOPPING_CART','Mi cesta de compra');
define('GET_A_QUOTE_TIP_1',"*Para consultas sobre el tiempo de entrega y la información de envío, por favor, completa los siguientes datos y envía tu solicitud de cotización. Nos pondremos en contacto contigo lo antes posible.");

//报价邮件
define("FS_INQUIRY_NEW_EMAIL"," te envió una solicitud de modificación de #");
define("FS_INQUIRY_NEW_EMAIL_1","Modificación de la cotización");
define("FS_INQUIRY_NEW_EMAIL_2"," te envió una solicitud para modificar la cotización ");
define("FS_INQUIRY_NEW_EMAIL_3",". Por favor, revisa los siguientes detalles y hace la cotización de nuevo lo antes posible.");
define("FS_INQUIRY_NEW_EMAIL_4","Número de caso:");
define("FS_INQUIRY_NEW_EMAIL_5","Artículo(s)");
define("FS_INQUIRY_NEW_EMAIL_6","Cant.");
define("FS_INQUIRY_NEW_EMAIL_7","Precio original");
define("FS_INQUIRY_NEW_EMAIL_8","Precio cotizado");
define("FS_INQUIRY_NEW_EMAIL_9","Total original:");
define("FS_INQUIRY_NEW_EMAIL_10","Total cotizado:");
define("FS_INQUIRY_NEW_EMAIL_11","Por favor, ponte en contacto con ");
define("FS_INQUIRY_NEW_EMAIL_12",", o envía la cotización a esta cuenta.");
define("FS_INQUIRY_NEW_EMAIL_13","Tu solicitud se ha enviado correctamente.");
define("FS_INQUIRY_NEW_EMAIL_14","Hemos recibido tu email. Tu gerente de cuenta te responderá dentro de 12-24 horas.");

define('FS_QUOTE_INQUIRY_01', 'Seleccionar archivo');
define('FS_QUOTE_INQUIRY_02', 'Subir lista de productos');
define('FS_QUOTE_INQUIRY_03', 'Por favor, introduce el ID del producto, o sube la lista de productos para solicitar una cotización.');
define('FS_QUOTE_INQUIRY_04', 'Tu solicitud de cotización se ha enviado correctamente.');
define('FS_QUOTE_INQUIRY_05', 'Tu gerente de cuenta procesará la cotización dentro de 12-24 horas, y te enviará un correo electrónico una vez que la cotización esté preparada.');
define("FS_QUOTE_EDIT_QUOTE", "Editar la cotización");
define("FS_QUOTE_QUOTE_REQUEST", "SOLICITUD DE COTIZACIÓN");
define("FS_QUOTE_INQUIRY_06", "Envía esta solicitud a tu gerente de cuenta");
define("FS_QUOTE_INQUIRY_07", "La cotización ");
define("FS_QUOTE_INQUIRY_08", " está dentro del plazo de validez, ");
define("FS_QUOTE_INQUIRY_09", "puedes tramitar el pedido directamente.");
define("FS_QUOTE_INQUIRY_10", "Si deseas modificar esta cotización o tienes algunas dudas, por favor, completa los siguientes datos. Tu mensaje se enviará por correo electrónico a tu gerente de cuenta.");
define("FS_QUOTE_INQUIRY_11", "De:");
define("FS_QUOTE_INQUIRY_12", "Te responderemos a esta dirección.");
define("FS_QUOTE_INQUIRY_13", "Para:");
define("FS_QUOTE_INQUIRY_14", "Mensaje que quieres dejar");
define("FS_QUOTE_INQUIRY_15", "Si deseas añadir o cambiar artículos, por favor, escribe el ID del producto (p. ej. #11552) y la cantidad.");
define("FS_QUOTE_INQUIRY_16", "Enviar un email");
define("FS_QUOTE_INQUIRY_17", "Imprimir la cesta de compra");
define("FS_QUOTE_INQUIRY_18", "Imprimir como una cotización");
define("FS_QUOTE_INQUIRY_19", "¿Deseas modificar esta cotización?");
define("FS_QUOTE_INQUIRY_20", "Artículo(s)");
define("FS_QUOTE_INQUIRY_21", "SUBIR LISTA DE PRODUCTOS");
define("FS_QUOTE_INQUIRY_22", "Lista de productos:");
define("FS_QUOTE_INQUIRY_23", "El estado de la solicitud de cotización ");
define("FS_QUOTE_INQUIRY_24", " se ha actualizado. Por favor, revísalo.");
define("FS_QUOTE_INQUIRY_25", "Por favor, sube los archivos relacionados con la orden de compra (PO).");
define("FS_QUOTE_INQUIRY_26", "OBSERVACIONES (OPCIONAL)");
define("FS_QUOTE_INQUIRY_28", "Observaciones");

//消费税邮件
define('FS_TAX_EMAIL_01','Application Received');
define('FS_TAX_EMAIL_02','FS - Your Tax Exemption Application Received');
define('FS_TAX_EMAIL_03','Your application is under review.');
define('FS_TAX_EMAIL_04','Tax Exemption State:');
define('FS_TAX_EMAIL_05','We\'ll let you know the result of your application within 1-2 business days, you can view the progress of the application by clicking the button below.');
define('FS_TAX_EMAIL_06','View application');
define('FS_TAX_EMAIL_07','If you have any questions in relation to this Tax Exemption Application, please <a href="'.HTTPS_SERVER.reset_url('service/sales_tax.html').'" target="_blank" style="color: #0070BC;text-decoration: none">learn</a> about the U.S. Sales Tax in FS.com Purchases, or <a href="'.zen_href_link(FILENAME_CONTACT_US).'" target="_blank" style="color: #0070BC;text-decoration: none">Contact Us</a> for help.');
define('FS_CHECKOUT_PAY_01','Pagar');
define('FS_COMMON_DHL','DHL Economy Select®');

//详情页新文件标记
define('FS_NEW_FILE_TAG','Nuevo');//详情页新文件标记

//inquiry
define('FS_INQUIRY_EDIT_SUCCESS_1','Tu modificación de ');
define('FS_INQUIRY_EDIT_SUCCESS_2',' se ha enviado correctamente.');
define('FS_MY_SHOPPING_CART_OFFICIAL_QUOTE','Mi cotización oficial');

define('FS_XING_HAO', '*');


define('FS_COMMON_WAREHOUSE_CN_NEW','FS.COM LIMITED<br> 
			Unit 1, Warehouse No. 7 <br> 
			South China International Logistics Center <br> 
			Longhua District <br>
			Shenzhen, 518109 <br> China');
// 德国仓
define('FS_COMMON_WAREHOUSE_EU','FS.COM GmbH<br> 
			NOVA Gewerbepark, Building 7,<br>
			Am Gfild 7<br>
			85375, Neufahrn bei Munich<br>
			Germany<br>
			Tel: +49 (0) 8165 80 90 517');
define('FS_COMMON_WAREHOUSE_US','FS.COM INC <br>
			380 CENTERPOINT BLVD<br>
			NEW CASTLE, DE 19720<br>
			United States <br>
			Tel: +1 (888) 468 7419');
// 美东仓
define('FS_COMMON_WAREHOUSE_US_EAST','A/A: FS.COM Inc.<br>
					Dirección: 380 Centerpoint Blvd,<br>
					New Castle, DE 19720,<br>
					United States<br>
					Teléfono: +1 (888) 468 7419');
// 澳洲仓
define('FS_COMMON_WAREHOUSE_AU','FS.COM PTY LTD<br>
				57-59 Edison Road<br>
				Dandenong South<br>
				VIC 3175<br>
				Australia<br>
				Tel: +61 3 9693 3488<br>
				ABN: 71 620 545 502');
define('FS_COMMON_WAREHOUSE_SG','FS TECH PTE. LTD<br>
				30A Kallang Place #11-10/11/12<br>
				Singapore 339213<br>
				Singapore<br>
				Tel: (65) 6443 7951<br>
				GST Reg No.: 201818919D');
// 新加坡仓
define('FS_COMMON_WAREHOUSE_DELIVER_TO_SG','A/A: FS Tech Pte Ltd.<br>
				Dirección: 30A Kallang Place #11-10/11/12<br>
				Singapore 339213<br>
				Singapore<br>
				Teléfono: +(65) 6443 7951');
//俄罗斯仓
define('FS_COMMON_WAREHOUSE_RU','《FiberStore.COM》Ltd.<br>
            No.4062, d. 6, str. 16<br>
            Proektiruemyy proezd<br>
            Moscow 115432<br>
            Russian Federation<br>
            Tel: +7 (499) 643 4876');
//下单邮件公司信息底部展示
// 深圳仓
define('FS_CHECKOUT_FS_NAME_CN', "FS.COM LIMITED");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_CN','
			Unit 1, Warehouse No. 7, 
			South China International Logistics Center,  
			Longhua District, 
			Shenzhen, 518109, China');
// 德国仓
define('FS_CHECKOUT_FS_NAME_EU', "FS.COM GmbH");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_EU','  
			NOVA Gewerbepark, Building 7,
			Am Gfild 7,
			85375, Neufahrn bei Munich,
			Germany');
define('FS_CHECKOUT_EMAIL_TEL_EU', '+49 (0) 8165 80 90 517');
define('FS_CHECKOUT_EMAIL_EU', 'de@fs.com');

// 美东仓
define('FS_CHECKOUT_FS_NAME_US', "FS.COM Inc");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_US',' 
			Dirección: 380 Centerpoint Blvd,
					New Castle, DE 19720,
					United States');
define('FS_CHECKOUT_EMAIL_TEL_US', 'Tel: +1 (888) 468 7419');
define('FS_CHECKOUT_EMAIL_US', 'us@fs.com');
// 澳洲仓 （澳大利亚）
define('FS_CHECKOUT_FS_NAME_AU', "FS.COM PTY LTD");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_AU','
				57-59 Edison Road,
				Dandenong South,
				VIC 3175,
				Australia,
				ABN: 71 620 545 502');
define('FS_CHECKOUT_EMAIL_TEL_AU', 'Tel: +61 3 9693 3488');
define('FS_CHECKOUT_EMAIL_AU', 'au@fs.com');
// 新加坡仓
define('FS_CHECKOUT_FS_NAME_SG', "FS TECH PTE. LTD");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_SG','
				30A Kallang Place #11-10/11/12,
				Singapore 339213,
				Singapore,
				GST Reg No.: 201818919D');
define('FS_CHECKOUT_EMAIL_TEL_SG', 'Tel: (65) 6443 7951');
define('FS_CHECKOUT_EMAIL_SG', 'sg@fs.com');


define('FS_ORDERS_TRACKING_NINJA_STATUS1', 'Recogido del remitente - FS.');
define('FS_ORDERS_TRACKING_NINJA_STATUS2', 'Paquete en proceso en el almacén de Ninja Van - Clasificación de paquetes de Ninja Van');
define('FS_ORDERS_TRACKING_NINJA_STATUS3', 'Paquete en camino');
define('FS_ORDERS_TRACKING_NINJA_STATUS4', 'Entregado correctamente');

//账户中心确认收货弹窗
define("FS_ACCOUNT_ORDER_REVIEWS_COUNT",'Reseñas de pedidos');
define('FS_ACCOUNT_HISTORY_INFO_THANK', "Gracias por comprar con nosotros.");
define('FS_ACCOUNT_HISTORY_INFO_REVIEWS', "Tu comentario es valioso para otros clientes. Nos gustaría saber tu opinión. <br />¡Haz clic en el siguiente botón y déjanos tu opinión!");
define('FS_ACCOUNT_HISTORY_INFO_NOT_NOW', "Ahora no");
define('FS_FOOTER_COOKIE_TIP_NEW','Utilizamos cookies para ofrecerte la mejor experiencia en nuestro sitio web. Al pulsar el botón Aceptar o continuar usar este sitio web, aceptas nuestro uso de cookies de acuerdo con nuestro <a href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">Política de cookies</a>. <br/>Puedes rechazar el uso de cookies haciendo clic <a href="javascript:;" class="refuse_cookie_btn_google">aquí</a>.');
define('FS_FOOTER_COOKIE_TIP_BTN','Aceptar');


//新增俄罗斯仓库
define("FS_WAREHOUSE_AREA_RU","desde el almacén en RU");
define("FS_WAREHOUSE_AREA_TIME_48","Recoge tu pedido en nuestro almacén en RU a la hora que te convenga");

//销量语言包
define('FS_PRODUCTS_SALES_SOLD', '%s vendidos');
define('FS_PRODUCTS_SALES_REVIEW','%s comentario');
define('FS_PRODUCTS_SALES_REVIEWS', '%s comentarios');

define('FS_REVIEWS_TAG_01', 'Comentarios de clientes');
define('FS_REVIEW_NEW_15', 'Haz clic en la imagen para añadir etiquetas. Puedes añadir');
define('FS_REVIEW_NEW_16', 'etiquetas.');
define('FS_REVIEW_NEW_17', 'Guardar');
define('FS_REVIEW_NEW_18', 'Editar etiqueta');
define('FS_REVIEW_NEW_19', 'Comprado recientemente');
define('FS_REVIEW_NEW_20', 'No se encuentra ningún pedido.');
define('FS_REVIEW_NEW_21', 'Confirmar');
define('FS_REVIEW_NEW_22', 'Haz clic para introducir ID/título.');
define('FS_REVIEW_NEW_23', 'Introduce el ID o el título del producto.');
define('FS_REVIEW_NEW_24', 'Añadir etiqueta para el producto');
define('FS_REVIEW_NEW_25', 'Ver la galería de fotos');
define('FS_REVIEW_NEW_26', 'etiqueta');

//详情优化
define('FS_PRODUCT_SPOTLIGHTS_01', 'Características del producto');
define('FS_PRODUCT_COMMUNITY_01', 'Comunidad');
define('FS_PRODUCT_COMMUNITY_02', 'Ideas');
define('FS_PRODUCT_COMMUNITY_03', 'Unboxing del switch S5860-20SQ | FS');
define('FS_PRODUCT_COMMUNITY_04', 'Prueba de Ixia RFC2544 para switch S5860-20SQ | FS');
define('FS_PRODUCT_COMMUNITY_05', 'Vídeo de producto: S5860-20SQ | FS');
define('FS_PRODUCT_COMMUNITY_06', '¿Cómo conectar switch de FS con switch de Cisco? | FS');
define('FS_PRODUCT_COMMUNITY_07', 'Unboxing the S3910-24TS Switch | FS');
define('FS_PRODUCT_COMMUNITY_08', 'Ixia RFC2544 Test for S3910-24TS Switch | FS');
define('FS_PRODUCT_COMMUNITY_09', 'S3910-24TS: Product Video | FS');
define('FS_PRODUCT_COMMUNITY_10', 'Unboxing the S5860-24XB-U Switch | FS');
define('FS_PRODUCT_COMMUNITY_11', 'Unboxing the S3910-48TS Switch | FS');
define('FS_PRODUCT_COMMUNITY_12', 'Ixia RFC2544 Test for S3910-48TS Switch | FS');
define('FS_PRODUCT_COMMUNITY_13', 'S3910-48TS: Product Video | FS');
define('FS_PRODUCT_COMMUNITY_14', 'First Look at S5860-24XB-U Switch | FS');
define('FS_PRODUCT_COMMUNITY_15', 'S5860-24XB-U Multi-Gig L3 Switch Ixia RFC2544 Test | FS');
define('FS_PRODUCT_COMMUNITY_16', 'Uninterruptible Power Supply Test on S5860-24XB-U | FS');
define('FS_PRODUCT_COMMUNITY_17', 'How to Connect FS Multi-Gig L3 Switch with Cisco Switch | FS');
define('FS_PRODUCT_COMMUNITY_18', 'Unboxing L2+ PoE+ Switch S3410-24TS-P | FS');
define('FS_PRODUCT_COMMUNITY_19', 'Take You to Know S3410-24TS-P in Short | FS');
define('FS_PRODUCT_COMMUNITY_20', 'How to Check Power Status of PoE Port via Web | FS');
define('FS_PRODUCT_COMMUNITY_21', 'IXIA RFC2544 Test on S3410-24TS-P PoE Switch | FS');
define('FS_PRODUCT_COMMUNITY_22', '¿Cómo reemplazar las fuentes de alimentación y los ventiladores | FS');
define('FS_PRODUCT_HIGHLIGHTS_01', 'Aspectos destacados');


//报价PDF语言包
define('FS_QUOTES_PDF_01', 'COTIZACIÓN OFICIAL');
define('FS_QUOTES_PDF_01_TAX', 'COTIZACIÓN OFICIAL');
define('FS_QUOTES_PDF_02', 'Número RQ');
define('FS_QUOTES_PDF_03', 'Creada por');
define('FS_QUOTES_PDF_04', '1. La cotización solo es válida por 15 días, comunica con tu gerente de cuenta para volver a consultar después del vencimiento.');
define('FS_QUOTES_PDF_05', '2. Por favor, deja un mensaje con el número RQ o el nombre de tu empresa cuando pagues este pedido.');
define('FS_QUOTES_PDF_TOTAL_TAX', 'Total');
//报价成功邮件语言包
define('EMAIL_QUOTES_SUCCESS_01', "Hemos recibido tu solicitud de cotización ");
define('EMAIL_QUOTES_SUCCESS_02', ' y la responderemos dentro de un día laboral.');
define('EMAIL_QUOTES_SUCCESS_03', 'Observaciones');
define('EMAIL_QUOTES_SUCCESS_04', 'Request quote, please give me your best offer.');
define('EMAIL_QUOTES_SUCCESS_05', 'Ver en mi cuenta');
define('EMAIL_QUOTES_SUCCESS_06', 'Descargar PDF');
//报价分享邮件语言包
define('EMAIL_QUOTES_SHARE_01', 'Puedes ver esta cotización y convertirla en un pedido en "Mi cuenta - Cotizaciones".');
define('EMAIL_QUOTES_SHARE_02', 'Si tienes preguntas sobre la configuración, el precio o el contrato, ');
define('EMAIL_QUOTES_SHARE_03', 'por favor, ponte en contacto con tu gerente de cuenta.');
define('EMAIL_QUOTES_SHARE_04', 'Cotización actualizada');
define('EMAIL_QUOTES_SHARE_05', 'Has recibido una nueva cotizaión desde FS.COM.');

//报价详情页语言包
define('FS_QUOTES_DETAILS_01', 'El inventario, la fecha de entrega, el impuesto estimado y el costo de envío están sujetos a cambios y se calcularán al finalizar la compra.');
define('FS_QUOTES_DETAILS_02', 'Comprar');
define('FS_QUOTES_DETAILS_03', 'A continuación se presentan los detalles de la cotización. Esta cotización es válida hasta $TIME.');
define('FS_QUOTES_DETAILS_04', 'Solicitud de cotización #:');
define('FS_QUOTES_DETAILS_05', 'Descargar PDF');
define('FS_QUOTES_DETAILS_06', 'Fecha de solicitud:');
define('FS_QUOTES_DETAILS_07', 'Fecha de cotización:');
define('FS_QUOTES_DETAILS_08', 'ID de cliente:');
define('FS_QUOTES_DETAILS_09', 'No. #');
define('FS_QUOTES_DETAILS_10', 'Gerente de cuenta:');
define('FS_QUOTES_DETAILS_11', 'Número de teléfono:');
define('FS_QUOTES_DETAILS_12', 'Dirección de entrega');
define('FS_QUOTES_DETAILS_13', 'Método de envío:');
define('FS_QUOTES_DETAILS_14', 'Dirección de facturación');
define('FS_QUOTES_DETAILS_15', 'Método de pago:');
define('FS_QUOTES_DETAILS_16', 'Ver todo');
define('FS_QUOTES_DETAILS_17', 'Referencia');
define('FS_QUOTES_DETAILS_18', 'Lo sentimos, el artículo ha sido quitado y no está disponible para la compra en línea.');
define('FS_QUOTES_DETAILS_19', 'Longitud:');
define('FS_QUOTES_DETAILS_20', 'Más');
define('FS_QUOTES_DETAILS_21', 'Este artículo incluye los siguientes productos');
define('FS_QUOTES_DETAILS_22', 'IVA/TAX:');
define('FS_QUOTES_DETAILS_23', 'Esta cotización ha expirado en $TIME. Puedes solicitar otra vez si es necesario.');
define('FS_QUOTES_DETAILS_24', 'Has realizado pedido con esta cotización con éxito.');


//报价列表页语言包
define('QUOTES_LIST_BRED_CRUMBS','Historial de cotizaciones');

define('QUOTES_LIST_TIME_TYPE_1', 'Todo el tiempo');
define('QUOTES_LIST_TIME_TYPE_2', 'Último mes');
define('QUOTES_LIST_TIME_TYPE_3', 'Últimos tres meses');
define('QUOTES_LIST_TIME_TYPE_4', 'Último año');
define('QUOTES_LIST_TIME_TYPE_5', 'Hace un año');

define('QUOTES_LIST_STATUS_TYPE_1', 'Cotizaciones online');
define('QUOTES_LIST_STATUS_TYPE_2', 'Activa');
define('QUOTES_LIST_STATUS_TYPE_3', 'Aceptada');
define('QUOTES_LIST_STATUS_TYPE_4', 'Expirada');
define('QUOTES_LIST_STATUS_TYPE_5', 'Cotizaciones offline');
define('QUOTES_LIST_STATUS_TYPE_6', 'Todos los estados');

define('QUOTES_LIST_RESULT_SINGULAR', 'resultado');
define('QUOTES_LIST_RESULT_PLURAL', 'resultados');
define('QUOTES_LIST_UPDATE_TIME', 'El precio ha sido actualizado en $TIME');
define('QUOTES_LIST_EXPIRE_TIME', 'Expiró en $TIME');
define('QUOTES_LIST_EXPIRE_TIME_ACTIVE', 'Esta cotización expirará en $TIME');
define('QUOTES_LIST_QUOTE_AGAIN', 'Solicitar de nuevo');
define('QUOTES_LIST_VIEW_ORDERS', 'Ver historial de cotizaciones');
define('QUOTES_LIST_SEARCH_PLACEHOLDER', 'Busca por número de cotización, descripción...');

define('FS_SHOPPING_CART_CREATE_QUOTE', 'Crea una cotización');
define('FS_QUOTES_ORDERS_NUMBER', 'Número de pedido');
define('QUOTES_LIST_EMPTY_TIPS', 'No se encuentra ninguna cotización.');
define('FS_QUOTES_CREATE_EMAIL_THEME','FS - Hemos recibido tu solicitud de cotización $NUM');
define('FS_QUOTES_SHARE_EMAIL_THEME','FS - Tu amigo $EMAIL te ha compartido una cotización');
define('FS_QUOTES_OFFLINE_DETAIL_TIPS', 'El costo de envío y los impuestos se calcularán en la página de pago.');


define('FS_RECENT_SEARCH', 'Búsqueda reciente');
define('FS_HOT_SEARCH', 'Búsqueda destacada');
define('FS_CHANGE', 'Cambiar');

define('FS_VIEW_WORD', 'Ver');

//一级分类页
define('FS_CATEGORIES_POPULAR', 'Categorías populares');
define('FS_CATEGORIES_BEST_SELLERS', 'Más vendidos');
define('FS_CATEGORIES_NETWORK', 'Accesorios de red');
define('FS_CATEGORIES_DISCOVERY', 'Descubrimiento');


define('CARD_NOT_SUPPORT', 'Esta forma de pago no está disponible actualmente. Por favor, utiliza otra tarjeta u otro método de pago.');
//全站help center 调整为FS Support 2021.1.15  ery
define('FS_COMMON_FS_SUPPORT','Soporte de FS');

define('FS_ADVANCED_SEARCH_RESULT_TIP_1', '<span class="new_proList_proListNtit">Se muestran resultados de</span> "###RECOMMEND_WORD###" <span class="new_proList_proListNtit">porque no se encontró ningún resultado para</span> "###SEARCH_WORD###"<span class="new_proList_proListNtit">.</span>');
define('FS_ADVANCED_SEARCH_RESULT_TIP_2', '¿Estás buscando <a href="###HREF_LINK###">###RECOMMEND_WORD###</a>?');

define('SEARCH_OFFLINE_PRODUCT_TIP_1_V2', 'Te recomendamos el siguiente nuevo producto.');
define('SEARCH_OFFLINE_PRODUCT_TIP_2_V2', 'Te recomendamos el siguiente producto similar.');
define('SEARCH_OFFLINE_PRODUCT_TIP_3_V2', 'Te recomendamos el siguiente producto personalizado.');
define('SEARCH_OFFLINE_PRODUCT_TIP_4_V2', ' ¿No encuentras lo que buscas? Contáctanos para obtener ayuda.');
define('SEARCH_OFFLINE_PRODUCT_TIP', '"KEYWORD" ya no está disponible en línea, pero está soportado por FS. Consulta la <a style="color: #0070BC;text-decoration: none" href="'.zen_href_link('offline_products_eos').'" target="_blank">Retirada de la venta</a> para más información.');
//信用卡语言包
define("CREDIT_CARD_ERROR_303","Rechazo genérico: El emisor no proporciona ninguna otra información");
define("CREDIT_CARD_ERROR_606","El emisor no permite este tipo de transacción");
define("CREDIT_CARD_ERROR_08","Datos de CVV2/CID/CVC2 no verificados");
define("CREDIT_CARD_ERROR_22","Número de tarjeta de crédito no válido");
define("CREDIT_CARD_ERROR_25","Fecha de caducidad no válida");
define("CREDIT_CARD_ERROR_26","Monto invalido");
define("CREDIT_CARD_ERROR_27","Titular de la tarjeta no válido");
define("CREDIT_CARD_ERROR_28","Número de autorización no válido");
define("CREDIT_CARD_ERROR_31","Cadena de verificación no válida");
define("CREDIT_CARD_ERROR_32","Código de transacción no válido");
define("CREDIT_CARD_ERROR_57","Número de referencia no válido");
define("CREDIT_CARD_ERROR_58","Cadena AVS no válida, la longitud de la cadena AVS ha superado el máximo de 40 caracteres.");
define('CREDIT_CARD_ERROR_260','El servicio no está disponible temporalmente debido a un error de red. Por favor, inténtalo más tarde o ponte en contacto con tu gerente de cuenta.');
define('CREDIT_CARD_ERROR_301','El servicio no está disponible temporalmente debido a un error de red. Por favor, inténtalo más tarde o ponte en contacto con tu gerente de cuenta.');
define('CREDIT_CARD_ERROR_304','No se encuentra la cuenta. Por favor, comprueba la información o ponte en contacto con el banco emisor.');
define('CREDIT_CARD_ERROR_401','El emisor quiere contacto de voz con el titular de la tarjeta. Por favor, llama a tu banco emisor.');
define('CREDIT_CARD_ERROR_502','La tarjeta ha sido reportada como perdida/robada. Por favor, ponte en contacto con tu banco emisor. Nota: No se aplica a American Express.');
define('CREDIT_CARD_ERROR_505','Tu cuenta está en archivo negativo. Por favor, intenta usar otra tarjeta o método de pago.');
define('CREDIT_CARD_ERROR_509','Excede el límite de cantidad de retiro o actividad. Por favor, intenta usar otra tarjeta o método de pago.');
define('CREDIT_CARD_ERROR_510','Excede el límite de retiro o recuento de actividades. Por favor, intenta usar otra tarjeta o método de pago.');
define('CREDIT_CARD_ERROR_519','Tu cuenta está en archivo negativo. Por favor, intenta usar otra tarjeta o método de pago.');
define('CREDIT_CARD_ERROR_521','El monto total excede el límite de crédito. Por favor, pruebe con otra tarjeta o método de pago.');
define('CREDIT_CARD_ERROR_522','Tu tarjeta ha caducado. Por favor, comprueba la fecha de caducidad o intenta usar otro método de pago.');
define('CREDIT_CARD_ERROR_530','Falta de información proporcionada por el banco emisor. Por favor, ponte en contacto con el banco o intenta usar otro método de pago.');
define('CREDIT_CARD_ERROR_531','El emisor ha rechazado la solicitud de autorización. Por favor, ponte en contacto con tu banco emisor o intenta usar otro método de pago.');
define('CREDIT_CARD_ERROR_591','Error del emisor. Por favor, ponte en contacto con el banco emisor o intenta usar otra tarjeta.');
define('CREDIT_CARD_ERROR_592','Error del emisor. Por favor, ponte en contacto con el banco emisor o intenta usar otra tarjeta.');
define('CREDIT_CARD_ERROR_594','Error del emisor. Por favor, ponte en contacto con el banco emisor o intenta usar otra tarjeta.');
define('CREDIT_CARD_ERROR_776','Transaccion duplicada. Por favor, ponte en contacto con tu gerente de cuenta para confirmar el estado de la transacción.');
define('CREDIT_CARD_ERROR_787','La transacción ha sido rechazado debido al alto riesgo. Por favor, intenta usar otro método de pago.');
define('CREDIT_CARD_ERROR_806','Tu tarjeta ha sido limitada. Por favor, intenta usar otra tarjeta o método de pago.');
define('CREDIT_CARD_ERROR_825','No se encuentra la cuenta. Por favor, comprueba la información o ponte en contacto con el banco emisor.');
define('CREDIT_CARD_ERROR_902','El servicio no está disponible temporalmente debido a un error de red. Por favor, inténtalo más tarde o ponte en contacto con tu gerente de cuenta.');
define('CREDIT_CARD_ERROR_904','Tu tarjeta no está activa. Por favor, ponte en contacto con tu banco emisor.');
define('CREDIT_CARD_ERROR_201','Número de cuenta no válido/formato incorrecto. Por favor, comprueba el número y vuelve a intentarlo.');
define('CREDIT_CARD_ERROR_204','Error no identificable. Por favor, inténtalo más tarde o cambia a otro método de pago.');
define('CREDIT_CARD_ERROR_233','El número de la tarjeta de crédito no corresponde al método de pago o el BIN no es válido. Por favor, intenta usar otra tarjeta o método de pago.');
define('CREDIT_CARD_ERROR_239','La tarjeta no es aceptada. Por favor, intenta usar otra tarjeta o elige otro método de pago.');
define('CREDIT_CARD_ERROR_261','Número de cuenta no válido/formato incorrecto. Por favor, comprueba el número y vuelve a intentarlo.');
define('CREDIT_CARD_ERROR_351','El servicio no está disponible temporalmente debido a un error de red. Por favor, inténtalo más tarde o ponte en contacto con tu gerente de cuenta.');
define('CREDIT_CARD_ERROR_755','No se encuentra la cuenta. Por favor, comprueba la información o ponte en contacto con el banco emisor.');
define('CREDIT_CARD_ERROR_758','La cuenta está bloqueada. Por favor, ponte en contacto con tu banco emisor o intenta usar otro método de pago.');
define('CREDIT_CARD_ERROR_834','La tarjeta no es aceptada. Por favor, intenta usar otra tarjeta o método de pago.');
define('HISTORY_TIPS', 'Puedes seleccionar las cotizaciones offline creadas por tu gerente de cuenta aquí.');
define('TIPS_BUTTON', 'OK');

define('FS_CHECKOUT_EPIDEMIC_TIPS', 'La entrega puede estar sujeta a retrasos o restricciones debido a medidas administrativas oficiales. 
Por favor, garantiza que alguien reciba el paquete. De lo contrario, será devuelto al remitente.');
define('FS_CHECKOUT_CUSTOMS_CLEARANCE_TIPS', 'El pedido puede retrasarse debido al despacho de aduanas.');

//quote成功发送邮件新增
define('QUOTES_NOTE_TITLE','Nota:');
define('QUOTES_NOTE_TIPS','El inventario, la fecha de entrega, el impuesto estimado y el costo de envío están sujetos a cambios y se calcularán de nuevo en la página de pago.');
define('QUOTES_RQN_NUMBER_TITLE','Nº RQN:');
define('QUOTES_TRADE_TERM_TITLE','Término comercial:');
define('QUOTES_PAYMENT_TERM_TITLE','Método de pago:');
define('QUOTES_SHIP_VIA_TITLE','Método de envío:');
define('QUOTES_DATE_ISSUED_TITLE','Fecha de emisión:');
define('QUOTES_EXPIRES_TITLE','Expirará en:');
define('QUOTES_ACCOUNT_MANAGER_TITLE','Gerente de cuenta:');
define('QUOTES_ACCOUNT_EMAIL_TITLE','Correo electrónico:');
define('QUOTES_DELIVER_TO','Dirección de entrega');
define('QUOTES_BILLING_TO','Dirección de facturación');
define('QUOTES_QUOTE_TITLE1','Artículo(s)');
define('QUOTES_QUOTE_TITLE2','Cant.');
define('QUOTES_QUOTE_TITLE3','Precio unitario');
define('QUOTES_QUOTE_TITLE4','Precio de cotización');

define('FS_WHAT_IS_DIFFERENCE', "¿En qué consisten las diferencias?");
define('FS_AVAILABILITY', 'Disponibilidad');
define('FS_ON_SALE', 'Disponible');
define('FS_END_SALE', 'No disponible');
define('FS_DIFFERENCES', 'Consulta las siguientes características detalladas para conocer plenamente las diferencias de los productos antes de realizar tu pedido.');
define('FS_SHOP_CART_SUBTOTAL','Subtotal:');

define('FS_CN_LIMIT_TIPS', 'Ten en cuenta que el artículo no se puede enviar a China.');
define('QUOTE_MESSAGE_TXT_1', 'Comentarios adicionales (por '. $_SESSION['customer_first_name'].')');
define('QUOTE_MESSAGE_TXT_2', 'Comentarios adicionales (por el/la gerente de cuenta | FS)');
