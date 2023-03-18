<?php

namespace Sabo\Model\System\QueryBuilder;

use Exception;
use Sabo\Config\SaboConfig;
use Sabo\Config\SaboConfigAttributes;

/**
 * gestion du sql insert
 */
trait Insert{
    /**
     * ajoute le sql insert
     * @param values tableau représentant les valeurs à insérer [nom_attribut => valeur]
     * @return this
     * @throws Exception (en mode debug) si values est bide
     */
    public function insert(array $values):QueryBuilder{
        if(empty($values) ){
            if(SaboConfig::getBoolConfig(SaboConfigAttributes::DEBUG_MODE) )
                throw new Exception("Values ne peut être vide dans une requête insert");
            else
                return $this;
        }

        $columnsToInsert = [];
        $marks = [];

        // récupération des valeurs à insérer
        foreach($values as $attributeName => $value){
            $columnName = $this->getAttributeLinkedColName($attributeName);

            array_push($columnsToInsert,"{$this->as}.{$columnName}");
            array_push($marks,"?");
        }

        $this->sqlString = "insert into {$this->linkedModel->getTableName()} as {$this->as}(" . implode(",",$columnsToInsert) . ") values(" . implode(",",$marks) . ") ";

        return $this;
    }
}