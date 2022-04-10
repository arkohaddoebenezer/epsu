<?php

namespace App\Http\Controllers;

use App\Http\Resources\CongressMemberResource;
use App\Models\CongressMembers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CongressMembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = CongressMembers::get();

        return response()->json([
            "data" => CongressMemberResource::collection($data)
        ]);
    }

    public function members($union, $congress)
    {
        $data = CongressMembers::when($union !== "all", function ($q) use($union) {
            return $q->where('union', $union);
        })->when($congress !== "all", function ($q) use($congress) {
            return $q->where('congress', $congress);
        })->get();

        return response()->json([
            "data" => CongressMemberResource::collection($data)
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
             "fname" => "required",
             "lname" => "required",
             "phone" => "required",
             "union" => "required",
             "congress" => "required",
             "createuser" => "required",
        ], [
            "fname.required" => "No fname supplied",
            "lname.required" => "No lname supplied",
            "phone.required" => "No phone supplied",
            "union.required" => "No union supplied",
            "congress.required" => "No congress supplied",
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

                CongressMembers::create([
                    'fname' => $request->fname,
                    'mname' => $request->mname,
                    'lname' => $request->lname,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'union' => $request->union,
                    'congress' => $request->congress,
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
            "fname" => "required",
            "lname" => "required",
            "phone" => "required",
            "union" => "required",
            "congress" => "required",
            "id" => "required",
       ], [
           "fname.required" => "No fname supplied",
           "lname.required" => "No lname supplied",
           "phone.required" => "No phone supplied",
           "union.required" => "No union supplied",
           "congress.required" => "No congress supplied",
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
                $record = CongressMembers::find($request->id);

                $record->update([
                    'fname' => $request->fname,
                    'mname' => $request->mname,
                    'lname' => $request->lname,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'union' => $request->union,
                    'congress' => $request->congress,
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
            $record = CongressMembers::find($id);

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