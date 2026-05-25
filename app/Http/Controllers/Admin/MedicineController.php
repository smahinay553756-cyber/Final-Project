<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        $query = Medicine::query();
        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('generic_name', 'like', "%{$request->search}%")
                  ->orWhere('brand', 'like', "%{$request->search}%");
        }
        if ($request->category) {
            $query->where('category', $request->category);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        return view('admin.medicines.index', [
            'medicines'  => $query->latest()->get(),
            'categories' => Medicine::distinct()->pluck('category'),
        ]);
    }

    public function create()
    {
        return view('admin.medicines.create', [
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'                  => 'required|string|max:255',
            'generic_name'          => 'nullable|string|max:255',
            'brand'                 => 'nullable|string|max:255',
            'category'              => 'required|string|max:100',
            'dosage_form'           => 'required|string|max:100',
            'dosage_strength'       => 'nullable|numeric',
            'dosage_unit'           => 'nullable|string|max:20',
            'weight_grams'          => 'nullable|numeric',
            'manufacturer'          => 'nullable|string|max:255',
            'batch_number'          => 'nullable|string|max:100',
            'manufacture_date'      => 'nullable|date',
            'expiry_date'           => 'nullable|date',
            'stock_quantity'        => 'required|integer|min:0',
            'reorder_level'         => 'required|integer|min:0',
            'unit_price'            => 'required|numeric|min:0',
            'selling_price'         => 'required|numeric|min:0',
            'storage_condition'     => 'nullable|string|max:255',
            'requires_prescription' => 'boolean',
            'description'           => 'nullable|string',
            'side_effects'          => 'nullable|string',
            'contraindications'     => 'nullable|string',
            'status'                => 'required|in:active,inactive,discontinued',
        ]);
        $data['requires_prescription'] = $request->boolean('requires_prescription');
        Medicine::create($data);
        return redirect()->route('admin.medicines.index')->with('success', 'Medicine added successfully.');
    }

    public function show(Medicine $medicine)
    {
        return view('admin.medicines.show', compact('medicine'));
    }

    public function edit(Medicine $medicine)
    {
        return view('admin.medicines.edit', [
            'medicine'  => $medicine,
        ]);
    }

    public function update(Request $request, Medicine $medicine)
    {
        $data = $request->validate([
            'name'                  => 'required|string|max:255',
            'generic_name'          => 'nullable|string|max:255',
            'brand'                 => 'nullable|string|max:255',
            'category'              => 'required|string|max:100',
            'dosage_form'           => 'required|string|max:100',
            'dosage_strength'       => 'nullable|numeric',
            'dosage_unit'           => 'nullable|string|max:20',
            'weight_grams'          => 'nullable|numeric',
            'manufacturer'          => 'nullable|string|max:255',
            'batch_number'          => 'nullable|string|max:100',
            'manufacture_date'      => 'nullable|date',
            'expiry_date'           => 'nullable|date',
            'stock_quantity'        => 'required|integer|min:0',
            'reorder_level'         => 'required|integer|min:0',
            'unit_price'            => 'required|numeric|min:0',
            'selling_price'         => 'required|numeric|min:0',
            'storage_condition'     => 'nullable|string|max:255',
            'requires_prescription' => 'boolean',
            'description'           => 'nullable|string',
            'side_effects'          => 'nullable|string',
            'contraindications'     => 'nullable|string',
            'status'                => 'required|in:active,inactive,discontinued',
        ]);
        $data['requires_prescription'] = $request->boolean('requires_prescription');
        $medicine->update($data);
        return redirect()->route('admin.medicines.index')->with('success', 'Medicine updated successfully.');
    }

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();
        return redirect()->route('admin.medicines.index')->with('success', 'Medicine deleted.');
    }
}
