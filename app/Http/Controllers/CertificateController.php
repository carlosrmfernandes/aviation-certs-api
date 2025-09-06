<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;
use Illuminate\Support\Facades\Validator;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::with('user')
            ->where('user_id', auth('api')->id())
            ->get();

        return response()->json($certificates);
    }

    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'description' => 'required|string',
            'partNumber' => 'required|string',
            'serialNumber' => 'sometimes|string|unique:certificates',
            'name' => 'required|string',
            'formNumber' => 'required|string',
            'workOrderNumber' => 'required|string',
            'quantity' => 'required|string',
            'status' => 'required|string',
            'remarks' => 'nullable|string',
            'approval' => 'required|string',
        ]);

        if ($data->fails()) {
            return response()->json(['errors' => $data->errors()], 422);
        }

        $certificate = Certificate::create([
            'user_id' => auth('api')->id(),
            'description' => $request->description,
            'partNumber' => $request->partNumber,
            'serialNumber' => $request->serialNumber,
            'name' => $request->name,
            'formNumber' => $request->formNumber,
            'workOrderNumber' => $request->workOrderNumber,
            'quantity' => $request->quantity,
            'status' => $request->status,
            'remarks' => $request->remarks,
            'approval' => $request->approval,
        ]);

        return response()->json($certificate->load('user'), 201);
    }

    public function show($id)
    {
        $certificate = Certificate::with('user')
            ->where('user_id', auth('api')->id())
            ->findOrFail($id);

        return response()->json($certificate);
    }

    public function update(Request $request, $id)
    {
        $certificate = Certificate::where('user_id', auth('api')->id())->findOrFail($id);

        $data = Validator::make($request->all(), [
            'description' => 'sometimes|string',
            'partNumber' => 'sometimes|string',
            'serialNumber' => 'sometimes|string|unique:certificates,serialNumber,' . $id,
            'name' => 'sometimes|string',
            'formNumber' => 'sometimes|string',
            'workOrderNumber' => 'sometimes|string',
            'quantity' => 'sometimes|string',
            'status' => 'sometimes|string',
            'remarks' => 'nullable|string',
            'approval' => 'sometimes|string',
        ]);

        if ($data->fails()) {
            return response()->json(['errors' => $data->errors()], 422);
        }

        $certificate->update($request->all());
        return response()->json($certificate->load('user'));
    }

    public function destroy($id)
    {
        $certificate = Certificate::where('user_id', auth('api')->id())->findOrFail($id);
        $certificate->delete();
        return response()->json(['message' => 'Certificate deleted successfully']);
    }
}
