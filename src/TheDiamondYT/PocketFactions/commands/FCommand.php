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

use pocketmine\command\CommandSender;

use TheDiamondYT\PocketFactions\Main;
use TheDiamondYT\PocketFactions\FPlayer;

abstract class FCommand {

    public $plugin;
    public $cfg;
    public $fme;
    
    private $name, $desc, $args;
    
    public function __construct(Main $plugin, $name, $desc, $args = "", $aliases = []) {
        $this->plugin = $plugin;
        $this->name = $name;
        $this->desc = $desc;
        $this->args = $args;
        $this->fme = new FPlayer;
        $this->cfg = $plugin->getConfig();
    }

    public function getName() {
        return $this->name;
    }
    
    public function getDescription() { 
        return $this->desc;
    }
    
    public function getUsage() {
        return "/f $this->name $this->args";
    }
    
    public function time() {
        return round(microtime(true) * 1000);
    }
    
    public function translate($string, array $params = [])  {
        return $this->plugin->getLanguage()->translateString($string, $params, null);
    }
    
    public abstract function execute(CommandSender $sender, array $args);
}
