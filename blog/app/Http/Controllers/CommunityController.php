<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Community;
use App\Models\Category;



class CommunityController extends Controller
{
    //
    function communities(Request $req){
        $user = Auth::user();
        $user_id = $user->id;

        $user_communities = Community::where('owner_id', $user_id)
                    ->orderBy('created_at', 'desc')
                    ->get();
        $all_communities = Community::all();
        $categories = Category::all();
      
        return view('community.communities',['user_communities' => $user_communities, 'categories' => $categories]);

    }

    function create_community(Request $req){
        // $data = $req->all();
        // dd($data); 
        
        
        $validatedData = $req->validate([
            'name' => 'required|string|max:255',
            'short_title' => 'nullable|string|max:255',
            'type' => 'required|in:public,private,closed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'terms_condition' => 'nullable|string',
            'categories' => 'required|array'
        ]);

        $user = Auth::user();
        $user_id = $user->id;
        $validatedData['owner_id'] = $user_id;
        $validatedData['created_by'] = $user_id;

        if ($req->hasFile('image')) {
            $imagePath = $req->file('image')->store('community_cover_images', 'public');
            $validatedData['image'] = $imagePath;
        }
        

        $community = Community::create($validatedData);

        if (isset($validatedData['categories'])) {
            $community->categories()->attach($validatedData['categories']);
        }

        return redirect()->route('community')->with('success', 'Community created successfully.');

    }
}
