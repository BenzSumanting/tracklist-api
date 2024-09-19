<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Song;
use App\Http\Resources\SongResource;
use App\Http\Requests\SongRequest;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $songs = Song::paginate();

        return response()->json([
            'data' => SongResource::collection($songs),
            'links' => [
                'first' => $songs->url(1),
                'last' => $songs->url($songs->lastPage()),
                'prev' => $songs->previousPageUrl(),
                'next' => $songs->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $songs->currentPage(),
                'last_page' => $songs->lastPage(),
                'per_page' => $songs->perPage(),
                'total' => $songs->total(),
            ]
        ], 200);
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
    public function store(SongRequest $request)
    {
        $new_song = Song::create($request->validated());
        return (new SongResource($new_song))->response()->setStatusCode(200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Song $song)
    {
        return (new SongResource($song))->response()->setStatusCode(200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SongRequest $request, Song $song)
    {
        $song->update( $request->validated() );
		return (new SongResource($song))->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Song $song)
    {
        $song->delete();
		return response()->noContent();
    }
}
