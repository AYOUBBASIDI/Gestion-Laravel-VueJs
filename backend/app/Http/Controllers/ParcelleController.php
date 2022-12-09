<?php

namespace App\Http\Controllers;
use App\Models\Parcelle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ParcelleController extends Controller
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

     
    public function newParcelle(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(),[
            'numero' => ['required',  'integer', 'unique:parcelles', ],
            'proprietaire_id' => ['required', 'exists:proprietaires,id'],
            'village_id' => ['required','exists:villages,id'],
            'date_delimitation' => ['required'],
            'user_id' => ['required'],
            'signature' => ['required']
        ]);


        if($validator->fails()){
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }

        $Parcelle = Parcelle::create($input);

        $response = [
            'success' => true,
            'message' => "Parcelle added succefully"
        ];
        return response()->json($response, 200);
    }

    public function getParcelles(Parcelle $Parcelles)
    {
        $Parcelles = Parcelle::with('User' , 'Village' , 'Proprietaire')->get();
        return $Parcelles;
    }

    public function getSpecificParcelle($id){
        $Parcelle = Parcelle::find($id);
        return $Parcelle;
    }

    public function deleteParcelle($id)
    {
        $Parcelle = Parcelle::find($id);
        $Parcelle->delete();
        $response = [
            'success' => true,
            'message' => "Parcelle deleted succesfully"
        ];
        return response()->json($response, 200);
    }

    public function updateParcelle(Request $request, $id){
        $Parcelle = Parcelle::find($id);
        $input = $request->all();
        $Parcelle->user_id = $input['user_id'];
        $Parcelle->village_id = $input['village_id'];
        $Parcelle->proprietaire_id = $input['proprietaire_id'];
        $Parcelle->numero = $input['numero'];
        $Parcelle->date_delimitation = $input['date_delimitation'];
        $Parcelle->signature = $input['signature'];
        $Parcelle->update();
        $response = [
            'success' => true,
            'message' => "Parcelle Updated Seccusfuly"
        ];
        return response()->json($response, 200);
    }
    
}
