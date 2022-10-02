<?php

namespace App\Services\Email\Base;

use App\Config\EmailConfig;
use App\Exception\SendEmailException;
use GuzzleHttp\Client;
use App\Services\BaseService;

class EmailTemplateService extends BaseService
{

    /**
     * @param $data
     * @return string
     * @throws \Exception
     */
    public function getEmailTemplate($data)
    {
        $block = isset($data['block']) ? $data['block'] : '';
        $module = isset($data['module']) ? $data['module'] : '';
        $name = isset($data['name']) ? $data['name'] : '';
        $session = isset($data['session']) ? $data['session'] : '';
        $user_email = trim(isset($data['user_email']) ? $data['user_email'] : '');
        $skipModules = self::trans('EMAIL_MODULES_TO_SKIP');
        if (empty($skipModules) && in_array($module, explode(',', $skipModules))) {
            throw new \Exception('module: [' . $module . '] has been skipped');
        }
        if (trim($name) == '') {
            throw new \Exception('email is missing recipient');
        }
        if (!self::zenNotNull($block)) {
            throw new \Exception('email is missing principal information');
        }
        if ((isset($block['EMAIL_MESSAGE_HTML']) && $block['EMAIL_MESSAGE_HTML'] == '')
        ) {
            throw new \Exception('Low inventory data : [ EMAIL_MESSAGE_HTML ] Incorrect setting');
        }
        if (is_array($session) && is_array($block)) {
            /* FOR OUR custome information*/
            if (!isset($block['FIRSTNAME']) || $block['FIRSTNAME'] == '') {
                $block['FIRSTNAME'] = $session['firstname'];
            }
            if (!isset($block['LASTNAME']) || $block['LASTNAME'] == '') {
                $block['LASTNAME'] = $session['lastname'];
            }
            if (!isset($block['EMAIL_ADDRESS']) || $block['EMAIL_ADDRESS'] == '') {
                $block['EMAIL_ADDRESS'] = $session['email_address'];
            }
            if (!isset($block['PASSWORD']) || $block['PASSWORD'] == '') {
                $block['PASSWORD'] = $session['password'];
            }
        }
        if (!is_array($block) && substr($block, 0, 6) == '<html>') {
            $email_html = $block;
        } else {
            $email_html = $this->getRealEmailTemplate($module, $block, (string)$data['languages_code']);
        }

        $email_html = str_replace('$user_email', $user_email, $email_html);
        //加密url
        $encode_url = self::encryptUrl('code=' . $user_email, 'feisu');
        $email_html = str_replace('$xxxx', $encode_url, $email_html);
        if (!is_array($block) && $block == '' || $block == 'none') {
            throw new \Exception('信息处理后,邮件缺少主体信息');
        }
        return $email_html;
    }

    /**
     * @param string $module
     * @param string $content
     * @param string $code
     * @return false|string|string[]
     * @throws \Exception
     */
    protected function getRealEmailTemplate($module = 'default', $content = '', $code = 'en')
    {
        $block = array();
        if (is_array($content)) {
            $block = $content;
        } else {
            $block['EMAIL_MESSAGE_HTML'] = $content;
        }

        $allTemplates = self::trans('DIR_FS_EMAIL_TEMPLATES');
        $template_filename_base = $allTemplates . 'email_template_';
        $module = str_replace(array('_extra', '_admin'), '', $module);

        //目前下单邮件确认都是指定的模板(目前只确认了下单邮件的)
        $template_filename = $template_filename_base . $module . '.html';
        if (!file_exists($template_filename)) {
            throw new \Exception('The designated template [' . $module . '] does not exist');
        }
        $fh = fopen($template_filename, 'rb');
        if (!$fh) {   // note: the 'b' is for compatibility with Windows systems
            throw new \Exception('could not open The designated template [' . $module . ']');
        }

        $file_holder = fread($fh, filesize($template_filename));
        fclose($fh);

        //strip linebreaks and tabs out of the template
        //  $file_holder = str_replace(array("\r\n", "\n", "\r", "\t"), '', $file_holder);
        $file_holder = str_replace(array("\t"), ' ', $file_holder);

        $catalogServer = self::trans('HTTP_CATALOG_SERVER');
        $httpServer = self::trans('HTTP_SERVER');
        if (empty($catalogServer)) {
            $catalogServer = $httpServer;
        }
        $storeName = self::trans('STORE_NAME');
        $dirWsCatalog = self::trans('DIR_WS_CATALOG');
        $emailFooterCopyright = self::trans('EMAIL_FOOTER_COPYRIGHT');
        $emailDisClaimer = self::trans('EMAIL_DISCLAIMER');
        $storeOwnerEmailAddress = self::trans('STORE_OWNER_EMAIL_ADDRESS');
        //check for some specifics that need to be included with all messages
        if (!isset($block['EMAIL_STORE_NAME']) || $block['EMAIL_STORE_NAME'] == '') {
            $block['EMAIL_STORE_NAME'] = $storeName;
        }
        if (!isset($block['EMAIL_STORE_URL']) || $block['EMAIL_STORE_URL'] == '') {
            $block['EMAIL_STORE_URL'] = '<a href="' . $catalogServer . $dirWsCatalog . '">' . $storeName . '</a>';
        }
        if (!isset($block['EMAIL_STORE_OWNER']) || $block['EMAIL_STORE_OWNER'] == '') {
            $block['EMAIL_STORE_OWNER'] = $storeName;
        }
        if (!isset($block['EMAIL_FOOTER_COPYRIGHT']) || $block['EMAIL_FOOTER_COPYRIGHT'] == '') {
            $block['EMAIL_FOOTER_COPYRIGHT'] = $emailFooterCopyright;
        }
        if (!isset($block['EMAIL_DISCLAIMER']) || $block['EMAIL_DISCLAIMER'] == '') {
            $block['EMAIL_DISCLAIMER'] = sprintf($emailDisClaimer, '<a href="mailto:' . $storeOwnerEmailAddress . '">'
                . $storeOwnerEmailAddress . ' </a>');
        }
        if (!isset($block['EMAIL_SPAM_DISCLAIMER']) || $block['EMAIL_SPAM_DISCLAIMER'] == '') {
            $block['EMAIL_SPAM_DISCLAIMER'] = self::trans('EMAIL_SPAM_DISCLAIMER');
        }
        if (!isset($block['EMAIL_DATE_SHORT']) || $block['EMAIL_DATE_SHORT'] == '') {
            $block['EMAIL_DATE_SHORT'] = self::zenDateShort(date('Y-m-d'));
        }
        if (!isset($block['EMAIL_DATE_LONG']) || $block['EMAIL_DATE_LONG'] == '') {
            $block['EMAIL_DATE_LONG'] = self::zenDateLong(date('Y-m-d'));
        }
        if (!isset($block['BASE_HREF']) || $block['BASE_HREF'] == '') {
            $block['BASE_HREF'] = $httpServer . $dirWsCatalog;
        }
        if (!isset($block['CHARSET']) || $block['CHARSET'] == '') {
            $block['CHARSET'] = self::trans('CHARSET');
        }
        if (!isset($block['EXTRA_INFO'])) {
            $block['EXTRA_INFO'] = '';
        }
        if (substr($module, -6) != '_extra' && $module != 'contact_us') {
            $block['EXTRA_INFO'] = '';
        }
        $block['COUPON_BLOCK'] = '';
        if (isset($block['COUPON_TEXT_VOUCHER_IS'], $block['COUPON_TEXT_TO_REDEEM'])
            && $block['COUPON_TEXT_VOUCHER_IS'] != ''
            && $block['COUPON_TEXT_TO_REDEEM'] != ''
        ) {
            $block['COUPON_BLOCK'] = '<div class="coupon-block">' .
                $block['COUPON_TEXT_VOUCHER_IS'] . $block['COUPON_DESCRIPTION'] . '<br />' .
                $block['COUPON_TEXT_TO_REDEEM'] .
                '<span class="coupon-code">' . $block['COUPON_CODE'] . '</span></div>';
        }
        $block['GV_BLOCK'] = '';
        if (isset($block['GV_WORTH'], $block['GV_REDEEM'], $block['GV_CODE_URL'])
            && $block['GV_WORTH'] != ''
            && $block['GV_REDEEM'] != ''
            && $block['GV_CODE_URL'] != ''
        ) {
            $block['GV_BLOCK'] = '<div class="gv-block">' .
                $block['GV_WORTH'] . '<br />' .
                $block['GV_REDEEM'] . $block['GV_CODE_URL'] . '<br />' .
                $block['GV_LINK_OTHER'] .
                '</div>';
        }
        $textUnsubscribe = self::trans('TEXT_UNSUBSCRIBE');
        $fileNameUnsubscribe = self::trans('FILENAME_UNSUBSCRIBE');
        //prepare the "unsubscribe" link:
        if (self::trans('IS_ADMIN_FLAG') === true) { // is this admin version, or catalog?
            $unsubscribeLink = $this->zenCatalogHrefLink(
                $fileNameUnsubscribe,
                'addr=' . $block['EMAIL_TO_ADDRESS'],
                $code
            );
        } else {
            $unsubscribeLink = $this->zenHrefLink($fileNameUnsubscribe, 'addr=' . $block['EMAIL_TO_ADDRESS'], $code);
        }
        $block['UNSUBSCRIBE_LINK'] = str_replace("\n", '', $textUnsubscribe) . ' <a href="' . $unsubscribeLink . '">' .
            $unsubscribeLink . '</a>';
        //now replace the $BLOCK_NAME items in the template file with the values passed to this function's array
        foreach ($block as $key => $value) {
            $file_holder = str_replace('$' . $key, $value, $file_holder);
        }
        return $file_holder;
    }

    /**
     * @param $page
     * @param $parameters
     * @param $code
     * @param string $ssl
     * @return string
     */
    private function zenHrefLink($page, $parameters, $code, $ssl = 'ssl')
    {
        $lang = self::getLinkLang($code);
        //暂不使用zen_href_link方法，拼接链接
        //return zen_href_link($this->url_base, $parameters, 'SSL');
        $server = ($ssl != 'ssl') ? 'HTTP_SERVER' : 'HTTPS_SERVER';
        return self::trans($server) .
            preg_replace('/&(?=&)/', "\\1", $lang . '/index.php?main_page=' . $page . '&' . $parameters);
    }

    /**
     * @param $page
     * @param $parameters
     * @param $code
     * @param string $ssl
     * @return string
     */
    private function zenCatalogHrefLink($page, $parameters, $code, $ssl = 'ssl')
    {
        $lang = self::getLinkLang($code);
        //暂不使用zen_href_link方法，拼接链接
        //return zen_href_link($this->url_base, $parameters, 'SSL');
        $server = ($ssl != 'ssl') ? 'HTTP_CATALOG_SERVER' : 'HTTPS_CATALOG_SERVER';
        if (empty($server)) {
            $server = ($ssl != 'ssl') ? 'HTTP_SERVER' : 'HTTPS_SERVER';
        }
        return self::trans($server) .
            preg_replace('/&(?=&)/', "\\1", $lang . '/index.php?main_page=' . $page . '&' . $parameters);
    }
}
