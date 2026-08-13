<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\MouvementStock;
use App\Models\TypeMouvement;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MouvementStockController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = MouvementStock::with(['article', 'user', 'typeMouvement']);

        if ($request->has('article_id')) {
            $query->where('article_id', $request->article_id);
        }

       if ($request->type === 'entree') {
            $query->entrees();
        } elseif ($request->type === 'sortie') {
            $query->sorties();
        }

        return response()->json($query->latest('date_mouvement')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'article_id' => 'required|exists:articles,id',
            'type_mouvement_id' => 'required|exists:type_mouvements,id',
            'quantite' => 'required|integer|min:1',
            'date_mouvement' => 'required|date',
            'motif' => 'required|string|max:150',
            'observation' => 'nullable|string',
        ]);

        $article = Article::findOrFail($validated['article_id']);
        $typeMouvement = TypeMouvement::findOrFail($validated['type_mouvement_id']);

        // On identifie si c'est une sortie via le code (OUT), pas en dur sur l'id
        $estUneSortie = $typeMouvement->code === 'OUT';

        if ($estUneSortie && $validated['quantite'] > $article->stock_actuel) {
            return response()->json([
                'message' => 'Quantité insuffisante en stock.',
                'stock_disponible' => $article->stock_actuel,
            ], 422);
        }

        $mouvement = MouvementStock::create([
            ...$validated,
            'user_id' => auth()->id(),
        ]);

        return response()->json($mouvement->load(['article', 'typeMouvement']), 201);
    }

    public function show(MouvementStock $mouvementStock): JsonResponse
    {
        return response()->json($mouvementStock->load(['article', 'user', 'typeMouvement']));
    }
}