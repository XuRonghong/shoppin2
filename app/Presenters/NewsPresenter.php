<?php

namespace App\Presenters;


class NewsPresenter extends Presenter
{
    protected $indexUrl;

    public function __construct()
    {
        $this->indexUrl = route('admin.news.index');
    }

    public function getParameters($index=null)
    {
        switch ($index){
            case 'index':
                return [
                    'Title' => 'All record',
                    'Summary' => '',
                ];
            case 'create':
                return [
                    'Title' => 'News create',
                    'Summary' => '',
                ];
            case 'edit':
                return [
                    'Title' => 'News edit',
                    'Summary' => '',
                ];
            case 'show':
                return [
                    'Title' => 'News show',
                    'Summary' => '',
                    'Disable'   => true
                ];
            default :
                return [
                    'Title' => '',
                    'Summary' => '',
                ];
        }
    }

    public function responseJson($errors=0, $method=0, $status=200)
    {
        if ($errors==0) {
            switch ($method) {
                case 'store':
                    return response()->json([
                        'status' => 1,
                        'message' => sprintf("已新增 %s", "一筆資料"),
                        'redirectUrl' => $this->indexUrl
                    ], $status);
                case 'update':
                    return response()->json([
                        'status' => 1,
                        'message' => sprintf("已更新 %s", "一筆資料"),
                        'redirectUrl' => $this->indexUrl
                    ], $status);
                case 'destroy':
                    return response()->json([
                        'status' => 1,
                        'message' => sprintf("已刪除 %s", "一筆資料"),
                        'redirectUrl' => $this->indexUrl
                    ], $status);
                default:
//                    return redirect(route('admin.news.index', $request->query()))
//                        ->with('success', sprintf("已新增 %s", "一筆資料"));
                    return response()->json([ ], 404);
            }
        } else {
            return response()->json([
                'status' => $method,
                'message' => $errors,
                'redirectUrl' => $this->indexUrl
            ], 422);
        }
    }
}
