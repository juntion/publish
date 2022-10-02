<?php

define('PURCHASE_TITLE_01', 'Submit a Purchase Order');
define('PURCHASE_TITLE_02', 'Make the PO process efficient, automatic and easy tracking');

define('PURCHASE_FORM_01', 'Please provide the following information to get your PO order processed quickly & easily.');
define('PURCHASE_FORM_02', 'Contact Information');
define('PURCHASE_FORM_03', 'First Name');
define('PURCHASE_FORM_04', 'Last Name');
define('PURCHASE_FORM_05', 'Email Address');
define('PURCHASE_FORM_06', 'Phone Number');
define('PURCHASE_FORM_07', 'PO Information');
define('PURCHASE_FORM_08', 'PO Number');
define('PURCHASE_FORM_09', 'Quotation/Pl Number');
define('PURCHASE_FORM_10', 'Upload Files');
define('PURCHASE_FORM_11', 'Comments');
define('PURCHASE_FORM_12', 'Submit PO');
define('PURCHASE_FORM_13', 'Select file');

define('PURCHASE_FORM_TIP_01', 'Please enter your PO number.');
define('PURCHASE_FORM_TIP_02', 'If you got an official quotation from FS before, you can leave the related info, like RQC2001020006/RQ2001300199/FS20200128000.');
define('PURCHASE_FORM_TIP_03', 'If you got an official quotation from FS before, you can upload related files with the PO together for confirmation.');
define('PURCHASE_FORM_TIP_04', 'Please upload the related files of PO.');
define('PURCHASE_FORM_TIP_05', 'Leave a remark if you have any request, like blind shipping, ticket number, products customize needs, ect.');
define('PURCHASE_FORM_TIP_06', 'The content should be no more than 500 characters.');

define('PURCHASE_FORM_TIP_07', 'Your PO was submitted successfully.');
define('PURCHASE_FORM_TIP_08', 'We will help to process the order within 12-24 hours, and you also can view update status in <a href="'.zen_href_link('purchase_order_list').'">Submit/View Purchase Order</a>.');

define('PURCHASE_LIST_01','Submit a New PO');
define('PURCHASE_LIST_02','YOUR PO LISTS');
define('PURCHASE_LIST_03','PO #');
define('PURCHASE_LIST_04','Date Created');
define('PURCHASE_LIST_05','Status');
define('PURCHASE_LIST_06','Order #');
define('PURCHASE_LIST_07','Submitted');
define('PURCHASE_LIST_07_TIP','Below is the PO information you have submitted, we will reply you within 12-24 hours.');
define('PURCHASE_LIST_08','Approved');
define('PURCHASE_LIST_08_TIP','Your PO has been approved, and we are processing to generate the order for you now.');
define('PURCHASE_LIST_09','Order Created');
define('PURCHASE_LIST_09_TIP','Your PO order has been created successfully, please click the “Pay Now” button to complete the payment and view more order status through “FSXXX”.');
define('PURCHASE_LIST_09_TIP1','Your PO order has been created successfully and is in processing now, you can view more order status  through “FSXXX”.');
define('PURCHASE_LIST_EMPTY_01','No Po History.');
define('PURCHASE_LIST_EMPTY_02','No Po Found.');
define('PURCHASE_LIST_FORM_01','Please make sure your PO include all needed information for quicker order processing.');
define('PURCHASE_LIST_FORM_02','Purchase order number');
define('PURCHASE_LIST_FORM_03','Eg: RQC2001020006');
define('PURCHASE_LIST_FORM_04','Leave a remark if you have any request, like blind shipping, ticket number, products customize needs, ect. ');

define('PURCHASE_PO_DETAILS','Purchase Order Details');
define('PURCHASE_PO_DETAILS_DATE','PO Request Date:');
define('PURCHASE_PO_DETAILS_QT','Quotation #:');
define('PURCHASE_PO_DETAILS_REQUEST','PO Request');
define('PURCHASE_PO_DETAILS_FILES','Files:');

//邮件
define('PURCHASE_EMAIL_REVIEWING','PO Reviewing');
define('PURCHASE_EMAIL_TITLE','FS - Your PO #POXXX is Under Review');
define('PURCHASE_EMAIL_CONTENT_01','We\'ve received your PO: #POXXX, our team will review and process it within 12-24 hours.');
define('PURCHASE_EMAIL_CONTENT_02','You can track the progress by logging into your account and going to the <a href="'.zen_href_link('purchase_order_list').'" target="_blank" style="color: #0070bc;text-decoration: none;">Submit/View Purchase Order</a> page.');

define('PURCHASE_PROCESS_TIP','Sign in or create an account to submit PO file and track its status online timely.');
define('PURCHASE_PROCESS_TITLE','How Does Purchase Order Process?');
define('PURCHASE_PROCESS_01','Submit a PO');
define('PURCHASE_PROCESS_01_TIP','Submit your purchase order (PO) file.');
define('PURCHASE_PROCESS_02','PO Processing');
define('PURCHASE_PROCESS_02_TIP','FS creates online order for you once PO approved.');
define('PURCHASE_PROCESS_03','Order Payment and Shipping');
define('PURCHASE_PROCESS_04','Once pending order created, please complete payment online for further order processing and shipping. For Credit Account Customer, your order will be processed directly once PO approved, and credit order will be shipped out first and payment received later.');
define('PURCHASE_PROCESS_05','For more order status tracking, you can check “<a href="'.zen_href_link('manage_orders').'" class="alone_a">Order History</a>”.');

define('PURCHASE_PROCESS_NEW_01', 'PO File:');