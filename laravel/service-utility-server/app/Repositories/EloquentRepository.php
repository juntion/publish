<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class EloquentRepository
{
    /**
     * The repository model class.
     *
     * @var Model
     */
    protected $model;

    /**
     * Query Builder
     * @var Builder
     */
    protected $query;

    /**
     * Magic callStatic method to forward static methods to the model.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return call_user_func_array([new static(), $method], $parameters);
    }

    /**
     * Magic call method to forward methods to the model.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        $model = $this->model;

        return call_user_func_array([$model, $method], $parameters);
    }

    /**
     * Set the relationships that should be eager loaded.
     *
     * @param mixed $relationships
     *
     * @return $this
     */
    public function with($relationships)
    {
        $this->query = $this->getQuery()->with($relationships);
        return $this;
    }

    /**
     * Add an "order by" clause to the repository instance.
     *
     * @param string $column
     * @param string $direction
     *
     * @return $this
     */
    public function orderBy($column, $direction = 'asc')
    {
        $this->query = $this->getQuery()->orderBy($column, $direction);
        return $this;
    }

    /**
     * Find an entity by its primary key.
     *
     * @param int   $id
     * @param array $columns
     * @param array $with
     * @return Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function find($id, $columns = ['*'], $with = [])
    {
        $result = $this->getQuery()->with($with)->find($id, $columns);
        $this->resetQuery();
        return $result;
    }

    /**
     * Find the entity by the given attribute.
     *
     * @param string $attribute
     * @param string $value
     * @param array  $columns
     * @param array  $with
     * @return Builder|Model|object|null
     */
    public function findBy($attribute, $value, $columns = ['*'], $with = [])
    {
        $result = $this->getQuery()->with($with)->where($attribute, '=', $value)->first($columns);
        $this->resetQuery();
        return $result;
    }

    /**
     * Find all entities.
     *
     * @param array $columns
     * @param array $with
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function findAll($columns = ['*'], $with = [])
    {
        $result = $this->getQuery()->with($with)->get($columns);
        $this->resetQuery();
        return $result;
    }

    /**
     * Find all entities matching where conditions.
     *
     * @param array $where
     * @param array $columns
     * @param array $with
     *
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function findWhere($where, $columns = ['*'], $with = [])
    {
        $where = $this->castRequest($where);
        $model = $this->getQuery();
        foreach ($where as $attribute => $value) {
            if (is_array($value)) {
                list($attribute, $condition, $value) = $value;
                $model->where($attribute, $condition, $value);
            } else {
                $model->where($attribute, '=', $value);
            }
        }
        $result = $model->with($with)->get($columns);
        $this->resetQuery();
        return $result;
    }

    /**
     * Find all entities matching where conditions.
     *
     * @param array $where
     *
     * @return Builder
     */
    public function findWhereTo($where)
    {
        $where = $this->castRequest($where);
        $model = $this->getQuery();
        foreach ($where as $attribute => $value) {
            if (is_array($value)) {
                list($attribute, $condition, $value) = $value;
                $model->where($attribute, $condition, $value);
            } else {
                $model->where($attribute, '=', $value);
            }
        }
        return $model;
    }

    /**
     * Find all entities matching whereBetween conditions.
     *
     * @param  string $attribute
     * @param  array  $values
     * @param  array  $columns
     * @param  array  $with
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function findWhereBetween($attribute, $values, $columns = ['*'], $with = [])
    {
        $values = $this->castRequest($values);
        $result = $this->getQuery()->with($with)->whereBetween($attribute, $values)->get($columns);
        $this->resetQuery();
        return $result;
    }

    /**
     * Find all entities matching whereIn conditions.
     *
     * @param string $attribute
     * @param array  $values
     * @param array  $columns
     * @param array  $with
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function findWhereIn($attribute, $values, $columns = ['*'], $with = [])
    {
        $values = $this->castRequest($values);
        $result = $this->getQuery()->with($with)->whereIn($attribute, $values)->get($columns);
        $this->resetQuery();
        return $result;
    }

    /**
     * Find all entities matching whereNotIn conditions.
     *
     * @param string $attribute
     * @param array  $values
     * @param array  $columns
     * @param array  $with
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function findWhereNotIn($attribute, $values, $columns = ['*'], $with = [])
    {
        $values = $this->castRequest($values);
        $result = $this->getQuery()->with($with)->whereNotIn($attribute, $values)->get($columns);
        $this->resetQuery();
        return $result;
    }

    /**
     * Find an entity matching the given attributes or create it.
     *
     * @param array $attributes
     *
     * @return array|mixed
     */
    public function findOrCreate($attributes)
    {
        $attributes = $this->castRequest($attributes);

        if (!is_null($instance = $this->findWhere($attributes)->first())) {
            return $instance;
        }

        return $this->create($attributes);
    }

    /**
     * Get an array with the values of the given column from entities.
     *
     * @param string      $column
     * @param string|null $key
     * @return \Illuminate\Support\Collection
     */
    public function pluck($column, $key = null)
    {
        $result = $this->getQuery()->pluck($column, $key);
        $this->resetQuery();
        return $result;
    }

    /**
     * Paginate the given query for retrieving entities.
     *
     * @param null   $perPage
     * @param array  $columns
     * @param string $pageName
     * @param null   $page
     * @param array  $with
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = null, $columns = ['*'], $with = [], $pageName = 'page', $page = null)
    {
        $result = $this->getQuery()->with($with)->paginate($perPage, $columns, $pageName, $page);
        $this->resetQuery();
        return $result;
    }

    /**
     * Create a new entity with the given attributes.
     *
     * @param mixed $attributes
     *
     * @return array
     */
    public function create($attributes)
    {
        $attributes = $this->castRequest($attributes);
        $instance = $this->model->newInstance($attributes);
        $created = $instance->save();
        return [
            $created,
            $instance,
        ];
    }

    /**
     * Update an entity with the given attributes.
     *
     * @param mixed $id
     * @param array $attributes
     *
     * @return array
     */
    public function update($id, $attributes)
    {
        $attributes = $this->castRequest($attributes);
        $updated = false;
        $instance = $id instanceof Model ? $id : $this->find($id);
        if ($instance) {
            $updated = $instance->update($attributes);
        }
        return [
            $updated,
            $instance,
        ];
    }

    /**
     * Delete an entity with the given ID.
     *
     * @param mixed $id
     * @throws \Exception
     * @return array
     */
    public function delete($id)
    {
        $deleted = false;
        $instance = $id instanceof Model ? $id : $this->find($id);
        if ($instance) {
            $deleted = $instance->delete();
        }
        return [
            $deleted,
            $instance,
        ];
    }

    /**
     * Cast HTTP request object to an array if need be.
     *
     * @param array|Request $request
     *
     * @return array
     */
    protected function castRequest($request)
    {
        return $request instanceof Request ? $request->all() : $request;
    }

    /**
     * @param array $columns
     * @return $this
     * @author: King
     * @version: 2020/1/2 15:23
     */
    public function select($columns = ['*'])
    {
        $this->query = $this->getQuery()->select($columns);
        return $this;
    }

    /**
     * @param $relation
     * @param \Closure|null $callback
     * @param string $operator
     * @param int $count
     * @return $this
     * @author: King
     * @version: 2020/7/21 16:38
     */
    public function whereHas($relation, \Closure $callback = null, $operator = '>=', $count = 1)
    {
        $this->query = $this->getQuery()->whereHas($relation, $callback, $operator, $count);
        return $this;
    }

    /**
     * @return Builder
     * @author: King
     * @version: 2020/1/2 16:19
     */
    protected function getQuery()
    {
        if (!empty($this->query) && $this->query instanceof Builder){
            return $this->query;
        } else {
            return $this->model->query();
        }
    }

    /**
     * @return mixed
     * @author: King
     * @version: 2020/1/7 11:10
     */
    protected function resetQuery()
    {
        $this->query = null;
    }

    /**
     * @return Builder
     * @author: King
     * @version: 2020/1/7 11:22
     */
    protected function newQuery()
    {
        $this->resetQuery();
        return $this->model->query();
    }
}
