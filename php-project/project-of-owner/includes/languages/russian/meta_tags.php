<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2008 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: meta_tags.php 10330 2008-10-10 20:14:32Z drbyte $
 */

// page title
define('TITLE', 'FS.COM');

// Site Tagline
define('SITE_TAGLINE', '');

// Custom Keywords
define('CUSTOM_KEYWORDS', 'Приемопередатчики,Патч-Корды, Adapters,Attenuators,FiberStore, online shopping');

// Home Page Only:
  define('HOME_PAGE_META_DESCRIPTION', 'FiberStore-магазин для оптического приемопередатчика, Мультиплексора / Демультиплексора, Оптического Медиаконвертера, Видео мультиплексора, оптических патч-кордов, оптических патч-панелей, оптоконнекторов и других оптических аксессуаров');
  define('HOME_PAGE_META_KEYWORDS', 'волоконно-оптическая связь, волоконно-оптическая сеть, волоконно-оптические продукты');

  // NOTE: If HOME_PAGE_TITLE is left blank (default) then TITLE and SITE_TAGLINE will be used instead.
  define('HOME_PAGE_TITLE', 'FiberStore - Решения для волоконно-оптических сетей, Все на FiberStore! '); // usually best left blank


// EZ-Pages meta-tags.  Follow this pattern for all ez-pages for which you desire custom metatags. Replace the # with ezpage id.
// If you wish to use defaults for any of the 3 items for a given page, simply do not define it.
// (ie: the Title tag is best not set, so that site-wide defaults can be used.)
// repeat pattern as necessary
  define('META_TAG_DESCRIPTION_EZPAGE_#','');
  define('META_TAG_KEYWORDS_EZPAGE_#','');
  define('META_TAG_TITLE_EZPAGE_#', '');

// Per-Page meta-tags. Follow this pattern for individual pages you wish to override. This is useful mainly for additional pages.
// replace "page_name" with the UPPERCASE name of your main_page= value, such as ABOUT_US or SHIPPINGINFO etc.
// repeat pattern as necessary
  define('META_TAG_DESCRIPTION_page_name','');
  define('META_TAG_KEYWORDS_page_name','');
  define('META_TAG_TITLE_page_name', '');

// Review Page can have a lead in:
  define('META_TAGS_REVIEW', 'Отзывы: ');

// separators for meta tag definitions
// Define Primary Section Output
  define('PRIMARY_SECTION', ' : ');

// Define Secondary Section Output
  define('SECONDARY_SECTION', ' - ');

// Define Tertiary Section Output
  define('TERTIARY_SECTION', ', ');

// Define divider ... usually just a space or a comma plus a space
  define('METATAGS_DIVIDER', ' ');

// Define which pages to tell robots/spiders not to index
// This is generally used for account-management pages or typical SSL pages, and usually doesn't need to be touched.
  define('ROBOTS_PAGES_TO_SKIP','вход,выход,создать_учетную запись,учетная запись,аккаунт_редактирование,аккаунт_история,аккаунт_история_инфо,аккаунт_бюллетени,аккаунт_уведомления,аккаунт_пароль,адресная_книга,расширенный_поиск,результат_расширенного_поиска,успешное_оформление заказа,оформить заказ_обработка,оформить заказ_доставка,checkout_payment,оформить заказ_подтверждение,cookie_использование,создать_аккаунт_успешно,контакты,скачать,скачать_тайм-аут,авторизация_клиентов,закрыт_на_техническое обслуживание,забыли_пароль,тайм-аут,отписаться,инфо_корзины,всплывающее_изображение,всплывающее_изображение_дополнительное,писать_отзывы_о товаре,ssl_проверка');


// favicon setting
// There is usually NO need to enable this unless you need to specify a path and/or a different filename
//  define('FAVICON','favicon.ico');

//dylan 2019.8.5 Add
define('METE_TAGS_CAT_BUY','Купить ');
define('METE_TAGS_CAT_BEST_PRICE',' онлайн, Самый лучший ');
define('META_TAGS_CATEGORIES_DESCRIPTION',' в FS.com.');

/*narrow*/
define('METE_TAGS_NARROW_FS',', Поиск FS.com');
define('METE_TAGS_NARROW_ONLINE_GLOBAL',' Online From Global ');
define('METE_TAGS_NARROW_OEM_MANUFACTURER',' Оптовая Цена на FS.com');
define('METE_TAGS_NARROW_OEM',' Купить и заказть оптоволоконные продукции от FS.com!');

/*support*/
define('METE_TAGS_SUPPORT_OF_FS','Поддержка FS.com');

define('METE_TAGS_POPULAR','Популярный -FS.com');
define('METE_TAGS_PRODUCTS_LIST','Прайс-лист ');
define('METE_TAGS_FIBER_OPTIC_PRODUCTS_LIST',' Прайс-лист оптоволоконных продукций');
define('META_TAGS_FIBERSTORE',' -FS.com');
define('META_TAGS_THE_LEADING','Ведущие оптоволоконные продукции. На этой странице вы можете легко найти все продукции FS.com, содержащие слово, начинающееся с буквы. ');
define('META_TAGS_CUSTOMER_SERVICE','Обслуживание клиентов');
define('META_TAGS_TUTORIAL_OF_COM','Руководство FS.com');
define('META_TAGS_NEWS_OF_COM','Новости FS.com');

define('META_TAGS_COMMON_TITLE','ЦОД, Предприятие, Телеком');
define('META_TAGS_COMMON_DESCRIPTION','FS - это новый бренд в решениях для ЦОД, Предприятий и Телеком. Мы помогаем ИТ специалистам легко и эффективно реализовать свои бизнес решения.');

//solutions页面meta相关
define('FS_SOLUTION_META_TITLE_O1','FS OTN решение для 10G DWDM двухволоконной сети');
define('FS_SOLUTION_META_DESCRIPTION_O1','FS предоставляет экономичное и легкое в управлении интегрированное решение 10G DWDM для взаимосвязи ЦОД (DCI) и корпоративных приложений.');
define('FS_SOLUTION_META_TITLE_O2','FS OTN решение для 10G DWDM одноволоконной сети');
define('FS_SOLUTION_META_DESCRIPTION_O2','FS предоставляет экономичное и легкое в управлении интегрированное решение 10G DWDM для взаимосвязи ЦОД (DCI) и корпоративных приложений.');
define('FS_SOLUTION_META_TITLE_O3','FS OTN решение для 25G DWDM двухволоконной сети');
define('FS_SOLUTION_META_DESCRIPTION_O3','FS обеспечивает решение 25G DWDM легкой масштабируемости и интеллектуального управления для 25G Ethernet, 5G приквела и взаимосвязи ЦОД.');
define('FS_SOLUTION_META_TITLE_O4','FS OTN решение для 25G DWDM одноволоконной сети');
define('FS_SOLUTION_META_DESCRIPTION_O4','FS обеспечивает решение 25G DWDM легкой масштабируемости и интеллектуального управления для 25G Ethernet, 5G приквела и взаимосвязи ЦОД.');
define('FS_SOLUTION_META_TITLE_O5','FS OTN решение для 10G CWDM двухволоконной сети');
define('FS_SOLUTION_META_DESCRIPTION_O5','FS предоставляет экономичное решение 10G CWDM с большой емкостью для городских сетей передачи на короткие расстояния.');
define('FS_SOLUTION_META_TITLE_O6','FS OTN решение для 10G CWDM одноволоконной сети');
define('FS_SOLUTION_META_DESCRIPTION_O6','FS предоставляет экономичное решение 10G CWDM с большой гибкостью для городских сетей передачи на короткие расстояния.');