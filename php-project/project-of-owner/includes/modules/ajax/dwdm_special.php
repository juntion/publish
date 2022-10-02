<?php
if (isset($_GET['ajax_request_action']) && $_GET['ajax_request_action']){
	$action = $_GET['ajax_request_action'];
	switch($_GET['ajax_request_action']){
		case 'set_customer_quote':
			$name = zen_db_prepare_input($_POST['name']);
			$phone = zen_db_prepare_input($_POST['phone']);
			$country_code = trim(str_replace('flag ','',$_POST['country_code']));
			$email = zen_db_prepare_input($_POST['email']);
			$content = zen_db_prepare_input(preg_replace("/(\\r\\n)+[\\t ]*/",'',$_POST['content']));
			$file = $_FILES['reviews_img'];
			$files_path = '';
			
			if(!empty($file['name'])){
				require_once(DIR_FS_CATALOG.'includes/classes/uploads.php');
				$fileFormat = array("application/msword",'jpg','png','gif','bmp','jpeg','txt',"application/vnd.ms-excel",'rar','zip','pdf'
				,"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet","application/vnd.openxmlformats-officedocument.wordprocessingml.document");
				$uplode_dir = 'dwdm_files';
				$savepath = $uplode_dir;    // 上传的文件存放目录,注:chmod 777 upload
				$maxsize = 0; //上传文件大小限制
				$overwrite = 0; //0. no 1. yes
				$f = new Uploads( $savepath, $fileFormat, $maxsize, $overwrite);

				if (!$f->run('reviews_img',0)){
					$error_info = $f->returnArray[0]['error'];
					//print_r($error_info);
					echo 0;
					exit;
				}
				$info = $f->returnArray;
				$files_path = '/images/dwdm_files/'.$info[0]['name'];			     
			}
			 //将数据保存到数据库中
			$colums = array(
				'name'=>$name,
				'country'=>trim($country_code),
				'phone'=>trim($phone),
				'email'=>trim($email),
				'quote_content'=>trim($content),
				'files_path'=>$files_path,
				'create_time'=>'now()',
				'language_id'=>$_SESSION['languages_id']
			);
			zen_db_perform('doc_dwdm_quote_special',$colums);
			echo 1;
			exit;
		break;
	}
}
	