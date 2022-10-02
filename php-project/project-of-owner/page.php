<?php

require('./includes/common.inc.php');

$action  = isset($_REQUEST['act']) ? trim($_REQUEST['act']) : '';
$option  = isset($_REQUEST['opt']) ? trim($_REQUEST['opt']) : '';

if($action == 'visitor' && $option == 'enquiry') { // 咨询
	
	include template('enquiry');
}
elseif($action == 'visitor' && $option == 'insert_enquiry') { // 插入咨询
	session_start();
	$result   = array('content'=>array(), 'error' => 0, 'message' => '');
	$show_msg = '';
	$user_name = !empty($_POST['user_name']) ? htmlspecialchars($_POST['user_name']) : '';
    $email = is_email($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
	$content = !empty($_POST['content']) ? htmlspecialchars($_POST['content']) : '';
	$captcha = !empty($_POST['captcha']) ? htmlspecialchars($_POST['captcha']) : '';
    
	if (!$user_name) {
		$show_msg = '姓名不能为空';
	} elseif (!$email) {
		$show_msg = '邮箱格式不正确';
	} elseif (!$content) {
		$show_msg = '咨询内容不能为空';
	} elseif (!$captcha) {
		$show_msg = '验证码不能为空';
	} elseif (md5($captcha) != $_SESSION['vcode']) {
		$show_msg = '验证码输入错误';
	}

	if (empty($show_msg)) {
		/* 保存评论内容 */
		$query = "INSERT INTO comment" .
			   " (email, user_name, content, add_time, ip_address, parent_id) VALUES " .
			   " ('$email', '$user_name', '" .$content."', ".time().", '".$onlineip."', '0')";

		$db->query($query);
		$result['message'] = urlencode(iconv('gb2312','utf-8', '已经功提交您的咨询'));
		die(json_encode($result));
	} else {
		$result['error'] = 1;
		$result['message'] = urlencode(iconv('gb2312','utf-8', $show_msg));
		die(json_encode($result));
	}
}
else {
	
	$page = $db->fetch_first("SELECT menu, cat, content, en_content, add_time FROM page WHERE menu='$action' AND cat='$option'");
	
	$page_local_arr = count($os_menu_list[$action]['menu_list'])>0 ? array($os_menu_list[$action]['menu_list'][$option]['name'], $os_menu_list[$action]['menu_name']) : array($os_menu_list[$option]['menu_name']);
	$page_local = join(' &gt; ', $page_local_arr);
	$page_head_local = join('_', $page_local_arr);
	
	include template('page');
}
?>