<?php

namespace App\Http\Controllers;

use App\Services\PromotionService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PromotionController extends Controller
{
    protected $service;

    public function __construct(PromotionService $service)
    {
        $this->service = $service;
    }

    public function create(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'libelle' => 'required|string',
            'dateDebut' => 'required|date',
            'dateFin' => 'required|date|after:dateDebut',
            'photoCouverture' => 'nullable|string',
            'referentiels' => 'nullable|array'
        ]);

        try {
            $promotion = $this->service->createPromotion($validated);
            return response()->json($promotion, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'libelle' => 'sometimes|required|string',
            'dateDebut' => 'sometimes|required|date',
            'dateFin' => 'sometimes|required|date|after:dateDebut',
            'photoCouverture' => 'nullable|string',
        ]);

        try {
            $promotion = $this->service->updatePromotion($id, $validated);
            return response()->json($promotion);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function updateReferentiels(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'referentiels' => 'required|array'
        ]);

        try {
            $promotion = $this->service->updateReferentiels($id, $validated['referentiels']);
            return response()->json($promotion);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function updateEtat(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'etat' => 'required|in:Actif,Cloturer,Inactif'
        ]);

        try {
            $promotion = $this->service->updateEtat($id, $validated['etat']);
            return response()->json($promotion);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function index(): JsonResponse
    {
        $promotions = $this->service->getAllPromotions();
        return response()->json($promotions);
    }

    public function encours(): JsonResponse
    {
        $promotion = $this->service->getPromotionEncours();
        return response()->json($promotion);
    }

    public function cloturer(string $id): JsonResponse
    {
        try {
            $promotion = $this->service->cloturerPromotion($id);
            return response()->json($promotion);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function getReferentiels(string $id): JsonResponse
    {
        try {
            $referentiels = $this->service->getReferentiels($id);
            return response()->json($referentiels);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function getStats(string $id): JsonResponse
    {
        try {
            $stats = $this->service->getStats($id);
            return response()->json($stats);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}