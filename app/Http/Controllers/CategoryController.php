<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::All();
        return view('AllCategories' , compact("categories"));
    }

public function store(Request $request) {
    

    $newCategory = $request->validate([
        'nom'     => 'required|string|max:55',
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
{   $category = Category::findOrFail($id);
    $category->delete();
    return redirect()->back()->with('msg', 'La catégorie a été supprimée');
}

public function edit($id){
    $category = Category::findOrFail($id);
    return view('editCategory' , compact('category'));
}

public function update(Request $request ,$id){
    $category = Category::findOrFail($id);
    $categoryUpdate = $request->validate([
        'nom'     => 'required|string|max:55',
        'desc'    => 'nullable|string|max:255',
    ]);

   $category->update($categoryUpdate);
    return redirect()->back()->with('msg' , 'La catégorie été mises à jour avec succès');
}
}
