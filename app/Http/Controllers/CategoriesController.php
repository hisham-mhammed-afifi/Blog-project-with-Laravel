<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\Categories\CategoriesRequest;
use App\Post;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'isAdmin'])->only('index', 'create', 'store', 'destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categories.index')
            ->with('categories', Category::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.index')
            ->with('categories', Category::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriesRequest $request)
    {
        Category::create([
            'name' => $request->name,
        ]);
        session()->flash('success', 'Category Created Successfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('categories.posts')
            ->with('categories', Category::all())
            ->with('category', $category)
            ->with('posts', $category->posts()->searched()->orderBy('id', 'desc')->simplePaginate(3));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category->posts->count() > 0) {
            session()->flash('error', 'Category can not be Deleted It has posts');
            return redirect()->back();
        }
        $category->delete();
        return redirect()->back();
    }
}
