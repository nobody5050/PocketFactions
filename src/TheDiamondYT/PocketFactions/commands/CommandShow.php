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
use TheDiamondYT\PocketFactions\struct\Role;
use TheDiamondYT\PocketFactions\struct\Relation;

class CommandShow extends FCommand {

    private $sender;

    public function __construct(PF $plugin) {
        parent::__construct($plugin, "show", $plugin->translate("show.desc"), ["who"]);
    }

    public function execute(CommandSender $sender, $fme, array $args) {
       // if(!$sender instanceof Player) {
       //     $this->msg($sender, $this->plugin->translate("command.mustbeplayer"));
       //     return;
       // }
        $this->sender = $sender;
        $faction = $fme->getFaction();
        if(!empty($args)) {
            $faction = $this->plugin->getFaction($args[0]); // check for faction
            if($faction === null)  {
                $faction = ($p = $this->plugin->getPlayer($args[0]))->getFaction(); // check for player
                if($p === null)
                    $faction = $fme->getFaction();  // just return our faction if not found
            }
        }    
        $long = $this->cfg["faction"]["show"]["longHeader"];
        $this->msg($sender, $this->plugin->translate($long ? "show.header.long" : "show.header", [Relation::getColorToFaction($fme, $faction) . $faction->getTag()]));
        
        $this->add("Description", $faction->getDescription());
        $this->add("Joining", $faction->isOpen() ? "no invitation needed" : "invitation is required");
    }
    
    private function add(string $key, string $value) {
        $this->msg($this->sender, TF::GOLD . "$key: " . TF::YELLOW . $value);
    }
}
