<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Departement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Mail\EmployeeCreatedMail;
use App\Mail\EmployeeUpdatedMail;

class UserController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('user.view');

        $query = User::with('departement');

        // Global Search
        $query->when($request->search, function ($q, $search) {
            $q->where(function ($sub) use ($search) {
                $sub->where('firstName', 'like', "%{$search}%")
                    ->orWhere('lastName', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('post', 'like', "%{$search}%")
                    ->orWhere('cin', 'like', "%{$search}%");
            });
        });

        // Advanced Filters
        $query->when($request->poste, fn($q, $v) => $q->where('post', $v))
              ->when($request->type, fn($q, $v) => $q->where('type', $v))
              ->when($request->typeContrat, fn($q, $v) => $q->where('typeContrat', $v))
              ->when($request->departement, fn($q, $v) => $q->where('idDepartement', $v))
              ->when($request->status, fn($q, $v) => $q->where('status', $v));

        $users = $query->latest()->paginate(10)->withQueryString();

        $stats = [
            'total' => User::count(),
            'conge' => User::where('status', 'conge')->count(),
            'freelance' => User::where('typeContrat', 'freelance')->count(),
        ];

        if ($request->ajax()) {
            return view('partials._user_table', compact('users'))->render();
        }

        $departements = Departement::all();
        $posts = User::whereNotNull('post')->distinct()->pluck('post');

        return view('AllUser', compact('users', 'departements', 'posts', 'stats'));
    }

public function store(Request $request) {
        Gate::authorize('user.create');

    $newUser = $request->validate([
        'firstName'     => 'required|string|max:50',
        'lastName'      => 'required|string|max:50',
        'email'         => 'required|email|unique:users,email',
        'password'      => 'required|min:8',
        'cin'           => 'required|string|unique:users,cin',
        'birthday'      => "required|date",
        'address'       => 'nullable|string|max:100',
        'phoneNumber'   => 'required|digits:10',
        'typeContrat'   => 'nullable|in:CD,CI,freelance',
        'salaire'       => 'required|numeric',
        'post'          => 'nullable|string|max:40',
        'dateEmb'       => 'nullable|date',
        'idDepartement' => 'nullable|exists:departements,idDepartement',
        'status'        => 'in:active,desactive,conge',
        'type'          => 'in:employee,admin,manager',
        'fichier'       => 'nullable|string',
        'rip'           => 'nullable|string',
    ]);
    
    $plainPassword = $request->password;
    $newUser['password'] = Hash::make($plainPassword);

    $createdUser = null;
    DB::transaction(function () use ($newUser, &$createdUser) {
        $createdUser = User::create($newUser);

        $createdUser->assignRole($createdUser->type);

        if ($createdUser->type === 'manager' && $createdUser->idDepartement) {
            $departement = Departement::find($createdUser->idDepartement);
            
            if ($departement) {
                if ($departement->idUser && $departement->idUser !== $createdUser->idUser) {
                    User::where('idUser', $departement->idUser)->update(['type' => 'employee']);
                }
                
              
                $departement->update(['idUser' => $createdUser->idUser]);
            }
        }
    });

    // Send welcome email with credentials
    try {
        $createdUser->load('departement');
        Mail::to($createdUser->email)->send(new EmployeeCreatedMail($createdUser, $plainPassword));
    } catch (\Exception $e) {
        \Log::error('Failed to send employee welcome email: ' . $e->getMessage());
    }

    return redirect()->back()->with('msg' , "L'utilisateur a été ajouté avec succès!");
}

public function show($id){
    Gate::authorize('user.view');
    if (request()->ajax()) {
        $user = User::with('departement')->findOrFail($id);
        return response()->json($user);
    }
    $users = User::with('departement')->get();
    $selectedUser = User::with('departement')->findOrFail($id);
    return view('AllUser' , compact('users', 'selectedUser'))->with('openModal', 'view');
}

    public function edit($id){
             Gate::authorize('user.edit');

        if (request()->ajax()) {
            $user = User::findOrFail($id);
            return response()->json($user);
        }
        $user = User::findOrFail($id);
        $departements = Departement::all();
        return view('users.edit', compact('user', 'departements'));
    }

    public function update(Request $request ,$id){
             Gate::authorize('user.edit');

        $user = User::findOrFail($id);
        $userUpdate = $request->validate([
            'firstName'    => 'required|string|max:50',
            'lastName'      => 'required|string|max:50',
            'email'         => 'required|email|unique:users,email,'.$id.',idUser',
            'password'      => 'nullable|min:8',
            'cin'           => 'required|string|unique:users,cin,'.$id.',idUser',
            'birthday'      => "required|date",
            'address'       => 'nullable|string|max:100',
            'phoneNumber'   => 'required|digits:10',
            'typeContrat'   => 'nullable|in:CD,CI,freelance',
            'salaire'       => 'required|numeric',
            'post'          => 'nullable|string|max:40',
            'dateEmb'       => 'nullable|date',
            'idDepartement' => 'nullable|exists:departements,idDepartement',
            'status'        => 'in:active,desactive,conge',
            'type'          => 'in:employee,admin,manager',
            'fichier'       => 'nullable|string',
            'rip'           => 'nullable|string',
        ]);
        
        $passwordChanged = false;
        if ($request->filled('password')) {
            $userUpdate['password'] = Hash::make($request->password);
            $passwordChanged = true;
        } else {
            unset($userUpdate['password']);
        }

        // Track changes for the notification email
        $trackedFields = ['firstName', 'lastName', 'email', 'cin', 'birthday', 'address', 'phoneNumber', 'typeContrat', 'salaire', 'post', 'dateEmb', 'idDepartement', 'status', 'type', 'rip'];
        $changes = [];
        foreach ($trackedFields as $field) {
            if (array_key_exists($field, $userUpdate) && (string)$user->$field !== (string)$userUpdate[$field]) {
                $oldVal = $user->$field;
                $newVal = $userUpdate[$field];

                if ($field === 'idDepartement') {
                    $oldDept = \App\Models\Departement::find($oldVal);
                    $newDept = \App\Models\Departement::find($newVal);
                    $oldVal = $oldDept ? $oldDept->title : '—';
                    $newVal = $newDept ? $newDept->title : '—';
                }

                $changes[$field] = [
                    'old' => $oldVal,
                    'new' => $newVal,
                ];
            }
        }
        if ($passwordChanged) {
            $changes['password'] = ['old' => null, 'new' => null];
        }

        DB::transaction(function () use ($user, $userUpdate) {
            $user->update($userUpdate);

            if ($user->type === 'manager' && $user->idDepartement) {
                $departement = Departement::find($user->idDepartement);
                
                if ($departement) {
                    Departement::where('idUser', $user->idUser)
                               ->where('idDepartement', '!=', $departement->idDepartement)
                               ->update(['idUser' => null]);

                    if ($departement->idUser && $departement->idUser !== $user->idUser) {
                        User::where('idUser', $departement->idUser)->update(['type' => 'employee']);
                    }
                    
                    $departement->update(['idUser' => $user->idUser]);
                }
            } else {
                Departement::where('idUser', $user->idUser)->update(['idUser' => null]);
            }
        });

        // Send update notification email if there are changes
        if (!empty($changes)) {
            try {
                $user->refresh();
                Mail::to($user->email)->send(new EmployeeUpdatedMail($user, $changes));
            } catch (\Exception $e) {
                \Log::error('Failed to send employee update email: ' . $e->getMessage());
            }
        }

        return redirect()->route('users.index')->with('msg' , 'Les informations utilisateur ont été mises à jour avec succès');
    }

    public function destroy($id)
    {   Gate::authorize('user.delete');
        $user = User::findOrFail($id);
        
        DB::transaction(function () use ($user) {
            Departement::where('idUser', $user->idUser)->update(['idUser' => null]);
            $user->delete();
        });

        return redirect()->route('users.index')->with('msg', 'L\'utilisateur a été supprimé avec succès.');
    }
}