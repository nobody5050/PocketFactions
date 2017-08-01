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
namespace TheDiamondYT\PocketFactions\util;

use TheDiamondYT\PocketFactions\entity\FactionRole;

class RoleUtil {
	private static $roles = [];

	public static function init() {
		self::addRole(new FactionRole(100, "Member"));
		self::addRole(new FactionRole(200, "Moderator", ["Mod"]));
		self::addRole(new FactionRole(300, "Administrator", ["Admin"]));
		self::addRole(new FactionRole(400, "Leader"));
	}
	
	public static function addRole(FactionRole $role) {
		self::$roles[$role->getId()] = $role;
	}
	
	public static function getRoleByName(string $name) {
		foreach(self::$roles as $role) {
			if(strtolower($role->getName()) === strtolower($name)) {
				return $role;
			}
		}
		return null;
	}
}
