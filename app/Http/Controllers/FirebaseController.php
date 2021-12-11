<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class FirebaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $temp = array();

        // $newValue = array(
        //     "nama" => "paramex",
        //     "des" => "ini paramex"
        // );
        // array_push($temp, $newValue);

        // $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/FirebaseKey.json');
        // $firebase = (new Factory)
        //     ->withServiceAccount($serviceAccount)
        //     ->withDatabaseUri('https://minigun-log-9ac8e-default-rtdb.asia-southeast1.firebasedatabase.app/')
        //     ->create();

        // $database = $firebase->getDatabase();

        // $reference = $database->getReference('log-barang');
        // $value = $reference->getValue();

        // $newPost = $database
        //     ->getReference('log-barang')
        //     ->push([
        //         'methodname' => 'Update',
        //         'message' => 'Mengupdate barang ID 2',
        //         'newvalue' => $temp,
        //         'oldvalue' => $temp,
        //         'timespan' => '20-0210'
        //     ]);

        // //test
        // $reference = $database->getReference('blog/posts');
        // $value = $reference->getValue();

        // dd(end($value));

        // echo '<pre>';
        // print_r($newPost->getvalue());
        

        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/FirebaseKey.json');
        $firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->withDatabaseUri('https://minigun-log-9ac8e-default-rtdb.asia-southeast1.firebasedatabase.app/')
        ->create();

        $database = $firebase->getDatabase();

        $reference = $database->getReference('log-barang');
        $value = $reference->getValue();

        $temp = end($value)['newvalue'];
        $dataUpdate = end($value)['newvalue'];

        $newValue = array(
            "nama" => "neosep",
            "des" => "ini neosep"
        );
        array_push($dataUpdate, $newValue);

        $reference = $database->getReference('log-barang');
        $value = $reference->getValue();

        $newPost = $database
        ->getReference('log-barang')
        ->push([
            'methodname' => 'Update',
            'message' => 'Mengupdate barang ID 2',
            'newvalue' => $dataUpdate,
            'oldvalue' => $temp,
            'timespan' => '20-0210'
        ]);        

        echo '<pre>';
        print_r($newPost->getvalue());
    }
}