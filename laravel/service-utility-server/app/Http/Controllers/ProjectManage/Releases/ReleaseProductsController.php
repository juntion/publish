<?php

namespace App\Http\Controllers\ProjectManage\Releases;

use App\Exceptions\System\InvalidParameterException;
use App\Exceptions\System\InvalidStatusException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectManage\Releases\ReleaseProductAddVersions;
use App\Http\Requests\ProjectManage\Releases\ReleaseProductStore;
use App\ProjectManage\Models\ReleaseProduct;
use App\ProjectManage\Repositories\Releases\ReleaseProductRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ReleaseProductsController extends Controller
{
    /**
     * @var ReleaseProductRepository
     */
    private $releaseProduct;

    public function __construct(ReleaseProductRepository $releaseProduct)
    {
        parent::__construct();

        $this->releaseProduct = $releaseProduct;
    }

    /**
     * @param ReleaseProductStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ReleaseProductStore $request)
    {
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $this->releaseProduct->store($data);
        } catch (\Exception $e) {
            DB::rollBack();
            if ($e instanceof InvalidParameterException) {
                return $this->failedWithMessage($e->getMessage());
            }
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * @param ReleaseProductStore $request
     * @param ReleaseProduct $releaseProduct
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ReleaseProductStore $request, ReleaseProduct $releaseProduct)
    {
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $this->releaseProduct->update($releaseProduct, $data);
        } catch (\Exception $e) {
            DB::rollBack();
            if ($e instanceof InvalidParameterException) {
                return $this->failedWithMessage($e->getMessage());
            }
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * @param ReleaseProduct $releaseProduct
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(ReleaseProduct $releaseProduct)
    {
        DB::beginTransaction();
        try {
            $this->releaseProduct->delete($releaseProduct);
        } catch (InvalidStatusException | InvalidParameterException $e) {
            $errCode = ($e instanceof InvalidParameterException) ? Response::HTTP_NOT_ACCEPTABLE : Response::HTTP_BAD_REQUEST;
            return $this->failedWithMessage($e->getMessage(), $errCode);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * @param Request $request
     * @param ReleaseProduct $releaseProduct
     * @return \Illuminate\Http\JsonResponse
     */
    public function status(Request $request, ReleaseProduct $releaseProduct)
    {
        $data = $request->validate([
            'status' => 'required|between:0,1',
            'comment' => 'required|string',
        ], [], [
            'status' => '状态',
            'comment' => '操作说明',
        ]);
        try {
            $this->releaseProduct->status($releaseProduct, $data);
        } catch (\Exception $e) {
            return $this->failedWithMessage($e->getMessage());
        }
        return $this->success();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $res = $this->releaseProduct->list($request);
        return $this->successWithData(['release_products' => $res]);
    }

    /**
     * @param ReleaseProduct $releaseProduct
     * @return \Illuminate\Http\JsonResponse
     */
    public function details(ReleaseProduct $releaseProduct)
    {
        $res = $this->releaseProduct->details($releaseProduct);
        return $this->successWithData(['release_product' => $res]);
    }

    /**
     * @param ReleaseProduct $releaseProduct
     * @return \Illuminate\Http\JsonResponse
     */
    public function logs(ReleaseProduct $releaseProduct)
    {
        return $this->successWithData(['status_logs' => $releaseProduct->logs()]);
    }

    /**
     * @param ReleaseProductAddVersions $request
     * @param ReleaseProduct $releaseProduct
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function addVersions(ReleaseProductAddVersions $request, ReleaseProduct $releaseProduct)
    {
        $this->checkPolicy($releaseProduct, __FUNCTION__);
        DB::beginTransaction();
        try {
            $this->releaseProduct->addVersions($releaseProduct, $request->validated());
        } catch (\Exception $e) {
            DB::rollBack();
            if ($e instanceof InvalidParameterException) {
                return $this->failedWithMessage($e->getMessage());
            }
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * @param ReleaseProduct $releaseProduct
     * @return \Illuminate\Http\JsonResponse
     */
    public function versionList(ReleaseProduct $releaseProduct)
    {
        $res = $this->releaseProduct->versionList($releaseProduct);
        return $this->successWithData(['release_versions' => $res]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function admins()
    {
        $res = $this->releaseProduct->admins();
        return $this->successWithData($res);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function statistics()
    {
        $res = $this->releaseProduct->statistics();
        return $this->successWithData(['statistics_data' => $res]);
    }
}
