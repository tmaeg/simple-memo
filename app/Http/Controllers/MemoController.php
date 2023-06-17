<?php

namespace App\Http\Controllers;

use App\Models\Memo;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Redirect;

class MemoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Memos/Index', [
            'memos' => Auth::user()->memos()->get(),
        ]);
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
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'content' => 'required|string|max:100',
        ]);

        $request->user()->memos()->create($validated);

        return redirect(route('dashboard'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Memo $memo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Memo $memo): Response
    {
        return Inertia::render('Memos/Edit', [
            'memo' => $memo,
            'no' => request()->query('no'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Memo $memo): RedirectResponse
    {
        $this->authorize('update', $memo);

        
        $validated = $request->validate([
            'content' => 'required|string|max:100',
        ]);

        $memo->update($validated);

        return redirect(route('dashboard'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Memo $memo)
    {
        //
    }
}
