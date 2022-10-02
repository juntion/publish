<?php

namespace App\Services\Email;

use App\Services\BaseService;

class ERateEmailService extends BaseService
{

    public function emailBody($name, $caseNumber)
    {
        $dear = self::trans('MY_CASE_UPLOAD_3') . ' ' . $name . self::trans('FS_EMAIL_COMMA');
        if ($name == 'señor/señora') {
            $dear = self::trans('MY_CASE_UPLOAD_3') . self::trans('FS_EMAIL_COMMA');
        }
        $body = '<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #232323;
                        line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 30px 20px 0" align="left">
                            ' . $dear . '
                        </td >
                    </tr >
                    </tbody >
                </table >
                <table width = "640" border = "0" cellpadding = "0" cellspacing = "0" >
                    <tbody >
                    <tr >
                        <td bgcolor = "#fff" style = "border-collapse: collapse" height = "10" >

                        </td >
                    </tr >
                    </tbody >
                </table >
                <table width = "640" border = "0" cellpadding = "0" cellspacing = "0" >
                    <tbody >
                    <tr >
                        <td bgcolor = "#fff" style = "border-collapse: collapse;font-size: 14px;color: #232323;
                        line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align = "left" >
                            ' . self::trans('FS_ERate_22') . '
                        </td >
                    </tr >
                    </tbody >
                </table >

                <table width = "640" border = "0" cellpadding = "0" cellspacing = "0" >
                    <tbody >
                    <tr >
                        <td bgcolor = "#fff" style = "border-collapse: collapse" height = "20" >

                        </td >
                    </tr >
                    </tbody >
                </table >

                <table width = "640" border = "0" cellpadding = "0" cellspacing = "0" >
                    <tbody >
                    <tr >
                        <td bgcolor = "#fff" 
                        style = "border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;
                        font-family: Open Sans,arial,sans-serif;padding: 0 20px 30px;" align = "left" >
                            ' . self::trans('REGIST_COM_EMAIL_SEND_15') . '
                        </td >
                    </tr >
                    </tbody >
                </table > ';
        $body = str_replace('$CNxxxxxxx', $caseNumber, $body);
        return $body;
    }
}
