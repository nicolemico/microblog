<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Models\Post;
use App\Models\Images;
use ErrorException;

class PostController extends Controller
{
    public function store(PostCreateRequest $request) {
        $filePath = [];

        if ($request->hasFile('postImage')) {
            foreach($request->file('postImage') as $image) {
                $path = $image->store('post');
                if (!$path) {
                    throw new ErrorException('Failed to upload file');
                }
                array_push($filePath, $path);
            }
        }

        $post = new Post;
        $post->user_id = $request->user()->id;
        $post->content = $request->postContent;
        $post->type = $request->type;
        $post->save();

        foreach($filePath as $imagePath) {
            $images = new Images;
            $images->post_id = $post->id;
            $images->path = $imagePath;
            $images->save();
        }

        return redirect()->back();
    }
}
