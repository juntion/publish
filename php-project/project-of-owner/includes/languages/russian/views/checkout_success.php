<?php
/*************************content*************************/
//ery		2014-9-18		add
define('HEADING_TITLE', 'Спасибо Вам!');
define('FS_SUCCESS_CART','Корзина');
define('FS_SUCCESS_CHECKOUT','Оформить Заказ');
define('FS_SUCCESS_SUCCESS','Успешно');
define('FS_SUCCESS_LIVE','Чат Онлайн');
define('FS_SUCCESS_THANK','Оплата успешно выполнена! Мы обработаем ваш заказ как можно скорее.');
define('FS_SUCCESS_SUMMARY','Содержание Заказа');
define('FS_SUCCESS_NUMBER','Номер Заказа');
define('FS_SUCCESS_TOTAL','Итоговая Сумма');
define('FS_SUCCESS_ITEM','Кол-во');
define('FS_SUCCESS_METHOD','Способ Доставки');
define('FS_SUCCESS_DATE','Дата Заказа');
define('FS_SUCCESS_PAYMENT','Способ Оплаты');
define('FS_SUCCESS_CREDIT','Кредитные/Дебетовые Карты');
define('FS_SUCCESS_IF','Если в сомнении, свяжитесь с нами:    Тел :+1-425-226-2035      E-mail:  ');
define('FS_SUCCESS_SALES','sales@fiberstore.com');
define('FS_SUCCESS_SUPPORT','Support@fiberstore.com');
define('FS_SUCCESS_YOU_CAN','Заказы успешно отправлены. Вы можете');
define('FS_SUCCESS_VIEW','Посмотреть Мои Заказы');
define('FS_SUCCESS_CHANGE','Сменить Мой Профиль');
define('FS_SUCCESS_SHIPPING','Адрес Доставки');
define('FS_SUCCESS_BACK','Назад');
/*****************html_checkout_success_hsbc.php*****************/
define('FS_SUCCESS_YOUR_NEXT','Далее необходимо завершить Wire Transfer оплаты и представить ваши платежные реквизиты.');
define('FS_SUCCESS_WIRE','Банковский Перевод');
define('FS_SUCCESS_ORDER','Печатать');
define('FS_SUCCESS_DETAIL','Информация Бенефициара Банковского Перевода');
define('FS_SUCCESS_BANK_NAME','Название Банка-Получателя');
define('FS_SUCCESS_HSBC','HSBC Hong Kong');
define('FS_SUCCESS_AC_NAME','Наименование Счета Бенефициара');
define('FS_SUCCESS_CO','FS.COM LIMITED');
define('FS_SUCCESS_AC_NO','Номер Счета Бенефициара');
define('FS_SUCCESS_TEL','817-888472-838');
define('FS_SUCCESS_SWIFT','СВИФТ-Код');
define('FS_SUCCESS_HK','HSBCHKHHHKH');
define('FS_SUCCESS_BANK_ADRESS','Адрес Банка-Получателя');
define('FS_SUCCESS_ROAD','1 Queen\'s Road Central, Hong Kong');
define('FS_SUCCESS_OUR','Адрес Нашей Компании');
define('FS_SUCCESS_NO','Eastern Side, Second Floor, Science &amp; Technology Park, No.6, Keyuan Road, Nanshan District, Shenzhen, China');
/******************html_checkout_success_paypalwpp.php*******************/
define('FS_SUCCESS_PAYPAL','Paypal');
define('FS_SUCCESS_TRANSFER','Transfer Информация Бенефициара');
define('FS_SUCCESS_TRANS_CODE','Paypal Код Операции');
define('FS_SUCCESS_YOU','Теперь вы можете вернуться на');
define('FS_SUCCESS_HOME','Главную Страницу');
define('FS_SUCCESS_OR','или просмотреть');
define('FS_SUCCESS_MY','Мой Заказ');
/*****************html_checkout_success_westernunion.php******************/
define('FS_SUCCESS_WES_YOUR','Далее необходимо завершить Western Union оплаты и представить ваши платежные реквизиты.');
define('FS_SUCCESS_WES_BENE','Информация Бенефициара');
define('FS_SUCCESS_BENEFICIARY','Бенефициара');
define('FS_SUCCESS_ZYX','ZongYun Xu');
define('FS_SUCCESS_FIRST','Имя');
define('FS_SUCCESS_ZY','ZongYun');
define('FS_SUCCESS_LAST','Фамилия');
define('FS_SUCCESS_X','Xu');
define('FS_SUCCESS_WES_RECEIVER','Номер телефона получателя');
define('FS_SUCCESS_PHONE','13926572260');
define('FS_SUCCESS_ADDRESS','Адрес');
define('FS_SUCCESS_SZ','Shenzhen 518045, China');
define('FS_SUCCESS_WU','Western Union');
define('FS_SUCCESS_NOTE','Внимание');
define('FS_SUCCESS_YOUR_ORDER','Статус вашего заказа изменится на “Оплата Подтверждена” в течение 2 рабочих дня после подтверждения вашей оплаты. Некоторые заказы могут занять дополнительное время для проверки.');

//add by frankie 2018.1.2.
define("FS_SUCCESS_PURCHASE_ADDRESS_NOTE","Адрес доставки не соответствует таковому на форме заявления на кредитный аккаунт. Мы рассмотрим заказ и отправим результат на вашу почту в течение 12 часов. Пожалуйста, загрузите заказ на покупку(PO) в течение 7 рабочих дней, или заказ будет автоматически отменен из-за изменения запасов.");
define("FS_SUCCESS_PURCHASE_MONEY_NOTE","Ваш доступный кредит был переполнен. Чтобы мы быстро обработали этот заказ, пожалуйста, оплатите предыдущие заказы на вращение кредитного лимита, или вы можете перейти в <a href ='".zen_href_link('my_dashboard')."'>”Мой кредит”</a>, чтобы подать заявку на увеличение кредитного лимита. Пожалуйста, загрузите заказ на покупку(PO) в течение 7 рабочих дней, или заказ будет автоматически отменен из-за изменения запасов.");
define("FS_SUCCESS_PURCHASE_DOUBLE_NOTE","Адрес доставки не соответствует таковому на форме заявления на кредитный аккаунт и ваш доступный кредит был переполнен. Чтобы мы быстро обработали этот заказ, пожалуйста, оплатите предыдущие заказы на вращение кредитного лимита, или вы можете перейти в <a href ='".zen_href_link('my_dashboard')."'>”Мой кредит”</a>, чтобы подать заявку на увеличение кредитного лимита. Мы рассмотрим заказ и отправим результат на вашу почту в течение 12 часов. Пожалуйста, загрузите заказ на покупку(PO) в течение 7 рабочих дней, или заказ будет автоматически отменен из-за изменения запасов.");
define("FS_SUCCESS_PURCHASE_MONEY_NOTE_1","Пожалуйста, загрузите заказ на покупку(PO) в течение 7 рабочих дней, или заказ будет автоматически отменен из-за изменения запасов");
define('FIBER_CHECK_SPARK','Счет в Банке Sparkasse:');
define("PICK_UP_ALERT1",'Требуется имя на удостоверении личности.');
define("PICK_UP_ALERT2",'Требуется номер телефона.');
define("PICK_UP_ALERT4",'Требуется время забора посылки.');
//add by helun 2018.5.15
define('FS_CHECKOUT_SUCCESS_01','заказы.');
define('FS_CHECKOUT_SUCCESS_02','Распечатать заказ');
define('FS_CHECKOUT_SUCCESS_03','Заказ');
define('FS_CHECKOUT_SUCCESS_04','');
define('FS_CHECKOUT_SUCCESS_06','Sparkasse Freising');
define('FS_CHECKOUT_SUCCESS_07',FS_DE_COMPANY_NAME);
define('FS_CHECKOUT_SUCCESS_08','DE16 7005 1003 0025 6748 88');
define('FS_CHECKOUT_SUCCESS_09','BYLADEM1FSI');
define('FS_CHECKOUT_SUCCESS_10','25674888');
define('FS_CHECKOUT_SUCCESS_11','Untere Hauptstr.29, 85354, Freising');
define('FS_CHECKOUT_SUCCESS_12','Заказ на покупку');
define('FS_CHECKOUT_SUCCESS_13','Дней');
define('FS_CHECKOUT_SUCCESS_14','Загрузить PO файл');

//add by Aron 2017.7.18
define('FS_SUCCESS_PURCHASE_YOUR_NEXT','Дальше загрузите ваш заказ на поставку (PO). Мы отправим груз при получении PO.');
define('FS_SUCCESS_PAYMENT_DATE','Дата Платежа');

//add by Aron 2017.7.25
define("FS_UPLOAD_TITLE","Загрузить Заказ на Поставку");
define("FS_UPLOAD_TEXT","Загрузите ваш Заказ на Поставку. Мы начнем обрабатывать Ваш заказ при получении PO. Убедитесь, что все необходимые подписи и информация были предоставлены. ");
define('FS_CHECKOUT_SUCCESS_05','Если у вас есть любой вопрос, пожалуйста, свяжитесь с нами по телефону '.fs_new_get_phone().' или напишите нам');
define('FS_CHECKOUT_SUCCESS_05_1','Если у вас есть любой вопрос, пожалуйста, свяжитесь с нами по телефону $PHONE или напишите нам $EMAIL.');
define('FS_SUCCESS_PURCHASE','Ваш заказ разделен на');
define('FS_CHECKOUT_SUCCESS_SALES','.');

//OP下单成功后提示语
define('FS_CHECKOUT_PURCHASE_ADDRESS','Адрес доставки не совпадает с адресами в Вашей заявке на кредит. Мы будем проверять заказ и сообщать Вам в течение 12 часов по электронной почте.');
define('FS_CHECKOUT_PURCHASE_EXCESS','Ваш доступный кредит был превышен. Чтобы заказ быстро обработан, оплатите предыдущие заказы для восстановления кредита, или Вы можете войти в раздел "Мой кредит" для подачи заявления на увеличение кредитного лимита.');
define('FS_CHECKOUT_PURCHASE_ALL','Адрес доставки не совпадает с адресами в Вашей заявке на кредит и доступный кредит тоже был превышен. Чтобы заказ быстро обработан, оплатите предыдущие заказы для восстановления кредита, или Вы можете войти в раздел "Мой кредит" для подачи заявления на увеличение кредитного лимита. Мы будем проверять заказ и сообщать Вам в течение 12 часов по электронной почте.');

//下单成功优化 add time 2020-04-06 jay
define('FS_CHECKOUT_SUCCESS_NEW_01', 'Спасибо за ваш заказ');
define('FS_CHECKOUT_SUCCESS_NEW_02', 'Из-за изменений запасов заказ будет отменен через 7 дней. Завершите платеж в течение 1-3 рабочих дней и укажите номер заказа FS или название вашей компании. Это поможет нашей финансовой группе определить ваш перевод и обработать заказы в своевременно.');
define('FS_CHECKOUT_SUCCESS_NEW_03', 'Информация о заказе');
define('FS_CHECKOUT_SUCCESS_NEW_PO_NUMBER_04', 'Номер заказа');
define('FS_CHECKOUT_SUCCESS_NEW_DELIERY_ADDRESS_05', 'Адресс доставки');
define('FS_CHECKOUT_SUCCESS_NEW_PAYMENT_INSTRUCTIONS_06', 'Инструкция по оплате');
define('FS_CHECKOUT_SUCCESS_NEW_07', 'После успешной отправки платежа отправьте банковскую квитанцию на ');
define('FS_CHECKOUT_SUCCESS_NEW_08', ' или ваш менеджер. Это поможет подготовить ваш заказ с приоритетом и избежать отмены заказа. Пожалуйста, отправьте ваш платеж на аккаунт ниже.');
define('FS_CHECKOUT_SUCCESS_NEW_BSB_09', 'BSB');
define('FS_CHECKOUT_SUCCESS_NEW_ACCOUNT_NO_10', 'Номер аккаунта.');
define('FS_CHECKOUT_SUCCESS_NEW_SWIFT_CODE_11', 'SWIFT Код');
define('FS_CHECKOUT_SUCCESS_NEW_BANK_ADDRESS_12', 'Адрес банка');
define('FS_CHECKOUT_SUCCESS_NEW_13', 'Оставьте свой номер заказа ');
define('FS_CHECKOUT_SUCCESS_NEW_14', ' и адрес электронной почты в банковском переводе.');
define('FS_CHECKOUT_SUCCESS_NEW_DELIVERY_POLICY_15', 'Политика доставки');
define('FS_CHECKOUT_SUCCESS_NEW_16', 'Расчетное время доставки не начинается до тех пор, пока мы не получим ваш платеж.');
define('FS_CHECKOUT_SUCCESS_NEW_17', 'Ваш заказ будет доставлен с 9:00 до 17:00 с понедельника по пятницу (исключая праздничные дни). Кто-то должен будет быть по указанному адресу, чтобы принять и подписать для доставки.');
define('FS_CHECKOUT_SUCCESS_NEW_PRINT_18', 'Распечатать');
define('FS_CHECKOUT_SUCCESS_NEW_DOWNLOAD_19', 'Скачать');
define('FS_CHECKOUT_SUCCESS_NEW_ORDER_DETAILS_20','Информация заказа');
define('FS_CHECKOUT_SUCCESS_NEW_BILLING_ADDRESS_21', 'Платежный адрес');
//账期
define('FS_CHECKOUT_SUCCESS_PURCHASE_THINK_YOU_01', 'Спасибо, ');
define('FS_CHECKOUT_SUCCESS_PURCHASE_YOUR_ORDER_02', 'Ваш заказ ');
define('FS_CHECKOUT_SUCCESS_PURCHASE_05', "Мы начнем обрабатывать заказ, как только получим PO файл. Убедитесь, что все необходимые подписи и информации предоставлены, пожалуйста. Вы также можете загрузить свой PO файл в ");
define('FS_CHECKOUT_SUCCESS_PURCHASE_LATER_06', ' позже.');
define('FS_CHECKOUT_SUCCESS_PURCHASE_ORDER_AMOUNT_07', 'Сумма заказа');
define('FS_CHECKOUT_SUCCESS_PURCHASE_TOTAL_08', 'Всего');
define('FS_CHECKOUT_SUCCESS_PURCHASE_09', 'Расчетное время доставки не начинается до тех пор, пока мы не получим ваш PO файл.');
define('FS_CHECKOUT_SUCCESS_PURCHASE_10', 'Ваш заказ будет доставлен с 9:00 до 17:00 с понедельника по пятницу (исключая праздничные дни). Кто-то должен будет быть по указанному адресу, чтобы принять и подписать для доставки.');
define('FS_CHECKOUT_SUCCESS_PURCHASE_ACCOUNT_CENTER_11', 'разделе Личный кабинет');
define('FS_CHECKOUT_SUCCESS_PURCHASE_12', 'Мы отправили вам по электронной почте детали заказа и подтверждение. Если у вас есть какие-либо вопросы, звоните ');
define('FS_CHECKOUT_SUCCESS_PURCHASE_13', 'Мой аккаунт');
define('FS_CHECKOUT_SUCCESS_PURCHASE_14', 'Узнайте, как FS облегчает ваши покупки в интернете');
define('FS_CHECKOUT_SUCCESS_PURCHASE_15', 'Посмотреть мой заказ');
define('FS_CHECKOUT_SUCCESS_PURCHASE_16', 'Отслеживайте свои товары');
define('FS_CHECKOUT_SUCCESS_PURCHASE_17', 'История заказа');

define('FS_CHECKOUT_SUCCESS_PURCHASE_18', "Оплата");
define('FS_CHECKOUT_SUCCESS_PURCHASE_19', "ru@fs.com");
define('FS_CHECKOUT_SUCCESS_PURCHASE_20', "Предполагаемая дата доставки");
define('FS_CHECKOUT_SUCCESS_PURCHASE_21', ".");
define('FS_CHECKOUT_SUCCESS_PURCHASE_22', "Дата заказа");
define('FS_CHECKOUT_SUCCESS_PURCHASE_23', "Номер заказа");
define('FS_CHECKOUT_SUCCESS_PURCHASE_24', "Информация о заказе");
define('FS_CHECKOUT_SUCCESS_PURCHASE_25', "Печать PI");

// 武汉仓
define('FS_COMMON_WAREHOUSE_CN_CHECKOUT_SUCCESS','Получатель: FS. COM LIMITED<br> 
			Адрес: A115 Jinhetian Business Centre No.329,<br> 
			Longhuan Third Rd<br> 
			Longhua District<br> 
			Shenzhen, 518109, China');

define('FS_COMMON_WAREHOUSE_CN_NEW_CHECKOUT_SUCCESS','FS.COM LIMITED<br> 
			A115 Jinhetian Business Centre <br> 
			No.329, Longhuan Third Rd <br> 
			Longhua District <br>
			Shenzhen, 518109, <br>China');

// 德国仓
define('FS_COMMON_WAREHOUSE_EU_CHECKOUT_SUCCESS','FS.COM GmbH<br> 
			NOVA Gewerbepark, Building 7,<br>
			Am Gfild 7<br>
			85375, Neufahrn bei Munich<br>
			Germany');
define('FS_COMMON_WAREHOUSE_US_CHECKOUT_SUCCESS','FS.COM INC <br>
			380 CENTERPOINT BLVD<br>
			NEW CASTLE, DE 19720<br>
			United States');
// 美东仓
define('FS_COMMON_WAREHOUSE_US_EAST_CHECKOUT_SUCCESS','Получатель: FS.COM Inc.<br>
					Адрес: 380 Centerpoint Blvd,<br>
					New Castle, DE 19720,<br>
					United States');
// 澳洲仓 （澳大利亚）
define('FS_COMMON_WAREHOUSE_AU_CHECKOUT_SUCCESS','FS.COM PTY LTD<br>
				57-59 Edison Road<br>
				Dandenong South<br>
				VIC 3175, Australia');
define('FS_COMMON_WAREHOUSE_SG_CHECKOUT_SUCCESS','FS TECH PTE. LTD<br>
				30A Kallang Place #11-10/11/12<br>
				Singapore 339213<br>
				Singapore');
// 新加坡仓
define('FS_COMMON_WAREHOUSE_DELIVER_TO_SG_CHECKOUT_SUCCESS','Получатель: FS Tech Pte Ltd.<br>
				Адрес: 30A Kallang Place #11-10/11/12<br>
				Singapore 339213<br>
				Singapore');

define('FS_COMMON_FEEDBACK_TIP','Для того, чтобы обеспечить лучший опыт покупок, мы хотели бы получить больше обратной связи от вас. <a href="javascript:;" style="color:#0070BC;" onclick="$(\'.have_feedback\').show()" id="have_checkout_feedback"> Нажмите здесь.</a>');

?>