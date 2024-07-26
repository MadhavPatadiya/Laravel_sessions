<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FormEntry;
use App\Models\ProductMaster;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function index()
    {
        $products = ProductMaster::all();

        return view('admin.form', compact('products'));
    }

    public function addToSession(Request $request)
    {
        $data = $request->all();
        $sessionData = session()->get('form_data', []);
        $sessionData[] = $data;
        // dd($sessionData);
        session(['form_data' => $sessionData]);

        return redirect()->back()->with('success', 'Data added to session successfully!');
    }
    public function dumpSessionData()
    {
        dump(session()->get('form_data', []));
    }

    public function removeFromSession($index)
    {
        $sessionData = session()->get('form_data', []);
        if (isset($sessionData[$index])) {
            unset($sessionData[$index]);
            $sessionData = array_values($sessionData);
        }
        session(['form_data' => $sessionData]);

        return redirect()->back()->with('success', 'Data removed from session successfully!');
    }

    public function submitSessionData()
    {
        $sessionData = session()->get('form_data', []);

        foreach ($sessionData as $data) {
            FormEntry::create([
                'customer' => $data['customer'],
                'product' => $data['product'],
                'rate' => $data['Rate'],
                'unit' => $data['Unit'],
                'qty' => $data['qty'],
                'discount' => $data['discount'],
                'netamount' => $data['net_amount'],
                'totalamount' => $data['total_amount'],
            ]);
        }
        session()->forget('form_data');

        return redirect()->back()->with('success', 'Data saved to database successfully!');
    }

}
