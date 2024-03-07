<?php

namespace App\Http\Controllers\thunghiem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LiveSearchController extends Controller
{
    public function index()
    {
        $data = DB::table('users')->orderBy('id', 'asc')->paginate(5);
        return view('pagination', compact('data'));
    }

    function fetch_data(Request $request)
    {
        if ($request->ajax()) {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);
            $data = DB::table('post')
                ->orWhere('name', 'like', '%' . $query . '%')
                ->orWhere('role', 'like', '%' . $query . '%')
                ->orderBy($sort_by, $sort_type)
                ->paginate(5);
            return view('pagination_data', compact('data'))->render();
        }
    }
}
