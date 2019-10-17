<?php

namespace App\Providers;

use App\Repositories\DbComponentIssueRepository;
use App\Repositories\DbComponentRepository;
use App\Repositories\DbIssueRepository;
use App\Repositories\DbTimelogRepository;
use App\Repositories\DbUserRepository;
use App\Repositories\Interfaces\ComponentIssueRepositoryInterface;
use App\Repositories\Interfaces\ComponentRepositoryInterface;
use App\Repositories\Interfaces\IssueRepositoryInterface;
use App\Repositories\Interfaces\TimelogRepositoryInterface;
use App\Repositories\Interfaces\UserRespositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        //call custom register repo method(s)...
        $this->registerComponentRepo();
        $this->registerIssueRepo();
        $this->registerComponentIssueRepo();
        $this->registerUserRepo();
        $this->registerTimelogRepo();

    }



    //registerComponentRepo function...
    public function registerComponentRepo(){

        //bind repository and interface classes to service provider...
        $this->app->bind(
            ComponentRepositoryInterface::class,
            DbComponentRepository::class

        );

    }

    //registerIssueRepo function...
    public function registerIssueRepo(){

        //bind repository and interface classes to service provider...
        $this->app->bind(
            IssueRepositoryInterface::class,
            DbIssueRepository::class

        );

    }

    //registerComponentIssueRepo function...
    public function registerComponentIssueRepo(){

        //bind repository and interface classes to service provider...
        $this->app->bind(
            ComponentIssueRepositoryInterface::class,
            DbComponentIssueRepository::class
        );
    }

    //registerUserRepo function...
    public function registerUserRepo(){

        //bind repository and interface classes to service provider...
        $this->app->bind(
            UserRespositoryInterface::class,
            DbUserRepository::class
        );
    }

    //registerTimelogRepo function...
    public function registerTimelogRepo(){

        //bind repository and interface classes to service provider...
        $this->app->bind(
            TimelogRepositoryInterface::class,
            DbTimelogRepository::class
        );
    }


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
