<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use App\Models\User;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    public function index(Request $request)
    {
        $search = request('search',' ');
        $group = request('group','none');
        $area = request('area','');

        $donors = User::where('available', 1)
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
        ->when(!empty($area), function ($query) use ($area) {
            return $query->where(DB::raw('lower(name)'), 'like', '%' . strtolower($area) . '%');
        }, function ($query) {
            return $query;
        })->paginate(10);

        return view('public.browse', compact('donors','search','group','area'));
    }

    public function test()
    {
        $students = json_decode(file_get_contents(storage_path() . "/data.json"), true);

        echo "<pre>";
        print_r($students);
        foreach ($students as $student) {
            User::create($student);
        }
        // echo $json_a['Jennifer'][status];
    }

    public function getDonors(Request $request)
    {
        $search = $request->search;
        $group = $request->group;
        $area = $request->area;
        $donors =
            User::where('available', 1)
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
            ->when(!empty($area), function ($query) use ($area) {
                return $query->where(DB::raw('lower(name)'), 'like', '%' . strtolower($area) . '%');
            }, function ($query) {
                return $query;
            })->paginate(10);

        return response()->json([
            'success' => true,
            'donors' => $donors,
            'status' => 200
        ]);
    }
}
