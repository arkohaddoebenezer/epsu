<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\InstitutionResource;
use App\Models\Institutions;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Institutions::get();

        return response()->json([
            "data" => InstitutionResource::collection($data)
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
             "name" => "required",
             "country" => "required",
             "region" => "required",
             "presbytery" => "required",
             "createuser" => "required",
        ], [
            "name.required" => "No name supplied",
            "country.required" => "No branch supplied",
            "region.required" => "No branch supplied",
            "presbytery.required" => "No branch supplied",
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

                Institutions::create([
                    'url_hash' => bin2hex(random_bytes(50)),
                    'name' => $request->name,
                    'country' => $request->country,
                    'region' => $request->region,
                    'presbytery' => $request->presbytery,
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
            "name" => "required",
            "country" => "required",
            "region" => "required",
            "presbytery" => "required",
            "id" => "required",
       ], [
           "name.required" => "No name supplied",
           "country.required" => "No branch supplied",
           "region.required" => "No branch supplied",
           "presbytery.required" => "No branch supplied",
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
                $record = Institutions::find($request->id);

                $record->update([
                    'name' => $request->name,
                    'country' => $request->country,
                    'region' => $request->region,
                    'presbytery' => $request->presbytery,
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
            $record = Institutions::find($id);

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
