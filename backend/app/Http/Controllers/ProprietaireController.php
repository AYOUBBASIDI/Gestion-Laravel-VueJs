<?php

namespace App\Http\Controllers;
use App\Models\Photo_identite;
use App\Models\Proprietaire;
use Illuminate\Http\Request;

class ProprietaireController extends Controller
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

     
    public function newProprietaire(Request $request)
    {
        // Save Photo in locally folder 
        if($request->hasFile('src')){
            $file = $request->file('src');
            $numero_identite = $request->numero_identite;
            $file_name = $numero_identite. '_' . $file->getClientOriginalName(); 
            $file->move(public_path('Photos_identite'), $file_name);

        }else{
            return response()->json($request->src,400);
        }
        
        // Save data to database
        $input = $request->all();
        $Proprietaire = Proprietaire::create($input);
        $input['src'] = $file_name;
        $input['proprietaire_id'] = $Proprietaire->id;
        $Photo_identite = Photo_identite::create($input);

        // send response
        $response = [
            'success' => true,
            'message' => "Proprietaire Added succesfully"
        ];
        return response()->json($response, 200);
    }

    public function getProprietaires(Proprietaire $Proprietaire)
    {
        $Proprietaires = Proprietaire::all();
        return $Proprietaires;
    }

    public function getSpecificProprietaire($id)
    {
        $Proprietaire = Proprietaire::find($id);
        return $Proprietaire;
    }

    public function deleteProprietaire($id)
    {
        $Proprietaire = Proprietaire::find($id);
        $Proprietaire->delete();
        $response = [
            'success' => true,
            'message' => "Proprietaire deleted succesfully"
        ];
        return response()->json($response, 200);
    }

    public function updateProprietaire(Request $request, $id){
      
        $input = $request->all();

        // Find Proprietaire
        $Proprietaire = Proprietaire::find($id);

        // Update Proprietaire table
        $Proprietaire->nom = $input['nom'];
        $Proprietaire->prenom = $input['prenom'];
        $Proprietaire->sexe = $input['sexe'];
        $Proprietaire->nationalite = $input['nationalite'];
        $Proprietaire->type_identite = $input['type_identite'];
        $Proprietaire->adresse = $input['adresse'];
        $Proprietaire->update();

        $response = [
            'success' => true,
            'message' => "Proprietaire Updated Seccusfuly"
        ];
        return response()->json($response, 200);
    } 

    
}
