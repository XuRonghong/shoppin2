<?php

namespace App\Presenters;


abstract class Presenter
{
    public function getRouteResource($route_name = '')
    {
        return [
            'index' => route($route_name.'.index'),
            'list' => route($route_name.'.list'),
            'create' => route($route_name.'.create'),
            'store' => route($route_name.'.index'),
            'edit'  => route($route_name.'.index').'/',
            'update' => url(str_replace('.','/',$route_name)).'/',
            'destroy' => url(str_replace('.','/',$route_name).'/destroy').'/',
            'show' => route($route_name.'.index').'/',
        ];
    }


    public function dateTime($column = 'created_at', $format = 'Y-m-d H:i:s')
    {
        if ($this->object->$column) {
            return $this->object->$column->format($format);
        }

        return null;
    }

    public function presentStatus()
    {
        if($this->object->status)
        {
            return '<span class="label label-success">啟用</span>';
        }

        return '<span class="label label-danger">停用</span>';
    }
}
