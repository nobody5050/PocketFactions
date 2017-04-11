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
 
namespace TheDiamondYT\PocketFactions\command;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

use TheDiamondYT\PocketFactions\PF;
use TheDiamondYT\PocketFactions\Faction;
use TheDiamondYT\PocketFactions\FPlayer;
use TheDiamondYT\PocketFactions\struct\Role;
use TheDiamondYT\PocketFactions\struct\Relation;
use TheDiamondYT\PocketFactions\event\FactionCreateEvent;

class CommandCreate extends FCommand {

    public function __construct(PF $plugin) {
        parent::__construct($plugin, "create", $plugin->translate("commands.create.description"));
        $this->setArgs("<faction name>"); 
    }

    public function execute(CommandSender $sender, $fme, array $args) {
        if(!$sender instanceof Player) {
            $this->msg($sender, TF::RED . $this->plugin->translate("commands.only-player"));
            return;
        }
        if(count($args) >= 2 or count($args) === 0) {
            $this->msg($sender, TF::RED . $this->getUsage());
            return;
        }
        if($fme->getFaction() !== null) {
            $this->msg($sender, $this->plugin->translate("player.has-faction"));
            return;
        }
        if($this->plugin->factionExists($args[0])) {
            $this->msg($sender, $this->plugin->translate("faction.tag.exists")); 
            return;
        }
        if($this->plugin->playerExists($args[0])) {
            $this->msg($sender, $this->plugin->translate("faction.tag.exists-player"));
            return;
        }
        if(!$this->alphanum($args[0])) {
            $this->msg($sender, $this->plugin->translate("faction.tag.invalid-chars"));
            return;
        }
        if(strlen($args[0]) > $this->cfg["faction"]["tag"]["maxLength"]) {
            $this->msg($sender, $this->plugin->translate("faction.tag.too-long")); 
            return;
        }
        
        $sender->getServer()->getPluginManager()->callEvent($ev = new FactionCreateEvent($sender, $args[0]));
        
        if($ev->isCancelled()) 
            return;
        
        $faction = new Faction();
        $faction->create();
        $faction->setTag($ev->getTag()); 
        
        $fme->setRole(Role::get("Leader"));
        $fme->setFaction($faction);
        
        foreach($this->plugin->getProvider()->getOnlinePlayers() as $player) 
            $this->msg($player, $this->plugin->translate("commands.create.success", [Relation::describeToPlayer($fme, $player), Relation::getColorToPlayer($fme, $player) . $ev->getTag()]));
            
        $this->msg($sender, $this->plugin->translate("commands.create.after", [($this->getCommand("desc"))->getUsage()]));
        
        if($this->cfg["faction"]["logFactionCreate"] === true)
            PF::log(TF::GRAY . $sender->getName() . " created a new faction " . $ev->getTag()); // Not even gonna do translation
    }
}
