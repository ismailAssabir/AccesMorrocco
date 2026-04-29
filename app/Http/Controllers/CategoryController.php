<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Barryvdh\DomPDF\Facade\Pdf;
class CategoryController extends Controller
{
    public function exportPdf()
    {
        Gate::authorize('category.view');
        
        $categories = Category::all();
        
        $pdf = Pdf::loadView('pdf.categories', compact('categories'));
        
        return $pdf->download('categories_' . date('Y-m-d_His') . '.pdf');
    }
    public function index(){
        Gate::authorize('category.view');
        $categories = Category::orderBy('idCategory', "desc")->get();
        return view('AllCategories' , compact("categories"));
    }

public function store(Request $request) {
    
    Gate::authorize('category.create');
    $newCategory = $request->validate([
        'nom'     => 'required|string|max:55',
        'desc'    => 'nullable|string',
       
    ]);
    $category = Category::create($newCategory);
    return redirect()->back()->with('msg' , "La catégorie a été ajoutée avec succès");

}
public function show($id){
    $category = Category::findOrFail($id);
    return view('showCategory' , compact('category'));
}

public function destroy($id)
{       Gate::authorize('category.delete');

    $category = Category::findOrFail($id);
    $category->delete();
    return redirect()->back()->with('msg', 'La catégorie a été supprimée');
}

public function edit($id){
        Gate::authorize('category.edit');

    $category = Category::findOrFail($id);
    return view('editCategory' , compact('category'));
}

public function update(Request $request ,$id){
    Gate::authorize('category.edit');
    $category = Category::findOrFail($id);
    $categoryUpdate = $request->validate([
        'nom'     => 'required|string|max:55',
        'desc'    => 'nullable|string',
    ]);

   $category->update($categoryUpdate);
    return redirect()->back()->with('msg' , 'La catégorie été mises à jour avec succès');
}
}
