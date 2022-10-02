<?php

namespace App\Exports;

use App\Enums\ProjectManage\DesignSubTaskStatus;
use App\Enums\ProjectManage\ProductStatus;

trait PMExportTrait
{
    /**
     * 是否有日期搜索
     * @return bool
     */
    protected function hasDateSearch(): bool
    {
        $search = request()->input('search');
        return $search && isset($search['created_at']);
    }

    /**
     * 设置公共部分
     * @param $workSheet
     * @param $lastColumn
     */
    public function setCommonPart($workSheet, $lastColumn)
    {
        $this->setMainTitle($workSheet, $lastColumn);
        $this->setDateCell($workSheet);
        $this->setHeaders($workSheet, $lastColumn);
    }

    /**
     * 设置主标题
     * @param $workSheet
     * @param $column
     */
    protected function setMainTitle($workSheet, $column)
    {
        $workSheet->getCell('A1')->setValue($this->title());
        $workSheet->mergeCells("A1:{$column}1");
        $workSheet->getRowDimension(1)->setRowHeight(50);
        $workSheet->getStyle("A1:{$column}1")->getAlignment()->setHorizontal('center')->setVertical('center');
        $workSheet->getStyle("A1:{$column}1")->getFont()->setBold(true)->setName('宋体')->setSize(18);
    }

    /**
     * 设置日期行
     * @param $workSheet
     */
    protected function setDateCell($workSheet)
    {
        if ($this->hasDateSearch()) {
            $date = explode(',', request()->input('search')['created_at']);
            $workSheet->getCell('A2')->setValue('日期：');
            $workSheet->getCell('B2')->setValue("自 {$date[0]} 至 {$date[1]}");
            $workSheet->getRowDimension(2)->setRowHeight(30);
            $workSheet->mergeCells('B2:D2');
            $workSheet->getStyle('A2:D2')->getAlignment()->setVertical('center');
            $workSheet->getStyle('A2:D2')->getFont()->setBold(true)->setName('微软雅黑')->setSize(10);
        }
    }

    /**
     * 设置表头
     * @param $workSheet
     * @param $column
     */
    protected function setHeaders($workSheet, $column)
    {
        for ($i = 0; $i < count($this->headers); $i++) {
            $workSheet->getCell(chr(65 + $i) . $this->headLine())->setValue($this->headers[$i]);
        }
        $workSheet->getStyle('A' . $this->headLine() . ':' . $column . $this->headLine())->getAlignment()->setVertical('center');
        $workSheet->getStyle('A' . $this->headLine() . ':' . $column . $this->headLine())->getFont()->setBold(true)->setName('微软雅黑')->setSize(10);
    }

    /**
     * 表格标题所在行
     * @return int
     */
    protected function headLine(): int
    {
        return $this->hasDateSearch() ? 3 : 2;
    }

    /**
     * 项目来源
     * @param $hasProject
     * @return string
     */
    protected function projectSource($hasProject)
    {
        $res = '';
        if ($hasProject->source_project_id) {
            $res .= 'XM:' . $hasProject->project->number . PHP_EOL;
            $res .= '标题:' . $hasProject->project->name;
        }
        return $res ? $res : '-';
    }

    /**
     * 导出文件名
     * @return string
     */
    public function exportFileName(): string
    {
        return $this->title() . '_' . date('YmdHis') . '.xlsx';
    }

    protected function getProducts($hasDemand)
    {
        if ($demand = $hasDemand->demand) {
            $products = $demand->products->whereIn('type', [ProductStatus::TypeLine, ProductStatus::TypeProduct]);
            return implode(PHP_EOL, $products->pluck('name')->toArray());
        }
        return '-';
    }

    protected function getDemandInfo($hasDemand)
    {
        if ($demand = $hasDemand->demand) {
            return "XQ:{$demand->number}" . PHP_EOL . "标题:{$demand->name}";
        }
        return '-';
    }

    private function getFinishDesc($subTask)
    {
        if (empty($subTask)) return '-';
        // 不显示
        if ($subTask->remaining_days === "") {
            return "";
        }
        // 进行中
        if ($subTask->remaining_days_type == 0) {
            if ($subTask->remaining_days >= 0) {
                return '还剩' . $subTask->remaining_days . '天';
            }
            if ($subTask->remaining_days < 0) {
                return '超时' . abs($subTask->remaining_days) . '天';
            }
        }
        // 已提交
        if ($subTask->remaining_days_type == 1) {
            if ($subTask->remaining_days > 0) {
                return '提前' . $subTask->remaining_days . '天';
            }
            if ($subTask->remaining_days < 0) {
                return '超时' . abs($subTask->remaining_days) . '天';
            }
            return '按时提交';
        }
        // 已完成
        if ($subTask->remaining_days_type == 2) {
            // 新增了 finish_type 字段，此处需要做兼容处理
            if (!empty($subTask->finish_type)) {
                return DesignSubTaskStatus::getFinishTypeDesc($subTask->finish_type);
            }

            if ($subTask->remaining_days > 0) {
                return '提前' . $subTask->remaining_days . '天';
            }
            if ($subTask->remaining_days < 0) {
                return '超时' . abs($subTask->remaining_days) . '天';
            }
            return '按时完成';
        }
    }

    /**
     * @param $user
     * @return mixed
     */
    public function getBasicDept($user)
    {
        $basicDept = $user->departments->where('parent_id', 0);
        if ($basicDept->count() == 1) {
            return $basicDept->first()->name;
        }
        return $user->basicDepartment->name;
    }
}
