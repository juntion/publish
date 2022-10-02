<?php

namespace Modules\Route\Http\Controllers;

use Modules\Base\Contracts\ListServiceInterface;
use Modules\Route\Entities\Route;
use Modules\Route\Http\Requests\RoutesRequest;
use Modules\Route\Http\Resources\RouteCollection;

class RouteController extends Controller
{
    public function index(RoutesRequest $request, ListServiceInterface $listService)
    {
        $listService->setBuilder(new Route());
        $listService->setRequest($request);

        return new RouteCollection($listService->getResource());
    }
}
