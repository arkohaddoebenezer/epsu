<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfessionalMemberResource;
use App\Models\ProfessionalMembers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProfessionalMembersController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ProfessionalMembers::get();

        return response()->json([
            "data" => ProfessionalMemberResource::collection($data)
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
             "title" => "required",
             "name" => "required",
             "group" => "required",
             "createuser" => "required",
        ], [
            "title.required" => "No title supplied",
            "name.required" => "No name supplied",
            "group.required" => "No group supplied",
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

                ProfessionalMembers::create([
                    'title' => $request->title,
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'group' => $request->group,
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
            "title" => "required",
            "name" => "required",
            "group" => "required",
            "id" => "required",
       ], [
           "title.required" => "No title supplied",
           "name.required" => "No name supplied",
           "group.required" => "No group supplied",
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
                $record = ProfessionalMembers::find($request->id);

                $record->update([
                    'title' => $request->title,
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'group' => $request->group,
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
            $record = ProfessionalMembers::find($id);

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
