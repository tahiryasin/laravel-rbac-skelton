<?php
/**
 * Override Yajra\Datatables\Datatables to use App\Overrides\CollectionEngine
 */

namespace App\Overrides;
use Yajra\Datatables\Datatables as YajraDatatables;
use Illuminate\Support\Collection;
use App\Overrides\CollectionEngine;

class Datatables extends YajraDatatables{
   
    /**
     * Gets query and returns instance of class.
     *
     * @param  mixed $builder
     * @return mixed
     */
    public static function of($builder)
    {
        $datatables          = app('App\Overrides\Datatables');
        $datatables->builder = $builder;

        if ($builder instanceof QueryBuilder) {
            $ins = $datatables->usingQueryBuilder($builder);
        } else {
            $ins = $builder instanceof Collection ? $datatables->usingCollection($builder) : $datatables->usingEloquent($builder);
        }

        return $ins;
    }
    
    /**
     * Datatables using Collection.
     *
     * @param \Illuminate\Support\Collection $builder
     * @return \Yajra\Datatables\Engines\CollectionEngine
     */
    public function usingCollection(Collection $builder)
    {
        return new CollectionEngine($builder, $this->request);
    }
}
