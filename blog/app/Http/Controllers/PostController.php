<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Blog;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

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
        $blogs = Blog::orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        return view('home', ['blogs' => $blogs, 'categories'=>$categories]);
    }
    else {
        return view('login');
    }
}

function sorted_home_blogs(Request $req){
    $user_id = session('user_id');
    if ($user_id) {
        $sortValue = $req->input('sorted_value') ;
        $filterValue = $req->filter_value;
        $blogArray = [];

            if ($sortValue == 'oldest') {
                $blogs = Blog::orderBy('created_at', 'asc');
                if($filterValue !== 'all' && $filterValue !== null){
                    $blogs->where('category_id', $filterValue);
                }
                $blogs = $blogs->get();
            }

            else if($sortValue == 'recent'){
                $blogs = Blog::orderBy('created_at', 'desc');
                if($filterValue !== 'all' && $filterValue !== null){
                    $blogs->where('category_id', $filterValue);
                }
                $blogs = $blogs->get();
            }

            else if($sortValue == 'last_hour'){
                $startTime = Carbon::now()->subHours(1);
                //$currentTime = Carbon::now();
                $blogs = Blog::orderBy('created_at', 'desc')
                        ->where('created_at', '>=',$startTime);
                if($filterValue !== 'all' && $filterValue !== null){
                    $blogs->where('category_id', $filterValue);
                }
                $blogs = $blogs->get();
            }
            else if($sortValue == 'Last_24'){
                $startTime = Carbon::now()->subHours(24);
                $blogs = Blog::orderBy('created_at', 'desc')
                             ->where('created_at', '>=',$startTime);
                if($filterValue !== 'all' && $filterValue !== null){
                    $blogs->where('category_id', $filterValue);
                }
                $blogs = $blogs->get();
            }
            else if($sortValue == 'last_week'){
                $startTime = Carbon::now()->subWeek();
                $blogs = Blog::orderBy('created_at', 'desc')
                            ->where('created_at', '>=',$startTime);
                if($filterValue !== 'all' && $filterValue !== null){
                    $blogs->where('category_id', $filterValue);
                }
                $blogs = $blogs->get();
            }
            else if($sortValue == 'last_month'){
                $startTime = Carbon::now()->subMonth();
                $blogs = Blog::orderBy('created_at', 'desc')
                    ->where('created_at', '>=',$startTime);
                if($filterValue !== 'all' && $filterValue !== null){
                    $blogs->where('category_id', $filterValue);
                }
                $blogs = $blogs->get();
            }
            else if($sortValue == 'last_year'){
                $startTime = Carbon::now()->subYear();
                $blogs = Blog::orderBy('created_at', 'desc')
                    ->where('created_at', '>=',$startTime);
                if($filterValue !== 'all' && $filterValue !== null){
                    $blogs->where('category_id', $filterValue);
                }
                $blogs = $blogs->get();
            }
            else if($sortValue == 'most_liked'){
                $blogs = Blog::withCount('likes')->orderBy('likes_count', 'desc')->orderBy('created_at', 'desc');
                if($filterValue !== 'all' && $filterValue !== null){
                    $blogs->where('category_id', $filterValue);
                }
                $blogs = $blogs->get();
            }
            else if($sortValue == 'most_commented'){
                $blogs = Blog::withCount('comments')->orderBy('comments_count', 'desc')->orderBy('created_at', 'desc');
                $blogs->orderBy('created_at', 'desc');
                if($filterValue !== 'all' && $filterValue !== null){
                    $blogs->where('category_id', $filterValue);
                }
                $blogs = $blogs->get();
            }
            else{
                $blogs = [];
            }

        if($blogs){
            foreach ($blogs as $blog) {
                $createdAt = Carbon::parse($blog->created_at);
                $currentTime = Carbon::now();

                $diffInSeconds = $createdAt->diffInSeconds($currentTime);
                $diffInMinutes = $createdAt->diffInMinutes($currentTime);
                $diffInHours = $createdAt->diffInHours($currentTime);
                $diffInDays = $createdAt->diffInDays($currentTime);
                $diffInMonths = $createdAt->diffInMonths($currentTime);
                $diffInYears = $createdAt->diffInYears($currentTime);

                // Rename the variable to $posted_at
                $posted_at = '';

                if ($diffInYears > 0) {
                    $posted_at = $diffInYears . ' year' . ($diffInYears > 1 ? 's' : '') . ' ago';
                } elseif ($diffInMonths > 0) {
                    $posted_at = $diffInMonths . ' month' . ($diffInMonths > 1 ? 's' : '') . ' ago';
                } elseif ($diffInDays > 0) {
                    $posted_at = $diffInDays . ' day' . ($diffInDays > 1 ? 's' : '') . ' ago';
                } elseif ($diffInHours > 0) {
                    $posted_at = $diffInHours . ' hour' . ($diffInHours > 1 ? 's' : '') . ' ago';
                } elseif ($diffInMinutes > 0) {
                    $posted_at = $diffInMinutes . ' minute' . ($diffInMinutes > 1 ? 's' : '') . ' ago';
                } else {
                    $posted_at = $diffInSeconds . ' second' . ($diffInSeconds > 1 ? 's' : '') . ' ago';
                }

                $blogArray[] = [
                    'user_name' => $blog->user->name, // Assuming you have a user relationship in your Blog model.
                    'title' => $blog->title,
                    'content' => $blog->content,
                    'total_likes' => $blog->totalLikes(), // You need to define this method in your Blog model.
                    'total_comments' => $blog->totalComments(), // You need to define this method in your Blog model.
                    'image' => asset('storage/' . $blog->image),
                    'id' => $blog->id,
                    'posted_at' => $posted_at
                ];
            }
        }


        return response()->json(['blogs' => $blogArray ,'sort_by' => $sortValue, 'filter_by' => $filterValue]);
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

