<?php

namespace App\Http\Controllers;
use App\Models\Village;
use Illuminate\Http\Request;

class VillageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     
    public function newVillage(Request $request)
    {
        $input = $request->all();
        $Village = Village::create($input);

        $response = [
            'success' => true,
            'message' => "Village Added succesfully"
        ];
        return response()->json($response, 200);
    }

    public function getVillages(Village $Villages)
    {
        $Villages = Village::all();
        return $Villages;
    }

    public function getSpecificVillage($id)
    {
        $Proprietaire = Village::find($id);
        return $Proprietaire;
    }

    public function deleteVillage($id)
    {
        $Village = Village::find($id);
        $Village->delete();
        $response = [
            'success' => true,
            'message' => "Village deleted succesfully"
        ];
        return response()->json($response, 200);
    }

    public function updateVillage(Request $request, $id){
        $village = Village::find($id);
        $input = $request->all();
        $village->nom = $input['nom'];
        $village->update();
        $response = [
            'success' => true,
            'message' => "Village Updated Seccusfuly"
        ];
        return response()->json($response, 200);
    }

    
}
