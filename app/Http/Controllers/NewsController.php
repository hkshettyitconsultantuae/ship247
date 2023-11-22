<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    const PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $news_query = News::query();
       
        $search_criteria = [
            'title' => $request->title,
            'category' => $request->category,
            'published_date' => $request->published_date,
        ];

        $title = $request->title ?? null;
        $category =$request->category ?? null;
        $published_date = $request->published_date ??null;

        if ($title) {
            $news_query->where(function ($titleQuery) use ($title) {
                $titleQuery->where('title', 'like', '%' . $title . '%');
            });
        }
        if ($category) {
            $news_query->where(function ($categoryQuery) use ($category) {
                $categoryQuery->where('category', 'like', '%' . $category . '%');
            });
        }

        if ($published_date) {
            $news_query->where(function ($q) use ($published_date) {
                $q->whereDate('published_date', '=', $published_date);
            });
        }

        $news_listing = $news_query->latest()->paginate(self::PER_PAGE)->appends($search_criteria);;
        return view('admin.news.index', compact('news_listing', 'title','category','published_date'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = News::distinct('category');
        return view('admin.news.create', compact( 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $news = new News;
        $news->title = $request->title;
        $news->category = $request->category;
        if($request->image) {
            $news->image = $request->image->store('news/images', 'public');
        }
        $news->detail = $request->detail;
        $news->published_date = $request->published_date;
        $news->save();

        return redirect()->route('superadmin.news.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        $categories = News::distinct('category');
        return view('admin.news.edit', compact('news', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        $news->title = $request->title;
        $news->category = $request->category;
        if($request->image) {
            $news->image = $request->image->store('news/images', 'public');
        }
        $news->detail = $request->detail;
        $news->published_date = $request->published_date;
        $news->save();

        return redirect()->route('superadmin.news.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->route('superadmin.news.index');
    }
}
