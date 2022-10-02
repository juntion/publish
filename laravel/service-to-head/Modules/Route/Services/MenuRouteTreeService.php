<?php

namespace Modules\Route\Services;

use Illuminate\Database\Eloquent\Collection;
use Modules\Base\Entities\User;
use Modules\Permission\Contracts\PermissionRepository;
use Modules\Route\Contracts\RouteRepository;
use Modules\Route\Contracts\RouteService;

class MenuRouteTreeService implements RouteService
{
    public $routeRepository;

    public function __construct(RouteRepository $routeRepository)
    {
        $this->routeRepository = $routeRepository;
    }

    public function getUserIndexRoute(User $user){
        return $this->routeRepository->getUserIndexRouteOrCache($user, function () use ($user) {
            return $this->routeRepository->getIndexRoute(app()->make(PermissionRepository::class)->getUserIndexPermission($user));
        });
    }

    public function getUserMenu(User $user){
        $tree = $this->routeRepository->getUserMenuOrCache($user, function () use ($user) {
            return $this->getMenuRouteTree(app()->make(PermissionRepository::class)->getUserRoutePermission($user));
        });

        return $this->treeChildrenSort($tree);
    }

    public function getUserRoutes(User $user)
    {
        return $this->routeRepository->getRoutesByPermissions(app()->make(PermissionRepository::class)->getUserRoutePermission($user));
    }

    public function getMenuRouteTree(Collection $permissions)
    {
        $treeData = [];

        list($routes, $menus, $menuToRoute) = $this->routeRepository->getMenuRouteData($permissions);

        foreach ($menus as $menu) {

            $routeList = [];
            if ($menuToRoute->has($menu->uuid)) {
                $menuToRoute->get($menu->uuid)->each(function ($menuRoute) use (&$routeList, $routes) {
                    $routeList[] = array_merge($routes->get($menuRoute->route_uuid)->attributesToArray(), [
                        'node_type' => 'route',
                        'parent_uuid' => $menuRoute->route_menu_uuid,
                        'sort' => $menuRoute->sort
                    ]);
                });
            }

            $treeData[$menu->uuid] = array_merge($menu->attributesToArray(), [
                'node_type' => 'menu',
                'children' => $routeList,
            ]);
        }

        $tree = $this->arrayToTree($treeData);

        return $this->treeChildrenSort($tree);
    }

    public function menuRouteToTree(Collection $menus)
    {
        $menuRouteNode = [];
        foreach ($menus as $menu) {
            $menuRouteNode[$menu->uuid] = $menu->attributesToArray();
            $menuRouteNode[$menu->uuid]['node_type'] = 'menu';
            $menuRouteNode[$menu->uuid]['children'] = [];

            if ($menu->routes->count()) {
                foreach ($menu->routes as $route) {
                    $menuRouteNode[$menu->uuid]['children'][] = array_merge(
                        $route->attributesToArray(),
                        [
                            'node_type' => 'route',
                            'parent_uuid' => $route->menu_route->route_menu_uuid,
                            'sort' => $route->menu_route->sort,
                        ]
                    );
                }
            }
        }

        $tree = $this->arrayToTree($menuRouteNode);

        return $this->treeChildrenSort($tree);
    }

    /**
     * 将数组转化成有层级结构的数组，树状结构的数组
     * @param $arr
     * @return array
     */
    private function arrayToTree($arr){
        foreach ($arr as &$node) {
            if ($node['parent_uuid']) {
                $arr[$node['parent_uuid']]['children'][] = &$node;
            }
        }

        $arr = collect($arr)->filter(function ($n) {
            return !$n['parent_uuid'];
        })->values()->toArray();

        return $arr;
    }

    /**
     * 递归排序数组
     *
     * @param  array $treeArr
     * @return array
     */
    private function treeChildrenSort($treeArr)
    {
        $treeArr = collect($treeArr)->sortBy('sort')->all();
        foreach ($treeArr as &$item) {
            if (isset($item['children']) && sizeof($item['children'])) {
                $item['children'] = $this->treeChildrenSort($item['children']);
            }
        }

        return array_values($treeArr);
    }
}
