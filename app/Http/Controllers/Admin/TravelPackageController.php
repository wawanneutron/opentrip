<?php

namespace App\Http\Controllers\Admin;

use App\Gallery;
use App\Http\Controllers\Controller;
use App\TravelPackage;
use App\Http\Requests\Admin\TravelPackageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class TravelPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = TravelPackage::latest()->get();

        return view('pages.admin.travel-package.index', [
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.travel-package.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TravelPackageRequest $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        $data['eat'] = $request->get('eat') == 'true' ? 1 : 0;
        $data['lodging_house'] = $request->get('lodging_house') == 'true' ? 1 : 0;

        $travelCreate = TravelPackage::create($data);

        if ($travelCreate) {
            return redirect()->route('admin.travel-package.index')
                ->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return redirect()->route('admin.travel-package.index')
                ->with(['error' => 'Data Gagal Disimpan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = TravelPackage::findOrFail($id);

        return view('pages.admin.travel-package.edit', [
            'item' => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TravelPackageRequest $request, $id)
    {
        $item = TravelPackage::findOrFail($id);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        $data['eat'] = $request->get('eat') == 'true' ? 1 : 0;
        $data['lodging_house'] = $request->get('lodging_house') == 'true' ? 1 : 0;

        $travelUpdate = $item->update($data);

        if ($travelUpdate) {
            return redirect()->route('admin.travel-package.index')
                ->with(['success' => 'Data Berhasil Diupdate']);
        } else {
            return redirect()->route('admin.travel-package.index')
                ->with(['error' => 'Data Gagal Diupdate']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = TravelPackage::findOrFail($id);
        $gallery = Gallery::whereTravelPackagesId($id);
        $item->delete();
        $gallery->delete();

        if ($item) {
            return response()->json([
                'status'    => 'success',
            ]);
        } else {
            return response()->json([
                'status'    => 'error',
            ]);
        }
    }
}
