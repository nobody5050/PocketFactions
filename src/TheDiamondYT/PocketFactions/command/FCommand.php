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
use pocketmine\command\ConsoleCommandSender;
use pocketmine\utils\TextFormat as TF;

use TheDiamondYT\PocketFactions\PF;
use TheDiamondYT\PocketFactions\entity\IPlayer;
use TheDiamondYT\PocketFactions\entity\FConsole;
use TheDiamondYT\PocketFactions\entity\Faction;
use TheDiamondYT\PocketFactions\util\TextUtil;

abstract class FCommand {

    public $plugin;
    public $cfg;
    
    private $name, $desc, $cmdArgs;
    private $aliases = [];
    
    public $sender;
    public $fme;
    public $args = [];
    
    public $senderMustBePlayer = false;
    public $senderMustBeLeader = false;
    
    public function __construct(PF $plugin, $name, $desc, $aliases = []) {
        $this->plugin = $plugin;
        $this->name = $name;
        $this->desc = $desc;
        $this->aliases = $aliases;
        $this->cfg = $plugin->getConfig(); 
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
        return TF::AQUA . "/f $this->name " . TF::DARK_AQUA . $this->cmdArgs;
    }
    
    /**
     * @param string
     */
    public function addRequiredArgument(string $arg) {
        $this->cmdArgs .= "<" . $arg . "> ";
    }
    
    /**
     * @param string
     */
    public function addOptionalArgument(string $arg) {
        $this->cmdArgs .= "[" . $arg . "] ";
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
     * @param string 
     */
    public function msg(string $text) {  
        $this->sender->sendMessage(TextUtil::parse($text));
    }
    
    /**
     * @param string
     * @return FCommand|null
     */
    public function getCommand(string $label) {
        return $this->plugin->getCommandManager()->getCommand($label);
    }
    
    public function execute(CommandSender $sender, $fme, array $args) {
        $this->sender = $sender;
        if($sender instanceof ConsoleCommandSender) {
            $this->fme = new FConsole($this->plugin); 
        } else {
            $this->fme = $fme;
        }
        $this->args = $args;   
        
        if($this->senderMustBePlayer && $sender instanceof ConsoleCommandSender) {
            $this->msg(TextUtil::parse($this->plugin->translate("commands.only-player")));
            return;
        }
        
        $this->perform($this->fme, $args);
    }
}
