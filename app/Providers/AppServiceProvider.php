<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Risk;
use App\Models\Miti;

class AppServiceProvider extends ServiceProvider
{

    public function boot()
    {
        // Hitung data global
        $matrixData = [];
        $allRisks = Risk::with('values')->get();
    
        foreach ($allRisks as $risk) {
            $level = $risk->values->first()->level ?? 'N/A';
    
            $matrixData[] = [
                'risk_level' => $level,
            ];
        }
    
        $highRiskCount = collect($matrixData)->where('risk_level', 'High')->count();
        $mediumRiskCount = collect($matrixData)->where('risk_level', 'Medium')->count();
        $lowRiskCount = collect($matrixData)->where('risk_level', 'Low')->count();
    
        // Bagikan variabel ke semua view
        View::share('highRiskCount', $highRiskCount);
        View::share('mediumRiskCount', $mediumRiskCount);
        View::share('lowRiskCount', $lowRiskCount);
    }
}
