<?php
// 公共表单验证
// firstname
define('FS_FIRST_REQUIRED_TIP',"Le prénom est requis.");
define('FS_FIRST_MIN_TIP',"Le prénom doit avoir 2 caractères minimum.");
define('FS_FIRST_MAX_TIP',"Le prénom doit comporter 32 caractères maximum.");
// lastname
define('FS_LAST_REQUIRED_TIP',"Le nom est requis.");
define('FS_LAST_MIN_TIP',"Le nom doit avoir 2 caractères minimum.");
define('FS_LAST_MAX_TIP',"Le nom de famille doit comporter 32 caractères maximum.");
// email
define('FS_YOUR_EMAIL_ADDRESS',"Votre Adresse e-mail");
define('FS_EMAIL_REQUIRED_TIP',"L'adresse e-mail est requise.");
define('FS_EMAIL_FORMAT_TIP',"Entrez une adresse e-mail valide. (ex. : quelqu’un@gmail.com)");
define('FS_EMAIL_HAS_REGISTERED_TIP',"Désolé, l'é-mail a été enregistré. Vous pouvez en changer un autre.");
define('FS_EMAIL_HAS_REGISTERED_TIP1',"Désolé, l'é-mail a déjà été enregistré. Veuillez vous connecter ou choisir d'avoir un compte.");
define('FS_EMAIL_NOT_FOUND_TIP',"Erreur : cette adresse e-mail n'est pas trouvée dans notre système, veuillez réessayer.");
define('FS_EMAIL_NOT_ACTIVED_TIP','Désolé ! Votre boîte de lettres n\'est pas activée, veuillez vous connecter pour l\'activer.');
define('FS_EMAIL_HAS_REGISTERED_TIP_01',"Le compte existe déjà. Cliquer ici pour <a href='".zen_href_link(FILENAME_LOGIN,'','SSL')."'>se connecter</a>.");
// new email
define('FS_NEW_EMAIL_ADDRESS','Nouvelle adresse e-mail');
define('FS_NEW_EMAIL_REQUIRED_TIP',"Une nouvelle adresse e-mail est requise.");
// confirm new email
define('FS_CONFIRM_NEW_EMAIL','Entrer de nouveau l\'adresse e-mail');
define('FS_CONFIRM_NEW_EMAIL_REQUIRED_TIP',"Veuillez entrer de nouveau l'adresse e-mail.");
define('FS_NEW_EMAIL_MATCH_TIP',"La nouvelle adresse e-mail doit correspondre.");
// password
define('FS_PASSWORD_REQUIRED_TIP',"Le mot de passe est requis.");
define('FS_PASSWORD_FORMAT_TIP',"6 caractères minimum avec au moins une lettre et un chiffre. Caractères spéciaux (_ ? @ ! # $ % & * .) autorisés.");
define('FS_PASSWORD_ERROR_TIP',"Votre mot de passe est incorrect, veuillez le vérifier et ressayer.");
define('FS_OLD_PASSWORD_ERROR_TIP',"Votre ancien mot de passe n'est pas correct, veuillez le vérifier à nouveau !");
// confirm password
define('FS_CONFIRM_PASSWORD',"Confirmer le mot de passe");// 只有注册表单才需要
define('FS_CURRENT_PASSWORD_REQUIRED_TIP',"Veuillez entrer votre mot de passe actuel.");
define('FS_CONFIRM_PASSWORD_REQUIRED_TIP',"Veuillez confirmer votre nouveau mot de passe.");
define('FS_PASSWORD_MATCH_TIP',"Le mot de passe doit correspondre.");
// new password
define('FS_NEW_PASSWORD','Nouveau mot de passe');
define('FS_NEW_PASSWORD_REQUIRED_TIP',"Veuillez entrer votre nouveau mot de passe.");
define('FS_PASSWORD_REQUIREMENT',"Votre mot de passe doit être :");
define('FS_PASSWORD_REQUIREMENT1',"6 caractères minimum");
define('FS_PASSWORD_REQUIREMENT2',"avec au moins une lettre et un chiffre");
// confirm new password
define('FS_CONFIRM_NEW_PASSWORD','Confirmer le nouveau mot de passe');
define('FS_CONFIRM_NEW_PASSWORD_REQUIRED_TIP',"Veuillez confirmer le nouveau mot de passe.");
define('FS_PASSWORD_DIFFERENT','Le nouveau mot de passe doit être différent de votre ancien mot de passe. ');
define('FS_PASSWORD_DIFFERENT','Le nouveau mot de passe doit être différent de votre ancien mot de passe. ');
define('FS_NEW_PASSWORD_MATCH_TIP',"Le nouveau mot de passe doit correspondre.");
//验证码
define('FS_IMAGE',"Image");
define('FS_TRY_DIFFERENT_IMAGE',"Essayer une autre image");
define('FS_TYPE_CHAR',"Entrer les caractères");
define('FS_IMAGE_FORM_TIP',"Entrer les caractères montrés dans cette image.");
// AGREE
define('FS_AGREE_REQUIRED_TIP', 'Veuillez accepter notre politique pour continuer.');
//Company name
define('FS_COMPANY_NAME_REQUIRED_TIP',"Le nom de l'entreprise est requis.");
define('FS_COMPANY_NAME_MIN_TIP',"Le nom de l'entreprise doit comporter au moins 2 caractères.");
//industry
define('FS_INDUSTRY_REQUIRED_TIP',"Veuillez sélectionner l'industrie dans laquelle votre entreprise s'insère.");
//industry
define('FS_SELECT_INDUSTRY','Sélectionnez une Industrie');
define('FS_INDUSTRY_REQUIRED_TIP',"Veuillez sélectionner l'industrie dans laquelle votre entreprise s'insère.");
//TAX/VAT
define('FS_TAX_REQUIRED_TIP','TAXE/TVA est requise.');
define('FS_TAX_FORMAT_TIP','Veuillez entrer un numéro Fiscal/TVA valide.');
//phone
define('FS_PHONE_REQUIRED_TIP','Votre numéro de téléphone est requis.');
define('FS_PHONE_MIN_TIP','Votre numéro de téléphone doit contenir au moins 7 chiffres.');
define('FS_PHONE_FORMAT_TIP','Votre numéro de téléphone doit contenir au moins 7 chiffres.');
//QTY
define('FS_PRODUCT_QTY_REQUIRED_TIP','La quantité de produit est requise.');
define('FS_PRODUCT_QTY_FORMAT_TIP','Cette qté de produit est invalide, s\'il vous plaît corriger et réessayer .');
// get a quote
define('COMMENTS_OR_QUESTIONS_REQUIRED_TIP','Les commentaires/questions sont requis.');
// feedback
define('FEEDBACK_RATE_REQUIRED_TIP','Veuillez évaluer votre expérience.');
define('FEEDBACK_TOPIC_REQUIRED_TIP','Veuillez sélectionner un sujet.');
define('FEEDBACK_CONTENT_REQUIRED_TIP','Veuillez entrer plus de 10 caractères.');
define('FS_TAX_PLACEHOLDER','ex. : FR12345678987');

// review
define('FS_REVIEW_RATING_REQUIRED_TIP','Veuillez évaluer ce produit.');
define('FS_REVIEW_TITLE_REQUIRED_TIP','Le titre d\'avis est requis.');
define('FS_REVIEW_TITLE_MIN_TIP','Veuillez écrire le titre du commentaire en plus de 3 caractères.');
define('FS_REVIEW_TITLE_MAX_TIP','Le titre d\'avis doit comporter 200 caractères maximum.');
define('FS_REVIEW_CONTENT_REQUIRED_TIP','Le contenu d\'avis est requis.');
define('FS_REVIEW_CONTENT_MIN_TIP','Veuillez écrire le commentaire en plus de 10 caractères.');
define('FS_REVIEW_CONTENT_MAX_TIP',"Veuillez limiter la longueur de votre commentaire à 5 000 caractères.");
// my case
define('FS_CASE_TYPE_REQUIRED_TIP','Veuillez choisir le type de service.');
define('FS_CASE_CONTENT_REQUIRED_TIP','Veuillez décrire vos questions afin que nous puissions traiter votre demande plus rapidement.');
define('FS_CASE_CONTENT_MAX_TIP','Veuillez ne pas dépasser 5,000 caractères.');
// apply money
define('FS_APPLY_MONEY_REQUIRED_TIP','Veuillez entrer le montant que vous souhaitez.');
define('FS_APPLY_MONEY_FORMAT_TIP','Veuillez entrer un montant valide allant jusqu\'à 2 décimales.');
//define('FS_APPLY_MONEY_REASON_TIP','Veuillez expliquer pourquoi vous devez augmenter le montant. Cela nous aidera dans le traitement de votre demande.');
define('FS_APPLY_MONEY_REASON_TIP','Veuillez expliquer la raison pour laquelle vous voulez augmenter le montant. Cela nous aidera dans le traitement de votre demande.');


//review new
define("FS_REVIEW_TITLE_REQUIRED_TIP_NEW",'Veuillez remplir le tire de votre commentaire');
define('FS_REVIEW_CONTENT_REQUIRED_TIP_NEW','Veuillez remplir votre commentaire');
define('FS_OLD_PASSWORD_REASON','Votre ancien mot de passe n\'est pas correct, veuillez le vérifier à nouveau !');
define('FS_SUBMIT_TOO_FREQUENT','L\'opération est trop fréquente.');
