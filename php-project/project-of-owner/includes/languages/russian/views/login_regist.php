<?php
// fairy 2017.12.18 整理
// 语言包中用双引号，考虑到小语种尤其是法语中经常出现单引号的情况。
// 用户登录、注册、企业注册、修改资料。
define('FS_NEW_CUSTOMER',"Новый покупатель?");
define('FS_JOIN_NOW',"Присоединяйтесь сейчас");
define('FS_WELCOME_BACK',"Добро пожаловать обратно");
define('FS_WELCOME',"Добро пожаловать");
define('FS_REGIST_BUSINESS_ACCOUNT',"Корпоративный аккаунт");
define('FS_SUBMIT_UPDATE_TO_BUSINESS_ACCOUNT','Обновление аккаунта');
define('FS_ALREADY_HAS_ACCOUNT',"Есть аккаунт?");
define('FS_UPGRADE_NEW',"Регистрация");
//密码
define('FS_FORGOT_YOUR_PASSWORD',"Забыли Ваш пароль?");
//其他登录
define('FS_LOGIN_BY_OTHER',"Войти через");
define('FS_SIGN_IN_GOOGLE',"Вход через google");
define('FS_SIGN_IN_PAYPAL',"Вход через Paypal");
define('FS_SIGN_IN_FACEBOOK',"Вход через Facebook");
define('FS_SIGN_IN_LINKEDIN',"Вход через Linkedin");

// 企业注册
define('FS_COMPANY_INFO',"Информация о Компании");
define('FS_CONTACT_INFO',"КОНТАКТНАЯ ИНФОРМАЦИЯ");
define('FS_BUSINESS_REGIST_SUCCESS_TIP', 'Поздравляем! Вы успешно создали бизнес-аккаунт на FS.COM.');
// 行业选择
define('FS_INDUSTRY_SELECT_COM','Связи, Телекоммутация');
define('FS_INDUSTRY_SELECT_CONSTRUCT','Строительство');
define('FS_INDUSTRY_SELECT_CONSULT','Консалтинг');
define('FS_INDUSTRY_SELECT_ENERGY','Электроэнергетикка, Нефть');
define('FS_INDUSTRY_SELECT_GOVERNMENT','Правительственное Учреждение');
define('FS_INDUSTRY_SELECT_HEALTH','Медицинская практика');
define('FS_INDUSTRY_SELECT_IT','Инофрмационные технолонии и услуги');
define('FS_INDUSTRY_SELECT_MANU','Производство, Химическая промышленность');
define('FS_INDUSTRY_SELECT_MEDIA','СМИ, Издательское дело, Рекламное дело');
define('FS_INDUSTRY_SELECT_NON','Некоммерческая Организация');
define('FS_INDUSTRY_SELECT_RETAIL','Рознияная и оптовая торговля');
define('FS_INDUSTRY_SELECT_SERVICE','Сервис');
define('FS_INDUSTRY_SELECT_TRANS','Логистика');
// 企业升级
define('FS_APPLY_BUSINESS_SUCCESS_TIP','Ваша заявка получена, пожалуйста, дождитесь подтверждения и проверки.');
define('FS_APPLY_BUEINESS_EXIST_TIP','Указанный e-mail уже зарегистрирован в качестве бизнес-аккаунта или находится на рассмотрении для перехода в бизнез-аккаунт.');
define('FS_APPLY_BUSINESS_SUCCESS_JUMP_TIP',"Нажмите здесь, чтобы войти в личный кабинет.");

// 游客登录页面
define('FS_LOGIN_REGIST_GUEST','Оформить заказ в качестве гостя');
define('FS_LOGIN_REGIST','Регистрация');
define('FS_LOGIN_REGIST_1','Оформить заказ в качестве гостя');
define('FS_LOGIN_REGIST_2','У вас нет аккаунта?');
define('FS_LOGIN_REGIST_3','Ваша покупка станет проще:');
define('FS_LOGIN_REGIST_4','Сохраненные адреса доставки');
define('FS_LOGIN_REGIST_5','Списки покупок');
define('FS_LOGIN_REGIST_6','Быстрый доступ к истории заказов');
define('FS_LOGIN_REGIST_7','Не хотите зарегистрироваться?');
define('FS_LOGIN_REGIST_8','Перейти к оформлению заказа и зарегистрироваться позже.');

// fairy 2018.8.8 改版
define('FS_MY_FS_ADVANTAGE',"Если у вас есть аккаунт FS");
define('FS_MY_FS_ADVANTAGE0',"Вы можете");
define('FS_MY_FS_ADVANTAGE1',"Оплатить быстро и легко");
define('FS_MY_FS_ADVANTAGE2',"Посмотреть и отследить заказы");
define('FS_MY_FS_ADVANTAGE3',"Запросить КП или отправить PO");
define('FS_MY_FS_ADVANTAGE4',"Получить техническую поддержку и решение");
define('FS_DONT_HAVE_FS_ACCOUNT',"У вас нет аккаунта?");
define('FS_QUICKLY_SET_UP_ACCOUNT',"Создайте безопасный аккаунт сразу.");
define('FS_LOG_ADVANTAGE',"Войдите в личный кабинет для быстрого оформления заказа. ");
define('FS_SIGN_OR_LOGIN','Войти в FS или <a href="'.zen_href_link('regist','','SSL').'">Регистрация</a>');
define('FS_HAVE_ACCOUNT','Есть аккаунт? <a href="'.zen_href_link(FILENAME_LOGIN,'','SSL').'">Войти</a>');

define('FS_THIRD_PARTY_BIND_TIP',"Если у вас уже есть аккаунт FS.COM, вы можете связать его, чтобы помочь нам лучше поддерживать ваши личные данные.");
define('FS_LINK_NOW',"Связать сейчас");
define('FS_HAVE_FS_ACCOUNT',"У вас нет аккаунт FS.COM?");
define('FS_GOOGLE_USER_DEAR',"Уважаемый");
define('FS_GOOGLE_USER_USER',"пользователь");
define('FS_GOOGLE_USER_WELCOME',", добро пожаловать");
define('FS_SKIP',"пропускать");
//2018-10-9carr m端游客入口
define('FS_LOG_ChecGuest',"Платить без регистрации");

//2018 12 4 helun
define('FS_LOG_RE_01',"Новый клиент");
define('FS_LOG_RE_02',"Экономить время сейчас.");
define('FS_LOG_RE_03',"Вам не нужен новый аккаунт для оформления заказа.");
define('FS_LOG_RE_04',"Экономить время в будушее.");
define('FS_LOG_RE_05',"Создайте FS.COM аккаунт для быстрого оформления заказа <br>и легкого доступа к истории заказов.");


// 登录页面remember me和气泡
define('FS_REMEMBER_ME',"Запомнить меня");
define('FS_SIGN_IN_REMEMBER_ME_01',"Чтобы обеспечить безопасность Вашего личного кабинета, ");
define('FS_SIGN_IN_REMEMBER_ME_02',"используйте эту опцию только на своих личных устройствах. ");

// 2020-02-25 登录注册页文案优化
define ('FS_LOGIN_RIGHT_TITLE', 'Войти в FS или');
define ('FS_FORGOT_PASSWORD', "Забыли пароль?");
define ('FS_LOGIN_KEEP_ME_SIGNED_IN', 'Запомнить');
define ('FS_LOGIN_OTHER_NEW', 'Войти через');
define ('FS_EMAIL_ADDRESS_NEW', "E-mail");

// 2020-10-12 第三方登陆
define('FS_3RD_01','Пароль');
define('FS_3RD_02','Подтвердите пароль');
define('FS_3RD_03','Отправить');
define('FS_3RD_04','Уже использовал FS');
define('FS_3RD_05','Связаться с существующим аккаунтом');
define('FS_3RD_06','@@@ Адрес электронной почты:');
define('FS_3RD_07','Мы будем использовать ваши данные @@@ для создания аккаунт FS.');
define('FS_3RD_08','Регистрация');

define('FS_3RD_09','Связаться с существующим аккаунтом');
define('FS_3RD_10','Войдите в FS, чтобы связать свой аккаунт с @@@.');
define('FS_3RD_11','Email');
define('FS_3RD_12','Пароль');
define('FS_3RD_14','Связаться с вашими аккаунтами');
define('FS_3RD_15','Вы также можете:');

define('FS_3RD_16','Связано успешно.');
define('FS_3RD_17','Вы можете использовать аккаунт @@@ для быстрого входа в FS ID.');
define('FS_3RD_18','Регистрация');

// 2020-10-27 忘记密码
define('FS_PS_PASSWORD_FORGOTTEN_TOO_FREQUENT','Вы слишком часто выполняете это действие. Повторите попытку через 1 минуту.');