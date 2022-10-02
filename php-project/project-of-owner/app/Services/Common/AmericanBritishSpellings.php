<?php


namespace App\Services\Common;

use App\Services\BaseService;
use App\Models\SwapAmericanToBritain;

class AmericanBritishSpellings extends BaseService
{
    private $SwapAmericanToBritain;
    public $data = array();

    public function __construct($data = [])
    {
        parent::__construct();
        $this->SwapAmericanToBritain = new SwapAmericanToBritain();
        $this->data = $data ? $data : $this->getAmericanToBritishSpellings();
    }

    public function swapBritishSpellingsForAmericanSpellings($args)
    {
        $text = $args['text'];
        $spelling_alternatives = $this->getAmericanToBritishSpellings();

        foreach ($spelling_alternatives as $american_spelling => $british_spelling) {
            if (is_array($british_spelling)) {
                foreach ($british_spelling as $british_word) {
                    $text = preg_replace('/\b' . $british_word . '\b/', $american_spelling, $text);

                    $uppercased_american_spelling = ucwords($american_spelling);
                    if ($uppercased_american_spelling != $american_spelling) {
                        $uppercased_british_spelling = ucwords($british_word);

                        $text = preg_replace(
                            '/\b' . $uppercased_british_spelling . '\b/',
                            $uppercased_american_spelling,
                            $text
                        );
                    }
                }
            } else {
                $text = preg_replace('/\b' . $british_spelling . '\b/', $american_spelling, $text);

                $uppercased_american_spelling = ucwords($american_spelling);
                if ($uppercased_american_spelling != $american_spelling) {
                    $uppercased_british_spelling = ucwords($british_spelling);

                    $text = preg_replace(
                        '/\b' . $uppercased_british_spelling . '\b/',
                        $uppercased_american_spelling,
                        $text
                    );
                }
            }
        }
        return $text;
    }

    public function swapAmericanSpellingsForBritishSpellings($args)
    {
        $text = $args['text'];
        $spelling_alternatives = $this->data;
        foreach ($spelling_alternatives as $k => $value) {
            foreach ($value as $american_spelling => $british_spelling) {
                if (is_array($british_spelling)) {
                    $british_spelling = $british_spelling[0];
                }

                $text = preg_replace('/\b' . $american_spelling . '\b/', $british_spelling, $text);

                $uppercased_british_spelling = ucwords($british_spelling);
                if ($uppercased_british_spelling != $british_spelling) {
                    $uppercased_american_spelling = ucwords($american_spelling);

                    $text = preg_replace(
                        '/\b' . $uppercased_american_spelling . '\b/',
                        $uppercased_british_spelling,
                        $text
                    );
                }
            }
        }

        return $text;
    }

    public function getAmericanToBritishSpellings()
    {
        // Sources:
        //
        //  8,000 Words: http://www.wordsworldwide.co.uk/docs/Words-Worldwide-Word-list-UK-US-2009.doc
        //  18,000 Words https://github.com/en-wl/wordlist/blob/master/varcon/varcon.txt
        //
        //  These sources did more than provide the total sum of words.  They cross-checked each other and found errors.
        //
        //  Total After Removing Duplicates: 20,000
        /*2019.06.20
         * 获取后台上传的需要转化的单词
         * */
        $result_data = [];
        $languages_code = $this->language_code;

        //de-en 直接运用uk一样的数据
        if ($languages_code =='dn') {
            $languages_code ='uk';
        }
        //获取后台数据
        $data = $this->SwapAmericanToBritain
            ->whereRaw('languages_code regexp "'.$languages_code.'"')
            ->orderBy('sort', 'desc')
            ->orderBy('id', 'desc')
            ->get(['american_word', 'britain_word']);
        foreach ($data as $key => $val) {
            $result_data[] = array(
                $val['american_word'] => $val['britain_word']
            );
        }
        return $result_data;
    }

    public function swapAmericanToBritain($content)
    {
        if ($content) {
            if (!in_array($this->language_code, array('uk','au','dn'))) {
                return $content;
            }
            //$american_british_spellings = new AmericanBritishSpellings(['text'=>$content], $resultData);
            if (strpos($content, '<') !== false) {//带有html的内容
                $extraPreg = '/<!--[\s\S]*?-->/';  //去掉原文中的注释部分
                $content = preg_replace($extraPreg, '', $content);
                //源码中的js 和 css不能被替换
                $jsPreg = "/<script[\s\S]*?<\/script>/i";
                preg_match_all($jsPreg, $content, $jsMatch);
                $content = preg_replace($jsPreg, '', $content);

                $cssPreg = '/<style[\s\S]*?<\/style>/i';
                preg_match_all($cssPreg, $content, $cssMatch);
                $content = preg_replace($cssPreg, '', $content);
                $arr = explode('<', $content);
                $new_arr = [];
                foreach ($arr as $key => $value) {
                    $new_arr[] = explode('>', $value);
                }
                if ($new_arr) {
                    $final_html = '';
                    foreach ($new_arr as $kk => $vv) {
                        //像 字符<br> 字符这样的特殊情况
                        if (count($vv) ==1 &&!empty($vv[0])) {
                            $final_html .= $vv[0];
                        } elseif (count($vv) > 1) {
                            $final_html .= '<' . $vv[0] . '>';
                            if ($vv[1]) {
                                $vv[1] = $this->swapAmericanSpellingsForBritishSpellings(['text' => $vv[1]]);
                                $final_html .= $vv[1];
                            }
                        }
                    }
                    $content = $final_html;
                    //如果原文中有js  css 则追加在content中
                    if ($cssMatch) {
                        $cssContent = '';
                        foreach ($cssMatch[0] as $key => $val) {
                            $cssContent .= $val;
                        }
                        $content .= $cssContent;
                    }
                    if ($jsMatch) {
                        $jsContent = '';
                        foreach ($jsMatch[0] as $key => $val) {
                            $jsContent .= $val;
                        }
                        $content .= $jsContent;
                    }
                }
            } else {//没有html的内容
                $content = $this->swapAmericanSpellingsForBritishSpellings(['text' => $content]);
            }
        }
        return $content;
    }
}
