<?php namespace App\Repositories;

use App\Component;
use App\Repositories\Interfaces\ComponentRepositoryInterface;

class DbComponentRepository implements ComponentRepositoryInterface {


    //take the passed results and then populate the components table with each Components endpoint result...
    public function populate($results) {

        //try/catch block to iterate through the passed results and store Component(s) record(s)...
        try{

            //iterate through each response item and store in the components table by creating a new Component...
            foreach($results as $item) {

                //instantiate new Component model object...
                $component = new Component;

                $component->name = $item['name'];

                $component->save();

            }

        }

        catch(\Exception $ex) {

            //echo out error message if a problem exists trying to save the new Component record(s)...
            echo "Something went wrong with the DbComponentRepository"."\n";
        }


    }

}
