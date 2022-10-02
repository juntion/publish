<?php

namespace App\Models;

use App\Events\Mail\PasswordRestEvent;
use App\Models\Sidebar\SidebarTemplate;
use App\Traits\DateFormatTrait;
use App\Traits\ModelsTrait;
use App\Traits\Permission\PermissionLogTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, HasMedia
{
    use Notifiable, ModelsTrait, HasMediaTrait, HasRoles, SoftDeletes, PermissionLogTrait, DateFormatTrait;

    const PASSWORD_HISTORY_MAX_COUNT = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'admin_telephone', 'which_language', 'is_customer_service', 'admin_level', 'duties',
        'update_pass_time', 'is_communal', 'code_email', 'assistant_id', 'assistant_name', 'company_id', 'password_history',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'password_history',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password_history' => 'json',
    ];

    protected $dates = ['deleted_at'];

    /**
     * 头像存放目录
     * @var string
     */
    protected $userAvatarMedia = 'avatar';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Str::uuid()->getHex();
        });
    }

    public function sendPasswordResetNotification($token)
    {
        event(new PasswordRestEvent($this, $token));
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    // 默认部门
    public function department()
    {
        return $this->belongsToMany(Department::class, 'user_has_departments')
            ->withPivot('is_default')->wherePivot('is_default', 1);
    }

    // 所有部门
    public function departments()
    {
        return $this->belongsToMany(Department::class, 'user_has_departments')->withPivot('is_default');
    }

    public function positions()
    {
        return $this->belongsToMany(Position::class, 'user_has_positions');
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'user_has_posts');
    }

    public function sidebarTemplates()
    {
        return $this->belongsToMany(SidebarTemplate::class, 'user_has_sidebar_templates');
    }

    // 用户首页
    public function pages()
    {
        return $this->belongsToMany(Page::class, 'user_has_homepages');
    }

    public function forbidSubsystems()
    {
        return $this->belongsToMany(Subsystem::class, 'forbidden_logins')->withTimestamps();
    }

    public function forbidPages()
    {
        return $this->belongsToMany(Page::class, 'user_forbid_pages');
    }

    public function loginHistory()
    {
        return $this->hasMany(LoginTrack::class)->orderBy('id', 'desc');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getGuardNameAttribute()
    {
        return config('app.guard');
    }

    /**
     * 获取用户的头像路径
     * @return string
     */
    public function getAvatarAttribute()
    {
        $avatarMedia = $this->getMedia($this->userAvatarMedia)->first();
        return $avatarMedia ? $avatarMedia->getUrl() : '';
    }

    // 记录密码历史
    public function setPasswordAttribute($val)
    {
        $history = $this->password_history ? collect($this->password_history) : collect();
        $history = $history->prepend($val)
            ->take(self::PASSWORD_HISTORY_MAX_COUNT)
            ->toArray();
        $this->attributes['password'] = $val;
        $this->attributes['password_history'] = json_encode($history);
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection($this->userAvatarMedia)
            ->useDisk('public')
            ->singleFile();
    }

    public function getUserAvatarMedia(): string
    {
        return $this->userAvatarMedia;
    }

    // 其他部门 ids
    public function getDepartmentIdsAttribute()
    {
        $departmentIds = $this->departments()->wherePivot('is_default', 0)->get()->pluck('id');
        return $departmentIds;
    }

    // 基础部门
    public function getBasicDepartmentAttribute()
    {
        $department = $this->department()->first();
        if ($department) {
            return $department->top();
        }
        return null;
    }

    // 接收验证码邮箱
    public function getReceiveCodeEmailAttribute()
    {
        return !empty($this->code_email) ? $this->code_email : $this->email;
    }

    public function isSuperAdmin()
    {
        return $this->hasRole('superAdmin');
    }

    /**
     * 获取用户默认所属部门ID，包括父级部门ID
     * @return array
     * @author: King
     * @version: 2020/7/9 17:43
     */
    public function getDeptIds()
    {
        if (!empty($this->department)) {
            $deptIds = collect(explode('-', $this->department->first()->path))->filter()->toArray();
            array_push($deptIds, $this->department->first()->id);
            return $deptIds;
        } else {
            return [];
        }
    }

    /**
     * 更新日期筛选
     */
    public function scopeUpdatedDate(Builder $builder, ...$data)
    {
        $data[0] = $data[0] . ' 00:00:00';
        $data[1] = $data[1] . ' 23:59:59';
        $builder->where(function ($q) use ($data) {
            $q->whereBetween('created_at', $data)->orWhereBetween('updated_at', $data);
        });
    }
}
