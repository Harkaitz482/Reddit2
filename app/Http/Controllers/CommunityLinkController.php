<?php

namespace App\Http\Controllers;

use App\Models\Channel;



use Illuminate\Support\Facades\Auth;


use App\Models\CommunityLink;
use Illuminate\Http\Request;

class CommunityLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $links = CommunityLink::where('approved', true)->latest('updated_at')->paginate(25);
        $channels = Channel::orderBy('title', 'asc')->get();

        return view('community/index', compact('links', 'channels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'link' => 'required|url|max:255',
            'channel_id' => 'required|exists:channels,id'
        ]);

        $data['user_id'] = Auth::id();
        $user = Auth::User();
        $trusted = $user->isTrusted();

        $approved = $trusted ? true : false ;;

        $data['approved'] = $approved;

        CommunityLink::create($data);
      


        





        if ($trusted) {
            return redirect()->back()->with('success', 'el enlace se ha creado correctamente');
        } else {
            return redirect()->back()->with('error', 'el enlace no se ha creado correctamente');
        }


        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(CommunityLink $communityLink)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommunityLink $communityLink)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommunityLink $communityLink)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommunityLink $communityLink)
    {
        //
    }
}
