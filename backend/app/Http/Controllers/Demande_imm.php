<?php

namespace App\Http\Controllers;
use App\Models\Parcelle;
use Exception;

class Demande_imm extends Controller
{
    public function generateDemande($id){
        $Parcelle = Parcelle::with('User' , 'Village' , 'Proprietaire')->find($id);
        
        $demande = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template.docx'));
        $demande->setValue('nom du propriétaire' ,$Parcelle->Proprietaire->nom);
        $demande->setValue('prénom du propriétaire' ,$Parcelle->Proprietaire->prenom);
        $demande->setValue('date de délimitation de la parcelle' ,$Parcelle->date_delimitation);
        $demande->setValue('numéro de la parcelle' ,$Parcelle->numero);
        $demande->setValue('nom du village' ,$Parcelle->Village->nom);
        $demande->setValue('adresse du propriétaire' ,$Parcelle->Proprietaire->adresse);

        try{
            $demande->saveAs('demande'.$Parcelle->numero.'.docx');
        }catch(Exception $e){
            //handle exception
        }

        return response()->download('demande'.$Parcelle->numero.'.docx');
        
    }
}
