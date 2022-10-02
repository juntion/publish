<?php

define('FS_SALES_INFO_TITLE','RMA');
define('FS_SALES_INFO_TYPE1','Возврат');
define('FS_SALES_INFO_TYPE2','Замена');
define('FS_SALES_INFO_TYPE3','Ремонт');
define('FS_SALES_INFO_TYPE_SELECT_TIPS','Пожалуйста, выберите тип возврата.');
define('FS_SALES_INFO_Qty','Кол-во:');
define('FS_SALES_INFO_VALIDATE_MAG1','Это обязательное поле.');
define('FS_SALES_INFO_REASON','Причина:');
define('FS_SALES_INFO_REASON_SELECT','Выберите один');
define('FS_SALES_INFO_REASON_SELECT_TIPS','Пожалуйста, выберите причину возврата.');
define('FS_SALES_INFO_SERIES_NUMBER_TIPS1','Это поможет нам ускорить процесс.');
define('FS_SALES_INFO_SERIES_NUMBER_TIPS2','Различные серийные номера могут быть разделены ";, /".');
define('FS_SALES_INFO_FMS_TIPS','Этот предмет включает в себя следующие продукты.');
define('FS_SALES_INFO_ADS_TIPS','Доставка в адрес доставки');
define('FS_SALES_INFO_ADS_ADD','Добавьте новый адрес');
define('FS_SALES_INFO_RADIO_NONE','Вы не выбрали ни одного товара.');
define('FS_SALES_INFO_CANCEL','Cancel');//*
define('FS_SALES_INFO_SUBMIT','Отправить');
define('FS_SALES_INFO_INTRODUCE_TITLE','Инструкции по возврату: ');
define ('FS_SALES_INFO_CREATE_ADS', 'Подтвердить адрес доставки');
define('FS_SALES_INFO_CREATE_ADS_TITLE','По умолчанию следующий адрес совпадает с адресом доставки в исходном заказе.');

//退换货改版2020.3.16 dylan Add
define('FS_SALES_INFO_SERIES_NUMBER','Добавить серийный номер');
define('FS_SALES_INFO_STEPS_TIPS1','1. Выберите тип возврата');
define('FS_SALES_INFO_STEPS_TIPS2','2. Выберите возвращенные товары');
define('FS_SALES_INFO_STEPS_TIPS3','3. Причина возврата');
define('FS_SALES_INFO_STEPS_TIPS4','4. Возврат на');
define('FS_SALES_INFO_STEPS_TIPS5','4. Отправить по адресу');
define('FS_SALES_INFO_COMMENTS','Дополнительные комментарии');
define('FS_SALES_FILE_UPLOAD','Загрузить файл');
define('FS_SALES_INFO_COMMENTS_HOLDER','Предоставьте более подробную информацию, например, проблемы, с которыми вы столкнулись, среду приложения и т. д.');
define('FS_SALES_INFO_COMMENTS_ERROR','Заполните комментарии о причине вашего запроса на возврат, пожалуйста.');
define('FS_SALES_INFO_RETURN_TO_TYPE1','Кредитная карта');
define('FS_SALES_INFO_RETURN_TO_TYPE1_TIPS','Это то же самое, что и первоначальный <br>способ оплаты.');
define('FS_SALES_INFO_RETURN_TO_TYPE2','FS Кредит');
define('FS_SALES_INFO_RETURN_TO_TYPE2_TIPS','Это может быть использовано для ваших будущих заказов.');
define('FS_SALES_INFO_FILE_UPLOAD','Разрешить файлы типа PDF, JPG, PNG.<br>Максимальный размер файла 5M.');
define('FS_SALES_INFO_SHIP_TO_1','Отправлять часть замены в');
define('FS_SALES_INFO_SHIP_TO_TIPS_1','Это адрес, на который будут отправлены части замены.');
define ('FS_SALES_INFO_SHIP_TO_2', 'Отправлять отремонтированные товары в');
define ('FS_SALES_INFO_SHIP_TO_TIPS_2', 'Это адрес, на который будут отправлены отремонтированные товары.');
define('FS_SALES_INFO_INTRODUCE_CONT1',' Для того, чтобы FS эффективно обработал ваш запрос RMA, важно вернуть все, что было отправлено в оригинальном заказе. Это может включать в себя, помимо прочего, руководства, кабели, аксессуары, полную оригинальную розничную упаковку и любые комплектные предметы.');
define('FS_SALES_INFO_INTRODUCE_CONT2',' Вы должны положить форму RMA в коробке. Возврат без RMA не будет обработан.');
define('FS_SALES_INFO_INTRODUCE_CONT3',' Если вы положили несколько RMA в коробку, вы должны положить каждую форму RMA в пакет. Кроме того, будьте осторожны, чтобы пометить и отделить элементы в коробке, чтобы наш отдел возврата мог точно обработать вашу RMA.');
define('FS_SALES_INFO_INTRODUCE_CONT4',' Политика возврата FS не распространяется на определенные продукты. Если у вас есть какие-либо вопросы, пожалуйста, свяжитесь с нами.');

define('FS_SALES_INFO_SERVICE_TYPE_1','Тип Проблемы');
define('FS_SALES_INFO_SERVICE_TYPE_2','Товары не работают должным образом');
define('FS_SALES_INFO_SERVICE_TYPE_3','Заказать неправильные продукты');
define('FS_SALES_INFO_SERVICE_TYPE_4','Больше не нужны');
define('FS_SALES_INFO_SERVICE_TYPE_5','Получен неправильный товар');
define('FS_SALES_INFO_SERVICE_TYPE_6','Не соответствует тому, что мы показываем');
define('FS_SALES_INFO_SERVICE_TYPE_7','Поврежденны по прибытии');
define('FS_SALES_INFO_SERVICE_TYPE_8','Не так, как ожидалось');
define('FS_SALES_INFO_SERVICE_TYPE_9','Другие причины');

define('FS_SALES_INFO_SERVICE_SPE_FMS_TIPS','Транспондер/Мультиплексор и 100G CFP модуль должны быть возвращены вместе.');

define('RMA_RETURN_WIN_01','Ваш RMA # #RMA_NUMBER# был одобрен.');
define('RMA_RETURN_WIN_02','Распечатайте RMA и отправьте посылку обратно в FS.');
define('RMA_RETURN_WIN_03','Ваш RMA# #RMA_NUMBER# был отправлен.');
define('RMA_RETURN_WIN_04','Распечатайте RMA и отправьте посылку обратно в FS после подтверждения возврата.');

define('RMA_RETURN_IS_SOFTWARE', 'Программное обеспечение не подлежит возврату. Если у вас есть вопросы, обратитесь к менеджеру своего аккаунта.');
define('RMA_RETURN_CHANGE', 'Редактировать');
define('FS_SALES_COMMENTS_OPTIONAL', 'Дополнительные комментарии (Необязательно)');
?>