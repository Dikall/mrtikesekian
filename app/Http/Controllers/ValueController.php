<?php

namespace App\Http\Controllers;

use App\Models\Value;
use App\Models\Risk;
use App\Models\Miti;
use Illuminate\Http\Request;
use App\Http\Request\RisklevelService;

    class ValueController extends Controller
    {   
        public function create()
        {
            $risks = Risk::doesntHave('values')->get();
            return view('admin.value', compact('risks'));
        }

        public function store(Request $request)
        {
        $request->validate([
            'risks_id' => 'required|exists:risks,id', // Pastikan bahwa risks_id ada dan valid
            'likelihood' => 'required|integer|between:1,5',
            'impact' => 'required|integer|between:1,5',
        ]);

        $likelihood = $request->input('likelihood');
        $impact = $request->input('impact');
        $level = $this->determineRiskLevel($likelihood, $impact);
        $risksId = $request->input('risks_id'); // Ambil nilai risks_id dari request

        // Simpan data ke dalam tabel values
        Value::create([
            'risks_id' => $risksId, // Sertakan risks_id
            'likelihood' => $likelihood,
            'impact' => $impact,
            'level' => $level,
        ]);

        return redirect()->route('admin.value')->with('success', 'Data berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {

    }

    public function determineRiskLevel($likelihood, $impact)
    {
        if ($likelihood >= 4 && $impact >= 4) {
            return 'High';
        } elseif (($likelihood >= 3 && $impact >= 3) || ($likelihood >= 4 && $impact >= 2)) {
            return 'Medium';
        } else {
            return 'Low';
        }
    }
    

}
