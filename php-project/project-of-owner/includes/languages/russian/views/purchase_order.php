<?php

define('PURCHASE_TITLE_01', 'Отправить PO');
define('PURCHASE_TITLE_02', 'Сделайте процесс PO эффективным, автоматическим и легко отслеживаемым');

define('PURCHASE_FORM_01', 'Предоставьте следующую информацию, чтобы быстро и легко обработать ваш заказ.');
define('PURCHASE_FORM_02', 'Контактная информация');
define('PURCHASE_FORM_03', 'Имя');
define('PURCHASE_FORM_04', 'Фамилия');
define('PURCHASE_FORM_05', 'Адрес электронной почты');
define('PURCHASE_FORM_06', 'Номер телефона');
define('PURCHASE_FORM_07', 'Информация PO');
define('PURCHASE_FORM_08', 'Номер PO');
define('PURCHASE_FORM_09', 'Номер КП/Pl');
define('PURCHASE_FORM_10', 'Загрузить файлы');
define('PURCHASE_FORM_11', 'Комментарии');
define('PURCHASE_FORM_12', 'Отправить PO');
define('PURCHASE_FORM_13', 'Выберите файл');

define('PURCHASE_FORM_TIP_01', 'Введите ваш номер PO.');
define('PURCHASE_FORM_TIP_02', 'Если вы получили КП от FS ранее, вы можете оставить соответствующую информацию, например, RQC2001020006 / RQ2001300199 / FS20200128000.');
define('PURCHASE_FORM_TIP_03', 'Если вы уже получили КП от FS, вы можете загрузить соответствующие файлы вместе с PO для подтверждения.');
define('PURCHASE_FORM_TIP_04', 'Загрузите соответствующие файлы PO.');
define('PURCHASE_FORM_TIP_05', 'Если у вас есть какие-либо запросы, пожалуйста, оставьте сообщение, такое как номер билета, индивидуальные требования к продукту и т. д.');
define('PURCHASE_FORM_TIP_06', 'Содержание должно быть не более 500 символов.');

define('PURCHASE_FORM_TIP_07', 'Ваш PO был успешно отправлен.');
define('PURCHASE_FORM_TIP_08', 'Мы поможем вам обработать заказ в течение 12-24 часов, а также вы можете проверить статус обновления в разделе <a href="'.zen_href_link('purchase_order_list').'">Отправить/Просмотреть заказ на покупку</a>.');

define('PURCHASE_LIST_01','Отправить новый PO');
define('PURCHASE_LIST_02','ВАШ СПИСОК PO');
define('PURCHASE_LIST_03','PO #');
define('PURCHASE_LIST_04','Дата создания');
define('PURCHASE_LIST_05','Статус');
define('PURCHASE_LIST_06','Заказ #');
define('PURCHASE_LIST_07','Отправлено');
define('PURCHASE_LIST_07_TIP','Ниже представлена информация о PO, которую вы отправили, мы ответим вам в течение 12-24 часов.');
define('PURCHASE_LIST_08','Одобренно');
define('PURCHASE_LIST_08_TIP','Ваш PO был одобрен, и мы сейчас обрабатываем его для создания заказа.');
define('PURCHASE_LIST_09','Заказ создан');
define('PURCHASE_LIST_09_TIP','Ваш заказ был успешно создан, пожалуйста, нажмите кнопку “Платить”, чтобы завершить оплату и просмотреть статус заказа через “FSXXX”.');
define('PURCHASE_LIST_09_TIP1','Ваш PO был успешно создан и сейчас обрабатывается, вы можете просмотреть статус заказа через “FSXXX”.');
define('PURCHASE_LIST_EMPTY_01','НЕТ ИСТОРИИ PO.');
define('PURCHASE_LIST_EMPTY_02','НЕТ PO НАЙДЕН.');
define('PURCHASE_LIST_FORM_01','Убедитесь, что ваш PO включает всю необходимую информацию для более быстрой обработки заказа.');
define('PURCHASE_LIST_FORM_02','Номер PO');
define('PURCHASE_LIST_FORM_03','Напр: RQC2001020006');
define('PURCHASE_LIST_FORM_04','Если у вас есть какие-либо запросы, пожалуйста, оставьте сообщение, такое как номер билета, индивидуальные требования к продукту и т. д. ');

define('PURCHASE_PO_DETAILS','Детали PO');
define('PURCHASE_PO_DETAILS_DATE','Дата запроса на PO:');
define('PURCHASE_PO_DETAILS_QT','КП #:');
define('PURCHASE_PO_DETAILS_REQUEST','Запрос на PO');
define('PURCHASE_PO_DETAILS_FILES','Файлы:');

//邮件
define('PURCHASE_EMAIL_REVIEWING','PO на рассмотрении');
define('PURCHASE_EMAIL_TITLE','FS - Ваш PO #POXXX находится на рассмотрении');
define('PURCHASE_EMAIL_CONTENT_01','Мы получили ваш PO #POXXX, наша команда проверит и обработает его в течение 12-24 часов.');
define('PURCHASE_EMAIL_CONTENT_02','Вы можете войти в личный кабинет и перейти на страницу <a href="'.zen_href_link('purchase_order_list').'" target="_blank" style="color: #0070bc;text-decoration: none;">Разместить/Просмотреть заказ PO</a>, чтобы отслеживать процесс.');

define('PURCHASE_PROCESS_TIP','Войти или зарегистрироваться, чтобы отправить PO файл и отслеживать статус онлайн во времени.');
define('PURCHASE_PROCESS_TITLE','Какая процедура сделать PO заказ?');
define('PURCHASE_PROCESS_01','Задать PO запрос');
define('PURCHASE_PROCESS_01_TIP','Отправьте PO файл заказа.');
define('PURCHASE_PROCESS_02','PO Обработанный');
define('PURCHASE_PROCESS_02_TIP','После утверждения заказа на поставку FS создаст для вас онлайн-заказ.');
define('PURCHASE_PROCESS_03','Оплата заказа и доставка');
define('PURCHASE_PROCESS_04','После создания ожидающего заказа завершите онлайн-платеж для дальнейшей обработки и доставки. Для клиентов с кредитным счетом ваш заказ будет обработан сразу после его утверждения, и кредитный заказ будет отправлен первым, а оплата получена позже.');
define('PURCHASE_PROCESS_05','Чтобы узнать больше об отслеживании статуса заказа, вы можете просмотреть “<a href="'.zen_href_link('manage_orders').'" class="alone_a">историю заказов</a>”.');