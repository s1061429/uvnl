<?php

namespace App\Http\Controllers\API\External;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\API\External\FootballData;

class FootballDataController extends Controller
{
    public function showCompetitions($year){
        $data = new FootballData();
        return $data->getAllCompetitions($year);
    }
}
