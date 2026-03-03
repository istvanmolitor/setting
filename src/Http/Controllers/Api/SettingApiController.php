<?php

namespace Molitor\Setting\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Molitor\Setting\Services\SettingHandler;

class SettingApiController extends Controller
{
    public function __construct(
        protected SettingHandler $settingHandler
    ) {
    }

    public function index(): JsonResponse
    {
        return response()->json($this->settingHandler->toArray());
    }

    public function show(string $slug): JsonResponse
    {
        $settingForm = $this->settingHandler->getSettingFormBySlug($slug);

        if (!$settingForm) {
            return response()->json(['message' => 'Setting not found'], 404);
        }

        return response()->json($settingForm->toArray());
    }

    public function update(Request $request, string $slug): JsonResponse
    {
        $settingForm = $this->settingHandler->getSettingFormBySlug($slug);

        if (!$settingForm) {
            return response()->json(['message' => 'Setting not found'], 404);
        }

        $this->settingHandler->saveSettingFormValues($slug, $request->all());

        return response()->json([
            'message' => 'Settings saved successfully',
            'data' => $settingForm->toArray(),
        ]);
    }
}
