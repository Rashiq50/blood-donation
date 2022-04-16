<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    public function index(Request $request)
    {

        $donors = User::where('available', true)->paginate(10);

        return view('public.browse', compact('donors'));
    }

    public function getDonors(Request $request)
    {
        $search = $request->search;
        $group = $request->group;
        $areas = $request->areas;
        $donors = User::where('available', true)
            ->when(!empty($search), function ($query) use ($search) {
                return $query->where(DB::raw('lower(name)'), 'like', '%' . strtolower($search) . '%');
            }, function ($query) {
                return $query;
            })
            ->when(!empty($group) && $group != 'none', function ($query) use ($group) {
                return $query->where('blood_group', '=', $group);
            }, function ($query) {
                return $query;
            })
            ->when(!empty($areas), function ($query)  use ($areas) {
                return $query->whereIn('area', $areas);
            }, function ($query) {
                return $query;
            })
            ->paginate(10);

        return response()->json([
            'success'=>true,
            'donors'=>$donors,
            'status'=>200
        ]);
    }
}
