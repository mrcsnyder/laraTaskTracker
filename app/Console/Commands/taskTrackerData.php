<?php

namespace App\Console\Commands;

use App\Repositories\Interfaces\ComponentIssueRepositoryInterface;
use App\Repositories\Interfaces\ComponentRepositoryInterface;
use App\Repositories\Interfaces\IssueRepositoryInterface;
use App\Repositories\Interfaces\TimelogRepositoryInterface;
use App\Repositories\Interfaces\UserRespositoryInterface;
use Illuminate\Console\Command;
use GuzzleHttp\Client;

class taskTrackerData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:data';

    //constant global endpoint_url prefix...
    protected $endpoint_url = 'https://my-json-server.typicode.com/bomoko/algm_assessment/';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Components, Issues (and relate them), Timelogs, and Users from the Endpoint.';


    /**
     * Create a new command instance.
     *
     * @param ComponentRepositoryInterface $components
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param ComponentRepositoryInterface $components
     * @param IssueRepositoryInterface $issues
     * @param ComponentIssueRepositoryInterface $component_issue
     * @param UserRespositoryInterface $users
     * @param TimelogRepositoryInterface $timelogs
     * @return mixed
     */
    public function handle(ComponentRepositoryInterface $components,
                           IssueRepositoryInterface $issues,
                           ComponentIssueRepositoryInterface $component_issue,
                           UserRespositoryInterface $users,
                           TimelogRepositoryInterface $timelogs
                            )
    {

        //store components as string...
        $compStr = 'components';

        //Add Components by passing $compStr and ComponentRepositoryInterface object to tryCatcher method...
        $this->tryCatcher($compStr, $components);

        //store issues as string...
        $IshStr = 'issues';

        //Add Issues by passing $IshStr and IssueRepositoryInterface object to tryCatcher method...
        $this->tryCatcher($IshStr, $issues);

        $compIshStr = 'component_issue';

        //relate issues to appropriate component(s) by passing compIshStr and ComponentIssueRepositoryInterface object to tryCatcher method...
        $this->tryCatcher($compIshStr, $component_issue);

        //store users as string...
        $usrStr = 'users';

        //Add Users by passing $usrStr and UserRepositoryInterface object to tryCatcher method...
        $this->tryCatcher($usrStr, $users);

        //store timelogs as string...

        $tLogStr = 'timelogs';

        $this->tryCatcher($tLogStr, $timelogs);


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


    //custom try catch method to DRY things up...
    public function tryCatcher($endpoint, $interface) {

        try {

            if($endpoint == 'component_issue') {
                //append issue to endpoint in this case...
                $endAppend = $this->endpoint_url.'issues';
            }
            else {
                //append appropriate name to endpoint...
                $endAppend = $this->endpoint_url.$endpoint;
            }

            //get Guzzle results from endpoint passed into method...
            $resultsEndpoint = $this->guzzler($endAppend);

        }

        catch(\Exception $ex) {

            echo "Something went wrong reaching the ".ucfirst($endpoint). "\n";

        }

        try {

            $interface->populate($resultsEndpoint);

            // print out appropriate success message to CLI...
            echo ucfirst($endpoint)." added successfully!"."\n";

        }

        catch(\Exception $ex) {

            echo "Something went wrong with the interface ".$interface. "\n";

        }


    }



}
