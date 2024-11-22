<?php

namespace App\Http\Controllers;

use App\Models\Value;
use App\Models\Risk;
use App\Models\Miti;
use Illuminate\Http\Request;

class RiskController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');
    
        // Ambil risiko dengan pencarian untuk tabel "List of Risk Factors"
        $risksQuery = Risk::with('values');
        if ($query) {
            $risksQuery->where('kemungkinan', 'LIKE', '%' . $query . '%');
        }
        $risks = $risksQuery->get();
    
        // Ambil semua risiko dan mitigasi untuk tabel "Risk Matrix"
        $matrixData = [];
        $allRisks = Risk::with('values')->get();
    
        foreach ($allRisks as $risk) {
            // Ambil nilai likelihood, impact, level, dan dampak dari tabel `values`
            $likelihood = $risk->values->first()->likelihood ?? 'N/A';
            $impact = $risk->values->first()->impact ?? 'N/A';
            $level = $risk->values->first()->level ?? 'N/A';
            $dampak = $risk->dampak ?? 'N/A';
    
            // Ambil data mitigasi untuk setiap risiko jika ada
            $mitigation = Miti::where('risk_id', $risk->id)->first();
            $mitigasi = $mitigation ? $mitigation->mitigasi : 'N/A';
    
            $matrixData[] = [
                'id' => $risk->id,
                'kode' => $risk->kode,
                'faktor' => $risk->faktor,
                'kemungkinan' => $risk->kemungkinan,
                'dampak' => $dampak,
                'likelihood' => $likelihood,
                'impact' => $impact,
                'risk_level' => $level,
                'mitigasi' => $mitigasi,
            ];
        }
    
        // Ubah matrixData menjadi koleksi Laravel
        $matrixCollection = collect($matrixData);
    
        // Hitung jumlah risiko berdasarkan tingkatannya
        $highRiskCount = $matrixCollection->where('risk_level', 'High')->count();
        $mediumRiskCount = $matrixCollection->where('risk_level', 'Medium')->count();
        $lowRiskCount = $matrixCollection->where('risk_level', 'Low')->count();
    
        // Kirim data ke view
        return view('dashboard', compact('risks', 'matrixData', 'highRiskCount', 'mediumRiskCount', 'lowRiskCount'));
    }
    

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kode' => 'required|string|max:4',
            'faktor' => 'required',
            'kemungkinan' => 'required|string|max:255',
            'dampak' => 'required|string|max:255',
        ]);
    
        // Simpan faktor risiko baru
        Risk::create($request->all());
    
        // Redirect kembali ke index
        return redirect()->route('admin.create')->with('success', 'Risk Factor created successfully.');
    }

    public function edit($id)
    {
        $factor = Risk::findOrFail($id);
        return view('admin.edit', compact('factor'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'faktor' => 'required',
            'kemungkinan' => 'required|string|max:255',
            'dampak' => 'required|string|max:255',
            'likelihood' => 'required|integer|between:1,5',
            'impact' => 'required|integer|between:1,5',
        ]);

        // Temukan dan update faktor risiko
        $factor = Risk::findOrFail($id);
        $factor->update([
            'faktor' => $request->input('faktor'),
            'kemungkinan' => $request->input('kemungkinan'),
            'dampak' => $request->input('dampak'),
        ]);

        // Temukan data values terkait dan update
        if ($factor->values->isNotEmpty()) {
            $value = $factor->values->first();
            $value->update([
                'likelihood' => $request->input('likelihood'),
                'impact' => $request->input('impact'),
                'level' => $this->determineRiskLevel($request->input('likelihood'), $request->input('impact')),
            ]);
        }

        return redirect()->route('risk.index')->with('success', 'Risk Factor and Values updated successfully.');
    }


    public function destroy($id)
    {
        $factor = Risk::findOrFail($id);
        $factor->delete();
        return redirect()->route('risk.index');
    }

    // Fungsi untuk menentukan tingkat risiko
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
