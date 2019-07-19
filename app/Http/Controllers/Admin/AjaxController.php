<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class AjaxController extends Controller
{
    //
    function dynamicDependent()
    {
        $country_list = DB::table('country_state_city')
            ->groupBy('country')
            ->get();
        return view('dynamic_dependent')->with('country_list', $country_list);
    }


    function dynamicDependentFetch(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        $data = DB::table('country_state_city')
            ->where($select, $value)
            ->groupBy($dependent)
            ->get();
        $output = '<option value="">Select '.ucfirst($dependent).'</option>';
        foreach($data as $row)
        {
            $output .= '<option value="'.$row->$dependent.'">'.$row->$dependent.'</option>';
        }
        echo $output;
    }




    function search(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('products')
                    ->where('name', 'like', '%' . $query . '%')
//                    ->orWhere('Address', 'like', '%' . $query . '%')
//                    ->orWhere('City', 'like', '%' . $query . '%')
//                    ->orWhere('PostalCode', 'like', '%' . $query . '%')
//                    ->orWhere('Country', 'like', '%' . $query . '%')
//                    ->orderBy('CustomerID', 'desc')
                    ->get();

            } else {
                $data = DB::table('products')
                    ->orderBy('id', 'desc')
                    ->get();
            }
            $total_row = $data->count();
            if ($total_row > 0) {
                foreach ($data as $row) {
                    $output .= '
                        <tr>
                         <td>' . $row->name . '</td>
                         <td>' . $row->price . '</td>
                        </tr>
                    ';
                }
            } else {
                $output = '
                   <tr>
                    <td align="center" colspan="4">No Data Found</td>
                   </tr>
                   ';
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row
            );

            echo json_encode($data);
        }
    }




    function AutoCompleteFetch(Request $request)
    {
        if($request->get('query'))
        {
            $query = $request->get('query');
            $data = DB::table('products')
                ->where('name', 'LIKE', "%{$query}%")
                ->get();
            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            foreach($data as $row)
            {
                $output .= '
                <li><a href="#">'.$row->name.'</a></li>
               ';
            }
            $output .= '</ul>';
            echo $output;
        }
    }

}
