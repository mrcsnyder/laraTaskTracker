<?php

namespace App\Http\Controllers;

use App\User;

use App\Timelog;

use App\Component;


class TimeKeeperController extends Controller
{

    // return JSON of an array of objects
    // (users and how much time they have logged on issues)...
    public function userTimelogs()
    {
        // query all users in user table...
        $users = User::all();

        // declare empty array to store final output...
        $jsonUsersTime = array();

        // iterate through each user and time log and
        foreach ($users as $user) {

            // store the user id one user at a time...
            $user_id = $user->id;

            // store summed seconds in loop...
            $summed_seconds = $user->timelogs()->sum("seconds_logged");

            // create temporary array to store user id and summed seconds cast as an integer...
            $tmpUserArray = ['user_id' => (int)$user_id, 'seconds_logged' => (int)$summed_seconds];

            // push converted json to array using php's array_push method...
            array_push($jsonUsersTime, $tmpUserArray);
        }

        // convert populated array to json...
        $jsonUsersTime = json_encode($jsonUsersTime);

        // return JSON object of users time summed...
        return $jsonUsersTime;

    }

    // return JSON of an array of objects
    // (number of issues per component, and the total number of seconds logged to that component)...
    public function componentMetaData()
    {
        // query and store all components in components table...
        $components = Component::all();

        // query and store all timelogs in the timelogs table (minimize database queries if called ahead of time)...
        $timelogs = Timelog::all();

        // declare empty array to store final output...
        $finalArr = [];

       // iterate through each component...
        foreach ($components as $component) {

        // plucked issue ids from component...
            $plucky = $component->issues->pluck('id');

            // reset summed_seconds_per_component to zero for each component at iteration...
            $summed_seconds_per_component = 0;

            // loop through all 'plucked' issue ids and query the Timelog to get total seconds logged...
            foreach($plucky as $plucked) {

                // grab current timelog based on plucked issue id iteration...
                $timelog = $timelogs->where('issue_id', $plucked);

                // add summed timelog based on previously passed issue id...
                $summed_seconds_per_component += $timelog->sum('seconds_logged');
            }

            // create temporary array to store component_id, count of issues, and summed seconds spent for each component... all cast as an integer (for good measure)...
            $tmpCompMetaArr = ['component_id' => (int)$component->id, 'number_of_issues' => (int)$component->issues()->count(), 'seconds_logged' => (int)$summed_seconds_per_component ];

            // push converted json to array using php's array_push method...
            array_push($finalArr, $tmpCompMetaArr);

        }

        // convert final populated array to json...
        $finalOutput = json_encode($finalArr);


        // return JSON object of component meta data summed...
        return $finalOutput;

    }


}
