<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

trait PolicyTrait
{
    static $policyClass = null;

    /**
     * @var array
     */
    private $policiesArr = [];

    /**
     * 设置策略过滤
     * @param array $policies
     * @return $this
     */
    public function onlyPolicies($policies = [])
    {
        $this->policiesArr = $policies;
        return $this;
    }

    public function getPoliciesAttribute()
    {
        $result = [];
        $policy = self::$policyClass ?? $this->guessModelPolicyClass($this);
        $policyClass = app()->make($policy);
        $reflector = new \ReflectionClass($policy);
        $policiesEmpty = empty($this->policiesArr);
        foreach ($reflector->getMethods() as $method) {
            if (!$method->isPublic()) continue;

            $methodName = $method->getName();
            if ($policiesEmpty || in_array($methodName, $this->policiesArr, true)) {
                $result[$methodName] = $policyClass->$methodName(Auth::user(), $this);
            }
        }
        return $result;
    }

    /**
     * @param $model
     * @return mixed|string
     * @throws \Exception
     */
    protected function guessModelPolicyClass($model)
    {
        $policiesArr = Gate::policies();
        $class = get_class($model);
        if (isset($policiesArr[$class])) {
            return self::$policyClass = $policiesArr[$class];
        }
        $policy = str_replace('/', '\\', dirname(str_replace('\\', '/', $class)) . '\\Policies\\' . class_basename($class) . 'Policy');
        if (!class_exists($policy)) {
            throw new \Exception("Class {$policy} not exists!");
        }
        return self::$policyClass = $policy;
    }
}
