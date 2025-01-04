<?php

namespace App\Http\Controllers;


use App\Services\DataMerger\JvDataMerger;
use Illuminate\Http\Request;


class ProcessJVPostingController extends Controller
{


    public function __construct(private JvDataMerger $jvDataMerger)
    {

    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $request->validate([
            'batchNumber' => 'required',
            'date' => [
                'date',
                'required'
            ],
            'year' => 'required',
            'description' => 'required',
            'postings' => [
                'required'
            ]
        ]);


        $postings = $request->postings;



        $mergeData = $this->jvDataMerger->merge($postings);

        // dd($mergeData);


        $response =  $response = $this->jvDataMerger->post($request, $mergeData);;


        // dd($response);

        if($response['status']){
            return to_route(route: 'jv');
        }


        abort(405, $response['error']);





        //return $response;

        // return to_route(route: 'jv');

    }
}
