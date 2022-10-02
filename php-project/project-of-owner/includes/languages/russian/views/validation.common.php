<?php
// 公共表单验证
// firstname
define('FS_FIRST_REQUIRED_TIP',"Введите ваше имя.");
define('FS_FIRST_MIN_TIP',"Имя должно содержать не менее 2 символов.");
define('FS_FIRST_MAX_TIP',"Введите не более 32 символов.");
// lastname
define('FS_LAST_REQUIRED_TIP',"Введите вашу фамилию.");
define('FS_LAST_MIN_TIP',"Фамилия должна содержать не менее 2 символов.");
define('FS_LAST_MAX_TIP',"Фамилия должна быть не более 32 символов.");
// email
define('FS_YOUR_EMAIL_ADDRESS',"Ваш Email");
define('FS_EMAIL_REQUIRED_TIP',"Введите ваш email");
define('FS_EMAIL_FORMAT_TIP',"Введите email.");
define('FS_EMAIL_HAS_REGISTERED_TIP',"Данный адрес электронной почты уже зарегистрирован.");
define('FS_EMAIL_HAS_REGISTERED_TIP1',"Данный адрес электронной почты уже зарегистрирован. Вы можете изменить на другой.");
define('FS_EMAIL_NOT_FOUND_TIP',"Данный адрес электронной почты не зарегистрирован.");
define('FS_EMAIL_NOT_ACTIVED_TIP','Сожалею! Ваша почта не активирована. Войдите в почту, чтобы активировать.');
define ('FS_EMAIL_HAS_REGISTERED_TIP_01',"Аккаунт уже существует. Нажмите здесь, чтобы <a href='".zen_href_link(FILENAME_LOGIN,'','SSL')."'> войти </a>.");

// new email
define('FS_NEW_EMAIL_ADDRESS','Новый адрес электронной почты');
define('FS_NEW_EMAIL_REQUIRED_TIP',"Поле «новый адрес эректронной почты» обязательно для заполнения.");
// confirm new email
define('FS_CONFIRM_NEW_EMAIL','Повторите новый адрес электронной почты');
define('FS_CONFIRM_NEW_EMAIL_REQUIRED_TIP',"Поле «повторите новый адрес эректронной почты» обязательно для заполнения.");
define('FS_NEW_EMAIL_MATCH_TIP',"Новые адресы эректронной почты должны быть одинаковыми.");
// password
define('FS_PASSWORD_REQUIRED_TIP',"Введите пароль");
define('FS_CURRENT_PASSWORD_REQUIRED_TIP',"Введите текущий пароль.");
define('FS_PASSWORD_FORMAT_TIP',"Минимум 6 символов; пороль должен содержать хотя бы одну букву и одну цифру.<br/>Специальные символы(_ ? @ ! # $ % & * .) разрешены.");
define('FS_PASSWORD_ERROR_TIP',"Этот пароль неправильный. Попробуйте еще раз, пожалуйста.");
define('FS_OLD_PASSWORD_ERROR_TIP',"Ваш старый пароль неверен, проверьте его ещё раз, пожалуйста !");
// confirm password
define('FS_CONFIRM_PASSWORD',"Повторите пароль");// 只有注册表单才需要
define('FS_CONFIRM_PASSWORD_REQUIRED_TIP',"Подтвердите свой новый пароль.");
define('FS_PASSWORD_MATCH_TIP',"Пароли должны быть одинаковыми.");
// new password
define('FS_NEW_PASSWORD','Новый пароль');
define('FS_NEW_PASSWORD_REQUIRED_TIP',"Введите новый пароль.");
define('FS_PASSWORD_REQUIREMENT',"Ваш пароль должен:");
define('FS_PASSWORD_REQUIREMENT1',"содержать не менее 6 символов");
define('FS_PASSWORD_REQUIREMENT2',"содержать минимум одну букву и одну цифру");
// confirm new password
define('FS_CONFIRM_NEW_PASSWORD','Повторите новый пароль');
define('FS_CONFIRM_NEW_PASSWORD_REQUIRED_TIP',"Поле «повторите новый пароль» обязательно для заполнения.");
define('FS_PASSWORD_DIFFERENT','Новый пароль должен отличаться от старого');
define('FS_NEW_PASSWORD_MATCH_TIP',"Новые пароли должны быть одинаковыми.");
//验证码
define('FS_IMAGE',"Картинка");
define('FS_TRY_DIFFERENT_IMAGE',"Показать другую картинку");
define('FS_TYPE_CHAR',"Введите символы");
define('FS_IMAGE_FORM_TIP',"Введите символы, которые Вы видите на картинке.");
// AGREE
define('FS_AGREE_REQUIRED_TIP', 'Пожалуйста, соглашайтесь с нашей политикой, чтобы продолжить.');
//Company name
define('FS_COMPANY_NAME_REQUIRED_TIP',"Введите название Вашей компании, пожалуйста.");
define('FS_COMPANY_NAME_MIN_TIP',"Название компании должно быть не менее двух символов.");
//industry
define('FS_SELECT_INDUSTRY','Выберите Отрасль');
define('FS_INDUSTRY_REQUIRED_TIP',"Выберите отрасль Вашей компании, пожалуйста.");
//TAX/VAT
define('FS_TAX_PLACEHOLDER','например:DE123456789');
define('FS_TAX_REQUIRED_TIP','Введите номер TAX.');
define('FS_TAX_FORMAT_TIP','Действительный номер TAX/VAT например: DE123456789');
define('FS_TAX_FORMAT_ARGENTINA_TIP','Введите действительный номер TAX, например: 00.000.000/0000-00.');
define('FS_TAX_FORMAT_BRAZIL_TIP','Введите действительный номер TAX, например: 00-00000000-0.');
define('FS_TAX_FORMAT_CHILE_TIP','Номер TAX должен содержать минимум 7 цифр.');
//phone
define('FS_PHONE_REQUIRED_TIP','Введите ваш номер телефона.');
define('FS_PHONE_FORMAT_TIP','Введите только цифры, не менее 7 символов.');
//国家
define('FS_SEARCH_YOUR_COUNTRY','Поиск вашей страны или региона');
define('FS_COUNTRY_REQUIRED_TIP','Выберите вашу страну/регион.');
//QTY
define('FS_PRODUCT_QTY_REQUIRED_TIP','Количество продукта требуется.');
define('FS_PRODUCT_QTY_FORMAT_TIP','Количество товара недействительно, исправьте его и попробуйте еще раз.');
// get a quote
define('COMMENTS_OR_QUESTIONS_REQUIRED_TIP','Комментарии/Вопросы требуются.');
// feedback
define('FEEDBACK_RATE_REQUIRED_TIP','Оцените данный товар.');
define('FEEDBACK_TOPIC_REQUIRED_TIP','Пожалуйста, выберите тему.');
define('FEEDBACK_CONTENT_REQUIRED_TIP','Пожалуйста, введите более 10 символов.');
// review
define('FS_REVIEW_RATING_REQUIRED_TIP','Пожалуйста, оцените этот продукт.');
define('FS_REVIEW_TITLE_REQUIRED_TIP','Требуется название вашего отзыва.');
define('FS_REVIEW_TITLE_MIN_TIP','Тема отзыва должна быть не менее 3 символов.');
define('FS_REVIEW_TITLE_MAX_TIP','Название вашего отзыва должно быть не более 200 символов.');
define('FS_REVIEW_CONTENT_REQUIRED_TIP','Требуется содержание вашего отзыва');
define('FS_REVIEW_CONTENT_MIN_TIP','Отзыв должен быть не менее 10 символов.');
define('FS_REVIEW_CONTENT_MAX_TIP', 'Вы можете ввести до 5000 символов.');
// my case
define('FS_CASE_TYPE_REQUIRED_TIP','Выберите тип сервиса.');
define('FS_CASE_CONTENT_REQUIRED_TIP','Пожалуйста, опишите ваши вопросы, чтобы мы могли быстрее обрабатывать ваш запрос.');
define('FS_CASE_CONTENT_MAX_TIP','Пожалуйста, не превышайте 5000 символов.');
// apply money
define('FS_APPLY_MONEY_REQUIRED_TIP','Пожалуйста, введите сумму, которую вы ожидаете.');
define('FS_APPLY_MONEY_FORMAT_TIP','Пожалуйста, введите допустимое количество до 2 десятичных знаков.');
define('FS_APPLY_MONEY_REASON_TIP','Пожалуйста, объясните, почему вам нужно увеличить сумму. Это будет полезно при обработке вашего запроса.');


define("FS_REVIEW_TITLE_REQUIRED_TIP_NEW",'Пожалуйста, заполните название вашего отзыва');
define('FS_REVIEW_CONTENT_REQUIRED_TIP_NEW','Заполните ваш отзыв, пожалуйста.');

define('FS_OLD_PASSWORD_REASON','Ваш старый пароль неверный, проверьте его еще раз, пожалуйста.');
