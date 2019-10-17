<?php namespace App\Repositories;

use App\Timelog;
use App\Repositories\Interfaces\TimelogRepositoryInterface;

class DbTimelogRepository implements TimelogRepositoryInterface {

    //take the passed results and then populate the timelogs table with each timelog endpoint result...
    public function populate($results) {

        //try/catch block to iterate through the passed results and store Timelog(s) record(s)...
        try{

            //iterate through each response item and store in the timelogs table by creating a new Timelog...
            foreach($results as $item) {

                //instantiate new Timelog model object...
                $timelog = new Timelog;

                $timelog->issue_id = $item['issue_id'];
                $timelog->user_id = $item['user_id'];
                $timelog->seconds_logged = $item['seconds_logged'];


                $timelog->save();

            }

        }

        catch(\Exception $ex) {

            //echo out error message if a problem exists trying to save the new Timelog record(s)...
            echo "Something went wrong with the DbTimelogRepository"."\n";

        }


    }

}
