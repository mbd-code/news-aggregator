<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Preference;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="News Aggregator API",
 *     description="This is the API documentation for the News Aggregator project.",
 *     @OA\Contact(
 *         email="support@example.com"
 *     )
 * )
 */
class ArticleController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/articles",
     *     summary="Makale listesini getir",
     *     tags={"Articles"},
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="per_page", in="query", required=false, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Başarılı", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Article"))),
     *     security={{"sanctum": {}}}
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $user = auth()->user();
        $preference = Preference::where('user_id', $user->id)->first();

        $query = Article::query();

        // Kullanıcının tercihlerine göre filtreleme yap
        if ($preference) {
            if ($preference->source) {
                $query->where('source', $preference->source);
            }
            if ($preference->category) {
                $query->where('category', $preference->category);
            }
            if ($preference->author) {
                $query->where('author', $preference->author);
            }
        }

        // Sayfalama parametreleri
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 10);

        $articles = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json($articles);
    }

    public function show($id): JsonResponse
    {
        $article = Article::findOrFail($id);
        return response()->json($article);
    }

    /**
     * @OA\Post(
     *     path="/api/articles",
     *     summary="Create a new article.",
     *     tags={"Articles"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "content", "source"},
     *             @OA\Property(property="title", type="string", example="New Article Title."),
     *             @OA\Property(property="content", type="string", example="Article content..."),
     *             @OA\Property(property="source", type="string", example="NewsAPI")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Article created."),
     *     security={{"sanctum": {}}}
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'nullable|string|max:100',
            'source' => 'required|string',
            'category' => 'nullable|string|max:50',
            'published_at' => 'nullable|date',
        ]);

        $article = Article::create($validated);

        return response()->json($article, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/articles/search",
     *     summary="Search articles.",
     *     tags={"Articles"},
     *     @OA\Parameter(name="keyword", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="category", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="source", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="date", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Article"))),
     *     security={{"sanctum": {}}}
     * )
     */

    public function search(Request $request): JsonResponse
    {
        $query = Article::query();

        if ($request->has('keyword')) {
            $query->where('title', 'like', '%' . $request->keyword . '%')
                ->orWhere('content', 'like', '%' . $request->keyword . '%');
        }

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('source')) {
            $query->where('source', $request->source);
        }

        if ($request->has('date')) {
            $query->whereDate('published_at', $request->date);
        }

        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 10);

        $articles = $query->paginate($perPage, ['*'], 'page', $page);
        return response()->json($articles);
    }
}
