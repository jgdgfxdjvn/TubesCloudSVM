<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Unit;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use PDF;
use App\Models\Employee;


class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $titlePage = "Data Resep";
        $items = Item::all();
       // dd($items);
        return view('apps.item.index', compact('titlePage', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titlePage = "Tambah Resep";
        $units = Unit::all();
        return view('apps.item.add', compact('units', 'titlePage'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'required' => ':attribute belum diisi',
            'unique' => 'Kode resep sudah digunakan',
            'numeric' => 'Inputan harus angka'
        ];

        $validate = Validator::make($request->all(), [
            'code_item' => 'required|unique:items,code',
            'name_item' => 'required',
            'desc_item' => 'required',
            'price_item' => 'required|numeric',
            'image_item' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            //'stock_item' => 'required|numeric',
            //'unit_item' => 'required'
        ], $messages);

        //Mengunggah gambar
        // if ($request->hasFile('image_item')) {
        //     $image = $request->file('image_item');
        //     $imagePath = $image->store('images', 'public');
        // }
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        $imagePath = time() . '.' . $request->image_item->extension();
        $request->image_item->storeAs('public/images', $imagePath);

        // if ($request->hasFile('image_item')) {
        //     $image = $request->file('image_item');
        //     $imageName = time() . '.' . $image->getClientOriginalExtension();
        //     $path = $image->storeAs('public/images', $imageName);
        //     $item->image_item = $imageName;
        // }
        $item = new Item;
        $item->code = $request->code_item;
        $item->unit_id = $request->unit_item;
        $item->name = $request->name_item;
        $item->price = $request->price_item;
        $item->desc = $request->desc_item;
        $item->image_item = $imagePath;
        //$item->unit_id = $request->unit_id;
       // $item->stock = $request->stock_item;

        $item->save();

        return redirect()->route('item.index')->with('notif', 'Berhasil Menambah Resep');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ]);

        $imagePath = $request->file('image')->store('images'); // Simpan gambar

        return response()->json(['image_item' => $imagePath]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $titlePage = "Edit Data Resep";
        $item = Item::find($id);
        $units = Unit::all();
        return view('apps.item.edit', compact('item', 'units', 'titlePage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $messages = [
            'required' => ':attribute belum diisi',
            'unique' => 'Kode Resep sudah digunakan',
            'numeric' => 'Inputtan harus angka'
        ];

        $validate = Validator::make($request->all(), [
            'code_item' => 'required|unique:items,code',
            'name_item' => 'required',
            'desc_item' => 'required',
            'price_item' => 'required|numeric',
            // 'image_item' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], $messages);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        // $imagePath = time() . '.' . $request->image_item->extension();
        // $request->image_item->storeAs('public/images', $imagePath);

        $item = Item::find($id);

        $item->code = $request->code_item;
        $item->unit_id = $request->unit_item;
        $item->name = $request->name_item;
        $item->price = $request->price_item;
        $item->desc = $request->desc_item;
        // $item->image_item = $imagePath;
        //$item->stock = $request->stock_item;

        $item->save();

        return redirect()->route('item.index')->with('notif', 'Berhasil Mengupdate Data Resep');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Item::find($id)->delete();
        return redirect()->route('item.index')->with('notif', 'Berhasil Menghapus Data Resep');
    }

    public function exportPdf()
{
    $items = Item::all();

    $pdf = PDF::loadView('apps.item.export_pdf', compact('items'));

    return $pdf->download('items.pdf');
}

}
