<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class AuditController extends Controller
{
    public function index()
    {
        if(!auth()->user()->hasRole('super-admin')) {
            abort(403, 'Unauthorized action.');
        }
        
        $audits = Audit::with('user')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('audits.index', compact('audits'));
    }
    
    public function show($id)
    {
        if(!auth()->user()->hasRole('super-admin')) {
            abort(403, 'Unauthorized action.');
        }
        
        $audit = Audit::with('user')->findOrFail($id);
        
        return view('audits.show', compact('audit'));
    }
}