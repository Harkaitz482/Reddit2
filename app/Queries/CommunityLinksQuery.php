<?php

namespace App\Queries;

use App\Models\Channel;
use App\Models\CommunityLink;
use Nette\Utils\Strings;

class CommunityLinksQuery
{
     public static function getByChannel(Channel $channel)
    {
        return CommunityLink::where('approved', 1)->where('channel_id', $channel['id'])->latest('updated_at')->paginate(25);
    }

    public static function getAll()
    {
        return CommunityLink::where('approved', 1)->latest('updated_at')->paginate(25);
    }

    public static function getMostPopular()
    {
        return CommunityLink::where('approved', 1)->withCount('users')->orderBy('users_count', 'desc')->paginate(25);
    }
    public static function getMostPopularbyChannel(Channel $channel)
    {
        return CommunityLink::where('approved', 1)->where('channel_id', $channel['id'])->withCount('users')->orderBy('users_count', 'desc')->paginate(25);
    }

    public static function getBysearch(String $busqueda)
    {
        return CommunityLink::where('title','like','%' .$busqueda .'%')->latest('updated_at')->paginate(25);
    }

    public static function getBySearchandMostPopular(String $busqueda)
    {
        return CommunityLink::where('approved', 1)->where('title', 'like', '%' .$busqueda . '%')->withCount('users')->orderBy('users_count', 'desc')->paginate(25);
    }
    
}
