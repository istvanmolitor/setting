<?php

namespace Molitor\Setting\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Molitor\Setting\Services\SettingHandlerService;

class SettingApiController extends Controller
{
    public function __construct(
        protected SettingHandlerService $settingHandlerService
    ) {
    }

    public function index(): JsonResponse
    {
        return response()->json($this->settingHandlerService->getTabs());
    }

    public function show(string $slug): JsonResponse
    {
        $settingForm = $this->settingHandlerService->getBySlug($slug);

        if (!$settingForm) {
            return response()->json(['message' => 'Setting not found'], 404);
        }

        return response()->json([
            'slug' => $settingForm->getSlug(),
            'label' => $settingForm->getLabel(),
            'form' => $settingForm->getForm(),
            'data' => $settingForm->getFormData(),
        ]);
    }

    public function update(Request $request, string $slug): JsonResponse
    {
        $settingForm = $this->settingHandlerService->getBySlug($slug);

        if (!$settingForm) {
            return response()->json(['message' => 'Setting not found'], 404);
        }

        $this->settingHandlerService->saveFormData($slug, $request->all());

        return response()->json([
            'message' => 'Settings saved successfully',
            'data' => $settingForm->getFormData(),
        ]);
    }
}
