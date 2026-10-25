<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use App\Models\MortgageRequest;
use App\Services\HouseService;
use App\Services\MortgageService;
use App\Services\PaymentService;
use Illuminate\Container\RewindableGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //untuk menerima request dari pengguna

    protected $houseService;
    protected $mortgageService;
    protected $paymentService;

    //untuk memanggil setiap bisnin logic yang dibutuhkan
    public function __construct(HouseService $houseService, MortgageService $mortgageService, PaymentService $paymentService)
    {
        $this->houseService = $houseService;
        $this->mortgageService = $mortgageService;
        $this->paymentService = $paymentService;
    }

    public function index()
    {
        $userId = Auth::id();
        $morgages = $this->mortgageService->getUserMortgage($userId);

        return view('customer.morgages.index', compact('morgages'));
    }

    public function details(MortgageRequest $mortgageRequest)
    {
        $details = $this->mortgageService->getMorgateDetails($mortgageRequest);

        return view('customer.mortgages.details', $details);

    }

    public function installment_details(Installment $installment)
    {
        $installmentDetails = $this->mortgageService->getInstallementDetails($installment);
        return view('customer.installments.index', compact('installmentDetails'));
    }

    public function installment_payment(MortgageRequest $mortgageRequest)
    {
        $paymentDetails = $this->mortgageService->getInstallmentPaymentDetails($mortgageRequest);
        return view('customer.installment.pay_installment', compact('paymentDetails'));
    }

    public function paymentStoreMidtrans(Request $request)
    {
        try {
            $mortgageRequest = $this->mortgageService->getMortgegeRequest($request->input('mortagage_request_id'));
            $snapToken = $this->paymentService->createPayment($mortgageRequest);

            return response()->json(['status'=>'success'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Payment Failed: '. $e->getMessage()
            ], 500);
        }
    }

    public function paymentMidtransNotification(Request $request)
    {
        try {
            $this->paymentService->processNotification();

            return response()->json(['status'=>'success'], 200);
        } catch (\Exception $e) {
             return response()->json([
                'error' => 'Failed to proses notification: '. $e->getMessage()
            ], 500);
        }
    }

}
