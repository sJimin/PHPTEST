<?php

namespace effect;

use effect\database\PluginData;
use effect\listener\EventListener;
use effect\listener\other\ListenerLoader;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use effect\EffectName\EffectName;
use pocketmine\utils\TextFormat;
use pocketmine\event\block\SignChangeEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\block\Block;
use pocketmine\tile\Sign;
use pocketmine\entity\Effect;

class effect extends PluginBase implements Listener {
	private $database;
	private $eventListener;
	private $listenerLoader;
	
	public function onEnable() {
		$this->database = new PluginData( $this );
		$this->eventListener = new EventListener ( $this );
		$this->listenerLoader = new ListenerLoader ( $this );
		$this->getServer ()->getPluginManager ()->registerEvents ( $this, $this );
		$pdFile=$this->getDescription();
		$this->getLogger()->info(TextFormat::RED.$pdFile->getName()." 버전 ".$pdFile->getVersion()."이(가) 활성화 되었습니다.");
		EffectName::init();
	}
	
	public function onDisable() {
		$this->save ();
		$pdFile=$this->getDescription();
		$this->getLogger()->info(TextFormat::BLUE.$pdFile->getName()." 버전 ".$pdFile->getVersion()."이(가) 종료되었습니다.");		
	}
	
	public function save($async = false) {
		$this->database->save ( $async );
	}
	
	public function onCommand(CommandSender $sender, Command $command, $label, array $args) {
		return $this->eventListener->onCommand ( $sender, $command, $label, $args );
	}

	public function getDataBase() {
		return $this->database;
	}
	
	public function getEventListener() {
		return $this->eventListener;
	}
	
	public function getListenerLoader() {
		return $this->listenerLoader;
	}
	
	public function onSignChange(SignChangeEvent $event){
		$getLine0=$event->getLine(0);
		$getLine1=$event->getLine(1);
		$player=$event->getPlayer();
		$effectType=array("1","2","3","4","5","8","9","10","11","12","13","14","18","19","20","21");
		foreach ($effectType as $effectArray){
			if($getLine0=="effect"&&$getLine1==$effectArray) //speed
			{
				$event->setLine(0,"-----------");
				$event->setLine(1,TextFormat::RED."[E".TextFormat::GOLD."f".TextFormat::YELLOW."f".TextFormat::GREEN."e".TextFormat::BLUE."c".TextFormat::DARK_PURPLE."t]");
				$event->setLine(2,TextFormat::AQUA.EffectName::getEffect($effectArray)->getName());
				$event->setLine(3,"-----------");
			}
			if($getLine0=="effect"&&$getLine1=="remove"){
				$event->setLine(0,"-----------");
				$event->setLine(1,TextFormat::RED."[E".TextFormat::GOLD."f".TextFormat::YELLOW."f".TextFormat::GREEN."e".TextFormat::BLUE."c".TextFormat::DARK_PURPLE."t]");
				$event->setLine(2,TextFormat::AQUA."효과제거");
				$event->setLine(3,"-----------");
			}
		}
	}
	public function onTouch(PlayerInteractEvent $event){
		$player=$event->getPlayer();
		if ($event->getBlock ()->getId () == Block::SIGN_POST or $event->getBlock ()->getId () == Block::WALL_SIGN){
			$tile = $event->getBlock ()->getLevel ()->getTile ( $event->getBlock () );
			if ($tile instanceof Sign) {
				$text = $tile->getText ();
				/*
				 if($text[0]=="-----------"&&$text[0]==TextFormat::RED."[E".TextFormat::GOLD."f".TextFormat::YELLOW."f".TextFormat::GREEN."e".TextFormat::BLUE."c".TextFormat::DARK_PURPLE."t]"&&$text[2]==TextFormat::AQUA."신속"&&$text[3]=="-----------"){
				 $effect= Effect::getEffect(1);
				 $effect->setDuration (300 * 20);
				 $effect->setAmplifier (3);
				 $player->addEffect($effect);
				 }
				 */
				//TODO 신속
				/*
				 if($text[0]=="-----------"&&$text[0]==TextFormat::RED."[E".TextFormat::GOLD."f".TextFormat::YELLOW."f".TextFormat::GREEN."e".TextFormat::BLUE."c".TextFormat::DARK_PURPLE."t]"&&$text[2]==TextFormat::AQUA."구속"&&$text[3]=="-----------"){
				 $effect= Effect::getEffect(2);
				 $effect->setDuration (300 * 20);
				 $effect->setAmplifier (3);
				 $player->addEffect($effect);
				 }
				 */
				//TODO 구속
				if($text[0]=="-----------"&&$text[1]==TextFormat::RED."[E".TextFormat::GOLD."f".TextFormat::YELLOW."f".TextFormat::GREEN."e".TextFormat::BLUE."c".TextFormat::DARK_PURPLE."t]"&&$text[2]==TextFormat::AQUA."성급함"&&$text[3]=="-----------"){
					$effect= Effect::getEffect(3);
					$effect->setDuration (300 * 20);
					$effect->setAmplifier (3);
					$player->addEffect($effect);
				}
				if($text[0]=="-----------"&&$text[1]==TextFormat::RED."[E".TextFormat::GOLD."f".TextFormat::YELLOW."f".TextFormat::GREEN."e".TextFormat::BLUE."c".TextFormat::DARK_PURPLE."t]"&&$text[2]==TextFormat::AQUA."피로"&&$text[3]=="-----------"){
					$effect= Effect::getEffect(4);
					$effect->setDuration (300 * 20);
					$effect->setAmplifier (3);
					$player->addEffect($effect);
				}
				if($text[0]=="-----------"&&$text[1]==TextFormat::RED."[E".TextFormat::GOLD."f".TextFormat::YELLOW."f".TextFormat::GREEN."e".TextFormat::BLUE."c".TextFormat::DARK_PURPLE."t]"&&$text[2]==TextFormat::AQUA."힘강화"&&$text[3]=="-----------"){
					$effect= Effect::getEffect(5);
					$effect->setDuration (300 * 20);
					$effect->setAmplifier (3);
					$player->addEffect($effect);
				}
				if($text[0]=="-----------"&&$text[1]==TextFormat::RED."[E".TextFormat::GOLD."f".TextFormat::YELLOW."f".TextFormat::GREEN."e".TextFormat::BLUE."c".TextFormat::DARK_PURPLE."t]"&&$text[2]==TextFormat::AQUA."점프강화"&&$text[3]=="-----------"){
					$effect= Effect::getEffect(8);
					$effect->setDuration (300 * 20);
					$effect->setAmplifier (4);
					$player->addEffect($effect);
				}
				if($text[0]=="-----------"&&$text[1]==TextFormat::RED."[E".TextFormat::GOLD."f".TextFormat::YELLOW."f".TextFormat::GREEN."e".TextFormat::BLUE."c".TextFormat::DARK_PURPLE."t]"&&$text[2]==TextFormat::AQUA."멀미"&&$text[3]=="-----------"){
					$effect= Effect::getEffect(9);
					$effect->setDuration (300 * 20);
					$effect->setAmplifier (1);
					$player->addEffect($effect);
				}
				if($text[0]=="-----------"&&$text[1]==TextFormat::RED."[E".TextFormat::GOLD."f".TextFormat::YELLOW."f".TextFormat::GREEN."e".TextFormat::BLUE."c".TextFormat::DARK_PURPLE."t]"&&$text[2]==TextFormat::AQUA."재생"&&$text[3]=="-----------"){
					$effect= Effect::getEffect(10);
					$effect->setDuration (300 * 20);
					$effect->setAmplifier (3);
					$player->addEffect($effect);
				}
				if($text[0]=="-----------"&&$text[1]==TextFormat::RED."[E".TextFormat::GOLD."f".TextFormat::YELLOW."f".TextFormat::GREEN."e".TextFormat::BLUE."c".TextFormat::DARK_PURPLE."t]"&&$text[2]==TextFormat::AQUA."저항"&&$text[3]=="-----------"){
					$effect= Effect::getEffect(11);
					$effect->setDuration (300 * 20);
					$effect->setAmplifier (3);
					$player->addEffect($effect);
				}
				if($text[0]=="-----------"&&$text[1]==TextFormat::RED."[E".TextFormat::GOLD."f".TextFormat::YELLOW."f".TextFormat::GREEN."e".TextFormat::BLUE."c".TextFormat::DARK_PURPLE."t]"&&$text[2]==TextFormat::AQUA."화염저항"&&$text[3]=="-----------"){
					$effect= Effect::getEffect(12);
					$effect->setDuration (300 * 20);
					$effect->setAmplifier (3);
					$player->addEffect($effect);
				}
				if($text[0]=="-----------"&&$text[1]==TextFormat::RED."[E".TextFormat::GOLD."f".TextFormat::YELLOW."f".TextFormat::GREEN."e".TextFormat::BLUE."c".TextFormat::DARK_PURPLE."t]"&&$text[2]==TextFormat::AQUA."수중호흡"&&$text[3]=="-----------"){
					$effect= Effect::getEffect(13);
					$effect->setDuration (300 * 20);
					$effect->setAmplifier (3);
					$player->addEffect($effect);
				}
				if($text[0]=="-----------"&&$text[1]==TextFormat::RED."[E".TextFormat::GOLD."f".TextFormat::YELLOW."f".TextFormat::GREEN."e".TextFormat::BLUE."c".TextFormat::DARK_PURPLE."t]"&&$text[2]==TextFormat::AQUA."투명화"&&$text[3]=="-----------"){
					$effect= Effect::getEffect(14);
					$effect->setDuration (300 * 20);
					$effect->setAmplifier (3);
					$player->addEffect($effect);
				}
				if($text[0]=="-----------"&&$text[1]==TextFormat::RED."[E".TextFormat::GOLD."f".TextFormat::YELLOW."f".TextFormat::GREEN."e".TextFormat::BLUE."c".TextFormat::DARK_PURPLE."t]"&&$text[2]==TextFormat::AQUA."나약함"&&$text[3]=="-----------"){
					$effect= Effect::getEffect(18);
					$effect->setDuration (300 * 20);
					$effect->setAmplifier (3);
					$player->addEffect($effect);
				}
				if($text[0]=="-----------"&&$text[1]==TextFormat::RED."[E".TextFormat::GOLD."f".TextFormat::YELLOW."f".TextFormat::GREEN."e".TextFormat::BLUE."c".TextFormat::DARK_PURPLE."t]"&&$text[2]==TextFormat::AQUA."독"&&$text[3]=="-----------"){
					$effect= Effect::getEffect(19);
					$effect->setDuration (300 * 20);
					$effect->setAmplifier (3);
					$player->addEffect($effect);
				}
				if($text[0]=="-----------"&&$text[1]==TextFormat::RED."[E".TextFormat::GOLD."f".TextFormat::YELLOW."f".TextFormat::GREEN."e".TextFormat::BLUE."c".TextFormat::DARK_PURPLE."t]"&&$text[2]==TextFormat::AQUA."위더"&&$text[3]=="-----------"){
					$effect= Effect::getEffect(20);
					$effect->setDuration (300 * 20);
					$effect->setAmplifier (3);
					$player->addEffect($effect);
				}
				/* if($text[0]=="-----------"&&$text[1]==TextFormat::RED."[E".TextFormat::GOLD."f".TextFormat::YELLOW."f".TextFormat::GREEN."e".TextFormat::BLUE."c".TextFormat::DARK_PURPLE."t]"&&$text[2]==TextFormat::AQUA."체력신장"&&$text[3]=="-----------"){
				 $effect= Effect::getEffect(21);
				 $effect->setDuration (300 * 20);
				 $effect->setAmplifier (3);
				 $player->addEffect($effect);
				 }  */
				//TODO 체력신장
				if($text[0]=="-----------"&&$text[1]==TextFormat::RED."[E".TextFormat::GOLD."f".TextFormat::YELLOW."f".TextFormat::GREEN."e".TextFormat::BLUE."c".TextFormat::DARK_PURPLE."t]"&&$text[2]==TextFormat::AQUA."효과제거"&&$text[3]=="-----------"){
					$player->removeAllEffects();
				}
			}
		}
	}
	
	
}

?>