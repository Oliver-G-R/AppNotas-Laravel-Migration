<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Services\NoteService;

class NoteController extends Controller
{
    public function __construct(
        private readonly NoteService $noteService
    ){}

    public function index (){
        return $this->noteService->getAllNotes();
    }

    public function store (NoteRequest $note){
        return $this->noteService->createNote($note);
    }

    public function update (NoteRequest $request, $id){
       return $this->noteService->updateNote($request, $id);
    }

    public function show($id){
        return $this->noteService->getNoteById($id);
    }

    public function destroy($id){
       return $this->noteService->deleteNote($id);
    }
}
