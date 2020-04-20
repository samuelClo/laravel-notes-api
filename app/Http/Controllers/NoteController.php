<?php

namespace App\Http\Controllers;

use App\note;
use Illuminate\Http\Request;
use Exception;

class noteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $error = null;
        $allNotes = null;

        try {
            $allNotes = Note::orderBy('created_at', 'desc')->get();
        } catch(Exception $err) {
            $error = $err->errorInfo[2];

            return  response()->json([
                'error' => $error,
            ]);
        }

        return  response()->json([
            'error' => $error,
            'notes' => $allNotes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $error = null;
        $note = null;
        $requestRes = $request->all();

        try {
            $note = Note::create($requestRes);
        } catch(Exception $err) {
            $error = $err->errorInfo[2];

            return  response()->json([
                'error' => $error,
            ]);
        }

        return  response()->json([
            'error' => $error,
            'note' => $note,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\note  $note
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $error = null;
        $note = null;

        try {
            $note = Note::findOrFail($id);
        } catch(Exception $err) {
            $error = 'Cet identifiant est inconnu';

            return  response()->json([
                'error' => $error,
            ], 404);
        }

        return  response()->json([
            'error' => $error,
            'note' => $note,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $error = null;
        $note = null;
        $requestRes = $request->all();

        try {
            $note = Note::findOrFail($id);
        } catch(Exception $err) {
            $error = 'Cet identifiant est inconnu';

            return  response()->json([
                'error' => $error,
            ], 404);
        }

        try {
            $note->update($requestRes);
        } catch(Exception $err) {
            $error = $err->errorInfo[2];
        }

        return  response()->json([
            'error' => $error,
            'note' => $note,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Note  $Note
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $error = null;
        $note = null;

        try {
            $note = Note::findOrFail($id);
        } catch(Exception $err) {
            $error = 'Cet identifiant est inconnu';

            return  response()->json([
                'error' => $error,
            ], 404);
        }

        try {
            $note->delete($id);
        } catch(Exception $err) {
            $error = $err->errorInfo[2];
        }

        return  response()->json([
            'error' => $error,
        ]);
    }
}
