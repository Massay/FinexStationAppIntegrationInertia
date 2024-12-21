<?php

namespace App\Http\Controllers;


use App\Services\DataMerger\JvDataMerger;
use Illuminate\Http\Request;


class ProcessJVPostingController extends Controller
{


    public function __construct(private JvDataMerger $jvDataMerger){

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

        $this->jvDataMerger->post($request, $mergeData);
    

        return to_route(route: 'jv');
       
    }
}
