<?php
/*
 *  _____           _        _   ______         _   _                 
 * |  __ \         | |      | | |  ____|       | | (_)                
 * | |__) |__   ___| | _____| |_| |__ __ _  ___| |_ _  ___  _ __  ___ 
 * |  ___/ _ \ / __| |/ / _ \ __|  __/ _` |/ __| __| |/ _ \| '_ \/ __|
 * | |  | (_) | (__|   <  __/ |_| | | (_| | (__| |_| | (_) | | | \__ \
 * |_|   \___/ \___|_|\_\___|\__|_|  \__,_|\___|\__|_|\___/|_| |_|___/
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.     
 *
 * PocketFactions v1.0.0 by Luke (TheDiamondYT)
 * All rights reserved.                         
 */
 
namespace TheDiamondYT\PocketFactions\commands;

use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;

use TheDiamondYT\PocketFactions\Main;

class FCommandManager extends PluginCommand {

    private $plugin;
    private $sender;

    public function __construct(Main $plugin) {
        parent::__construct("factions", $plugin); 
        $this->setAliases(["faction", "fac", "f"]);
        $this->setDescription("The main command for PocketFactions."); // TODO: Translation
        $this->registerCommand(new CommandCreate($plugin));
        $this->registerCommand(new CommandVersion($plugin));
        $this->registerCommand(new CommandReload($plugin));
    }
    
    public function execute(CommandSender $sender, $label, array $args) {
        $this->sender = $sender;
        if(count($args) > 0) {
            $subcommand = strtolower(array_shift($args));
            if(isset($this->subcommands[$subcommand])) {
                $command = $this->subcommands[$subcommand];
            } else {
                //TODO: Translation
                return true;
            }
            $command->execute($sender, $args);
        }
    }
    
    public function registerCommand(FCommand $command) {
        $this->subcommands[$command->getName()] = $command;
    }
}     
