<?php

use Illuminate\Support\Collection;

class DepartmentSeeder extends BaseSeeder
{
    const TABLE = 'fs_basic_data';
    const MODEL = \App\Models\Department::class;

    public function handel()
    {
        $this->setModel(self::MODEL);
        // fs_data_type 类型,1:公司部门 4部门分组
        $departments = $this->db->table(self::TABLE)->where('fs_data_type', 1)->orderBy('fs_data_id')->get();
        // 获取部门树结构
        $departments = $this->getTree($departments)['tree'];

        try {
            // 将部门结构写入数据库
            $this->insetData($departments);
        } catch (\Exception $e) {
            \Log::error('迁移部门失败', [$e->getMessage()]);
        }
    }

    public function getTree(Collection $collection, $keySub = 'children')
    {
        $tree = $list = [];
        foreach ($collection as $item) {
            $list[] = $item;
            $children = $this->db->table(self::TABLE)
                ->where('fs_data_type', 4)->orderBy('fs_data_id')->where('parent_id', $item->fs_data_id)->get();
            $tmp = $this->getTree($children, $keySub);
            $data = array_merge(collect($item)->forget('children')->toArray(), [$keySub => $tmp['tree']]);
            $tree[] = $data;
            $list = array_merge($list, $tmp['list']);
        }
        return ['tree' => $tree, 'list' => $list];
    }

    protected function insetData($departments, $parentId = 0)
    {
        foreach ($departments as $item) {
            $data = [
                'name' => $item['fs_data_name'],
                'parent_id' => $parentId,
                'locale' => json_encode([
                    'en' => $item['fs_data_name'],
                    'zh-CN' => $item['fs_data_name'],
                ]),
                'origin_id' => $item['fs_data_id'],
            ];
            // 基础部门
            if ($item['fs_data_type'] == 1) {
                $data['is_base'] = 1;
            }
            $department = $this->model->create($data);
            // 存在子部门，递归插入
            if (!empty($item['children'])) {
                $this->insetData($item['children'], $department->id);
            }
        }
    }
}
