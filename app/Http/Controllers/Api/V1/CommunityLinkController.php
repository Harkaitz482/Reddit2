<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommunityLinkForm;
use App\Models\CommunityLink;
use Illuminate\Http\Request;
use App\Models\Channel;
use App\Queries\CommunityLinksQuery;
use Illuminate\Support\Facades\Auth;





class CommunityLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }
    public function index(channel $channel)
    {
        $channels = Channel::orderBy('title', 'asc')->get();

        if (request()->exists('popular')) {
            // otra consulta
            $links = CommunityLinksQuery::getMostPopular();
        } else {
            if ($channel != null) {
                $links = CommunityLinksQuery::getMostPopularbyChannel($channel);
            } else {
                $links = CommunityLinksQuery::getAll();
            }
        }

        if (request()->exists('busqueda') && request()->exists('popular')) {
            $links = CommunityLinksQuery::getBySearchandMostPopular(trim(request()->get('busqueda')));
        } else if (request()->exists('busqueda')) {
            $links = CommunityLinksQuery::getBysearch(trim(request()->get('busqueda')));
        }

        return response()->json(['Links' => $links], 200);
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
                return response()->with('info', 'El enlace ya está publicado y aprobado pero usted es un usuario no verificado, por lo que no se actualizará en la lista');
            }
            if ($approved == true) {
                return response()->with('success', 'link actualizado correctamente!');
            } else {
                return response()->with('info', 'object successfully updated, waiting for a moderator to accept it');
            }
        } else {
            CommunityLink::create($data);
            if ($approved == true) {
                return response()->with('success', 'link created successfully!');
            } else {
                return response()->with('info', 'object successfully created, waiting for a moderator to accept it');
            }
        }



        return response()->json(['message' => "Your link will be reviewed for the administrator before publishing.Thanks for your contribution."], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(CommunityLink $communityLink)
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
