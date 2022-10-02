<?php

class AmericanBritishSpellings
{
    public $data = array();
    public function __construct($args,$data=[])
    {
        $this->data = $data ? $data : $this->GetAmericanToBritishSpellings();
    }

    public function SwapBritishSpellingsForAmericanSpellings($args)
    {
        $text = $args['text'];
        $spelling_alternatives = $this->GetAmericanToBritishSpellings();

        foreach ($spelling_alternatives as $american_spelling => $british_spelling) {
            if (is_array($british_spelling)) {
                foreach ($british_spelling as $british_word) {
                    $text = preg_replace('/\b' . $british_word . '\b/', $american_spelling, $text);

                    $uppercased_american_spelling = ucwords($american_spelling);
                    if ($uppercased_american_spelling != $american_spelling) {
                        $uppercased_british_spelling = ucwords($british_word);

                        $text = preg_replace('/\b' . $uppercased_british_spelling . '\b/', $uppercased_american_spelling, $text);
                    }
                }
            } else {
                $text = preg_replace('/\b' . $british_spelling . '\b/', $american_spelling, $text);

                $uppercased_american_spelling = ucwords($american_spelling);
                if ($uppercased_american_spelling != $american_spelling) {
                    $uppercased_british_spelling = ucwords($british_spelling);

                    $text = preg_replace('/\b' . $uppercased_british_spelling . '\b/', $uppercased_american_spelling, $text);
                }
            }
        }
        return $text;
    }

    public function SwapAmericanSpellingsForBritishSpellings($args)
    {
        $text = $args['text'];
        $spelling_alternatives = $this->data;
        foreach ($spelling_alternatives as $k=>$value) {
            foreach ($value as $american_spelling => $british_spelling) {
                if (is_array($british_spelling)) {
                    $british_spelling = $british_spelling[0];
                }

                $text = preg_replace('/\b' . $american_spelling . '\b/', $british_spelling, $text);

                $uppercased_british_spelling = ucwords($british_spelling);
                if ($uppercased_british_spelling != $british_spelling) {
                    $uppercased_american_spelling = ucwords($american_spelling);

                    $text = preg_replace('/\b' . $uppercased_american_spelling . '\b/', $uppercased_british_spelling, $text);
                }
            }
        }

        return $text;
    }

    public function GetAmericanToBritishSpellings()
    {
        global $db;
        // Sources:
        //
        //	8,000 Words: http://www.wordsworldwide.co.uk/docs/Words-Worldwide-Word-list-UK-US-2009.doc
        //	18,000 Words https://github.com/en-wl/wordlist/blob/master/varcon/varcon.txt
        //
        //  These sources did more than provide the total sum of words.  They cross-checked each other and found errors.
        //
        //  Total After Removing Duplicates: 20,000
        /*2019.06.20
         * 获取后台上传的需要转化的单词
         * */
        $languages_code = $_SESSION['languages_code'];
        //de-en 直接运用uk一样的数据
        if($languages_code =='dn'){
            $languages_code ='uk';
        }
        $word_md5 = md5('american_british_'.$languages_code);
        $redis_word = get_redis_key_value($word_md5,'american_british');
        if(!$redis_word){
            $sqlCache = sqlCacheType();
            //获取后台数据
            $sql = "select {$sqlCache} american_word,britain_word from swap_american_to_britain where languages_code regexp ',".$languages_code.",' order by sort desc,id desc";
            $data = $db->getAll($sql);
            foreach ($data as $key=>$val){
                $result_data[] = array(
                    $val['american_word'] => $val['britain_word']
                );
            }
            set_redis_key_value($word_md5, $result_data,24*3600,'american_british');
        }else{
            $result_data = $redis_word;
        }
        return $result_data;
    }
}

?>