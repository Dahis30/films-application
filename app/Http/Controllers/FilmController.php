<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;
use App\Http\Requests\Film as FilmRequest;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $films = Film::withTrashed()->oldest('title')->paginate(5);
        return view('index', compact('films'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FilmRequest $filmRequest)
    {
        Film::create($filmRequest->all());
        return redirect()->route('films.index')->with('info', 'Le film a bien été créé');
    }

    /**
     * Display the specified resource.
     */
    public function show(Film $film)
    {
        return view('show', compact('film'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Film $film)
    {
        return view('edit', compact('film'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FilmRequest $filmRequest, Film $film)
    {
        $film->update($filmRequest->all());
        return redirect()->route('films.index')->with('info', 'Le film a bien été modifié');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Film $film)
    {
        $film->delete();
        return back()->with('info', 'Le film a bien été mis dans la corbeille.');
    }

    public function forceDestroy($id)
    {
        Film::withTrashed()->whereId($id)->firstOrFail()->forceDelete();
        return back()->with('info', 'Le film a bien été supprimé définitivement dans la base de données.');
    }

    public function restore($id)
    {
        Film::withTrashed()->whereId($id)->firstOrFail()->restore();
        return back()->with('info', 'Le film a bien été restauré.');
    }
}
