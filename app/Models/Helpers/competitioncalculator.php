<?php
namespace App\Models\Helpers;

class CompetitionCalculator {
    
    protected $_points_win = 3;
    protected $_points_draw = 1;
    protected $_fixtures = [];
    protected $_all_fixtures = [];
    protected $_period_fixtures = [];
    protected $_teams = [];
    protected $_teamtotals = [];
    protected $_matchday = 0;
    protected $_teamodds = FALSE;
    
    public function __construct($fixtures){
        $this->_all_fixtures = $fixtures;
        $this->_fixtures = $fixtures;
    }
    
    public function resetTeams(){
        $this->_teams = [];
    }
    
    
    public function setMatchday($matchday){
        foreach ($this->_fixtures as $fixture) {
            
        }
    }
    
    public function setPeriodFixtures($begin,$end){
        $begin_ts = strtotime($begin);
        $end_ts = strtotime($end);
        $this->_fixtures = [];
        foreach($this->_all_fixtures as $fixture){            
            if(strtotime($fixture['date']) >= $begin_ts && strtotime($fixture['date']) <= $end_ts){
                $this->_fixtures[] = $fixture;
            }
        }

        return $this->_fixtures;   
    }
    
    public function getPeriodStandings($date){
        $date_ts = strtotime($date.'-12 month');
        $end_ts = strtotime($date);
        $standings = [];
        while($date_ts <= $end_ts){            
            $this->resetTeams();
            $this->setPeriodFixtures(date('Y-m-d',$date_ts-2678400), date('Y-m-d',$date_ts));
            $this->calculate();
            $standings[date('Y-m-d',$date_ts)] = $this->getStandings();
            $date_ts += 86400;
        }
        
        return $standings;
    }
    
    public function getTeamOdds(){
        $date = date('Y-m-d');
        $standings = $this->getPeriodStandings($date);
        $total_mean = 0;
        $this->_teamodds = [];
        foreach($standings[$date] as $team => $results){
            $total_mean += $results['meanpoints'];
        }
        foreach($standings[$date] as $team => $results){
            $this->_teamodds[$team] = $results['meanpoints']/$total_mean;
        }     
        
        return $this->_teamodds;
        
    }
    
    public function calculateAlternative(){
        $this->getTeamOdds();
        $this->resetTeams();
        $this->calculate();
    }
    
    public function calculate(){
        $this->setPoints();
        $this->setGoals();
        $this->setTeamsTotals();
        $this->setPlayed();
        $this->setMeanPoints();
    }


    public function setPoints() {

        foreach ($this->_fixtures as $fixture) {
            $winHome = $this->_points_win;
            $drawHome = $this->_points_draw;
            $winAway = $this->_points_win;
            $drawAway = $this->_points_draw;
            if($this->_teamodds){
                $winHome = $this->_points_win * $this->_teamodds[$fixture['awayTeamName']];
                $drawHome = $this->_points_draw * $this->_teamodds[$fixture['awayTeamName']];
                $winAway = $this->_points_win * $this->_teamodds[$fixture['homeTeamName']];
                $drawAway = $this->_points_draw * $this->_teamodds[$fixture['homeTeamName']];
            }
            
            $result = $fixture['result'];
            if (!isset($this->_teams[$fixture['homeTeamName']]['points'])) {
                $this->_teams[$fixture['homeTeamName']]['points'] = 0;
            }
            if (!isset($this->_teams[$fixture['awayTeamName']]['points'])) {
                $this->_teams[$fixture['awayTeamName']]['points'] = 0;
            }
            if ($result['goalsHomeTeam'] > $result['goalsAwayTeam']) {
                $this->_teams[$fixture['homeTeamName']]['points'] += $winHome;
            } elseif ($result['goalsHomeTeam'] == $result['goalsAwayTeam']) {
                $this->_teams[$fixture['homeTeamName']]['points'] += $drawHome;
                $this->_teams[$fixture['awayTeamName']]['points'] += $drawAway;
            } else {
                $this->_teams[$fixture['awayTeamName']]['points'] += $winAway;
            }
        }
    }
    
    public function setMeanPoints() {
        foreach ($this->_fixtures as $fixture) {
            $this->_teams[$fixture['homeTeamName']]['meanpoints'] = $this->_teams[$fixture['homeTeamName']]['points'] / $this->_teams[$fixture['homeTeamName']]['played'];
            $this->_teams[$fixture['awayTeamName']]['meanpoints'] = $this->_teams[$fixture['awayTeamName']]['points'] / $this->_teams[$fixture['awayTeamName']]['played'];
        }
    }


    
    public function setGoals() {

        foreach ($this->_fixtures as $fixture) {
            $result = $fixture['result'];
            if (!isset($this->_teams[$fixture['homeTeamName']]['goalsscored'])) {
                $this->_teams[$fixture['homeTeamName']]['goalsscored'] = 0;
            }
            if (!isset($this->_teams[$fixture['awayTeamName']]['goalsscored'])) {
                $this->_teams[$fixture['awayTeamName']]['goalsscored'] = 0;
            }
            if (!isset($this->_teams[$fixture['homeTeamName']]['goalsconceded'])) {
                $this->_teams[$fixture['homeTeamName']]['goalsconceded'] = 0;
            }
            if (!isset($this->_teams[$fixture['awayTeamName']]['goalsconceded'])) {
                $this->_teams[$fixture['awayTeamName']]['goalsconceded'] = 0;
            }
            if (!isset($this->_teams[$fixture['homeTeamName']]['goaldifference'])) {
                $this->_teams[$fixture['homeTeamName']]['goaldifference'] = 0;
            }
            if (!isset($this->_teams[$fixture['awayTeamName']]['goaldifference'])) {
                $this->_teams[$fixture['awayTeamName']]['goaldifference'] = 0;
            }

            $this->_teams[$fixture['homeTeamName']]['goalsscored'] += $result['goalsHomeTeam'];
            $this->_teams[$fixture['awayTeamName']]['goalsscored'] += $result['goalsAwayTeam'];
            $this->_teams[$fixture['homeTeamName']]['goalsconceded'] += $result['goalsAwayTeam'];
            $this->_teams[$fixture['awayTeamName']]['goalsconceded'] += $result['goalsHomeTeam'];
            $this->_teams[$fixture['homeTeamName']]['goaldifference'] += $result['goalsHomeTeam'] - $result['goalsAwayTeam'];
            $this->_teams[$fixture['awayTeamName']]['goaldifference'] += $result['goalsAwayTeam'] - $result['goalsHomeTeam'];
        }
    }
    
    public function setPlayed() {

        foreach ($this->_fixtures as $fixture) {
            $result = $fixture['result'];
            if (!isset($this->_teams[$fixture['homeTeamName']]['played'])) {
                $this->_teams[$fixture['homeTeamName']]['played'] = 0;
            }
            if (!isset($this->_teams[$fixture['awayTeamName']]['played'])) {
                $this->_teams[$fixture['awayTeamName']]['played'] = 0;
            }

            $this->_teams[$fixture['homeTeamName']]['played'] += 1;
            $this->_teams[$fixture['awayTeamName']]['played'] += 1;
        }
    }

    public function setTeamsTotals(){
        $this->_teamtotals = [];        
        foreach($this->_teams as $team => $results){
            $this->_teamtotals[$team] = $results['points'] * 10000000 + ($results['goaldifference']) * 1000 + $results['goalsscored'];
        }
    }
    
    public function getStandings(){
        
        arsort($this->_teamtotals);
        $teams = [];
        foreach($this->_teamtotals as $team => $points){
            $teams[$team] = $this->_teams[$team];
        }

        return $teams;
    }

}