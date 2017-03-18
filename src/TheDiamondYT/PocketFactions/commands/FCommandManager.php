<?php

namespace TheDiamondYT\PocketFactions\commands;

use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;

use TheDiamondYT\PocketFactions\Main;

class FCommandManager extends PluginCommand {

    private $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("f", $plugin); //TODO: Aliases and shite
        $this->registerCommand(new TestCommand($plugin));
    }
    
    public function execute(CommandSender $sender, $label, array $args) {
        if(count($args) > 0) {
            $subcommand = strtolower(array_shift($args));
            if(isset($this->subcommands[$subcommand])) {
                $command = $this->subcommands[$subcommand];
            } else {
                //TODO: Translation
                return true;
            }
            if(!$command->execute($sender, $args)) {
                //TODO: Translation
            }
        }
    }
    
    public function registerCommand(FCommand $command) {
        $this->subcommands[$command->getName()] = $command;
    }
}     
