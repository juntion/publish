<?php
$output .='<table align="center" border="1" cellspacing="0" cellpadding="0" width="80%" style="text-align:center;line-height: 30px;">';
$output .='<caption style="font-size:16px;color:blue;font-weight:bolder;">客户订单附属信息:</caption>';
$output .= '<tr><th>name</th><th>country</th><th>telephone</th><th>time</th></tr>';
while (!$hsbc->EOF){

	$output .= '<tr><td>'.$hsbc->fields['sender_name'].'</td><td>'.$hsbc->fields['countries_name'].'</td><td>'.$hsbc->fields['sender_telephone'].'</td><td>'.$hsbc->fields['sender_time'].'</td></tr>';
	$hsbc->MoveNext();
}
$output .='</table>';