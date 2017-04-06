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
 * PocketFactions v1.0.1 by Luke (TheDiamondYT)
 * All rights reserved.                         
 */
 
namespace TheDiamondYT\PocketFactions\commands;

use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat as TF;

use TheDiamondYT\PocketFactions\PF;
use TheDiamondYT\PocketFactions\FPlayer;
use TheDiamondYT\PocketFactions\Faction;

abstract class FCommand {

    public $plugin;
    public $cfg;
    
    private $sender;
    
    private $name, $desc, $args;
    private $aliases = [];
    
    public function __construct(PF $plugin, $name, $desc, $aliases = []) {
        $this->plugin = $plugin;
        $this->cfg = $plugin->getConfig();
        $this->name = $name;
        $this->desc = $desc;
        $this->aliases = $aliases;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }
    
    /** 
     * @return string
     */
    public function getDescription() { 
        return $this->desc;
    }
   
    /**
     * @return string
     */
    public function getUsage() {
        return TF::AQUA . "/f $this->name " . TF::DARK_AQUA . $this->args;
    }
    
    /**
     * Set the command arguments. TODO: remove
     *
     * @param string
     */
    public function setArgs(string $args) {
        $this->args = $args; 
    }
    
    /**
     * @return array
     */
    public function getAliases() {
        return $this->aliases;
    }
    
    /**
     * Convienient method for sending a message to a player
     *
     * @param CommandSender|Player 
     * @param string 
     */
    public function msg($player, string $text) {
        if($player instanceof FPlayer) {
            $player->msg(TF::YELLOW . $text);
        } else {
            $player->sendMessage(TF::YELLOW . $text);
        }
    }
    
    public function getCommand(string $label) {
        return $this->plugin->getCommandManager()->getCommand($label);
    }
    
    public abstract function execute(CommandSender $sender, $fme, array $args);
}
