<?php

namespace App\Http\Controllers;

use App\Models\Chirp;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class ChirpController extends Controller
{
    public function index(): InertiaResponse
    {
        return Inertia::render(component:'Chirps/Index', props:[
            'chirps' => Chirp::with(relations:'user:id,name')->latest()->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(rules:[
            'message' => 'required|string|max:255',
        ]);

        $request->user()->chirps()->create($validated);

        return redirect(to:route(name:'chirps.index'));
    }

    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        $this->authorize(ability:'update', arguments:$chirp);

        $validated = $request->validate(rules:[
            'message' => 'required|string|max:255',
        ]);

        $chirp->update(attributes:$validated);

        return redirect(to:route(name:'chirps.index'));
    }

    public function destroy(Chirp $chirp): RedirectResponse
    {
        $this->authorize(ability:'delete', arguments:$chirp);

        $chirp->delete();

        return redirect(to:route(name:'chirps.index'));
    }
}
