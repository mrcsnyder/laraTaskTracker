<?php namespace App\Repositories;

use App\Issue;
use App\Repositories\Interfaces\IssueRepositoryInterface;

class DbIssueRepository implements IssueRepositoryInterface {

    //take the passed results and then populate the issues table with each Issue endpoint result...
    public function populate($results) {

        //try/catch block to iterate through the passed results and store Issue(s) record(s)...
        try{

            //iterate through each response item and store in the components table by creating a new Component...
            foreach($results as $item) {

                //instantiate new Issue model object
                $issue = new Issue;

                $issue->code = $item['code'];

                $issue->save();

            }

        }

        catch(\Exception $ex) {

            //echo out error message if a problem exists trying to save the new Issue record(s)...
            echo "Something went wrong with the DbIssueRepository"."\n";

        }


    }

}
