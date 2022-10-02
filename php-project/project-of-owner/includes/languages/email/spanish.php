<?php
/****************************公共头部***********************************/
define('EMAIL_HEAHER_RIGHT', '+34 (91) 123 7299');
define('EMAIL_MENU_HOME','Live Chat');
define('EMAIL_MENU_SUPPORT','con un experto');
define('EMAIL_HOME_URL',zen_href_link('index'));


/****************************公共底部****************************************/
define('EMAIL_SUPPORT_URL','FS en Facebook');
define('EMAIL_MENU_TUTORIAL','Twitter');
define('EMAIL_TUTORIAL_URL','Contáctenos ');
define('EMAIL_MENU_ABOUT_US','Mi cuenta');
define('EMAIL_ABOUT_US_URL','Ayuda rápida');
define('EMAIL_MENU_SERVICE','Política de privacidad');
define('EMAIL_SERVICE_URL','Este correo es informativo, favor no responder a esta dirección de correo.');
define('EMAIL_MENU_CONTACT_US','Contáctenos');
define('EMAIL_CONTACT_US_URL','fs.com');
define('EMAIL_MENU_PURCHASE_HELP','  Todos los derechos reservados.');
define('EMAIL_PURCHASE_HELP_URL',zen_href_link('how_to_buy'));
define('EMAIL_FOOTER_PROMPT',zen_href_link('my_dashboard'));
define('EMAIL_FOOTER_FS_COPYRIGHT',zen_href_link('privacy_policy'));
define('EMAIL_FOOTER_FS_CONTACT',zen_href_link('contact_us'));

// fairy add
define('EMAIL_FOOTER_FACEBOOK','FS en Facebook');
define('EMAIL_FOOTER_TWITTER','Twitter');
// fairy add 2017.11.28
define('EMAIL_FOOTER_SINCERELY','Sinceramente,');
define('EMAIL_FOOTER_FS_SERVICE','Servicio al cliente de <a href="'.zen_href_link(FILENAME_DEFAULT).'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a>');

/**************************************content common text**************************************/
define('EMAIL_BODY_COMMON_FSCOM','FS.COM');
define('EMAIL_BODY_COMMON_DEAR','Hola');
define('EMAIL_BODY_COMMON_THANKS','Gracias');
define('EMAIL_BODY_COMMON_PHONE','Teléfono: ');
define('EMAIL_BODY_COMMON_PARTNER','Socios');
define('EMAIL_BODY_COMMON_URL_BASE',zen_href_link('index'));

//装箱页面新增
define("FS_PRODUCT_INFO_SIZE","Tamaño:");
define("FS_PRODUCT_INFO_PIECE","Ordenar por pieza");
define("FS_PRODUCT_INFO_CASE","Ordenar por caja(");
define("FS_PRODUCT_INFO_PIS","pzs/caja)");

/*
 *客户保留购物车产品，邮件发给自己
 */
define('FS_EMAIL_CART','Su lista de cesta le está esperando.');
define('FS_EMAIL_PAST','Estaba visitando ');
define('FS_EMAIL_FS','FS.COM');
define('FS_EMAIL_SAVED','y guardó la lista de artículos para la compra futura. Utilice los siguientes enlaces para encontrar más detalles sobre todos los productos y realizar el compra en');
define('FS_EMAIL_FSCOM',zen_href_link('index'));
define('FS_EMAIL_MESSAGE','Su mensaje:');
define('FS_EMAIL_LIST',zen_href_link('save_shopping_list'));
define('FS_EMAIL_SIN','Sinceramente,');
define('FS_EMAIL_TEAM','Equipo de Servicio a Cliente');
define('FS_EMAIL_SENT','Este email ha sido enviado por su mismo ');
define('FS_EMAIL_SHARE',"'por el servicio de Compartir con un Amigo. Como una consecuencia de recibir este mensaje, no recibirá cualquier mensaje no solicitado desde ");
define('FS_EMAIL_OUR',", ver más sobre nuestra ");
define('FS_EMAIL_POLICY',"Política de Privacidad");
define('EMAIL_CUSTOMER_SHOPPING_LIST',zen_href_link('share_shopping_list'));
define('FS_EMAIL_TO_US_DEAR','Estimado/a ');
define('EMAIL_SAVE_SHOPPING_LIST_SUBJECT','Una página web desde FS.COM ha sido compartido con usted.');
/*
*客户分享购物车邮件（不同部分）
*/
define('FS_EMAIL_SENT_1','Este email fue enviado por ');
define('FS_EMAIL_CART_1','Su Amigo');
define('FS_EMAIL_CARTS_1','ha compartido una lista de cesta con usted.');
define('FS_EMAIL_PAST_1',' cree que usted quiere checar estos artículos desde FS.COM. Aquí tiene la lista. Utilice los siguientes enlaces para encontrar más detalles sobre todos los productos y realizar el compra en ');
define('FS_EMAIL_MESSAGE_1',"Mensaje:");
define('FS_EMAIL_THIS_1','Este email ha sido enviado por su amigo');
define('FS_EMAIL_USING_1','utilizando');
define('FS_EMAIL_URL_1',zen_href_link('privacy_policy'));

//标题
define('EMAIL_SAVE_SHOPPING_LIST_SUBJECT_1','FS.COM - Tiene una Lista de Cesta desde ');

// fairy add 2017.11.28
define('EMAIL_BODY_COMMON_PLATFORM','Plataforma');
define('EMAIL_BODY_COMMON_BROWSER','Nevegador');
define('EMAIL_BODY_COMMON_IP_ADDRESS','Dirección IP');
define('EMAIL_BODY_COMMON_UNKNOWN','Desconocido');
define('EMAIL_BODY_COMMON_EAMIL_USER','Información de seguridad utilizada: ');
define('EMAIL_BODY_COMMON_EAMIL_COUNTRY','País/región ');
define('EMAIL_BODY_COMMON_CUSTOMER_NAME','Nombre del cliente: ');
define('EMAIL_BODY_COMMON_CUSTOMER_EMAIL','Correo electrónico del cliente: ');

/*********************************contact us to customer*************************************/
define('EMAIL_CONTACT_US_TO_CUSTOMER_TEXT1','Hemos recibido su pregunta y le responderemos dentro de 12 horas. Además, por favor compruebe la carpeta de spam si no recibe nuestra respuesta dentro de 12 horas.');
define('EMAIL_CONTACT_US_TO_CUSTOMER_TEXT2','¿Necesita ayuda rápida? Compruebe las FAQs, y podría encontrar las respuestas.<br>O, contacte con su representante de ventas o con la atención al cliente para obetener apoyos. Ellos están siempre dispuestos a responder a su pregunta.');
define('EMAIL_CONTACT_US_TO_CUSTOMER_TEXT3','8 am.- 5 pm. PST. lunes a viernes：'.FS_PHONE_ES);
define('EMAIL_CONTACT_US_TO_CUSTOMER_TEXT4','PD. Por favor no responda a este email. Los emails enviados a esta dirección no serán contestados.');
define('EMAIL_CONTACT_US_TO_SUBJECT','Agradecemos su mensaje -- FS.COM');

/************************************regist to customer*********************************************/
define('EMAIL_REGIST_TO_CUSTOMER_SUBJECT','¡Gracias por formar parte de FS.COM!');
define('EMAIL_REGIST_TO_CUSTOMER_TEXT1','¡Gracias por formar parte de FS.COM!<br />Tu registro se ha efectuado con éxito. A partir de ahora, ingresando tu nombre de usuario y contraseña podrás consultar todos tus pedidos, realizar el seguimiento de tus pedidos abiertos, y gestionar carritos habituales, etc. ');
define('EMAIL_REGIST_TO_CUSTOMER_TEXT2','<br />¡Recibe nuestra más cordial bienvenida y brindamos la mejor experiencia de compra en <a target="_blank" href="'.zen_href_link('index').'">FS.COM</a>!');
define('EMAIL_REGIST_TO_CUSTOMER_TEXT3','Información de contacto:
<br />
<br />
Teléfono:  +34 (91) 123 7299<br />
Correo electrónico: sales@fs.com<br />');

//fairy
// 个人、企业激活邮件内容
define('EMAIL_REGIST_COMMON_VERIFY_EMAIL','Verificar correo electrónico');
define('EMAIL_REGIST_COMMON_VERIFYT_TITLE2','Si el enlace no funciona, intente copiar esta URL en la barra de direcciones de su navegador:');
define('EMAIL_REGIST_COMMON_VERIFYT_TIME','Este enlace caducará 3 días después de que se haya enviado este correo electrónico.');
define('EMAIL_REGIST_COMMON_SINCERELY','Sinceramente');
define('EMAIL_REGIST_COMMON_FS','Equipo de servicio al cliente de FS.COM');
// 个人、企业激活邮件内容
define('EMAIL_REGIST_TO_CUSTOMER_THANK','¡Gracias por configurar su cuenta FS.COM!');
define('EMAIL_REGIST_TO_CUSTOMER_INTRO','Su cuenta FS.COM es su destino para todas las excelentes características que FS.COM tiene para ofrecer a los usuarios registrados, que incluyen:');
define('EMAIL_REGIST_TO_CUSTOMER_INTRO_DES','<li>Fácil seguimiento de su historial de pedidos</li>
                  <li>Pago más rápido con un libro de direcciones</li>
                  <li>Actualizaciones de correos electrónicos sobre nuevos productos y promociones</li>
                  <li>Asistencia técnica gratuita e inmediata</li>');
define('EMAIL_REGIST_TO_CUSTOMER_VERIFYT_TITLE','Para aprovechar esta función, le solicitamos que verifique su dirección de correo electrónico haciendo clic en el siguiente enlace.');
// 企业激活邮件
define('EMAIL_REGIST_TO_COMPANY_THANK','¡Gracias por solicitar una cuenta comercial con FS.COM!');
define('EMAIL_REGIST_TO_COMPANY_INTRO','Su solicitud está actualmente en revisión. Le enviaremos un mensaje de correo electrónico en 24 horas sobre el resultado una vez sea verificado.');
define('EMAIL_REGIST_TO_COMPANY_VERIFYT_TITLE','Para finalizar la configuración de su cuenta, verifique su dirección de correo electrónico haciendo clic en el enlace a continuación.');
define('EMAIL_REGIST_TO_COMPANY_THANK_AGAIN','Agradecemos su cooperación y gracias de nuevo por su confianza en FS.COM.');
// 个人用户升级企业用户邮件
define('EMAIL_UPGRADE_TO_COMPANY_CONSULT','Si tiene alguna otra pregunta, no dude en <a href="'.zen_href_link('contact_us').'" style="color:#0070BC; text-decoration:none;">contactarnos</a>.');
define('FS_SUBMIT_SUB1','Enviar');

//fairy 个人注册
define('EMAIL_REGIST_TO_CUSTOMER_THANK_AGAIN','Ahora podría ingresar a Fiberstore con su cuenta. Si necesita más ayuda, siéntase libre de <a href="'.zen_href_link('contact_us').'" style="color:#0070BC; text-decoration:none;">contactar con nosotros.</a>');

/***************************** password forgotten to customer ***************************************/
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_SUBJECT','FS.COM - Nueva contraseña');
// fairy 2017.11.28
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_TITLE','¿Cómo restablecer la contraseña de su cuenta en <a href="'.zen_href_link(FILENAME_DEFAULT).'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a>?');
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_TEXT1','Este correo electrónico fue enviado a usted en respuesta a su solicitud para modificar su contraseña de su cuenta en <a href="'.zen_href_link(FILENAME_DEFAULT).'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a>.');
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_TEXT2','Haga clic en el enlace de abajo para ir al sitio web de <a href="'.zen_href_link(FILENAME_DEFAULT).'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> y restablecer su contraseña: ');
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_RESET_BUTTON','Restablecer la contraseña');
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_TEXT3','Tenga en cuenta que el enlace anterior será útil de solo 3 días.');
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_TEXT4','Si no realizó este cambio o si cree que una persona no autorizada ha accedido a su cuenta, por favor <a href="RESET_PWD_LINK" target="_blank" style="color:#0070BC; text-decoration:none;">restablezca su contraseña</a> inmediatamente. Luego <a href="'.zen_href_link('login').'" target="_blank" style="color:#0070BC; text-decoration:none;">entre</a> para revisar y actualizar su configuración de seguridad.');

/***************************** 修改密码成功之后发的邮件 ***************************************/
// fairy 修改密码成功之后的邮件 add 2017.11.28
define('FS_PWD_UPDATE_SUCCESS_EAMIL_THEME','FS.COM - Contraseña de la cuenta modificada');
define('FS_PWD_UPDATE_SUCCESS_EAMIL_TITLE','Su contraseña ha cambiado con éxito.');
define('FS_PWD_UPDATE_SUCCESS_EAMIL_CON1','La contraseña para su <a href="'.zen_href_link(FILENAME_DEFAULT).'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> ID (<a href="mailto:EMAIL_USER_EMAIL" style="color:#232323; text-decoration:none;"><b>EMAIL_USER_EMAIL</b></a>) ha sido cambiado con éxito en <b>EMAIL_TIME</b>.');
define('FS_PWD_UPDATE_SUCCESS_EAMIL_USER','Información de seguridad utilizada: ');
define('FS_PWD_UPDATE_SUCCESS_EAMIL_COUNTRY','País/región: ');
define('FS_PWD_UPDATE_SUCCESS_EAMIL_CON2','Ahora puede usar su nueva información de seguridad para iniciar sesión en su cuenta. Si necesita ayuda adicional, por favor <a href="'.zen_href_link('contact_us').'" target="_blank" style="color:#0070BC; text-decoration:none;">contáctenos</a>.');
define('FS_PWD_UPDATE_SUCCESS_EAMIL_CON3','Si no realizó este cambio o si cree que una persona no autorizada ha accedido a su cuenta, por favor <a href="'.zen_href_link('password_forgotten').'" target="_blank" style="color:#0070BC; text-decoration:none;">reestablezca su contraseña</a> inmediatamente. Luego <a href="'.zen_href_link('login').'" target="_blank" style="color:#0070BC; text-decoration:none;">entre</a> para revisar y actualizar su configuración de seguridad.');


/**************************************** company_regist *****************************************************/
define('EMAIL_COMPANY_REGIST_SUBJECT','Solicitud de cuenta de negocios de Fiberstore');
define('EMAIL_COMPANY_REGIST_TEXT1','Gracias por su solicitud de la cuenta de negocios para obtener más cooperación. <br><br>
La aplicación está siendo revisada, y le enviaremos un correo electrónico en 48 horas sobre el resultado una vez que la aplicación de membresía corporativa se haya verificada.');
define('EMAIL_COMPANY_REGIST_TEXT2','Atentamente,');
define('EMAIL_COMPANY_REGIST_TEXT3','Fiberstore Co., Limited');

/********************************************* checkout common ****************************************************************/
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SUBJECT','Pedido de Fiberstore# %s ');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_ORDER_NO','N.º del pedido');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_ORDERED_ON','Pedido hecho en');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_BILL_TO','Facturar a');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_PAYMENT_METHOD','Método de pago');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SHIP_TO','Enviar a');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SHIP_VIA','Enviar por');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_ITEM_NAME','Artículo');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_FSID','FS ID#');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_ITEM_PRICE','Precio del artículo');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_QTY','Cantidad');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_PRICE','Precio');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SUBTOTAL','Subtotal');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SHIP_CHARGE','Cargos de envío');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_GRAND_TOTAL','Importe total');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_FS_SKU','FS SKU#');
define('EMAIL_CHECKOUT_COMMON_PAYMENT_METHOD_PAYPAL','Paypal');
define('EMAIL_CHECKOUT_COMMON_PAYMENT_METHOD_CARD','Tarjeta de crédito/débito');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_VIEW_OR_MANAGE_ORDER','Ver o administrar pedido');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_ORDER_SUMMARY','Resumen del pedido');

/***************************************checkout_westernunion_or_wiretransfer*************************************************/
define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_TEXT1','Preguntas frecuentes');
define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_TEXT2','¿Cuándo recibiré mis artículos?');
define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_TEXT3','Una vez que confirmemos su pago y terminemos de procesar su pedido, sus artículos serán embalados y enviados a su destino inmediatamente.
			Usted puede utilizar el número de pedido para comprobar el estado de este pedido en cualquier momento en Mis pedidos. Para más detalles sobre el procesamiento y plazo de entrega, por favor contacte con nosotros.
			Para otras preguntas, por favor visite nuestro FAQ.');
define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_TEXT4','¿Cómo puedo contactar con usted?');
define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_TEXT5','Para cualquier ayuda, por favor envíenos un correo electrónico a <a target="_blank" href="mailto:sales@fs.com" style="color:#3E6EC1;">sales@fs.com</a>
      o llámenos al <a style="color:#363636;" target="_blank" value="+1 877 205 5306">+1 877 205 5306</a> o haga clic en Live Chat para chatear en línea o dejar un mensaje, y vamos a responder dentro de  12 horas. ');
define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_INTRODUCTION_WESTERN_UNION','¡Gracias por ordenar de Fiberstore! Hemos recibido su pedido y estamos a la espera de la confirmación del pago.<br>

							Por favor, visite <a target="_blank" href="'.zen_href_link('manage_orders').'" style="color:#363636;">Mis pedidos</a> para ver nuestra información de la cuenta de Western Union si no sabe la información de la cuenta durante el proceso de check out.<br><br>

							Enviar su confirmación de pago por Western Union

							Una vez que haya completado la transacción de Western Union, por favor envíe el número de MTCN a <a target="_blank" href="mailto:sales@fs.com" style="color:#363636;">sales@fs.com</a> o haga clic en el enlace de abajo para enviar los detalles de la transacción: <a target="_blank" href="$URL" style="color:#363636;">Haga clic para enviar los detalles de la transacción</a>

							No podemos procesar su orden hasta que su pago ha sido confirmado. Una vez que su pago haya sido confirmado, vamos a enviarle un correo electrónico "Confirmación de Pago" y, a continuación comenzaremos a procesar su pedido.<br>

							¿Necesita más ayuda para pagar su pedido? Simplemente póngase en contacto con nosotros en <a target="_blank" href="mailto:sales@fs.com" style="color:#363636;">sales@fs.com</a> para obtener ayuda. Le contestaremos dentro de 12 horas.<br>');
define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_INTRODUCTION_WIRE_TRANSFER','<p>¡Gracias por ordenar de FiberStore! Hemos recibido su pedido y estamos a la espera de la confirmación del pago.<br>

      Por favor, visite <a target="_blank" href="'.zen_href_link('manage_orders').'" style="color:#363636;">Mis pedidos</a> para ver nuestra información de la cuenta de transferencia bancaria si no sabe la información de la cuenta durante el proceso de check out.</p>

      <p>Enviar su confirmación de pago por transferencia bancaria<br>

        Una vez que haya completado la transferencia bancaria, por favor envíe la comfirmación a <a target="_blank" href="mailto:sales@fs.com" style="color:#363636;">sales@fs.com</a> o haga clic en el enlace de abajo para enviar los detalles de la transacción: <a target="_blank" href="$URL" style="color:#363636;">Haga clic para enviar los detalles de la transacción </a><br>

       No podemos procesar su orden hasta que su pago ha sido confirmado. Una vez que su pago haya sido confirmado, vamos a enviarle un correo electrónico "Confirmación de Pago" y, a continuación comenzaremos a procesar su pedido.</p>

      <p>¿Necesita más ayuda para pagar su pedido? Simplemente póngase en contacto con nosotros en <a target="_blank" href="mailto:sales@fs.com" style="color:#363636;">sales@fs.com</a> para obtener ayuda. Le contestaremos dentro de 12 horas.</p>');

define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_INTRODUCTION_PURCHASE_ORDER','<p>Gracias por comprar con nosotros, aquí está los detalles de su orden de compra: </p>');

define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_INTRODUCTION_PURCHASE_ORDER_TEXT1","<p style='color:rgb(51,51,51);margin:0;padding:0;'>Por favor vaya a <a  href='".zen_href_link('manage_orders')."'>'Mis pedidos'</a> para cargar el archivo PO si aún no lo ha hecho. No podemos procesar su pedido hasta que se haya confirmado su pedido. </p>");

define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_INTRODUCTION_PURCHASE_ORDER_TEXT2","<p style='color:rgb(51,51,51);margin:0;padding:0;'>Si tiene más preguntas sobre su pedido, envíenos un correo a <a target='_blank' href='http://sales@fs.com'>sales@fs.com</a>. Nos pondremos en contacto con usted dentro de las 12 horas.</p>");	  
/************************************* checkout paypal or credit card ****************************************/
define('EMAIL_CHECKOUT_PAYPAL_TEXT1','Pedido recibido, esperando la confirmación de pago');
/*************************************** checkout payment success ******************************/
define('EMAIL_CHECKOUT_PAYMENT_SUCCESS_TEXT1','¡Gracias por tu compra!Hemos recibido tu pedido y está siendo procesado, a continuación puedes revisar los detalles del mismo.Para cualquier duda estamos a tus órdenes en: <a href="'.zen_href_link('customer_service').'"target="_blank">Contáctenos</a>.');

/*********************************** orders status *************************************/
define('EMAIL_ORDERS_STATUS_SUBJECT','Estado del pedido # ');
define('EMAIL_ORDERS_STATUS_FOR_ORDER','Nº del pedido:');
define('EMAIL_ORDERS_STATUS_TEXT1','El estado se ha cambiado. Por favor visite <a href="'.zen_href_link('account_history_info').'&orders_id=$ORDER_ID">Mis pedidos</a> en www.fs.com para comprobar los detalles.');
define('EMAIL_ORDERS_STATUS_TEXT2','Para cualquier ayuda, por favor envíenos un correo electrónico a	sales@fs.com o llámenos al +1 877 205 5306, y vamos a responder dentro de las 12 horas.');
define('EMAIL_ORDERS_STATUS_TEXT3','Gracias por todo el apoyo.');
define('EMAIL_ORDERS_STATUS_TEXT4','Saludos cordiales,');
define('EMAIL_ORDERS_STATUS_TEXT5','Equipo de servicios de Fiberstore');

/************************************** sales manager to customer *********************************************/
define('EMAIL_SALES_MANAGER_SUBJECT','Administrador asigna una representante de ventas para usted -- FS.COM');
define('EMAIL_SALES_MANAGER_TEXT1','¡Buen día! <br><br>Gracias por unirse a Fiberstore. ');
define('EMAIL_SALES_MANAGER_TEXT2','Soy');
define('EMAIL_SALES_MANAGER_TEXT3','su representante de ventas. ');
define('EMAIL_SALES_MANAGER_TEXT4','Si tiene alguna duda o pregunta sobre nuestro producto u otra información relacionada sobre Fiberstore, no dude en ponerse en contacto conmigo. Es un placer ofrecer pleno apoyo para usted.<br><br><br>
			<span style="font-family:Calibri;font-size:13px;">Esta es mi información de contacto:</span>');
define('EMAIL_SALES_MANAGER_TEL','Tel:');
define('EMAIL_SALES_MANAGER_MOBILE','Móvil:');
define('EMAIL_SALES_MANAGER_EMAIL','Email:');
define('EMAIL_SALES_MANAGER_TEXT5','(12/7 Apoyo de &amp; compras)');
define('EMAIL_SALES_MANAGER_TEXT6','<span style="font-family:Calibri;font-size:13px;">Room 301, Third Floor, Weiyong Building, No. 10, Kefa Road, Nanshan District, Shenzhen, 518057, CHINA</span>');
define('EMAIL_SALES_MANAGER_TEXT7','Atentamente');

/************************************ backend common *********************************************/
//update orders status 
define('EMAIL_BACKEND_COMMON_PAYMENT_RECEIVED',' Pago recibido');
define('EMAIL_BACKEND_COMMON_YOUR_ORDER','Su pedido:');
define('EMAIL_BACKEND_COMMON_TEXT1','se ha actualizado:');
define('EMAIL_BACKEND_COMMON_TRACK_INFORMATION','Información de seguimiento:');
define('EMAIL_BACKEND_COMMON_PROCESSING',' Procesando');
define('EMAIL_BACKEND_COMMON_TRACKING_INFO',' Información de seguimiento');
define('EMAIL_BACKEND_COMMON_TEXT2',' Todos los productos en su pedido han sido enviado, y se tardará 3-4 días laborales para llegar a su dirección, y usted podría obtener la información de seguimiento en su cuenta en Fiberstore.');
define('EMAIL_BACKEND_COMMON_SHIPPING_METHOD','Método de envío:');
define('EMAIL_BACKEND_COMMON_TACKINF_NUMBER','Número de seguimiento:');
define('EMAIL_BACKEND_COMMON_TEXT3','ha sido enviado.');
define('EMAIL_BACKEND_COMMON_REFUNDED',' Reembolsado');
define('EMAIL_BACKEND_COMMON_IS_CANCELED','cancelado');
define('EMAIL_BACKEND_COMMON_CANCELED','Cancelado');
define('EMAIL_BACKEND_COMMON_COMPLETED',' Completado');
define('EMAIL_BACKEND_COMMON_NO_INFO','no info');
define('EMAIL_BACKEND_COMMON_TEXT4','Consejos: Para más detalles, por favor entre en su cuenta de fiberstore. Si usted tiene alguna pregunta, por favor');
//reviews to customer
define('EMAIL_BACKEND_COMMON_REVIEWS_REPLY_SUBJECT','Nueva respuesta de reseña de Fiberstore.');
define('EMAIL_BACKEND_COMMON_YOUR_REVIEW','Su reseña:');
define('EMAIL_BACKEND_COMMON_PRODUCTS_NAME_URL','Nombre de productos|Reseña Url:');
define('EMAIL_BACKEND_COMMON_REPLY_BY','Respuesta de:');
define('EMAIL_BACKEND_COMMON_REPLY_CONTENT','Contenido de respuesta:');

/*********************************** business account success to customer *************************************************/
define('EMAIL_BUSINESS_ACCOUNT_SUCCESS_SUBJECT','Su solicitud de cuenta de negocios ha sido aceptada.');
define('EMAIL_BUSINESS_ACCOUNT_SUCCESS_TEXT1','Felicitaciones, su solicitud de la cuenta de negocios ha sido aceptada.');
define('EMAIL_BUSINESS_ACCOUNT_SUCCESS_TEXT2','Con la cuenta de negocios, disfrutará de los siguientes servicios:');
define('EMAIL_BUSINESS_ACCOUNT_SUCCESS_TEXT3','1. Obtener $PER descuento<br>
        2. El mejor método de envío<br>
        3. Representante de ventas profesional y soporte técnico<br>
        <br><br>Atentamente<br><br>
        Fiberstore Co., Limited');

/************************    customer question to customer     *********************/
define('EMAIL_CUSTOMER_QUESTION_TC_SUBJECT','Sus preguntas han sido respondidas por Fiberstore');
define('EMAIL_CUSTOMER_QUESTION_TC_TEXT1','Gracias por sus comentarios de las preguntas.');
define('EMAIL_CUSTOMER_QUESTION_TC_TEXT2','Haremos todo lo posible para ofrecerles soluciones integrales más actualizadas.');
define('EMAIL_CUSTOMER_QUESTION_TC_TEXT3','Sinceramente');

//购物车页面保存购物列表邮件
define('EMAIL_SAVE_SHOPPING_LIST_SUBJECT','¡Una página web de FS.COM ha sido compartida con usted!');
define('EMAIL_SAVE_DEAR','Estimado(a)');

//西雅图发货延迟通知邮件 2017.8.2  ery
define('EMAIL_BODY_COMMON_TAX_NUMBER','Número de VAT');
define('ORDER_DELAY_TITLE','Productos para su urgente pedido# están en stock || FS.COM');
define('ORDER_DELAY_EMAIL_WE',"Estamos encantados de recibir su pedido% s en FS.COM.");
define('ORDER_DELAY_EMAIL_THIS',"Este correo electrónico es para mantenerlo informado sobre los artículos %s en su pedido recién llegado a nuestro almacén. Nuestro departamento de control de calidad necesita un poco de tiempo para ordenar e inspeccionar los artículos recibidos, por lo que habrá alguna demora para su envío durante la noche.");
define('ORDER_DELAY_EMAIL_PLEASE',"Por favor tengan paciencia con nosotros mientras vamos a arreglar el envío y mantenerlo actualizado con la información de seguimiento inmediatamente después. Sinceramente lo siento por las molestias.");
define('ORDER_DELAY_EMAIL_THANKS','Gracias por su paciencia de antemano.');

// add by Aron
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SUBJECT1','Confirmado por el pedido de Fiberstore # %s ');
define('EMAIL_CHECKOUT_COMMON_TO_PURCHASE_CUSTOMER_SUBJECT','Orden de compra de Fiberstore # %s ');
/************************************* checkout purchase ****************************************/
define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_INTRODUCTION_PURCHASE_ORDER_TEXT3","<p style='color:rgb(51,51,51);margin:0;padding:0;'> ¡Gracias de nuevo por su pedido! </p>");
define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_INTRODUCTION_PURCHASE_ORDER_TEXT4","<p style='color:rgb(51,51,51);margin:0;padding:0;'> Atención al cliente de FS.COM </p>");
define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_START1","Gracias por los documentos de PO, se podía ver el PO a través  <a href='".zen_href_link('manage_orders')."'  target='_blank'>'Mis pedidos'</a>.");
define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_START2","Su pedido será procesado en breve, el número de seguimiento será enviado una vez que las mercancías se envíen.");
define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_START3","Si tienes alguna pregunta, por favor no dude en <a href='".zen_href_link('contact_us')."'  target='_blank'>ponerse en contacto con nosotros</a>.");
define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_START4","¡Gracias!");
define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_START_NO","Número de PO  ");

// fairy 异地登录邮件 add 2017.11.28
define('FS_OFFSITE_LOGIN_EAMIL_THEME','FS.COM - Notificación de nueva actividad de la cuenta');
define('FS_OFFSITE_LOGIN_EAMIL_TITLE','Nuevo inicio de sesión en EMAIL_USER_DEVICE');
define('FS_OFFSITE_LOGIN_EAMIL_CONTENT1','Su cuenta de FS <a href="mailto:EMAIL_USER_EMAIL" style="color:#232323; text-decoration:none; font-weight:600;">EMAIL_USER_EMAIL</a> acaba de iniciar sesión en un nuevo dispositivo.');
define('FS_OFFSITE_LOGIN_EAMIL_LOCATION','Ubicación aproximada');
define('FS_OFFSITE_LOGIN_EAMIL_TIME','Timpo');
define('FS_OFFSITE_LOGIN_EAMIL_CONTENT2','Si no reconoce esta actividad o si cree que una persona no autorizada ha accedido a su cuenta, restablezca su contraseña de inmediato.');
define('FS_OFFSITE_LOGIN_EAMIL_CONTENT3','Si tiene más preguntas, siéntase libre de <a href="'.zen_href_link('contact_us').'" target="_blank" style="color:#0070BC; text-decoration:none;">contactarnos</a>.');

// fairy 修改密码成功
define('FS_MODIFY_PWD_EAMIL_SUCCESS_THEME','FS.COM - Contraseña de cuenta modificada');
define('FS_MODIFY_PWD_EAMIL_SUCCESS_TITLE','Su contraseña de cuenta ha sido modificada con éxito.');
define('FS_MODIFY_PWD_EAMIL_SUCCESS_CONTENT1','La contraseña para su <a href="'.zen_href_link(FILENAME_DEFAULT).'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> ID (<a href="mailto:EMAIL_USER_EMAIL" style="color:#232323; text-decoration:none;"><b>EMAIL_USER_EMAIL</b></a>) ha sido modificada con éxito en <b>EMAIL_TIME</b>.');
define('FS_MODIFY_PWD_EAMIL_SUCCESS_CONTENT2','Ahora puede utilizar la nueva información de seguridad para entrar en su cuenta. Si necesita ayuda adicional, por favor <a href="'.zen_href_link('contact_us').'" target="_blank" style="color:#0070BC; text-decoration:none;">contáctenos</a>.');
define('FS_MODIFY_PWD_EAMIL_SUCCESS_CONTENT3','Si no ha cambiado su contraseña o si otra persona entra en su cuenta sin autoridad, por favor <a href="'.zen_href_link('password_forgotten').'" target="_blank" style="color:#0070BC; text-decoration:none;">reestablezca su contraseña</a> inmediatamente.  Luego <a href="'.zen_href_link('login').'" target="_blank" style="color:#0070BC; text-decoration:none;">entre</a> y actualice ajustes de seguridad.');

// fairy 修改邮件成功
define('FS_MODIFY_EMAIL_SUCCESS_EAMIL_THEME','FS.COM - Dirección de Email modificada');
define('FS_MODIFY_EMAIL_SUCCESS_EAMIL_TITLE','La dirección de su Email ha sido modificada con éxito.');
define('FS_MODIFY_EMAIL_SUCCESS_EAMIL_CONTENT1','La dirección de su Email ha sido modificada con éxito en <b>EMAIL_TIME</b>. La dirección nueva de su Email es <a href="mailto:EMAIL_USER_EMAIL" style="color:#232323; text-decoration:none; font-weight:600;">EMAIL_USER_EMAIL</a>.');
define('FS_MODIFY_EMAIL_SUCCESS_EAMIL_CONTENT2','Ahora puede utilizar la nueva dirección de Email para entrar en su cuenta. Si necesita ayuda adicional, por favor <a href="'.zen_href_link('contact_us').'" target="_blank" style="color:#0070BC; text-decoration:none;">contáctenos</a>.');
define('FS_MODIFY_EMAIL_SUCCESS_EAMIL_CONTENT3','Si no ha cambiado su dirección o si otra persona entra en su cuenta sin autoridad, por favor <a href="'.zen_href_link('password_forgotten').'" target="_blank" style="color:#0070BC; text-decoration:none;">reestablezca su contraseña</a> inmediatamente.  Luego <a href="'.zen_href_link('login').'" target="_blank" style="color:#0070BC; text-decoration:none;">entre</a> y actualice ajustes de seguridad.');

// fairy 修改邮件给销售的
define('FS_MODIFY_EMAIL_SUCCESS_SALE_EAMIL_THEME','FS.COM - Dirección de Email de tu cliente modificada');
define('FS_MODIFY_EMAIL_SUCCESS_SALE_EAMIL_TITLE','Tu cliente(CUSTOMER_NAME）ha cambiado la dirección de Email.');
define('FS_MODIFY_EMAIL_SUCCESS_SALE_EAMIL_CONTENT1','La dirección de Email de tu cliente(CUSTOMER_NAME）ha sido modificada con éxito en <b>EMAIL_TIME</b>.');
define('FS_MODIFY_EMAIL_SUCCESS_SALE_EAMIL_CONTENT2','La dirección de Email anterior es OLD_EMAIL.');
define('FS_MODIFY_EMAIL_SUCCESS_SALE_EAMIL_CONTENT3','La dirección de Email nueva NEW_EMAIL.');

//add by aron
define("EMAIL_CHECKOUT_WAREHOUSE_THANK","Gracias por comprar en");
define("EMAIL_CHECKOUT_WAREHOUSE_LIVE","Live Chat");
define("EMAIL_CHECKOUT_WAREHOUSE_WITH","con un experto");
define("EMAIL_CHECKOUT_WAREHOUSE_SIN","Sinceramente,");
define("EMAIL_CHECKOUT_WAREHOUSE_DEAR","Hola");
define("EMAIL_CHECKOUT_WAREHOUSE_TEAM","Equipo de Servicio al Cliente ");
define("EMAIL_CHECKOUT_WAREHOUSE_SHPPING","Dirección de envío: ");
define("EMAIL_CHECKOUT_WAREHOUSE_TIT","Si tiene más preguntas con respecto a su pedido, siéntase libre de ");
define("EMAIL_CHECKOUT_WAREHOUSE_YOUR","Su PO#");
define("EMAIL_CHECKOUT_WAREHOUSE_UP","ha sido cargado exitosamente.");
define("EMAIL_CHECKOUT_WAREHOUSE_INVOICE","Gracias por los documentos de PO, ahora puede ver el PO e imprimir la factura a través de");
define("EMAIL_CHECKOUT_WAREHOUSE_ORDERS","Mis pedidos");
define("EMAIL_CHECKOUT_WAREHOUSE_NOW","ahora.");
define("EMAIL_CHECKOUT_WAREHOUSE_CHARGES","Gastos de envío");
define("EMAIL_CHECKOUT_WAREHOUSE_TOTAL","Gran total");
define("EMAIL_CHECKOUT_WAREHOUSE_SUBTOTAL","Subtotal");
define("EMAIL_CHECKOUT_WAREHOUSE_PROCESS","Su pedido será procesada pronto, si tiene más preguntas con respecto a su pedido, no dude en");
//checkout_payment_success
define('EMAIL_CHECKOUT_SUCCESS_YOUR','Su pago del pedido confirmado aquí.');
define('EMAIL_CHECKOUT_SUCCESS_WE','Hemos recibido su pago por pedido ');
define('EMAIL_CHECKOUT_SUCCESS_THANK',', gracias por su gran apoyo aquí.');
//rma_success   售后单申请成功邮件
define('EMAIL_RMA_SUCCESS_APPROVED_YRR','Su solicitud RMA # %s ha sido aprobada.');
define('EMAIL_RMA_SUCCESS_APPROVED_YOUR','Su solicitud RMA # %s  ha sido aprobada, siga el diagrama de flujo en línea y devuelva el paquete a la dirección indicada.');
define('EMAIL_RMA_SUCCESS_APPROVED_WE','Procesaremos el %s una vez que recibamos el paquete. Para ayuda inmediata, siéntase libre de <a href="'.zen_href_link('contact_us').'" target="_blank" style="color:#0070BC; text-decoration:none;">Contactar con nosotros
</a>.');
define('EMAIL_RMA_SUCCESS_SUBMIT_YOUR','Su solicitud RMA # %s está en revisión.');
define('EMAIL_RMA_SUCCESS_SUBMIT_WE','Hemos recibido su solicitud de RMA y tendremos una revisión rápida. Para obtener más información sobre el proceso, sus representantes de ventas especializados lo actualizarán oportunamente.');
define('EMAIL_RMA_SUCCESS_SUBMIT_FOR','Para ayuda inmediata, siéntase libre de <a href="'.zen_href_link('contact_us').'" target="_blank" style="color:#0070BC; text-decoration:none;">Contactar con nosotros</a>.');
define('EMAIL_RMA_SUCCESS_TITLE','FS.COM - Solicitud de RMA # %s');

// fairy 申请报价之后的邮件
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_THEME','FS.COM - Solicitud de cotización INQUIRY_NUMBER');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_TITLE','Se recibió su solicitud de cotización INQUIRY_NUMBER.');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_TITLE_SALE','Usted tiene una nueva solicitud de cotización INQUIRY_NUMBER.');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_CONTENT1','A continuación encontrará los detalles de su solicitud de cotización. Uno de nuestros representantes se comunicará con usted lo antes posible con la información solicitada.');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_CONTENT2','Pedir detalles');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_CONTENT3','Si es un miembro registrado, puede rastrear y revisar los detalles de la cotización vía <a href="'.zen_href_link('inquiry_list').'" style="color: #0070BC;">centro de cuenta</a>.');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_CONTENT4','Gracias por enviar una solicitud de cotización. Uno de nuestros representantes se comunicará con usted lo antes posible con la información solicitada.');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_RQ_NUMBER','Número de RQ');

//fairy 个人中心用户添加评论，给对应销售发的邮件
define('FS_PRODUCT_REVIEW_SUCCESS_SALE_EMAIL_THEME','Nuevo comentario de cliente de producto de FS.');
define('FS_CUSTOMER_REVIEWS', 'Comentarios de cliente');
define('FS_REVIEWS_URL', 'Nombre de cliente|URL de comentarios');
define('FS_REVIEW_RATING', 'Valoración de comentario');
define('FS_REVIEW_CONTENT', 'Contenido de comentario');
