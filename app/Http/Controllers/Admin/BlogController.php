<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function blogAll(Request $request, $userId = null)
    {
        $pageTitle = 'All Blogs';

        $blogs = Blog::orderBy('id', 'desc')->paginate(getPaginate());

        return view('admin.blogs.all_blogs', compact('pageTitle', 'blogs'));

    }

    public function store(Request $request)
{
    try {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blogs,slug',
            'content' => 'required|string',
            'status' => 'required|integer',
        ]);

        Blog::create([
            'title' => $validatedData['title'],
            'slug' => $validatedData['slug'],
            'content' => $validatedData['content'],
            'status' => $validatedData['status'],
            'published_at' => $validatedData['status'] == Blog::STATUS_PUBLISHED ? now() : null,
        ]);

        $message  = "Blog Created Successfully";

        return returnBack($message, 'success');
    } catch (\Exception $e) {
        $errorMessage = "Failed to create the blog. Please check the form for errors.";

        return returnBack($errorMessage, 'error');
    }
}


public function delete($id)
{
    try {
        $blog = Blog::findOrFail($id);

        $blog->delete();

        $message = "Blog post deleted successfully!";

        return returnBack($message, 'success');
    } catch (\Exception $e) {

        $errorMessage = "Failed to delete the blog post. Please try again.";

        return returnBack($errorMessage, 'error');
    }
}


}
