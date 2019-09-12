<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;

use App\Component;

use App\Issue;

use App\ComponentIssue;

use App\User;

use App\Timelog;

use GuzzleHttp\Client;

class taskTrackerData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Components, Issues (and relate them), Timelogs, and Users from the Endpoint.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        //try/catch to call Components endpoint and populate database
        try{

            // components endpoint...
            $url = 'https://my-json-server.typicode.com/bomoko/algm_assessment/components';

            //pass in the endpoint URL and store Guzzle endpoint GET request results...
            $results = $this->guzzler($url);

            //iterate through each response item and store in the components table by creating a new Component...
            foreach($results as $item) {

                // instantiate new Component...
                $component = new Component;

                // set the appropriate data into appropriate field in components table...
               $component->name = $item['name'];

               //save component record to the components table...
               $component->save();

            }

            // print out success message to CLI...
            echo"Components added successfully!"."\n";

        }

        //if endpoint is incorrect or unreachable... then it will echo this to the CLI when attempting to run the add:data artisan command...
        catch(\Exception $ex) {

            echo "The Components endpoint could not be reached.  Try again buddy. :("."\n";

        }


        //try/catch to call Issues endpoint and populate database
        try{

            // issues endpoint...
             $url = 'https://my-json-server.typicode.com/bomoko/algm_assessment/issues';

            //pass in the endpoint URL and store Guzzle endpoint GET request results...
            $results = $this->guzzler($url);

            //iterate through each response item and store in the Issues table by creating a new Issue...
            foreach($results as $item) {

                // instantiate new Issue...
                $issue = new Issue;

                //set the appropriate data into appropriate field in issues table...
                $issue->code = $item['code'];

                //save issue record to the issues table...
                //saving also gives us the ability to see ID of this created record which we will need in next loop...
                $issue->save();


                //iterate through the Issue endpoint's components...
                foreach($item['components'] as $component) {

                    // instantiate a new ComponentIssue (pivot table model)...
                    $component_issue = new ComponentIssue();

                    //set the values of each component_issue to the appropriate component id and issue id...
                    $component_issue->component_id = $component;
                    $component_issue->issue_id = $issue->id;

                    // save the related records to the pivot table...
                    $component_issue->save();
                }


            }

            // print out success message to CLI...
            echo "Issues added and related to Components successfully!"."\n";

        }

            //if endpoint is incorrect or unreachable... then it will echo this to the CLI when attempting to run the add:data artisan command...
        catch(\Exception $ex) {

            echo "The Issues endpoint could not be reached.  Try again buddy. :("."\n";

        }


        //try/catch to call Users endpoint and populate database
        try{

            // users endpoint...
            $url = 'https://my-json-server.typicode.com/bomoko/algm_assessment/users';

            //pass in the endpoint URL and store Guzzle endpoint GET request results...
            $results = $this->guzzler($url);

            //iterate through each response item and store in the Users table by creating a new User...
            foreach($results as $item) {

                // instantiate new User...
                $user = new User;

                //set the appropriate data into appropriate field in users table...
                $user->name = $item['name'];
                $user->email = $item['email'];

                //save user record to the users table...
                $user->save();
            }

            // print out success message to CLI...
            echo "Users added successfully!"."\n";
        }

            //if endpoint is incorrect or unreachable... then it will echo this to the CLI when attempting to run the add:data artisan command...
        catch(\Exception $ex) {

            echo "The Users endpoint could not be reached.  Try again buddy. :("."\n";

        }


        //try/catch to call Timelogs endpoint and populate database
        try{

            // timelogs endpoint...
            $url = 'https://my-json-server.typicode.com/bomoko/algm_assessment/timelogs';

            //pass in the endpoint URL and store Guzzle endpoint GET request results...
            $results = $this->guzzler($url);

            //iterate through each response item and store in the Users table by creating a new User...
            foreach($results as $item) {

                // instantiate new Timelog...
                $timelog = new Timelog;

                //set the appropriate data into appropriate field in timelogs table...
                $timelog->issue_id = $item['issue_id'];
                $timelog->user_id = $item['user_id'];
                $timelog->seconds_logged = $item['seconds_logged'];

                //save timelog record to the timelogs table...
                $timelog->save();

            }
            // print out success message to CLI...
            echo "Timelogs added successfully!"."\n";
        }

            //if endpoint is incorrect or unreachable... then it will echo this to the CLI when attempting to run the add:data artisan command...
        catch(\Exception $ex) {


            echo "The Timelogs endpoint could not be reached.  Try again buddy. :("."\n";


        }

    }

    //custom Guzzle function to DRY up command code a bit...
    public function guzzler($url) {

        //instantiate Guzzle client...
        $client = new Client();

        //use client to do a get request on the URL...
        $response = $client->get($url);

        //use the Guzzle client's getBody method to store results...
        $results = $response->getBody();

        //use json_decode with an associative array to get the data in the format we like...
        $results = json_decode($results, true);

        //return the results...
        return $results;

    }

}
