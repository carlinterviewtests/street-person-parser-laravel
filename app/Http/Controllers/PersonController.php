<?php

namespace App\Http\Controllers;
use App\Services\CsvPersonParser;

class PersonController extends Controller
{
    public function uploadPersonCSV()
    {
        // Create an instance of the CsvPersonParser class
        $parser = new CsvPersonParser();

        // Call the parse() method on the instance
        $people = $parser->parse(file(storage_path('/person-fixtures/people.csv')));

        dd($people); // Die and dump to view data in required format as outlined in readme.

        // return $people;
    }
}
