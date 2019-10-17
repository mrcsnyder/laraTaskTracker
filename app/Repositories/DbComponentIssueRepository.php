<?php namespace App\Repositories;

use App\ComponentIssue;
use App\Repositories\Interfaces\ComponentIssueRepositoryInterface;

class DbComponentIssueRepository implements ComponentIssueRepositoryInterface {


    //take the passed results and then populate the ComponentsIssue (pivot) table with each related Issues endpoint result...
    public function populate($results) {

        //try/catch block to iterate through the passed Issues endpoint results and store ComponentIssue(s)
        // (relate issue(s) to component(s)) record(s)...
        try{

            //iterate through each Issue response item...
            foreach($results as $item) {


                $this_id = $item['id'];
                // iterate through each Issue's 'component' JSON data attribute...
                // ...and store record into component_issue pivot table to relate records appropriately...
                    foreach($item['components'] as $component) {

                    // instantiate a new ComponentIssue (pivot table model)...
                    $component_issue = new ComponentIssue();

                    //set the values of each component_issue to the appropriate component_id and issue_id...
                    $component_issue->component_id = $component;
                    $component_issue->issue_id = $this_id;

                    // save the related records to the pivot table...
                    $component_issue->save();
                }

            }

        }

        catch(\Exception $ex) {

            //echo out error message if a problem exists trying to save the new ComponentIssue pivot record(s)...
            echo "Something went wrong with the DbComponentIssueRepository"."\n";
        }


    }

}
