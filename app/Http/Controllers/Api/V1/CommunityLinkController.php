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


        $user_id = $request->input('user_id');
        $data = $request->validated();


        $approved = Auth::user()->isTrusted();

        $data['user_id'] = $user_id;

        $data['approved'] = $approved;

        $link = new CommunityLink();

        $link->user_id = Auth::id();



        // $data['channel_id'] = 1;
        // dd($data);
        // CommunityLink::create($data);
        // return back()->with('success', 'Item created successfully!');


        if ($link->hasAlreadyBeenSubmitted($data['link'])) {
            if ($approved === false) {
                return response()->json(['info' => 'El enlace ya está publicado y aprobado, pero usted es un usuario no verificado, por lo que no se actualizará en la lista']);
            } elseif ($approved === true) {
                return response()->json(['success' => '¡Enlace actualizado correctamente!']);
            } else {
                return response()->json(['info' => 'Objeto actualizado con éxito, esperando que un moderador lo apruebe']);
            }
        } else {
            CommunityLink::create($data);
            if ($approved === true) {
                return response()->json(['success' => '¡Enlace creado exitosamente!']);
            } else {
                return response()->json(['message' => 'Su enlace será revisado por el administrador antes de su publicación. Gracias por su contribución.'], 201);
            }
        }
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
