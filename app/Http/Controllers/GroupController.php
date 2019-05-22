<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use DataTables;
use Validator;

class GroupController extends Controller
{
    //
    function index()
    {
        return view('group.index');
        //http://127.0.0:8000/ajaxdata
    }


    function list()
    {
        $groupss = Group::select('id', 'name', 'type');
        return Datatables::of($groupss)
            ->addColumn('action', function($groups){
                return '<a href="#" class="btn btn-xs btn-primary edit" id="'.$groups->id.'">
                            <i class="glyphicon glyphicon-edit"></i> Edit
                        </a>
                        <a href="#" class="btn btn-xs btn-danger delete" id="'.$groups->id.'">
                            <i class="glyphicon glyphicon-remove"></i> Delete
                        </a>';
            })
            ->make(true);
    }


    function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
//            'rank' => 'required',
            'group_name' => 'required',
            'type'  => 'required',
        ]);

        $error_array = array();
        $success_output = '';
        if ($validation->fails())
        {
            foreach($validation->messages()->getMessages() as $field_name => $messages)
            {
                $error_array[] = $messages;
            }
        }
        else
        {
                if($request->get('button_action') == "insert")
                {
                    $group = new Group([
                        'rank'    =>  0,
                        'name'    =>  $request->get('group_name'),
                        'type'     =>  $request->get('type')
                    ]);
                    $group->save();
                    $success_output = '<div class="alert alert-success">Data Inserted</div>';
                }

                if($request->get('button_action') == 'update')
                {
                    $group = Group::find($request->get('group_id'));
                    $group->rank = $request->get('rank', 0);
                    $group->name = $request->get('group_name');
                    $group->type = $request->get('type');
                    $group->save();
                    $success_output = '<div class="alert alert-success">Data Updated</div>';
                }
        }
        $output = array(
            'error'     =>  $error_array,
            'success'   =>  $success_output
        );
        echo json_encode($output);
    }

    function edit(Request $request)
    {
        $id = $request->input('id');
        $group = Group::find($id);
        $output = array(
            'name'    =>  $group->name,
            'type'     =>  $group->type
        );
        echo json_encode($output);
    }

    function destroy(Request $request)
    {
        $group = Group::find($request->input('id'));
        if($group->delete())
        {
            echo 'Data Deleted';
        }
    }
}
