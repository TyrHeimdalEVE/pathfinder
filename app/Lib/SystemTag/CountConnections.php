<?php

namespace Exodus4D\Pathfinder\Lib\SystemTag;

use Exodus4D\Pathfinder\Model\Pathfinder\ConnectionModel;
use Exodus4D\Pathfinder\Model\Pathfinder\MapModel;
use Exodus4D\Pathfinder\Model\Pathfinder\SystemModel;
use Exodus4D\Pathfinder\Model\Universe\AbstractUniverseModel;
use Exodus4D\Pathfinder\Lib\SystemTag;

class CountConnections implements SystemTagInterface
{
    /**
     * @param SystemModel $targetSystem
     * @param SystemModel $sourceSystem
     * @param MapModel $map
     * @return string|null
     * @throws \Exception
     */
    static function generateFor(SystemModel $targetSystem, SystemModel $sourceSystem, MapModel $map) : ?string
    {
        // set target class for new system being added to the map
        $targetClass = $targetSystem->security;
        
        // Get all systems from active map
        $systems = $map->getSystemsData();
                
        // empty array to append tags to,        
        // iterate over systems and append tag to $tags if security matches targetSystem security 
        // and it is not our home (locked)
        $tags = array();
        foreach ($systems as $system) {
          if ($system->security === $targetClass && !$system->locked && $system->tag) {
            array_push($tags, SystemTag::tagToInt($system->tag));
          }
        };
                
        $whConnections = array_filter($sourceSystem->getConnections(), function (ConnectionModel $connection) {
          return $connection->isWormhole();
        });
        $countWhConnections = count($whConnections);
        if($sourceSystem->locked){
            if($sourceSystem->Locked && $targetClass == "C5" && !in_array(1, $tags)){
                $systemTag         = 1;
                return $systemTag;
            }
            if($sourceSystem->Locked && $targetClass == "0.0" && !in_array("SNS", $tags)){
                $systemTag         = "SNS";
                return $systemTag;
            }
            else {
                $countWhConnections++;
        
                $parentTag          = $sourceSystem->tag;
                $systemTag          = "$parentTag$countWhConnections";
                
                return max($systemTag, 1);
            }
        }
    }
}
