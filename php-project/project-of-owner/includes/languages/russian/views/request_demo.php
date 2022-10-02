<?php
define('REQUEST_DEMO_BANNER_TITLE', 'Демонстрация сетевого коммутатора');

define('REQUEST_DEMO_ALREADY_HAVE_AN_ACCOUNT','Уже есть аккаунт? <a href="'.zen_href_link(FILENAME_LOGIN,'','SSL').'">Войти</a> или <a href="'.zen_href_link(FILENAME_REGIST,'','SSL').'">Регистрация</a>');

define('REQUEST_DEMO_INDUSTRY', 'Отрасль');
define('REQUEST_DEMO_OPTION_DEFAULT', 'Выберите');
define('REQUEST_DEMO_INDUSTRY_OPTION_1', 'Искусство/Развлечения');
define('REQUEST_DEMO_INDUSTRY_OPTION_2', 'Образование-высшее образование');
define('REQUEST_DEMO_INDUSTRY_OPTION_3', 'Edu - K-12, государственное & частное');
define('REQUEST_DEMO_INDUSTRY_OPTION_4', 'Edu - Другие');
define('REQUEST_DEMO_INDUSTRY_OPTION_5', 'Энергетика/Коммунальные услуги');
define('REQUEST_DEMO_INDUSTRY_OPTION_6', 'Финансовые услуги');
define('REQUEST_DEMO_INDUSTRY_OPTION_7', 'Правительство');
define('REQUEST_DEMO_INDUSTRY_OPTION_8', 'Здравоохранение');
define('REQUEST_DEMO_INDUSTRY_OPTION_9', 'Высокие технологии - программное обеспечение/оборудование');
define('REQUEST_DEMO_INDUSTRY_OPTION_10', 'Гостиничный бизнес/Гостиницы & отдых');
define('REQUEST_DEMO_INDUSTRY_OPTION_11', 'Библиотека');
define('REQUEST_DEMO_INDUSTRY_OPTION_12', 'Производство');
define('REQUEST_DEMO_INDUSTRY_OPTION_13', 'Медиа/Развлечения');
define('REQUEST_DEMO_INDUSTRY_OPTION_14', 'Некоммерческие & Членские организации');
define('REQUEST_DEMO_INDUSTRY_OPTION_15', 'Другой');
define('REQUEST_DEMO_INDUSTRY_OPTION_16', 'Професиональные услуги');
define('REQUEST_DEMO_INDUSTRY_OPTION_17', 'Розничная торговля/Ресторан');
define('REQUEST_DEMO_INDUSTRY_OPTION_18', 'Поставщик услуг');
define('REQUEST_DEMO_INDUSTRY_OPTION_19', 'Транспорт');
define('REQUEST_DEMO_INDUSTRY_OPTION_20', 'VAR/системный интегратор');
define('REQUEST_DEMO_INDUSTRY_OPTION_21', 'Оптовая/Распространение');


define('REQUEST_DEMO_COMPANY', 'Компания');
define('REQUEST_DEMO_COMPANY_SIZE', 'Размер компании');
define('REQUEST_DEMO_COMPANY_SIZE_TIP_01', '1 - 99');
define('REQUEST_DEMO_COMPANY_SIZE_TIP_02', '100 - 999');
define('REQUEST_DEMO_COMPANY_SIZE_TIP_03', '1,000 - 1,999');
define('REQUEST_DEMO_COMPANY_SIZE_TIP_04', '2,000 - 3,999');
define('REQUEST_DEMO_COMPANY_SIZE_TIP_05', '4,000+');

define('REQUEST_DEMO_COMMENT_OPTIONAL', 'Отзыв (необязательно) :');
define('REQUEST_DEMO_COMMENT_OPTIONAL_PLACEHOLDER', 'Попробовать разместить свой вопрос.');

define('REQUEST_DEMO_SEARCH_RESULT', 'Нет результата для "#KEYWORD#", дважды проверьте правильность написания.');
define('REQUEST_DEMO_HOT_SEARCH', 'Хит:');
define('REQUEST_DEMO_HOT_SCHEDULE_TIME', 'Назначить время');

define('REQUEST_DEMO_TIP_01', 'Попробовать коммутатор FS');
define('REQUEST_DEMO_TIP_02', 'Наша служба удаленного тестирования позволяет пользователям развертывать и подключаться к коммутаторам, работающим в нашей лаборатории, получать удаленный доступ к этим коммутаторам для их работы.');
define('REQUEST_DEMO_TIP_03', 'Что для меня может сделать демо FS:');
define('REQUEST_DEMO_TIP_04', '100+ функций опыта');
define('REQUEST_DEMO_TIP_05', 'Функциональные испытания');
define('REQUEST_DEMO_TIP_06', 'Совместимость фирменных коммутаторов');
define('REQUEST_DEMO_TIP_07', 'Стандартные сценарии применения');
define('REQUEST_DEMO_TIP_08', 'Заказать решение');
define('REQUEST_DEMO_TIP_09', 'Чего я могу ожидать?');
define('REQUEST_DEMO_TIP_10', 'Моделирование пользовательских сценариев,ощущение работы на месте');
define('REQUEST_DEMO_TIP_11', 'Никакой задержки, никакого замораживания экрана');
define('REQUEST_DEMO_TIP_12', '1 минута доступа, 30 минут опыта');
define('REQUEST_DEMO_TIP_13', 'Онлайн-поддержка технического инженера один на один');

define('REQUEST_DEMO_FORM_01', 'Какой коммутатор вас интересует?');
define('REQUEST_DEMO_FORM_02', 'Какие функции вы хотите попробовать?');

define('REQUEST_DEMO_SUCCESS_TIP_01', 'Ваш запрос #NUMBER# успешно отправлен.');
define('REQUEST_DEMO_SUCCESS_TIP_02', 'Мы свяжемся с вами в течении 24 часов.');

define('REQUEST_DEMO_SEARCH_DEFAULT_ARRAY', json_encode(array(
    array('id' => 1, 'txt' => 'VLAN'),
    array('id' => 2, 'txt' => 'QINQ'),
    array('id' => 3, 'txt' => 'LACP'),
    array('id' => 4, 'txt' => 'Static routing'),
    array('id' => 5, 'txt' => 'RIP'),
    array('id' => 6, 'txt' => 'RIPng'),
    array('id' => 7, 'txt' => 'OSPFv2'),
    array('id' => 8, 'txt' => 'OSPFv3'),
    array('id' => 9, 'txt' => 'BGP4'),
    array('id' => 10, 'txt' => 'SNMP'),
    array('id' => 11, 'txt' => 'Web'),
    array('id' => 12, 'txt' => 'sFlow'),
    array('id' => 13, 'txt' => 'SSH'),
    array('id' => 14, 'txt' => 'DHCP Snooping'),
    array('id' => 15, 'txt' => 'DHCP Server'),
    array('id' => 16, 'txt' => 'DHCP Client'),
    array('id' => 17, 'txt' => 'DHCP Relay'),
    array('id' => 18, 'txt' => 'NTP'),
    array('id' => 19, 'txt' => 'Stacking')
)));
define('REQUEST_DEMO_SEARCH_OTHERS_ARRAY', json_encode(array(
    array('id' => 20, 'txt' => 'flow-control'),
    array('id' => 21, 'txt' => 'STP'),
    array('id' => 22, 'txt' => 'RSTP'),
    array('id' => 23, 'txt' => 'MSTP'),
    array('id' => 24, 'txt' => 'Storm suppression'),
    array('id' => 25, 'txt' => 'Mirror'),
    array('id' => 26, 'txt' => 'Static MAC addresses'),
    array('id' => 27, 'txt' => 'RLDP'),
    array('id' => 28, 'txt' => 'lldp'),
    array('id' => 29, 'txt' => 'Layer2 Protocol tunnel'),
    array('id' => 30, 'txt' => 'REUP'),
    array('id' => 31, 'txt' => 'G.8032'),
    array('id' => 32, 'txt' => 'VCT'),
    array('id' => 33, 'txt' => 'igmp-snooping'),
    array('id' => 34, 'txt' => 'MLD snooping'),
    array('id' => 35, 'txt' => 'ipv4 vrf'),
    array('id' => 36, 'txt' => 'ipv6'),
    array('id' => 37, 'txt' => 'IGMP'),
    array('id' => 38, 'txt' => 'PIM-DM'),
    array('id' => 39, 'txt' => 'PIM-SM'),
    array('id' => 40, 'txt' => 'PIM-SSM'),
    array('id' => 41, 'txt' => 'RIPng'),
    array('id' => 42, 'txt' => 'ospfv3'),
    array('id' => 43, 'txt' => 'BGP4+'),
    array('id' => 44, 'txt' => 'ACL'),
    array('id' => 45, 'txt' => 'QoS'),
    array('id' => 46, 'txt' => 'Tacacs+'),
    array('id' => 47, 'txt' => '802.1x'),
    array('id' => 48, 'txt' => 'безопасность порта'),
    array('id' => 49, 'txt' => 'DAI'),
    array('id' => 50, 'txt' => 'защита источника IP'),
    array('id' => 51, 'txt' => 'TFTP'),
    array('id' => 52, 'txt' => 'FTP'),
    array('id' => 53, 'txt' => 'SNTP'),
    array('id' => 54, 'txt' => 'VRRP')
)));

define('REQUEST_DEMO_FORM_TIP_01', 'Выбрать отрасль.');
define('REQUEST_DEMO_FORM_TIP_02', 'Введите название вашей компании.');
define('REQUEST_DEMO_FORM_TIP_03', 'Выбрать размер вашей компании.');
define('REQUEST_DEMO_FORM_TIP_04', 'Выбрать коммутатор.');
define('REQUEST_DEMO_FORM_TIP_05', 'Выбрать хотя бы одну функцию.');
define('REQUEST_DEMO_FORM_TIP_06', 'Выбрать время.');

define('REQUEST_DEMO_EMAIL_01','FS - Мы получили ваш запрос на демонстрацию ');
define('REQUEST_DEMO_EMAIL_02','Мы получили ваш запрос на демонстрацию <a style="color: #0070bc;text-decoration: none" target="_blank" href="#HREF#">#NUMBER#</a>, вы можете ссылаться на этот номер во всех последующих сообщениях далее.');
define('REQUEST_DEMO_EMAIL_03','Ниже приводится тестовая информация:');
define('REQUEST_DEMO_EMAIL_04','Модель коммутатора: ');
define('REQUEST_DEMO_EMAIL_05','Заинтересованные Функции: ');
define('REQUEST_DEMO_EMAIL_06','Запланированное время: ');
define('REQUEST_DEMO_EMAIL_07','Перед запуском тестовой демонстрации подготовьте программное обеспечение <a style="color: #0070bc;text-decoration: none" target="_blank" href="https://www.teamviewer.com/download/windows/">TeamViewer</a> , и наша команда свяжется с вами в ближайшее время.');
define('REQUEST_DEMO_EMAIL_08','Ваш TeamViewer<b>Partner (FS) ID - 658526138</b>, и пароль будет отправлен вам за 15 минут до запланированного времени.');

define('REQUEST_DEMO_SEARCH','Поиск');