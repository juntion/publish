<?php

namespace Modules\Route\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Modules\Route\Contracts\RouteService;
use Modules\Route\Entities\RouteMenu as Menu;
use Modules\Route\Http\Requests\CreateMenuRequest;
use Modules\Route\Http\Requests\EditMenuRequest;
use Modules\Route\Http\Requests\AddMenuRoutesRequest;
use Modules\Route\Http\Resources\MenuResource;
use Modules\Route\Http\Resources\RouteCollection;

class MenuController extends Controller
{
    /**
     * 获取当前登录用户的，首页和侧边栏
     *
     * @param Request $request
     * @param RouteService $routeService
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchMenu(Request $request , RouteService $routeService)
    {
        $user = $request->user();

        $data = [];
        $data['index'] = $routeService->getUserIndexRoute($user);
        $data['menu'] = $routeService->getUserMenu($user);
        $data['routes'] = $routeService->getUserRoutes($user);

        return $this->successWithData($data);
    }

    public function store(CreateMenuRequest $request)
    {
        $guardName = $request->post('guard_name');
        $parentUuid = $request->post('parent_uuid') ?: null;
        $sort = Menu::where(['guard_name' => $guardName, 'parent_uuid' => $parentUuid])->count();

        if ($parentUuid) {
            $sort += Menu::find($parentUuid)->routes()->count();
        }

        $menu = Menu::create([
            'uuid' => Str::uuid()->getHex()->toString(),
            'parent_uuid' => $parentUuid,
            'guard_name' => $guardName,
            'name' => $request->post('name'),
            'icon' => $request->post('icon') ?: '',
            'locale' => $request->post('locale'),
            'comment' => $request->post('comment') ?: '',
            'sort' => $sort,
        ])->refresh();

        return new MenuResource($menu);
    }

    public function update(EditMenuRequest $request, $uuid)
    {
        $menu = Menu::where('uuid', $uuid)->first();

        if ($menu->name != $request->input('name')) {
            $request->validate(['name' => 'unique:route_menus']);
        }

        $flag = $menu->update([
            'name' => $request->input('name'),
            'icon' => $request->input('icon') ?: '',
            'locale' => $request->input('locale'),
            'comment' => $request->input('comment') ?: '',
        ]);
        return $flag ? new MenuResource($menu) : $this->failed();
    }

    public function routes($uuid)
    {
        $menu = Menu::find($uuid);
        return new RouteCollection($menu->routes);
    }

    public function addRoutes(AddMenuRoutesRequest $request, $uuid)
    {
        $routes = $request->input('routes');

        $menu = Menu::find($uuid);
        $sort = $menu->children()->count() + $menu->routes()->count();

        $addRoutes = [];
        foreach ($routes as $k => $routeUuid) {
            $addRoutes[$routeUuid] = ['sort' => $sort + $k];
        }

        $menu->routes()->syncWithoutDetaching($addRoutes);
        return $this->successWithMessage();
    }
}
