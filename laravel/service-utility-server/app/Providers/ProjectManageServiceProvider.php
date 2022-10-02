<?php

namespace App\Providers;

use App\Models\System\Media;
use App\Observers\AppealObserver;
use App\Observers\BugObserver;
use App\Observers\DemandLinksObserver;
use App\Observers\DemandObserver;
use App\Observers\DesignPartObserver;
use App\Observers\DesignSubTaskObserver;
use App\Observers\DesignTaskObserver;
use App\Observers\DevSubTaskObserver;
use App\Observers\DevTaskObserver;
use App\Observers\MediaObserver;
use App\Observers\ProductObserver;
use App\Observers\ProjectObserver;
use App\Observers\Releases\ReleaseProductObserver;
use App\Observers\Releases\ReleaseVersionObserver;
use App\Observers\TestSubTaskObserver;
use App\Observers\TestTaskObserver;
use App\ProjectManage\Models\Appeal;
use App\ProjectManage\Models\Bug;
use App\ProjectManage\Models\Demand;
use App\ProjectManage\Models\DemandLink;
use App\ProjectManage\Models\DesignPart;
use App\ProjectManage\Models\DesignSubTask;
use App\ProjectManage\Models\DesignTask;
use App\ProjectManage\Models\DevSubTask;
use App\ProjectManage\Models\DevTask;
use App\ProjectManage\Models\Product;
use App\ProjectManage\Models\Project;
use App\ProjectManage\Models\ReleaseProduct;
use App\ProjectManage\Models\ReleaseVersion;
use App\ProjectManage\Models\TestSubTask;
use App\ProjectManage\Models\TestTask;
use Illuminate\Support\ServiceProvider;

class ProjectManageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // 监听状态变化 记录日志
        Product::observe(ProductObserver::class);
        Appeal::observe(AppealObserver::class);
        Demand::observe(DemandObserver::class);
        DesignTask::observe(DesignTaskObserver::class);
        DesignSubTask::observe(DesignSubTaskObserver::class);
        DesignPart::observe(DesignPartObserver::class);
        DevTask::observe(DevTaskObserver::class);
        DevSubTask::observe(DevSubTaskObserver::class);
        TestTask::observe(TestTaskObserver::class);
        TestSubTask::observe(TestSubTaskObserver::class);
        DemandLink::observe(DemandLinksObserver::class);
        Project::observe(ProjectObserver::class);
        Bug::observe(BugObserver::class);
        Media::observe(MediaObserver::class);
        ReleaseProduct::observe(ReleaseProductObserver::class);
        ReleaseVersion::observe(ReleaseVersionObserver::class);
    }
}
