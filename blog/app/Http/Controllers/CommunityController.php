<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Community;
use App\Models\Category;
use App\Helper\Countries;
use Illuminate\Support\Facades\DB; 



class CommunityController extends Controller
{
    //
    function communities(Request $req){
        $user = Auth::user();
        $user_id = $user->id;

        $user_communities = Community::where('owner_id', $user_id)
                    ->orderBy('created_at', 'desc')
                    ->get();
        $joined_communities = $user->joined_communities;
        // $all_communities = Community::all();
        $unowned_communities = Community::where('owner_id', '!=', $user_id)
            ->whereDoesntHave('members', function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            })
            ->get();        
        $categories = Category::all();
        $countryData = Countries::$countryData;
        $locations = array_merge(['WORLD' => 'World'], $countryData);

        $newest_communities = Community::orderBy('created_at', 'desc')->take(100)->get();
        $most_membered_communities = Community::withCount('members')
        ->orderBy('members_count', 'desc')
        ->take(100)
        ->get();
        
        
        return view('community.communities',['unowned_communities' => $unowned_communities,'joined_communities' => $joined_communities,'newest_communities'=> $newest_communities, 'most_membered_communities'=> $most_membered_communities,'user_communities' => $user_communities, 'categories' => $categories,'locations' => $locations]);

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
            'categories' => 'required|array',
            'locations' => 'required|array',
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


        if (isset($validatedData['locations'])) {
            foreach ($validatedData['locations'] as $location) {
                DB::table('community_location')->insert([
                    'community_id' => $community->id,
                    'country' => $location,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->route('community')->with('success', 'Community created successfully.');

    }

    function community_page($id){
    
        $community = Community::find($id);
        
        return view('community.cummunity_page', ['community' => $community]);
    }

    function community_join($id){
        $user = Auth::user(); // Get the authenticated user
        $community = Community::findOrFail($id); // Find the community by ID

        // Check if the user is already a member
        if (!$community->members->contains($user->id)) {
            // Attach the user to the community
            $community->members()->attach($user->id);
            return redirect()->route('community_page', ['id' => $community->id])
            ->with('success', 'You have joined the community!');
        }

        return redirect()->route('community_page', ['id' => $community->id])
            ->with('success', 'You are already a member of this community.');
    }
}
