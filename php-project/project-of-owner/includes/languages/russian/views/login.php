<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2009 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: login.php 14280 2009-08-29 01:33:18Z drbyte $
 */

define('NAVBAR_TITLE', 'Вход');
define('HEADING_TITLE', 'Добро Пожаловать, Войти, пожалуйста, в ');

define('HEADING_NEW_CUSTOMER', 'Новый? Укажите, пожалуйста,  платежную информацию');
define('HEADING_NEW_CUSTOMER_SPLIT', 'Новые Клиенты');

define('TEXT_NEW_CUSTOMER_INTRODUCTION', 'Создать архив клиента по <strong>' . STORE_NAME . '</strong>  который позволяет вам делать покупки быстрее, отслеживать статус вашего текущих заказов и просматривать предыдущие заказы.');
define('TEXT_NEW_CUSTOMER_INTRODUCTION_SPLIT', 'Есть аккаунт PayPal? Хотите быстро оплатить с помощью кредитной карты? Нажмите кнопку PayPal ниже, чтобы использовать Экспресс-вариант.');
define('TEXT_NEW_CUSTOMER_POST_INTRODUCTION_DIVIDER', '<span class="larger">Или</span><br />');
define('TEXT_NEW_CUSTOMER_POST_INTRODUCTION_SPLIT', 'Создать архив клиента по <strong>' . STORE_NAME . '</strong> который позволяет вам делать покупки быстрее, отслеживать статус вашего текущих заказов и просматривать предыдущие заказы  и пользоваться преимуществами наших других членов.');

define('HEADING_RETURNING_CUSTOMER', 'Дорогие клиенты: Войдите в, пожалуйста, ');
define('HEADING_RETURNING_CUSTOMER_SPLIT', 'Дорогие Клиенты');

define('TEXT_RETURNING_CUSTOMER_SPLIT', 'Для продолжения,  войдите, пожалуйста, в свою  <strong>' . STORE_NAME . '</strong> учетную запись.');

define('TEXT_PASSWORD_FORGOTTEN', 'Забыли пароль?');

define('TEXT_LOGIN_ERROR_NO_RECORD', 'Ошибка: извините, указанный адрес электронной почты не совпадает! Если вы зарегистрированы, проверьте еще раз, пожалуйста ! Вы и можете снова зарегистрироваться справа !');define('TEXT_LOGIN_ERROR_PASSWORD_NOT_MATCH', 'Ошибка: Извините, ваш пароль неправилен, проверьте его еще раз, пожалуйста!');
define('TEXT_VISITORS_CART', '<strong>Note:</strong> Если вы покупали у нас раньше и оставили кое-что в корзину, для вашего удобства, содержание будет объединено когда вы вернетесь в систему. <a href="javascript:session_win();">[More Info]</a>');

define('TABLE_HEADING_PRIVACY_CONDITIONS', '<span class="privacyconditions">Заявление О Конфиденциальности</span>');
define('TEXT_PRIVACY_CONDITIONS_DESCRIPTION', '<span class="privacydescription">Подтвердите, пожалуйста, что вы согласны с нашим заявлением о конфиденциальности, и поставьте галочку в следующем окне. Заявление о конфиденциальности можно прочитать</span> <a href="' . zen_href_link(FILENAME_PRIVACY, '', 'SSL') . '"><span class="pseudolink">здесь</span></a>.');
define('TEXT_PRIVACY_CONDITIONS_CONFIRM', '<span class="privacyagree">Заявление о конфиденциальности прочитано, я согласен(а).</span>');

define('ERROR_SECURITY_ERROR', 'Была ошибка безопасности при попытке логина.');

define('TEXT_LOGIN_BANNED', 'Ошибка: отказано в доступе.');




/************BOF LOGIN LANGUAGE****************/
define('TEXT_LOGIN_SUCCESS', 'bienvenidos a Fiberstore.com');

define('TEXT_LOGIN_FIVE','Fiberstore te llevará a la página principal automáticamente en 5 segundos');

define('TEXT_SUCCESS_MSG','O usted puede ir a las siguientes páginas de forma manual');

define('TEXT_SIGN_REGIST','Войти или создать аккаунт');


define('COPYRIGHT','Авторское Право @ 2002-'.date('Y',time()).' Fiberstore. Все Права Защищены.');

define('TEXT_LOGIN_ENTER','Введите адрес электронной почты, пожалуйста.');
//define('TEXT_PASSWORD_MSG','Ваш пароль должен содержать не менее 7 символов.');
define('TEXT_PASSWORD_MSG','Ваш пароль должен содержать минимум 7 символов.');
define('TEXT_PASSWORD_ENTER','Введите Ваш пароль, пожалуйста.');



define('TEXT_LOGIN_PLACE','Заказать онлайн');

define('TEXT_LOGIN_TRACK','Отслеживать заказ онлайн');

define('TEXT_LOGIN_VIEW','Просмотреть историю заказов');

define('TEXT_LOGIN_CREATE','Создавать список любимых, списки пожеланий и тому подобные!');

define('TEXT_LOGIN_MAKE','Делать бюджет проекта с помощью списков желаний');

define('TEXT_LOGIN_TECHNICAL','Получить поддержки от технической группы');

define('TEXT_LOGIN_HELP','Нужна Помощь?');

define('TEXT_LOGIN_HELP_WITH','Нужна помощь с');

define('TEXT_LOGIN_RETURNING','возврат и замена товара');

define('TEXT_LOGIN_VIEW_THE','Читайте');

define('TEXT_LOGIN_RMA','Вариант решения RMA ');

define('TEXT_LOGIN_PAGE','напишите нам письмо или электронную почту по адресу');

define('TEXT_LOGIN_EMAIL','service@fiberstore.com');

define('TEXT_LOGIN_CONTACT','Контакт');

define('TEXT_VIEW_FAQ','Читайте страницу ЧЗВ (часто задаваемые вопросы)');

define('TEXT_LOGIN_QUESTIONS','Есть вопросы о перевозке груза и доставки?');

define('TEXT_LOGIN_SHOP','Удовлетворительный Шопинг');

define('TEXT_SHOPPING_ON','Шопинг На FIBERSTORE.COM');

define('TEXT_IS_SAFE','Является надежным и безопасным.');

define('TEXT_LOGIN_GUARANTEED','Гарантировано!');

define('TEXT_LOGIN_FIBERSTORE','Вы платите ничего , если несанкционированные сборы взимаются с Вашей кредитной карты в результате покупки в fiberstore.com.');

define('TEXT_LOGIN_SAFE','ГАРАНТИЯ БЕЗОПАСНОЙ ПОКУПКИ');

define('TEXT_LOGIN_INFORMATION','Вся информация шифруется и передается без риска с использованием протокола защищенных Сокетов (SSL) протокол.');

define('TEXT_LOGIN_PROTECT','Как Мы Защищаем Ваши Личные Данные?');

define('TEXT_LOGIN_FREE','БЕСПЛАТНАЯ ДОСТАВКА И БЕСПЛАТНЫЙ ВОЗВРАТ');

define('TEXT_LOGIN_UNSA','Если вы неудовлетворены с вашей покупкой из FiberStore ко.,ООО вы можете вернуть товар в исходное состояние в течение 7 дней на возврат денег. Мы будем даже платить за возврат товара!');

define('TEXT_LOGIN_DELIVER','Чтобы доставить беззаботную операцию и исключить затраты, связанные с гарантийным ремонтом, FiberStore предлагает пожизненную гарантию в качестве стандартной функции во всех основных продуктовых линеек.');

define('TEXT_LOGIN_MORE','Узнать Больше?');

define('TEXT_LOGIN_OR','Или');

define('TEXT_LOGIN_CASE','пароли чувствительны к регистру');







define('ACCOUNT_FOOTER_TITLE','Удовлетворительный Шопинг');

define('ACCOUNT_FOOTER_SHOPPING','Шопинг На FIBERSTORE.COM ');

define('ACCOUNT_FOOTER_SECURE','Является надежным и безопасным.');

define('ACCOUNT_FOOTER_PAY','Вы платите ничего , если несанкционированные сборы взимаются с Вашей кредитной карты в результате покупки в fiberstore.com.');

define('ACCOUNT_FOOTER_SAFE','ГАРАНТИЯ БЕЗОПАСНОЙ ПОКУПКИ');

define('ACCOUNT_FOOTER_INFORMATION','Вся информация шифруется и передается без риска с использованием протокола защищенных Сокетов (SSL) протокол.');

define('ACCOUNT_FOOTER_HOW','Как Мы Защищаем Ваши Личные Данные?');

define('ACCOUNT_FOOTER_FREE','БЕСПЛАТНАЯ ДОСТАВКА И БЕСПЛАТНЫЙ ВОЗВРАТ');

define('ACCOUNT_FOOTER_SHOP','Если вы неудовлетворены с вашей покупкой из FiberStore ко.,ООО вы можете вернуть товар в исходное состояние в течение 7 дней на возврат денег. Мы будем даже платить за возврат товара!');

define('ACCOUNT_FOOTER_DELIVER','Чтобы доставить беззаботную операцию и исключить затраты, связанные с гарантийным ремонтом, FiberStore предлагает пожизненную гарантию в качестве стандартной функции во всех основных продуктовых линеек.');

define('ACCOUNT_FOOTER_LEARN','Узнать Больше?');

define('ACCOUNT_EMAIL_ERROR','Ошибка: Адрес электронной почты не найден в регистре нашей системы, введите заново, пожалуйста.');

define('ACCOUNT_PASSWORD_ERROR','Ошибка: Неправильный пароль. Пожалуйста, попробуйте еще раз!');

define('ACCOUNT_YZM_ERROR','Введите символы, изображенные на картинке!');



/***********EOF LOGIN LANGUAGUE***************/

/****************content*****************/
//ery   2016-8-29   add
define('FS_LOGIN_WELCOME','Добро пожаловать');
define('FS_LOGIN_TO_FS','Войти в Fiberstore');
define('FS_LOGIN_EMAIL','E-Mail');
define('FS_LOGIN_EMAIL_MSG','Электронная почта, которая вы ввели, не действует. Проверьте свою электронную почту и попробуйте еще раз, пожалуйста.');
define('FS_LOGIN_PASS','Пароль');
define('FS_LOGIN_PASS_MSG','Ваш пароль должен содержать минимум 6 символов.');
define('FS_LOGIN_IMG','Образ');
define('FS_LOGIN_IMG_TRY','Попробуйте другой образ.');
define('FS_LOGIN_CHAR','Введите символы:');
define('FS_LOGIN_CHAR_MSG','Введите символы, как они показаны на изображении.');
define('FS_LOGIN_FORGOT','Забыли пароль?');
define('FS_LOGIN_STAY','Оставаться в системе');
define('FS_LOGIN_SIGN','Логин');
define('FS_LOGIN_OTHER','Логин другими способами:');
define('FS_LOGIN_NEW','Регистрация');
define('FS_LOGIN_REGISTER','Частный Аккаунт');
define('FS_LOGIN_MEMBER_CAN','Член Fiberstore может:');
define('FS_LOGIN_PLACE','Заказать онлайн');
define('FS_LOGIN_TRACK','Отслеживать заказ онлайн');
define('FS_LOGIN_VIEW','Просмотреть историю заказов');
define('FS_LOGIN_CREATE','Создавать список любимых, списки пожеланий и тому подобные!');
define('FS_LOGIN_MAKE','Делать бюджет проекта с помощью списков желаний');
define('FS_LOGIN_TECH','Получить поддержки от технической группы');
define('FS_LOGIN_BUSINESS','Зарегистрировать Бизнес-Аккаунт');
define('FS_LOGIN_COPY','Copyright');
define('FS_LOGIN_RIGHTS','Все права защищены.');
define('FS_LOGIN_GOOGLE','Войти по Google');
define('FS_LOGIN_PAYPAL','Войти по Paypal');
define('FS_LOGIN_BUSINESS1','Бизнес-Аккаунт');

/********************header_php**********************/
define('FS_LOGIN_EMAIL_ERROR','Ошибка: Адрес электронной почты не найден в регистре нашей системы, введите заново, пожалуйста.');
define('FS_LOGIN_PASS_ERROR','Ошибка: Неправильный пароль. Пожалуйста, попробуйте еще раз!');

//2017.5.26		Add		ERY
define('FS_LOGIN_FACEBOOK','Вход через Facebook');
define('FS_LOGIN_PLEASE','');
define('FS_LOGIN_OR','ИЛИ');
define('FS_LOGIN_REGIST','Зарегистрируйте и создайте новый аккаунт для');





















































