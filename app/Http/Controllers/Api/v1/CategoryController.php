<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllCategoryResource;
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
    }
    public function index(Request $request)
    {
        // dd($request->input());
        // echo '<pre>';
        // print_r($request->input());
        // '</pre>';

        try {
            $page = $request->has("page") ? $request->page : 1;
            $limit = $request->has("limit") ? $request->limit : 10;

            $category = Category::query();
            $total_item = $category->count();
            $categories =  $category->limit($limit)->offset(($page - 1) * $limit)->latest()->get();

            $paginate = [
                "page_size" => $limit,
                "current_page" => $page,
                "total_item" => $total_item,
                "total_page_count" => ceil($total_item / $limit),
            ];

            return (CategoryResources::collection($categories))->additional(["paginate" => $paginate]);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function allCategory()
    {
        try {
            $categories = Category::all();
            return AllCategoryResource::collection($categories)->additional([
                "meta" => [
                    "message" => "Categories Fetch Successfully",
                ]
            ]);
        } catch (Exception $e) {
            $this->response['meta']['message']  = $e->getMessage();
        }

        return $this->returnResponse();
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

        try {
            if ($request->has("category_status")) {
                $status = $request->category_status === true ? "y" : "n";
                $is_update =   $category->update([
                    "is_active" => $status,
                ]);
                if ($is_update) {
                    return "success";
                } else {
                    return  "something_wrong";
                }
            } else {
                $is_update = $category->update($request->input());
                if ($is_update) {
                    return "success";
                } else {
                    return  "something_wrong";
                }
            }
        } catch (Exception $ex) {
            return response()->json($ex->getMessage());
        }
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
