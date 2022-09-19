<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResources;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // echo "hjooo";
    }
    public function index()
    {
        try {
            //code...
        } catch (Exception $e) {
        }
        $category = Category::query();
        $total_item = $category->count();
        $categories =  $category->latest()->get();

        $pageSize = 2;
        $currentPage =  1;


        $paginate = [
            "page_size" => $pageSize,
            "current_page" => $currentPage,
            "total_item" => $total_item,
            "total_page_count" => ceil($total_item / $pageSize),
        ];

        return (CategoryResources::collection($categories))->additional(["paginate" => $paginate]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = Category::create($request->input());
        return response()->json($category, Response::HTTP_CREATED);

        //
        // echo "hiiikkllkkl";
        // return response()->json("hiiii store call");
        // dd($request->input());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {

        return response()->json($category);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $is_update = $category->update($request->input());
        if ($is_update) {
            return "success";
        } else {
            return  "something_wrong";
        }
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
        $is_delete = $category->delete();
        return response()->json($is_delete);
    }
}
