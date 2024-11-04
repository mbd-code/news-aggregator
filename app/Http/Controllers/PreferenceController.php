<?php

namespace App\Http\Controllers;

use App\Models\Preference;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class PreferenceController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/preferences",
     *     summary="Set or update user preferences.",
     *     tags={"Preferences"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="source", type="string", example="NewsAPI"),
     *             @OA\Property(property="category", type="string", example="General"),
     *             @OA\Property(property="author", type="string", example="Test")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Preferences updated."),
     *     security={{"sanctum": {}}}
     * )
     */
    public function storeOrUpdate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'source' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
        ]);

        $preference = Preference::updateOrCreate(
            ['user_id' => auth()->id()],
            $validated + ['user_id' => auth()->id()]
        );

        return response()->json($preference);
    }

    /**
     * @OA\Get(
     *     path="/api/preferences",
     *     summary="Retrieve user preferences.",
     *     tags={"Preferences"},
     *     @OA\Response(response=200, description="Preferences retrieved."),
     *     security={{"sanctum": {}}}
     * )
     */
    public function index(): JsonResponse
    {
        $preference = Preference::where('user_id', auth()->id())->first();
        return response()->json($preference);
    }
}
