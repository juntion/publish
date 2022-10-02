<?php

namespace Modules\Share\Console;

use Illuminate\Console\Command;
use Modules\Share\Entities\ResourceCategory;

class FixCategoryErrorData extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'share:fix-category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '修复初始化数据错误(此命令已废弃)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $deleteCate = [
            '25G/40G/51G 光模块', '25G/40G/52G 光模块', '25G/40G/53G 光模块', '25G/40G/54G 光模块', '25G/40G/55G 光模块',
            '25G/40G/56G 光模块',
            '10G/16G/33G 光模块', '10G/16G/34G 光模块', '10G/16G/35G 光模块', '10G/16G/36G 光模块', '10G/16G/37G 光模块',
            '10G/16G/38G 光模块', '10G/16G/39G 光模块',
            '100G/397G 光模块', '100G/398G 光模块', '100G/399G 光模块', '100G/396G 光模块',
            'FMT 11G光传输系统', 'FMT 12G光传输系统', 'FMT 13G光传输系统', 'FMT 14G光传输系统', 'FMT 15G光传输系统', 'FMT 16G光传输系统',
            'M6501系列OTN设备', 'M6502系列OTN设备',
            'M6201系列WDM设备', 'M6202系列WDM设备', 'M6203系列WDM设备', 'M6204系列WDM设备', 'M6205系列WDM设备', 'M6206系列WDM设备',
        ];


        $updateCate = [
            '100G/400G 光模块'   => [
                '100G QSFP28', '100G CFP/CFP2/CFP4', '100G 转换光模块', '400G QSFP-DD',
            ],
            '25G/40G/50G 光模块' => [
                '25G BiDi SFP28', '25G WDM SFP28', '40G QSFP+', '40G 转换光模块', '50G QSFP28', 'Customized 40G/25G'
            ],
            '10G/16G/32G 光模块' => [
                '10G BiDi SFP+', '10G CWDM SFP+', '10G DWDM SFP+', '10G XFP/X2/XENPAK', '10G 转换光模块',
                '8G/10G/16G/32G FC', 'Customized 32G/16G/10G'
            ],
            'FMT 10G光传输系统'    => [
                ['FMT 11G光传输系统' => '光纤放大器'],
                ['FMT 12G光传输系统' => '色散补偿器'],
                ['FMT 13G光传输系统' => '光线路保护'],
                ['FMT 14G光传输系统' => 'DWDM 红/蓝波滤波器'],
                ['FMT 15G光传输系统' => '光监控'], 'FMT 管理&配件'
            ],
            'M6500系列OTN设备'    => [
                '100G 复用器', '机箱&配件'
            ],
            'M6200系列WDM设备'    => [
                'Mux Demux Cards',
                ['M6202系列WDM设备' => '光纤放大器'],
                ['M6203系列WDM设备' => '色散补偿器'],
                ['M6204系列WDM设备' => '光线路保护'],
                ['M6205系列WDM设备' => 'DWDM 红/蓝波滤波器'],
                '管理&配件'
            ]
        ];

        foreach ($updateCate as $key => $val) {
            $parent_uuid = ResourceCategory::query()->where('name', $key)->first()->uuid;
            foreach ($val as $item) {
                if (is_array($item)) {
                    $p_key = array_key_first($item);
                    $old_parent_uuid = ResourceCategory::query()->where('name', $p_key)->first()->uuid;
                    ResourceCategory::query()->where('name', $item[$p_key])->where('parent_uuid',
                        $old_parent_uuid)->update([
                        'parent_uuid'      => $parent_uuid,
                        'three_level_uuid' => $parent_uuid
                    ]);
                } else {
                    ResourceCategory::query()->where('name', $item)->update([
                        'parent_uuid'      => $parent_uuid,
                        'three_level_uuid' => $parent_uuid
                    ]);
                }
            }
        }
        ResourceCategory::query()->whereIn('name', $deleteCate)->forceDelete();
    }
}
