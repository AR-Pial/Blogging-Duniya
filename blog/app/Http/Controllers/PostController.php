<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Blog;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

function get_categories(Request $req){

    $user_id = session('user_id');
    if ($user_id) {
        $categories = Category::all();
        return view('create_blog', ['categories' => $categories]);
    }
    else {
        return view('login');
    }
}
function create_post(Request $req){
    $user_id = session('user_id');
    $blog = new Blog();
    $blog->title = $req->title;
    $blog->content = $req->blog_content;
    $blog->category_id = $req->category;
    $blog->user_id = $user_id;


    if ($req->hasFile('image')) {
        $imagePath = $req->file('image')->store('blog_images', 'public');
        $blog->image = $imagePath;
    }
    $blog->save();
    return redirect()->route('user_posts');
}

function home_blogs(Request $req){

    $user_id = session('user_id');
    if ($user_id) {

        $blogs = Blog::all();
        return view('home', ['blogs' => $blogs]);
    }
    else {
        return view('login');
    }
}

function blog_page($id){

    $user_id = session('user_id');
    if ($user_id) {
        $blog = Blog::find($id);
        $user = User::find($user_id);
        $comments = $blog->comments;
        $liked = $user->likedBlogs->contains($blog);
        return view('blog_page', ['blog' => $blog,'comments'=>$comments,'liked'=>$liked]);
    }
    else {
        return view('login');
    }
}

function get_blog(Request $req){
    $user_id = session('user_id');
    if ($user_id) {
        $categories = Category::all();
        $id = $req->input('id');
        $blog = Blog::find($id);
        return response()->json(['blog' => $blog,'categories' => $categories]);
    }
    else {
        return view('login');
    }
}

function edit_blog(Request $req){
    $blogId = $req->input('blog_id');
    $category = $req->input('category');
    $title = $req->input('title');
    $blogContent = $req->input('blog_content');

    $blog = Blog::find($blogId);
    $blog->title=$title;
    $blog->category_id=$category;
    $blog->content=$blogContent;

    if($req->hasFile('image')) {
        if($blog->image){
            $prev_image = $blog->image;
            Storage::delete('public/' . $prev_image);
        }
        $imagePath = $req->file('image')->store('blog_images', 'public');
        $blog->image = $imagePath;
    }

    $blog->save();
    return response()->json(["ok" => $req]);
}

function delete_blog(Request $req){
    $user_id = session('user_id');
    if ($user_id){
        $id = $req->input('id');
        $blog = Blog::find($id);
        if($blog->image){
            $prev_image = $blog->image;
            Storage::delete('public/' . $prev_image);
        }
        $blog-> delete();

        return response()->json(["message"=> "Blog Deleted."]);
    }
    else{
        return view('login');
    }
}

    function create_comment(Request $req){
        $user_id = session('user_id');
        if($user_id){
            $blogID = $req->input('blog_id');
            $user_comment = $req->input('comment');
            $comment = new Comment();
            $comment->content = $user_comment;
            $comment->user_id = $user_id;
            $comment->blog_id = $blogID;
            $comment->save();
            return response()->json(["message"=>"Comment Created"]);
        }
        else{
            return view('login');
        }
    }

    function delete_comment(Request $req){
        $user_id = session('user_id');
        if ($user_id){
            $id = $req->input('id');
            $comment = Comment::find($id);
            $comment-> delete();
            return response()->json(["message"=> "Comment Deleted."]);
        }
        else{
            return view('login');
        }
    }

    function like_unlike(Request $req){
        $user_id = session('user_id');
        if($user_id){
            $id = $req->input('blog_id');
            $blog = Blog::find($id);
            $user = User::find($user_id);
            $liked = $user->likedBlogs->contains($blog);
            if ($liked){
                $user->likedBlogs()->detach($blog);
                return response()->json(["message"=> "Blog Unliked"]);
            }
            else{
                $user->likedBlogs()->attach($blog);
                return response()->json(["message"=> "Liked"]);
            }

        }
        else{
            return view('login');
        }
    }


}

