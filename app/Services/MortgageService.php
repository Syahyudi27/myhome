<?php

namespace App\Services;

use App\Models\House;
use App\Models\Interest;
use App\Models\MortgageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MortgageService 
{
    public function handleInterestRequest(Request $request)
    {
        $validatedData = $request->validate([
            'dp_percentage' => 'required|integer|min:0|max:100',
            'interest_id' => 'required|integer|exists:interests,id',
            'documents' => 'required|file|mimes:pdf|max:2048',
        ]);

        $interest = Interest::findOrFail($validatedData['interest_id']);
        $house = $interest->house;

        $mortgageDetails = $this->calculateMortgageDetails($house, $interest, $validatedData['dp_percentage']);

        $documentPath = $this->uploadDocument($request);

        return $this->createMortgageRequest($mortgageDetails, $documentPath);
    }

    public function calculateMortgageDetails(House $house, Interest $interest, $dpPercentage): array
    {
        $housePrice = $house->price;
        $dpTotalAmount = $housePrice * ($dpPercentage / 100);
        $loanTotalAmount = $housePrice - $dpTotalAmount;
        $durationYears = $interest->duration;
        $totalPayments = $durationYears * 12; // Total number of monthly payments
        $monthlyInterestRate = $interest->interest / 100 / 12; // Monthly interest rate

        // Amortization formula for monthly payment
        $numerator = $loanTotalAmount * $monthlyInterestRate * pow(1 + $monthlyInterestRate, $totalPayments);
        $denominator = pow(1 + $monthlyInterestRate, $totalPayments) - 1;
        $monthlyAmount = $denominator > 0 ? $numerator / $denominator : 0;

        $loanInterestTotalAmount = $monthlyAmount * $totalPayments;

        return compact(
            'house',
            'interest',
            'housePrice',
            'dpTotalAmount',
            'dpPercentage',
            'loanTotalAmount',
            'monthlyAmount',
            'loanInterestTotalAmount'
        );
    }

    public function uploadDocument(Request $request): ?string
    {
        if ($request->hasFile('documents')){
            return $request->file('documents')->store('documents', 'public');
        }
        return null;
    }

    public function createMortgageRequest(array $details, string $documentPath): MortgageRequest
    {
        $mortgageRequest = MortgageRequest::create([
            'user_id' => Auth::id(),
            'house_id' => $details['house']->id,
            'interest_id' => $details['interest']->id,
            'interest' => $details['interest']->interest,
            'duration' => $details['interest']->duration,
            'bank_name' => $details['interest']->bank->name,
            'dp_percentage' => $details['dpPercentage'],
            'house_price' => $details['housePrice'],
            'dp_total_amount' => $details['dpTotalAmount'],
            'loan_total_amount' => $details['loanTotalAmount'],
            'loan_interest_total_amount' => $details['loanInterestTotalAmount'],
            'monthly_amount' => $details['monthlyAmount'],
            'status' => 'Waiting for Bank',
            'documents' => $documentPath,
        ]);

        session(['interest_id' => $details['interest']->id]);

        return $mortgageRequest;
    }

    public function getInterestFromSession()
    {
        $interestId = session('interest_id');
        return $interestId ? Interest::findOrFail($interestId) : null;
    }

    public function getUserMortgage($userId)
    {
        return MortgageRequest::with(['house', 'house.city', 'house.category'])
        ->where('user_id', $userId)
        ->get();
    }
}