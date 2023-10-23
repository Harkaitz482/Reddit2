<?php

namespace App\Http\Controllers;

use App\Models\Channel;

use App\http\Requests\CommunityLinkForm;

use Illuminate\Support\Facades\Auth;


use App\Models\CommunityLink;
use Illuminate\Http\Request;

class CommunityLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Channel $channel = null)
    {
        // dd($channel);
        $channels = Channel::orderBy('title', 'asc')->get();

        if ($channel != null) {

            $links = $channel -> communitylinks()->where('approved', true)->where('channel_id', $channel->id) ->latest('updated_at')->paginate(25);
            
        } else {
            $links = CommunityLink::where('approved', true)->latest('updated_at')->paginate(25);
        }

        return view('community/index', compact('links', 'channels', 'channel'));
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
    public function store(CommunityLinkForm $request)
    {
        $link = new CommunityLink();
        $link->user_id = Auth::id();

        $data = $request->validated();



        $data['user_id'] = Auth::id();
        $user = Auth::User();
        $trusted = $user->isTrusted();


        $approved = $trusted ? true : false;;

        $data['approved'] = $approved;

        CommunityLink::create($data);








        if ($link->hasAlreadyBeenSubmitted($data['link'])) {

            if ($approved == false) {
                return back()->with('info', 'El enlace ya está publicado y aprobado pero usted es un usuario no verificado, por lo que no se actualizará en la lista');
            }
            if ($approved == true) {
                return back()->with('success', 'link actualizado correctamente!');
            } else {
                return back()->with('info', 'object successfully updated, waiting for a moderator to accept it');
            }
        } else {
            CommunityLink::create($data);
            if ($approved == true) {
                return back()->with('success', 'link created successfully!');
            } else {
                return back()->with('info', 'object successfully created, waiting for a moderator to accept it');
            }
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
