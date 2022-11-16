<?php

namespace App\Http\Controllers\Payslip;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Payslip\PayslipRepositoryInterface;

class PayslipController extends Controller
{
    private $modelRepo;
    public function __construct(
        PayslipRepositoryInterface $modelRepo,
    ) {
        $this->modelRepo = $modelRepo;
    }

    public function show($id)
    {
        $result = $this->modelRepo->show($id);
        return view("blades.payslip.payslip", ["data" => $result]);
    }
}
