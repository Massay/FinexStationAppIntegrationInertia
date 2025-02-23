<?php

namespace App\Http\Controllers;


use App\Services\DataMerger\SivDataMerger;
use Illuminate\Http\Request;


class ProcessSivPostingController extends Controller
{



    public function __construct(private SivDataMerger $sivDataMerger){

    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'batchNumber' => 'required',
            'year' => 'required',
            'date' => 'required',
            'description' => 'required',
            'postings' => 'required',
            'unitPriceAgo' => [
                'required',
                'gt:0'
            ],
            'unitPricePms' => [
                'required',
                'gt:0'
            ]
        ]);

        $postings = $request->postings;

        $mergeData = $this->sivDataMerger->merge($postings);
        // dd($mergeData);
        $response = $this->sivDataMerger->post($request, $mergeData);
        //dd($response);
        if($response['status']){
            return to_route('siv');
        }

        abort(405, $response['error']);

    }

}
