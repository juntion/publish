<?php

namespace Modules\Route\Http\Controllers;

use Modules\Route\Entities\RouteMenu as Menu;
use Modules\Route\Entities\Route;
use Modules\Route\Contracts\RouteService;
use Modules\Route\Http\Requests\EditMenuRouteTreeRequest;
use Modules\Route\Http\Requests\DeleteMenuRouteTreeNodeRequest;

class MenuRouteTreeController extends Controller
{
    public function tree($guard, RouteService $routeService)
    {
        $menus = Menu::where('guard_name', $guard)->with('routes')->get();

        return $this->successWithData(['tree' => $routeService->menuRouteToTree($menus)]);
    }

    public function update(EditMenuRouteTreeRequest $request, $guard)
    {
        $formParentUuid = $request->input('form_parent_uuid') ?: null;
        $toParentUuid = $request->input('to_parent_uuid') ?: null;
        $nodeUuid = $request->input('node_uuid');
        $type = $request->input('node_type');
        $sort = $request->input('sort');

        if ($formParentUuid != $toParentUuid) {
            if ($type == 'menu') {
                Menu::find($nodeUuid)->update(['parent_uuid' => $toParentUuid]);
            }
            if ($type == 'route') {
                Route::find($nodeUuid)->menus()->updateExistingPivot($formParentUuid, ['route_menu_uuid' => $toParentUuid]);
            }
        }

        $this->updateSort($sort);

        return $this->success();
    }

    public function destroyNode(DeleteMenuRouteTreeNodeRequest $request, $guard, $uuid)
    {
        $type = $request->input('node_type');
        $parentUuid = $request->input('parent_uuid') ?: null;
        $sort = $request->input('sort');

        if ($type == 'menu') {
            $menu = Menu::where(['guard_name' => $guard, 'uuid' => $uuid])->first();
            $menu->menuRouteTreeDelete();
        }

        if ($type == 'route') {
            Menu::find($parentUuid)->routes()->detach($uuid);
        }

        $this->updateSort($sort);

        return $this->deleteSuccess();
    }

    public function updateSort($sort)
    {
        foreach ($sort as $node) {
            if ($node['node_type'] == 'menu') {
                Menu::find($node['uuid'])->update(['sort' => $node['sort']]);
            }
            if ($node['node_type'] == 'route') {
                Menu::find($node['parent_uuid'])->routes()->updateExistingPivot($node['uuid'], ['sort' => $node['sort']]);
            }
        }
    }

}
