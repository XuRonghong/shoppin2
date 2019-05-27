<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use Validator;

class MessageController extends Controller
{
    //
    function index()
    {
        $messages = Message::get();
        return view('message.index', compact('messages'));
    }

    function insert(Request $request)
    {
        if($request->ajax())
        {
            $rules = array(
                'title.*'  => 'required',
                'content.*'  => 'required'
            );
            $error = Validator::make($request->all(), $rules);
            if($error->fails())
            {
                return response()->json([
                    'error'  => $error->errors()->all()
                ]);
            }

            $title = $request->get('title');
            $content = $request->get('content');
            for($count = 0; $count < count($title); $count++)
            {
                $data = array(
                    'title' => $title[$count],
                    'content'  => $content[$count]
                );
                $insert_data[] = $data;
            }

            Message::insert($insert_data);
            return response()->json([
                'success'  => 'Data Added successfully.',
                'data'      => $insert_data
            ]);
        }
    }
}
