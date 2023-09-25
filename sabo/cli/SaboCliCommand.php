<?php
namespace Sabo\Cli;

/**
 * parent des commandes sabo
 */
abstract class SaboCliCommand{
    /**
     * liste des commandes
     */
    private static array $commands;

    /**
     * vérifie si la saisie vaux la touche entrée
     * @param string $input la saisie
     * @return bool si la touche entrée a été utilisé
     */
    protected function isEnter(string $input):bool{
        return empty(trim($input) );
    }

    /**
     * exécute la commande présente en ligne
     * @param int $argc le nombre d'argument
     * @param array|null $argv les arguments passés
     */
    public static function execArgvCommand(int $argc,?array $argv):void{
        if($argv == null){
            self::printMessage("erreur interne veuillez retenter");

            return;
        }

        // vérification qu'un commande ait été saisi
        if($argc < 2){
            self::printMessage("veuillez saisir une commande");

            return;
        }

        // affichage de la liste des commandes
        if($argv[1] == "--showlist"){
            foreach(self::$commands as $commandClass) self::printMessage( $commandClass->getCommandDescription() );
            
            return;
        }

        $commandClass = self::findCommandFrom($argv[1]);

        // commande non trouvé
        if($commandClass == null){
            self::printMessage("commande non trouvé - tapez --showlist pour afficher la liste des commandes");

            return;
        }

        // vérification en cas de demande d'aide
        if($argc > 2 && in_array($argv[2],["--help","-h","--h"]) ){
            self::printMessage($commandClass->getHelp() );

            return;
        }

        $command = $argv[1];
        
        $argv = array_slice($argv,2);

        self::printMessage($commandClass->execCommand($argc - 2,$argv,$command) ? "succès" : "échec");
    }

    /**
     * enregistre les commandes
     * @param array $commands (format - CommandClass::class)
     */
    public static function registerCommands(array $commands):void{
        self::$commands = [];

        // vérification de la class des commandes
        foreach($commands as $commandClass){
            if(is_subclass_of($commandClass,__CLASS__) ) array_push(self::$commands,new $commandClass() );
        }     
    }   

    /**
     * affiche le message donnée
     * @param string $message le message à afficher
     */
    public static function printMessage(string $message):void{
        echo "\nsabo >> {$message}";
    }

    /**
     * tente de trouver la class lié à la commande passé
     * @param string $argvElement la chaine commande
     * @return SaboCliCommand|null la commande ou null en cas d'échec
     */
    private static function findCommandFrom(string $argvElement):?SaboCliCommand{
        foreach(self::$commands as $commandClass){
            if($commandClass->isMyCommand($argvElement) ) return $commandClass;
        }

        return null;
    }

    /**
     * exécute la commande
     * @param int $argc taille de argv
     * @param array $argv les arguments de la ligne de commande
     * @param string $calledCommand la commande appelé
     * @return bool la réussite de la commande
     */
    public abstract function execCommand(int $argc,array $argv,string $calledCommand):bool; 

    /**
     * @return string une description de la commande
     */
    protected abstract function getCommandDescription():string; 

    /**
     * @return string l'aide de la commande
     */
    protected abstract function getHelp():string;

    /**
     * @param stirng $firstArg l'argument à vérifier
     * @return bool si la commande appartient à la class
     */
    protected abstract function isMyCommand(string $firstArg):bool;
}