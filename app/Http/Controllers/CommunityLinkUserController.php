<?php

namespace App\Http\Controllers;

use App\Models\CommunityLink;
use App\Models\CommunityLinkUser;
use Illuminate\Support\Facades\Auth;



use Illuminate\Http\Request;

class CommunityLinkUserController extends Controller
{
    public function store(CommunityLink $link)
    {
        CommunityLinkUser::firstOrNew([
            'user_id' => Auth::id(),
            'community_link_id' => $link->id
            ])->toggle();
        return back();
    }
}
