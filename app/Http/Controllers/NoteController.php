<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Support\Facades\Validator;
class NoteController extends Controller
{
    public function index (){
        
        try {
            $userData = Note::all();
            
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
                "data" => $th->getMessage()
            ], 500);
        }
    }

    public function store (Request $request){
        try {
            $body = $request->all();

            $validatData = Validator::make($body, [
                "titulo" => "required", 
                "descripcion" => "required",
                "importancia" => "in:medium,hig,no-important",
            ]);

            if($validatData->fails()){
                return response()->json([
                    "status"=> "error",
                    "errors" => $validatData->errors()
                    ], 400);
            }

            $note = Note::create($body);

            return response()->json([
                "status"=> "success",
                "message"=> "Se creo la nota",
                "data"=> $note
                ],201);
        

        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Error al obtener los datos",
                "data" => $th->getMessage()
            ], 500);
        }
    }

    public function update (Request $request, $id){
        try {
            $body = $request->all();

            $note = Note::find($id);

            if(!$note){
                return response()->json([
                    "message"=> "No existe la nota"
                ], 404);
            }


            $validatData = Validator::make($body, [
                "titulo" => "required", 
                "descripcion" => "required",
                "importancia" => "in:medium,hig,no-important",
            ]);

            if($validatData->fails()){
                return response()->json([
                    "status"=> "error",
                    "errors" => $validatData->errors()
                    ], 400);
            }

            $note->titulo = $body["titulo"];
            $note->descripcion = $body["descripcion"];
            $note->importancia = $body["importancia"];
            $note->save();


            return response()->json([
                "message" => "Nota actualizada de forma exitosa",
                "data" => $note
            ]);


        } catch (\Throwable $th) {
              return response()->json([
                "message" => "Error al obtener los datos",
                "data" => $th->getMessage()
            ], 500);
        }
    }

    public function show($id){
        try {
            $note = Note::find($id);

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
                "data" => $th->getMessage()
            ], 500);
        }
    }

    public function destroy($id){
        try {
            $note = Note::find($id);

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
                "data" => $th->getMessage()
            ], 500);
        }
    }
}
