<?php


namespace App\Traits;

trait TransTrait
{
    /**
     * 语言包翻译
     *
     * @author aron
     * @date 2019.11.8
     * @param string $text
     * @return string
     */
    public static function trans($text = "")
    {
        $text = defined($text) ? constant($text): "";
        return $text;
    }
}
