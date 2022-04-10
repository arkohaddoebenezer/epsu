<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\BranchResource;
use App\Models\Branches;
use App\Models\Districts;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Branches::get();

        return response()->json([
            "data" => BranchResource::collection($data)
        ]);
    }

    public function branches($presbytery, $district)
    {
        $data = Branches::with('_district._presbytery')->when($presbytery !== "all" && $district === 'all', function ($q) use ($presbytery) {
            $q->whereHas('_district._presbytery', function ($query) use ($presbytery) {
                $query->where('presbytery', $presbytery);
            });
        })->when($district !== "all", function ($q) use ($district) {
            return $q->where('district', $district);
        })->get();

        return response()->json([
            "data" => BranchResource::collection($data)
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
            "district" => "required",
            "createuser" => "required",
        ], [
            "name.required" => "No name supplied",
            "district.required" => "No district supplied",
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

                Branches::create([
                    'url_hash' => bin2hex(random_bytes(50)),
                    'name' => $request->name,
                    'district' => $request->district,
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
            "district" => "required"
        ], [
            "id.required" => "No id supplied",
            "name.required" => "No name supplied",
            "district.required" => "No district supplied",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "ok" => false,
                "msg" => "Operation failed." . join(". ", $validator->errors()->all()),
            ]);
        }

        try {
            $transResult = DB::transaction(function () use ($request) {
                $record = Branches::find($request->id);

                $record->update([
                    'name' => $request->name,
                    'district' => $request->presbytery,
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
            $record = Branches::find($id);

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
