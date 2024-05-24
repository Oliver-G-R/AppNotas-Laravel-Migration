<?php

namespace App\Services;

use App\Http\Requests\NoteRequest;
use App\Models\Note;
use Illuminate\Http\Response;

class NoteService
{
  public function __construct(
    private readonly Note $NoteModel  
  ){}

  public function createNote (NoteRequest $note){
    try {
      $allNoteInfo = $note->all();

      $note = $this->NoteModel::create($allNoteInfo);

      return response()->json([
          "status"=> "success",
          "message"=> "Se creo la nota",
          "data"=> $note
          ],201);
    
    } catch (\Throwable $th) {
      return response()->json([
          "message" => "Error al obtener los datos",
      ], 500);
    }
  }

  public function getNoteById ($id){
    try {

      $note = $this->NoteModel::find($id);

      if(!$note){
          return response()->json([
              "message"=> "No existe la nota"
          ], 404);
      }

      return response()->json([
          "message"=> "Nota obtenida correctamente",
          "data"=> $note
      ],200);
    } catch (\Throwable $th) {
        return response()->json([
            "message" => "Error al obtener los datos",
        ], 500);
    }
  }

  public function updateNote (NoteRequest $note,  $id){
    try {

      $body = $note->all();

      $note = $this->NoteModel::find($id);

      if(!$note){
          return response()->json([
              "message"=> "No existe la nota"
          ], 404);
      }

      $note->titulo = $body["titulo"];
      $note->descripcion = $body["descripcion"];
      $note->importancia = $body["importancia"];
      $note->save();


      return response()->json([
          "message" => "Nota actualizada de forma exitosa",
          "data" => $note
      ], 200);


    } catch (\Throwable $th) {
        return response()->json([
          "message" => "Error al obtener los datos",
      ], 500);
    }
  }

  public function deleteNote ($id){
    try {
      $note = $this->NoteModel::find($id);

      if(!$note){
          return response()->json([
              "message"=> "No existe la nota"
          ], 404);
      }

      $note->delete();

      return response()->json([
          "message"=> "Nota eliminada correctamente"
      ],200);

    } catch (\Throwable $th) {
        return response()->json([
            "message" => "Error al obtener los datos",
        ], 500);
    }
  }

  public function getAllNotes (){
    try {
      $userData = $this->NoteModel->all();
      
      if($userData->isEmpty()){
          return response()->json([
              "message"=> "No hay datos registrados"
          ], 200);
      }

      return response()->json([
          "message"=> "Datos obtenidos correctamente",
          "data"=> $userData
      ],200);

    } catch (\Throwable $th) {
      return response()->json([
          "message" => "Error al obtener los datos",
      ], 500);
    }
  }
}