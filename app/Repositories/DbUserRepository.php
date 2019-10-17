<?php namespace App\Repositories;

use App\User;
use App\Repositories\Interfaces\UserRespositoryInterface;

class DbUserRepository implements UserRespositoryInterface {

    //take the passed results and then populate the users table with each issue endpoint result...
    public function populate($results) {

        //try/catch block to iterate through the passed results and store User(s) record(s)...
        try{

            //iterate through each response item and store in the users table by creating a new User...
            foreach($results as $item) {

                //instantiate new User model object...
                $user = new User;

                $user->name = $item['name'];
                $user->email = $item['email'];

                $user->save();

            }

        }

        catch(\Exception $ex) {

            //echo out error message if a problem exists trying to save the new User record(s)...
            echo "Something went wrong with the DbUserRepository"."\n";

        }


    }

}
