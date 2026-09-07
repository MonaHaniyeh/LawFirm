<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseFile;

class AdminCaseController extends Controller
{
    /**
     * Display all cases.
     */
    public function index()
    {
        $cases = CaseFile::with([
            'client:id,name,email',
            'lawyer:id,name,email',
        ])
            ->latest()
            ->paginate(15);

        return view('admin.cases.index', compact('cases'));
    }

    /**
     * Display one case.
     */
    public function show(CaseFile $case)
    {
        $case->load([
            'client:id,name,email',
            'lawyer:id,name,email',
            'documents',
            'messages',
            'appointments',
            'invoices',
        ]);

        return view('admin.cases.show', compact('case'));
    }
}