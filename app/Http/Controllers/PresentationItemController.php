<?php

namespace App\Http\Controllers;

use App\Models\PresentationItem;
use Illuminate\Http\Request;

class PresentationItemController extends Controller
{
    /**
     * Display a listing of the items with Search, Filter, and Pagination.
     */
    public function index(Request $request)
    {
        $query = PresentationItem::with(['category', 'presentation']);

        // --- SEARCH Logic ---
        // Searches through unit price or related presentation/category names
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('prixUnitaire', 'LIKE', "%{$search}%")
                  ->orWhereHas('presentation', function($pq) use ($search) {
                      $pq->where('idPresentation', 'LIKE', "%{$search}%"); 
                  })
                  ->orWhereHas('category', function($cq) use ($search) {
                      $cq->where('idCategory', 'LIKE', "%{$search}%");
                  });
            });
        }

        // --- FILTER Logic ---
        if ($request->filled('idCategory')) {
            $query->where('idCategory', $request->idCategory);
        }

        if ($request->filled('idPresentation')) {
            $query->where('idPresentation', $request->idPresentation);
        }

        // Pagination (10 per page)
        $items = $query->latest('idItems')->paginate(10);

        return response()->json($items);
    }

    /**
     * Store a newly created item.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'idPresentation' => 'required|exists:presentations,idPresentation',
            'idCategory'     => 'nullable|exists:categories,idCategory',
            'prixUnitaire'   => 'required|numeric',
            'quantity'       => 'required|integer|min:1',
        ]);

        // Auto-calculate total
        $validated['totale'] = $validated['prixUnitaire'] * $validated['quantity'];

        $item = PresentationItem::create($validated);

        return response()->json(['message' => 'Item created successfully', 'data' => $item], 201);
    }

    /**
     * Display the specified item.
     */
    public function show($id)
    {
        $item = PresentationItem::with(['category', 'presentation'])->findOrFail($id);
        return response()->json($item);
    }

    /**
     * Update the specified item.
     */
    public function update(Request $request, $id)
    {
        $item = PresentationItem::findOrFail($id);

        $validated = $request->validate([
            'idPresentation' => 'sometimes|required|exists:presentations,idPresentation',
            'idCategory'     => 'nullable|exists:categories,idCategory',
            'prixUnitaire'   => 'sometimes|required|numeric',
            'quantity'       => 'sometimes|required|integer|min:1',
        ]);

        // Recalculate total if price or quantity changed
        $price = $request->input('prixUnitaire', $item->prixUnitaire);
        $qty = $request->input('quantity', $item->quantity);
        $validated['totale'] = $price * $qty;

        $item->update($validated);

        return response()->json(['message' => 'Item updated successfully', 'data' => $item]);
    }

    /**
     * Remove the specified item.
     */
    public function destroy($id)
    {
        $item = PresentationItem::findOrFail($id);
        $item->delete();

        return response()->json(['message' => 'Item deleted successfully']);
    }
}