<?php
/**
 * @note:solution处理文件
 * @author:paul
 * @time:2020/6/18
 */
namespace App\Services\Solution;

use App\Models\SolutionAdditionalImage;
use App\Models\SolutionDescription;
use App\Models\SolutionDetailDescription;

class SolutionDescServices extends SolutionServices
{

    private $solution_id;
    private $outArr = [];

    public function __construct($solution_id)
    {
        parent::__construct();

        $this ->solution_id = $solution_id;

        self::judgePage();
    }

    /***
     * @note:获取solution的产品简单描述和主多图
     */
    public function getSolutionImgDes()
    {
        //简短的描述表
        $solution_desc_obj = new SolutionDescription();
        $descIns = $solution_desc_obj
            ->where(['solution_id'=>$this ->solution_id, 'is_show'=>1, 'is_delete'=>1])
            ->select(['description','img_link'])
            ->get();

        foreach ($descIns as $k => $obj) {
            $this->outArr['descrip'][$k]['img_link'] = $obj -> img_link;
            $this->outArr['descrip'][$k]['description'] = parent::getTranDescription($obj);
        }
        $solution_desc_img_obj = new SolutionAdditionalImage();
        $this->outArr['imageAll'] = $solution_desc_img_obj
            ->where(['solution_id'=>$this ->solution_id])
            ->select(['img_link','type','is_main'])
            ->orderBy('sort_order', 'asc') //排序的升序
            ->get()
            ->toArray();
        //获取default的值 视频或者图片
        $this ->outArr['defaultImg'] = array();
        foreach ($this->outArr['imageAll'] as $key => $val) {
            if (!isset($this ->outArr['defaultImg'][$val['type']])) {
                $this ->outArr['defaultImg'][$val['type']] = $val;
            }
        }
        return $this->outArr;
    }

    /***
     * @note 获取详情的描述信息 paul add 这块的数据还没确定
     */
    public function getSolutionDetails()
    {
        //后期拓展可加上sku或者产品清单的筛选
        $solution_detail_obj = new SolutionDetailDescription();
        $detailDescIns = $solution_detail_obj
            ->where(['solution_id'=>$this ->solution_id])
            ->select('description')
            ->first();

        if (!$detailDescIns) {
            return [];
        }

        $detailData = json_decode(parent::getTranDescription($detailDescIns), true);

        foreach ($detailData as $key => $val) {
            if ($val['type'] == 'tag01') {
                foreach ($val['list'] as $sk => $sv) {
                    $scene_arr = get_products_tag_by_ids(array($sv['tag']));
                    $detailData[$key]['list'][$sk]['scene'] = $scene_arr[$sv['tag']];
                }
            }
        }

        return $detailData;
    }

    /***
     * @note 检查页面是否存在否则做相关跳转 paul add
     */
    protected function judgePage()
    {
        $solutionIns = $this ->sl_m
            ->where(['id'=>$this ->solution_id,'is_show'=>1])
            ->select(['title','is_new','model'])
            ->first();
        if (!$solutionIns) {
            //没有查到符合条件的solution跳转404页面
            header('HTTP/1.1 404 Not Found');
            zen_redirect(zen_href_link(FILENAME_PAGE_NOT_FOUND));
        }

        $this ->outArr['solutionInfo']['title'] = parent::getTranDescription($solutionIns);
        $this ->outArr['solutionInfo']['model'] = parent::getTranDescription($solutionIns, 'model');
        $this ->outArr['solutionInfo']['is_new'] = $solutionIns['is_new'];
    }
}
