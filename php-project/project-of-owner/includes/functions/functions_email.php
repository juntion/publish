<?php
use App\Config\EmailConfig;
/**
 * Set email system debugging off or on
 * 0=off
 * 1=show SMTP status errors
 * 2=show SMTP server responses
 * 4=show SMTP readlines if applicable
 * 5=maximum information
 * 'preview' to show HTML-emails on-screen while sending
 */
if (!defined('EMAIL_SYSTEM_DEBUG')) define('EMAIL_SYSTEM_DEBUG','0');
if (!defined('EMAIL_ATTACHMENTS_ENABLED')) define('EMAIL_ATTACHMENTS_ENABLED', true);
/**
 * enable embedded image support
 */
if (!defined('EMAIL_ATTACH_EMBEDDED_IMAGES')) define('EMAIL_ATTACH_EMBEDDED_IMAGES', 'Yes');

/**
 * If using authentication protocol, enter appropriate option here: 'ssl' or 'tls' or 'starttls'
 * If using 'starttls', you must add a define for 'SMTPAUTH_EMAIL_CERTIFICATE_CONTEXT' in the extra_datafiles folder to supply your certificate-context
 */
if (!defined('SMTPAUTH_EMAIL_PROTOCOL')) define('SMTPAUTH_EMAIL_PROTOCOL', 'none');


function zen_mail($to_name, $to_address, $email_subject, $email_text, $from_email_name, $from_email_address, $block=array(), $module='default', $attachments_list='',$add_bcc='' ) {
    global $db, $messageStack, $zco_notifier;
    if($to_address==$from_email_address){
        return;
    }
    //注册邮件判断是否为空数据ternence.qin
    if($email_subject=="Customer Info" && !$block['EMAIL_BODY']){
        return;
    }
    if (!defined('DEVELOPER_OVERRIDE_EMAIL_STATUS') || (defined('DEVELOPER_OVERRIDE_EMAIL_STATUS') && DEVELOPER_OVERRIDE_EMAIL_STATUS == 'site'))
        if (SEND_EMAILS != 'true') return false;  // if sending email is disabled in Admin, just exit

    if (defined('DEVELOPER_OVERRIDE_EMAIL_ADDRESS') && DEVELOPER_OVERRIDE_EMAIL_ADDRESS != '') $to_address = DEVELOPER_OVERRIDE_EMAIL_ADDRESS;

    // ignore sending emails for any of the following pages
    // (The EMAIL_MODULES_TO_SKIP constant can be defined in a new file in the "extra_configures" folder)
    if (defined('EMAIL_MODULES_TO_SKIP') && in_array($module,explode(",",constant('EMAIL_MODULES_TO_SKIP')))) return false;

    // check for injection attempts. If new-line characters found in header fields, simply fail to send the message
    foreach(array($from_email_address, $to_address, $from_email_name, $to_name, $email_subject) as $key=>$value) {
        if (preg_match("/\r/i",$value) || preg_match("/\n/i",$value)) return false;
    }

    // if no text or html-msg supplied, exit
    if (trim($email_text) == '' && (!zen_not_null($block) || (isset($block['EMAIL_MESSAGE_HTML']) && $block['EMAIL_MESSAGE_HTML'] == '')) ) return false;

    // Parse "from" addresses for "name" <email@address.com> structure, and supply name/address info from it.
    if (preg_match("/ *([^<]*) *<([^>]*)> */i",$from_email_address,$regs)) {
        $from_email_name = trim($regs[1]);
        $from_email_address = $regs[2];
    }
    // if email name is same as email address, use the Store Name as the senders 'Name'
    if ($from_email_name == $from_email_address) $from_email_name = STORE_NAME;

    // loop thru multiple email recipients if more than one listed  --- (esp for the admin's "Extra" emails)...
    foreach(explode(',',$to_address) as $key=>$value) {
        if ($value != $from_email_address) {
            if (preg_match("/ *([^<]*) *<([^>]*)> */i", $value, $regs)) {
                $to_name = str_replace('"', '', trim($regs[1]));
                $to_email_address = $regs[2];
            } elseif (preg_match("/ *([^ ]*) */i", $value, $regs)) {
                $to_email_address = trim($regs[1]);
            }
            if (!isset($to_email_address)) $to_email_address = trim($to_address); //if not more than one, just use the main one.

            //define some additional html message blocks available to templates, then build the html portion.
            //define some additional html message blocks available to templates, then build the html portion.
            if (!isset($block['EMAIL_TO_NAME']) || $block['EMAIL_TO_NAME'] == '') $block['EMAIL_TO_NAME'] = $to_name;
            if (!isset($block['EMAIL_TO_ADDRESS']) || $block['EMAIL_TO_ADDRESS'] == '') $block['EMAIL_TO_ADDRESS'] = $to_email_address;
            if (!isset($block['EMAIL_SUBJECT']) || $block['EMAIL_SUBJECT'] == '') $block['EMAIL_SUBJECT'] = $email_subject;
            if (!isset($block['EMAIL_FROM_NAME']) || $block['EMAIL_FROM_NAME'] == '') $block['EMAIL_FROM_NAME'] = $from_email_name;
            if (!isset($block['EMAIL_FROM_ADDRESS']) || $block['EMAIL_FROM_ADDRESS'] == '') $block['EMAIL_FROM_ADDRESS'] = $from_email_address;

            /*bof use costome words*/
            if (isset($_SESSION['customer_email_data']) && is_array($_SESSION['customer_email_data'])) {
                /* FOR OUR custome information*/
                if (!isset($block['FIRSTNAME']) || $block['FIRSTNAME'] == '') $block['FIRSTNAME'] = $_SESSION['customer_email_data']['firstname'];
                if (!isset($block['LASTNAME']) || $block['LASTNAME'] == '') $block['LASTNAME'] = $_SESSION['customer_email_data']['lastname'];
                if (!isset($block['EMAIL_ADDRESS']) || $block['EMAIL_ADDRESS'] == '') $block['EMAIL_ADDRESS'] = $_SESSION['customer_email_data']['email_address'];
                if (!isset($block['PASSWORD']) || $block['PASSWORD'] == '') $block['PASSWORD'] = $_SESSION['customer_email_data']['password'];

            }
            /*eof use costome words*/


            $email_html = (!is_array($block) && substr($block, 0, 6) == '<html>') ? $block : zen_build_html_email_from_template($module, $block);
            $email_html = str_replace('$user_email',$to_address,$email_html);
            if (!is_array($block) && $block == '' || $block == 'none') $email_html = '';

            // Build the email based on whether customer has selected HTML or TEXT, and whether we have supplied HTML or TEXT-only components
            // special handling for XML content
            if ($email_text == '') {
                $email_text = str_replace(array('<br>', '<br />'), "<br />\n", $block['EMAIL_MESSAGE_HTML']);
                $email_text = str_replace('</p>', "</p>\n", $email_text);
                $email_text = ($module != 'xml_record') ? htmlspecialchars(stripslashes(strip_tags($email_text))) : $email_text;
            } else {
                $email_text = ($module != 'xml_record') ? strip_tags($email_text) : $email_text;
            }

            if ($module != 'xml_record') {
                if (!strstr($email_text, sprintf(EMAIL_DISCLAIMER, STORE_OWNER_EMAIL_ADDRESS)) && $to_email_address != STORE_OWNER_EMAIL_ADDRESS && !defined('EMAIL_DISCLAIMER_NEW_CUSTOMER')) $email_text .= "\n" . sprintf(EMAIL_DISCLAIMER, STORE_OWNER_EMAIL_ADDRESS);
                if (defined('EMAIL_SPAM_DISCLAIMER') && EMAIL_SPAM_DISCLAIMER != '' && !strstr($email_text, EMAIL_SPAM_DISCLAIMER) && $to_email_address != STORE_OWNER_EMAIL_ADDRESS) $email_text .= "\n" . EMAIL_SPAM_DISCLAIMER;
            }

            // bof: body of the email clean-up
            // clean up &amp; and && from email text
            while (strstr($email_text, '&amp;&amp;')) $email_text = str_replace('&amp;&amp;', '&amp;', $email_text);
            while (strstr($email_text, '&amp;')) $email_text = str_replace('&amp;', '&', $email_text);
            while (strstr($email_text, '&&')) $email_text = str_replace('&&', '&', $email_text);

            // clean up currencies for text emails
            $zen_fix_currencies = preg_split("/[:,]/", CURRENCIES_TRANSLATIONS);
            $size = sizeof($zen_fix_currencies);
            for ($i = 0, $n = $size; $i < $n; $i += 2) {
                $zen_fix_current = $zen_fix_currencies[$i];
                $zen_fix_replace = $zen_fix_currencies[$i + 1];
                if (strlen($zen_fix_current) > 0) {
                    while (strpos($email_text, $zen_fix_current)) $email_text = str_replace($zen_fix_current, $zen_fix_replace, $email_text);
                }
            }

            // fix double quotes
            while (strstr($email_text, '&quot;')) $email_text = str_replace('&quot;', '"', $email_text);
            // prevent null characters
            while (strstr($email_text, chr(0))) $email_text = str_replace(chr(0), ' ', $email_text);

            // fix slashes
            $text = stripslashes($email_text);
            $email_html = stripslashes($email_html);

            // eof: body of the email clean-up

            //determine customer's email preference type: HTML or TEXT-ONLY  (HTML assumed if not specified)
            $sql = "select customers_email_format from " . TABLE_CUSTOMERS . " where customers_email_address= :custEmailAddress:";
            $sql = $db->bindVars($sql, ':custEmailAddress:', $to_email_address, 'string');
            $result = $db->Execute($sql);
            $customers_email_format = ($result->RecordCount() > 0) ? $result->fields['customers_email_format'] : '';

            if ($customers_email_format == 'NONE' || $customers_email_format == 'OUT') return; //if requested no mail, then don't send.
//      if ($customers_email_format == 'HTML') $customers_email_format = 'HTML'; // if they opted-in to HTML messages, then send HTML format

            // handling admin/"extra"/copy emails:
            if (ADMIN_EXTRA_EMAIL_FORMAT == 'TEXT' && substr($module, -6) == '_extra') {
                $email_html = '';  // just blank out the html portion if admin has selected text-only
            }
            //determine what format to send messages in if this is an admin email for newsletters:
            /*      if ($customers_email_format == '' && ADMIN_EXTRA_EMAIL_FORMAT == 'HTML' && in_array($module, array('newsletters', 'product_notification')) && isset($_SESSION['admin_id'])) {
                    $customers_email_format = 'HTML';
                  }*/


            // special handling for XML content
            if ($module == 'xml_record') {
                $email_html = '';
                $customers_email_format = 'TEXT';
            }

            //notifier intercept option
            $zco_notifier->notify('NOTIFY_EMAIL_AFTER_EMAIL_FORMAT_DETERMINED');

            // now lets build the mail object with the phpmailer class
            $mail = new PHPMailer();
            $lang_code = strtolower(($_SESSION['languages_code'] == '' ? 'en' : $_SESSION['languages_code']));
            $mail->SetLanguage($lang_code, DIR_FS_CATALOG . DIR_WS_CLASSES . 'support/');
            $mail->CharSet = (defined('CHARSET')) ? CHARSET : "iso-8859-1";
            $mail->Encoding = (defined('EMAIL_ENCODING_METHOD')) ? EMAIL_ENCODING_METHOD : "7bit";
            if ((int)EMAIL_SYSTEM_DEBUG > 0) $mail->SMTPDebug = (int)EMAIL_SYSTEM_DEBUG;
            $mail->WordWrap = 76;    // set word wrap to 76 characters
            // set proper line-endings based on switch ... important for windows vs linux hosts:
            $mail->LE = (EMAIL_LINEFEED == 'CRLF') ? "\r\n" : "\n";

            switch (EMAIL_TRANSPORT) {
                case 'smtp':
                    $mail->IsSMTP();
                    $mail->Host = trim(EMAIL_SMTPAUTH_MAIL_SERVER);
                    if (EMAIL_SMTPAUTH_MAIL_SERVER_PORT != '25' && EMAIL_SMTPAUTH_MAIL_SERVER_PORT != '') $mail->Port = trim(EMAIL_SMTPAUTH_MAIL_SERVER_PORT);
                    $mail->LE = "\r\n";
                    break;
                case 'smtpauth':
                    $mail->IsSMTP();
                    $mail->SMTPAuth = true;

                    // fairy add 不同情况用不同账号发邮件
                    // 带fs.com的邮箱是谷歌邮箱
                    if ($from_email_address == 'account@fs.com') {
                        $mail->Username = 'account@fs.com';
                        $mail->Password = 'yuxuan3507';
                    } elseif ($from_email_address == 'noreply@fs.com') {
                        $mail->Username = 'noreply@fs.com';
                        $mail->Password = 'yuxuan35073507';
                    } else {
                        $mail->Username = (zen_not_null(EMAIL_SMTPAUTH_MAILBOX)) ? trim(EMAIL_SMTPAUTH_MAILBOX) : EMAIL_FROM;
                        $mail->Password = trim(EMAIL_SMTPAUTH_PASSWORD);
                    }

                    $mail->Host = trim(EMAIL_SMTPAUTH_MAIL_SERVER);
                    if (EMAIL_SMTPAUTH_MAIL_SERVER_PORT != '25' && EMAIL_SMTPAUTH_MAIL_SERVER_PORT != '') $mail->Port = trim(EMAIL_SMTPAUTH_MAIL_SERVER_PORT);
                    $mail->LE = "\r\n";
                    //set encryption protocol to allow support for Gmail or other secured email protocols
                    if (EMAIL_SMTPAUTH_MAIL_SERVER_PORT == '465' || EMAIL_SMTPAUTH_MAIL_SERVER_PORT == '587' || EMAIL_SMTPAUTH_MAIL_SERVER == 'smtp.gmail.com') $mail->Protocol = 'ssl';
                    if (defined('SMTPAUTH_EMAIL_PROTOCOL') && SMTPAUTH_EMAIL_PROTOCOL != 'none') {
                        $mail->Protocol = SMTPAUTH_EMAIL_PROTOCOL;
                        if (SMTPAUTH_EMAIL_PROTOCOL == 'starttls' && defined('SMTPAUTH_EMAIL_CERTIFICATE_CONTEXT')) {
                            $mail->Starttls = true;
                            $mail->Context = SMTPAUTH_EMAIL_CERTIFICATE_CONTEXT;
                        }
                    }
                    break;
                case 'PHP':
                    $mail->IsMail();
                    break;
                case 'Qmail':
                    $mail->IsQmail();
                    break;
                case 'sendmail':
                case 'sendmail-f':
                    $mail->LE = "\n";
                default:
                    $mail->IsSendmail();
                    if (defined('EMAIL_SENDMAIL_PATH')) $mail->Sendmail = trim(EMAIL_SENDMAIL_PATH);
                    break;
            }

            $mail->Subject = $email_subject;
            $mail->From = $from_email_address;
            $mail->FromName = $from_email_name;
            $mail->AddAddress($to_email_address, $to_name);
            //$mail->AddAddress($to_email_address);    // (alternate format if no name, since name is optional)
            //$mail->AddBCC(STORE_NAME, STORE_OWNER_EMAIL_ADDRESS);
            if($add_bcc !=''){
                if(is_array($add_bcc)){
                    foreach ($add_bcc as $k => $v) {
                        $mail->AddBCC($v);
                    }
                }else{
                    $mail->AddBCC($add_bcc);
                }
            }

            // set the reply-to address.  If none set yet, then use Store's default email name/address.
            // If sending from contact-us or tell-a-friend page, use the supplied info
            $email_reply_to_address = (isset($email_reply_to_address) && $email_reply_to_address != '') ? $email_reply_to_address : (in_array($module, array('contact_us', 'tell_a_friend')) ? $from_email_address : EMAIL_FROM);
            $email_reply_to_name = (isset($email_reply_to_name) && $email_reply_to_name != '') ? $email_reply_to_name : (in_array($module, array('contact_us', 'tell_a_friend')) ? $from_email_name : STORE_NAME);
            $mail->AddReplyTo($email_reply_to_address, $email_reply_to_name);

            // if mailserver requires that all outgoing mail must go "from" an email address matching domain on server, set it to store address
            if (EMAIL_SEND_MUST_BE_STORE == 'Yes') $mail->From = EMAIL_FROM;

            if (EMAIL_TRANSPORT == 'sendmail-f' || EMAIL_SEND_MUST_BE_STORE == 'Yes') {
                $mail->Sender = EMAIL_FROM;
            }

            if (EMAIL_USE_HTML == 'true') $email_html = processEmbeddedImages($email_html, $mail);

            // PROCESS FILE ATTACHMENTS
            if ($attachments_list == '') $attachments_list = array();
            if (is_string($attachments_list)) {
                if (file_exists($attachments_list)) {
                    $attachments_list = array(array('file' => $attachments_list));
                } elseif (file_exists(DIR_FS_CATALOG . $attachments_list)) {
                    $attachments_list = array(array('file' => DIR_FS_CATALOG . $attachments_list));
                } else {
                    $attachments_list = array();
                }
            }
            global $newAttachmentsList;
            $zco_notifier->notify('NOTIFY_EMAIL_BEFORE_PROCESS_ATTACHMENTS', array('attachments' => $attachments_list, 'module' => $module));
            if (isset($newAttachmentsList) && is_array($newAttachmentsList)) $attachments_list = $newAttachmentsList;
            if (defined('EMAIL_ATTACHMENTS_ENABLED') && EMAIL_ATTACHMENTS_ENABLED && is_array($attachments_list) && sizeof($attachments_list) > 0) {
                foreach ($attachments_list as $key => $val) {
                    $fname = (isset($val['name']) ? $val['name'] : null);
                    $mimeType = (isset($val['mime_type']) && $val['mime_type'] != '' && $val['mime_type'] != 'application/octet-stream') ? $val['mime_type'] : '';
                    switch (true) {
                        case (isset($val['raw_data']) && $val['raw_data'] != ''):
                            $fdata = $val['raw_data'];
                            if ($mimeType != '') {
                                $mail->AddStringAttachment($fdata, $fname, "base64", $mimeType);
                            } else {
                                $mail->AddStringAttachment($fdata, $fname);
                            }
                            break;
                        case (isset($val['file']) && file_exists($val['file'])): //'file' portion must contain the full path to the file to be attached
                            $fdata = $val['file'];
                            if ($mimeType != '') {
                                $mail->AddAttachment($fdata, $fname, "base64", $mimeType);
                            } else {
                                $mail->AddAttachment($fdata, $fname);
                            }
                            break;
                    } // end switch
                } //end foreach attachments_list
            } //endif attachments_enabled
            $zco_notifier->notify('NOTIFY_EMAIL_AFTER_PROCESS_ATTACHMENTS', sizeof($attachments_list));

            /*bof force to use html format*/
            $customers_email_format = 'HTML';
            /*bof force to use html format*/


            // prepare content sections:
            if (EMAIL_USE_HTML == 'true' && trim($email_html) != '' &&
                ($customers_email_format == 'HTML' || (ADMIN_EXTRA_EMAIL_FORMAT != 'TEXT' && substr($module, -6) == '_extra'))
            ) {
                $mail->IsHTML(true);           // set email format to HTML
                $mail->Body = $email_html;  // HTML-content of message
                $mail->AltBody = $text;        // text-only content of message
            } else {                        // use only text portion if not HTML-formatted
                $mail->Body = $text;        // text-only content of message
            }

            /**
             * Send the email. If an error occurs, trap it and display it in the messageStack
             */

            $ErrorInfo = '';
            $zco_notifier->notify('NOTIFY_EMAIL_READY_TO_SEND');
            if (!($result = $mail->Send())) {
                //邮件错误日志        调试用
                $file_path = DIR_FS_CATALOG . 'includes/languages/email/log/';
                $file_name = 'email_error_log_' . date('YmdHis') . mt_rand(1000, 9999) . '.log';
                $fp = fopen($file_path . $file_name, 'w') or die($file_path . $file_name);
                if (IS_ADMIN_FLAG === true) {
                    $messageStack->add_session(sprintf(EMAIL_SEND_FAILED . '&nbsp;' . $mail->ErrorInfo, $to_name, $to_email_address, $email_subject), 'error');
                } else {
                    $messageStack->add('header', sprintf(EMAIL_SEND_FAILED . '&nbsp;' . $mail->ErrorInfo, $to_name, $to_email_address, $email_subject), 'error');
                }
                if ($fp) {
                    $time = gmdate('Y-m-d H:i:s');
                    $unix_time = strtotime($time) + 3600 * 8;
                    $bj_time = date('Y-m-d H:i:s', $unix_time);
                    $content = '[' . $bj_time . '] Email error info:' . $mail->ErrorInfo . ';   To name:' . $to_name . ';   To email:' . $to_email_address . ';  Email subject:' . $email_subject . ';  Email_template:' . $module;
                    fwrite($fp, $content) or die($content);
                }
                fclose($fp);
                $file_error_array = scandir($file_path);  //日志删除
                $file_num = count($file_error_array) - 2;
                $arr = array();
                foreach ($file_error_array as $v) {
                    if (is_file($file_path . $v)) {
                        $arr[filemtime($file_path . $v)] = $v;
                    }
                }
                ksort($arr);
                if ($file_num > 25) {
                    $i = 0;
                    foreach ($arr as $k => $v) {
                        if ($i == 0) {
                            unlink($file_path . $arr[$k]);
                        }
                        $i++;
                    }
                }
                $ErrorInfo .= $mail->ErrorInfo . '<br />';
            }
            $zco_notifier->notify('NOTIFY_EMAIL_AFTER_SEND');

            // Archive this message to storage log
            // don't archive pwd-resets and CC numbers
            if (EMAIL_ARCHIVE == 'true' && $module != 'password_forgotten_admin' && $module != 'cc_middle_digs' && $module != 'no_archive') {
                zen_mail_archive_write($to_name, $to_email_address, $from_email_name, $from_email_address, $email_subject, $email_html, $text, $module, $ErrorInfo);
            } // endif archiving
        }
    }// end foreach loop thru possible multiple email addresses
    $zco_notifier->notify('NOTIFY_EMAIL_AFTER_SEND_ALL_SPECIFIED_ADDRESSES');
    sendingMailRecord($to_name, $to_address, $from_email_name, $from_email_address,$ErrorInfo);
    if (EMAIL_FRIENDLY_ERRORS=='false' && $ErrorInfo != '') die('<br /><br />Email Error: ' . $ErrorInfo);

    return $ErrorInfo;
}  // end function

function sendingMailRecord($to_name, $to_email_address, $from_email_name, $from_email_address,$ErrorInfo){
    if(!empty($to_email_address) && !empty($from_email_name)){
        $data =[
            'send_time'=>time(),
            'recipient'=>$to_name,
            'send_mailbox '=>$to_email_address,
            'sender'=>$from_email_name,
            'addressee '=>$from_email_address,
            'description'=>$ErrorInfo,
            'delivery_status' =>$ErrorInfo?"":1,
        ];
        zen_db_perform('send_email', $data, 'insert');
    }
}
/**
 * zen_mail_archive_write()
 *
 * this function stores sent emails into a table in the database as a log record of email activity.  This table CAN get VERY big!
 * To disable this function, set the "Email Archives" switch to 'false' in ADMIN!
 *
 * See zen_mail() function description for more details on the meaning of these parameters
 * @param string $to_name
 * @param string $to_email_address
 * @param string $from_email_name
 * @param string $from_email_address
 * @param string $email_subject
 * @param string $email_html
 * @param array $email_text
 * @param string $module
 **/
function zen_mail_archive_write($to_name, $to_email_address, $from_email_name, $from_email_address, $email_subject, $email_html, $email_text, $module, $error_msgs) {
    global $db;
    $to_name = zen_db_prepare_input($to_name);
    $to_email_address = zen_db_prepare_input($to_email_address);
    $from_email_name = zen_db_prepare_input($from_email_name);
    $from_email_address = zen_db_prepare_input($from_email_address);
    $email_subject = zen_db_prepare_input($email_subject);
    $email_html = (EMAIL_USE_HTML=='true') ? zen_db_prepare_input($email_html) : zen_db_prepare_input('HTML disabled in admin');
    $email_text = zen_db_prepare_input($email_text);
    $module = zen_db_prepare_input($module);
    $error_msgs = zen_db_prepare_input($error_msgs);

}

//DEFINE EMAIL-ARCHIVABLE-MODULES LIST // this array will likely be used by the email archive log VIEWER module in future
$emodules_array = array();
$emodules_array[] = array('id' => 'newsletters', 'text' => 'Newsletters');
$emodules_array[] = array('id' => 'product_notification', 'text' => 'Product Notifications');
$emodules_array[] = array('id' => 'direct_email', 'text' => 'One-Time Email');
$emodules_array[] = array('id' => 'contact_us', 'text' => 'Contact Us');
$emodules_array[] = array('id' => 'coupon', 'text' => 'Send Coupon');
$emodules_array[] = array('id' => 'coupon_extra', 'text' => 'Send Coupon');
$emodules_array[] = array('id' => 'gv_queue', 'text' => 'Send-GV-Queue');
$emodules_array[] = array('id' => 'gv_mail', 'text' => 'Send-GV');
$emodules_array[] = array('id' => 'gv_mail_extra', 'text' => 'Send-GV-Extra');
$emodules_array[] = array('id' => 'welcome', 'text' => 'New Customer Welcome');
$emodules_array[] = array('id' => 'welcome_extra', 'text' => 'New Customer Welcome-Extra');
$emodules_array[] = array('id' => 'password_forgotten', 'text' => 'Password Forgotten');
$emodules_array[] = array('id' => 'password_forgotten_admin', 'text' => 'Password Forgotten');
$emodules_array[] = array('id' => 'checkout', 'text' => 'Checkout');
$emodules_array[] = array('id' => 'checkout_extra', 'text' => 'Checkout-Extra');
$emodules_array[] = array('id' => 'order_status', 'text' => 'Order Status');
$emodules_array[] = array('id' => 'order_status_extra', 'text' => 'Order Status-Extra');
$emodules_array[] = array('id' => 'low_stock', 'text' => 'Low Stock Notices');
$emodules_array[] = array('id' => 'cc_middle_digs', 'text' => 'CC - Middle-Digits');
$emodules_array[] = array('id' => 'tell_a_friend', 'text' => 'Tell-A-Friend');
$emodules_array[] = array('id' => 'tell_a_friend_extra', 'text' => 'Tell-A-Friend-Extra');
$emodules_array[] = array('id' => 'purchase_order', 'text' => 'Purchase Order');
$emodules_array[] = array('id' => 'payment_modules', 'text' => 'Payment Modules');
$emodules_array[] = array('id' => 'payment_modules_extra', 'text' => 'Payment Modules-Extra');
/////////////////////////////////////////////////////////////////////////////////////////
////////END SECTION FOR EMAIL FUNCTIONS//////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////


/**
 * select email template based on 'module' (supplied as param to function)
 * selectively go thru each template tag and substitute appropriate text
 * finally, build full html content as "return" output from class
 **/
function zen_build_html_email_from_template($module='default', $content='') {
    global $messageStack, $current_page_base;
    $block = array();
    if (is_array($content)) {
        $block = $content;
    } else {
        $block['EMAIL_MESSAGE_HTML'] = $content;
    }
    // Identify and Read the template file for the type of message being sent
    //$langfolder = (strtolower($_SESSION['languages_code']) == 'en') ? '' : strtolower($_SESSION['languages_code']) . '/';
    $langfolder = '';
    $template_filename_base = DIR_FS_EMAIL_TEMPLATES . $langfolder . "email_template_";
    $template_filename = DIR_FS_EMAIL_TEMPLATES . $langfolder . "email_template_" . $current_page_base . ".html";

    if (!file_exists($template_filename)) {
        if (isset($block['EMAIL_TEMPLATE_FILENAME']) && $block['EMAIL_TEMPLATE_FILENAME'] != '' && file_exists($block['EMAIL_TEMPLATE_FILENAME'] . '.html')) {
            $template_filename = $block['EMAIL_TEMPLATE_FILENAME'] . '.html';
        } elseif (file_exists($template_filename_base . str_replace(array('_extra','_admin'),'',$module) . '.html')) {
            $template_filename = $template_filename_base . str_replace(array('_extra','_admin'),'',$module) . '.html';
        } elseif (file_exists($template_filename_base . 'default' . '.html')) {
            $template_filename = $template_filename_base . 'default' . '.html';
        } else {
            if(isset($messageStack)) $messageStack->add('header','ERROR: The email template file for (' . $template_filename_base . ') or (' . $template_filename . ') cannot be found.','caution');
            return ''; // couldn't find template file, so return an empty string for html message.
        }
    }
    if (!$fh = fopen($template_filename, 'rb')) {   // note: the 'b' is for compatibility with Windows systems
        if (isset($messageStack)) $messageStack->add('header','ERROR: The email template file (' . $template_filename_base . ') or (' . $template_filename . ') cannot be opened', 'caution');
    }

    $file_holder = fread($fh, filesize($template_filename));
    fclose($fh);

    //strip linebreaks and tabs out of the template
//  $file_holder = str_replace(array("\r\n", "\n", "\r", "\t"), '', $file_holder);
    $file_holder = str_replace(array("\t"), ' ', $file_holder);


    if (!defined('HTTP_CATALOG_SERVER')) define('HTTP_CATALOG_SERVER', HTTP_SERVER);
    //check for some specifics that need to be included with all messages
    if (!isset($block['EMAIL_STORE_NAME']) || $block['EMAIL_STORE_NAME'] == '')     $block['EMAIL_STORE_NAME']  = STORE_NAME;
    if (!isset($block['EMAIL_STORE_URL']) || $block['EMAIL_STORE_URL'] == '')       $block['EMAIL_STORE_URL']   = '<a href="'.HTTP_CATALOG_SERVER . DIR_WS_CATALOG.'">'.STORE_NAME.'</a>';
    if (!isset($block['EMAIL_STORE_OWNER']) || $block['EMAIL_STORE_OWNER'] == '')   $block['EMAIL_STORE_OWNER'] = STORE_OWNER;
    if (!isset($block['EMAIL_FOOTER_COPYRIGHT']) || $block['EMAIL_FOOTER_COPYRIGHT'] == '') $block['EMAIL_FOOTER_COPYRIGHT'] = EMAIL_FOOTER_COPYRIGHT;
    if (!isset($block['EMAIL_DISCLAIMER']) || $block['EMAIL_DISCLAIMER'] == '')     $block['EMAIL_DISCLAIMER']  = sprintf(EMAIL_DISCLAIMER, '<a href="mailto:' . STORE_OWNER_EMAIL_ADDRESS . '">'. STORE_OWNER_EMAIL_ADDRESS .' </a>');
    if (!isset($block['EMAIL_SPAM_DISCLAIMER']) || $block['EMAIL_SPAM_DISCLAIMER'] == '')   $block['EMAIL_SPAM_DISCLAIMER']  = EMAIL_SPAM_DISCLAIMER;
    if (!isset($block['EMAIL_DATE_SHORT']) || $block['EMAIL_DATE_SHORT'] == '')     $block['EMAIL_DATE_SHORT']  = zen_date_short(date("Y-m-d"));
    if (!isset($block['EMAIL_DATE_LONG']) || $block['EMAIL_DATE_LONG'] == '')       $block['EMAIL_DATE_LONG']   = zen_date_long(date("Y-m-d"));
    if (!isset($block['BASE_HREF']) || $block['BASE_HREF'] == '') $block['BASE_HREF'] = HTTP_SERVER . DIR_WS_CATALOG;
    if (!isset($block['CHARSET']) || $block['CHARSET'] == '') $block['CHARSET'] = CHARSET;
    //  if (!isset($block['EMAIL_STYLESHEET']) || $block['EMAIL_STYLESHEET'] == '')      $block['EMAIL_STYLESHEET']       = str_replace(array("\r\n", "\n", "\r"), "",@file_get_contents(DIR_FS_EMAIL_TEMPLATES.'stylesheet.css'));

    if (!isset($block['EXTRA_INFO']))  $block['EXTRA_INFO']  = '';
    if (substr($module,-6) != '_extra' && $module != 'contact_us')  $block['EXTRA_INFO']  = '';

    $block['COUPON_BLOCK'] = '';
    if (isset($block['COUPON_TEXT_VOUCHER_IS']) && $block['COUPON_TEXT_VOUCHER_IS'] != '' && isset($block['COUPON_TEXT_TO_REDEEM']) && $block['COUPON_TEXT_TO_REDEEM'] != '') {
        $block['COUPON_BLOCK'] = '<div class="coupon-block">' . $block['COUPON_TEXT_VOUCHER_IS'] . $block['COUPON_DESCRIPTION'] . '<br />' . $block['COUPON_TEXT_TO_REDEEM'] . '<span class="coupon-code">' . $block['COUPON_CODE'] . '</span></div>';
    }

    $block['GV_BLOCK'] = '';
    if (isset($block['GV_WORTH']) && $block['GV_WORTH'] != '' && isset($block['GV_REDEEM']) && $block['GV_REDEEM'] != '' && isset($block['GV_CODE_URL']) && $block['GV_CODE_URL'] != '') {
        $block['GV_BLOCK'] = '<div class="gv-block">' . $block['GV_WORTH'] . '<br />' . $block['GV_REDEEM'] . $block['GV_CODE_URL'] . '<br />' . $block['GV_LINK_OTHER'] . '</div>';
    }

    //prepare the "unsubscribe" link:
    if (IS_ADMIN_FLAG === true) { // is this admin version, or catalog?
        $block['UNSUBSCRIBE_LINK'] = str_replace("\n",'',TEXT_UNSUBSCRIBE) . ' <a href="' . zen_catalog_href_link(FILENAME_UNSUBSCRIBE, "addr=" . $block['EMAIL_TO_ADDRESS']) . '">' . zen_catalog_href_link(FILENAME_UNSUBSCRIBE, "addr=" . $block['EMAIL_TO_ADDRESS']) . '</a>';
    } else {
        $block['UNSUBSCRIBE_LINK'] = str_replace("\n",'',TEXT_UNSUBSCRIBE) . ' <a href="' . zen_href_link(FILENAME_UNSUBSCRIBE, "addr=" . $block['EMAIL_TO_ADDRESS']) . '">' . zen_href_link(FILENAME_UNSUBSCRIBE, "addr=" . $block['EMAIL_TO_ADDRESS']) . '</a>';
    }

    //now replace the $BLOCK_NAME items in the template file with the values passed to this function's array
    foreach ($block as $key=>$value) {
        $file_holder = str_replace('$' . $key, $value, $file_holder);
    }

    //DEBUG -- to display preview on-screen
    if (EMAIL_SYSTEM_DEBUG=='preview') echo $file_holder;
    //echo $module,$file_holder;die;

    return $file_holder;
}


/**
 * Function to build array of additional email content collected and sent on admin-copies of emails:
 *
 */
function email_collect_extra_info($from, $email_from, $login, $login_email, $login_phone='', $login_fax='') {
    // get host_address from either session or one time for both email types to save server load
    if (!$_SESSION['customers_host_address']) {
        if (SESSION_IP_TO_HOST_ADDRESS == 'true') {
            $email_host_address = @gethostbyaddr($_SERVER['REMOTE_ADDR']);
        } else {
            $email_host_address = OFFICE_IP_TO_HOST_ADDRESS;
        }
    } else {
        $email_host_address = $_SESSION['customers_host_address'];
    }

    // generate footer details for "also-send-to" emails
    $extra_info=array();
    $extra_info['TEXT'] =
        OFFICE_USE . "\t" . "\n" .
        OFFICE_FROM . "\t" . $from . "\n" .
        OFFICE_EMAIL. "\t" . $email_from . "\n" .
        (trim($login) !='' ? OFFICE_LOGIN_NAME . "\t" . $login . "\n"  : '') .
        (trim($login_email) !='' ? OFFICE_LOGIN_EMAIL . "\t" . $login_email . "\n"  : '') .
        ($login_phone !='' ? OFFICE_LOGIN_PHONE . "\t" . $login_phone . "\n" : '') .
        ($login_fax !='' ? OFFICE_LOGIN_FAX . "\t" . $login_fax . "\n" : '') .
        OFFICE_IP_ADDRESS . "\t" . $_SESSION['customers_ip_address'] . ' - ' . $_SERVER['REMOTE_ADDR'] . "\n" .
        OFFICE_HOST_ADDRESS . "\t" . $email_host_address . "\n" .
        OFFICE_DATE_TIME . "\t" . date("D M j Y G:i:s T") . "\n\n";

    $extra_info['HTML'] = '<table class="extra-info">' .
        '<tr><td class="extra-info-bold" colspan="2">' . OFFICE_USE . '</td></tr>' .
        '<tr><td class="extra-info-bold">' . OFFICE_FROM . '</td><td>' . $from . '</td></tr>' .
        '<tr><td class="extra-info-bold">' . OFFICE_EMAIL. '</td><td>' . $email_from . '</td></tr>' .
        ($login !='' ? '<tr><td class="extra-info-bold">' . OFFICE_LOGIN_NAME . '</td><td>' . $login . '</td></tr>' : '') .
        ($login_email !='' ? '<tr><td class="extra-info-bold">' . OFFICE_LOGIN_EMAIL . '</td><td>' . $login_email . '</td></tr>' : '') .
        ($login_phone !='' ? '<tr><td class="extra-info-bold">' . OFFICE_LOGIN_PHONE . '</td><td>' . $login_phone . '</td></tr>' : '') .
        ($login_fax !='' ? '<tr><td class="extra-info-bold">' . OFFICE_LOGIN_FAX . '</td><td>' . $login_fax . '</td></tr>' : '') .
        '<tr><td class="extra-info-bold">' . OFFICE_IP_ADDRESS . '</td><td>' . $_SESSION['customers_ip_address'] . ' - ' . $_SERVER['REMOTE_ADDR'] . '</td></tr>' .
        '<tr><td class="extra-info-bold">' . OFFICE_HOST_ADDRESS . '</td><td>' . $email_host_address . '</td></tr>' .
        '<tr><td class="extra-info-bold">' . OFFICE_DATE_TIME . '</td><td>' . date('D M j Y G:i:s T') . '</td></tr>' . '</table>';
    return $extra_info;
}


function zen_validate_email($email) {
    $valid_address = TRUE;

    if (substr_count($email,'@') != 1) return false;
    list( $user, $domain ) = explode( "@", $email );
    $valid_ip_form = '[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}';
    $valid_email_pattern = '^[a-z0-9]+[a-z0-9_\.\'\-]*@[a-z0-9]+[a-z0-9\.\-]*\.(([a-z]{2,6})|([0-9]{1,3}))$';
    $space_check = '[ ]';

    // strip beginning and ending quotes, if and only if both present
    if( (preg_match('/^["]/', $user) && preg_match('/["]$/', $user)) ){
        $user = preg_replace ( '/^["]/', '', $user );
        $user = preg_replace ( '/["]$/', '', $user );
        $user = preg_replace ( '/'.$space_check.'/', '', $user ); //spaces in quoted addresses OK per RFC (?)
        $email = $user."@".$domain; // contine with stripped quotes for remainder
    }

    // fail if contains spaces in domain name
    if (strstr($domain,' ')) return false;

    // if email domain part is an IP address, check each part for a value under 256
    if (preg_match('/'.$valid_ip_form.'/', $domain)) {
        $digit = explode( ".", $domain );
        for($i=0; $i<4; $i++) {
            if ($digit[$i] > 255) {
                $valid_address = false;
                return $valid_address;
                exit;
            }
            // stop crafty people from using internal IP addresses
            if (($digit[0] == 192) || ($digit[0] == 10)) {
                $valid_address = false;
                return $valid_address;
                exit;
            }
        }
    }

    if (rfc_validate_email($email) == FALSE) { // do RFC validation, using old method as fallback if it fails
        if (!preg_match('/'.$valid_email_pattern.'/i', $email)) { // validate against valid email patterns
            $valid_address = false;
            return $valid_address;
            exit;
        }
    }
    return $valid_address;
}
/**
 * RFC validation
 * @copyright Portions copyright Chris Corbyn
 *
 * @param string $address
 * @return boolean
 */
function rfc_validate_email($address)
{
    $rfcValidEmailPattern = '(?:(?:(?:(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])' .
        '|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]' .
        '|[\x21-\x27\x2A-\x5B\x5D-\x7E])' .
        '|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])' .
        '|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])' .
        '|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]' .
        '|[\x21-\x27\x2A-\x5B\x5D-\x7E])' .
        '|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])' .
        '|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))' .
        '|(?:(?:[ \t]*(?:\r\n))?[ \t])))?(?:[a-zA-Z0-9!#\$%&\'\*\+\-\/=\?\^_`\{\}\|~]+(\.[a-zA-Z0-9!#\$%&\'\*\+\-\/=\?\^_`\{\}\|~]+)*)+(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])' .
        '|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]' .
        '|[\x21-\x27\x2A-\x5B\x5D-\x7E])' .
        '|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])' .
        '|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])' .
        '|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]' .
        '|[\x21-\x27\x2A-\x5B\x5D-\x7E])' .
        '|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])' .
        '|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))' .
        '|(?:(?:[ \t]*(?:\r\n))?[ \t])))?)' .
        '|(?:(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])' .
        '|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]' .
        '|[\x21-\x27\x2A-\x5B\x5D-\x7E])' .
        '|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])' .
        '|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])' .
        '|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]' .
        '|[\x21-\x27\x2A-\x5B\x5D-\x7E])' .
        '|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])' .
        '|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))' .
        '|(?:(?:[ \t]*(?:\r\n))?[ \t])))?"((?:(?:[ \t]*(?:\r\n))?[ \t])?(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]' .
        '|[\x21\x23-\x5B\x5D-\x7E])' .
        '|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])))*(?:(?:[ \t]*(?:\r\n))?[ \t])?"(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])' .
        '|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]' .
        '|[\x21-\x27\x2A-\x5B\x5D-\x7E])' .
        '|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])' .
        '|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])' .
        '|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]' .
        '|[\x21-\x27\x2A-\x5B\x5D-\x7E])' .
        '|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])' .
        '|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))' .
        '|(?:(?:[ \t]*(?:\r\n))?[ \t])))?))@(?:(?:(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])' .
        '|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]' .
        '|[\x21-\x27\x2A-\x5B\x5D-\x7E])' .
        '|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])' .
        '|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])' .
        '|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]' .
        '|[\x21-\x27\x2A-\x5B\x5D-\x7E])' .
        '|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])' .
        '|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))' .
        '|(?:(?:[ \t]*(?:\r\n))?[ \t])))?(?:[a-zA-Z0-9!#\$%&\'\*\+\-\/=\?\^_`\{\}\|~]+(\.[a-zA-Z0-9!#\$%&\'\*\+\-\/=\?\^_`\{\}\|~]+)*)+(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])' .
        '|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]' .
        '|[\x21-\x27\x2A-\x5B\x5D-\x7E])' .
        '|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])' .
        '|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])' .
        '|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]' .
        '|[\x21-\x27\x2A-\x5B\x5D-\x7E])' .
        '|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])' .
        '|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))' .
        '|(?:(?:[ \t]*(?:\r\n))?[ \t])))?)' .
        '|(?:(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])' .
        '|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]' .
        '|[\x21-\x27\x2A-\x5B\x5D-\x7E])' .
        '|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])' .
        '|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])' .
        '|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]' .
        '|[\x21-\x27\x2A-\x5B\x5D-\x7E])' .
        '|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])' .
        '|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))' .
        '|(?:(?:[ \t]*(?:\r\n))?[ \t])))?\[((?:(?:[ \t]*(?:\r\n))?[ \t])?(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]' .
        '|[\x21-\x5A\x5E-\x7E])' .
        '|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])))*?(?:(?:[ \t]*(?:\r\n))?[ \t])?\](?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])' .
        '|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]' .
        '|[\x21-\x27\x2A-\x5B\x5D-\x7E])' .
        '|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])' .
        '|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])' .
        '|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]' .
        '|[\x21-\x27\x2A-\x5B\x5D-\x7E])' .
        '|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])' .
        '|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))' .
        '|(?:(?:[ \t]*(?:\r\n))?[ \t])))?)))';

    if (!preg_match('/^' . $rfcValidEmailPattern . '$/D', $address))
    {
        return FALSE;
    } else {
        return TRUE;
    }
}

/**
 * PROCESS EMBEDDED IMAGES
 * attach and properly embed any embedded images marked as 'embed="yes"'
 *
 * @param string $email_html
 * return string
 */
function processEmbeddedImages ($email_html, & $mail)
{
    if (defined('EMAIL_ATTACH_EMBEDDED_IMAGES') && EMAIL_ATTACH_EMBEDDED_IMAGES == 'Yes')
    {
        $imageFiles = array();
        $imagesToProcess = array();
        if (preg_match_all('#<img.*src=\"(.*?)\".*?\/>#', $email_html, $imagesToProcess))
        {
            for ($i = 0, $n = count($imagesToProcess[0]); $i < $n; $i ++)
            {
                $exists = strpos($imagesToProcess[0][$i], 'embed="yes"');
                if ($exists !== false)
                {
                    // prevent duplicate attachments - if already processed, remember it
                    if (array_key_exists($imagesToProcess[1][$i], $imageFiles))
                    {
                        $substitute = $imageFiles[$imagesToProcess[1][$i]];

                        // if not a duplicate, and file can be located on filesystem, add it as an attachment, and replace its SRC attribute with the embedded code
                    } elseif (file_exists(DIR_FS_CATALOG . $imagesToProcess[1][$i]))
                    {
                        $rpos = strrpos($imagesToProcess[1][$i], '.');
                        $ext = substr($imagesToProcess[1][$i], $rpos + 1);
                        $name = basename($imagesToProcess[1][$i], '.'.$ext);
                        switch (strtolower($ext)) {
                            case 'gif':
                                $mimetype = 'image/gif';
                                break;
                            case 'jpg':
                            case 'jpeg':
                                $mimetype = 'image/jpeg';
                                break;
                            case 'png':
                            default:
                                $mimetype = 'image/png';
                                break;
                        }
                        $substitute = $name . $i;
                        $mail->AddEmbeddedImage(DIR_FS_CATALOG . $imagesToProcess[1][$i], $substitute, $name . '.' . $ext, "base64", $mimetype);
                        $imageFiles[$imagesToProcess[1][$i]] = $substitute;
                    }
                    $email_html = str_replace($imagesToProcess[1][$i], 'cid:'.$substitute, $email_html);
                }
            }
        }
    }
    return $email_html;
}


function zen_mail_contact_us_or_bulk_order_inquiry($to_name, $to_address, $email_subject, $email_text, $from_email_name, $from_email_address, $block=array(), $module='default', $attachments_list='' ) {
    global $db, $messageStack, $zco_notifier;
    if (!defined('DEVELOPER_OVERRIDE_EMAIL_STATUS') || (defined('DEVELOPER_OVERRIDE_EMAIL_STATUS') && DEVELOPER_OVERRIDE_EMAIL_STATUS == 'site'))
        if (SEND_EMAILS != 'true') return false;  // if sending email is disabled in Admin, just exit

    if (defined('DEVELOPER_OVERRIDE_EMAIL_ADDRESS') && DEVELOPER_OVERRIDE_EMAIL_ADDRESS != '') $to_address = DEVELOPER_OVERRIDE_EMAIL_ADDRESS;

    // ignore sending emails for any of the following pages
    // (The EMAIL_MODULES_TO_SKIP constant can be defined in a new file in the "extra_configures" folder)
    if (defined('EMAIL_MODULES_TO_SKIP') && in_array($module,explode(",",constant('EMAIL_MODULES_TO_SKIP')))) return false;

    // check for injection attempts. If new-line characters found in header fields, simply fail to send the message
    foreach(array($from_email_address, $to_address, $from_email_name, $to_name, $email_subject) as $key=>$value) {
        if (preg_match("/\r/i",$value) || preg_match("/\n/i",$value)) return false;
    }

    // if no text or html-msg supplied, exit
    if (trim($email_text) == '' && (!zen_not_null($block) || (isset($block['EMAIL_MESSAGE_HTML']) && $block['EMAIL_MESSAGE_HTML'] == '')) ) return false;

    // Parse "from" addresses for "name" <email@address.com> structure, and supply name/address info from it.
    if (preg_match("/ *([^<]*) *<([^>]*)> */i",$from_email_address,$regs)) {
        $from_email_name = trim($regs[1]);
        $from_email_address = $regs[2];
    }
    // if email name is same as email address, use the Store Name as the senders 'Name'
    if ($from_email_name == $from_email_address) $from_email_name = STORE_NAME;

    // loop thru multiple email recipients if more than one listed  --- (esp for the admin's "Extra" emails)...
    foreach(explode(',',$to_address) as $key=>$value) {
        if (preg_match("/ *([^<]*) *<([^>]*)> */i",$value,$regs)) {
            $to_name = str_replace('"', '', trim($regs[1]));
            $to_email_address = $regs[2];
        } elseif (preg_match("/ *([^ ]*) */i",$value,$regs)) {
            $to_email_address = trim($regs[1]);
        }
        if (!isset($to_email_address)) $to_email_address=trim($to_address); //if not more than one, just use the main one.

        //define some additional html message blocks available to templates, then build the html portion.
        //define some additional html message blocks available to templates, then build the html portion.
        if (!isset($block['EMAIL_TO_NAME']) || $block['EMAIL_TO_NAME'] == '')       $block['EMAIL_TO_NAME'] = $to_name;
        if (!isset($block['EMAIL_TO_ADDRESS']) || $block['EMAIL_TO_ADDRESS'] == '') $block['EMAIL_TO_ADDRESS'] = $to_email_address;
        if (!isset($block['EMAIL_SUBJECT']) || $block['EMAIL_SUBJECT'] == '')       $block['EMAIL_SUBJECT'] = $email_subject;
        if (!isset($block['EMAIL_FROM_NAME']) || $block['EMAIL_FROM_NAME'] == '')   $block['EMAIL_FROM_NAME'] = $from_email_name;
        if (!isset($block['EMAIL_FROM_ADDRESS']) || $block['EMAIL_FROM_ADDRESS'] == '') $block['EMAIL_FROM_ADDRESS'] = $from_email_address;

        /*bof use costome words*/
        if (isset($_SESSION['customer_email_data']) && is_array($_SESSION['customer_email_data'])) {
            /* FOR OUR custome information*/
            if (!isset($block['FIRSTNAME']) || $block['FIRSTNAME'] == '') $block['FIRSTNAME'] = $_SESSION['customer_email_data']['firstname'];
            if (!isset($block['LASTNAME']) || $block['LASTNAME'] == '') $block['LASTNAME'] = $_SESSION['customer_email_data']['lastname'];
            if (!isset($block['EMAIL_ADDRESS']) || $block['EMAIL_ADDRESS'] == '') $block['EMAIL_ADDRESS'] = $_SESSION['customer_email_data']['email_address'];
            if (!isset($block['PASSWORD']) || $block['PASSWORD'] == '') $block['PASSWORD'] = $_SESSION['customer_email_data']['password'];

        }
        /*eof use costome words*/


        $email_html = (!is_array($block) && substr($block, 0, 6) == '<html>') ? $block : zen_build_html_email_from_template($module, $block);
        $email_html = str_replace('$user_email',$to_address,$email_html);
        if (!is_array($block) && $block == '' || $block == 'none') $email_html = '';

        // Build the email based on whether customer has selected HTML or TEXT, and whether we have supplied HTML or TEXT-only components
        // special handling for XML content
        if ($email_text == '') {
            $email_text = str_replace(array('<br>','<br />'), "<br />\n", $block['EMAIL_MESSAGE_HTML']);
            $email_text = str_replace('</p>', "</p>\n", $email_text);
            $email_text = ($module != 'xml_record') ? htmlspecialchars(stripslashes(strip_tags($email_text))) : $email_text;
        } else {
            $email_text = ($module != 'xml_record') ? strip_tags($email_text) : $email_text;
        }

        if ($module != 'xml_record') {
            if (!strstr($email_text, sprintf(EMAIL_DISCLAIMER, STORE_OWNER_EMAIL_ADDRESS)) && $to_email_address != STORE_OWNER_EMAIL_ADDRESS && !defined('EMAIL_DISCLAIMER_NEW_CUSTOMER')) $email_text .= "\n" . sprintf(EMAIL_DISCLAIMER, STORE_OWNER_EMAIL_ADDRESS);
            if (defined('EMAIL_SPAM_DISCLAIMER') && EMAIL_SPAM_DISCLAIMER != '' && !strstr($email_text, EMAIL_SPAM_DISCLAIMER) && $to_email_address != STORE_OWNER_EMAIL_ADDRESS) $email_text .= "\n" . EMAIL_SPAM_DISCLAIMER;
        }

        // bof: body of the email clean-up
        // clean up &amp; and && from email text
        while (strstr($email_text, '&amp;&amp;')) $email_text = str_replace('&amp;&amp;', '&amp;', $email_text);
        while (strstr($email_text, '&amp;')) $email_text = str_replace('&amp;', '&', $email_text);
        while (strstr($email_text, '&&')) $email_text = str_replace('&&', '&', $email_text);

        // clean up currencies for text emails
        $zen_fix_currencies = preg_split("/[:,]/" , CURRENCIES_TRANSLATIONS);
        $size = sizeof($zen_fix_currencies);
        for ($i=0, $n=$size; $i<$n; $i+=2) {
            $zen_fix_current = $zen_fix_currencies[$i];
            $zen_fix_replace = $zen_fix_currencies[$i+1];
            if (strlen($zen_fix_current)>0) {
                while (strpos($email_text, $zen_fix_current)) $email_text = str_replace($zen_fix_current, $zen_fix_replace, $email_text);
            }
        }

        // fix double quotes
        while (strstr($email_text, '&quot;')) $email_text = str_replace('&quot;', '"', $email_text);
        // prevent null characters
        while (strstr($email_text, chr(0))) $email_text = str_replace(chr(0), ' ', $email_text);

        // fix slashes
        $text = stripslashes($email_text);
        $email_html = stripslashes($email_html);

        // eof: body of the email clean-up

        //determine customer's email preference type: HTML or TEXT-ONLY  (HTML assumed if not specified)
        $sql = "select customers_email_format from " . TABLE_CUSTOMERS . " where customers_email_address= :custEmailAddress:";
        $sql = $db->bindVars($sql, ':custEmailAddress:', $to_email_address, 'string');
        $result = $db->Execute($sql);
        $customers_email_format = ($result->RecordCount() > 0) ? $result->fields['customers_email_format'] : '';

        if ($customers_email_format == 'NONE' || $customers_email_format == 'OUT') return; //if requested no mail, then don't send.
        //      if ($customers_email_format == 'HTML') $customers_email_format = 'HTML'; // if they opted-in to HTML messages, then send HTML format

        // handling admin/"extra"/copy emails:
        if (ADMIN_EXTRA_EMAIL_FORMAT == 'TEXT' && substr($module,-6)=='_extra') {
            $email_html='';  // just blank out the html portion if admin has selected text-only
        }
        //determine what format to send messages in if this is an admin email for newsletters:
        /*      if ($customers_email_format == '' && ADMIN_EXTRA_EMAIL_FORMAT == 'HTML' && in_array($module, array('newsletters', 'product_notification')) && isset($_SESSION['admin_id'])) {
         $customers_email_format = 'HTML';
        }*/


        // special handling for XML content
        if ($module == 'xml_record') {
            $email_html = '';
            $customers_email_format ='TEXT';
        }

        //notifier intercept option
        $zco_notifier->notify('NOTIFY_EMAIL_AFTER_EMAIL_FORMAT_DETERMINED');

        // now lets build the mail object with the phpmailer class
        $mail = new PHPMailer();
        $lang_code = strtolower(($_SESSION['languages_code'] == '' ? 'en' : $_SESSION['languages_code'] ));
        $mail->SetLanguage($lang_code, DIR_FS_CATALOG . DIR_WS_CLASSES . 'support/');
        $mail->CharSet =  (defined('CHARSET')) ? CHARSET : "iso-8859-1";
        $mail->Encoding = (defined('EMAIL_ENCODING_METHOD')) ? EMAIL_ENCODING_METHOD : "7bit";
        if ((int)EMAIL_SYSTEM_DEBUG > 0 ) $mail->SMTPDebug = (int)EMAIL_SYSTEM_DEBUG;
        $mail->WordWrap = 76;    // set word wrap to 76 characters
        // set proper line-endings based on switch ... important for windows vs linux hosts:
        $mail->LE = (EMAIL_LINEFEED == 'CRLF') ? "\r\n" : "\n";

        $mail_transport = 'smtpauth';
        switch (EMAIL_TRANSPORT) {
            case 'smtpauth':
                $mail->IsSMTP();
                $mail->SMTPAuth = true;
                $mail->Username = 'legal@fs.com';
                $mail->Password = 'SZfs2015_0201';
                $mail->Host = trim(EMAIL_SMTPAUTH_MAIL_SERVER);
                if (EMAIL_SMTPAUTH_MAIL_SERVER_PORT != '25' && EMAIL_SMTPAUTH_MAIL_SERVER_PORT != '') $mail->Port = trim(EMAIL_SMTPAUTH_MAIL_SERVER_PORT);
                $mail->LE = "\r\n";
                //set encryption protocol to allow support for Gmail or other secured email protocols
                if (EMAIL_SMTPAUTH_MAIL_SERVER_PORT == '465' || EMAIL_SMTPAUTH_MAIL_SERVER_PORT == '587' || EMAIL_SMTPAUTH_MAIL_SERVER == 'smtp.gmail.com') $mail->Protocol = 'ssl';
                if (defined('SMTPAUTH_EMAIL_PROTOCOL') && SMTPAUTH_EMAIL_PROTOCOL != 'none') {
                    $mail->Protocol = SMTPAUTH_EMAIL_PROTOCOL;
                    if (SMTPAUTH_EMAIL_PROTOCOL == 'starttls' && defined('SMTPAUTH_EMAIL_CERTIFICATE_CONTEXT')) {
                        $mail->Starttls = true;
                        $mail->Context = SMTPAUTH_EMAIL_CERTIFICATE_CONTEXT;
                    }
                }
                break;
            case 'smtp':
                $mail->IsSMTP();
                $mail->Host = trim(EMAIL_SMTPAUTH_MAIL_SERVER);
                if (EMAIL_SMTPAUTH_MAIL_SERVER_PORT != '25' && EMAIL_SMTPAUTH_MAIL_SERVER_PORT != '') $mail->Port = trim(EMAIL_SMTPAUTH_MAIL_SERVER_PORT);
                $mail->LE = "\r\n";
                break;

            case 'PHP':
                $mail->IsMail();
                break;
            case 'Qmail':
                $mail->IsQmail();
                break;
            case 'sendmail':
            case 'sendmail-f':
                $mail->LE = "\n";
            default:
                $mail->IsSendmail();
                if (defined('EMAIL_SENDMAIL_PATH')) $mail->Sendmail = trim(EMAIL_SENDMAIL_PATH);
                break;
        }

        $mail->Subject  = $email_subject;
        //$mail->From     = $from_email_address;    测试完还原
        $mail->From     = EMAIL_FROM;
        $mail->FromName = $from_email_name;
        $mail->AddAddress($to_email_address, $to_name);
        //$mail->AddAddress($to_email_address);    // (alternate format if no name, since name is optional)
        //$mail->AddBCC(STORE_NAME, STORE_OWNER_EMAIL_ADDRESS);

        // set the reply-to address.  If none set yet, then use Store's default email name/address.
        // If sending from contact-us or tell-a-friend page, use the supplied info
        $email_reply_to_address = (isset($email_reply_to_address) && $email_reply_to_address != '') ? $email_reply_to_address : (in_array($module, array('contact_us',  'tell_a_friend')) ? $from_email_address : EMAIL_FROM);
        $email_reply_to_name    = (isset($email_reply_to_name) && $email_reply_to_name != '')    ? $email_reply_to_name    : (in_array($module, array('contact_us',  'tell_a_friend')) ? $from_email_name    : STORE_NAME);
        $mail->AddReplyTo($email_reply_to_address, $email_reply_to_name);

        // if mailserver requires that all outgoing mail must go "from" an email address matching domain on server, set it to store address
        if (EMAIL_SEND_MUST_BE_STORE=='Yes') $mail->From = EMAIL_FROM;

        if (EMAIL_TRANSPORT=='sendmail-f' || EMAIL_SEND_MUST_BE_STORE=='Yes') {
            $mail->Sender = EMAIL_FROM;
        }

        if (EMAIL_USE_HTML == 'true') $email_html = processEmbeddedImages($email_html, $mail);

        // PROCESS FILE ATTACHMENTS
        if ($attachments_list == '') $attachments_list = array();
        if (is_string($attachments_list)) {
            if (file_exists($attachments_list)) {
                $attachments_list = array(array('file' => $attachments_list));
            } elseif (file_exists(DIR_FS_CATALOG . $attachments_list)) {
                $attachments_list = array(array('file' => DIR_FS_CATALOG . $attachments_list));
            } else {
                $attachments_list = array();
            }
        }
        global $newAttachmentsList;
        $zco_notifier->notify('NOTIFY_EMAIL_BEFORE_PROCESS_ATTACHMENTS', array('attachments'=>$attachments_list, 'module'=>$module));
        if (isset($newAttachmentsList) && is_array($newAttachmentsList)) $attachments_list = $newAttachmentsList;
        if (defined('EMAIL_ATTACHMENTS_ENABLED') && EMAIL_ATTACHMENTS_ENABLED && is_array($attachments_list) && sizeof($attachments_list) > 0) {
            foreach($attachments_list as $key => $val) {
                $fname = (isset($val['name']) ? $val['name'] : null);
                $mimeType = (isset($val['mime_type']) && $val['mime_type'] != '' && $val['mime_type'] != 'application/octet-stream') ? $val['mime_type'] : '';
                switch (true) {
                    case (isset($val['raw_data']) && $val['raw_data'] != ''):
                        $fdata = $val['raw_data'];
                        if ($mimeType != '') {
                            $mail->AddStringAttachment($fdata, $fname, "base64", $mimeType);
                        } else {
                            $mail->AddStringAttachment($fdata, $fname);
                        }
                        break;
                    case (isset($val['file']) && file_exists($val['file'])): //'file' portion must contain the full path to the file to be attached
                        $fdata = $val['file'];
                        if ($mimeType != '') {
                            $mail->AddAttachment($fdata, $fname, "base64", $mimeType);
                        } else {
                            $mail->AddAttachment($fdata, $fname);
                        }
                        break;
                } // end switch
            } //end foreach attachments_list
        } //endif attachments_enabled
        $zco_notifier->notify('NOTIFY_EMAIL_AFTER_PROCESS_ATTACHMENTS', sizeof($attachments_list));

        /*bof force to use html format*/
        $customers_email_format = 'HTML';
        /*bof force to use html format*/


        // prepare content sections:
        if (EMAIL_USE_HTML == 'true' && trim($email_html) != '' &&
            ($customers_email_format == 'HTML' || (ADMIN_EXTRA_EMAIL_FORMAT != 'TEXT' && substr($module,-6)=='_extra'))) {
            $mail->IsHTML(true);           // set email format to HTML
            $mail->Body    = $email_html;  // HTML-content of message
            $mail->AltBody = $text;        // text-only content of message
        }  else {                        // use only text portion if not HTML-formatted
            $mail->Body    = $text;        // text-only content of message
        }

        /**
         * Send the email. If an error occurs, trap it and display it in the messageStack
         */

        $ErrorInfo = '';
        $zco_notifier->notify('NOTIFY_EMAIL_READY_TO_SEND');
        if (!($result = $mail->Send())) {
            //邮件错误日志        调试用
            $file_path = DIR_FS_CATALOG.'includes/languages/email/log/';
            $file_name='email_error_log_'.date('YmdHis').mt_rand(1000,9999).'.log';
            $fp=fopen($file_path.$file_name,'w') or die($file_path.$file_name);
            if (IS_ADMIN_FLAG === true) {
                $messageStack->add_session(sprintf(EMAIL_SEND_FAILED . '&nbsp;'. $mail->ErrorInfo, $to_name, $to_email_address, $email_subject),'error');
            } else {
                $messageStack->add('header',sprintf(EMAIL_SEND_FAILED . '&nbsp;'. $mail->ErrorInfo, $to_name, $to_email_address, $email_subject),'error');
            }
            if($fp){
                $time = gmdate('Y-m-d H:i:s');
                $unix_time = strtotime($time)+3600*8;
                $bj_time = date('Y-m-d H:i:s',$unix_time);
                $content = '['.$bj_time.'] Email error info:'.$mail->ErrorInfo.';   To name:'.$to_name.';   To email:'.$to_email_address.';  Email subject:'.$email_subject.';  Email_template:'.$module;
                fwrite($fp,$content) or die($content);
            }
            fclose($fp);
            //日志超量删除
            $file_error_array=scandir($file_path);
            $file_num = count($file_error_array)-2;
            $arr=array();
            foreach ($file_error_array as $v){
                if(is_file($file_path.$v)){
                    $arr[filemtime($file_path.$v)] = $v;
                }
            }
            ksort($arr);
            if($file_num>25){
                $i = 0;
                foreach ($arr as $k=>$v){
                    if($i==0){
                        unlink($file_path.$arr[$k]);
                    }
                    $i++;
                }
            }
            $ErrorInfo .= $mail->ErrorInfo . '<br />';
        }
        $zco_notifier->notify('NOTIFY_EMAIL_AFTER_SEND');

        // Archive this message to storage log
        // don't archive pwd-resets and CC numbers
        if (EMAIL_ARCHIVE == 'true'  && $module != 'password_forgotten_admin' && $module != 'cc_middle_digs' && $module != 'no_archive') {
            zen_mail_archive_write($to_name, $to_email_address, $from_email_name, $from_email_address, $email_subject, $email_html, $text, $module, $ErrorInfo );
        } // endif archiving
    } // end foreach loop thru possible multiple email addresses
    $zco_notifier->notify('NOTIFY_EMAIL_AFTER_SEND_ALL_SPECIFIED_ADDRESSES');

    if (EMAIL_FRIENDLY_ERRORS=='false' && $ErrorInfo != '') die('<br /><br />Email Error: ' . $ErrorInfo);

    return $ErrorInfo;
}  // end function

function zen_mail_subscribe($to_name, $to_address, $email_subject, $email_text, $from_email_name, $from_email_address, $block=array(), $module='default', $attachments_list='' ) {
    global $db, $messageStack, $zco_notifier;
    if (!defined('DEVELOPER_OVERRIDE_EMAIL_STATUS') || (defined('DEVELOPER_OVERRIDE_EMAIL_STATUS') && DEVELOPER_OVERRIDE_EMAIL_STATUS == 'site'))
        if (SEND_EMAILS != 'true') return false;  // if sending email is disabled in Admin, just exit

    if (defined('DEVELOPER_OVERRIDE_EMAIL_ADDRESS') && DEVELOPER_OVERRIDE_EMAIL_ADDRESS != '') $to_address = DEVELOPER_OVERRIDE_EMAIL_ADDRESS;

    // ignore sending emails for any of the following pages
    // (The EMAIL_MODULES_TO_SKIP constant can be defined in a new file in the "extra_configures" folder)
    if (defined('EMAIL_MODULES_TO_SKIP') && in_array($module,explode(",",constant('EMAIL_MODULES_TO_SKIP')))) return false;

    // check for injection attempts. If new-line characters found in header fields, simply fail to send the message
    foreach(array($from_email_address, $to_address, $from_email_name, $to_name, $email_subject) as $key=>$value) {
        if (preg_match("/\r/i",$value) || preg_match("/\n/i",$value)) return false;
    }

    // if no text or html-msg supplied, exit
    if (trim($email_text) == '' && (!zen_not_null($block) || (isset($block['EMAIL_MESSAGE_HTML']) && $block['EMAIL_MESSAGE_HTML'] == '')) ) return false;

    // Parse "from" addresses for "name" <email@address.com> structure, and supply name/address info from it.
    if (preg_match("/ *([^<]*) *<([^>]*)> */i",$from_email_address,$regs)) {
        $from_email_name = trim($regs[1]);
        $from_email_address = $regs[2];
    }
    // if email name is same as email address, use the Store Name as the senders 'Name'
    if ($from_email_name == $from_email_address) $from_email_name = STORE_NAME;

    // loop thru multiple email recipients if more than one listed  --- (esp for the admin's "Extra" emails)...
    foreach(explode(',',$to_address) as $key=>$value) {
        if (preg_match("/ *([^<]*) *<([^>]*)> */i",$value,$regs)) {
            $to_name = str_replace('"', '', trim($regs[1]));
            $to_email_address = $regs[2];
        } elseif (preg_match("/ *([^ ]*) */i",$value,$regs)) {
            $to_email_address = trim($regs[1]);
        }
        if (!isset($to_email_address)) $to_email_address=trim($to_address); //if not more than one, just use the main one.

        //define some additional html message blocks available to templates, then build the html portion.
        //define some additional html message blocks available to templates, then build the html portion.
        if (!isset($block['EMAIL_TO_NAME']) || $block['EMAIL_TO_NAME'] == '')       $block['EMAIL_TO_NAME'] = $to_name;
        if (!isset($block['EMAIL_TO_ADDRESS']) || $block['EMAIL_TO_ADDRESS'] == '') $block['EMAIL_TO_ADDRESS'] = $to_email_address;
        if (!isset($block['EMAIL_SUBJECT']) || $block['EMAIL_SUBJECT'] == '')       $block['EMAIL_SUBJECT'] = $email_subject;
        if (!isset($block['EMAIL_FROM_NAME']) || $block['EMAIL_FROM_NAME'] == '')   $block['EMAIL_FROM_NAME'] = $from_email_name;
        if (!isset($block['EMAIL_FROM_ADDRESS']) || $block['EMAIL_FROM_ADDRESS'] == '') $block['EMAIL_FROM_ADDRESS'] = $from_email_address;

        /*bof use costome words*/
        if (isset($_SESSION['customer_email_data']) && is_array($_SESSION['customer_email_data'])) {
            /* FOR OUR custome information*/
            if (!isset($block['FIRSTNAME']) || $block['FIRSTNAME'] == '') $block['FIRSTNAME'] = $_SESSION['customer_email_data']['firstname'];
            if (!isset($block['LASTNAME']) || $block['LASTNAME'] == '') $block['LASTNAME'] = $_SESSION['customer_email_data']['lastname'];
            if (!isset($block['EMAIL_ADDRESS']) || $block['EMAIL_ADDRESS'] == '') $block['EMAIL_ADDRESS'] = $_SESSION['customer_email_data']['email_address'];
            if (!isset($block['PASSWORD']) || $block['PASSWORD'] == '') $block['PASSWORD'] = $_SESSION['customer_email_data']['password'];

        }
        /*eof use costome words*/


        $email_html = (!is_array($block) && substr($block, 0, 6) == '<html>') ? $block : zen_build_html_email_from_template($module, $block);
        $email_html = str_replace('$user_email',$to_address,$email_html);
        if (!is_array($block) && $block == '' || $block == 'none') $email_html = '';

        // Build the email based on whether customer has selected HTML or TEXT, and whether we have supplied HTML or TEXT-only components
        // special handling for XML content
        if ($email_text == '') {
            $email_text = str_replace(array('<br>','<br />'), "<br />\n", $block['EMAIL_MESSAGE_HTML']);
            $email_text = str_replace('</p>', "</p>\n", $email_text);
            $email_text = ($module != 'xml_record') ? htmlspecialchars(stripslashes(strip_tags($email_text))) : $email_text;
        } else {
            $email_text = ($module != 'xml_record') ? strip_tags($email_text) : $email_text;
        }

        if ($module != 'xml_record') {
            if (!strstr($email_text, sprintf(EMAIL_DISCLAIMER, STORE_OWNER_EMAIL_ADDRESS)) && $to_email_address != STORE_OWNER_EMAIL_ADDRESS && !defined('EMAIL_DISCLAIMER_NEW_CUSTOMER')) $email_text .= "\n" . sprintf(EMAIL_DISCLAIMER, STORE_OWNER_EMAIL_ADDRESS);
            if (defined('EMAIL_SPAM_DISCLAIMER') && EMAIL_SPAM_DISCLAIMER != '' && !strstr($email_text, EMAIL_SPAM_DISCLAIMER) && $to_email_address != STORE_OWNER_EMAIL_ADDRESS) $email_text .= "\n" . EMAIL_SPAM_DISCLAIMER;
        }

        // bof: body of the email clean-up
        // clean up &amp; and && from email text
        while (strstr($email_text, '&amp;&amp;')) $email_text = str_replace('&amp;&amp;', '&amp;', $email_text);
        while (strstr($email_text, '&amp;')) $email_text = str_replace('&amp;', '&', $email_text);
        while (strstr($email_text, '&&')) $email_text = str_replace('&&', '&', $email_text);

        // clean up currencies for text emails
        $zen_fix_currencies = preg_split("/[:,]/" , CURRENCIES_TRANSLATIONS);
        $size = sizeof($zen_fix_currencies);
        for ($i=0, $n=$size; $i<$n; $i+=2) {
            $zen_fix_current = $zen_fix_currencies[$i];
            $zen_fix_replace = $zen_fix_currencies[$i+1];
            if (strlen($zen_fix_current)>0) {
                while (strpos($email_text, $zen_fix_current)) $email_text = str_replace($zen_fix_current, $zen_fix_replace, $email_text);
            }
        }

        // fix double quotes
        while (strstr($email_text, '&quot;')) $email_text = str_replace('&quot;', '"', $email_text);
        // prevent null characters
        while (strstr($email_text, chr(0))) $email_text = str_replace(chr(0), ' ', $email_text);

        // fix slashes
        $text = stripslashes($email_text);
        $email_html = stripslashes($email_html);

        // eof: body of the email clean-up

        //determine customer's email preference type: HTML or TEXT-ONLY  (HTML assumed if not specified)
        $sql = "select customers_email_format from " . TABLE_CUSTOMERS . " where customers_email_address= :custEmailAddress:";
        $sql = $db->bindVars($sql, ':custEmailAddress:', $to_email_address, 'string');
        $result = $db->Execute($sql);
        $customers_email_format = ($result->RecordCount() > 0) ? $result->fields['customers_email_format'] : '';

        if ($customers_email_format == 'NONE' || $customers_email_format == 'OUT') return; //if requested no mail, then don't send.
        //      if ($customers_email_format == 'HTML') $customers_email_format = 'HTML'; // if they opted-in to HTML messages, then send HTML format

        // handling admin/"extra"/copy emails:
        if (ADMIN_EXTRA_EMAIL_FORMAT == 'TEXT' && substr($module,-6)=='_extra') {
            $email_html='';  // just blank out the html portion if admin has selected text-only
        }
        //determine what format to send messages in if this is an admin email for newsletters:
        /*      if ($customers_email_format == '' && ADMIN_EXTRA_EMAIL_FORMAT == 'HTML' && in_array($module, array('newsletters', 'product_notification')) && isset($_SESSION['admin_id'])) {
         $customers_email_format = 'HTML';
        }*/


        // special handling for XML content
        if ($module == 'xml_record') {
            $email_html = '';
            $customers_email_format ='TEXT';
        }

        //notifier intercept option
        $zco_notifier->notify('NOTIFY_EMAIL_AFTER_EMAIL_FORMAT_DETERMINED');

        // now lets build the mail object with the phpmailer class
        $mail = new PHPMailer();
        $lang_code = strtolower(($_SESSION['languages_code'] == '' ? 'en' : $_SESSION['languages_code'] ));
        $mail->SetLanguage($lang_code, DIR_FS_CATALOG . DIR_WS_CLASSES . 'support/');
        $mail->CharSet =  (defined('CHARSET')) ? CHARSET : "iso-8859-1";
        $mail->Encoding = (defined('EMAIL_ENCODING_METHOD')) ? EMAIL_ENCODING_METHOD : "7bit";
        if ((int)EMAIL_SYSTEM_DEBUG > 0 ) $mail->SMTPDebug = (int)EMAIL_SYSTEM_DEBUG;
        $mail->WordWrap = 76;    // set word wrap to 76 characters
        // set proper line-endings based on switch ... important for windows vs linux hosts:
        $mail->LE = (EMAIL_LINEFEED == 'CRLF') ? "\r\n" : "\n";

        $mail_transport = 'smtpauth';
        switch (EMAIL_TRANSPORT) {
            case 'smtpauth':
                $mail->IsSMTP();
                $mail->SMTPAuth = true;
                $mail->Username = 'noreply@fiberstore.com';
                $mail->Password = 'USfs_20130901';
                $mail->Host = trim(EMAIL_SMTPAUTH_MAIL_SERVER);
                if (EMAIL_SMTPAUTH_MAIL_SERVER_PORT != '25' && EMAIL_SMTPAUTH_MAIL_SERVER_PORT != '') $mail->Port = trim(EMAIL_SMTPAUTH_MAIL_SERVER_PORT);
                $mail->LE = "\r\n";
                //set encryption protocol to allow support for Gmail or other secured email protocols
                if (EMAIL_SMTPAUTH_MAIL_SERVER_PORT == '465' || EMAIL_SMTPAUTH_MAIL_SERVER_PORT == '587' || EMAIL_SMTPAUTH_MAIL_SERVER == 'smtp.gmail.com') $mail->Protocol = 'ssl';
                if (defined('SMTPAUTH_EMAIL_PROTOCOL') && SMTPAUTH_EMAIL_PROTOCOL != 'none') {
                    $mail->Protocol = SMTPAUTH_EMAIL_PROTOCOL;
                    if (SMTPAUTH_EMAIL_PROTOCOL == 'starttls' && defined('SMTPAUTH_EMAIL_CERTIFICATE_CONTEXT')) {
                        $mail->Starttls = true;
                        $mail->Context = SMTPAUTH_EMAIL_CERTIFICATE_CONTEXT;
                    }
                }
                break;
            case 'smtp':
                $mail->IsSMTP();
                $mail->Host = trim(EMAIL_SMTPAUTH_MAIL_SERVER);
                if (EMAIL_SMTPAUTH_MAIL_SERVER_PORT != '25' && EMAIL_SMTPAUTH_MAIL_SERVER_PORT != '') $mail->Port = trim(EMAIL_SMTPAUTH_MAIL_SERVER_PORT);
                $mail->LE = "\r\n";
                break;

            case 'PHP':
                $mail->IsMail();
                break;
            case 'Qmail':
                $mail->IsQmail();
                break;
            case 'sendmail':
            case 'sendmail-f':
                $mail->LE = "\n";
            default:
                $mail->IsSendmail();
                if (defined('EMAIL_SENDMAIL_PATH')) $mail->Sendmail = trim(EMAIL_SENDMAIL_PATH);
                break;
        }

        $mail->Subject  = $email_subject;
        $mail->From     = $from_email_address;
        $mail->FromName = $from_email_name;
        $mail->AddAddress($to_email_address, $to_name);
        //$mail->AddAddress($to_email_address);    // (alternate format if no name, since name is optional)
        //$mail->AddBCC(STORE_NAME, STORE_OWNER_EMAIL_ADDRESS);

        // set the reply-to address.  If none set yet, then use Store's default email name/address.
        // If sending from contact-us or tell-a-friend page, use the supplied info
        $email_reply_to_address = (isset($email_reply_to_address) && $email_reply_to_address != '') ? $email_reply_to_address : (in_array($module, array('contact_us',  'tell_a_friend')) ? $from_email_address : EMAIL_FROM);
        $email_reply_to_name    = (isset($email_reply_to_name) && $email_reply_to_name != '')    ? $email_reply_to_name    : (in_array($module, array('contact_us',  'tell_a_friend')) ? $from_email_name    : STORE_NAME);
        $mail->AddReplyTo($email_reply_to_address, $email_reply_to_name);

        // if mailserver requires that all outgoing mail must go "from" an email address matching domain on server, set it to store address
        if (EMAIL_SEND_MUST_BE_STORE=='Yes') $mail->From = EMAIL_FROM;

        if (EMAIL_TRANSPORT=='sendmail-f' || EMAIL_SEND_MUST_BE_STORE=='Yes') {
            $mail->Sender = EMAIL_FROM;
        }

        if (EMAIL_USE_HTML == 'true') $email_html = processEmbeddedImages($email_html, $mail);

        // PROCESS FILE ATTACHMENTS
        if ($attachments_list == '') $attachments_list = array();
        if (is_string($attachments_list)) {
            if (file_exists($attachments_list)) {
                $attachments_list = array(array('file' => $attachments_list));
            } elseif (file_exists(DIR_FS_CATALOG . $attachments_list)) {
                $attachments_list = array(array('file' => DIR_FS_CATALOG . $attachments_list));
            } else {
                $attachments_list = array();
            }
        }
        global $newAttachmentsList;
        $zco_notifier->notify('NOTIFY_EMAIL_BEFORE_PROCESS_ATTACHMENTS', array('attachments'=>$attachments_list, 'module'=>$module));
        if (isset($newAttachmentsList) && is_array($newAttachmentsList)) $attachments_list = $newAttachmentsList;
        if (defined('EMAIL_ATTACHMENTS_ENABLED') && EMAIL_ATTACHMENTS_ENABLED && is_array($attachments_list) && sizeof($attachments_list) > 0) {
            foreach($attachments_list as $key => $val) {
                $fname = (isset($val['name']) ? $val['name'] : null);
                $mimeType = (isset($val['mime_type']) && $val['mime_type'] != '' && $val['mime_type'] != 'application/octet-stream') ? $val['mime_type'] : '';
                switch (true) {
                    case (isset($val['raw_data']) && $val['raw_data'] != ''):
                        $fdata = $val['raw_data'];
                        if ($mimeType != '') {
                            $mail->AddStringAttachment($fdata, $fname, "base64", $mimeType);
                        } else {
                            $mail->AddStringAttachment($fdata, $fname);
                        }
                        break;
                    case (isset($val['file']) && file_exists($val['file'])): //'file' portion must contain the full path to the file to be attached
                        $fdata = $val['file'];
                        if ($mimeType != '') {
                            $mail->AddAttachment($fdata, $fname, "base64", $mimeType);
                        } else {
                            $mail->AddAttachment($fdata, $fname);
                        }
                        break;
                } // end switch
            } //end foreach attachments_list
        } //endif attachments_enabled
        $zco_notifier->notify('NOTIFY_EMAIL_AFTER_PROCESS_ATTACHMENTS', sizeof($attachments_list));

        /*bof force to use html format*/
        $customers_email_format = 'HTML';
        /*bof force to use html format*/


        // prepare content sections:
        if (EMAIL_USE_HTML == 'true' && trim($email_html) != '' &&
            ($customers_email_format == 'HTML' || (ADMIN_EXTRA_EMAIL_FORMAT != 'TEXT' && substr($module,-6)=='_extra'))) {
            $mail->IsHTML(true);           // set email format to HTML
            $mail->Body    = $email_html;  // HTML-content of message
            $mail->AltBody = $text;        // text-only content of message
        }  else {                        // use only text portion if not HTML-formatted
            $mail->Body    = $text;        // text-only content of message
        }

        /**
         * Send the email. If an error occurs, trap it and display it in the messageStack
         */

        $ErrorInfo = '';
        $zco_notifier->notify('NOTIFY_EMAIL_READY_TO_SEND');
        if (!($result = $mail->Send())) {
            if (IS_ADMIN_FLAG === true) {
                $messageStack->add_session(sprintf(EMAIL_SEND_FAILED . '&nbsp;'. $mail->ErrorInfo, $to_name, $to_email_address, $email_subject),'error');
            } else {
                $messageStack->add('header',sprintf(EMAIL_SEND_FAILED . '&nbsp;'. $mail->ErrorInfo, $to_name, $to_email_address, $email_subject),'error');
            }
            $ErrorInfo .= $mail->ErrorInfo . '<br />';
        }
        $zco_notifier->notify('NOTIFY_EMAIL_AFTER_SEND');

        // Archive this message to storage log
        // don't archive pwd-resets and CC numbers
        if (EMAIL_ARCHIVE == 'true'  && $module != 'password_forgotten_admin' && $module != 'cc_middle_digs' && $module != 'no_archive') {
            zen_mail_archive_write($to_name, $to_email_address, $from_email_name, $from_email_address, $email_subject, $email_html, $text, $module, $ErrorInfo );
        } // endif archiving
    } // end foreach loop thru possible multiple email addresses
    $zco_notifier->notify('NOTIFY_EMAIL_AFTER_SEND_ALL_SPECIFIED_ADDRESSES');

    if (EMAIL_FRIENDLY_ERRORS=='false' && $ErrorInfo != '') die('<br /><br />Email Error: ' . $ErrorInfo);

    return $ErrorInfo;
}
/**
 * 根据客户的language_id来获取邮件的头部和尾部
 * @param: string or int   $customer_id    =admim是为管理员邮件发送英文版
 * @return:   array $html   返回邮件头部和尾部
 * @author: Buck
 * @date: 2016-8-3 下午5:10:27
 */
function  zen_get_corresponding_languages_email_common($customer_id=''){
    global $db;
    if($customer_id==''){  //根据网站languages_id调用模板
        $languages_id=$_SESSION['languages_id'];
    }elseif($customer_id!='' && $customer_id != 'admin'){   //客户
        $sql='select language_id from customers where customers_id = '.(int)$customer_id;
        $result=$db->Execute($sql);
        $languages_id= ($result->RecordCount() > 0) ? $result->fields['language_id']:$_SESSION['languages_id'];
    }elseif ($customer_id == 'admin'){   //管理员
        $languages_id=1;
    }
    switch ((int)$languages_id){
        case 1: include_once(DIR_FS_CATALOG.DIR_WS_LANGUAGES.'email/english.php');break;
        case 2: include_once(DIR_FS_CATALOG.DIR_WS_LANGUAGES.'email/spanish.php');break;
        case 3: include_once(DIR_FS_CATALOG.DIR_WS_LANGUAGES.'email/france.php');break;
        case 4: include_once(DIR_FS_CATALOG.DIR_WS_LANGUAGES.'email/russian.php');break;
        case 5: include_once(DIR_FS_CATALOG.DIR_WS_LANGUAGES.'email/german.php');break;
        case 6: include_once(DIR_FS_CATALOG.DIR_WS_LANGUAGES.'email/chinese.php');break;
        case 8: include_once(DIR_FS_CATALOG.DIR_WS_LANGUAGES.'email/japan.php');break;
        default: include_once(DIR_FS_CATALOG.DIR_WS_LANGUAGES.'email/english.php');break;
    }
    $warehouse_title ="<div style='background: #f7f7f7;width: 100%;float: left;'>
    <style type='text/css'>
    @font-face{font-family:Myriad;font-style:normal;font-weight:400;src:url(https://www.fs.com/includes/templates/fiberstore/fonts/MyriadPro-Regular.otf);src:local('Myriad'),local('Myriad'),url(https://www.fs.com/includes/templates/fiberstore/fonts/MyriadPro-Regular.otf) format('otf')}
    @font-face{font-family:Myriad;font-style:normal;font-weight:400;src:local('Myriad Light'),local('Myriad-Light'),url(https://www.fs.com/includes/templates/fiberstore/fonts/MyriadPro-Light.otf) format('otf')}
    @font-face{font-family:Myriad;font-style:normal;font-weight:600;src:local('Myriad semibold webfont'),local('Myriad-semibold-webfont'),url(https://www.fs.com/includes/templates/fiberstore/fonts/MyriadPro-Semibold.otf) format('otf')}
    @font-face{font-family:'Open Sans';font-style:normal;font-weight:400;src:url(https://www.fs.com/includes/templates/fiberstore/fonts/opensans.woff);src:local('Open Sans'),local('OpenSans'),url(https://www.fs.com/includes/templates/fiberstore/fonts/opensans.woff) format('woff')}
    @font-face{font-family:'Open Sans';font-style:normal;font-weight:400;src:local('Open Sans Light'),local('OpenSans-Light'),url(https://www.fs.com/includes/templates/fiberstore/fonts/opensans-light-webfont.woff) format('woff')}
    @font-face{font-family:'Open Sans';font-style:normal;font-weight:600;src:local('opensans semibold webfont'),local('opensans-semibold-webfont'),url(https://www.fs.com/includes/templates/fiberstore/fonts/opensans-semibold-webfont.woff) format('woff')}
#mailContentContainer,#mailContentContainer td,#mailContentContainer input,#mailContentContainer button,#mailContentContainer select{font-family: 'Open Sans',Arial,Helvetica,sans-serif !important;font-style: normal;}
    #mailContentContainer{margin-right:0 !important}
    </style>
    <div class='em_content' style='padding: 3%;padding-top:0;box-sizing: border-box;width: 650px;margin: 0px auto 50px auto;background: #FFFFFF;margin-top:0'>
      <div class='em_top' style='text-decoration: none;text-align: center;background: #a7a6a6;font-size: 14px;color: #FFF;line-height: 30px;'>
      <a style='text-decoration: none;height: 30px;text-align: center;font-size: 14px;color: #FFF;line-height: 30px;' href=".zen_href_link('index').">";
    $warehouse_address = '<div style="margin-top: 12px;font-size: 12px;line-height: 20px;color: #232323;text-align: center;" class="em_bot">';
    if($languages_id==9 && au_warehouse($_SESSION['countries_code_21'],"country_code")==false){
        //UK站
        $warehouse_title .= SEND_MAIL_1;
        $warehouse_address .= SEND_MAIL_2;
    }else{
        if(seattle_warehouse("country_code",$_SESSION['countries_code_21'])==true){
            //西雅图仓
            $warehouse_title .= SEND_MAIL_3;
            $warehouse_address .= SEND_MAIL_4;
        }elseif(all_german_warehouse("country_code",$_SESSION['countries_code_21'])==true) {
            //德国仓
            $warehouse_title .= SEND_MAIL_5;
            $warehouse_address .= SEND_MAIL_6;
        }elseif(au_warehouse($_SESSION['countries_code_21'],"country_code")==true){
            //澳洲仓
            if($_SESSION['countries_code_21']=="NZ"){
                $warehouse_title .=  SEND_MAIL_9;
                $warehouse_address .= SEND_MAIL_8;
            }else{
                $warehouse_title .=  SEND_MAIL_7;
                $warehouse_address .= SEND_MAIL_8;
            }
        }else{
            //全球仓
            $warehouse_title .= SEND_MAIL_9;
            $warehouse_address .= SEND_MAIL_10;
        }
    }
    $warehouse_title .='</a></div>';
    $warehouse_address .='<div style="margin-top: 12px;font-size: 13px;line-height: 20px;color: #232323;text-align: center;" class="em_bottom"><a href="'.zen_href_link('index').'" style="text-decoration:none;color: #232323;" target="_blank">www.fs.com</a></div>
		</div></div></div>';
    $html_header=$warehouse_title.EMAIL_HEADER_INFO;
    $html_footer=EMAIL_FOOTER_INFO.$warehouse_address;
    $email_common_text['EMAIL_HEAHER_RIGHT']=EMAIL_HEAHER_RIGHT;
    $email_common_text['EMAIL_MENU_HOME']=EMAIL_MENU_HOME;
    $email_common_text['EMAIL_HOME_URL']=EMAIL_HOME_URL;
    $email_common_text['EMAIL_MENU_SUPPORT']=EMAIL_MENU_SUPPORT;
    $email_common_text['EMAIL_SUPPORT_URL']=EMAIL_SUPPORT_URL;
    $email_common_text['EMAIL_MENU_TUTORIAL']=EMAIL_MENU_TUTORIAL;
    $email_common_text['EMAIL_TUTORIAL_URL']=EMAIL_TUTORIAL_URL;
    $email_common_text['EMAIL_MENU_ABOUT_US']=EMAIL_MENU_ABOUT_US;
    $email_common_text['EMAIL_ABOUT_US_URL']=EMAIL_ABOUT_US_URL;
    $email_common_text['EMAIL_MENU_SERVICE']=EMAIL_MENU_SERVICE;
    $email_common_text['EMAIL_SERVICE_URL']=EMAIL_SERVICE_URL;
    $email_common_text['EMAIL_MENU_CONTACT_US']=EMAIL_MENU_CONTACT_US;
    $email_common_text['EMAIL_CONTACT_US_URL']=EMAIL_CONTACT_US_URL;
    $email_common_text['EMAIL_MENU_PURCHASE_HELP']=EMAIL_MENU_PURCHASE_HELP;
    $email_common_text['EMAIL_PURCHASE_HELP_URL']=EMAIL_PURCHASE_HELP_URL;
    $email_common_text['EMAIL_FOOTER_FS_COPYRIGHT']=EMAIL_FOOTER_FS_COPYRIGHT;
    $email_common_text['EMAIL_FOOTER_PROMPT'] = EMAIL_FOOTER_PROMPT;

    foreach ($email_common_text as $k=>$v){
        $html_header = str_replace('$'.$k,$v,$html_header);
        $html_footer = str_replace('$'.$k,$v,$html_footer);
    }
    return $html=array('html_header'=>$html_header,'html_footer'=>$html_footer);
}

// 注册发送激活邮件
function send_active_email($email_address){
    global $db;
    $sql = 'select * from customers WHERE customers_email_address="'.$email_address.'" limit 1 ';
    $customers = $db->getAll($sql);
    $customers = $customers[0];

    $sql = 'select * from partner_register WHERE company_email="'.$email_address.'" limit 1 ';
    $partners = $db->getAll($sql);
    $partners = $partners[0];

    // 英文站，考虑如果该用户是老用户，对应销售是什么语种，注册时候，给用户发相应语种的邮件
    if($customers['is_old'] == 1 && $_SESSION['languages_id']==1){
        $sql = 'select A.which_language 
                from admin_to_customers AC 
                left join admin A on AC.admin_id = A.admin_id 
                WHERE AC.customers_id="'.$customers['customers_id'].'" limit 1 ';
        $admins = $db->getAll($sql);
        $admins = $admins[0];
        if($admins['which_language'] != 1){
            switch ($admins['which_language']){
                case 2: $email_lan = DIR_FS_CATALOG.'es/'.DIR_WS_LANGUAGES.'email/spanish.php';include_once($email_lan);break;
                case 3: $email_lan = DIR_FS_CATALOG.'fr/'.DIR_WS_LANGUAGES.'email/france.php';include_once($email_lan);break;
                case 4: $email_lan = DIR_FS_CATALOG.'ru/'.DIR_WS_LANGUAGES.'email/russian.php';include_once($email_lan);break;
                case 5: $email_lan = DIR_FS_CATALOG.'de/'.DIR_WS_LANGUAGES.'email/german.php';include_once($email_lan);break;
            }
        }
    }

    $html_msg = array();
    $html=zen_get_corresponding_languages_email_common();
    $html_msg['EMAIL_HEADER'] = $html['html_header'];
    $html_msg['EMAIL_FOOTER'] = $html['html_footer'];
    $html_msg['FS_EMAIL_COMMA'] = FS_EMAIL_COMMA;
    if(!$partners) { // 个人用户
        $html_msg['EMAIL_BODY_COMMON_DEAR'] = '<div style="padding:10px 0 20px 0; font-weight:600;">' . EMAIL_REGIST_TO_CUSTOMER_THANK . '</div>' . EMAIL_BODY_COMMON_DEAR.FS_EMAIL_COMMA;
    }else{
        $html_msg['EMAIL_BODY_COMMON_DEAR'] = '<div style="padding:10px 0 20px 0; font-weight:600;">' . EMAIL_REGIST_TO_COMPANY_THANK . '</div>' . EMAIL_BODY_COMMON_DEAR.FS_EMAIL_COMMA;
    }
    $html_msg['EMAIL_FIRST_NAME'] = $customers['customers_firstname'];
    $html_msg['EMAIL_LAST_NAME'] = $customers['customers_lastname'];
    $customer_name = $customers['customers_firstname'].' '.$customers['customers_lastname'];

    $re_url = HTTP_SERVER.'/index.php?main_page=regist_email_check&do=active&c='.myEncode($customers['customers_id']).'&k='.$customers['email_check_seed'];
    if(!$partners){ // 个人用户
        $email_text_new =
            '<div style="line-height:22px;font-size: 14px;">
        <div style="padding:0 0 20px 0; font-size:13px;">'.EMAIL_REGIST_TO_CUSTOMER_INTRO.'</div>
        <ul style="padding: 0 20px; margin: 0;font-size:13px;">'.EMAIL_REGIST_TO_CUSTOMER_INTRO_DES.'</ul>
        <div style="padding:20px 0; font-size:13px;">'.EMAIL_REGIST_TO_CUSTOMER_VERIFYT_TITLE.'</div>
        <div style="padding:0 0 20px 0; font-size:13px;"><a href="'.$re_url.'" target="_blank" style="color:#0070BC; text-decoration:none;">'.EMAIL_REGIST_COMMON_VERIFY_EMAIL.'</a></div>
        <div style="padding:20px 0; font-size:13px;">'.EMAIL_REGIST_COMMON_VERIFYT_TITLE2.'<br />
            <a href="'.$re_url.'" target="_blank" style="color:#0070BC; text-decoration:none;">'.$re_url.'</a>
        </div>
         <div style="padding:0 0 20px 0; font-size:13px;">'.EMAIL_REGIST_COMMON_VERIFYT_TIME.'</div>
         <div style="padding:0 0 20px 0; ">'.EMAIL_REGIST_COMMON_SINCERELY.'</div>
         <div style="margin-bottom:-40px;">'.EMAIL_REGIST_COMMON_FS.'</div>
        </div>';
        $email_subject = EMAIL_REGIST_TO_CUSTOMER_SUBJECT;
    }else{ // 企业用户
        $email_text_new =
            '<div style="line-height:22px; font-size: 14px;">
        <div style="padding:0 0 20px 0; font-size:13px;">'.EMAIL_REGIST_TO_COMPANY_INTRO.'</div>
        <div style="padding:20px 0; font-size:13px;">'.EMAIL_REGIST_TO_COMPANY_VERIFYT_TITLE.'</div>
        <div style="padding:0 0 20px 0; font-size:13px;"><a href="'.$re_url.'" target="_blank" style="color:#0070BC; text-decoration:none;">'.EMAIL_REGIST_COMMON_VERIFY_EMAIL.'</a></div>
        <div style="padding:20px 0; font-size:13px;">'.EMAIL_REGIST_COMMON_VERIFYT_TITLE2.'<br />
            <a href="'.$re_url.'" target="_blank" style="color:#0070BC; text-decoration:none;">'.$re_url.'</a>
        </div>
         <div style="padding:0 0 20px 0; font-size:13px;">'.EMAIL_REGIST_COMMON_VERIFYT_TIME.'</div>
         <div style="padding:0 0 20px 0; font-size:13px;">'.EMAIL_REGIST_TO_COMPANY_THANK_AGAIN.'</div>
         <div style="padding:0 0 20px 0; ">'.EMAIL_REGIST_COMMON_SINCERELY.'</div>
         <div style="margin-bottom:-40px;">'.EMAIL_REGIST_COMMON_FS.'</div>
        </div>';
        $email_subject = EMAIL_COMPANY_REGIST_SUBJECT;
    }

    $html_msg['EMAIL_REGIST_TO_CUSTOMER_TEXT1'] = $email_text_new;
    $html_msg['EMAIL_REGIST_TO_CUSTOMER_TEXT2'] = $html_msg['EMAIL_REGIST_TO_CUSTOMER_TEXT3'] = $email_text = '';
    if (trim ( EMAIL_SUBJECT ) != 'n/a')
        $send_to_email = 'support@fiberstore.com';
    sendwebmail($customer_name,$email_address,'注册激活邮件:'.date('Y-m-d H:i:s', time()),STORE_NAME,$email_subject,$html_msg,'regist_to_customer');

}

// 发送升级邮件，并给相应销售发邮件
function send_update_email($email_address){
    global $db;

    $sql = 'select * from customers WHERE customers_email_address="'.$email_address.'" limit 1 ';
    $customers = $db->getAll($sql);
    $customers = $customers[0];
    $cid = $customers['customers_id'];

    $email_warehouse_info = get_email_langpac();
    $html = common_email_header_and_footer(REGIST_COM_EMAIL_UPGRADE_TITLE,REGIST_COM_EMAIL_UPGRADE_01,$email_warehouse_info);
    $html_msg['EMAIL_HEADER'] = $html['header'];
    $html_msg['EMAIL_FOOTER'] = $html['footer'];
    $customer_name = $customers['customers_firstname'].($customers['customers_lastname'] ? ' '.$customers['customers_lastname'] : '');
    $customer_name = ucwords($customer_name);
    $html_body = '<table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 30px 20px 0" align="left">
                                    <a style="color:#232323;text-decoration: none;cursor:auto" href="javascript:;">'.REGIST_COM_EMAIL_UPGRADE_02.' '.$customer_name.FS_EMAIL_COMMA.'</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse" height="15">

                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                                    '.REGIST_COM_EMAIL_UPGRADE_03.'
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse" height="30">

                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px 30px;" align="left">
                                    '.REGIST_COM_EMAIL_UPGRADE_04.'
                                </td>
                            </tr>
                            </tbody>
                        </table>';
    $html_msg['EMAIL_BODY'] = $html_body;
    sendwebmail($customer_name,$email_address,'发送升级邮件给客户:'.date('Y-m-d H:i:s', time()),STORE_NAME,REGIST_COM_EMAIL_UPGRADE_THEME,$html_msg,'default');

    // 申请成功之后，给相应的销售发邮件
    $sql = 'select A.admin_email,A.admin_name from admin_to_customers AC 
          LEFT join admin A on AC.admin_id=A.admin_id 
          WHERE AC.customers_id = ' . $cid . ' limit 1 ';
    $admin = $db->getAll($sql);
    $admin_one = $admin[0];
    if ($admin_one['admin_email']) {
        $html_msg['EMAIL_BODY'] = '邮箱为' . $email_address . '的用户 在' . date('Y-m-d H:i:s') . '申请了企业会员，请及时处理！';
        sendwebmail($admin_one['admin_email'],$admin_one['admin_email'],'发送升级邮件给销售:'.date('Y-m-d H:i:s', time()),STORE_NAME,REGIST_COM_EMAIL_UPGRADE_THEME,$html_msg,'default');
    }
}

// 企业注册发送邮件（新用户）
function send_company_regist_email($email_address){
    global $db;
    $sql = 'select * from customers WHERE customers_email_address="'.$email_address.'" limit 1 ';
    $customers = $db->getAll($sql);
    $customers = $customers[0];

    // 英文站，考虑如果该用户是老用户，对应销售是什么语种，注册时候，给用户发相应语种的邮件
    if($customers['is_old'] == 1 && $_SESSION['languages_id']==1){
        $sql = 'select A.which_language 
                from admin_to_customers AC 
                left join admin A on AC.admin_id = A.admin_id 
                WHERE AC.customers_id="'.$customers['customers_id'].'" limit 1 ';
        $admins = $db->getAll($sql);
        $admins = $admins[0];
        if($admins['which_language'] != 1){
            switch ($admins['which_language']){
                case 2: $email_lan = DIR_FS_CATALOG.'es/'.DIR_WS_LANGUAGES.'email/spanish.php';include_once($email_lan);break;
                case 3: $email_lan = DIR_FS_CATALOG.'fr/'.DIR_WS_LANGUAGES.'email/france.php';include_once($email_lan);break;
                case 4: $email_lan = DIR_FS_CATALOG.'ru/'.DIR_WS_LANGUAGES.'email/russian.php';include_once($email_lan);break;
                case 5: $email_lan = DIR_FS_CATALOG.'de/'.DIR_WS_LANGUAGES.'email/german.php';include_once($email_lan);break;
                case 8: $email_lan = DIR_FS_CATALOG.'jp/'.DIR_WS_LANGUAGES.'email/japan.php';include_once($email_lan);break;
            }
        }
    }

    $email_warehouse_info = get_email_langpac();
    $html = common_email_header_and_footer(REGIST_COM_EMAIL_SEND_TITLE,REGIST_COM_EMAIL_SEND_01,$email_warehouse_info);
    $html_msg['EMAIL_HEADER'] = $html['header'];
    $html_msg['EMAIL_FOOTER'] = $html['footer'];
    $customer_name = $customers['customers_firstname'].($customers['customers_lastname'] ? ' '.$customers['customers_lastname'] : '');
    $customer_name = ucwords($customer_name);

    if($_SESSION['languages_id'] == 8){
        $text_01 = '<a href="'.zen_href_link('edit_my_account').'" style="color: #0070BC;text-decoration: none">'.REGIST_COM_EMAIL_SEND_08.'</a>'.REGIST_COM_EMAIL_SEND_09.REGIST_COM_EMAIL_SEND_10;
        $text_02 = '<a href="'.zen_href_link('my_cases').'" style="color: #0070BC;text-decoration: none">'.REGIST_COM_EMAIL_SEND_11.'</a>'.REGIST_COM_EMAIL_SEND_12.REGIST_COM_EMAIL_SEND_13;
    }else{
        $text_01 = REGIST_COM_EMAIL_SEND_08.'<a href="'.zen_href_link('edit_my_account').'" style="color: #0070BC;text-decoration: none">'.REGIST_COM_EMAIL_SEND_09.'</a>'.REGIST_COM_EMAIL_SEND_10;
        $text_02 = REGIST_COM_EMAIL_SEND_11.'<a href="'.zen_href_link('my_cases').'" style="color: #0070BC;text-decoration: none">'.REGIST_COM_EMAIL_SEND_12.'</a>'.REGIST_COM_EMAIL_SEND_13;
    }


    $html_body = '<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 30px 20px 0" align="left">
                        <a style="color:#232323;text-decoration: none;cursor:auto" href="javascript:;">'.RESET_EMAIL_SUCCESS_02.' '.$customer_name.FS_EMAIL_COMMA.'</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="15">

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            '.REGIST_COM_EMAIL_SEND_03.'
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="15">

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            '.REGIST_COM_EMAIL_SEND_04.'<a href="'.zen_href_link('login').'" style="color: #0070BC;text-decoration: none">'.REGIST_COM_EMAIL_SEND_05.'</a>'.REGIST_COM_EMAIL_SEND_06.'
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="15">

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            '.REGIST_COM_EMAIL_SEND_07.'
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="15">

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px 0 36px" align="left">
                            <ul style="padding: 0 0px 0 16px;margin: 0;">
                                <li style="font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding-bottom: 5px">
                                    '.$text_01.'
                                </li>
                                <li style="font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding-bottom: 5px">
                                    '.$text_02.'
                                </li>
                                <li style="font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;">
                                    '.REGIST_COM_EMAIL_SEND_14.'
                                </li>
                            </ul>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="30">

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px 30px;" align="left">
                            '.REGIST_COM_EMAIL_SEND_15.'
                        </td>
                    </tr>
                    </tbody>
                </table>';
    $html_msg['EMAIL_BODY'] = $html_body;
    $email_subject = REGIST_COM_EMAIL_SEND_THEME;
    sendwebmail($customer_name,$email_address,'企业注册邮件:'.date('Y-m-d H:i:s', time()),STORE_NAME,$email_subject,$html_msg,'default');
}

// 个人注册发送邮件
function send_person_regist_email($email_address){
    global $db;
    $sql = 'select * from customers WHERE customers_email_address="'.$email_address.'" limit 1 ';
    $customers = $db->getAll($sql);
    $customers = $customers[0];

    // 英文站，考虑如果该用户是老用户，对应销售是什么语种，注册时候，给用户发相应语种的邮件
    if($customers['is_old'] == 1 && $_SESSION['languages_id']==1){
        $sql = 'select A.which_language 
                from admin_to_customers AC 
                left join admin A on AC.admin_id = A.admin_id 
                WHERE AC.customers_id="'.$customers['customers_id'].'" limit 1 ';
        $admins = $db->getAll($sql);
        $admins = $admins[0];
        if($admins['which_language'] != 1){
            switch ($admins['which_language']){
                case 2: $email_lan = DIR_FS_CATALOG.DIR_WS_LANGUAGES.'email/spanish.php';include_once($email_lan);break;
                case 3: $email_lan = DIR_FS_CATALOG.DIR_WS_LANGUAGES.'email/france.php';include_once($email_lan);break;
                case 4: $email_lan = DIR_FS_CATALOG.DIR_WS_LANGUAGES.'email/russian.php';include_once($email_lan);break;
                case 5: $email_lan = DIR_FS_CATALOG.DIR_WS_LANGUAGES.'email/german.php';include_once($email_lan);break;
            }
        }
    }

    $email_warehouse_info = get_email_langpac();
    $html = common_email_header_and_footer(REGIST_EMAIL_SEND_TITLE,REGIST_EMAIL_SEND_01,$email_warehouse_info);
    $customer_name = $customers['customers_firstname'].($customers['customers_lastname'] ? ' '.$customers['customers_lastname'] : '');
    $customer_name = ucwords($customer_name);
    $customers_number_new = $customers['customers_number_new'];   // 客户编号

    if($_SESSION['languages_id'] == 8){
        $text_01 = '<a href="'.zen_href_link('edit_my_account').'" style="color: #0070BC;text-decoration: none">'.REGIST_EMAIL_SEND_07.'</a>'.REGIST_EMAIL_SEND_08.REGIST_EMAIL_SEND_09;
        $text_02 = '<a href="'.zen_href_link('my_cases').'" style="color: #0070BC;text-decoration: none">'.REGIST_EMAIL_SEND_10.'</a>'.REGIST_EMAIL_SEND_11.REGIST_EMAIL_SEND_12;
    }else{
        $text_01 = REGIST_EMAIL_SEND_07.'<a href="'.zen_href_link('edit_my_account').'" style="color: #0070BC;text-decoration: none">'.REGIST_EMAIL_SEND_08.'</a>'.REGIST_EMAIL_SEND_09;
        $text_02 = REGIST_EMAIL_SEND_10.'<a href="'.zen_href_link('my_cases').'" style="color: #0070BC;text-decoration: none">'.REGIST_EMAIL_SEND_11.'</a>'.REGIST_EMAIL_SEND_12;
    }

    $lang = $_SESSION['languages_code'];

    $html_body = '<table border="0" cellpadding="0" cellspacing="0" width="640">
                            <tbody>
                                <tr>
                                    <td align="center" bgcolor="#f5f6f7" height="68" style="border-collapse:collapse"><a
                                            href="'.zen_href_link('index').'" style="text-decoration:none" target="_blank"><img
                                                class="CToWUd" onerror=""
                                                src="https://img-en.fs.com/includes/templates/fiberstore/images/email/Email-logo.png"
                                                style="display:inline-block; height:38px; outline:none; text-decoration:none; vertical-align:middle" />
                                            <span
                                                style="border-left:1px solid #767474; color:#4c4948; display:inline-block; font-family:open sans,arial,sans-serif; font-size:18px; height:24px; line-height:24px; margin-left:10px; padding-left:10px; vertical-align:middle">'.REGIST_EMAIL_SEND_NEW_01.'</span> </a></td>
                                </tr>
                            </tbody>
                        </table>

                        <table border="0" cellpadding="0" cellspacing="0" width="640">
                            <tbody>
                                <tr>
                                    <td bgcolor="#fff" height="316" style="border-collapse:collapse;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td height="314"
                                                        style="border-collapse:collapse;background:url(https://img-en.fs.com/includes/templates/fiberstore/images/email/login/banner_account_created.jpg) no-repeat">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td height="100%" style="border-collapse:collapse"
                                                                        valign="middle" width="1%"></td>
                                                                    <td align="center"
                                                                        style="border-collapse:collapse;font-family:Open Sans,arial,sans-serif;"
                                                                        valign="middle" width="98%"><span
                                                                            style="color:#fff; font-size:26px; font-weight:400; line-height:34px">
                                                                            '.REGIST_EMAIL_SEND_NEW_02.'

                                                                        </span><br />
                                                                        <span
                                                                            style="color:#fff; font-size:13px; font-weight:400; line-height:22px;display: inline-block;padding: 13px 0 5px">
                                                                            '.REGIST_EMAIL_SEND_NEW_03.'
                                                                        </span> <br>
                                                                        <a href="'.zen_href_link('index').'"
                                                                            style="font-size: 14px; display: inline-block; margin-top: 10px; text-decoration-line: none; color: rgb(255, 255, 255);background: transparent; padding: 8px 20px; border-radius: 2px;border: 1px solid #fff;"
                                                                            target="_blank">'.REGIST_EMAIL_SEND_NEW_12.'</a></td>
                                                                    <td height="100%" style="border-collapse:collapse"
                                                                        valign="middle" width="1%"></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table border="0" cellpadding="0" cellspacing="0" width="640">
                            <tbody>
                                <tr>
                                    <td bgcolor="#fff" height="50"
                                        style="border-collapse: collapse; background-color: rgb(255, 255, 255); line-height: 30px;">
                                    </td>
                                </tr>
                            </tbody>
                        </table>


                        <table border="0" cellpadding="0" cellspacing="0" width="640">
                            <tbody>
                                <tr>
                                    <td bgcolor="#fff"
                                        style="border-collapse:collapse;background-color: #fff;padding: 0 10px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td bgcolor="#fff"
                                                        style="border-collapse:collapse;font-size:14px;color:#232323;line-height:22px;font-family:Open Sans,arial,sans-serif;"
                                                        width="130px">
                                                        <a href="https://www.fs.com/'.$lang.'/company/quality_control.html" style="text-decoration: none;" target="_blank">
                                                            <img alt=""
                                                                src="https://img-en.fs.com/includes/templates/fiberstore/images/email/login/V1_03.jpg"
                                                                style="padding: 0 25px 0 40px;" />
                                                        </a>
                                                    </td>
                                                    <td bgcolor="#fff"
                                                        style="border-collapse: collapse; line-height: 264px;background-color: #fff;">
                                                        <p
                                                            style="font-size: 18px;line-height: 24px;font-family:Open Sans,arial,sans-serif;color: #232323;font-weight: 600;margin: 0;">
                                                            <a style="font-size: 18px;line-height: 24px;font-family:Open Sans,arial,sans-serif;color: #232323;font-weight: 600;margin: 0; text-decoration: none;" href="https://www.fs.com/'.$lang.'/company/quality_control.html" target="_blank">
                                                                '.REGIST_EMAIL_SEND_NEW_04.'
                                                            
                                                            </a>
                                                        </p>
                                                        <p
                                                            style="font-size: 14px;line-height: 24px;font-family:Open Sans,arial,sans-serif;color: #616265;margin: 0;">
                                                            '.REGIST_EMAIL_SEND_NEW_05.'
                                                        </p>

                                                    </td>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td bgcolor="#fff" height="20"
                                        style="border-collapse: collapse; background-color: rgb(255, 255, 255); line-height: 30px;">
                                    </td>
                                </tr>
                                <tr>
                                    <td bgcolor="#fff"
                                        style="border-collapse:collapse;background-color: #fff;padding: 0 10px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td bgcolor="#fff"
                                                        style="border-collapse:collapse;font-size:14px;color:#232323;line-height:22px;font-family:Open Sans,arial,sans-serif;"
                                                        width="130px">
                                                        <a href="https://www.fs.com/'.$lang.'/case-studies.html" style="text-decoration: none;" target="_blank">
                                                            <img alt=""
                                                                src="https://img-en.fs.com/includes/templates/fiberstore/images/email/login/icon_solution.jpg"
                                                                style="padding: 0 25px 0 40px;" />
                                                        </a>
                                                    </td>
                                                    <td bgcolor="#fff"
                                                        style="border-collapse: collapse; line-height: 264px;background-color: #fff;">
                                                        <p
                                                            style="font-size: 18px;line-height: 24px;font-family:Open Sans,arial,sans-serif;color: #232323;font-weight: 600;margin: 0;">
                                                            <a style="font-size: 18px;line-height: 24px;font-family:Open Sans,arial,sans-serif;color: #232323;font-weight: 600;margin: 0; text-decoration: none;" href="https://www.fs.com/'.$lang.'/case-studies.html" target="_blank">
                                                                '.REGIST_EMAIL_SEND_NEW_06.'
                                                            </a>
                                                        </p>
                                                        <p style="font-size: 14px;line-height: 24px;font-family:Open Sans,arial,sans-serif;color: #616265;margin: 0;">
                                                            '.REGIST_EMAIL_SEND_NEW_07.'
                                                        </p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td bgcolor="#fff" height="20"
                                        style="border-collapse: collapse; background-color: rgb(255, 255, 255); line-height: 30px;">
                                    </td>
                                </tr>
                                <tr>
                                    <td bgcolor="#fff"
                                        style="border-collapse:collapse;background-color: #fff;padding: 0 10px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td bgcolor="#fff"
                                                        style="border-collapse:collapse;font-size:14px;color:#232323;line-height:22px;font-family:Open Sans,arial,sans-serif;"
                                                        width="130px">
                                                        <a href="https://www.fs.com/'.$lang.'/shipping_delivery.html" style="text-decoration: none;" target="_blank">
                                                            <img alt=""
                                                                src="https://img-en.fs.com/includes/templates/fiberstore/images/email/login/icon_delivery.jpg"
                                                                style="padding: 0 25px 0 40px;" />
                                                        </a>
                                                    </td>
                                                    <td bgcolor="#fff"
                                                        style="border-collapse: collapse; line-height: 264px;background-color: #fff;">
                                                        <p
                                                            style="font-size: 18px;line-height: 24px;font-family:Open Sans,arial,sans-serif;color: #232323;font-weight: 600;margin: 0;">
                                                            <a style="font-size: 18px;line-height: 24px;font-family:Open Sans,arial,sans-serif;color: #232323;font-weight: 600;margin: 0; text-decoration: none;" href="https://www.fs.com/'.$lang.'/shipping_delivery.html" target="_blank">
                                                                '.REGIST_EMAIL_SEND_NEW_08.'
                                                            </a>
                                                            

                                                        </p>
                                                        <p
                                                            style="font-size: 14px;line-height: 24px;font-family:Open Sans,arial,sans-serif;color: #616265;margin: 0;">
                                                            '.REGIST_EMAIL_SEND_NEW_09.'
                                                        </p>

                                                    </td>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table border="0" cellpadding="0" cellspacing="0" width="640">
                            <tbody>
                                <tr>
                                    <td bgcolor="#fff" height="50"
                                        style="border-collapse: collapse; background-color: rgb(255, 255, 255); line-height: 20px;">
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table border="0" cellpadding="0" cellspacing="0" width="640">
                            <tbody>
                                <tr>
                                    <td bgcolor="#fff"
                                        style="border-collapse:collapse;background-color: #fff;padding: 0 10px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tbody>
                                                <tr >
                                                    <td align="center" bgcolor="#f7f7f7" height="300"
                                                        style="border-collapse:collapse;font-size:14px;color:#232323;line-height:22px;font-family:Open Sans,arial,sans-serif;"
                                                        width="47.65%">
                                                        <div
                                                            style="margin: 0;box-sizing: border-box;width: 100%;height: 100%;text-align: left;">
                                                            <div style="background: url(https://img-en.fs.com/includes/templates/fiberstore/images/email/login/support_1text.jpg); height: 204px; position: relative; top: 0;">
                                                                <a href="https://www.fs.com/'.$lang.'/specials/remote-technical-support-111.html" style="text-decoration: none; color: #fff;font-size:14px; display: inline-block; position: absolute; left: 10px; bottom: 4px;line-height: 24px;" target="_blank" rel="noopener">
                                                                    '.REGIST_EMAIL_SEND_NEW_13.'<img src="https://img-en.fs.com/includes/templates/fiberstore/images/email/switch/white-arrow.png" style="margin-left: 5px; vertical-align: middle;">
                                                                </a>
                                                            </div>
                                                            <div style="padding: 2px 10px  8px;">

                                                                <p
                                                                    style="font-size: 13px;line-height: 22px;font-family:Open Sans,arial,sans-serif;color: #616265;margin-bottom: 7px;">
                                                                    '.REGIST_EMAIL_SEND_NEW_10.'
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td bgcolor="#fff" height="300"
                                                        style="border-collapse: collapse; line-height: 264px;background-color: #fff;"
                                                        width="10"></td>
                                                    <td align="center" bgcolor="#f7f7f7" height="300"
                                                        style="border-collapse:collapse;font-size:14px;color:#232323;line-height:22px;font-family:Open Sans,arial,sans-serif;"
                                                        width="47.65%">
                                                        <div
                                                            style="margin: 0;box-sizing: border-box;width: 100%;height: 100%;text-align: left;">
                                                            <div style="background: url(https://img-en.fs.com/includes/templates/fiberstore/images/email/login/support_2text.jpg); height: 204px; position: relative; top: 0;">
                                                                <a href="https://community.fs.com/'.$lang.'" style="text-decoration: none; color: #fff;font-size:14px; display: inline-block; position: absolute; left: 10px; bottom: 4px;line-height: 24px;" target="_blank" rel="noopener">
                                                                    '.REGIST_EMAIL_SEND_NEW_14.'<img src="https://img-en.fs.com/includes/templates/fiberstore/images/email/switch/white-arrow.png" style="margin-left: 5px; vertical-align: middle;">
                                                                </a>
                                                            </div>
                                                            <div style="padding: 2px 10px  8px;">

                                                                <p
                                                                    style="font-size: 13px;line-height: 22px;font-family:Open Sans,arial,sans-serif;color: #616265;margin-bottom: 7px;">
                                                                    '.REGIST_EMAIL_SEND_NEW_11.'
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>';


    if (trim ( EMAIL_SUBJECT ) != 'n/a')
        $send_to_email = 'support@fiberstore.com';
    $html=common_email_header_and_footer('',"");
    $html_msg['EMAIL_BODY'] = $html_body;
    $html_msg['EMAIL_FOOTER'] = $html['footer'];
    $email_subject = REGIST_EMAIL_SEND_THEME;

    sendwebmail($customer_name,$email_address,'个人注册邮件:'.date('Y-m-d H:i:s', time()),STORE_NAME,$email_subject,$html_msg,'regist_new');
}

//引入对应国家的邮件语言包
function get_email_langpac($customer_id = ''){
    global $db;
//$customer_id =$_SESSION['']
    if($customer_id==''){  //根据网站languages_id调用模板
        $languages_id=$_SESSION['languages_id'];
    }elseif($customer_id!='' && $customer_id != 'admin'){   //客户
        $sql='select language_id from customers where customers_id = '.(int)$customer_id;
        $result=$db->Execute($sql);
        $languages_id= ($result->RecordCount() > 0) ? $result->fields['language_id']:$_SESSION['languages_id'];
    }elseif ($customer_id == 'admin'){   //管理员
        $languages_id=1;
    }

    switch ((int)$languages_id){
        case 1: include_once(DIR_FS_CATALOG.DIR_WS_LANGUAGES.'email/english.php');break;
        case 2: include_once(DIR_FS_CATALOG.DIR_WS_LANGUAGES.'email/spanish.php');break;
        case 3: include_once(DIR_FS_CATALOG.DIR_WS_LANGUAGES.'email/france.php');break;
        case 4: include_once(DIR_FS_CATALOG.DIR_WS_LANGUAGES.'email/russian.php');break;
        case 5: include_once(DIR_FS_CATALOG.DIR_WS_LANGUAGES.'email/german.php');break;
        case 6: include_once(DIR_FS_CATALOG.DIR_WS_LANGUAGES.'email/chinese.php');break;
        case 8: include_once(DIR_FS_CATALOG.DIR_WS_LANGUAGES.'email/japan.php');break;
        case 14: include_once(DIR_FS_CATALOG.DIR_WS_LANGUAGES.'email/italy.php');break;
        default: include_once(DIR_FS_CATALOG.DIR_WS_LANGUAGES.'email/english.php');break;
    }

    //获取底部邮件warehouse
    if($languages_id==9 && au_warehouse($_SESSION['countries_code_21'],"country_code")==false){
        //UK站
        $warehouse_address = SEND_MAIL_2;
        $warehouse_address_url = 'https://www.google.com/maps/place/FS+United+Kingdom+-+Fiberstore/@52.483003,-1.9027787,17z/data=!3m1!4b1!4m5!3m4!1s0x4870bd2fe74ff8e3:0xe90a2b139db17b07!8m2!3d52.483003!4d-1.90059';
    }else{
        if(seattle_warehouse("country_code",$_SESSION['countries_code_21'])==true){
            //西雅图仓
            $warehouse_address = SEND_MAIL_4;
            $warehouse_address_url = 'https://www.google.com/maps/place/FS+-+Fiberstore/@39.661399,-75.5946574,17z/data=!3m1!4b1!4m5!3m4!1s0x89c703490657dc77:0x58499e823b0d8cfb!8m2!3d39.661399!4d-75.5924687';
        }elseif(all_german_warehouse("country_code",$_SESSION['countries_code_21'])==true) {
            //德国仓
            $warehouse_address = SEND_MAIL_6;
        }elseif(au_warehouse($_SESSION['countries_code_21'],"country_code")==true){
            //澳洲仓
            if($_SESSION['countries_code_21']=="NZ"){
                $warehouse_address = SEND_MAIL_8;
            }
        }else{
            //全球仓
            $warehouse_address = SEND_MAIL_10;
        }
    }

    return $warehouse_address;
}

//新版邮件公共头尾处理 $header_title 头部需要用到的标题;$warehouse_address 邮件底部仓库信息;
function common_email_header_and_footer($header_title,$first_message,$warehouse_address = '',$isReissueDe = false){
    if($_SESSION['languages_id'] == 8){
        $text ='<a style="color: #0070BC;text-decoration: none" href="javascript:;">$user_email</a>'. EMAIL_COMMON_FOOTER_NEW_02;
    }elseif($_SESSION['languages_id'] == 5){
        $text = sprintf(EMAIL_COMMON_FOOTER_NEW_02,'<a style="color: #0070BC;text-decoration: none" href="javascript:;">$user_email</a>');
    }else{
        $text = EMAIL_COMMON_FOOTER_NEW_02.'<a style="color: #0070BC;text-decoration: none" href="javascript:;">$user_email</a>.';
    }
    //判断德国仓底部展示德国公司信息
    if ($isReissueDe) {
        $deAddress = '<tr>
                        <td align="center" style="border-collapse: collapse;font-size: 12px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;">
                            '.EMAIL_COMMON_FOOTER_NEW_10 . date('Y') . ' <a style="color:#232323;text-decoration:none" href="' . zen_href_link(FILENAME_DEFAULT) . '" target="_blank">'.FS_CHECKOUT_FS_NAME_EU.'</a>
                            <br>
                            <span style="color: #232323;text-decoration: none">
                                '.FS_CHECKOUT_EMAIL_WAREHOUSE_EU.'
                            </span> <br>
                            <span style="color: #232323;text-decoration: none">
                                '.FS_PRINT_ORDER_TEL.'<a href="tel:'.FS_CHECKOUT_EMAIL_TEL_EU.'">'.FS_CHECKOUT_EMAIL_TEL_EU.'</a> | '.SAMPLE_EMAIL_04.'<a href="mailto:'.FS_CHECKOUT_EMAIL_EU.'">'.FS_CHECKOUT_EMAIL_EU.'</a>
                            </span>
                        </td>
                    </tr>';
    } else {
        $deAddress = ' <tr>
                            <td align="center" style="border-collapse: collapse;font-size: 12px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;">
                                '.EMAIL_COMMON_FOOTER_NEW_10 . date('Y') . ' <a style="color:#232323;text-decoration:none" href="' . zen_href_link(FILENAME_DEFAULT) . '" target="_blank">FS.COM</a>'.EMAIL_COMMON_FOOTER_NEW_09.'
                            </td>
                        </tr>';
    }
    $html_header = '<body>
                            <div style="width:100%!important;background:#fff">
                                <div style="display:none;font-size:1px;color:#232323;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden">'.$first_message.'</div>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f5f6f7">
                                    <tbody>
                                        <tr>
                                            <td style="border-collapse: collapse" width="100%" align="center" bgcolor="#f5f6f7">
                                                <table width="640" border="0" cellpadding="0" cellspacing="0">
                                                    <tbody>
                                                        <tr>
                                                            <td bgcolor="#f5f6f7" height="68" style="border-collapse: collapse" align="center">
                                                                <a href="'.zen_href_link('index').'" style="text-decoration: none">
                                                                    <img style="display:inline-block;text-decoration: none;outline: none;height: 38px;vertical-align: middle" src="'.HTTPS_IMAGE_SERVER.'includes/templates/fiberstore/images/email/Email-logo.png" alt="">
                                                                    <span style="color: #232323;font-size: 18px;color: #4c4948;display: inline-block;vertical-align: middle;height: 24px;line-height: 24px;font-family: Open Sans,arial,sans-serif;border-left: 1px solid #767474;margin-left: 10px;padding-left: 10px">'.$header_title.'</span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                              </table>';
    $html_footer = '<table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td bgcolor="#f5f6f7" style="border-collapse: collapse" height="20">

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td bgcolor="#f5f6f7" style="border-collapse: collapse;font-size: 12px;color: #232323;line-height: 22px;" align="center">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <tr>
                                                    <td align="center" style="border-collapse: collapse;font-size: 12px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;">
                                                        '.EMAIL_COMMON_FOOTER_NEW_01.'<a style="color: #0070BC;text-decoration: none" href="'.zen_href_link('index').'">FS.COM</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td bgcolor="#f5f6f7" style="border-collapse: collapse" height="20">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center" style="border-collapse: collapse;font-size: 12px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;">
                                                        <a style="display:inline-block;width:15px;height:15px;margin:0 5px;background:url(https://img-en.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position:0 0" href="'.sourceHtml('linkedin', false).'" target="_blank"></a>
                                                        <a style="display:inline-block;width:15px;height:15px;margin:0 5px;background:url(https://img-en.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position:-20px 0" href="'.sourceHtml('youtube', false).'" target="_blank"></a>
                                                        <a style="display:inline-block;width:15px;height:15px;margin:0 5px;background:url(https://img-en.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position:-40px 0" href="'.sourceHtml('facebook', false).'" target="_blank"></a>
                                                        <a style="display:inline-block;width:15px;height:15px;margin:0 5px;background:url(https://img-en.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position:-60px 0" href="'.sourceHtml('twitter', false).'" target="_blank"></a>
                                                        <a style="display:inline-block;width:15px;height:15px;margin:0 5px;background:url(https://img-en.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position:-80px 0" href="'.sourceHtml('twitter', false).'" target="_blank"></a>
                                                        <a style="display:inline-block;width:15px;height:15px;margin:0 5px;background:url(https://img-en.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position:-100px 0" href="'.sourceHtml('instagram', false).'" target="_blank"></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td bgcolor="#f5f6f7" style="border-collapse: collapse" height="20">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center" style="border-collapse: collapse;font-size: 12px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;">
                                                        <a style="text-decoration:none;font-size:12px;color:#232323;line-height:12px;display:inline-block;font-family: Open Sans,arial,sans-serif;padding-right: 6px;border-right: 1px solid #232323;margin-right: 4px;" href="'.zen_href_link('contact_us').'" target="_blank">'.EMAIL_COMMON_FOOTER_NEW_05.'</a>
                                                        <a style="text-decoration:none;font-size:12px;color:#232323;line-height:12px;display:inline-block;font-family: Open Sans,arial,sans-serif;padding-right: 6px;border-right: 1px solid #232323;margin-right: 4px;" href="'.zen_href_link('my_dashboard').'" target="_blank">'.EMAIL_COMMON_FOOTER_NEW_06.'</a>
                                                        <a style="text-decoration:none;font-size:12px;color:#232323;line-height:12px;display:inline-block;font-family: Open Sans,arial,sans-serif;padding-right: 6px;border-right: 1px solid #232323;margin-right: 4px;" href="'.zen_href_link('shipping_delivery').'" target="_blank">'.EMAIL_COMMON_FOOTER_NEW_07.'</a>
                                                        <a style="text-decoration:none;font-size:12px;color:#232323;line-height:12px;display:inline-block;font-family: Open Sans,arial,sans-serif;padding-right: 6px;" href="'.HTTPS_SERVER.reset_url('policies/day_return_policy.html').'" target="_blank">'.EMAIL_COMMON_FOOTER_NEW_08.'</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td bgcolor="#f5f6f7" style="border-collapse: collapse" height="15">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center" style="border-collapse: collapse;font-size: 12px;color: #232323;line-height: 18px;font-family: Open Sans,arial,sans-serif;">
                                                        '.$text.'
                                                        <br>
                                                        <a href="'.zen_href_link('email_subscription','$xxxx').'" style="color: #232323;text-decoration: none">'.EMAIL_COMMON_FOOTER_NEW_03.'</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td bgcolor="#f5f6f7" style="border-collapse: collapse" height="15">

                                                    </td>
                                                </tr>
                                                '.$deAddress.'
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#f5f6f7" style="border-collapse: collapse" height="15">

                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div style="display:none;white-space:nowrap;font:15px courier;line-height:0">
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table width="700" border="0" cellpadding="0" cellspacing="0" class="m_-7247573128365416932m_4216763956208593540table" id="m_-7247573128365416932m_4216763956208593540spacer-600" style="width:600px;max-width:600px;min-width:600px">
            <tbody>
            <tr>
                <td bgcolor="#ffffff"><img src="http://images.hello.zendesk.com/EloquaImages/clients/ZendeskInc/%7B123c1adb-7774-4470-b163-77f859ab86ff%7D_spacer.gif" border="0" width="700" height="1" hspace="0" vspace="0" style="width:700px;min-width:700px" class="CToWUd"></td>
            </tr>
            </tbody>
        </table>
        <table cellpadding="0" cellspacing="0" style="border:0px;padding:0px;margin:0px;display:none;float:left">
            <tbody>
            <tr>
                <td height="1" style="font-size:1px;line-height:1px;padding:0px">
                    <br>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</body>';
    $html = ['header'=> $html_header,'footer' => $html_footer];
    return $html;
}

//parker 密码重置成功之后的邮件
function sendPwdResetSuccessEmail($email_address,$email_username){
    $email_warehouse_info = get_email_langpac();
    $html = common_email_header_and_footer(RESET_PASS_SUCCESS_TITLE,RESET_PASS_SUCCESS_01,$email_warehouse_info);
    $html_msg['EMAIL_HEADER'] = $html['header'];
    $html_msg['EMAIL_FOOTER'] = $html['footer'];

    $html_body = '<table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 30px 20px 0" align="left">
                                    <a style="color:#232323;text-decoration: none;cursor:auto" href="javascript:;">'.RESET_PASS_SUCCESS_05.' '.$email_username.FS_EMAIL_COMMA.'</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse" height="15">

                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                                    '.RESET_PASS_SUCCESS_01.'
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse" height="30">

                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;text-align: center;">
                                    <a href="'.zen_href_link('login').'" 
                                      style="border-radius:2px;
                                      color: #0070BC;
                                      text-decoration:none;
                                      text-align:center;
                                      font-size:14px;
                                      display:inline-block;
                                      margin:0 auto;
                                      border:1px solid #0070BC;
                                      padding:10px 12px;
                                      font-family:Open Sans,arial,sans-serif;">'.RESET_PASS_SUCCESS_02.'</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse" height="30">

                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                                    '.RESET_PASS_SUCCESS_03.'
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse" height="15">

                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px 30px;" align="left">
                                    '.RESET_PASS_SUCCESS_04.'
                                </td>
                            </tr>
                            </tbody>
                        </table>';
    $html_msg['EMAIL_BODY'] = $html_body;
    sendwebmail($email_username,$email_address,'重置密码邮件:'.date('Y-m-d h:i:s',time()),STORE_NAME,RESET_PASS_SUCCESS_THEME,$html_msg,'default');
}

//parker 发送重置密码的邮件
function sendPwdForgottenEmail($cid,$email_address,$email_username,$rand_code){
    $url = zen_href_link('password_update','code='.$rand_code.'&cus='.$cid,"SSL");
    $email_warehouse_info = get_email_langpac();
    $html = common_email_header_and_footer(RESET_PASS_SEND_TITLE,RESET_PASS_SEND_06,$email_warehouse_info);
    $html_msg['EMAIL_HEADER'] = $html['header'];
    $html_msg['EMAIL_FOOTER'] = $html['footer'];

    $html_body = '<table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 23px 20px 0" align="left">
                                    <p style="color:#232323;text-decoration: none;cursor:auto" href="javascript:;">'.RESET_PASS_SEND_05.' '.$email_username.FS_EMAIL_COMMA.'</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>         
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                                    '.RESET_PASS_SEND_01.'
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse" height="30">

                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;text-align: center;">
                                  <a href="'.$url.'" 
                                    style="border-radius:2px;
                                    color: #0070BC;
                                    text-decoration:none;
                                    text-align:center;
                                    font-size:14px;
                                    display:inline-block;
                                    margin:0 auto;
                                    border:1px solid #0070BC;
                                    padding:10px 12px;
                                    font-family:Open Sans,arial,sans-serif;">'.RESET_PASS_SEND_02.'</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse" height="30">

                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                                    '.RESET_PASS_SEND_03.'
                                </td>
                            </tr>
                             <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse" height="10">

                                </td>
                            </tr>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;padding:0 20px;font-size: 14px;color: #232323;font-weight: 600;font-family: Open Sans,arial,sans-serif;line-height: 22px" align="left"> '.$rand_code.'
                                 </td>
                            </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse" height="15">

                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px 30px;" align="left">
                                    '.RESET_PASS_EXPIRE_TIME.'
                                </td>
                            </tr>
                            </tbody>
                        </table>
                         
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse" height="15">

                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px 30px;" align="left">
                                    '.RESET_PASS_SEND_04.'
                                </td>
                            </tr>
                            </tbody>
                        </table>';
    $html_msg['EMAIL_BODY'] = $html_body;
    sendwebmail($email_username,$email_address,'修改密码成功邮件:'.date('Y-m-d h:i:s',time()),STORE_NAME,RESET_PASS_SEND_THEME,$html_msg,'default');
}

//修改邮箱成功之后的邮件
function sendEmailModifySuccessEmail($email_address,$email_username,$old_email_address,$new_email_address){
    $email_warehouse_info = get_email_langpac();
    $title = '';
    if($_SESSION['languages_id'] == 5){
        $title = sprintf(RESET_EMAIL_SUCCESS_01,$email_address);
        $text1 = sprintf(RESET_EMAIL_SUCCESS_01,'<a style="color: #0070BC;text-decoration: none" href="javascript:;">'.$email_address.'</a>');
    }elseif($_SESSION['languages_id'] == 8){
        $title = RESET_EMAIL_SUCCESS_01.$email_address.FS_EMAIL_POINT;
        $text1 = RESET_EMAIL_SUCCESS_01.'<a style="color: #0070BC;text-decoration: none" href="javascript:;">'.$email_address.'</a>';
    }else{
        $title = RESET_EMAIL_SUCCESS_01.$email_address.FS_EMAIL_POINT;
        $text1 = RESET_EMAIL_SUCCESS_01.'<a style="color: #0070BC;text-decoration: none" href="javascript:;">'.$email_address.'</a>'.FS_EMAIL_POINT;
    }
    $html = common_email_header_and_footer(RESET_EMAIL_SUCCESS_TITLE,$title,$email_warehouse_info);
    $html_msg['EMAIL_HEADER'] = $html['header'];
    $html_msg['EMAIL_FOOTER'] = $html['footer'];
    if($_SESSION['languages_id'] == 8){
        $text = RESET_EMAIL_SUCCESS_06.'<a style="color: #0070BC;text-decoration: none" href="'.zen_href_link('my_dashboard').'">'.RESET_EMAIL_SUCCESS_04.'</a>'.RESET_EMAIL_SUCCESS_08;
    }else{
        $text = RESET_EMAIL_SUCCESS_06.'<a style="color: #0070BC;text-decoration: none" href="'.zen_href_link('my_dashboard').'">'.RESET_EMAIL_SUCCESS_04.'</a>.';
    }
    $html_body = ' <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 30px 20px 0" align="left">
                        <a style="color:#232323;text-decoration: none;cursor:auto" href="javascript:;">'.RESET_EMAIL_SUCCESS_02.' '.$email_username.FS_EMAIL_COMMA.'</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="15">

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            '.$text1.'
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="15">

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px;" align="left">
                            '.RESET_EMAIL_SUCCESS_03.'<a style="color: #0070BC;text-decoration: none" href="'.zen_href_link('my_dashboard').'">'.RESET_EMAIL_SUCCESS_04.'</a>'.RESET_EMAIL_SUCCESS_05.'
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="15">

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px;" align="left">
                            '.$text.'
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="15">

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px 30px;" align="left">
                            '.RESET_EMAIL_SUCCESS_07.'
                        </td>
                    </tr>
                    </tbody>
                </table>';
    $html_msg['EMAIL_BODY'] = $html_body;
    // EMAIL_FROM
    sendwebmail($email_username,$email_address,'修改邮箱成功邮件:'.date('Y-m-d h:i:s',time()),STORE_NAME,RESET_EMAIL_SUCCESS_THEME,$html_msg,'default');
    // 老邮箱发送邮件
    sendwebmail($email_username,$old_email_address,'修改邮箱成功邮件:'.date('Y-m-d h:i:s',time()),STORE_NAME,RESET_EMAIL_SUCCESS_THEME,$html_msg,'default');
}

// fairy 修改密码成功之后的邮件
function sendPwdModifySuccessEmail($email_address,$email_username){
    $html=zen_get_corresponding_languages_email_common();
    $html_msg['EMAIL_HEADER'] = $html['html_header'];
    $html_msg['EMAIL_FOOTER'] = $html['html_footer'];

    $emailContent1 = str_replace('EMAIL_USER_EMAIL',$email_address,FS_MODIFY_PWD_EAMIL_SUCCESS_CONTENT1);
    $emailTime = gmdate('m/d/Y H:i').'(GMT)';
    $emailContent1 = str_replace('EMAIL_TIME',$emailTime,$emailContent1);
    $emailCity = $_SESSION['user_ip_info']['ipCountryName'];
    $emailPlatform = getUserOS();
    $ip_address = getCustomersIP();

    $html_msg['EMAIL_BODY'] = '
            <table style="line-height: 20px;">
                <tr><td colspan="2" style="font-size:15px; font-weight:600;">'.FS_MODIFY_PWD_EAMIL_SUCCESS_TITLE.'</td></tr>
                <tr><td colspan="2" style="padding-top:20px;">'.EMAIL_BODY_COMMON_DEAR.' '.$email_username.''.FS_EMAIL_COMMA.'</td></tr>
                <tr><td colspan="2" style="padding-top:20px;">'.$emailContent1.'</td></tr>
                <tr>
                    <td colspan="2" style="padding-top:20px;">
                        '.EMAIL_BODY_COMMON_EAMIL_USER.'<a href="mailto:'.$email_address.'" style="color:#232323; text-decoration:none;"><b>'.$email_address.'</b></a><br />
                        '.EMAIL_BODY_COMMON_EAMIL_COUNTRY.': <b>'.$emailCity.'</b><br />
                        '.EMAIL_BODY_COMMON_PLATFORM.': <b>'.$emailPlatform.'</b><br />
                        '.EMAIL_BODY_COMMON_IP_ADDRESS.': <b>'.$ip_address.'</b>
                    </td>
                </tr>
                <tr><td colspan="2" style="padding-top:20px;">'.FS_MODIFY_PWD_EAMIL_SUCCESS_CONTENT2.'</td></tr>
                <tr><td colspan="2" style="padding-top:20px;">'.FS_MODIFY_PWD_EAMIL_SUCCESS_CONTENT3.'</td></tr>
                <tr><td colspan="2" style="padding-top:20px;">'.EMAIL_FOOTER_SINCERELY.'</td></tr>
                <tr><td colspan="2" style="padding-top:20px; padding-bottom:10px;">'.EMAIL_FOOTER_FS_SERVICE.'</td></tr>
            </table>';

    // EMAIL_FROM
    sendwebmail($email_username,$email_address,'修改密码成功邮件:'.date('Y-m-d h:i:s',time()),STORE_NAME,FS_MODIFY_PWD_EAMIL_SUCCESS_THEME,$html_msg,'default');
}

// fairy 修改邮箱成功之后,给销售发邮件
function sendEmailModifySuccessEmailToSaler($email_address,$email_username,$customer_username,$old_email_address,$new_email_address){
    $html=zen_get_corresponding_languages_email_common();
    $html_msg['EMAIL_HEADER'] = $html['html_header'];
    $html_msg['EMAIL_FOOTER'] = $html['html_footer'];
    $emailContent1 = str_replace('EMAIL_USER_EMAIL',$new_email_address,FS_MODIFY_EMAIL_SUCCESS_SALE_EAMIL_CONTENT1);
    $emailTime = gmdate('m/d/Y H:i').'(GMT)';
    $emailContent1 = str_replace('EMAIL_TIME',$emailTime,$emailContent1);
    $emailContent1 = str_replace('CUSTOMER_NAME',$customer_username,$emailContent1);

    $emailContent2 = str_replace('OLD_EMAIL',$old_email_address,FS_MODIFY_EMAIL_SUCCESS_SALE_EAMIL_CONTENT2);
    $emailContent3 = str_replace('NEW_EMAIL',$new_email_address,FS_MODIFY_EMAIL_SUCCESS_SALE_EAMIL_CONTENT3);

    $title = str_replace('CUSTOMER_NAME',$customer_username,FS_MODIFY_EMAIL_SUCCESS_SALE_EAMIL_TITLE);
    $html_msg['EMAIL_BODY'] = '
                <table style="line-height: 20px;">
                    <tr><td colspan="2" style="font-size:15px; font-weight:600;">'.$title.'</td></tr>
                    <tr><td colspan="2" style="padding-top:20px;">'.EMAIL_BODY_COMMON_DEAR.' '.$email_username.''.FS_EMAIL_COMMA.'</td></tr>
                    <tr><td colspan="2" style="padding-top:20px;">'.$emailContent1.'</td></tr>
                    <tr><td colspan="2" style="padding-top:20px;">'.$emailContent2.'</td></tr>
                    <tr><td colspan="2" style="padding-top:20px;">'.$emailContent3.'</td></tr>
                    <tr><td colspan="2" style="padding-top:20px;">'.EMAIL_FOOTER_SINCERELY.'</td></tr>
                    <tr><td colspan="2" style="padding-top:20px; padding-bottom:10px;">'.EMAIL_FOOTER_FS_SERVICE.'</td></tr>
                </table>';

    // EMAIL_FROM
    sendwebmail($email_username,$email_address,'修改邮箱成功给销售发邮件:'.date('Y-m-d H:i:s', time()),STORE_NAME,FS_MODIFY_EMAIL_SUCCESS_SALE_EAMIL_THEME,$html_msg,'default');
}

//前台Leave Feedback入口留言邮件
function send_service_admin_email($admin_id=0,$content,$email='',$name='',$subject)
{
    $msg = array();
    define('FS_TITLE_THEME', $subject);
    $html=common_email_header_and_footer(FS_TITLE_THEME,"");
    $msg['EMAIL_HEADER'] = $html['header'];
    $msg['EMAIL_FOOTER'] = $html['footer'];
    if ($content) {
        $msg['CUSTOMER_NAME'] = $content['customer_name'];
        $msg['SOURCE'] = $content['source'];
        $msg['COUNTRY'] = $content['country'];
        $msg['EMAIL_ADDRESS'] = $content['email'];
        $msg['PHONE_NUMBER'] = $content['phone'];
        $msg['URGENCE_LEVEL'] = $content['level'];
        $msg['CONTENTS'] = $content['content'];
    }
    if(!empty($content['email'])){
        $customer_id = zen_get_customer_id_of_input_email($content['email']);
        if(!empty($customer_id)){
            $admin_id = zen_get_customer_has_allot_to_admin($customer_id);
            if (!empty($admin_id)) {
                $admin_data = fs_get_data_from_db_fields_array(array('admin_name', 'admin_email'), 'admin', 'admin_id=' . $admin_id, 'limit 1');
                $admin_name = $admin_data[0][0];
                $admin_email = $admin_data[0][1];
                sendwebmail($admin_name,$admin_email,'Feedback留言入口销售提醒邮件:'.date('Y-m-d h:i:s',time()),STORE_NAME,FS_TITLE_THEME,$msg,'insert_enquiry_to_us');
            }
        }
    }
    //给客服发送提醒邮件，取消给销售发送邮件，统一在后台发送
    if ($email) {
        sendwebmail($name,$email,'Feedback留言入口客服提醒邮件:'.date('Y-m-d h:i:s',time()),STORE_NAME,FS_TITLE_THEME,$msg,'insert_enquiry_to_us');
    }
}


//新加坡on-site上门服务邮件
function get_mail_sg_on_site($data){
    $html_msg = array();
    $html=common_email_header_and_footer(FS_SEND_EMAIL_3,"");
    $procucts_info = '';
    if($data['products_ids']){
        $productIds = [];
        switch ($data['from']) {
            case 'order':
                $productIds = fs_get_datas('orders_products', 'orders_id=' . $data['orders_id'] . ' and products_id in (' . $data['products_ids'] . ')', 'products_id,products_quantity');
                break;
            case 'instock':
                $productIds = fs_get_datas('products_instock_shipping_info', 'products_instock_id=' . $data['products_instock_id'] . ' and products_id in (' . $data['products_ids'] . ')', 'products_id,products_num');
                break;
            default:
                break;
        }
        $products = [];
        foreach ($productIds as $product) {
            $products[] = [
                'id'    => $product['products_id'],
                'num'   => isset($product['products_quantity']) ? $product['products_quantity'] : $product['products_num'],
                'img'   => get_resources_img($product['products_id'], 80, 80, '', ''),
                'name'  => zen_get_products_name($product['products_id']),
                'href'  => zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . $product['products_id'])
            ];
        }
        if (zen_not_null($products)){
            foreach ($products as $product){
                $procucts_info .= '<table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding: 30px 0;">
                                <tbody>
                                <tr>
                                    <td width="60" valign="middle" style="border-collapse: collapse;">
                                        <a style="text-decoration: none" href="'.$product['href'].'">
                                            '.$product['img'].'
                                        </a>
                                    </td>
                                    <td valign="middle" style="border-collapse: collapse;padding-left: 20px;color: #333;text-decoration: none;font-size: 14px;font-family: Open Sans,arial,sans-serif;line-height: 22px">
                                        <a style="color: #333;text-decoration: none;font-size: 14px;line-height: 22px;font-family: Open Sans,arial,sans-serif;margin-bottom: 5px;display: inline-block" href="'.$product['href'].'">
                                            '.$product['name'].'
                                            <span style="color: #999;font-family: Open Sans,arial,sans-serif;">#'.$product['id'].'</span>
                                        </a>
                                        <br>
                                        Qty:'.$product['num'].'
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td bgcolor="#fff" style="border-collapse: collapse;border-top: 1px solid #f7f8f9">
                                    </td>
                                </tr>
                                </tbody>
                            </table>';
            }
            $order_number = 'Order Number: '.$data['orders_number'].' <br />';
        }
    }
    $html_msg['EMAIL_HEADER'] = $html['header'];
    $html_msg['EMAIL_FOOTER'] = $html['footer'];
    require_once(DIR_WS_CLASSES . 'SGInstallerServiceClass.php');
    $showtime = SGInstallerServiceClass::sgInstallTimeTrans($data['appointment_start_time']);
    $html_msg['EMAIL_BODY'] = '
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 30px 20px 0" align="left">
                            Dear '.$data['customer_name'].',
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="20">

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            We\'ve received your request for on-site technical service. Our technical specialist will contact you before heading to your address.
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="20">

                        </td>
                    </tr>
                    </tbody>
                </table>
                
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                           Any changes, please contact us at <a style="text-decoration: none;color: #0070bc;">+(65) 6443 7951</a> or email <a style="text-decoration: none;color: #0070bc;" href="mailto:sg@fs.com">sg@fs.com</a>.
                        </td>
                    </tr>
                    </tbody>
                </table>
                
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="20">

                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            '.$order_number.'
                            Contact Info: '.$data['customer_name'].' <br />
                            Phone No: +(65) '.$data['customer_phone'].' <br />
                            Email Address: <a style="text-decoration: none;color: #0070bc;" href="mailto:'.$data['customer_email'].'">'.$data['customer_email'].'</a> <br />
                            Scheduled time: '.$showtime.' <br />
                        </td>
                    </tr>
                    </tbody>
                </table>
                
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="30">
                        </td>
                    </tr>
                    </tbody>
                </table>
                
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;padding: 0 20px;border-top: 1px solid #f7f8f9;border-bottom: 1px solid #f7f8f9">
                            '.$procucts_info.'
                        </td>
                    </tr>
                    </tbody>
                </table>';
    $title = 'FS - Your On-site Technical Service request received';
    sendwebmail($data['customer_name'],$data['customer_email'],'新加坡On-site上门服务邮件:'.date('Y-m-d h:i:s',time()),STORE_NAME,$title,$html_msg,'default');
}

//新加坡预约安装邮件
function get_mail_sg_installation($order_id){
    if($order_id){
        global $db;
        $orders_info = $db->getAll("select delivery_name,customers_email_address,delivery_lastname,delivery_country,delivery_street_address,orders_number from orders where orders_id='".$order_id."' limit 1");

        if($orders_info[0]['orders_number']){
            //开始时间
            $appointment_start_time = $db->Execute("select appointment_start_time from customer_appointment_info where orders_number ='".$orders_info[0]['orders_number']."'")->fields['appointment_start_time'];
            if($appointment_start_time) {
                require_once(DIR_WS_CLASSES . 'SGInstallerServiceClass.php');
                $showtime = SGInstallerServiceClass::sgInstallTimeTrans($appointment_start_time);
                $name = $orders_info[0]['delivery_name'] . ' ' . $orders_info[0]['delivery_lastname'];
                $html_msg = array();
                get_email_langpac();
                $html = common_email_header_and_footer(FS_SG_EMAIL_26, "");
                $html_msg['EMAIL_HEADER'] = $html['header'];
                $html_msg['EMAIL_FOOTER'] = $html['footer'];
                $html_msg['EMAIL_BODY'] = '<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 30px 20px 0" align="left">
                             '.FS_EMAIL_TO_US_DEAR . $name . FS_EMAIL_COMMA . '
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="20">

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            '.FS_SG_EMAIL_10.'<a style="color: #0070bc;text-decoration: none" href="' . zen_href_link('account_history_info', 'orders_id=' . $order_id, 'SSL') . '">#' . $orders_info[0]['orders_number'] . '</a>'.FS_SG_EMAIL_11.'
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="20">
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            '.FS_SG_EMAIL_12.'
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="20">
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            '.FS_SG_EMAIL_15.' ' . $name . FS_EMAIL_COMMA . ' <br />
                            '.FS_SG_EMAIL_16.' +(65) 6443 7951 <br/>
                            '.FS_SG_EMAIL_17.' ' . $orders_info[0]['delivery_street_address'] . ' <br/>
                            '.FS_SG_EMAIL_18.' ' . $showtime .' <br />
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="30">
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px 30px;" align="left">
                            '.FS_SG_EMAIL_13.'
                            <br>
                            '.FS_SG_EMAIL_14.'
                        </td>
                    </tr>
                    </tbody>
                </table>';
                $title = FS_SG_EMAIL_19. $orders_info[0]['orders_number'].FS_SG_EMAIL_20;
                sendwebmail($name, $orders_info[0]['customers_email_address'], '安装时间前两个小时提醒邮件:' . date('Y-m-d h:i:s', time()), STORE_NAME, $title, $html_msg, 'default');
            }
        }
    }
}

//新加坡预约安装未付款邮件
function get_mail_sg_payment($order_id){
    if($order_id){
        global $db,$currencies;
        $orders_info = $db->getAll("select delivery_name,customers_email_address,delivery_lastname,delivery_country,delivery_street_address,orders_number from orders where orders_id='".$order_id."' limit 1");
        $br_html="";
        if($_SESSION['languages_code']=='en'){
            $br_html ="<br>";
        }
        if($orders_info[0]['orders_number']){
            //开始时间
            $appointment_start_time = $db->Execute("select appointment_start_time from customer_appointment_info where orders_number ='".$orders_info[0]['orders_number']."'")->fields['appointment_start_time'];
            if($appointment_start_time){
                $name = $orders_info[0]['delivery_name'] . ' ' . $orders_info[0]['delivery_lastname'];
                $html_msg = array();
                get_email_langpac();
                $html=common_email_header_and_footer(FS_SG_EMAIL_27,"");
                $all_price = $order_id ? zen_get_order_cost_by_order($order_id)['ot_total'] : 0;
                $html_msg['EMAIL_HEADER'] = $html['header'];
                $html_msg['EMAIL_FOOTER'] = $html['footer'];
                $html_msg['EMAIL_BODY'] = '<table width="640" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 30px 20px 0" align="left">
                                 '.FS_EMAIL_TO_US_DEAR.$name.FS_EMAIL_COMMA.'
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table width="640" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#fff" style="border-collapse: collapse" height="20">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table width="640" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">'.FS_SG_EMAIL_21.' <a style="color: #0070bc;text-decoration: none" href="'.zen_href_link('account_history_info','orders_id='.$order_id,'SSL').'">#'.$orders_info[0]['orders_number'].'</a>'.$br_html.' ('.$all_price.')'.FS_SG_EMAIL_22.'</td>
                        </tr>
                        <tr>
                            <td bgcolor="#fff" style="border-collapse: collapse" height="20">
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                             '.FS_SG_EMAIL_23.'
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table width="640" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#fff" style="border-collapse: collapse" height="30">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table width="640" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px 30px;" align="left">
                                '.FS_SG_EMAIL_13.'
                                <br>
                                 '.FS_SG_EMAIL_14.'
                            </td>
                        </tr>
                        </tbody>
                    </table>';
                $title=FS_SG_EMAIL_19.$orders_info[0]['orders_number'].' '.FS_SG_EMAIL_28;
                sendwebmail($name,$orders_info[0]['customers_email_address'],'新加坡上门安装未付款提醒邮件:'.date('Y-m-d h:i:s',time()),STORE_NAME,$title,$html_msg,'default');
            }
        }
    }
}

function get_mail_site_and_country(){
    $languages_code =$_SESSION['languages_code'];
    $country_iso_code = $_SESSION['countries_iso_code'];
    $country_iso_code = strtolower($country_iso_code);
    $service_email='';
    if (in_array($country_iso_code,array('de'))){
        $service_email = 'de@fs.com';
    }elseif (in_array($country_iso_code,array('ar','bo','cl','co','dm','ec','gt','gy','hn','jm','mx','pa','py','pe','uy','sv','cr'))){
        $service_email = 'mx@fs.com';
    }elseif (in_array($country_iso_code,array('es'))){
        $service_email = 'es@fs.com';
    }elseif (in_array($country_iso_code,array('fr'))){
        $service_email = 'fr@fs.com';
    }elseif (in_array($country_iso_code,array('jp'))){
        $service_email = 'jp@fs.com';
    }elseif (in_array($country_iso_code,array('it'))){
        $service_email = 'italy@fs.com';
    }elseif (in_array($country_iso_code,array('am','az','ge','kz','kg','ru','tj','tm','ua','uz'))){
        $service_email = 'ru@fs.com';
    }else{
        if($languages_code == 'en'){
            if(in_array($country_iso_code,array('us','ca', 'pr'))){
                $service_email = 'us@fs.com';
            }else{
                $service_email = 'sales@fs.com';
            }

        }
        if($languages_code == 'sg'){
            if(in_array($country_iso_code,array('bd','bt','bn','kh','tl','hk','in','id','kr','la','my','mv','mn','mm','np','pk','ph','sg','lk','tw','th','vn'))){
                $service_email = 'sg@fs.com';
            }else{
                $service_email = 'sales@fs.com';
            }
        }
        if(empty($service_email)){
            switch ($languages_code){
                case "uk":
                    $service_email = 'uk@fs.com';
                    break;

                case "au":
                    $service_email = 'au@fs.com';
                    break;


                case "de":
                    $service_email = 'de@fs.com';
                    break;

                case "dn":
                    $service_email = 'eu@fs.com';
                    break;

                case "fr":
                    $service_email = 'fr@fs.com';
                    break;

                case "mx":
                    $service_email = 'mx@fs.com';
                    break;

                case "es":
                    $service_email = 'es@fs.com';
                    break;

                case "ru":
                    $service_email = 'ru@fs.com';
                    break;

                case "jp":
                    $service_email = 'jp@fs.com';
                    break;

                case 'it':
                    $service_email = 'italy@fs.com';
                    break;
            }
        }
    }
    return $service_email;
}


/**
 * 发送售后邮件
 * @param $rma_res
 * @param $orders_id
 * @param $cs_num
 */
function sendRmaEmail($rma_res, $orders_id, $cs_num)
{
    global $currencies;
    global $db;
    get_email_langpac();

    $audit_type = $rma_res['audit_type'];
    $rma_type = $rma_res['rma_type'];
    $rma_products = $rma_res['products'];
    $total_price = $rma_res['total_price'];
    $title_info = '';
    define('SERVICE_SUBJECT', sprintf(EMAIL_RMA_SUCCESS_TITLE, $cs_num));

    $sql = 'SELECT purchase_order_num,orders_number,currency,currency_value,delivery_suburb,delivery_state,delivery_company,delivery_name,delivery_country,delivery_telephone,delivery_street_address,delivery_city,delivery_postcode,delivery_lastname,billing_name,billing_suburb,billing_state,billing_company,billing_lastname,billing_street_address,billing_city,billing_postcode,billing_country,billing_telephone
    FROM orders
    WHERE orders_id ='.(int)$orders_id;

    $orders_arr = $db->getAll($sql);
    $orders_info = $orders_arr[0];
    $purchase_order_num = $orders_info['purchase_order_num'];
    $order_number = $orders_info['orders_number'];
    $currency = $orders_info['currency'];
    $currency_value = $orders_info['currency_value'];

    if($cs_num){
        $refund_sql = 'SELECT entry_firstname,entry_lastname,entry_company,entry_street_address,entry_suburb,entry_city,entry_postcode,entry_state,entry_country_id,entry_telephone from customers_service cs LEFT JOIN customers_service_address csa USING(customers_service_id) WHERE cs.service_number="'.$cs_num.'" AND csa.type=1';
        $refund_data = $db->getAll($refund_sql);
        //退换货收货地址
        $orders_info['refund_shipping_address'] = $refund_data[0];
    }

    $total_price = $currencies->total_format($total_price, true, $currency, $currency_value);
    $po_html = '';
    if (!empty($purchase_order_num)) {
        $po_html = '(' . FS_SEND_EMAIL_71 . '#<a href="javascript:;" style="color: #232323;text-decoration: none">' . $purchase_order_num . '</a>)';
    }

    if($audit_type == 1) {

        $email_title = FS_SEND_EMAIL_3;
        switch ($rma_type) {
            case 1:
                $title = FS_SEND_EMAIL_32;
                $title_info = FS_SEND_EMAIL_33;
                $email_text2 = FS_SEND_EMAIL_41;
                $email_text3 = FS_SEND_EMAIL_44;
                if ($_SESSION['languages_code'] == 'de') $email_title = 'RMA-Antrag erhalten';
                break;
            case 2:
                $title = FS_SEND_EMAIL_34;
                $title_info = FS_SEND_EMAIL_35;
                $email_text2 = FS_SEND_EMAIL_42;
                $email_text3 = FS_SEND_EMAIL_45;
                if ($_SESSION['languages_code'] == 'de') $email_title = 'RMA-Antrag erhalten';
                break;
            case 3:
                $title = FS_SEND_EMAIL_36;
                $title_info = FS_SEND_EMAIL_37;
                $email_text2 = FS_SEND_EMAIL_43;
                $email_text3 = FS_SEND_EMAIL_46;
                if ($_SESSION['languages_code'] == 'de') $email_title = 'RMA-Antrag erhalten';
                break;
        }


        $html_msg['EMAIL_BODY'] = get_service_artificial_email_html($email_text2, $po_html,ucfirst($_SESSION['customer_first_name']),$orders_id, $order_number, $email_text3);

    }else {

        if ($_SESSION['languages_code'] == 'jp') {
            $title_info = "注文" . $order_number . "注文に対する返品を完了するには、次の手順に従ってください。";
        } else {
            $title_info = FS_SEND_EMAIL_39 . $order_number . ".";
        }
        $email_title = FS_SEND_EMAIL_40;
        $title = FS_SEND_EMAIL_38;

        switch ($rma_type) {
            case 1:
                $email_tx = $_SESSION['languages_code'] == "fr" ? '' : FS_SEND_EMAIL_47;
                $email_text1 = FS_SEND_EMAIL_48;
                $email_text2 = FS_SEND_EMAIL_49;
                $text4 = FS_SEND_EMAIL_50 . $total_price . FS_SEND_EMAIL_51;
                if ($_SESSION['languages_code'] == "ru") {
                    $text4 = ' После получения возвращенного товара мы вернем вам '. $total_price .' через ваш оригинальный способ оплаты в течение 1 рабочего дня. Деньги будут зачислены на ваш счет в течение недели.';
                }
                $email_shipping = getRmaEmailHtmlOne($email_tx, $total_price, $currency, $currency_value);

                break;
            case 2:
            case 3:

                if ($_SESSION['languages_code'] == "jp") {
                    $email_text1 = FS_SEND_EMAIL_48;
                    if($rma_type == 2){
                        $email_text2 = str_replace('返金', '交換', FS_SEND_EMAIL_49);
                    }else{
                        $email_text2 = str_replace('返金', 'メンテナンス', FS_SEND_EMAIL_49);
                    }
                } else {
                    $email_text1 = FS_SEND_EMAIL_61;
                    $email_text2 = FS_SEND_EMAIL_62;
                }

                $email_tx = $_SESSION['languages_code'] == "fr" ? '' : ($rma_type == 2 ? FS_SEND_EMAIL_60 : FS_SEND_EMAIL_64);
                $email_tx = $email_tx .' '. FS_SEND_EMAIL_68;
                if ($rma_type == 2 &&  $_SESSION['languages_code'] == "ru") {
                    $email_tx = 'Детали замены';
                } elseif ($rma_type == 3 &&  $_SESSION['languages_code'] == "ru") {
                    $email_tx = 'Детали технического обслуживания';
                } elseif ($rma_type == 2 &&  $_SESSION['languages_code'] == "de") {
                    $email_tx = 'Übersicht über die umgetauschte Artikel';
                }
                $text4 = $rma_type == 2 ? FS_SEND_EMAIL_63 : FS_SEND_EMAIL_67;

                $email_shipping = getRmaEmailHtmlTwo($email_tx, $orders_info);

                break;
        }
        $html_msg['EMAIL_BODY'] = get_service_automatic_email_html($email_tx, $email_text1, $email_text2, ucfirst($_SESSION['customer_first_name']), $orders_id, $email_shipping, $order_number, $po_html, $text4, $rma_type);

    }

    $html = common_email_header_and_footer($email_title, $title_info);
    $html_msg['EMAIL_HEADER'] = $html['header'];
    $html_msg['EMAIL_FOOTER'] = $html['footer'];

    $count = count($rma_products) - 1;
    foreach ($rma_products as $key => $products){

        $products_id = $products['products_id'];
        $orders_products_id = $products['orders_products_id'];
        $image = get_resources_img($products_id, 60, 60);
        $attrHtml = getRmaEmailattrHtml($orders_products_id);
        $apply_qty = $products['products_num'];

        //组装邮件产品Html结构
        $html_msg['EMAIL_BODY'] .= getRmaEmailProductsHtml($products_id, $image, $attrHtml, $apply_qty, $key, $count);
    }

    $to_name = ucfirst($_SESSION['customer_first_name']) . ' ' . ucfirst($_SESSION['customer_last_name']);
    $to_email = $_SESSION['customers_email_address'];
    $admin_id = zen_get_customer_has_allot_to_admin($_SESSION['customer_id']);

    sendwebmail($to_name, $to_email, '退换货邮件发送给客户' . date('Y-m-d h:i:s', time()), STORE_NAME, $title, $html_msg, 'default');
    if ($admin_id) {
        $admin_data = fs_get_data_from_db_fields_array(array('admin_name', 'admin_email'), 'admin', 'admin_id=' . $admin_id, 'limit 1');
        $admin_name = $admin_data[0][0];
        $admin_email = $admin_data[0][1];

        sendwebmail($admin_name, $admin_email, '退换货邮件发送给销售' . date('Y-m-d h:i:s', time()), STORE_NAME, $title, $html_msg, 'default');
    }

}

/**
 * 获取邮件html结构
 * @param $email_tx
 * @param $total_price
 * @param $currency
 * @param $currency_value
 * @return mixed
 */
function getRmaEmailHtmlOne($email_tx, $total_price, $currency, $currency_value)
{
    global $currencies;

    $email_html = '<table width="640" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                    <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 18px;color: #232323;font-weight: 600;font-family: Open Sans,arial,sans-serif;line-height: 24px" align="center">
' . $email_tx . FS_SEND_EMAIL_52 . '
                    </td>
                </tr>
                </tbody>
            </table>
            <table width="640" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                    <td bgcolor="#ffffff" style="border-collapse: collapse;" height="20">
                    </td>
                </tr>
                </tbody>
            </table>
            <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 0 20px;border-collapse: collapse;" align="left">
                            <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse: collapse">
                                <tbody>
                                <tr>
                                    <td width="50%" style="border-collapse: collapse;">
                                        <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse: collapse">
                                            <tbody>
                                            <tr>
                                                <td width="60%" style="border-collapse: collapse;font-size: 14px;color: #999;font-family:Open Sans,arial,sans-serif;">
    ' . FS_SEND_EMAIL_53 . '
                                                </td>
                                                <td width="40%" align="right" style="border-collapse: collapse;font-size: 14px;color: #232323;font-weight: 600;font-family:Open Sans,arial,sans-serif;padding-right: 10px">
    ' . $total_price . '
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="100%" colspan="2" style="border-collapse: collapse;" height="10">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="60%" style="border-collapse: collapse;font-size: 14px;color: #999;font-family:Open Sans,arial,sans-serif;">
    ' . FS_SEND_EMAIL_54 . '
                                                </td>
                                                <td width="40%" align="right" style="border-collapse: collapse;font-size: 14px;color: #232323;font-weight: 600;font-family:Open Sans,arial,sans-serif;padding-right: 10px">
    ' . $currencies->total_format(0, true,$currency, $currency_value) . '
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="100%" colspan="2" style="border-collapse: collapse;border-bottom: 1px solid #f7f7f7" height="5">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="100%" colspan="2" style="border-collapse: collapse;" height="5">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="60%" style="border-collapse: collapse;font-size: 14px;color: #999;font-family:Open Sans,arial,sans-serif;">
    ' . FS_SEND_EMAIL_55 . '
                                                </td>
                                                <td width="40%" align="right" style="border-collapse: collapse;font-size: 14px;color: #232323;font-weight: 600;font-family:Open Sans,arial,sans-serif;padding-right: 10px">
    ' . $total_price . '
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td width="50%" style="box-sizing: border-box;font-family: Open Sans,arial,sans-serif;font-size: 14px;color: #232323;padding:10px 20px;background: url(\'https://img-en.fs.com/includes/templates/fiberstore/images/email/unnamed11-left.png\') no-repeat left center #e5e5e5">
                                        <span style="display: inline-block">
    ' . FS_SEND_EMAIL_56 . '
                                        </span>
                                        <br>
                                        <span style="display: inline-block;margin-bottom: 15px;font-weight: 600">
    ' . FS_SEND_EMAIL_57 . $total_price . '
                                        </span>
                                        <br>';

    if ($_SESSION['languages_code'] == 'jp') {
        $email_html .= '<span style="display: inline-block">
            ' . FS_SEND_EMAIL_58 . ' <a style="color: #232323;text-decoration: none" href="' . HTTPS_SERVER . reset_url('policies/day_return_policy.html') . '">ここ</a>をクリックしてください。
          </span>';
    } else {
        $email_html .= '<span style="display: inline-block">
            ' . FS_SEND_EMAIL_58 . ' <a style="color: #232323;text-decoration: none" href="' . HTTPS_SERVER . reset_url('policies/day_return_policy.html') . '">' . FS_SEND_EMAIL_59 . '</a>
          </span>';
    }

    $email_html .= '            </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>';

    return $email_shipping;
}

/**
 * 发送消费税邮件
 * @param array $taxArray
 */
function sendTaxExemptionEmail($taxArray)
{
    if ($taxArray) {
        get_email_langpac();
        $title_info = FS_TAX_EMAIL_01;
        $tx_info = FS_TAX_EMAIL_02;
        $html=common_email_header_and_footer($title_info,$tx_info);
        $html_msg = '';
        $html_msg['EMAIL_HEADER'] = $html['header'];
        $html_msg['EMAIL_FOOTER'] = $html['footer'];
        $html_msg['EMAIL_BODY'] = '<table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td bgcolor="#fff" style="border-collapse: collapse" height="45">

                                    </td>
                                </tr>
                            </tbody>
                        </table> 
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td bgcolor="#fff" style="border-collapse: collapse" align="center">
                                        <span
                                            style="font-size:26px;color:#232323;line-height: 26px;display: inline-block;vertical-align: middle;">
                                            '.FS_TAX_EMAIL_03.'
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td bgcolor="#fff" style="border-collapse: collapse" height="45">

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td bgcolor="#fff" style="border-collapse: collapse;padding: 0 20px;">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <tr>
                                                    <td
                                                        style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 24px;font-family:Open Sans,arial,sans-serif;">
                                                        <span
                                                            style="color: #232323;display: inline-block;margin-bottom: 3px;font-weight: 600;">
                                                            '.FS_ACCOUNT_NEW.'
                                                            <a href="'.EMAIL_MY_ACCOUNT_URL.'" style="color: #0070BC;text-decoration: none">
                                                            '.$taxArray['customers_new'].'
                                                            </a>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 24px;font-family:Open Sans,arial,sans-serif;">
                                                        <span
                                                            style="color: #232323;display: inline-block;margin-bottom: 3px;font-weight: 600;">
                                                            '.FS_ACCOUNT_CASE_E_MAIL.' 
                                                            '.$taxArray['customers_email'].'
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 24px;font-family:Open Sans,arial,sans-serif;">
                                                        <span
                                                            style="color: #232323;display: inline-block;margin-bottom: 3px;font-weight: 600;">
                                                            '.FS_TAX_EMAIL_04.'
                                                            '.$taxArray['state'].'
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td bgcolor="#fff" style="border-collapse: collapse" height="35">

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td bgcolor="#fff"
                                        style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 24px;font-family: Open Sans,arial,sans-serif;padding: 0 20px"
                                        align="left">
                                        '.FS_TAX_EMAIL_05.'
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td bgcolor="#fff" style="border-collapse: collapse;" height="25">

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td bgcolor="#fff"
                                        style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 24px;font-family: Open Sans,arial,sans-serif;padding: 0 20px"
                                        align="center">
                                        <a style="font-size: 14px;display: inline-block;text-decoration: none;padding: 10px 20px;border: 1px solid #0681d3;border-radius:2px;color: #007FC2;"
                                            href="'.zen_href_link('tax_exemption').'" target="_blank">
                                            '.FS_TAX_EMAIL_06.'
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td bgcolor="#fff" style="border-collapse: collapse;" height="25">

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td bgcolor="#fff"
                                        style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 24px;font-family: Open Sans,arial,sans-serif;padding: 0 20px"
                                        align="left">
                                        '.FS_TAX_EMAIL_07.'
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td bgcolor="#fff" style="border-collapse: collapse;" height="15">

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td bgcolor="#fff"
                                        style="border-collapse:collapse;background-color: #fff;padding: 0 10px;">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <tr>
                                                    <td bgcolor="#fff" align="center" width="50%"
                                                        style="border-collapse:collapse;font-size:14px;color:#232323;line-height:22px;font-family:Open Sans,arial,sans-serif;">
                                                        <div
                                                            style="margin: 0;padding: 30px 20px;box-sizing: border-box;width: 100%;height: 100%;text-align: center;">
                                                            <img src="https://img-en.fs.com/includes/templates/fiberstore/images/email/network-solution-emil-icon02.png"
                                                                style="display: block;margin: 0 auto 25px;" alt="">
                                                            <p
                                                                style="font-size: 14px;line-height: 24px;font-family:Open Sans,arial,sans-serif;color: #232323;margin-bottom: 10px;">
                                                                '.COMMON_SERVICE_04.'</p>
                                                            <p
                                                                style="font-size: 13px;line-height: 22px;font-family:Open Sans,arial,sans-serif;color: #616265;margin-bottom: 10px;height: 54px;margin-bottom: 15px;">
                                                                '.COMMON_SERVICE_05.'</p>
                                                            <a href="'.zen_href_link(FILENAME_CONTACT_US).'" target="_blank"
                                                                style="text-decoration: none;color: #0070bc;font-size: 14px;font-family:Open Sans,arial,sans-serif;line-height: 24px;">
                                                                '.COMMON_SERVICE_06.'
                                                                <img style="margin-left:5px;vertical-align: middle;" src="https://img-en.fs.com/includes/templates/fiberstore/images/email/network-solution-emil-icon05.jpg">
                                                                </a>
                                                        </div>
                                                    </td>

                                                    <td bgcolor="#fff" align="center" width="50%"
                                                        style="border-collapse:collapse;font-size:14px;color:#232323;line-height:22px;font-family:Open Sans,arial,sans-serif">
                                                        <div
                                                            style="margin: 0;padding: 30px 20px;box-sizing: border-box;width: 100%;height: 100%;text-align: center;">
                                                            <img src="https://img-en.fs.com/includes/templates/fiberstore/images/email/network-solution-emil-icon03.png"
                                                                style="display: block;margin: 0 auto 32px;" alt="">
                                                            <p
                                                                style="font-size: 14px;line-height: 24px;font-family:Open Sans,arial,sans-serif;color: #232323;margin-bottom: 10px;">
                                                                '.FS_AMP_FOOTER_01.'</p>
                                                            <p
                                                                style="font-size: 13px;line-height: 22px;font-family:Open Sans,arial,sans-serif;color: #616265;margin-bottom: 10px;height: 54px;margin-bottom: 15px;">
                                                                '.FS_CONTACT_GET_SUPPORT.'</p>
                                                            <a href="'. HTTPS_SERVER . reset_url('live_chat_service_mail.html').'" target="_blank"
                                                                style="text-decoration: none;color: #0070bc;font-size: 14px;font-family:Open Sans,arial,sans-serif;line-height: 24px;">
                                                                '.COMMON_SERVICE_13.'
                                                                <img style="margin-left:5px;vertical-align: middle;" src="https://img-en.fs.com/includes/templates/fiberstore/images/email/network-solution-emil-icon05.jpg"></a>
                                                        </div>
                                                    </td>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>';
        sendwebmail($taxArray['customers_name'], $taxArray['customers_email'],'消费税入口客户提醒邮件:'.date('Y-m-d h:i:s',time()),STORE_NAME, $tx_info, $html_msg,'default');
        if ($taxArray['admin_email']) {
            sendwebmail($taxArray['admin_name'], $taxArray['admin_email'],'消费税入口销售提醒邮件:'.date('Y-m-d h:i:s',time()),STORE_NAME, $tx_info, $html_msg,'default');
        }
    }
}

/**
 * 获取邮件html结构
 * @param $email_tx
 * @param $orders_info
 * @return string
 */
function getRmaEmailHtmlTwo($email_tx, $orders_info)
{
    global $currencies;

    $delivery_suburb = $orders_info['delivery_suburb'] ? ',<br>' . $orders_info['delivery_suburb'] . '<br>' : "<br>";
    $billing_suburb = $orders_info['billing_suburb'] ? ',<br>' . $orders_info['billing_suburb'] . '<br>' : "<br>";
    $delivery_state = $orders_info['delivery_state'] ? $orders_info['delivery_state'] . ', ' : "";
    $billing_state = $orders_info['billing_state'] ? $orders_info['billing_state'] . ', ' : "";
    $delivery_company = $orders_info['delivery_company'] ? '<br>' . $orders_info['delivery_company'] : "";
    $billing_company = $orders_info['billing_company'] ? '<br>' . $orders_info['billing_company'] : "";
    $delivery_country_name = $orders_info['delivery_country'];
    //退换货收货地址
    if($orders_info['refund_shipping_address']){
        $delivery_suburb = $orders_info['refund_shipping_address']['entry_suburb'] ? ',<br>' . $orders_info['refund_shipping_address']['entry_suburb'] . '<br>' : "<br>";
        $delivery_state = $orders_info['refund_shipping_address']['entry_state'] ? $orders_info['refund_shipping_address']['entry_state'] . ', ' : "";
        $delivery_company = $orders_info['refund_shipping_address']['entry_company'] ? '<br>' . $orders_info['refund_shipping_address']['entry_company'] : "";
        $delivery_country_name = getLanguageCountriesName($orders_info['refund_shipping_address']['entry_country_id']);
    }

    $email_shipping = '<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 18px;color: #232323;font-weight: 600;font-family: Open Sans,arial,sans-serif;line-height: 24px" align="center">
                            ' . $email_tx . '
                        </td>
                    </tr>
                    </tbody>
                </table>
                       <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;" height="20">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                       <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;padding: 0 20px;">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;">
                                            <span style="color: #818181;display: inline-block;margin-bottom: 3px">
                                                ' . FS_SEND_EMAIL_69 . '
                                            </span>
                                        <br>
                                        <a style="color: #232323;text-decoration: none" href="javascript:;">
                                            ' . ucwords($orders_info['refund_shipping_address']['entry_firstname']) . ' ' . ucwords($orders_info['refund_shipping_address']['entry_lastname']) . '
                                            ' . $delivery_company . '
                                            <br>
                                            ' . $orders_info['refund_shipping_address']['entry_street_address'] . $delivery_suburb . '
                                            ' . $orders_info['refund_shipping_address']['entry_city'] . ', ' . $orders_info['refund_shipping_address']['entry_postcode'] . '
                                            <br>' . $delivery_state . $delivery_country_name . '
                                            <br>' . EMAIL_BODY_COMMON_PHONE . $orders_info['refund_shipping_address']['entry_telephone'] . '
                                        </a>
                                    </td>
                                    <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;padding-left: 20px;">
                                            <span style="color: #818181;display: inline-block;margin-bottom: 3px">
                                                ' . FS_SEND_EMAIL_70 . '
                                            </span>
                                        <br>
                                        <a style="color: #232323;text-decoration: none" href="javascript:;">
                                            ' . ucwords($orders_info['billing_name']) . ' ' . ucwords($orders_info['billing_lastname']) . '
                                            ' . $billing_company . '
                                            <br>
                                            ' . $orders_info['billing_street_address'] . $billing_suburb . '
                                            ' . $orders_info['billing_city'] . ', ' . $orders_info['billing_postcode'] . '
                                            <br>' . $billing_state . $orders_info['billing_country'] . '
                                            <br>' . EMAIL_BODY_COMMON_PHONE . $orders_info['billing_telephone'] . '
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>';

    return $email_shipping;
}

/**
 * 获取邮件定制产品属性结构
 * @param $orders_products_id
 * @return string
 */
function getRmaEmailattrHtml($orders_products_id)
{
    //展示产品属性
    $attrHtml = '';
    $attributes_arr = zen_get_orders_products_attributes($orders_products_id);
    $attributes_length = zen_get_order_product_length($orders_products_id);
    if (!empty($attributes_arr)) {
        foreach ($attributes_arr as $xx => $attr) {
            if (!$attributes_length) {
                if (!preg_match('/option/i', $attr['products_options_values'])) {
                    $attrHtml .= '<div style="font-size:12px;">' . ucwords($attr['products_options']) . ': ' . ucwords($attr['products_options_values']) . '&nbsp;&nbsp;</div>';
                }
            } else {
                foreach ($attributes_length as $ky => $ve) {
                    $attrHtml .= '<div style="font-size:12px;">' . FS_LENGTH . ':' . ucwords($ve['length_name']) . ' </div>';
                }
                $attrHtml .= '<div style="font-size:12px;">' . ucwords($attr['products_options_values']) . ':' . ucwords($attr['products_options']) . ' </div>';
            }
        }
    }

    return $attrHtml;

}

/**
 * 获取邮件产品结构
 * @param $products_id
 * @param $images
 * @param $attrHtml
 * @param $qty
 * @param $key
 * @param $count
 * @return string
 */
function getRmaEmailProductsHtml($products_id, $images, $attrHtml, $qty, $key, $count)
{
    $products_name = zen_get_products_name($products_id,'');

    $html = '<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;padding-left:20px;" width="60">
                            <a style="text-decoration: none;" href="' . zen_href_link('product_info', 'products_id=' . $products_id) . '">
                                ' . $images . '
                            </a>
                        </td>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" height="20">
                            <a style="text-decoration: none;color: #232323;" href="' . zen_href_link('product_info', 'products_id=' . $products_id) . '">
                                <span>' . $products_name . '<span style="text-decoration: none;color: #999;"> #' . $products_id . '</span></span>
                            </a> 
                             <div style="padding:5px 0 0 0;color: #616265;">' . $attrHtml . '</div>
                            <span>' . FS_SEND_EMAIL_8 . '<span>' . $qty . '</span></span>
                        </td>
                    </tr>
                    </tbody>
                </table>';

    if ($key < $count) {
        $html .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;border-bottom: 1px solid #f7f7f7;" height="20">
                        </td>
                    </tr>
                    </tbody>
                </table>
                  <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;" height="20">
                        </td>
                    </tr>
                    </tbody>
                </table>';
    } else {
        $html .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;" height="30">

                        </td>
                    </tr>
                    </tbody>
                </table>';
    }

    return $html;

}


$oauthTokenUrl = EmailConfig::OAUTH_TOKEN_URL;
$clientId = EmailConfig::CLIENT_ID;
$clientSecret = EmailConfig::CLIENT_SECRET;

function requestAccessMailToken($oauthTokenUrl, $clientId, $clientSecret)
{
    $data_string = array(
        'grant_type' => 'client_credentials',
        'client_id' => $clientId,
        'client_secret' => $clientSecret,
        'scope' => 'rest'
    );

    $ch = curl_init($oauthTokenUrl);
    curl_setopt($ch, CURLOPT_FAILONERROR, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_string, null, '&'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $json = curl_exec($ch);

    curl_close($ch);

    $data = json_decode($json, true);

    if (null === $data) {
        echo 'No valid json returned.' . PHP_EOL;
        exit(1);
    } elseif (isset($data['error'])) {
        echo $data['error'] . ': ' . $data['error_description'] . PHP_EOL;
        exit(1);
    }

    return $data;
}

/*
 * 请求第三方接口
 * $type string 0删除联系人 1新增联系人
 * $data array
 */
function dmartech_api($type,$data){
    $data_info = '';
    if($type === '0'){
        $type_str = 'user_delete';
        $data_info = $data['del'];
    }elseif( in_array($type,['1','2','3']) ){
        $type_str = 'user';
        $data_info = $data['update'];
    }else{
        return;
    }

    $oauthTokenUrl = 'https://data-api.dmartech.cn/api/v1/api/import?secret=5264e587-1299-402a-9b09-7555682a28bd';
    $accessToken = "5264e587-1299-402a-9b09-7555682a28bd";
    $method = "post";  //类型输出
    $item = array("type"=>$type_str, "properties"=>$data_info);
    $data_string = json_encode($item);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $oauthTokenUrl);
    curl_setopt($ch, CURLOPT_FAILONERROR, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch,CURLOPT_HTTPHEADER,array("accept: application/json","content-type: application/json"));
    $response    = curl_exec($ch);
    $curl_error  = curl_error($ch);
    return ['response'=>$response,'curl_error'=>$curl_error];
}

/*
 * 用户是否取消系统邮件
 * para $email 
 * return bool
 */
function is_customer_cancel_system_mail($email){
    global $db;
    $sql = "select system_mail_subscribe from customers where customers_email_address = '".$email."' limit 1";
	$result = $db->Execute($sql);
    $result = $result->fields['system_mail_subscribe'];
    if($result == 2){
        return true;
    }
    return false;
}


/*
 * $email_name:邮件名后台可见
 * $title:邮件主题
 * $email: 发件人
 * $block，$module:邮件模板
 */
function sendwebmail($name,$user_email,$email_name,$email,$title,$block,$module='default',$groups=81,$attachments_list='',$orders_id = 0){
    global $oauthTokenUrl,$clientId,$clientSecret;

//    //用户是否取消系统邮件
    if($_SESSION['customers_email_address']){
        $user_email = trim($user_email);
        if(is_customer_cancel_system_mail($_SESSION['customers_email_address'])){
            if($user_email == $_SESSION['customers_email_address']){
                return false;
            }
        }
    }
    if (defined('ORDER_PENDING_EMAIL_QUEUE_SEND') && ORDER_PENDING_EMAIL_QUEUE_SEND && !empty($orders_id)){
        $data = [
            'name'             => $name,
            'user_email'       => $user_email,
            'email_name'       => $email_name,
            'email'            => $email,
            'title'            => $title,
            'block'            => $block,
            'module'           => $module,
            'groups'           => $groups,
            'attachments_list' => $attachments_list,
            'languages_code'   => (string)$_SESSION['languages_code'] ?: 'en',
            'session'          => isset($_SESSION['customer_email_data']) ? $_SESSION['customer_email_data'] : ''
        ];
        (new \App\Models\OrdersPendingEmailQueue())->insert(
            [
                'orders_id'  => $orders_id,  //只记录主单id
                'data'       => json_encode($data),
                'created_at' => time()
            ]
        );
        return true;
    }

    if (defined('ORDER_PENDING_EMAIL_QUEUE_SEND') && $module == 'regist_new') {
        $data = [
            'name'             => $name,
            'user_email'       => $user_email,
            'email_name'       => $email_name,
            'email'            => $email,
            'title'            => $title,
            'block'            => $block,
            'module'           => $module,
            'groups'           => $groups,
            'attachments_list' => $attachments_list,
            'languages_code'   => (string)$_SESSION['languages_code'] ?: 'en',
            'session'          => isset($_SESSION['customer_email_data']) ? $_SESSION['customer_email_data'] : ''
        ];
        (new \App\Models\RegistEmailQueue())->insert(
            [
                'customers_id'  => $_SESSION['customer_id'],  //客户id
                'data'       => json_encode($data),
                'created_at' => time()
            ]
        );
        return true;
    }

    if($attachments_list=='' && (strpos($_SERVER["SERVER_NAME"],'www.fs.com')!==false || strpos($_SERVER["SERVER_NAME"],'tx.fs.com')!==false)){
    $accessTokenData = requestAccessMailToken($oauthTokenUrl, $clientId, $clientSecret);
    $accessToken = $accessTokenData['access_token'];
    $expiretime = time() + $accessTokenData['expires_in'];
    //生成邮件
    if (defined('EMAIL_MODULES_TO_SKIP') && in_array($module,explode(",",constant('EMAIL_MODULES_TO_SKIP')))) return false;
    if (trim($name) == '' && (!zen_not_null($block) || (isset($block['EMAIL_MESSAGE_HTML']) && $block['EMAIL_MESSAGE_HTML'] == '')) ) return false;
    if (isset($_SESSION['customer_email_data']) && is_array($_SESSION['customer_email_data'])) {
        /* FOR OUR custome information*/
        if (!isset($block['FIRSTNAME']) || $block['FIRSTNAME'] == '') $block['FIRSTNAME'] = $_SESSION['customer_email_data']['firstname'];
        if (!isset($block['LASTNAME']) || $block['LASTNAME'] == '') $block['LASTNAME'] = $_SESSION['customer_email_data']['lastname'];
        if (!isset($block['EMAIL_ADDRESS']) || $block['EMAIL_ADDRESS'] == '') $block['EMAIL_ADDRESS'] = $_SESSION['customer_email_data']['email_address'];
        if (!isset($block['PASSWORD']) || $block['PASSWORD'] == '') $block['PASSWORD'] = $_SESSION['customer_email_data']['password'];
    }
    $email_html = (!is_array($block) && substr($block, 0, 6) == '<html>') ? $block : zen_build_html_email_from_template($module, $block);
    $email_html = str_replace('$user_email',$user_email,$email_html);
//    //加密url
    $key_url = 'feisu';
    $encode_url = encrypt_url('code='.$user_email,$key_url);
    $email_html = str_replace('$xxxx',$encode_url,$email_html);
    if (!is_array($block) && $block == '' || $block == 'none') $email_html = '';
    //得到邮件模板ID发送邮件
    $url = "https://fs-sys.webpower.eu/admin/api/index.php/rest/3/contact/sendSingleMail";   //输出的链接地址
    $item = array(
        "mailingId"=>79143,"attachments"=>array(),
        "contact"=> array("email"=> $user_email,"mobile_nr"=> "", "lang"=>"cn",
            "custom"=>array(array("field"=> "mail_subject", "value"=> $title),
                array("field"=> "sender_name", "value"=> $email))),
        "overrideDuplicateAndSend"=> true,
        "extraContactData"=> array(array("field"=>'DMD_extra1', "value"=> $email_html))
    );

    $data_string = json_encode($item);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FAILONERROR, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch,CURLOPT_HTTPHEADER,array("accept: application/json","authorization: Bearer " . $accessToken,"content-type: application/json"));
    $response    = curl_exec($ch);
    $curl_error  = curl_error($ch);
    $response = json_decode($response);
    if(!$response->id){
        //如果发件失败,用原来的发邮件方式
        zen_mail($name,$user_email,$title,'',STORE_NAME,EMAIL_FROM,$block,$module,$attachments_list);
    }
  }else{
        if(strpos($_SERVER["SERVER_NAME"],'www.fs.com')!==false || strpos($_SERVER["SERVER_NAME"],'test.whgxwl.com')!==false || strpos($_SERVER["SERVER_NAME"],'tx.fs.com')!==false){
            //如果有附件，用原来发件方式
            zen_mail($name,$user_email,$title,'',STORE_NAME,EMAIL_FROM,$block,$module,$attachments_list);

        }
  }
}

