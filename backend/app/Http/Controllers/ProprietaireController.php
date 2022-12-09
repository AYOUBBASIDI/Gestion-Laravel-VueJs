<?php

namespace App\Http\Controllers;

use App\Models\Photo_identite;
use App\Models\Proprietaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

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

        $AcceptedTypes=["Cin", "Passeport", "Permis", "Carte de résident"];

        $validator = Validator::make($request->all(),[
            'nom' => ['required'],
            'prenom' => ['required'],
            'sexe' => ['required'],
            'nationalite' => ['required'],
            'type_identite' => ['required','exists:'.$AcceptedTypes],
            'numero_identite' => ['required','unique:proprietaires'],
            'adresse' => ['required']
        ]);


        if($validator->fails()){
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }

        // Save Photo in locally folder 
        if ($request->hasFile('src')) {
            $file = $request->file('src');
            $numero_identite = $request->numero_identite;
            $file_name = $numero_identite . '_' . $file->getClientOriginalName();
            $file->move(public_path('Photos_identite'), $file_name);
        } else {
            return response()->json("Problem", 400);
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

    public function getProprietaires(Proprietaire $Proprietaires)
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

    public function updateProprietaire(Request $request, $id)
    {

        $Proprietaire = Proprietaire::find($id);
        if ($request->hasFile('src')) {    
            $file = $request->file('src');
            $numero_identite = $request->numero_identite;
            $file_name = $numero_identite . '_' . $file->getClientOriginalName();
            $file->move(public_path('Photos_identite'), $file_name);
            $photo = Photo_identite::where('proprietaire_id', $Proprietaire->id)->first();
            File::delete('Photos_identite/' . $photo->src);
            $photo->src = $file_name;
            $photo->update();
        } else {
            return response()->json($request->src, 400);
        }
        $Proprietaire->update($request->all());
        $response = [
            'success' => true,
            'message' => "Proprietaire Updated Seccusfuly"
        ];
        return response()->json($response, 200);
    }
}
