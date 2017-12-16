<?php

namespace App\Http\Controllers\Core;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\API\External\FootballData;
use App\Models\Helpers\CompetitionCalculator;
use Cloudinary;

class CompetitionController extends Controller
{

    protected $_competition_id = FALSE;
    
    public function __construct($competition_id) {
        $this->_competition_id = $competition_id;
    }
    
    public function fixtures(){
        Cloudinary::config(array( 
  "cloud_name" => "stplus", 
  "api_key" => "832196364416766", 
  "api_secret" => "OoFJaC9pd3I9xC1QiifgYq7ra5c" 
));
echo cl_image_tag("sample.jpg", array( "alt" => "Sample Image" ));
echo 'test';

        $api = new FootballData();
        $results = $api->getCompetitionFixtures($this->_competition_id);

        $fixtures = $results['fixtures'];

        return view('competition/fixtures')->with('fixtures',$fixtures);      
    }
    
    public function standings(){
        $api = new FootballData();
        $fixtures = $api->getCompetitionFinishedFixtures($this->_competition_id);

        $calc = new CompetitionCalculator($fixtures);
//        $calc->setPeriodFixtures('2016-01-01', '2016-02-01');
        $calc->calculateAlternative();
//        $calc->getTeamOdds('2016-01-03');
       

        return view('competition/standings')->with('teams',$calc->getStandings());      
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
