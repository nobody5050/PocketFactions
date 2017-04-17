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
    /* @var PF */
    public $plugin;
    /* @var array */
    public $cfg;
    
    /* @var string */
    private $name, $desc, $cmdArgs;
    /* @var array */
    private $aliases = [];
    
    /* @var CommandSender */
    public $sender;
    /* @var IPlayer */
    public $fme;
    /* @var array */
    public $args = [];
    
    /* @var bool */
    public $senderMustBePlayer = false;
    public $senderMustBeOperator = false;
    public $senderMustBeLeader = false;
    public $senderMustHaveFaction = false;
    
    public function __construct(PF $plugin, $name, $desc, $aliases = []) {
        $this->plugin = $plugin;
        $this->name = $name;
        $this->desc = $desc;
        $this->aliases = $aliases;
        $this->cfg = $plugin->getConfig(); 
    }
    
    /**
     * Returns the command name.
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }
    
    /** 
     * Returns the command description.
     *
     * @return string
     */
    public function getDescription() { 
        return $this->desc;
    }
   
    /**
     * Returns the command name and arguments.
     *
     * @return string
     */
    public function getUsage() {
        return TF::AQUA . "/f $this->name " . TF::DARK_AQUA . $this->cmdArgs;
    }
    
    /**
     * Add a required argument for the command.
     *
     * @param string
     */
    public function addRequiredArgument(string $arg) {
        $this->cmdArgs .= "<" . $arg . "> ";
    }
    
    /**
     * Add an optional argument for the command.
     *
     * @param string
     */
    public function addOptionalArgument(string $arg) {
        $this->cmdArgs .= "[" . $arg . "] ";
    }
    
    /**
     * Returns the command aliases.
     *
     * @return array 
     */
    public function getAliases() {
        return $this->aliases;
    }
    
    /**
     * Convienient method for sending a message to a player.
     *
     * @param string 
     */
    public function msg(string $text) {                   
        $this->sender->sendMessage(TextUtil::parse($text));
    }
    
    /**
     * Convienient method to get a faction command.
     *
     * @param string
     * @return FCommand|null
     */
    public function getCommand(string $label) {
        return $this->plugin->getCommandManager()->getCommand($label);
    }
    
    /**
     * Sets up variables and does command checks, then performs the command.
     *
     * @param CommandSender 
     * @param IPlayer    
     * @param array   
     *
     * @see FCommandManager
     */
    public function execute(CommandSender $sender, $fme, array $args) {
        $this->sender = $sender;
        if($sender instanceof ConsoleCommandSender) {
            $this->fme = new FConsole($this->plugin); 
        } else {
            $this->fme = $fme;
        }
        $this->args = $args;   
        
        if($this->senderMustBePlayer === true && $sender instanceof ConsoleCommandSender) {
            $this->msg($this->plugin->translate("commands.only-player"));
            return;
        }
        if($this->senderMustBeOperator === true && !$sender->isOp()) {
            // TODO
        }
        if($this->senderMustHaveFaction === true && !$this->fme->hasFaction()) {
            $this->msg($this->plugin->translate("player.no-faction"));
            return;
        }
        if($this->senderMustBeLeader === true && !$fme->isLeader()) {
            $this->msg($this->plugin->translate("commands.only-leader"));
            return;
        }
        
        $this->perform($this->fme, $args);
    }
}
