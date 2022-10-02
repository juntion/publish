<?php
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
define('FS_HEADER_SEARCH','Поиск');
define('FS_HEADER_01','Поиск...');
define('FS_HEADER_02','Горячие запросы');
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
//define('FS_ACCOUNT', 'Личный Кабинет');
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
define('FS_MY_CASES','Мои Запросы');
define('FS_MY_QUOTES','Мои КП');
define('FS_ACCOUNT_SETTING','Настройки аккаунта');
define('FS_VIEW_ALL','Смотреть все');

// 搜索
define('FS_SEARCH_PRODUCTS','Поиск продукта');
define('FS_NEW_CHOOESE_CURRENCY','Выберите Валюту');
// 2018.7.23 fairy help
define('FS_NEED_HELP_BIG','Чат Сейчас');
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

define('FS_TAGIMG_TITLE','Рекомендуемые Комбинации');
define('FS_INDEX_CATE_PRODUCTS','Товары');
?>