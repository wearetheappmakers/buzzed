<?php

namespace App\Scopes;

use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class SellerScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    // withoutGlobalScope(ClinicScope::class)
    public function apply(Builder $builder, Model $model)
    {
        $table = $model->getTable();
        
        if(Auth::guard('seller')->check()) {
            $builder->where($table . '.seller_id', Auth::user()->id); 
        }
         
    }
}
