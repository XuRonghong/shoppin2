<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\News;
use Validator;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = [
            'Title' => 'News create',
            'Summary' => '',
        ];

        //
        $news = News::all();

        $route_url = [
            'index' => route('admin.news.index'),
            'list' => route('admin.news.list'),
            'create' => route('admin.news.create'),
            'edit'  => route('admin.news.index').'/',
            'destroy' => url('admin/news/destroy').'/',
            'show' => route('admin.news.index').'/',
        ];

        return view('admin.news.index', compact('data','news', 'route_url'));
    }


    public function list(Request $request)
    {
        //
        $sort_arr = [];
        $search_arr = [];
        $search_word = $request->input('sSearch', '');
        $iDisplayLength = $request->input('iDisplayLength', 10);
        $iDisplayStart = $request->input('iDisplayStart', 0);
        $sEcho = $request->input('sEcho', '');
        $column_arr = explode(',', $request->input('sColumns', ''));
        foreach ($column_arr as $key => $item)
        {
            if ($item == "") {
                unset( $column_arr[$key] );
                continue;
            }
            if ($request->input( 'bSearchable_' . $key ) == "true") {
                $search_arr[$key] = $item;
            }
            if ($request->input( 'bSortable_' . $key ) == "true") {
                $sort_arr[$key] = $item;
            }
        }
        $sort_name = $sort_arr[ $request->input( 'iSortCol_0' ) ];
        $sort_dir = $request->input( 'sSortDir_0' );

        $map = [];
        $total_count = News::query()->where($map)
            ->where(function( $query ) use ( $sort_arr, $search_word ) {
                foreach ($sort_arr as $item) {
                    $query->orWhere( $item, 'like', '%' . $search_word . '%' );
                }
            })
            ->count();

        $data_arr = News::query()//->where($map)
            ->where(function( $query ) use ( $search_arr, $search_word ) {
                foreach ($search_arr as $item) {
                    $query->orWhere( $item, 'like', '%' . $search_word . '%' );
                }
            })
            ->orderBy( $sort_name, $sort_dir )
            ->offset($iDisplayStart)
            ->limit($iDisplayLength)
//            ->skip( $iDisplayStart )
//            ->take( $iDisplayLength );
            ->get();
        if ( !$data_arr)
        {
            return response()->json([
                'status'=> 0,
                'message'=> ['Oops! 沒有資料!']
            ],204);
        }
        return response()->json([
            'status'=> 1,
            'message'=> sprintf("已得到 %s", $total_count."筆資料"),
            'sEcho'=>$sEcho,
            'iTotalDisplayRecords'=>$total_count,
            'iTotalRecords'=>$total_count,
            'aaData'=> $data_arr
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data = [
            'Title' => 'News create',
            'Summary' => '',
        ];
        $news = [];
        return view('admin.news.create', compact('data', 'news'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rules = [
            'title' => 'required',
            'summary' => 'required',
//            'hashtag_name' => 'required|array',
            'startTime' => 'nullable',
            'endTime' => 'nullable',
            'open' => 'nullable'
        ];

        $messages = [
            'title.required' => '標題為必填項目',
            'summary.required' => '內文為必填項目',
//            'category_id.required' => '商品分類為必填項目',
//            'hashtag_name.required' => '標籤為必填項目',
        ];

        $data = $request->validate($rules, $messages);

        try{
            $news = new News([
                'title' => $request->get('title'),
                'summary' => $request->get('summary'),
//                'authorId' => 0,
//                'startTime' => 0,
//                'endTime' => 0
            ]);
            $news->save();
        }catch (\Exception $e){
            return response()->json([
                'status'=> 0,
                'message'=> $e->getMessage()
            ],422);
        }

        return response()->json([
            'status'=> 1,
            'message'=>sprintf("已新增 %s", "一筆資料"),
            'redirectUrl'=> route('admin.news.index')
        ],200);
//        return redirect(route('admin.articles.index', $request->query()))
//            ->with('success', sprintf("已新增 %s", "一筆資料"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = [
            'Title' => 'News create',
            'Summary' => '',
            'Disable'   => true
        ];
        //
        $news = News::findOrFail($id);
        return view('admin.news.create', compact('data','news'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'Title' => 'News create',
            'Summary' => '',
        ];
        //
        $news = News::findOrFail($id);
        return view('admin.news.create', compact('data','news'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $rules = [
            'title' => 'required',
            'summary' => 'required',
//            'hashtag_name' => 'required|array',
            'startTime' => 'nullable',
            'endTime' => 'nullable',
            'open' => 'nullable'
        ];

        $messages = [
            'title.required' => '標題為必填項目',
            'summary.required' => '內文為必填項目',
//            'category_id.required' => '商品分類為必填項目',
//            'hashtag_name.required' => '標籤為必填項目',
        ];

        $data = $request->validate($rules, $messages);

        try{
            $news = News::findOrFail($id)->update($data);
        }catch (\Exception $e){
            return response()->json([
                'status'=> 0,
                'message'=> $e->getMessage()
            ],422);
        }

        return response()->json([
            'status'=> 1,
            'message'=>sprintf("已更新 %s", "一筆資料"),
            'redirectUrl'=> route('admin.news.index')
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = News::findOrFail($id);
        $data->delete();
        return response()->json([
            'status'=> 1,
            'message'=>sprintf("已刪除 %s", "一筆資料"),
            'redirectUrl'=> route('admin.news.index')
        ],200);
    }
}
