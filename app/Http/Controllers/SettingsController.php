<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    public function getToggleState()
    {
        $setting = Setting::firstOrCreate(
            ['user_id' => auth('api')->id()],
            ['toggle_value' => true]
        );

        return response()->json([
            'enabled' => (bool)$setting->toggle_value
        ]);
    }

    public function updateToggleState(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'enabled' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $setting = Setting::updateOrCreate(
            ['user_id' => auth('api')->id()],
            ['toggle_value' => $request->input('enabled')]
        );

        return response()->json([
            'message' => 'Toggle state updated successfully',
            'enabled' => (bool)$setting->toggle_value
        ]);
    }
}
