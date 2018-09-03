<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function updateModel($model, $data = [])
    {
        $result = [];

        foreach ($data as $key => $value) {
            if (isset($value)) {
                $result[$key] = gettype($value) === 'boolean' ? $value === true : $value;
            }
        }

        $model->fill($result);
        $model->save();
    }
}
