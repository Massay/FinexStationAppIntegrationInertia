<?php

namespace App\Contracts;


interface DataMergerInterface{
    public function merge($postings): array;

    public function post($request,$data);
}