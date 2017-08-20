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
 * PocketFactions by Luke (TheDiamondYT)
 * All rights reserved.
 */
namespace TheDiamondYT\PocketFactions\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;

use TheDiamondYT\PocketFactions\Loader;
use TheDiamondYT\PocketFactions\entity\FactionConsole;

class Registry extends Command implements PluginIdentifiableCommand {
	/** @var FactionCommand[] */
	private $commands;
	
	/** @var Loader */
	private $loader;
	
	public function __construct(Loader $loader) {
		parent::__construct("faction", $loader);
		$this->setAliases(["fac", "f"]);
		$this->loader = $loader;
		
		$this->registerCommand(new CreateCommand($loader));
		$this->registerCommand(new DescriptionCommand($loader));
		$this->registerCommand(new HelpCommand($loader));
		$this->registerCommand(new MotdCommand($loader));
		$this->registerCommand(new TitleCommand($loader));
		$this->registerCommand(new VersionCommand($loader));
	}
	
	public function execute(CommandSender $sender, $label, array $args) {
		$player = $sender instanceof Player ? $this->getLoader()->getPlayer($sender->getName()) : new FactionConsole($sender);
		if(count($args) > 0) {
			$command = strtolower(array_shift($args));
			if(isset($this->commands[$command])) {
				$command = $this->commands[$command];
			} else {
				$sender->sendMessage($this->getLoader()->translate("commands.not-found", [$command]));
				return true;
			}
			$command->perform($player, $args);
		} else {
			$this->getCommand("help")->perform($player, $args);
		}
		return true;
	}
	
	public function registerCommand(FactionCommand $command) {
		if(isset($this->commands[$command->getName()])) {
			throw new \RuntimeException("Failed to register command \"{$command->getName()}\", command already registered.");
		}
		$this->commands[$command->getName()] = $command;
	}
	
	public function getCommands(): array {
		return $this->commands;
	}
	
	public function getCommand(string $name) {
		foreach($this->commands as $command) {
			if($command->getName() === $name) {
				return $command;
			}
		}
		return null;
	}
	
	protected function getLoader(): Loader {
		return $this->loader;
	}
	
	public function getPlugin(): Loader {
		return $this->loader;
	}
}
