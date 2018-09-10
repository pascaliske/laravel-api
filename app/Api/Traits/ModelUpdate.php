<?php

namespace App\Api\Traits;

trait ModelUpdate
{
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
