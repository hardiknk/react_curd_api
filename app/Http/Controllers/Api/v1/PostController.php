<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PhpParser\Node\Stmt\TryCatch;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $page = $request->has("page") ? $request->page : 1;
            $limit = $request->has("limit") ? $request->limit : 2;

            $posts = Post::query();
            $posts = $posts->withExists("category");
            $total_item = $posts->count();
            $posts =  $posts->limit($limit)->offset(($page - 1) * $limit)->latest()->get();

            // dd($posts->category);
            $paginate = [
                "page_size" => $limit,
                "current_page" => $page,
                "total_item" => $total_item,
                "total_page_count" => ceil($total_item / $limit),
            ];

            return (PostResource::collection($posts))->additional(["paginate" => $paginate]);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
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
        try {
            $request['custom_id'] = getUniqueString("posts");
            $post = Post::create($request->all());
            return (new PostResource($post))->additional([
                "meta" => [
                    "message" => "Post Create Sucessfully",
                ]
            ]);
        } catch (Exception $e) {
        }

        return $this->returnResponse();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {

        try {
            $this->status = Response::HTTP_OK;
            return (new PostResource($post))->additional([
                "meta" => [
                    "message" => "Post Data Fetch Successfully",
                ]
            ]);
        } catch (Exception $e) {
            $this->status["meta"]["message"] = $e->getMessage();
        }

        return $this->returnResponse();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        try {
            if ($request->has("post_status")) {
                $status = $request->post_status === true ? "y" : "n";
                $is_update =   $post->update([
                    "is_active" => $status,
                ]);
                if ($is_update) {
                    return "success";
                } else {
                    return  "something_wrong";
                }
            } else {
                $is_update = $post->update($request->input());
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
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $status = "";
        try {
            $is_delete = $post->delete();
            $status = "success";
        } catch (QueryException $e) {
            $status = "error";
        } catch (Exception $e) {
            $status = "error";
        }

        return response()->json($status);
    }
}
