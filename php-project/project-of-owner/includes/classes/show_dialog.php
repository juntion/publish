<?php

class show_dialog{
	
	function display_show_dialog($pID) {
	//$html = '';

		$html ='
		<div class="P_bulk" style="color:#dedede;">
			<div id="popup_'.$pID.'" class="ui-widget ui-widget-content ui-corner-all" style="position: fixed; left: 50%; top: 50%; width: 650px; margin-top: -200px; margin-left: -300px; padding: 15px; z-index: 9999999; box-shadow: 0px 0px 16px rgb(0, 0, 0); font-size: 11px;">
				
			<div class="ui-dialog-content ui-widget-content" style="background: none; border: 0; ">
		<a id="lb-close" class="noCtrTrack" onclick="$(\'#popup_'.$pID.'\').hide();" href="javascript:;"></a>
			<div class="quote_products" style="color:#000; font-size:13px"><b>'.zen_get_products_name($pID).'</b></div>
			<ul class="login_regist_21 p_ly_mian">

						  <li><span><em>*</em>'.FS_DIALOG_EMAIL.':</span>
						  <input type="text" name="email" id="email_'.$pID.'" class="big_input">
						  <i class="help_info"></i>
						   <div class="error_prompt" style="display:none;" id="n_of_email_'.$pID.'"> '.FS_DIALOG_AGAIN.'</div>
						  <div class="ccc"></div>
						  </li>
					
						  <li class="height_01"><span><em>*</em>'.FS_DIALOG_COMMENTS.':</span>
						  <textarea name="enquiry" id="enquiry_'.$pID.'" class="login_014 aaa" ></textarea>
						  <i class="help_info"></i>
						  <div class="error_prompt" style="display:none;" id="n_of_content_'.$pID.'"> '.FS_DIALOG_THIS.'</div>
						  <div class="ccc"></div>
						  </li>
					   <li class="kong"><div class="set_button">
					  <input type="button" value="'.FS_SUBMIT.'" id="submit_button" class="button_02" onClick="ajax_get_products_quote('.$pID.')"></div></li>
						<div class="ccc"></div>
			</ul>            

		</div></div></div>';
	return $html;
	}
	
	
	function display_question() {
		$html ='
	   <div class="ui-overlay" id="fs_overlay" >
       <div class="ui-widget-overlay" style="filter: alpha(opacity=30);"></div>
       </div>
          <div id="fs_popup" class="ui-widget ui-widget-content ui-corner-all  ui-corner_pop">		  <div style="background: none; border: 0; " class="ui-dialog-content ui-widget-content"> 
		  <form id="orderForm" method="post">
		   <div class="cancel_order_title"> '.FS_DIALOG_ASK. zen_customer_has_admin_of_cid($_SESSION['customer_id']) .FS_DIALOG_A.'</div>
          <div class="my_agent_pop">
          <ul class="Management_Review_10">
            <form id="form1" name="form1" method="post" action="">            	
				
				<li><p>'.FS_DIALOG_TITLE.':</p>
                <input class="big_input" type="text" name="title" id="title" placeholder="">
                <i class="help_info"></i>
                <div style="display:none;" class="error_prompt " id="n_of_title" name="question_subject_err">'.FS_DIALOG_YOUR.'</div>
                </li> 
				<li><p>'.FS_DIALOG_CONTENT.': </p>
                <textarea onkeyup="textCounter(this.form.question,this.form.remLen,3000);" onkeydown="textCounter(this.form.question,this.form.remLen,3000);" class="login_014 aaa" name="content" id="content" placeholder="'.FS_DIALOG_PLEASE.'"></textarea>
				<div style="display:none;" class="error_prompt " id="n_of_content" name="question_err">'.FS_DIALOG_YOUR2.'</div>
				<div style="display:none;" class="error_prompt " id="n_of_title_content" name="question1_err">'.FS_DIALOG_PLEASE1.'</div>
				</li>
				<input type="button" value="'.FS_SUBMIT.'"  class="button_02" onClick="ajax_get_save_question()">
				<a class="button_01" onclick="$(\'.ui-widget-overlay,#fs_popup\').hide();" href="javascript: ;">'.FS_CANCEL.'</a>
				<div class="ccc"></div>
                </form>    
          </ul>

			<div class="box_close"><a onclick="$(\'.ui-widget-overlay,#fs_popup\').hide();" href="javascript: ;"></a></div>
			<div class="ccc"></div>
			</form>
		  </div>
		</div>';
	return $html;
	}
	function display_qa() {
		$html ='
		   <div class="ui-overlay" id="fs_overlay" >
		   <div class="ui-widget-overlay" style="filter: alpha(opacity=30);"></div>
		   </div>
			<div id="fs_popup" class="ui-widget ui-widget-content ui-corner-all  ui-corner_pop">
			  <div style="background: none; border: 0; " class="ui-dialog-content ui-widget-content"> 
			  <form id="orderForm" method="post">
			   <div class="cancel_order_title"> '.FS_DIALOG_ASK. zen_customer_has_admin_of_cid($_SESSION['customer_id']) .FS_DIALOG_A.' </div>
			  <div class="my_agent_pop">
			  <ul class="Management_Review_10">
				<form id="form1" name="form1" method="post" action="">            	
					
					<li><p>'.FS_DIALOG_TITLE.':</p>
					<input class="big_input" type="text" name="subject" id="subject" placeholder="">
					<i class="help_info"></i>
					<div style="display:none;" class="error_prompt " id="n_of_title" name="question_subject_err">'.FS_DIALOG_YOUR.'</div>
					</li> 
					<li><p>'.FS_DIALOG_CONTENT.': </p>
					<textarea onkeyup="textCounter(this.form.question,this.form.remLen,3000);" onkeydown="textCounter(this.form.question,this.form.remLen,3000);" class="login_014 aaa" name="question" id="question" placeholder="'.FS_DIALOG_PLEASE.'"></textarea>
					<div style="display:none;" class="error_prompt " id="n_of_content" name="question_err">'.FS_DIALOG_YOUR2.'</div>
					<div style="display:none;" class="error_prompt " id="n_of_title_content" name="question1_err">'.FS_DIALOG_PLEASE1.'</div>
					</li>
					<input type="button" value="'.FS_SUBMIT.'"  class="button_02" onClick="ajax_get_save_qa()">
					<a class="button_01" onclick="$(\'.ui-widget-overlay,#fs_popup\').hide();" href="javascript: ;">'.FS_CANCEL.'</a>
					<div class="ccc"></div>
					</form>    
			  </ul>

			<div class="box_close"><a onclick="$(\'.ui-widget-overlay,#fs_popup\').hide();" href="javascript: ;"></a></div>
			<div class="ccc"></div>
			</form>
		  </div>
		</div>';
		return $html;
	}
	function display_left_qa() {
		$html ='
		   <div class="ui-widget-overlay" style="display: block;"></div>
			<div id="left_popup" class="ui-widget ui-widget-content ui-corner-all ui-corner-layer ui-corner-fixed">
			  <form id="orderForm" method="post">
			   <div class="popup_tit">Ask '. zen_customer_has_admin_of_cid($_SESSION['customer_id']) .FS_DIALOG_A .'</div>
			  <div class="popup_con my_questions_pop ">
			  <ul class="Management_Review_10">
				<form id="leftform1" name="form1" method="post" action="">            	
					
					<li><p>'.FS_DIALOG_TITLE .':</p>
					<input class="big_input" type="text" name="leftsubject" id="leftsubject" placeholder="">
					<i class="help_info"></i>
					<div style="display:none;" class="error_prompt " id="n_of_lefttitle" name="question_subject_err">'.FS_DIALOG_YOUR.'</div>
					</li> 
					<li><p>'.FS_DIALOG_CONTENT .': </p>
					<textarea onkeyup="textCounter(this.form.question,this.form.remLen,3000);" onkeydown="textCounter(this.form.question,this.form.remLen,3000);" class="login_014 aaa" name="leftquestion" id="leftquestion" placeholder="'.FS_DIALOG_PLEASE .'"></textarea>
					<div style="display:none;" class="error_prompt " id="n_of_leftcontent" name="question_err">'.FS_DIALOG_YOUR2 .'</div>
					<div style="display:none;" class="error_prompt " id="n_of_left_content" name="question1_err">'.FS_DIALOG_PLEASE1 .'</div>
					<div class="ccc"></div>
					</li>
					<input type="button" value="'.FS_SUBMIT .'"  class="button_02" onClick="ajax_get_save_left_qa()">
					<a class="button_01" onclick="$(\'.ui-widget-overlay,#left_popup\').hide();" href="javascript: ;">'.FS_CANCEL .'</a>
					<div class="ccc"></div>
					</form>    
			  </ul>

		<div class="box_close"><a onclick="$(\'.ui-widget-overlay,#left_popup\').hide();" href="javascript: ;"></a></div>
		<div class="ccc"></div>
		</form>

	</div>';
	return $html;
	}
}
?>
