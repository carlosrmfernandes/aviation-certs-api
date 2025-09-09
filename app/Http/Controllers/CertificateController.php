<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;
use App\Models\CertificateItem;
use Illuminate\Support\Facades\Validator;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::with(['user', 'items'])
            ->where('user_id', auth('api')->id())
            ->get();

        return response()->json($certificates);
    }

    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'approvingAuthority' => 'required|string',
            'approvingCountry' => 'required|string',
            'formTrackingNumber' => 'required|string',
            'organizationName' => 'required|string',
            'organizationAddress' => 'nullable|string',
            'workOrderContractInvoiceNumber' => 'nullable|string',
            'remarks' => 'nullable|string',
            'conformityApprovedDesign' => 'boolean',
            'conformityNonApprovedDesign' => 'boolean',
            'returnToService' => 'boolean',
            'otherRegulation' => 'boolean',
            'authorizedSignature13' => 'nullable|string',
            'approvalAuthorizationNo' => 'nullable|string',
            'authorizedSignature14' => 'nullable|string',
            'approvalCertificateNo' => 'nullable|string',
            'name13' => 'nullable|string',
            'date13' => 'nullable|string',
            'name14' => 'nullable|string',
            'date14' => 'nullable|string',

            'items' => 'required|array',
            'items.*.item' => 'required|string',
            'items.*.description' => 'required|string',
            'items.*.partNumber' => 'required|string',
            'items.*.quantity' => 'required|string',
            'items.*.serialNumber' => 'nullable|string',
            'items.*.status' => 'required|string',
        ]);

        if ($data->fails()) {
            return response()->json(['errors' => $data->errors()], 422);
        }

        $certificate = Certificate::create([
            'user_id' => auth('api')->id(),
            'approvingAuthority' => $request->approvingAuthority,
            'approvingCountry' => $request->approvingCountry,
            'formTrackingNumber' => $request->formTrackingNumber,
            'organizationName' => $request->organizationName,
            'organizationAddress' => $request->organizationAddress,
            'workOrderContractInvoiceNumber' => $request->workOrderContractInvoiceNumber,
            'remarks' => $request->remarks,
            'conformityApprovedDesign' => $request->conformityApprovedDesign ?? false,
            'conformityNonApprovedDesign' => $request->conformityNonApprovedDesign ?? false,
            'returnToService' => $request->returnToService ?? false,
            'otherRegulation' => $request->otherRegulation ?? false,
            'authorizedSignature13' => $request->authorizedSignature13,
            'approvalAuthorizationNo' => $request->approvalAuthorizationNo,
            'authorizedSignature14' => $request->authorizedSignature14,
            'approvalCertificateNo' => $request->approvalCertificateNo,
            'name13' => $request->name13,
            'date13' => $request->date13,
            'name14' => $request->name14,
            'date14' => $request->date14,
        ]);

        foreach ($request->items as $itemData) {
            CertificateItem::create([
                'certificate_id' => $certificate->id,
                'item' => $itemData['item'],
                'description' => $itemData['description'],
                'partNumber' => $itemData['partNumber'],
                'quantity' => $itemData['quantity'],
                'serialNumber' => $itemData['serialNumber'],
                'status' => $itemData['status'],
            ]);
        }

        return response()->json($certificate->load(['user', 'items']), 201);
    }

    public function show($id)
    {
        $certificate = Certificate::with(['user', 'items'])
            ->where('user_id', auth('api')->id())
            ->findOrFail($id);

        return response()->json($certificate);
    }

    public function update(Request $request, $id)
    {
        $certificate = Certificate::where('user_id', auth('api')->id())->findOrFail($id);

        $data = Validator::make($request->all(), [
            'approvingAuthority' => 'required|string',
            'approvingCountry' => 'required|string',
            'formTrackingNumber' => 'required|string',
            'organizationName' => 'required|string',
            'organizationAddress' => 'nullable|string',
            'workOrderContractInvoiceNumber' => 'nullable|string',
            'remarks' => 'nullable|string',
            'conformityApprovedDesign' => 'boolean',
            'conformityNonApprovedDesign' => 'boolean',
            'returnToService' => 'boolean',
            'otherRegulation' => 'boolean',
            'authorizedSignature13' => 'nullable|string',
            'approvalAuthorizationNo' => 'nullable|string',
            'authorizedSignature14' => 'nullable|string',
            'approvalCertificateNo' => 'nullable|string',
            'name13' => 'nullable|string',
            'date13' => 'nullable|string',
            'name14' => 'nullable|string',
            'date14' => 'nullable|string',

            'items' => 'required|array',
            'items.*.item' => 'required|string',
            'items.*.description' => 'required|string',
            'items.*.partNumber' => 'required|string',
            'items.*.quantity' => 'required|string',
            'items.*.serialNumber' => 'nullable|string',
            'items.*.status' => 'required|string',
        ]);

        if ($data->fails()) {
            return response()->json(['errors' => $data->errors()], 422);
        }

        $certificate->update($request->only([
            'approvingAuthority', 'approvingCountry', 'formTrackingNumber',
            'organizationName', 'organizationAddress', 'workOrderContractInvoiceNumber',
            'remarks', 'conformityApprovedDesign', 'conformityNonApprovedDesign',
            'returnToService', 'otherRegulation', 'authorizedSignature13',
            'approvalAuthorizationNo', 'authorizedSignature14', 'approvalCertificateNo',
            'name13', 'date13', 'name14', 'date14'
        ]));

        if ($request->has('items')) {
            $existingItemIds = [];

            foreach ($request->items as $itemData) {
                if (isset($itemData['id'])) {
                    $item = CertificateItem::where('certificate_id', $certificate->id)
                        ->where('id', $itemData['id'])
                        ->first();

                    if ($item) {
                        $item->update($itemData);
                        $existingItemIds[] = $item->id;
                    }
                } else {
                    $newItem = CertificateItem::create([
                        'certificate_id' => $certificate->id,
                        'item' => $itemData['item'],
                        'description' => $itemData['description'],
                        'partNumber' => $itemData['partNumber'],
                        'quantity' => $itemData['quantity'],
                        'serialNumber' => $itemData['serialNumber'],
                        'status' => $itemData['status'],
                    ]);
                    $existingItemIds[] = $newItem->id;
                }
            }

            CertificateItem::where('certificate_id', $certificate->id)
                ->whereNotIn('id', $existingItemIds)
                ->delete();
        }

        return response()->json($certificate->load(['user', 'items']));
    }

    public function destroy($id)
    {
        $certificate = Certificate::where('user_id', auth('api')->id())->findOrFail($id);
        $certificate->delete();
        return response()->json(['message' => 'Certificate deleted successfully']);
    }
}
