<?php

namespace App\Api\Traits;

trait Restriction
{
    protected function restrict($permission, $methods=null)
    {
        if (is_null($methods)) {
            $this->middleware('api.auth', ['only' => $permission]);
        } else {
            $this->middleware(['api.auth', $permission], ['only' => $methods]);
        }
    }
}
