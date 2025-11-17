<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Blog::where('is_active', true);

        // Search functionality
        if ($request->has('search') && $request->input('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $blogs = $query->orderBy('created_at', 'desc')->paginate(9);

        return view('client.blogs.index', compact('blogs'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $blog = Blog::where('is_active', true)->findOrFail($id);
        $recentBlogs = Blog::where('is_active', true)
            ->where('id', '!=', $id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('client.blogs.show', compact('blog', 'recentBlogs'));
    }
}
