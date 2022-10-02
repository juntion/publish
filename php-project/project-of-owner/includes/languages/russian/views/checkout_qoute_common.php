<?php
$language_package = array(
    'confirm_order' => 'Оформить заказ',
    'shaft_cart' => 'Корзина',
    'shaft_confirm_order' => 'Оформить заказ',
    'shaft_order_payment' => 'Оплата',
    //地址栏基础语言包
    'address_add' => 'Добавить новый адрес',
    'address_shipping' => 'Адрес доставки',
    'address_billing' => 'Адрес выставления счета',
    'address_change' => 'Редактировать',
    'address_first_name' => 'Имя',
    'address_last_name' => 'Фамилия',
    'address_country' => 'Страна/Регион',
    'address_type' => 'Тип плательщика',
    'address_type_default' => 'Выберите',
    'address_type_business' => 'рабочий',
    'address_type_individual' => 'частный',
    'address_eu_type_business' => 'Рабочий',
    'address_eu_type_individual' => 'Частный',
    'address_au_type_business' => 'рабочий',
    'address_au_type_individual' => 'частный',
    'address_company_name' => 'Название Компании',
    'address_street_1' => 'Адрес, Первая Строка',
    'address_street_2' => 'Адрес, Вторая Строка',
    'address_street_placeholder_1' => 'Улица, c/o',
    'address_street_placeholder_2' => 'Квартира, дом, этаж и т.д.',
    'address_city' => 'Город',
    'address_state' => 'Страна/Провинция/Регион',
    'address_post_code' => 'Почтовый Индекс',
    'address_phone_number' => 'Телефона',
    'address_state_default' => 'Выберите область',
    'address_choice_notice' => 'Выберите адрес.',
    'address_invalid_notice' => 'Выбранный вами адрес недействителен. Перепроверьте свой адрес.',
    'address_avatax_error' => 'Выбранный вами адрес доставки недействителен. Проверьте свой адрес доставки.',

    // share order shipping news 语言包
    'share_popup_title' => 'Поделяться новостями об отправке заказа',
    'share_popup_name' => 'Получатель/Имя',
    'share_popup_email' => 'Адрес электронной почты',
    'share_popup_warn' => 'Уведомление об отправке будет отправлено на email, на котором размещен заказ (по умолчанию), и введенный email.',
    'share_popup_back' => 'Назад',
    'share_popup_save' => 'Сохранить',
    'share_popup_email_required' => 'Ваш адрес электронной почты обязателен.',
    'share_popup_email_valid' => 'Введите действительный email.',



    //地址栏欧盟语言包
    'address_eu_street_1' => 'Улица и номер дома',
    'address_eu_street_2' => 'Дополнительный адрес',
    'address_eu_post_code' => 'Почтовый Индекс',
    //地址栏澳洲语言包
    'address_au_city' => 'Город',
    'address_au_state' => 'State',
    'address_au_post_code' => 'Почтовый Индекс',
    //地址栏俄罗斯语言包
    'address_ru_type' => 'Тип плательщика',
    'address_ru_type_business' => 'Юридическое лицо /ИП',
    'address_ru_type_individual' => 'Физическое лицо',
    'address_ru_delete' => 'Удалить реквизиты? ',

    //地址栏所有税号框语言包
    'address_tax_input_title' => 'ИНН',
    'address_tax_input_tips' => 'Для ускорения таможенного оформления, заполните действующий налоговый номер.',
    'address_eu_tax_input_title' => 'НДС/Налоговый номер',
    'address_eu_tax_input_tips' => 'Если у вас есть действующий налоговый номер, вы можете быть освобождены от уплаты НДС.',
    'address_non_eu_tax_input_title' => 'Налоговый номер',
    'address_non_eu_tax_input_tips' => 'Для ускорения таможенного оформления, заполните действующий налоговый номерr.',
    'address_au_tax_input_title' => 'ABN',
    'address_ec_tax_input_title' => 'RUC',
    'address_sg_tax_input_title' => 'Номер GST',
    'address_in_tax_input_title_1' => 'PAN',
    'address_in_tax_input_title_2' => 'GSTIN',
    //清关困难国家税号框TITLE
    'address_cl_tax_input_title' => 'RUT',
    'address_br_tax_input_title_1' => 'CNPJ',
    'address_br_tax_input_title_2' => 'CPF',
    'address_ar_tax_input_title_1' => 'CUIT',
    'address_ar_tax_input_title_2' => 'CUIL',
    //地址锁定语言包
    'address_lock_australia_1' => 'FS Австралия',
    'address_lock_australia_2' => 'Заказы на этом сайте не могут быть доставлены в Австралию. Перейдите на',
    'address_lock_australia_3' => 'если вы хотите отправить в Австралию.',

    'address_lock_us_1' => 'FS Соединенные Штаты',
    'address_lock_us_2' => 'Заказы на этом сайте не могут быть доставлены в США. Перейдите на',
    'address_lock_us_3' => 'если вы хотите доставить в США.',

    'address_lock_ru_1' => "FS Российская Федерация",
    'address_lock_ru_2' => 'Для юр. лиц заказы должны быть оплачены безналичным расчетом в рублях. Перейдите на',
    'address_lock_ru_3' => 'если вы хотите разместить заказ.',

    'address_lock_cn_1' => 'Некоторые товар не может быть доставлен в Китай, вернуться их ',
    'address_lock_cn_2' => 'в корзину',
    'address_lock_cn_3' => ' и удалить.',
    'cn_limit_ads_tips' => "Некоторые товар не может быть доставлен в Китай, вернуться их <a href='".zen_href_link('shopping_cart')."'>в корзину</a> и удалить.",
    'cn_limit_products_tips' => "Этот товар не может быть доставлен в Китай.",

    //地址栏报错提示语
    'address_first_name_error' => 'Введите имя',
    'address_last_name_error' => 'Введите фамилию.',
    'address_address_type_error' => 'Введите тип адреса.',
    'address_company_name_error' => 'Введите название вашей компании.',
    'address_street_1_error' => 'Введите адрес.',
    'address_city_error' => 'Введите город.',
    'address_state_error' => 'Введите область.',
    'address_post_code_error' => 'Введите почтовый индекс.',
    'address_phone_number_error' => 'Введите номер телефона.',
    'address_tax_input_error' => 'введите действительный номер плательщика НДС. Например: $VAT',
    'address_tax_input_error_required' => 'Введите номер НДС',

    'address_popup_tips' => 'Для доставки требуется подпись. Мы не отправляем на почтовые ящики.',
    //支付方式语言包
    'payment_title' => 'Способ оплаты',
    'payment_credit_title' => '	Кредитная/Дебетовая Карта',
    'payment_credit_content' => "FS принимает все следующие карты и P-карты. Выбор вашей кредитной карты и ввод данных вашей кредитной карты происходит после нажатия \"Оформить заказ\".",
    'payment_paypal_title' => 'PayPal/Кредитная Карта PayPal',
    'payment_paypal_content' => 'Нажмите "Оформить заказ" , и вы будете перенаправлены на ваш счет PayPal для завершения платежа, а статус заказа будет отслеживаться.',
    //Electronic支付方式语言包
    'payment_electronic_title' => 'Электронный Чек (ECheck)',
    'payment_electronic_content' => 'Мы принимаем только электронные чеки, выданные банками США. Обработка платежа может занимать 1-2 рабочих дня.',
    'payment_erc_name' => 'Bank Название банка получателя',
    'payment_erc_number' => 'Bank Счет получателя',
    'payment_erc_type' => 'Account Type',
    'payment_erc_type_options_1' => 'Checking',
    'payment_erc_type_options_2' => 'Saving',
    'payment_erc_number_confirm' => 'Confirm Bank Счет получателя',
    'payment_erc_routing_number' => 'ABA /ACH routing number',
    'payment_erc_name_error' => 'Требуется Bank Название банка получателя.',
    'payment_erc_number_error' => 'Требуется Bank Счет получателя.',
    'payment_erc_account_type' => 'Тип аккаунта',
    'payment_erc_number_confirm_error' => 'Требуется Bank Счет получателя.',
    'payment_erc_number_confirm_error_1' => 'Please enter the same value again.',
    'payment_erc_routing_number_error' => 'Bank ABA /ACH routing Number is required.',
    'payment_wire_desc' => 'Получать оплату банковским переводом в течение 1-3 рабочих дней.',
    //bank transfer 语言包
    'payment_us_no_ach_policy_hsbc' => [
        'payment_title' => 'Банк Америки',
        'details' => [
            [
                'title' => '',
                'info' => [
                    [
                        'key' => 'Название банка получателя:',
                        'value' => 'FS COM INC'
                    ],
                    [
                        'key' => 'Счет Бенефициара #:',
                        'value' => '138 119 625 329'
                    ],
                    [
                        'key' => 'Номер Маршрута #:',
                        'value' => '026 009 593'
                    ],
                    [
                        'key' => 'Код SWIFT:',
                        'value' => 'BOFAUS3N'
                    ],
                    [
                        'key' => 'Адрес Банка:',
                        'value' => '380 Centerpoint Blvd, New Castle, DE 19720'
                    ]
                ]
            ]
        ]
    ],
    'payment_us_ach_policy_hsbc' => array(
        'payment_title' => 'Банк Америки',
        'details' => [
            [
                'title' => 'Банковским переводом',
                'info' => [
                    [
                        'key' => 'Название банка получателя:',
                        'value' => 'FS COM INC'
                    ],
                    [
                        'key' => 'Счет Бенефициара #:',
                        'value' => '138 119 625 329'
                    ],
                    [
                        'key' => 'Номер Маршрута #:',
                        'value' => '026 009 593'
                    ],
                    [
                        'key' => 'Код SWIFT:',
                        'value' => 'BOFAUS3N'
                    ],
                    [
                        'key' => 'Адрес Банка:',
                        'value' => '380 Centerpoint Blvd, New Castle, DE 19720'
                    ]
                ]
            ],
            [
                'title' => 'Via ACH',
                'info' => [
                    [
                        'key' => 'Название банка получателя:',
                        'value' => 'FS COM INC'
                    ],
                    [
                        'key' => 'Счет Бенефициара #:',
                        'value' => '138 119 625 329'
                    ],
                    [
                        'key' => 'ACH Routing #:',
                        'value' => '125 000 024'
                    ]
                ]
            ]
        ]
    ),
    'payment_sg_policy_hsbc' => [
        'payment_title' => 'Банковский счет OCBC:',
        'details' => [
            [
                'title' => '',
                'info' => [
                    [
                        'key' => 'Название банка получателя:',
                        'value' => 'FS TECH PTE. LTD.'
                    ],
                    [
                        'key' => 'Номер счёта USD в OCBC:',
                        'value' => '712885193001'
                    ],
                    [
                        'key' => 'Код SWIFT:',
                        'value' => 'OCBCSGSG'
                    ],
                    [
                        'key' => 'Код банка:',
                        'value' => '7339'
                    ],
                    [
                        'key' => 'Код филиала:',
                        'value' => 'First 3 digits of your account no.'
                    ],
                    [
                        'key' => 'Название филиала:',
                        'value' => 'NORTH Branch'
                    ],
                    [
                        'key' => 'Адрес банка:',
                        'value' => '65 Chulia Street, OCBC Centre, Singapore 049513'
                    ]
                ]
            ]
        ]
    ],
    'payment_sg_usd_policy_hsbc' => [
        'payment_title' => 'OCBC Bank Account:',
        'details' => [
            [
                'title' => '',
                'info' => [
                    [
                        'key' => 'Account Name:',
                        'value' => 'FS TECH PTE. LTD.'
                    ],
                    [
                        'key' => 'OCBC SGD Account Number:',
                        'value' => '503468316301'
                    ],
                    [
                        'key' => 'Intermediary Bank (for TT in USD):',
                        'value' => 'JP MORGAN CHASE BANK, NEW YORK, USA'
                    ],
                    [
                        'key' => 'Swift Code:',
                        'value' => 'CHASUS33'
                    ]
                ]
            ]
        ]
    ],
    'payment_usd_policy_hsbc' => [
        'payment_title' => 'Счет в Банке Sparkasse:',
        'details' => [
            [
                'title' => '',
                'info' => [
                    [
                        'key' => 'Название банка получателя:',
                        'value' => 'FS.COM GmbH'
                    ],
                    [
                        'key' => 'Название Банка:',
                        'value' => 'Sparkasse Freising'
                    ],
                    [
                        'key' => 'IBAN:',
                        'value' => 'DE12 7005 1003 0970 0195 27'
                    ],
                    [
                        'key' => 'BIC:',
                        'value' => 'BYLADEM1FSI'
                    ],
                    [
                        'key' => 'Счет получателя:',
                        'value' => '970 0195 27'
                    ],
                    [
                        'key' => 'Адрес банка:',
                        'value' => 'Untere Hauptstrasse 29, 85354 Freising'
                    ]
                ]
            ]
        ]
    ],
    'payment_gb_policy_hsbc' => [
        'payment_title' => 'Счет в Банке Sparkasse:',
        'details' => [
            [
                'title' => '',
                'info' => [
                    [
                        'key' => 'Название банка получателя:',
                        'value' => 'FS.COM GmbH'
                    ],
                    [
                        'key' => 'Название Банка:',
                        'value' => 'Sparkasse Freising'
                    ],
                    [
                        'key' => 'IBAN:',
                        'value' => 'DE38 7005 1003 0970 0272 07'
                    ],
                    [
                        'key' => 'BIC:',
                        'value' => 'BYLADEM1FSI'
                    ],
                    [
                        'key' => 'Счет получателя:',
                        'value' => '970 0272 07'
                    ],
                    [
                        'key' => 'Адрес банка:',
                        'value' => 'Untere Hauptstrasse 29, 85354 Freising'
                    ]
                ]
            ]
        ]
    ],
    'payment_chf_policy_hsbc' => [
        'payment_title' => 'Счет в Банке Sparkasse:',
        'details' => [
            [
                'title' => '',
                'info' => [
                    [
                        'key' => 'Название банка получателя:',
                        'value' => 'FS.COM GmbH'
                    ],
                    [
                        'key' => 'Название Банка:',
                        'value' => 'Sparkasse Freising'
                    ],
                    [
                        'key' => 'IBAN:',
                        'value' => 'DE27 7005 1003 0970 0573 78'
                    ],
                    [
                        'key' => 'BIC:',
                        'value' => 'BYLADEM1FSI'
                    ],
                    [
                        'key' => 'Счет получателя:',
                        'value' => '970 0573 78'
                    ],
                    [
                        'key' => 'Адрес банка:',
                        'value' => 'Untere Hauptstrasse 29, 85354 Freising'
                    ]
                ]
            ]
        ]
    ],
    'payment_sek_policy_hsbc' => [
        'payment_title' => 'Счет в Банке Sparkasse:',
        'details' => [
            [
                'title' => '',
                'info' => [
                    [
                        'key' => 'Название банка получателя:',
                        'value' => 'FS.COM GmbH'
                    ],
                    [
                        'key' => 'Название Банка:',
                        'value' => 'Sparkasse Freising'
                    ],
                    [
                        'key' => 'IBAN:',
                        'value' => 'DE98 7005 1003 0970 1070 25 '
                    ],
                    [
                        'key' => 'BIC:',
                        'value' => 'BYLADEM1FSI'
                    ],
                    [
                        'key' => 'Счет получателя:',
                        'value' => '970 1070 25'
                    ],
                    [
                        'key' => 'Адрес банка:',
                        'value' => 'Untere Hauptstrasse 29, 85354 Freising'
                    ]
                ]
            ]
        ]
    ],
    'payment_de_policy_hsbc' => [
        'payment_title' => 'Счет в Банке Sparkasse:',
        'details' => [
            [
                'title' => '',
                'info' => [
                    [
                        'key' => 'Название банка получателя:',
                        'value' => 'FS.COM GmbH'
                    ],
                    [
                        'key' => 'Название Банка:',
                        'value' => 'Sparkasse Freising'
                    ],
                    [
                        'key' => 'IBAN:',
                        'value' => 'DE16 7005 1003 0025 6748 88'
                    ],
                    [
                        'key' => 'BIC:',
                        'value' => 'BYLADEM1FSI'
                    ],
                    [
                        'key' => 'Счет получателя:',
                        'value' => '25674888'
                    ],
                    [
                        'key' => 'Адрес банка:',
                        'value' => 'Untere Hauptstrasse 29, 85354 Freising'
                    ]
                ]
            ]
        ]
    ],
    'payment_us_hsbc_policy_hsbc' => array(
        'payment_title' => 'Счет в Банке HSBC',
        'details' => [
            [
                'title' => '',
                'info' => [
                    [
                        'key' => 'Beneficiary Название Банка:',
                        'value' => 'HSBC Hong Kong'
                    ],
                    [
                        'key' => 'Бенефициар:',
                        'value' => 'FS.COM LIMITED'
                    ],
                    [
                        'key' => 'Счет Бенефициара:',
                        'value' => '817-888472-838'
                    ],
                    [
                        'key' => 'Код SWIFT:',
                        'value' => 'HSBCHKHHHKH'
                    ],
                    [
                        'key' => 'Адрес банка получателя:',
                        'value' => '1 Queen\'s Road Central, Hong Kong'
                    ]
                ]
            ]
        ]
    ),
    'payment_au_policy_hsbc' => [
        'payment_title' => 'Банковский счет ANZ:',
        'details' => [
            [
                'title' => '',
                'info' => [
                    [
                        'key' => 'Название банка получателя:',
                        'value' => 'FS.COM Pty Ltd'
                    ],
                    [
                        'key' => 'BSB:',
                        'value' => '013160'
                    ],
                    [
                        'key' => 'Номер счета.:',
                        'value' => '416794959'
                    ],
                    [
                        'key' => 'Код SWIFT:',
                        'value' => 'ANZBAU3M'
                    ],
                    [
                        'key' => 'Адрес банка:',
                        'value' => '230 Swanston St, Melbourne, VIC, 3000'
                    ]
                ]
            ]
        ]
    ],
    'bank_name_au' => 'Direct Deposit',
    'bank_name_us' => 'Банковский Перевод',
    'bank_name_ach_ca' => 'Банковский Перевод',
    'bank_name_ach' => 'Банковский/ACH Перевод',

    //purchase 支付 表达
    'payment_net_title' => 'Отсрочка платежа',
    'payment_net_title_1' => 'Условия оплаты:',
    'payment_net_frozen' => 'Ваш кредитный счет находится в состоянии Кредит Приостановлен, и вариант оплаты Условия Нетто недоступен.
     Оплатить <a href="'.zen_href_link("manage_orders").'">неоплаченные счета или выбрать другой способ оплаты.',
    'payment_net_content' => 'Загрузите файл заказа на покупку после отправки заказа, и заказ будет обработан своевременно.',
    //ideal支付表达
    'payment_idea_title' => 'iDEAL',
    'payment_idea_content' => 'Вы перейдете к странице официального сайта банка и войдете в свою аккаунт IDEAL, чтобы завершить платеж. После оплаты FS обычно получает платеж в течение 1-2 рабочих дней.',
    //sofort 支付表达
    'payment_sofort_title' => 'SOFORT',
    'payment_sofort_content' => 'После оплаты FS обычно получает платеж в течение 3-5 рабочих дней.',
    'payment_enets_title' => 'eNets',
    'payment_enets_content' => 'Мы предлагаем вам способ оплаты в режиме реального времени, чтобы принимать интернет-платежи.и.',
    //YANDEX
    'payment_yandex_title' => 'YANDEX',
    'payment_yandex_content' => 'Мы предлагаем вам способ оплаты в режиме реального времени, чтобы принимать интернет-платежи.',
    'payment_yandex_des' => 'После оформления заказа, наши менеджеры обработают Ваш заказ и скоро свяжутся с вами по телефону или лектронной почте.',
    'payment_yandex_add' => 'Добавить реквизиты новой организации',

    'payment_web_title' => 'Web Money',
    'payment_web_content' => 'Мы предлагаем вам способ оплаты в режиме реального времени, чтобы принимать интернет-платежи.',
    //alfa
    'payment_alfa_edit' => 'Редактировать',
    'payment_alfa_remove' => 'Удалить',
    'payment_alfa_organization' => 'Название организации',
    'payment_alfa_legal' => 'Юридический адрес',
    'payment_alfa_inn' => 'INN',
    'payment_alfa_kpp' => 'КПП',
    'payment_alfa_bic' => 'БИК',
    'payment_alfa_bank' => 'Название Банка',
    'payment_alfa_mail' => 'E-mail',
    'payment_alfa_phone' => 'Номер телефона',
    'payment_alfa_title' => 'Редактировать платежную информацию',
    //alfa表单验证错误信息
    'payment_alfa_organization_error' => 'Требуется название организации.',
    'payment_alfa_inn_error' => 'Введите ИНН.',
    'payment_alfa_inn_digit_error' => 'INN is a sequence of 10-12 digits.',
    'payment_alfa_kpp_error' => 'Введите КПП.',
    'payment_alfa_kpp_digit_error' => 'KPP is a sequence of 10-12 digits.',
    'payment_alfa_bic_error' => 'Введите БИК.',
    'payment_alfa_bic_digit_error' => 'BIC is a sequence of 9 digits.',
    'payment_alfa_legal_error' => 'Требуется юридический адрес.',
    'payment_alfa_bank_error' => 'Требуется название Банка.',
    'payment_alfa_email_error' => 'Введите Ваш адрес электронной почты.',
    'payment_alfa_email_valid_error' =>'Введите действительный адрес электронной почты.',
    'payment_alfa_phone_error' => 'Требуется ваш номер телефона',
    'payment_alfa_empty_error' => 'Введите ваши реквизиты.',

    //美国澳洲gsp
    'import_fee' => 'Импортные пошлины',
    'gsp_include' => 'включена',
    'us_gsp_des' => 'Товар будет отправлен с глобального азиатского склада через <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">Глобальную программу доставки (GSP)</a>. Импортные пошлины при покупке и таможенное оформление, обрабатываются FS.
        <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">Узнайте больше</a>',
    'other_gsp_des' => 'Товар будет отправлен с глобального азиатского склада через <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">Глобальную программу доставки (GSP)</a>. Импортные пошлины при покупке и таможенное оформление, обрабатываются FS.
    <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">Узнайте больше</a>',

    'info_detail' => 'Детали заказа',
    'info_edit_cart' => 'Редактировать корзину',
    'info_po_number_title' => 'Номер PO (необязательно)',
    'info_po_number_placeholder' => 'Введите ваш номер PO',
    'info_delivery_int_title' => 'Инструкции по доставке (необязательно)',
    'info_delivery_int_placeholder' => 'Номер талона, время доставки или другие инструкции по доставке.',

    'info_products_desc_1' => 'Эта позиция включает следующие товары',
    'info_products_desc_2' => 'Товар будет отправлен с глобального азиатского склада через <a target="_blank" href="/specials/global-shipping-program-107.html">Глобальную программу доставки (GSP)</a>. Импортные пошлины при покупке и таможенное оформление, обрабатываются FS. Налог с продаж будет включен при оформлении заказа. <a target="_blank" href="/specials/global-shipping-program-107.html">Узнайте больше</a>',
    'info_products_shipping_tips_1' => 'Выбирать вариант доставки',
    'info_products_shipping_tips_2' => 'Заказы, полученные оплату после закрытия наших складов (5:00pm EST) будут отправлены на следующий рабочий день. Время доставки заказов в отдаленные районы может быть больше.',
    'info_products_comments' => 'Отзыв (необязательно)',
    'info_products_comments_placeholder' => 'Введите свой комментарий',

    'cost_item' => 'Ваш заказ ($NUM шт)',
    'cost_item_plural' => 'Ваш заказ ($NUM шт)',
    'cost_sipping' => 'Доставка:',
    'cost_tax' => 'Налог:',
    'cost_us_tax' => 'Est. Sales Tax:',
    'cost_subtotal' => 'Товары:',
    'cost_total' => 'Итого:',
    'confirm_btn' => 'Подтвердить заказ',
    'terms_use' => 'Нажимая кнопку выше, вы соглашаетесь с нашей <a target="_blank" href="'.reset_url('/policies/privacy_policy.html').'">политикой конфиденциальности</a> и <a target="_blank" href="'.reset_url('/policies/terms_of_use.html').'">условиями использования</a> FS.',
    'chat_phone' => '<a href="javascript:;" onclick="LC_API.open_chat_window();return false;">Онлайн чат</a> или позвоните нам по телефону',
    'share_btn' => 'Поделиться новостями о доставке',
    'system_busy' => 'Система занята. Попробовать позже',
    //没有地址时提示
    'no_shippingTip' => 'После ввода адреса доставки и выставления счета будут отображаться соответствующие данные о доставке, инвентаризации, расходах и другая информация.',
    'Save' => 'Сохранить',
    'Cancel' => 'Отменить',
    'Delete' => 'Удалить',
    //新增语言包 custom
    'delivery_comments' => 'Введите комментарий',
    'delivery_express_account' => 'Express аккаунт',
    'delivery_express_account_required' => 'Требуется ваш Express аккаунт.',
    'delivery_name' => 'Имя в удостоверении личности',
    'delivery_name_required' => 'Требуется ФИО в паспорте.',
    'delivery_email' => 'Адрес почты',
    'delivery_email_required' => 'Требуется адрес электронной почты.',
    'delivery_email_valid' => 'Введите действительный адрес электронной почты.',
    //运费自提错误提示语
    'delivery_contact' => 'Номер телефона',
    'delivery_contact_required' => 'Требуется номер телефона.',
    'delivery_time' => 'Времени самовывоза',
    'delivery_time_required' => 'Требуется время забирать посылку.',
    //分仓
    'delivery_title' => 'Доставка',
    'cost_insurance' => 'Cтраховка:',
    //选择地址
    'choose_shipping_address' => 'Выбирать адрес доставки',
    'add_billing_address' => 'Добавить адрес выставления счета',
    'billing_same_as_shipping' => 'Платежный адрес совпадает с адресом доставки',
    'upload_cash' => 'ЗАГРУЗИТЬ РЕКВИЗИТЫ ОРГАНИЗАЦИИ',
    'cash_information' => 'БАНКОВСКИЕ РЕКВИЗИТЫ',
    'confirm' => 'Подтвердить',
    'basic_information'  => 'Основная информация',
    'address_back' => 'Отмена',
    'address_save' => 'Сохранить',
    'CashTitle' => 'Безналичный расчет',
    'covid_meesage' => '*Советуем заполнить ваш домашний адрес в течение специального периода управления COVID-19, чтобы обеспечить своевременность получения.',
    //结算底部
    'privatePolicy' => '<a href="'.reset_url('/policies/privacy_policy.html').'">Конфиденциальность</a>',
    'termUse' => '<a href="'.reset_url('/policies/terms_of_use.html').'">Условия использования</a>',
    'fscomInc' => 'FS.COM Inc.',
    'confirm_delete_address' => 'Вы хотите удалить этот адрес?',
    //编辑地址
    'add_shipping_address' => 'Добавить адрес доставки',
    'edit_shipping_address' => 'Редактировать адрес доставки',
    'choose_billing_address' => 'Выбирать адрес выставления счета',
    'edit_billing_address' => 'Редактировать адрес выставления счета',
    //购物车数量
    'costItem' => 'Ваш заказ',
    'cartItem' => 'товар',
    'cartItems' => 'шт.',
    //顶部跳转
    'Confirmation' => 'Подтверждение',
    'confirmRedirect' => ' Вы хотите вернуться в корзину?',
    'stayInCheckout' => 'Оформить заказ',
    'returnToCart' => ' К корзине',
    //自提仓库地址信息
    'pick_up_au' => '<span>FS склад в Мельбурне:</span> 
                     57-59 Edison Rd, Dandenong South, VIC 3175, Australia | +61 3 9693 3488 <span><br>Время самовывоз: </span>
                     9:30am - 5pm (AEST) | Пн.-Пт.',
    'pick_up_de' => '<span>Расположение склада:</span> 
                     NOVA Gewerbepark Building 7, Am Gfild 7, 85375 Neufahrn Germany |  +49 (0) 8165 80 90 517 <span>
                     <br>Время самовывоз: </span>
                     10:00am - 12:00am '.(SUMMER_TIME ? '(UTC/GMT+2)' : '(UTC/GMT+1)').', 2:00pm - 5:30pm '.(SUMMER_TIME ? '(UTC/GMT+2)' : '(UTC/GMT+1)').' | Пн.-пт.',
    'pick_up_sg' => '<span>Склад SG FS:</span> 
                     30A Kallang Pl, #11-10/11/12, Singapore 339213 | +65 6443 7951 <span>
                     <br>Время самовывоз: </span>
                     9:00am - 5:00pm (GMT+8) | Пн.-пт.',
    'pick_up_us' => '<span>Расположение склада:</span> 
                     380 Centerpoint Blvd, New Castle, DE 19720, United States | +1 (888) 468 7419 <span>
                     <br>Время самовывоз: </span>
                      9:30am - 5:30pm (EST) | Пн.-пт.',
    'po_error' => 'Номер заказа должен состоит от 1 до 50 символов.',
    'delivery_error' =>'Номер заказа составляет от 1 до 50 знаков.',

    //税收政策语言包
    'tax_us_warehouse_show' =>   '(Без учета <a href="javascript:void(0)">налогов и сборов</a>)',
    'tax_us_warehouse_title' =>   'О пошлинах и налогах',
    'tax_us_warehouse_content' => '<p>Продукты в наличии на нашем складе в США будут отправлены напрямую из Делавера в любое место $COUNTRY.</p>
                                   <p>Если заказы содержат продукты, которые временно отсутствуют на складе в США, мы отправим их вам напрямую со склада в Азии, чтобы ускорить доставку.</p>
                                    <p>Когда вы размещаете заказ онлайн, FS.COM взимает ТОЛЬКО стоимость продукта и стоимость доставки. Любые возможные пошлины и тарифы, вызванные таможенным оформлением, должны нести вы сами.</p>',
    'tax_nz_warehouse_title' => 'О пошлинах и налогах',
    'tax_nz_warehouse_show' => '<a href="javascript:void(0)"></a>',
    'tax_nz_warehouse_content' => '<p>Для заказов, отправленных в страны за пределами Австралии, FS.COM будет взимать стоимость товаров и доставки при размещении заказа. Для этих заказов импортные или таможенные сборы могут взиматься в зависимости от законов конкретных стран.</p>
                                    <p>Таможенные или импортные пошлины взимаются после того, как посылки доставляются до стран назначения. Дополнительные сборы за таможенное оформление возлагаются на получателя.</p>',
    'tax_sg_warehouse_title' => 'О GST и тарифе',
    'tax_sg_warehouse_content' => '<p>Для заказов, отправленных со склада в Сингапуре и доставленных в места на территории Сингапура, FS обязана взимать налог GST на стоимость продукта и стоимость доставки по ставке 7%.</p>
                                   <p>Если заказываемых вами товаров в настоящее время нет на складе, мы отправим их напрямую со склада в Азии (Китай) без взимания НДС. Однако на эти пакеты могут взиматься ввозные или таможенные пошлины. Любые тарифы или импортные пошлины, вызванные таможенным оформлением, должны декларироваться и нести получатель.</p>',
    'tax_sg_warehouse_show' => '<a href="javascript:void(0)">(Включая GST)</a>',
    'tax_sg_other_show' => '<a href="javascript:void(0)">(Без налогов)</a>',
    'tax_sg_other_title' => 'О GST и тарифе',
    'tax_sg_other_content' => 'Для заказов, отправленных в пункты назначения за пределами Сингапура, мы только взимаем стоимость продукта и доставки сборов. Никакой налог с продаж (например, НДС или GST) не взимается. Однако, для этих заказов импортные или таможенные сборы могут взиматься в зависимости от законов/правил конкретных стран. Любые тарифы или импортные сборы, вызванных таможенным оформлением грузов, возлагаются на получателя.',

    'tax_ru_warehouse_private_show' => '<a href="javascript:void(0)">(Без учета налогов)</a>',
    'tax_ru_warehouse_private_title' => 'О пошлинах и налогах',
    'tax_ru_warehouse_private_content' => 'Заказ от физ. лица будет отправлен напрямую с нашего международного склада до двери. Мы ТОЛЬКО взимаем стоимость товара и доставки. FS не взимает никаких таможенных пошлин и сборов. Дополнительные пошлины и сборы за таможенное оформление возлагаются на получателя. С 1 января 2020 года порог беспошлинной торговли в России снижается до €200 и до 31 кг за одну посылку. Если Вас интересует другой способ доставки или хотите оплатить юр. лицом, свяжитесь со своим менеджером и узнать подробности.',

    'tax_ru_warehouse_public_show' => '<a href="javascript:void(0)">(Включая НДС)</a>',
    'tax_ru_warehouse_public_title' => 'НДС в РФ',
    'tax_ru_warehouse_public_content' => 'В соответствии с Главой 21 НК РФ Налог на добавленную стоимость (НДС), компания ООО ФС.КОМ обязана взимать НДС со всех заказов, доставляемых в Россию. Вся продукция из нашего каталога облагается стандартным НДС в размере 20% от стоимости в соответствии с Общим налоговым правом России. Вам будет известна общая сумма, включая НДС, до совершения оплаты, если Вы внесете всю необходимую информацию о заказе (включая тип предприятия и адрес доставки). ',

    'tax_cn_warehouse_title' => 'О пошлинах и налогах',
    'tax_cn_warehouse_show' => '<a href="javascript:void(0)">(Без пошлин и сборов)</a>',
    'tax_cn_warehouse_content' => 'Заказ от физ. лица будет отправлен напрямую с нашего международного склада до двери. Мы ТОЛЬКО взимаем стоимость товара и доставки. FS не взимает никаких таможенных пошлин и сборов. Дополнительные пошлины и сборы за таможенное оформление возлагаются на получателя. С 1 января 2020 года порог беспошлинной торговли в России снижается до €200 и до 31 кг за одну посылку. Если Вас интересует другой способ доставки или хотите оплатить юр. лицом, свяжитесь со своим менеджером и узнать подробности.',

    'tax_warehouse_de_include_title' => 'О НДС, пошлинах и налогах',
    'tax_warehouse_de_include_show' => '<a href="javascript:void(0)">(С учетом налогов)</a>',
    'tax_warehouse_de_excluding_show' => '<a href="javascript:void(0)">(Без пошлин и сборов)</a>',

    'tax_warehouse_de_include_local_show' => '<a href="javascript:void(0)">(Включая НДС)</a>',
    'tax_warehouse_de_excluding_local_show' => '<a href="javascript:void(0)">(Без НДС)</a>',
    'tax_warehouse_de_description' => 'Все товары будут отправлены со склада Германии. В соответствии с законами, регулирующими деятельность членов ЕС, компания FS.COM GmbH обязана взимать НДС со всех заказов, доставляемых из Германии в странах-членах ЕС (включая Северную Ирландию).',
    'tax_warehouse_de_description1' => 'Великобритания сейчас находится за пределами ЕС, поэтому есть некоторые изменения для заказов, доставляемых в Великобританию.',
    'tax_warehouse_de_description2' => 'Для заказов, доставленных в страны, не входящие в ЕС (включая Великобританию), вы можете облагаться импортными пошлинами или налогами, которые взимаются после того, как посылка достигает указанного пункта назначения. Любые дополнительные сборы за таможенное оформление также будут оплачиваться вами самостоятельно. Мы не контролируем эти сборы, поэтому вы можете связаться с вашей местной таможней для получения дополнительной информации.',
    'tax_warehouse_de_key1' => 'Германия',
    'tax_warehouse_de_value1' => 'НДС и тариф',
    'tax_warehouse_de_key2' => 'Страна/регион назначения',
    'tax_warehouse_de_value2' => 'Взимается 19% НДС.',
    'tax_warehouse_de_key3' => 'Франция и Монако',
    'tax_warehouse_de_value3' => 'Взимается 20% НДС, но если предлагается действительный идентификационный номер НДС ЕС, НДС будет освобожден.',
    'tax_warehouse_de_key4' => 'Нидерланды, Испания, Бельгия',
    'tax_warehouse_de_value4' => '21% НДС будет взиматься, но если будет предложен действительный идентификационный номер НДС ЕС, НДС будет освобожден.',
    'tax_warehouse_de_key5' => 'Италия',
    'tax_warehouse_de_value5' => 'Взимается НДС в размере 22%, но если предлагается действительный идентификационный номер НДС в ЕС, НДС будет освобожден.',
    'tax_warehouse_de_key6' => 'Швеция, Дания',
    'tax_warehouse_de_value6' => 'Взимается 25% НДС, но если предлагается действительный идентификационный номер НДС ЕС, НДС будет освобожден.',
    'tax_warehouse_de_key7' => 'Другие члены ЕС (включая Северную Ирландию)',
    'tax_warehouse_de_value7' => 'Взимается НДС в размере 16%, но если предлагается действительный идентификационный номер НДС в ЕС, НДС будет освобожден.',
    'tax_warehouse_de_key8' => 'Страны, не входящие в ЕС (включая Великобританию)',
    'tax_warehouse_de_value8' => 'НДС не взимается, но таможенное оформление оплачивается самостоятельно.',
    'tax_au_warehouse_show' => '(Включая GST, <a href="javascript:void(0)">подробнее</a>)',
    'tax_au_warehouse_title' => 'Ваш заказ',
    'total_au' => 'Итог:',
    'total_gst' => 'GST:',
    'total_before_gst' => 'Итого до GST:',
    'total_delivery' => 'Доставка:',
    'total_item'=>'товар:',
    'address_default' => 'По умолчанию',
    'share_popup_name_required' => 'Введите получателя/имя.',
    'enter_po_number' => 'PO',
    'enter_delivery_instruction'  => 'Срок доставки или другие инструкции по доставке.',
    'enter_comments' => 'Введите комментарий',
    'pick_up_time' => 'Время самовывоза',
    'ads_type_validate' => 'Снова выбирать тип плательщика.',

    'return_to_basket' => 'Вернуться в корзину',
    'preview_quote_pdf' => 'Посмотреть PDF',
    'create_quote_btn' => 'Создано',
    'create_quote_tips' => 'Наличный запас, дата доставки, предполагаемые налоги и стоимость доставки могут измениться и будут рассчитаны при оформлении заказа.',
    'quote_success_text_1' => 'Ваше КП успешно создан.',
    'quote_success_text_2' => 'Вы можете посмотреть это предложение в разделе <a href="'.zen_href_link('quotes_list','click_type=16').'">Аккаунт/Запросы на КП</a>.',
    'quote_success_text_3' => 'Если у вас есть вопросы, обратитесь к менеджеру.',

    'quote_share_email' => 'Поделиться по электронной почте',
    'quote_back_shopping' => 'Вернуться в корзину',
    //quotes share弹窗
    'share_quote' => 'Поделиться КП',
    'from' => 'От',
    'to' => 'До',
    'share_placeholder' => "Разделяйте получателей точкой с запятой ';'",
    'share_admin_text' => 'Отправить менеджеру аккаунта',
    'share_others_text' => "Поделитесь КП в аккаунте получателя",

    'returnToQuote' => 'История предложений',
    'company_optional' => ' (необязательно)',
    'create_quote' => 'КП',
    'quote_detail' => 'Детали КП',
    'attention_name' => 'Дополнительные инструкции (необязательно)',
    'quote_desc' => 'Введите детали КП для справки',
    'quote_item' => 'Товары',
    'quote_products_id' => 'ID товара',
    'quote_unit_price' => 'Цена за единицу',
    'quote_products_qty' => 'Кол-во',
    'quote_total' => 'Общая Сумма',
    'quote_payment_description_paypal' => 'Перенаправление на PayPal через безопасное онлайн-соединение и оплата с помощью баланса вашего счета paypal или кредитной/дебетовой карты.',
    'quote_payment_description_ideal' => 'Оплачивайте онлайн с помощью iDEAL, в надежной среде онлайн-банкинга вашего собственного банка.',
    'quote_payment_description_sofort' => 'Оплачивайте с помощью SOFORT и используйте собственные банковские реквизиты, которые просты, удобны и безопасны.',
    'quote_share_success_tips1' => 'Коммерческое предложение успешно отправлено',
    'quote_share_success_tips2' => 'Мы отправили КП на указанный вами адрес электронной почты.',
    'quote_payment_description_credit' => 'Мы принимаем следующие кредитные/дебетовые карты и P-Card, выпущенные этими компаниями.',

    'search' => 'search',
    'address_information' => 'Информация об адресе',
    'street_address_c' => 'Улица, c/o',
    'street_apt' => 'Квартира，дом，этаж и т.д.',
    'state_select' => 'Выберите вашу область',

    'quote_issue_us' => FS_COMMON_WAREHOUSE_US,
    'quote_issue_de' =>  FS_COMMON_WAREHOUSE_EU,
    'quote_issue_sg' => FS_COMMON_WAREHOUSE_SG,
    'quote_issue_ru' => FS_COMMON_WAREHOUSE_RU,
    'quote_issue_au' => FS_COMMON_WAREHOUSE_AU,
    'quote_issue_cn' => FS_COMMON_WAREHOUSE_CN_NEW,
    'alfa_upload_select' => 'Выбрать файл',
    'alfa_upload_tip' => 'Разрешить файлы типа JPG, JPGE, PDF, PNG, DOC, DOCX, XLS, XLSX. Максимальный размер файла 5M.',

    'quote_update_notice' => 'Уведомление',
    'quote_update_description' => 'Коммерческое предложение обновлено.',
    'quote_return' => 'Детали КП',
    'quote_continue' => 'Оформить заказ',
    'quote_send_email' => 'Отправить',
    'quote_email_check_tips1' => 'Поле \'Адрес Электронной Почты Получателя\' обязательно для выполнения.',
    'quote_email_check_tips2' => 'Напишите Ваш адрес электронной почты, пожалуйста.',
    'Gst_Excluded' => 'GST Excluded',
    'Confirm_Order_Option_tips'=>'Вы можете изменить способ доставки для этого заказа здесь.',
    'Tips_Button'=>'Подтвердить',

    'quote_success_click_here_1'=>'Ваш отзыв поможет нам предоставить вам лучший опыт работы с коммерческой предложению. ',
    'quote_success_click_here_2'=>'Нажмите здесь',
    'quote_success_click_here_3'=>' чтобы оставить отзыв.',
    'Question_submit_success_title'=>'Спасибо за ваш отзыв.',
    'Question_submit_success_content'=>'Ваш отзыв поможет нам предоставить вам лучший опыт работы с коммерческой предложению.',
    'Question_title'=>'Отзыв',
    'Question_tips1'=>'Ваш отзыв поможет нам предоставить вам лучший опыт работы с коммерческой предложению.',
    'Question_tips2'=>'Ваша оценка функции коммерческих предложений.',
    'Question_tips2_empty'=>'Выбирать рейтинг.',
    'Question_tips3'=>'Оставить свои предложения или отзыв.',
    'Question_tips3_empty'=>'Введите более 10 символов.',
    'Question_tips3_placeholder'=>'Ваши отзывы будут полезены другим покупателям.',
    'Question_tips4'=>'Отправить',
);
