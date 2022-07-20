<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Lead;
use App\Mail\NewContractRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    public function store(Request $request) {
        $data = $request->all();
        // Verifica dei dati
        $validator = Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        // Salvare il nuovo lead nel database
        $lead = new Lead();
        $lead->fill($data);
        $lead->save();

        // Inviare l'email all'amministratore per avvisarlo che c'è stata una nuova ichiesta di contatto
        Mail::to('superadmin@boolpress.it')->send(new NewContractRequest($lead));

        return response()->json([
            'success' => true
        ]);
    }
}