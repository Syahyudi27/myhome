<?php

namespace App\Filament\Widgets;

use App\Models\House;
use App\Models\MortgageRequest;
use App\Models\CreditTransaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1; // Urutan paling atas

    protected function getStats(): array
    {
        return [
            Stat::make('Total Properti', House::count())
                ->description('Jumlah rumah terdaftar')
                ->descriptionIcon('heroicon-m-home')
                ->color('primary'),

            Stat::make('KPR Pending', MortgageRequest::where('status', 'pending')->count())
                ->description('Membutuhkan review admin')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Total Penggunaan Token', CreditTransaction::where('type', 'deduction')->sum('amount'))
                ->description('Token dikonsumsi agen')
                ->descriptionIcon('heroicon-m-bolt')
                ->color('success'),
        ];
    }
}