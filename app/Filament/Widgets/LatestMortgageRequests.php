<?php

namespace App\Filament\Widgets;

use App\Models\MortgageRequest;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestMortgageRequests extends BaseWidget
{
    protected static ?int $sort = 2; // Tampil di bawah Stats
    protected int | string | array $columnSpan = 'full'; // Lebar penuh

    public function table(Table $table): Table
    {
        return $table
            ->query(MortgageRequest::query()->latest()->limit(5))
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Pemohon'),
                Tables\Columns\TextColumn::make('house.name')->label('Properti'),
                Tables\Columns\TextColumn::make('bank_name')->label('Bank'),
                Tables\Columns\TextColumn::make('monthly_amount')->money('IDR')->label('Angsuran/Bln'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
            ]);
    }
}