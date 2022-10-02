<?php
define('REQUEST_DEMO_BANNER_TITLE', 'Demos for Network Switches');

define('REQUEST_DEMO_ALREADY_HAVE_AN_ACCOUNT','Already have an account ? <a href="'.zen_href_link(FILENAME_LOGIN,'','SSL').'">Sign in</a> or <a href="'.zen_href_link(FILENAME_REGIST,'','SSL').'">Create an account</a>');

define('REQUEST_DEMO_INDUSTRY', 'Industry');
define('REQUEST_DEMO_OPTION_DEFAULT', 'Please Select');
define('REQUEST_DEMO_INDUSTRY_OPTION_1', 'Arts/Recreation');
define('REQUEST_DEMO_INDUSTRY_OPTION_2', 'Edu - Higher Ed');
define('REQUEST_DEMO_INDUSTRY_OPTION_3', 'Edu - K-12, Public & Private');
define('REQUEST_DEMO_INDUSTRY_OPTION_4', 'Edu - Others');
define('REQUEST_DEMO_INDUSTRY_OPTION_5', 'Energy/Utilities');
define('REQUEST_DEMO_INDUSTRY_OPTION_6', 'Financial Services');
define('REQUEST_DEMO_INDUSTRY_OPTION_7', 'Government');
define('REQUEST_DEMO_INDUSTRY_OPTION_8', 'Health Care');
define('REQUEST_DEMO_INDUSTRY_OPTION_9', 'High Tech - Soft/Hardware');
define('REQUEST_DEMO_INDUSTRY_OPTION_10', 'Hospitality/Hotels &Leisure');
define('REQUEST_DEMO_INDUSTRY_OPTION_11', 'Library');
define('REQUEST_DEMO_INDUSTRY_OPTION_12', 'Manufacturing');
define('REQUEST_DEMO_INDUSTRY_OPTION_13', 'Media/Entertainment');
define('REQUEST_DEMO_INDUSTRY_OPTION_14', 'Non-Profit & Membership Orgs');
define('REQUEST_DEMO_INDUSTRY_OPTION_15', 'Others');
define('REQUEST_DEMO_INDUSTRY_OPTION_16', 'Professional Services');
define('REQUEST_DEMO_INDUSTRY_OPTION_17', 'Retail/Restaurants');
define('REQUEST_DEMO_INDUSTRY_OPTION_18', 'Service Provider');
define('REQUEST_DEMO_INDUSTRY_OPTION_19', 'Transportation');
define('REQUEST_DEMO_INDUSTRY_OPTION_20', 'VAR/Systems Integrator');
define('REQUEST_DEMO_INDUSTRY_OPTION_21', 'Wholesale/Distribution');


define('REQUEST_DEMO_COMPANY', 'Company Name');
define('REQUEST_DEMO_COMPANY_SIZE', 'Company Size');
define('REQUEST_DEMO_COMPANY_SIZE_TIP_01', '1 to 99');
define('REQUEST_DEMO_COMPANY_SIZE_TIP_02', '100 to 999');
define('REQUEST_DEMO_COMPANY_SIZE_TIP_03', '1,000 to 1,999');
define('REQUEST_DEMO_COMPANY_SIZE_TIP_04', '2,000 to 3,999');
define('REQUEST_DEMO_COMPANY_SIZE_TIP_05', '4,000+');

define('REQUEST_DEMO_COMMENT_OPTIONAL', 'Comments (Optional) :');
define('REQUEST_DEMO_COMMENT_OPTIONAL_PLACEHOLDER', 'Don\'t find what you want ? Try to post your issues.');

define('REQUEST_DEMO_SEARCH_RESULT', 'There is no result for "#KEYWORD#", please double check your spelling.');
define('REQUEST_DEMO_HOT_SEARCH', 'Hot Search:');
define('REQUEST_DEMO_HOT_SCHEDULE_TIME', 'Please schedule a time');

define('REQUEST_DEMO_TIP_01', 'Try FS Switches');
define('REQUEST_DEMO_TIP_02', 'Our remote testing service allows users to deploy and connect to Switches running in our lab, access these Switches remotely to operate them.');
define('REQUEST_DEMO_TIP_03', 'What FS demo can do for me:');
define('REQUEST_DEMO_TIP_04', '100+ functions experience');
define('REQUEST_DEMO_TIP_05', 'Performance tests');
define('REQUEST_DEMO_TIP_06', 'Branded switch compatibility');
define('REQUEST_DEMO_TIP_07', 'Standard application scenarios');
define('REQUEST_DEMO_TIP_08', 'Customized solutions');
define('REQUEST_DEMO_TIP_09', 'What can I expect?');
define('REQUEST_DEMO_TIP_10', 'User scenarios simulation, on-site operation feeling');
define('REQUEST_DEMO_TIP_11', 'No delay, no screen freezing');
define('REQUEST_DEMO_TIP_12', '1 minute access, 30 minutes experience');
define('REQUEST_DEMO_TIP_13', 'One-on-One technical engineer online support');

define('REQUEST_DEMO_FORM_01', 'Which switch are you interested in?');
define('REQUEST_DEMO_FORM_02', 'Which functions would you like to try?');

define('REQUEST_DEMO_SUCCESS_TIP_01', 'Your request #NUMBER# has been submitted successfully.');
define('REQUEST_DEMO_SUCCESS_TIP_02', 'We will contact you within 24 hours.');

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

define('REQUEST_DEMO_FORM_TIP_01', 'Please select industry.');
define('REQUEST_DEMO_FORM_TIP_02', 'Please enter your company name.');
define('REQUEST_DEMO_FORM_TIP_03', 'Please select your company size.');
define('REQUEST_DEMO_FORM_TIP_04', 'Please select a switch.');
define('REQUEST_DEMO_FORM_TIP_05', 'Please select at least one function.');
define('REQUEST_DEMO_FORM_TIP_06', 'Please select time.');

define('REQUEST_DEMO_EMAIL_01','FS - We received your demo request ');
define('REQUEST_DEMO_EMAIL_02','We\'ve received your demo request <a style="color: #0070bc;text-decoration: none" target="_blank" href="#HREF#">#NUMBER#</a>, you can refer to this number in all follow-up communications next.');
define('REQUEST_DEMO_EMAIL_03','The following is the test information:');
define('REQUEST_DEMO_EMAIL_04','Switch Model: ');
define('REQUEST_DEMO_EMAIL_05','Interested Functions: ');
define('REQUEST_DEMO_EMAIL_06','Scheduled Time: ');
define('REQUEST_DEMO_EMAIL_07','Please well prepared with <a style="color: #0070bc;text-decoration: none" target="_blank" href="https://www.teamviewer.com/download/windows/">TeamViewer</a> tool before start your testing demo, our team will be in touch soon.');
define('REQUEST_DEMO_EMAIL_08','Your TeamViewer <b>Partner (FS) ID is 658526138</b>, password will be sent to you in 15 minutes before your scheduled time.');

define('REQUEST_DEMO_SEARCH','Search');