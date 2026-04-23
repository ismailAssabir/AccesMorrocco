<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\User;
use App\Models\Departement;
use Illuminate\Support\Facades\Hash;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // كنستعملو with باش نجيبو البيانات ديال الجداول المرتبطة فدقة وحدة
        $leads = Lead::with(['user', 'client', 'departements'])->get();
        return view('leads.index', compact('leads'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'firstName'     => 'required|string|max:25',
            'lastName'      => 'required|string|max:25',
            'email'         => 'nullable|email|unique:leads,email',
            'password'      => 'nullable|min:6',
            'adresse'       => 'nullable|string',
            'CNE'           => 'nullable|string',
            'phoneNumber'   => 'nullable|string',
            'nationalite'   => 'nullable|string',
            'source'        => 'nullable|string',
            'note'          => 'nullable|string',
            'type'          => 'required|string|max:20',
            'idUser'        => 'nullable|exists:users,idUser',
            'idClient'      => 'nullable|exists:clients,idClient',
            'idDepartement' => 'nullable|exists:departements,idDepartement',
        ]);

        // تعمير تاريخ الإنشاء أوتوماتيكياً
        $validatedData['dateCreation'] = now()->toDateString();

        // تشفير كلمة السر إذا وُجدت
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        }

        Lead::create($validatedData);

        return redirect()->back()->with('msg', 'Lead ajouté avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $lead = Lead::with(['user', 'client', 'departements'])->findOrFail($id);
        return view('leads.show', compact('lead'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);

        $validatedData = $request->validate([
            'firstName'     => 'required|string|max:25',
            'lastName'      => 'required|string|max:25',
            'email'         => 'nullable|email|unique:leads,email,' . $id . ',idLead',
            'password'      => 'nullable|min:6',
            'adresse'       => 'nullable|string',
            'CNE'           => 'nullable|string',
            'phoneNumber'   => 'nullable|string',
            'nationalite'   => 'nullable|string',
            'source'        => 'nullable|string',
            'note'          => 'nullable|string',
            'type'          => 'required|string|max:20',
            'idUser'        => 'nullable|exists:users,idUser',
            'idClient'      => 'nullable|exists:clients,idClient',
            'idDepartement' => 'nullable|exists:departements,idDepartement',
        ]);

        // تحديث كلمة السر فقط إذا تم إدخالها، وإلا كنحيدوها من الـ Array باش ما تمسحش القديمة
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        } else {
            unset($validatedData['password']);
        }

        $lead->update($validatedData);

        return redirect()->back()->with('msg', 'Lead mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lead = Lead::findOrFail($id);
        $lead->delete();

        return redirect()->back()->with('msg', 'Lead supprimé avec succès !');
    }
}