<?php

namespace App\Http\Controllers;

use App\Http\Resources\MemberResource;
use App\Models\Members;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Members::get();

        return response()->json([
            "data" => MemberResource::collection($data)
        ]);
    }

    public function members($presbytery, $district, $branch, $union)
    {
        $data = Members::when($presbytery !== "all", function ($q) use($presbytery) {
            return $q->where('presbytery', $presbytery);
        })->when($district !== "all", function ($q) use($district) {
            return $q->where('district', $district);
        })->when($branch !== "all", function ($q) use($branch) {
            return $q->where('branch', $branch);
        })->when($union !== "all", function ($q) use($union) {
            return $q->where('union', $union);
        })->get();

        return response()->json([
            "data" => MemberResource::collection($data)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
             "presbytery" => "required",
             "district" => "required",
             "branch" => "required",
             "union" => "required",
             "title" => "required",
             "fname" => "required",
             "lname" => "required",
             "gender" => "required",
             "phone" => "required",
             "member_type" => "required",
             "createuser" => "required",

        ], [
            "presbytery.required" => "No presbytery supplied",
            "district.required" => "No district supplied",
            "branch.required" => "No branch supplied",
            "union.required" => "No union supplied",
            "title.required" => "No title supplied",
            "fname.required" => "No first name supplied",
            "lname.required" => "No last name supplied",
            "gender.required" => "No gender supplied",
            "phone.required" => "No phone supplied",
            "member_type.required" => "No member type supplied",
            "createuser.required" => "No user supplied",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "ok" => false,
                "msg" => "Operation failed." . join(". ", $validator->errors()->all()),
            ]);
        }

        try {
            $transResult = DB::transaction(function () use ($request) {

                Members::create([
                    'url_hash' => bin2hex(random_bytes(50)),
                    'presbytery' => $request->presbytery,
                    'district' => $request->district,
                    'branch' => $request->branch,
                    'union' => $request->union,
                    'member_id' =>  strtoupper(bin2hex(random_bytes(8))),
                    'title' => $request->title,
                    'fname' => $request->fname,
                    'mname' => $request->mname,
                    'lname' => $request->lname,
                    'gender' => $request->gender,
                    'dob' => $request->dob,
                    'marital_status' => $request->marital_status,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'nationality' => $request->nationality,
                    'hometown' => $request->hometown,
                    'region' => $request->region,
                    'member_type' => $request->member_type,
                    'institution' => $request->institution,
                    'programme' => $request->programme,
                    'current_level' => $request->current_level,
                    'academic_year' => $request->academic_year,
                    'residence' => $request->residence,
                    'room_details' => $request->room_details,
                    'employment_status' => $request->employment_status,
                    'profession' => $request->profession,
                    'pob' => $request->pob,
                    'mother_church' => $request->mother_church,
                    'place_of_work' => $request->place_of_work,
                    'emergency_person' => $request->emergency_person,
                    'emergency_contact' => $request->emergency_contact,
                    'picture' => $request->picture,
                    'position' => $request->position,
                    'position_year' => $request->position_year,
                    'createuser' => $request->createuser,
                ]);
            });

            if (!empty($transResult)) {
                throw new Exception($transResult);
            }

            return response()->json([
                "ok" => true,
                "msg" => "Record added successfully",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "ok" => false,
                "msg" => "An error occured while adding record, please contact admin",
                "error" => [
                    "msg" => $e->__toString(),
                    "fix" => "Please complete all required fields",
                ]
            ]);
        }
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
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "presbytery" => "required",
            "district" => "required",
            "branch" => "required",
            "union" => "required",
            "title" => "required",
            "fname" => "required",
            "lname" => "required",
            "gender" => "required",
            "phone" => "required",
            "member_type" => "required",
            "createuser" => "required",
            "id" => "required",
       ], [
           "presbytery.required" => "No presbytery supplied",
           "district.required" => "No district supplied",
           "branch.required" => "No branch supplied",
           "union.required" => "No union supplied",
           "title.required" => "No title supplied",
           "fname.required" => "No first name supplied",
           "lname.required" => "No last name supplied",
           "gender.required" => "No gender supplied",
           "phone.required" => "No phone supplied",
           "member_type.required" => "No member type supplied",
           "createuser.required" => "No user supplied",
           "id.required" => "No id supplied",
       ]);

        if ($validator->fails()) {
            return response()->json([
                "ok" => false,
                "msg" => "Operation failed." . join(". ", $validator->errors()->all()),
            ]);
        }

        try {
            $transResult = DB::transaction(function () use ($request) {
                $record = Members::find($request->id);

                $record->update([
                    'presbytery' => $request->presbytery,
                    'district' => $request->district,
                    'branch' => $request->branch,
                    'union' => $request->union,
                    'title' => $request->title,
                    'fname' => $request->fname,
                    'mname' => $request->mname,
                    'lname' => $request->lname,
                    'gender' => $request->gender,
                    'dob' => $request->dob,
                    'marital_status' => $request->marital_status,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'nationality' => $request->nationality,
                    'hometown' => $request->hometown,
                    'region' => $request->region,
                    'member_type' => $request->member_type,
                    'institution' => $request->institution,
                    'programme' => $request->programme,
                    'current_level' => $request->current_level,
                    'academic_year' => $request->academic_year,
                    'residence' => $request->residence,
                    'room_details' => $request->room_details,
                    'employment_status' => $request->employment_status,
                    'profession' => $request->profession,
                    'pob' => $request->pob,
                    'mother_church' => $request->mother_church,
                    'place_of_work' => $request->place_of_work,
                    'emergency_person' => $request->emergency_person,
                    'emergency_contact' => $request->emergency_contact,
                    'picture' => $request->picture,
                    'position' => $request->position,
                    'position_year' => $request->position_year,
                ]);
            });

            if (!empty($transResult)) {
                throw new Exception($transResult);
            }

            return response()->json([
                "ok" => true,
                "msg" => "Record updated successfully",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "ok" => false,
                "msg" => "An error occured while updating record, please contact admin",
                "error" => [
                    "msg" => $e->__toString(),
                    "fix" => "Please complete all required fields",
                ]
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $record = Members::find($id);

            if (!$record) {
                return response()->json([
                    "ok" => false,
                    "msg" => "Rccord not found!",
                ]);
            }

            $record->delete();

            return response()->json([
                "ok" => true,
                "msg" => "Deleted successfully",
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                "ok" => false,
                "msg" => "Request failed. An internal error occured",
                "errMsg" => $e->getMessage(),
            ]);
        }
    }
}
