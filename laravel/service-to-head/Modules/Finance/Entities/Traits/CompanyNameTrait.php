<?php


namespace Modules\Finance\Entities\Traits;


trait CompanyNameTrait
{
    protected $companyPool = [];

    public function getCompanyName($producsInstock)
    {
        $companyId = $this->getCompanyId($producsInstock);

        return $this->getNameByIdFromPool($companyId);
    }


    protected function toSeattleCompany()
    {
        return [
            1 => 3, //美国
            3 => 1, //德国
            4 => 4, //澳洲
            5 => 3, //美国
            6 => 5, //英国'
            7 => 6, //新加坡
            8 => 7, //俄罗斯
        ];
    }
    /**
     * @return int[]|mixed
     */
    protected function toTransportCompany()
    {
        return [
            2 => 3, //美国
            3 => 1, //德国
            4 => 4, //澳洲
            5 => 3, //美国
            8 => 7, //俄罗斯
            9 => 6, //新加坡
        ];
    }

    protected function getNameByIdFromPool($id)
    {
        if(!array_key_exists($id, $this->companyPool)){
            $companyRes = $this->orderCompanyRepository->getCompanyBaseInfo($id);
            if (is_null($companyRes)) {
                $this->companyPool[$id] = '';
            } else {
                $this->companyPool[$id] = $companyRes->name;
            }
        }
        return $this->companyPool[$id];
    }

    public function getCompanyId($producsInstock)
    {
        $seattle = $producsInstock->is_seattle;
        $notTransport = $producsInstock->is_not_transport;
        if ($seattle) {
            $companyId = $this->toSeattleCompany()[$seattle];
        } elseif ($notTransport > 1) {
            $companyId = $this->toTransportCompany()[$notTransport];
        } else {
            $companyId = 10;//国内直发的统一算深圳公司
        }
        return $companyId;
    }
}
