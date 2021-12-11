<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

use Carbon\carbon;

use App\Barang;

class BarangController extends Controller
{    
    public function add(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'stok'  => 'required',
            'detail' => 'required'
        ]);

        try {
            $addProcessDB = new Barang;
            $addProcessDB->name = $request->name;
            $addProcessDB->stok = $request->stok;
            $addProcessDB->detail = $request->detail;

            $addProcessDB->save();
            
            //ADD LOG
            $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/FirebaseKey.json');
            $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://minigun-log-9ac8e-default-rtdb.asia-southeast1.firebasedatabase.app/')
            ->create();

            $database = $firebase->getDatabase();

            $reference = $database->getReference('log-barang');
            $value = $reference->getValue();

            if($value != null && !empty(end($value)['newvalue']))
            {                    
                $oldData = end($value)['newvalue'];          
            }
            else{                
                $oldData = array();
            }

            $dataUpdate = Barang::all()->toArray(); 

            $newPost = $database
            ->getReference('log-barang')
            ->push([
                'methodname' => 'Add',
                'message' => 'Menambahkan barang '. $request->name . ' dengan ID '. $addProcessDB->id,
                'newvalue' => $dataUpdate,
                'oldvalue' => $oldData,
                'timespan' => Carbon::now()->format('Y-m-d H:i:s')
            ]);                                      

            return redirect()->back()->with('Success', 'Data barang berhasil ditambahkan!');
        } catch (\Illuminate\Database\QueryException $exception) {
            return redirect()->back()->with('Error', 'Ops! Data barang gagal ditambahkan.');
        }
    }

    public function edit(Request $request)
    {                      
        $this->validate($request, [
            'name' => 'required',
            'stok'  => 'required',
            'detail' => 'required'
        ]);

        try {
            $barangnya = Barang::where('id', $request->id)->first();
            $barangnya->name = $request->name;
            $barangnya->stok = $request->stok;
            $barangnya->detail = $request->detail;

            $barangnya->save();

            //EDIT LOG
            $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/FirebaseKey.json');
            $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://minigun-log-9ac8e-default-rtdb.asia-southeast1.firebasedatabase.app/')
            ->create();

            $database = $firebase->getDatabase();

            $reference = $database->getReference('log-barang');
            $value = $reference->getValue();

            $oldData = end($value)['newvalue'];

            $dataUpdate = Barang::all()->toArray();

            $newPost = $database
            ->getReference('log-barang')
            ->push([
                'methodname' => 'Edit',
                'message' => 'Edit Barang ID '. $request->id,
                'newvalue' => $dataUpdate,
                'oldvalue' => $oldData,
                'timespan' => Carbon::now()->format('Y-m-d H:i:s')
            ]); 

            return redirect()->back()->with('Success', 'Data barang Form berhasil dirubah!');
        } catch (\Illuminate\Database\QueryException $exception) {
            return redirect()->back()->with('Error', 'Ops! Terjadi kesalahan, harap periksa inputan data.');
        }
    }

    public function delete($id)
    {
        if(auth()->user()->level_user!=0)
        {
            return redirect()->back();
        }
        
        try {
            Barang::where('id', $id)->delete();

            //DELETE LOG
            $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/FirebaseKey.json');
            $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://minigun-log-9ac8e-default-rtdb.asia-southeast1.firebasedatabase.app/')
            ->create();

            $database = $firebase->getDatabase();

            $reference = $database->getReference('log-barang');
            $value = $reference->getValue();

            $oldData = end($value)['newvalue'];

            $dataUpdate = Barang::all()->toArray();

            $newPost = $database
            ->getReference('log-barang')
            ->push([
                'methodname' => 'Delete',
                'message' => 'Delete Barang ID ' . $id,
                'newvalue' => $dataUpdate,
                'oldvalue' => $oldData,
                'timespan' => Carbon::now()->format('Y-m-d H:i:s')
            ]); 
            return redirect()->back()->with('Success', 'Data barang berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $exception) {
            return redirect()->back()->with('Error', 'Data barang tidak berhasil dihapus!');
        }
    }
}
