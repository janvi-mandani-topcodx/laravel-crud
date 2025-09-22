<?php
namespace App\Repositories;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model;
abstract class BaseRepository
{
    /**
     * @var Model
     */
    protected $model;
    /**
     * @var Application
     */
    protected $app;
    /**
     * @param  Application  $app
     *
     * @throws Exception
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
//        $this->makeModel();
    }
}





