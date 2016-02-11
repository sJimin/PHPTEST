<?php 
namespace effect\EffectName;

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
 */

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityRegainHealthEvent;
use pocketmine\network\protocol\MobEffectPacket;
use pocketmine\Player;
use pocketmine\entity\Entity;


class EffectName{
	const SPEED = 1;
	const SLOWNESS = 2;
	const HASTE = 3;
	const SWIFTNESS = 3;
	const FATIGUE = 4;
	const MINING_FATIGUE = 4;
	const STRENGTH = 5;
	//TODO: const HEALING = 6;
	//TODO: const HARMING = 7;
	const JUMP = 8;
	const NAUSEA = 9;
	const CONFUSION = 9;
	const REGENERATION = 10;
	const DAMAGE_RESISTANCE = 11;
	const FIRE_RESISTANCE = 12;
	const WATER_BREATHING = 13;
	const INVISIBILITY = 14;
	//const BLINDNESS = 15;
	//const NIGHT_VISION = 16;
	//const HUNGER = 17;
	const WEAKNESS = 18;
	const POISON = 19;
	const WITHER = 20;
	const HEALTH_BOOST = 21;
	//const ABSORPTION = 22;
	//const SATURATION = 23;
	
	/** @var Effect[] */
	protected static $effects;
	
	public static function init(){
		self::$effects = new \SplFixedByteArray(256);
	
		self::$effects[EffectName::SPEED] = new EffectName(EffectName::SPEED, "Speed", 124, 175, 198);
		self::$effects[EffectName::SLOWNESS] = new EffectName(EffectName::SLOWNESS, "Slowdown", 90, 108, 129, true);
		self::$effects[EffectName::SWIFTNESS] = new EffectName(EffectName::SWIFTNESS, ".digSpeed", 217, 192, 67);
		self::$effects[EffectName::FATIGUE] = new EffectName(EffectName::FATIGUE, "digSlowDown", 74, 66, 23, true);
		self::$effects[EffectName::STRENGTH] = new EffectName(EffectName::STRENGTH, "damageBoost", 147, 36, 35);
		//self::$effects[EffectName::HEALING] = new InstantEffect(Effect::HEALING, "%potion.heal", 248, 36, 35);
		//self::$effects[EffectName::HARMING] = new InstantEffect(Effect::HARMING, "%potion.harm", 67, 10, 9, true);
		self::$effects[EffectName::JUMP] = new EffectName(EffectName::JUMP, "jump", 34, 255, 76);
		self::$Effects[EffectName::NAUSEA] = new EffectName(EffectName::NAUSEA, "confusion", 85, 29, 74, true);
		self::$effects[EffectName::REGENERATION] = new EffectName(EffectName::REGENERATION, "regeneration", 205, 92, 171);
		self::$effects[EffectName::DAMAGE_RESISTANCE] = new EffectName(EffectName::DAMAGE_RESISTANCE, "resistance", 153, 69, 58);
		self::$effects[EffectName::FIRE_RESISTANCE] = new EffectName(EffectName::FIRE_RESISTANCE, "fireResistance", 228, 154, 58);
		self::$effects[EffectName::WATER_BREATHING] = new EffectName(EffectName::WATER_BREATHING, "waterBreathing", 46, 82, 153);
		self::$effects[EffectName::INVISIBILITY] = new EffectName(EffectName::INVISIBILITY, "invisibility", 127, 131, 146);
		//Hunger
		self::$effects[EffectName::WEAKNESS] = new EffectName(EffectName::WEAKNESS, "weakness", 72, 77, 72 , true);
		self::$effects[EffectName::POISON] = new EffectName(EffectName::POISON, "poison", 78, 147, 49, true);
		self::$effects[EffectName::WITHER] = new EffectName(EffectName::WITHER, "wither", 53, 42, 39, true);
		self::$effects[EffectName::HEALTH_BOOST] = new EffectName(EffectName::HEALTH_BOOST, "healthBoost", 248, 125, 35);
		//Absorption
		//Saturation
	}
	
	/**
	 * @param int $id
	 * @return $this
	 */
	public static function getEffect($id){
		if(isset(self::$effects[$id])){
			return clone self::$effects[(int) $id];
		}
		return null;
	}
	
	public static function getEffectByName($name){
		if(defined(EffectName::class . "::" . strtoupper($name))){
			return self::getEffect(constant(EffectName::class . "::" . strtoupper($name)));
		}
		return null;
	}
	
	/** @var int */
	protected $id;
	
	protected $name;
	
	protected $duration;
	
	protected $amplifier;
	
	protected $color;
	
	protected $show = true;
	
	protected $ambient = false;
	
	protected $bad;
	
	public function __construct($id, $name, $r, $g, $b, $isBad = false){
		$this->id = $id;
		$this->name = $name;
		$this->bad = (bool) $isBad;
		$this->setColor($r, $g, $b);
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function setDuration($ticks){
		$this->duration = $ticks;
		return $this;
	}
	
	public function getDuration(){
		return $this->duration;
	}
	
	public function isVisible(){
		return $this->show;
	}
	
	public function setVisible($bool){
		$this->show = (bool) $bool;
		return $this;
	}
	
	/**
	 * @return int
	 */
	public function getAmplifier(){
		return $this->amplifier;
	}
	
	/**
	 * @param int $amplifier
	 *
	 * @return $this
	 */
	public function setAmplifier($amplifier){
		$this->amplifier = (int) $amplifier;
		return $this;
	}
	
	public function isAmbient(){
		return $this->ambient;
	}
	
	public function setAmbient($ambient = true){
		$this->ambient = (bool) $ambient;
		return $this;
	}
	
	public function isBad(){
		return $this->bad;
	}
	
	public function canTick(){
		switch($this->id){
			case EffectName::POISON:
				if(($interval = (25 >> $this->amplifier)) > 0){
					return ($this->duration % $interval) === 0;
				}
				return true;
			case EffectName::WITHER:
				if(($interval = (50 >> $this->amplifier)) > 0){
					return ($this->duration % $interval) === 0;
				}
				return true;
			case EffectName::REGENERATION:
				if(($interval = (40 >> $this->amplifier)) > 0){
					return ($this->duration % $interval) === 0;
				}
				return true;
		}
		return false;
	}
	
	public function applyEffect(Entity $entity){
		switch($this->id){
			case EffectName::POISON:
				if($entity->getHealth() > 1){
					$ev = new EntityDamageEvent($entity, EntityDamageEvent::CAUSE_MAGIC, 1);
					$entity->attack($ev->getFinalDamage(), $ev);
				}
				break;
	
			case EffectName::WITHER:
				$ev = new EntityDamageEvent($entity, EntityDamageEvent::CAUSE_MAGIC, 1);
				$entity->attack($ev->getFinalDamage(), $ev);
				break;
	
			case EffectName::REGENERATION:
				if($entity->getHealth() < $entity->getMaxHealth()){
					$ev = new EntityRegainHealthEvent($entity, 1, EntityRegainHealthEvent::CAUSE_MAGIC);
					$entity->heal($ev->getAmount(), $ev);
				}
				break;
		}
	}
	
	public function getColor(){
		return [$this->color >> 16, ($this->color >> 8) & 0xff, $this->color & 0xff];
	}
	
	public function setColor($r, $g, $b){
		$this->color = (($r & 0xff) << 16) + (($g & 0xff) << 8) + ($b & 0xff);
	}
	
	public function add(Entity $entity, $modify = false){
		if($entity instanceof Player){
			$pk = new MobEffectPacket();
			$pk->eid = 0;
			$pk->effectId = $this->getId();
			$pk->amplifier = $this->getAmplifier();
			$pk->particles = $this->isVisible();
			$pk->duration = $this->getDuration();
			if($modify){
				$pk->eventId = MobEffectPacket::EVENT_MODIFY;
			}else{
				$pk->eventId = MobEffectPacket::EVENT_ADD;
			}
	
			$entity->dataPacket($pk);
		}
	
		if($this->id === EffectName::INVISIBILITY){
			$entity->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_INVISIBLE, true);
			$entity->setDataProperty(Entity::DATA_SHOW_NAMETAG, Entity::DATA_TYPE_BYTE, 0);
		}
	}
	
	public function remove(Entity $entity){
		if($entity instanceof Player){
			$pk = new MobEffectPacket();
			$pk->eid = 0;
			$pk->eventId = MobEffectPacket::EVENT_REMOVE;
			$pk->effectId = $this->getId();
	
			$entity->dataPacket($pk);
		}
	
		if($this->id === EffectName::INVISIBILITY){
			$entity->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_INVISIBLE, false);
			$entity->setDataProperty(Entity::DATA_SHOW_NAMETAG, Entity::DATA_TYPE_BYTE, 1);
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}









































?>