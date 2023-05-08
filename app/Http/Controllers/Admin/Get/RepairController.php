<?php

namespace App\Http\Controllers\Admin\Get;

use App\Http\Controllers\Controller;
use App\Models\Repair_applicant;
use Illuminate\Http\Request;

class RepairController extends Controller
{
    public function list(Request $request)
    {
        $repairs = Repair_applicant::orderByDesc("id")->get();

        $countRepairs = Repair_applicant::count();

        return view("admin.repairs.list", [
            'repairs' => $repairs,
            'countRepairs' => $countRepairs,
        ]);
    }
}
