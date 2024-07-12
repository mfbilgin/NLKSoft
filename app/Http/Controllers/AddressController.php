<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AddressController extends Controller
{
    public function create()
    {
        return view('address.create');
    }

    public function store(Request $request)
    {
        $this->validator($request);
        $address = new Address();
        $address->user_id = auth()->id();
        $address->address_name = $request->address_name;
        $address->contact_name = $request->contact_name;
        $address->address = $request->address;
        $address->city = $request->city;
        $address->zip_code = $request->zip_code;
        $address->phone = $request->phone;
        $address->identity_number = $request->identity_number;
        $address->save();
        return redirect()->back()->with('status', 'success')->with('message', 'Adresin başarıyla eklendi.');
    }

    public function show_select_address_page()
    {
        $user_id = auth()->id();
        $addresses = Address::where('user_id', $user_id)->get();
        return view('address.select', compact('addresses'));
    }

    public function edit($id)
    {
        $address = Address::find($id);
        return view('address.edit', compact('address'));
    }

    public function update(Request $request, $id)
    {
        $this->validator($request);
        $address = Address::find($id);
        $address->update($request->all());
        return redirect()->back()->with('status', 'success')->with('message', 'Adresin başarıyla güncellendi.');
    }

    public function destroy(Request $request, $id)
    {
        Log::info($request);
        $address = Address::find($id);
        $address->delete();
        if ($request->has('from_select')) {
            return redirect()->route('address.select')->with('status', 'success')->with('message', 'Adresin başarıyla silindi.');
        }
        return redirect()->back()->with('status', 'success')->with('message', 'Adresin başarıyla silindi.');
    }

    private function validator($data)
    {
        return $data->validate([
            'address_name' => 'required | max:255 | min:2',
            'contact_name' => 'required',
            'address' => 'required | max:255 | min:10',
            'city' => 'required',
            'zip_code' => 'required | numeric',
            'phone' => 'required | numeric',
            'identity_number' => 'required | numeric | min:11',
        ]);
    }
}
