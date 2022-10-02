<?php

namespace Modules\Permission\Entities;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Modules\Base\Entities\Model;
use Modules\Permission\Entities\Traits\Cache\RefreshByRoleEvent;

class Role extends Model
{
    use RefreshByRoleEvent;

    protected $guarded = [];

    protected $casts = [
        'locale' => 'json',
    ];

    /**
     * A role may be given various permissions.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            config('permission.models.permission'),
            config('permission.table_names.role_has_permissions'),
            'role_uuid',
            'permission_uuid'
        );
    }

    /**
     * A role belongs to some users of the model associated with its guard.
     */
    public function users(): MorphToMany
    {
        return $this->morphedByMany(
            $this->getModelForGuard($this->attributes['guard_name']),
            'model',
            config('permission.table_names.model_has_roles'),
            'role_uuid',
            config('permission.column_names.model_morph_key')
        )->withPivot('is_default');
    }

    private function getModelForGuard(string $guard)
    {
        return collect(config('auth.guards'))
            ->map(function ($guard) {
                if (!isset($guard['provider'])) {
                    return;
                }

                return config("auth.providers.{$guard['provider']}.model");
            })->get($guard);
    }
}
