<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Interest;
use App\Models\MortgageRequest;
use App\Services\HouseService;
use App\Services\MortgageService;
use Illuminate\Http\Request;

class FrontController extends Controller
{

    protected $houseService;
    protected $mortgageService;

    public function __construct(HouseService $houseService, mortgageService $mortgageService)
    {
        $this->houseService = $houseService;
        $this->mortgageService = $mortgageService;
    }

    public function index()
    {
        $data = $this->houseService->getCategoriesAndCities();
        return view('front.index', $data);
    }

     public function search(Request $request)
    {
        $data = $this->houseService->searchHouses($request->all());
        return view('front.search', $data);
    }

    public function details(House $house)
    {
        $houseDetails = $this->houseService->getHouseDetails($house);
        return view('front.details', compact('houseDetails'));
    }

    public function interest(Interest $interest)
    {
        return view('customer.mortgages.request_mortagage', compact('interest'));
    }

    public function request_interest(Request $request)
    {
        $this->mortgageService->handleInterestRequest($request);
        return redirect()->route('front.request_success');
    }

    public function request_success()
    {
        
    }
    
}


