<?php

namespace App\Http\Controllers;

use App\Models\Branches;
use App\Models\Congress;
use App\Models\Districts;
use App\Models\Institutions;
use App\Models\Members;
use App\Models\Presbyteries;
use App\Models\ProfessionalGroups;
use App\Models\Regions;
use App\Models\Unions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoutesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function dashboard()
    {
        $members = Members::when(Auth::user()->usertype == 'presbytery', function ($q) {
            return $q->where('presbytery', Auth::user()->presbytery);
        })->when(Auth::user()->usertype == 'district', function ($q) {
            return $q->where('district', Auth::user()->district);
        })->when(Auth::user()->usertype == 'branch', function ($q) {
            return $q->where('branch', Auth::user()->branch);
        })->when(Auth::user()->usertype == 'union', function ($q) {
            return $q->where('union', Auth::user()->union);
        })->count();

        $presbyteries = Presbyteries::count();
        $districts = Districts::count();
        $branches = Branches::count();
        $unions = Unions::count();
        $professional_groups = ProfessionalGroups::count();

        return view('dashboard',[
            "members" => $members,
            "presbyteries" => $presbyteries,
            "districts" => $districts,
            "branches" => $branches,
            "unions" => $unions,
            "professional_groups" => $professional_groups,
        ]);
    }

    public function presbyteries()
    {
        $presbyteries = Presbyteries::all();
        return view('modules.presbytery.index', [
            'presbyteries' => $presbyteries
        ]);
    }

    public function districts()
    {
        $presbyteries = Presbyteries::all();

        $districts = Districts::when(Auth::user()->usertype == 'presbytery', function ($q) {
            return $q->where('presbytery', Auth::user()->presbytery);
        })->get();

        return view('modules.districts.index', [
            'districts' => $districts,
            'presbyteries' => $presbyteries
        ]);
    }

    public function branches()
    {
        $presbyteries = Presbyteries::with('children')->get();
    
        $districts = Districts::when(Auth::user()->usertype == 'presbytery', function ($q) {
            return $q->where('presbytery', Auth::user()->presbytery);
        })->get();

        return view('modules.branches.index', [
            'districts' => $districts,
            'presbyteries' => $presbyteries
        ]);
    }

    public function unions()
    {
        $presbyteries = Presbyteries::with('children')->get();
    
        $districts = Districts::with('children')->when(Auth::user()->usertype == 'presbytery', function ($q) {
            return $q->where('presbytery', Auth::user()->presbytery);
        })->get();

        $branches = Branches::when(Auth::user()->usertype == 'district', function ($q) {
            return $q->where('district', Auth::user()->district);
        })->get();

        return view('modules.unions.index', [
            'districts' => $districts,
            'presbyteries' => $presbyteries,
            'branches' => $branches,
        ]);
    }


    public function institutions()
    {
        $presbyteries = Presbyteries::all();
        $regions = Regions::all();
    
        return view('modules.institutions.index', [
            'regions' => $regions,
            'presbyteries' => $presbyteries
        ]);
    }

    public function groups()
    {
        return view('modules.groups.index', [
        ]);
    }


    public function professional_members()
    {
        $groups = ProfessionalGroups::all();
    
        return view('modules.professional_members.index', [
            'groups' => $groups,
        ]);
    }

    public function congress()
    {
        return view('modules.congress.index', [
        ]);
    }

    public function congress_members()
    {
        $congresses = Congress::all();
        $unions = Unions::all();
    
        return view('modules.congress_members.index', [
            'congresses' => $congresses,
            'unions' => $unions,
        ]);
    }

    public function executives()
    {
        return view('modules.executives.index', [
        ]);
    }

    public function council()
    {
        return view('modules.council.index', [
        ]);
    }

    public function messaging()
    {
        $presbyteries = Presbyteries::all();
        $regions = Regions::all();
        $institutions = Institutions::all();
    
        $districts = Districts::when(Auth::user()->usertype == 'presbytery', function ($q) {
            return $q->where('presbytery', Auth::user()->presbytery);
        })->get();

        $branches = Branches::when(Auth::user()->usertype == 'district', function ($q) {
            return $q->where('district', Auth::user()->district);
        })->get();

        $unions = Unions::when(Auth::user()->usertype == 'branch', function ($q) {
            return $q->where('branch', Auth::user()->branch);
        })->get();

        $users = Members::all();

        return view('modules.messaging.index', [
            'districts' => $districts,
            'presbyteries' => $presbyteries,
            'branches' => $branches,
            'unions' => $unions,
            'regions' => $regions,
            "institutions" => $institutions,
            'users' => $users,
        ]);
    }

    public function members()
    {
        $presbyteries = Presbyteries::all();
        $regions = Regions::all();
        $institutions = Institutions::all();
    
        $districts = Districts::when(Auth::user()->usertype == 'presbytery', function ($q) {
            return $q->where('presbytery', Auth::user()->presbytery);
        })->get();

        $branches = Branches::when(Auth::user()->usertype == 'district', function ($q) {
            return $q->where('district', Auth::user()->district);
        })->get();

        $unions = Unions::when(Auth::user()->usertype == 'branch', function ($q) {
            return $q->where('branch', Auth::user()->branch);
        })->get();

        return view('modules.member.index', [
            'districts' => $districts,
            'presbyteries' => $presbyteries,
            'branches' => $branches,
            'unions' => $unions,
            'regions' => $regions,
            "institutions" => $institutions,
        ]);
    }
    
    public function users()
    {
        $presbyteries = Presbyteries::with('children')->get();
        $districts = Districts::with('children')->get();
        $branches = Branches::with('children')->get();
        $unions = Unions::all();

        return view('modules.users.index', [
            'presbyteries' => $presbyteries,
            'districts' => $districts, 
            'branches' => $branches,
            'unions' => $unions,
            ]);
    }

}
