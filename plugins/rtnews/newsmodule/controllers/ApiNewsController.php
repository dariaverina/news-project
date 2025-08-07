<?php

namespace RtNews\NewsModule\Controllers;

use RtNews\NewsModule\Models\News;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiNewsController extends BaseController
{
    // GET /api/news
    public function index()
    {
        $news = News::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->get();

        return response()->json($news);
    }

    // GET /api/news/{slug} 
    public function show($slug)
    {
        $newsItem = News::where('slug', $slug)->where('is_published', true)->first();

        if (!$newsItem) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json($newsItem);
    }

    // POST /api/news
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'title' => 'required|string',
            'slug' => 'required|string|unique:rtnews_news,slug',
            'content' => 'nullable|string',
            'published_at' => 'nullable|date',
            'is_published' => 'boolean',
        ]);

        $news = News::create($validated);

        return response()->json($news, 201);
    }

    // PUT /api/news/{id} 
    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $news = News::find($id);

        if (!$news) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string',
            'slug' => 'sometimes|required|string|unique:rtnews_news,slug,' . $id,
            'content' => 'nullable|string',
            'published_at' => 'nullable|date',
            'is_published' => 'boolean',
        ]);

        $news->update($validated);

        return response()->json($news);
    }

    // DELETE /api/news/{id}
    public function destroy($id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $news = News::find($id);

        if (!$news) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $news->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
