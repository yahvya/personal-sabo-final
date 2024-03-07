<?php

namespace SaboCore\Cli\Cli;

use BeBat\ConsoleColor\Style\Color;
use SaboCore\Cli\Commands\SaboCommand;
use SaboCore\Cli\Theme\Theme;
use SaboCore\Config\Config;
use SaboCore\Utils\Printer\Printer;
use Throwable;

/**
 * @brief Gestionnaire de commande du framework
 * @author yahaya bathily https://github.com/yahvya/
 */
class SaboCli{
    /**
     * @var ArgumentManager gestionnaire d'arguments
     */
    protected ArgumentManager $argumentManager;

    /**
     * @var Config configuration de thème
     */
    protected Config $themeConfig;

    /**
     * @var array<string,SaboCommand> commandes
     */
    protected array $commands = [];

    /**
     * @param string[] $argv arguments de la ligne de commande
     * @param Config $themeConfig configuration de thème
     */
    public function __construct(array $argv,Config $themeConfig){
        $this->argumentManager = new ArgumentManager($argv);
        $this->themeConfig = $themeConfig;
    }

    /**
     * @brief Enregistre une commande
     * @param SaboCommand $executor class d'exécution de la commande
     * @return $this
     */
    public function registerCommand(SaboCommand $executor):SaboCli{
        $this->commands[$executor->getName()] = $executor;

        return $this;
    }

    /**
     * @return SaboCommand[] les commandes
     */
    public function getCommands():array{
        return $this->commands;
    }

    /**
     * @return Config la configuration du thème
     */
    public function getThemeConfig():Config{
        return $this->themeConfig;
    }

    /**
     * @brief Lance l'exécution du traitement cli
     * @return void
     */
    public function start():void{
        try{
            // recherche et exécution de la commande
            $command = $this->argumentManager->next();

            if($command == null){
                Printer::printStyle(
                    "Veuillez saisir la commande à lancer",
                    $this->themeConfig->getConfig(Theme::IMPORTANT_ERROR_STYLE->value)
                );
                return;
            }

            if(!array_key_exists($command,$this->commands) ){
                Printer::printStyle(
                    "Commande non trouvé, pensez à utilisez (help)",
                    $this->themeConfig->getConfig(Theme::BASIC_ERROR_STYLE->value)
                );
                return;
            }

            // exécution de la commande
            $this->commands[$command]->execCommand($this);
        }
        catch(Throwable){
            Printer::print("Echec d'exécution de la commande", Color::Red);
        }
    }
}