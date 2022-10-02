<?php
if(isset($_GET['request_type'])){
	$debug = false;
	require 'includes/application_top.php';
		switch ($_GET['request_type']){
			
			case 'fa_submit':
			if($_POST['qa_question']){
            $products_id = $_POST['products_id'];
		    $products_url = $_POST['products_url'];
		    $products_name = zen_db_prepare_input($_POST['products_name']);
			$operate_name = zen_db_prepare_input($_POST['admin_name']);
			$question = zen_db_prepare_input($_POST['qa_question']);
			$answer = zen_db_prepare_input($_POST['qa_answer']);

			$feedback_db = array(
		 				'fiberstore_qa_products_id' => $products_id,
		 				'products_name' => $products_name,
		 				'products_url' => $products_url,
		 				'operate_name' => $operate_name,
                        'question' => $question,
		 				'answer' => $answer,
                        'feedback_add_time' => 'now()'
		 			);
	           zen_db_perform('fiberstore_qa_archive', $feedback_db);
	
			exit('success');
			}else{
			exit('error');
			}
		    break;
			
			case 'submit_broker':
			  if($_POST['content']){
			  	$question_type = $_POST['type'];
			  	$question_title = $_POST['title'];
			  	$question_content = $_POST['content'];
			  	
			    $question = array(
			            'customers_id' => $_SESSION['customer_id'],
		 				'question_type' => $question_type,
		 				'question_title' => $question_title,
			            'question_content' => $question_content,
                        'add_time' => 'now()'
		 			);
			  zen_db_perform('customers_broker', $question);
			  exit('success');
				}else{
				exit('error');
				}
			break;
		    
		    }
      }