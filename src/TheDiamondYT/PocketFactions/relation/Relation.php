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
namespace TheDiamondYT\PocketFactions\relation;

use pocketmine\utils\TextFormat as TF;

use TheDiamondYT\PocketFactions\Configuration;
use TheDiamondYT\PocketFactions\Faction;
use TheDiamondYT\PocketFactions\FactionMember;

class Relation {

	public static function describeTo(RelationParticipator $me, RelationParticipator $that) {
		$myFaction = self::getFaction($me);
		$thatFaction = self::getFaction($that);
		if($that instanceof Faction) {
			if($myFaction === $thatFaction) {
				$text = "your faction";
			} else {
				$text = $myFaction->getTag();
			}
		} elseif($that instanceof FactionMember) {
			if($me === $that) {
				$text = "you";
			}
		}
		return self::getColorTo($me, $that) . $text;
	}
	
	public static function getColorTo(RelationParticipator $me, RelationParticipator $that) {
		$myFaction = self::getFaction($me);
		$thatFaction = self::getFaction($that);
		if($thatFaction->getId() === "wilderness") {
			return Configuration::get("faction.default-factions.wilderness.color");
		}
		return TF::WHITE;
	}

	private static function getFaction(RelationPartipator $object) {
		if($object instanceof Faction) {
			return $object;
		}
		if($object instanceof FactionMember) {
			if($object->hasFaction()) {
				return $object->getFaction();
			}
		}
		return null;
	}
}
