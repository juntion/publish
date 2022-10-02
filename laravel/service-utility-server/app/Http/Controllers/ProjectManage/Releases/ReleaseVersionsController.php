<?php

namespace App\Http\Controllers\ProjectManage\Releases;

use App\Exceptions\System\InvalidParameterException;
use App\Exceptions\System\InvalidStatusException;
use App\Exports\ReleaseVersionFeatureExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectManage\Releases\ReleaseVersionUpdate;
use App\ProjectManage\Models\ReleaseVersion;
use App\ProjectManage\Repositories\DropDownUserRepository;
use App\ProjectManage\Repositories\Releases\ReleaseVersionRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReleaseVersionsController extends Controller
{
    /**
     * @var ReleaseVersionRepository
     */
    private $releaseVersion;

    public function __construct(ReleaseVersionRepository $releaseVersion)
    {
        parent::__construct();

        $this->releaseVersion = $releaseVersion;
    }

    /**
     * @param ReleaseVersionUpdate $request
     * @param ReleaseVersion $releaseVersion
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidStatusException
     */
    public function update(ReleaseVersionUpdate $request, ReleaseVersion $releaseVersion)
    {
        $this->checkPolicy($releaseVersion, __FUNCTION__);
        $this->releaseVersion->update($releaseVersion, $request->validated());
        return $this->success();
    }

    /**
     * @param ReleaseVersion $releaseVersion
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function delete(ReleaseVersion $releaseVersion)
    {
        $this->checkPolicy($releaseVersion, __FUNCTION__);
        try {
            $this->releaseVersion->delete($releaseVersion);
        } catch (InvalidStatusException $e) {
            return $this->failedWithMessage($e->getMessage());
        } catch (InvalidParameterException $e) {
            return $this->failedWithMessage($e->getMessage(), Response::HTTP_NOT_ACCEPTABLE);
        } catch (\Exception $e) {
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->success();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVersionsByProduct(Request $request)
    {
        $request->validate([
            'product_id' => 'integer|exists:pm_products,id',
        ], [], [
            'product_id' => '产品ID',
        ]);
        $res = $this->releaseVersion->getVersionsByProduct($request);
        return $this->successWithData($res);
    }

    /**
     * @param ReleaseVersion $releaseVersion
     * @return \Illuminate\Http\JsonResponse
     */
    public function logs(ReleaseVersion $releaseVersion)
    {
        return $this->successWithData(['status_logs' => $releaseVersion->logs()]);
    }

    /**
     * @param ReleaseVersion $releaseVersion
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function releaseTest(ReleaseVersion $releaseVersion)
    {
        $this->checkPolicy($releaseVersion, __FUNCTION__);
        DB::beginTransaction();
        try {
            [$errMsg, $errData] = $this->releaseVersion->releaseTest($releaseVersion);
            if ($errMsg) {
                return $this->failedWithMessageAndErrors($errData, $errMsg);
            }
            // 创建新版本号
            $newVersion = $this->releaseVersion->createNewVersion($releaseVersion);
        } catch (\Exception $e) {
            DB::rollBack();
            if ($e instanceof InvalidParameterException) {
                return $this->failedWithMessage($e->getMessage(), Response::HTTP_NOT_ACCEPTABLE);
            }
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->successWithMessage('系统已自动创建了一个新的计划版本号,' . $newVersion->full_version);
    }

    /**
     * @param ReleaseVersion $releaseVersion
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function releaseOnline(ReleaseVersion $releaseVersion)
    {
        $this->checkPolicy($releaseVersion, __FUNCTION__);
        DB::beginTransaction();
        try {
            [$errMsg, $errData, $demands] = $this->releaseVersion->releaseOnline($releaseVersion);
            if ($errMsg) {
                return $this->failedWithMessageAndErrors($errData, $errMsg);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            if ($e instanceof InvalidParameterException) {
                return $this->failedWithMessage($e->getMessage(), Response::HTTP_NOT_ACCEPTABLE);
            }
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->successWithData([
            'version' => $releaseVersion->full_version,
            'demands' => $demands->pluck('number')->toArray(),
        ]);
    }

    /**
     * @param Request $request
     * @param ReleaseVersion $releaseVersion
     * @return \Illuminate\Http\JsonResponse
     */
    public function features(Request $request, ReleaseVersion $releaseVersion)
    {
        $features = $this->releaseVersion->features($releaseVersion, $request);
        return $this->successWithData($features);
    }

    /**
     * @param ReleaseVersion $releaseVersion
     * @param ReleaseVersionFeatureExport $export
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function featureExport(ReleaseVersion $releaseVersion, ReleaseVersionFeatureExport $export)
    {
        return Excel::download($export, $export->exportFileName());
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function modifyVersion(Request $request, $id)
    {
        $data = $request->validate([
            'task_type' => 'required|string',
            'release_type' => 'required|integer|between:0,2',
            'release_version_id' => 'integer|exists:pm_release_versions,id',
            'release_comment' => 'string|max:255',
        ], [], [
            'task_type' => '任务类型',
            'release_type' => '发版类型',
            'release_version_id' => '版本号',
            'release_comment' => '操作备注',
        ]);

        try {
            $this->releaseVersion->modifyVersion($id, $data);
        } catch (InvalidParameterException | InvalidStatusException $e) {
            return $this->failedWithMessage($e->getMessage());
        } catch (\Exception $e) {
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->success();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function confirmVersion(Request $request, $id)
    {
        try {
            $this->releaseVersion->confirmVersion($id);
        } catch (InvalidParameterException | InvalidStatusException $e) {
            return $this->failedWithMessage($e->getMessage());
        } catch (\Exception $e) {
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->success();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelConfirmVersion(Request $request, $id)
    {
        try {
            $this->releaseVersion->cancelConfirmVersion($id);
        } catch (InvalidParameterException | InvalidStatusException $e) {
            return $this->failedWithMessage($e->getMessage());
        } catch (\Exception $e) {
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->success();
    }

    /**
     * 任务发布测试
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function taskReleaseTest(Request $request, $id)
    {
        try {
            [$errMsg, $errData] = $this->releaseVersion->taskReleaseTest($id);
            if ($errMsg) {
                return $this->failedWithMessageAndErrors($errData, $errMsg);
            }
        } catch (InvalidParameterException $e) {
            return $this->failedWithMessage($e->getMessage(), Response::HTTP_NOT_ACCEPTABLE);
        } catch (InvalidStatusException $e) {
            return $this->failedWithMessage($e->getMessage());
        } catch (\Exception $e) {
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->success();
    }

    /**
     * 功能点的产品发布人
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function productPublisher()
    {
        $dropDownUser = app()->make(DropDownUserRepository::class);
        $users = $dropDownUser->getUsersByPermissions(['pm.demand.create', 'pm.tasks.design.store', 'pm.tasks.dev.store',
            'pm.tasks.frontend.store', 'pm.tasks.mobile.store']);
        return $this->successWithData(compact('users'));
    }
}
