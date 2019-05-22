<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;

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
        $news = News::all();

        return view('news.index', compact($news));
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
        return view('news.create');
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
            'detail' => 'required',
//            'hashtag_name' => 'required|array',
            'startTime' => 'nullable',
            'endTime' => 'nullable',
            'open' => 'nullable'
        ];

        $messages = [
            'title.required' => '標題為必填項目',
            'detail.required' => '內文為必填項目',
//            'category_id.required' => '商品分類為必填項目',
//            'hashtag_name.required' => '標籤為必填項目',
        ];

        $data = $request->validate($rules, $messages);

        try{
            $news = new News([
                'title' => $request->get('title'),
                'detail' => $request->get('detail'),
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
            'redirectUrl'=> route('news.create')
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    }
}
