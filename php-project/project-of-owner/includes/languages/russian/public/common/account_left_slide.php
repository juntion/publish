<?php 
//Content in account left slide
//2016-9-8      add by Frankie 
define('MY_ACCOUNT','Мой Аккаунт');
define('ORDER_CENTER',' Центр Заказа');
define('ALL_ORDER','Все заказы');
define('PENDING_ORDER','Отложенные Заказы');
define('TRANSACTION','Сделанные Заказы');
define('CANCELED_ORDER','Отмененные Заказы');
define('EXCHANGE','Обмен И Возврат Заказов');
define('MY_ADDRESS','Мой Адрес');
define('NEWSLETTER','Новостные рассылки');
define('CHANGE_PASSWORD','Сменить пароль');
define('MY_REVIEWS','Мои Отзывы');
define('MY_QUESTION','Мои Вопросы');
define('MY_SALES_REPRESENTIVE','Мой представитель по продажам');
define('MY_CONTACT','Связаться с');
define('FS_CONTACT_HELP','Чем Вам Помочь?');
define('FS_CONTACT_CHAT','Чат Онлайн Сейчас');
//2017.5.12   add  by ery
define('ACCOUNT_LEFT_EDIT','Редактировать Личный кабинет');
define('ACCOUNT_LEFT_ORDER','Мои заказы');
define('ACCOUNT_LEFT_ADDRESS','Мои адреса доставки');
define('ACCOUNT_LEFT_QUESTION','Вопросы');
define('ACCOUNT_LEFT_MANAGE','Управление подпиской');
define('ACCOUNT_LEFT_QUOTATION','Ценовое Предложение');
define('ACCOUNT_LEFT_QUOTATION_DETAIL','Детали Предложения');
define('FS_CART_ORDER_PRICE','Сумма Заказа');
define('FS_CART_QUOTATION_PRICE','Сумма Предложения');
define('FS_REMOVED_QUOTATION','В случае удаления данного товара из корзины льготная цена доступна только через вход на странице "Ценовое Предложение".');


// 2018.11.29 fairy 个人中心改版
define('FS_MY_ACCOUNT','Личный кабинет');
define('ACCOUNT_SETTING','Редактировать личный кабинет');
define('FS_RETURN_ORDERS','Заказы на Возврат');
define('FS_MY_QUOTES','Запросы на спецпредложения');
define('FS_WISH_LIST','Список Желаний');
define('FS_MY_CASES','Мои вопросы');
define('FS_ADDRESS_BOOK','Адреса Доставки');

//列表页面为空跳转
define('FS_MEMBER_LIST_EMPTY_PAGE_JUMP','<span class="alone_Special">Вернуться на</span> <a href="'.zen_href_link(FILENAME_DEFAULT,'','SSL').'">Главную</a>');

// english.php
define("FS_COMMON_CONTINUE",'Дальше');
define("FS_COMMON_OPERATION",'Операция');
define('FS_COMMON_VIEW','Посмотреть');
define('FS_PURCHASE_ORDER_NUMBER','Номер PO');
define('FS_FILE_UPLOADED_SUCCESS','Успешно Загружен Файл');
define("MANAGE_ORDER_UPLOAD_FORMAT_ERROR","Доступны файлы типа: PDF, JPG, PNG.");
define("MANAGE_ORDER_UPLOAD_ERROR_NEW","Доступны файлы типа: PDF, JPG, PNG. <br/>Максимальный размер файла:4 МБ.");
define("FS_UPLOAD_PO_FILE",'Добавить файл PO');

// 2018.12.7 fairy
define('F_RECEIPT_CONFIRMATION_SUCCESS_TIP','Спасибо за Ваши покупки в FS.COM, ожидаем Вашего следующего посещения.');

// 表单验证
define("ADDRESS_PLACE_HODLER","Улица, c/o");
define("ADDRESS_PLACE_HODLER2","Квартира, дом, этаж и т.д.");
define("FS_ZIP_CODE","Почтовый Индекс");
define("FS_ADDRESS","Адрес, Первая Строка");
define("FS_ADDRESS2","Адрес, Вторая Строка");
define('FS_CHECK_COUNTRY_REGION','Страна/Регион');
define("FS_CHECKOUT_ERROR1","Поле 'Имя' обязательно для заполнения");
define("FS_CHECKOUT_ERROR2","Поле 'Фамилия' обязательно для заполнения");
define("FS_CHECKOUT_ERROR3","Поле 'Адрес, Первая Строка' обязательно для заполнения");
define("FS_CHECKOUT_ERROR4","Поле 'Почтовый Индекс' обязательно для заполнения");
define("FS_CHECKOUT_ERROR5","Поле 'Город' обязательно для заполнения");
define("FS_CHECKOUT_ERROR6","Поле 'Страна' обязательно для заполнения");
define("FS_CHECKOUT_ERROR7","Поле 'Номер Телефона' обязательно для заполнения");
define("FS_CHECKOUT_ERROR8","Поле 'Номер VAT/TAX' обязательно для заполнения");
define("FS_CHECKOUT_ERROR9","Поле 'Штат' обязательно для заполнения.");
define("FS_CHECKOUT_ERROR10","Поле 'Название Компании' обязательно для заполнения.");
define("FS_CHECKOUT_ERROR11","Действительный номер TAX/VAT например:DE123456789");
define("FS_CHECKOUT_ERROR12","Адрес доставки должен быть не менее 4 символов.");
define("FS_CHECKOUT_ERROR13","Ваше имя должно содержать не менее двух символов.");
define("FS_CHECKOUT_ERROR14","Ваша фамилия должна содержать не менее двух символов.");
define("FS_CHECKOUT_ERROR15","Ваш почтовый индекс должен быть не менее 3 символов..");
define("FS_CHECKOUT_ERROR16","Ваш заказ не смогут кинуть в почтовый ящик");
define("FS_CHECKOUT_ERROR17","Поле 'Тип Адреса' обязательно для заполнения.");
define("FS_CHECKOUT_ERROR28","Пожалуйста, введите действительный почтовый индекс");
define("FS_ADDRESS_LINE_TWO_MIN_MAX_TIP","Длина второй строки адреса должна быть от 4 до 35 символов.");
define("FS_CITY_MIN_MAX_TIP","Длина второй строки адреса должна быть от 1 до 50 символов.");

// 订单和退换货公共的导航
define('FS_ORDER_ALL','Все заказы');
define('FS_ORDER_PENDING','В ожидании платежа');
define('FS_ORDER_COMPLETED','Сделанные');
define('FS_ORDER_CANCELLED','Отмененные');
define('FS_ORDER_PURCHASE','Платить');
define('FS_ORDER_PROGRESSING','Обработанные');
define('FS_ORDER_RETURN_ITEM','Возврат Товара');

define('FS_FILE_UPLOADED_SUCCESS_TXT','Файл успешно загружен.');