<?php

namespace TheDiamondYT\PocketFactions\commands;

use pocketmine\command\CommandSender;

use TheDiamondYT\PocketFactions\Main;

abstract class FCommand {

    public $plugin;
    
    private $name, $desc, $usage;
    
    public function __construct(Main $plugin, $name, $desc, $usage, $aliases = []) {
        $this->plugin = $plugin;
        $this->name = $name;
        $this->desc = $desc;
        $this->usage = $usage;
    }

    public function getName() {
        return $this->name;
    }
    
    public function getDescription() { 
        return $this->desc;
    }
    
    public function getUsage() {
        return $this->usage;
    }
    
    public abstract function execute(CommandSender $sender, array $args);
}
