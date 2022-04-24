<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Keuangan;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\HttpFoundation\File\File;
use Illuminate\Support\Facades\Storage;
class KeuanganController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Keuangan::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
       
        $uang = Keuangan::make($request->all(),[
            'keterangan' => ['required','string','max:255'],
            'pemasukan' => 'required',
            'pengeluaran' => ['required'],
            'jumlah' => ['required'],
        ]);

        $params = [
            'keterangan' => $request->keterangan,
            'pemasukan' => $request->pemasukan,
            'pengeluaran' => $request->pengeluaran,
            'jumlah' => $request->jumlah,
        ];

        if($keuangan= Keuangan::create($params)){

            $response = [
                 'tambah' => $keuangan,
            ];
 
            return response()->json(['status'=>'true', 'message'=> 'Berhasil', 'data'=>$response], 401);
 
        }else{
            return response()->json(['status'=>'false', 'message'=> 'Gagal', 'data'=> []], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Keuangan::create([
            "keterangan","pemasukan",'pengeluaran',"jumlah"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Keuangan::findOrFail($id);
        if (is_null($data)) {
            return response()->json('Data tidak ditemukan', 404);
        }
        return response()->json([$data]);
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'keterangan' => ['required','string','max:255'],
            'pemasukan' => 'required',
            'pengeluaran' => ['required'],
            'jumlah' => ['required'],
        ]);

        if($validator->fails()){
            return response()->json(['status'=>'false', 'message'=> 'Gagal'], 401);
        }

        $keuangan = Keuangan::findOrFail($id);
        $keuangan->update([
            'keterangan' => $request->keterangan,
            'pemasukan' => $request->pemasukan,
            'pengeluaran' => $request->pengeluaran,
            'jumlah' => $request->jumlah,
        ]);
        return response()->json(['status'=>true,'data'=>$keuangan, 'message' =>'Data terupdate '], 200);
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}