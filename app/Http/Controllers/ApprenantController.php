<?php

namespace App\Http\Controllers;

use App\Services\ApprenantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApprenantController extends Controller
{
    protected $apprenantService;

    public function __construct(ApprenantService $apprenantService)
    {
        $this->apprenantService = $apprenantService;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'adresse' => 'required|string',
            'telephone' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'photo' => 'required|string',
            'referentiel' => 'required|string',
            'date_naissance' => 'required|date',
            'sexe' => 'required|in:M,F',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $id = $this->apprenantService->createApprenant($request->all());
            return response()->json(['id' => $id, 'message' => 'Apprenant créé avec succès'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function import(Request $request)
    {
     
        $request->validate(["file" => 'required|file']);
    
        try {
            // Appel au service pour l'importation
            $result = $this->apprenantService->importApprenants($request->file('file'));
            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    
    public function index(Request $request)
    {
    
        $filters = $request->only(['referentiel', 'statut']);
        $apprenants = $this->apprenantService->getApprenants($filters);
        return response()->json($apprenants, 200);
    }

    public function show(Request $request, $id)
    {
        $filters = $request->only(['presence', 'notes']);
        try {
            $apprenant = $this->apprenantService->getApprenant($id, $filters);
            return response()->json($apprenant, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function inactiveApprenants()
    {
        $inactiveApprenants = $this->apprenantService->getInactiveApprenants();
        return response()->json($inactiveApprenants, 200);
    }

    public function sendBulkReminder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $this->apprenantService->sendBulkActivationReminder($request->ids);
        return response()->json(['message' => 'Rappels envoyés avec succès'], 200);
    }

    public function sendReminder($id)
    {
        try {
            $this->apprenantService->sendActivationReminder($id);
            return response()->json(['message' => 'Rappel envoyé avec succès'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}