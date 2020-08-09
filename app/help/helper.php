<?php


use Illuminate\Http\Request;

function countPurchases(Request $request)
{
    if ($request->has('date_from') ){
        return 'yes';
    }else{
        return 'No';
    }

}
