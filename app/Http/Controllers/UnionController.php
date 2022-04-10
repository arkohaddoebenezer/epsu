<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UnionResource;
use App\Models\Unions;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UnionController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Unions::get();

        return response()->json([
            "data" => UnionResource::collection($data)
        ]);
    }

    public function unions($presbytery, $district, $branch)
    {

        $data = Unions::with('_branch._district._presbytery', '_branch._district')->when($presbytery !== "all", function ($q) use ($presbytery) {
            $q->whereHas('_branch._district._presbytery', function ($query) use ($presbytery) {
                $query->where('presbytery', $presbytery);
            });
        })->when($district !== "all", function ($q) use ($district) {
            $q->whereHas('_branch._district', function ($query) use ($district) {
                $query->where('district', $district);
            });
        })->when($branch !== "all", function ($q) use ($branch) {
            return $q->where('branch', $branch);
        })->get();

        // $data = Unions::when($branch !== "all", function ($q) use($branch) {
        //     return $q->where('branch', $branch);
        // })->get();

        return response()->json([
            "data" => UnionResource::collection($data)
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
             "branch" => "required",
             "createuser" => "required",
        ], [
            "name.required" => "No name supplied",
            "branch.required" => "No branch supplied",
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

                Unions::create([
                    'url_hash' => bin2hex(random_bytes(50)),
                    'name' => $request->name,
                    'branch' => $request->branch,
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
            "branch" => "required"
        ], [
            "id.required" => "No id supplied",
            "name.required" => "No name supplied",
            "branch.required" => "No branch supplied",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "ok" => false,
                "msg" => "Operation failed." . join(". ", $validator->errors()->all()),
            ]);
        }

        try {
            $transResult = DB::transaction(function () use ($request) {
                $record = Unions::find($request->id);

                $record->update([
                    'name' => $request->name,
                    'branch' => $request->branch,
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
            $record = Unions::find($id);

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
