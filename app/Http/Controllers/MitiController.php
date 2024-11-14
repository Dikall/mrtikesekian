<?php

namespace App\Http\Controllers;

use App\Models\Miti;
use App\Models\Risk;
use Illuminate\Http\Request;


class MitiController extends Controller
{

    public function create()
    {
        $risks = Risk::doesntHave('mitis')->get();
        return view('admin.mitigasi', compact('risks'));
    }    

    public function store(Request $request)
    {
        $request->validate([
            'risk_id' => 'required|exists:risks,id', // Ensure risk_id exists in risks table
            'mitigasi' => 'required|string|max:255',
        ]);

        Miti::create([
            'risk_id' => $request->input('risk_id'),
            'mitigasi' => $request->input('mitigasi'),
        ]);

        return redirect()->route('miti.create')->with('success', 'Mitigation data successfully added.');
    }
}
