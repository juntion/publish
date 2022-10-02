<?php
//搜索详情关键词匹配case_studies页面内容 ternence 2020/8/19
namespace App\Services\CaseStudies;

use App\Services\BaseService;
use App\Models\DocArticle;
use App\Models\DocArticleDescription;

class CaseStudiesService extends BaseService
{
    private $docArticle;
    private $docArticleDescription;

    public function __construct()
    {
        parent::__construct();
        $this->docArticle = new DocArticle();
        $this->docArticleDescription = new DocArticleDescription();
    }

    /**
     * 匹配对应关键词文章
     * @param $keywords
     * @return array
     */
    public function keywordsThematicSearch($keywords, $doc_categories_id, $type)
    {
        if ($type) {
            $res = $this->docArticleDescription->leftJoin('doc_article as c', 'c.doc_article_id', '=', 'cld.doc_article_id')
                ->leftJoin('doc_article_category as d', 'd.doc_article_id', '=', 'cld.doc_article_id')
                ->where('cld.doc_article_title', 'like', '%' . $keywords . '%')
                ->where('cld.doc_des_status', 1)
                ->where('cld.language_id', $this->language_id)
                ->where('c.doc_article_image', '!=', '')
                ->where('d.doc_categories_id', $doc_categories_id)
                ->where('c.doc_case_type_id', $type)
                ->limit(5)
                ->orderby('cld.doc_article_des_sort_order', 'cld.doc_article_des_sort_order != 0 DESC')
                ->orderby('cld.doc_article_des_sort_order', 'ASC')
                ->orderby('cld.doc_article_des_last_modified', 'DESC')
                ->get(['cld.doc_article_title', 'c.doc_article_image', 'c.doc_article_id'])
                ->toArray();
        } else {
            $res = $this->docArticleDescription->leftJoin('doc_article as c', 'c.doc_article_id', '=', 'cld.doc_article_id')
                ->leftJoin('doc_article_category as d', 'd.doc_article_id', '=', 'cld.doc_article_id')
                ->where('cld.doc_article_title', 'like', '%' . $keywords . '%')
                ->where('cld.doc_des_status', 1)
                ->where('cld.language_id', $this->language_id)
                ->where('c.doc_article_image', '!=', '')
                ->where('d.doc_categories_id', $doc_categories_id)
                ->limit(5)
                ->orderby('cld.doc_article_des_sort_order', 'cld.doc_article_des_sort_order != 0 DESC')
                ->orderby('cld.doc_article_des_sort_order', 'ASC')
                ->orderby('cld.doc_article_des_last_modified', 'DESC')
                ->get(['cld.doc_article_title', 'c.doc_article_image', 'c.doc_article_id','c.doc_case_type_id'])
                ->toArray();
        }


        $data = [];
        if (sizeof($res)) {
            foreach ($res as $key => $value) {
                $data[] = [
                    'id' => $value['doc_article_id'],
                    'href_link' => str_replace(' ', '-', ucfirst(strtolower($value['doc_article_title']))) . '-aid-' . $value['doc_article_id'].'.html',
                    'title' => $value['doc_article_title'],
                    'image' => HTTPS_IMAGE_SERVER.'images/'.$value['doc_article_image'],
                    'type_id' => $value['doc_case_type_id'],
                    ];
            }
        }

        return $data;
    }
}
