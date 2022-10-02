<?php
// 公共的语言包都放到这里

// classic/order.info.php
//Content in My_dashboard
//2016-9-6 add by frankie
define('FIBERSTORE_ORDER_STATUS','Статус Заказа');
define('FIBERSTORE_VIEW_DETAILS','Смотреть Подробности');
define('FIBERSTORE_ORDER_NUMBER','Номер Заказа');
define('FIBERSTORE_ORDER_CUSTOMER_NAME','Имя Клиента');
define('FIBERSTORE_ORDER_TOTAL','Общая сумма');
define('FIBERSTORE_ORDER_PAYMENT','Оплата');
define('FIBERSTORE_DASHBOARD_NO_ORDER','У Вас нет заказов.');


// classic/show_dialog.php
//2017.5.26		ADD		ERY
define('FS_DIALOG_ASK','Задать ');
define('FS_DIALOG_A',' вопрос');
define('FS_DIALOG_TITLE','Заголовок');
define('FS_DIALOG_YOUR','Тема вашего вопроса требуется');
define('FS_DIALOG_CONTENT','Содержание');
define('FS_DIALOG_PLEASE','Пожалуйста, введите ваши вопросы');
define('FS_DIALOG_YOUR2','Ваше содержание требуется');
define('FS_DIALOG_PLEASE1',"Не более 3,000 символов.");



// common/account_left_slide.php
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
define('FS_MY_QUOTES','Запросить цену');
define('FS_WISH_LIST','Список Желаний');
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
define('F_RECEIPT_CONFIRMATION_SUCCESS_TIP','Спасибо за Ваши покупки в FS, ожидаем Вашего следующего посещения.');

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
define('FS_ORDER_PENDING','К оплате');
define('FS_ORDER_COMPLETED','Сделанные');
define('FS_ORDER_CANCELLED','Отменено');
define('FS_ORDER_PURCHASE','Кредитный заказ');
define('FS_ORDER_PROGRESSING','Обработанные');
define('FS_ORDER_RETURN_ITEM','Возврат товара');

define('FS_FILE_UPLOADED_SUCCESS_TXT','Файл успешно загружен.');



// common_service.php
define('COMMON_SERVICE_01','Свяжитесь с нами');
define('COMMON_SERVICE_02','FS фокусируется на решение ЦОД, корпоративных сетей и OTN, чтобы помочь вам построить именно то, что вам нужно. <br> Свяжитесь с нами, мы же готовы помочь вам. ');
define('COMMON_SERVICE_03','Выберите наиболее удобный способ и свяжитесь с нами');
define('COMMON_SERVICE_04','Онлайн-чат');
define('COMMON_SERVICE_05','Напишите нам, и мы сразу ответим на все интересующие Вас вопросы. Наш центр поддержки клиентов работает 24/7.');
define('COMMON_SERVICE_06','Написать в Онлайн-чат');
define('COMMON_SERVICE_07','Заказать обратный звонок');
define('COMMON_SERVICE_08','Позвоните нам по телефону: ');
define('COMMON_SERVICE_09',' или закажите обратный звонок.');
define('COMMON_SERVICE_10','Заказать обратный звонок');
define('COMMON_SERVICE_11','Электронная Почта');
define('COMMON_SERVICE_12','Отправьте нам свой вопрос по электронной почте. Мы ответим Вам в самое ближайшее время.');
define('COMMON_SERVICE_13','Отправить e-mail');
define('COMMON_SERVICE_14','Техническая поддержка');
define('COMMON_SERVICE_15','Получить бесплатную поддержку & решение для своего проекта онлайн.');
define('COMMON_SERVICE_16','Получить техподдержку');
define('COMMON_SERVICE_17','Команда профессионалов');
define('COMMON_SERVICE_18','FS уважает и ценит своих сотрудников, по-настоящему увлеченных тем, что они делают. Мы ценим их инициативность и с радостью готовы выслушать');
define('COMMON_SERVICE_19','новые идеи и предложения по улучшению работы нашей компании. Именно благодаря открытому диалогу и дружеской атмосфере в команде, FS предоставляет высокое качество обсуживания нашим клиентам по всему миру.');
define('COMMON_SERVICE_20','Начать');
define('FS_SHOP_CART_ALERT_JS_13',' От*');
define('FS_SHOP_CART_ALERT_JS_14','До*');
define('FS_SHOP_CART_ALERT_JS_15','Личное Сообщение (необязательно):');
//quote
define('FS_VIEW_QUOTE_SHEET','Просмотреть спецпредложение');
define('FS_PRODUCT_HAS_BEEN_ADDED','Продукт был добавлен.');
define('FS_SAVE_CSRT_LIMIT_TIP','Пожалуйста, введите название корзины, размером не более 30 слов.');
define('FS_QUOTE','Предложение');
define('FS_SAVED_CART_EMAIL','Электронная почта');



// common/footer.php文件
/*底部共用文件*/
// fallwind	2016.8.24	add
// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 整理
// footer computer
define('FS_FOOTER_ABOUT_FS','О нас');
define('FS_ABOUT_FS_COM','О нас');
define('FS_FOOTER_WHY_US','Почему выбирают нас');
define('LATEST_NEWS','Новости');
define('FS_FOOTER_LATEST','Новости');
define('FS_FOOTER_CONTACT_US','Контакты');
// Frankie 2018.1.22
define('FS_IMPRINT','Юридическое уведомление');

// footer Customer Service
define('FS_FOOTER_CUSTOMER_SERVICE','Наш Сервис');
define('FS_FOOTER_OEM','OEM услуги');
define('FS_ABOUT_US','О нас');
//fallwind	2017.5.10	tpl_footer.php
define('FS_OEM_AMP_CUSTOM','OEM услуги');
define('FS_FOOTER_WARRANTY','Гарантия');
define('FS_FOOTER_POLICY','Политика возврата и замены товара');
define('FS_RETURN_POLICY','Возврат');
define('FS_FOOTER_QUALITY','Сертификаты');
define('FS_FOOTER_PARTNER','Бизнес аккаунт');

// footer Payment & Shipping
define('FS_FOOTER_PAY_SHIP','Оплата и Доставка');
define('FS_PAYMENT_METHODS','Оплата');	//Payment Methods
define('FS_NET_AMP_W',"PO");
define('FS_FOOTER_DELIVERY','Доставка');

// footer Quick Help
define('FS_FOOTER_QUICK_HELP','Оперативная Помощь');
define('FS_FOOTER_PURCHASE_HELP','Как сделать заказ');
define('FS_FORGOT_YOUR_PASSWORD','Забыли пароль?');
define('FS_FOOTER_FAQ','ЧАВО');
define('FS_TRACK_YOUR_PACKAGE','Отслеживание посылок');
define("FS_HLEP_CENTER","FS Поддержка");
define("FS_DAY_RETURN_POLICY","Возврат");

// footer Questions? Aron 2017.8.6
define("FS_YAO1","Есть вопрос? Свяжитесь с нами");
define("FS_YAO2","Мы представляем помощь 24/7");
define("FS_YAO3","Чат Сейчас");
define("FS_YAO4","Чат c представителем онлайн");

// Popular
define('FS_FOOTER_POPULAR_PAGES','Popular Pages:');    //小语种没有这个

// 手机站切换版本
define('FS_FULL_SITE','Email');
define('FS_MOBILE_SITE','мобильный сайт');
define('FS_FOOTER_LIVE_CHAT','Чат Сейчас');

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 新版 新增
define("FS_HIGH_QUALITY","Высокое качество");
define("FS_SAFE_SHOPPING","Надежная покупка");
define("FS_FAST_DELIVERY","Гарантия возврата RETURN_DAYS дней");

// 版权相关
define('FS_PRIVACY_AND_POLICY',"Конфиденциальность и Cookies");
define('FS_TERMS_OF_USE',"Условия использования");
define('FS_TERMS_OF_USE_DE',"Правила пользования");
define('FS_SITE_MAP','Карта сайта');
define('FS_FOOTER_FEEDBACK','Оставить отзыв');

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 新版 新增
define("FS_FOOTER_COPYRIGHT","Copyright © 2009-YEAR ".FS_LOCAL_COMPANY_NAME." Все права защищены.");
define("FS_FOOTER_COPYRIGHT_M","Copyright © 2009-YEAR <span>".FS_LOCAL_COMPANY_NAME."</span> Все права защищены.");
define("FS_COPYRIGHT","Copyright © 2009-");
define("FS_ALL_RIGHTS_RESERVED"," FS.COM Все Права Защищены");
define('FS_FOOTER_REQUEST_A_SAMPLE','Получить товар на тестирование');



// common/footer_keyword_tags.php文件
define('FS_FOOTER_EASTERN_SIDE','Eastern Side, Second Floor, Science & Technology Park, No.6, Keyuan Road');
define('FS_FOOTER_NANSHAN','Nanshan District');
define('FS_FOOTER_SHENZHEN','Shenzhen');
define('FS_FOOTER_FS','FS.COM');
define('FS_FOOTER_ALL_RIGHTS','Все права защищены');
define('FS_FOOTER_PRIVACY','Конфиденциальность');
define('FS_FOOTER_TERMS','Условия использования');
define('FS_FOOTER_MOBILE_SITE','Mobile Site');




// common/header.php文件
/* tpl_header.php */
// Make by Frankie  2016-8-19
// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 整理

// 配置文件 start
define('FS_SITE_UNIQUE_LANGUAGE_ID','4');
// 配置文件 end

// 在线聊天html代码 - 旧，现在可能不用了
define('FS_CHAT_NOW','Онлайн чат');
define('FS_ONLINE_CAHT','Онлайн чат');
define('FS_LIVE_CAHT','Чат Сейчас');
define('FS_PRE_SALE','Предпродажное Обслуживание');
define('FS_CHAT_WITH','Чат через онлайн-продаж для получения дополнительной информации перед покупкой!');
define('FS_STAR','Давайте начнем чат');
define('FS_AFTER_SALE','Послепродажное Обслуживание');
define('FS_PL_GO','Если вы уже сделали покупки, перейдите на страницу ');
define('FS_MY_ORDER','Мой Заказ');
define('FS_PAGE_TO',' узнать конкретнные детали заказа, пожалуйста.');

//by add helun 2018 5 28 手机版 Hot Search
define('FS_HEADER_SEARCH','Найти');
define('FS_HEADER_01','Поиск...');
define('FS_HEADER_02','Популярные запросы');
define('FS_HEADER_03','Cisco 40G QSFP+');
define('FS_HEADER_04','100G QSFP28');
define('FS_HEADER_05','10G SFP+ DAC');
define('FS_HEADER_06','DWDM SFP+');
define('FS_HEADER_07','CWDM DWDM MUX');
define('FS_HEADER_08','MTP MPO патч-корды');
define('FS_HEADER_09','LC патч-корды');
define('FS_HEADER_10','Аттенюаторы');
define('FS_HEADER_11','История');
define('FS_HEADER_12','Очистить историю');

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 新版
// top
define('FS_HELP_SUPPORT', 'Помощь и поддержка');
define('FS_CALL_US', 'Позвоните нам');
define('FS_SAVED_CARTS', 'Сохраненные корзины');
// 用户相关
define('FS_ACCOUNT', 'Личный кабинет');
define('FS_NEW_CUSTOMER','Новый покупатель?');
define('FS_REGISTER_ACCOUNT','Регистрация');
define('FS_SIGN_OUT','Выйти');
define('FS_MY_ACCOUNT','Мой личный кабинет');
define('FS_MY_ORDERS','Мои заказы');
define('FS_MY_ORDER','Мой заказ');
define('FS_MY_ADDRESS','Мой адрес');
define('FS_SOLUTIONS','Решения');
define('FS_ALL_CATEGORIES','Каталог');
define('FS_PROJECT_INQUIRY','Запрос о проекте');
define('FS_SEE_ALL_OFFERINGS','Просмотреть все товары');
define('FS_RESOURCES','Библиотека');
define('FS_RELATED_INFO','Дополнительная информация');
define('FS_CONTACT_US','Контакты');
// 国家选择
define('FS_PRODUCTS_DIFFERENT','Продукты могут иметь разные цены и доступность на основе страны/региона.');
define('FS_NEW_LANGUAGE_CURRENCY','Язык/Валюта');
define('FS_COUNTRY_REGION','Страна/Регион');

//用户相关，新改版 2019/3/29 rebirth.ma
define('FS_MAIN_MENU','Главное Меню');
define('FS_NETWORKING','Корпоративные Сети');
define('FS_ORDER_HISTORY','История заказов');
define('FS_ADDRESS_BOOK','Список Адресы');
define('FS_MY_CASES','Центр вопроса');
define('FS_MY_QUOTES','Мои КП');
define('FS_ACCOUNT_SETTING','Настройки аккаунта');
define('FS_VIEW_ALL','Смотреть все');

// 搜索
define('FS_SEARCH_PRODUCTS','Поиск продукта');
define('FS_NEW_CHOOESE_CURRENCY','Выберите Валюту');
// 2018.7.23 fairy help
define('FS_NEED_HELP_BIG','Нужна помощь?');
define('FS_CHAT_LIVE_WITH_US','Чат онлайн');
define('FS_SEND_US_A_MESSAGE','Напишите нам');
define('FS_E_MAIL_NOW','Email');
define("FS_LIVE_CHAT","Чат сейчас");
define("FS_WANT_TO_CALL","Позвоните нам?");
define("FS_BREADCRUMB_HOME","Главная");
/*2018-9-22.顶部增加一个版块*/
define('FS_CHAT_LIVE_WITH_GET','Техническая поддержка');
define('FS_CHAT_LIVE_WITH_GET_A','Получить консультанцию');

// 2018.10.6  ery  头部左上角免运费政策弹窗
define('HEADER_FREE_SHIPPINH_01','Быстрая доставка & Легкий возврат');
define('HEADER_FREE_SHIPPINH_02','Бесплатная доставка от %s');//%s不用翻译替换的是价格,如US $79
define('HEADER_FREE_SHIPPINH_03','и разные способы доставки в соответствии с вашим графиком и бюджетом.');
define('HEADER_FREE_SHIPPINH_04','Отправка в тот же день');
define('HEADER_FREE_SHIPPINH_05','благодаря большим запасам на глобальных складах.');
define('HEADER_FREE_SHIPPINH_06','Гарантия возврата 30 дней');
define('HEADER_FREE_SHIPPINH_07','для большиства заказов.');
define('HEADER_FREE_SHIPPINH_08','Любой продукт с наклейкой Бесплатная Доставка на странице продукта может быть доставлен бесплатно. FS.COM оставляет за собой право в любое время изменить это предложение. Для получения дополнительной информации нажмите <a href="'.zen_href_link('shipping_delivery').'">Политику доставки</a> или <a href="'.zen_href_link('day_return_policy').'">Политику возврата</a>.');
define('HEADER_FREE_SHIPPINH_09','Доставка за пределы вашей страны? Перейдите в страну назначения на веб-сайте, чтобы проверить правильность политики.');
define('HEADER_FREE_SHIPPINH_10','Быстрая доставка & Легкий возврат');
define('HEADER_FREE_SHIPPINH_11','Бесплатная доставка от %s');//%s不用翻译替换的是价格,如79€
define('HEADER_FREE_SHIPPINH_12','и разные способы доставки в соответствии с вашим графиком и бюджетом.');
define('HEADER_FREE_SHIPPINH_13','Отправка в тот же день');
define('HEADER_FREE_SHIPPINH_14','Любой продукт с наклейкой Бесплатная Доставка на странице продукта может быть доставлен бесплатно. FS.COM оставляет за собой право в любое время изменить это предложение. Для получения дополнительной информации нажмите <a href="'.zen_href_link('shipping_delivery').'">Политику доставки</a> или <a href="'.zen_href_link('day_return_policy').'">Политику возврата</a>.');
define('HEADER_FREE_SHIPPINH_15','Доставка за пределы вашей страны? Перейдите в страну назначения на веб-сайте, чтобы проверить правильность политики.');
define('HEADER_FREE_SHIPPINH_16','Более 310000 товаров в наличии');
define('HEADER_FREE_SHIPPINH_17','для поддержки ваших потребностей.');
define('HEADER_FREE_SHIPPINH_18','На время доставки могут влиять запасы. Для получения дополнительной информации нажмите <a href="'.zen_href_link('shipping_delivery').'">Политику доставки</a> или <a href="'.zen_href_link('day_return_policy').'">Политику возврата</a>.');
define('HEADER_FREE_SHIPPINH_19','Shipping time may be influenced by inventories. Read more on <a href="'.zen_href_link('shipping_delivery').'">delivery policy</a> or <a href="'.zen_href_link('day_return_policy').'">return policy</a>.');

//手机端侧边栏政策页
define('FS_PH_HELP_SETTING','Помощь & Настройка');

// 浏览器
define('FS_UPGRADE','ОБНОВИТЕ СВОЙ БРАУЗЕР');
define('FS_UPGRADE_TIP','Вы используете устаревший браузер. Пожалуйста, обновите свой браузер для лучшего опыта.');
define('BROWSER_CHROME','Chrome');
define('BROWSER_FIREFOX','Firefox');
define('BROWSER_IE','Internet Explorer');
define('BROWSER_EDGE','Edge');
define('FS_SHIPPING_DELIVERY_RU',' Бесплатная доставка от 20 000 ₽');

define('FS_TAGIMG_TITLE','Изучение решения');
define('FS_INDEX_CATE_PRODUCTS','Товары');




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
define('FS_PHONE_SG','+(65) 3163 0003');		// Singapore
define('FS_PHONE_TW','+886 (2) 5592 4011');		// Taiwan
define('FS_PHONE_IT','+44 (0) 121 716 1755');	// Italy
define('FS_PHONE_CH','+41 (43) 508 5909');		// Switzerland
define('FS_PHONE_DK','+45 7876 8321');			// Denmark
define('FS_PHONE_NZ','+64 (9) 985 3566');		// New Zealand
define('FS_PHONE_WH','+(852) 8176 3606');       //wuhan
define('FS_PHONE_JP','+81 345888332');			//japan

define('FS_PHONE_MY_DASHBOARD','+7 (499) 643 4876');


define('FS_PHONE_SITE_EU','+49 (0) 8165 80 90 517');
define('FS_PHONE_SITE_UK','+44 (0) 121 716 1755');
define('FS_PHONE_SITE_ES','+34 (91) 123 7299');
define('FS_PHONE_SITE_FR','+33 (1) 82 884 336');
define('FS_PHONE_SITE_RU','+7 (499) 643 4876');
define('FS_PHONE_SITE_MX','+52 (55) 3098 7566');
define('FS_PHONE_SITE_AU','+61 3 9693 3488');
define('FS_PHONE_SITE_JP','+1 (877) 205 5306');
define('FS_PHONE_SITE_SG','+(65) 3163 0003');
if(US_WAREHOUSE_UP){
    define('FS_PHONE_US','+1 (888) 468 7419');		// United States
    define('FS_PHONE_SITE_US','+1 (888) 468 7419');
    define('FS_PHONE_CHECKOUT_US','+1 (888) 468 7419');
}else{
    define('FS_PHONE_US','+1 (877) 205 5306');		// United States
    define('FS_PHONE_SITE_US','+1 (877) 205 5306 (PST) <br/> +1 (888) 468 7419 (EST)');
    define('FS_PHONE_CHECKOUT_US','+1 (877) 205 5306 (PST) / +1 (888) 468 7419 (EST)');
}
if($_SESSION['languages_code']=='sg'){
    define('FS_COMMON_PHONE','+(65) 6443 7951');
}else{
    define('FS_COMMON_PHONE','+7 (499) 643 4876');
}



// common/resources.php
//catalog
define('PRODCUT_CATALOGS_01','Каталог Товаров');
define('PRODCUT_CATALOGS_02','База Знаний');
define('PRODCUT_CATALOGS_03','Решения');
define('TUTORIAL_ALL','Всё');
define('TUTORIAL_ALL_ATGS','Всё Теги');
define('FS_LOAD_MORE','Больше');
define('FS_SUPPORT_CASE','Практические Примеры');

//support
define('SUPPORT_SEC_01','Решение для Межсоединения');
define('SUPPORT_SEC_02','Решение для Прокладки');
define('SUPPORT_SEC_03','Решение для Предприятий');
define('SUPPORT_SEC_04','Решение для WDM');
define('SUPPORT_SEC_05','Решение для FTTX');


//knowledge
define('KNOWLEDGE_01','fiber optics1');
define('KNOWLEDGE_02','Knowledge base to help IT pros get started and shape the future of business');
define('KNOWLEDGE_03','RELATED');
define('KNOWLEDGE_04','Share on');
define('KNOWLEDGE_05','Related Blog Posts');
define('KNOWLEDGE_06','TOPICS');

define('PRODCUT_CATALOGS_04','Видео о Продукте');
define('PRODCUT_CATALOGS_05','Все');
define('PRODCUT_CATALOGS_06','Сеть');
define('PRODCUT_CATALOGS_07','Прокладка Кабелей');
define('PRODCUT_CATALOGS_08','WDM & FTTx');
define('PRODCUT_CATALOGS_09','Корпоративная Cеть');
define('PRODCUT_CATALOGS_10','Тест & Инструмент');




// common/tpl_left_side_bar_for_categories_narrow_by.php
/*content*/
//fallwind	2016.8.22	add
define('CLEAR_SELECTIONS','Удалить Выбор');




// functions/functions_shipping.php
define('FS_SHIP_IN_PERSON','Самовывоз ');



// functions/product_instock.php
define('FS_SHIP_PC',' шт');
define('FS_SHIP_PCS',' шт');
define('FS_SHIP_AVAI','Доступны');
define('FS_SHIP_STOCK',' в наличии');
define('FS_SHIP_DEVE','Развитие');
define('FS_SHIP_ESTIMATED','Отправка ');
define('FS_SHIP_INVENTORY','Отправка будет ');
define('FS_SHIP_ROLL',' Рул.');
define('FS_SHIP_ROLLS',' Рул.');
define('FS_SHIP_ROLL_1KM',' (1Рулон = 1KM)');
define('FS_SHIP_ROLL_2KM',' (1Рулона = 2KM)');
define('FS_SHIP_PLACE',' Заказы, сделанные сегодня, будут отправлены за ');
define('FS_SHIP_DAYS',' рабочих дня');
define('FS_SHIP_DAYS1','рабочих дней');
//左上角  俄罗斯国家展示邮箱
define('FS_HEADER_EMAIL','<span>Напишите нам:  <a href="mailto:ru@fs.com">ru@fs.com</a></span>');


define("CREDIT_HOLDER_NAME_ERROR1","Вводите имя владельца  карты, пожалуйста.");
define("CREDIT_HOLDER_NAME_ERROR2","Неправильно вводите имя владельца карты, попробуйте ещё раз.");
define("CREDIT_CARD_NUMBER_ERROR1","Вводите номер карты, пожалуйста.");
define("CREDIT_CARD_NUMBER_ERROR2","Номера карты не существует. Введите правильный номер.");
define("CREDIT_CARD_DATE_ERROR1","Вводите срок действия карты, пожалуйста.");
define("CREDIT_CARD_DATE_ERROR2","Неправильно вводите срок действия карты, попробуйте ещё раз.");
define("CREDIT_CARD_CODE_ERROR1","Вводите код безопасности, пожалуйста.");
define("CREDIT_CARD_CODE_ERROR2","Неправильно вводите код безопасности, попробуйте ещё раз.");
//Jeremy 2019.07.18 新版一级分类页底部
define('NEW_PATCH_PANEL_01', 'Тест производительности');
define('NEW_PATCH_PANEL_02', 'Все Ethernet кабели прошли тест Fluke Channel.');
define('NEW_PATCH_PANEL_03', 'Гарантия качества');
define('NEW_PATCH_PANEL_04', 'Сертификация качества CE, RoHS, ISO9001 гарантирована.');
define('NEW_PATCH_PANEL_05', 'Большой запас');
define('NEW_PATCH_PANEL_06', 'Полный запас товаров для отправки в тот же день.');
define('NEW_PATCH_PANEL_07', 'Экономическая сделка');
define('NEW_PATCH_PANEL_08', 'Оптовая цена кабелей помогает Вам сэкономить бюджет проекта.');

define('NEW_PATCH_PANEL_01_209', 'Строгая программа испытаний');
define('NEW_PATCH_PANEL_02_209', 'Инспекция торца и потери IL и потери RL.');

define('NEW_PATCH_PANEL_01_1', 'Большая гибкость');
define('NEW_PATCH_PANEL_02_1', 'Поддержка нескольких интерфейсов для удовлетворения различных потребностей бизнес-приложений.');
define('NEW_PATCH_PANEL_04_1', 'Все товары прошли строгие тесты.');

define('NEW_PATCH_PANEL_01_911', 'Быстрая доставка');
define('NEW_PATCH_PANEL_02_911', 'Местные склады, охватывающие мировые рынки, экономят Ваше драгоценное время.');

define('NEW_PATCH_PANEL_01_9', 'Широкая совместимость');
define('NEW_PATCH_PANEL_02_9', 'Совместимы со всеми основными поставщиками и системами.');
define('NEW_PATCH_PANEL_04_9', 'Сертификация качества CE, RoHS, IEC, FCC, ISO9001 и FDA гарантирована.');

define('NEW_PATCH_PANEL_02_4', 'Все товары прошли тесты и соответствуют стандартным требованиям.');
define('NEW_PATCH_PANEL_08_4', 'Оптовая цена помогает Вам сэкономить бюджет проекта.');


//shopping_cart/save_cart/inquiry的email功能 ery 2019-08-12 add
define('FS_EMIAL_BOTTOM_MSG','<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr><td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 13px;color: #232323;line-height: 20px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
    Вы получили <a style="color: #232323;text-decoration: none;" href="javascript:;"></a> это письмо от <a style="color: #232323;text-decoration: none;" href="'.zen_href_link('index').'">FS.COM</a>.
                             В результате получения этого письма вы не будете получать никаких не желательных сообщений от <a style="color: #232323;text-decoration: none;" href="'.zen_href_link('index').'">FS.COM</a>.
                            Узнайте больше о нашей <a style="color: #232323;text-decoration: none;" href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">Политике конфиденциальности</a>.
                        </td></tr>
                    </tbody>
                </table>');


//邮件
define('SAMPLE_EMAIL_DEAR','Уважаемый/ая');
define('SAMPLE_EMAIL_01', 'Мы получили ваш запрос, и наша команда свяжется с вами в ближайшее время.');
define('SAMPLE_EMAIL_02', 'Здесь Ваш номер запроса <a style="color: #0070bc;text-decoration: none" href="javascript:;">###case_number###</a>. Вы можете ссылаться на этот номер во всех последующих сообщениях, касающихся этого запроса.');
define('SAMPLE_EMAIL_03', 'Контактная информация: ' );
define('SAMPLE_EMAIL_04', 'Эл. адрес: ');
define('SAMPLE_EMAIL_05', 'Страна: ');
define('SAMPLE_EMAIL_06', 'Номер телефона: ');
define('SAMPLE_EMAIL_07', 'Ваши дополнительные комментарии: ' );
define('SAMPLE_EMAIL_08', 'Спасибо');
define('SAMPLE_EMAIL_09', 'Команда FS');
define('SAMPLE_EMAIL_30', 'Вот номер Вашего вопроса <a style="color: #0070bc;text-decoration: none" href="$HREF">###case_number###</a>. Вы можете ссылаться на этот номер во всех последующих сообщениях через <a style="color: #0070bc;text-decoration: none" href="$HREF">онлайн центр вопросы</a> по поводу этого запроса.');

define('FS_CONTACT_GET_SUPPORT','Очень рады ответить на любые ваши вопросы.');
define ('FS_CONTACT_LEAVE', 'Оставьте сообщение');

define ('CUSTOMER_SERVICE_OTHERS_46', 'У вас уже есть аккаунт? <a style="color: #0070bc;" href="'. zen_href_link(FILENAME_LOGIN,'','SSL').'"> Войти</a> или <a style="color: #0070bc;" href="'.zen_href_link(FILENAME_REGIST,'','SSL').'"> Регистрация </a> ');
define('CUSTOMER_SERVICE_OTHERS_47', '<a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">Войти</a> или <a href="'.zen_href_link(FILENAME_REGIST, '', 'SSL').'">Регистрация</a> для получения персонализированных услуг.');
define('CUSTOMER_SERVICE_OTHERS_48', 'Есть аккаунт? <a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">Войти</a> или <a href="'.zen_href_link(FILENAME_REGIST, '', 'SSL').'">Регистрация</a>.');

//服务页面公用
define('FS_SUPPORT_FORM_TXT','Пожалуйста, заполните информацию. Мы свяжемся с вами как можно скорее.');
define('FS_SUPPORT_FORM_PLACEHOLDER','Ваши комментарии помогут FS быстрее отвечать.');
define('FS_PLEASE_ENTER_COMMENTS','Запишите больше комментариев о вашем запросе, пожалуйста.');
define('FS_COMMON_AT_LEAST','Пожалуйста, напишите содержание более 3 символов.');
define('FS_COMMON_AT_MOST','Ваше содержание не может превышать 1000 символов.');
define("FS_SUPPORT_EMAIL","Электронная почта");
define('FS_SUPPORT_PHONE','Телефон');
define('FS_FIRST_NAME_PLEASE','Введите ваше имя.');
define('FS_LAST_NAME_PLEASE','Введите вашу фамилию.');
define('FS_SUPPORT_COMMENTS','Комментарий');
define('FS_SUPPORT_FIRST_NAME','Имя');
define('FS_SUPPORT_LAST_NAME','Фамилия');
define('SOLUTION_PRIVACY_POLICY',' Я согласен с <a href='.reset_url('policies/privacy_policy.html').' target="_blank" style=\'color: #232323\'>политикой конфиденциальности</a> и <a href='.reset_url('policies/terms_of_use.html').' target="_blank" style=\'color: #232323\'> условиями использования FS</a>.');
define ('FS_SUPPORT_EMAIL_TOUCH_SOON', 'Мы получили Ваш запрос на службу поддержки, и наша команда скоро свяжется с Вами.');

//美东电话
define('FS_PHONE_US_EAST','+1 (888) 468 7419');
//武汉仓电话
define('FS_PHONE_CN','+86 (027) 87639823');

//shopping_cart save_items 页面的 meta标签 2019.12.23
define('META_TAGS_SHOPPING_CART_TITLE', 'Kорзина');
define('META_TAGS_SHOPPING_CART_DESCRIPTION', 'Покупайте лучшие продукты для ЦОД, корпоративных сетей и доступа к Интернету. Мы помогаем IT-специалистам легко и экономически эффективно реализовать свое бизнес-решение.');
define('META_TAGS_SAVED_ITEMS_TITLE', 'Cохраненные корзины');
define('META_TAGS_SAVED_ITEMS_DESCRIPTION', 'После добавления товаров в корзину нажмите «Сохранить корзину», чтобы сохранить коллекции товаров. Вы можете создать столько сохраненных корзин, сколько захотите, и использовать сохраненные корзины для повторных заказов.');

//sfp_optical_module 页面的 meta标签 2020.08.05
define('META_TAGS_SFP_TITLE', 'Список запасов 10G CWDM/DWDM SFP+');
define('META_TAGS_SFP_DESCRIPTION', 'Полный ассортимент товаров 10G CWDM/DWDM SFP модулей (DWDM SFP 80 км/40 км, CWDM SFP 80 км/40 км/20 км/10 км) дает краткий обзор инвентаря товаров и предоставляет помощь для решений WDM.');


//专题  walking_through   gr_series_cabinet   sfp_optical_module 语言包
define('FS_SPECIAL_GOALS','Узнайте, как мы достигаем ваших целей');
define('FS_SPECIAL_DESIGN_CENTER','Центр дизайна');
define('FS_SPECIAL_DESIGN_CENTER_DES','Опыт в учете требований и<br/>предоставлении инновационного, экономически эффективного<br/>и надежного универсального решения.');
define('FS_SPECIAL_QUALITY','Центр качества');
define('FS_SPECIAL_QUALITY_DES','Обеспечить товар высокого качества со строгими тестированием<br/>и сертификации отраслевых стандартов.');
define('FS_SPECIAL_TEC','Техническая поддержка');
define('FS_SPECIAL_TEC_SMALL','Запрос на поддержку');
define('FS_SPECIAL_TEC_DES','Получите бесплатную поддержку & дизайн решения для<br/>вашего проекта онлайн.');
define('FS_SUBMIT_SUCCESS','Ваш запрос ##number## был успешно отправлен.');
define('FS_SUBMIT_SUCCESS_TIP_TXT_SAMPLE','Мы ответим вам в течение 1-3 часов по телефону или электронной почте в рабочее время.');

define('SAMPLE_EMAIL_31','Адрес: ');
define('SAMPLE_EMAIL_32','Кол-во: ');
define('SAMPLE_EMAIL_33','Список продуктов');

define ('FS_BROWSING_HISTORY', 'История просмотра');

define ('FS_PRODUCT_DOWNLOAD', 'Загрузки');
define ('FS_PRODUCT_MORE', 'Узнайте больше');
define('FS_PRODUCT_SUPPORT','Поддержка товара');

//结算页、订单确认成功页、银行转账邮件、订单详情
define ("PAYMENT_BANK_ACH", "Банковский/ACH Перевод");
define ("PAYMENT_BANK_ACH_CA", "Банковский Перевод");
define ("PAYMENT_BANK_OF_US", "Банк Америки");
define ("PAYMENT_BANK_VIA", "Банковский перевод");
define ("PAYMENT_BANK_ACCOUNT_NAME", "FS COM INC");
define ("PAYMENT_BANK_WIRE_ROUTING", "Номер Маршрута #:");
define ("PAYMENT_BANK_SWIFT_CODE", "Код SWIFT:");
define ("PAYMENT_BANK_ACH_ROUTING", "Номер ACH:");
define ("PAYMENT_BANK_VIA_ACH", "Через ACH");

define("PAYMENT_BANK_ACCOUNT_NAME_COMMON",'Название Бенефициара:');
define("PAYMENT_BANK_ACCOUNT",'Счет Бенефициара #:');
define("PAYMENT_BANK_ADDRESS",'Адрес Банка:');

// QV弹窗公用语言包
define('FS_COMMON_QTY_SMALL','Кол-во');
define('FS_QV_QUICK_VIEW','Быстрый просмотр');
define('FS_SEE_FULL_DETAILS','Просмотр деталей');
define('FS_CUSTOMIZED','В Корзину');
define('FS_PRODUCTS_INFORMATION','Характеристики продукта');
define('FS_CUSTOMER_ALSO_VIEWED','Клиенты, которые смотрели этот товар, также интересовались');

// fairy 2019.1.15 add 公共标题需要
define('FS_TITLE_COMPATIBLE','Совместимый');

//ery 2020.05.25  buy more 功能相关语言包
define('FS_BUY_MORE_01', 'Купить снова');
define('FS_BUY_MORE_02', 'Товары, приобретенные через "Купить снова", будут точно такими же, как ваш заказ %s.');	//%s会替换成订单号
define('FS_BUY_MORE_03', 'Продукт такой же, как предыдущий заказ %s.');		//%s会替换成订单号

//头部下拉版块
define('FS_HEADER_SUPPORT','Поддержка');
define('FS_HEADER_TEC_SUPPORT','Техподдержка');
define('FS_HEADER_CUSTOMER_SUPPORT','Поддержку для клиентов');
define('FS_HEADER_SERVICE_SUPPORT','Служба поддержки');
define('FS_HEADER_TEC_DES',' Ищите документы, примеры из практики, видео и т. д. В нашей библиотеке ресурсов или запросите техническую поддержку для получения индивидуальных решений.');
define('FS_HEADER_TEC_URL_01','Технические документы');
define('FS_HEADER_TEC_URL_02','Тестовой стенд');
define('FS_HEADER_TEC_URL_03','Загрузка файла');
define('FS_HEADER_TEC_URL_04','Приверженность качеству');
define('FS_HEADER_TEC_URL_05','Практические примеры ');
define('FS_HEADER_TEC_URL_06','Запрос гарантии');
define('FS_HEADER_TEC_URL_07','Видеотека');
define('FS_HEADER_SUPPORT_RIGHT_DES','FS Экспертные услуги');
define('FS_HEADER_SUPPORT_RIGHT_URL','Поддерживать связь');
define('FS_HEADER_CUSTOMER_DES','Получить немедленную помощь до или после покупки: запрос заказа, размещение заказа, отслеживание заказа или другие связанные с этим вопросы.');
define('FS_HEADER_CUSTOMER_URL_01','Запросить КП');
define('FS_HEADER_CUSTOMER_URL_02','Запрос возврата & возмещения');
define('FS_HEADER_CUSTOMER_URL_03','Запрос образца товара');
define('FS_HEADER_CUSTOMER_URL_04','Отсрочка платежа');
define('FS_HEADER_CUSTOMER_URL_05','Отправить PO');
define('FS_HEADER_CUSTOMER_URL_07','Отслеживание товаров');
define('FS_HEADER_CUSTOMER_URL_08','Новинка');
define('FS_HEADER_CUSTOMER_URL_09','Распродажа');
define('FS_HEADER_CUSTOMER_URL_10','Проверка продукта');
define('FS_HEADER_CUSTOMER_URL_11','Запросить демо');
define('FS_HEADER_SERVICE_DES','Изучите популярные темы, такие как учетные записи, доставка, возвраты и т. д. FS стремится предоставить вам самый простой опыт покупки.');
define('FS_HEADER_SHIPPING_DELIVERY','Доставка');
define('FS_HEADER_RETURN_POLICY','Возврат & Обмен товара');
define('FS_HEADER_PAYMENT','Оплата');
define('FS_HEADER_HELP_CENTER','FS Поддержка');
define('FS_HEADER_COMPANY','Компания');
define('FS_HEADER_ABOUT_US','О нас');
define('FS_HEADER_CONTACT_US','Контакты');
define('FS_HEADER_NEWS','Партнеры');
define('FS_HEADER_ABOUT_DES','FS является ведущим мировым поставщиком коммуникационного оборудования и проектных решений. Мы стремимся помочь вам построить, подключить, защитить и оптимизировать вашу оптическую инфраструктуру.');
define('FS_HEADER_ABOUT_EXPLORE','Исследовать FS');
define('FS_HEADER_CONTACT_DES','Мы всегда рады Вам помочь. Добро пожаловать связаться к нам в любое время для получения быстрой и лучшей технической поддержки & обслуживания клиентов.');
define('FS_HEADER_LEARN_MORE','Подробнее');

//以下部分 因分仓、站点各异
define('FS_HEADER_NEWS_READ_MORE','<a class="home_solution_sub_level_right_dd_a" href="'.reset_url('company/fiberstore_with_partners.html').'"><span>Познакомьтесь с нашими партнерами</span><i class="iconfont icon">&#xf089;</i></a>');
define('FS_HEADER_NEWS_DES','<dd>FS предлагает заказные и экономически эффективные сетевые решения для вашего бизнеса. Нашим товарам и услугам доверяют некоторые из самых влиятельных компаний в мире. </dd>');
define('FS_HEADER_NEWS_RIGHT_DES','FS Achieves a Series of Authoritative International Certification');
define('FS_HEADER_NEWS_RIGHT_DATE','June 8, 2020');

define('FS_CUSTOMER_SUPPORT_TIP','Этот товар#XXX является заказным товаром, за подробностями обратитесь к менеджеру своего аккаунта.');
// 武汉仓
define('FS_RMA_WAREHOUSE_CN','<dt>Получатель: FS. COM LIMITED </dt>
			<dd>Адрес: A115 Jinhetian Business Centre No.329, Longhuan Third Rd Longhua District Shenzhen, 518109, China</dd>
			<dd>Тел.: +86-0755-83571351</dd>');

// 德国仓
define('FS_RMA_WAREHOUSE_EU','<dt>FS.COM GmbH </dt>
			<dd>NOVA Gewerbepark, Building 7, Am Gfild 7 85375, Neufahrn bei Munich Germany</dd>
			<dd>Тел: +49 (0) 8165 80 90 517</dd>');

define('FS_RMA_WAREHOUSE_US','<dt>FS.COM INC </dt>
			<dd>380 CENTERPOINT BLVD, NEW CASTLE, DE 19720, United States</dd>
	
			<dd>Тел: +1 (888) 468 7419</dd>');
// 美东仓
define('FS_RMA_WAREHOUSE_US_EAST','<dt>Получатель: FS.COM Inc.</dt>
					<dd>Адрес: 380 Centerpoint Blvd, New Castle, DE 19720, United States</dd>
		
					<dd>Тел.: +1 (888) 468 7419</dd>');
// 澳洲仓 （澳大利亚）
define('FS_RMA_WAREHOUSE_AU','<dt>FS.COM PTY LTD</dt>
				<dd>57-59 Edison Road, Dandenong South, VIC 3175, Australia</dd>
				<dd>Тел: +61 3 9693 3488</dd>
				<dd>ABN: 71 620 545 502</dd>');

// 新加坡仓
define('FS_RMA_WAREHOUSE_SG','<dt>Получатель: FS Tech Pte Ltd.</dt>
				<dd>Адрес: 30A Kallang Place #11-10/11/12, Singapore 339213</dd>
				<dd>Тел.: +(65) 6443 7951</dd>');

define('FS_RMA_WAREHOUSE_RU','<dt>ООО «ФС.КОМ» </dt>
             <dd>4062-й, дом 6, строение 16, Проезд Проектируемый 115432, город Москва, Российская Федерация
             </dd>
             <dd>Тел: +7 (499) 643 4876</dd>');

//TW账户中心改版
define('FS_ACCOUNT_TW_QUOTE','Запрос КП');
define('FS_ACCOUNT_TW_CREDIT','Кредитный аккуант');
define('FS_ACCOUNT_TW_CREDIT_DETAILS','Кредитный информации');
define('FS_ACCOUNT_TW_USER',' Информация пользователя');
define('FS_ACCOUNT_TW_SUPPORT','Центр вопроса');
define('FS_ACCOUNT_TW_TAX','Tax Exempt Apply');
define('FS_ACCOUNT_TW_USEFUL','Инструмент');
define('FS_ACCOUNT_TW_ACCOUNT','Администратор аккаунта');
define('FS_ACCOUNT_TW_YOU','У вас есть неоплаченный заказ.');
define('FS_ACCOUNT_TW_ORDERS','Заказы');
define('FS_ACCOUNT_TW_MOST_ORDER','Самый последний заказ');
define('FS_ACCOUNT_TW_VIEW_ORDERS','Просмотреть все заказы');
define('FS_ACCOUNT_TW_ORDERS_SEARCH','Заказ #, PO #, ID товара #, P/N, Отзыв...');
define('FS_ACCOUNT_TW_PENDING_PAYMENT','К оплате');
define('FS_ACCOUNT_TW_WAIT','Передается в доставку');
define('FS_ACCOUNT_TW_TRANSIT','В пути');
define('FS_ACCOUNT_TW_DELIVERED','Доставлен');
define('FS_ACCOUNT_TW_PENDING_REVIEW','Отзывы о заказе');
define('FS_ACCOUNT_TW_NO_ORDER','Заказы не найдены.');
define('FS_ACCOUNT_TW_VIEW_CART','Просмотреть корзину');
define('FS_ACCOUNT_TW_VIEW_TICKETS','Посмотреть все вопросы');
define('FS_ACCOUNT_TW_CREATE_TICKET','Задать новый вопрос');
define('FS_ACCOUNT_TW_SEARCH_TICKET','Bопрос #, Содержание…');
define('FS_ACCOUNT_TW_TICKET','Bопрос #');
define('FS_ACCOUNT_TW_TICKET_TYPE','Виды поддержки');
define('FS_ACCOUNT_TW_TICKET_COMMENT','Содержание');
define('FS_ACCOUNT_TW_TICKET_DATE','Дата создания');
define('FS_ACCOUNT_TW_TICKET_STATUS','Статус');
define('FS_ACCOUNT_TW_TICKET_ACTION','Действия');
define('FS_ACCOUNT_TW_NO_TICKET','Нет истории вопроса.');
define('FS_ACCOUNT_TW_ORDER','Заказ #');
define('FS_ACCOUNT_TW_SPLIT_ORDER','Разделить заказ');
define('FS_ACCOUNT_TW_DELIVERY','Доставка');
define('FS_ACCOUNT_TW_DELIVERY_ON','Доставлено ');
define('FS_ACCOUNT_TW_THE','По следующим причинам, следующие товары нельзя повторно заказать повторно. Нажимать кнопку Пропустить и Продолжить, чтобы снова добавить оставшиеся товары в корзину.');
define('FS_ACCOUNT_TW_THE_NO','По следующим причинам, следующие товары нельзя повторно заказать повторно.');
define('FS_ACCOUNT_TW_ITEMS','Товары, приобретенные через Купить Снова, будут точно такими же, как ваш заказ #%s.');
define('FS_ACCOUNT_TW_YOU_CAN','Вы можете использовать эту кнопку, чтобы снова поместить все товары в этом заказе в корзину.');
define('FS_ACCOUNT_TW_ORDER_AGAIN','Купить снова');
define('FS_ACCOUNT_TW_CREATE_TICKET','Задать новый вопрос');
define('FS_ACCOUNT_TW_SUPPORT_TYPE','Тип сервиса');
define('FS_ACCOUNT_TW_ATTACH_PO','Загрузить PO');
define('FS_ACCOUNT_TW_SHOW_MORE','Показать больше');
define('FS_ACCOUNT_TW_BASIC_INFO','Основная информация');
define('FS_ACCOUNT_TW_ADDRESS_INFO','Адрес');
define('FS_ACCOUNT_TW_QUOTES_LIST_TIPS','Добавлять следующие товар(ы) в корзину и создавать коммерческое предложение.');
define('FS_ACCOUNT_TW_MOST_QUOTE','Последние КП');
define('FS_ACCOUNT_TW_VIEW_QUOTES','Посмотреть все КП');
define('FS_ACCOUNT_TW_NO_QUOTE','Запрос на КП не найден.');
define('FS_ACCOUNT_TW_QUOTE_ITEM','КП #, ID товара #');
define('FS_ACCOUNT_TW_QUOTE_AGAIN_TIPS1','По следующим причинам невозможно напрямую воссоздать КП на следующие товар(ы).');
define('FS_ACCOUNT_TW_QUOTE_AGAIN_TIPS2','По следующим причинам новое предложение не может быть предоставлено для следующих товаров. Нажимая кнопку "пропустить", чтобы добавить оставшиеся товар(ы) обратно в корзину и создать КП.');

define('FS_FOOTER_EXPLORE','Исследовать');
define('FS_HEADER_NEW_PRODUCT','Новинки');
define('FS_HEADER_CHANGE','Обновить');
define('FS_COMMON_VIEW_MORE','Подробнее');
define('FS_CART_EMPTY_TIP','Войдите, чтобы просмотреть корзину или продолжить покупку.');
define('BIllS_TIPS1','Вы можете проверить все свои инвойсы здесь.');
define('BIllS_TIPS2','Здесь вы можете проверить статус своего кредитного счета и все инвойсы.');
define('TIPS_BUTTON', 'Подтвердить');
define('TIPS_NEW', 'Новый');
define('FS_ATTRIBUTE_CUSTOMIZED','Заказной');
//warranty 新增分类质保信息
define('FS_WARRANTY_YEARS',' года');
define('FS_WARRANTY_YEAR',' год');
define('FS_WARRANTY_DAYS',' дней');
define('FS_WARRANTY_CONSUMABLE','Расходный');
define('FS_WARRANTY_UNAVAILABLE','Недоступен');
define('FS_WARRANTY_SUB_CATEGORY','Подкатегория');
define('FS_WARRANTY_RETURN','Срок <br>возврата');
define('FS_WARRANTY_CHANGE','Срок <br>обмена');
define('FS_WARRANTY_PERIOD','Гарантийный <br> срок');

define('FS_WARRANTY_NOTE','Примечания');

define('ORDER_PAYMENT_TIPS','Убедитесь, что указанный выше платежный адрес совпадает с адресом в выписке по вашей кредитной карте.');
define('ORDER_PAYMENT_SAFE','Безопасный и зашифрованный');
define('ORDER_PAYMENT_TIPS_2','Ваша информация будет использоваться только для обработки этого заказа и не будет храниться в FS.');

