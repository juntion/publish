<?php
$output .='<table align="center" border="1" cellspacing="0" cellpadding="0" width="80%" style="text-align:center;line-height: 30px;">';
$output .='<caption>客户订单附属信息:</caption>';
$output .= '<tr><th>transfer number</td><th>name</th><th>address</th><th>city</th><th>country</th><th>state</th><th>postcode</th><th>telephone</th><th>question</th><th>answer</th><th>time</th></tr>';
while (!$westernuion->EOF){

	$output .= '<tr><td>'.$westernuion->fields['sender_transfer_number'].'</td><td>'.
		$westernuion->fields['sender_firstname'] .' '.$westernuion->fields['sender_middlername'].' '.$westernuion->fields['sender_lastname'].'</td><td>'.
		$westernuion->fields['sender_street_address'].'</td><td>'.
		$westernuion->fields['sender_city'].'</td><td>'.
		$westernuion->fields['countries_name'].'</td><td>'.
		$westernuion->fields['sender_state'].'</td><td>'.
		$westernuion->fields['sender_postcode'].'</td><td>'.
		$westernuion->fields['sender_telephone'].'</td><td>'.
		$westernuion->fields['sender_question'].'</td><td>'.
		$westernuion->fields['sender_answer'].'</td><td>'.
		$westernuion->fields['sender_time'].'</td></tr>';
	$westernuion->MoveNext();
}
$output .='</table>';