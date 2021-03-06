<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Player as PlayerResource;
use App\Http\Resources\PlayerCollection;



class PlayerController extends Controller
{
    //returns all players
    public function index(){
        return new PlayerCollection(\App\Models\Player::all());
    }

    //show a single player
    public function show($id){
        return new PlayerResource(\App\Models\Player::findOrFail($id));
    }
    //save player
    public function store(Request $request){
        $request -> validate([
            'name' => 'required|max:255',
        ]);

        $player = \App\Models\Player::create($request->all());

        return (new PlayerResource($player))->response()->setStatusCode(201);
    }

    public function answer($id,Request $request){
        //merge correct bool to correct answer
        $request->merge(['correct' => (bool) json_decode($request->get('correct'))]);

        $request -> validate(['correct' => 'required|boolean']);

        //retrieve curent player
        $player = Player::findOrdFail($id);

        //increment questions answered
        $player->answers++;

        //check whether question answered is coreect if not, subtract one else add one
        $player->points = ($request->get('correct')?$player->points+1:$player->points-1);

        $player->save();

        return new PlayerResource($player);
    }

    public function delete($id){
        \App\Models\Player::findOrFail($id)->delete();

        return response()->json(null,204);
    }

    public function resetAnswer($id){
        $player = \App\Models\Player::findOrFail($id);
        $player->asnwers = 0;
        $player->points = 0;

        return new PlayerResource($player);

    }
}
