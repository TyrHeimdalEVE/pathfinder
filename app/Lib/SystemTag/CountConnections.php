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
        // Get WH Class of new node being added to the map -> $targetClass
        $targetClass = $targetSystem->security;

        // Get all WH connections of sourceSystem -> $whConnections
        $whConnections = array_filter($sourceSystem->getConnections(), function (ConnectionModel $connection) {
            return $connection->isWormhole();
        });

        // Get Tag of sourceSystem -> $parentTag
        $parentTag          = $sourceSystem->tag;

        // Get all systems from active map -> $systems
        $systems = $map->getSystemsData();

        // Get total count of connections of $whConnections -> $countWhConnections
        $countWhConnections = count($whConnections);

        // Declare $tags as an array
        $tags = array();
           
        // If HOME HOLE
        if($parentTag === '0'){

            // I'm lazy, ok?
            function num2alpha($n) {
                $r = '';
                for ($i = 1; $n >= 0 && $i < 10; $i++) {
                $r = chr(0x41 + ($n % pow(26, $i) / pow(26, $i - 1))) . $r;
                $n -= pow(26, $i);
                }
                return $r;
            }

            // Iterate over all systems on map -> $system
            foreach ($systems as $system) {
                if($system->security === $targetClass){
                    if(preg_match('/^(1)|(1\.[a-zA-Z])$/', $system->tag)){
                        $countStaticC5++;
                        $alphaStaticC5 = num2alpha($countStaticC5);
                    } elseif(preg_match('/^(SNS)|(SNS\.[a-zA-Z])$/', $system->tag)){
                        $countStaticNS++;
                        $alphaStaticNS = num2alpha($countStaticNS);
                    }
                }
            }

            // If target WH is a C5
            if($targetClass === 'C5' && !$countStaticC5){
                // Give tag -> 1
                $systemTag          = '1';
            } elseif ($targetClass === 'C5' && $countStaticC5){
                // Give tag -> 1.A-Z
                
                $systemTag          = "1.$alphaStaticC5";
            } elseif ($targetClass === '0.0' && !$countStaticNS){
                // Give tag -> SNS
                $systemTag          = 'SNS';
            } elseif ($targetClass === '0.0' && $countStaticNS){
                // Give tag -> SNS.A-Z
                $systemTag          = "SNS.$alphaStaticNS";
            } else {
                $countWhConnections++;
                $systemTag          = "$countWhConnections";
            }
        } else {
            $systemTag          = "$parentTag$countWhConnections";
            //return max($systemTag, 1);
        }
        return $systemTag;
    }
}
