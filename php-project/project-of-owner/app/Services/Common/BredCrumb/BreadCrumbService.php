<?php


namespace App\Services\Common\BredCrumb;

use App\Services\BaseService;
use App\Services\Common\BredCrumb\BreadCrumbBaseService;

/**
 * 面包屑
 *
 * @author aron
 * @date 2019.11.13
 * Class BreadCrumbService
 * @package App\Services\Common\BredCrumb
 */
class BreadCrumbService extends BaseService
{
    public $breadcrumbs;

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs = new BreadCrumbBaseService();
        $this->breadcrumbs->setDivider(' <i class="iconfont icon">/</i>')
            ->addCssClasses('after')
            ->setListItemCssClass('alone_a');
    }

    /**
     * 生成面包屑
     *
     * @author aron
     * @date 2019.11.11
     * @param array $add
     * @return string
     */
    public function createBredCrumb($add = [])
    {
        if ($this->language_id == 1) {
            $this->language_code = '';
        }
        if ($this->language_code == 'dn') {
            $this->language_code = 'de-en';
        }
        $this->breadcrumbs->addCrumb(self::trans('ACCOUNT_MY_HOME'), '/' . $this->language_code);
        if (!empty($add)) {
            foreach ($add as $i => $item) {
                $this->breadcrumbs->addCrumb($i, $item);
            }
        }
        return $this->breadcrumbs->render();
    }
}
