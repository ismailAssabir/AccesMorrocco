<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    public function index(){
        Gate::authorize('category.view');
        $categories = Category::All();
        return view('AllCategories' , compact("categories"));
    }

public function store(Request $request) {
    
    Gate::authorize('category.create');
    $newCategory = $request->validate([
        'title'     => 'required|string|max:55',
        'desc'    => 'nullable|string|max:255',
       
    ]);
    $category = Category::create($newCategory);
    return redirect()->back()->with('msg' , "La catégorie a été ajoutée avec succès");

}
// public function show($id){
//     $category = Category::findOrFail($id);
//     return view('showCategory' , compact('category'));
// }

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
        'desc'    => 'nullable|string|max:255',
    ]);

   $category->update($categoryUpdate);
    return redirect()->back()->with('msg' , 'La catégorie été mises à jour avec succès');
}
}
