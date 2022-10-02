<?php
if(isset($_GET['request_type'])){
	$debug = false;
	require 'includes/application_top.php';
	if (isset($_POST['securityToken']) && $_SESSION['securityToken'] == $_POST['securityToken']){
		switch ($_GET['request_type']){

			case 'support_helpful':
				$type = $_POST['type'];
				$rID = $_POST['rID'];
				$cid = $_POST['cid'];  			
				$count = 1;
           require ('fs_ajax/functions_fs_support.php');
           if (is_exist_support_userful($rID)){
	           if (1 == $type){  
	           	$fs_update_column_sql = ' support_userful_count = support_userful_count + 1 ';
	           	$fs_query = "update ".TABLE_SUPPORT_ARTICLE_IS_USEFUL." set ".$fs_update_column_sql." where support_article_id = ".(int)$rID;
	           	//echo $fs_query;	      
	           	$db->Execute($fs_query);
	           }else exit('error');
	           	$count = get_support_userful_count($rID,$type);
	           	echo '{"rID":"'.$rID.'","num":"'.$count.'"}';
           }else {
	           $arr1 = array('support_article_id' => $rID);
	           if (1 == $type)  $arr2 = array('support_userful_count' => '1',customers_id => $_SESSION['customer_id'],'support_useful_time' => 'now()');
	           zen_db_perform(TABLE_SUPPORT_ARTICLE_IS_USEFUL,array_merge($arr1,$arr2));
	           echo '{"rID":"'.$rID.'","num":"'.$count.'"}';
           }
           break;
           
/**
 * 				$support = array(
		 				'support_article_id' => $rID,
		 				'customers_id' => $cid,
		 				'support_useful_time' => 'now()',
						'support_userful_count' => '1'
		 			);
				zen_db_perform(TABLE_SUPPORT_ARTICLE_IS_USEFUL, $support);
				
		$sql = "select count(support_article_is_useful_id) as total from ".TABLE_SUPPORT_ARTICLE_IS_USEFUL." where support_article_id= '".$rID."' ";
		$get_useful = $db->Execute($sql);		
				$count = $get_useful->fields['total'];
					
				echo '{"rID":"'.$rID.'","num":"'.$count.'"}';
				break;
 */
				
			case 'support_service':
				 $customer_id = $_SESSION['customer_id'];
				 $email = $_POST['support_email'];
				 $topic = $_POST['support_topic'];
				 $content = $_POST['support_content'];
				 //if(isset($_POST['support_article_id'])) $support_article_id = $_POST['support_article_id'];
				 
				 //echo '{"cID":"'.$customer_id.'","email":"'.$email.'","topic":"'.$topic.'","content":"'.$contant.'"}';
				 $support = array(
		 				'support_articles_extension_customers_id' => $customer_id,
				        'support_articles_extension_articles_id' => isset($_POST['support_article_id']) ? $_POST['support_article_id'] : '',
				 		'support_survey_email' => $email,
		 				'support_articles_extension_date_add' => 'now()'
		 			);
				   zen_db_perform(TABLE_SUPPORT_ARTICLES_EXTENSION, $support);
				  
				  //$a_id = $db->insert_ID();
				 $articles_extension = array(
			    	'language_id' => $_SESSION['languages_id'], 
			    	'support_articles_title' => $topic, 
				 	'support_admin_id' => $customer_id, 
			    	'support_articles_description' => $content
			      );
                  zen_db_perform(TABLE_SUPPORT_ARTICLES_EXTENSION_DESCRIPTION,$articles_extension);
				   
                  exit('success');
				  //$messageStack->add_session('添加成功', 'success');
		break;	
		}
	}
}