<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class DeletedAdminScope implements Scope{

public function apply (Builder $builder, Model $model){

    $builder->orderBy($model::CREATED_AT, 'desc');
     
    if(Auth::check() && Auth::user()->is_admin){
    
    $builder->withTrashed();
    }


}


}