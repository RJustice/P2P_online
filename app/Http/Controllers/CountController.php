<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Storage;
use Response;

class CountController extends Controller
{
    protected $dataFile = 'data_file.json';
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($type = 'all')
    {
        $return = [];
        $data = Storage::disk('local')->get($this->dataFile);
        $data = json_decode($data,true);
        $now = time();
        $register = $data['register'];
        $projects = $data['projects'];
        $num = 0;
        $reload = false;
        if( $now - $register['updated'] > $register['randTime'] ){
            $data['register']['count'] = $register['count'] + mt_rand($register['randMin'],$register['randMax']);
            $data['register']['updated'] = $now;
            $reload = true;
        }

        if( $now - $projects['updated'] > $projects['randTime'] ){
            $t = 0;
            foreach( $projects as $k => $project ){
                $has = $project['has'];
                $total = $project['total'];
                $rand = mt_rand($project['randMin'],$project['randMax']);
                if( $has == 'done' ){
                    $has = 0;
                }
                if( $has + $rand >= $total ){
                    $has = 'done';
                }else{
                    $has = $has + $rand;
                }
                $data['projects'][$k]['has'] = $has;
                $t += $rand;
            }
            $data['projects']['updated'] = $now;
            $data['projects']['total'] = $data['projects']['total'] + $t * 10000 + mt_rand(100,3000);
            $reload = true;
        }
        if( $reload ){
            Storage::disk('local')->put($this->dataFile,json_encode($data));
        }
        $return = [
            'register' => $data['register']['count'],
            'projects' => [
                'pj1' => [
                    'c' => $data['projects']['pj1']['has'],
                    't' => $data['projects']['pj1']['total']
                ],
                'pj2' => [
                    'c' => $data['projects']['pj2']['has'],
                    't' => $data['projects']['pj3']['total']
                ],
                'pj3' => [
                    'c' => $data['projects']['pj3']['has'],
                    't' => $data['projects']['pj3']['total']
                ],
                'pj4' => [
                    'c' => $data['projects']['pj4']['has'],
                    't' => $data['projects']['pj4']['total']
                ],
                'pj5' => [
                    'c' => $data['projects']['pj5']['has'],
                    't' => $data['projects']['pj5']['total']
                ],
                'pj6' => [
                    'c' => $data['projects']['pj6']['has'],
                    't' => $data['projects']['pj6']['total']
                ],
                'pj7' => [
                    'c' => $data['projects']['pj7']['has'],
                    't' => $data['projects']['pj7']['total']
                ],
                'pj8' => [
                    'c' => $data['projects']['pj8']['has'],
                    't' => $data['projects']['pj8']['total']
                ],
            ],
            'total' => $data['projects']['total']
        ];
        return Response::json($return);
    }

    /*Storage::disk('local')->put($this->dataFile,json_encode([
            'register' => [
                'count'=>1593,
                'updated' => time(),
                'randMin' => 1,
                'randMax' => 10,
                'randTime' => 300,
            ],
            'projects' => [
                'pj1' => [
                    'total' => 5000,
                    'has' => 3578,
                    'randMin' => 10,
                    'randMax' => 50,
                ],
                'pj2' => [
                    'total' => 5000,
                    'has' => 2580,
                    'randMin' => 10,
                    'randMax' => 50,
                ],
                'pj3' => [
                    'total' => 5000,
                    'has' => 3700,
                    'randMin' => 10,
                    'randMax' => 50,
                ],
                'pj4' => [
                    'total' => 5000,
                    'has' => 2860,
                    'randMin' => 10,
                    'randMax' => 50,
                ],
                'pj5' => [
                    'total' => 3000,
                    'has' => 1600,
                    'randMin' => 10,
                    'randMax' => 50,
                ],
                'pj6' => [
                    'total' => 3000,
                    'has' => 1900,
                    'randMin' => 10,
                    'randMax' => 50,
                ],
                'pj7' => [
                    'total' => 8000,
                    'has' => 4960,
                    'randMin' => 100,
                    'randMax' => 200,
                ],
                'pj8' => [
                    'total' => 8000,
                    'has' => 6840,
                    'randMin' => 100,
                    'randMax' => 200,
                ],
                'updated' => strtotime(date('Y-m-d')),
                'randTime' => 86400,
            ]
        ])
    );*/

}
