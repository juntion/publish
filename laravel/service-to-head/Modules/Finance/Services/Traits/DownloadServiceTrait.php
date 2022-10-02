<?php


namespace Modules\Finance\Services\Traits;


use Illuminate\Database\Eloquent\Builder;

trait DownloadServiceTrait
{
    public function apply(Builder $model)
    {
        $filter = $this->filter;
        $allowFilter = $this->request->allowFilter();
        $allowSort = $this->request->allowSort();

        if (sizeof($filter)) {
            foreach ($filter as $key => $value) {
                if (is_null($value)) {
                    continue;
                }
                if (in_array($key, $allowFilter)) {
                    if ($this->request->isScopeQuery($key)) {
                        $model = $model->where(function ($q)use ($key, $value){
                            return $this->request->mappingScopeQuery($q, $key, $value);
                        });
                    } else {
                        $model = $model->where($key, $value);
                    }
                }
            }
        }

        if (sizeof($this->sort)) {
            foreach ($this->sort as $key => $value) {
                if (in_array($key, $allowSort)) $model = $model->orderBy($key, $value);
            }
        }

        return $model;
    }

    /**
     * 根据数值判断对应的Excel列      起始数是0   即0=A  25=Z  26=AA
     */
    public static function getLetterColumn($num, &$left = '')
    {
        $num = $num + 1;
        $perfix = 0;
        if ($num > 26) {
            $perfix = floor($num / 26);
            $hand = $num % 26 == 0 ? 26 : $num % 26;
            $perfix = $num % 26 == 0 ? ($perfix - 1) : $perfix;
        } else {
            $hand = $num;
        }
        switch ($hand) {
            case 1:
                $handLette = 'A';
                break;
            case 2:
                $handLette = 'B';
                break;
            case 3:
                $handLette = 'C';
                break;
            case 4:
                $handLette = 'D';
                break;
            case 5:
                $handLette = 'E';
                break;
            case 6:
                $handLette = 'F';
                break;
            case 7:
                $handLette = 'G';
                break;
            case 8:
                $handLette = 'H';
                break;
            case 9:
                $handLette = 'I';
                break;
            case 10:
                $handLette = 'J';
                break;
            case 11:
                $handLette = 'K';
                break;
            case 12:
                $handLette = 'L';
                break;
            case 13:
                $handLette = 'M';
                break;
            case 14:
                $handLette = 'N';
                break;
            case 15:
                $handLette = 'O';
                break;
            case 16:
                $handLette = 'P';
                break;
            case 17:
                $handLette = 'Q';
                break;
            case 18:
                $handLette = 'R';
                break;
            case 19:
                $handLette = 'S';
                break;
            case 20:
                $handLette = 'T';
                break;
            case 21:
                $handLette = 'U';
                break;
            case 22:
                $handLette = 'V';
                break;
            case 23:
                $handLette = 'W';
                break;
            case 24:
                $handLette = 'X';
                break;
            case 25:
                $handLette = 'Y';
                break;
            case 26:
                $handLette = 'Z';
                break;
            default:
                $handLette = '';
                break;
        }
        if ($perfix) {
            $left = self::getLetterColumn($perfix - 1, $left);
        }
        return $left . $handLette;
    }

    /**
     * 设置表头
     * @param $workSheet
     * @param $column
     */
    protected function setHeaders($workSheet, $column)
    {
        for ($i = 0; $i < count($this->headers); $i++) {
            $workSheet->getCell($this->getLetterColumn($i) . $this->headLine())->setValue(($this->headers)[$i]);
        }
        $workSheet->getStyle('A' . $this->headLine() . ':' . $column . $this->headLine())->getAlignment()->setVertical('center');
        $workSheet->getStyle('A' . $this->headLine() . ':' . $column . $this->headLine())->getFont()->setBold(true)->setName('微软雅黑')->setSize(10);
    }
}
