<?php

namespace App\ProjectManage\Models;

use App\Enums\ProjectManage\ProductStatus;
use App\Enums\ProjectManage\TeamMemberType;
use App\Enums\ProjectManage\TeamType;
use App\Support\QueryBuilder\Filters\MayFilter;
use App\Support\QueryBuilder\Filters\MustFilter;
use App\Traits\DateFormatTrait;
use App\Traits\StatusLogTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use StatusLogTrait, DateFormatTrait;

    protected $table = 'pm_products';

    protected $fillable = ['name', 'description', 'status', 'type', 'parent_id', 'design_review', 'sort'];

    protected $appends = ['status_desc',];

    public function scopeIsOpen($query)
    {
        return $query->where('status', ProductStatus::STATUS_ON);
    }

    public function scopeIsLine($query)
    {
        return $query->where('type', ProductStatus::TypeLine);
    }

    public function getChildrenAttribute()
    {
        return Product::where('parent_id', $this->id)
            ->orderBy('status', 'desc')
            ->orderBy('sort', 'asc')
            ->get();
    }

    public function getParentAttribute()
    {
        return Product::query()->where('id', $this->parent_id)->first();
    }

    public function appeals()
    {
        return $this->belongsToMany(Appeal::class, 'pm_appeals_has_products');
    }

    public function demands()
    {
        return $this->belongsToMany(Demand::class, 'pm_demands_has_products');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'pm_projects_has_products');
    }

    // 关联的发版产品
    public function releaseProducts()
    {
        return $this->belongsToMany(ReleaseProduct::class, 'pm_release_product_has_products');
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function getTeamPrincipalUsers($teams)
    {
        $result = [];
        $teams = $teams->where('is_default', 1);
        $team = $teams->where('type', TeamType::TYPE_PRODUCT)->first();
        $result['product'] = $team ? $team->user_name : '未绑定';

        $team = $teams->where('type', TeamType::TYPE_DESIGN)->first();
        $result['design'] = $team ? $team->user_name : '未绑定';

        $team = $teams->where('type', TeamType::TYPE_DEVELOP)->first();
        $result['develop'] = $team ? $team->user_name : '未绑定';

        $team = $teams->where('type', TeamType::TYPE_TEST)->first();
        $result['test'] = $team ? $team->user_name : '未绑定';

        $team = $teams->where('type', TeamType::TYPE_FRONTEND)->first();
        $result['frontend'] = $team ? $team->user_name : '未绑定';

        $team = $teams->where('type', TeamType::TYPE_MOBILE)->first();
        $result['mobile'] = $team ? $team->user_name : '未绑定';

        return $result;
    }

    public function members()
    {
        return $this->hasManyThrough(TeamMember::class, Team::class, 'product_id', 'team_id', 'id');
    }

    public function getStatus($status)
    {
        return ProductStatus::getStatusDescription($status);
    }

    /**
     * 产品线的筛选
     * @param Builder $builder
     * @param mixed ...$data
     * @return Builder
     */
    public function scopeProductLine(Builder $builder, ...$data)
    {
        $type = $data[0];
        $val = $data[1];
        $searchType = $data[2];
        return $this->searchProduct($builder, $val, $type, ProductStatus::TypeLine, $searchType);
    }

    /**
     * 产品筛选
     * @param Builder $builder
     * @param mixed ...$data
     * @return Builder
     */
    public function scopeProductName(Builder $builder, ...$data)
    {
        $type = $data[0];
        $val = $data[1];
        $searchType = $data[2];
        return $this->searchProduct($builder, $val, $type, ProductStatus::TypeProduct, $searchType);
    }

    /**模块筛选
     * @param Builder $builder
     * @param mixed ...$data
     * @return Builder
     */
    public function scopeProductModule(Builder $builder, ...$data)
    {
        $type = $data[0];
        $val = $data[1];
        $searchType = $data[2];
        return $this->searchProduct($builder, $val, $type, ProductStatus::TypeModule, $searchType);
    }

    /**
     * 标签筛选
     * @param Builder $builder
     * @param mixed ...$data
     * @return Builder
     */
    public function scopeProductCategory(Builder $builder, ...$data)
    {
        $type = $data[0];
        $val = $data[1];
        $searchType = $data[2];
        return $this->searchProduct($builder, $val, $type, ProductStatus::TypeCategory, $searchType);
    }

    /**
     * 产品相关
     * @param Builder $builder
     * @param $val
     * @param $type
     * @param $product_type
     * @param $searchType
     * @return Builder
     */
    protected function searchProduct(Builder $builder, $val, $type, $product_type, $searchType)
    {
        if ($searchType == 'may') {
            $builder = $builder->orWhere(function ($query) use ($type, $val, $product_type) {
                $query->where($query->qualifyColumn('type'), $product_type)->where(function ($q) use ($type, $val) {
                    (new MayFilter())->getSqlByTypeAndVal($q, $type, $val, $q->qualifyColumn('name'));
                });
            });
        } else {
            $builder = $builder->Where(function ($query) use ($type, $val, $product_type) {
                $query->where($query->qualifyColumn('type'), $product_type)->where(function ($q) use ($type, $val) {
                    (new MustFilter())->getSqlByTypeAndVal($q, $type, $val, $q->qualifyColumn('name'));
                });
            });
        }
        return $builder;
    }

    /**
     * @param Builder $builder
     * @param $val
     * @param $type
     * @param $product_type
     * @param $searchType
     * @return Builder
     */
    protected function searchManger(Builder $builder, $val, $type, $product_type, $searchType, $relate, $col)
    {
        if ($searchType == 'may') {
            $builder = $builder->orWhereHas($relate, function ($query) use ($type, $val, $product_type, $col) {
                $query->where($query->qualifyColumn('type'), $product_type)
                    ->where(function ($q) use ($type, $val, $col) {
                        (new MayFilter())->getSqlByTypeAndVal($q, $type, $val, $q->qualifyColumn($col));
                    });
            });
        } else {
            $builder = $builder->WhereHas($relate, function ($query) use ($type, $val, $product_type, $col) {
                $query->where($query->qualifyColumn('type'), $product_type)
                    ->where(function ($q) use ($type, $val, $col) {
                        (new MustFilter())->getSqlByTypeAndVal($q, $type, $val, $q->qualifyColumn($col));
                    });
            });
        }
        return $builder;
    }

    protected function searchMember(Builder $builder, $val, $type, $product_type, $searchType)
    {
        if ($searchType == 'may') {
            $builder = $builder->orWhereHas('teams', function ($query) use ($type, $val, $product_type) {
                $query->WhereHas('members', function ($q) use ($type, $val, $product_type) {
                    $q->where($q->qualifyColumn('type'), $product_type)->where(function ($q1) use ($type, $val) {
                        (new MayFilter())->getSqlByTypeAndVal($q1, $type, $val, $q1->qualifyColumn('user_id'));
                    });
                });
            });
        } else {
            $builder = $builder->WhereHas('teams', function ($query) use ($type, $val, $product_type) {
                $query->WhereHas('members', function ($q) use ($type, $val, $product_type) {
                    $q->where($q->qualifyColumn('type'), $product_type)->where(function ($q1) use ($type, $val) {
                        (new MustFilter())->getSqlByTypeAndVal($q1, $type, $val, $q1->qualifyColumn('user_id'));
                    });
                });
            });
        }
        return $builder;
    }

    /**
     * @param Builder $builder
     * @param mixed ...$data
     * @return Builder
     */
    public function scopeProductManager(Builder $builder, ...$data)
    {
        $type = $data[0];
        $val = $data[1];
        $searchType = $data[2];
        return $this->searchManger($builder, $val, $type, TeamType::TYPE_PRODUCT, $searchType, 'teams', 'user_id');
    }

    /**
     * @param Builder $builder
     * @param mixed ...$data
     * @return Builder
     */
    public function scopeDesignMainManager(Builder $builder, ...$data)
    {
        $type = $data[0];
        $val = $data[1];
        $searchType = $data[2];
        return $this->searchManger($builder, $val, $type, TeamType::TYPE_DESIGN, $searchType, 'teams', 'user_id');
    }

    /**
     * @param Builder $builder
     * @param mixed ...$data
     * @return Builder
     */
    public function scopeDevManager(Builder $builder, ...$data)
    {
        $type = $data[0];
        $val = $data[1];
        $searchType = $data[2];
        return $this->searchManger($builder, $val, $type, TeamType::TYPE_DEVELOP, $searchType, 'teams', 'user_id');
    }

    /**
     * @param Builder $builder
     * @param mixed ...$data
     * @return Builder
     */
    public function scopeTestManager(Builder $builder, ...$data)
    {
        $type = $data[0];
        $val = $data[1];
        $searchType = $data[2];
        return $this->searchManger($builder, $val, $type, TeamType::TYPE_TEST, $searchType, 'teams', 'user_id');
    }

    public function scopeProductMembers(Builder $builder, ...$data)
    {
        $type = $data[0];
        $val = $data[1];
        $searchType = $data[2];
        return $this->searchMember($builder, $val, $type, TeamMemberType::TYPE_PRODUCT, $searchType);
    }

    public function scopeInteractionManager(Builder $builder, ...$data)
    {
        $type = $data[0];
        $val = $data[1];
        $searchType = $data[2];
        return $this->searchMember($builder, $val, $type, TeamMemberType::TYPE_INTERACTIVE, $searchType);
    }

    public function scopeVisualManager(Builder $builder, ...$data)
    {
        $type = $data[0];
        $val = $data[1];
        $searchType = $data[2];
        return $this->searchMember($builder, $val, $type, TeamMemberType::TYPE_VISUAL, $searchType);
    }

    public function scopeFrontEndManager(Builder $builder, ...$data)
    {
        $type = $data[0];
        $val = $data[1];
        $searchType = $data[2];
        return $this->searchManger($builder, $val, $type, TeamType::TYPE_FRONTEND, $searchType, 'teams', 'user_id');
    }


    public function scopeMobileManager(Builder $builder, ...$data)
    {
        $type = $data[0];
        $val = $data[1];
        $searchType = $data[2];
        return $this->searchManger($builder, $val, $type, TeamType::TYPE_MOBILE, $searchType, 'teams', 'user_id');
    }

    public function scopeUIManager(Builder $builder, ...$data)
    {
        $type = $data[0];
        $val = $data[1];
        $searchType = $data[2];
        return $this->searchMember($builder, $val, $type, TeamMemberType::TYPE_ART, $searchType);
    }

    /**
     * 关键字 查询name/description
     * @param Builder $builder
     * @param $data
     * @return Builder
     */
    public function scopeKeyword(Builder $builder, $data)
    {
        $start = substr($data, 0, 1);
        $end = substr($data, -1);
        if ($start == "%" || $end == "%") {
            $builder->where(function ($query) use ($data) {
                $query->orWhere('name', 'like', $data)->orWhere('description', 'like', $data);
            });
        } else {
            $builder->where(function ($query) use ($data) {
                $query->orWhere('name', $data)->orWhere('description', $data);
            });
        }
        return $builder;
    }
}
