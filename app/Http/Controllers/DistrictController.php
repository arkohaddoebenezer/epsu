<?php

namespace App\Http\Controllers;

use App\Http\Resources\DistrictResource;
use App\Models\Districts;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Districts::get();

        return response()->json([
            "data" => DistrictResource::collection($data)
        ]);
    }

    public function districts($presbytery)
    {
        $data = Districts::when($presbytery !== "all", function ($q) use($presbytery) {
            return $q->where('presbytery', $presbytery);
        })->get();

        return response()->json([
            "data" => DistrictResource::collection($data)
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
             "presbytery" => "required",
             "createuser" => "required",
        ], [
            "name.required" => "No name supplied",
            "presbytery.required" => "No presbytery supplied",
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

                Districts::create([
                    'url_hash' => bin2hex(random_bytes(50)),
                    'name' => $request->name,
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
            "id" => "required",
            "name" => "required",
            "presbytery" => "required"
        ], [
            "id.required" => "No id supplied",
            "name.required" => "No name supplied",
            "presbytery.required" => "No presbytery supplied",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "ok" => false,
                "msg" => "Operation failed." . join(". ", $validator->errors()->all()),
            ]);
        }

        try {
            $transResult = DB::transaction(function () use ($request) {
                $record = Districts::find($request->id);

                $record->update([
                    'name' => $request->name,
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
            $record = Districts::find($id);

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
