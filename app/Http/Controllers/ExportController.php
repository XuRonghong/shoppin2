<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Excel;

class ExportController extends Controller
{
    //
    function index()
    {
        $customer_data = DB::table('users')->get();
        return view('users')->with('customer_data', $customer_data);
    }

    function excel()
    {
        $customer_data = DB::table('users')->get()->toArray();
        $customer_array[] = array('Customer Name', 'Address', 'City', 'Postal Code', 'Country');
        foreach($customer_data as $customer)
        {
            $customer_array[] = array(
                'Customer Name'  => $customer->name,
                'Address'   => $customer->email,
                'City'    => $customer->password,
                'Postal Code'  => $customer->created_at,
                'Country'   => $customer->updated_at
            );
        }
        Excel::create('Customer Data', function($excel) use ($customer_array){
            $excel->setTitle('Customer Data');
            $excel->sheet('Customer Data', function($sheet) use ($customer_array){
                $sheet->fromArray($customer_array, null, 'A1', false, false);
            });
        })->download('xlsx');
    }
}
