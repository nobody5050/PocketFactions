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
namespace TheDiamondYT\PocketFactions\commands;

use TheDiamondYT\PocketFactions\Loader;

abstract class FactionCommand {
	/** @var string */
	private $name;
	
	/** @var Loader */
	private $loader;
	
	public function __construct(Loader $loader, string $name) {
		$this->loader = $loader;
		$this->name = $name;
	} 
	
	public function getName(): string {
		return $this->name;
	}
	
	// TODO: better solution
	public abstract function getArguments(): string;
	
	public function getUsage(): string {
		return $this->getLoader()->translate("templates.command-usage", [
			$this->getName(),
			$this->getArguments()
		]);
	}
	
	protected function getLoader(): Loader {
		return $this->loader;
	}
}
