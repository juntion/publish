<?php
define('REQUEST_DEMO_BANNER_TITLE', 'Démonstration pour Switch Réseau');

define('REQUEST_DEMO_ALREADY_HAVE_AN_ACCOUNT','Vous avez déjà un compte ? <a href="'.zen_href_link(FILENAME_LOGIN,'','SSL').'">Connectez-vous</a> ou <a href="'.zen_href_link(FILENAME_REGIST,'','SSL').'">Créez un Compte</a>');

define('REQUEST_DEMO_INDUSTRY', 'Secteur');
define('REQUEST_DEMO_OPTION_DEFAULT', 'Veuillez Sélectionner');
define('REQUEST_DEMO_INDUSTRY_OPTION_1', 'Arts/Récréation');
define('REQUEST_DEMO_INDUSTRY_OPTION_2', 'Éducation - Éducation Supérieure');
define('REQUEST_DEMO_INDUSTRY_OPTION_3', 'Éducation - K-12, Public & Privé');
define('REQUEST_DEMO_INDUSTRY_OPTION_4', 'Éducation - Autres');
define('REQUEST_DEMO_INDUSTRY_OPTION_5', 'Énergie/Services Publics');
define('REQUEST_DEMO_INDUSTRY_OPTION_6', 'Services Financiers');
define('REQUEST_DEMO_INDUSTRY_OPTION_7', 'Gouvernement');
define('REQUEST_DEMO_INDUSTRY_OPTION_8', 'Soins de Santé');
define('REQUEST_DEMO_INDUSTRY_OPTION_9', 'Haute Technologie - Logiciel/Matériel');
define('REQUEST_DEMO_INDUSTRY_OPTION_10', 'Hôtellerie/Hôtels & Loisirs');
define('REQUEST_DEMO_INDUSTRY_OPTION_11', 'Bibliothèque');
define('REQUEST_DEMO_INDUSTRY_OPTION_12', 'Fabrication');
define('REQUEST_DEMO_INDUSTRY_OPTION_13', 'Médias/Divertissement');
define('REQUEST_DEMO_INDUSTRY_OPTION_14', 'Organismes à But non Lucratif et Associations de Membres');
define('REQUEST_DEMO_INDUSTRY_OPTION_15', 'Autres');
define('REQUEST_DEMO_INDUSTRY_OPTION_16', 'Services Professionnels');
define('REQUEST_DEMO_INDUSTRY_OPTION_17', 'Commerce de Détail/Restaurants');
define('REQUEST_DEMO_INDUSTRY_OPTION_18', 'Fournisseur de Service');
define('REQUEST_DEMO_INDUSTRY_OPTION_19', 'Transport');
define('REQUEST_DEMO_INDUSTRY_OPTION_20', 'VAR/Intégrateur de Systèmes');
define('REQUEST_DEMO_INDUSTRY_OPTION_21', 'Commerce de Gros/Distribution');


define('REQUEST_DEMO_COMPANY', 'Entreprise');
define('REQUEST_DEMO_COMPANY_SIZE', 'Taille de l\'Entreprise');
define('REQUEST_DEMO_COMPANY_SIZE_TIP_01', '1 à 99');
define('REQUEST_DEMO_COMPANY_SIZE_TIP_02', '100 à 999');
define('REQUEST_DEMO_COMPANY_SIZE_TIP_03', '1,000 à 1,999');
define('REQUEST_DEMO_COMPANY_SIZE_TIP_04', '2,000 à 3,999');
define('REQUEST_DEMO_COMPANY_SIZE_TIP_05', '4,000+');

define('REQUEST_DEMO_COMMENT_OPTIONAL', 'Commentaires (Optionnels) :');
define('REQUEST_DEMO_COMMENT_OPTIONAL_PLACEHOLDER', 'Vous ne trouvez pas ce que vous voulez ? Essayez d\'écrire vos problèmes.');

define('REQUEST_DEMO_SEARCH_RESULT', 'Il n\'y a pas de résultat pour "#KEYWORD#", veuillez vérifier l\'orthographe.');
define('REQUEST_DEMO_HOT_SEARCH', 'Recherches Populaires :');
define('REQUEST_DEMO_HOT_SCHEDULE_TIME', 'Veuillez indiquer la date et l\'heure');

define('REQUEST_DEMO_TIP_01', 'Essayez les Commutateurs de FS');
define('REQUEST_DEMO_TIP_02', 'Notre service de test à distance permet aux utilisateurs d\'accéder et opérer de manière distante les commutateurs déployés dans nos laboratoires.');
define('REQUEST_DEMO_TIP_03', 'En quoi ces démonstrations peuvent m\'être utiles :');
define('REQUEST_DEMO_TIP_04', 'Plus de 100 fonctionnalités');
define('REQUEST_DEMO_TIP_05', 'Tests de performance');
define('REQUEST_DEMO_TIP_06', 'Compatibilité avec les commutateurs de marque');
define('REQUEST_DEMO_TIP_07', 'Scénarios d\'application standard');
define('REQUEST_DEMO_TIP_08', 'Solutions personnalisées');
define('REQUEST_DEMO_TIP_09', 'À quoi puis-je m\'attendre ?');
define('REQUEST_DEMO_TIP_10', 'Simulation de scénario et ambiance opérationnelle');
define('REQUEST_DEMO_TIP_11', 'Aucun délai, aucun blocage d\'écran');
define('REQUEST_DEMO_TIP_12', '1 minute d\'accès, 30 minutes d\'expérience');
define('REQUEST_DEMO_TIP_13', 'Assistance technique personnalisée en ligne avec ingénieur');

define('REQUEST_DEMO_FORM_01', 'Quel switch vous intéresse ?');
define('REQUEST_DEMO_FORM_02', 'Quelles sont les fonctions que vous souhaitez essayer ?');

define('REQUEST_DEMO_SUCCESS_TIP_01', 'Votre demande #NUMBER# a été soumise avec succès.');
define('REQUEST_DEMO_SUCCESS_TIP_02', 'Nous vous contacterons dans les 24 heures.');

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
    array('id' => 48, 'txt' => 'port Security'),
    array('id' => 49, 'txt' => 'DAI'),
    array('id' => 50, 'txt' => 'ip source guard'),
    array('id' => 51, 'txt' => 'TFTP'),
    array('id' => 52, 'txt' => 'FTP'),
    array('id' => 53, 'txt' => 'SNTP'),
    array('id' => 54, 'txt' => 'VRRP')
)));

define('REQUEST_DEMO_FORM_TIP_01', 'Veuillez sélectionner un secteur.');
define('REQUEST_DEMO_FORM_TIP_02', 'Veuillez entrer le nom de votre entreprise.');
define('REQUEST_DEMO_FORM_TIP_03', 'Veuillez sélectionner la taille de votre entreprise.');
define('REQUEST_DEMO_FORM_TIP_04', 'Veuillez sélectionner un switch.');
define('REQUEST_DEMO_FORM_TIP_05', 'Veuillez sélectionner au moins une fonction.');
define('REQUEST_DEMO_FORM_TIP_06', 'Veuillez sélectionner le temps.');

define('REQUEST_DEMO_EMAIL_01','FS - Nous avons reçu votre demande de démonstration ');
define('REQUEST_DEMO_EMAIL_02','Nous avons reçu votre demande de démonstration <a style="color: #0070bc;text-decoration: none" target="_blank" href="#HREF#">#NUMBER#</a>, Vous pouvez faire référence à ce numéro dans toutes les communications ultérieures.');
define('REQUEST_DEMO_EMAIL_03','Voici les informations de test :');
define('REQUEST_DEMO_EMAIL_04','Modèle de Switch : ');
define('REQUEST_DEMO_EMAIL_05','Fonctions Intéressées : ');
define('REQUEST_DEMO_EMAIL_06','Temps Prévu : ');
define('REQUEST_DEMO_EMAIL_07','Veuillez bien vous préparer avec l\'outil <a style="color: #0070bc;text-decoration: none" target="_blank" href="https://www.teamviewer.com/download/windows/">TeamViewer</a> avant de commencer votre démonstration de test, notre équipe vous contactera bientôt.');
define('REQUEST_DEMO_EMAIL_08','<b>Votre identifiant TeamViewer est 658526138</b>. Le mot de passe vous sera envoyé 15 minutes avant le rendez-vous.');

define('REQUEST_DEMO_SEARCH','Rechercher');