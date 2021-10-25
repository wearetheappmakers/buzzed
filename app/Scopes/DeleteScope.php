<?php

namespace App\Scopes;

use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class DeleteScope implements Scope
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
        $builder->where($table . '.deleted_at', NULL);
         
    }
}
