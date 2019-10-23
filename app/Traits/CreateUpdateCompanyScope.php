<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait CreateUpdateCompanyScope{
    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
            $model->created_by = auth()->user()->id;
            $model->company_id = auth()->user()->company_id;
        });

        static::updating(function($model){
            $model->updated_by = auth()->user()->id;
        });

        static::addGlobalScope('company', function(Builder $builder){
            $builder->where('company_id', auth()->user()->company_id);
        });
    }
}