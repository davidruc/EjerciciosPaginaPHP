<?php

/*
 * By adding type hints and enabling strict type checking, code can become
 * easier to read, self-documenting and reduce the number of potential bugs.
 * By default, type declarations are non-strict, which means they will attempt
 * to change the original type to match the type specified by the
 * type-declaration.
 *
 * In other words, if you pass a string to a function requiring a float,
 * it will attempt to convert the string value to a float.
 *
 * To enable strict mode, a single declare directive must be placed at the top
 * of the file.
 * This means that the strictness of typing is configured on a per-file basis.
 * This directive not only affects the type declarations of parameters, but also
 * a function's return type.
 *
 * For more info review the Concept on strict type checking in the PHP track
 * <link>.
 *
 * To disable strict typing, comment out the directive below.
 */

 class Tournament
 {
     public $rawArray;
     public $teamArray;
     public $outputArray;
     function __construct()
     {
         $this->rawArray = array();
         $this->teamArray = array();
         $this->outputArray = array();
     }
     function tally($inputMatch)
     {
         if (!$this->createRawArray($inputMatch)) return $this->getHeader();
         $this->createOutputArray();
         $this->addScoreToArray();
         //$this->addPointsToArray();
         usort($this->outputArray, array("Tournament", "compare"));
         return $this->finalString();
     }
     function finalString()
     {
         $outputString = $this->getHeader();
         foreach ($this->outputArray as $outputArrayValue) {
             $outputString .= "\n" . $outputArrayValue[0] . str_repeat(' ', 31 - strlen($outputArrayValue[0])) . "|  " . $outputArrayValue[1] . " |  " . $outputArrayValue[2] . " |  " . $outputArrayValue[3] . " |  " . $outputArrayValue[4] . " |  " . $outputArrayValue[5];
         }
         return $outputString;
     }
     function getHeader()
     {
         return "Team" . str_repeat(' ', 27) . "| MP |  W |  D |  L |  P";
         //return "Team                           | MP |  W |  D |  L |  P";
     }
     // erzeugt ein zwei Deminsionales Array, indem alle Informationen, des Übergebenen Strings gespeichert sind
     function createRawArray($inputMatch)
     {
         if ($inputMatch == "") return false;
         $this->rawArray = explode(PHP_EOL, $inputMatch);
         //echo var_dump($formatArray);
         for ($i = 0; $i < sizeOf($this->rawArray); $i++) {
             $this->rawArray[$i] = explode(";", $this->rawArray[$i]);
         }
         //return fillPoints(getScoreArray(getTeamArray($formatArray), $formatArray));
         //return $this->rawArray;
         return true;
     }
     
     function createOutputArray(){
         $this->createTeamArray();
         foreach($this->teamArray as $teamArrayValue){
             array_push($this->outputArray, array($teamArrayValue, 0, 0, 0, 0, 0));
         }
     }
     function createTeamArray(){
         foreach($this->rawArray as $rawArrayValue){
             if(array_search($rawArrayValue[0], $this->teamArray) === false and array_search($rawArrayValue[1], $this->teamArray) === false){
                 array_push($this->teamArray, $rawArrayValue[0]);
                 array_push($this->teamArray, $rawArrayValue[1]);
             }
             else if(array_search($rawArrayValue[0], $this->teamArray) === false){
                 array_push($this->teamArray, $rawArrayValue[0]);
             }else if(array_search($rawArrayValue[1], $this->teamArray) === false){
                 array_push($this->teamArray, $rawArrayValue[1]);
             }
         }
     }
     function addScoreToArray()
     {
         for($i = 0; $i < sizeOf($this->rawArray); $i++){
             $indexOfTeam1 = array_search($this->rawArray[$i][0], $this->teamArray);
             $indexOfTeam2 = array_search($this->rawArray[$i][1], $this->teamArray);
             // Matchplayed für das Team1 +1
             $this->outputArray[$indexOfTeam1][1] += 1;
             // Matchplayed für das Team2 +1 
             $this->outputArray[$indexOfTeam2][1] += 1;
     
             if ($this->rawArray[$i][2] === "win") {
                 // win für Team1 +1
                 $this->outputArray[$indexOfTeam1][2] += 1;
                 // loss für Team2 +1
                 $this->outputArray[$indexOfTeam2][4] += 1;
                 // Punkte für Team1 +3
                 $this->outputArray[$indexOfTeam1][5] += 3;
             } elseif($this->rawArray[$i][2] === "loss"){
                 // win für Team2 +1
                 $this->outputArray[$indexOfTeam2][2] += 1;
                 // loss für Team1 +1
                 $this->outputArray[$indexOfTeam1][4] += 1;
                 // Punkte für Team2 +3
                 $this->outputArray[$indexOfTeam2][5] += 3;
             } else {
                 // draw für Team1 +1
                 $this->outputArray[$indexOfTeam1][3] += 1;
                 // draw für Team2 +1
                 $this->outputArray[$indexOfTeam2][3] += 1;
                 // Punkte für Team1 +1
                 $this->outputArray[$indexOfTeam1][5] += 1;
                 // Punkte für Team2 +1
                 $this->outputArray[$indexOfTeam2][5] += 1;
             }
         }
     }
     private static function compare($array1, $array2){
         if($array1[5] > $array2[5]) return -1;
         else if ($array1[5] < $array2[5]) return 1;
         else return strcasecmp($array1[0], $array2[0]);
     }
     
 }

?>