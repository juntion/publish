<?php

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 10, 'number' => '01', 'company_name' => '深圳宇轩网络技术有限公司'],
            ['id' => 8, 'number' => '02', 'company_name' => 'FS.COM LIMITED（香港公司）'],
            ['id' => 9, 'number' => '03', 'company_name' => '深圳市宇轩网络技术有限公司武汉分公司'],
            ['id' => 1, 'number' => '04', 'company_name' => '宇轩网络技术（德国）有限公司'],
            ['id' => 4, 'number' => '05', 'company_name' => '宇轩网络技术（澳大利亚）有限公司'],
            ['id' => 6, 'number' => '06', 'company_name' => '宇轩网络技术（新加坡）有限公司'],
            ['id' => 5, 'number' => '07', 'company_name' => '宇轩网络技术（英国）有限公司'],
            ['id' => 7, 'number' => '08', 'company_name' => '宇轩网络技术（俄罗斯）有限公司'],
            ['id' => 2, 'number' => '09', 'company_name' => '美西公司'],
            ['id' => 3, 'number' => '10', 'company_name' => '宇轩网络技术（美国）有限公司'],
            ['id' => 11, 'number' => '11', 'company_name' => '武汉宇轩飞速通信技术有限公司'],
        ];
        $companies = Company::all()->pluck('number')->toArray();
        foreach ($data as $item) {
            if (!in_array($item['number'], $companies)) {
                Company::query()->create($item);
            }
        }
    }
}
