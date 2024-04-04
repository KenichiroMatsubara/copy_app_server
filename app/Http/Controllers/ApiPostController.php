<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowPostRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class ApiPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @param \Illuminate\Http\Request
     */
    public function index(Request $request)
    {
        if(!$request->input('uid')){
            return response()->json([
                'status'=>false,
                'message'=>'Uid Param not found'
            ],400);
        }
        $uid = $request->input('uid');
        $posts = Post::where('uid',$uid)->get();
        return response()->json([
            'status'=>true,
            'message'=> 'Posts are shown successfully!',
            'uid'=>$uid,
            'data'=> $posts,
        ],200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $post = Post::create($request->all());
        return response()->json([
            'status'=>true,
            'message'=>'Post Created successfully!',
            'post' => $post
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return response()->json([
            'status'=>true,
            'message'=>'Post found successfully!',
            'post'=>$post
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request,$id)
    {
        $update = [
            'desc'=>$request->desc
        ];
        $post=Post::where('id',$id)->update($update);
        $posts = Post::all();
        if($post){
            return response()->json([
                'status'=>true,
                'message'=>'Post is updated successfully!',
                'data' => $posts,
            ],200);
        }
        else {
            return response()->json([
                'status'=>false,
                'message'=> 'Post not found'
            ],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id)->delete();
        $posts = Post::all();
        if($post){
            return response()->json([
                'message'=>'Post deleted successfully!',
                'data'=>$posts
            ],200);
        }
        else {
            return response()->json([
                'message'=>'Post not found',
            ],404);
        }
    }
}
