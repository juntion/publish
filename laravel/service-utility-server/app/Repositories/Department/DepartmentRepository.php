<?php

namespace App\Repositories\Department;

use App\Models\Department;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class DepartmentRepository extends BaseRepository
{
    protected $model;

    protected $allowedSearches = ['id', 'name'];

    protected $allDepartments;
    protected $hasChildrenDept;

    public function __construct(Department $department)
    {
        $this->model = $department;
    }

    public function getDepartments($id)
    {
        return $this->model->where('parent_id', $id)->get();
    }

    /**
     * 获取部门下所有用户
     * @param $department
     * @return Collection
     */
    public function getUser(Department $department)
    {
        $deptData = Department::query()
            ->where('path', 'like', $department->path . $department->id . '-%')
            ->get();
        $deptData = $deptData->push($department);
        $deptData->load(['users', 'users.company']);

        $users = collect();
        foreach ($deptData as $dept) {
            $users = $users->merge($dept->users);
        }
        return $users;
    }

    /**
     * @param $id
     * @return array
     * @author: King
     * @version: 2020/4/29 11:22
     */
    public function getAllDepartments($id)
    {
        $dept = $this->model->newQuery()->find($id);
        return $this->model->newQuery()
            ->where('path', 'like', $dept->path . $dept->id . '-%')
            ->get()
            ->toArray();
    }

    /**
     * 部门树结构
     * @param int $parentId
     * @return mixed
     */
    public function tree($parentId = 0)
    {
        $this->allDepartments = $this->model->all();
        $this->hasChildrenDept = $this->allDepartments->pluck('parent_id')->unique()->toArray();
        $department = $this->allDepartments->where('parent_id', $parentId);
        $result = $this->getTree($department);
        return $result['tree'];
    }

    /**
     * @param Collection $collection
     * @param string $keySub
     * @return array
     */
    public function getTree(Collection $collection, $keySub = 'children')
    {
        $tree = $list = [];
        foreach ($collection as $item) {
            $list[] = $item->toArray();
            $tmp['tree'] = [];
            $tmp['list'] = [];
            // 排除掉没有下级的部门
            if (in_array($item->id, $this->hasChildrenDept)) {
                $children = $this->allDepartments->where('parent_id', $item->id);
                $tmp = $this->getTree($children, $keySub);
            }
            $data = array_merge(collect($item->toArray())->forget('children')->toArray(), [$keySub => $tmp['tree']]);
            $tree[] = $data;
            $list = array_merge($list, $tmp['list']);
        }
        return ['tree' => $tree, 'list' => $list];
    }
}
