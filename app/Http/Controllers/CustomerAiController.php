<?php

namespace App\Http\Controllers;

use App\Services\CustomerAiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerAiController extends Controller
{
    public function message(
        Request $request,
        CustomerAiService $assistant
    ): JsonResponse {
        $validated = $request->validate([
            'message' => [
                'required',
                'string',
                'max:1000',
            ],

            'context' => [
                'nullable',
                'array',
            ],

            'context.selected_product_id' => [
                'nullable',
                'integer',
            ],

            'context.current_page' => [
                'nullable',
                'string',
                'in:products,product,cart,orders,wishlist,profile,settings,ai_hub,other',
            ],

            'context.visible_product_ids' => [
                'nullable',
                'array',
                'max:12',
            ],

            'context.visible_product_ids.*' => [
                'integer',
            ],
        ]);

        $result = $assistant->respond(
            $validated['message'],
            $request->user(),
            $validated['context'] ?? []
        );

        return response()->json($result);
    }

    public function clearHistory(Request $request, CustomerAiService $assistant): JsonResponse
    {
        $assistant->clearHistory($request->user());

        return response()->json(['ok' => true]);
    }

    public function history(Request $request, CustomerAiService $assistant): JsonResponse
    {
        return response()->json([
            'ok' => true,
            'messages' => $assistant->history($request->user()),
        ])->header('Cache-Control', 'private, no-store');
    }
}
