<?php

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentCodeSeeder extends Seeder
{
    /**
     * 填充部门代码
     */
    public function run()
    {
        foreach (self::DEPARTMENT_CODES as $name => $code) {
            $dept = Department::query()->where('is_base', 1)->where('name', $name)->first();
            if ($dept) {
                $dept->update(['code' => $code]);
            }
        }
    }

    // 部门名称 => 代码
    const DEPARTMENT_CODES = [
        '总经办' => 'ZJ',
        '财务部' => 'CW',
        '行政部' => 'XZ',
        '人力资源部' => 'RS',
        '证券事务部' => 'ZQ',
        '知识产权部' => 'CQ',
        '政府事务部' => 'ZF',
        '内控管理部' => 'NK',
        '英文销售部' => 'XS-EN',
        '多语言销售部' => 'XS-MU',
        '中文销售部' => 'XS-CN',
        '管理培训团队' => 'XS-TR',
        '平台服务团队' => 'XS-PL',
        '销售系统团队' => 'XS-IT',
        '业务审核团队' => 'XS-AP',
        '销售服务中心' => 'XS-SE',
        '邮件团队' => 'XS-MT',
        '销售策略中心' => 'XS-ST',
        '系统开发部' => 'KF',
        '系统分析部' => 'FX',
        '用户分析部' => 'YH',
        '网络设计部' => 'WS',
        '品牌设计部' => 'PS',
        '媒体视觉部' => 'SJ',
        '技术测试部' => 'CS',
        '技术服务部' => 'FW',
        '技术支持部' => 'JS',
        '产品研发部' => 'CY',
        '项目管理部' => 'XM',
        '方案研发部' => 'FY',
        '产品部' => 'CP',
        '工业设计部' => 'GY',
        '品牌营销部' => 'PP',
        '采购部' => 'CG',
        '新品策略部' => 'CG',
        '产品软件部' => 'RJ',
        '品质分析部' => 'PK',
        '仓管部' => 'CK',
        '物流部' => 'WL',
        '海外运营部' => 'YY',
        '海外市场部' => 'SC',
        'North-America-Branches' => 'US',
        'German-Branch' => 'DE',
        'UK-Branch' => 'UK',
        'AU-Branch' => 'AU',
        'Russian-Branch' => 'RU',
        'SG-Branch' => 'SG',
    ];
}
