<?php

namespace App\Http\Controllers;

use App\Services\ReferentielService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ReferentielController extends Controller
{
    protected $referentielService;

    public function __construct(ReferentielService $referentielService)
    {
        $this->referentielService = $referentielService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['etat']);
        $referentiels = $this->referentielService->getReferentiels($filters);
        return response()->json($referentiels, 200);
    }

    public function store(Request $request)
    {
        // Générer un code unique
        $code = $this->generateUniqueCode();

        // Fusionner le code généré avec les autres données de la requête
        $data = $request->all();
        $data['code'] = $code; // Ajoute le code généré

        $validator = Validator::make($data, [
            'libelle' => 'required|string|unique:referentiels',
            'description' => 'required|string',
            'photo_couverture' => 'required|string',
            'competences' => 'array',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $id = $this->referentielService->createReferentiel($data);
            return response()->json(['id' => $id, 'message' => 'Référentiel créé avec succès'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    private function generateUniqueCode()
    {
        do {
            $code = 'REF' . strtoupper(Str::random(5)); // Génère un code aléatoire de 5 lettres après "REF"
            // Vérifiez l'unicité dans Firebase
            $existingReferentiels = $this->referentielService->getReferentiels(['code' => $code]);
        } while (!empty($existingReferentiels)); // Continue jusqu'à ce qu'un code unique soit trouvé

        return $code;
    }


    public function show(Request $request, $id)
    {
        $filters = $request->only(['competence', 'modules']);
        try {
            $referentiel = $this->referentielService->getReferentiel($id, $filters);
            return response()->json($referentiel, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'libelle' => 'string',
            'description' => 'string',
            'photo_couverture' => 'string',
            'competences' => 'array',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $this->referentielService->updateReferentiel($id, $request->all());
            return response()->json(['message' => 'Référentiel mis à jour avec succès'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $this->referentielService->deleteReferentiel($id);
            return response()->json(['message' => 'Référentiel archivé avec succès'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function archived()
    {
        $archivedReferentiels = $this->referentielService->getArchivedReferentiels();
        return response()->json($archivedReferentiels, 200);
    }
}
