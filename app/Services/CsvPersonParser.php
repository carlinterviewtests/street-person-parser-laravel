<?php
namespace App\Services;
use Illuminate\Support\Collection;

class CsvPersonParser
{
    const TITLES =  ["Mr", "Mister", "Mrs", "Ms", "Miss", "Dr", "Prof"];

    public function parse(array $input): Collection
    {
        $people = collect();

        // Read in the CSV file and convert it to an array of arrays
        $csvData = array_map('str_getcsv',$input);

        foreach ($csvData as $row) {

            // Split the names into an array based on the "and" or "&" separator
            $names = preg_split('/\s+(&|and)\s+/',$row[0]);
            $namesLength = count($names);

            // If the row has more than just a title
             if($namesLength > 1){

                 // check if the value contains a title
                 if($this->detectTitle($names[0])){
                     $arrayParts = explode(' ',$names[1]);
                     $newName =  array_pop($arrayParts);
                     $names[0] .= ' ' . $newName;
                 }
             }

            // Loop through each name and create a person object
            foreach ($names as $name) {
                $person = $this->createPerson($name);

                // Add the person to the collection if valid
                if ($person != null){
                    $people->push($person);
                }
            }
        }
        // Return the collection of people
        return $people;
    }

    // Helper function to create a person object from a name string
    function createPerson(string $name): ?array
    {
        $parts = explode(' ', $name);

        // Return null if the data is not valid
        if (count($parts) <= 1) {
            return null;
        }

        // Initialize a new person array with null values for each field
        $person = [
            'title' => $parts[0],
            'first_name' => null,
            'initial' => null,
            'last_name' => $parts[count($parts) - 1]
        ];

        if (count($parts) === 3 && strlen($parts[1]) <= 2) {
            $person['initial'] = str_replace('.', '', $parts[1]);
        } elseif (count($parts) === 3) {
            $person['first_name'] = $parts[1];
        }

        return $person;
    }

    public function detectTitle($input)
    {
        // Loop through each title in the TITLES array
        foreach (self::TITLES as $title) {
            // Check if the input matches the current title, ignoring case
            if (strcasecmp($input, $title) === 0) {
                return true; // Return true if a match is found
            }
        }
        return false; // Return false if no match is found
    }
}
