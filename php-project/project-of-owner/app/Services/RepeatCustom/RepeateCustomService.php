<?php


namespace App\Services\RepeatCustom;

use App\Services\BaseService;
use App\Models\RepeatCustomDistribution;
use Illuminate\Database\Capsule\Manager as DB;

class RepeateCustomService extends BaseService
{
    private $repeateCustomObj;  // repeat_custom_distribution

    protected $applyDepartment = [
        '1' => [850, 857, 858, 851, 859, 860, 848, 853, 854, 849, 855, 856, 628, 844, 852, 861, 862],
        '2' => [850, 857, 858],
        '3' => [851, 859, 860],
        '4' => [848, 853, 854],
        '5' => [849, 855, 856],
        '8' => [852, 861, 862],
        '14' => [1112],
    ];

    public function __construct()
    {
        parent::__construct();
        $this->repeateCustomObj = new RepeatCustomDistribution();
    }

    /**
     *
     * @param array $allot_register_info 传递的参数
     * @param string $repeat_type
     * @return string
     */
    public function getRepeateApply($allot_register_info = [], $repeat_type = '')
    {
        $is_apply = $this->repeateCustomObj
            ->rightJoin('admin', 'repeat_custom_distribution.sale_id', '=', 'admin.admin_id')
            ->where('repeat_custom_distribution.examine_status', 1)
            ->where('repeat_custom_distribution.is_over', 0)
            ->where('repeat_custom_distribution.custom_type', $repeat_type);
        if (in_array($allot_register_info['language_id'], [1, 2, 3, 4, 5, 8, 14])) {
            if ($allot_register_info['language_id'] == 1) {
                $is_apply->whereNotIn('admin.department', $this->applyDepartment[1]);
            } else {
                $is_apply->whereIn('admin.department', $this->applyDepartment[1]);
            }
        }
        $info = $is_apply
            ->limit(1)
            ->get(['repeat_custom_distribution.id', 'repeat_custom_distribution.sale_id'])->toArray();
        return $info[0] ? $info[0] : [];
    }

    /**
     *
     * @param $allot_register_info
     * @param $compensate_at
     * @param $is_apply
     * @return mixed
     */
    public function updateRepeateDdistribution($allot_register_info, $compensate_at, $is_apply)
    {
        $result = $this->repeateCustomObj
            ->where('id', $is_apply)
            ->update([
                'compensate_at' => $compensate_at,
                'is_over' => 1,
                'compensate_email' => $allot_register_info['customers_email_address'],
                'phone' => $allot_register_info['customers_telephone'],
            ]);
        return $result;
    }
}
