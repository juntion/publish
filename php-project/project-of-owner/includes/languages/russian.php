<?php

define('FOOTER_TEXT_BODY', 'Copyright &copy; 2009-' . date('Y') . ' <a href="" target="_blank">FS.COM</a> Все права защищены. <a href="/ru/privacy_policy.html">Конфиденциальность </a> <a href="/ru/terms_of_use.html">&nbsp;&nbsp;Условия использования.</a> ');


/*bof language for my_account*/
define('FIBERSTORE_ORDER_HELLO', 'Здравствуйте, ');
//define('FIBERSTORE_CDN_IMAGES','https://d2gwt4r5cjfqmi.cloudfront.net/');
define('FIBERSTORE_CDN_IMAGES', '/images/');
define('FIBERSTORE_ORDER_LOGIN_AS', 'Вошли');

define('FS_PLEASE_W_REVIEW', 'Напишите ваш ответ.');
define('FS_EMAIL_FSCOM', 'https://www.fs.com/ru');
define('FS_REVIEWS_COMMENT_DEACRIPTION','Вы должны войти в личный кабинет или зарегистрироваться прежде чем оставлять комментарии.');

define('EXSIT_EMAIL_ADDRESS', 'Наша система уже есть запись этого адреса электронной почты - попробуйте войти посредством этого адреса электронной почты, пожалуйста.Если вы больше не используете этот адрес,вы можете исправить его в Мой Аккаунт.');

//夏令时--冬令时
define('SUMMER_TIME',true);
if(SUMMER_TIME){
    define('FS_SUMMER_OR_WINTER_TIME','3:30pm (UTC/GMT+2)');
    define('FS_CHECKOUT_TIME','4:30pm UTC/GMT+2');
}else{
    define('FS_SUMMER_OR_WINTER_TIME','3:00pm (UTC/GMT)');
    define('FS_CHECKOUT_TIME','4:30pm UTC/GMT+1');
}

//******************body box menu***********************/
define('F_BODY_HEADER_BACK', 'Вернуться на главную страницу Fiberstore');
define('F_BODY_HEADER_GS', 'Глобальная<br>Доставка');
define('F_BODY_HEADER_ITEMS', 'товаров');
define('F_BODY_HEADER_ITEM', 'товаров');
define('F_BODY_HEADER_ITEM_TWO', 'товаров');
define('F_BODY_MENU_CATEG', 'Каталог');
define('F_BODY_MENU_HOME', 'Главная');
define('F_BODY_MENU_WHOLESALES', 'Oптом');
define('F_BODY_MENU_PROD', 'Продукты');
define('F_BODY_MENU_TUTORIAL', 'Руководство');
define('F_BODY_MENU_ABOUT', 'О Нас');
define('F_BODY_MENU_SUPP', 'Сервис');
define('F_BODY_MENU_CONTANT', 'Контакт');

//2017-12-7  add   ery
define('EMAIL_CHECKOUT_COMMON_SUCCESS_TITLE','FS.COM - Спасибо за Ваш заказ %s, обработаем его сразу после подтверждения оплаты');
define('EMAIL_CHECKOUT_COMMON_SUCCESS_TITLE_PO','FS.COM - Спасибо за Ваш заказ %s, обработаем его сразу после подтверждения заказа PO');
define('EMAIL_CHECKOUT_PAYMENT_SUCCESS_TITLE','FS.COM - Платёж на заказ %s получен');
define('EMAIL_CHECKOUT_PO','успешно загружен');

define("FS_WAREHOUSE_AREA_35","Спасибо за Ваш заказ на покупку.</br>Примечание: Сумма заказа превышает Ваш кредитный лимит в FS.COM. Чтобы мы могли быстро обрабатывать этот заказ, пожалуйста, оплатите предыдущие заказы на вращение кредитного лимита, или Вы можете войти
  в «Личный кабинет» и нажмите «Заказ на покупку», чтобы подать заявку на увеличение кредитного лимита, мы отправим Вам по электронной почте результат после просмотра.");
//***************shop cart******************************/
define('F_HAVE_NO_SHOPCART', 'Ваша корзина пуста.');
define('FIBERSTORE_REMOVE', 'Удалить');
define('FIBERSTORE_CART_TOTAL', 'Итого');
define('FIBERSTORE_EDITE_ORDER', 'Изменить Заказ');
define('FIBERSTORE_EDITE_ORDER_RU', 'Просмотреть корзину');
define('FIBERSTORE_CHECK_YOU_ORDER', 'Платить');
define('FS_PROCEED_TO_CHECKOUT', 'ПЕРЕЙТИ К ОФОРМЛЕНИЮ ЗАКАЗА');
define('FS_ITEMS', 'Кол-во');
define('FS_CART', 'Корзина');
define('FS_VIEW_ALL', 'Смотреть все');
define('FS_FILTER', 'фильтр');
define('FS_SAVED_ITEMS', 'Все сохраненные товары');
define('FS_SAVED_CART', 'Сохраните телега');
//******************Product List************************/
//*****************产品列表页标题******************************
define('FIBERSTORE_LIST_BIAO', 'По умолчанию');
define('FIBERSTORE_LIST_BIAO2', 'Объем Продаж');
define('FIBERSTORE_LIST_BIAO3', 'Цена');
define('FIBERSTORE_LIST_BIAO4', 'Новинки');
define('FIBERSTORE_LIST_BIAO5', 'фото');
define('FIBERSTORE_LIST_BIAO6', 'Статус');
define('FIBERSTORE_LIST_BIAO7', 'Дата Отправки');
define('FIBERSTORE_LIST_BIAO8', 'Цена');
define('FIBERSTORE_LIST_BIAO9', 'Кол-во');
define('FIBERSTORE_LIST_BIAO10', 'Цены по Объёму');
define('FIBERSTORE_LIST_BIAO11', 'Примерно в тот же день');
define('FIBERSTORE_LIST_BIAO12', 'В корзину');
define('FIBERSTORE_LIST_BIAO13', 'Если Вам нужен большой объем заказа, подайте заявку на ');
define('FIBERSTORE_LIST_BIAO131', 'Бизнес-Аккаунт </a> или');
define('FIBERSTORE_LIST_BIAO132', ' свяжитесь с нами</a>  чтобы получить наибольшие льготы.');
define('FIBERSTORE_LIST_BIAO14', 'Количество');
define('FIBERSTORE_LIST_BIAO15', 'Цена');

define('FIBERSTORE_LIST_BIAO14', 'Примерно на следующий день');
define('FIBERSTORE_LIST_BIAO15', 'Estimated on');
define('FIBERSTORE_LIST_BIAO16', 'Подробности');
define('FIBERSTORE_LIST_BIAO17', ' Комментарии');
define('FIBERSTORE_LIST_BIAO18', 'Длина Волны');
define('FIBERSTORE_LIST_BIAO19', 'Расстояние');
define('FIBERSTORE_LIST_BIAO20', 'Скорость');
define('FIBERSTORE_LIST_BIAO21', 'Запрос Цены');
define('FIBERSTORE_LIST_BIAO22', 'Название');
define('FIBERSTORE_LIST_BIAO23', 'Валюты');
define('FIBERSTORE_LIST_BIAO24', 'Оптические Аттенюаторы :');
define('FIBERSTORE_LIST_BIAO25', 'Волоконно-Оптические Модемы :');
define('FIBERSTORE_LIST_BIAO26', 'Рабочая Длина Волны :');
define('FIBERSTORE_LIST_BIAO27', 'Совместимые Бренды:');
define('FIBERSTORE_LIST_BIAO28', 'Больше');
define('FIBERSTORE_LIST_BIAO29', 'Показать Больше Брендов');
define('FIBERSTORE_LIST_BIAO31', 'Показать Меньше Брендов');
define('FIBERSTORE_LIST_BIAO30', 'Категории');

// 2016-05-14 新增
define('FIBERSTORE_QUICKFINDER', 'Быстрый Поиск');
define('FIBERSTORE_PAGE', 'Страница');
define('FIBERSTORE_POPULARITY', 'Популярности');
//2016-5-16新增
define('FIBERSTORE_P_LOW_TO_HIGH', 'Цене: Сверху');
define('FIBERSTORE_P_HIGH_TO_LOW', 'Цене: Снизу');
define('FIBERSTORE_R_HIGH_TO_LOW', 'Оценкам');
define('FIBERSTORE_NEWEST_F', 'Новинкам');
define('FIBERSTORE_POPU', 'Популярности');


define('F_PRODUCT_IMAGES', 'фото');
define('F_PRODUCT_STATUS', 'Состояние ');
define('F_PRODUCT_WAVELENGTH', 'Длина волны');
define('F_PRODUCT_DISTANCE', 'Расстояние');
define('F_PRODUCT_DATERATE', 'Скорость');
define('F_PRODUCT_SHIPDATE', 'Дата Доставки');
define('F_VOLUME_PRICE', 'Объем ценообразование');
define('F_VOLUME_PRICE_GET', 'Если вам нужен большой объем заказа, пожалуйста, подавайте заявку на <a href="<?php echo $href;?>" target="_blank">бизнес-аккаунт</a> или <a href="<?php echo zen_href_link(FILENAME_CONTACT_US)?>" target="_blank">свяжитесь с нами,</a> чтобы пользоваться преференциальной политики.');
define('F_OPTION_ARRAY1', 'Цена с высокой к низкому');
define('F_OPTION_ARRAY2', 'Цена от низкой до высокой');
define('F_OPTION_ARRAY3', 'Бестселлеры');
define('F_OPTION_ARRAY4', 'Лучшие По Рейтингу Товары ');
define('F_OPTION_ARRAY5', 'Новинки');

define('F_PRODUCT_RECOMMEND', 'Рекомендуемые Продукты');
define('F_PRODUCT_RESULTS', '<div class="results_font">К сожалению,мы не нашли <s>0</s> результаты!  <a href="<?php echo zen_href_link(FILENAME_DEFAULT, cPath=' . (int)$current_category_id . ');?>"> Посмотрите другие продукты</a>.</div>');
define('F_PRODUCT_REVIEWS', 'отзывы');
define('FIBERSTORE_SHOW_RESULTS', '<b>Показать результаты для</b>');
define('FIBERSTORE_SHOW_BRANDS', 'Больше Брендов');
define('FIBERSOTER_SHOW_MORE_BRANDS', ' Больше Брендов');
define('FIBERSOTER_COMPATIBLE_BRANDS', 'Совместимые Бренды');
define('FIBERSOTER_SHOW_LESS_BRANDS', 'Показать Меньше Брендов');
//******************LEFT_sidebar************************/


//******************product_detail******************* *********************/


/***********checkout_globalcollect_billing 2016-06-06***************************/
define('PAY_ORDER_SUCCESS', 'Спасибо за покупки у нас! Ваш заказ принят.');
define('PAY_ORDER_SUMMARY', 'Содержание Заказа');
define('PAY_ORDER_NUMBER', 'Номер Заказа');
define('PAY_TOTAL_AMOUNT', 'Общая Сумма');
define('PAY_ITEM', 'Товар(ы)');
define('PAY_SHIPPING_METHOD', 'Способ Доставки');
define('PAY_ORDER_DATE', 'Дата Заказа');
define('PAY_PAYMENT_METHOD', 'Способ Оплаты');
define('PAY_CONTACT_US', 'Если у вас есть любой вопрос, свяжитесь с нами ');
define('PAY_TEL', 'Тел');
define('PAY_EMAIL', 'E-mail');
define('PAY_YOU_CAN', 'Заказ успешно отправлен, Вы можете');
define('PAY_VIEW_ORDER', 'Посмотреть Мои Заказы');
define('PAY_CHANGE_ORDER', 'Изменить Мои Заказы');
define('PAY_SHIPPING_ADDRESS', 'Адрес Доставки');
define('PAY_BACK_HOME', 'Назад');
define('FIBER_DELETE', 'Удалить этот товар');
define('FIBER_YES', 'Да');
define('FIBER_NO', 'Нет');

define('FIBERSTORE_CART', 'Корзина');
define('FIBERSTORE_CHECKOUT', 'Оформить Заказ');
define('FIBERSTORE_SUCCESS', 'Оформление Заказа');
define('FIBERSTORE_BILLING_ADDRESS', 'Платёжный Адрес');
define('FIBERSTORE_FIRST_NAME', 'Имя');
define('FIBERSTORE_LAST_NAME', 'Фамилия');
define('FIBERSTORE_POSTAL_CODE', 'Почтовый Индекс');
define('FIBERSTORE_CITY', 'Город');
define('FIBERSTORE_COUNTRY', 'Страна/Регион');
define('FIBERSTORE_STATE', 'Край');
define('FIBERSTORE_PROVINCE', 'Область');
define('FIBERSTORE_REGION', 'Регион');
define('FIBERSTORE_TELEPHONE_NUMBER', 'Номер Телефона');


/***********checkout_globalcollect_billing 2016-05-18***************************/
define('F_USE_CREDIT', 'Платеж был отклонен. Используйте другую кредитную карту или поменяйте способ оплаты путем PayPal или банковского перевода в открытом порядке, пожалуйста');
define('F_MAKE_SURE', 'Убедитесь, что ниже введенный расчётный адрес согласуется с именем и адресом, связанными с Вашей кредитной картой для этой покупки. Обратите внимание, что страны Вашего расчётного адреса и адреса доставки должны быть одинаковыми');
define('F_COUNTRY', ' Страна-Получатель');
define('F_ZIP', 'ZIP');
define('F_ORDER_SUMMARY', 'Содержание Заказа');
define('F_ORDER_NUMBER', ' Номер Заказа');
define('F_TOTAL_AMOUNT', 'Итоговая Сумма');
define('F_SELECT_CARD_TYPE', 'Выберите тип карты, заполните следующую информацию и нажмите Продолжить');
define('F_NOTE', 'Примечание: В целях безопасности, мы не сохраним любые данные Вашей кредитной карты');
define('F_SELECT_CREDIT', 'Выберите Кредитную');
define('F_DEBIT_CARD', 'Дебетовую Карту');
define('F_ACCEPT', 'Мы принимаем следующие кредитные/дебетовые карты');
define('F_CREDIT_OR_DEBIT', 'Платёжный Центр Кредитной/Дебетовой Карты');
define('F_CARD_NUMBER', 'Номер Карты');
define('F_EXPIRATION_DATE', 'Дата Истечения');
define('F_MONTH', 'Месяц');
define('F_YEAR', 'Год');
define('F_SECURITY_CODE', ' Код Безопасности');
define('F_LOADING', 'Обработка');
define('F_CONTINUE', 'Продолжить');


/*******************Checkout***********************************/
/*****************2016-05-18新增******************/
define('F_EDIT', 'Изменять');
define('F_PROCEED_TO_PAYPAL', 'Перейти к PayPal ');
define('F_CONFIRM_TO_PAYMENT', 'Подтвердить Платеж');
define('F_SUBMIT_ORDER', 'Отправить Заказ');
define('F_SHIP_SAME_DAY', 'Отправка в тот день');
define('F_SHIP_NEXT_DAY', 'Почти на второй день');
define('F_SHIP_TIME', 'Расчетное время:');
define('F_WENHAO', 'Может быть некоторая разница между расчетным временем и фактическим временем');
define('F_CHAT_NOW', 'Чат Онлайн');
define('F_PLEASE_SELECT', 'Выберите');
define('F_PLEASE_ENTER_FIRST_NAME', 'Введите ваше Имя');
define('F_PLEASE_ENTER_LAST_NAME', 'Введите ваше Фамилия');
define('F_PLEASE_ENTER_STREET_ADDRESS', 'Введите ваш Адрес');
define('F_PLEASE_ENTER_CITY', 'Введите ваш Город');
define('F_PLEASE_ENTER_POSTAL_CODE', 'Введите Почтовый Код');
define('F_PLEASE_ENTER_COUNTRY', 'Введите вашу Страну');
define('F_PLEASE_ENTER_STATE', 'Введите ваш Штат/Провинцию/Регион');
define('F_PLEASE_ENTER_TELEPHONE_NUMBER', 'Введите ваш Номер Телефона');
/*****************2016-05-19新增******************/
define('F_TIP', 'Введите Ваш адрес доставки выше, то система Fiberstore покажет Вам все способы доставки в вашу страну');
define('F_TIPS', 'Советы');

/*****************2016-6-16新增*****************/
define('F_OUTDOOR_WHO1', 'Применения');
define('F_OUTDOOR_WHO2', 'Техническое Описание');
define('F_OUTDOOR_WHO3', 'Артикул');
define('F_OUTDOOR_WHO4', 'Диам. Кабеля(mm)');
define('F_OUTDOOR_WHO5', 'Вес Кабеля(kg/km)');
define('F_OUTDOOR_WHO6', 'Цена за Единицу($/m)');
define('F_OUTDOOR_WHO7', 'К сожалению, мы нашли <s>0</s> результатов!');
define('F_OUTDOOR_WHO8', 'Посмотрите другие товары');
define('F_OUTDOOR_WHO9', 'Рекомендованные Товары');


define('NAVBAR_TITLE_1', 'Оформить Заказ');
define('F_SHIPPING_ADDRESS', 'Адрес Доставки ');
define('F_M_BILLING_ADDRESS', 'Управлять вашими платежными адресами');
define('F_NEW_SHIPPING_ADDRESS', 'Добавить новый адрес доставки');
define('F_SHIPPING_METHOD', 'Способ Доставки');
define('F_CART', 'Корзина');
define('F_SUCCESS', 'Успешно');
define('F_SHIPPINGTIME_COST', '<th width="500">Способ Доставки
                      </th>
                    <th width="230">Расчетное Время Доставки
                      </th>
                    <th width="118">Стоимость
                      </th>');
define('F_FEDEX_IP', 'FedEx IP');
define('F_PRIORITY', 'Приоритет');
define('F_FREIGHT_COLLECT', 'Фрахт');
define('F_UNIT_PRICE', 'Цена за Единицу');
define('F_WARNING', 'Если вы предпочитаете использовать свой собственный  экспресс-счет, предоставьте номер счета, пожалуйста. Затем Fiberstore не взимает плату за перевозку.');
define('F_SHIPPING_METHOD', 'Способ Доставки: ');
define('F_EXPRESS_ACCOUNT', 'Экспресс Счет: ');
define('F_NO_SHIPPING', 'Нет доставка в выбранную страну, для подробной информации, пожалуйста');
define('F_CONTACT_US', 'свяжитесь с нами');
define('F_TIPS', 'Советы');
define('F_TIPS_MSG', 'Введите ваш адрес доставки выше, пожалуйста, и Fiberstore система покажет все способы доставки для Вас.');
define('F_WHEN_ORDER_ARRIVE', 'Когда товар доставим?');
define('F_PROCESSING', ' Время обработки и доставки ');
define('F_MORE_INFORMATION', 'Дополнительная Информация');
define('F_PROCESSING_TIME', 'Время обработки:');
define('F_ALL_PRODUCTS', 'Все продукты требуют обработки перед отгрузкой. Обработка включает в себя выбор продукта, проверку качества и тщательно упаковки для отгрузки.<br />
                <b>Среднее время обработки:</b> В среднем 2-5 дней<br />
                <b>Исключения:</b> В зависимости от обстоятельств. Вы должны связаться с нашим отделом продажи для дополнительной информации.<br />
                <br />
                <span>Доставка:</span><br />
                Время доставки зависит от способа доставки:<br />
                <b>Быстрая Доставка:</b> 1-4 рабочих дней<br />
                <b>Стандартная Доставка:</b> 2-6 рабочих дней<br />
                <b>Супер Экономичная Доставка:</b> 10-30 рабочих дней <br />
                fs.com выбирает лучшего перевозчика исходя из требований Вашего заказа и адреса доставки. И мы свяжемся с вами при особых обстоятельствах.<br />');
define('F_PAYMENT_METHOD', 'Способ Оплаты');
define('F_WE_CURRENTLY', 'В настоящее время мы помогаем Вам в телеграфным переводе (TT) для всех заказов. Также относимся к безопасности очень серьезно, поэтому ваши данные надежно защищены');
define('F_CART_SUMMARY', 'В Корзине');
define('F_ITTEM', 'шт');
define('F_QTY', 'Кол-во');
define('F_WEIGHT', 'Вес');
define('F_PRICE', 'Цена');
define('F_TOTA_AMOUNT', 'Общая Сумма');
define('F_TOTAL', 'Итого:');
define('F_SHIPPING_COST', '(+)Стоимость Доставки:');
define('F_EXCLUDING_TAXES', 'Без Учета Налогов?');
define('F_PO', 'Введите Ваш номер заказа');
define('FIBERSTORE_WAIT_PROCESSING', 'Обработка');
define('DISCLAIMER_ORDERS', 'Отказ от ответственности за Международные Заказы');
define('DISCLAIMER_ORDERS_CONMENT', 'Ввозные таможенные пошлины, налоги и брокерские вознаграждения не включены в цену продукта, доставку или расходы на обработку, которые будут взимать при доставке от перевозчиков для некоторых посылок. Ведь таможня взимает таможенные сборы случайным образом по прибытию посылки, мы не можем предсказать эти расходы.<br />
            <br />
            Эти сборы являются ответственностью получателя, потому что мы только начисляем транспортные расходы на пасылки. Вы можете узнать у таможни вашей страны о том, что эти дополнительные расходы будут.');

define('FS_CHECK_PAYTIT', 'В настоящее время мы принимаем PayPal, Кредитные/Дебетовые Карты и Банковский Электронный Перевод для всех заказов. Мы очень серьезно относимся к безопасности, поэтому ваши данные надежно защищены у нас.');
define('FS_CHECK_PAY1', 'Кредитные/Дебетовые Карты');
define('FS_CHECK_PAY2', 'Банковский Перевод');
define('FS_CHECK_NOTE', 'Внимание');
define('CHECK_PAY1_TIT', 'Существующие пользователи PayPal могут совершить платеж посредством Вашего аккаунта PayPal');
define('CHECK_PAY1_CON', 'Новые пользователи могут сначала зарегистрировать аккаунт PayPal, и потом продолжить платить на веб-сайте PayPal.');
define('CHECK_PAY1_FOT', 'вы можете перевести деньги напрямую в PayPal для нас, наш счет:');
define('CHECK_PAY2_TIT', 'Мы принимаем следующие кредитные и дебетовые карты:');
define('CHECK_PAY2_CON', 'В целях безопасности, мы не будем сохранять никаких данных Вашей кредитной карты.');
define('CHECK_PAY3_TIT', 'Реквизиты бенефициария Банковского Электронного Перевода:');
define('CHECK_PAY3_ADD1', 'Название Банка-Получателя:');
define('CHECK_PAY3_ADD2', 'ФИО Бенефициара:');
define('CHECK_PAY3_ADD3', 'Номер Расчётного Счёта Получателя:');
define('CHECK_PAY3_ADD4', 'SWIFT Адресс:');
define('CHECK_PAY3_ADD5', 'Адресс Банка-Получателя:');
define('CHECK_PAY3_ADD6', 'Адрес Нашей Компании:');
define('CHECK_PAY3_ADD7', 'ул. Keyuan, "Научно-Технологический Парк", д.6 на втором этаже с восточной стороны, Наньшань Район, г. Шэньчжэнь, Китай');
define('CHECK_PAY3_CON', 'Клиенты, которые выбирают банковский перевод, несут ответственность за все расходы и пошлины за обработку местных банков-посредников.');
define('FS_CHECK_TOTAL', '<b>Отказ от Ответственности за Международные Заказы</b><br /><br />

Ввозные таможенные пошлины, налоги и брокерские вознаграждения не включены в цену продукта, доставку или расходы на обработку, которые будут взимать при доставке от перевозчиков для некоторых посылок. Ведь таможня взимает таможенные сборы случайным образом по прибытию посылки, мы не можем предсказать эти расходы.<br />
            <br />
            Эти сборы являются ответственностью получателя, потому что мы только начисляем транспортные расходы на пасылки. Вы можете узнать у таможни вашей страны о том, что эти дополнительные расходы будут.');
define('FS_CHECK_EDIT', 'Редактировать Заказ');
define('FS_CHECK_SUB1', 'Перейти на Paypal');
define('FS_CHECK_SUB2', 'Отправить Заказ');
define('FS_ADDRESS_TIT', 'Поля, обязательные для заполнения.');
define('FS_ADDRESS_TIT1', 'Адрес Выставления Счета');
define('FS_ADDRESS_TIT2', 'Добавить Новый Платежный Адрес');
define('FS_ADDRESS_LI1', 'Имя:');
define('FS_ADDRESS_LI2', 'Фамилия:');
define('FS_ADDRESS_LI3', 'Адресная Строка:');
define('FS_ADDRESS_LI4', 'Город:');
define('FS_ADDRESS_LI5', 'Страна:');
define('FS_ADDRESS_LI6', 'Выбирайте');
define('FS_ADDRESS_LI7', 'Штат / Провинция / Регион:');
define('FS_ADDRESS_LI8', 'ZIP / Почтовый Индекс:');
define('FS_ADDRESS_LI9', 'Номер Телефона:');
define('FS_ADDRESS_LI10', 'Сохранение');
define('FS_ADDRESS_LI11', 'Отмена');
define('FS_ADDRESS_LI12', 'Обработка идёт...');
define('FS_CHECK_COLLECT', 'Фрахт Подлежит Уплате Грузополучателем');
define('FS_COLLECT_TIT', 'Способ Доставки:');
define('FS_COLLECT_TIT1', 'Счет Экспресса:');

define('FIBERSTORE_CREDIT_CARD', 'Расчёт Кредитной Карты');
define('FIBERSTORE_CREDIT_CARD2', '
          <td width="20%"><div align="left" class="pay_lc_01">Корзина</div></td>
          <td width="25%"><div align="center" class="pay_lc_03">Оформить Заказ</div></td>
          <td width="25%"><div align="right" class="pay_lc_04">Успешная Покупка</div></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div class="login_new_03">
  <div class="login_new_04">
    <div class="transfer">
      <div class="credit_card_left">
	  <div class="login_title">Кредитная/Дебетовая Карта - Платёжный Центр</div>
        <div class="credit_card_title">Информация Платёжа</div>
        <div class="credit_card_content"><span>Проверьте введённый адерес, пожалуйста, чтобы он совпадал с информацией той кредитной карты для этой покупки. Обратите внимание на то, что страна Вашего платежного адреса и страна адреса доставки должны быть одинаковыми.');

define('FIBERSTORE_CREDIT_CARD3', 'Имя:');
define('FIBERSTORE_CREDIT_CARD4', 'Фамилия:');
define('FIBERSTORE_CREDIT_CARD5', 'Платежный Адрес');
define('FIBERSTORE_CREDIT_CARD6', 'Страна/Регион Получателя:');
define('FIBERSTORE_CREDIT_CARD7', 'Штат / Провинция / Регион:');
define('FIBERSTORE_CREDIT_CARD8', 'Город:');
define('FIBERSTORE_CREDIT_CARD9', 'ZIP / Почтовый Индекс:');
define('FIBERSTORE_CREDIT_CARDT', 'Номер Телефона:');
define('FIBERSTORE_CREDIT_CARD10', 'Ваш платеж был отклонен. Используйте другую кредитную карту или поменяйте способ оплаты посредством PayPal или Банковского Перевода, пожалуйста.');
define('FIBERSTORE_CREDIT_CARD11', 'Информация Кредитной/Дебетовой Карты
<div class="track_orders_wenhao">
		<div class="question_bg"></div>
			<div class="question_text_01 leftjt"><div class="arrow"></div><div class="popover-content">Мы принимаем следующие кредитные/дебетовые карты. Выберите тип карты, заполните информацию ниже, и нажмите кнопку Продолжить.<span>(Примечание: В целях безопасности, мы не будем сохранять информацию Вашей кредитной карты.)');
define('FIBERSTORE_CREDIT_CARD12', 'Выберите Кредитную/Дебетовую Карту:');
define('FIBERSTORE_CREDIT_CARD13', 'Номер Карты:');
define('FIBERSTORE_CREDIT_CARD14', 'дата Истечения:');
define('FIBERSTORE_CREDIT_CARD15', 'Месяц');
define('FIBERSTORE_CREDIT_CARD16', 'Год');
define('FIBERSTORE_CREDIT_CARD17', 'Код Безопасности Карты:');
define('FIBERSTORE_CREDIT_CARD18', 'Продолжить');
define('FIBERSTORE_CREDIT_CARD19', 'Содержание Заказа');
define('FIBERSTORE_CREDIT_CARD20', 'Стоимость:');
define('FIBERSTORE_CREDIT_CARD21', 'Фрахт:');
define('FIBERSTORE_CREDIT_CARD22', 'Итого:');
define('FIBERSTORE_CREDIT_CARD23', 'Дополнительные безопасные платежные системы:');
//2016-6-8
define('PAY_XIFANGLIANMENG', 'Печатать Заказ</a> 
</div>
  <div class="layout_title">Информация Бенефициара Банковского Перевода</div>
    <div class="layout_son">
         <table width="100%" border="0" cellpadding="0" cellspacing="0" class="wire_info">
                  <tbody>
                    <tr>
                      <th width="170" valign="top">Название Банка Получателя:</th>
                      <td valign="top">HSBC Hong Kong</td>
                    </tr>
                    <tr>
                      <th valign="top">Название Бенефициара: </th>
                      <td valign="top">FIBERSTORE CO., LIMITED</td>
                    </tr>
                    <tr>
                      <th valign="top">Счет Бенефициара:</th>
                      <td valign="top">817-498231-838</td>
                    </tr>
                    <tr>
                      <th valign="top">SWIFT Адресс:</th>
                      <td valign="top">HSBCHKHHHKH</td>
                    </tr>
                    <tr>
                      <th valign="top">Адрес Банка Бенефициара:</th>
                      <td valign="top">1 Queen\'s Road Central, Hong Kong</td>
                    </tr>
                    <tr>
                      <th valign="top">Адресс Нашей Компании:</th>
                      <td valign="top">Eastern Side, Second Floor, Science &amp; Technology Park, No.6, Keyuan Road, Nanshan District, Shenzhen, China');
/************************end_checkout******************************/

define('TEXT_DISPLAY_NUMBER_OF_NEWS', 'Show <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> News )');
define('TEXT_DISPLAY_NUMBER_OF_TUTORIAL', 'Show <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> Tutorial )');
/*eof*/
// look in your $PATH_LOCALE/locale directory for available locales..
// on RedHat try 'en_US'
// on FreeBSD try 'en_US.ISO_8859-1'
// on Windows try 'en', or 'English'
@setlocale(LC_TIME, 'en_US.UTF-8');
define('DATE_FORMAT_SHORT', '%m/%d/%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()
define('DATE_FORMAT', 'm/d/Y'); // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');
// define('FIBERSTORE_REGIST_ERROR','Our system already has a record of that email address - please try logging in with that email address. If you do not use that address any longer you can correct it in the My Account area.');
define('FIBERSTORE_REGIST_ERROR', 'Nuestro sistema ya tiene un registro de dicha dirección de correo electrónico - por favor intenta acceder a dicha dirección de correo electrónico. Si usted no usa esa dirección por más tiempo se puede corregir en el area Mi Cuenta');
define('FIBERSTORE_LOGIN_ERROR', 'La dirección de email o la contrase?a es incorrecta.');

/*bof language contact_us email time:2012_12_17*/
//define('FIBERSTORE_WELCOME_MEAASGE','This email message was sent from a notification-only address that cannot accept incoming email. PLEASE DO NOT REPLY to this message. If you have any questions please contact us.');
define('FIBERSTORE_WELCOME_MEAASGE', 'Este mensaje fue enviado desde una dirección exclusivamente de notificación que no puede recibir mensajes entrantes. Por favor no responda a este mensaje. Si usted tiene alguna pregunta, por favor póngase en contacto con nosotros.');

define('FIBERSTORE_REVIEW_NO', 'Ninguna revisión actualmente .');
define('FIBERSTORE_WELCOME_TO', 'Estimado cliente,');
define('FIBERSTORE_WELCOME_CART', 'Carrito Permanente');
//define('FIBERSTORE_WELCOME_CART','Permanent Cart');
define('FIBERSTORE_CONTACT_ABOUT', 'sobre nosotros contenido de ecoptical.com');
define('FIBERSTORE_CUSTOMER_NAME', 'Nombre del cliente:');
define('FIBERSTORE_CUSTOMER_EMAIL', 'Cliente E-mail:');
define('FIBERSTORE_CONTACT_SUBJECT', 'sujeto');
define('FIBERSTORE_CONTACT_CONTENTS', 'Contenido:');
define('FIBERSTORE_CONTACT_FROM', 'De http://www.fs.com');

define('FIBERSTORE_SELECT', 'Por favor seleccione...');
//  define('FIBERSTORE_SELECT','Please select ...');

define('EMAIL_HEADER_INFO', '
	<!-- 2018.6.26头部-->
			<div class="em_img" style="text-align: center;margin-top: 20px;margin-bottom: 8px;">
				<a href="'.zen_href_link('index').'">
					<img style="display: inline-block;" width="150" src="https://www.fs.com/images/email-logo.png"/>
				</a>		
			</div>
			<div class="em_a" style="text-align: center;margin-bottom: 20px;">
				<a style="display: inline-block;font-size: 12px;color: #232323;line-height: 20px;text-decoration: none;" href="'.HTTPS_SERVER.reset_url('support/Data-Center-Products.html').'">ЦОД</a>
				<em class="em_em" style="display: inline-block;margin-left: 5px;margin-right: 5px;height: 10px;width: 1px;background: #616265;"></em>
				<a style="display: inline-block;font-size: 12px;color: #232323;line-height: 20px;text-decoration: none;" href="'.HTTPS_SERVER.reset_url('support/Enterprise-Small-Business.html').'">Корпоративные Сети</a>
				<em class="em_em" style="display: inline-block;margin-left: 5px;margin-right: 5px;height: 10px;width: 1px;background: #616265;"></em>
				<a style="display: inline-block;font-size: 12px;color: #232323;line-height: 20px;text-decoration: none;" href="'.HTTPS_SERVER.reset_url('support/ISP-Networks.html').'">OTN</a>
			</div>');
define('EMAIL_FOOTER_INFO','
			<hr class="em_hr" style="border:none;border-top: 1px solid #e5e5e5;" />
			<div class="em_p" style="margin-top: 36px;margin-bottom: 26px;text-align: center;font-size: 12px;">Поделиться своим опытом использования <a style="text-decoration: none;font-size: 12px;line-height: 20px;color: #232323;text-align: center;padding-bottom: 10px;margin-bottom: 20px;" href="'.zen_href_link('index').'">#FS.COM</a></div>
			<div class="em_icon" style="text-align: center;">
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: 0 0;" href="'.sourceHtml('linkedin', false).'"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -20px 0;" href="'.sourceHtml('youtube', false).'"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -40px 0;" href="'.sourceHtml('facebook', false).'"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -60px 0;" href="'.sourceHtml('twitter', false).'"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -80px 0;" href="https://www.pinterest.co.uk/?show_error=true"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -100px 0;" href="'.sourceHtml('instagram', false).'"></a>
			</div>
			<div class="em_a01" style="text-align: center;margin-top: 18px;margin-bottom: 14px;">
				<a style="text-decoration: none;font-size: 12px;color: #232323;line-height: 20px;display: inline-block;margin: 0 6px;" href="'.zen_href_link('contact_us').'">Свяжитесь с нами</a>
				<a style="text-decoration: none;font-size: 12px;color: #232323;line-height: 20px;display: inline-block;margin: 0 6px;" href="'.zen_href_link('account_newsletters').'">Личный кабинет</a>
				<a style="text-decoration: none;font-size: 12px;color: #232323;line-height: 20px;display: inline-block;margin: 0 6px;" href="'.zen_href_link('shipping_delivery').'">Доставка</a>
				<a style="text-decoration: none;font-size: 12px;color: #232323;line-height: 20px;display: inline-block;margin: 0 6px;" href="'.HTTPS_SERVER.reset_url('policies/day_return_policy.html').'">Возврат</a>
			</div>
			<div class="em_p01" style="font-size: 12px;line-height: 20px;color: #232323;text-align: center;">Вы получили это письмо на адрес $user_email.</div>
			<div class="em_p01" style="font-size: 12px;line-height: 20px;color: #232323;text-align: center;">
				<a style="text-decoration: none;font-size: 12px;line-height: 20px;color: #232323;text-align: center;" href="'.zen_href_link('account_newsletters').'">Нажимая кнопку ниже, вы можете изменять свои предпочтения или отказываться от подписки.</a>
			</div>');


/* 产品、分类公用 */
define('FS_CUSTOMILIZED_ADD_TO_CART','В Корзину');
define('FS_ADD_TO_CART', 'В Корзину');
define('CATEGORIES_HEADING_DETAILS', 'Подробности');
define('FS_VIEW_CART', 'К корзине');
define('FS_REVIEWS', 'Отзыв');
define('FS_REVIEW','Отзывы');
define('FS_REVIEWS_SMALL', 'Отзыв');
define('FS_SHARE', 'Опубликовать');
define('FS_NEED_HELP', ' Чат Сейчас');
define('FS_COMPATIBLE', 'Cовместимый');
define('FS_LENGTH', 'Длина');
define('FS_TOTAL_LENGTH', 'Общая Длина');
define('FS_CUSTOM_LENGTH', 'Заказать Длину');
define('FS_SHIPPING_COST', 'Доставка');
define('FS_SHIP_SAME_DAY', ' Отправка в тот же день');
define('FS_SHIP_NEXT_DAY', ' Отправка на второй день');
define('FS_OUT_OF_STOCK', 'Отсутствие запасов');
define('FS_DELETE_PRODUCT', 'Удалить продукт');
define('FS_AVAILABILTY', 'Наличие');
define('FS_PRODUCTS_ORDERS_RECEIVED', 'Заказы, принятые 1:00 вечера по тихоокеанскому времени с пн. по пт. (за исключением праздничных дней), будут отправлены на следующий рабочий день.');
define('FS_PRODUCTS_ACTUAL_TIME', 'Может быть некоторая разница между расчетным временем и фактическим временем.');
define('PRODUCT_INFO_ADD', 'Добавить');
define('PRODUCT_INFO_ADDED', 'Добавлен');
define('FS_TRANSCEIVER_TYPE', 'Тип Трансивера:');
define('ACCOUNT_FOOTER_TITLE', 'Удовлетворительный Шопинг');

define('ACCOUNT_FOOTER_SHOPPING', 'Шопинг На FIBERSTORE.COM ');

define('ACCOUNT_FOOTER_SECURE', 'Является надежным и безопасным.');

define('TEXT_LOGIN_GUARANTEED', 'Гарантировано!');

define('ACCOUNT_FOOTER_PAY', 'Вы платите ничего , если несанкционированные сборы взимаются с Вашей кредитной карты в результате покупки в fs.com.');

define('ACCOUNT_FOOTER_SAFE', 'ГАРАНТИЯ БЕЗОПАСНОЙ ПОКУПКИ');

define('ACCOUNT_FOOTER_INFORMATION', 'Вся информация шифруется и передается без риска с использованием протокола защищенных Сокетов (SSL) протокол.');

define('ACCOUNT_FOOTER_HOW', 'Как Мы Защищаем Ваши Личные Данные?');

define('ACCOUNT_FOOTER_FREE', 'БЕСПЛАТНАЯ ДОСТАВКА И БЕСПЛАТНЫЙ ВОЗВРАТ');

define('ACCOUNT_FOOTER_SHOP', 'Если вы неудовлетворены с вашей покупкой из FiberStore ко.,ООО вы можете вернуть товар в исходное состояние в течение 7 дней на возврат денег. Мы будем даже платить за возврат товара!');

define('ACCOUNT_FOOTER_DELIVER', 'Чтобы доставить беззаботную операцию и исключить затраты, связанные с гарантийным ремонтом, FiberStore предлагает пожизненную гарантию в качестве стандартной функции во всех основных продуктовых линеек.');

define('ACCOUNT_FOOTER_LEARN', 'Узанать больше');

define('TEXT_FIBERSTORE_REGIST_RESPECTS', 'fs.com уважает вашу частную жизнь. Мы не предоставляем и не продаем Вашу личную информацию кому-либо.');

define('TEXT_FIBERSTORE_REGIST_PRIVACY', 'Политика конфиденциальности.');

////
// Return date in raw format
// $date should be in format mm/dd/yyyy
// raw date is in format YYYYMMDD, or DDMMYYYY
if (!function_exists('zen_date_raw')) {
    function zen_date_raw($date, $reverse = false)
    {
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
define('HTML_PARAMS', 'dir="ltr" lang="en"');

// charset for web pages and emails
define('CHARSET', 'UTF-8');

// footer text in includes/footer.php
define('FOOTER_TEXT_REQUESTS_SINCE', 'запросы с');

// Define the name of your Gift Certificate as Gift Voucher, Gift Certificate, Zen Cart Dollars, etc. here for use through out the shop
define('TEXT_GV_NAME', 'Подарочный Сертификат');
define('TEXT_GV_NAMES', 'Подарочные Сертификаты');

// used for redeem code, redemption code, or redemption id
define('TEXT_GV_REDEEM', 'Кодовое Слово');

// used for redeem code sidebox
define('BOX_HEADING_GV_REDEEM', TEXT_GV_NAME);
define('BOX_GV_REDEEM_INFO', 'Кодовое слово: ');

// text for gender
define('MALE', 'Дорогой');
define('FEMALE', 'Дорогая');
define('MALE_ADDRESS', 'Дорогой');
define('FEMALE_ADDRESS', 'Дорогая');

// text for date of birth example
define('DOB_FORMAT_STRING', 'дд/мм/гггг');

//text for sidebox heading links
define('BOX_HEADING_LINKS', '&nbsp;&nbsp;[more]');

// categories box text in sideboxes/categories.php
define('BOX_HEADING_CATEGORIES', 'Категории');

// manufacturers box text in sideboxes/manufacturers.php
define('BOX_HEADING_MANUFACTURERS', 'Производители');

// whats_new box text in sideboxes/whats_new.php
define('BOX_HEADING_WHATS_NEW', 'Новинки');
define('CATEGORIES_BOX_HEADING_WHATS_NEW', 'Новые Продукты ...');

define('BOX_HEADING_FEATURED_PRODUCTS', 'Рекомендуемые');
define('CATEGORIES_BOX_HEADING_FEATURED_PRODUCTS', 'Рекомендуемые Продукты...');
define('TEXT_NO_FEATURED_PRODUCTS', 'Больше рекомендуемых товаров будут добавлены в ближайшее время. Зайдите попозже, пожалуйста.');

define('TEXT_NO_ALL_PRODUCTS', 'Больше продуктов будут добавлены в ближайшее время. Зайдите попозже, пожалуйста.');
define('CATEGORIES_BOX_HEADING_PRODUCTS_ALL', 'Все Товары ...');

// quick_find box text in sideboxes/quick_find.php
define('BOX_HEADING_SEARCH', 'Поиск');
define('BOX_SEARCH_ADVANCED_SEARCH', 'Расширенный Поиск');
define('HEADING_SEARCH_KEYWORDS_DEFAULT', 'Введите слова для поиска здесь ...');
// specials box text in sideboxes/specials.php
define('BOX_HEADING_SPECIALS', 'Товары по скидкой');
define('CATEGORIES_BOX_HEADING_SPECIALS', 'Товары по скидкой ...');

// reviews box text in sideboxes/reviews.php
define('BOX_HEADING_REVIEWS', 'Отзывы');
define('BOX_REVIEWS_WRITE_REVIEW', 'Написать отзыв на этот продукт.');
define('BOX_REVIEWS_NO_REVIEWS', 'В данный момент нет отзывов о товаре.');
define('BOX_REVIEWS_TEXT_OF_5_STARS', '% из 5 звезд!');

// shopping_cart box text in sideboxes/shopping_cart.php
define('BOX_HEADING_SHOPPING_CART', 'Корзина');
define('BOX_SHOPPING_CART_EMPTY', 'Ваша корзина пуста.');
define('BOX_SHOPPING_CART_DIVIDER', 'ea.-&nbsp;');

// order_history box text in sideboxes/order_history.php
define('BOX_HEADING_CUSTOMER_ORDERS', 'Быстрый Повторный Заказ');

// best_sellers box text in sideboxes/best_sellers.php
define('BOX_HEADING_BESTSELLERS', 'Бестселлеры');
define('BOX_HEADING_BESTSELLERS_IN', 'Бестселлеры в<br />&nbsp;&nbsp;');

// notifications box text in sideboxes/products_notifications.php
define('BOX_HEADING_NOTIFICATIONS', 'Уведомления');
define('BOX_NOTIFICATIONS_NOTIFY', 'Сообщите мне о новинках <strong>%s</strong>');
define('BOX_NOTIFICATIONS_NOTIFY_REMOVE', 'Не сообщите мне о новинках <strong>%s</strong>');

// manufacturer box text
define('BOX_HEADING_MANUFACTURER_INFO', 'Информация О Производителе');
define('BOX_MANUFACTURER_INFO_HOMEPAGE', '%s Главная Страница.');
define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', 'Другие продукты');

// languages box text in sideboxes/languages.php


// currencies box text in sideboxes/currencies.php
define('BOX_HEADING_CURRENCIES', 'Валюты');

// information box text in sideboxes/information.php
define('BOX_HEADING_INFORMATION', 'Информация');
define('BOX_INFORMATION_PRIVACY', 'Уведомление О Конфиденциальности');
define('BOX_INFORMATION_CONDITIONS', 'Условия использования');
define('BOX_INFORMATION_SHIPPING', 'Доставка &amp; Возвраты');
define('BOX_INFORMATION_CONTACT', 'Контакт');
define('BOX_BBINDEX', 'Форум');
define('BOX_INFORMATION_UNSUBSCRIBE', 'Отписаться Рассылку');

define('BOX_INFORMATION_SITE_MAP', 'Карта сайта Fiberstore');

// information box text in sideboxes/more_information.php - were TUTORIAL_
define('BOX_HEADING_MORE_INFORMATION', 'Дополнительная Информация');
define('BOX_INFORMATION_PAGE_2', 'Страница 2');
define('BOX_INFORMATION_PAGE_3', 'Страница 3');
define('BOX_INFORMATION_PAGE_4', 'Страница 4');

// tell a friend box text in sideboxes/tell_a_friend.php
define('BOX_HEADING_TELL_A_FRIEND', 'Поделиться с другами');
define('BOX_TELL_A_FRIEND_TEXT', 'Рассказать знакомым об этой продукции.');

// wishlist box text in includes/boxes/wishlist.php
define('BOX_HEADING_CUSTOMER_WISHLIST', 'Мой Список пожеланий');
define('BOX_WISHLIST_EMPTY', 'У вас нет товаров в Вашем Списке пожеланий');
define('IMAGE_BUTTON_ADD_WISHLIST', 'Добавить в Список пожеланий');
define('TEXT_WISHLIST_COUNT', 'В настоящее время %s из предметов в вашем списке пожеланий.');
define('TEXT_DISPLAY_NUMBER_OF_WISHLIST', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> items on your wishlist)');

//New billing address text
define('SET_AS_PRIMARY', 'Установить в качестве Основного Адреса');
define('NEW_ADDRESS_TITLE', 'Платёжный Адрес');

// javascript messages
define('JS_ERROR', 'Ошибки произошли во время обработки вашей формы.\n\nВыполните следующие корректировки,пожалуйста:\n\n');

define('JS_REVIEW_TEXT', '* Добавьте несколько слов к вашим комментариям, пожалуйста. Обзор должен содержать по крайней мере ' . REVIEW_TEXT_MIN_LENGTH . '  символов.');
define('JS_REVIEW_RATING', '* Выберите рейтинг для этого товара, пожалуйста.');

define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* Выберите способ оплаты для Вашего заказа, пожалуйста.');

define('JS_ERROR_SUBMITTED', 'Эта форма уже была представлена. Пожалуйста, нажмите ОК и подождите, пока этот процесс завершится.');

define('ERROR_NO_PAYMENT_MODULE_SELECTED', 'Выберите способ оплаты для Вашего заказа, пожалуйста.');
define('ERROR_CONDITIONS_NOT_ACCEPTED', 'Please confirm the terms and conditions bound to this order by ticking the box below.');
define('ERROR_PRIVACY_STATEMENT_NOT_ACCEPTED', 'Подтвердите, пожалуйста, заявление о конфиденциальности, поставив галочку в поле ниже.');

define('CATEGORY_COMPANY', 'Сведения о компании');
define('CATEGORY_PERSONAL', 'Ваши Личные Данные');
define('CATEGORY_ADDRESS', 'Ваш Адрес');
define('CATEGORY_CONTACT', 'Ваша Контактная Информация');
define('CATEGORY_OPTIONS', 'Опции');
define('CATEGORY_PASSWORD', 'Ваш Пароль');
define('CATEGORY_LOGIN', 'Логин');
define('PULL_DOWN_DEFAULT', 'Выберите Вашу Страну, пожалуйста ');
define('PLEASE_SELECT', 'Выберите, пожалуйста ...');
define('TYPE_BELOW', 'Введите ниже выбор ...');

define('ENTRY_COMPANY', 'Название Компании:');
define('ENTRY_COMPANY_ERROR', 'Введите название компании, пожалуйста.');
define('ENTRY_COMPANY_TEXT', '');
define('ENTRY_GENDER', 'Приветствие:');
define('ENTRY_GENDER_ERROR', 'Выберите приветствие, пожалуйста.');
define('ENTRY_GENDER_TEXT', '*');
define('ENTRY_FIRST_NAME', 'Имя:');
define('ENTRY_FIRST_NAME_ERROR', 'Ваше имя правильно? Наша система требует минимум ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' символов. Попробуйте еще раз, пожалуйста. ');
define('ENTRY_FIRST_NAME_TEXT', '*');
define('ENTRY_LAST_NAME', 'Last Name:');
define('ENTRY_LAST_NAME_ERROR', 'Ваше фамилия правильно? Наша система требует минимум ' . ENTRY_LAST_NAME_MIN_LENGTH . ' символов. Попробуйте еще раз, пожалуйста.');
define('ENTRY_LAST_NAME_TEXT', '*');
define('ENTRY_DATE_OF_BIRTH', 'Дата рождения:');
define('ENTRY_DATE_OF_BIRTH_ERROR', 'Ваша дата рождения правильна? Наша система требует дату в формате: мм/ДД/ГГГГ (пример 05/21/1970)');
define('ENTRY_DATE_OF_BIRTH_TEXT', '* (пример 05/21/1970)');
define('ENTRY_EMAIL_ADDRESS', 'Адрес Электронной Почты:');
define('ENTRY_EMAIL_ADDRESS_ERROR', 'Ваш адрес электронной почты правильный? Он должен содержать по крайней мере ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . 'символов. Попробуйте еще раз, пожалуйста.');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'К сожалению, наша система не понимает ваш адрес электронной почты. Попробуйте еще раз, пожалуйста.');
// define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Este e-mail ya existe en nuestra base de datos - por favor, entre con otro e-mail o cree otra cuenta con una dirección de e-mail diferen.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Наша система уже записала тот адрес электронной почты - попробуйте войти в систему на этот электронный адрес, пожалуйста. Если Вы не больше используете этот адрес, вы можете исправить его в кабинете МОЙ АККАУНТ.');

define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
define('ENTRY_NICK', ' Ник Форума:');
define('ENTRY_NICK_TEXT', '*'); // note to display beside nickname input field
define('ENTRY_NICK_DUPLICATE_ERROR', 'Этот Ник уже используется. Попробуйте другой, пожалуйста.');
define('ENTRY_NICK_LENGTH_ERROR', 'Попробуйте еще раз, пожалуйста. Ваш ник должен содержать как минимум ' . ENTRY_NICK_MIN_LENGTH . 'символов.');
define('ENTRY_STREET_ADDRESS', 'Почтовый Адрес:');
define('ENTRY_STREET_ADDRESS_ERROR', 'Ваш почтовый адрес должен содержать минимум ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . 'символов.');
define('ENTRY_STREET_ADDRESS_TEXT', '*');
define('ENTRY_SUBURB', 'Адрес строка 2:');
define('ENTRY_SUBURB_ERROR', '');
define('ENTRY_SUBURB_TEXT', '');
define('ENTRY_POST_CODE', 'Почтовый Индекс:');
define('ENTRY_POST_CODE_ERROR', 'Ваш почтовый индекс должен содержать минимум' . ENTRY_POSTCODE_MIN_LENGTH . ' символов.');
define('ENTRY_POST_CODE_TEXT', '*');
define('ENTRY_CITY', 'Город:');
define('ENTRY_CUSTOMERS_REFERRAL', 'Referral Code:');

define('ENTRY_CITY_ERROR', 'Ваш город должен содержать минимум ' . ENTRY_CITY_MIN_LENGTH . ' символов.');
define('ENTRY_CITY_TEXT', '*');
define('ENTRY_STATE', 'Край/Область/Регион:');
define('ENTRY_STATE_ERROR', 'Ваш Штат должен содержать минимум ' . ENTRY_STATE_MIN_LENGTH . ' символов.');
define('ENTRY_STATE_ERROR_SELECT', 'Выберите регион из Штат-выпадающего меню.');
define('ENTRY_STATE_TEXT', '*');
define('JS_STATE_SELECT', '-- Выберите, пожалуйста --');
define('ENTRY_COUNTRY', 'Страна:');
define('ENTRY_COUNTRY_ERROR', 'Вы должны выбрать страну из Страна-выпадающего меню.');
define('ENTRY_COUNTRY_TEXT', '*');
define('ENTRY_TELEPHONE_NUMBER', 'Телефон:');
define('ENTRY_TELEPHONE_NUMBER_ERROR', 'Ваш номер телефона должен содержать минимум' . ENTRY_TELEPHONE_MIN_LENGTH . ' символов.');
define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
define('ENTRY_FAX_NUMBER', 'Номер Факса:');
define('ENTRY_FAX_NUMBER_ERROR', '');
define('ENTRY_FAX_NUMBER_TEXT', '');
define('ENTRY_NEWSLETTER', 'Подписаться на нашу рассылку.');
define('ENTRY_NEWSLETTER_TEXT', '');
define('ENTRY_NEWSLETTER_YES', 'подписаться');
define('ENTRY_NEWSLETTER_NO', 'отписаться');
define('ENTRY_NEWSLETTER_ERROR', '');
define('ENTRY_PASSWORD', 'Пароль:');
define('ENTRY_PASSWORD_ERROR', 'Ваш пароль должен содержать минимум ' . ENTRY_PASSWORD_MIN_LENGTH . ' символов.');
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'Подтверждение пароля должно соответствовать паролю.');
define('ENTRY_PASSWORD_TEXT', '* (по крайней мере ' . ENTRY_PASSWORD_MIN_LENGTH . '  символов)');
define('ENTRY_PASSWORD_CONFIRMATION', 'Подтвердите Пароль:');
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT', 'Текущий Пароль:');
define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_ERROR', 'Ваш пароль должен содержать минимум' . ENTRY_PASSWORD_MIN_LENGTH . ' символов.');
define('ENTRY_PASSWORD_NEW', 'Новый Пароль:');
define('ENTRY_PASSWORD_NEW_TEXT', '*');
define('ENTRY_PASSWORD_NEW_ERROR', 'Ваш новый пароль должен содержать минимум ' . ENTRY_PASSWORD_MIN_LENGTH . 'символов.');
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'Подтверждение пароля должно соответствовать новому паролю.');
define('PASSWORD_HIDDEN', '--Скрытые--');

define('FORM_REQUIRED_INFORMATION', '* Необходимая информация');
define('ENTRY_REQUIRED_SYMBOL', '*');

// constants for use in zen_prev_next_display function
define('TEXT_RESULT_PAGE', '');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Итого: <strong>%d</strong> Пункты &nbsp;&nbsp; <strong>%d</strong> / %d');

define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> products)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> orders)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> reviews)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> new products)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> specials)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_FEATURED_PRODUCTS', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> featured products)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_ALL', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> products)');
define('TEXT_TOTAL_NUMBER_OF_REVIEWS', '(<strong>%d</strong>)');


define('PREVNEXT_TITLE_FIRST_PAGE', 'Первая Страница');
define('PREVNEXT_TITLE_PREVIOUS_PAGE', 'Предыдущая Страница');
define('PREVNEXT_TITLE_NEXT_PAGE', 'Следующая Страница');
define('PREVNEXT_TITLE_LAST_PAGE', 'Последняя страница');
define('PREVNEXT_TITLE_PAGE_NO', 'Страница %d');
define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'Предыдущий набор %d страниц');
define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'Следующий набор %d страниц');
define('PREVNEXT_BUTTON_FIRST', 'Первый');
define('PREVNEXT_BUTTON_PREV', 'Пред');
define('PREVNEXT_BUTTON_NEXT', 'След');
define('PREVNEXT_BUTTON_LAST', 'Последний');

define('TEXT_BASE_PRICE', 'Начинается с: ');

define('TEXT_CLICK_TO_ENLARGE', 'увеличенное изображение');

define('TEXT_SORT_PRODUCTS', 'Католог товаров');
define('TEXT_DESCENDINGLY', 'по убыванию');
define('TEXT_ASCENDINGLY', 'по возрастанию');
define('TEXT_BY', ' по ');

define('TEXT_REVIEW_BY', 'по %s');
define('TEXT_REVIEW_WORD_COUNT', '%s словам');
define('TEXT_REVIEW_RATING', 'Рейтинг: %s [%s]');
define('TEXT_REVIEW_DATE_ADDED', 'Добавленная Дата: %s');
define('TEXT_NO_REVIEWS', 'В данный момент нет отзывов о товаре.');

define('TEXT_NO_NEW_PRODUCTS', 'Более новые продукты будут добавлены в ближайшее время. Зайдите попозже, пожалуйста.');

define('TEXT_UNKNOWN_TAX_RATE', 'Налог С Продаж');

define('TEXT_REQUIRED', '<span class="errorText">Требуется</span>');

define('WARNING_INSTALL_DIRECTORY_EXISTS', 'Предупреждение:  директория установки на: %s. Удалите эту директорию для безопасности, пожалуйста.');
define('WARNING_CONFIG_FILE_WRITEABLE', 'Предупреждение: Я могу писать в конфигурационный файл: %s.Это потенциальный риск безопасности -  установите, пожалуйста, необходимые права доступа к этому файлу (только для чтения, CHMOD 644 или 444 являются типичными).. Вам может потребоваться использовать ваш хостинг панель управления/файловый менеджер для изменения разрешения эффективно. Обратитесь к вашему хостингу для помощи. <a href="http://tutorials.zen-cart.com/index.php?article=90" target="_blank">Смотрите этот FAQ</a>');
define('ERROR_FILE_NOT_REMOVEABLE', 'Error: Не удалось удалить указанный файл. Возможно, вам придется использовать FTP удалить файл из-за ограничения прав конфигурации сервера.');
define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'Предупреждение: Директория сессий не существует: ' . zen_session_save_path() . '. Сессии не будут работать пока эта директория создается.');
define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'Предупреждение: Я не умею писать директорию сессий: ' . zen_session_save_path() . '. Сессии не будут работать до тех пор, пока правильные настройки прав доступа пользователя установлены.');
define('WARNING_SESSION_AUTO_START', 'Предупреждение: session.auto_start включена - отключите эту функцию PHP в php.ini и перезапустите веб-сервер, пожалуйста.');
define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'Предупреждение:Директории загружаемых продуктов  не существует: ' . DIR_FS_DOWNLOAD . '. Загружаемые продукты не будут работать, пока эта директория является допустимой.');
define('WARNING_SQL_CACHE_DIRECTORY_NON_EXISTENT', 'Предупреждение: Каталога кэша SQL не существует: ' . DIR_FS_SQL_CACHE . '. SQL-кэширование не будет работать, пока эта директория создается.');
define('WARNING_SQL_CACHE_DIRECTORY_NOT_WRITEABLE', 'Предупреждение:Я не умею писать директорию на SQL кэш: ' . DIR_FS_SQL_CACHE . '. SQL-кэширование не будет работать до тех пор, пока правильные настройки прав доступа пользователя установлены.');
define('WARNING_DATABASE_VERSION_OUT_OF_DATE', 'Для Вашей базы данных появляется необходимость ямочного ремонта на более высокий уровень. Вижу Админ->Инструменты->Информация о сервере пересмотреть патч уровни.');
define('WARNING_COULD_NOT_LOCATE_LANG_FILE', 'Предупреждение: Не удалось найти файл языка: ');

define('TEXT_CCVAL_ERROR_INVALID_DATE', 'Введенная дата срока действия кредитной карты является недействительной. Проверьте даты и попробуйте еще раз, пожалуйста.');
define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'Введенный номер кредитной карты неверный. Проверьте номер и попробуйте еще раз, пожалуйста.');
define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'Номер кредитной карты, начиная с %s был введен неправильно, или мы не принимаем такую карту. Попробуйте еще раз или используйте другую кредитную карту, пожалуйста.');

define('BOX_INFORMATION_DISCOUNT_COUPONS', 'Купоны На Скидку');
define('BOX_INFORMATION_GV', TEXT_GV_NAME . ' Вопросы и ответы');
define('VOUCHER_BALANCE', TEXT_GV_NAME . ' Баланс ');
define('BOX_HEADING_GIFT_VOUCHER', TEXT_GV_NAME . ' Счет');
define('GV_FAQ', TEXT_GV_NAME . ' Вопросы и ответы');
define('ERROR_REDEEMED_AMOUNT', 'Поздравляем, что вы использовали ');
define('ERROR_NO_REDEEM_CODE', 'Вы не ввели ' . TEXT_GV_REDEEM . '.');
define('ERROR_NO_INVALID_REDEEM_GV', 'Недействительно' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM);
define('TABLE_HEADING_CREDIT', 'Credits Available');
define('GV_HAS_VOUCHERA', 'У вас есть средства в вашем ' . TEXT_GV_NAME . '  счете. Если вы хотите <br />
                           вы можете отправить эти средства <a class="pageResults" href="');

define('GV_HAS_VOUCHERB', '"><strong>по электронной почте</strong></a> кому-то');
define('ENTRY_AMOUNT_CHECK_ERROR', 'У вас не хватает средств, чтобы отправить эту сумму.');
define('BOX_SEND_TO_FRIEND', 'Отправить ' . TEXT_GV_NAME . ' ');

define('VOUCHER_REDEEMED', TEXT_GV_NAME . ' использованные');
define('CART_COUPON', 'Купон :');
define('CART_COUPON_INFO', 'дополнительная информация');
define('TEXT_SEND_OR_SPEND', 'У вас есть баланс в вашем ' . TEXT_GV_NAME . ' счете. Вы можете провести его или отправить его кому-то другому. Для отправки нажмите на кнопку ниже.');
define('TEXT_BALANCE_IS', 'Ваш' . TEXT_GV_NAME . ' баланс: ');
define('TEXT_AVAILABLE_BALANCE', 'Ваш ' . TEXT_GV_NAME . ' Аккаунт');

// payment method is GV/Discount
define('PAYMENT_METHOD_GV', 'Подарочный Сертификат/Купон');
define('PAYMENT_MODULE_GV', 'GV/DC');

define('TABLE_HEADING_CREDIT_PAYMENT', 'Credits Available');

define('TEXT_INVALID_REDEEM_COUPON', 'Недопустимый Код Купона');
define('TEXT_INVALID_REDEEM_COUPON_MINIMUM', 'Вы должны потратить по крайней мере %s, чтобы использовать этот купон');
define('TEXT_INVALID_STARTDATE_COUPON', 'Этот купон еще не доступен');
define('TEXT_INVALID_FINISHDATE_COUPON', 'Этот купон истек');
define('TEXT_INVALID_USES_COUPON', 'Этот купон может быть использован только ');
define('TIMES', ' раз.');
define('TIME', ' раз.');
define('TEXT_INVALID_USES_USER_COUPON', 'Вы воспользовались промо-кодом: %s максимальное количество раз разрешено на одного клиента. ');
define('REDEEMED_COUPON', 'купон стоит ');
define('REDEEMED_MIN_ORDER', 'по приказу свыше ');
define('REDEEMED_RESTRICTIONS', ' [Ограничение Продукта-Категории]');
define('TEXT_ERROR', 'Произошла ошибка');
define('TEXT_INVALID_COUPON_PRODUCT', 'Этот купон код не действует для любого продукта в настоящее время в вашей корзине.');
define('TEXT_VALID_COUPON', 'Поздравляем вас, что вы использовали купон на скидку');
define('TEXT_REMOVE_REDEEM_COUPON_ZONE', 'Введеный код купона  не действителен для адреса, который вы выбрали.');

// more info in place of buy now
define('MORE_INFO_TEXT', '... подробнее');

// IP Address
define('TEXT_YOUR_IP_ADDRESS', 'Ваш IP-адрес: ');

//Generic Address Heading
define('HEADING_ADDRESS_INFORMATION', 'Адресная информация');

// cart contents
define('PRODUCTS_ORDER_QTY_TEXT_IN_CART', 'Количество в корзине: ');
define('PRODUCTS_ORDER_QTY_TEXT', 'Добавить в корзину: ');

// success messages for added to cart when display cart is off
// set to blank for no messages
// for all pages except where multiple add to cart is used:
define('SUCCESS_ADDED_TO_CART_PRODUCT', 'Товар успешно добавлен в корзину ...');
// only for where multiple add to cart is used:
define('SUCCESS_ADDED_TO_CART_PRODUCTS', 'Успешно добавлен выбранный продукт(ы) в корзину ...');

define('TEXT_PRODUCT_WEIGHT_UNIT', 'kg');

// Shipping
define('TEXT_SHIPPING_WEIGHT', 'kg');
define('TEXT_SHIPPING_BOXES', 'Коробки');

// Discount Savings
define('PRODUCT_PRICE_DISCOUNT_PREFIX_1', 'Сохранить &nbsp;');
define('PRODUCT_PRICE_DISCOUNT_PREFIX', 'Сохранить:&nbsp;');
define('PRODUCT_PRICE_DISCOUNT_PERCENTAGE', '% выкл.');
define('PRODUCT_PRICE_DISCOUNT_AMOUNT', '&nbsp;выкл.');

// Sale Maker Sale Price
define('PRODUCT_PRICE_SALE', 'Продажа:&nbsp;');

//universal symbols
define('TEXT_NUMBER_SYMBOL', '# ');

// banner_box
define('BOX_HEADING_BANNER_BOX', 'Спонсоры');
define('TEXT_BANNER_BOX', 'Посетите наших спонсоров, пожалуйста ...');

// banner box 2
define('BOX_HEADING_BANNER_BOX2', 'Вы видели ...');
define('TEXT_BANNER_BOX2', 'Проверьте это сегодня!');

// banner_box - all
define('BOX_HEADING_BANNER_BOX_ALL', 'Спонсоры');
define('TEXT_BANNER_BOX_ALL', 'Посетите наших спонсоров, пожалуйста ...');

// boxes defines
define('PULL_DOWN_ALL', 'Выберите, пожалуйста');
define('PULL_DOWN_MANUFACTURERS', '- Сброс -');
// shipping estimator
define('PULL_DOWN_SHIPPING_ESTIMATOR_SELECT', 'Выберите, пожалуйста');

// general Sort By
define('TEXT_INFO_SORT_BY', 'Сортировать по: ');

// close window image popups
define('TEXT_CLOSE_WINDOW', ' - Кликните по изображению, чтобы закрыть его');
// close popups
define('TEXT_CURRENT_CLOSE_WINDOW', '[ Закрыть Окно ]');

// iii 031104 added:  File upload error strings
define('ERROR_FILETYPE_NOT_ALLOWED', 'Ошибка: Тип файла не допускается.');
define('WARNING_NO_FILE_UPLOADED', 'Предупреждение: файл не загружен.');
define('SUCCESS_FILE_SAVED_SUCCESSFULLY', 'Успех: файл успешно сохранен.');
define('ERROR_FILE_NOT_SAVED', 'Ошибка: файл не сохранен.');
define('ERROR_DESTINATION_NOT_WRITEABLE', 'Ошибка: назначения не доступен для записи.');
define('ERROR_DESTINATION_DOES_NOT_EXIST', 'Ошибка: назначения не существует.');
define('ERROR_FILE_TOO_BIG', 'Предупреждение: файл слишком большой для загрузки!<br /> Заказать можно, но пожалуйста, свяжитесь с администрацией сайта для помощи загрузки');
// End iii added

define('TEXT_BEFORE_DOWN_FOR_MAINTENANCE', 'ВНИМАНИЕ: этот сайт планируется быть закрыт на техническое обслуживание: ');
define('TEXT_ADMIN_DOWN_FOR_MAINTENANCE', 'ВНИМАНИЕ: Сайт в настоящее время закрыт на техническое обслуживание');

define('PRODUCTS_PRICE_IS_FREE_TEXT', 'Это бесплатно!');
define('PRODUCTS_PRICE_IS_CALL_FOR_PRICE_TEXT', 'Цена по запросу');
define('TEXT_CALL_FOR_PRICE', 'Цена по запросу');

define('TEXT_INVALID_SELECTION', ' Вы выбрали неверный выбор: ');
define('TEXT_ERROR_OPTION_FOR', ' Вариант: ');
define('TEXT_INVALID_USER_INPUT', 'Требуется пользовательский ввод<br />');

// product_listing
define('PRODUCTS_QUANTITY_MIN_TEXT_LISTING', 'Минимум: ');
define('PRODUCTS_QUANTITY_UNIT_TEXT_LISTING', 'Единицы: ');
define('PRODUCTS_QUANTITY_IN_CART_LISTING', 'В корзину:');
define('PRODUCTS_QUANTITY_ADD_ADDITIONAL_LISTING', 'Добавить Дополнительные:');

define('PRODUCTS_QUANTITY_MAX_TEXT_LISTING', 'Максимум:');

define('TEXT_PRODUCTS_MIX_OFF', '*Смешанные ВЫКЛ.');
define('TEXT_PRODUCTS_MIX_ON', '*Смешанные ВКЛ.');

define('TEXT_PRODUCTS_MIX_OFF_SHOPPING_CART', '<br />*Вы не можете смешать варианты по этому пункту, чтобы соответствовать минимальным требованиям количества.*<br />');
define('TEXT_PRODUCTS_MIX_ON_SHOPPING_CART', '*Смешанные Варианты ВКЛ<br />');

define('ERROR_MAXIMUM_QTY', 'Количество добавленных в корзину был скорректировано из-за ограничения на разрешенный максимум . Смотреть этот пункт: ');
define('ERROR_CORRECTIONS_HEADING', 'Исправьте следующие, пожалуйста : <br />');
define('ERROR_QUANTITY_ADJUSTED', 'Количество добавленных в корзину было скорректировано. Товар, который вы хотели недоступен в дробных количествах. Количество товара: ');
define('ERROR_QUANTITY_CHANGED_FROM', ',был изменен от: ');
define('ERROR_QUANTITY_CHANGED_TO', ' до ');

// Downloads Controller
define('DOWNLOADS_CONTROLLER_ON_HOLD_MSG', 'Обратите внимание: скачивание не доступно, пока платеж не был подтвержден');
define('TEXT_FILESIZE_BYTES', ' байты');
define('TEXT_FILESIZE_MEGS', ' МБ');

// shopping cart errors
define('ERROR_PRODUCT', 'Товар: ');
define('ERROR_PRODUCT_STATUS_SHOPPING_CART', '<br />Извините, этот продукт был удален из нашей инвентаризации в этот раз.<br />Этот товар был удален из корзины.');
define('ERROR_PRODUCT_QUANTITY_MIN', ',  ... Ошибоки минимального количества  - ');
define('ERROR_PRODUCT_QUANTITY_UNITS', ' ... Ошибки количества единиц  - ');
define('ERROR_PRODUCT_OPTION_SELECTION', '<br /> ...Недопустимые значения выбранной опции');
define('ERROR_PRODUCT_QUANTITY_ORDERED', '<br /> Вы заказали всего: ');
define('ERROR_PRODUCT_QUANTITY_MAX', ' ...Ошибки максимальноего количества  - ');
define('ERROR_PRODUCT_QUANTITY_MIN_SHOPPING_CART', ', имеет ограничение минимального количества. ');
define('ERROR_PRODUCT_QUANTITY_UNITS_SHOPPING_CART', ' ...Ошибки количества единиц  - ');
define('ERROR_PRODUCT_QUANTITY_MAX_SHOPPING_CART', ' ... Ошибки максимального количества - ');

define('WARNING_SHOPPING_CART_COMBINED', 'Обратите внимание: для Вашего удобства, ваша текущая корзина была совмещена с корзиной из Вашего последнего визита. Проверьте корзину перед оплатой');

// error on checkout when $_SESSION['customers_id' does not exist in customers table
define('ERROR_CUSTOMERS_ID_INVALID', 'Информация клиента не может быть проверен! <br />Пожалуйста, войдите или воссоздать свой счет ...');
define('HOT_PRODUCTS','Популярные товары');
define('TABLE_HEADING_FEATURED_PRODUCTS', 'Хит продаж');

define('TABLE_HEADING_NEW_PRODUCTS', 'Новые Продукты Для %s');
define('TABLE_HEADING_UPCOMING_PRODUCTS', 'Ожидаемые Продукты');
define('TABLE_HEADING_DATE_EXPECTED', 'Ожидаемая дата');
define('TABLE_HEADING_SPECIALS_INDEX', 'Месячные скидки для %s');

define('CAPTION_UPCOMING_PRODUCTS', 'Эти товары будут в наличии в ближайшее время');
define('SUMMARY_TABLE_UPCOMING_PRODUCTS', 'Таблица содержит список продуктов, которые должны быть в наличии в ближайшее время и нужные ожидаемые предметы');

// meta tags special defines
define('META_TAG_PRODUCTS_PRICE_IS_FREE_TEXT', 'Это бесплатно!');
//meta_tags  新模板 2016-9-26 frankie
//模块
define('MODEL_META_DES_03', 'на FS.COM! Пожизненная гарантия, ROHS, 100% тестирование совместимости, OEM/ODM заказ.');

//跳线
define('FIBER_META_DES_02', 'на FS.COM! 100% оптически тестирование перед отгрузкой с пожизненной гарантией. Заказной сервис доступен.');

//其他
define('OTHER_META_DES_02', 'на FS.COM! Конкурентоспособная цена и первоклассное обслуживание для Вас!');

// customer login
define('TEXT_SHOWCASE_ONLY', 'Контакт');
// set for login for prices
define('TEXT_LOGIN_FOR_PRICE_PRICE', 'Цена Недоступна');
define('TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE', 'Логин для цена');
// set for show room only
define('TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM', ''); // blank for prices or enter your own text
define('TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE_SHOWROOM', 'Только Показать Номер');

// authorization pending
define('TEXT_AUTHORIZATION_PENDING_PRICE', 'Цена Недоступна');
define('TEXT_AUTHORIZATION_PENDING_BUTTON_REPLACE', 'В ОЖИДАНИИ УТВЕРЖДЕНИЯ');
define('TEXT_LOGIN_TO_SHOP_BUTTON_REPLACE', 'Вход в магазин');

// text pricing
define('TEXT_CHARGES_WORD', 'Рассчитанные Затраты:');
define('TEXT_PER_WORD', '<br />Цена за слово: ');
define('TEXT_WORDS_FREE', ' Слово(а) бесплатно ');
define('TEXT_CHARGES_LETTERS', 'Рассчитанные Затраты:');
define('TEXT_PER_LETTER', '<br />Цена за письмо: ');
define('TEXT_LETTERS_FREE', ' Буква(ы) бесплатно ');
define('TEXT_ONETIME_CHARGES', '*разовые сборы = ');
define('TEXT_ONETIME_CHARGES_EMAIL', "\t" . '*разовые сборы = ');
define('TEXT_ATTRIBUTES_QTY_PRICES_HELP', 'Вариант скидки с количеством ');
define('TABLE_ATTRIBUTES_QTY_PRICE_QTY', 'Кол-во');
define('TABLE_ATTRIBUTES_QTY_PRICE_PRICE', 'Цена');
define('TEXT_ATTRIBUTES_QTY_PRICES_ONETIME_HELP', 'Вариант Скидки с количеством Разовых Сборов');

// textarea attribute input fields
define('TEXT_MAXIMUM_CHARACTERS_ALLOWED', ' разрешенное максимальное количество символов');
define('TEXT_REMAINING', 'оставшиеся');

// Shipping Estimator
define('CART_SHIPPING_OPTIONS', 'Расчетная стоимость пересылки');
define('CART_SHIPPING_OPTIONS_LOGIN', 'Пожалуйста <a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '"><span class="pseudolink">войдите в систему</span></a>,чтобы увидеть ваши личные расходы по доставке.');
define('CART_SHIPPING_METHOD_TEXT', 'Доступные Способы Доставки');
define('CART_SHIPPING_METHOD_RATES', 'Ставки');
define('CART_SHIPPING_METHOD_TO', 'Доставить: ');
define('CART_SHIPPING_METHOD_TO_NOLOGIN', 'Доставить: <a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '"><span class="pseudolink">Войти</span></a>');
define('CART_SHIPPING_METHOD_FREE_TEXT', 'Бесплатная Доставка');
define('CART_SHIPPING_METHOD_ALL_DOWNLOADS', '- Загрузки');
define('CART_SHIPPING_METHOD_RECALCULATE', 'Пересчитывать');
define('CART_SHIPPING_METHOD_ZIP_REQUIRED', 'правда');
define('CART_SHIPPING_METHOD_ADDRESS', 'Адрес:');
define('CART_OT', 'Общая Сметная:');
define('CART_OT_SHOW', 'правда'); // set to false if you don't want order totals
define('CART_ITEMS', 'Товары в корзину: ');
define('CART_SELECT', 'Выберите');
define('ERROR_CART_UPDATE', '<strong>Обновите Ваш заказ, пожалуйста.</strong> ');
define('IMAGE_BUTTON_UPDATE_CART', 'Обновить');
define('EMPTY_CART_TEXT_NO_QUOTE', 'Упс! Ваша сессия истекла ... Обновите Вашу корзину для предложения доставки, пожалуйста...');
define('CART_SHIPPING_QUOTE_CRITERIA', 'Предложение доставки зависит от адресной информации, которую Вы выбрали:');

// multiple product add to cart
define('TEXT_PRODUCT_LISTING_MULTIPLE_ADD_TO_CART', 'Добавить: ');
define('TEXT_PRODUCT_ALL_LISTING_MULTIPLE_ADD_TO_CART', 'Добавить:');
define('TEXT_PRODUCT_FEATURED_LISTING_MULTIPLE_ADD_TO_CART', 'Добавить: ');
define('TEXT_PRODUCT_NEW_LISTING_MULTIPLE_ADD_TO_CART', 'Добавить: ');
//moved SUBMIT_BUTTON_ADD_PRODUCTS_TO_CART to button_names.php as BUTTON_ADD_PRODUCTS_TO_CART_ALT

// discount qty table
define('TEXT_HEADER_DISCOUNT_PRICES_PERCENTAGE', 'Кол-Во Скидка Ваша Цена');
define('TEXT_HEADER_DISCOUNT_PRICES_ACTUAL_PRICE', 'Кол-Во Новая цена со скидкой');
define('TEXT_HEADER_DISCOUNT_PRICES_AMOUNT_OFF', 'Кол-Во Скидка');
define('TEXT_FOOTER_DISCOUNT_QUANTITIES', '* Скидки могут отличаться в зависимости от вариантов выше');
define('TEXT_HEADER_DISCOUNTS_OFF', 'Кол-Во Скидки Недоступны ...');

// sort order titles for dropdowns
define('PULL_DOWN_ALL_RESET', '- Сброс - ');
define('TEXT_INFO_SORT_BY_PRODUCTS_NAME', 'Наименование Товара');
define('TEXT_INFO_SORT_BY_PRODUCTS_NAME_DESC', 'Наименование товара - по убыванию');
define('TEXT_INFO_SORT_BY_PRODUCTS_PRICE', 'Цена - с низкой до высокой');
define('TEXT_INFO_SORT_BY_PRODUCTS_PRICE_DESC', 'Цена - от высокой к низкой');
define('TEXT_INFO_SORT_BY_PRODUCTS_MODEL', 'Модель');
define('TEXT_INFO_SORT_BY_PRODUCTS_DATE_DESC', 'Дата добавленная - от новой к старой');
define('TEXT_INFO_SORT_BY_PRODUCTS_DATE', 'Дата добавленная - от старой к новой ');
define('TEXT_INFO_SORT_BY_PRODUCTS_SORT_ORDER', 'Дисплей По Умолчанию');

// downloads module defines
define('TABLE_HEADING_DOWNLOAD_DATE', 'Ссылка Истекает');
define('TABLE_HEADING_DOWNLOAD_COUNT', 'Оставшиеся');
define('HEADING_DOWNLOAD', 'Для загрузки файлов нажмите кнопку "Загрузить" и выберите "Сохранить на диск" из контекстного меню.');
define('TABLE_HEADING_DOWNLOAD_FILENAME', 'Имя файла');
define('TABLE_HEADING_PRODUCT_NAME', 'Наименование пункта');
define('TABLE_HEADING_BYTE_SIZE', 'Размер файла');
define('TEXT_DOWNLOADS_UNLIMITED', 'Неограниченный');
define('TEXT_DOWNLOADS_UNLIMITED_COUNT', '--- *** ---');

// misc
define('COLON_SPACER', ':&nbsp;&nbsp;');

// table headings for cart display and upcoming products
define('TABLE_HEADING_QUANTITY', 'Кол-Во.');
define('TABLE_HEADING_PRODUCTS', 'Наименование товара');
define('TABLE_HEADING_TOTAL', 'Итого');

// create account - login shared
define('TABLE_HEADING_PRIVACY_CONDITIONS', 'Заявление О Конфиденциальности');
define('TEXT_PRIVACY_CONDITIONS_DESCRIPTION', 'Подтвердите, пожалуйста, что вы согласны с нашим заявлением о конфиденциальности, поставив галочку в следующем окне. Заявление о конфиденциальности можно прочитать <a href="' . zen_href_link(FILENAME_PRIVACY, '', 'SSL') . '"><span class="pseudolink">здесь</span></a>.');
define('TEXT_PRIVACY_CONDITIONS_CONFIRM', 'Я прочитал содержание и согласен с Вашим заявлением о конфиденциальности.');
define('TABLE_HEADING_ADDRESS_DETAILS', 'Адресные Данные');
define('TABLE_HEADING_PHONE_FAX_DETAILS', 'Дополнительные Контактные Данные');
define('TABLE_HEADING_DATE_OF_BIRTH', 'Подтвердить Ваш Возраст');
define('TABLE_HEADING_LOGIN_DETAILS', 'Регистрационные Данные');
define('TABLE_HEADING_REFERRAL_DETAILS', 'Were You Referred to Us?');

define('ENTRY_EMAIL_PREFERENCE', 'Рассылки и Электронная почта');
define('ENTRY_EMAIL_HTML_DISPLAY', 'HTML');
define('ENTRY_EMAIL_TEXT_DISPLAY', 'ТЕКСТ-только');
define('EMAIL_SEND_FAILED', 'ERROR: Сбой отправки по электронной почте: "%s" <%s> на тему: "%s"');

define('DB_ERROR_NOT_CONNECTED', 'Ошибка - не удалось подключиться к базе данных');

// EZ-PAGES Alerts
define('TEXT_EZPAGES_STATUS_HEADER_ADMIN', 'ВНИМАНИЕ: EZ-страницы заголовка - только для IP Админ');
define('TEXT_EZPAGES_STATUS_FOOTER_ADMIN', 'ВНИМАНИЕ: EZ-страницы Нижний КОЛОНТИТУЛ - только для IP Админ');
define('TEXT_EZPAGES_STATUS_SIDEBOX_ADMIN', 'ВНИМАНИЕ: EZ-страницы SIDEBOX - только для IP Админ');

// extra product listing sorter
define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER', '');
define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER_NAMES', 'Элементы, начиная с ...');
define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER_NAMES_RESET', '-- Сброс --');

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
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_CREDIT_CARDS);

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

define('FIBERSTORE_VIEW_MORE', 'Больше...');
define('FIBERSTORE_WISHLIST_ADD_TO_CART', 'Добавить В Корзину');
define('FIBERSTORE_MESSAGE_ADD_TO_WISHLIST_SUCCESS', 'Удалось добавить в Список Пожеланий');
define('FIBERSTORE_DELETE', 'Удалить');
define('FIBERSTORE_PRICE', 'Цена');
define('FIBERSTORE_VIEW_MORE_ORDERS', 'Все заказы »');
define('FIBERSTORE_ORDER_IMAGE', ' Фото продуктов');
define('FIBERSTORE_POST', 'Почта');
define('FIBERSTORE_CANCEL_ORDER', 'Отменить заказ');
define('FIBERSTORE_PRODTCTS_DETAILS', 'Детали Продуктов');

define('FIBERSTORE_OEM_CUSTOM', 'OEM & Клиенты');
define('FIBERSTORE_ANY_TYPE', 'Любой тип');
define('FIBERSTORE_ANY_LENGTH', 'Любая Длина');
define('FIBERSTORE_ANY_COLOR', 'Любой Цвет');
define('FIBERSTORE_WORK_PROJECT', 'Давайте поработаем с Вами на Ваш пользовательский проект');

define('TEXT_OPTION_DIVIDER', '&nbsp;-&nbsp;');
define('HPE_LIMIT', 'Из-за его специального материала, выберите "VAL_XXX" совместимость для Вашего заказа, и заполните модель оборудования пожалуйста.');
define('HPE_LIMIT2', 'Совместимости 《VAL_XXX》 не доступно для вашего заказа из-за особенности материала.');

/*此语言包不要翻译*/
define('TEXT_PREFIX', 'text_prefix_');
/*  end*/
// LANGUAGE FOR COMMON FOOTER

define('FOOTER_TIT_FIR', 'Поддержки Fiberstore');
define('FOOTER_FILENAME_SUPPORT', 'Подробнее »');
define('FOOTER_MTP_HREF', 'MTP / MPO Компоненты подключения');
define('FOOTER_MTP_CON', 'MTP/MPO волоконно-системы являются по-настоящему товаром инновационной группы как мульти-волокна ...');
define('FOOTER_TIT_SEC', 'Отзывы Клиентов');
define('FOOTER_CON_SEC', 'Мы купили несколько Мux, DWDM XFP и SFP на Fiberstore, которые до сих пор ещё работают отлично. Я знаю, что много ISPS также используют оборудования здесь.<i></i><b>-- Angryceo</b>');
define('FOOTER_TIT_TIR', 'Новости');
define('FOOTER_PAGE_SEA', 'Популярные Страницы:');
define('FOOTER_SHARE_TIT', 'Добро Пожаловать Присоединиться К Нашему Сообществу:');

define('FOOTER_ABOUT_TIR4', 'Все права защищены.');
define('FOOTER_ABOUT_TIR5', 'Конфиденциальность.');
define('FOOTER_ABOUT_TIR6', 'Условия использования.');
//FOOTER END
//HEADER LIVE


//HEADER END
//live chat
define('LIVE_CHAT_TIT', 'Получить Все Поддержки для Покупки');
define('LIVE_CHAT_TIT1', 'Профессиональный Сервис & Поддержка доступна тремя разными способами');
define('LIVE_CHAT_TIT2', 'Fiberstore удалось получить Ваше сообщение, спасобо!');
define('LIVE_CHAT_CON1', 'Чат онлайн на Fiberstore');
define('LIVE_CHAT_CON2', 'Связаться с нами и сразу получить соответствующую информацию.');
define('LIVE_CHAT_CON3', '8 утра. до Полуночи ТСВ Пн. по Пт.');
define('LIVE_CHAT_CON4', 'Оставьте нам сообщение, мы ответим Вам как можно скорее.');
define('LIVE_CHAT_CON5', 'Оставить Сообщение');
define('LIVE_CHAT_CON6', 'Написать Email');
define('LIVE_CHAT_CON7', 'Ответ Не Позднее 12 Часов');
define('LIVE_CHAT_CON8', 'Отправить запрос и получить быстрый ответ от Fiberstore.');
define('LIVE_CHAT_CON9', ' E-mail    ');
define('LIVE_CHAT_CON91', 'Телефон: +1-425-226-2035');
define('LIVE_CHAT_CON10', 'Доступны');
define('LIVE_CHAT_CON11', 'Недоступно');
define('LIVE_CHAT_CON12', 'Позвонить');
define('LIVE_HEAD_CON1', 'Или нажмите на кнопку ниже, чтобы мы вам позвонили.<br /> 8 утра.- 5 вечера. CEDT.  Пн. по Пт.');
define('LIVE_HEAD_CON2', 'Или нажмите на кнопку ниже, чтобы мы вам позвонили.<br /> 8 утра.- 5 вечера. EST.  Пн. по Пт.');
define('LIVE_HEAD_CON3', 'Или нажмите на кнопку ниже, чтобы мы вам позвонили.<br /> 8 утра.- 5 вечера. BST.  Пн. по Пт.');
define('LIVE_HEAD_CON4', 'Или нажмите на кнопку ниже, чтобы мы вам позвонили.<br />8 утра.- 5 вечера. PST.  Пн. по Пт.');
define('LIVE_CHAT_HTML', 'Офлайн');

//live chat end
//left_slide_bar
define('LEFT_SLIDE_TIT1', 'О Компании');
define('LEFT_SLIDE_TIT2', 'Обслуживания');
define('LEFT_SLIDE_TIT3', 'Платёж & Доставки');
define('LEFT_SLIDE_TIT4', 'Быстрая Помощь');
define('LEFT_SLIDE_CON1', 'Контакты');
define('LEFT_SLIDE_CON2', 'О Fiberstore');
define('LEFT_SLIDE_CON3', 'Почему Нам');
define('LEFT_SLIDE_CON4', 'Новости');
define('LEFT_SLIDE_CON5', 'Бизнес-Счет');
define('LEFT_SLIDE_CON6', 'Карта Сайта');
define('LEFT_SLIDE_CON7', 'OEM & Пользовательские');
define('LEFT_SLIDE_CON8', 'Контроль Качества');
define('LEFT_SLIDE_CON9', 'Стандарт ИСО');
define('LEFT_SLIDE_CON10', 'Гарантия');
define('LEFT_SLIDE_CON11', 'RMA Решение');
define('LEFT_SLIDE_CON12', 'Политика возврата и замены товара');
define('LEFT_SLIDE_CON13', 'Гарантия возврата денег');
define('LEFT_SLIDE_CON14', 'Способы Платёжа');
define('LEFT_SLIDE_CON15', 'Net 30 & W9');
define('LEFT_SLIDE_CON16', 'Руководство по Перевозке');
define('LEFT_SLIDE_CON17', 'Доставка & Отгрузка');
define('LEFT_SLIDE_CON18', 'Помощь при Покупке');
define('LEFT_SLIDE_CON19', 'ЧАВО');
//left_slide_bar_end
//TPL INDEX
define('FIBERSTORE_SHOPPING_HELP', 'Ваша корзина пуста.');
define('FIBERSTORE_INDEX_HELP', '<dd><b>Как Вам помочь<br />сегодня?</b><i>Чат Онлайн Сейчас</i></dd>');
define('FIBERSTORE_INDEX_SIDER', '<p class="sidebar_03_02 "><b>Партнерская Программа</b> Растет Ваш Бизнес</p>');
define('FIBERSTORE_INDEX_SIDER1', '<p class="sidebar_03_02 "><b>Международная Доставка</b> Глобальная Доставка от 2 до 3 дней  Доставка по всему миру</p>');
define('FIBERSTORE_INDEX_SIDER2', '<p class="sidebar_03_02"><b>Стандарт ISO</b> Ориентирован на качество и точность</p>');
define('FIBERSTORE_INDEX_SIDER3', '<p class="sidebar_03_02"><b>Способ Оплаты</b> Безопасного Платежа</p>');
define('FIBERSTORE_INDEX_SIDER4', '<p class="sidebar_03_02"><b>Пожизненная Гарантия</b>При Нормальном Использовании</p>');
define('FIBERSTORE_INDEX_OEM', '<span class="oem_02">OEM &amp;Пользовательский</span> <span class="oem_03 "><ul><li>Любой продукт </li><li>Любой размер</li><li>Любой тип</li><li>Любой цвет</li></ul></span> <span class="oem_03 oem_04">Отличное Качество  &  Сервис удовлетворяют все Ваши требования</span>');
//wholesale
define('FS_ADD', 'Добавить...');
define('FS_WAIT', 'Подождите...');


//INDEX END
//2016-5-19新增一级分类
define('FIBERSTORE_TRANS1', 'Искать по Сетевым Устройствам');
define('FIBERSTORE_TRANS2', 'Искать по Оригинальным Модулям');
define('FIBERSTORE_TRANS3', 'Оптические Патч-Корды</h1>
      </div>
      <div class="title_small">FS.COM поставляет высококачественные оптические кабельные сборки, в частности, Патч-Корды, Пигтейлы, Mode Conditioning Патч-Корды, Breakout Кабели и др. Все наши оптические кабели доступны по заказным вариантам: Одномодовые 9/125, Многомодовые 62.5/125 OM1, Многомодовые 50/125 OM2 и Многомодовые 10 Гигабитные 50/125 OM3/OM4 волокна. </div>
      
      <div class="sidebar_find">
          <span>Популярные Оптические Кабели');
define('FIBERSTORE_TRANS4', 'Выбор по Разъёмам');
define('FIBERSTORE_TRANS5', 'Все Оптические Кабельные Сборки');
define('FIBERSTORE_TRANS6', 'Выбор по Категориям');

//2016-5-19客户中心支付按钮
define('FIBERSTORE_HSBC1', 'Содержание Заказа');
define('FIBERSTORE_HSBC2', 'Номер Заказа');
define('FIBERSTORE_HSBC3', 'Общая Сумма');
define('FIBERSTORE_HSBC4', 'Предмет(ы)');
define('FIBERSTORE_HSBC5', 'Способ Доставки');
define('FIBERSTORE_HSBC6', 'Дата Заказа');
define('FIBERSTORE_HSBC7', 'Способ Оплаты: Банковский Перевод');
define('FIBERSTORE_HSBC8', 'Информация Бенефициара Банковского Перевода');
define('FIBERSTORE_HSBC9', 'Название Банка-Получателя:</th>
                      <td valign="top">HSBC Hong Kong</td>
                    </tr>
                    <tr>
                      <th valign="top">Наименование Счета Бенефициара: </th>
                      <td valign="top">FIBERSTORE CO., LIMITED</td>
                    </tr>
                    <tr>
                      <th valign="top">Номер Счета Бенефициара:</th>
                      <td valign="top">817-498231-838</td>
                    </tr>
                    <tr>
                      <th valign="top">СВИФТ-Код:</th>
                      <td valign="top">HSBCHKHHHKH</td>
                    </tr>
                    <tr>
                      <th valign="top">Адрес Банка-Получателя:</th>
                      <td valign="top">1 Queen\'s Road Central, Hong Kong</td>
                    </tr>
                    <tr>
                      <th valign="top">Адрес Нашей Компании:</th>
                      <td valign="top">Eastern Side, Second Floor, Science &amp; Technology Park, No.6, Keyuan Road, Nanshan District, Shenzhen, China');
define('FIBERSTORE_HSBC10', 'Заполните Вашу Информацию Банковского Перевода');
define('FIBERSTORE_HSBC11', 'ФИО Плательщика');
define('FIBERSTORE_HSBC12', 'Заполните полное название, которое Вы используете для банковского перевода, либо физическое лицо или компания');
define('FIBERSTORE_HSBC13', 'Страна');
define('FIBERSTORE_HSBC14', 'Выберите');
define('FIBERSTORE_HSBC15', 'Выберите Вашу страну.');
define('FIBERSTORE_HSBC16', 'Сумма Платежа');
define('FIBERSTORE_HSBC17', 'Поле «Сумма Платежа» обязательно. Напр.: $29.22 или € 29.22 или 29.22(По умолчанию $)');
define('FIBERSTORE_HSBC18', 'Время Оплаты');
define('FIBERSTORE_HSBC19', 'Поле «Время Оплаты» обязательно (Напр.: 2014-6-12)');
define('FIBERSTORE_HSBC20', 'Номер Телефона Плательщика');
define('FIBERSTORE_HSBC21', 'Номер телефона должен быть действительным, по которому мы можем связаться с Вами в случае необходимости');
define('FIBERSTORE_HSBC22', 'Отправить');
define('FIBERSTORE_HSBC23', 'Способ Оплаты');
define('FIBERSTORE_HSBC24', 'Существующие PayPal пользователи могут совершить платеж через ваш PayPal счет</span> 
     <p>Новые пользователи могут сначала зарегистрировать PayPal счет, и потом продолжить платёж на веб-сайте PayPal.<br />
    Примечание: Вы можете переводить нам деньги напрямую на PayPal, наш счет: paypal@fs.com.');
define('FIBERSTORE_HSBC25', 'Перейти к Paypal');
//2016-5-20.推广文章页面

//2016-5-19客户中心支付按钮
define('FIBERSTORE_HSBC1', 'Содержание Заказа');
define('FIBERSTORE_HSBC2', 'Номер Заказа');
define('FIBERSTORE_HSBC3', 'Общая Сумма');
define('FIBERSTORE_HSBC4', 'Предмет(ы)');
define('FIBERSTORE_HSBC5', 'Способ Доставки');
define('FIBERSTORE_HSBC6', 'Дата Заказа');
define('FIBERSTORE_HSBC7', 'Способ Оплаты: Банковский Перевод');
define('FIBERSTORE_HSBC8', 'Информация Бенефициара Банковского Перевода');
define('FIBERSTORE_HSBC9', 'Название Банка-Получателя:</th>
                      <td valign="top">HSBC Hong Kong</td>
                    </tr>
                    <tr>
                      <th valign="top">Наименование Счета Бенефициара: </th>
                      <td valign="top">FIBERSTORE CO., LIMITED</td>
                    </tr>
                    <tr>
                      <th valign="top">Номер Счета Бенефициара:</th>
                      <td valign="top">817-498231-838</td>
                    </tr>
                    <tr>
                      <th valign="top">СВИФТ-Код:</th>
                      <td valign="top">HSBCHKHHHKH</td>
                    </tr>
                    <tr>
                      <th valign="top">Адрес Банка-Получателя:</th>
                      <td valign="top">1 Queen\'s Road Central, Hong Kong</td>
                    </tr>
                    <tr>
                      <th valign="top">Адрес Нашей Компании:</th>
                      <td valign="top">Eastern Side, Second Floor, Science &amp; Technology Park, No.6, Keyuan Road, Nanshan District, Shenzhen, China');
define('FIBERSTORE_HSBC10', 'Заполните Вашу Информацию Банковского Перевода');
define('FIBERSTORE_HSBC11', 'ФИО Плательщика');
define('FIBERSTORE_HSBC12', 'Заполните полное название, которое Вы используете для банковского перевода, либо физическое лицо или компания');
define('FIBERSTORE_HSBC13', 'Страна');
define('FIBERSTORE_HSBC14', 'Выберите');
define('FIBERSTORE_HSBC15', 'Выберите Вашу страну.');
define('FIBERSTORE_HSBC16', 'Сумма Платежа');
define('FIBERSTORE_HSBC17', 'Поле «Сумма Платежа» обязательно. Напр.: $29.22 или € 29.22 или 29.22(По умолчанию $)');
define('FIBERSTORE_HSBC18', 'Время Оплаты');
define('FIBERSTORE_HSBC19', 'Поле «Время Оплаты» обязательно (Напр.: 2014-6-12)');
define('FIBERSTORE_HSBC20', 'Номер Телефона Плательщика');
define('FIBERSTORE_HSBC21', 'Номер телефона должен быть действительным, по которому мы можем связаться с Вами в случае необходимости');
define('FIBERSTORE_HSBC22', 'Отправить');
define('FIBERSTORE_HSBC23', 'Способ Оплаты');
define('FIBERSTORE_HSBC24', 'Существующие PayPal пользователи могут совершить платеж через ваш PayPal счет</span> 
     <p>Новые пользователи могут сначала зарегистрировать PayPal счет, и потом продолжить платёж на веб-сайте PayPal.<br />
    Примечание: Вы можете переводить нам деньги напрямую на PayPal, наш счет: paypal@fs.com.');
define('FIBERSTORE_HSBC25', 'Перейти к Paypal');

//2016-6-16 订单确认页面 ,货到付款弹窗 （checkout）
define('FS_CHECKOUT_FREIGHT', 'Фрахт оплачивается покупателем в порту назначения');
define('FS_CHECKOUT_SHIPPING_METHOD', 'Способ Доставки :');
define('FS_CHECKOUT_EXPRESS_ACCOUNT', 'Express Аккаунт :');
define('FS_CHECKOUT_SUBMIT', 'Отправить');
define('FS_CHECKOUT_ORDER_REMARKS', 'Замечания Заказа');
define('FS_CHECKOUT_ORDER_ADVISE', 'Сообщите артикул моделя вашего оборудования для уточнения совместимости, пожалуйста.');
define('FS_CHECKOUT_REMARKS', 'Если есть дополнительные требования для доставки заказа, упаковки товара или другой информации, напишите их в окне замечания, пожалуйста. И это будет полезно для обработки заказа.');

//tpl_header.php   melo


//tpl_fiber_optic_patch_cable.php   fallwind
define('FS_CLEAR_SELECTIONS', 'Удалить Выбор');
define('FS_AVAILABLE', 'Доступны');
define('FS_ESTIMATED_THE_NEXT_DAY', 'Почти на второй день');
define('FS_ORDERS_RECEIVED', 'Заказы, оформленные в 1:00 дня PST (тихоокеанское поясное время) по пн-пт (за исключением праздничных дней) будут отправлены на следующий рабочий день.');
define('FS_THERE_MAY_BE_SOME', 'Может быть некоторая разница между расчетным временем и фактическим временем.');
define('FS_YOUR_PRICE', 'Цена:');
define('FS_QUANTITY', 'Кол-во:');
define('FS_ADD_TO_CART', 'В Корзину');
define('FS_PREVIOUS', 'Пред');
define('FS_NEXT', 'След');
define('FS_APPLICATION', 'применение');

//2016-8-3 frankie 
define('SHORT_DES', 'Оптические Патч-Корды');
define('SHORT_TEXT', 'FS.COM поставляет высококачественные оптические кабельные сборки, как патчкорды, пигтейлы, MCPs,   breakout кабели и т.д. Волокна всех наших оптических кабелей доступны по выборам одномодовым 9/125, многомодовым 62.5/125 OM1, многомодовым 50/125 OM2 и многомодовым10 Гбит 50/125 OM3/ОМ4');

//tpl_account_history_info_default.php   fallwind  2016.8.5-16
define('FS_DAYS', 'дни');

//2016-8-11 frankie
define('FS_GET_QUOTE1', 'Быстрый Запрос');
define('FS_GET_QUOTE2', 'Заполните и отправьте следующую информацию, пожалуйста, чтобы наши соответственные работники сразу разрешат ваш вопрос.');
define('FS_GET_QUOTE3', 'Заполните обязательные поля ниже, и наш профессиональный консультант-продавец скоро свяжется с Вами за 12 часов.');
define('FS_GET_QUOTE4', 'ФИО:');
define('FS_GET_QUOTE5', 'Адрес Почты:');
define('FS_GET_QUOTE6', 'Страна:');
define('FS_GET_QUOTE7', 'О Чем:');

define('FS_REGARDING1', 'Выберите');
define('FS_REGARDING2', 'Заказы');
define('FS_REGARDING3', 'Оптовая Цена');
define('FS_REGARDING4', 'Платёж');
define('FS_REGARDING5', 'Срок Поставки');
define('FS_REGARDING6', 'Гарантия');
define('FS_REGARDING7', 'Послепродажное');
define('FS_REGARDING8', ' Технологическое Решение');
define('FS_REGARDING9', 'Описание Изделия ');
define('FS_REGARDING10', 'Общая Информация ');

define('FS_GET_QUOTE8', 'Номер Телефона:');
define('FS_GET_QUOTE9', 'Тема Сообщения:');
define('FS_GET_QUOTE10', 'Отправить');

define('FS_GET_QUOTE11', 'Убедитесь, что Вы заполнили ваше имя.');
define('FS_GET_QUOTE12', 'Введенный адрес электронной почты не идентифицирован. (Пример: someone@example.com).');
define('FS_GET_QUOTE13', 'Введите действующий телефонный номер.');
define('FS_GET_QUOTE14', 'Введите Ваш вопрос, пожалуйста.');
define('FS_GET_QUOTE15', 'Ваше сообшение принято, спасибо!');
define('FS_GET_QUOTE16', 'К сожалению, Вы были добавлены в черный список!');
define('FS_GET_QUOTE17', 'Убедитесь, что Вы выбирали вашу страну.');
define('FS_GET_QUOTE18', 'Ваш номер телефона должен быть не менее 7 цифр.');
define('FS_GET_QUOTE19', 'Обработка');

//Content  in  order  page
// 2016-9-8  add by  frankie 
define('ALL_ORDER', 'Все заказы');
define('UNPAID_ORDER', 'Отложенные Заказы');
define('TRADING_ORDERS', 'Заказы Сделки');
define('CLOSED_ORDERS', 'Отмененные Заказы');

define('FIBERSTORE_QUESTION', 'Вопрос успешно представлен');
define('FIBERSTORE_ORDER_PRIVATE', 'Частные Заказы');
define('FIBERSTORE_ORDER_COMPANY', 'Все заказы для этой компании');
define('FIBERSTORE_ORDER_SELECT', 'Выберите по порядку Дату');
define('PLEASE', 'Пожалуйста, выберите');
define('WEEK', 'Последняя Неделя');
define('MONTH', 'Последний Месяц');
define('THREE_MONTH', 'Последние Три Месяца');
define('FIBERSTORE_ORDER_ENTER', 'Введите Номер Вашего заказа');
define('FIBERSTORE_ORDER_NO', 'Номер заказа');
define('SEARCH', 'Поиск');
define('FIBERSTORE_ORDER_PROMT', 'НЕ НАЙДЕНЫ ЗАКАЗЫ.');
define('FIBERSTORE_ORDER_PICTURE', 'Фото Продуктов');
define('FIBERSTORE_ORDER_DATE', 'Дата Заказа');
define('CANCELED', 'Заказ oтменён');
define('FIBERSTORE_ORDER_OPERATE', 'Работать');
define('FIBERSTORE_VIEW_DETAILS', 'Смотреть Подробности');
define('PREVIOUS', 'Предыдущие');
define('NEXT', 'Далее');
define('PAYMENT', 'Оплата');
define('FIBERSTORE_ORDER_PAGE', '');
define('FIBERSTORE_ORDER_OF', '/');
define('FS_LEARN_MORE', 'Подробнее');
define('CONNECTING_PAYPAL', 'Подключение к PayPal');
define('ARE_YOU_SURE', 'Вы уверены, что отменить заказ?');
define('ONCE_YOU_DO', 'Как только вы это сделаете, оно не может быть восстановлено.');
define('HOWEVER', 'Тем не менее, если вы на самом деле означает, предоставьте нам причину (ы) для отмены, пожалуйста.');
define('EXPENSIVE', 'Дорогой фрахт');
define('DUPLICATE', 'Дублировать заказ');
define('FAILING', 'Сбой оплаты');
define('WRONG', 'Неправильное написание информации');
define('OUT', 'В наличии нет');
define('NO_NEED', 'Не надо');
define('OFFLINE', 'Оффлайн сделка');
define('FIBERSTORE_ORDER_CONFIRM', 'Подтвердить');
define('OTHERS', 'Другие');
define('BEFORE_SUBMITTING', 'Перед отправкой,заполните причины для отмены заказа, пожалуйста');
define('CANCEL', 'Отмена');
define('FS_CANCEL', 'Отмена');

//fallwind	2016.9.9	add
define('FIBERSTORE_PROCESSING', 'Обработка');
define('FIBERSTORE_LIVE_CHAT', 'Чат Онлайн');
define('FIBERSTORE_EDIT_CART', 'В Корзину');
define('FIBERSTORE_ALL_RIGHTS_RESERVED', 'Все Права Защищены');
//分类 搜索公用常量 公用常量，不要随意删除
define('FIBERSTORE_IMAGES', 'Картинки');
define('FIBERSTORE_DETAILS', 'Детали');
define('FIBERSTORE_SHOWING', 'Показать');
define('FIBERSTORE_RESULTS_BY', ' результатов по ');
define('FIBERSTORE_OF', '');
define('FIBERSTORE_YOUR_PRICE', 'Цена');
define('FIBERSTORE_QUANTITY', 'Кол-во');
define('FIBERSTORE_ADD_TO_CART', 'В Корзину');
define('FS_CUSTOM', 'Заказать');
define("FIBERSTORE_PRODUCTS","шт. ");
define("FIBERSTORE_PRODUCT","шт. ");
define("FIBERSTORE_RESULTS_BY01","Сначала :");
define("FIBERSTORE_RESULTS_VIEW","Показать :");
define("FIBERSTORE_RESULTS_VIDEO","Видео");


define('FS_COMMON_CLEAR', 'Вычеркнуть Выборы');
define('FS_COMMON_COMPLIANT', 'Соответствует IEEE 802.3z стандартам для приложений Fast Ethernet и Gigabit Ethernet');
define('FS_COMMON_ADD', 'Добавить');
define('FS_COMMON_ADDED', 'Добавлен');
define('FS_COMMON_PROCESSING', 'Обработанные');
define('FS_COMMON_PLEASE_WAIT', 'Подождите');
define('FS_COMMON_PRODUCT', 'Быстрый Просмотр Товара');
define('FS_COMMON_NEXT', 'След');
define('FS_COMMON_PREVIOUS', 'Пред');
define('FS_PRICE_LOW_HIGH', 'дешевле');
define('FS_PRICE_HIGH_LOW', 'дороже');
define('FS_RATE_HOGH', 'с высоким рейтингом');
define('FS_NEWEST_FIRST', 'новинки');
define('FS_POPULARITY', 'популярные');
//update 2016.10.27 frankie
define('FS_QUICK_VIEW', 'Быстрый Просмотр Товара');
define('FS_WAIT', 'Подождите, пожалуйста');
//update 2016.12.5 frankie
define('FS_VERIFIED_PUR', 'Проверенная Покупка');
define('FS_COMMENTS', 'Комментариев');
define('FS_SUBMIT', 'Отправить');
define('FS_REVIEWS9', 'От ');
define('FS_REVIEWS26', ',');
define('FS_REVIEWS10', 'Опубликовать');
define('FS_REVIEWS11', 'Комментарий');
define('FS_DELETE','Удалить');
define('FIBERSTORE_POPUP_SUCCEED', 'Изображение Клиента изменено.');
define('FIBERSTORE_POPUP_FAILURE', 'Файл слишком велик!');
/****************end 公用常量****************/


//module shipping   运费模块 
define('FS_SHIP_ORDER', 'К Стране');
define('FS_CHOOSE_SHIP', 'Выберите Способ Доставки ');
define('FS_COMPANY', 'Компании');
define('FS_TIME', 'Срок');
define('FS_COST', 'Расходы');
define('FS_TO', 'к');
define('FS_VIA', 'по');
define('FS_FREE_SHIP', 'Бесплатно');
define('FS_PREFER', 'Если вы предпочитаете использовать свой собственный express аккаунт, предоставьте номер аккаунта, пожалуйста, затем Fiberstore не взимает плату за перевозку.');
define('FS_METHOD', 'Способы доставки');
define('FS_ACCOUNt', 'Express Аккаунт');
define('FS_NO_SHIPPING', 'Нет отправка доступны для выбранной страны');
define('FS_BUSINESS_DAYS', 'рабочих дней');
define('FS_BUSINESS_DAY', 'Рабочий день');
define('FS_BUSINESS_DAYES', 'рабочих дней');
define('FS_SHIP_CONFIRM', 'Подтвердить');
define('FS_WORK_DAYS_SERVICE', 'Working Days');

//frankie  stock_list
define('STOCK_LIST_FILTER', 'Фильтр');
define('STOCK_LIST_MODEL', 'Модель');
define('STOCK_LIST_DESCRIPTION', 'Описание');
define('STOCK_LIST_PRICE', 'Цена');
define('STOCK_LIST_WUHAN', 'В Наличии');
define('STOCK_LIST_QUANTITY', 'Количество');

//评论相关页面编辑头像 2017.4.10  ery
define('FS_ADAPTER_TYPE', 'Тип Адаптера');
define('FS_TRANS_RELATED', 'Type');

define('FS_REVIEWS_REPLACE', 'Заменить изображение');
define('FS_REVIEWS_EDIT', 'Edit Your Profile');
define('FS_REVIEWS_RECOMMENDED', 'Рекомендуемое изображение');
define('FS_REVIEWS_LOCAL', 'Загрузить изображение');
define('FS_REVIEWS_ONLY', 'Можно загрузить картинку в формате JPG, GIF, PNG, JPEG, BMP, объём файла не больше 300KB');
define('FS_REVIEWS_SAVE', 'Сохранить');

//add by frankie  2017.6.28 
define('FS_PANEL_REQUEST', 'Отправить Запрос');
define('FS_PANEL_YOUR', 'ФИО');
define('FS_PANEL_PHONE', 'Номер Телефона');
define('FS_PANEL_COUNTRY', 'Страна');
define('FS_PANEL_SEARCH', 'Поиск вашей страны');
define('FS_PANEL_EMAIL', 'Ваш Адрес Почты');
define('FS_PANEL_COMMENTS', 'Отзывы/Вопросы');
define('FS_PANEL_UPLOAD', 'Загрузить Файлы');
define('FS_PANEL_COMPLETE', 'Загрузка Совершена');
define('FS_PANEL_PLEASE', 'Пожалуйста, заполните правильную информацию!');

//账户中心相关页面公用向量   2017.5.12  ery  add
/*edit_my_account页面*/
define('ACCOUNT_MY_ACCOUNT', 'Личный кабинет');
define('ACCOUNT_EDIT_ACCOUNT', 'Редактировать личный кабинет');
define('ACCOUNT_EDIT_BELOW', 'Пожалуйста, редактируйте свои данные ниже, затем нажмите кнопку "обновить" для изменения.');
define('ACCOUNT_EDIT_FOLLOW', 'Пожалуйста, проверьте следующее…');
define('ACCOUNT_EDIT_ACCOUNT_INFO', 'Информация об Аккаунте');
define('ACCOUNT_EDIT_UPDATE', 'Сохранить');
define('ACCOUNT_EDIT_EMAIL', 'Адрес Электронной Почты');
define('ACCOUNT_EDIT_NEW', 'Новый Пароль');
define('ACCOUNT_EDIT_REENTER', 'Повтор Пароля');
define('ACCOUNT_EDIT_ADDRESS', 'Информация об Адресе');
define('ACCOUNT_EDIT_FIRST', 'Имя');
define('ACCOUNT_EDIT_LAST', 'Фамилия');
define('ACCOUNT_EDIT_COMPANY', 'Название Компании');
define('ACCOUNT_EDIT_STREET', 'Адрес, Первая Строка');
define('ACCOUNT_EDIT_LINE', 'Адрес, Вторая Строка');
define('ACCOUNT_EDIT_POSTAL', 'Почтовый Индекс');
define('ACCOUNT_EDIT_CITY', 'Город');
define('ACCOUNT_EDIT_COUNTRY', 'Страна/Регион');
define('ACCOUNT_EDIT_STATE', 'Край / Область / Регион');
define('ACCOUNT_EDIT_PHONE', 'Номер Телефона');
define('ACCOUNT_EDIT_EMIAL_MSG', 'Не удоалось найти данный аккаунт.(Пример:someone@example.com).');
define('ACCOUNT_EDIT_PASS_MSG', 'Длина пароля должен быть не менее 7 символов.');
define('ACCOUNT_EDIT_CONFIRM_MSG', "Повтор пароля не совпадает с новым паролем. Они должны быть одинаковыми.");
define('ACCOUNT_EDIT_FIRST_MSG', 'Пожалуйста, введите Ваше Имя.');
define('ACCOUNT_EDIT_LAST_MSG', 'Пожалуйста, введите Bашу  Фамилию.');
define('ACCOUNT_EDIT_STREET_MSG', 'Пожалуйста, введите ваш  Адрес.');
define('ACCOUNT_EDIT_POSTAL_MSG', 'Пожалуйста, введите ваш  Почтовый Индекс.');
define('ACCOUNT_EDIT_CITY_MSG', 'Пожалуйста, введите ваш  Город.');
define('ACCOUNT_EDIT_COUNTRY_MSG', 'Пожалуйста, введите вашу  Страну.');
define('ACCOUNT_EDIT_STATE_MSG', 'Пожалуйста, введите ваш  Край / Область / Регион.');
define('ACCOUNT_EDIT_PHONE_MSG', 'Пожалуйста, введите ваш  Номер Телефона.');
define('ACCOUNT_EDIT_HEADER_OUR', 'Данный адрес электронной почты в нашей системе занят другим пользователем. .');
define('ACCOUNT_EDIT_HEADER_EDIT', 'Ник успешно сменен .');
define('ACCOUNT_EDIT_HEADER_FILE', 'Файл слишком вилик!');
define('ACCOUNT_EDIT_HEADER_CUSTOMER', 'Ваше Фото успешно изменено.');
define('ACCOUNT_EDIT_HEADER_THANKS', 'Спасибо');
define('ACCOUNT_EDIT_HEADER_FS', 'FS.COM Обслуживание Клиентов');
define('ACCOUNT_EDIT_HEADER_INFO', 'FS.COM:Обновление Информации об Аккаунте');
define('ACCOUNT_EDIT_HEADER_YOUR', 'Информация об учетной записи FS.COM была обновлена. Просмотрите ниже, чтобы подтвердить обновленную информацию.');


/*my_questions和my_questions_details页面*/
define('FS_QUSTION', 'Вопрос QA_COUNT');
define('FS_QUSTION_TELL', 'Скажите нам ваши вопросы, и мы сделаем все возможное, чтобы вам помочь.');
define('FS_QUSTION_ASK', 'Задать Вопрос');
define('FS_QUSTION_DATE', 'Дата');
define('FS_QUSTION_STATUS', 'Статус');
define('FS_QUSTION_VIEW', 'Просмотреть');
define('FS_QUSTION_REMOVE', 'Удалить');
define('FS_QUSTION_ENTRIES', 'Записи');
define('FS_QUSTION_NO', 'Не заполняется заголовок.');
define('FS_QUSTION_ANSWERS', 'Ответы');
define('FS_QUSTION_REPLY', 'Вопросы были в обработке, пожалуйста, будьте терпеливы.');
define('FS_QUSTION_JS', 'Удалите данную информацию ?');
/*manage_address页面*/
define('FS_ADDRESS_BOOK', 'Мои адреса доставки');
define('FS_ADDRESS_NAME', 'ФИО');
define('FS_ADDRESS_COMPANY', 'Компания');
define('FS_ADDRESS_ADDRESS', 'Адрес');
define('FS_ADDRESS_NO', 'Адрес не найден');
define('FS_ADDRESS_DEFAULT', 'По умолчанию');
define('FS_ADDRESS_SET', 'Настройка по умолчанию');
define('FS_ADDRESS_EDIT', 'Редактировать');
define('FS_ADDRESS_CREATE', 'Создать аккаунт');
define('FS_ADDRESS_UPDATE', 'Обновить Список Адресов');
define('FS_ADDRESS_PLEASE', 'Пожалуйста, заполните эту форму, чтобы изменить этот адрес, затем нажмите кнопку "обновить".');

define('FS_ADDRESS_FIRST_REQUIRED_TIP', 'Поле «имя» обязательно для заполнения.');
define('FS_ADDRESS_FIRST_MSG', 'Ваша фамилия должна содержать не менее 2 символов.');

define('FS_ADDRESS_LAST_REQUIRED_TIP', 'Поле «фамилия» обязательно для заполнения.');
define('FS_ADDRESS_LAST_MSG', 'Ваше имя должно содержать не менее 2 символов.');

define('FS_ADDRESS_SORRY', 'Извините, требуется адрес доставки.');
define('FS_ADDRESS_STREET_FORMAT_TIP', 'Первая строка адреса должна иметь длину от 4 до 35 символов.');
define("FS_ADDRESS_STREET_PO_BOX_TIP", "Мы не отправляем в почтовые ящики.");

define('FS_ADDRESS_POSTAL_REQUIRED_TIP', 'Поле «почтовый индекс» обязательно для заполнения.');
define('FS_ADDRESS_POSTAL_MSG', 'Ваш почтовый индекс должен содержать не менее 3 символов.');

define('FS_ADDRESS_COUNTRY_MSG', 'Ваша страна требуется.');
define('FS_ADDRESS_STATE_MSG', 'Ваша область требуется.');

define('FS_ADDRESS_PHONE_REQUIRED_TIP', 'Поле «номер телефона» обязательно для заполнения.');
define('FS_ADDRESS_PHONE_MSG', 'Ваш номер телефона должен содержать не менее 6 цифр.');

define('FS_ADDRESS_UP_ADDRESS', 'Добавить');
define('FS_ADDRESS_NEW', 'Новый Адрес');
define('FS_ADDRESS_NEW_PLEASE', 'Пожалуйста, заполните эту форму, чтобы добавить новый адрес, затем нажмите кнопку Добавить.');
define('FS_ADDRESS_ADD', 'Добавьте Адрес');
define('FS_ADDRESS_DELETE', 'Адрес успешно удалён!');
define('FS_ADDRESS_SET_SUCCESS', 'Адрес по умолчанию успешно установлен!');
define('FS_ADDRESS_UP_SUCCESS', 'Информация успешно изменена.');
define('FS_ADDRESS_ADD_SUCCESS', 'Адрес успешно добавлен.');
/*manage_order相关页面*/
define('MANAGE_ORDER_STATUS', 'Статус Заказа');
define('MANAGE_ORDER_ORDER', 'Заказ #:');
define('MANAGE_ORDER_SHIPMENT', 'Доставка');
define('MANAGE_ORDER_INFORMATION', 'Информация о заказе');
define('MANAGE_ORDER_DATE', 'Дата заказа');
define('MANAGE_ORDER_PAYMENT', 'Способ Оплаты');
define('MANAGE_ORDER_SEE', 'Просмотреть Все');
define('MANAGE_ORDER_PO', 'Номер PO');
define('MANAGE_ORDER_RMA_NO', 'Номер RMA');
define('MANAGE_ORDER_TEL', 'телефон');
define('MANAGE_ORDER_NOT', 'Вы пока ничего не заказали');
define('MANAGE_ORDER_SHIPPING', 'Информация о Доставке');
define('MANAGE_ORDER_PRODUCT', 'Продукт');
define('MANAGE_ORDER_ITEM', 'Цена за единицу');
define('MANAGE_ORDER_QUANTITY', 'Количество');
define('MANAGE_ORDER_TOTAL', 'Общая Сумма');
define('MANAGE_ORDER_QTY', 'Кол-во');
define('MANAGE_ORDER_WRITE', 'Оставить отзыв');
define('MANAGE_ORDER_PRINT', 'Печать');
define('MANAGE_ORDER_REORDER', 'Восстановить Заказ');
define('MANAGE_ORDER_TIME', 'Время обработки');
define('MANAGE_ORDER_INFO', 'Статус Заказа');
define('MANAGE_ORDER_OPERATOR', 'Оператор Процесса');
define('MANAGE_ORDER_COMMODITY', 'Обработка');
define('MANAGE_ORDER_MSG', 'Заказ успешно отменён!');
define('MANAGE_ORDER_ALL', 'Все заказы');
define('MANAGE_ORDER_PENDING', 'Отложенные Заказы');
define('MANAGE_ORDER_COMPLETED', 'Сделанные Заказы');
define('MANAGE_ORDER_CANCELLED', 'Отмененные Заказы');
define('MANAGE_ORDER_RMA', 'Обмен и Возврат Заказов');
define('MANAGE_ORDER_PLACED', 'Дата заказа');
define('MANAGE_ORDER_SHIPING', 'Доставка до');
define('MANAGE_ORDER_DETAILS', 'Детали Заказа');
define('MANAGE_ORDER_INVOICE', 'Распечатать Инвойс');
define('MANAGE_ORDER_DOWNLOAD_INVOICE', 'Скачать');
define('MANAGE_ORDER_BUY', 'Повторить заказ');
define('MANAGE_ORDER_VIEW', 'Просмотреть Больше Товаров в Заказе');
define('MANAGE_ORDER_PAY', 'Платить');
define('MANAGE_ORDER_CANCEL', 'Отменить заказ');
define('MANAGE_ORDER_RETURN', 'Возврат/Обмен');
define('MANAGE_ORDER_RESTORE', 'Восстановить Отмененный Заказ');
define('MANAGE_ORDER_MONTH', 'Последний месяц');
define('MANAGE_ORDER_THREE_MONTHS', 'Последние 3 месяца');
define('MANAGE_ORDER_YEAR', 'Последний год');
define('MANAGE_ORDER_YEAR_AGO', 'Год назад');
define('MANAGE_ORDER_NO', 'Номер Заказа');
define('MANAGE_ORDER_HEADER', 'Заявка на отменение заказа был успешно отправлен. Пожалуйста, ожидайте обработки');
define('MANAGE_ORDER_EA','/шт.');
define('FIBERSTORE_ORDER_PROMT2','Нет заказов.');
/*sales_service页面*/
define('FS_SALES_CHOOSE', 'Выберите товар для возврата');
define('FS_SALES_ALL', 'Все');
define('FS_SALES_RETURN', 'Назад');
define('FS_SALES_CONTINUE', 'Далее');
define('FS_SALES_SELECT', 'Пожалуйста, выберите продукты');
define('FS_SALES_CONFIRM', 'Отмените этот заказ ?');
/*sales_service_info页面*/
define('FS_SALES_REASONS', 'ПОДТВЕРЖДЕНИЕ RMA');
define('FS_SALES_PLEASE', 'Пожалуйста, выберите Тип Сервиса');
define('FS_SALES_REFUND', 'Возврат Товара&Денег');
define('FS_SALES_REPLACE', 'Обмен');
define('FS_SALES_MAINTENANCE', 'Ремонт');
define('FS_SALES_WHY', 'Почему вы возвращаете этот товар?');
define('FS_SALES_NO', 'Товар больше не нужен');
define('FS_SALES_INCORRECT', 'Не подошел товар или размер.');
define('FS_SALES_MATCH', "Товар не соответствует описанию");
define('FS_SALES_DAMAGED', 'Товар повреждён при доставке');
define('FS_SALES_RECEIVED', 'Получен не тот (ошибочный) товар');
define('FS_SALES_NOT', 'Товар не соответствует ожиданиям');
define('FS_SALES_NO_REASON', 'Нет причин');
define('FS_SALES_OTHER', 'Другие причины');
define('FS_SALES_COMMENTS', 'Комментарии (требуются)');
define('FS_SALES_NOTE', 'Примечание');
define('FS_SALES_WE', "Мы не предлагаем исключения из политики в ответ на комментарии");
define('FS_SALES_WRITE', 'Введите ваши вопросы, пожалуйста');
define('FS_SALES_SUCCESSFUL', 'успешно');
define('RMA_TRACK_STATUS', 'Отслеживание Статуса');
define('RMA_SERVICE_TYPE', 'Тип Сервиса');
define('RMA_REASON', 'Причины для Сервиса');
/*sales_service_details*/
define('SALES_DETAILS_CONFIRM', 'Подтвердить Получение');
define('SALES_DETAILS_RECEIPT', 'Подтверждение Получения');
define('SALES_DETAILS_SUBMIT', 'Заявка RMA Отправлена');
define('SALES_DETAILS_REJECT', 'Отклонена');
define('SALES_DETAILS_APPROVED', 'Принята');
define('SALES_DETAILS_RETURN', 'Вернуть');
define('SALES_DETAILS_RMA', 'RMA Получен');
define('SALES_DETAILS_NEW', 'Новая Отправка');
define('SALES_DETAILS_REFUND', 'Распечатать Инвойс');
define('SALES_DETAILS_COMPLETE', 'Завершен');
define('SALES_DETAILS_SEND', 'Как Вернуть Товар ');
define('SALES_DETAILS_FROM', 'Возврат из');
define('SALES_DETAILS_EDIT', 'Редактировать');
define('SALES_DETAILS_DELIVER', 'Информация получателя');
define('SALES_DETAILS_FILL', 'Заполните Грузовую Накладную');
define('SALES_DETAILS_AWB', 'Пожалуйста, заполните грузовую накладную для отслеживания посылок, и как только получится ваша посылка, обмен или возврат товара будет обработан в ближайшее время.');
define('SALES_DETAILS_TRACKING', 'Номер Отслеживания');
define('SALES_DETAILS_PLEASE', 'Введите номер отслеживания.');
define('SALES_DETAILS_PRINT', 'Распечатать RMA');
define('SALES_DETAILS_STEP_CONFIRM', 'Подтвердить Адрес');
define('SALES_DETAILS_STEP_PRINT', 'Печать RMA');
define('SALES_DETAILS_STEP_ATTACH', 'Вставить Форму RMA');
define('SALES_DETAILS_STEP_CREATE', 'Оформить Транспортную Этикетку');
define('SALES_DETAILS_STEP_SHIP', 'Отправить');
define('SALES_DETAILS_PRINT_MSG', 'Формуляр RMA помогает нам отличить вашу посылку и быстро обработать заявку на возврат или обменну товара. Пожалуйста, распечатайте его и прикрепите его к возвращенной посылке.');
define('SALES_DETAILS_SEND_MSG', ' Чтобы вернуть покупку необходимо следовать ниже заведенному порядку возвращения. Вы можете оформить грузовую накладную (shipping label) на веб-сайте транстпортной компании или в отделении перевозчика. Если вы считаете, что грузовая накладная должна быть оформлена и оплачена FS.COM, позвоните нам по телефону +7 (499) 643 4876 или напишите нам по адресу service.us@fs.com.');
define('SALES_DETAILS_CANCEL','Отмена');


/*售后流程状态提示*/
define('SALES_MSG_APPROVED', 'Ваша Заявка на Обмен и Возврат Товаров была принята, пожалуйста, верните нам посылку(-и).');
define('SALES_MSG_SUBMIT', 'Ваша Заявка на Обмен и Возврат Товаров была отправлена, пожалуйста, ожидайте.');
define('SALES_MSG_RETURN', 'Спасибо за возврат нам посылок, наш отдел логистики будет уделять внимание состоянию доставки.');
define('SALES_MSG_COMPLETE', 'Обмен или возврат товаров завершен.');

//define('FS_THEA_CTUAL_SHIPPING_TIME','Может быть некоторая разница между расчетным временем и фактическим временем.');

//manage_orders & sales_service_list  2017.6.10		add 	ery
define('MANAGE_ORDER_SEARCH', 'Поиск всех заказов');
define('MANAGE_ORDER_FILTER', 'Фильтр по заказам');
define('MANAGE_ORDER_BACK', 'Назад');
define('MANAGE_ORDER_APPLY', 'Применить');
define('MANAGE_ORDER_TYPE', 'Тип Заказа');
define('MANAGE_ORDER_TIME_FILTER', 'Фильтр по дате');
//2017.6.6		add		ery   manage_orders & account_history_info
define('F_RECEIPT_CONFIRMATION', 'Доставлен');
define('F_REFUNDED_PROCESSING', 'Обработка Возврата Платежа');
define('MANAGE_ORDER_ARE', 'Вы уверены, что получили продукты? ');
define('MANAGE_ORDER_YES', 'Да');
define('MANAGE_ORDER_JS_NO', 'Нет');
define('FIBERSTORE_REFUND', 'Подтверждение Возврата Платежа');
define('FIBERSTORE_ONCE_RECOVERED', 'Как только он было подтвержден, он больше не могут быть восстановлен.');
define('FIBERSTORE_PLEASE_KINDLY', 'Заполните причины отмены заказа, если вы настаиваете на этом.');
define('FS_THEA_CTUAL_SHIPPING_TIME','Мы всегда стремимся предлагать самую быструю доставку с глобальной складской системой. Для получения дополнительной информации, пожалуйста, посмотрите <a href="'.zen_href_link('shipping_delivery').'">Политику доставки</a>.');

//2017.7.5 add by frankie
define('ACCOUNT_EDIT_SUCCESS', 'Успешно');
define('FS_REMOVED_CART', 'успешно удален из корзины');
define('FS_UPDATE', 'Обновить');

//2017.7.11 add by  frankie
define('PATCH_PANEL_01', 'Как получить дополнительную поддержку?');
define('PATCH_PANEL_02', 'FS прилагает силу в решениях для ЦОД, корпоративной сети и оптической транспортной сети, чтобы помочь вам создать нужную сеть.');
define('PATCH_PANEL_03', 'Пожалуйста, свяжитесь с Технической Поддержкой: ');
define('PATCH_PANEL_04', 'или Отделом Продаж:');

//2017.7.11  add by frankie
define('ACCOUNT_TOTAL', 'Итого');
define('ACCOUNT_OF_SHIPPING', '(+)Доставка:');
define('ACCOUNT_OF_TOTAL', 'Общая стоимость:');
define ('ACCOUNT_OF_GSP_TOTAL_AU', 'Общая стоимость (включая GST)');
define ('FS_ORDERS_DETAILS_TAX_AU', 'Стоимость GST');

//2017.8.3 add by frankie
define('TITLE_RELARED_DES', "Every transceiver is individually tested on corresponding equipment such as Cisco, Arista, Juniper, Dell, Brocade and other brands, passed the monitoring of Fiberstore's intelligent quality control system.");
define('TITLE_RELARED_01', '40GBASE-SR4 QSFP+ 850nm 150m MTP/MPO Transceiver for MMF');
define('TITLE_RELARED_02', 'QSFP28 100GBASE-SR4 850nm 100m Transceiver');
define('TITLE_RELARED_03', '40GBASE-LR4 and OTU3 QSFP+ 1310nm 10km LC Transceiver for SMF');
define('TITLE_RELARED_04', 'QSFP28 100GBASE-LR4 1310nm 10km Transceiver');
define('TITLE_RELARED_05', 'Compatible Brand');

//checkout 运输方式
define('FS_CHECK_OTHERS','Другие');
//2017.8.15 add  全站通用常量
define('FS_SER_COMMON_EMALl', 'Sales@fs.com');
define('FS_EMAIL','ru@fs.com');

define("MANAGE_ORDER_VIEW_PO", "Просмотреть мой PO");
define("MANAGE_PO_NUMBER", "Заказ на поставку#");
//2017.8.9 		add 	ery  税号
define('FS_VAT_PLEASE', 'Пожалуйста, введите действительный номер VAT.');
define('FS_VAT_NO', 'Идентификационный номер плательщика VAT');
define('FS_CHECK_OUT_STATE', 'Выберите вашу область');
define('FS_CHECK_OUT_PLEASE', 'Введите вашу Страну');
define('FS_CHECK_OUT_INVALID', 'Недействительный номер телефона. Попробуйте ещё раз.');
define('FS_CHECK_OUT_NEED', 'Нужна помощь');
define('FS_CHECK_OUT_LIVE', 'Чат Сейчас');
define('FS_CHECK_OUT_EMAIL', 'Email');
define('FS_CHECK_OUT_TAX', 'Налог');
define('FS_CHECK_OUT_TAX_RU', 'Налог');
define('FS_CHECK_OUT_TAX_CN', 'Налог');
define('FS_CHECK_OUT_ORDER', 'СВОДНАЯ ИНФОРМАЦИЯ О ЗАКАЗЕ');
define('FS_CHECK_OUT_REMARKS', 'Добавить Замечания');
define('FS_CHECK_OUT_CHANGE', 'Изменить');
define('FS_CHECK_OUT_ADD', 'Добавить новый адрес');
define('FS_CHECK_OUT_REVIEW', 'Просмотреть Товары и Доставку');
define('FS_CHECK_OUT_YOUR', 'Ваши товары');
define('FS_CHECK_OUT_ADDRESS', 'Ваши адресы');
define('EMAIL_CHECKOUT_COMMON_VAT_COST', 'НДС');
define('EMAIL_CHECKOUT_COMMON_VAT_COST2', 'НДС');
define('EMAIL_CHECKOUT_COMMON_VAT_COST_FR','НДС');
define('FS_CHECK_OUT_INCLUDEING', '(С Учетом Налогов)');
define('FS_CHECK_OUT_EXCLUDING', '(Без учета налогов и сборов)');

define('FS_CHECK_OUT_EXCLUDING_CA','(Без учета <a href="javascript:void(0);" onclick="show_taxes()" class=" checkout_Npro_priceLiL tax_content tax_color">налогов и сборов</a>)');

define('FS_CHECK_OUT_EXCLUDING_RU_NATURE', '(Без пошлин и сборов)');

define('FS_CHECK_ADDRESS_TYPE', "Тип адреса");
define('FS_CHECK_OUT_ADTYPE_TIT', "Поле «тип адреса» обязательно для заполнения.");
define('FS_CHECK_OUT_COMPANY_TIT', "Поле «название компании» обязательно для заполнения.");
define('FIBER_CHECK_TWO', 'UPS 2nd Day Air<sup>®</sup> service');
define('FIBER_CHECK_STAND', 'UPS Ground<sup>®</sup> service');
define('FIBER_CHECK_ONE', 'UPS Next Day-Afternoon<sup>®</sup> service');
define('FIBER_FEDEX_CHECK_OVER', 'FedEX Overnight<sup>®</sup> service');
define('FIBER_FEDEX_CHECK_TWO', 'FedEX 2Day<sup>®</sup> service');
define('FIBER_FEDEX_CHECK_GROUND', 'FedEX Ground<sup>®</sup> service');
define("ADDRESSTYPE", "Тип плательщика");
define("FS_CHECK_OUT_SELECT", "Выберите");
define("FS_CHECK_OUT_BUSINESS", "рабочий");
define("FS_CHECK_OUT_INDIVIDUAL", "частный");
//checkout快递类型
define('FS_CHECKOUT_UPS_PLUS','UPS Express Plus Next Day 9:00');
define('FS_CHECKOUT_UPS','UPS Express Next Day 12:00');
define("ADDRESS_TYPE_TIT1", "Тип Адреса не может быть пустым");
define("ADDRESS_TYPE_TIT2", "Название компании не может быть пустым");
define("FS_ADDRESS_INVOCE", 'Отправьте мне инвойс по почте.');
// add by aron 2017.7.17  
define("MANAGE_ORDER_PURCHASE_ORDER", 'Заказ на Поставку');
define("MANAGE_ORDER_UPLOAD_PO_FILE", 'Загрузить Файл заказа на поставку');
define("MANAGE_ORDER_UPLOAD_PURCHASE_ORDER", 'Загрузить Заказ на Поставку');
define("MANAGE_ORDER_UPLOAD_MESAAGE", 'Мы отправим груз при получении заказа на поставку. Он должен быть получен за 5 дней, в том числе заказ# по PO.');
define("MANAGE_ORDER_UPLOAD_FILE_TEXT", ' Выбрать Файл ');
define("MANAGE_ORDER_UPLOAD_ERROR", "Доступны файлы типа PDF, JPG, PNG. Максимальный размер файла:4MB");
define("MANAGE_ORDER_UPLOAD_SUBMIT", "Загрузить");
define("MANAGE_ORDER_UPLOAD_LABEL", 'Загрузить Файл');

define('FS_DHLG', 'DHL Express Domestic');
define('FS_DHLE', 'DHL Economy');
define('FS_DHLEE', 'DHL Express Worldwide');

define('FS_WAREHOSE_CA_TIP', 'Бесплатная доставка при сумме заказа более 79 долл. и наличии на U.S. складе');
define('FS_WAREHOSE_EU_TIP', 'Бесплатная доставка при сумме заказа более 79 долл. и наличии на EU складе (в Германии)');
define('FS_WAREHOSE_OTHER_TIP', 'FS.COM глобальная складская система обеспечивает самую быструю доставку до ');

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 免运费提示信息（每个站点显示不一样。不是直接翻译的）
define('FS_HEADER_FREE_SHIPPING_US_TIP','Бесплатная доставка при сумме заказа на приемлемые товары от US$ 79');
define('FS_FOOTER_FREE_SHIPPING_US_TIP','Бесплатная');
define('FS_HEADER_FREE_SHIPPING_DE_TIP','Бесплатная доставка при сумме заказа на приемлемые товары от $MONEY');
define('FS_FOOTER_FREE_SHIPPING_DE_TIP','Бесплатная доставка');
define('FS_HEADER_FREE_SHIPPING_AU_TIP','Бесплатная доставка при сумме заказа на приемлемые товары от A$99');
define('FS_FOOTER_FREE_SHIPPING_AU_TIP','Бесплатная доставка');
define('FS_HEADER_FREE_SHIPPING_OTHER_TIP','Отправка в тот же день при заказе продуктов, имеющихся в наличии');
define('FS_FOOTER_FREE_SHIPPING_OTHER_TIP','Отправка в тот же день ');
define('FS_M_FREE_SHIPPING_DE_TIP','Беспл. доставка от $MONEY');
define('FS_M_FREE_SHIPPING_AU_TIP','Бесплатная доставка от A$99');
define('FS_M_FREE_SHIPPING_FAST_SHIPPING','Быстрая доставка в США');
define('FS_M_SHIPPING_US_TIP','Бесплатная доставка от US$ 79');
define('FS_M_SHIPPING_DELIVERY_RU','Беспл. доставка от ₽ 20 000');

//add-ternence
define('MY_CASE_UPLOAD_1', 'Ваш запрос на решение ');
define('MY_CASE_UPLOAD_2', ' был отправлен.');
define('MY_CASE_UPLOAD_3', 'Уважаемый/ая ');
define('MY_CASE_UPLOAD_4', 'Благодарим Вас за обращение в службу  технической поддержки по проектированию решений FS.COM, мы получили Ваш запрос и создали номер вопроса ');
define('MY_CASE_UPLOAD_5', ' для Вашего запрос на решение.');
define('MY_CASE_UPLOAD_6', 'Мы свяжемся с Вами в течение 24 часов, пожалуйста, проверьте электронную почту.');
define('MY_CASE_UPLOAD_7', 'В то же время эти ресурсы, может быть, Вам полезны: ');
define('MY_CASE_UPLOAD_8', 'https://www.fs.com/ru/Data-Center-Cabling.html');
define('MY_CASE_UPLOAD_9', 'https://www.fs.com/ru/Enterprise-Networks.html');
define('MY_CASE_UPLOAD_10', 'https://www.fs.com/ru/Long-haul-Transmission.html');
define('MY_CASE_UPLOAD_11', 'https://www.fs.com/ru/Optic-OEM-Solution.html');
define('MY_CASE_UPLOAD_12', 'Кабельная Система для ЦОД');
define('MY_CASE_UPLOAD_13', 'Корпоративная сеть');
define('MY_CASE_UPLOAD_14', 'Передача на Дальнее Расстояние');
define('MY_CASE_UPLOAD_15', 'OEM Услуги');
define('MY_CASE_UPLOAD_16', 'С уважением,');
define('MY_CASE_UPLOAD_17', 'https://www.fs.com/ru/');
define('MY_CASE_UPLOAD_18', 'FS.COM');
define('MY_CASE_UPLOAD_19', ' Cлужба Технической Поддержки по Проектированию Решений');
define('MY_CASE_UPLOAD_20', 'FS.COM - Запрос на Решение & Номер Вопроса: ');
//2017-9-12  ery   add 层级属性定制提示语
define('PROINFO_CUSTOM_WAVE', 'Введите другие требуемые длины волн.');
define('PROINFO_CUSTOM_GRID', 'Введите другой требуемый grid channel.');
define('PROINFO_CUSTOM_RATIO', 'Введите другой требуемый коэффициент разветвления.');
define('FS_STOCK_OPTION','Вариант');

//2017.10.12. add by frankie 自提
define("CHECKOUT_ONESELF_PICH", "Самовывоз");

//2017-10.12  dylan 产品详情页installation属性
define('FS_PRODUCT_INSTALLATION', 'Установка:');
define('FS_PRODUCT_INSTALLATION_TEXT', 'Подходит для установки на FMU-1UFMX-N шасси в стойке');
define('FS_PRODUCT_INSTALLATION_TEXT2', 'Подходит для установки на ');
define('FS_PRODUCT_INSTALLATION_TEXT3', 'FMT04-CH1U');
define('FS_PRODUCT_INSTALLATION_TEXT4', ' шасси в стойке');
define ('FS_PRODUCT_INSTALLATION_TEXT5', 'Кассета LGX подходит к шасси <a href="'.zen_href_link('product_info','products_id=51608','SSL').'" style="color: #0070BC;">FLG-1UFMX-N</a>, которое можно установить в стойку');
define('FS_PRODUCT_INFO_STEP','Шаг');

//2019.1.10 详情页评论
define('FS_REVIEWS34',' Голосов');
define('FS_REVIEWS35',' Голос');
define('FS_REVIEW_REPORT','Cообщить по ошибке');
define('FS_REVIEWS31','Показан');
define('FS_REVIEWS32','комментарий');
define('FS_BY','от');
define('FS_REVIEWS36','комментарии');
define('FS_REVIEWS_STARS_TITLE','Оценка: ');
define('FS_READ_MORE','Больше');
define('FS_SEE_LESS','Меньше');

define('FS_MOBILE_CLOSE','Раскрыть');
//define('FS_PRODUCT_CUSTOMIZATION','Примечание:');
//define('FS_PRODUCT_CUSTOMIZATION_TEXT','Типичная входная мощность=Выходная мощность-Усиление');
define('FS_PRODUCT_CUSTOMIZATION_TEXT', 'FMU Вставной модуль используется в ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT1', 'FMT-CH');
define('FS_PRODUCT_CUSTOMIZATION_TEXT2','Вставной модуль используется в ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT3', 'FUD Вставной модуль используется в ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT4', 'FMU-1UFMX-N');
define('FS_PRODUCT_CUSTOMIZATION_TEXT5', ' шасси для монтажа на стойке');
define('FS_PRODUCT_CUSTOMIZATION_TEXT6', 'FUD-1UFMX-N');
define('FS_PRODUCT_CUSTOMIZATION_TEXT7', 'Вставной модуль используется в ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT8', 'FS-2U-RC001');
define('FS_PRODUCT_ITEM','Продукт ID: ');
//2017-11-2   add  ery  国家下拉框搜索提示语
define('FS_COUNTRY_SEARCH', 'Поиск вашей страны/региона');

//2017.12.2 dylan 产品详情页图标描述
define('PRO_AUTHENTICATION_ICON_PLEASE','Пожалуйста <a href="'.zen_href_link('contact_us').'" target="_blank">свяжитесь с нами</a> для подробности.');
define('PRO_AUTHENTICATION_ICON_01','Данный товар соответствует применимым требованиям Директивы (ЕС) 2015/863 RoHS. Он ограничивает использование десяти опасных материалов при изготовлении различных типов электронного и электрического оборудования: свинец, ртуть, кадмий, шестивалентный хром, полибромированные бифенилы и дифенилэфиры, и четыре различных фталата. ');
define('PRO_AUTHENTICATION_ICON_02', 'Данный продукт имеет пожизненную гарантию. ');
define('PRO_AUTHENTICATION_ICON_03', 'Данный продукт соответствует требованиям ISO9001. Эта система действительна для компании, занимающейся разработкой, производством и поставкой оптического оборудования. ');
define('PRO_AUTHENTICATION_ICON_04', 'Данный продукт соответствует стандарту CE, который указывает на соответствие основным требованиям к охране здоровья и безопасности. ');
define('PRO_AUTHENTICATION_ICON_05', 'Данный продукт полностью соответствует требованиям FCC, целью которого является более рациональное управление радиоволнами и магнитными полями. ');
define('PRO_AUTHENTICATION_ICON_06', 'FDA отвечает за сохранение здоровья и защиты населения от опасной и нежелательной радиации путем регулирования радиационных электронных продуктов. ');
define('PRO_AUTHENTICATION_LEARN', 'для подробности.');
//new
define ('PRO_AUTHENTICATION_ICON_07', 'Этот продукт полностью соответствует ETL, чтобы показывать соответствие с соответствующими отраслевыми стандартами для любого электрического или механического продукта. ');
define ('PRO_AUTHENTICATION_ICON_08', 'Этот продукт был произведен в соответствии с требованиями UL, который является глобальным консалтингом и сертификацией безопасности. ');
define('PRO_AUTHENTICATION_ICON_09','CB - это международная система, управляемая IECEE. Этот продукт основан на стандартах IEC для тестирования безопасности электрических продуктов. ');
//
define('PRO_AUTHENTICATION_ICON_10','REACH - это постановление Европейского Союза, принятое для улучшения защиты здоровья человека и окружающей среды путем более точной и более ранней идентификации внутренних свойств химических веществ. ');
define ('PRO_AUTHENTICATION_ICON_11', 'Этот продукт соответствует RCM, что указывает соответствие требованиям электробезопасности, EMC, EME и телекоммуникации. ');
define('PRO_AUTHENTICATION_ICON_12', 'Данный продукт полностью соответствует WEEE, который является экологическим законодательством Европейского Союза и направлен на улучшение сбора, обработки и утилизации продуктов в конце срока их службы. ');
define('PRO_AUTHENTICATION_ICON_13', 'Этот товар соответствует сертификации 3C. Это система оценки соответствия продукции, внедренная правительствами различных стран с целью защиты личной безопасности потребителей и национальной безопасности, а также усиления управления качеством продукции в соответствии с законами и постановлениями. ');
define('PRO_AUTHENTICATION_ICON_14', 'Знак VCCI (Voluntary Control Council for Interference) является сертификатом EMC продукта и обязательной сертификацией для мультимедийного оборудования (MME) в Японии и предназначен специально для ИТ-оборудования, управления электромагнитным запуском. Этот продукт полностью соответствует сертификации VCCI в Японии. ');
define('PRO_AUTHENTICATION_ICON_15', 'TELEC - это обязательная сертификация для беспроводных продуктов в Японии, также называемая сертификатом MIC в Японии. Этот товар соответствует сертификации TELEC, необходимой для беспроводных товаров, (продукты Bluetooth, мобильные телефоны, WIFI маршрутизаторы, дроны и т. Д.), экспортируемых в Японию. ');
define('PRO_AUTHENTICATION_ICON_16', 'Этот товар соответствует ISO14001. Эта сертификация предназначена для организаций, которые хотят систематически управлять своими экологическими обязанностями, чтобы способствовать экологической устойчивости. ');
define('PRO_AUTHENTICATION_ICON_17', 'Товар полностью соответствует российскому сертификату ТР ТС (Сертификат ЕАС), что означает соответствие стандартам стран-членов таможенного союза, а также требованиям качества и безопасности. ');
define('PRO_AUTHENTICATION_ICON_18', 'Этот продукт полностью соответствует требованиям безопасности, установленным UL (Underwriters Laboratories Inc.). ');
//2017.12.8 frankie   询价
define('GET_A_QUOTE', 'Запросить цену');
define('FS_WRITE_OTHER_DEVICES', 'напр.:Cisco N9K-C9396PX');
define('HPE_LIMIT', 'Из-за его специального материала, выберите "VAL_XXX" совместимость для Вашего заказа, и заполните модель оборудования пожалуйста.');
define('HPE_LIMIT2', 'Совместимости 《VAL_XXX》 не доступно для вашего заказа из-за особенности материала.');
define('model_number_empty','Пожалуйста, введите номер модели вашего оборудования.');

define('FS_SUCCESS_METHOD', 'Способ Доставки');
define('FS_SUCCESS_DELIVERY', 'Предполагаемая дата доставки');
define('FS_SUCCESS_SHIP_FROM', 'Отправка со');
define('FS_SUCCESS_ORDER_DINGDAN', 'Заказ #');
define('FS_SUCCESS_ORDER_QUESTION', 'Если у Вас есть любой вопрос, пожалуйста, позвоните нам по +7 (499) 643 4876 или напишите нам');

define("FS_SUCCESS_ECHECK","Электронный чек");
//ceckout_success
define('FS_PURCHASE_NUMBER','Номер заказа на покупку');

define("FS_WAREHOUSE_EU", "склад DE");
define("FS_WAREHOUSE_US", "склад U.S.");
define("FS_WAREHOUSE_CN", " склад CN");
define('FS_ITEMS_CHECK','шт.');
//公用头部账户板块
define('FS_COMMON_HEADER_ACCOUNT','Аккаунт');
define('FS_COMMON_HEADER_CASES','Запросы');
define('FS_COMMON_HEADER_NOT','Поменять Аккаунт? ');
define('FS_COMMON_HEADER_OUT','Выйти');
define('MANAGE_ORDER_HISTORY','История заказов');
define('FS_ACCOUNT_NO','Номер ');


//checkout_payment_success
define('EMAIL_CHECKOUT_SUCCESS_YOUR', 'Ваша оплата получена.');
define('EMAIL_CHECKOUT_SUCCESS_WE', 'Мы уже получили Вашу оплату ');
define('EMAIL_CHECKOUT_SUCCESS_THANK', ' спасибо Вам за поддержку.');


define('FIBER_CHECK_TWO', 'UPS 2nd Day Air<sup>®</sup> service');
define('FIBER_CHECK_TWO_AM','UPS 2nd Day A.M.<sup>®</sup> service');
define('FIBER_CHECK_STAND', 'UPS Ground<sup>®</sup> service');
define('FIBER_CHECK_ONE', 'UPS Next Day-Afternoon<sup>®</sup> service');

define('FIBER_FEDEX_CHECK_OVER', 'FedEX Overnight<sup>®</sup> service');
define('FIBER_FEDEX_CHECK_TWO', 'FedEX 2Day<sup>®</sup> service');
define('FIBER_CHECK_USE', 'Использовать свой аккаунт перевозки');
define('FIBER_CHECK_FREE', 'Бесплатная');
define('FIBER_CHECK_FREE_SHIPPING', 'Бесплатно');


define("FS_WAREHOUSE_AREA_32", "Спасибо Вам за заказ! Вот детали заказа. Ождает подтверждения PO.");


define('EMAIL_CHECKOUT_PAYPAL_TEXT1', 'Мы получили Ваш заказ в <a href="https://www.fs.com/ru/" target="_blank">FS.COM</a>.  Обработаем его сразу после подтверждения оплаты.');
define('EMAIL_CHECKOUT_PAYPAL_TEXT2', 'Мы получили Ваш заказ в ');
define('EMAIL_CHECKOUT_PAYPAL_TEXT3', 'FS.COM');
define('EMAIL_CHECKOUT_PAYPAL_TEXT4', ' и обработаем его сразу после подтверждения оплаты.');
define('EMAIL_CHECKOUT_PAYPAL_TEXT4_1','. Ниже приведена информация о вашем заказе, пожалуйста, подтвердите и завершите оплату в удобное время.');
define('EMAIL_CHECKOUT_PAYPAL_TEXT5', 'Предполагаемая дата доставки');
define('EMAIL_CHECKOUT_PAYPAL_TEXT6', 'Если у Вас имеется дополнительный вопрос о заказе, пожалуйста, не стесняйтесь ');
define('EMAIL_CHECKOUT_PAYPAL_TEXT7', '<a style="color: #0070BC;text-decoration: none;" href="'.zen_href_link('contact_us').'">свяжитесь с нами</a>');
define('EMAIL_CHECKOUT_PAYPAL_TEXT8', ' Команда ');
define('EMAIL_CHECKOUT_PAYPAL_TEXT9',', и мы будем рады Вам помочь!');
define('EMAIL_CHECKOUT_PAYPAL_TEXT10','Мы получили Ваш заказ в FS.COM.  Обработаем его сразу после подтверждения оплаты.');

define('EMAIL_CHECKOUT_COMMON_SUCCESS_TITLE','FS.COM - Спасибо за Ваш Заказ %s');
define('EMAIL_CHECKOUT_PAYMENT_SUCCESS_TITLE','FS.COM - Заказ %s Платёж Получен');


define("QTY_SHOW_ZERO_STOCK", "шт");
define("QTY_SHOW_MORE_STOCK", "шт");
define("QTY_SHOW_ZERO_STOCK_1", " шт");
define("QTY_SHOW_MORE_STOCK_2", " шт");
define("QTY_SHOW_AVAILABLE","Доступны");
//add by quest 2019-03-08
define("QTY_SHOW_AVAILABLE_NEW_INFO","В Транзите");
define("QTY_SHOW_AVAILABLE_TAG_NEW_INFO","Нужен Транзит");
define('QTY_SHOW_IN_CN_STOCK_1','В наличии');

//add by aron
define("EMAIL_CHECKOUT_WAREHOUSE_THANK", "Спасибо за Вашу покупку в ");
define("EMAIL_CHECKOUT_WAREHOUSE_LIVE", "Онлайн-чат с представителем");
define("EMAIL_CHECKOUT_WAREHOUSE_WITH", " FS.COM");
define("EMAIL_CHECKOUT_WAREHOUSE_SIN", "С уважением,");
define("EMAIL_CHECKOUT_WAREHOUSE_DEAR", "Уважаемый(ая)");
define("EMAIL_CHECKOUT_WAREHOUSE_TEAM", " Команда");
define("EMAIL_CHECKOUT_WAREHOUSE_SHPPING", "Адрес доставки: ");
define("EMAIL_CHECKOUT_WAREHOUSE_TIT", "Если у Вас есть дополнительные вопросы о заказе, пожалуйста, ");
define("EMAIL_CHECKOUT_WAREHOUSE_YOUR", "Ваш заказ на поставку(PO)#");
define("EMAIL_CHECKOUT_WAREHOUSE_UP", "успешно загружен.");
define("EMAIL_CHECKOUT_WAREHOUSE_INVOICE", "Спасибо Вам за информцию PO. Вы можете просмотреть заказ на поставку(PO) и печать инвойс через");
define("EMAIL_CHECKOUT_WAREHOUSE_ORDERS", "Мои заказы");
define("EMAIL_CHECKOUT_WAREHOUSE_NOW", "сейчас.");
define("EMAIL_CHECKOUT_WAREHOUSE_CHARGES", "Стоимость доставки");
define("EMAIL_CHECKOUT_WAREHOUSE_TOTAL", "Общая сумма");
define("EMAIL_CHECKOUT_WAREHOUSE_SUBTOTAL", "Итого");
define("EMAIL_CHECKOUT_WAREHOUSE_PROCESS", "Ваш заказ будет обработан в ближайшее время. Если у Вас имеется дополнительный вопрос о заказе, пожалуйста, не стесняйтесь");

define("FS_WAREHOUSE_AREA_SG", "Отправить со склада SG");
define("FS_WAREHOUSE_AREA_PR",'Отправить из FS США');
//分仓分库语言包
define("FS_WAREHOUSE_AREA_1", "Отправить со склада CN");
define("FS_WAREHOUSE_AREA_2", "Отправить со склада U.S.");
define("FS_WAREHOUSE_AREA_3", "Отправить со склада DE");
define("FS_WAREHOUSE_AREA_4", "- Отправка в тот же день");
define("FS_WAREHOUSE_AREA_5", "- Отправка будет ");
define("FS_WAREHOUSE_AREA_6", "Заказ будет разбит на ");
define("FS_WAREHOUSE_AREA_7", "посылок. ");
define("FS_WAREHOUSE_AREA_8", "Товар");
define("FS_WAREHOUSE_AREA_9", "Цена за Единицу");
define("FS_WAREHOUSE_AREA_10", "Количество");
define("FS_WAREHOUSE_AREA_11", "Итого");
define("FS_WAREHOUSE_AREA_12", "Пожалуйста, перейдите в страницу '");
define("FS_WAREHOUSE_AREA_13", "Мои Заказы");
define("FS_WAREHOUSE_AREA_14", "' чтобы загрузить документ о вашем заказе на поставку(PO). Мы начнем обрабатывать заказ при получении вашего документа.");
define("FS_WAREHOUSE_AREA_15", "Спасибо Вам за покупку на ");
define("FS_WAREHOUSE_AREA_16", "! Ниже заказ ожидает оплаты.");
define("FS_WAREHOUSE_AREA_17", "Спасибо Вам за покупку на FS.COM! Ваш заказ принят в нашу систему и скоро будет обработан. ");
define("FS_WAREHOUSE_AREA_18", "Спасибо Вам за покупку на FS.COM. Ваш заказ #");
define("FS_WAREHOUSE_AREA_19", " оформленный ");
define("FS_WAREHOUSE_AREA_20", " принят и ожидает оплаты. Для Вашего удобства Вы можете отправить платёж напрямую на наш счет: paypal@fs.com.");
define("FS_WAREHOUSE_AREA_21", "Если есть какая-нибудь проблема или вопрос о платеже через paypal, пожалуйста, не стесняйтесь связаться с нами по ");
define("FS_WAREHOUSE_AREA_22", "У Вас пока нет заказов");
define("FS_WAREHOUSE_AREA_23", "Заказ принят и ожидает обработки");
define("FS_WAREHOUSE_AREA_24", "принят и ожидает оплаты.");
define("FS_WAREHOUSE_AREA_25", "Если у Вас есть какая-нибудь проблема или вопрос о платеже кредитной/дебетовой картой, пожалуйста, не стесняйтесь связаться с нами по");
define("FS_WAREHOUSE_AREA_26", "Заказ принят, ожидает оплаты");
define("FS_WAREHOUSE_AREA_27", "Если у Вас есть какая-нибудь проблема или вопрос о");
define("FS_WAREHOUSE_AREA_28", "пожалуйста, не стесняйтесь связаться с нами по");
define("FS_WAREHOUSE_AREA_29", "Номер Заказа:");
define("FS_WAREHOUSE_AREA_30", "Способ доставки:");
define("FS_WAREHOUSE_AREA_31", "заказ на fiberstore...");

/*结算页交期气泡提示语*/
define ("FS_WAREHOUSE_AREA_TIME_36", "Отправка была задержана из-за каникул в США");
define ("FS_WAREHOUSE_AREA_TIME_37", "Отправка была задержана из-за каникул в Австралии.");
define ("FS_WAREHOUSE_AREA_TIME_38", "Отправка была задержана из-за каникул в Германии.");
define ("FS_WAREHOUSE_AREA_TIME_39", "Отправка была задержана из-за каникул в Сингапуре.");
define ("FS_WAREHOUSE_AREA_TIME_42", "Отправка была задержана из-за каникул в Китае.");
define ("FS_WAREHOUSE_AREA_TIME_40", "Отправка была задержана из-за выходных.");
define("FS_WAREHOUSE_AREA_TIME_41",'<div class="track_orders_wenhao shipping_notice m_track_orders_wenhao m-track-alert" style=""><i class="iconfont icon">&#xf071;</i><p></p><div class="new_m_bg1"></div><div class="new_m_bg_wap"><div class="question_text_01 leftjt"><div class="arrow"></div><div class="popover-content">$TIME_TIPS</div><div class="new__mdiv_block"><span class="new_m_icon_Close">Раскрыть</span></div></div></div></div>');
define("FS_WAREHOUSE_AREA_TIME_43","Забрать на складе в США в желаемое время");
define("FS_WAREHOUSE_AREA_TIME_44","Самовывоз со склада DE (Германия) в желаемое время");
define("FS_WAREHOUSE_AREA_TIME_45","Забрать на складе AU в желаемое время");
define("FS_WAREHOUSE_AREA_TIME_46","Забрать на складе Азии в желаемое время");
define("FS_WAREHOUSE_AREA_TIME_47","Забрать на складе SG в желаемое время");
define("FS_WAREHOUSE_AREA_SHIP_CN"," со склада CN");
define("FS_WAREHOUSE_AREA_SHIP_US"," со склада в США");
define("FS_WAREHOUSE_AREA_SHIP_AU"," со склада AU");
define("FS_WAREHOUSE_AREA_SHIP_DE"," со склада DE (Германия)");
define("FS_WAREHOUSE_AREA_SHIP_SG"," со склада SG");
define("FS_PICK_UP_WAREHOUSE", "Забрать на складе");

//2017-12-2  add   ery  产品无库存是的提示语
define('FS_PRODUCTS_CUSTOMIZED', 'Заказные');
define('FS_COMMON_LEVEL_WAS', 'был');
//2017-12-13  add  ery 公用的tt账号语言包
define('FS_COMMON_TT_BANK', '<table cellspacing="0" cellpadding="5" border="0" class="m_yh_information">
						  <tr>
							<td>Название банк получателя: </td>
							<td><b>HSBC Hong Kong</b></td>
						  </tr>
						  <tr>
							<td>Получатель: </td>
							<td><b>FS.COM LIMITED</b></td>
						  </tr>
						  <tr>
							<td>Счет получателя: </td>
							<td><b>817-888472-838</b></td>
						  </tr>
						  <tr>
							<td>SWIFT Код: </td>
							<td><b>HSBCHKHHHKH</b></td>
						  </tr>
						  <tr>
							<td>Адрес банка получателя: </td>
							<td><b>1 Queen\'s Road Central, Hong Kong</b></td>
						  </tr>
					  </table>');
//2017-12-14  ery  add  manage_orders和account_history_info页面reorder提示语
define('FS_COMMON_REORDER_CLOSE', 'Очень жаль, что данный продукт(ы) не существует или больше не доступен.');
define('FS_COMMON_REORDER_CUSTOM', 'Это продукт(ы) с индивидуальным требованиям. Пожалуйста, повторите выбор параметров.');
define('FS_COMMON_REORDER_SKIP', 'Пропустить и продолжить');

define("FS_POPUP_TIT_ALERT", "Подпись обязательна для доставки. Мы не отправляем в почтовые ящики.");
define("FS_POPUP_TIT_ALERT_NOT_PO", "Подпись обязательна для доставки.");
define("FS_POPUP_TIT_ALERT2", "Мы не отправляем в почтовые ящики.");
//2017-12-15  ery  add  前台相关打印发票页面的公司地址
// 武汉仓
define('FS_COMMON_WAREHOUSE_CN','Получатель: FS. COM LIMITED<br> 
			Адрес: A115 Jinhetian Business Centre No.329,<br> 
			Longhuan Third Rd<br> 
			Longhua District<br> 
			Shenzhen, 518109, China<br>
			Тел.: +86-0755-83571351');

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
			Тел: +49 (0) 8165 80 90 517');
define('FS_COMMON_WAREHOUSE_US','FS.COM INC <br>
			380 CENTERPOINT BLVD<br>
			NEW CASTLE, DE 19720<br>
			United States <br>
			Тел: +1 (888) 468 7419');
// 美东仓
define('FS_COMMON_WAREHOUSE_US_EAST','Получатель: FS.COM Inc.<br>
					Адрес: 380 Centerpoint Blvd,<br>
					New Castle, DE 19720,<br>
					United States<br>
					Тел.: +1 (888) 468 7419');
// 澳洲仓 （澳大利亚）
define('FS_COMMON_WAREHOUSE_AU','FS.COM PTY LTD<br>
				57-59 Edison Road<br>
				Dandenong South<br>
				VIC 3175<br>
				Australia<br>
				Тел: +61 3 9693 3488<br>
				ABN: 71 620 545 502');
define('FS_COMMON_WAREHOUSE_SG','FS TECH PTE. LTD<br>
				30A Kallang Place #11-10/11/12<br>
				Singapore 339213<br>
				Singapore<br>
				Тел: (65) 6443 7951<br>
				GST Reg No.: 201818919D');
// 新加坡仓
define('FS_COMMON_WAREHOUSE_DELIVER_TO_SG','Получатель: FS Tech Pte Ltd.<br>
				Адрес: 30A Kallang Place #11-10/11/12<br>
				Singapore 339213<br>
				Singapore<br>
				Тел.: +(65) 6443 7951');
define("QTY_SHOW_ZERO", "шт на");
define("QTY_SHOW_MORE", "шт на складе");
define("QTY_SHOW_ZERO_STOCK", "шт");
define("QTY_SHOW_MORE_STOCK", "шт");
define("QTY_SHOW_MORE_STOCK", "шт");
define("QTY_SHOW_ZERO_STOCK_1", "шт в наличии");
define("QTY_SHOW_MORE_STOCK_2", " шт в наличии");

define("CHECKOUT_EIDT_TIT_FS", "* пожалуйста, редактируйте и обновляйте ваш адрес");
define("CHECKOUT_EIDT_TIT_FS1", "Редактировать адрес доставки");
define("CHECKOUT_EIDT_TIT_FS2", "Редактировать платёжный адрес");
define("CHECKOUT_EIDT_TIT_FS3", "* Пожалуйста, редактируйте и обновляйте ваш платёжный адрес");

define("FS_IN_STOCK", "в наличии");
define("QTY_SHOW_ZERO3", "шт in");


//再次付款
/**************************html_checkout_payment_against_paypal.php**************************/
define('FS_AGAINST_PROCEED', 'Перейти в Paypal');
/************************** add by Aron html_checkout_gloabal**************************/
define("GLOBAL_FIRSTNAME", "Имя");
define("GLOBAL_LASTNAME", "Фамилия");
define("GLOBAL_ADDRESS1", "Адрес, Первая Строка");
define("GLOBAL_ADDRESS2", "Адрес, Вторая Строка(не обязательно)");
define("GLOBAL_POSTAL", "Почтовый Индекс");
define("GLOBAL_CITY", "Город");
define("GLOBAL_COUNTRY", "Страна/Регион");
define("GLOBAL_PHONE", "Номер Телефона");
define("GLOBAL_STATE", "Край / Область / Регион");
define("GLOABL_VAT", "НОМЕР VAT");
define("GLOABL_COMPANY", "Название Компании");
define("GLOABL_ADRESSTYPE", "Тип Адреса");
define("GLOABL_CART", "Корзина");
define("GLOABL_EDIT_BILLING", "Редактировать Ваш Платёжный Адрес");
define("GLOABL_CHECK_FOLLOWING", "Пожалуйста, проверьте ниже…");
define("GLOABL_CHECKETOUT", "Оформить заказ");
define("GLOABL_SUCCESS", "Успешно");
define("GLOABL_LIVECHAT", "Чат Сейчас");
define("GLOBAL_TEXT1", "Если у вас имеется вопрос о статусе заказа, свяжитесь с вашим менеджером по продажам, пожалуйста. ");
define("GLOBAL_TEXT2", "Платёж отклонен. Попробуйте другую кредитную карту или измените способ оплаты на PayPal или банковский перевод (Wire Transfer).");
define("GLOBAL_TEXT3", "Пожалуйста, убедитесь, что платежный адрес, указанный ниже, совпадает с данными Вашей банковской карты. Обратите внимание, что адрес доставки и платежный адрес должны совпадать. ");

define("GLOBAL_TEXT4", "Оплата кредитной/дебетовой картой");
define("GLOBAL_TEXT5", "Мы принимаем к оплате следующие кредитные и дебетовые карты. Пожалуйста, выберите тип карты и заполните информациию ниже. После этого нажмите кнопку “Продолжить”, чтобы подтвердить заказ.(В целях безопасности мы не сохраняем данные Вашей банковской карты на нашем сайте.) ");

define("GLOBAL_TEXT6", "Выберите тип банковской карты:");

define("GLOBAL_TEXT7", "Сумма заказа");
define("GLOBAL_TEXT8", "Номер Заказа:");
define("GLOBAL_TEXT9", "Нужна помощь? ");
define("GLOBAL_TEXT10", " Перейти в центр Помощи или  ");
define("GLOBAL_TEXT11", " Адрес выставления счета  ");
define("GLOBAL_TEXT12", "Редактировать");
define("GLOBAL_TEXT13", "Номер Карты");
define("GLOBAL_TEXT14", "Дата Окончания Действия карты");
define("GLOBAL_TEXT15", "Месяц");
define("GLOBAL_TEXT16", "Год");
define("GLOBAL_TEXT17", "Защитный Код");
define("ADDRESS_TYPE1", "Рабочий");
define("ADDRESS_TYPE2", "Частный");
define("CHECKOUT_PLEASE1", "выберите");
define("GLOABL_VAT_PLEASE2", "Действительный номер TAX/VAT например:DE123456789");
define("ADDRESS_TYPE_TIT1", "Тип адреса не может быть пустым");
define("ADDRESS_TYPE_TIT2", "Страна не может быть пустой");
define('FS_SUCCESS_ORDER_DINGDAN', 'Заказ #');
define("FS_QUESTION", "Если у Вас есть любой вопрос, позвоните нам");
define("FS_EMAIL_US", "или напишите нам");
define("FS_NOT_NULL", "Номер заказа на поставку(PO) не может быть пустым");
define("FS_SYSTEM_ERROR_TIT", "Если у вас имеется вопрос о статусе заказа, свяжитесь с вашим менеджером по продажам, пожалуйста.");

define('EMAIL_CHECKOUT_SUCCESS_YOUR', ' Su pago del pedido confirmado.');
define('EMAIL_CHECKOUT_SUCCESS_WE', 'Мы уже получили Вашу оплату за заказ ');
define('EMAIL_CHECKOUT_SUCCESS_THANK', ' Спасибо Вам за поддержку.');

//2018-1-24  ery  add   产品详情页属性未勾选加入购物车的提示语
define('FS_PRODUCT_INFO_ATTR_PLEASE','Пожалуйста, выберите опцию для каждого атрибута.');
//产品详情页长度定制框语言包
define('FS_LENGTH_CUSTOM_FEET', 'Feet Or');
define('FS_LENGTH_CUSTOM_METER', 'Meter');
define('FS_PRODUCTS_AOC_LENGTH_ERROR','Длина кабеля может быть заказана от 0.5 м до 100 м (от 1.64ft до 328.084.ft), как Вам требуется.');

//2018 1-9.aRON 游客邮件
define("FS_GUEST_EMAIL_THANK", "в качестве гостя");
define("FS_GUEST_EMAIL_CONTACT", "Мы будем держать Вас в курсе статуса заказа по данному адресу почты. Если у вас есть дополнительные вопросы о вашем заказе, пожалуйста, свяжитесь с ");

define("CHECKOUT_TAXE_US_TIT", "О налоге с продаж (sales tax) и  пошлинах");
define("CHECKOUT_TAXE_US_FRONT", "Если товары отправляются с нашего склада в США в штате Вашингтон, налог с продаж в размере 10% будет взиматься в соответствии с налоговым законодательством штата Вашингтон. Однако если Вы можете предоставить действительный сертификат освобождения от налогов для штата (ов), где Вы находитесь, налог с продаж не будет взиматься. Заказы, отправляемые в Канаду и Мексику, свободны от налога с продаж, но покупатель несет ответственность за таможенное оформление и оплату пошлин. При размещении заказа онлайн мы будем взимать стоимость доставки. Если необходимо, FS.COM может помочь с организацией предоплаты таможенных сборов.");
define("CHECKOUT_TAXE_US_BACK", "При отправке со склада CN, FS.COM взимает только стоимость товаров и доставки. Импортные сборы или таможенные пошлины могут взиматься в зависимости от законов стран назначения после того, как посылки доставляются до стран назначения. Дополнительные сборы за таможенное оформление возлагаются на получателя; мы не можем контролировать эти сборы. Таможенная политика разных стран сильно отличаются. Мы советуем Вам связаться с локальными таможенными органами для получения дополнительной информации. При необходимости компания FS.COM может помочь заранее уплатить таможенные сборы.");

define("CHECKOUT_TAXE_CN_TIT", "О пошлинах и налогах");
define("CHECKOUT_TAXE_CN_TIT1","О пошлинах и налогах");
define("CHECKOUT_TAXE_CN_FRONT", "Для заказов, отправленных с нашего склада CN, мы ТОЛЬКО взимаем стоимость продукта и доставки. Никакой налог с продаж (например, НДС или GST) не взимается. Однако, для этих заказов импортные или таможенные сборы могут взиматься в зависимости от законов/правил конкретных стран. Дополнительные сборы за таможенное оформление возлагаются на получателя. Если вам нужна помощь в предварительной оплате таможенной пошлины, пожалуйста, свяжитесь с нами.");

define("CHECKOUT_TAXE_DE_TIT", "О НДС(Налоге на добавочную стоимость) & О пошлинах и налогах");
//俄语
define("CHECKOUT_TAXE_DE_FRONT","Все товары будут отправлены со склада Германии. В соответствии с законами, регулирующими деятельность членов Европейского Союза, компания FS.COM GmbH обязана взимать НДС со всех заказов, доставляемых в страны Европейском Союзе.");
define("CHECKOUT_TAXE_DE_BACK","<div class=\"help-center-table\"><div class=\"help-center-taHead help-center-taTr\"><div>Страна назначения</div><div>НДС &amp; Тариф</div></div><div class=\"help-center-taTr\"><div>Германия</div><div>НДС 19% будет взиматься</div></div><div class=\"help-center-taTr\"><div>Франция и Монако</div><div>Взимается НДС в размере 20%, но если указан действительный идентификатор НДС в ЕС, НДС будет отменен.</div></div><div class=\"help-center-taTr\"><div>Нидерланды, Испания, Бельгия.</div><div>Взимается НДС в размере 21%, но если указан действительный идентификатор НДС в ЕС, НДС будет отменен.</div></div><div class=\"help-center-taTr\"><div>Италия</div><div>Взимается НДС в размере 22%, но если указан действительный идентификатор НДС в ЕС, НДС будет отменен.
</div></div><div class=\"help-center-taTr\"><div>Швеция</div><div>Взимается НДС в размере 25%, но если указан действительный идентификатор НДС в ЕС, НДС будет отменен.</div></div><div class=\"help-center-taTr\"><div>Другие члены ЕС</div><div>Взимается НДС в размере 19%, но если указан действительный идентификатор НДС в ЕС, НДС будет отменен.</div></div><div class=\"help-center-taTr\"><div>Страны не входящие в ЕС</div><div>НДС не взимается, но таможенное оформление несет получатель. </div></div></div>");
define("CHECKOUT_TAXE_NEW_CN_CONTENT","Продукты в наличии на нашем складе в США будут отправлены напрямую из Делавера в любое место США. FS.COM будет взимать ТОЛЬКО стоимость продукта и стоимость доставки. Никакой налог с продаж не взимается.<br/><br/>Если заказы содержат продукты, которые временно отсутствуют на складе в США, мы отправим их вам напрямую со склада в Азии, чтобы ускорить доставку. Если на странице с описанием продукта есть информация \"Бесплатная Доставка\", FS.COM будет нести все возможные пошлины и тарифы, связанные с оформлением импорта. <br/><br/>Для продуктов, которые НЕ имеют информацию \"Бесплатная Доставка\" на странице продукта, они являются тяжелыми или негабаритными. Они будут отправлены напрямую со склада в Азии и не могут получить бесплатную доставку. И любые возможные расходы, связанные с таможенным оформлением, должны нести вы сами.");
define("CHECKOUT_TAXE_NEW_CA_CONTENT","Продукты в наличии на нашем складе в США будут отправлены напрямую из Делавера в любое место Канады.<br/><br/>Если заказы содержат продукты, которые временно отсутствуют на складе в США, мы отправим их вам напрямую со склада в Азии, чтобы ускорить доставку. <br/><br/>Когда вы размещаете заказ онлайн, FS.COM взимает ТОЛЬКО стоимость продукта и стоимость доставки. Любые возможные пошлины и тарифы, вызванные таможенным оформлением, должны нести вы сами.");
define("CHECKOUT_TAXE_NEW_MX_CONTENT","Продукты в наличии на нашем складе в США будут отправлены напрямую из Делавера в любое место Мексики.<br/><br/>Если заказы содержат продукты, которые временно отсутствуют на складе в США, мы отправим их вам напрямую со склада в Азии, чтобы ускорить доставку. <br/><br/>Когда вы размещаете заказ онлайн, FS.COM взимает ТОЛЬКО стоимость продукта и стоимость доставки. Любые возможные пошлины и тарифы, вызванные таможенным оформлением, должны нести вы сами.");


//游客页面注册
define("REGITS_FROM_GUEST_EMAIL_ERROR1", "Адрес почты требуется.");
define("REGITS_FROM_GUEST_EMAIL_ERROR2", "Введите действительный адрес почты. (например:someone@gmail.com)");
define("REGITS_FROM_GUEST_PASSWORD_ERROR1", "не менее 6 символов; минимум одна буква и одна цифра в пароле.");
define("REGITS_FROM_GUEST_PASSWORD_ERROR2", "Пароли должны быть одинаковыми.");
define("REGITS_FROM_GUEST_ASK", "Хотели бы Вы создать новый аккаунт?");
define("REGITS_FROM_GUEST_CAN", "Остался ещё один шаг, чтобы получить больше услуг. Имея свой аккаунт FS, Вы можете:");
define("REGITS_FROM_GUEST_EASY", "Отслеживать заказ онлайн");
define("REGITS_FROM_GUEST_FASTER", "Более быстро оформить заказ с помощью списка адресов");
define("REGITS_FROM_GUEST_NO", "Нет, спасибо.");
define("REGITS_FROM_GUEST_YES", "Да, хочу создать новый аккаунт.");
define("REGITS_FROM_GUEST_USE", "Использовать мой адрес почты при оформлении заказа");
define("REGITS_FROM_GUEST_OR", "ИЛИ");
define("REGITS_FROM_GUEST_HISTORY", "если адрес электронной почты для оформления заказа отличается от адреса почты для регистрации, они будут автоматически связаны, чтобы мы служили вам лучше. Письма о заказе будут отправлены на Вашу почту, которая используется при регистрации. С этим адресом почты вы можете войти в свой аккаунт FS.COM для управления и отслеживания заказов в любое время.");
define("REGITS_FROM_GUEST_PASWORD", "Пароль");
define("REGITS_FROM_GUEST_CPASWORD", "Повторить пароль");
define("REGITS_FROM_GUEST_NOTE", 'Обратите внимание: Ваш номер телефона требуется, чтобы кульер смог связаться с Вамми. И адрес почты требуется, чтобы мы могли держать Вас в курсе статуса заказа.<br>Вы можете посетить страницу <a href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">Политика конфиденциальности и Cookies</a> для подробности.');
define("REGITS_FROM_GUEST_EXSIT1", "Данный адрес почты существует в нашей системе. Пожалуйста, прямо войдите в Ваш аккаунт. &nbsp;&nbsp;&nbsp;&nbsp;");
define("REGITS_FROM_GUEST_EXSIT2", "Войти »");
define("REGIST_NUM_LENGTH", "не менее 6 символов");
define("REGIST_NUM_LEAST", "не менее 6 символов; минимум одна буква и одна цифра в пароле.");

//春节设置,请勿乱修改,1->开启春节分仓 0->关闭春节分仓
define("FS_IS_SPRING", 0);
define("CN_SPRING_WAREHOUSE_MESSAGE", "Продукты в наличии на складе в Китае будут отправлены после Китайского Нового года (10 фев 2018 - 20 фев 2018).");
define("FS_EMPTY_COST", "К сожалению, доступных способов доставки в Ваш регион пока нет. Пожалуйста, выберите свой аккаунт перевозчика для оплаты доставки. Если Вас интересует другая логистическая служба и нужна наша помощь, <a href='https://www.fs.com/ru/contact_us.html'>свяжитесь с нами</a>, пожалуйста.");
define("FS_RU_SPRING", "Напоминание：Заранее приносим Вам свои извинения: в период китайского нового года (10.02.2018-20.02.2018), доставка заказов в страны, не являющиеся членами Евросоюза, будет осуществляться только из США. Из-за ограничений российской таможни и сервисов быстрой доставки, мы отправим Вам товары с нашего китайского склада после окончания праздников.");
define("FS_QTY_CHANGED", "Пожалуйста, оплатите заказ как можно скорее, чтобы мы обработали его при вервой возможности. Иначе Ваш заказ может быть задержан из-за отсутствия наличия продукта.");
define("CN_SPRING_WAREHOUSE_MESSAGE1", "Обратите внимение: Заказ ");
define("CN_SPRING_WAREHOUSE_MESSAGE2", "будет отправлен с киатайского склада после окончания китайского нового года (06.02.2018-20.02.2018).");
define("FS_JS_TIT_CHECK1", "</br>Время самовывоза: ");
define("FS_JS_TIT_CHECK2", "Тихоокеанское время：");
define("FS_JS_TIT_CHECK3", "Понедельник-Пятница");
define("FS_JS_TIT_CHECK4", "10:00am - 12:00am");
define("FS_JS_TIT_CHECK5", ", 2:00pm - 5:30pm ");
define("FS_JS_TIT_CHECK_US","9:30 - 17:30");
define("FS_JS_TIT_CHECK6", "Имя в удостоверении личности");
define("FS_JS_TIT_CHECK7", "Адрес почты");
define("FS_JS_TIT_CHECK8", "Номер телефона");
define("FS_JS_TIT_CHECK9", "Выбор времени самовывоза");
define("PICK_UP_ALERT1", 'к сожалению, имя в удостоверении личности обязательно.');
define("PICK_UP_ALERT2", 'к сожалению, номер удостоверении личности обязательно.');
define("PICK_UP_ALERT4", 'Выберите время самовывоза.');
define("REGITS_FROM_GUEST_EMAIL_ERROR3", "Введите действительный адрес почты.");
define('FS_CHECKOUT_MONDAY_TO_FRIDAY', ' | Пн.-Пт.');
//helun 客户提出问提成功
define('FS_MODIFY_EMAIL_MY_CASE_01', 'Ваш вопрос');
define('FS_MODIFY_EMAIL_MY_CASE_02', 'подтвержден.');
define('FS_MODIFY_EMAIL_MY_CASE_03', 'Спасибо Вам за то, что связались с <a href="' . HTTPS_SERVER . '/" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a>. Это письмо отправлено, чтобы сообщить Вам о получении Вашего вопроса');
define('FS_MODIFY_EMAIL_MY_CASE_04', 'Наша <a href="' . HTTPS_SERVER . '/" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> команда продаж будет отвечать на Ваш вопрос в течение 12 часов.');
define('FS_MODIFY_EMAIL_MY_CASE_05', 'Если Вам нужна быстрая помощь, пожалуйста, свяжитесь с нами по телефону <a href="tel:++1 (888) 468 7419" style="color:#232323; text-decoration:none;">+1 (888) 468 7419</a>. Вы также можете получить быструю помощь через Чат Сейчас.');
define('FS_MODIFY_EMAIL_MY_CASE_06', 'С уважением,');
define('FS_MODIFY_EMAIL_MY_CASE_07', 'Каманда поддержки <a href="' .zen_href_link('index'). '" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a>');
define('FS_MODIFY_EMAIL_MY_CASE_08', 'Уважаемый/ая');
define('FS_MODIFY_EMAIL_MY_CASE_09', 'FS.COM - Номер вопроса: ');

//request_stock
define("FS_EMAIL_REQUEST_STOCK_01","FS.COM - Мой Спрос & Номер Вопроса: ");
define("FS_EMAIL_REQUEST_STOCK_02","Ваш запрос на продукт #");
define('FS_EMAIL_REQUEST_STOCK_11',' получен.<br />
									Номер Вопроса:');
define("FS_EMAIL_REQUEST_STOCK_03","Уважаемый/ая ");
define("FS_EMAIL_REQUEST_STOCK_04","Большое спасибо Вам за запрос. Очень Важно для нас, чтобы наш отдел управления запасами знал Ваш спрос. Ваш специальный менеджер по продажам будет связываться с Вами. В то же время, ");
define("FS_EMAIL_REQUEST_STOCK_05"," отдел управления запасами будет изучать Ваш спрос и оптимизировать наш план управления запасами. ");
define('FS_EMAIL_REQUEST_STOCK_06','Если Вам нужна быстрая помощь, прямо позвоните нам по номеру телефона <a href="tel:+7 (499) 643 4876" style="color:#232323; text-decoration:none;">+7 (499) 643 4876</a> . Вы также можете связаться с нами через Онлайн-Чат.');
define('FS_EMAIL_REQUEST_STOCK_07','С уважением,');
define('FS_EMAIL_REQUEST_STOCK_08','<a href="'.zen_href_link('index').'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> Команда поддержки ');
define('FS_EMAIL_REQUEST_STOCK_09','Уважаемый/ая');
define('FS_EMAIL_REQUEST_STOCK_10','FS.COM - Номер вопроса: ');

//2017-12-29   ery  add  sales_service_details
define('SALES_DETAILS_PRINT_LABEL', 'Распечатать транспортную этикетку');
define('SALES_DETAILS_LABEL_MSG', 'FS.COM открыл доступ к печати транспортной этикетки для обратной доставки. 
Пожалуйста, прикрепите транспортную этикетку к внешней стороне коробки и отправьте его нам в ближайшем пункте UPS.');
define('SALES_DETAILS_PSL', 'Распечатать транспортную этикетку');
define('FS_SALES_DETAILS_COMMENT', 'Комментарии (обязательно)');
define('FS_SALES_DETAILS_REVIEW', 'Обзор Возврата/Замены Товара');
define('FS_SALES_DETAILS_NO', 'Номер RMA');
define('FS_SALES_DETAILS_STATUS', 'Статус RMA');
define('FS_SALES_DETAILS_AMOUNT', 'Сумма');
define('FS_SALES_DETAILS_RPI', 'Информация о возмещении средств');
define('FS_SALES_DETAILS_RA', 'Сумма Возмещения');
define('FS_SALES_DETAILS_RM', 'Способ Возмещения');
define('FS_SALES_DETAILS_SAME', 'Тот же способ, который Вы оплатили покупку');
define('FS_SALES_DETAILS_NOTE', 'Обратите внимание: окончательная сумма возмещения будет указана в письме с подтверждением возврата, которое будет отправлено Вам.');
define('FS_SALES_DETAILS_PROCESS', 'Процесс RMA');
define('FS_SALES_DETAILS_AWB', 'Обновить AWB');
define('FS_SALES_DETAILS_ADDRESS', 'Подтверждение Адреса');
//2017-12-30  ery    add
define('FS_SALES_INFO_REQUEST', 'Заявка RMA');
define('FS_SALES_INFO_A', 'Заявка на возврат не гарантирует получение номера разрешения на возврат и должна быть проверена, так как некоторые товары не возвращаются.');
define('FS_SALES_INFO_PLEASE', 'Пожалуйста, ознакомьтесь с Условиями Продаж и Политикой Возврата и Замены Товара. Вы будете сообщены в течение 24 часов, если ваша заявка была одобрена или отклонена.');
define('FS_SALES_INFO_YOU', 'Максимум ');
define('FS_SALES_INFO_WHAT', 'Укажите причину возврата товара.');
define('FS_SALES_INFO_QI', 'Проблема с качеством');
define('FS_SALES_INFO_SI', 'Проблема с обслуживанием');
define('FS_SALES_INFO_OI', 'Другие проблемы');
define('FS_SALES_INFO_WE', "Мы не можем сделать исключения");
define('FS_SALES_INFO_ATTA', 'Загрузка файла');
define('FS_SALES_INFO_ALLOW', 'Поддерживаются форматы: PDF, JPG, PNG.');
define('FS_SALES_INFO_ADD', 'Добавить фото');
define('FS_SALES_INFO_VERIFY', 'Проверить адрес RMA');
define('FS_SALES_INFO_KIND', 'Обратите внимание');
define('FS_SALES_INFO_OUR', 'Наша послепродажная команда будет связываться с вами. Пожалуйста, держите телефон открытым.');
define('FS_SALES_INFO_I', 'Я соглашаюсь с ');
define('FS_SALES_INFO_RP', 'Политикой Возврата и Замены Товара');
define('FS_SALES_INFO_PLEASE_AGREE', 'Пожалуйста, соглашайтесь с Политикой Возврата и Замены Товара, чтобы продолжить.');
define('FS_SALES_INFO_PLEASE_WRITE', 'Напишите вашу проблему.');
define('FS_SALES_INFO_ITEMS', 'Продукты не работают должным образом');
define('FS_SALES_INFO_MIS', 'Размер не соответствует ');
define('FS_SALES_INFO_DID', 'Продукты не соответствуют описанию');
define('FS_SALES_INFO_RE', 'Продукты некачественные');
define('FS_SALES_INFO_UN', 'Не отправляются товары в удобное время для меня');
define('FS_SALES_INFO_DA', 'Товары повреждены при доставке');
define('FS_SALES_INFO_NO', 'Больше не нужны');
define('FS_SALES_INFO_NOT', 'Не так, как ожидалось');
define('FS_SALES_INFO_WRONG', 'Купил неправильные продукты');
define('FS_MANAGE_ORDERS_PO', 'Номер PO');
define('FS_MANAGE_ORDERS_RE', 'Проверена');
define('FS_MANAGE_ORDERS_TN', 'Номер для отслеживания');
define('FS_MANAGE_ORDERS_MORE', 'Товар');
define('FS_MANAGE_ORDERS_RECORDA', 'показывать по');
define('FS_MANAGE_ORDERS_PURCHASE', "Номер PO не может быть пустым");
define("FS_MANAGE_ORDERS_FILE","Пожалуйста, загрузите ваш Заказ на покупку(PO) файл.");
define('FS_MANAGE_ORDERS_OC', "Комментарии заказа");
//2018-1-3   ery    add
define('FS_SALES_DETAILS_RAE', 'Легко возвратить ');
define('FS_SALES_DETAILS_NO_LABEL', 'Пожалуйста, следуйте блок-схеме ниже для возврата товара. Мы предоставляем вам обратный адрес доставки, потом вы отправляете товары через транспортную компанию, которую вы выбрали. Пожалуйста, сообщите нам номер отслеживания. Если у вас есть любой вопрос, свяжитесь с нами для немедленной помощи.');
define('FS_SALES_DETAILS_LABEL', 'Пожалуйста, следуйте блок-схеме ниже для возврата товара. Мы предоставляем вам этикетку для обратной доставки, потом вы отправляете нам товары в авторизованном пункте UPS с данной этикеткой, по которой вы можете отслеживать товар на обратном пути к нам.');
define('FS_SALES_DETAILS_CR', 'Отменить RMA');
//2018-1-22    ery  add   sales_service_info页面
define('FS_SALES_INFO_NUMBER', 'Серийный номер');
define('FS_SALES_INFO_FOR', 'Пожалуйста, укажите серийный номер модуля, чтобы мы могли лучше определить и решить проблему.');
define('FS_SALES_INFO_BRIEFLY', 'Кратко опишите проблему');
define('FS_REFUND_PROCESSING', 'Возмещение средств в обработке');
define('FS_REFUND_APPLICATION', 'Заявка на вомещение средств');
define('FS_REFUND_SUCCESS_MSG', 'Возмещение средств завершено. Пожалуйста, проверьте выписку по счету.');
define('FS_REFUND_FAIL_MSG', 'К сожалению, ваша заявка на возмещение средств отклонена. Если у вас есть вопрос, свяжитесь с нами, пожалуйста.');
define('FS_REFUND_APPMSG', 'Ваша заявка на возмещение находится на рассмотрении. Скоро будет результат.');
define('MANAGE_ORDER_SEARCH_NO', 'Номер/ID PO/Заказа');
define('FIBERSTORE_ORDER_PROMT_RMA', 'Нет заявки RMA.');

//2018-3-19   add   ery  产品详情页Compatible Brands属性未勾选的提示语
define('FS_PRODUCT_INFO_BRAND_PLEASE', 'Выберите бренд, пожалуйста.');
define('FS_PRODUCT_INFO_BRAND_CHOOSE', 'выбрать бренд');

//fairy 整理公共的
// 公共表单
define ('FS_TAX_ERROR_EMPTY', 'Введите действительный налоговый номер，пожалуйста.');
define('FS_SECURITY_ERROR', 'Возникла ошибка безопасности.');  // token验证不正确
define('FS_SYSTME_BUSY', 'Система занята. Пожалуйста, повторите попытку позже.'); // 异步提交，连接服务器出现error情况
define('FS_ACCESS_DENIED', 'Ошибка: Доступ закрыт.'); //没有权限访问
define('FS_ACCESS_DENIED_1', 'Ошибка: код 999.');
define('FS_FORM_REQUEST_ERROR', 'Система занята. Пожалуйста, повторите попытку позже.');
define('FS_NON_MANDAROTY', "Необязательно");
define('FS_COMMON_SAVE', "Сохранить");
define('FS_COMMON_CANCEL', "Отменить");
define('FS_COMMON_YES',"Да");
define('FS_COMMON_NO',"Нет");
define('FS_COMMON_SUBMIT',"Отправить");
define('FS_COMMON_PROCESSING',"В обработке");
define('FS_COMMON_EDIT','Редактировать');
define('FS_COMMON_LESS',"Менее");
define('FS_CONFIRM','Подтвердить');
define("FS_PLEASE_CHOOSE_ONE",'Пожалуйста, выберите один...');

//验证码 start
define('FS_ENTER_CHARACTER',"Введите символы, которые вы видите");
define('FS_IMAGE_REQUIRED_TIP',"Введите символы на картинке, пожалуйста.");
//验证码-服务器端的验证
define('FS_IMAGE_ERROR_TIP',"Символы неверные. Попробуйте еще раз, пожалуйста.");
define('FS_IMAGE_EXPIRE_TIP',"Из-за долгого времени нет операций, пожалуйста, обновите символы и повторите ввод.");
define('FS_IMAGE_FIRST_SHOW_PWD_ERROR_TIP',"Чтобы надежнее защитить свой аккаунт,  введите пароль ещё раз, затем введите символы, указанные на картинке ниже, пожалуйста.");
define('FS_IMAGE_FIRST_SHOW_EMAIL_ERROR_TIP',"Чтобы надежнее защитить свой аккаунт, пожалуйста, введите адрес электронной почты еще раз, затем введите символы, указанные на картинке ниже.");
//验证码 end

// 公共的
define('FS_USERNAME', 'Имя пользователя');
define('FS_FIRST_NAME', "Имя");
define('FS_LAST_NAME', "Фамилия");
define('FS_PASSWORD', "Пароль");
define('FS_EMAIL_ADDRESS', "E-mail");

define('FS_EMAIL_ADDRESS1', "E-mail");
define('FS_COMPANY_WEBSITE', "Сайт Компании");
define('FS_INDUSTRY', "Отрасль");
define('FS_COMPANY_NAME', "Название Компании");
define('FS_ENTERPRISE_OWNER_NAME', "ФИО Предприятия-владельца");
define('FS_YOUR_COUNTRY', "Страна/Регион");
define('FS_COUNTRY', "Страна/Регион");
define('FS_OTHER_COUNTRIES', " Другие страны/регионы");
define('FS_SELECT_YOUR_COUNTRY_REGION','Выберите вашу страну/регион');
define('FS_SELECT_COUNTRY_REGION','Выберите страну/регион');
define('CURRENT','Сейчас');
define('MAIN_MENU','Главное меню');
define('FS_COMMON_COUNTRY_REGION','Страна/Регион');
define('FS_SELECT_CURRENCY','Выберите Язык/Валюту');
define('FS_LANGUAGE_CURRENCY','Язык/Валюта');
define('FS_VAT_NUMBER', "Налоговый номер");
define('FS_PHONE_NUMBER', "Телефона");
define('FS_COMMON_COMPANY','Компания');
define('FS_FOOTER_COMPANY_INFO','Компания');
define('FS_QTY','Кол-во');
define ('FS_OPTIONAL_COMPANY', ' (необязательно)');
// 公共的
define('FS_OR', 'или');
define('FS_OTHERS', 'Другие');
define('FS_LOADING', "Загрузка");
define('FS_SHOW', "Показать");
define('FS_HIDE', "Скрыть");
define('FS_HELLO', 'Здравствуйте');
define('FS_COMMON_MORE','Больше');
define('FS_COMMON_CUSTOMIZED','Заказной');
// 公共的
define('FS_COPY', "Copyright");
define('FS_RIGHTS', "Все права защищены");
define('FS_TERMS_OF_USE', "Условия использования");
define('FS_POLICY', "Конфиденциальность");
define('FS_AGREE_POLICY','Нажимая кнопку ниже, вы соглашаетесь с  <a href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'" target="_blank">Политикой конфиденциальности и использования файлов Cookies</a> и <a href="'.HTTPS_SERVER.reset_url('policies/terms_of_use.html').'" target="_blank">Условиями использования</a>.');
define('FS_FOOTER_COOKIE_TIP','Мы используем cookies, чтобы обеспечить вам лучший опыт покупок. Продолжая использовать этот сайт, вы соглашаетесь с использованием файлов cookie в соответствии с нашей <a href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">политикой конфиденциальности</a>.');
define('FS_FOOTER_COOKIE_MOBILE_TIP','Мы используем файлы cookie, чтобы предложить вам лучший опыт покупок. Посмотрите <a href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">Политику конфиденциальности</a>.');
define('FS_I_ACCEPT','Я соглашаюсь');

// 2018.4.3 fairy 报价
define('FS_GET_A_QUOTE_BIG', 'Запросить цену');
define('FS_GET_A_QUOTE_FREE', 'В Корзину');
define('FS_GET_A_QUOTE', 'Запросить цену');
define('FS_REQUEST_DEADLINE','Запрос был закрыт по расписанию. Обновленная версия будет доступна в ближайшее время, пожалуйста, оставайтесь с нами.');

define("FS_SHIPPING_AREA_BY_WAREHOUSE_CN", "Доступно для немедленной отправки со склада в Китае");
define("FS_SHIPPING_AREA_BY_WAREHOUSE_US", "Доступно для немедленной отгрузки со склада в США");
define("FS_SHIPPING_AREA_BY_WAREHOUSE_EU", "Доступна для немедленной отправки со склада в Европе");
define("FS_SHIPPING_AREA_BY_WAREHOUSE_SHORT_CN", "с CN склада");
define("FS_SHIPPING_AREA_BY_WAREHOUSE_SHORT_US", "с U.S. склада");
define("FS_SHIPPING_AREA_BY_WAREHOUSE_SHORT_EU", "с EU склада");
define("FS_BULK_WAREHOUSE", "Расчетное время отправки с CN склада:");
define("FREE_SHIPPING_TEXT1", "Бесплатная доставка для заказа выше €79 (влючаются товары большого размера).");
define("FREE_SHIPPING_TEXT2", "Бесплатная доставка для заказа выше $79 (влючаются товары большого размера).");
define("FS_TIME_ZONE_RULE_US", "(UTC/GMT+1)");
if(SUMMER_TIME){
    define("FS_TIME_ZONE_RULE_EU"," (UTC/GMT+2)");
}else{
    define("FS_TIME_ZONE_RULE_EU"," (UTC/GMT+1)");
}
define('FS_LIMIT_MONEY', "Общая сумма превышает лимит, пожалуйста, разделите заказ или выберите другой способ оплаты!");
define('FS_LIMIT_MONEY_15000','Сумма превышает ограничение (€ 15000), разобьете заказ или выберите другой способ оплаты!');
define('FS_LIMIT_MONEY_10000','Сумма превышает ограничение (€ 10000), разобьете заказ или выберите другой способ оплаты!');

//2018-3-15  ery  add  订单上传logo
define('FS_ATTRIBUTE_OEM', 'OEM/ODM Услуги');
define('NEWS_FS_ATTRIBUTE_OEM','Заказать этикетки');
define('FS_ATTRIBUTE_NONE', 'Нет');
define('FS_ATTRIBUTE_DESIGN', 'Заказная Наклейка');

define('FS_ORDER_LOGO_DESIGN', "Загрузить логотип на наклейке");
define('FS_ORDER_LOGO_YOUR', "Загрузите Логотип или конкретное Название Поставщика & Артикул для справки.");
define('FS_ORDER_LOGO_WE', "Мы подтвердим наклейку и обработаем ваш заказ по требованию. Вы также можете отправить логотип на нашу почту.");
define('FS_ORDER_LOGO_UPLOAD', "Загрузить логотип");
define('FS_ORDER_LOGO_DELETE', "Удалить логотип?");
define('FS_ORDER_LOGO_UP_SUCCESS', 'Логотип успешно загружен.');
define('FS_ORDER_LOGO_DEL_SUCCESS', 'Логотип успешно удален.');
//产品详情页
define("FS_FOR_FREE_SHIPPING", "Бесплатная");
define("FS_SG_FREE_SHIPPING","Бесплатная доставка и установка");
define("FS_SG_NO_FREE_SHIPPING","Бесплатная установка ");
define("FS_FOR_FREE_SHIPPING_US", 'при сумме заказа от $MONEY');
define("FS_FOR_FREES_SHIPPING_ONE", "Если Вы хотите получить заказ завтра, ");
define("FS_FOR_FREES_SHIPPING_TWO", "оформите его ");
define("FS_FOR_FREES_SHIPPING_TIME", "до 16:00 PST");
define("FS_FOR_FREES_SHIPPING_TIME_UP", "до 16:00 PST");
define("FS_FOR_FREES_SHIPPING_THREE", "и выберите опцию Overnight Shipping (доставка на следующий день) при оплате.");
define("FS_FOR_FREES_SHIPPING_FOUR", "Доставка:");
define("FS_FOR_FREES_SHIPPING_FIVE", "Получить заказ в течение 1-3 рабочих дня можно при его оформлении до <span>16:00 PST</span>.");
define("FS_FOR_FREES_SHIPPING_FIVE_CA_UP", "Получить заказ в течение 1-3 рабочих дня можно при его оформлении до <span>16:00 PST</span>.");
define("FS_FOR_FREES_SHIPPING_FIVE_MX_UP", "Получить заказ в течение 1-3 рабочих дня можно при его оформлении до <span>16:00 PST</span>.");
define("FS_FOR_FREES_SHIPPING_SIX", "Хотите получить заказ во вторник? Выберите опцию  Overnight Shipping (доставка на следующий день) при оплате.");
define("FS_FOR_FREE_SHIPPING_DE", "Доставка бесплатна ");
define("FS_FOR_FREE_SHIPPING_DE_MONEY", ' заказов на сумму от $MONEY');
define("FS_FOR_FREES_SHIPPING_FIVE_DE1", " <span>Закажите до 16:00 (UTC/GMT +2)</span> и выберите опцию DHL Express при оплате.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE2", " <span>Закажите до 16:00 (UTC/GMT +2)</span> и выберите опцию UPS Express Saver при оплате.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE3", "Хотите получить заказ быстрее? Оформите его до <span>17:00 (UTC/GMT +2)</span> и выберите опцию UPS Express Saver при оплате.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE4", " <span>до 15:00 (UTC/GMT +1)</span> и выберите опцию UPS Express Saver при оплате.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE5", " <span>до 15:00 (UTC/GMT +1)</span> и выберите опцию UPS Express Saver при оплате.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE6", "Хотите получить заказ быстрее? Оформите его до <span>11:00 (UTC/GMT -3)</span> и выберите опцию UPS Express Saver при оплате.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE7", "Хотите получить заказ быстрее? Оформите его до <span>18:00 (UTC/GMT +4)</span> и выберите опцию UPS Express Saver при оплате.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE8", "Хотите получить заказ быстрее? Оформите его до <span>15:00 (UTC/GMT +1)</span> и выберите опцию UPS Express Saver при оплате.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE9", "Хотите получить заказ быстрее? Оформите его до <span>17:00 (UTC/GMT +3)</span> и выберите опцию UPS Express Saver при оплате.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE10", "<span>до 16:00 (UTC/GMT +3)</span> и выберите опцию UPS Express Saver при оплате.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE11", "Хотите получить заказ быстрее? Оформите его до <span>12:00 (UTC/GMT -2)</span> и выберите опцию DHL Express при оплате.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE12", "Отправим Ваш заказ во вторник, и Вы получите его в течение 1-3 рабочих дня.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE13", "Хотите получить заказ во вторник? Выберите опцию DHL Express при оплате.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE14", "Хотите получить заказ во вторник? Выберите опцию UPS Express Saver при оплате.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE15", "Хотите получить заказ быстрее? Выберите опцию UPS Express Saver при оплате.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE16", "Хотите получить заказ быстрее? Выберите опцию DHL Express при оплате.");
define("FS_FOR_FREE_SHIPPING_GB1", "Бесплатная доставка по Великобритании");
define("FS_FOR_FREE_SHIPPING_GB3", "заказов на сумму от 79 £");
define("FS_FOR_FREE_SHIPPING_GB4", "в Великобританию");
define('FS_ITEM_LOCATION', 'Местонахождение:');
define('FS_SEATTLE_WASHINGTON', 'Сиэтл, США');
define('FS_SEATTLE_EU', 'Мюнхен, Германия');
define('FS_SEATTLE_CN', 'Ухань, Китай');

//详情页Compatible Brands提示 dylan 2019.11.18
define('FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_01','eg: Cisco N9K-C9396PX to Juniper MX960');
define('FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_02','eg: Cisco N9K-C9396PX QSFP+ to Juniper MX960 SFP+');
define('FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_03','eg: Cisco N9K-C9396PX QSFP+ to Juniper EX4200 XFP');
define('FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_04','eg: Cisco N9K-C9396PX QSFP28 to Juniper QFX5200 SFP28');
define('FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_05','eg: Cisco Nexus 5696Q CXP to Juniper MX960 QSFP+');

define ('FS_SELECT_TYPE', 'Наиболее распространенные параметры, купленные нашими клиентами.');
DEFINE ( 'FS_SELECT_DEFAULT', 'По умолчанию');
DEFINE ( 'FS_SELECT_CUSTOMIZE', 'Заказной');
define ('FSCHOOSE_SPECI', 'Выбрать параметры:');

//add by quest 2019-03-11  // 2019 3.18 po产品 shipping弹窗 pico
define("FS_FOR_FREE_SHIPPING_PRE_ORDER","на заказы больше MONEY");
if (get_warehouse_by_code($_SESSION['countries_iso_code']) == 'de') {
    define('FS_PRE_PRODUCTS_SHIPPING_WD_TITLE', "Бесплатная Доставка при Сумме Предзаказа от MONEY");
    define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO', "Чтобы получить право на бесплатную доставку, добавьте в корзину товары минимум  MONEY. Любой товар предзаказа с «БЕСПЛАТНОЙ доставкой» на этой странице является приемлемым и вносит свой вклад в минимальный заказ на бесплатную доставку.");
    define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO_03', "Время обработки товаров для предзаказа составляет около 15 рабочих дней. Мы отправим их после изготовления и тщательного тестирования. Скорость доставки будет зависеть от способа доставки, который вы выберете при оформлении заказа.");
    define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO_04', "Сервис предзаказа поможет вам более гибко и свободно планировать свой проект. Подробнее о <a href ='".zen_href_link('index')."specials/pre-order-service-71.html' target='_blank'>сервисе предзаказа</a>.");
}else {
    define('FS_PRE_PRODUCTS_SHIPPING_WD_TITLE',"Предзаказ, Массовое Снабжение & Зкономия Бюджета");
    define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO', "Чтобы лучше обслуживать наши малые и средние предприятия и крупные предприятия, FS инвестирует в производителя площадью 10 000 квадратных метров и добавляет производственные линии, ориентированные на предзаказ, которые могут помочь клиентам сократить бюджет за счет массового производства и выполнить поставку проекта. ");
    define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO_03', "Время обработки товаров для предзаказа составляет около 15 рабочих дней. Поэтому клиенты могут заранее оформить свои планы закупок для запланированных проектов.");
    define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO_04', "Мы отправим их после изготовления и тщательного тестирования. Скорость доставки будет зависеть от способа доставки, который вы выберете во время оформления заказа. <br><br> Подробнее о <a href ='".zen_href_link('index')."shipping_delivery.html' target='_blank'>сервисе предзаказа</a>.");

}
define("FS_SHIPPING_POLICY_US","Дата доставки применяется к товарам в наличии, купленным до 17:00 EST в рабочие дни. После этого ваш заказ будет отправлен на следующий рабочий день. Если запрошенное вами количество превышает запас, товары будут отправлены в другой партии без дополнительной оплаты. Для подробной информации, обратитесь к странице оформления заказа.");
define("FS_SHIPPING_POLICY_CA","Дата доставки применяется к товарам в наличии, купленным до 17:00 в рабочие дни. После этого ваш заказ будет отправлен на следующий рабочий день. Если запрошенное вами количество превышает запас, товары будут отправлены в другой партии без дополнительной оплаты. Для подробной информации, обратитесь к странице оформления заказа.");
define("FS_SHIPPING_POLICY_MX","Дата доставки применяется к товарам в наличии, купленным до 16:00 в рабочие дни После этого ваш заказ будет отправлен на следующий рабочий день. Если запрошенное вами количество превышает запас, товары будут отправлены в другой партии без дополнительной оплаты. Для подробной информации, обратитесь к странице оформления заказа.");
define("FS_SHIPPING_POLICY_NZ","Дата доставки применяется к товарам в наличии, купленным до 15:00 (AEST/AEDT) в рабочие дни. После этого ваш заказ будет отправлен на следующий рабочий день. Если запрошенное вами количество превышает запас, товары будут отправлены в другой партии без дополнительной оплаты. Для подробной информации, обратитесь к странице оформления заказа.");
define("FS_SHIPPING_POLICY_AU","Дата доставки применяется к товарам в наличии, купленным до 15:00 (AEST/AEDT) в рабочие дни. После этого ваш заказ будет отправлен на следующий рабочий день. Если запрошенное вами количество превышает запас, товары будут отправлены в другой партии без дополнительной оплаты. Для подробной информации, обратитесь к странице оформления заказа.");
define("FS_SHIPPING_POLICY_GB","Дата доставки применяется к товарам в наличии, купленным до ".FS_SUMMER_OR_WINTER_TIME." в рабочие дни. После этого ваш заказ будет отправлен на следующий рабочий день. Если запрошенное вами количество превышает запас, товары будут отправлены в другой партии без дополнительной оплаты. Для подробной информации, обратитесь к странице оформления заказа.");
define("FS_SHIPPING_POLICY_DE","Дата доставки применяется к товарам в наличии, купленным до ".(SUMMER_TIME ? '16:30 (UTC/GMT+2)' : '16:30 (UTC/GMT+1)')." в рабочие дни. После этого ваш заказ будет отправлен на следующий рабочий день. Если запрошенное вами количество превышает запас, товары будут отправлены в другой партии без дополнительной оплаты. Для подробной информации, обратитесь к странице оформления заказа.");
define("FS_SHIPPING_POLICY_CN","Дата доставки применяется к товарам в наличии, купленным до 10:30am (UTC/GMT+3) в рабочие дни. Если запрошенное вами количество превышает запас, товары будут отправлены в другой партии без дополнительной оплаты. Для подробной информации, обратитесь к странице оформления заказа.");
define("FS_SHIPPING_POLICY_SG","Дата доставки применяется к товарам в наличии, купленным до 15:30 (GMT 8) в рабочие дни. После этого ваш заказ будет отправлен на следующий рабочий день. Если запрошенное вами количество превышает запас, товары будут отправлены в другой партии без дополнительной оплаты. Для подробной информации, обратитесь к странице оформления заказа.");
define("FS_SHIPPING_POLICY_RU","Дата доставки применяется к товарам в наличии, купленным до 10:30am (UTC/GMT+3) в рабочие дни. Если запрошенное вами количество превышает запас, товары будут отправлены в другой партии без дополнительной оплаты. Для подробной информации, обратитесь к странице оформления заказа.");

//Delivery & Return Dylan 2019.8.7
define('FS_DELIVERY_RETURN','Гарантия и возврат');
define('FS_FAST_SHIPPING_SOUTH_EAST_ASIA','Быстрая доставка в Юго-Восточную Азию');
define('FS_DELIVERY_FREE_RETURNS_CONTENT','<p>Если товары работают не так, как ожидается, гарантия FS может разрешить возврат, обмен или ремонт товаров. </p><br/>
<p>Мы предлагаем возможность возврата для замены или возмещения стоимости в течение 30 дней для большинства товаров на складе. В течение гарантийного срока мы предоставляем бесплатный ремонт.</p><br/>
<p>Для расходных материалов отсутствует гарантийный срок и бесплатную услугу по ремонту. При обнаружении проблем с качеством после получения товаров, свяжитесь с нами, пожалуйста. Мы решим Вашу проблему в кратчайшие сроки. Просмотрите <a href="'.reset_url("/policies/day_return_policy.html ").'" target="_blank">Политику возврата</a> и <a href="'.reset_url("/policies/warranty.html").'" target="_blank">Гарантию</a> для дополнительной информации.</p>');
define('FS_SHIPPING_INFO_DETAIL_FREE_SHIPPING_STANDARD','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">Заказы с соответсвующими товарами на сумму до $MONEY и более имеют право на бесплатную доставку. Подробности о получении  бесплатной доставки посетите раздел <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Доставки</a>.</div>');
define('FS_SHIPPING_INFO_DETAIL_FAST_SHIPPING_BUCK','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">FS предоставляет несколько вариантов доставки в соответствии с Вашим графиком или бюджетом. И товары в наличии будут отправлены в течение 24 рабочих часов после оформления заказа. Подробност посетите раздел <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Доставки</a>.</div>');
define('FS_SHIPPING_INFO_DETAIL_FAST_SHIPPING_PRE','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">Заказы на предзаказные товары с соответсвующими товарами на сумму до $MONEY  и более имеют право на бесплатную доставку. Подробности о получении  бесплатной доставки посетите раздел <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Доставки</a>.</div>');
define('FS_SHIPPING_INFO_DETAIL_RU','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">Заказы с соответсвующими товарами на сумму до $MONEY ₽лей и более имеют право на бесплатную доставку. Подробности о получении  бесплатной доставки посетите раздел <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Доставки</a>.</div>');

//2017.5.7 add by frankie
define("FS_PRODUCT_DETAILS","Детали Продукта");


define("FS_FESTIVAL1","Государственный праздничный день начинается в Германии ");
define("FS_FESTIVAL2","года. FS.COM GmbH вернется");
define("FS_FESTIVAL3"," на складе в Германии.");
define("FS_FESTIVAL4","года. FS.COM GmbH вернется");
define("FS_FESTIVAL5","nd");
define("FS_FESTIVAL6","Официальный нерабочий ден в США");
define("FS_FESTIVAL7","года. FS.COM вернется");
define("FS_FESTIVAL8"," года. Заказы, оформленные во время праздника, будут обработаны ");
define("FS_FESTIVAL8_01"," года. Заказы, оформленные во время праздника, будут обработаны ");
/******meta标签语言包*****/
define("FS_META_PRO_01","Купить ");
define("FS_META_PRO_02"," от поставщиков центров обработки данных, корпоративных сетей и сетевых решений  ISP по лучшей цене.");
/******end*****/

define('FS_CHECK_OUT_TAX_SG','GST');
define('FS_CHECK_OUT_INCLUDING_SG','(С учетом налога на товары и услуги)');

//新增加
define('FS_CHECK_OUT_TAX_AU','Налог на товары и услуги');
define('FS_CHECK_OUT_EXCLUDING_AU','(Без учета налога на товары и услуги)');
define('FS_CHECK_OUT_INCLUDING_AU','(С учетом налога на товары и услуги)');
define("FS_WAREHOUSE_AREA_AU","Отправка со склада AU");
define("CHECKOUT_TAXE_AU_TIT","О налоге на товары и услуги(GST) и тарифе");
define("CHECKOUT_TAXE_AU_CONTENT", "В соответствии с <em class='alone_font_italic'>A New Tax System (Goods and Services Tax) Act 1999</em>, FS.COM PTY LTD за отправку товара из Мельбурнского склада обязана взимать GST со всех заказов, доставленных в Австралии. Все товары подлежат стандартной ставке GST 10% соответственно. После того, как вы заполните информацию о заказе, вы сможете увидеть общую сумму с учетом применимого GST в сводке заказа.</br></br>Для заказов с продуктами, недоступными на нашем складе в Мельбурне, мы можем отправить их по прибытии в Мельбурн после передачи из Азии.</br></br>Для заказов, содержащих тяжелые или негабаритные предметы, мы отправим их вам непосредственно из Азии. В этом случае при оформлении заказа GST не взимается. Но посылки могут облагаться ввозной или таможенной пошлиной, в зависимости от законодательства. Любые тарифы или ввозные таможенные пошлины, вызванные таможенным оформлением, должны быть объявлены и оплачиваться вами самостоятельно.");
define("FREE_SHIPPING_TEXT3","Бесплатная доставка при сумме заказа от AU$ 99.");
define("FS_WAREHOUSE_AU","склад AU");
define("FS_WAREHOUSE_SG","склад SG");
define("FS_WAREHOUSE_RU","склад RU");
define('EMAIL_CHECKOUT_COMMON_VAT_COST_AU','Налог на товары и услуги');
define('PRODUCTS_SHIP_TODAY','Отправка сегодня');
define('ITEM_LOCATION_AU','Мельбурн, Австралия ');
define('FS_COMMON_WAREHOUSE_AU','FS.COM Pty Ltd<br>
			ABN 71 620 545 502 <br>
			57-59 Edison Rd,<br>
			Dandenong South,<br>
			VIC 3175,<br>
			Австралия
			Тел: +61 (2) 8317 1119');
define('FS_LOGIN_REGIST_PWD_REQUIRED_TIP_COMMON',"Требуется пароль.");
define('FS_LOGIN_REGIST_EMAIL_FORMAT_TIP_COMMON',"Пожалуйста, введите действительный адрес электронной почты.(например:someone@gmail.com)");
define('FS_LOGIN_REGIST_EMAIL_REQUIRED_TIP_COMMON',"Требуется адрес электронной почты.");
define('FS_LOGIN_REGIST_PWD_ERROR_TIP_COMMON',"Неверный пароль. Введите ваш пароль ещё раз.");
define('FS_LOGIN_REGIST_EMAIL_NOT_FOUND_ERROR_COMMON',"Ошибка: Адрес электронной почты не найден в регистре нашей системы. Введите заново, пожалуйста.");
define('FS_LOGIN_REGIST_LOGIN_BANNED_COMMON', 'Ошибка: Доступ закрыт.');
define("FS_LOGIN_POPUP1","Время ожидания соединения истекло");
define("FS_LOGIN_POPUP2","Время сессии истекло, пожалуйста, попробуйте ещё раз.");
define("FS_LOGIN_POPUP3","Чтобы продолжить, введите пароль, пожалуйста.");
define("FS_LOGIN_POPUP4","Адрес электронной почты");
define("FS_LOGIN_POPUP5","Изменить аккаунт?");
define("FS_LOGIN_POPUP6","Пароль");
define("FS_LOGIN_POPUP7","Забыли ваш аккаунт?");
define("FS_LOGIN_POPUP8","показать");
define("FS_LOGIN_POPUP9","скрыть");
define("FS_ADDRESS_EDIT_TITLE","Редактировать адрес");
define('FS_CHECK_OUT_TAX_DE','Налог');
define('FS_COMMON_WAREHOUSE_US_ES','FS.COM INC<br>
            380 Centerpoint Blvd<br>
            New Castle, DE 19720,<br>
            United States<br>
            Тел: +1 425-326-8461
            ');
define("GLOBAL_TEXT_NAME","ФИО владельца карты");






//新增
define("FS_CHECKOUT_ERROR1","Введите имя");
define("FS_CHECKOUT_ERROR2","Введите фамилию");
define("FS_CHECKOUT_ERROR3","Введите адрес, первую строку");
define("FS_CHECKOUT_ERROR4","Введите почтовый индекс");
define("FS_CHECKOUT_ERROR5","Введите город");
define("FS_CHECKOUT_ERROR6","Поле 'Страна' обязательно для заполнения");
define("FS_CHECKOUT_ERROR7","Введите номер телефона");
define("FS_CHECKOUT_ERROR8","Ваш НОМЕР TAX/VAT требуется заполнить");
define("FS_CHECKOUT_ERROR9","Поле 'область' обязательно для заполнения.");
define("FS_CHECKOUT_ERROR10","Поле 'Название Компании' обязательно для заполнения.");

define("FS_CHECKOUT_ERROR11","Действительный номер TAX/VAT например:DE123456789");
define("FS_CHECKOUT_ERROR12","Адрес доставки должен быть не менее 4 символов.");
define("FS_CHECKOUT_ERROR13","Ваше имя должно содержать не менее двух символов.");
define("FS_CHECKOUT_ERROR14","Ваша фамилия должна содержать не менее двух символов.");
define("FS_CHECKOUT_ERROR15","Ваш почтовый индекс должен быть не менее 3 символов..");
define("FS_CHECKOUT_ERROR16","Ваш заказ не смогут кинуть в почтовый ящик");
define("FS_CHECKOUT_ERROR17","Выберите тип адреса");
define("FS_CHECKOUT_ERROR18","Пожалуйста, выберите адрес доставки.");
define("FS_CHECKOUT_ERROR19","Страна отсутствует в выбранном адресе, пожалуйста, отредактируйте еще раз");
define("FS_CHECKOUT_ERROR20","В указанном вами адресе отсутствует номер телефона");
define("FS_CHECKOUT_ERROR21","Обновите ваш адрес доставки (введите Тип Адреса и Номер VAT/TAX).");

define("FS_CHECKOUT_DEFAULT","по умолчанию");
define("FS_CHECKOUT_EDIT","редактировать");
define("FS_CHECK_ACCOUNT","Аккаунт");
define("FS_CHECK_SELF","Использовать адрес доставки как платёжный адрес для выставления счета");
define("FS_NETWORK_ERROR","Ой, произошла сетевая ошибка.");
define("FS_CHECKOUT_ERROR22","Аккаунт не может быть пустым");
define('FIBER_CHECK_SPARK','Счет в Банке Sparkasse:');
define("FS_CHECKOUT_ERROR23",'Требуется ФИО в паспорте.');
define("FS_CHECKOUT_ERROR24",'Требуется номер телефона.');
define("FS_CHECKOUT_ERROR25",'Требуется время забирать посылку.');
define("FS_CHECKOUT_ERROR26",'Требуется адрес электронной почты.');
define("FS_CHECKOUT_ERROR27","Обновите ваш адрес доставки (введите почтовый индекс).");
define("FS_CHECKOUT_ERROR28","Пожалуйста, введите действительный почтовый индекс");
define("FS_CHECKOUT_NEW1",'Корзина');
define("FS_CHECKOUT_NEW2",'Оформить заказ');
define("FS_CHECKOUT_NEW3",'Успешно');
define("FS_CHECKOUT_NEW4",'Адрес Доставки');
define("FS_CHECKOUT_NEW6",'Адрес доставки по умолчанию');
define("FS_CHECKOUT_NEW7",'Добавить новый адрес');
define("FS_CHECKOUT_NEW8",'Добавить новый платёжный адрес');
define("FS_CHECKOUT_NEW9",'Платёжный Адрес');
define("FS_CHECKOUT_NEW10",'добавьте ваш платёжный адрес');
define("FS_CHECKOUT_NEW11",'Способ Оплаты');
define("FS_CHECKOUT_NEW12",'Условия Оплаты: ');
define("FS_CHECKOUT_NEW13",'Просмотреть Товары и Доставку');
define("FS_CHECKOUT_NEW14",'Доставка');
define("FS_CHECKOUT_NEW15",'Товар(ы)');
define("FS_CHECKOUT_NEW16",'Добавить комментарий');
define("FS_CHECKOUT_NEW17",'Комментарий');
define("FS_CHECKOUT_NEW18",'Номер заказа на покупку (PO)');
define("FS_CHECKOUT_NEW19",'Пожалуйста, укажите модель Вашего сетевого оборудования для того, чтобы мы убедились в совместимости приобретаемого Вами товара.');
define("FS_CHECKOUT_NEW20",'Комментарии по доставке, упаковке или продукту будут полезны для обработки заказа.');
define("FS_CHECKOUT_NEW21",'Сумма Заказа ');
define("FS_CHECKOUT_NEW22",'Товары:');
define("FS_CHECKOUT_NEW23",'Доставка:');
define("FS_CHECKOUT_NEW24",'Вам предоставляется БЕСПЛАТНАЯ доставка');
define("FS_CHECKOUT_NEW25","Подтверждая заказ, вы соглашаетесь с");
define("FS_CHECKOUT_NEW26","условиями использования.");
define("FS_CHECKOUT_NEW27","Оформить заказ");
define("FS_CHECKOUT_NEW28","Copyright &copy; 2009-".date('Y',time())." FS.COM Ltd. Все права защищены.");
define("FS_CHECKOUT_NEW29","Далее");
define("FS_CHECKOUT_NEW30","Редактировать Корзину ");
define("FS_CHECKOUT_NEW31","PayPal");
define("FS_CHECKOUT_NEW32","Кредитная/Дебетовая Карта");
define("FS_CHECKOUT_NEW33","Банковский Перевод");
define("FS_CHECKOUT_NEW34","Условие об отсрочке платежа");
define("FS_CHECKOUT_NEW35"," BPAY");
define("FS_CHECKOUT_NEW36"," eNETS");
define("FS_CHECKOUT_NEW37","Яндекс Деньги");
define("FS_CHECKOUT_NEW38","Web Money");
define("FS_CHECKOUT_NEW39","iDEAL");
define("FS_CHECKOUT_NEW40","SOFORT");
define("FS_CHECKOUT_NEW41","Итого");
define('FIBERSTORE_FIRST_NAME','Имя');
define('FIBERSTORE_LAST_NAME','Фамилия');
define('FIBERSTORE_COUNTRY','Страна или Регион');
define("FS_CHECKOUT_ERROR30","Требуется ваш адрес электронной почты.");
define("FS_CHECKOUT_ERROR31","Ваш адрес электронной почты неверный.");
define("FS_CHECKOUT_EXPIRED","Время сессии истекло?");
define("FS_CHECKOUT_EXPIRED_CONFIRM","подтвердить");
define("FS_ADDRESS_MESSAGE3","Улица, c/o");
define("FS_ADDRESS_MESSAGE4","Квартира, дом, этаж и т.д.");
define("CHECKOUT_TAXE_CN_FRONT1","Для всех заказов, отправленных с нашего склада CN в континентальный Китай, HK, Макао и Тайвань, предоставляется БЕСПЛАТНАЯ доставка (по умолчанию SF Express в континентальный Китай и Fedex IE в HK, Макао и Тайвань).");
define("CHECKOUT_TAXE_CN_FRONT2","В соответствии с законом КНР о налоговом контроле (Administration of Tax Collection, LATC), FS.COM обязана взимать НДС в размере 13% со всех заказов, доставляемых в континентальный Китай. А для заказов, отправленных в HK, Макао и Тайвань, НДС не взимается. Однако на эти товары могут быть наложены импортные или таможенные сборы в зависимости от законов конкретного региона. Получатель берет на себя ответственность за уплату сборов за таможенное оформление.");
// 2018.7.23 fairy 底部反馈弹窗
define('FS_GIVE_FEEDBACK','Отзывы о FS');
define('FS_GIVE_FEEDBACK_TIP','Благодарим за обращение к FS. Ваш отзыв поможет нам предоставить клиентам лучший опыт покупок.');
define('FS_RATE_THIS_PAGE','Оцените ваш общий опыт с FS *');
define('FS_NOT_LIKELY','Ужасно');
define('FS_VERY_LIKELY','Отлично');
define('FS_TELL_US_SUGGESTIONS','Выберите тему вашего отзыва.*');
define('FS_ENTER_COMMENTS','Сообщите нам Ваши комментарии.');
define('FS_PROVIDE_EMAIL','Если вы хотите получить от нас ответ, оставьте свои контактные данные.');
define('FS_PROVIDE_EMAIL_TIP','Примечания: данная информация НЕ будет использоваться для каких-либо других целей. Мы ценим вашу конфиденциальность.');
define('FS_FEEDBACK_THANKYOU','Вы успешно поделились.');
define('FS_FEEDBACK_THANKYOU_TIP_01','Ваш отзыв важен для нас, мы рассмотрим и используем его для улучшения веб-сайта FS для будущих посещений.');
define('FS_FEEDBACK_THANKYOU_TIP_02','Ваше удовлетворение - наше постоянное стремление, мы будем и впредь предлагать вам более качественные услуги и удобство покупки.');
define("CHECK_SET_DEFAULT","По умолчанию");
define("CHECK_SEARCH","Поиск");
define("FS_CHECKOUT_ERROR29","Пожалуйста, редактируйте ваш адрес(введите действительный почтовый индекс).");
define("FS_CHECKOUT_ERROR35","Пожалуйста, редактируйте ваш адрес(выберите правильную страну).");
define('FS_FEEDBACK_NAME','ФИО');
define('FS_FEEDBACK_EMAIL','Адрес электронной почты');

define("FS_HSBC_INFO1","Название банк получателя");
define("FS_HSBC_INFO2","Получатель");
define("FS_HSBC_INFO3","IBAN:");
define("FS_HSBC_INFO4","BIC:");
define("FS_HSBC_INFO5","Счет получателя:");
define("FS_HSBC_INFO6","Адрес банка получателя:");
define("FS_PO_ADDRESS_04","После того, как вы успешно оформите заказ, необходимо просмотреть для обеспечения безопасности вашего заказа, поскольку адрес доставки не тот, который отмечен значком «PO».");

define('FS_SHARE_CART_06','Менеджер по Продажам. ');

//add ternence 2018-7-9
define('FS_SHOP_CART_ALERT_JS_50','Товар(ы)');
define('FS_SHOP_CART_ALERT_JS_51','Всего (');
define('FS_SHOP_CART_ALERT_JS_52','):');
define('FS_SHOP_CART_ALERT_JS_53','Сумма');
define('FS_SHOP_CART_ALERT_JS_54','(без учета доставки и налогов )');
define('FS_SHOP_CART_ALERT_JS_55','Ваше Имя');
define('FS_SHOP_CART_ALERT_JS_55_1','Имя Получателя');
define('FS_SHOP_CART_ALERT_JS_56','Ваш Адрес Электронной Почты');
define('FS_SHOP_CART_ALERT_JS_56_1',"Разделяйте нескольких получателей точкой с запятой';'");
define('FS_SHOP_CART_ALERT_JS_57','не более 500 символов.');
define('FS_SHOP_CART_ALERT_JS_58','Сохраненная корзина');
define('FS_SHOP_CART_ALERT_JS_59','Вам предоставляется БЕСПЛАТНАЯ доставка ');
define('FS_SHOP_CART_ALERT_JS_60','Страна доставки:');
define('FS_SHOP_CART_ALERT_JS_61','БЕСПЛАТНАЯ доставка предоставляется при заказе от US$ 79.');
define('FS_SHOP_CART_ALERT_JS_62','Чтобы ваш заказ соответствовал требованием БЕСПЛАТНОЙ доставки, нужно добавить подходящие продукты от  ');
define('FS_SHOP_CART_ALERT_JS_63','');
define('FS_SHOP_CART_ALERT_JS_64','Вам предоставляется БЕСПЛАТНАЯ доставка ');
define('FS_SHOP_CART_ALERT_JS_65','БЕСПЛАТНАЯ доставка предоставляется при заказе от €79.');
define('FS_SHOP_CART_ALERT_JS_66','БЕСПЛАТНАЯ доставка предоставляется при заказе от £79.');
define('FS_SHOP_CART_ALERT_JS_67','БЕСПЛАТНАЯ доставка предоставляется при заказе от €79.');
define('FS_SHOP_CART_ALERT_JS_68','БЕСПЛАТНАЯ доставка предоставляется при заказе от £79.');
define('FS_SHOP_CART_ALERT_JS_69','Безопасная оплата');
define('FS_SHOP_CART_ALERT_JS_70','Продолжить покупки');
define('FS_SHOP_CART_ALERT_JS_71','БЕСПЛАТНАЯ доставка предоставляется при заказе от AUD$99.');
define('FS_SHOP_CART_ALERT_JS_72','Сохранить корзину');
define('FS_SHOP_CART_ALERT_JS_72_1','Сохранить');
define('FS_SHOP_CART_ALERT_JS_73','Поделиться корзиной по эл. почте');
define('FS_SHOP_CART_ALERT_JS_74','Распечатать');
define("FS_SHOP_CART_ALERT_JS_76_1","Отправить");
define("FS_AJAX_DELETE1","был успешно удален из вашей корзины.");
define("FS_AJAX_DELETE2","Отменить");
define('FS_SHOP_CART_WAS_ACCOUNT','Была');
define('FS_CART_ITEM','шт)');
define('FS_CART_ITEMS','шт)');
//add by helun
define('FS_AGAINST_BPAY_01','Дата Заказа:');
define('FS_AGAINST_BPAY_02','Общая Сумма:');
define('FS_AGAINST_BPAY_03','Ваш заказ разделен на');
define('FS_AGAINST_BPAY_04','заказа.');
define('FS_AGAINST_BPAY_05','Ожидаемая дата отправки');
define('FS_AGAINST_BPAY_06','Отправка со');
define('FS_AGAINST_BPAY_07','Заказ');
define('FS_AGAINST_BPAY_08','');
define('FS_AGAINST_BPAY_09','Перейти к');
define('FS_AGAINST_BPAY_10','Sparkasse Freising');
define('FS_AGAINST_BPAY_11','FS.COM GmbH');
define('FS_AGAINST_BPAY_12','DE16 7005 1003 0025 6748 88');
define('FS_AGAINST_BPAY_13','BYLADEM1FSI');
define('FS_AGAINST_BPAY_14','25674888');
define('FS_AGAINST_BPAY_15','Untere Hauptstr.29, 85354, Freising');
define('FS_AGAINST_BPAY_16','817-888472-838');
define('FS_AGAINST_BPAY_17','HSBCHKHHHKH');


define("FS_WAREHOUSE_SEA","Cклад в Сиэтле");
define("FS_WAREHOUSE_DEL","Cклад в Делавэре");
define("FS_COMMON_CHECKOUT_HSBC","После оплаты FS обычно получает платеж в течение 1-3 рабочих дней. Мы обработаем заказ сразу после получения оплаты.");
define("FS_COMMON_CHECKOUT_SUCCESS_ORDER_HSBC","Укажите Ваш номер заказа FS при оплате, чтобы Ваш заказ мог быть своевременно обработан. Обычно средства получают в течение 1-3 рабочих дня. Запас будет не зарезервирован до получения оплаты.");
define("FS_WAREHOUSE_AREA_36","Отправка со склада в Сиэтле");
define("FS_WAREHOUSE_AREA_37","Отправка со склада в Делавэре");
define("FS_LIVE_CHAT_CHECKOUT","<a target='_blank' href='javascript:;' onclick='LC_API.open_chat_window();return false;'>Онлайн чат</a> или позвоните нам по телефону");

/**
 *评论邮件
 */
define('FS_EMAIL_TO_US_DEAR','Уважаемый/Уважаемая ');
define('EMAIL_MESSAGE_TITLE_REVIEWS',' Oтзыв получен');
define('FS_PRODUCT_REVIEW_SUBJECT_TITLE','FS-Спасибо за Ваш отзыв.');
define('FS_EMAIL_REVIEWS_WELL_CONTENT','Мы очень благодарны за Ваши добрые слова и рады услышать,  что у Вас такой большой опыт взаимодействия с нашей командой.');
define('FS_EMAIL_REVIEWS_WELL_FEEDBACK','Подобная обратная связь помогает нам постоянно улучшать испытания клиентов, зная, что мы делаем правильно , и что мы можем сделать.');
define('FS_EMAIL_REVIEWS_BAD_CONTENT','Мы сожалеем, что Ваши испытания не соответствовали вашим ожиданиям. Это был необычный случай, и мы сделаем лучше.');
define('FS_EMAIL_REVIEWS_BAD_FEEDBACK','Вы можете быть уверены, что Ваш менеджер свяжется с Вами в течение 48 часов. Искренне надеемся работать с Вами, чтобы решить любые проблемы как можно быстрее.');
define('FS_EMAIL_REVIEWS_THANKS','Спасибо');
define('FS_EMAIL_REVIEWS_TEAM','Команда FS');
define('FS_EMAIL_REVIEWS_WELL_HEADER','Спасибо за ваш отзыв. Мы продолжим предлагать лучшие продукты как обычно.');
define('FS_EMAIL_REVIEWS_BAD_HEADER','Спасибо за ваш отзыв. Мы поможем вам решить эту проблему как можно скорее.');

/*
 * 客户分享产品邮件   产品详情页属性右下角的email分享按钮
 */
define('FS_EMAIL_PRODUCT_SHARE1','Ваш друг поделился с Вами этим товаром на ');
define('FS_EMAIL_PRODUCT_SHARE2','FS.COM.');
define('FS_EMAIL_PRODUCT_SHARE3','Вас может заинтересовать эта страница на ');
define('FS_EMAIL_PRODUCT_SHARE4','Подробнее');
define('FS_EMAIL_PRODUCT_SHARE5','С уважением,');
define('FS_EMAIL_PRODUCT_SHARE6','FS.COM');
define('FS_EMAIL_PRODUCT_SHARE7',' команда');
define('FS_EMAIL_PRODUCT_SHARE8','Это письмо было отправлено от ');
define('FS_EMAIL_PRODUCT_SHARE9',' сервис Поделиться с другом. После получения этого сообщения Вы не получите какое-либо незапрашиваемое сообщение от ');
define('FS_EMAIL_PRODUCT_SHARE10',zen_href_link('index'));
define('FS_EMAIL_SHARE_TITLE_ONE','FS.COM - Ваш друг ');
define('FS_EMAIL_SHARE_TITLE_TWO',' хочет, чтобы вы увидели этот товар.');
define('FS_EMAIL_PRODUCT_SHARE11','Сообщение от ');
define('FS_SHARE_EMAIL_12','Отправить...');
define('FS_PRO_SHARE_EMAIL','Ваше сообщение уже было отправлено.');
define('FS_EMAIL_PRODUCT_SHARE13','. Узнайте больше о нашей ');
define('FS_EMAIL_PRODUCT_USING',' через ');
define('FS_EMAIL_POLICY',"Политике конфиденциальности");
/*
 * 新版详情页
 */
define('FS_PLEASE_SELECT','Пожалуйста, выберите...');
define('FS_JUST_ADD','Вы добавили ');
define('FS_POPUP_ITEM',' шт.');
define('FS_COUNTINUE_SHOPPING','Продолжить покупки');
define('FS_PRODUCT_SHIPPING','Доставка');
define('FS_PRODUCT_RETURNS','Возврат');
define('FS_PRODUCT_LIVE_CHAT','Онлайн чат');
define('FS_PRODUCT_EXPERT','Чат Сейчас:');
define('FS_PRODUCT_QUESTIONS','Вопрос');
define('FS_REVIEWS_BY','от');
define('FS_PRODUCT_CART_POPUP','Клиенты, купившие этот товар, также приобрели');
define('FS_REVIEWS35',' Голос');
define('FS_REVIEWS34',' Голосов');

//2018.9.6 Yoyo  add 产品详情  shipping&returns
define('FS_ASK_EXPERT','Онлайн-консультант:');
//产品详情页产品加入购物车后的弹出框信息
define('FS_JUST_ADDED','Вы добавили ');
define('FS_JUST_ITEM',' Товар');
define('FS_JUST_ITEMS',' шт.');
define('FS_CART_QTY','Кол-во:');
define('FS_CONTINUE_SHOPPING','Продолжить покупки');
define('FS_SHOPPING_CART_NEW_SHARE_CART', 'Поделиться корзиной');
define('FS_SHOPPING_CART_NEW_PRINT_CART', 'Распечатать корзину');
define("FS_SHOP_CART_ALERT_JS_77","К корзине");


//加購彈窗
define("FS_NEW_POPUP_01","Вы добавили");
define("FS_NEW_POPUP_02","Кол-во:");
define("FS_NEW_POPUP_03","Продолжить покупки");
define("FS_NEW_POPUP_04","Перейти в корзину");
define("FS_NEW_POPUP_05","шт.");

define('FIBER_CHECK_ANZ','Счет в Банке ANZ:');
define('FIBER_CHECK_ACCOUNT','Название банка получателя:');
define('FIBER_CHECK_PTY','FS.COM Pty Ltd');
define('FIBER_CHECK_BSB','BSB:');
define('FIBER_CHECK_013','013160');
define('FIBER_CHECK_ACCOUNT_NO','Счет Бенефициара:');
define('FIBER_CHECK_4167','416794959');
define('FIBER_CHECK_SWIFT_CODE','SWIFT Код:');
define('FIBER_CHECK_ANZBAU3M','ANZBAU3M');
define('FIBER_CHECK_BANK','Адрес банка получателя:');
define('FIBER_CHECK_ST_VIC','230 Swanston St, Melbourne, VIC, 3000');
define('FIBER_CHECK_TITLE_AU','To pay via direct deposit, please use the following bank account information:');

define('FS_CHECKOUT_SUCCESS_06','Sparkasse Freising');
define('FS_CHECKOUT_SUCCESS_07','FS.COM GmbH');
define('FS_CHECKOUT_SUCCESS_08','DE16 7005 1003 0025 6748 88');
define('FS_CHECKOUT_SUCCESS_09','BYLADEM1FSI');
define('FS_CHECKOUT_SUCCESS_10','25674888');
define('FS_CHECKOUT_SUCCESS_11','Untere Hauptstr.29, 85354, Freising');
define('FIBER_CHECK_TITLE_AU','Для оплаты через прямой депозит, пожалуйста, используйте следующую информацию:');
//uk
define('FIBERSTORE_INFO_WIRE_DE','Счет в Банке Sparkasse');
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

define('FS_SUCCESS_YOUR_NEXT','Далее необходимо завершить Wire Transfer оплаты и представить ваши платежные реквизиты.');
define('FS_SUCCESS_WIRE','Банковский Перевод');
define('FS_SUCCESS_ORDER','Печатать');
define('FS_SUCCESS_DETAIL','Информация Бенефициара Банковского Перевода');
define('FS_SUCCESS_BANK_NAME','Название Банка Получателя:');
define('FS_SUCCESS_HSBC','HSBC Hong Kong');
define('FS_SUCCESS_AC_NAME','Бенефициар:');
define('FS_SUCCESS_CO','FS.COM LIMITED');
define('FS_SUCCESS_AC_NO','Счет Бенефициара:');
define('FS_SUCCESS_TEL','817-888472-838');
define('FS_SUCCESS_SWIFT','SWIFT Код:');
define('FS_SUCCESS_HK','HSBCHKHHHKH');
define('FS_SUCCESS_BANK_ADRESS','Адрес Банка Получателя:');
define('FS_SUCCESS_ROAD','1 Queen\'s Road Central, Hong Kong');
define('FS_SUCCESS_OUR','Адрес Нашей Компании');
define('FS_SUCCESS_NO','Eastern Side, Second Floor, Science &amp; Technology Park, No.6, Keyuan Road, Nanshan District, Shenzhen, China');

// fairy 2018.9.6 add 登录注册相关语言包公用
define('FS_SIGN_IN',"Войти");
define('FS_SIGN_IN_BUTTON',"Войти");  // 俄语提交按钮和文字表达不一样
define('FS_CREATE_ACCOUNT',"Регистрация");
define('FS_CREATE_ACCOUNT_BUTTON',"Зарегистрироваться"); // 俄语提交按钮和文字表达不一样
define("FS_PICK_UP_AT_WAREHOUSE","Самовывоз ");
define("FS_TIME_ZONE_RULE_US_ES"," (EST)");
define("FS_TIME_ZONE_ADDRESS_US","<span>Расположение склада:</span> 820 SW 34th Street Bldg W7 Suite H Renton, WA 98057, United States | +1 (877) 205 5306 ");
define("FS_TIME_ZONE_ADDRESS_DE","<span>Расположение склада:</span> NOVA Gewerbepark Building 7, Am Gfild 7, 85375 Neufahrn Germany | +49 (0) 8165 80 90 517 ");
define("FS_TIME_ZONE_ADDRESS_US_ES","<span>Расположение склада:</span> 380 Centerpoint Blvd, New Castle, DE 19720, United States | +1 (425) 326 8461 ");

//added Yoyo  2018/9/20
//站点融合整理 邮件标点符号整理成常量
define('FS_EMAIL_COMMA',',');   //逗号
define('FS_EMAIL_POINT','.'); //句号
define('FS_EMAIL_PERIOD','.');
define('FS_EMAIL_MARK','.');//感叹号英语中是句点
define('FS_EMAIL_PAUSE',',&nbsp;');  //日语中的逗号有时是顿号
//产品详情货币单位
define('FS_PRODUCT_PRICE_EA','/шт');


//added by Yoyo
define('FS_CHOOSE_ONE','Выберите тему отзыва');
define('FS_WEB_ERROR','Ошибка сайта');
define('FS_FEEDBACK_PRODUCT','Продукт');
define('FS_ORDER_SUPPORT',' Поддержка заказа');
define('FS_TECH_SUPPORT','Техническая поддержка');
define('FS_SITE_SEARCH','Поиск продукта');
define('FS_FEEDBACK_OTHER','Другие');

define('EMAIL_OVER79_FREE_DELIVERY','<tr><td style="font-size:12px;font-weight: 400;padding-top: 35px;">При заказе приемлемых товаров на сумму больше $79 бесплатная доставка предоставляется. </td></tr>');
//added Yoyo 产品分享
define('FS_EMAIL_POLICY_2',"");
define('FS_SHARE_AGAIN','Поделиться ещё раз');
define('FS_TRACK_ORDER','Вы можете отслеживать статус заказа, нажимая ');
define('FS_TRACK_MY_ORDERS','Мои заказы');
define('FS_ORDER_COMMENTS','Комментарий заказа: ');
define('FS_TRACK_PO_ORDER','Вы можете отслеживать свой статус в ');
define('FS_TRACK_ACCOUNT_CENTER','личном кабинете');
define('FS_STOCK_LIST_OTHER_ID','ID');
define('FS_COMMON_FILE','файл');

//checkout_payment_against
define('FS_CREDIT_CARD_NUMBER','Номер карты');
define('FS_CREDIT_EXPIRY_DATE','Срок действия');
define('FS_CREDIT_CONTINUE','Продолжать');

//manage_orders 取消订单邮件
define('FS_CANCEL_ORDER',"Ваш заказ#");
define('FS_CANCEL_ORDER_1',"отменен");
define('FS_CANCEL_ORDER_2',"По Вашему запросу, мы отменили Ваш заказ# ");
define('FS_CANCEL_ORDER_3',". Очень жаль, но надеемся на сотрудничество с Вами в ближайшее время.");
define('FS_CANCEL_ORDER_4',"Если у Вас есть любой вопрос, пожалуйста, <a href='".zen_href_link('contact_us')."'>свяжитесь с нами</a> , всегда готовы помочь.");
define('FS_CANCEL_ORDER_5',"Email:");
define('FS_CANCEL_ORDER_6',"Номер заказа: ");
define('FS_CANCEL_ORDER_7',"Причина:");
define('FS_CANCEL_ORDER_8','Заказ# ');
define('FS_SUBMIT', 'Сохранить');

//print_order & print_main_order
define('FS_PRINT_ORDER_TEL','Tel:');
define('FS_PRINT_ORDER_NUM','Номер НДС:');
define('FS_PRINT_ORDER_CREDIT','Кредитная/Дебетовая Карта ');
define('FS_PRINT_ORDER_PURCHASE','Заказ на Покупку(PO)');
define('FS_PRINT_ORDER_BANK','Банковский Перевод');
define('FS_PRINT_ORDER_WESTERN','Вестерн Юнион ');
define('FS_PAY_WAY_PAYPAL','Paypal');
define('FS_PAY_WAY_PAYEEZY','payeezy');
define("FS_CHECKOUT_NEW42","Электронный Чек ");
define('FS_PRINT_ORDER_FREE','Free');

//2018-9-15  add  ery  游客结算页面账号已存在提示语
define('FS_CHECKOUT_GUEST_LOG_MSG','Такой E-mail уже зарегистрирован. Пожалуйста, войдите в личный кабинет.&nbsp;&nbsp;<a href="'.zen_href_link('login').'">Войти »</a>');
define('FS_CUSTOMERS_ALSO','Клиенты, купившие этот товар, также приобрели');

//购物车分享相关 移动到公共语言包部分
define('FS_SHOP_CART_ALERT_JS_43',"Поле 'Имя' обязательно для заполнения.");
define('FS_SHOP_CART_ALERT_JS_43_01',"Поле 'Имя Получателя'обязательно для заполнения.");
define('FS_SHOP_CART_ALERT_JS_44',"Поле 'Адрес Электронной Почты' обязательно для выполнения.");
define('FS_SHOP_CART_ALERT_JS_44_01',"Поле 'Адрес Электронной Почты Получателя' обязательно для выполнения.");
define('FS_SHOP_CART_ALERT_JS_45','Напишите Ваш адрес электронной почты, пожалуйста.');
define('FS_SHOP_CART_ALERT_JS_46','Отправить Менеджеру по Продажам ');
define("CHECKOUT_TAX_NZ_CONTENT","Для заказов, отправленных в страны за пределами Австралии, FS.COM будет взимать стоимость товаров и доставки при размещении заказа. Для этих заказов импортные или таможенные сборы могут взиматься в зависимости от законов конкретных стран. <br/><br/> Таможенные или импортные пошлины взимаются после того, как посылки доставляются до стран назначения. Дополнительные сборы за таможенное оформление возлагаются на получателя.");
define("FS_TIME_ZONE_ADDRESS_AU","<span>FS склад в Мельбурне:</span> 57-59 Edison Rd, Dandenong South, VIC 3175, Australia | +61 3 9693 3488 ");
define("FS_TIME_ZONE_RULE_AU","(AEST)");
define("FS_JS_TIT_CHECK_AU","9:30am - 5pm ");
define("FS_OVERNIGHT_TITLE","Заказ, полученный оплату после окончания рабочего дня (5:00pm EST), будет отправлен на следующий рабочий день. Доставка осуществляется только в рабочие дни.");
define("FS_OVERNIGHT_TITLE_UP","Заказ, полученный оплату после окончания рабочего дня (5:00pm EST), будет отправлен на следующий рабочий день. Доставка осуществляется только в рабочие дни.");
//第三方登录提示语
define("REDIRECT_DEAR","Уважаемый пользователь ");
define("REDIRECT_USER","");
define("REDIRECT_WELCOME"," добро пожаловать");
define("REDIRECT_NOTICE","Вы уже зарегистрировали аккаунт FS с тем же адресом <br>электронной почты. Чтобы повысить эффективность управления Вашего аккаунта, Вы войдете <br>в свой аккаунт FS. Если Вы не знаете об этом аккаунте, <br>Cвяжитесь с нами, пожалуйста.");
define("REDIRECT_ACCOUNT","свяжитесь с нами. Перейти в ваш личный кабинет FS за ");

define("FS_PRODUCT_INFO_SIZE","Упаковка:");
define("FS_PRODUCT_INFO_PIECE","1 шт.");
define("FS_PRODUCT_INFO_CASE","Купить по ящикам(");
define("FS_PRODUCT_INFO_PIS","шт./ящик");
define("FS_PRODUCT_INFO_PIS_1","шт./");
define("FS_CHECKOUT_ERROR36","Пажалуйста введите действитеный номер VAT");
define("FS_SHOP_CART_SAVED_ITMES","товаров");  //俄语的不一样

// 税号模板 start
//新增结账税号验证
define("FS_CHECKOUT_VAX_CH","Пожалуйста, введите действительный номер налога, например: 00.000.000-0.");
define("FS_CHECKOUT_VAX_AR","Пожалуйста, введите действительный номер налога, например: 00-00000000-0.");
define("FS_CHECKOUT_VAX_BR_BS","Пожалуйста, введите действительный номер налога, например: 00.000.000/0000-00.");
define("FS_CHECKOUT_VAX_BR_IN","Пожалуйста, введите действительный номер налога, например: 000.000.000/00.");
define("FS_TAXT_TITLE_NOTICE","Ваш заказ может быть освобожден от налога путем предоставления правильного и действительного номера НДС.");
define("FS_TAXT_TITLE_NOTICE_OTHER","Для ускорения таможенного оформления, пожалуйста, заполните действующий налоговый номер.");
// 税号模块 end

define('FS_CHOOSE_LENGTH','Длина');
define('FS_LENGTH_NAME','Длина');
define('FS_OPTION_NAME','Номер Модели');

//manage_orders
define('FS_MANAGE_ORDERS_PUR','Причина требуется');

define("FS_NO_FREE_SHIPPING_US_HEAVY","Заказы, содержающие большие или тежёлые продукты, не включены в нашу политику «Бесплатная доставка».");
define("FS_NO_FREE_SHIPPING_AU_REMOTE","Этот заказ доставляется в отдаленный район, поэтому взимается стоимость доставки.");
define("FS_NO_FREE_SHIPPING_DEAU_HEAVY","Заказы, содержающие большие или тежёлые продукты, не включены в нашу политику «Бесплатная доставка».");

//产品详情404页面
define('FS_404_HOT_PRODUCTS','Популярные продукты');
define('SEARCH_OFFINE_1','Извините, данный продукт больше не предоставляется онлайн.');
define('SEARCH_OFFINE_2','Вы можете нажать Запросить цену для получения предложения.');
define('SEARCH_OFFINE_3','Запросить цену');
define('SEARCH_OFFINE_4','Нужна помощь? Посетите ');
define('SEARCH_OFFINE_5','Центр помощи');
define('SEARCH_OFFINE_6',' для дополнительной помощи.');
define("SOLUTION_SUB_PAGE_05",'Запрос о проекте');
define('FS_PRODUCT_RELATED','Связанные продукты');
define('SEARCH_OFFINE_7','Извините, запрошенная вами страница не найдена.');
define('SEARCH_OFFINE_8','Ошибка могла произойти по нескольким причинам:');
define ('SEARCH_OFFINE_9', 'Страница переместилась на другой адрес.');
define ('SEARCH_OFFINE_10', 'Веб-адрес введен неправильно.');
define('SEARCH_OFFINE_11','Проверьте статус URL, или перейдите на <a href="'.zen_href_link(FILENAME_DEFAULT,'','NONSSL').'">домашнюю страницу</a>.');
define('SEARCH_OFFINE_12','главную страницу.');
define ('FS_OUTDATED_LINK', 'Ссылка, которая привела Вас сюда, устарела.');
define('FS_PAGE_NOT_FOUND','Страница не найдена');
//faq问题汇总
define('FS_FAQ_HELPFUL_01',"Полезно ли?");
define('FS_FAQ_HELPFUL_02',"Да");
define('FS_FAQ_HELPFUL_03',"Нет");
define('FS_FAQ_HELPFUL_04',"Спасибо за ваш отзыв.");
define('FS_FAQ_HELPFUL_05',"Что мы можем улучшить?");
define('FS_FAQ_HELPFUL_06',"Это путано");
define('FS_FAQ_HELPFUL_07',"Это не отвечало на мой вопрос");
define('FS_FAQ_HELPFUL_08',"Мне не нравится ваша политика");
define('FS_FAQ_HELPFUL_09',"Отправить");

//产品详情页新增弹窗语言包
define("FS_PRODUCTS_REORDERING","Reordering");
define("FS_FOR_FREE_SHIPPING_GET_AROUND","Get it around");
define("FS_CHOOSE_LOCATION","Выберите свое местоположение");
define("FS_DELIVERY_OPTION","Варианты доставки и скорость доставки зависят от местоположения.");
define("FS_SHIP_OUTSIDE","отправить за");
define("FS_SHIP_CONTINUE_SEE","Вы будете видеть точные стоимости доставки и даты доставки при оформлении заказа.");
define("FS_SHIP_DONE","Подтвердить");
define("FS_REDIRECT_PART1","Продолжить покупку на");
define("FS_REDIRECT_PART2"," и проверить местную цену и способ доставки?");
define("FS_SHIP_TO","Отправить в");
define("FS_SHIP_CHANGE","Изменить");
define("FS_SHIP_OR","или");
define("FS_SHIP_ENTER","или ввести ");
define("FS_SHIP_ZIP_CODE"," почтовый индекс");
define("FS_SHIP_APPLY"," Применить");
define("FS_SHIP_ADD_NEW_ADDRESS","Добавить новый адрес");
define("FS_SHIP_SIGN_IN",'<a href="'.zen_href_link("login","","SSL").'"> Войдите,</a> чтобы увидеть ваши адреса');
define("FS_SHIP_MANAGE","Управление адресами");
define("FS_SHIP_TODAY","Отправить сегодня");
define("FS_SHIP_GET_TODAY","доставка к концу дня сегодня");
define("FS_PRODUCTS_POST_CODE_EMPTY_INVALID","Введите действительный почтовый индекс");
define('FS_PRODUCTS_CUSTOMIZE','Заказные');
define("FS_SHIP_OR_OTHER","или изменить на другую страну");
define("FS_SHIP_LIST_COUNTRY","Страна/Регион");
define("FS_SHIP_LIST_POST","почтовый индекс");
define("FS_SHIP_DELIVEY_TO","Страна доставки:");

define("FS_CN_HUBEI","Ухань, Хубэй");
define("FS_CN_APAC","склад CN");
define("FS_DE_MUNICH","Мюнхен, Бавария");
define("FS_AU_VIC","Мельбурн, Виктория");
define("FS_US_WA","Вашингтон/Делавэр");
define("FS_FOR_FREE_SHIPPING_GET_ARRIVE","доставка ");
define("FS_APAC_NOTICE","FS азиатский склад в основном поддерживает прямую доставку по всему миру. <a  target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Подробнее</a>");
define("FS_US_NOTICE","Склад U.S. в Делавэре поддерживает быструю отправку в тот же день. <a  target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Узнайте больше</a>");
define("FS_US_UP_NOTICE","FS американские склады, расположенные в Сиэтле и Делавэре, поддерживают отправку в тот же день в пределах ближайших штатов США, Аляски, Гавайских островов, военных адресов APO/FPO, Пуэрто-Рико и в Канаду, Мексику.  <a  target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Подробнее</a>");
define("FS_US_OTHER_NOTICE","FS американские склады, расположенные в Сиэтле и Делавэре, поддерживают отправку в тот же день в Соединенные Штаты, Канаду и Мексику.  <a  target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Подробнее</a>");
define("FS_US_UP_OTHER_NOTICE","FS американские склады, расположенные в Сиэтле и Делавэре, поддерживают отправку в тот же день в Соединенные Штаты, Канаду и Мексику.  <a  target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Подробнее</a>");
define("FS_DE_NOTICE","Склад DE FS, расположенный в Мюнхене, поддерживает быструю доставку. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Узнайте больше</a>");
define("FS_DE_OTHER_NOTICE","FS европейский склад, расположенный в Мюнхене, поддерживает отправку в Великобританию, ЕС и другие европейские страны. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Подробнее</a>");
define("FS_AU_OTHER_NOTICE","FS австралийский склад, расположенный в Мельбурне, поддерживает отправку в тот же день в Австралию и в Новую Зеландию.");
define("FS_NZ_OTHER_NOTICE","FS австралийский склад, расположенный в Мельбурне, поддерживает отправку в тот же день в Новую Зеландию. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Подробнее</a>");
define("FS_CN_NOTICE","Глобальный склад FS в Азии поддерживает быструю отправку в тот же день. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Узнайте больше</a>");


//dylan 2019.8.28 add
define('FS_CUSTOM_NOTICE',"Товары будут отправлены после подготовки. Там могут быть производственный цикл. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Узнайте больше</a>");
define('FS_INSTOCK_NOTICE',"<p class='pro_font_w'>Доступны, в Пути</p> Товары находятся в пути к нашему складу и будут отправлены после прибытия. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Узнайте больше</a>");
define('FS_TRANSIT_NOTICE',"<p class='pro_font_w'>Доступны, Нужен Транзит</p> Товары будут отправлены после подготовки. Нужно некоторое время для изготовления. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Узнайте больше</a>");
define('FS_AU_NOTICE',"Склад AU в Мельбурне поддерживает быструю отправку в тот же день. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Узнайте больше</a>");
define('FS_BUCK_NOTICE',"Тяжелые или негабаритные товары будут отправлены со склада в Азии.");
define('FS_SG_NOTICE',"Склад FS AU, расположенного в Сингапуре, обеспечивает быструю доставку в тот же день. <a target='_blank' href='".zen_href_link("shipping_delivery","","SSL")."'>Подробнее </a>");

//add by quest 2019-03-08
define("FS_NO_QTY_NOTICE","Товары отправлены для транзита с глобального склада.");
define("FS_NO_QTY_TAG_NOTICE","Товары готовятся к транзиту с глобального склада.");
define("FS_NO_QTY_TAG_NOTICE_NEW","Товары готовятся к транзиту с азиатского склада.");
define("FS_NO_QTY_NOTICE_NEW","Товары отправлены для транзита с азиатского склада.");

define("FS_SURBSTREET_MAXLENGTH_ERROR","Вторая строка адреса должна содержать не более 35 символов.");
define("FS_TELEPHONE_MAXLENGTH_ERROR","Номер телефона должен содержать не более 15 символов.");
define("FS_COMPANY_MAXLENGTH_ERROR","Название компании должно быть от 1 до 100 символов.");
define("FS_FIRSTNAME_MAXLENGTH_ERROR","Имя должно содержать не более 35 символов.");
define("FS_LASTNAME_MAXLENGTH_ERROR","Фамилия должна содержать не более 35 символов.");
define("FS_CHECKOUT_ERROR12","Первая строка адреса должна иметь длину от 4 до 300 символов.");
define("FS_PRODUCTS_POST_CODE_EMPTY_ERROR","Поле 'Почтовый Индекс' обязательно для заполнения");

define('FS_SEARCH_YOUR_COUNTRY','Поиск вашей страны или региона');

define('FAIL_TO_OPEN_SOURCE','Не удалось загрузить изображение');
define('FAIL_TO_CONNECT_FTP','Не удалось подключиться к серверу');

//超时取消订单
define('MANAGE_ORDER_RESTORE_1','Оплата заказа действует в течение ');
define('MANAGE_ORDER_RESTORE_2','Оплата заказа действует в течение ');
define('MANAGE_ORDER_RESTORE_3','Пожалуйста, выполните оплату в течение 30 минут, в противном случае заказ будет отменен автоматически из-за изменения запасов товаров.');
define('MANAGE_ORDER_RESTORE_4','Купить снова');
define('MANAGE_ORDER_RESTORE_5','Пожалуйста, загрузите ваш файл заказа на покупку(PO) в течение 7 дней, в противном случае заказ будет отменен автоматически из-за изменения запасов товаров.');
define('MANAGE_ORDER_RESTORE_6','Пожалуйста, выполните оплату в течение 2  дней, в противном случае заказ будет отменен автоматически из-за изменения запасов товаров.');
define('MANAGE_ORDER_RESTORE_7','Пожалуйста, выполните оплату в течение 7  дней, в противном случае заказ будет отменен автоматически из-за изменения запасов товаров.');
define("FS_INQUIRY_SUBMITED",'Отправлено');
define("FS_INQUIRY_QUOTED",'Получено');
define("FS_INQUIRY_DEALED",'Куплено');
define("FS_INQUIRY_CANCELED",'Отменено');
define("FS_INQUIRY_REVIEWING",'Рассмотрено');

// 个人中心详情页面
define("FS_INQUIRY_SUBTOTAL",'Всего');
define("FS_INQUIRY_CHECKOUT",'Оформить заказ');
define("FS_INQUIRY_ADD_FILE",'Добавить Файл');
define("FS_INQUIRY_CANCEL_SUCCESS",'Отменить успешно');
define("FS_NOTES",'Примечания');

// 个人中心列表页面
define("FS_INQUIRY_TOTAL_QUOTE_NUMBER",'Всего запросов: ');
define("FS_INQUIRY_VIEW",'Просмотреть');
define("FS_INQUIRY_CANCEL_THIS_QUOTE",'Отменить это предложение?');
define("FS_INQUIRY_CANCEL_QUOTE_TIP1",'Как только вы отмените, его невозможно восстановить.');
define("FS_INQUIRY_CANCEL_QUOTE_TIP2",'Если вы хотите отметить, пожалуйста, напишите нам причину: ');
define("FS_INQUIRY_CANCEL_REASON1",'Уже купили у других магазинах');
define("FS_INQUIRY_CANCEL_REASON2",'Повторное предложение');
define("FS_INQUIRY_CANCEL_REASON3",'Нет нужных продуктов');
define("FS_INQUIRY_CANCEL_REASON4",'Вопрос о гарантии');
define("FS_INQUIRY_CANCEL_REASON5",'Длинный срок поставки');
define("FS_INQUIRY_CANCEL_REASON6",'Слишком дорогой');
define("FS_INQUIRY_CANCEL_REASON7",'Не нужно');
define("FS_INQUIRY_CANCEL_REQUIRED_TIP",'Пожалуйста, укажите причины отмены предложения перед отправкой просьба.');
define('FS_INQUIRY_EMPTY_PAGE_TIP','Пока не существует запрос на цену. Запросить цену на странице продукта.');
define('FS_INQUIRY_LIST_TIP','Проверить статус ваших запросов и совершить покупку напрямую по льготным ценам.');
define('FS_CANCEL_QUOTE','Отменить запрос на цену');

define("FS_FORWARD_SHIPPING","Перевозчик (включая предоплату таможенных сборов и налоги)");
define("FS_FORWARD_SHIPPING_NOTICE","Указанная цена включает стоимость доставки и возможные пошлины и налоги. Необходимая страховка также будет взиматься и показываться в Итоге Заказа, рассчитанной по сумме промежуточного итога.");
define('FS_CHECK_OUT_INSURANCE','Страховка');

//产品详情页产品树收起提示语
define('FS_COMMON_CLOSE','Меньше');
define('FS_COMMON_FS_PN', 'FS P/N: ');

//新版邮件
define("SEND_MAIL_1","Бесплатная доставка для заказов свыше £79");
define("SEND_MAIL_2","Fiberstore Ltd, Part 7th Floor, 45 CHURCH STREET, Birmingham, B3 2RT");
define("SEND_MAIL_3","Бесплатная доставка для заказов свыше $79");
define("SEND_MAIL_4","<a href='".zen_href_link('index')."' style='text-decoration:none;color: #232323;'>FS.COM</a> INC, 380 CENTERPOINT BLVD, NEW CASTLE, DE 19720");
define("SEND_MAIL_5","Бесплатная доставка для заказов свыше €79");
define("SEND_MAIL_6","GmbH, NOVA Gewerbepark, Building 7, Am Gfild 7, 85375 Neufahrn, Germany");
define("SEND_MAIL_7","Бесплатная доставка для заказов свыше A$99");
define("SEND_MAIL_8","<a href='".zen_href_link('index')."' style='text-decoration:none;color: #232323;'>FS.COM</a> Pty Ltd, ABN 71 620 545 502,57-59 Edison Rd, Dandenong South, VIC 3175, Australia");
define("SEND_MAIL_9","Товары в наличии могут быть отправлены в тот же день");
define("SEND_MAIL_10","<a href='".zen_href_link('index')."' style='text-decoration:none;color: #232323;'>FS.COM</a> Limited Room 2702, 27 Floor Yisibo Software Building, Haitian Second Road, Yuehai Street Nanshan District, Shenzhen, 518054, China");
//Postbank账户
define('FIBER_CHECK_COMMON_ACCOUNT','Номер счета:');
define('FIBER_CHECK_COMMON_CODE','Банковский код:');
define('FIBER_CHECK_COMMON_IBAN','IBAN:');
define('FIBER_CHECK_COMMON_BIC','BIC:');

define('FIBER_CHECK_DO_TITLE','US-$ счет');
define('FIBER_CHECK_DO_ACCOUNT_VALUE','0902543668');
define('FIBER_CHECK_DO_CODE_VALUE','590 100 66');
define('FIBER_CHECK_DO_IBAN_VALUE','DE98 5901 0066 0902 5436 68');
define('FIBER_CHECK_DO_BIC_VALUE','PBNKDEFF590');

define('FIBER_CHECK_GB_TITLE','Британский фунт GBP');
define('FIBER_CHECK_GB_ACCOUNT_VALUE','0902544661');
define('FIBER_CHECK_GB_CODE_VALUE','590 100 66');
define('FIBER_CHECK_GB_IBAN_VALUE','DE59 5901 0066 0902 5446 61');
define('FIBER_CHECK_GB_BIC_VALUE','PBNKDEFF590');

define('FIBER_CHECK_CH_TITLE','Швейцарский франк CHF');
define('FIBER_CHECK_CH_ACCOUNT_VALUE','0902545664');
define('FIBER_CHECK_CH_CODE_VALUE','590 100 66');
define('FIBER_CHECK_CH_IBAN_VALUE','DE41 5901 0066 0902 5456 64');
define('FIBER_CHECK_CH_BIC_VALUE','PBNKDEFF590');

define('FIBER_CHECK_POST_TITLE','Счет в Банке Postbank');
define('FIBER_CHECK_COMMON_ACCOUNT_NAME','Название Счета:');
define('FIBER_CHECK_COMMON_BANK','Название Банка:');
define('FIBER_CHECK_COMMON_ADDRESS','Адрес Банка:');

define('FIBER_CHECK_SG_TITLE','Счёт банка OCBC');
define('FIBER_CHECK_SG_OCBC_USD','Номер счёта USD в OCBC:');
define('FIBER_CHECK_SG_OCBC_SGD','Номер счёта SGD в OCBC:');
define('FIBER_CHECK_SG_INT_BANK','Банк-посредник (для ТТ в долларах США)');
define('FIBER_CHECK_SG_SWIFT','Код SWIFT:');
define('FIBER_CHECK_SG_BANK_CODE','Код банка:');
define('FIBER_CHECK_SG_BRANCH_CODE','Код филиала:');
define('FIBER_CHECK_SG_BRANCH_CODE_CONTENT','Первые 3 цифры Вашего счёта №.');
define('FIBER_CHECK_SG_BRANCH_NAME','Название филиала:');
define('FIBER_CHECK_SG_BRANCH_NAME_CONTENT','СЕВЕРНЫЙ Филиал');
define('FIBER_CHECK_SG_BANK_ADDRESS','Адрес банка:');
define('FIBER_CHECK_SG_BANK_ADDRESS_CONTENT','65 Chulia Street, OCBC Centre, Singapore 049513');

define('FIBER_CHECK_COMMON_ACCOUNT_NAME_VALUE','FS.COM GmbH');
define('FIBER_CHECK_COMMON_BANK_VALUE','Postbank');
define('FIBER_CHECK_COMMON_CODE_ADDRESS_VALUE','Eckenheimer Landstr.242 60320 Frankfurt');


//new_cart
define('FS_NEW_SHIPPING_FREE','Этот заказ может пользоваться бесплатной доставки!');
define('FS_GO_SHOPPING','Продолжить покупку');
define('FS_ENTERPRISE_NETWORK','Корпоративная Сеть');
define('FS_OTN_SOLUTION',' Решение для OTN');
define('FS_DATA_CENTER_SOLUTION','Решение для ЦОД');
define('FS_OEM_SOLUTION',' Решение для OEM');
define('FS_RECENTLY_VIEWED','Недавно вы смотрели');
define ('FS_CART_TIP', 'У вас уже есть аккаунт FS? <a target="_blank" href="'.zen_href_link('login','','SSL').'" class="cart_no_23Link"> Войдите, </a> чтобы просмотреть или изменить товары в корзине. ');
define('FS_ADDED_TO_CART','В корзину');
define('FS_REMOVED','Удалить');
define('FS_SHOP_CART_MOVE','В корзину');
define('FS_SHOP_CART_SAVE','Отложить');
define('FS_SHOP_CART_SIMILAR','Посмотреть связанные продукты');
define('FS_SHOP_CART_SAVED','Отложить');
define('FS_CART_EMPTY','Ваша корзина пуста.');
define('FS_SVAE_FOR_LATER_TIP','уже был отложен.');
define('FS_MOVE_TO_CART_TIP','уже был в корзине.');
define('FS_DELETE_FOR_LATER','Удалить Отложить ');
define('FS_DELETE_SURE_SAVE','Вы уверены, что хотите удалить отложенный продукт?');
define('FS_DELETE_SURE','Вы уверены, что хотите удалить ');
define('FS_DELETE_CART_TITLE','Удалить Сохраненные Корзины');
define('FS_SYMBOL',',');

//四级分类名称
define('FS_CATEGORIES_01','Тип Товара');
define('FS_CATEGORIES_02','Товарная Классификация');
define('FS_CATEGORIES_03','Тип Инструмента');
define('FS_CATEGORIES_04','Тип Медиаконвертеров');
define('FS_CATEGORIES_05','Тип Кабеля');
define('FS_CATEGORIES_06','Тип KVM Консоли');
define('FS_CATEGORIES_07','Тип Видео Конвертера');
define('FS_CATEGORIES_08','Применения');

define('FS_ADDED_TO_CART','Товар добавлен в корзину');

//下架产品气泡,提示
define('FS_PRODUCT_OFF_TEXT','Извините, этот товар уже был удален и больше не доступен для покупки.');
define('FS_PRODUCT_OFF_TEXT_2','Извините, следующие товары могут быть удалены и больше не доступны для покупок из FS.COM.');
define('FS_PRODUCT_OFF_TEXT_3','Выберите атрибуты');
define('FS_PRODUCT_OFF_TEXT_4','Атрибуты следующих заказных товаров изменены, перейдите на страницу о продукте, чтобы выбрать атрибуты.');
define('FS_PRODUCT_OFF_TEXT_5','*Некоторые товары из этого заказа не могут быть добавлены в корзину.');
define('FS_PRODUCT_OFF_TEXT_6','Ваш заказ содержит недоступные товары, пропустите и продолжайте добавлять PO файл.');
define('FS_PRODUCT_OFF_TEXT_7','Ниже товар(ы) больше не доступны и не будут рассчитаны в общую стоимость при оформлении заказа.');
define('FS_PRODUCT_OFF_TEXT_8','Один товар в корзине недоступен. Он не будет рассчитываться при оформлении заказа.');
define('FS_PRODUCT_OFF_TEXT_9','Эти товары в корзине недоступны. Oни не будет рассчитываться при оформлении заказа.');
define('FS_PRODUCT_CLEARANCE_TEXT','Следующие товары могут быть без запасов, пожалуйста, обратитесь к менеджеру своего аккаунта для получения дополнительного количества.');
define('FS_PRODUCT_CLEARANCE_TEXT_1','Указанное Вами количество превышает доступный запас и было скорректировано соответственно, пожалуйста, обратитесь к менеджеру своего аккаунта для получения дополнительного количества.');

// 添加购物车成功弹窗
define('FS_ADDED_ONE_ITEM','Вы добавили [ADDITEM] шт');
define('FS_ADDED_MORE_ITEM','Вы добавили [ADDITEM] шт');
define('FS_PRODUCTS_JS_MOQ','Мин. заказ этого товара - это '); //需要看显示上下文
define('FS_PRODUCTS_JS_UPPER','НЕТ верхнего предела');

define("FS_ECHECK_NOTICE","* Мы принимаем только электронные чеки, выданные банками США. Обработка платежа может занимать 1-2 рабочих дня.");
define("FS_ECHECK_BANK_ACCOUNT","Название банковского счёта");
define("FS_ECHECK_BANK_ACCOUNT_NUMBER","Номер банковского счёта");
define("FS_ECHECK_BANK_ACCOUNT_TYPE","Тип счета");
define("FS_ECHECK_BANK_ACCOUNT_CHECK","Проверено");
define("FS_ECHECK_BANK_ACCOUNT_SAVE","Сохранено");
define("FS_ECHECK_BANK_ACCOUNT_CONFIRM","Подтвердить номер банковского счёта");
define("FS_ECHECK_BANK_ACCOUNT_ROUTE","Номер роутинга ABA/ACH");
define("FS_ECHECK_ERROR_1","Требуется имя банковского счета.");
define("FS_ECHECK_ERROR_2","Требуется номер банковского счёта.");
define("FS_ECHECK_ERROR_3","Требуется тип счёта.");
define("FS_ECHECK_ERROR_4","Подтверждение банка Номер счета требуется.");
define("FS_ECHECK_ERROR_5","Требуется банковский номер роутинга ABA/ACH.");

//quest add 2019.1.07
define('FS_DOWNLOAD','Скачать');
define('FS_DOWNLOADS', 'Загрузки');
define("FS_PRODUCTS_PICK_UP","Бесплатно забрать посылку с понедельника по пятницу. ");
define("FS_PRODUCTS_VIA","");


//fairy 2019.1.15 add
define('FS_COLOR_RED','Красный');
define('FS_COLOR_BLUR','Синий');
define('FS_COLOR_GREEN','Серый');

//账户中心
define('FS_MANAGE_ORDERS_1','Следующая информация предназначена для конечного пользователя или оператора коммутатора. Важно предлагать услуги технической поддержки. Пожалуйста, убедитесь, что вся информация является правдивой и действительной.');
define('FS_MANAGE_ORDERS_2','Заявка отправлена');
define('FS_MANAGE_ORDERS_3','Лицензионный ключ: ');
define('FS_MANAGE_ORDERS_4','Процесс: ');
define('FS_MANAGE_ORDERS_5','Лицензионный ключ принят');
define('FS_MANAGE_ORDERS_6','Активация завершена');
define('FS_MANAGE_ORDERS_7','Информация успешно отправлена. Мы отправим вам письмо с лицензионным ключом для активации коммутатора в ближайшее время.');
define('FS_MANAGE_ORDERS_8','N Серии Cumulus Коммутаторов');
define('FS_MANAGE_ORDERS_9','Лицензионный ключ N Серии Cumulus Коммутаторов');
define('FS_MANAGE_ORDERS_10','Уважаемый(-ая)');
define('FS_MANAGE_ORDERS_11','Ваш лицензионный ключ: ');
define('FS_MANAGE_ORDERS_12','Примечание: Проверка лицензионного ключа займет около 3 дней. После завершения проверки вы можете импортировать её в коммутатор. ');
define('FS_MANAGE_ORDERS_13','1. Использование и ограничения лицензии');
define('FS_MANAGE_ORDERS_14','Лицензионный ключ будет долгосрочным и действительным.');
define('FS_MANAGE_ORDERS_15','Вы можете пользоваться 1 год, а также 45 дней технической поддержки с момента активации. (Дополнительные бесплатные услуги будут просрочены, если вы не используете в течение 45 дней).');
define('FS_MANAGE_ORDERS_16','После истечения срока действия услуги вы можете продолжить ее приобретение, если хотите.');
define('FS_MANAGE_ORDERS_17','2. Процесс импорта лицензионного ключа');
define('FS_MANAGE_ORDERS_18','Пожалуйста, проверьте следующие ресурсы для импорта лицензии:');
define('FS_MANAGE_ORDERS_19','Мы приветствуем вас связаться с нами по любым вопросам во время действия лицензии или желанием расширить услуги технической поддержки. Наша контактная информация следующая:');
define('FS_MANAGE_ORDERS_20','Электронная Почта: ');
define('FS_MANAGE_ORDERS_21','Тел: +7 （499）6434876');
define('FS_MANAGE_ORDERS_23','Пожалуйста, убедитесь, что этот лицензионный ключ остался в безопасности и импортируйте его на коммутатор, когда вам это нужно.');
define('FS_MANAGE_ORDERS_24','С уважением,');
define('FS_MANAGE_ORDERS_25','FS.COM Техническая Команда');
define('FS_MANAGE_ORDERS_26','Видео: ');
define('FS_MANAGE_ORDERS_26_1','Видео');
define('FS_MANAGE_ORDERS_27','PDF: ');
define('FS_MANAGE_ORDERS_28','Телефон: ');
define('FS_MANAGE_ORDERS_29','Бесплатная доставка заказов от суммы заказа €79');
define('FS_MANAGE_ORDERS_30','Получить Лицензионный Ключ');
define('FS_MANAGE_ORDERS_31','Дорогой/ая ');
define('FS_MANAGE_ORDERS_32','Вот ваш лицензионный ключ: ');
define('FS_MANAGE_ORDERS_33','Leaf(10G/25G): 556688 <br />Spine(40G/100G): 335521');
define('FS_MANAGE_ORDERS_34','Обратите Внимание: ');
define('FS_MANAGE_ORDERS_35','1. Лицензионный ключ будет долгосрочным и эффективным. Пожалуйста, убедитесь, что этот лицензионный ключ остается безопасным. Проверка лицензионного ключа занимает около 3 дней.');
define('FS_MANAGE_ORDERS_36','2. После завершения, вы можете импортировать его на коммутатор. Вы можете пользоваться технической поддержкой в течение 1 года и 45 дней. Если вы не используете ее в течение 45 дней, дополнительная бесплатная услуга будет недействительной. После истечения срока действия услуги, вы можете продолжить ее приобретение, если хотите.');
define('FS_MANAGE_ORDERS_37','Как Импортировать Лицензионный Ключ');
define('FS_MANAGE_ORDERS_38','Пожалуйста, проверьте следующие ресурсы для помощи:');
define('FS_MANAGE_ORDERS_39','Мы рады приветствовать вас приходить к нам за любыми вопросами во время действия лицензии или по желанию продления услуг технической поддержки. Наша контактная информация выглядит следующим образом:');
define('FS_MANAGE_ORDERS_40','Электронная Почта: <a style="text-decoration: none;color: #232323;">tech@fs.com</a> <br />Телефон: +7 （499）6434876');
define('FS_MANAGE_ORDERS_41','С уважением,');
define('FS_MANAGE_ORDERS_42','Техническая Команда FS.COM');
define('FS_MANAGE_ORDERS_43','Поле Название Вашей Компании обязательно для заполнения');
define('FS_MANAGE_ORDERS_44','Поле Имя обязательно для заполнения');
define('FS_MANAGE_ORDERS_45','Поле Номер Телефона обязательно для заполнения');
define('FS_MANAGE_ORDERS_46','Поле Адрес Электронной Почты обязательно для заполнения');
define('FS_MANAGE_ORDERS_47','Введите действительный адрес электронной почты.(пример: somebody@example.com).');
define('FS_MANAGE_ORDERS_48','Пожалуйста, нажмите кнопку EULA');
define('FS_MANAGE_ORDERS_49','Поле Ваш Веб-адрес обязательно для заполнения');
define('FS_MANAGE_ORDERS_50','Это сообщение было отправлено к ');
define('FS_MANAGE_ORDERS_51','Бесплатная доставка: Некоторые исключения применяются.');
define('FS_MANAGE_ORDERS_52','Подробнее о нашей');
define('FS_MANAGE_ORDERS_53','политике доставки');
define('FS_MANAGE_ORDERS_54','FS.COM Inc.');
define("CULUMS_OFF1","Подать заявку на активацию");
define("CULUMS_OFF2","Следующая информация предназначена для конечного пользователя или оператора коммутатора. Необходимо предлагать услуги технической поддержки. Пожалуйста, убедитесь, что вся информация является действительной и эффективной. ");
define("CULUMS_OFF3","Название Компании");
define("CULUMS_OFF4","ФИО Пользователя");
define("CULUMS_OFF5","Тел");
define("CULUMS_OFF6","Адрес Эл. Почты");
define("CULUMS_OFF7","Веб-адрес");
define("CULUMS_OFF8","Соглашение EULA.");
define("CULUMS_OFF9","Cumulus Networks®");
define("CULUMS_OFF10","Подать заявку на активацию");
define("CULUMS_OFF11","Лицензионное Соглашение Конечного Пользователя");
define("CULUMS_OFF12","Условия настоящего соглашения, а также Подтверждение Заказа, предоставленное вам (далее - “Лицензиат”) компанией Cumulus Networks, Inc. (”Cumulus“) или реселлером, который уполномочен Cumulus распространять программное обеспечение Cumulus (авторизованный реселлер) являются соглашением между Cumulus и вами. Настоящие условия применяются к программному обеспечению, с которым они распространяются, включая носители, на которых вы их получили, если таковые имеются. Условия  соглашения также применяются к любым обновлениям, дополнениям и услугам поддержки Cumulus для программного обеспечения, которые Cumulus может предоставить вам, если эти элементы не сопровождаются другими условиями. Если да, то применяются эти условия.  Используя программное обеспечение, вы подтверждаете, что у вас есть действительное подтверждение заказа в отношении каждой копии программного обеспечения, которое вы используете, и что вы принимаете эти условия в связи с каждой копией.");
define("CULUMS_OFF13","ЕСЛИ ВЫ НЕ ПРИНИМАЕТЕ ЭТИ УСЛОВИЯ, НЕ ИСПОЛЬЗУЙТЕ ПРОГРАММНОЕ ОБЕСПЕЧЕНИЕ. Используя программное обеспечение, вы принимаете и соглашаетесь соблюдать настоящее лицензионное соглашение (соглашение).");
define("CULUMS_OFF14","АНАЛИЗ, БЕТА-ВЕРСИИ И ЛИЦЕНЗИИ NFR. Если вы получили лицензию на продукт, который идентифицируется Cumulus  как  Оценочная лицензия (Evaluation License)  или бета-лицензия (Beta License), действуют следующие дополнительные ограничения на ваши права: если иное не разрешено в письменном виде  Cumulus, использование продукта (я) допускается только на срок не более тридцати дней в внутренней непроизводственной среде (только тестирование и оценка); и (II)  ограничено не более пятью одновременными экземплярами продукта, исключительно работающих на оборудовании, принадлежащем или исключительно контролируемым вами, если иное не санкционировано  Cumulus. Если вы получите лицензию на продукт, который идентифицируется  Cumulus как лицензия не для перепродажи ( Not-For-Resale - NFR), следующие дополнительные ограничения применяются к лицензии: использование вами продукта разрешено только для одного экземпляра принадлежащего или исключительно контролируемого вами, пока вы являетесь партнером в соответствии с действующей  партнерской программой Cumulus, которая дает вам право на получение NFR лицензии, (II) ограчивающей  демонстрацию, тестирование и обучение (допускается без производства, обработки информации или использования инфраструктуры ). Несмотря на все вышесказанное, оценка, бета-лицензия, лицензионные продукты NFR и любой продукт (или его часть), идентифицированный Cumulus как ранний доступ( Early Access), предоставляются как есть без компенсации, поддержки или гарантий любого рода, явных или подразумеваемых. Вы принимаете на себя все риски, связанные с использованием ознакомительных бета-лицензий и лицензионных продуктов NFR. ЭТО СОГЛАШЕНИЕ МОЖЕТ БЫТЬ ЗАМЕНЕНО ТОЛЬКО ОТДЕЛЬНЫМ, ПОДПИСАННЫМ ПИСЬМЕННЫМ СОГЛАШЕНИЕМ С CUMULUS NETWORKS, INC. КОТОРОЕ ПРЯМО ССЫЛАЕТСЯ НА НАСТОЯЩЕЕ СОГЛАШЕНИЕ И ЗАМЕНЯЕТ ЕГО (ЗАМЕНЯЮЩЕЕ СОГЛАШЕНИЕ)).");
define("CULUMS_OFF15","Стороны договариваются о нижеследующем:");
define("CULUMS_OFF16","1.Терминология");
define("CULUMS_OFF17","a. “Продукт” означает исполняемяемую версия(ы) сетевого программного обеспечения, предоставляемую компанией Cumulus , что ясно определено  в подтверждении заказа(ов) (как определено в разделе 3(а)), регулируемого настоящим Соглашением, и  доступ к его ресурсам, включая все обновления и новые версии продукта доступны для лицензиата в соответствии с настоящим Соглашением и действующей документацей для конечных пользователей.");
define("CULUMS_OFF18","b. Конфиденциальная информация  означает все изобретения, алгоритмы, ноу-хау и идеи, а также всю другую деловую, техническую и финансовую информацию, которую сторона получает от другой стороны, если: а) идентифицирована как конфиденциальная или запатентованная при разлашении или до, или б) лицо может предположить, что такая информация является конфиденциальной с учетом содержания или обстоятельств разглашения.");
define("CULUMS_OFF19","c.  Права собственности  означают патентные права, авторские права, права на коммерческую тайну, права на базу данных sui generis и все другие права интеллектуальной и промышленной собственности любого рода.");
define("CULUMS_OFF20","2.Предоставление Лицензии");
define("CULUMS_OFF21","а. При условии полной оплаты в соответствии с разделом 3 и соблюдением лицензиата других условиями настоящего Соглашения,  Cumulus предоставляет лицензиату, и только лицензиату, при сохранении всех имущественных прав Cumulus, ограниченную, неисключительную, полностью оплаченную лицензию только для копирования и внутреннего использования  лицензиатом количество приобретенных лицензий продукта только на соответствующий срок действия лицензии (“лицензионный срок”), исключительно на соответствующих кремниевых коммутаторах, и исключительно до максимальной скорости порта, как указано в каждом подтверждении заказа (как определено в разделе 3(а)).");
define("CULUMS_OFF22","b. Вышеуказанная лицензия не разрешает сублицензирование, распространение или разглашения данных о продукте третьим лицам, и лицензиат соглашается, что он не будет участвовать в таком сублицензировании, разглашении или распространении.");
define("CULUMS_OFF23","c. Лицензиат не должен (и не должен позволять своим сотрудникам  или третьим лицам): (I) модифицировать или создавать вторичные работы на основе Продукта; (II) не декомпилировать или пытаться получить какой-либо исходный код, или базовые идеи или алгоритмы Продукта (кроме случаев, когда тех случаев, когдаэто разрешено законодательством),  (III) удалять или изменять какие-либо  обозначения товара, товарный знак, авторское право или другие уведомления, встроенные в ИЛИ В или на продукте; или (iv) публиковать или иным образом распространять результаты бенчмаркинга или исследований производительности третьим лицам без предварительного письменного согласия Cumulus. Лицензиат несет единоличную ответственность за соблюдение и соответствие всех условий настоящего Соглашения его сотрудниками, подрядчиками, поставщиками услуг и агентами, а также любыми другими третьими лицами, которым был разрешен доступ к продукту в результате действия или бездействия лицензиата. Лицензиат обязан возместить, обезопасить и защитить Cumulus и его лицензиаров от любых претензий или исков, включая судебные издержки и расходы, которые возникают или являются результатом любого несанкционированного или незаконного использования или распространения продукта.");
define("CULUMS_OFF24","d. Продукт включает в себя пакеты программного обеспечения с открытым исходным кодом (в совокупности “программное обеспечение с открытым исходным кодом”). Каждый пакет с открытым исходным кодом входит в состав Продукта и предоставляются лицензиату в соответствии с действующим открытым исходным кодом программного пакета. В случае любого противоречия между лицензией с открытым исходным кодом программного пакета и текстом настоящего договора, лицензия на пакет программного обеспечения с открытым исходным кодом действует только в отношении этого конкретного пакета с открытым исходным кодом.");
define("CULUMS_OFF25","e. Продукт регулируется экспортными законами, ограничениями и правилами США. Лицензиат не будет экспортировать или реэкспортировать, или разрешать экспорт или реэкспорт продукта в нарушение любых таких законов, ограничений или правил.");
define("CULUMS_OFF26","Ф. Изделие (я) разработано для частного использования, и включает в себя коммерческую тайну и конфиденциальную информацию; (II) является коммерческим продуктом, состоящим из коммерческого компьютерного программного обеспечения и документации для коммерческого программного обеспечения, регулируются в соответствии с положениями документа DFARS Section 227.7202 и FAR Section 12.212 и не должно считаться некоммерческим программным обеспечением и  некоммерческой документацией программного обеспечения в соответствии с любым положением  документа  DFARS; и (III) не не должно предлагается правительственным учреждениям США по лицензии на коммерческое программное обеспечение, как указано в документе Far 52.227-19. в соответствии с 48 h 48 CFR 12.212 и 48 CFR 227.72022, продукт лицензируется для государства и конечных пользователей исключительно как коммерческий продукт и только с теми правами, которые предоставляются другим конечным пользователям в соответствии с условиями настоящего Договора. Этот раздел 2 (f) заменяет собой любое положение в FAR, DFAR или другие положения и дополнения FAR. Неопубликованные права защищены законами об авторском праве Соединенных Штатов.");
define("CULUMS_OFF27","3.Цена; Оплата; Учетная документация.");
define("CULUMS_OFF28","a. В течение срока действия настоящего Соглашения лицензиат может направлять запросы на дополнительные приобретенные лицензии, направляя заказы компании Cumulus или уполномоченному реселлеру. Компания Cumulus или авторизованный реселлер направит в ответ официальный и принятый заказ, подтверждающий количество приобретенных лицензий, срок действия лицензии, общую стоимость, причитающиеся налоги и любые дополнительные условия в отношении приобретенных лицензий (каждая такая форма - “подтверждение заказа”). Каждое подтверждение заказа  включается в настоящее соглашение в полном объеме. Каждая приобретенная лицензия, указанная в подтверждении заказа, позволяет лицензиату создать единую копию продукта и использовать копию продукта в соответствии с предоставленной лицензией, указанной в разделе 2.");
define("CULUMS_OFF29","b. В течение срока действия настоящего Соглашения лицензиат имеет право покупать приобретенные лицензии в соответствии с подтверждениями заказа, предоставленными Cumulus лицензиату (без учета налогов, если таковые имеются).  Если это указано в соответствующем подтверждении заказа, ранее приобретенные лицензии будут немедленно прекращены, как указано в  подтверждении заказа, и заменены новыми приобретенными лицензиями (такая замена, “конвертация”).  Условия, применимые к Конвертациям, будут указаны в соответствующем подтверждении заказа и / или расписании, описывающем специфику такой конвертации (такое расписание, “уведомление о конверсии”).");
define("CULUMS_OFF30","с. Лицензиат обязуется выплатить компании Cumulus (или уполномоченному реселлеру) все применимые сборы, указанные в каждом подтверждении заказа (далее - “сборы”), в течение тридцати (30) дней с момента получения каждого подтверждения заказа или в соответствии с иным соглашением между лицензиатом и уполномоченным реселлером. Соответствующая валюта будет указана в подтверждении заказа, в противном случае это доллары США. Сборы возврату не подлежат. Если явно не указано, что налоги указаны в подтверждении заказа, все причитающиеся суммы не включают налоги, удержания, пошлины, сборы, тарифы и другие государственные сборы (включая, помимо прочего, НДС), за исключением налогов на чистый доход Cumulus (в совокупности “налоги”), и лицензиат несет ответственность за уплату всех налогов. Стороны будут разумно сотрудничать, чтобы законно минимизировать налоги. В случае если  лицензиат не платит Cumulus или авторизованным реселлерам какую либо часть взносов в установленный срок,  лицензиат обязуется также заплатить Cumulus или авторизованным реселлерам за просрочку платежа в размере 1,5% от общей задолжности за месяц за период, в которы  любые такие сборы являются просроченными, если иное не согласовано между лицензиатом и уполномоченным реселлером.");
define("CULUMS_OFF31","d. В течение срока действия настоящего Соглашения и в течение одного (1) года после его прекращения лицензиат будет создавать и вести записи, касающиеся использования лицензиатом продукта, которые должны включать, без ограничений, каждую установку копии продукта и уникальный идентификатор оборудования, на котором он установлен (в совокупности записи). По запросу Cumulus лицензиат незамедлительно предоставит такие записи Cumulus с целью проверки соблюдения настоящего Соглашения. В случае, если лицензиату не удается создать, сохранить или отправить записи, как требуется в этом разделе или в случае каких-либо споров в отношении точности такой информации, Cumulus  могут проверить использование лицензиатом продукта (например, через обзор копии соответствующих лог-файлов и т. д.), в любом месте, в котором продукт установлен или был установлен или иным образом использован лицензиатом.");
define("CULUMS_OFF32","4.Доставка и техническая поддержка.");
define("CULUMS_OFF33","a. После получения первого подтверждения заказа по настоящему Соглашению Cumulus незамедлительно доставит лицензиату один экземпляр Продукта в исполняемом виде.");
define("CULUMS_OFF34","b. Лицензиат может заказать услуги технической поддержки у Cumulus, как указано в соответствующем подтверждении заказа,  при условии оплаты лицензиатом применимых сборов за поддержку.  Лицензиат признает и соглашается с тем, что поддержка Cumulus регулируется условиями и положениями, изложенными по следующему адресу: <a href= 'javascript:;' >https://cumulusnetworks.com/support/overview/< / a> (“программа технической поддержки Cumulus”).");
define("CULUMS_OFF35","С. Если это не запрещено договором или законом, Cumulus предоставляет лицензиату обновления и новые версии продукта, которые он делает общедоступными для клиентов Cumulus, при условии, что лицензиат имеет одну или несколько приобретенных лицензий, которые находятся в хорошем состоянии в соответствии с настоящим Соглашением, и лицензиат заказал и оплатил программу поддержки Cumulus, как указано в соответствующем подтверждении заказа.");
define("COLUMNS_OFF36", "5. Публичность; Раскрытие Соглашения; Товарные Знаки.");
define("CULUMS_OFF37","a. Cumulus имеет право ссылаться на Лицензиата как на клиента без раскрытия условий настоящего Соглашения. За исключением случаев, предусмотренных законом или иным образом изложенных в настоящем Соглашении, все публичные объявления, касающиеся условий настоящего Соглашения, согласовываются между Cumulus и Лицензиатом по взаимному согласию.");
define("CULUMS_OFF38","b. За исключением случаев, оговоренных в настоящем документе, ни одна из сторон не может использовать товарные знаки и знаки обслуживания другой стороны (знаки), кроме как в соответствии с письменным (включая электронные сообщения) одобрением другой стороны. Лицензиат предоставляет Cumulus ограниченную лицензию на использование знаков лицензиата в соответствии с руководящими принципами использования знаков лицензиата с единственной целью идентификации лицензиата в качестве клиента. Стороны не будут иным образом использовать или регистрировать (или делать какую-либо регистрацию в отношении) знаков другой стороны в любой точке мира. Ни одна из сторон не будет оспаривать в любой точке мира использование или разрешение другой стороной любого из знаков такой стороны. Никакое другое право или лицензия в отношении любого товарного знака, фирменного наименования или другого обозначения не предоставляется в соответствии с настоящим Соглашением.");
define("CULUMS_OFF39","6.Запрет На Уступку. Ни настоящее Соглашение, ни какие-либо права, лицензии или обязательства по нему не могут быть уступлены любой из сторон без предварительного письменного согласия не уступающей стороны; любая запрещенная предполагаемая уступка является недействительной. Несмотря на вышеизложенное, каждая из сторон вправе переуступать данное соглашение или делегировать свои права и обязанности  любому покупателю полной  или существенной части такой стороны активов или бизнеса или ценных бумаг, относящихся к предмету настоящего Соглашения, при условии, что в случае любого такого назначения, после получения уведомления об уступке, не назначенная сторона обязана в течение тридцати дней расторгнуть настоящий Договор после письменного уведомления.");
define("CULUMS_OFF40","7.Срок действия Соглашения. Срок действия настоящего Соглашения действует до окончания последнего срока действия лицензии.  Настоящее соглашение автоматически прекращает свое действие, включая предоставление лицензии в разделе 2, Если лицензиат не выполняет какое-либо из условий раздела 2. Настоящее соглашение может быть расторгнуто, если любая из сторон существенно не выполняет или не соблюдает настоящее Соглашение или любое существенное положение настоящего соглашения. Прекращение вступает в силу через тридцать (30) дней после уведомления о расторжении договора виновной стороне, если невыполненные обязательства  не будут устранены в течение тридцати (30) дней.");
define("CULUMS_OFF41","8.Выживание. Права на оплату, разделы 1, 2 (b-e), 3 (b), 6, 7, 8, 9, 10, 11, 12, 13 (14 и, за исключением случаев, прямо предусмотренных в настоящем документе, любое право на иск о нарушении настоящего Соглашения до его прекращения остается в силе после прекращения действия настоящего Соглашения. В случае прекращения действия лицензии за нарушение Cumulus, все приобретенные лицензии остаются в силе до окончания срока действия лицензии. В случае прекращения действия лицензии за нарушение лицензиатом, все приобретенные лицензии должны быть немедленно прекращены.");
define("CULUMS_OFF42","9.Уведомления и запросы. Все уведомления, согласия, разрешения и запросы в связи с настоящим Соглашением, считаются полученными сразу после того, как они были отправлены воздушной курьерской пересылкой, и оплачены расходы; и направлены в  юридический отдел при условии в последнем подтверждения заказа,  регулируещегося настоящим Соглашением или по другому адресу, как лицо стороне, получившей  уведомление или запрос, обощначенный путем письменного уведомления в соответствии с разделом 9.");
define("CULUMS_OFF43","10.Контролирующий закон; гонорар адвоката. Настоящее Соглашение регулируется и толкуется в соответствии с законами штата Калифорния и США без учета положений коллизионного права и без учета UCITA или Конвенции Организации Объединенных Наций о договорах международной купли-продажи товаров. Исключительной юрисдикцией и местом рассмотрения исков, связанных с предметом настоящего соглашения, являются суды штата Калифорния и федеральные суды США в округе Санта-Клара, штат Калифорния. Обе стороны дают согласие на юрисдикцию и место в таких судах и соглашается, что процесс может быть проведен в порядке, предусмотренном договором об уведомлениях, или как разрешено в  Калифорнии или федеральным законом. Сторона, выигравшая спор, имеет право на возмещение разумной части  расходов на оплату услуг адвокатов и других расходов.");
define("CULUMS_OFF44","11.Конфиденциальность");
define("CULUMS_OFF45","Ценовые условия данного Соглашения, товаров и основополагающие изобретения, алгоритмы, ноу-хау и идеи -  служебной информация Cumulus . За исключением случаев, прямо и недвусмысленно разрешенных в настоящем документе, лицензиат будет хранить в тайне и не будет использовать или раскрывать какую-либо конфиденциальную информацию, а его сотрудники и подрядчики будут также связаны в письменной форме. Ничто в настоящем Соглашении не разрешает принимающей стороне раскрывать или использовать, за исключением случаев, явно разрешенных в другом месте настоящего Соглашения, конфиденциальную информацию раскрывающей стороны, а затем только по мере необходимости для целей настоящего Соглашения. При расторжении настоящего Соглашения лицензиат обязуется незамедлительно вернуть или уничтожить любую информацию, являющуюся собственностью лицензиата, а также любые ее копии, выдержки и производные, если иное не предусмотрено настоящим Соглашением. Кроме того, лицензиат должен немедленно уничтожить все копии продукта  i), как только действующие лицензии истекает в отношении этой копии продукта; и II) до распределения оборудования, где продукт установлен третьим лицам, в том числе оборудования, продавцу или производителю. Каждая сторона признает, что нарушение ею настоящего раздела 11 нанесет непоправимый ущерб другой стороне, денежный ущерб которой не является адекватным средством правовой защиты. Соответственно, одна сторона будет иметь право добиваться судебного запрета и других справедливых средств правовой защиты в случае такого нарушения другой стороной.");
define("CULUMS_OFF46","12.Ограниченная Ответственность. ЗА ИСКЛЮЧЕНИЕМ СЛУЧАЕВ, ПРЕДУСМОТРЕННЫХ НИЖЕ, А ТАКЖЕ НЕСМОТРЯ НА ДРУГИЕ ПОЛОЖЕНИЯ НАСТОЯЩЕГО СОГЛАШЕНИЯ ИЛИ В ПРОТИВНОМ СЛУЧАЕ, НИ ОДНА ИЗ СТОРОН НЕ НЕСЕТ ОТВЕТСТВЕННОСТЬ ИЛИ ОБЯЗАТЕЛЬСТВА ПО КАКОМУ-ЛИБО РАЗДЕЛУ НАСТОЯЩЕГО ДОГОВОРА ИЛИ В РАМКАХ КОНТРАКТА, ХАЛАТНОСТЬЮ, СТРОГОЙ ОТВЕТСТВЕННОСТЬЮ ИЛИ ДРУГИМ ЮРИДИЧЕСКИМ ИЛИ СПРАВЕДЛИВЫМ ТЕОРИЯМ  (A) ДЛЯ ЛЮБЫХ СУММ, ПРЕВЫШАЮЩИХ СОВОКУПНОСТЬ УПЛАЧЕННЫХ ЕЙ ЛИЦЕНЗИОННЫХ ПЛАТЕЖЕЙ (В СЛУЧАЕ CUMULUS) ИЛИ (В СЛУЧАЕ ЛИЦЕНЗИАТА), ВЫПЛАЧЕННЫЕ ИЛИ ПРИЧИТАЮЩИЕСЯ С НЕГО ПО НАСТОЯЩЕМУ СОГЛАШЕНИЮ, ИЛИ (B) ЛЮБЫЕ СЛУЧАЙНЫЕ ИЛИ КОСВЕННЫЕ УБЫТКИ, УПУЩЕННАЯ ВЫГОДА (ЗА ИСКЛЮЧЕНИЕМ СУММ, ПОДЛЕЖАЩИХ ВЫПЛАТЕ В СООТВЕТСТВИИ С РАЗДЕЛОМ 3) ИЛИ УТРАЧЕННЫЕ ИЛИ ПОВРЕЖДЕННЫЕ ДАННЫЕ ИЛИ ПРЕРВАННОЕ ИСПОЛЬЗОВАНИЕ ИЛИ (С) РАСХОДЫ НА ЗАКУПКУ ЗАМЕЩАЮЩИХ ТОВАРОВ, ТЕХНОЛОГИЙ ИЛИ УСЛУГ. Ограничения, изложенные в настоящем разделе 12, не применяются к нарушениям разделов 2(b-e) и 11 или к действиям лицензиата, выходящим за рамки лицензии, предоставляемой по настоящему Соглашению.");
define("CULUMS_OFF47","13.Гарантия.");
define("CULUMS_OFF48","a. Cumulus гарантирует лицензиату, что продукт будет хорошего качества и разработан  в соответствии с самыми высокими профессиональными стандартами. Единственным средством правовой защиты лицензиата от нарушения настоящей гарантии или дефектов продукта являются его права в соответствии с разделом 4(b). Cumulus не дает никаких гарантий относительно возможности ошибок или бесперебойного использования.");
define("CULUMS_OFF49",". Продукт не создан, предназначен или сертифицирован для использования в компонентах или системах, предназначенных для работы с опасными системами или приложениями (например, оружия, систем вооружения, ядерных установок, средств общественного транспорта, авиации, жизнеобеспечения, компьютеров или оборудования (в том числе реанимационного оборудования и хирургических имплантов), контроля за загрязнением, управление опасными веществами, или на любые другие опасные приложения), в которых отказ работы продукта может создать ситуацию, которая может привести к получению травмы или смерти. Лицензиат понимает, что использование продукта в таких приложениях полностью находится на риске лицензиата, и лицензиат настоящим принимает на себя весь такой риск.");
define("CULUMS_OFF50","с. ЗА ИСКЛЮЧЕНИЕМ СЛУЧАЕВ, ПРЯМО УКАЗАННЫХ ВЫШЕ, CUMULUS НЕ ДАЕТ НИКАКИХ ГАРАНТИЙ ЛЮБОМУ ФИЗИЧЕСКОМУ ИЛИ ЮРИДИЧЕСКОМУ ЛИЦУ В ОТНОШЕНИИ ПРОДУКТА И ОТКАЗЫВАЕТСЯ ОТ ВСЕХ ПОДРАЗУМЕВАЕМЫХ ГАРАНТИЙ, ВКЛЮЧАЯ БЕЗ ОГРАНИЧЕНИЙ ГАРАНТИИ ТОВАРНОЙ ПРИГОДНОСТИ И ПРИГОДНОСТИ ДЛЯ КОНКРЕТНОЙ ЦЕЛИ И НЕНАРУШЕНИЯ ПРАВ.");
define("CULUMS_OFF51","д. КАЖДАЯ СТОРОНА ПРИЗНАЕТ И СОГЛАШАЕТСЯ С ТЕМ, ЧТО ОТКАЗ ОТ ГАРАНТИЙ И ОТВЕТСТВЕННОСТИ И ИСПРАВЛЕНИЯ В НАСТОЯЩЕМ ДОГОВОРЕ И ОГРАНИЧЕНИЯ ЯВЛЯЮТСЯ ВОПРОСОМ ДЛЯ ОБСУЖДЕНИЯ ДЛЯ ОСНОВЫ ЭТОГО СОГЛАШЕНИЯ И, ЧТО ОНИ БЫЛИ УЧТЕНЫ И ОТРАЖЕНЫ В ОПРЕДЕЛЕНИИ РАССМОТРЕНИЯ КАЖДОЙ СТОРОНОЙ В РАМКАХ НАСТОЯЩЕГО СОГЛАШЕНИЯ И В РЕШЕНИИ КАЖДОЙ ИЗ СТОРОН ЗАКЛЮЧИТЬ ДАННОЕ СОГЛАШЕНИЕ.");
define("CULUMS_OFF52","14.Общее. Настоящее соглашение представляет собой полное соглашение между сторонами в отношении предмета настоящего соглашения и объединяет все предыдущие и одновременные сообщения. Оно не может быть изменено, за исключением письменного соглашения, датированного последующей датой настоящего Соглашения и подписанного от имени лицензиата и Cumulus их должным образом уполномоченными представителями. Если какое-либо положение настоящего Соглашения будет признано судом компетентной юрисдикции незаконным, недействительным или неисполнимым, такое положение должно быть ограничено или исключено в минимально необходимой степени, чтобы это соглашение оставалось в силе и подлежит исполнению. Никакой отказ от любого нарушения любого положения настоящего Соглашения не является отказом от любого предыдущего, одновременного или последующего нарушения того же или любого другого положения настоящего Соглашения, и никакой отказ не имеет силы, если он не сделан в письменной форме и не подписан уполномоченным представителем отказывающейся стороны.");
define("CULUMS_OFF53","Отправить");
define("CULUMS_OFF54","Авторские права  @ 2002-".date('Y',time())." FS.COM Limited Все права защищены.");
define("CULUMS_OFF55","политика конфиденциальности");
define("CULUMS_OFF56","Информация  успешно отправлена. В течение 10 минут мы отправим вам электронное письмо с лицензионным кодом для активации коммутатора.");
define("CULUMS_OFF57","Требуется Название вашей компании");
define("CULUMS_OFF58","Требуется ваш номер телефона");
define("CULUMS_OFF59","Требуется ваш адрес электронной почты");
define("CULUMS_OFF60","Указанный адрес электронной почты не распознан (пример: someone@example.com)");
define("CULUMS_OFF61","Пожалуйста, поставьте галочку о принятии условий Соглашения  EULA");
define("CULUMS_OFF62","Требуется ваш веб-адрес");
define("CULUMS_OFF63","Вы предоставили информацию для проверки, пожалуйста, не отправляйте повторно");
define("CULUMS_OFF64","Информация успешно отправлена, вам не нужно отправлять снова.");
define("CULUMS_OFF65","Информация о Товаре");
define("CULUMS_OFF66","Поделиться своим опытом использования ");

//2019-01-07 继续付款，再次付款，付款成功
define('FS_PAYMENT_CONFIRM','Подтвердить');
define('PAYMENT_AGAINST_PAYPAL_SECURITY','Вы будете перенаправлены на счет PayPal для оплаты этого заказа.');
define('PAYMENT_AGAINST_BANK_SENTENCE01','Средства дойдут в течение 1-3 рабочих дня. Мы обрабатываем ваш заказ после получения оплаты.');
define('PAYMENT_AGAINST_BANK_SENTENCE02','Если вы платите, сообщите нам, чтобы мы могли проверить ваш платеж и своевременно обработать ваш заказ.');
define('PAYMENT_AGAINST_BANK_FILL','Заполните Вашу Информацию о Банковском Переводе');
define('PAYMENT_AGAINST_PAYPAL','PayPal');
define('PAYMENT_AGAINST_BANK','Банковский Перевод');
define('PAYMENT_AGAINST_EDIT','Редактировать');
define('PAYMENT_AGAINST_BANK_EMAIL','Адрес Электронной Почты Плательщика');

define('FS_ORDER_UPLOAD_PO_PURCHASE_ERROR_TIP','Номер заказа на покупку не может быть пустым.');
define("FS_ORDER_UPLOAD_PO_MESSAGE",'Ваш заказ не будет отправлен, пока не получен действительный документ заказа на покупку (PO) в течение 7 рабочих дней.');

define('FS_AGAINST_PAYER','Имя Плательщика');
define('FS_AGAINST_PAY_TIME','Время Оплаты');
define('FS_AGAINST_PAY_AMOUNT','Сумма Оплаты');
define('FS_AGAINST_COUNTRY','Страна');
define('FS_AGAINST_PHONE','Номер Телефона Плательщика');
define('FS_AGAINST_OR','Пожалуйста, заполните полное имя, которое вы используете для банковского перевода, будь то физическое или юридическое лицо.');
define('FS_AGAINST_YOUR','Поле Ваше Время Оплаты обязательно для заполнения(например: 26/01/2019)');
define('FS_AGAINST_MUST','Должен быть действительный номер телефона, по которому мы можем связаться с вами при необходимости');

define('FS_BT_SUCCESSFULLY','Обновление успешно!');
define('FS_BT_SUCCESSFULLY_SENTENCE_01','Средства обычно поступают в течение 1-3 рабочих дня. Мы разберемся с этим как можно скорее. Нажмите');
define('FS_BT_SUCCESSFULLY_SENTENCE_02',' История Заказов ');
define('FS_BT_SUCCESSFULLY_SENTENCE_03','для увидения заказа.');

define("FS_CHECKOUT_NEW28","Copyright © 2009-2019 FS.COM Ltd. Все Права Защищены.");

define('GLOBAL_GS_SENTENCE1','Обратите внимание: Мы не будем сохранять данные вашей кредитной карты для безопасности.');
define('GLOBAL_GS_SENTENCE2','Мы принимаем следующие кредитные / дебетовые карты, а также P-карты, выпущенную этими компаниями. Выберите тип карты, заполните информацию ниже и нажмите \'Подтвердить.');
define('GLOBAL_GS_SENTENCE3', 'Мы принимаем следующие кредитные / дебетовые карты. В целях безопасности мы не будем сохранять данные вашей кредитной карты.');
define('FS_AGAINST_WE','Мы принимаем следующие кредитные / дебетовые карты, а также P-карты, выпущенную этими компаниями. Выберите тип карты, заполните информацию ниже и нажмите \'Подтвердить.');
define("GLOBAL_GC_TEXT6","Выберите кредитную/дебетовую карту:");
define("GLOBAL_GC_TEXT7","Сумма Заказа");
define("GLOBAL_GC_TEXT8","Номер Заказа");
define("GLOBAL_GC_TEXT11","Платежный Адрес");
define("GLOABL_GC_LIVECHAT","Чат Сейчас");
define("GLOABL_CART","Корзина");
define("GLOABL_CHECKETOUT","Оплатить");
define("GLOABL_SUCCESS","Успешно");
define("GLOBAL_EXPECTED_SHIPPING","Ожидаемая Отправка");
define("GLOBAL_EXPECTED_DELIVERY", "Доставлен");
define('FS_ALLOWED_FILE_TYPES','Доступны типы файлов ');
define('CHECKOUT_BILLING_CREDIT','Оплата кредитной/дебетовой картой');
define('FS_GC_TIPS_01','Извините, ваш запрос отклонен. Проверьте и попробуйте снова, или выберите другой способ оплаты.');
define('FS_GC_TIPS_02','1. Сумма платежа превышает ограничение (€ 15000) ;');
define('FS_GC_TIPS_03','2. Карта не поддерживает платеж в данной валюте;');
define('FS_GC_TIPS_04','3. Ошибка сети. Попробуйте позже.');
//加购弹窗
define('FS_ADD_CART_PROCHUSE','Итого ');

//地址模块 start
define("FS_ADD_NEW_ADDRESS","Добавить новый адрес");
define('FS_ADD_SHIPPING_ADDRESSES','Добавить новый адрес');
define('FS_ADD_BILLING_ADDRESS','Добавить новый платежный адрес');
//地址模块 end
define('FS_REGIST','Регистрация');
//询价弹窗
define("FS_INQUIRY_YOUR_ITEM",'Товары');

define('FS_SAMPLE_APPLICATION_SUBMIT','Отправить...');
define("CHECKOUT_TAXE_CLEARANCE_CN_FRONT","Для заказов, отправленных с нашего международного склада в Азии (CN), мы взимаем плату только за товар и доставку. Никакие налоги с продаж (напр. НДС или GST) не взимаются. Тем не менее, отправления могут облагаться ввозными или таможенными пошлинами, в зависимости от законов/правил конкретной страны. Любой тариф или ввозная пошлина, вызванная таможенным оформлением, должны быть задекларированы и оплачены получателем. Для заказов отправленных из Малайзии, Индонезии и Филиппин, мы предоставляем услугу “Почтовый форвардинг”, как метод перевозки товара, для того чтобы помочь клиентам с предоплатой пошлин и налогов. Для клиентов из других стран предлагаем связаться с нами, если вам нужна помощь в оплате таможенных пошлин.");

// 上传 start
//2018-9-20 ery add
define('FS_COMMON_FILE','файл');
//服务器端的提示
define("FS_UPLOAD_ERROR1",'Ошибка первого приложения: ');
define("FS_UPLOAD_ERROR2",'Ошибка второго приложения: ');
define("FS_UPLOAD_ERROR3",'Ошибка третьего приложения: ');
define("FS_UPLOAD_ERROR4",'Ошибка четвёртого приложения: ');
define("FS_UPLOAD_ERROR5",'Ошибка пятого приложения: ');
// 2019.2.26 fairy add
define("FS_UPLOAD_FORMAT_TIP",'Доступны типы файлов $FILE_TYPE');
define("FS_UPLOAD_SIZE_DEFAULT_TIP",'Максимальный размер файла: 5M.');
// 上传 end

//信用卡新加坡渠道弹窗
define("GLOABL_TEXT_DECLINED_1","Ой, ваша кредитная карта отклонена. Это обусловлено одной из следующих причин:");
define("GLOABL_TEXT_DECLINED_2","1.Убедитесь, что за 30 дней существует не более 2 уникальных платёжных адресов, связанных с картой или с электронной почтой.");
define("GLOABL_TEXT_DECLINED_3","2.Убедитесь, что страна, где ваш карта выдана, совпадает со страной в адресе доставки.");
define("GLOABL_TEXT_DECLINED_8","3.Убедитесь, что страна, где ваш карта выдана, совпадает со страной в платёжном адресе.");
define("GLOABL_TEXT_DECLINED_4","Обратитесь в отдел по работе с клиентами организации, выпустившей вашу кредитную карту. Если проблуму не можно решить, советуем попробовать другую кредитную карту или изменить способ оплаты на PayPal, Банковский Перевод (Wire Transfer) или Чек.");
define("GLOABL_TEXT_DECLINED_5","Ваша кредитная карта отклонена банком-эмитентом");
define("GLOABL_TEXT_DECLINED_6","Отклонение вашей карты обусловлено различными причинами. Общие причины включают:");

define("GLOABL_TEXT_DECLINED_7","Обратитесь в отдел по работе с клиентами организации, выпустившей вашу кредитную карту. Либо можно попробовать другую кредитную карту или изменить способ оплаты на PayPal или Банковский Перевод (Wire Transfer).");
define("GLOABL_TEXT_DECLINED_9","Нажмите здесь, чтобы оплатить другим способом оплаты.");
define("GLOABL_TEXT_DECLINED_10","Пожалуйста, разбейте заказ на части, если сумма превышает € 15000.00, или");
define("GLOABL_TEXT_DECLINED_11"," нажмите здесь, ");
define("GLOABL_TEXT_DECLINED_12","чтобы оплатить другим способом оплаты.");

define('FS_CLEARACNE_05','Больше');
define('FS_CLEARACNE_06','подробнее');

//退换货提示
define('FS_ACCOUNT_HISTORY_1','Пожалуйста, подтвердите получение пакета, возврат&amp;замена будут активированы.');

//详情页定制产品加购弹窗
define('FS_CUSTOMIZED_INFORMATION','Заказная Информация');
define('FS_CUSTOMIZED','Заказной');
define('FS_PROCESSING','Обработанные');
define('FS_SHIPPING','Отправка');
define('FS_DELIVERED','Доставка');
define('FS_PROCESSING_EST','Обработка: ');
define('FS_SHIPPING_EST','Отправка: ');
define('FS_DELIVERED_EST','Доставка: ');
define('FS_BUSINESS_DAYS_ADD',' рабочих дней');
define('FS_BUSINESS_DAYS_DELIVER_TO',' рабочих дней, доставить в ');
define('FS_EST','Около ');
define('FS_CUSTOMIZED_ADD_TO_CART','Подтвердить');
define('FS_KEEP_SHOPPING','Продолжить Покупки');
define('FS_CONTINUE_TO_CART','Перейти в Корзину');

define('FS_PRODCUTS_INFO_VIEW','Посмотреть Полную Спецификацию:');
define ('FS_PRODUCTS_INFO_VIEW_NEW', 'Больше');

define('FS_PRE_ORDER','Предзаказ');
define('FS_DAY_PROCESSING','<span class="process_time_dylan">$DAYNUMBER</span> -дневное время обработки');
define('FS_DAY_PROCESSING_SEARCH','<span class="process_time_dylan">$DAYNUMBER</span> -дневное время обработки');

define("PREORDER_DESPRCTION","Предзаказ специализируется на  исследованиях и разработках, клиентоориентированную сборку. Основан на экономии от масштабов и автоматизации производства, что позволяет нам предоставлять оптовую закупку и обеспечивать проекты клиентов, чей бюджет строго определен, экономически выгодной продукцией, а также гарантировать более быструю доставку, чем  у других компаний.");

//新版邮件公共头尾语言包
define('EMAIL_COMMON_FOOTER_NEW_01',"Поделиться своим опытом использования #");
define('EMAIL_COMMON_FOOTER_NEW_02',"Вы получили это письмо на адрес ");
define('EMAIL_COMMON_FOOTER_NEW_03',"Если Вы не хотите получать рассылку или изменить персональные настройки. Нажмите здесь. ");
define('EMAIL_COMMON_FOOTER_NEW_04',"FS.COM Inc, 380 Centerpoint Blvd, New Castle, DE 19720");
define('EMAIL_COMMON_FOOTER_NEW_05',"Свяжитесь с нами");
define('EMAIL_COMMON_FOOTER_NEW_06',"Личный кабинет");
define('EMAIL_COMMON_FOOTER_NEW_07',"Доставка");
define('EMAIL_COMMON_FOOTER_NEW_08',"Возврат");
define('EMAIL_COMMON_FOOTER_NEW_09'," Все права защищены.");
define('EMAIL_COMMON_FOOTER_NEW_10',"Copyright &copy; ");

//密码重置成功之后的邮件
define('RESET_PASS_SUCCESS_01',"Ваш пароль успешно изменен. Вы можете использовать новый пароль сразу на всех наших сайтах.");
define('RESET_PASS_SUCCESS_02','Войти в личный кабинет');
define('RESET_PASS_SUCCESS_03',"Если этот запрос сделан не Вами, пожалуйста, ответьте на это письмо или позвоните нам по телефону +7 (499) 6434876.");
define('RESET_PASS_SUCCESS_04','С уважением<br>Команда FS');
define('RESET_PASS_SUCCESS_05','Уважаемый/-ая');
define('RESET_PASS_SUCCESS_TITLE','Пароль Обновлен');
define('RESET_PASS_SUCCESS_THEME','Ваш пароль был обновлен');

//发送重置密码的邮件
define('RESET_PASS_SEND_01',"Мы получили ваш запрос на восстановление пароля FS аккаунта. Если вы не отправили этот запрос, проигнорируйте это письмо. Если вы отправили этот запрос, нажмите кнопку ниже, чтобы получить новый пароль.");
define('RESET_PASS_SEND_02',"Установить новый пароль");
define('RESET_PASS_SEND_03',"P.S. Если у вас возникли проблемы с нажатием кнопки восстановление пароля, скопируйте и вставьте следующий код на страницу восстановления пароля.");
define('RESET_PASS_SEND_04',"С уважением<br>Команда FS");
define('RESET_PASS_SEND_05',"Уважаемый/-ая");
define('RESET_PASS_SEND_06',"Нет пароля? нет проблем. мы поможем вам сбросить его.");
define('RESET_PASS_SEND_TITLE','Восстановление Пароля');
define('RESET_PASS_SEND_THEME','Инструкция по восстановлению пароля');
define('RESET_PASS_EXPIRE_TIME','Срок действия этого кода истекает через 4 часа. Чтобы получить новую ссылку для восстановления пароля, посетите
<a style="color: #0070BC;text-decoration: none" href="'.zen_href_link(FILENAME_LOGIN).'">'.zen_href_link(FILENAME_LOGIN).'</a>');

//修改邮箱成功之后的邮件
define('RESET_EMAIL_SUCCESS_01',"Ваш адрес эл. почты успешно сменен на ");
define('RESET_EMAIL_SUCCESS_02','Уважаемый/-ая');
define('RESET_EMAIL_SUCCESS_03','Используйте этот адрес для доступа к информации ');
define('RESET_EMAIL_SUCCESS_04',"Личный кабинет");
define('RESET_EMAIL_SUCCESS_05',".");
define('RESET_EMAIL_SUCCESS_06',"Если вы не просили изменить свои данные, пожалуйста, посетите ");
define('RESET_EMAIL_SUCCESS_07',"С уважением<br>Команда FS");
define('RESET_EMAIL_SUCCESS_TITLE','Адрес Эл. Почты Обновлен');
define('RESET_EMAIL_SUCCESS_THEME','FS - Ваш адрес эл. почты был обновлен');

//个人用户注册
define('REGIST_EMAIL_SEND_01',"Ваш аккаунт был успешно создан. Теперь вы можете войти, используя свой адрес эл. почты и пароль.");
define('REGIST_EMAIL_SEND_02',"Уважаемый/-ая");
define('REGIST_EMAIL_SEND_03',"Ваш аккаунт был успешно создан. Теперь вы можете ");
define('REGIST_EMAIL_SEND_04',"войти");
define('REGIST_EMAIL_SEND_05'," с помощью эл. почты и пароля.");
define('REGIST_EMAIL_SEND_06',"После входа, вы можете:");
define('REGIST_EMAIL_SEND_07',"Редактировать свой ");
define('REGIST_EMAIL_SEND_08',"личный кабинет");
define('REGIST_EMAIL_SEND_09'," и легко запросить доступ к службам FS.");
define('REGIST_EMAIL_SEND_10',"Отправить ");
define('REGIST_EMAIL_SEND_11',"запрос технической поддержки");
define('REGIST_EMAIL_SEND_12'," и получить бесплатный & немедленный ответ.");
define('REGIST_EMAIL_SEND_13',"Сделать покупку онлайн и отслеживать статус заказа в любое время.");
define('REGIST_EMAIL_SEND_14',"С уважением<br>Команда FS");
define('REGIST_EMAIL_SEND_15',"Ваш личный кабинет был успешно создан, номер - ");
define('REGIST_EMAIL_SEND_16',". Теперь Вы можете ");
define('REGIST_EMAIL_SEND_TITLE','Аккаунт Создан');
define('REGIST_EMAIL_SEND_THEME','Начните делать покупки с новой учетной записью FS!');

//企业用户注册(新用户注册)
define('REGIST_COM_EMAIL_SEND_01','Мы получили ваш запрос на бизнес-аккаунт. Заявка сейчас находится на рассмотрении, и этот процесс может занять от 1 до 3 рабочих дней. ');
define('REGIST_COM_EMAIL_SEND_03','Мы получили ваш запрос на бизнес-аккаунт. Заявка сейчас находится на рассмотрении, и этот процесс может занять от 1 до 3 рабочих дней. 
Результат заявки будет выслан своевременно по почте FS.');
define('REGIST_COM_EMAIL_SEND_02','Уважаемый/-ая');
define('REGIST_COM_EMAIL_SEND_04','До одобрения, вы можете ');
define('REGIST_COM_EMAIL_SEND_05','войти,');
define('REGIST_COM_EMAIL_SEND_06',' используя свой адрес эл. почты и пароль, и пользоваться стандартными услугами аккаунта в первую очередь.');
define('REGIST_COM_EMAIL_SEND_07','После входа, вы можете:');
define('REGIST_COM_EMAIL_SEND_08','Редактировать свой ');
define('REGIST_COM_EMAIL_SEND_09','личный кабинет');
define('REGIST_COM_EMAIL_SEND_10',' и легко запросить доступ к службам FS.');
define('REGIST_COM_EMAIL_SEND_11','Отправить ');
define('REGIST_COM_EMAIL_SEND_12','запрос технической поддержки');
define('REGIST_COM_EMAIL_SEND_13',' и получить бесплатный & немедленный ответ.');
define('REGIST_COM_EMAIL_SEND_14','Сделать покупку онлайн и отслеживать статус заказа в любое время.');
define('REGIST_COM_EMAIL_SEND_15','С уважением<br>Команда FS');
define('REGIST_COM_EMAIL_SEND_TITLE','Запрос Принят');
define('REGIST_COM_EMAIL_SEND_THEME','FS - Ваш запрос на Бизнес Аккаунт уже принят');

//新注册邮件语言包
define('REGIST_EMAIL_SEND_NEW_01',"Аккаунт создан");
define('REGIST_EMAIL_SEND_NEW_02',"Добро пожаловать в FS");
define('REGIST_EMAIL_SEND_NEW_03',"Ведущий мировой поставщик оборудований и решений для интернет-коммуникаций");
define('REGIST_EMAIL_SEND_NEW_04',"Гарантия качества");
define('REGIST_EMAIL_SEND_NEW_05',"Обеспечение качества, ориентированное на клиента и устойчивое управление");
define('REGIST_EMAIL_SEND_NEW_06',"Индивидуальные решения");
define('REGIST_EMAIL_SEND_NEW_07',"Предоставлять инновационные, экономичные и надежные универсальные решения.");
define('REGIST_EMAIL_SEND_NEW_08',"Ускоренная доставка");
define('REGIST_EMAIL_SEND_NEW_09',"Местные склады, адекватный инвентарь и политика бесплатной доставки.");
define('REGIST_EMAIL_SEND_NEW_10',"Обеспечить экспертизу и техническую поддержку, чтобы продвинуть ваш бизнес вперед.");
define('REGIST_EMAIL_SEND_NEW_11',"Посетите наш блог, wiki, запросы и объявления, чтобы найти решения для выдающихся рекомендаций.");
define('REGIST_EMAIL_SEND_NEW_12',"Давайте начнем");
define('REGIST_EMAIL_SEND_NEW_13',"FS техподдержка");
define('REGIST_EMAIL_SEND_NEW_14',"FS сообщество");

//老用户升级
define('REGIST_COM_EMAIL_UPGRADE_01','Мы получили ваш запрос на бизнес-аккаунт. Заявка сейчас находится на рассмотрении, и этот процесс может занять от 1 до 3 рабочих дней. ');
define('REGIST_COM_EMAIL_UPGRADE_02','Уважаемый/-ая');
define('REGIST_COM_EMAIL_UPGRADE_03','Мы получили ваш запрос на бизнес-аккаунт. Заявка сейчас находится на рассмотрении, и этот процесс может занять от 1 до 3 рабочих дней. Результат заявки будет выслан своевременно по почте FS.');
define('REGIST_COM_EMAIL_UPGRADE_04','С уважением<br>Команда FS');
define('REGIST_COM_EMAIL_UPGRADE_TITLE','Запрос Принят');
define('REGIST_COM_EMAIL_UPGRADE_THEME','FS - Ваш запрос на Бизнес Аккаунт уже принят');

//订单邮件语言包
define('FS_ORDER_EMAIL_01','Спасибо за выбор FS. Мы получили ваш заказ в ожидании платежа ');
define('FS_ORDER_EMAIL_02','. Завершить оплату и ваш заказ может быть обработан как можно скорее.');
define('FS_ORDER_EMAIL_03','Детали для вашего заказа ');
define('FS_ORDER_EMAIL_04',' ниже. Мы отправим вам электронное письмо, как только появится обновление вашего заказа.');
define('FS_ORDER_EMAIL_05','Детали для вашего заказа ');
define('FS_ORDER_EMAIL_06','ниже. Поскольку вы выбрали «Самовывоз со склада», мы отправим вам по электронной почте инструкцию по получении, как только ваш заказ будет готов.');
define('FS_ORDER_EMAIL_07','Спасибо за выбор FS. Мы получили ваш заказ в ожидании платежа. Завершить оплату и ваш заказ может быть обработан как можно скорее.');
define('FS_ORDER_EMAIL_08','Детали для вашего заказа ниже. Поскольку вы выбрали «Самовывоз со склада», мы отправим вам инструкцию по электронной почте, как только ваш заказ будет готов.');
define('FS_ORDER_EMAIL_09','Спасибо за покупку. Детали для вашего заказа ниже. Как только товары в вашем заказе будут отправлены, мы немедленно отправим вам информацию для отслеживания.');
define('FS_ORDER_EMAIL_10','Заказ');
define('FS_ORDER_EMAIL_11','Ваша покупка была разделена на ');
define('FS_ORDER_EMAIL_12',' заказа.');
define('FS_ORDER_EMAIL_13','Управлять Заказами');
define('FS_ORDER_EMAIL_14','Заказ');
define('FS_ORDER_EMAIL_15','Заказан');
define('FS_ORDER_EMAIL_16','Ориентировочно Отправлен');
define('FS_ORDER_EMAIL_17','Ожидаемая Доставка');
define('FS_ORDER_EMAIL_18','Не волнуйтесь, мы сообщим вам, как только ваши товары будут отправлены. Чтобы получить последний статус вашего заказа, вы можете просмотреть ');
define('FS_ORDER_EMAIL_19','Личный кабинет');
define('FS_ORDER_EMAIL_20',' в любое время.');
define('FS_ORDER_EMAIL_21','Если вам нужно изменить или отменить свой заказ, посетите ');
define('FS_ORDER_EMAIL_22','. Обратите внимание, что после отправки вашего товара вы не сможете вносить дальнейшие изменения.');
define('FS_ORDER_EMAIL_23','Не волнуйтесь, мы сообщим вам, как только ваши товары будут отправлены. Вы можете связаться с нами в любое время для получения последнего статуса вашего заказа.');
define('FS_ORDER_EMAIL_24','Если вам необходимо изменить или отменить ваш заказ, пожалуйста, свяжитесь с вашим менеджером по продажам. Обратите внимание, что после отправки вашего товара вы не сможете вносить дальнейшие изменения.');
define('FS_ORDER_EMAIL_25','Завершить оплату и ваш заказ может быть обработан как можно скорее.');
define('FS_ORDER_EMAIL_26','Заказ Принят');
define('FS_ORDER_EMAIL_27','Обработка Заказа');
define('FS_ORDER_EMAIL_28','Уважаемый/-ая ');
define('FS_ORDER_EMAIL_29','Детали Доставки');
define('FS_ORDER_EMAIL_30','Доставка в');
define('FS_ORDER_EMAIL_31','Контакты');
define('FS_ORDER_EMAIL_32','Часто Задаваемые Вопросы');
define('FS_ORDER_EMAIL_33','Где товар, который я заказал?');
define('FS_ORDER_EMAIL_34','Как я могу изменить свой заказ?');
define('FS_ORDER_EMAIL_35','Детали Оплаты');
define('FS_ORDER_EMAIL_36','Итого:');
define('FS_ORDER_EMAIL_37','Доставка :');
define('FS_ORDER_EMAIL_38','Общая Стоимость:');
define('FS_ORDER_EMAIL_39','Способ Оплаты:');
define('FS_ORDER_EMAIL_40','Все сборы появятся в <a style="color: #0070BC;text-decoration: none" href="javascript:;">FS COM</a>.');
define('FS_ORDER_EMAIL_41','Счет в');
define('FS_ORDER_EMAIL_42','Спасибо за ваш заказ. Смотрите внутри для деталей вашего заказа.');
define('FS_ORDER_EMAIL_43','FS - Мы получили ваш Заказ в Ожидании Платежа %s');
define('FS_ORDER_EMAIL_44','Адрес самовывоза');
define('FS_ORDER_EMAIL_45','Человек самовывоза');
define('FS_ORDER_EMAIL_46','. Загрузите файл PO и ваш заказ будет обработан как можно скорее.');
define('FS_ORDER_EMAIL_47','FS - Спасибо за покупку. Ваш заказ %s');
define('FS_ORDER_EMAIL_48','Заказ на покупку');
define('FS_ORDER_EMAIL_49','Готов');
define('FS_ORDER_EMAIL_50','Пикап');
//2019.4.9 新增俄罗斯对公支付 邮件语言包 [ORDERNUMBER]不需要翻译保留即可，只有一单时会替换成对应的订单号，多单时会替换为空
define('FS_ORDER_EMAIL_51', "Спасибо за выбор FS. Мы получили ваш отложенный заказ [ORDERNUMBER]. Счет будет отправлен на Ваш e-mail менеджером.");
define('FS_ORDER_EMAIL_52','Пожалуйста, проверьте ваши реквизиты:');
define('FS_ORDER_EMAIL_53','Контактное лицо');
define('FS_ORDER_EMAIL_54','Номер телефона*');
define('FS_ORDER_EMAIL_55','E-mail*');
define('FS_ORDER_EMAIL_56','Название организации*');
define('FS_ORDER_EMAIL_57','ИНН*');
define('FS_ORDER_EMAIL_58','КПП*');
define('FS_ORDER_EMAIL_59','ОКПО');
define('FS_ORDER_EMAIL_60','БИК*');
define('FS_ORDER_EMAIL_61','Юридический адрес*');
define('FS_ORDER_EMAIL_62','Почтовый адрес');
define('FS_ORDER_EMAIL_63','Корреспондентский счет');
define('FS_ORDER_EMAIL_64','Название банка*');
define('FS_ORDER_EMAIL_65','Расчетный счет*');
define('FS_ORDER_EMAIL_66','Имя владельца');
define('FS_ORDER_EMAIL_67','Реквизиты');
define('FS_ORDER_EMAIL_68','Длина');
define('FS_ORDER_EMAIL_09_1','Ваш заказ был разбит на два заказа ');
define('FS_ORDER_EMAIL_09_2','Подробности ниже. Мы отправим вам электронное письмо, как только появится обновление ваших заказов.');
define('FS_ORDER_EMAIL_69','Вы можете отслеживать статус вашего заказа, войдя в свой личный кабинет и перейдя на ');
define('FS_ORDER_EMAIL_70','История заказов');
define('FS_ORDER_EMAIL_71',' страницу.');
define('FS_ORDER_EMAIL_72','Платеж получен');
define('FS_ORDER_EMAIL_73','В процессе');
define('FS_ORDER_EMAIL_74','В пути');
define('FS_ORDER_EMAIL_75','Доставлен');
define('FS_ORDER_EMAIL_76','PO Подтвержден');
define('FS_ORDER_EMAIL_ALFA_01','Мы выставим Вам счёт по загруженным реквизитам в течение 24 часов. Вы можете посмотреть загруженный файл в разделе <a style="color: #0070BC;text-decoration:none" href="'.zen_href_link('my_companies').'" target="_blank">Личный кабинет-Контрагенты</a>.');
//邮件系统改版语言包
//在线询价(A)
define('FS_SEND_EMAIL','FS - Мы получили ваш запрос на коммерческое предложение ');
define('FS_SEND_EMAIL_1',"Мы получили ваш запрос на коммерческое предложение ");
define('FS_SEND_EMAIL_2'," и отправим вам по электронной почте КП с подробностями в течение одного рабочего дня.");
define('FS_SEND_EMAIL_3',"Запрос принят");
define('FS_SEND_EMAIL_3_1','Мы получили ваш запрос на образец $CASENUMBER');
define('FS_SEND_EMAIL_4'," и отправим вам по электронной почте КП с подробностями в течение одного рабочего дня.");
define('FS_SEND_EMAIL_5',"Сообщение");
define('FS_SEND_EMAIL_6',"Коммерческое предложение");
define('FS_SEND_EMAIL_7',"Комментарии");
define('FS_SEND_EMAIL_8',"Кол-во: ");
//在线技术咨询A
define('FS_SEND_EMAIL_8_1','FS - Мы получили Ваш запрос на поддержку ');
define ('FS_SEND_EMAIL_8_2', 'FS - Мы получили Ваш технический запрос ');//product_support页面，发送邮件
define('FS_SEND_EMAIL_9',"Благодарим Вас за контакт с FS, Ваш номер запроса ");
define('FS_SEND_EMAIL_10',". Наша команда технической поддержки свяжется с Вами в течение 6-18 часов.");
define ('FS_SEND_EMAIL_10_1', ". Мы свяжемся с Вами в течение 6-18 часов.");//product_support页面，发送邮件
//产品QA邮件
define('FS_SEND_EMAIL_11',"FS - Мы получили ваш запрос о товаре #");
define('FS_SEND_EMAIL_12',"Запрос принят");
define('FS_SEND_EMAIL_12_1',"Мы получили ваш запрос о товаре #");
define('FS_SEND_EMAIL_13'," и свяжемся с вами в течение одного рабочего дня.");
define('FS_SEND_EMAIL_14',"Мы получили ваш запрос о товаре ");
define('FS_SEND_EMAIL_15'," и свяжемся с вами в течение одного рабочего дня.");
//退换货all
define('FS_SEND_EMAIL_16',"Мы работаем над этим");
define('FS_SEND_EMAIL_17',"Мы получили ваш запрос относительно ваших проблем с заказом ");
define('FS_SEND_EMAIL_18',"Спасибо, что позволили нам заботиться об этом для вас!");
define('FS_SEND_EMAIL_19',"FS - Мы получили ваш запрос на поддержку ");
define('FS_SEND_EMAIL_20',"Благодарим за контакт с FS. Мы получили ваш запрос на поддержку и свяжется с вами в течение одного рабочего дня.");
define('FS_SEND_EMAIL_21',"Благодарим за контакт с FS. Мы получили ваш запрос на поддержку и свяжется с вами в течение одного рабочего дня. Номер вашего запроса");
define('FS_SEND_EMAIL_22',"Мы получили ваш запрос на складской запас о товаре #");
define('FS_SEND_EMAIL_23'," и свяжется с вами в течение одного рабочего дня.");
define('FS_SEND_EMAIL_24',"Мы получили ваш запрос на складской запас о товаре ");
define('FS_SEND_EMAIL_25'," и свяжется с вами в течение одного рабочего дня. Ваш номер запроса ");
define('FS_SEND_EMAIL_26',". Вы можете ссылаться на этот номер во всех последующих сообщениях, касающихся этого запроса.");
define('FS_SEND_EMAIL_27',"Ваш товар");
define('FS_SEND_EMAIL_28',"Комментарии");
define('FS_SEND_EMAIL_29',"Запрос кол-во: ");
define('FS_SEND_EMAIL_30'," Запрос даты прибытия: ");
define('FS_SEND_EMAIL_31',"FS - Мы получили ваш запрос на складской запас ");
define('FS_SEND_EMAIL_32',"FS - Мы получили ваш запрос на возврат");
define('FS_SEND_EMAIL_33',"Мы получили ваш запрос на возврат сумм и вышлем вам дополнительную информацию в течение одного рабочего дня..");
define('FS_SEND_EMAIL_34',"FS - Мы получили ваш запрос на замену");
define('FS_SEND_EMAIL_35',"Мы получили ваш запрос на замену и вышлем вам дополнительную информацию в течение одного рабочего дня..");
define('FS_SEND_EMAIL_36',"FS - Мы получили ваш запрос на ремонт");
define('FS_SEND_EMAIL_37',"Мы получили ваш запрос на ремонт и отправим вам дополнительную информацию в течение одного рабочего дня.");
define('FS_SEND_EMAIL_38'," Инструкции для вашего FS возврат");
define('FS_SEND_EMAIL_39',"Выполните следующие действия, чтобы завершить возврат заказа. #");
define('FS_SEND_EMAIL_40',"Заказ-возврат");
define('FS_SEND_EMAIL_41'," и отправим вам по электронной почте дополнительную информацию о деталях возврата в течение одного рабочего дня.");
define('FS_SEND_EMAIL_42'," и отправит вам по электронной почте дополнительную информацию о замене в течение одного рабочего дня.");
define('FS_SEND_EMAIL_43'," И отправит вам по электронной почте дополнительную информацию о ремонте в течение одного рабочего дня.");
define('FS_SEND_EMAIL_44',"Часть возврата");
define('FS_SEND_EMAIL_45',"Часть замены");
define('FS_SEND_EMAIL_46',"Часть ремонта");
define('FS_SEND_EMAIL_47',"Возврат сумм");
define('FS_SEND_EMAIL_48',"Мы сожалеем, что товар (ы) из вашего заказа");
define('FS_SEND_EMAIL_49'," не подходит для вас. Чтобы завершить возврат, выполните следующие простые шаги:");
define('FS_SEND_EMAIL_50',"После получения возвращенных товаров мы вам верним ");
define('FS_SEND_EMAIL_51'," в течение одного рабочего дня. Возарат средств применяется к исходному способу оплаты. Деньги будут на вашем счете в течение недели ");
define('FS_SEND_EMAIL_52'," Общий обзор");
define('FS_SEND_EMAIL_53',"Стоимость платежа:");
define('FS_SEND_EMAIL_54',"Стоимости возврата доставки:");
define('FS_SEND_EMAIL_55',"Общий возврат:");
define('FS_SEND_EMAIL_56',"Способ возврата:");
define('FS_SEND_EMAIL_57',"Исходный способ оплаты ");
define('FS_SEND_EMAIL_58',"Более информаций о нашей политике возврата, ");
define('FS_SEND_EMAIL_59',"Нажмите здесь");
define('FS_SEND_EMAIL_60',"Замена");
define('FS_SEND_EMAIL_61',"Мы сожалеем, что у вас возникли проблемы с вашим заказом");
define('FS_SEND_EMAIL_62'," Чтобы завершить замену, выполните следующие простые шаги:");
define('FS_SEND_EMAIL_63',"После получения возвращенного товара (ов) мы отправим новый товар как можно скорее и вышлем вам информацию для отслеживания, когда он будет доступен.");
define('FS_SEND_EMAIL_64',"Ремонт");
define('FS_SEND_EMAIL_67',"После получения возвращенного товара, мы отправим отремонтированный товар как можно скорее и вышлем вам информацию для отслеживания, когда он будет доступен.");
define('FS_SEND_EMAIL_68',"Общий обзор");
define('FS_SEND_EMAIL_69',"Доставить по адресу");
define('FS_SEND_EMAIL_70',"Контактная информация");
define('FS_SEND_EMAIL_71',"Примечание: PO#");
define('FS_SEND_EMAIL_83',"Цена: ");
//样品申请邮件
define('FS_SEND_EMAIL_84',"Мы получили ваш запроса на образец и сообщим результаты в течение 24 часов..");
define('FS_SEND_EMAIL_85',"Мы получили ваш запрос на образец, и менеджер из нашей команды скоро свяжется с вами. Номер вашего запроса ");
define('FS_SEND_EMAIL_86',". Вы можете ссылаться на этот номер во всех последующих сообщениях, касающихся этого запроса.");
define('FS_SEND_EMAIL_87',"Список образцов");
define('FS_SEND_EMAIL_88',"Запрошенное кол-во: ");
define('FS_SEND_EMAIL_89',"Комментарии");
define('FS_SEND_EMAIL_90',"FS - Мы получили ваш запрос на образец ");
//cumlums交换机发送激活码邮件
define('FS_SEND_EMAIL_91',"Лицензионный ключ");
define('FS_SEND_EMAIL_92',"Ваша информация об активации была успешно отправлена.");
define('FS_SEND_EMAIL_94',"Ваш лицензионный ключ и информация о заказе указаны ниже. Вам необходимо установить этот лицензионный ключ на коммутаторе, чтобы активировать программное обеспечение. Этот лицензионный ключ уникален для вашей учетной записи. У вас будет около 3 дней, чтобы помочь вам активировать его. Пожалуйста, скопируйте и вставьте текст лицензионного ключа в соответствующее время в процессе установки лицензии.");
define('FS_SEND_EMAIL_95',"Обратите внимание: лицензионный ключ будет долгосрочным и эффективным. Срок службы технической поддержки составляет 1 год, но вы можете получить дополнительные 45 дней бесплатно, если вы установите в течение 45 дней.");
define('FS_SEND_EMAIL_96',"Если у вас есть вопросы или вам нужна помощь, пожалуйста, свяжитесь с нами ");
define('FS_SEND_EMAIL_97',"Лицензионный ключ");
define('FS_SEND_EMAIL_98',"Для Cumulus Linux 2.5.3 или более поздних версий:");
define('FS_SEND_EMAIL_99',"Номер заказа: ");
define('FS_SEND_EMAIL_100',"Дата: ");
define('FS_SEND_EMAIL_101',"Более");
define('FS_SEND_EMAIL_102',"FS - Лицензионный ключ");
//付款链接
define('FS_SEND_EMAIL_103',"<br>Замечание:");
define('FS_SEND_EMAIL_104'," отправил вам запрос на оплату");
define('FS_SEND_EMAIL_105',"Номер инвойса : ");
define('FS_SEND_EMAIL_106',"Заплатить сейчас");
define('FS_SEND_EMAIL_107',"FS - У вас есть запрос на оплату от ");
//分享购物车
define('FS_SEND_EMAIL_108',"Поделиться корзиной");
define('FS_SEND_EMAIL_109',"Ваш друг ");
define('FS_SEND_EMAIL_110'," поделился с вами списком корзины.");
define('FS_SEND_EMAIL_111',"Ваш друг ");
define('FS_SEND_EMAIL_112'," поделился с вами списком корзины. Вы можете нажать кнопку ниже, чтобы просмотреть полную информацию и добавить в свой список корзин.");
define('FS_SEND_EMAIL_113',"Список корзины");
define('FS_SEND_EMAIL_115',"Вы получили это ");
define('FS_SEND_EMAIL_116'," письмо от ");
define('FS_SEND_EMAIL_117',"с помощью FS.COM. В результате получения");
define('FS_SEND_EMAIL_118'," В результате получения этого письма вы не будете получать никаких не желательных сообщений от ");
define('FS_SEND_EMAIL_119',"Узнайте больше о нашей ");
define('FS_SEND_EMAIL_120',"Политике конфиденциальности");
define('FS_SEND_EMAIL_121',"FS - Ваш друг ");
define('FS_SEND_EMAIL_122'," поделился с вами списком корзины");
//分享产品
define('FS_SEND_EMAIL_123',"Поделиться товаром");
define('FS_SEND_EMAIL_124',"Вы могли бы быть заинтересованы в этом пункте");
define('FS_SEND_EMAIL_125',"Более информаций");
define('FS_SEND_EMAIL_126',"этого сообщения вы не получите никаких нежелательных сообщений от ");
define('FS_SEND_EMAIL_127',"Узнать больше о нашей ");
define('FS_SEND_EMAIL_129'," поделился с вами товаром");
//RMA取消订单邮件
define('FS_SEND_EMAIL_130',"Обновление RMA");
define('FS_SEND_EMAIL_131',"Ваша заявка RMA на заказ# ");
define('FS_SEND_EMAIL_132'," была отменена. Мы будем помогать вам решать дальнейшую проблему.");
define('FS_SEND_EMAIL_133',"Отменено RMA");
define('FS_SEND_EMAIL_135'," был отменен.");
define('FS_SEND_EMAIL_136',"Мы будем помогать вам решать дальнейшую проблему.");
define('FS_SEND_EMAIL_137',"RMA Часть");
//订单评价成功邮件
define('FS_SEND_EMAIL_138'," отправил вам запрос на оплату.");
define('FS_SEND_EMAIL_139',"Обновление заказа");
define('FS_SEND_EMAIL_140',"Ваш заказ #");
define('FS_SEND_EMAIL_141',"Отмененный заказ");
define('FS_SEND_EMAIL_142',"Спасибо за покупкy и мы надеемся увидеть вас снова в ближайшее время.");
define('FS_SEND_EMAIL_143',"Информация о заказе");
//留言入口客户调查问卷
define('FS_SEND_EMAIL_144',"Поделиться отзывом");
define('FS_SEND_EMAIL_145',"Какова вероятность того, что вы порекомендуете FS другу или коллеге?");
define('FS_SEND_EMAIL_146',"Для получения наилучшего обслуживания,<br>ответьте на вопрос выше, пожалуйста. Когда вы ответите, вам требуется представить<br>краткое объяснение вашей оценки. Все ваши отзывы очень нам помогли.");
//live_chat留言
define('FS_SEND_EMAIL_147',"Тема отзыва");
define('FS_SEND_EMAIL_148',"Спасибо за контакт с FS. Мы уже получили ваше письмо и свяжемся с вами в течение 12 часов.\"");
define('FS_SEND_EMAIL_149',"FS - Мы получили ваше письмо");
define('FS_SEND_EMAIL_150',"Спасибо за контакт с FS. Мы получили ваше письмо и свяжемся с вами в течение 12 часов. Номер вашего запроса ");
define('FS_SEND_EMAIL_151',"Поделиться товаром");
define('FS_SEND_EMAIL_152',"Вы могли бы быть заинтересованы в этом товаре");
define('FS_SEND_EMAIL_153',"Ваш друг ");
define('FS_SEND_EMAIL_154',"  Это письмо от ");
define('FS_SEND_EMAIL_155'," поделился этим товаром с вами через ");
define('FS_SEND_EMAIL_156',"FS - Ваша RMA была отменена");
define('FS_SEND_EMAIL_157',"FS - Мы получили ваш запрос на коммерческое предложение ");
define('FS_SEND_EMAIL_158',"Сообщение от");
define('FS_SEND_EMAIL_159',"Добавить в список");
//退换货
define('FS_SEND_EMAIL_160',"Ваш Заказ #");
define('FS_SEND_EMAIL_160_01',"FS - Ваш заказ #");
define('FS_SEND_EMAIL_161',"FS - Ваш FS Заказ ");
define('FS_SEND_EMAIL_162',"Инструкция Возврата");
define('FS_SEND_EMAIL_163',"1. Печатать RMA");
define('FS_SEND_EMAIL_164',"RMA может помочь нам отличить вашу посылку. Распечатайте форму RMA и прикрепите ее на коробке.");
define('FS_SEND_EMAIL_165',"2. Упаковать товар (ы)");
define('FS_SEND_EMAIL_166',"Удалите старые метки, если вы используете оригинальную коробку (и) и прикрепили RMA");
define('FS_SEND_EMAIL_167',"3. Отправить товар");
define('FS_SEND_EMAIL_168',"Отправьте нам посылку");
define('FS_SEND_EMAIL_169',"4. Получить вашу замену");
define ('FS_SEND_EMAIL_170', "Спасибо за обращение в FS. Мы получили ваш запрос на вызов и свяжемся с вами в удобное для вас время.");
define ('FS_SEND_EMAIL_171', "FS - Мы получили ваш запрос на вызов");
define('FS_SEND_EMAIL_3_1',"Запрос на оплату");
define("PRERDER_PROCESSIONG","<i class='popover_i'></i>Время обработки заказа включает время его изготовления и тестирования и время указывается всегда в рабочих днях. Время доставки рассчитывается отдельно, определяется выбранной скоростью доставки.");
define("PRERER_SAVE"," чтобы сэкономить бюджет вашего проекта");

//quest add 2019-03-01
define('CHECKOUT_CUSTOMER_ACCOUNT1','Пожалуйста, введите действительный аккаунт, состоящий из 9 цифр');
define('CHECKOUT_CUSTOMER_ACCOUNT2','Пожалуйста, введите действительный аккаунт, состоящий из 6 символов');

// fairy 2019.1.17 组合子产品
define("FS_ITEM_INCLUDES_PRODUCTS","Эта позиция включает следующие товары");



define('MODULE_ORDER_TOTAL_TAX_TITLE', 'Tax');
define('MODULE_ORDER_TOTAL_TAX_DESCRIPTION', 'Order Tax');

define('MODULE_ORDER_TOTAL_TOTAL_TITLE', 'Total general');
define('MODULE_ORDER_TOTAL_TOTAL_DESCRIPTION', 'Order Total');

define('MODULE_ORDER_TOTAL_SHIPPING_TITLE', '(+)Shipping Cost:');
define('MODULE_ORDER_TOTAL_SHIPPING_DESCRIPTION', 'Order Shipping Cost');

define('MODULE_ORDER_TOTAL_SUBTOTAL_TITLE', 'Total');
define('MODULE_ORDER_TOTAL_SUBTOTAL_DESCRIPTION', 'Order Sub-Total');

//2019.3.9   ery  add 专题询价板块
define('FS_SPECILA_INQUIRY_QUESTION', 'Вопросы? Мы скоро ответим.');
define('FS_SPECILA_INQUIRY_ASK', 'Если у Вас есть какие-либо вопросы о ценах, доставке и т. д., наши опытные менеджеры по продажам готовы Вам помочь.');

//rebirth.ma  2019.03.12  上传错误定义
define("FS_FILE_TOO_LARGE","Файл слишком велик, загрузка не удалась");

define('FIBERSTORE_PRODUCT_DETAIL','Детали Продукта');

//rebirth.ma  2019.03.22  购物车样式调整
define("FS_Summary","Ваша корзина");

//liang.zhu 2019.04.02 定义tpl_modules_index_product_list_old_style.php
define('TPL_MODULES_INDEX_PRODUCT_LIST_OLD_STYLE_GRID', 'Посмотреть в сетке');
define('TPL_MODULES_INDEX_PRODUCT_LIST_OLD_STYLE_LIST', 'Посмотреть в списке');
define('TPL_MODULES_INDEX_PRODUCT_LIST_OLD_STYLE_QUICKFINDER', 'Быстрый поиск');

//2019.4.4  ery  ADD俄罗斯对公支付方式名
define("FS_CHECKOUT_NEW_CASHLESS","Безналичный расчет");
define("SHIPPING_COURIER_DELIVERY","Доставка курьерской службой для юр. лица");
define("SHIPPING_COURIER_DELIVERY_01"," для физ. лица");
define("SHIPPING_DELIVERY","Способ Доставки");
//2019.4.11  ery add  俄罗斯对公支付收税政策文字表达优化
define('CHECKOUT_TAXE_RU_TIT', 'В соответствии с Главой 21 НК РФ Налог на добавленную стоимость (НДС), компания ООО ФС.КОМ обязана взимать НДС со всех заказов, доставляемых в Россию. Вся продукция из нашего каталога облагается стандартным НДС в размере 20% от стоимости в соответствии с Общим налоговым правом России. Вам будет известна общая сумма, включая НДС, до совершения оплаты, если Вы внесете всю необходимую информацию о заказе (включая тип предприятия и адрес доставки).');
define("CHECKOUT_TAXE_RU_TIT_FOR_NATURAL","Заказ от физ. лица будет отправлен напрямую с нашего международного склада до двери. Мы ТОЛЬКО взимаем стоимость товара и доставки. FS не взимает никаких таможенных пошлин и сборов. Дополнительные пошлины и сборы за таможенное оформление возлагаются на получателя. С 1 января 2020 года порог беспошлинной торговли в России снижается до €200 и до 31 кг за одну посылку. Если Вас интересует другой способ доставки или хотите оплатить юр. лицом, свяжитесь со своим менеджером и узнать подробности.");
define("FS_EMAIL_ERROR","Неправильный адрес электронной почты");
define("FS_CREDIT_CARD_NOTICE","Пожалуйста, введите ваш платежный адрес.");


//Jeremy.Wu 2019.4.17 定义本地取货
define('FS_LOCAL_PICKUP','Местный Самовывоз');

//报价改版 ternence 2019.04.17
define("FS_INQUIRY_INFO","КП");
define("FS_INQUIRY_INFO_1","Добавить новые продукты");
define("FS_INQUIRY_INFO_2","Добавить");
define("FS_INQUIRY_INFO_3","ID товара не может быть пустым.");
define("FS_INQUIRY_INFO_4","Цена за ед.");
define("FS_INQUIRY_INFO_5"," Комментарий ");
define("FS_INQUIRY_INFO_6","Редактировать");
define("FS_INQUIRY_INFO_7","У вас уже есть аккаунт?");
define("FS_INQUIRY_INFO_8","войти</a> или ");
define("FS_INQUIRY_INFO_9","Регистрация");
define("FS_INQUIRY_INFO_10","  Отслеживать состояние запроса онлайн.");
define("FS_INQUIRY_INFO_11","Информация о спецпредложении");
define("FS_INQUIRY_INFO_12","Логотип");
define("FS_INQUIRY_INFO_13","Гарантия");
define("FS_INQUIRY_INFO_14","Срок доставки");
define("FS_INQUIRY_INFO_15","Оптовая цена");
define("FS_INQUIRY_INFO_16","PO Заказ");
define("FS_INQUIRY_INFO_17","Дополнительные комментарии");
define("FS_INQUIRY_INFO_18","Файл");
define("FS_INQUIRY_INFO_19","Возможные типы файлов JPG, PDF, PNG , XLS, XLSX <br> Максимальный размер файлов 5M");
define("FS_INQUIRY_INFO_20","Отправить запрос");
define("FS_INQUIRY_INFO_21","Запрос на КП пуст.");
define("FS_INQUIRY_INFO_22","Продолжить покупки");
define("FS_INQUIRY_INFO_24","Рассмотрение может занять 12 часов.");
define("FS_INQUIRY_INFO_25","Запросить цену");
define("FS_INQUIRY_INFO_26","Это продукт, изготовленный по индивидуальному заказу. Перейдите на страницу продукта, чтобы выбрать параметр и добавить в список спецпредложений.");
define("FS_INQUIRY_INFO_26_2","ID продукта");
define("FS_INQUIRY_INFO_26_3","не было найдено в наших записях.");
define("FS_INQUIRY_INFO_27","Ваш запрос NO.");
define("FS_INQUIRY_INFO_28"," Был отправлен.");
define("FS_INQUIRY_INFO_29","Мы отправим вам КП в течение 12-24 часов. Вы можете посмотреть статус запроса в разделе <b>Личный кабинет </b> > <b>История предложений</b>. ");
define("FS_INQUIRY_INFO_30","Здравствуйте, гост! ");
define("FS_INQUIRY_INFO_30_1","Выбрать параметр ");
define("FS_INQUIRY_INFO_31","После регистрации вы можете легко просмотреть спецпредложение в своем аккаунте, а также получить лучший сервис FS, включая:");
define("FS_INQUIRY_INFO_32","- Легко отслеживать через вашу историю заказов");
define("FS_INQUIRY_INFO_33","- быстро оформить заказ с адресной книгой");
define("FS_INQUIRY_INFO_34","Хотите создать аккаунт сейчас?");
define("FS_INQUIRY_INFO_35","Нет, спасибо. (Мы ответим ваше спецпредложение по электронной почте )");
define("FS_INQUIRY_INFO_36","Да, я хочу создать аккаунт сейчас.");

define("FS_INQUIRY_INFO_37","Актуальные предложения");
define("FS_INQUIRY_INFO_38","Проверьте статус запроса и совершите покупки напрямую по льготным ценам. ");
define("FS_INQUIRY_INFO_39","Связаться с обслуживанием Клиентов");
define("FS_INQUIRY_INFO_40","Дата запроса на КП");
define("FS_INQUIRY_INFO_41","КП #");
define("FS_INQUIRY_INFO_42","Всего");
define("FS_INQUIRY_INFO_43","Название спецпредложения");
define("FS_INQUIRY_INFO_43_1","Смотреть больше");
define("FS_INQUIRY_INFO_43_2","Отменить запрос на КП");

define("FS_INQUIRY_INFO_44","Добавлено в запросов");
define("FS_INQUIRY_INFO_45","Количество");
define("FS_INQUIRY_INFO_46","Перейти в список");
define("FS_INQUIRY_INFO_47","Запросить цену");
define("FS_INQUIRY_INFO_48","Список Запросов на КП ");
define("FS_INQUIRY_INFO_23","Ваш КП запрос.");
define("FS_INQUIRY_INFO_23_1"," был отправлен.");
define("FS_INQUIRY_INFO_49","Название Спецпредложения:");
define("FS_INQUIRY_INFO_50","Срок действия данного спецпредложения истечёт через X дней. Пожалуйста, совершите пладёж как можно скорее.");
//define("FS_INQUIRY_INFO_51",'Истек срок действия вашего спецпредложения.');
define("FS_INQUIRY_INFO_52","Комментарий");
define("FS_INQUIRY_INFO_54","Введите ID товара#");
define("FS_INQUIRY_INFO_55","ID продукта не может быть пустым");
define("FS_INQUIRY_INFO_56","Полное Имя*");
define("FS_INQUIRY_INFO_57","Email*");
define("FS_INQUIRY_INFO_58","Номер телефона*");
define("FS_INQUIRY_INFO_59","ID товара ");
define("FS_INQUIRY_INFO_60"," не было найдено в наших записях.");
define("FS_INQUIRY_INFO_61","Тема вашего спецпредложения");
define("FS_INQUIRY_INFO_62","Номер запроса");
define("FS_INQUIRY_INFO_63","Пожалуйста, выберите параметры.");
define("FS_INQUIRY_BUY_TIP",'Срок действия данного спецпредложения составляет 15 дней. Количество покупаемых товаров должно быть не менее того в запросе. Совершите платёж как можно скорее, пожалуйста.');
define("FS_INQUIRY_INFO_53","Список запросов на спецпредложение");
define("FS_INQUIRY_INFO_64","Все КП");
define("FS_INQUIRY_INFO_65","Срок действия данного КП составляет 15 дней. Совершите платёж как можно скорее, пожалуйста.");
define("FS_INQUIRY_INFO_66","Истек срок действия Вашего КП.");

define('FS_INQUIRY_EMPTY_TXT','Запрос на КП пуст.');
define('FS_INQUIRY_EMPTY_TXT_01','Отправьте запрос на КП в деталях товара или прямо введите ID товара онлайн.');
define('FS_INQUIRY_EMPTY_TXT_A','<p class="empty_txt">Если у вас есть аккаунт FS, <a href="'.zen_href_link('login','','SSL').'">Войдите,</a> чтобы увидеть свой запрос на КП.</p>');

//ternence.qin
define('FS_CREDIT','Мой кредитный аккаунт');


define('FS_ACCOUNT_NEW_01','Чат сейчас');
define('FS_ACCOUNT_NEW_02','Пнд. - Птн.');
define('FS_ACCOUNT_NEW_03','Заказы');
define('FS_ACCOUNT_NEW_04','Мои заказы');
define('FS_ACCOUNT_NEW_05','Возвращенные');
define('FS_ACCOUNT_NEW_06','Доступная кредитная линия:');
define('FS_ACCOUNT_NEW_07','Последние заказы');
define('FS_ACCOUNT_NEW_08','Посмотреть мои заказы');
define('FS_ACCOUNT_NEW_09','Вы пока не сделали заказ.');
define('FS_ACCOUNT_NEW_10','Недавно смотрели');
define('FS_ACCOUNT_NEW_11','Последние запросы');
define('FS_ACCOUNT_NEW_12','Посмотреть мои запросы');
define('FS_ACCOUNT_NEW_13','Вы пока не делали запрос.');

//2019.5.3 pico 企业账号注册

define("FS_BUSINESS_ACCOUNT_01","Преимущества корпоративного аккаунта");
define("FS_BUSINESS_ACCOUNT_02","Создайте корпоративный аккаунт FS сегодня и вы будете получать скидку 2% на товары и услуги, а также другие большие преимущества.");
define("FS_BUSINESS_ACCOUNT_03","Льготная цена");
define("FS_BUSINESS_ACCOUNT_04","Быстрая доставка");
define("FS_BUSINESS_ACCOUNT_05","Легко запрость спецпредложение");
define("FS_BUSINESS_ACCOUNT_06","Профессиальное изготовление по индивидуальному заказу");
define("FS_BUSINESS_ACCOUNT_07",'У вас уже есть аккаунт? <a class="lr_right_href" href="' . zen_href_link('partner_update') . '">Обновить аккаунт</a>');
define("FS_BUSINESS_ACCOUNT_08",'Нужна помощь? Мы здесь 24/7');
define("FS_BUSINESS_ACCOUNT_09",'Чат Сейчас');
define("FS_BUSINESS_ACCOUNT_10",'+7 （499）6434876');
define("FS_BUSINESS_ACCOUNT_11",'ru@fs.com');
define("FS_BUSINESS_ACCOUNT_12",'Ваша Заявка на Бизнес Аккаунт Находится в Обработке.');
define("FS_BUSINESS_ACCOUNT_13",'Добро пожаловать в FS, ваша заявка была получена, менеджер по продажам рассмотрит вашу заявку как можно скорее.');
define("FS_BUSINESS_ACCOUNT_14",'Ваша заявка получена и находится на рассмотрении. Подождите для проверки и подтверждения, пожалуйста.');
define("FS_BUSINESS_ACCOUNT_15",'Нажмите здесь, чтобы войти в свой аккаунт');
define("FS_BUSINESS_ACCOUNT_16",'Ваша заявка на корпоративный аккаунт находится на рассмотрении.');
define("FS_BUSINESS_ACCOUNT_17",'У вас нет аккаунта? <a class="lr_right_href" href="' . zen_href_link('partner_submit') . '"> Создать корпоративный аккаунт</a>');
define("FS_BUSINESS_ACCOUNT_18",'Создайте корпоративный аккаунт');
define("FS_BUSINESS_ACCOUNT_19",'Обновите аккаунт');
define("FS_BUSINESS_ACCOUNT_20",'Ваша заявка уже получена.');
//add by rebirth  结算页超重超大标签
define('FS_HEAVY','тяжелый');
define('FS_OVERSIZED','Негабаритный');
//2019 5 3 定义武汉仓发货的文案优化
define('FS_HEADER_FREE_SHIPPING_CNRU_TIP','Быстрая отправка в');
define('FS_FOOTER_FREE_SHIPPING_CNRU_TIP','Отправка в тот же день');
define('FS_FOOTER_FREE_SHIPPING_CN_TIP','Бесплатная доставка от 20 000 ₽');
define('FS_BANNER_FREE_SHIPPING_CNRU_TIP','Российская Федерация Отправка в тот же день');

//add by jeremy 各语种公司名称
define('FS_LOCAL_COMPANY_NAME','FS.COM Ltd.');
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
define('FS_AMP_CATE_05','Коммутаторы');
define('FS_AMP_CATE_06','WDM<br>MUX');
define('FS_AMP_CATE_07','Оптические патч-корды');
define('FS_AMP_CATE_08','MTP/MPO кабели');
define('FS_AMP_CATE_09','Кроссы/панели');
define('FS_AMP_CATE_10','Медные кабели');
//Interconnection产品模块
define('FS_AMP_INTERCONNECT_01','Межсоединение');
//Optical Transport Network产品模块
define('FS_AMP_OPTICAL_TRANS_01','Оптическая транспортная сеть');
//Network Cable Assemblies产品模块
define('FS_AMP_NETWORK_CABLE_01','Кабельная система');
//Space Management产品模块
define('FS_AMP_SPACE_MANAGE_01','Корпоративные сети');
//Solution模块
define('FS_AMP_SOLUTION_01','Решения');
//公共底部模块
define('FS_AMP_FOOTER_01','Напишите нам');
define('FS_AMP_FOOTER_02','Чат сейчас');
define('FS_AMP_FOOTER_03','Live ChaSupport');
define('FS_AMP_FOOTER_04','Company');
define('FS_AMP_FOOTER_05','Quick Access');
define('FS_AMP_FOOTER_06','Copyright © 2009-2019 FS.COM Inc All Rights Reserved.');
define('FS_AMP_FOOTER_07','Privacy policy');
define('FS_AMP_FOOTER_08','Terms of use');
//第一级侧边栏
define('FS_AMP_FIRST_SIDEBAR_01','Личный кабинет / Вход в личный кабинет');
define('FS_AMP_FIRST_SIDEBAR_02','Каталог');
define('FS_AMP_FIRST_SIDEBAR_03','Корпоративные Сети');
define('FS_AMP_FIRST_SIDEBAR_04','Оптические Модули');
define('FS_AMP_FIRST_SIDEBAR_05','Кабельные Сборки');
define('FS_AMP_FIRST_SIDEBAR_06','Стойки/Панели/Кроссы');
define('FS_AMP_FIRST_SIDEBAR_07','WDM & Оптический Доступ');
define('FS_AMP_FIRST_SIDEBAR_08','Cat5e/Cat 6/Cat 7/Cat 8');
define('FS_AMP_FIRST_SIDEBAR_09','Тестеры & Инструменты');
define('FS_AMP_FIRST_SIDEBAR_10','Support');
define('FS_AMP_FIRST_SIDEBAR_11','Company');
define('FS_AMP_FIRST_SIDEBAR_12','Quick Access');
define('FS_AMP_FIRST_SIDEBAR_13','Помощь & Настройка');
//所有二级分类侧边栏
define('FS_AMP_SECOND_SIDEBAR_01','Главное Меню');
define('FS_AMP_SECOND_SIDEBAR_02','Корпоративные Сети');
define('FS_AMP_SECOND_SIDEBAR_03','Ethernet Коммутаторы');
define('FS_AMP_SECOND_SIDEBAR_04','Коммутаторы ЦОД');
define('FS_AMP_SECOND_SIDEBAR_05','PDU, UPS, Система Питания');
define('FS_AMP_SECOND_SIDEBAR_06','Сетевые Адаптеры');
define('FS_AMP_SECOND_SIDEBAR_07','Маршрутизаторы, Серверы');
define('FS_AMP_SECOND_SIDEBAR_08','Медиаконвертеры, KVM, TAP');
define('FS_AMP_SECOND_SIDEBAR_09','Оптические Модули');
define('FS_AMP_SECOND_SIDEBAR_10','40G/100G Модули');
define('FS_AMP_SECOND_SIDEBAR_11','Модули SFP+');
define('FS_AMP_SECOND_SIDEBAR_12','Модули SFP');
define('FS_AMP_SECOND_SIDEBAR_13','Кабели DAC (Direct Attach Cables)');
define('FS_AMP_SECOND_SIDEBAR_14','Кабели AOC (Active Optical Cables)');
define('FS_AMP_SECOND_SIDEBAR_15','Модули XFP');
define('FS_AMP_SECOND_SIDEBAR_16','Цифровое Видео Модули');
define('FS_AMP_SECOND_SIDEBAR_17','Другие Модули');
define('FS_AMP_SECOND_SIDEBAR_18','FS Программатор');
define('FS_AMP_SECOND_SIDEBAR_19','Кабельные Сборки');
define('FS_AMP_SECOND_SIDEBAR_20','Кабели MTP');
define('FS_AMP_SECOND_SIDEBAR_21','Оптические Патч-Корды');
define('FS_AMP_SECOND_SIDEBAR_22','Износоустойчивые Кабельные Сборки');
define('FS_AMP_SECOND_SIDEBAR_23','Кабели MPO');
define('FS_AMP_SECOND_SIDEBAR_24','Высокоплотные Патч-Корды');
define('FS_AMP_SECOND_SIDEBAR_25','Претерминированные Многоволоконные Кабели');
define('FS_AMP_SECOND_SIDEBAR_26','Оптические Пигтейлы');
define('FS_AMP_SECOND_SIDEBAR_27','Оптические Адаптеры и Разъемы');
define('FS_AMP_SECOND_SIDEBAR_28','Оптические Кабели');
define('FS_AMP_SECOND_SIDEBAR_29','Стойки/Панели/Кроссы');
define('FS_AMP_SECOND_SIDEBAR_30','Стоийки & Шкафы');
define('FS_AMP_SECOND_SIDEBAR_31','Оптические Кроссы');
define('FS_AMP_SECOND_SIDEBAR_32','Панели Оптических Адаптеров');
define('FS_AMP_SECOND_SIDEBAR_33','MTP Оптические Кассеты');
define('FS_AMP_SECOND_SIDEBAR_34','MPO Оптические Кассеты');
define('FS_AMP_SECOND_SIDEBAR_35','Волоконно-оптические Кассеты');

define('FS_AMP_SECOND_SIDEBAR_57','MTP-LC Breakout Панели');
define('FS_AMP_SECOND_SIDEBAR_58','Кабельные Управления');
define('FS_AMP_SECOND_SIDEBAR_59','Система Кабельных Каналов');

define('FS_AMP_SECOND_SIDEBAR_36','WDM & Оптический Доступ');
define('FS_AMP_SECOND_SIDEBAR_37','Mux Demux & OADM');
define('FS_AMP_SECOND_SIDEBAR_38','Пассивные Оптические Компоненты');
define('FS_AMP_SECOND_SIDEBAR_39','Оптическое Окончание');
define('FS_AMP_SECOND_SIDEBAR_40','FMT WDM Транспортная Платформа');
define('FS_AMP_SECOND_SIDEBAR_41','FMT Модульные Инфраструктуры');
define('FS_AMP_SECOND_SIDEBAR_42','Тестеры & Инструменты');
define('FS_AMP_SECOND_SIDEBAR_43','Cat5e/Cat 6/Cat 7/Cat 8');
define('FS_AMP_SECOND_SIDEBAR_44','Патч-Корды');
define('FS_AMP_SECOND_SIDEBAR_45','Претерминированные Кабельные Сборки');
define('FS_AMP_SECOND_SIDEBAR_46','Кабели Витая Пара');
define('FS_AMP_SECOND_SIDEBAR_47','Патч панели 19\'\'');
define('FS_AMP_SECOND_SIDEBAR_48','Kabelmanagement');
define('FS_AMP_SECOND_SIDEBAR_49','Кабельные Управления');
define('FS_AMP_SECOND_SIDEBAR_50','Оптические Инструмент & Тестеры');
define('FS_AMP_SECOND_SIDEBAR_51','Оптические Очистки');
define('FS_AMP_SECOND_SIDEBAR_52','Базовые Тестеры Оптики');
define('FS_AMP_SECOND_SIDEBAR_53','Передовые Тестеры Оптики');
define('FS_AMP_SECOND_SIDEBAR_54','Оптические Полировки & Сращивания');
define('FS_AMP_SECOND_SIDEBAR_55','Оптические Инструменты');
define('FS_AMP_SECOND_SIDEBAR_56','Оптические Инструменты & Тестеры');
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
define('FS_AMP_SEARCH_01','Горячие запросы');
//语言选择
define('FS_AMP_SELECT_LANG_01','Выберите страну/регион');
define('FS_AMP_SELECT_LANG_02','Сохранить');
//订阅功能语言包(单页面，账户中心)
define('FS_EMAIL_SUBSCRIPTION_01','Подписки по электронной почте');
define('FS_EMAIL_SUBSCRIPTION_02','Управлять предпочтениями подписки на электронную почту и получать последние новости от FS.');
define('FS_EMAIL_SUBSCRIPTION_03','Настройки подписки эл. почты');
define('FS_EMAIL_SUBSCRIPTION_04','Подтвердите электронную почту, которую Вы хотите управлять подпиской');
define('FS_EMAIL_SUBSCRIPTION_05','Подпишитесь на электронные письма FS, чтобы узнать больше о последних льготных политиках, новостях инвентаря, технической поддержке и т.д. Электронные письма FS будут держать Вас в курсе! Или новые продукция, или решения для центров обработки данных, которые Вы можете не знать.');
define('FS_EMAIL_SUBSCRIPTION_06','Электронные письма о Вашем аккаунте и заказах очень важны. Мы отправляем их, даже если Вы отказались от рекламных писем.');
define('FS_EMAIL_SUBSCRIPTION_07','Внимание: любые изменения могут вступить в силу только через 48 часов. Поэтому Вы будете по-прежнему получать электронные письма о заказах, льготных политиках, новостях инвентаризации и технической поддержке независимо от подписки на электронную почту.');
define('FS_EMAIL_SUBSCRIPTION_08','Как часто Вы хотите получать рекламные акции?');
define('FS_EMAIL_SUBSCRIPTION_09','Регулярно');
define('FS_EMAIL_SUBSCRIPTION_10','Не чаще одного раза в неделю');
define('FS_EMAIL_SUBSCRIPTION_11','Не чаще одного раза в месяц');
define('FS_EMAIL_SUBSCRIPTION_12','Никогда');
define('FS_EMAIL_SUBSCRIPTION_13','Сохранять');
define('FS_EMAIL_SUBSCRIPTION_14','Отменять');
define('FS_EMAIL_SUBSCRIPTION_15','Ваш запрос был успешно отправлен!');
define('FS_EMAIL_SUBSCRIPTION_16','Мы ответим Вам в течение 24 часов.');
define('FS_EMAIL_SUBSCRIPTION_17','Введите адрес электронной почты, пожалуйста.');
define('FS_EMAIL_SUBSCRIPTION_18','Просмотр, изменение или отмена подписки.');
define('FS_EMAIL_SUBSCRIPTION_19','<span class="iconfont icon">&#xf158;</span>Вы успешно отписались.');
define('FS_EMAIL_SUBSCRIPTION_20','Вы больше не будете получать рекламные письма от FS.');
define('FS_EMAIL_SUBSCRIPTION_21','<span class="iconfont icon">&#xf158;</span>Вы успешно подписались.');
define('FS_EMAIL_SUBSCRIPTION_22','Спасибо за подписку на письма FS.');
define ('FS_EMAIL_SUBSCRIPTION_23', 'Отправьте мне письмо о последних новостях FS один раз в месяц.');
define('FS_EMAIL_SUBSCRIPTION_24','Вы больше не будете получать электронной почте запросы на комментарии FS.');
define('FS_EMAIL_SUBSCRIPTION_25','Вы больше не будете получать рекламная почта и запросы на комментарии FS.');

//底部订阅语言包
define('FS_EMAIL_SUBSCRIPTION_FOOTER_01','Подписаться');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_02','Получайте самые последние новости от FS');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_03','Ваш адрес электронной почты');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_04','Введите адрес электронной почты, пожалуйста.');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_05','Система занята.  Повторите попытку позже.');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_06','Спасибо за подписку!');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_07','Мобильное приложение');
//2019.5.27 新政策弹窗 pico
define('FS_SHIPPING_RETURNS','<a class="info_returns" href="javascript:;">'.FS_DELIVERY_RETURN.'</a>');
define('FS_SHIPPING_WARRANTY','<a class="info_warranty" href="javascript:;">Гарантия</a>');
define('FS_SHIPPING_SUPPORT','<a class="" href="'.reset_url('product_support.html?products_id=###').'" target="_blank">Поддержка продуктов</a>');
define('FS_SHIPPING_RETURNS_TITLE','30 дней на возврат');
define('FS_SHIPPING_RETURNS_PART',"FS предоставляет возврат и обмен товаров в течение 30 дней, чтобы гарантировать Вам по-настоящему беспроблемный опыт покупок. Если причиной возврата является наша ошибка, мы будем нести ответственность за все расходы по доставке и налогу. Посетите <a href ='".zen_href_link('index')."policies/day_return_policy.html' target='_blank'>Возврат</a> для того, чтобы узнать подробности о разных продуктах.");
define('FS_SHIPPING_WARRANTY_TITLE','Гарантия на весь ассортимент продукции');
define('FS_SHIPPING_WARRANTY_PART',"Если возникала проблема с товаром, но Вы прошли окно возврата, не беспокойтесь. Пока продукт находится на гарантии, Вы можете пользоваться бесплатным ремонтом. Запросить конкретный гарантийный срок продукции <a href ='".zen_href_link('index')."policies/warranty.html' target='_blank'>Политика гарантии</a>.");
define('FS_SHIPPING_SUPPORT_TITLE','Бесплатное техническое обслуживание');
define('FS_SHIPPING_SUPPORT_PART',"FS стремится стать надежными партнерами наших клиентов и предлагает полную серию товаров цифровой инфраструктуры и комплексное универсальное цифровое решение.");
define('FS_SHIPPING_SUPPORT_PART_BR',"Вы можете <a href='".reset_url('solution_support.html')."' target='_blank'> Запросить техническую поддержку</a>, чтобы получить своевременную помощь по любым вопросам об проектах или бесплатном решении для подключения.");

//add by ternence 询价产品弹窗
define('FS_PRODUCT_INQUIRY_3','Ваш запрос получен FS. Вам будет ответ.');
define('FS_PRODUCT_INQUIRY_1','Мы ответим Вам в течение 24 часов.');
define('FS_PRODUCT_INQUIRY_2','Нажав на кнопку ниже, Вы принимаете <a href="javascript:;" class="">Политику конфиденциальности и файлов Cookie</a> и <a href="javascript:;">Условия использования</a> FS.');

//add by ternence 结算页面地址提示
define('FS_SALES_INFO_MODAL_ZIP_CODE','Почтовый Индекс*');
//退换货指引入口
define('FS_RETURN_BUTTON','Возврат товара');

//登陆超时
define('LOING_TIMEOUT','Время Вашего сеанса истекло. Войдите еще раз, пожалуйста.');
//产品详情AOC
define('PRODUCT_AOC','Мы можем изготовить кабели необходимой длины от 1m до 300m (от 3ft до 984.252ft) по Вашему требованию.');
define('PRODUCT_AOC_1','Мы можем изготовить кабели необходимой длины от 1m до 30m (от 3ft до 98.43ft) по Вашему требованию.');
//报价列表
define('QUOTE_EMPTY_1','Вы пока не сделали запроса предложения.');
define('QUOTE_EMPTY_2','Начать Покупки');
define('QUOTE_EMPTY_3','Запрос предложения не найден.');

define("ATTRIBUTE_MESSAGE",'Полностью совместит с коммутаторами Cisco. Для больше совместимых вариантов, <a target="_blank" href="https://tmgmatrix.cisco.com"> нажмите здесь</a>, пожалуйста.');

//首页cart sign in翻译
define('FILENAME_SIGN_IN','Войти');
define('FILENAME_HOME_CART','Корзина');

//购物车登陆且为空的状态 添加save cart入口
//define('FS_SAVE_CART_ENTRANCE','Найти товары в <a href="'.zen_href_link('saved_items','type=saved_carts','SSL').'">сохраненных корзинах</a> или продолжить покупки.');
define ('FS_SAVE_CART_ENTRANCE', 'Продолжить покупки на FS или просмотреть свои <a target="_blank" href="'.zen_href_link('saved_items','type=saved_carts','SSL').'"> Сохраненные корзины </a>. ');
//报价添加打印
define('INQUIRY_GET_A_QUOTE','Нужна помощь при покупке?');
define('INQUIRY_GET_A_QUOTE_1',"Мы всегда готовы помочь решить проблему с заказом, продуктом и установкой. Свяжитесь с нами по телефону ");
define('INQUIRY_GET_A_QUOTE_2',' или по почте ');
define('INQUIRY_GET_A_QUOTE_3','Распечатать КП');
define('INQUIRY_GET_A_QUOTE_4','Детали КП');
define('INQUIRY_GET_A_QUOTE_5','Кол-во(шт.)');
define('INQUIRY_GET_A_QUOTE_6','Сумма КП');

//add by liang.zhu 2019.07.04 functions_shippgin.php中的 zen_get_order_shipping_method_by_code函数使用
define('FS_CUSTOMER_ACCOUNT', 'Личный кабинет клиента');

//qv库存提示
define('QV_SHOW_AVAILABLE_01', 'Доступны, Нужен Транзит');
define('QV_SHOW_AVAILABLE_02', 'Доступны, В Транзите');

//清仓产品加购限制 Dylan 2019.8.27
define ('FS_CLEARANCE_TIPS_TITLE', 'Доступного количества недостаточно');
define ('FS_CLEARANCE_TIPS_CONTENT', 'Указанное Вами количество превышает доступный запас <span class="clearance_total_qty">$QTY</span>, пожалуйста, обратитесь к менеджеру своего аккаунта для получения дополнительного количества.');
define('QV_CLEARANCE_TIPS','Указанное Вами количество превышает доступный запас <span class="clearance_total_qty">$QTY</span>.');
define ('QV_CLEARANCE_EMPTY_QTY_TIPS', 'Товар отсутствует на складе, пожалуйста, обратитесь к менеджеру своего аккаунта для доступности.');


//文章分类
define('CASE_STUDIES_01','Регион');
define('CASE_STUDIES_02','Северная Америка');
define('CASE_STUDIES_03','Латинская Америка');
define('CASE_STUDIES_04','Европа');
define('CASE_STUDIES_05','Океания');
define('CASE_STUDIES_06','Африка');
define('CASE_STUDIES_07','Ближний Восток');
define('CASE_STUDIES_08','Азия');
define('CASE_STUDIES_09','Тип решений');
define('CASE_STUDIES_10','OTN');
define('CASE_STUDIES_11','Корпоративная сеть');
define('CASE_STUDIES_12','Кабельная система ЦОД');
define('CASE_STUDIES_13','Сфера деятельности');
define('CASE_STUDIES_14','Финансы');
define('CASE_STUDIES_15','Образование');
define('CASE_STUDIES_16','Здравоохранение');
define('CASE_STUDIES_17','ISP');
define('CASE_STUDIES_18','Производство');
define('CASE_STUDIES_19','Транспорт');
define('CASE_STUDIES_20','Розничная торговля');
define('CASE_CLEAR_ALL','Очистить всё');
define("FS_PRODUCTS","Результат: ");
define("FS_PRODUCT","Результат");
define('CASE_CATEGORY_MENU_CASE_STUDIES','Практические примеры');

define('FS_TEST_TOOL','Тестеры');


// add yang
define('FS_PRODUCT_INSTALLATION_TEXT_1','Подходит для <a href="ru/c/fhd-rack-mount-45" style="color: #0070BC;">стоечного</a> и <a href="ru/c/fhd-wall-mount-3358" style="color: #0070BC;">настенного</a> оптического кросса FHD');
define('FS_PRODUCT_INSTALLATION_TEXT_2','Подходит для для оптического кросса <a href="'.zen_href_link('product_info','products_id=68911','SSL').'" style="color: #0070BC;">FHX-1UFSP</a>, который можно устанавливать в 19-дюймовые стойки');
define('FS_PRODUCT_INSTALLATION_TEXT_3','Подходит для для оптического кросса <a href="'.zen_href_link('product_info','products_id=72772','SSL').'" style="color: #0070BC;">FHX-1UFSP</a>, который можно устанавливать в 19-дюймовые стойки');
define('FS_PRODUCT_INSTALLATION_TEXT_4','Подходит для для оптического кросса <a href="'.zen_href_link('product_info','products_id=74183','SSL').'" style="color: #0070BC;">FHZ-1UFSP</a>, который можно устанавливать в 19-дюймовые стойки');
define('FS_ADDRESS_PO','PO');

//dylan 2019.7.26
define('FS_PRODUCT_INSTALLATION_TEXT_5','Подходит для сетевых и серверных шкафов <a href="'.zen_href_link('product_info','products_id=73579','SSL').'" style="color: #0070BC;">серии GR800</a> и <a href="'.zen_href_link('product_info','products_id=79273','SSL').'" style="color: #0070BC;">серии HR800</a>');
define('FS_PRODUCT_INSTALLATION_TEXT_6','Подходит для серверных шкафов <a href="'.zen_href_link('product_info','products_id=73958','SSL').'" style="color: #0070BC;">серии GR600</a> и <a href="'.zen_href_link('product_info','products_id=79272','SSL').'" style="color: #0070BC;">серии HR600</a>');
define('FS_PRODUCT_INSTALLATION_TEXT_7','Подходит для сетевых и серверных шкафов <a href="'.zen_href_link('product_info','products_id=73579','SSL').'" style="color: #0070BC;">серии GR800</a> и <a href="'.zen_href_link('product_info','products_id=73958','SSL').'" style="color: #0070BC;">серии GR600</a>');
define('FS_PRODUCT_INSTALLATION_TEXT_8','Подходит для сетевых и серверных шкафов <a href="'.zen_href_link('product_info','products_id=73579','SSL').'" style="color: #0070BC;">серии GR800</a>');
define('FS_PRODUCT_INSTALLATION_TEXT_9','Модуль FMX 100G подходит для шасси <a href="'.zen_href_link(FILENAME_PRODUCT_INFO,'products_id=96454','SSL').'" style="color:#0070BC;">FMX-100G-CH2U</a> которое можно смонтироваться на стойке');

// add by pico
define('CHECKOUT_ERROR_01', 'Выберите способ оплаты, пожалуйста.');
define('CHECKOUT_ERROR_02', 'Имя владельца карты обязательно.');
define('CHECKOUT_ERROR_03', 'Номер карты обязателен.');
define('CHECKOUT_ERROR_04', 'Код безопасности обязателен.');
define("GLOBAL_GC_TEXT13","Номер карты");
define("GLOBAL_GC_TEXT14","Действителен до");
define("GLOBAL_GC_TEXT17","CVV");

//add by Jeremy 新版一級分類頁
define('FS_IDEAS_ADVICE', 'Комбинация применения');
define('FS_BEST_SELLERS', 'Хит продажи');
define('FS_CASE_STUDIES', 'Практические примеры');


//add ternence
define('INQUIRY_TITLE','Отправить список запросов КП по электронной почте');
define('INQUIRY_TITLE_1','Полученный Вами список запросов КП');
define('INQUIRY_TITLE_2','Письмо отправлено успешно');
define('INQUIRY_TITLE_3','Получило! Ваш запрос коммерческих предложений был отправлен вашему списку адресатов');
define('INQUIRY_TITLE_4','Вернуться список запросов КП');
define('INQUIRY_TITLE_5','Письмо отправлено успешно');
define('INQUIRY_TITLE_6','Кто-то создал список запросов только для Вас, чтобы Вы могли подключиться! Если Вам еще нужна помощь, Вы всегда можете');
define('INQUIRY_TITLE_7','Добавить в список ниже, ');
define('INQUIRY_TITLE_8','  Вы добавите в список запросов КП то, что видите на этой странице.');
define('INQUIRY_TITLE_9','Поделиться с вами список запросов');
define('INQUIRY_TITLE_10','Коммерческое предложение');
define('INQUIRY_TITLE_11',' поделился с Вами списком запросов КП. Вы можете нажать кнопку ниже, чтобы посмотреть полную информацию и добавить в свой список запросов КП.');
define('INQUIRY_TITLE_12',' поделились с Вами списком запросов');
define('INQUIRY_TITLE_13','Добавить в список');
define("FS_INQUIRY_INFO_67",'Ваш запрос на КП пуст. Если у Вас есть аккаунт, <a class="quote_sing" target="_blank" href="'.zen_href_link('login','','SSL').'">войдите,</a> чтобы увидеть список запросов.');
define("FS_INQUIRY_INFO_68",'Email');
define("FS_INQUIRY_INFO_69",'Кол-во');


//checkout 修改地址印度税号框提示
define('CHECKOUT_TAX_1','ИНН');
define('CHECKOUT_TAX_2','Для ускорения таможенного оформления, пожалуйста, заполните действующий налоговый номер.');

// 2019-7-4 potato 登录注册need help
define('FS_SIGN_IN_NEED_HTLP',"Нужна помощь?");
define('FS_SIGN_IN_CONTACT_CUSTOMER_SUPPORT',"Свяжитесь со службой поддержки клиентов.");


//ery  add 2019.7.15  赠品提示语
define('FS_GIFT_TITLE_IS','Следующий товар бесплатен и не учтен его стоимость в общей сумме заказа.');
define('FS_GIFT_TITLE_ARE','Следующие товары бесплатны и не учтены их стоимости в общей сумме заказа.');
define('FS_GIFT_TITLE_FREE','<div class="addCrat_item_giftBox after"><span class="iconfont icon"></span><div class="addCrat_item_giftTxt1">Бесплатный подарок</div></div>');
define('FS_GIFT_CHECK_TITLE','Бесплатный подарок недоступен для текущего адреса доставки, при необходимости выберите инструмент тестирования на странице товара.');
define('FS_GIFT_TITLE_FREE_EMAIL','<div style="background: #ebf8e7;border-radius: 2px;display: inline-block;padding: 3px 10px;margin-bottom: 8px;line-height: 20px;"><span style="font-size: 16px;float: left;color: #18a109;"><img src="https://img-en.fs.com/includes/templates/fiberstore/images/pro-gift.png"></span><div style="padding-left: 21px;color: #18a109;">Бесплатный подарок</div></div>');

define('FS_COMMON_PRIVACY_POLICY',' Я согласен с <a href='.HTTPS_SERVER.reset_url('policies/privacy_policy.html').' target="_blank">политикой конфиденциальности</a> и <a href='.HTTPS_SERVER.reset_url('policies/terms_of_use.html').' target="_blank"> условиями использования</a> FS.');
define('FS_COMMON_PRIVACY_POLICY_ERROR','Убедитесь, что вы соглашаетесь с политикой конфиденциальности и условиями использования.');

define('NEW_PRODUCTS_TAG','Новинка');

define('HOT_PRODUCTS_TAG','Хит');

define("INVALID_CVV_ERROR",'Код безопасности неверный. Введите правильный код и попробуйте снова пожалуйста.');

define('FS_ACCOUNT_CODING_REQUESTS','Запросы кодирования');
define('FS_ACCOUNT_MY_CODING_REQUESTS','Мои запросы кодирования');
define('FS_ACCOUNT_CODING_REQUEST_BTN','Запросить кодирование');
define('CODING_REQUESTS_LIST','Списки запросов кодирования');
define('CODING_REQUESTS_CODING_DETAILS','Детали запроса кодирования');

// 2019-7-19 potato 地址编辑提示修改
define("FS_POST_CODE_TITLE_ERROR","Ваш почтовый индекс обязателен.");
define("FS_CITY_TITLE_ERROR","Ваш город обязателен.");
define("FS_CHECKOUT_ERROR28_AU","Введите действующий почтовый индекс, пожалуйста.");
define("ACCOUNT_EDIT_CITY_AU","Город");
define("ACCOUNT_EDIT_STATE_AU","Область");
define("FS_ZIP_CODE_AU_NEW","Почтовый индекс");


//add by liang.zhu 2019.09.02
define ('FS_COMMON_LEARN_MORE', 'Узнайте больше');
define ('FS_COMMON_SEE_MORE', 'Подробнее');
define ('FS_COMMON_SEE_LESS', 'Меньше');

//模块标签属性
DEFINE ( 'FS_PLACEHOLDER_EG', 'напр.:');
define ('FS_OPTIONAL', ' (необязательно)');

// 2019-9-2 potato 俄罗斯的税号
define('FS_CHECK_OUT_TAX_NEW_RU','НДС');
define('FS_CHECK_OUT_INCLUDEING_RU','(Включая НДС)');
define ('FS_CHECK_OUT_EXCLUDING_RU', '(Без НДС)');

//2019-9-7 Jeremy 购物车改版
define ("FS_CART_ITEM_TOTAL", "Всего");
define ("FS_CART_ATTR_BTN", "Выберите атрибут(ы)");
define ("FS_CART_ATTR_CONTENT", "Это заказной продукт. Пожалуйста, сначала выберите атрибут(ы).");

// 表单次数提交频繁
define('FS_SUBMIT_TOO_OFTEN','Слишком много попыток. Пожалуйста, повторите позже.');
define('FS_ROBOT_VERIFY_PROMOPT','Следуйте инструкциям, пожалуйста, чтобы завершить проверку.');

//2019-09-17 add by liang.zhu
define("CHECKOUT_TAXE_SG_TIT", "О GST и тарифе");
define("CHECKOUT_TAXE_SG_FRONT", "Для заказов, отправленных с Сингапурского склада в территории Сингапура, FS.COM TECH PTE LTD обязан взимать стоимость продукта и доставки сборов в размере 7%.<br/> <br/> Для продуктов, заказанных Вами в настоящее время не в наличии, мы отправим их непосредственно из склада Азии(CN) и не взимаем GST. Однако, эти пакеты могут быть оценены на импортные или таможенные сборы. Любые тарифы или импортные сборы, вызванных таможенным оформлением грузов, возлагаются на получателя.");
//新加坡其他10国家
define("CHECKOUT_TAXE_SG_OTHERS_TIT", "О пошлинах и налогах");
define("CHECKOUT_TAXE_SG_OTHERS_FRONT", "Для заказов, отправленных в пункты назначения за пределами Сингапура, мы только взимаем стоимость продукта и доставки сборов. Никакой налог с продаж (например, НДС или GST) не взимается. Однако, для этих заказов импортные или таможенные сборы могут взиматься в зависимости от законов/правил конкретных стран. Любые тарифы или импортные сборы, вызванных таможенным оформлением грузов, возлагаются на получателя.");

//mtp退货货提示语
define ('FS_RETURN_ALL_MTP_PRODUCTS', 'Пожалуйста, верните все эти аксессуары вместе.');
//2019-09-17 liang.zhu 国家所属于的洲
//北美洲
define('FS_STATE_NORTH_AMERICA', 'Северная Америка');
//澳洲
define('FS_STATE_OCEANIA', 'Океания');
//亚洲
define('FS_STATE_ASIA', ' Азия');
//欧洲
define('FS_STATE_EUROPE', 'Европа');
define('FS_PORTFOLIOS','портфели');
define('FS_ORDER_LINK_REMARK','Nota');
define('FS_VIEW_INVOICE_BUBBLE','Por favor, ponte en contacto con tu gerente de cuenta para la nueva factura de este pedido.');

define("FS_TIME_ZONE_RULE_SG","(GMT+8)");
define("FS_JS_TIT_CHECK_SG","9:00am - 5:00pm ");
define("FS_SHIPPING_SG_GRAB_TIPS","Эта услуга доступна для заказов разовой поставки, отправленных со склада SG, и оплаченных до 15:00 в рабочие дни.");
define("FS_TIME_ZONE_ADDRESS_SG","<span>Склад SG FS:</span> 30A Kallang Pl, #11-10/11/12, Singapore 339213 | +65 6443 7951");

define('FS_SG_VAT_NUMBER',"Номер GST");

//无时差报价
define('FS_SHOP_CART_ALERT_JS_121','Отправить список запросов КП по электронной почте');
define("FS_INQUIRY_REVIEWING_1",'Отправлено');
define("FS_INQUIRY_QUOTED_1",'Одобрено');
define('FS_QUOTE_INFO_1','Детали КП');
define("FS_INQUIRY_CANCELED_1",'Истек срок действия');
define('FS_QUOTE_INFO_2','Цена за единицу');
define('FS_QUOTE_INFO_3','Целевая цена');
define('FS_QUOTE_INFO_4','Цена со скидкой');
define('FS_QUOTE_INFO_5','(Цена без учета налогов и стоимости доставки)');
define('FS_QUOTE_INFO_6','Всего');
define('FS_QUOTE_INFO_8','Сначала выберите товар пожалуйста.');
define('FS_QUOTE_INFO_9','Спасибо. Мы отправили ваше КП в список получателей по электронной почте.');
define('FS_QUOTE_INFO_10','Вернуться к Деталям КП');
define('FS_QUOTE_INFO_11','Запросить цену снова');
define('FS_QUOTE_INFO_12','Запросить цену');
define('FS_QUOTE_INFO_12_1','Целевая цена');
define('FS_QUOTE_INFO_13','Сумма (');
define('FS_QUOTE_INFO_14',' Товар');
define('FS_QUOTE_INFO_15','Целевая цена:');
define('FS_QUOTE_INFO_16','Цена без учета налогов и стоимости доставки');
define('FS_QUOTE_INFO_17','Это КП предлагает скидки на основе всего списка товаров. Если Вы удалите некоторые товары со списка товаров, скидка будет недействительной.');
define('FS_QUOTE_INFO_18','Это КП предлагает различные скидки в зависимости от количества каждого товара. Если Вы уменьшите количество товаров при оформления заказа, скидка на выбранный товар будет недействительной.');
define('FS_SEND_EMAIL_2019_1',"Мы получили Ваш запрос на КП ");
define('FS_SEND_EMAIL_2019_2',", Ваш менеджер по аккаунту предоставит Вам КП через 30 минут. Проверьте, пожалуйста, его в ");
define('FS_SEND_EMAIL_2019_3',"Моем КП");
define('FS_SEND_EMAIL_2019_4'," позже.");
define('FS_SEND_EMAIL_2019_5',"Ваш клиент ");
define('FS_SEND_EMAIL_2019_6',"Запросить КП");
define('FS_SEND_EMAIL_2019_7',"Ваш товар");
define('FS_SEND_EMAIL_2019_8',"Кол: ");
define('FS_SEND_EMAIL_2019_9',"Ваш товар");
define('FS_SEND_EMAIL_2019_10',"Кол-во");
define('FS_SEND_EMAIL_2019_11',"Целевая цена");
define('FS_SEND_EMAIL_2019_12',"Цена за ед.");
define('FS_SEND_EMAIL_2019_13',"Сумма:");
define('FS_SEND_EMAIL_2019_14',"Целевая:");
define('FS_SEND_EMAIL_2019_15',"Перейти к КП");
define('FS_QUOTE_INFO_19','Дата');
define("FS_INQUIRY_INFO_65_1","Это КП действителен только в течение 15 дней и истекает ");
define("FS_INQUIRY_INFO_65_2",", Истекает ");
define("FS_INQUIRY_INFO_65_3","Общая сумма:");

// rebirth  2019.08.16  订单支付超时提示语
define('FS_ORDERS_OVERTIMES_01', 'Пожалуйста,завершите платёж в течение ');
define('FS_ORDERS_OVERTIMES_02', '');
define('FS_ORDERS_OVERTIMES_03', '');
define('FS_ORDERS_OVERTIMES_02_PO', '');//德语的在po方面有语法区别
define('FS_ORDERS_OVERTIMES_03_PO', '');//德语的在po方面有语法区别
define('FS_ORDERS_OVERTIMES_04', 'В противном случае заказ будет отменен автоматически из-за изменения запасов товаров.');
define('FS_ORDERS_OVERTIMES_05', 'Пожалуйста, загрузите файл PO в течение ');
define('FS_ORDERS_OVERTIMES_06', 'Внимание: Укажите Ваш номер заказа FS при оплате, чтобы Ваш заказ мог быть своевременно обработан. Обычно средства получают в течение 1-3 рабочих дня.');
define('FS_ORDERS_OVERTIMES_07', 'Ваш заказ должен быть проверен по следующей причине:');
define('FS_ORDERS_OVERTIMES_08', 'Адрес доставки не совпадает с адресами в Вашей заявке на кредит');
define('FS_ORDERS_OVERTIMES_09', 'Ваш доступный кредит был превышен');
define('FS_ORDERS_OVERTIMES_10', 'Пожалуйста, оплатите предыдущие заказы для восстановления кредита, или Вы можете войти в раздел "Мой кредит" для подачи заявления на увеличение кредитного лимита. Мы будем проверять заказ и сообщать Вам по электронной почте.');
define('FS_ORDERS_OVERTIMES_11', 'Мы будем проверять заказ и сообщать Вам в течение 12 часов по электронной почте.');
define('FS_ORDERS_OVERTIMES_12', 'Чтобы заказ быстро обработан, оплатите предыдущие заказы для восстановления кредита, или Вы можете войти в раздел "Мой кредит" для подачи заявления на увеличение кредитного лимита.');
define('FS_ORDERS_OVERTIMES_13', 'Обратный отсчет');
define('FS_ORDERS_OVERTIMES_14', 'дн'); //天  这三个是英文的 day  hour minute 首字母缩写
define('FS_ORDERS_OVERTIMES_15', 'ч'); //时
define('FS_ORDERS_OVERTIMES_16', 'мин'); //分
define('FS_ORDERS_OVERTIMES_17', 'К сожалению, Ваш заказ был отменен из-за истечения срока оплаты.');
define('FS_ORDERS_OVERTIMES_18', 'Вы можете найти его в истории заказов и нажать "Повторить заказ", чтобы заказать повторно.');
define('FS_ORDERS_OVERTIMES_19', 'Что-то пошло не так с Вашим заказом......');
define('FS_ORDERS_OVERTIMES_20', 'Мы получили Ваш денежный перевод от');
define('FS_ORDERS_OVERTIMES_21', 'Однако, заказ был закрыт из-за истечения срока оплаты (указан в заказах в ожидании платежа FS). Пожалуйста, свяжитесь с менеджером по аккаунту, чтобы восстановить заказ. Приносим извинения за неудобства!');
define ('FS_ORDERS_OVERTIMES_22', 'В Вашем кредитном аккаунте имеются просроченные счета. Оплатите предыдущие заказы пожалуйста. В противном случае Ваш менеджер по аккаунту свяжется с Вами и попросит дополнительные документы для проверки.');
// rebirth  2019.09.06  订单支付超时  提醒邮件语言包
define('FS_ORDERS_OVERTIMES_36','FS Напоминание о заказе- Ожидание Оплаты ');
define('FS_ORDERS_OVERTIMES_23','Напоминание о заказе');
define('FS_ORDERS_OVERTIMES_24','Спасибо за выбор FS. Мы заметили, что у Вас неоплаченный заказ <b style="font-weight: 600;">');
define('FS_ORDERS_OVERTIMES_25','<b style="font-weight: 600;">Внимание</b>:Если Вы оплатили заказ, проигнорируйте это письмо и мы вскоре обработаем Ваш заказ. Если Вам больше не нужны эти товары, проигнорируйте это письмо и заказ будет автоматически отменен позже.');
define('FS_ORDERS_OVERTIMES_26','Хорошего дня!');
define('FS_ORDERS_OVERTIMES_27','</b>.  Напоминаем, что он будет автоматически отменен через ');
define('FS_ORDERS_OVERTIMES_28','. Просто <a style="color: #0070bc;text-decoration:none;" href="');
define('FS_ORDERS_OVERTIMES_29','">нажмите здесь</a> чтобы совершить покупку, и Ваш заказ может быть в обработке как можно скорее.');


//by rebirth 2019.10.18 新版上传提示 俄语
define ("FS_UPLOAD_NEW_NOTICE_ONE", "Пожалуйста, используйте файл PDF, JPG, PNG, DOC, DOCX, XLS, XLSX или TXT.");
define ("FS_UPLOAD_NEW_NOTICE_TWO", "Пожалуйста, используйте файл JPG, GIF, PNG, JPEG или BMP.");
define("FS_UPLOAD_NEW_NOTICE_THREE","Максимальный размер 5M.");
define("FS_UPLOAD_NEW_NOTICE_FOUR","Максимальный размер 300KB.");
define ("FS_UPLOAD_NEW_ERROR_1", "Загруженный файл запрещен!"); // 该 文件 不允许 上传
define ("FS_UPLOAD_NEW_ERROR_2", "Файл уже существует!"); // 文件 已 存在
define ("FS_UPLOAD_NEW_ERROR_3", "Не удалось загрузить файлы на облачный сервер."); // 文件 上传 云 服务器 失败
define('FS_UPLOAD_NEW_ERROR_4', 'Загруженный файл превышает директиву');//文件大小超过php.ini的限制

define('FS_SHOP_CART_SG_INSTALL','Бесплатная установка предоставляется для товаров на складе SG. Оформить заказ, чтобы узнать больше.');

define('FS_CHECKOUT_SGINSTALL_CC','Вы выбрали сервис установки. Не забудьте, пожалуйста, завершить оплату до запланированного времени установки, в противном случае сервис может быть отложен.');
define('FS_SG_DELIVERY_FREE_RETURNS_CONTENT','Бесплатная установка службы поддерживается для всех продуктов в наличии. Вы можете выбрать услугу на странице оформления заказа.');
define('FS_SG_DELIVERY_RETURN','Бесплатная установка');

define('FS_CHECKOUT_SGINSTALL_SUCCESS_1','Вы выбрали сервис установки. Когда заказ будет готов к отправке, наш технический специалист свяжется с вами перед отъездом.');
define('FS_CHECKOUT_SGINSTALL_SUCCESS_2','Вы выбрали сервис установки. Не забудьте, пожалуйста, завершить оплату до запланированного времени установки, в противном случае сервис может быть отложен.');
define('FS_CHECKOUT_SGINSTALL_SUCCESS_3','Вы выбрали сервис установки. Загрузите, пожалуйста, PO-файл до запланированного времени установки, иначе сервис может быть отложен.');

define('FS_SG_CALENDAR_1',"Выберите время установки");
define('FS_SG_CALENDAR_2',"Получить доступное время для установки");
define('FS_SG_CALENDAR_3',"Выберите FS Доставка & Установка");
define('FS_SG_CALENDAR_4',"Выберите предпочтительное время установки.");
define("FS_SG_CALENDAR_5","Установка на месте");
define("FS_SG_CALENDAR_6",'Изменение доставки');
define("FS_SG_CALENDAR_7","Вы отменили все запросы на установку. Мы организуем поставку для вас.");
define("FS_SG_CALENDAR_8","отменить");
define("FS_SG_CALENDAR_9","Да, верно");
define("FS_SG_CALENDAR_10",'Только выбранные товары будут установлены после доставки.');
define("FS_SG_CALENDAR_11",'* В настоящее время услуга по установке доступна для товаров, отправленных со склада SG. Приносим извинения за неудобства.');
define('FS_FESTIVAL16','Праздник в Сингапуре в');
define('FS_FESTIVAL17',' в Складе SG.');
define('FS_FESTIVAL18','Праздники в России начнутся');
define('FS_FESTIVAL19','.');

//rebirth 2019.10.25 新加坡上门服务-账户中心
define("FS_SG_CALENDAR_100","Запрос на установку");
define("FS_SG_CALENDAR_101","Выберите тип услуги");
define("FS_SG_CALENDAR_102","Выберите, пожалуйста ");
define("FS_SG_CALENDAR_103","Поддержка проекта");
define("FS_SG_CALENDAR_104","Устранение неисправностей и ремонт");
define("FS_SG_CALENDAR_105","Выберите тип услуги, пожалуйста.");
define("FS_SG_CALENDAR_106","Напишите детали вашего запроса*");
define("FS_SG_CALENDAR_107","Опишите ваш запрос, пожалуйста..");
define("FS_SG_CALENDAR_108","Содержание должно быть не менее 4 символов.");
define("FS_SG_CALENDAR_109","Содержание должно быть не более 500 символов.");
define("FS_SG_CALENDAR_110","Запрос на установку");
define("FS_SG_CALENDAR_111","Тип услуги");
define("FS_SG_CALENDAR_112","Запланированное время");
define("FS_SG_CALENDAR_113","Детали запроса");
define("FS_SG_CALENDAR_114","Запланированная установка");
define("FS_SG_CALENDAR_115","Ваш запрос на установку получен.");
define("FS_SG_CALENDAR_116","Наш технический специалист свяжется с вами, прежде чем отправиться к вам.");

//ternence 新加坡上门服务邮件
define("FS_SG_EMAIL","Спасибо за выбор FS Сингапур, мы получили ваш отложенный заказ ");
define("FS_SG_EMAIL_1","Завершите оплату и вы снова получите от нас письмо, как только заказ запланирован для бесплатной установки.");
define("FS_SG_EMAIL_2","Некоторые товары доступны для бесплатной установки, вы можете <a href=".zen_href_link('manage_orders')." style=\"color: #0070BC;text-decoration: none\" target=\"_blank\">запросить установку</a> службы, если вам необходимо. Завершите платеж и вы снова получите письмо от нас.");
define("FS_SG_EMAIL_3","Вы выбрали сервис установки для вашего заказа ");
define("FS_SG_EMAIL_4"," Мы свяжемся с вами, когда наш технический специалист направится на ваш адрес доставки.");
define("FS_SG_EMAIL_5","Чтобы отслеживать статус вашего заказа, войдите в личный кабинет и перейдите на ");
define("FS_SG_EMAIL_6","Детали заказа ");
define("FS_SG_EMAIL_7","ниже. Мы отправим вам почту, как только появится обновление вашего заказа.");
define("FS_SG_EMAIL_8","Вы можете отслеживать статус вашего заказа, войдя в личный кабинет и перейдя на ");
define("FS_SG_EMAIL_9"," ОбратитЗаказ Отменёне внимание, что этот заказ может быть установлен бесплатно, и вы можете потратить некоторое время <a href=".zen_href_link('manage_orders')." style=\"color: #0070BC;text-decoration: none\" target=\"_blank\">здесь</a>.");
define("FS_SG_EMAIL_10","Ваш заказ ");
define("FS_SG_EMAIL_11"," готов к установке, и наш технический специалист будет направлен на ваш адрес вовремя.");
define("FS_SG_EMAIL_12","Если у вас есть какие-либо изменения, пожалуйста, свяжитесь с нами по <a style=\"color: #0070bc;text-decoration: none\" href=\"тел:+(65) 6443 7951\">+(65) 6443 7951</a> или почте <a style=\"color: #0070bc;text-decoration: none\" href=\"mailto:sg@fs.com\">sg@fs.com</a>.");
define("FS_SG_EMAIL_13","Спасибо");
define("FS_SG_EMAIL_14","Команда FS");
define("FS_SG_EMAIL_15","Контактная информация:");
define("FS_SG_EMAIL_16","Номер телефона:");
define("FS_SG_EMAIL_17","Адрес:");
define("FS_SG_EMAIL_18","Запланированное время:");
define("FS_SG_EMAIL_19","FS заказ ");
define("FS_SG_EMAIL_20"," Напоминание об установке");
define("FS_SG_EMAIL_21","Спасибо за выбор FS Сингапур. Мы заметили, что вы оставили неоплаченный заказ");
define("FS_SG_EMAIL_22"," с услугой установки на месте. Напоминание о том, что услуга была отменена.");
define("FS_SG_EMAIL_23","<a href=".zen_href_link('manage_orders')." style=\"color: #0070BC;text-decoration: none\" target=\"_blank\">Нажмите здесь</a>, чтобы завершить покупку, и вы можете выбрать новое удобное время для установки службы в Личный Кабинет.");
define ("FS_SG_EMAIL_24", "Ваш заказ FS");
define ("FS_SG_EMAIL_25", "отправлен");
define ("FS_SG_EMAIL_26", "Напоминание об установке");
define ("FS_SG_EMAIL_27", "Установка отменена");
define ("FS_SG_EMAIL_28", "Напоминание о платеже");
define ('FS_SHIPPING_SG_INSTALL_TIPS', 'Для этой доставки Вы можете выбрать предпочтительное время установки. Услуги по установке доступны только с FS Доставкой & Бесплатной установкой.');

define('FS_SG_DELIVERY_INSTALLATION', 'FS Доставка & Бесплатная установка');
define('FS_SG_NEXT_WORKING_DAY', 'FS Доставка на следующий рабочий день');
define('FS_SG_SAME_WORKING_DAY', 'FS Доставка в тот же рабочий день');
define ('FS_ACCOUNT_DETELE', 'Данный аккаунт был удален');
define('FS_SG_SIMPLYPOST_SHIPPING', 'SimplyPost 1-3 рабочих дня');

//rebirth 2019.10.17 订单超时,分钟,工作日的单复数处理
define('FS_ORDERS_OVERTIMES_30','минута');
define('FS_ORDERS_OVERTIMES_31','минуты');
define('FS_ORDERS_OVERTIMES_32','минут');
define('FS_ORDERS_OVERTIMES_33','рабочий день');
define('FS_ORDERS_OVERTIMES_34','рабочих дня');
define('FS_ORDERS_OVERTIMES_35','рабочих дней');

//liang.zhu 2019.10.31 product_support页面的service type, 同时也在my_case_details页面上使用
define('PRODUCT_SUPPORT_SERVICE_TYPE', 'Тип обслуживания');
define('PRODUCT_SUPPORT_SERVICE_TYPE_01', 'Поддержка использования товара');
define('PRODUCT_SUPPORT_SERVICE_TYPE_02', 'Поддержка связи ссылки');
define('PRODUCT_SUPPORT_SERVICE_TYPE_03', 'Поддержка установки и настройки');
define('PRODUCT_SUPPORT_SERVICE_TYPE_04', 'Другие');

//邀请评论
define("EMAIL_MESSAGE_TITTLE","Поделитесь опытом");
define("EMAIL_MESSAGE_01","Как мы сделали?");
define("EMAIL_MESSAGE_02","Оставьте свой отзыв");
define('EMAIL_MESSAGE_CONTENT', 'Мы будем рады, если вы поможете нам и другим клиентам через комментарий заказанных товаров <a style="color: #0070bc;text-decoration: none;" href="javascript:;">#ORDER_NUMBER</a>. Это займет всего минуту и действительно помогает другим. Нажмите на кнопку ниже, чтобы оставить свой комментарий!');
define('EMAIL_MESSAGE_SUBTITLE', 'Есть вопросы к вашему заказу?');
define('EMAIL_MESSAGE_SUB_CONTENT', 'Будь то техническая поддержка, вопросы гарантии или доставки, мы будем рады помочь вам. Посетите <a style="color: #0070bc;text-decoration: none;" href="javascript:;">Центр помощи</a> для получения быстрой и полезной помощи.');
define('EMAIL_TO_LICENSE_5','Узнать больше');
define('EMAIL_TO_LICENSE_6','У вас есть новый товар для отзыва на FS.COM');


//针对4，5星评论给客户发送第二封邮件
define('EMAIL_REVIEWS_FOUR_FIVE_01', 'Спасибо за поддержку');
define('EMAIL_REVIEWS_FOUR_FIVE_02', 'Большое спасибо за отзыв о вашем опыте на Trustpilot. Пожалуйста, также оцените FS.');
define('EMAIL_REVIEWS_FOUR_FIVE_03', 'Ваша оценка');
define('EMAIL_REVIEWS_FOUR_FIVE_04', 'Ваши комментарии (хорошие или плохие) будут немедленно опубликованы на Trustpilot.com, чтобы помочь другим принимать более обоснованные решения.');
define('EMAIL_REVIEWS_FOUR_FIVE_05', 'Спасибо за ваше внимание, и мы с нетерпением ждем встречи с вами снова! <br>Команда FS.');
define('EMAIL_REVIEWS_FOUR_FIVE_06', 'Оцените нас');
define('EMAIL_REVIEWS_FOUR_FIVE_07', 'Ваш опыт важен - спасибо за поделение');



//表达修改 by rebirth  2019/11/13
define('FS_TECHNICAL_SUPPORT','Техническая поддержка');
define('FS_REQUEST_SUPPORT','Запрос на поддержку');

//账户中心报价改版2019/11/20
define("FS_INQUIRY_LIST_1",'Статус запроса');
define("FS_INQUIRY_LIST_2",'Актуальные предложения');
define("FS_INQUIRY_LIST_3",'Связаться с обслуживанием Клиентов');
define("FS_INQUIRY_LIST_4",'Поиск предложения');
define("FS_INQUIRY_LIST_5",'КП #: ');
define("FS_INQUIRY_LIST_6",'Поиск');
define("FS_INQUIRY_LIST_7",'Дата запроса на КП:');
define("FS_INQUIRY_LIST_8",'Всего');
define("FS_INQUIRY_LIST_9",'Кол-во:');
define("FS_INQUIRY_LIST_10",'Смотреть больше');
define("FS_INQUIRY_LIST_11",'Срок действия данного КП до XX года.');
define("FS_INQUIRY_LIST_12",'Срок действия данного спецпредложения истек XX года.');
define("FS_INQUIRY_LIST_13",'ЗАПРОС НА КП НЕ НАЙДЕН.');
define("FS_INQUIRY_LIST_14",'Начать покупки');
define("FS_INQUIRY_LIST_15",'Если вы не можете найти свой запрос на КП, попробуйте выбрать другие условия фильтра.');
define("FS_INQUIRY_LIST_16",'Детали предложения');
define("FS_INQUIRY_LIST_17",'Название запроса:');
define("FS_INQUIRY_LIST_18",'Запросить на КП снова');
define("FS_INQUIRY_LIST_19",'Добавить в корзину');
define("FS_INQUIRY_LIST_20",'Распечатать КП');
define("FS_INQUIRY_LIST_21",'ЗАПРОС НА КП');
define("FS_INQUIRY_LIST_22",'Товар');
define("FS_INQUIRY_LIST_23",'Цена товара');
define("FS_INQUIRY_LIST_24",'Количество');
define("FS_INQUIRY_LIST_25",'Цена запроса');
define("FS_INQUIRY_LIST_26",'ID клиента:');
define("FS_INQUIRY_LIST_28",'Номер телефона #:');
define("FS_INQUIRY_LIST_29",'Общая сумма запроса:');
define("FS_INQUIRY_LIST_30",'Ниже приведен Запрос КП, который вы отправили, ваш менеджер ответит вам в течение 24 часов.');
define("FS_INQUIRY_LIST_31",'Запрос на КП находится на рассмотрении вашего менеджера, вы получите ответ в течение 24 часов.');
define("FS_INQUIRY_LIST_30_1",'Запрос на КП находится на рассмотрении, Вы получите ответ в течение 24 часов.');
define("FS_INQUIRY_LIST_32",'Ниже детали вашего запроса на КП. Срок действия данного спецпредложения составляет 15 дней.');
define("FS_INQUIRY_LIST_33",'Срок действия данного КП истек ');
define("FS_INQUIRY_LIST_34",'года. При необходимости вы можете запросить КП снова.');

define("FS_INQUIRY_LIST_35",'КП #');
define("FS_INQUIRY_LIST_36",'Дата Запроса КП:');
define("FS_INQUIRY_LIST_37",'Запрос на КП #:');
define("FS_INQUIRY_LIST_38",'Товар: #');
define("FS_INQUIRY_LIST_38_1",'Товар #: ');
define("FS_INQUIRY_LIST_39",'Ниже указано КП, которое Вы запросили.');
define("FS_INQUIRY_LIST_40",'ССЫЛКА');
define("FS_INQUIRY_LIST_41",'Распечатать страницу');
define("FS_INQUIRY_LIST_42",'Дата запроса:');
// manage address
define("FS_CREATE_NEW_ADDRESS", 'Создать новый адрес');
define("FS_DEFAULT", 'Умолчание');
define("FS_SAVE_ADDRESSES", 'Сохраненные адреса');
define("FS_EDIT_REMOVE", 'Редактировать/Удалить');
define("FS_EDIT", 'Редактировать');
define("FS_REMOVE", 'Удалить');
define("FS_NO_SHIPPING_ADDRESS_HISTORY", 'НЕТ ИСТОРИИ АДРЕСОВ ДОСТАВКИ.');
define("FS_NO_BILLING_ADDRESS_HISTORY", 'НЕТ ИСТОРИИ ПЛАТЕЖНОГО АДРЕСА.');

//2019.11.22 ery  add 账户中心订单产品加购提示语
define('FS_MANAGE_CUSTOM_TIP', 'Этот продукт является заказным товаром, перейдите на страницу сведений о продукте, чтобы выбрать.');
define('FS_MANAGE_CLOSE_TIP', 'Этот продукт больше не доступен онлайн. Свяжитесь с вашим менеджером для проверки, или вы можете посмотреть аналогичный продукт онлайн. ');

/**
 * by  rebirth   账户中心改版——my_credit页面
 */
define('FS_NEW_ACCOUNT_MY_CREDIT_01','Ваш статус');
define('FS_NEW_ACCOUNT_MY_CREDIT_02','');
define('FS_NEW_ACCOUNT_MY_CREDIT_03','Текущий баланс');
define('FS_NEW_ACCOUNT_MY_CREDIT_04','Общий кредитный лимит');
define('FS_NEW_ACCOUNT_MY_CREDIT_05','Запрос на увеличение кредитного лимита');
define('FS_NEW_ACCOUNT_MY_CREDIT_06','Поиск заказа');
define('FS_NEW_ACCOUNT_MY_CREDIT_07','PO #, Заказ #');
define('FS_NEW_ACCOUNT_MY_CREDIT_08','Дата');
define('FS_NEW_ACCOUNT_MY_CREDIT_09','ИСТОРИИ ПОКУПКИ НЕТ.');
define('FS_NEW_ACCOUNT_MY_CREDIT_10','Начать покупки ');
define('FS_NEW_ACCOUNT_MY_CREDIT_11','НИКАКОЙ ПОКУПКИ НЕ НАЙДЕН.');
define('FS_NEW_ACCOUNT_MY_CREDIT_12', 'Найти');

// 账户中心首页
define("FS_ACCOUNT_ADMINISTRATOR",'Администратор аккаунта:');
define("FS_ACCOUNT_NEW",'Аккаунт #:');
define("FS_NAME",'Имя');
define("FS_ACCOUNT_MANAGE_CONTACT",'Контакт менеджера по работе с клиентами:');
define("FS_ACCOUNT_PHONE",'Номер:');
define("FS_ACCOUNT_ORDERS_PENDING",'В ожидании платежа');
define("FS_ACCOUNT_ORDERS_PROGRESSING",'В обработке');
define("FS_ACCOUNT_ORDERS_COMPLETED",'Выполненные');
define("FS_ACCOUNT_ORDERS_ACTIVE_QUOTE",'Актуальный запрос');
define("FS_ACCOUNT_ORDERS_RMA",'RMA');
define("FS_ACCOUNT_ORDERS",'ЗАКАЗЫ');
define("FS_ACCOUNT_VIEW_TRACK_ORDERS",'Просмотр и отслеживание последних заказов');
define("FS_ACCOUNT_HISTORY",'История заказов');
define("FS_ACCOUNT_NEW_QUOTE_REQUEST",'Новый запрос');
define("FS_ACCOUNT_QUOTE_STATUS",'Статус / История запросов на КП');
define("FS_ACCOUNT_NEW_RMA_REQUEST",'Новый запрос на RMA');
define("FS_ACCOUNT_RMA_STATUS",'Статус / История RMA');
define("FS_ACCOUNT_REVIEW_PURCHASES",'Проверьте свои покупки');
define("FS_ACCOUNT_QUOTE_STATUS_TRACKING",'Проверьте статус, отслеживание истории заказа.');
define("FS_ACCOUNT_VIEW_ORDERS",'Посмотреть заказы');
define("FS_ACCOUNT_SEARCH_ORDERS",'Поиск заказов:');
define("FS_ACCOUNT_PO_ORDER_ID",'PO #, Заказ #, ID товара');
define("FS_ACCOUNT_SEARCH",'Поиск');
define("FS_ACCOUNT_NET_TERMS",'КРЕДИТНЫЙ АККАУНТ');
define("FS_ACCOUNT_BUY_NOW_PAY_LATER",'Купить сейчас, заплатить позже');
define("FS_ACCOUNT_CURRENT_BALANCE",'Текущий баланс');
define("FS_ACCOUNT_VIEW_CREDIT_DETAILS",'Ваша кредитная информация');
define("FS_ACCOUNT_NACCOUNT_SETTINGS",'НАСТРОЙКИ АККАУНТА');
define("FS_ACCOUNT_PASSWORD_MAIL",'Пароль и почта');
define("FS_ACCOUNT_USER_PHOTO",'Фотография пользователя');
define("FS_ACCOUNT_USER_NAME",'Имя пользователя');
define("FS_ACCOUNT_EMAIL_ADDRESS",'Адрес электронной почты');
define("FS_ACCOUNT_EMAIL_PASSWORD",'Пароль');
define("FS_ACCOUNT_EMAIL_PREFERENCES",'Настройки подписки по электронной почте');
define("FS_ACCOUNT_SHOPPING_TOOLS",'ПОЛЕЗНЫЕ ИНСТРУМЕНТЫ');
define("FS_ACCOUNT_USEFUL_SHOPPING",'Поддержка и обратная связь');
define("FS_ACCOUNT_REQUEST_SAMPLE",'Запросить образец');
define("FS_ACCOUNT_WRITE_REVIEW",'Написать отзыв о FS');
define("FS_ACCOUNT_USER_INFORMATION",'ИНФОРМАЦИЯ ПОЛЬЗОВАТЕЛЯ');
define("FS_ACCOUNT_CASES_AND_ADDRESSES",'Вопросы и адреса');
define("FS_ACCOUNT_ADDRESS_BOOK",'Адрес доставки');
define("FS_ACCOUNT_CASE_CENTER",'Центр вопроса');
define("FS_ACCOUNT_TAX_EXEMPTION",'FS.COM INC charges tax on orders shipping to a number of states where FS is required to collect tax. If you are a  tax-exemption organization, you may click "<a class="alone_a" href="'.zen_href_link('tax_exemption','','SSL').'">Apply for Tax Exemption</a>" for tax exempted.');

define ( "FS_ACCOUNT_CASE_E_MAIL", 'Электронная почта:');
define ("FS_CREATE_SHIPPING_ADDRESS", "Добавить новый адрес доставки");
define ("FS_CREATE_BILLING_ADDRESS", "Добавить новый платёжный адрес");
define ("FS_EDIT_SHIPPING_ADDRESS", "Редактировать адрес доставки");
define ("FS_EDIT_BILLING_ADDRESS", "Редактировать платежный адрес");
define ( "FS_CONFIRMATION", 'Подтверждение');
define ("FS_DELETE_THIS_ADDRESS", "Удалить этот адрес?");
define ("FS_SAVED_ADDRESSES", "Сохраненные адреса");
define ("FS_SAVE_AS_DEFAULT", "Сохранить по умолчанию");

define('FS_SALES_INFO_MODAL_TITLE','Добавить Новый Адрес');
define('FS_SALES_INFO_MODAL_FNAME','Имя');
define('FS_SALES_INFO_MODAL_LNAME','Фамилия');
define('FS_SALES_INFO_MODAL_COUNTRY','Страна/Регион');
define('FS_SALES_INFO_MODAL_ADS_TYPE','Тип Адреса');
define('FS_SALES_INFO_MODAL_COMPANT','Название Компании');
define('FS_SALES_INFO_MODAL_VAT','НОМЕР VAT/TAX');
define('FS_SALES_INFO_MODAL_ADS1','Адрес');
define('FS_SALES_INFO_MODAL_ADS2','Адрес 2');
define('FS_SALES_INFO_MODAL_CITY','Город/Место');
define('FS_SALES_INFO_MODAL_SPR','Государство/Провинция/Регион');
define('FS_SALES_INFO_MODAL_STATE','Пожалуйста, выберите штат');
define('FS_SALES_INFO_MODAL_ZIP_CODE_NEW','Почтовый Индекс');
define('FS_SALES_INFO_MODAL_PHONE_NUM','Номер Телефона');
define('FS_SALES_INFO_MODAL_BTN_CANCEL','Отменить');
define('FS_SALES_INFO_MODAL_BTN_SAVE','Сохранить');
define('FS_SALES_INFO_MODAL_ADS1_HOLDER','Улица');
define('FS_SALES_INFO_MODAL_ADS2_HOLDER','Дом, строение, корпус и так далее.');

define('FS_SALES_DETILS_TYPE1','Возврат сумм');
define('FS_SALES_DETILS_TYPE2','Замена');
define('FS_SALES_DETILS_TYPE3','Ремонт');
define('FS_RMA_NAVI1','Подтверждение RMA');
define('FS_RMA_NAVI2','История RMA');
define('FS_RMA_NAVI3','Подробности RMA');
define('FS_RMA_NAVI4','RMA');
define('FS_RMA_NAVI5','Новый запрос RMA');
define ('FS_RMA_DETAILS_NAVI1', 'Детали обмена');
define ('FS_RMA_DETAILS_NAVI2', 'Детали обмена');
define ('FS_RMA_DETAILS_NAVI3', 'Детали ремонта');

//2019.11.26 再次付款页面提示语
define('FS_CHECKOUT_AGAINST_TRANSFER_PLEASE', 'Пожалуйста, перейдите на следующий аккаунт.');


define('FS_RMA_SEARCH_TIPS','Все RMA');

define("FS_ACCOUNT_REQUEST_A_SAMPLE",'Получить товар на тестирование');
define("FS_ACCOUNT_USEFUL_TOOLS",'ПОЛЕЗНЫЕ ИНСТРУМЕНТЫ');
define("FS_ACCOUNT_SUPPORT_FEEDBACK",'Поддержка и обратная связь');
define("FS_ACCOUNT_CANCEL",'Удалить');
define("FS_ACCOUNT_SHIPPING_ADDRESS",'АДРЕСА ДОСТАВКИ');
define("FS_ACCOUNT_BILLING_ADDRESS",'ПЛАТЁЖНЫЕ АДРЕСА');
define('ACCOUNT_MY_HOME','Главная');
define("FS_REVIEW_PURCHASE_10",'Заказ #, ID товара #');

define('FS_INDEX_FPE_TITLE', 'Хит продаж');
define('FS_INDEX_ETN_TITLE', 'Рассматривать сеть');
define('FS_INDEX_SERVICE_TITLE', 'Услуги');
define('FS_ACCOUNT_TITLE','Статус заказа');
define('FS_ACCOUNT_BTN','Посмотреть заказы');
define('FS_ACCOUNT_CONTENT','Отслеживайте свой заказ, чтобы получить последний статус посылки и примерное время доставки.');
define('FS_ACCOUNT_TITLE_REGISTER','Создать аккаунт');

define('FIBER_SPARKASSE_BANK_NAME','Название Банка:');

//订单详情
define('FS_PRINT_QTY','Кол-во');
define('FS_PRINT_UNIT_PRICE','Цена');
define('FS_PRINT_TOTAL','Сумма');
define('FS_PRINT_SHIPMENT','Отгрузка');
define('FS_PRINT_SUBTOTAL','Итого:');
define('FS_PRINT_SHIPPING_COST','Стоимость доставки:');
define('FS_PRINT_SHIPPING_TAX','В том числе НДС:');
define('FS_PRINT_TOTAL_WIDTH_COLON','Всего к оплате:');

//税后价公用语言包 add dylan 2020.5.13
define ('FS_BLANKET_32', 'Стоимость доставки');
define ('FS_BLANKET_33', 'Стоимость GST');
define('FS_BLANKET_34','Итого');
define('FS_BLANKET_35','Включая GST');

define('FS_PRINT_ITEM','Товар');

define('ACCOUNT_EDIT_CITY_FROMAT_TIP','Ваш город должен быть длиной не менее 2 символов.');
define('ACCOUNT_EDIT_SUBCITY_FROMAT_TIP','Ваша адресная строка 2 должна быть длиной не менее 2 символов.');

//报价相关
define('INQUIRY_QUOTE_LIST_1','Посмотреть запрос');
define('INQUIRY_QUOTE_LIST_2','История запросов');

define('FS_CHECKOUT_ERROR_VAT','Bведите действительный номер НДС. например: $VAT');
define ('FS_CHECKOUT_POPUP_TIPS', 'Вы хотите вернуться в корзину?');
define ('FS_CHECKOUT_POPUP_TIPS_QUOTE', 'Вы уверены, что хотите вернуться к своему предложению?');
define ('FS_CHECKOUT_POPUP_BUTTON1', 'Оформить заказ');
define ('FS_CHECKOUT_POPUP_BUTTON2', 'к корзине');
DEFINE ( 'FS_CHECKOUT_PAYMENT', 'Заплатить');
define('FS_CHECKOUT_PAYMENT_PO','Загрузить PO');


// MUX流程轴节点
define('FS_ORDER_CUSTOMIZED','Hастроенный');
define('FS_ORDER_MANUFACTURING','Производство');
define('FS_ORDER_TEST_PASS','Проходит тест');
define('FS_ORDER_SHIPPED','Отправлен');
define('FS_ORDER_TEST_REPORT','Протокол Испытаний');
//报价语言包
define('INQUIRY_LISTS_1','Все предложения');
define('INQUIRY_LISTS_2','Актуальный');
define('INQUIRY_LISTS_3','Купленный');
define('INQUIRY_LISTS_4','КП был создан для оформления заказа.');
define('INQUIRY_LISTS_5','ССЫЛКА');
define('INQUIRY_LISTS_6','Детали запроса');
define('FS_INQUIRY_INFO_66_1','Запрос на КП истек ');
define('FS_INQUIRY_INFO_66_6','Запрос на КП истек ');
define('FS_INQUIRY_INFO_66_2',' Вы можете запросить на КП снова, если нужно.');
define('FS_INQUIRY_INFO_66_3','Срок действия этого запроса истек ');
define('FS_INQUIRY_INFO_66_7','Срок действия этого запроса истек ');
define('FS_INQUIRY_INFO_66_4','Запрос действителен до ');
define("FS_INQUIRY_LIST_27",'Менеджер по продажам:');
define('FS_INQUIRY_INFO_66_5','Вы можете оформить заказ сразу после получения КП от своего менеджера.');
define('FS_QUOTE','Предложение');
define('INQUIRY_LISTS_7','Весь период');
define('INQUIRY_LISTS_8','История предложений');
define('INQUIRY_LISTS_9','История запросов');
define('INQUIRY_LISTS_10','Запрос КП');
define('INQUIRY_LISTS_11',' Коммерческое предложение');



define('FS_PRODUCTS_INFO_NOTE_TITLE','Внимание: ');
define('FS_PRODUCTS_INFO_NOTE_TIPS','Coherent CFP Модуль не продается отдельно.');


/**
 *   po 暂停授信提示语 add by rebirth  2020/01.07
 */
define('FS_PO_FORZEN_NOTICE_01','Ваш кредитный аккаунт находится в состоянии "Приостановка Кредита" и оплата отсрочки платежа недоступна. <a href="'.zen_href_link('manage_orders','','SSL').'" target="_blank">Оплатите неоплаченные счета</a> или выберите другие способы оплаты.');
define('FS_PO_FORZEN_NOTICE_02','Ваш кредитный аккаунт находится в состоянии "Приостановка Кредита". Узнайте больше на странице Подробностей Кредита.');

define('FS_PO_FORZEN_NOTICE_03','Ваш кредитный аккаунт находится в состоянии "Приостановка Кредита" и оплата отсрочки платежа недоступна. <a href="'.zen_href_link('manage_orders','','SSL').'" >Оплатите неоплаченные счета</a> или свяжитесь с менеджером своего аккаунта для получения более подробной информации.');

define("FS_ACCOUNT_RMA_ORDERS",'Статус возврата');
define("FS_ACCOUNT_PO_NUMBER",'PO #');
define("FS_ACCOUNT_REQUEST_RMA",'Оформление возврата');
define("FS_ACCOUNT_RMA_HISTORY",'История RMA');
define("FS_ACCOUNT_PO_ORDER",'Разместить/Просмотреть заказ PO');
define("FS_ACCOUNT_REVIEW_YOUR_ORDER",'Оставить отзыв');
define("FS_ACCOUNT_QUOTES",'ЗАПРОСЫ НА КП');
define("FS_ACCOUNT_QUICK_QUOTE",'Быстрый запрос и просмотр статуса');
define("FS_ACCOUNT_ACTIVE",'Актуальные предложения');
define("FS_ACCOUNT_QUOTE_HISTORY",'История предложений');
define("FS_ACCOUNT_REQUEST_QUOTE",'Запрос на КП');
define("FS_ACCOUNT_ORDER_PENDING",'К оплате ');
define("FS_ACCOUNT_ORDER_PROGRESSING",'В обработке');
define("FS_ACCOUNT_ORDER_COMMENTS",'Комментарии:');
define ('INQUIRY_LISTS_12', 'Истек срок действия: ');
define ('INQUIRY_LISTS_13', 'Создано: ');
define ('INQUIRY_LISTS_14', 'Менеджер по аккаунту:');
//support
define("SUPPORT_PAGE","Добро пожаловать в службу поддержки клиентов FS. Чем мы можем помочь?");
define("SUPPORT_PAGE_1","Немедленная помощь");
define("SUPPORT_PAGE_2","Чат Сейчас ");
define("SUPPORT_PAGE_3","Центр загрузки");
define("SUPPORT_PAGE_4","Подробнее");
define("SUPPORT_PAGE_5","Запрос на техподдержку");
define("SUPPORT_PAGE_6","Запрос на цену");
define("SUPPORT_PAGE_7","Практические Примеры");
define("SUPPORT_PAGE_8","Поддержка видео");
define("SUPPORT_PAGE_9","Сообщество");
define("SUPPORT_PAGE_10","Больше ресурсов поддержки");
define("SUPPORT_PAGE_11","Возврат сумм");
define("SUPPORT_PAGE_12","Отслеживание посылок");
define("SUPPORT_PAGE_13","Получить товар на тестирование");
define("SUPPORT_PAGE_14","Центр помощи");
define('FS_SUPPORT','Поддержка');

define('FS_SEND_EMAIL_PAYMENT',"Запрос на оплату");

define('FS_BY_CLICKING','По клику \'Отправить Заказ\', вы соглашаетесь с нашим');
define('FS_TERMS_AND_CONDITIONS','Условия использования');
define('FS_PRIVACY_AND_COOKIES','  Конфиденциальность и Cookies');
define('FS_AND_RIGHT_OF_WITHDRAWL','и правом на снятие средств.');
define("FS_ZIP_CODE_EU","Почтовый Индекс");
define("FS_ADDRESS_EU","Адрес, Первая Строка");
define("FS_ADDRESS2_EU","Адрес, Вторая Строка");
define('ACCOUNT_EDIT_CITY_EU','Город');

//feedback select 2020-03-02 jay
define('FS_GIVE_FEEDBACK_TIP_1','Благодарим за обращение к FS. Для получения немедленной помощи, пожалуйста, свяжитесь с нами через');
define('FS_GIVE_FEEDBACK_TIP_2','FS Поддержка');//链接
define('FS_GIVE_FEEDBACK_TIP_3','или');
define('FS_GIVE_FEEDBACK_TIP_4','Онлайн чат');//链接
define('FS_GIVE_FEEDBACK_TIP_5','');
define('FS_FEEDBACK_SELECT_1', 'Дизайн сайта');
define('FS_FEEDBACK_SELECT_2', 'Поиск и навигация');
define('FS_FEEDBACK_SELECT_3', 'Товар');
define('FS_FEEDBACK_SELECT_4', 'Оформление заказа и оплата');
define('FS_FEEDBACK_SELECT_5', 'Доставка');
define('FS_FEEDBACK_SELECT_6', 'Возврат и обмен');
define('FS_FEEDBACK_SELECT_7', 'Сервис и поддержка');
define('FS_FEEDBACK_SELECT_8', 'Предложение к сайту');
define ('FS_AND', 'и');
define ('FS_RIGHT_OF_WITHDRAWL', 'Право заимствования');
define('FS_RIGHT_OF_WITHDRAWL_01','');
define('FS_CHECKOUT_ERROR3_EU','Введите адрес, первую строку');
define ('INQUIRY_LISTS_15', 'История КП');


// 2020-03-16  e-rate   rebirth
define('FS_ERate_01','E-rate');
define('FS_ERate_02','E-rate for Education & Learning');
define('FS_ERate_03','Server Room');
define('FS_ERate_04','Classroom');
define('FS_ERate_05','Lecture Hall');
define('FS_ERate_06','Laboratory');
define('FS_ERate_07','Contact an EDU specialist today');
define('FS_ERate_08','Mon - Fri, 9:00am-5:00pm EST');
define('FS_ERate_09','+1 (888) 468 7419');
define('FS_ERate_10','E-rate Discounts');
define('FS_ERate_11','Take advantage of E-rate funding to receive discounts on networking equipment. Most public, private, and charter schools & libraries qualify. We proudly serve teachers, principals, and IT support staff by sourcing the best technology solutions for classrooms—at every level of education.');
define('FS_ERate_12','FS SPIN (Form 498 ID): 143051712');
define('FS_ERate_13','Get Started for E-rate');
define('FS_ERate_14','Leave your contact or call us for assistant');
define('FS_ERate_15','Please enter your email address.');
define('FS_ERate_16','Please enter a valid email address.');
define('FS_ERate_17','Thank you. We will get in touch with you ASAP.');
define('FS_ERate_18','10G DWDM Interconnections Over 120km in Campus Network');
define('FS_ERate_19','FS FMU DWDM and FMT series enable good quality transmission over long distance in a simple way.');
define('FS_ERate_20','Показать всё');
define('FS_ERate_21','Sir/Madam');
define('FS_ERate_22','We\'ve received your E-Rate request and will get in touch with you soon. Here is your case number $CNxxxxxxx, you can refer to this number in all follow-up communications regarding this request.');
define('FS_ERate_23','FS - We received your E-Rate request ');
define('FS_ERate_24','Featured Case');
define('FS_ERate_25','Laboratory');
define('FS_ERate_26','Your Email Address');
define('FS_ERate_27','E-rate for Education ');
define('FS_ERate_28','E-rate Support');
define('FS_ERate_29','Receive discounts with E-rate funding');

define('CART_SHIPPING_METHOD_CHECKOUT_PRE', 'Доставка:');
define('CART_SHIPPING_METHOD_CHECKOUT_TEXT', 'Рассчитано при оплате');
define('FS_COMMON_GSP_1','Оотправить со склада CN FS');
define('FS_COMMON_GSP_2','Импортные пошлины ');
define('FS_COMMON_GSP_3','включена');
define('FS_COMMON_GSP_4','Импортная пошлина включена в покупку, а также таможенне оформление, выполняемые FS.');
define('FS_COMMON_5','Закрывать');


define("FS_SHOP_CART_LIST_SUB", "Итого");

//详情页定制弹窗文字 2020.3.19  ery
define('FS_DETAIL_CUSTOM_1', 'Заказано');
define('FS_DETAIL_CUSTOM_2', 'Изготовлено');
define('FS_DETAIL_CUSTOM_3', 'Отправлено');
define('FS_DETAIL_CUSTOM_4', 'Доставлено');
define('FS_DETAIL_CUSTOM_5', 'Ориентировочный срок изготовления: ');
define('FS_DETAIL_CUSTOM_6', 'Ориентировочное время отправки: ');
define('FS_DETAIL_CUSTOM_7', 'Ориентировочное время доставки: ');

//GSP库存展示相关文字 2020.0.20 ery
define('FS_GSP_STOCK_1', 'Customized');
define('FS_GSP_STOCK_2', 'Международные продукты');
define('FS_GSP_STOCK_3', 'ship from ');
define('FS_GSP_STOCK_4', 'FS Asia');
define('FS_GSP_STOCK_5', 'Import Fees Deposit');
define('FS_GSP_STOCK_6', 'included');
define ('FS_GSP_STOCK_7', 'Товар будет отправлен с глобального азиатского склада через <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'"> Глобальную программу доставки (GSP) </a>. Импортные пошлины при покупке и таможенное оформление, обрабатываются FS. <a target = "_ blank" href = "'. reset_url('/specials/global-shipping-program-107.html').'"> Узнайте больше</a> ');
define('FS_GSP_STOCK_8', 'Close');
define ('FS_GSP_STOCK_9', 'Данный товар будет отправлен с Глобального азиатского склада через <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'"> Глобальную программу доставки (GSP) </a>. Импортные пошлины, включенные при покупке и таможенное оформление обрабатываются FS. Налог с продаж будет включен при оформлении заказа. <a target = "_ blank" href = "'. Reset_url ('/specials/global-shipping-program-107.html').'">Узнайте больше</a> ');
define('FS_AVAILABLE', 'Доступны');
define('FS_LOACAL_EMPTY_INSTOCK_SHOW','Товар будет отправлен с глобального склада Азии. ');

define('FS_OUTBREAK_NOTICE', 'Мы здесь, чтобы помочь Вам - письмо о COVID-19 от FS');
define('FS_OUTBREAK_NOTICE_M', 'Письмо о коронавирусе COVID-19 от FS');
define('FS_OUTBREAK_READ_MORE', 'Подробнее');



//subtotal(有税收的带上税收)
define('FS_SHOP_CART_SUBTOTAL','Итого:');
define ('FS_SHOP_CART_EXCL_VAT', 'НДС ($VAT)');
define ('FS_SHOP_CART_EXCL_SG_VAT', 'GST (7%)');
define ('FS_SHOP_CART_EXCL_AU_VAT', 'GST Австралии (10%)');
define ('FS_SHOP_CART_EXCL_DE_VAT', 'НДС Германии ($VAT)');

//详情页交期提示语
define('FS_GSP_LOCAL_STOCK_DELIVERY_TIPS','Дата доставки применяется к товарам в наличии, купленным до 17：00 EST в рабочие дни. После этого ваш заказ будет отправлен на следующий рабочий день.Если запрашиваемое количество превышает запас, товары будут отправлены со склада FS Азии согласно <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'"> Глобальную программу доставки (GSP)</a>.');
define ('FS_GSP_COVID_TIPS', 'Доставка может быть задержана из-за распространения коронавируса COVID-19. Для получения подробной информации об отслеживании товаров, обратитесь к <a href = "'. reset_url ('/ login.html'). '" target="_blank">моему аккаунту</a>.');

define('PRODUCTS_WARRANTY','Модулей');
define('PRODUCTS_WARRANTY_1','Профессиональная ');
define('PRODUCTS_WARRANTY_2','программа тестирования');
define('PRODUCTS_WARRANTY_3',' качества для теста ');
define('PRODUCTS_WARRANTY_4','Доставка');
define('PRODUCTS_WARRANTY_5','WARRANTY_YEARS Летняя гарантия');
define('PRODUCTS_WARRANTY_5_1','WARRANTY_YEARS Летняя гарантия');
define('PRODUCTS_WARRANTY_6','Пожизненная гарантия');
define('PRODUCTS_WARRANTY_7','Бесплатный возврат');

//打印发票 VAT No 本地化
define ('FS_VAT_NO_EU', 'Номер НДС: ');
define ('FS_VAT_NO_AU', 'ABN: ');
define ('FS_VAT_NO_SG', 'GST Регист. номер: ');
define ('FS_VAT_NO_BR', 'CNPJ: ');
define ('FS_VAT_NO_CL', 'RUT: ');
define ('FS_VAT_NO_AR', 'CUIT:');
define ('FS_VAT_NO_DEFAULT', 'ИНН: ');

//购物车saved_items、saved_cart_details
define ('FS_SAVED_CARTS', 'Сохраненные корзины');
define ('FS_ALL_SAVED_CARTS', 'Все сохраненные корзины');
define ('FS_ADD_ALL_TO_CARTS', 'Добавить все в корзину');
define ( 'FS_GO', 'Идти');
define ( 'FS_SHOW_CART', 'Показать');
define ( 'FS_SEARCH', 'поиск');
define ('FS_CART_NAME', 'Название корзины');
define ('FS_SEARCH_SAVED_CARTS', 'Поиск сохраненных товаров');
define ('FS_DATE_SAVED', 'Дата создания');
define ('FS_CUSTOMER_ID', ' ID клиента');
define ('FS_ACCOUNT_MANAGER', 'Менеджер по аккаунту');
define ( 'FS_PHONE', 'Телефон #');
define ( 'FS_SUBTOTAL', 'Итого');
define ('FS_VIEW_SHIPPING_CART', 'Просмотреть Сохраненные Товары');
define ('FS_SAVE_CART_CONDITIONS', 'Если вы не можете найти свою корзину, попробуйте выбрать другие условия фильтра.');
define ('FS_NO_SAVED_CART_FOUND', 'СОХРАНЕННОЙ КОРЗИНЫ НЕ НАЙДЕНА.');
define ('FS_CRET_REFERENCE', 'ССЫЛКА НА КОРЗИНУ');
define ('FS_CART_DELETE', 'Удалить');
define ('FS_CART_NEW_ITEMS', 'Новый товар(ы) был добавлен в ваш');
define ('FS_CART_SUCCESSFULLY_UPDATED', 'Ваша корзина была успешно обновлена');
define ('FS_CART_SAVED_CART_NAME', 'Название сохраненной корзины');
define ('FS_CART_NEW_CART_CREATE', 'Новая корзина была создана.');
define ('FS_CART_HAS_BEEN_ADD', 'был добавлен в ваши сохраненные корзины.');
define ('FS_CART_NAME_ALREADY_EXISTED', 'Это название уже существует. Пожалуйста, используйте другое название.');
define ('FS_ADD_TO_SAVED_CART', 'Добавить');
define ('FS_SAVE_CART_SELECT', 'Выбрать сохраненную корзину');
define ('FS_ADD_THE_ITEMS', 'Или добавить товар (ы) в существующую сохраненную корзину.');
define ('FS_NAME_YOUR_SAVED_CART', 'Назовите сохраненную корзину');
define ('FS_ADD_TO_CART', 'Добавить в корзину');
define ('FS_EMIAL_YOUR_CART', 'Отправить корзину по эл. почте');
define ('FS_PRINT_THIS_PAGE', 'Распечатать эту страницу');
define ('FS_SAVED_CART_DETAILS', 'Детали сохраненной корзины');
define ('FS_BELOW_IS_THE_CART', 'Ниже приведены детали корзины, которые вы сохранили.');
define ('FS_CART_CONTACT_CUSTOMER_SERVICE', 'Связаться со службой поддержки');
define ('FS_UPDATED_SUCCESSFULLY', 'Ваша корзина была успешно обновлена.');
define ('FS_NEW_ITEM_CART', 'Новый товар (ы) был добавлен в вашу Сохраненную Корзину');
define ('FS_CART_ALL_ITEMS', 'Все товары в этой корзине больше недоступны для покупки, свяжитесь со своим менеджером по аккаунту для доступности, пожалуйста.');
define ('FS_CART_SOME_CUSTOMIZED', 'Некоторые заказные товары в этой корзине были изменены, перейдите на страницу деталей товаров, чтобы выбрать атрибуты.');
define ('FS_CART_ALL_CUSTOMEIZED_ITEMS', 'Все товары в этой корзине были изменены, перейдите на страницу деталей товаров, чтобы выбрать атрибуты.');
define ('FS_CART_THE_QUANTITY', 'Указанное вами количество превышает доступный запас и было скорректировано соответственно, обратитесь к менеджеру своего аккаунта за дополнительным количеством.');
define ('FS_CART_SHOPPING_CART_DIRECTLY', 'Товары в этой корзине больше недоступны для покупки онлайн, свяжитесь с менеджером своего аккаунта для доступности, пожалуйста. В то же время, доступные товары были перемещены в корзину покупок напрямую.');
define ('FS_CART_QUANTITY_ADDITIONAL', 'Указанное вами количество превышает доступный запас и было скорректировано соответственно, обратитесь к менеджеру своего аккаунта для получения дополнительного количества.');
define ('FS_CART_CUSTOMIZED_SHOPPING_CART', 'Зказные товары в этой корзине были изменены, перейдите на страницу деталей товаров, чтобы выбрать атрибуты. В то же время, доступные товары были перемещены в корзину покупок напрямую.');
define('FS_SAVE_CSRT_LIMIT_TIP_CART','Название сохраненной корзины не более 150 символов.');
define('FS_FROM','От');
define('FS_TO_EMAIL','До');
define ('FS_SELECT_SAVE_CART', 'Выберите корзину, пожалуйста.');


define('DHL_EXPRESS_WORLDWIDE_1_2_BUSINESS_DAY', 'DHL Express Worldwide® 1-2 Business Day Service');
define('UPS_NEXT_DAY_AIR_EARLY', 'UPS Next Day-Early® service');
define('FS_SERVICE_WORD', '');

// add by rebirth  2020.04.09  下单付款邮件优化
define('FS_EMAIL_OPTIMIZE_01', 'Оплатить');
define('FS_EMAIL_OPTIMIZE_02', 'Внимание: если вы уже заплатили, игнорируйте это письмо, пожалуйста. Спасибо.');
define('FS_EMAIL_OPTIMIZE_03', 'Мы здесь!');
define('FS_EMAIL_OPTIMIZE_04', 'Подробная информация о вашем заказе #ORDER_NUMBER приведена ниже. Мы вышлем вам информацию об отслеживании, как только будет получено любое обновление вашего заказа.');
define('FS_EMAIL_OPTIMIZE_05', 'Посмотреть заказ');
define('FS_EMAIL_OPTIMIZE_06', 'Внимание: если вы уже загрузили PO, игнорируйте это письмо, пожалуйста. Спасибо.');
define('FS_EMAIL_OPTIMIZE_07', 'Спасибо за ваш заказ');
define('FS_EMAIL_OPTIMIZE_08', 'Завершите оплату в течение 7 рабочих дней, пожалуйста. В противном случае заказ будет отменен из-за изменений в инвентаре товара. После того как оплата будет завершена, вы получите уведомление о том, что заказ был подтвержден.');
define('FS_EMAIL_OPTIMIZE_09', 'Инструкция по оплате');
define('FS_EMAIL_OPTIMIZE_10', 'После успешного перевода денежных средств, отправьте платежное поручение по почте $FS_EMAIL или своему менеджеру. Это поможет подготовить ваш заказ с приоритетом и избежать отмены заказа. Пожалуйста, отправьте ваш платеж на счет ниже.');
define('FS_EMAIL_OPTIMIZE_11', 'Внимание: Оставьте свой номер заказа $ORDER_NUMBER и адрес электронной почты в напоминании о банковском переводе, пожалуйста.');
define('FS_EMAIL_OPTIMIZE_12', 'Политика Доставки');
define('FS_EMAIL_OPTIMIZE_13', 'Расчетное время доставки не начинается, пока мы не получим ваш платеж');
define('FS_EMAIL_OPTIMIZE_14', 'Ваш заказ будет доставлен с 9:00 до 17:00 с понедельника по пятницу (исключая праздничные дни). Кто-то должен будет быть по указанному адресу, чтобы принять и подписать для доставки.');

define('FS_SELECT_SAVE_CART', 'Выберите корзину, пожалуйста.');
define('FS_PLEASE_CHECK_THE_URL', 'Проверьте URL или перейдите к');
define( 'FS_HOMEPAGE', 'Главная');
define('FS_GO_TO_HOMEPAGE', 'Перейти на Главную');

define ('STARTRACK_PREMIUM_EXPRESS', 'StarTrack Premium 1-3 рабочих дня');
define('TNT_ROAD_EXPRESS_1_4', 'TNT Road Express 1-4 рабочих дня');
define('DHL_EXPRESS_1_3', 'DHL Express 1-3 рабочих дня');

define('FS_NOTICE_FREE_SHIPPING','Беспл. доставка от $MONEY');
define('FS_NOTICE_FREE_DELIVERY','Бесплатная доставка от $MONEY');
define('FS_NOTICE_FAST_SHIPPING','Быстрая отправка в $COUNTRY');
define('FS_NOTICE_HEADER_COMMON_TIPS',' Из-за эффекта COVID-19 время доставки будет больше, чем обычно.');

define("FS_WORD_CLOSE", "Закрыть");

//报价购物车
define('FS_NEW_OTHER_LENGTH','Другая длина');
define('FS_INQUIRY_CART_1',"Запросить КП");
define('FS_INQUIRY_CART_2',"Контактная информация КП");
define('FS_INQUIRY_CART_3',"Имя*");
define('FS_INQUIRY_CART_4',"Фамилия*");
define('FS_INQUIRY_CART_5',"E-mail*");
define('FS_INQUIRY_CART_6',"Телефон");
define('FS_INQUIRY_CART_7',"Комментарии");
define('FS_INQUIRY_CART_8',"Загрузить файл");
define('FS_INQUIRY_CART_9',"Разрешить файлы типа PDF, JPG, PNG.<br>Максимальный размер файла 5M.");
define('FS_INQUIRY_CART_10',"Быстро добавляйте товары в детали своего предложения, вводя ID товаров и их количество.");
define('FS_INQUIRY_CART_11',"Добавить в КП");
define('FS_INQUIRY_CART_12',"Запросить КП");
define('FS_INQUIRY_CART_13',"Оставьте сообщение, если у вас есть особые требования.");
define('FS_INQUIRY_CART_14',"ID товара # ");


define('FS_INQUIRY_CART_15', "Введите ID товара.");

define('UPS_EXPRESS_NEXT_DAY_SERVICE', 'UPS Express Saver Следующий день');
define("FS_BLANK", ' ');

// 结算页美国、澳大利亚跳转
define ('AUSTRALIA_HREF_1', "Заказы на этой странице не могут быть доставлены в Австралию. Перейдите на ");
define ('FS_AUSTRALIA_CHECKOUT', "FS Australia");
define ('AUSTRALIA_HREF_2', " Если вы хотите доставить товары в Австралию. ");
define ('UNITED_STATES_SITE_HREF_1', "Заказы на этой странице не могут быть доставлены в Соединенные Штаты. Перейдите на ");
define ('FS_UNITED_STATES_SITE', "FS United States");
define ('UNITED_STATES_SITE_HREF_2', " Если вы хотите доставить товары в Соединенные Штаты. ");
define ('RUSSIAN_SITE_HREF_1', "Для юр. лиц заказы должны быть оплачены безналичным расчетом в рублях. Пожалуйста, перейдите на ");
define ('FS_RUSSIAN_SITE', "FS Россия");
define ('RUSSIAN_SITE_HREF_2', " если вы хотите разместить заказ.");


//头部购物车loading板块提示语
define('FS_TOP_CART_LOAD_TITLE', 'Загрузка');


define ('FS_INQUIRY_CART_15', "Введите ID товара.");
define('FS_VAX_TITLE_US','Ожидаемый налог с продаж');
define ('FS_VAX_TITLE_US_TAX', 'Налог с продаж');

define ('FS_VAX_US_TIPS', 'В соответствии с налоговым законодательством штата FS обязана взимать налог с продаж с неосвобожденных сторон. <a href="https://www.fs.com/service/sales_tax.html" target="_blank"> Подробнее </a>');


define ('FS_INQUIRY_CART_15', "Введите ID товара.");

//账户中添加查看评论入口
define('FS_ACCOUNT_VIEW_REVIEWS', "Посмотреть отзывы");
define('FS_VIEW_REVIEWS_WRITE_A_REVIEW', "Написать отзывы");
define('FS_VIEW_REVIEWS_SEARCH', "Поиск");
define('FS_VIEW_REVIEWS_SEARCH_REVIEWS', "Поиск отзывов:");
define('FS_VIEW_REVIEWS_ITEM', "Заказ #, ID товара #");
define('FS_VIEW_REVIEWS_1', "Отзывы не найдены.");
define('FS_VIEW_REVIEWS_2', "Найдите свой заказ и поделитесь отзывом.");
define('FS_VIEW_REVIEWS_REVIEWED_ON', "Отзыв на ");
define('FS_VIEW_REVIEWS_VERY_SATISFIED', "Очень доволен");
define('FS_VIEW_REVIEWS_READ_MORE', "Читать далее");
define('FS_VIEW_REVIEWS_MORE', "Больше");
define('FS_VIEW_REVIEWS_SHOW', "Показать");
define('FS_VIEW_REVIEWS_COMMENTS', "Комментарии");


define('FS_SRVICE_WORD', "");

//俄罗斯国家 详情页展示税后价
define('FS_EXCLUDED_VAT',' (без НДС) ');
define('FS_INCLUDED_VAT',' (включая НДС) ');

define('FS_PRODUCT_MATERIAL_M','м');
define('FS_PRODUCT_MATERIAL_CABLE',' Кабельные материалы');
define('FS_PRODUCT_MATERIAL_TIP','Время доставки будет немного больше, так как запрашиваемое количество превышает запас. Чтобы запросить разделенную отгрузку товаров на складе, свяжитесь с вашим менеджером по работе с клиентами, пожалуйста.');


define ('FS_INQUIRY_PRODUCTS_NUM', "Проверьте информацию о продукте в деталях КП.");

//前台账期申请  rebirth.ma   2020.05.22
define('FS_NET_30_01', 'Введите ваше полное имя.');
define('FS_NET_30_02', 'Загрузите вашу форму заявки.');
define('FS_NET_30_03', 'Кредитный аккаунт уже существует.');
define('FS_NET_30_04', 'FS - Ваша заявка на получение кредитного аккаунта получена');
define('FS_NET_30_05', 'Мы получили ваш запрос о отсрочке платежа. В настоящее время он находится на рассмотрении, и этот процесс может занять примерно 2-3 рабочих дня. Когда решение будет принято, вы будете уведомлены по электронной почте FS своевременно.');
define('FS_NET_30_06', 'Статус заявки');
define('FS_NET_30_07', 'Отправлено');
define('FS_NET_30_08', 'На рассмотрении');
define('FS_NET_30_09', 'Одобренно');
define('FS_NET_30_10', 'Отклонено');
define('FS_NET_30_11', 'Отправить форму заявки');
define('FS_NET_30_12', 'Имя и Фамилия');
define('FS_NET_30_13', 'Email');
define('FS_NET_30_14', 'Телефон');
define('FS_NET_30_15', 'Загрузите файлы');
define('FS_NET_30_16', 'Выберите файл');
define('FS_NET_30_17', 'Ваша заявка была успешно отправлена.');
define('FS_NET_30_18', 'Мы отправим результаты проверки по электронной почте в течение 2-3 рабочих дней. Вы также можете отслеживать обновления в "#CASE_CENTER" в FS аккаунте.');
define('FS_NET_30_19', 'Спасибо! Ваша заявка на кредитный аккаунт была успешно отправлена.');
define('FS_NET_30_20', 'Ваша заявка на получение кредитного аккаунта находится на рассмотрении, подождите приблизительно 2-3 рабочих дня для обработки.');
define('FS_NET_30_21', 'Я рад сообщить вам, что ваша заявка на получение кредитного аккаунта была одобрена. Отныне вы можете размещать заказы через свой кредитный аккаунт.');
define('FS_NET_30_22', 'Вы также можете просмотреть свои кредитные данные в "#FS_CREDIT".');
define('FS_NET_30_23', 'С сожалением сообщаем вам, что ваша заявка на получение кредитного аккаунта была отклонена. ');//与后面还有一句话，注意本句话最后面的空格
define('FS_NET_30_24', 'Вы хотите повторно подать заявку на получение кредитного аккаунта?');
define('FS_NET_30_25', 'Заполните и отправьте форму заявки в "#NET_TERMS".');
define('FS_NET_30_26', 'Если у вас есть какие-либо вопросы, свяжитесь с менеджером #ACCOUNT_MANAGER.');
define('FS_NET_30_27', 'Страна/Регион');
define('FS_NET_30_28', 'Комментарии');
define('FS_NET_30_29', 'Загрузить');
define('FS_NET_30_30','С уважением<br>Команда FS');
define('FS_NET_30_31','Запрос получен');
define('FS_NET_30_32','Отсрочке платежа');

//new-product
define('FS_NEW_PRODUCT_EXPLORE','Узнайте о последних инновациях');

//取消订阅
define ('FS_UNSUBSCRIBE_MAIL_1', 'Новости FS');
define ('FS_UNSUBSCRIBE_MAIL_2', 'Узнайте больше о последних льготных политиках, новостях запасов, технической поддержке и т. д.');
define('FS_UNSUBSCRIBE_MAIL_3','Создание комментариев по электронной почте');
define('FS_UNSUBSCRIBE_MAIL_4','Через 7 дней после доставки заказа будет отправлено электронное письмо с запросом на комментарий.');
define ('FS_UNSUBSCRIBE_MAIL_5', 'Управление настройками подписки для получения писем от FS.');
define('FS_UNSUBSCRIBE_MAIL_6','FS email будет держать вас в курсе! Email о вашей аккаунт и заказе важна. Мы отправляем их, даже если вы отказались от маркетинговых email.');

//账户中心添加关于俄罗斯对公支付
define('FS_ACCOUNT_MY_COMPANIES', 'Контрагенты');
/*wdm库存展示版块语言包*/
define('FS_WDM_WAVELENGTH_NM','Длина волны (nm)');

define("FS_CHECKOUT_RU_FILE_TIPS_2", "Разрешить файлы типа JPG, JPGE, PDF, PNG, DOC, DOCX, XLS, XLSX. Максимальный размер файла 5M.");

//100G产品提示语
define ("FS_COHERENT_CFP", "Coherent модуль CFP не продается отдельно.");


//checkout 账单地址邮编验证提示
define ('FS_ZIP_VALID_1', 'Введенный адрес не соответствует почтовому индексу. Проверьте ваш адрес еще раз, пожалуйста.');
define ('FS_ZIP_VALID_2', 'Введите действительный почтовый индекс, пожалуйста.');

define("FS_SOLUTION_CLICK_OPEN_VIEW","Нажмите, чтобы открыть расширенный вид");
define("FS_CUSTOMIZE_YOUR_SOLUTION","Выбрать&Заказать решение");
define("FS_TECH_SPEC_CUSTOMOZATION","Технические характеристики");
define("FS_SOLUTION_OVERVIEW",'Обзор');
define("FS_SOLUTION_CUSTOMIZED",'В Корзину');
define("FS_SOLUTION_EDIT",'Редактировать');
define("FS_SOLUTION_CONFIGURATION",'Конфигурация решения');
define("FS_SOLUTION_MORE",'Больше');
define('FS_SOLUTION_LESS','Меньше');
define("FS_SOLUTION_DEVICES",'Оборудования');
define("FS_SOLUTION_TRANSCEIVER",'Модуль');
define("FS_SOLUTION_WAVE_COM_BAR",'Длина волны & Совместимые бренды');
define("FS_SOLUTION_ACCESSORIES",'Аксессуары');
define("FS_SOLUTION_CHOOSE_LENGTH",'Выбрать длину');
define("FS_SOLUTION_INFO",'Информация о решении');

define('FS_SOLUTION_PERSONALIZATION','Заказной');
define('FS_SOLUTION_MANUFACTURING','Производство');
define('FS_SOLUTION_SHIPPED','Отправлено');
define('FS_SOLUTION_ARRIVED','Доставлено');
define('FS_SOLUTION_CON_LIST','Список конфигурации решения');
define('FS_SOLUTION_QUANTITY','Количество');
define('FS_SOLUTION_TOTAL','Итог');

define('FS_SOLUTION_SITEA','Сайт A ');
define('FS_SOLUTION_SITEB','Сайт B');

define('FS_SOLUTION_NAV_01','Сеть OTN');
define('FS_SOLUTION_NAV_02','Сеть кампуса');
define('FS_SOLUTION_NAV_03','ЦОД');
define('FS_SOLUTION_NAV_04','Структурированные Кабели');
define('FS_SOLUTION_NAV_05','По Применению');
define('FS_SOLUTION_NAV_06','10G CWDM Двухволоконная Сеть');
define('FS_SOLUTION_NAV_07','10G CWDM Одноволоконная Сеть');
define('FS_SOLUTION_NAV_08','10G DWDM Двухволоконная Сеть');
define('FS_SOLUTION_NAV_09','10G DWDM Одноволоконная Сеть');
define('FS_SOLUTION_NAV_10','25G DWDM Двухволоконная Сеть');
define('FS_SOLUTION_NAV_11','25G DWDM Одноволоконная Сеть');
define('FS_SOLUTION_NAV_12','40/100G Связная Сеть');
define('FS_SOLUTION_NAV_13','Корпоративная сеть');
define('FS_SOLUTION_NAV_14','Беспроводная связь и мобильность');
define('FS_SOLUTION_NAV_15','Сеть многоотраслевая');
define('FS_SOLUTION_NAV_16','Облачная сеть');
define('FS_SOLUTION_NAV_17','Структурированная кабельная система для ЦОД');
define('FS_SOLUTION_NAV_18','MTP®/MPO Кабельная система высокой плотности');
define('FS_SOLUTION_NAV_19','40G/100G Миграция');
define('FS_SOLUTION_NAV_20','Претерминированные медные кабели');
define('FS_SOLUTION_NAV_21','Мультисервисное решение CWDM');
define('FS_SOLUTION_NAV_22','10G DWDM Транспортное решение для дальних перевозок');
define('FS_SOLUTION_NAV_23','Решение 25G WDM для 5G Fronthaul');
define('FS_SOLUTION_NAV_24','100G когерентное решение DWDM');
define('FS_SOLUTION_NAV_25','MLAG Решение для оптимизации сети');
define('FS_SOLUTION_NAV_26','Коммутация сетей ядра ЦОД');
define('FS_SOLUTION_NAV_27','Решение Power over Ethernet');
define('FS_SOLUTION_NAV_28','Безопасное беспроводное решение');
define('FS_SOLUTION_NAV_29','Структурированная кабельная система для ЦОД');
define('FS_SOLUTION_NAV_30','MTP®/MPO Кабельная система высокой плотности');
define('FS_SOLUTION_NAV_31','40G/100G Миграция');
define('FS_SOLUTION_NAV_32','Претерминированные медные кабели');
define('FS_SOLUTION_NAV_33','Профессиональная команда технической поддержки и решения');
define('FS_SOLUTION_NAV_34','Корпоративный ЦОД');
define('FS_SOLUTION_NAV_35','Провайдер ЦОД');
define('FS_SOLUTION_NAV_36','Гипермасштабный и Облачный ЦОД');
define('FS_SOLUTION_NAV_37','Многопользовательский ЦОД');
//solutions 版块新增专题
define('FS_SOLUTION_NAV_M6200','10G DWDM на дальнее расстояние серии M6200 ');
define('FS_SOLUTION_NAV_M6500','100G/200G с высокой пропускной способностью серии M6500 ');
define('FS_SOLUTION_NAV_M6800','Решение 1.6T серии M6800 для DCI');
define('FS_SOLUTION_NAV_WiFi6','Сетевое решение Wi-Fi 6');
#新加坡
define("FS_CHECKOUT_ERROR_SG_01","Ваш адрес 2 требуется.");
define("FS_CHECKOUT_ERROR_SG_02","Квартира, дом, этаж и т.д.");
define("FS_CHECKOUT_ERROR_SG_03","Номер талона");
define("FS_CHECKOUT_ERROR_SG_04","Чтобы обеспечить бесперебойную доставку, укажите номер талона, отправленного в Equinix.");
define("FS_CHECKOUT_ERROR_SG_05","*Советуем заполнить ваш домашний адрес в течение специального периода управления COVID-19, чтобы обеспечить своевременность получения.");
define("FS_CHECKOUT_ERROR_SG_06","Введите свой полный адрес доставки.");

define('FS_CHECKOUT_ERROR_001',"Вы достигли максимально допустимых единиц для покупки вышеуказанных товаров. Все доступные товары добавляются в корзину.");
define('FS_CHECKOUT_ERROR_002','Выберите <span>4</span> разных каналов.');

define("FS_SEE_ALL_RESULTS","Посмотреть все результаты");

//账户中心展示交换机软件更新
define('FS_SOFTWARE_DOWNLOAD',"Скачать программное обеспечение");
define('FS_CHECK',"Проверить последнюю версию программного обеспечения коммутаторов, которые вы приобрели.");
define('FS_SOFWARE','Скачать программное обеспечение');
define('FS_SOFWARE_1','Связаться со службой поддержки');
define('FS_SOFWARE_2','Проверить последнюю версию программного обеспечения коммутаторов, которые вы приобрели. Для получения дополнительной версии программного обеспечения, перейдите на');
define('FS_SOFWARE_4','центр загрузки');
define('FS_SOFWARE_5','Показать:');
define('FS_SOFWARE_6','Сетевые Коммутаторы');
define('FS_SOFWARE_7','1G/10G Коммутаторы');
define('FS_SOFWARE_8','25G Коммутаторы');
define('FS_SOFWARE_9','40G Коммутаторы');
define('FS_SOFWARE_10','100G Коммутаторы');
define('FS_SOFWARE_11','400G Коммутаторы');
define('FS_SOFWARE_12','Поиск товара:');
define('FS_SOFWARE_13','Поиск');
define('FS_SOFWARE_14','Последняя информация о файле');
define('FS_SOFWARE_15','ID товара');
define('FS_SOFWARE_16','Дата выпуска');
define('FS_SOFWARE_17','Размер');
define('FS_SOFWARE_18','Програмное обеспечение');
define('FS_SOFWARE_19','Уведомление');
define('FS_SOFWARE_20','Последняя информация о файле');
define('FS_SOFWARE_22','Объявление о выпуске');
define('FS_SOFWARE_23','Выпускать');
define('FS_SOFWARE_24','Програмное обеспечение');
define('FS_SOFWARE_25','Скачать');
define('FS_SOFWARE_26','Уведомление о программном обеспечении');
define('FS_SOFWARE_27','Отказаться от подписки');
define('FS_SOFWARE_28','Подписаться');
define('FS_SOFWARE_29','Отписаться от новой версии программного обеспечения?');
define('FS_SOFWARE_30','Подписаться на новый выпуск программного обеспечения?');
define('FS_SOFWARE_31','Если вы не можете найти свое программное обеспечение, попробуйте выбрать другие условия фильтра.');
define('FS_SOFWARE_32','Вы не покупали FS коммутаторы раньше, приобретите FS коммутаторы.');
define('FS_SOFWARE_33','Начать покупки');
define('FS_SOFWARE_34','Вы успешно подписались.');
define('FS_SOFWARE_35','Вы получите уведомление о последней версии программного обеспечения по электронной почте.');
define('FS_SOFWARE_36','Вы успешно подписались.');
define('FS_SOFWARE_37','Вы успешно отписались.');
define('FS_SOFWARE_38','Вы больше не будете получать уведомление о последней версии программного обеспечения по электронной почте.');
define('FS_SOFWARE_39','ID товара');
define('FS_SOFWARE_40','НЕ НАЙДЕНО ПРОГРАММНОЕ ОБЕСПЕЧЕНИЕ.');
define('FS_SOFWARE_41','Подписка подтверждена');
define('FS_SOFWARE_42','Вы успешно подписались на обновления программного обеспечения следующих коммутаторов. Как только будет доступна последняя версия, мы отправим вам уведомление.');
define('FS_SOFWARE_43','Вы также можете быть заинтересованы в...');
define('FS_SOFWARE_44','Узнайте, что мы принесли клиентам <br> по всему миру.');
define('FS_SOFWARE_45','Ознакомьтесь с последними инновационными продуктами & событиями компании.');
define('FS_SOFWARE_46','FS - Подписка на обновления программного обеспечения');
define('FS_SOFWARE_47','Отписаться успешно');
define('FS_SOFWARE_48','Вы больше не будете получать уведомления об обновлении программного обеспечения для следующих коммутаторов.');
define('FS_SOFWARE_49','Если есть ошибки, нажмите кнопку ниже, чтобы повторно подписаться.');
define('FS_SOFWARE_50','Повторно подписаться');
define('FS_SOFWARE_51','Будем на связи');
define('FS_SOFWARE_52','Подписка на программное обеспечение');
define('FS_SOFWARE_53','Успех клиента FS');
define('FS_SOFWARE_54','FS Новое объявление');


define('FS_CHECKOUT_SPEC_PRODUCTS_DOUBT','Не можете найти способ доставки?');
define('FS_CHECKOUT_SPEC_PRODUCTS_TIPS','Из-за ограничений перевозчика по размеру товара курьерские компании не могут доставить заказы, содержащие #73579/#73958. Вы можете выбрать свой собственный перевозчик или связаться со своим менеджером для получения информации о доставке. Прошу прощения за неудобства.');

define('FS_CHECKOUT_FOOTER_NEW_01', 'Я хочу написать отзыв');
define('FS_CHECKOUT_FOOTER_NEW_02', '<a href="' . reset_url('service/fs_support.html'). '" target="_blank" > Центр помощи</a> или <a target="_blank" href="' . reset_url('contact_us.html') . '">Контакты</a>.');
define('FS_CHECKOUT_FOOTER_NEW_03', 'Для получения немедленной помощи, пожалуйста, свяжитесь с нами через');
define('FS_CHECKOUT_FOOTER_NEW_04', 'Выберите тему вашего отзыва*');
define('FS_CHECKOUT_FOOTER_NEW_05', 'Выберите, пожалуйста... ');
define('FS_CHECKOUT_FOOTER_NEW_06', 'Войти или Регистрация');
define('FS_CHECKOUT_FOOTER_NEW_07', 'Корзина');
define('FS_CHECKOUT_FOOTER_NEW_08', 'Налог');
define('FS_CHECKOUT_FOOTER_NEW_09', 'Адрес доставки&Платежный адрес ');
define('FS_CHECKOUT_FOOTER_NEW_10', 'Доставка');
define('FS_CHECKOUT_FOOTER_NEW_11', 'Оплата');
define('FS_CHECKOUT_FOOTER_NEW_12', 'Другие');
define('FS_CHECKOUT_FOOTER_NEW_13', 'Выберите тему, пожалуйста.');
define('FS_CHECKOUT_FOOTER_NEW_14', 'Что мы можем делать, чтобы улучшить ваш опыт?');
define('FS_CHECKOUT_FOOTER_NEW_15', 'Ваши комментарии помогут FS быстрее реагировать.');
define('FS_CHECKOUT_FOOTER_NEW_16', 'Введите более 10 цифр.');
define('FS_CHECKOUT_FOOTER_NEW_17', 'Отправить');
define('FS_CHECKOUT_FOOTER_NEW_18', 'Спасибо за ваш отзыв.');
define('FS_CHECKOUT_FOOTER_NEW_19', 'Мы рассмотрим ваши отзывы и улучшим сайт FS для будущих посещений.');
define('FS_CHECKOUT_SUCCESS_EMAIL_01', 'Новый отзыв пришёл');
define('FS_CHECKOUT_SUCCESS_EMAIL_02', 'Клиент предоставил следующую информацию на странице оплаченного заказа, при необходимости обратите внимание, пожалуйста.');
define('FS_CHECKOUT_SUCCESS_EMAIL_03', 'Имя:');
define('FS_CHECKOUT_SUCCESS_EMAIL_04', 'E-mail:');
define('FS_CHECKOUT_SUCCESS_EMAIL_05', 'Номер заказа:');
define('FS_CHECKOUT_SUCCESS_EMAIL_06', 'Тема отзыва:');
define('FS_CHECKOUT_SUCCESS_EMAIL_07', 'Другое содержание:');
define('FS_CHECKOUT_SUCCESS_EMAIL_08', 'Тема отзыва');

define('FS_PRINT',"Чтобы защитить конфиденциальность клиента, введите аккаунт пользователя FS, который разместил этот заказ, чтобы проверить детали заказа:");
define('FS_PRINT_1',"Подтвердить");
define('FS_PRINT_2',"Введенный адрес электронной почты не соответствует информации о заказе. Подтвердите и введите снова.");
define('FS_PRINT_3',"Введите адрес электронной почты.");



//评论改版
define('FS_REVIEW_07','Модель устройства');
define('FS_REVIEW_08','Добавление названия модели товара может помочь другим покупателям..');
define('FS_REVIEW_09','Доступны типы файлов JPG, JPEG, PNG. Максимальный размер файла- 5M');
define('FS_REVIEW_11','По выбору');
define('FS_REVIEW_ATTRIBUTE_CONTENT', 'Совместимые бренды');



//2020.08.03 liang.zhu
define('FS_CLEARANCE_TIP_01_01', 'Эта распродажа ограничена $QTY шт и будет снять после продажи.');
define('FS_CLEARANCE_TIP_01_02', 'Для большего количества мы рекомендуем приобрести альтернативный товар "<a style="color:#0070BC;" target="_blank" href="'.reset_url('/products/$PRODUCTS_ID.html').'">$PRODUCTS_ID</a>".');
define('FS_CLEARANCE_TIP_02_01', 'Эта распродажа отсутствует на складе и будет снять после продажи в ближайшее время.');
define('FS_CLEARANCE_TIP_02_02', 'Для большего количества мы рекомендуем приобрести альтернативный товар "<a style="color:#0070BC;" target="_blank" href="'.reset_url('/products/$PRODUCTS_ID.html').'">$PRODUCTS_ID</a>".');
define('FS_CLEARANCE_TIP_03_01', 'Эта распродажа ограничена $QTY шт и будет снять после продажи.');
define('FS_CLEARANCE_TIP_03_02', 'Для большего количества, связаться со своим менеджером, пожалуйста.');
define('FS_CLEARANCE_TIP_04_01', 'Эта распродажа отсутствует на складе и будет снять после продажи в ближайшее время.');
define('FS_CLEARANCE_TIP_04_02', 'Для большего количества, связаться со своим менеджером, пожалуйста.');


define('CHECKOUT_COMPANY_TYPE', 'Неверный тип адреса');

## 添加 Delivery Instructions信息
define("FS_DELIVERY_TITLE", "Инструкции по доставке (необязательно)");
define("FS_DELIVERY_TICKET_NUMBER", "Номер талона, код безопасности и т. Д.");
define("FS_DELIVERY_OTHER_INFO", "Время доставки или другие инструкции по доставке");
define("FS_DELIVERY_PROMPT", "Ваши инструкции помогут нам доставить вашу посылку.");
define('FS_DELIVERY_INSTRUCTIONS', 'Инструкции по доставке');

//PO
define('FS_CHECKOUT_SUCCESS_PURCHASE_03', ' подтверждено. Загрузите PO файл в течение 7 рабочих дней, пожалуйста. В противном случае заказ будет отменен автоматически из-за изменения инвентаря товаров.');
define('FS_CHECKOUT_SUCCESS_PURCHASE_04', 'Загрузить PO файл');
define('FS_CHECKOUT_SUCCESS_PURCHASE_04_1', 'Что такое PO Файл?');
define('FS_PO_FILE','PO');
define('FS_PO_FILE_1','FS.COM Inc.');
define('FS_PO_FILE_2','380 Centerpoint Blvd, New Castle,<br /> DE 19720, United States');
define('FS_PO_FILE_3','PO');
define('FS_PO_FILE_4','Дата: 08/08/2020<br />PO #: PO0001');
define('FS_PO_FILE_5','Поставщик');
define('FS_PO_FILE_6','ДОСТАВКА ДО');
define('FS_PO_FILE_7','ПЛАТЕЛЬЩИК');
define('FS_PO_FILE_8','FS.COM Pty Ltd');
define('FS_PO_FILE_9','57-59 Edison Rd, Dandenong South, <br />VIC 3175, Australia <br />ABN 71 620 545 502');
define('FS_PO_FILE_10','Менеджер по работе с клиентами: ');
define('FS_PO_FILE_11','Ann.Smith');
define('FS_PO_FILE_12','Электронная почта: ');
define('FS_PO_FILE_13','Ann.Smith@fs.com');
define('FS_PO_FILE_14','FS.COM Pty Ltd');
define('FS_PO_FILE_15','380 Centerpoint Blvd <br />New Castle, <br />DE 19720');
define('FS_PO_FILE_16','Тел #: ');
define('FS_PO_FILE_17','+1 (888) 468 7419');
define('FS_PO_FILE_18','Attn: ');
define('FS_PO_FILE_19','Steven');
define('FS_PO_FILE_20','FS.COM Inc.');
define('FS_PO_FILE_21','380 Centerpoint Blvd <br />New Castle, <br />DE 19720');
define('FS_PO_FILE_22','Тел #: ');
define('FS_PO_FILE_23','+1 (888) 468 7419');
define('FS_PO_FILE_24','Attn: ');
define('FS_PO_FILE_25','Steven');
define('FS_PO_FILE_26','Условия оплаты');
define('FS_PO_FILE_27','Заявитель');
define('FS_PO_FILE_28','Отдел');
define('FS_PO_FILE_29','Wire Transfer');
define('FS_PO_FILE_30','Steven Jones');
define('FS_PO_FILE_31','Отдел закупок');
define('FS_PO_FILE_32','FS RQC #: RQC2008010003');
define('FS_PO_FILE_33','<th>Описание товара</th><th>ID товара</th><th>Кол-во (шт.)</th><th>Цена за ед.</th><th>Итого (Товар)</th>');
define('FS_PO_FILE_36','Стоимость товара:');
define('FS_PO_FILE_38','Стоимость доставки:');
define('FS_PO_FILE_39','НДС:');
define('FS_PO_FILE_40','Итого:');
define('FS_PO_FILE_41',"Что такое PO файл?");
define('FS_PO_FILE_42',"PO файл используется в качестве документа для заказа на покупку и обычно включает следующее:");
define('FS_PO_FILE_43',"Дата и номер PO;");
define('FS_PO_FILE_44',"Информация о компании покупателя и продавца;");
define('FS_PO_FILE_45',"Адрес доставки&Платежный адрес; Условия оплаты;");
define('FS_PO_FILE_46',"FS Информация о товаре и цене.");
define('FS_PO_FILE_47',"Посмотреть пример PO файла");

define('FS_OFFLINE_ORDERS','Оффлайн Заказы');
define('FS_OFFLINE_COMBINED_SHIPMENT','Совместная доставка ');
define('FS_OFFLINE_COMBINED_SHIPMENT_DETAILAS','Чтобы сократить количество доставок и помочь защитить окружающую среду, FS организовала следующие заказы для отправки вместе. Нажмите на номер заказа, чтобы проверить детали каждого заказа.');
define('FS_OFFLINE_TRACK_YOUR_PACKAGE_01','Если статус заказа не обновляется, обратитесь к вашему менеджеру. Вы увидите свой заказ на"');
define('FS_OFFLINE_TRACK_YOUR_PACKAGE_02','" при отправке');

//线下订单列表
define('FS_OFFLINE_01','Скачать инвойс');
define('FS_OFFLINE_02','Заказ размещен на: ');
define('FS_OFFLINE_03','Заказ #: ');
define('FS_OFFLINE_04','Всего: ');
define('FS_OFFLINE_05','Стоимость доставки: ');
define('FS_OFFLINE_06','GST: ');
define('FS_OFFLINE_07','Страхование: ');
define('FS_OFFLINE_08','Итого: ');
define('FS_OFFLINE_09','Ваш заказ был доставлен в соответствии с выбранным способом при оформлении заказа. Вы можете проверить статус отслеживания, нажав Номер отслеживания ниже или в электронном письме с уведомлением. Однако некоторые транспортные компании не всегда обновляют информацию об отслеживании немедленно, поэтому ваш статус доставки может быть отложен.');
define('FS_OFFLINE_10','Отследить статус заказа по новому номеру заказа');
define('FS_OFFLINE_11','Основными преимуществами являются его пассивный характер - отсутствие необходимости в источнике питания или охлаждении и надежность - отсутствие особых требований к микроклимату, Основными преимуществами являются его пассивный характер - отсутствие необходимости в источнике питания или охлаждении и надежность - отсутствие особых требований к микроклимату, Основными преимуществами являются его пассивный характер - отсутствие необходимости в источнике питания или охлаждении и надежность - отсутствие особых требований к микроклимату, Основными преимуществами являются его пассивный характер - отсутствие необходимости в источнике питания или охлаждении и надежность - отсутствие особых требований к микроклимату, Основными преимуществами являются его пассивный характер - отсутствие необходимости в источнике питания или охлаждении и надежность - отсутствие особых требований к микроклимату, Основными преимуществами являются его пассивный характер - отсутствие необходимости в источнике питания ');
define('FS_OFFLINE_12','Подтвердить получение');
define('FS_OFFLINE_13','Доставка отменена. Если у вас возникнут вопросы, обратитесь к менеджеру своего аккаунта.');
define('FS_OFFLINE_14','Посмотреть ');
define('FS_OFFLINE_15',' больше посылок');
define('FS_OFFLINE_16',' в этом заказе.');
define('FS_OFFLINE_17','Обработка');
define('FS_OFFLINE_18','хорошо');
define('FS_OFFLINE_19','Заказ # ');
define('FS_OFFLINE_20','(текущий заказ)');
define('FS_OFFLINE_21','Заказов не найдено.');
define('FS_OFFLINE_22','Если вы не можете найти свой заказ, попробуйте выбрать другие условия фильтрации или проверьте номер заказа #.<br/>Поиск офлайн-заказов возможен только после отправки. Перед этим вы можете связаться со своим менеджером аккаунта.');
//线下订单订单详情
define('FS_OFFLINE_ORDERS','Офлайн-заказы');
define('FS_OFFLINE_COMBINED_SHIPMENT','Комбинированная доставка');
define('FS_OFFLINE_COMBINED_SHIPMENT_DETAILAS','Чтобы сократить объем доставки и защитить окружающую среду, FS отправит ваши заказы вместе. Нажмите номер заказа, чтобы просмотреть подробную информацию о соответствующем заказе.');
define('FS_OFFLINE_TRACK_YOUR_PACKAGE_01','Если статус заказа не обновлялся, обратитесь к менеджеру своего аккаунта. Вы посмотрите этот заказ в"');
define('FS_OFFLINE_TRACK_YOUR_PACKAGE_02','" когда он будет отправлен.');
define('FS_OFFINE_TRANSACTION','Офлайн-отслеживание посылок');
define('FS_OFFINE_TRANSACTION_1','Доставка отменена. Если у вас возникнут вопросы, обратитесь к менеджеру своего аккаунта.');
define('FS_OFFLINE_POPUP','Другие заказы включены в эту посылку.');
define('FS_OFFINE_TRANSACTION','Офлайн-транзакция');
define('FS_OFFINE_TRANSACTION_2','Посмотрите информацию об отслеживании доставки ниже');
define('FS_OFFINE_TRANSACTION_4','Ваш заказ обрабатывается.');
//my credit orders 页面
define('FS_VIEW_CONTENT','Этот заказ разделен на несколько поставок, вы можете просмотреть все инвойсы в деталях заказа, поскольку инвойсы разделены для каждой доставки. Нажмите для ');
define('FS_VIEW_LINK','смотрения все инвойсы.');
define('FS_MY_CREDIT_01','Показать:');
define('FS_MY_CREDIT_02','Онлайн-заказы');
define('FS_MY_CREDIT_03','Оффлайн заказ');
define('FS_MY_CREDIT_04','Идти');
define('FS_OFFINE_TRACK_INFO_1','Если статус заказа не обновлялся, обратитесь к менеджеру своего аккаунта. вы посмотрите этот заказ в "<a class="new_alone_a" href="'.zen_href_link('manage_orders').'">Истории заказов</a>" , когда он будет отправлен.');
define('FS_INFO_IN_TRANSIT','В пути');

define('FS_PRINT_AVE_1','FS.COM LIMITED</br>Unit 1, Warehouse No. 7</br>South China International Logistics Center</br>Longhua District</br>Shenzhen, 518109');
define('FS_PRINT_US_1','China');
//结算页
define('FS_CHECK_OUT_EXCLUDING1','Без учета пошлин и налогов');


define('FS_SEARCH_NEW','Результаты поиска для ');
define('FS_SEARCH_NEW_1',"Товар");
define('FS_SEARCH_NEW_2',"Документы &amp; Ресурсы");
define('FS_SEARCH_NEW_3',"Решения");
define('FS_SEARCH_NEW_4',"Практические примеры");
define('FS_SEARCH_NEW_5',"Скачать");
define('FS_SEARCH_NEW_6',"Очистить все");
define('FS_SEARCH_NEW_7',"Решения");
define('FS_SEARCH_NEW_8',"Практические примеры");
define('FS_SEARCH_NEW_9',"Название");
define('FS_SEARCH_NEW_10',"Тип");
define('FS_SEARCH_NEW_11',"Дата");
define('FS_SEARCH_NEW_12',"файл");
define('FS_SEARCH_NEW_13',"Новости");
define('FS_SEARCH_NEW_14',"больше не доступен онлайн. Аналогичный товар рекомендуется ");
define('FS_SEARCH_NEW_15'," ниже.");
define('FS_SEARCH_NEW_16'," больше не доступен онлайн. Перейдите к разделу Запросить КП.");

define('FS_ACCOUNT_SEARCH_ALL_TIMES', 'Весь период');

define('FS_MY_SHOPPING_CART','Моя корзина');
define('GET_A_QUOTE_TIP_1',"*Чтобы узнать срок поставки или информацию о доставке, заполните следующую форму и отправьте запрос, мы ответим вам как можно скорее.");

define("FS_INQUIRY_NEW_EMAIL"," отправил вам запрос на изменение #");
define("FS_INQUIRY_NEW_EMAIL_1"," Изменение КП");
define("FS_INQUIRY_NEW_EMAIL_2","отправила вам запрос на изменение КП");
define("FS_INQUIRY_NEW_EMAIL_3",", проверьте следующие данные и как можно скорее измените КП.");
define("FS_INQUIRY_NEW_EMAIL_4","Номер вопроса:");
define("FS_INQUIRY_NEW_EMAIL_5","Товар(ы)");
define("FS_INQUIRY_NEW_EMAIL_6","Кол-во");
define("FS_INQUIRY_NEW_EMAIL_7","Цена за ед.");
define("FS_INQUIRY_NEW_EMAIL_8","КП");
define("FS_INQUIRY_NEW_EMAIL_9","Начальная сумма:");
define("FS_INQUIRY_NEW_EMAIL_10","Итого :");
define("FS_INQUIRY_NEW_EMAIL_11","Ответьте на ");
define("FS_INQUIRY_NEW_EMAIL_12"," отправьте запросу в этот аккаунт.");
define("FS_INQUIRY_NEW_EMAIL_13","Ваш комментарий был отправлен.");
define("FS_INQUIRY_NEW_EMAIL_14","Мы получили ваше письмо. Менеджер ответит вам в течение 12–24 часов.");


define('FS_QUOTE_INQUIRY_01', 'Выбрать файл');
define('FS_QUOTE_INQUIRY_02', 'Загрузить список товаров');
define('FS_QUOTE_INQUIRY_03', 'Введите ID товара или загрузите список товаров, которые запрос КП.');
define('FS_QUOTE_INQUIRY_04', 'Ваш запрос КП успешно отправлен.');
define('FS_QUOTE_INQUIRY_05', 'Менеджер обработает запрос в течение 12-24 часов и отправит вам по электронной почте.');
define("FS_QUOTE_EDIT_QUOTE", "Изменить КП");
define("FS_QUOTE_QUOTE_REQUEST", "ЗАПРОСИТЬ КП");
define("FS_QUOTE_INQUIRY_06", "Отправьте запрос КП вашему менеджеру по электронной почте");
define("FS_QUOTE_INQUIRY_07", "Ваш КП ");
define("FS_QUOTE_INQUIRY_08", "действительно, ");
define("FS_QUOTE_INQUIRY_09", "вы можете оформить заказ.");
define("FS_QUOTE_INQUIRY_10", "Если вам нужно изменить это КП или у вас есть вопросы, вы можете заполнить следующую информацию. На основании вашего сообщения менеджеру будет отправлено электронное почте.");
define("FS_QUOTE_INQUIRY_11", "От:");
define("FS_QUOTE_INQUIRY_12", "Менеджер ответит на это письмо.");
define("FS_QUOTE_INQUIRY_13", "До:");
define("FS_QUOTE_INQUIRY_14", "О чем вы хотите поговорить");
define("FS_QUOTE_INQUIRY_15", "Если вы хотите добавить или изменить товары, запишите ID (eg. #11552) товара и количество.");
define("FS_QUOTE_INQUIRY_16", "Отправить");
define("FS_QUOTE_INQUIRY_17", "Распечатать корзину");
define("FS_QUOTE_INQUIRY_18", "Распечатать КП");
define("FS_QUOTE_INQUIRY_19", "Нужно изменить это КП?");
define("FS_QUOTE_INQUIRY_20", "Товары");
define("FS_QUOTE_INQUIRY_21", "ЗАГРУЗИТЬ СПИСОК ТОВАРОВ");
define("FS_QUOTE_INQUIRY_22", "Список товаров:");
define("FS_QUOTE_INQUIRY_23", "Статус запросить КП ");
define("FS_QUOTE_INQUIRY_24", " обновлен. Проверьте еще раз.");
define("FS_QUOTE_INQUIRY_25", "Загрузите PO файл.");
define("FS_QUOTE_INQUIRY_26", "КОММЕНТАРИИ (НЕОБЯЗАТЕЛЬНО)");
define("FS_QUOTE_INQUIRY_28", "Описание");

//消费税邮件
define('FS_TAX_EMAIL_01','Application Received');
define('FS_TAX_EMAIL_02','FS - Your Tax Exemption Application Received');
define('FS_TAX_EMAIL_03','Your application is under review.');
define('FS_TAX_EMAIL_04','Tax Exemption State:');
define('FS_TAX_EMAIL_05','We\'ll let you know the result of your application within 1-2 business days, you can view the progress of the application by clicking the button below.');
define('FS_TAX_EMAIL_06','View application');
define('FS_TAX_EMAIL_07','If you have any questions in relation to this Tax Exemption Application, please <a href="'.HTTPS_SERVER.reset_url('service/sales_tax.html').'" target="_blank" style="color: #0070BC;text-decoration: none">learn</a> about the U.S. Sales Tax in FS.com Purchases, or <a href="'.zen_href_link(FILENAME_CONTACT_US).'" target="_blank" style="color: #0070BC;text-decoration: none">Contact Us</a> for help.');
define('FS_CHECKOUT_PAY_01','Оплатить ');
define('FS_COMMON_DHL','DHL Economy Select®');

//详情页新文件标记
define('FS_NEW_FILE_TAG','Новинка');

//inquiry
define('FS_INQUIRY_EDIT_SUCCESS_1','Ваше изменение ');
define('FS_INQUIRY_EDIT_SUCCESS_2',' успешно отправлено.');
define('FS_MY_SHOPPING_CART_OFFICIAL_QUOTE','Моё официальное КП');

define('FS_XING_HAO', '*');

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
define('FS_CHECKOUT_FS_NAME_US', "Получатель: FS.COM Inc.");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_US',' 
			Адрес: 380 Centerpoint Blvd,
					New Castle, DE 19720,
					United States
');
define('FS_CHECKOUT_EMAIL_TEL_US', 'Тел.: +1 (888) 468 7419');
define('FS_CHECKOUT_EMAIL_US', 'us@fs.com');
// 澳洲仓 （澳大利亚）
define('FS_CHECKOUT_FS_NAME_AU', "FS.COM PTY LTD");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_AU','
				57-59 Edison Road,
				Dandenong South,
				VIC 3175,
				Australia,
				ABN: 71 620 545 502
');
define('FS_CHECKOUT_EMAIL_TEL_AU', 'Тел: +61 3 9693 3488');
define('FS_CHECKOUT_EMAIL_AU', 'au@fs.com');
// 新加坡仓
define('FS_CHECKOUT_FS_NAME_SG', "FS TECH PTE. LTD");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_SG','
				30A Kallang Place #11-10/11/12,
				Singapore 339213,
				Singapore,
				GST Reg No.: 201818919D
');
define('FS_CHECKOUT_EMAIL_TEL_SG', 'Тел: (65) 6443 7951');
define('FS_CHECKOUT_EMAIL_SG', 'sg@fs.com');


define('FS_ORDERS_TRACKING_NINJA_STATUS1', 'Успешно получено от отправителя - FS');
define('FS_ORDERS_TRACKING_NINJA_STATUS2', 'Груз обрабатывается на складе Ninja Van - сортировочный комплекс Ninja Van');
define('FS_ORDERS_TRACKING_NINJA_STATUS3', 'В пути');
define('FS_ORDERS_TRACKING_NINJA_STATUS4', 'Доставлено');

//评论
define("FS_ACCOUNT_ORDER_REVIEWS_COUNT",'Отзывы о заказе');
define('FS_ACCOUNT_HISTORY_INFO_THANK', "Спасибо за покупку.");
define('FS_ACCOUNT_HISTORY_INFO_REVIEWS', "Ваши отзывы будут полезены другим покупателям, и мы очень рады получить ваши отзыв. Нажмите на кнопку ниже и оставьте свой отзыв!");
define('FS_ACCOUNT_HISTORY_INFO_NOT_NOW', "Не сейчас");

define('FS_FOOTER_COOKIE_TIP_NEW','Мы используем cookies, чтобы обеспечить вам лучший опыт покупок. Нажимая кнопку "принять" или продолжая использовать этот сайт, вы соглашаетесь с использованием файлов cookie в соответствии с нашей <a href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">Политикой конфиденциальности</a>. А если вы не соглашаетесь, <a href="javascript:;" class="refuse_cookie_btn_google">нажмите здесь</a>.');
define('FS_FOOTER_COOKIE_TIP_BTN','Принять');


//新增俄罗斯仓库
define("FS_WAREHOUSE_RU","склад RU");
define('FS_RU_NOTICE',"RU склад FS в Москве поддерживает быструю отправку в тот же день. <a target='_blank' href='".zen_href_link("shipping_delivery","","SSL")."'>Узнайте больше</a>");
define('FS_COMMON_WAREHOUSE_RU','ООО «ФС.КОМ» <br>4062-й, дом 6, строение 16<br>Проезд Проектируемый<br>115432, город Москва,<br>Российская Федерация<br>Тел: +7 (499) 643 4876');
define("FS_WAREHOUSE_AREA_TIME_48","Самовывоз со склада RU в желаемое время");
define("FS_WAREHOUSE_AREA_SHIP_RU"," со склада RU");
define("FS_WAREHOUSE_AREA_RU","Отправить со склада RU");

//销量语言包
define('FS_PRODUCTS_SALES_SOLD', 'Заказы %s');
define('FS_PRODUCTS_SALES_REVIEW', 'Отзывы %s');
define('FS_PRODUCTS_SALES_REVIEWS', 'Отзывы %s');



define('FS_REVIEWS_TAG_01', 'Отзывы клиентов');
define('FS_REVIEW_NEW_15', 'Нажимать на картинку, чтобы добавить теги, вы также можете добавить');
define('FS_REVIEW_NEW_16', 'тег');
define('FS_REVIEW_NEW_17', 'Сохранить');
define('FS_REVIEW_NEW_18', 'Изменить тег');
define('FS_REVIEW_NEW_19', 'Недавно купленный');
define('FS_REVIEW_NEW_20', 'Заказ не найден.');
define('FS_REVIEW_NEW_21', 'Подтвердить');
define('FS_REVIEW_NEW_22', 'Нажимать, чтобы ввести ID товара/название товара');
define('FS_REVIEW_NEW_23', 'Введите ID товара/название товара.');
define('FS_REVIEW_NEW_24', 'Добавить тег');
define('FS_REVIEW_NEW_25', 'Посмотреть фотографии покупателей');
define('FS_REVIEW_NEW_26', 'тег');

//详情优化
define('FS_PRODUCT_SPOTLIGHTS_01', 'Преимущество товара');
define('FS_PRODUCT_COMMUNITY_01', 'Сообщество');
define('FS_PRODUCT_COMMUNITY_02', 'Изучение решения');
define('FS_PRODUCT_COMMUNITY_03', 'Распаковка коммутатора S5860-20SQ | FS');
define('FS_PRODUCT_COMMUNITY_04', 'Тестирование Ixia RFC2544 для коммутатора S5860-20SQ | FS');
define('FS_PRODUCT_COMMUNITY_05', 'S5860-20SQ: Видео товара | FS');
define('FS_PRODUCT_COMMUNITY_06', 'Как подключить коммутатор FS к коммутатору Cisco | FS');

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
define('FS_PRODUCT_COMMUNITY_22', 'Как заменить блок питания и вентилятор | FS');
define('FS_PRODUCT_HIGHLIGHTS_01', 'Характеристики товара');

define('FS_PRODUCT_HIGHLIGHTS_01', 'Характеристики товара');

//报价PDF语言包
define('FS_QUOTES_PDF_01', 'Коммерческое предложение');
define('FS_QUOTES_PDF_01_TAX', 'Коммерческое предложение');
define('FS_QUOTES_PDF_02', 'Номер RQ');
define('FS_QUOTES_PDF_03', 'Создано');
define('FS_QUOTES_PDF_04', '1. Коммерческое предложение действительно только 15 дней, свяжитесь с менеджером для повторной проверки после истечения срока.');
define('FS_QUOTES_PDF_05', '2. При оплате этого заказа записать номер RQ заказа или название компании.');
define('FS_QUOTES_PDF_TOTAL_TAX', 'Итого');
//报价成功邮件语言包
define('EMAIL_QUOTES_SUCCESS_01', "Мы получили ваш запрос на коммерческое предложение ");
define('EMAIL_QUOTES_SUCCESS_02', ' и отправим вам по электронной почте КП с подробностями в течение одного рабочего дня.');
define('EMAIL_QUOTES_SUCCESS_03', 'Cообщение');
define('EMAIL_QUOTES_SUCCESS_04', 'Request quote, please give me your best offer.');
define('EMAIL_QUOTES_SUCCESS_05', 'Посмотреть в аккаунте');
define('EMAIL_QUOTES_SUCCESS_06', 'Скачать PDF');
//报价分享邮件语言包
define('EMAIL_QUOTES_SHARE_01', 'Вы можете посмотреть это предложение в разделе Аккаунт/Запросы на КП и преобразовать его в заказ.');
define('EMAIL_QUOTES_SHARE_02', 'Если у вас есть вопросы по конфигурации, цене и проверке контракта, ');
define('EMAIL_QUOTES_SHARE_03', 'обратитесь к менеджеру своего аккаунта.');
define('EMAIL_QUOTES_SHARE_04', 'Обновленное КП');
define('EMAIL_QUOTES_SHARE_05', 'Вы получили новое КП от FS.');


//报价详情页语言包
define('FS_QUOTES_DETAILS_01', 'Наличный запас, дата доставки, предполагаемые налоги и стоимость доставки могут измениться и будут рассчитаны при оформлении заказа.');
define('FS_QUOTES_DETAILS_02', 'Посмотреть');
define('FS_QUOTES_DETAILS_03', 'Ниже приведена ваша деталь КП и действительно до $TIME.');
define('FS_QUOTES_DETAILS_04', 'Запрос на КП #:');
define('FS_QUOTES_DETAILS_05', 'Скачать КП');
define('FS_QUOTES_DETAILS_06', 'Дата запроса на КП:');
define('FS_QUOTES_DETAILS_07', 'Дата:');
define('FS_QUOTES_DETAILS_08', 'ID клиента:');
define('FS_QUOTES_DETAILS_09', 'Номер.  #');
define('FS_QUOTES_DETAILS_10', 'Менеджер по аккаунту:');
define('FS_QUOTES_DETAILS_11', 'Номер телефона #:');
define('FS_QUOTES_DETAILS_12', 'ДОСТАВКА ДО');
define('FS_QUOTES_DETAILS_13', 'Способ Доставки: ');
define('FS_QUOTES_DETAILS_14', 'ПЛАТЕЛЬЩИК');
define('FS_QUOTES_DETAILS_15', 'Способ Оплаты:');
define('FS_QUOTES_DETAILS_16', 'Посмотреть все');
define('FS_QUOTES_DETAILS_17', 'ССЫЛКА');
define('FS_QUOTES_DETAILS_18', 'К сожалению, товар был удален и больше не доступен для покупки.');
define('FS_QUOTES_DETAILS_19', 'Длина: ');
define('FS_QUOTES_DETAILS_20', 'Больше');
define('FS_QUOTES_DETAILS_21', 'Этот товар включает следующие продукты');
define('FS_QUOTES_DETAILS_22', 'НДС:');
define('FS_QUOTES_DETAILS_23', 'Запрос на КП истек $TIME. Вы можете запросить на КП снова, если нужно.');
define('FS_QUOTES_DETAILS_24', 'КП был создан для оформления заказа.');


//报价列表页语言包
define('QUOTES_LIST_BRED_CRUMBS','История предложений');

define('QUOTES_LIST_TIME_TYPE_1', 'Весь период');
define('QUOTES_LIST_TIME_TYPE_2', 'Последний месяц');
define('QUOTES_LIST_TIME_TYPE_3', 'Последние 3 месяца');
define('QUOTES_LIST_TIME_TYPE_4', 'Последний год');
define('QUOTES_LIST_TIME_TYPE_5', 'Год назад');

define('QUOTES_LIST_STATUS_TYPE_1', 'Онлайн-КП');
define('QUOTES_LIST_STATUS_TYPE_2', 'Актуальный');
define('QUOTES_LIST_STATUS_TYPE_3', 'Купленный');
define('QUOTES_LIST_STATUS_TYPE_4', 'Истек срок действия');
define('QUOTES_LIST_STATUS_TYPE_5', 'Оффлайн КП');
define('QUOTES_LIST_STATUS_TYPE_6', 'Все статус');

define('QUOTES_LIST_RESULT_SINGULAR', 'Результат');
define('QUOTES_LIST_RESULT_PLURAL', 'Результаты');
define('QUOTES_LIST_UPDATE_TIME', 'Цена обновлена ​​в $TIME');
define('QUOTES_LIST_EXPIRE_TIME', 'Срок действия истекает $TIME');
define('QUOTES_LIST_EXPIRE_TIME_ACTIVE', 'Срок действия истекает $TIME');
define('QUOTES_LIST_QUOTE_AGAIN', 'Запросить снова');
define('QUOTES_LIST_VIEW_ORDERS', 'Посмотреть историю заказов');
define('QUOTES_LIST_SEARCH_PLACEHOLDER', 'Запросить КП#, Детали КП …');

define('FS_SHOPPING_CART_CREATE_QUOTE', 'КП');
define('FS_QUOTES_ORDERS_NUMBER', 'Номер заказа');
define('QUOTES_LIST_EMPTY_TIPS', 'Запрос на КП не найден.');
define('FS_QUOTES_CREATE_EMAIL_THEME','FS - Мы получили ваш запрос на коммерческое предложение $NUM');
define('FS_QUOTES_SHARE_EMAIL_THEME','FS -  Ваш друг $EMAIL поделился с вами коммерческом предложении');
define('FS_QUOTES_OFFLINE_DETAIL_TIPS', 'Стоимость доставки и налогов будет рассчитана на странице оформления заказа.');


define('FS_RECENT_SEARCH', 'История поиска');
define('FS_HOT_SEARCH', 'Хит');
define('FS_CHANGE', 'Изменить');

define('FS_VIEW_WORD', 'Посмотреть');

//一级分类页
define('FS_CATEGORIES_POPULAR', 'Популярные категории');
define('FS_CATEGORIES_BEST_SELLERS', 'Хит продаж');
define('FS_CATEGORIES_NETWORK', 'Сетевые аксессуары');
define('FS_CATEGORIES_DISCOVERY', 'Cообщество');

define('CARD_NOT_SUPPORT', 'Этот способ оплаты в настоящее время не поддерживается. Оплатите другим способом.');

//全站help center 调整为FS Support 2021.1.15  ery
define('FS_COMMON_FS_SUPPORT','FS Поддержка');
define('FS_ADVANCED_SEARCH_RESULT_TIP_1', '<span class="new_proList_proListNtit">Нет результатов для</span> "###RECOMMEND_WORD###" <span class="new_proList_proListNtit">поэтому отображаются результаты поиска для</span> "###SEARCH_WORD###"<span class="new_proList_proListNtit">.</span>');
define('FS_ADVANCED_SEARCH_RESULT_TIP_2', 'Быть может, вы искали <a target="_blank" href="###HREF_LINK###">###RECOMMEND_WORD###</a>');

define('SEARCH_OFFLINE_PRODUCT_TIP_1_V2', 'Ниже приведены рекомендуемые новые товары обновления для вашей справки.');
define('SEARCH_OFFLINE_PRODUCT_TIP_2_V2', 'Рекомендуется использовать аналогичные товары.');
define('SEARCH_OFFLINE_PRODUCT_TIP_3_V2', 'Рекомендуется использовать заказные товары.');
define('SEARCH_OFFLINE_PRODUCT_TIP_4_V2', ' Не нашли нужный товар? Свяжитесь с нами.');
define('SEARCH_OFFLINE_PRODUCT_TIP', '"KEYWORD" на сайте больше не доступен, но FS ещё поставляет этот товар. Для подробной информации, обратитесь к странице <a style="color: #0070BC;text-decoration: none" href="'.zen_href_link('offline_products_eos').'" target="_blank">политика окончание продажи</a>.');

//信用卡语言包
define("CREDIT_CARD_ERROR_303","Общий отказ – Эмитент не предоставляет никакой другой информации");
define("CREDIT_CARD_ERROR_606","Эмитент не допускает такого рода сделок");
define("CREDIT_CARD_ERROR_08","Данные CAV2/CID/CVC2 не проверены");
define("CREDIT_CARD_ERROR_22","Недопустимый номер кредитной карты");
define("CREDIT_CARD_ERROR_25","Недействительный срок годности");
define("CREDIT_CARD_ERROR_26","Недопустимая сумма");
define("CREDIT_CARD_ERROR_27","Неверный владелец карты");
define("CREDIT_CARD_ERROR_28","Неверный номер авторизации");
define("CREDIT_CARD_ERROR_31","Недействительный код подтверждения");
define("CREDIT_CARD_ERROR_32","Неверный номер транзакции");
define("CREDIT_CARD_ERROR_57","Неверный ссылочный номер");
define("CREDIT_CARD_ERROR_58","Недопустимая строка AVS, длина строки AVS превысила максимум 40 символов");
define('CREDIT_CARD_ERROR_260','Служба временно недоступна из-за ошибки сети. попробуйте позже или обратитесь к своему менеджеру.');
define('CREDIT_CARD_ERROR_301','Служба временно недоступна из-за ошибки сети. попробуйте позже или обратитесь к своему менеджеру.');
define('CREDIT_CARD_ERROR_304','Учетная запись не найдена. Проверять информацию или связываться с банком-эмитентом.');
define('CREDIT_CARD_ERROR_401','Эмитент хочет иметь голосовой контакт с держателем карты. Позвоните в свой банк-эмитент.');
define('CREDIT_CARD_ERROR_502','Карта считается утерянной/украденной. Обратитесь в банк-эмитент. Внимание: Не относится к American Express.');
define('CREDIT_CARD_ERROR_505','Ваш учетный записи находится в отрицательном файле. Попробуйте другую карту или способ оплаты.');
define('CREDIT_CARD_ERROR_509','Превышать лимит на вывод средств или сумму активности. Попробуйте другую карту или способ оплаты.');
define('CREDIT_CARD_ERROR_510','Превышать лимит на вывод средств или сумму активности. Попробуйте другую карту или способ оплаты.');
define('CREDIT_CARD_ERROR_519','Ваш учетный записи находится в отрицательном файле. Попробуйте другую карту или способ оплаты.');
define('CREDIT_CARD_ERROR_521','Общая сумма превышает кредитный лимит. Попробуйте другую карту или способ оплаты.');
define('CREDIT_CARD_ERROR_522','Истек срок действия вашей банковской карты. Проверьте срок годности или попробуйте другой способ оплаты.');
define('CREDIT_CARD_ERROR_530','Отсутствие информации, предоставленной банком-эмитентом. Обратитесь в банк или попробуйте другой способ оплаты.');
define('CREDIT_CARD_ERROR_531','Эмитент отклонил запрос на аутентификацию. Обратитесь в банк-эмитент или попробуйте другой способ оплаты.');
define('CREDIT_CARD_ERROR_591','Банк-эмитент недоступен. Обратитесь в банк-эмитент или попробуйте другую карту.');
define('CREDIT_CARD_ERROR_592','Банк-эмитент недоступен. Обратитесь в банк-эмитент или попробуйте другую карту.');
define('CREDIT_CARD_ERROR_594','Банк-эмитент недоступен. Обратитесь в банк-эмитент или попробуйте другую карту.');
define('CREDIT_CARD_ERROR_776','Дублирующая транзакция. Свяжитесь с вашим менеджером, чтобы подтвердить статус транзакции.');
define('CREDIT_CARD_ERROR_787','Из-за высокого риска сделка была отклонена. Попробуйте другой способ оплаты.');
define('CREDIT_CARD_ERROR_806','Ваша карта заблокирована. Попробуйте другую карту или способ оплаты.');
define('CREDIT_CARD_ERROR_825','Учетная запись не найдена. Проверять информацию и повторите попытку.');
define('CREDIT_CARD_ERROR_902','Служба временно недоступна из-за ошибки сети. попробуйте позже или обратитесь к своему менеджеру.');
define('CREDIT_CARD_ERROR_904','Ваша банковская карта не активирована. Обратитесь с вашим банком-эмитентом.');
define('CREDIT_CARD_ERROR_201','Неверный номер учетной записи/ошибка формата. Проверьте номер и попробуйте еще раз.');
define('CREDIT_CARD_ERROR_204','Неизвестная ошибка. попробуйте позже или выберите другой способ оплаты.');
define('CREDIT_CARD_ERROR_233','Номер кредитной карты не соответствует способу оплаты или неверный BIN. Попробуйте другую карту или способ оплаты.');
define('CREDIT_CARD_ERROR_239','Карта не поддерживается. Попробуйте другую карту или выберите другой способ оплаты.');
define('CREDIT_CARD_ERROR_261','Неверный номер учетной записи/ошибка формата. Проверьте номер и попробуйте еще раз.');
define('CREDIT_CARD_ERROR_351','Служба временно недоступна из-за ошибки сети. попробуйте позже или обратитесь к своему менеджеру.');
define('CREDIT_CARD_ERROR_755','Учетная запись не найдена. Проверять информацию или связываться с банком-эмитентом.');
define('CREDIT_CARD_ERROR_758','Счет заморожен. Обратитесь в банк-эмитент или попробуйте другой способ оплаты.');
define('CREDIT_CARD_ERROR_834','Карта не поддерживается. Попробуйте другую карту или способ оплаты.');
define('HISTORY_TIPS', 'Здесь вы можете выбрать офлайн-предложение, созданное менеджером.');
define('TIPS_BUTTON', 'Подтвердить');

define('FS_CHECKOUT_EPIDEMIC_TIPS', 'Из-за официальных административных мер доставка может быть отложена или ограничена.
Убеждаться, что кто-то принимать доставку, иначе посылка будет возвращена отправителю.');
define('FS_CHECKOUT_CUSTOMS_CLEARANCE_TIPS', 'Доставка может быть задержана из-за растаможки.');

//quote成功发送邮件新增
define('QUOTES_NOTE_TITLE','Внимание:');
define('QUOTES_NOTE_TIPS','Запас, дата доставки, предполагаемые налоги и стоимость доставки могут измениться и будут рассчитаны при оформлении заказа.');
define('QUOTES_RQN_NUMBER_TITLE','RQN:');
define('QUOTES_TRADE_TERM_TITLE','Условия торговли:');
define('QUOTES_PAYMENT_TERM_TITLE','Срок платежа:');
define('QUOTES_SHIP_VIA_TITLE','Способ доставки:');
define('QUOTES_DATE_ISSUED_TITLE','Дата:');
define('QUOTES_EXPIRES_TITLE','Дата истечения:');
define('QUOTES_ACCOUNT_MANAGER_TITLE','Менеджер:');
define('QUOTES_ACCOUNT_EMAIL_TITLE','Электронная почта:');
define('QUOTES_DELIVER_TO','Адрес доставки');
define('QUOTES_BILLING_TO','Адрес выставления счета');
define('QUOTES_QUOTE_TITLE1',' Товар(ы)');
define('QUOTES_QUOTE_TITLE2','Кол-во');
define('QUOTES_QUOTE_TITLE3','Цена за ед.');
define('QUOTES_QUOTE_TITLE4','Кол-во (шт.)');


define('FS_WHAT_IS_DIFFERENCE', "В чём разница?");
define('FS_AVAILABILITY', 'Доступность');
define('FS_ON_SALE', 'Доступны');
define('FS_END_SALE', 'Недоступны');
define('FS_DIFFERENCES', 'Перед покупкой внимательно проверять подробные параметры, чтобы полностью понять различия товаров.');

define('FS_CN_LIMIT_TIPS', 'Этот товар не может быть доставлен в Китай.');
define('QUOTE_MESSAGE_TXT_1', 'Дополнительные комментарии (от '. $_SESSION['customer_first_name'].')');
define('QUOTE_MESSAGE_TXT_2', 'Дополнительные комментарии (От менеджера | FS)');
