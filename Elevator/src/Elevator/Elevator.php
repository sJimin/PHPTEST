<?php 
namespace Elevator;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\event\block\SignChangeEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\block\Block;
use pocketmine\tile\Sign;
use pocketmine\math\Vector3;



class Elevator extends PluginBase implements Listener{
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$pdFile=$this->getDescription();
		$this->getLogger()->info(TextFormat::RED.$pdFile->getName()." 버전 ".$pdFile->getVersion()."이(가) 활성화 되었습니다.");
	    
	}
	
	public function onDisable(){
		$pdFile=$this->getDescription();
		$this->getLogger()->info(TextFormat::BLUE.$pdFile->getName()." 버전 ".$pdFile->getVersion()."이(가) 종료되었습니다.");
	}
	
	public function onCommand(CommandSender $sender,Command $command, $label,array $args){
		if($sender->hasPermission("엘베")){
			if(!isset($args[0])){
				$sender->sendMessage(TextFormat::AQUA."첫줄:엘레베이터");
				$sender->sendMessage(TextFormat::AQUA."두번쨰줄:상승|하강");
				$sender->sendMessage(TextFormat::AQUA."터치로 상승하강 5칸");
			}
		}
	}
	//명령어로 높이 조절
	
	public function SignChangedEvent(SignChangeEvent $event){					
		if ($event->getLine(0)==="엘레베이터"&&$event->getLine(1)==="상승"){
			$event->setLine(0,TextFormat::GOLD."==========");
			$event->setLine(1,TextFormat::RED."[엘".TextFormat::GOLD."레".TextFormat::YELLOW."베".TextFormat::GREEN."이".TextFormat::BLUE."터]");
			$event->setLine(2,TextFormat::RED."↑↑상승↑↑");
			$event->setLine(3,TextFormat::GOLD."==========");
		}
		if ($event->getLine(0)=="엘레베이터"&&$event->getLine(1)=="하강"){
			$event->setLine(0,TextFormat::GOLD."==========");
			$event->setLine(1,TextFormat::RED."[엘".TextFormat::GOLD."레".TextFormat::YELLOW."베".TextFormat::GREEN."이".TextFormat::BLUE."터]");
			$event->setLine(2,TextFormat::RED."↓↓하강↓↓");
			$event->setLine(3,TextFormat::GOLD."==========");
		}
		}
		
	
	//표지판 터치시 일정 높이로 올라가거나 내려감 
	
	//엘레베이터
	// 상승 or 하강
	
	public function onTouch(PlayerInteractEvent $event){	
			$player=$event->getPlayer();
			if ($event->getBlock ()->getId () == Block::SIGN_POST or $event->getBlock ()->getId () == Block::WALL_SIGN){
				$tile = $event->getBlock ()->getLevel ()->getTile ( $event->getBlock () );
				if ($tile instanceof Sign) {
					$text = $tile->getText ();
				   if($text[0]==TextFormat::GOLD."=========="&&$text[1]==TextFormat::RED."[엘".TextFormat::GOLD."레".TextFormat::YELLOW."베".TextFormat::GREEN."이".TextFormat::BLUE."터]"&&$text[2]==TextFormat::RED."↑↑상승↑↑"&&$text[3]==TextFormat::GOLD."=========="){
				   	$x=$player->getFloorX();
				   	$y=$player->getFloorY();
				   	$z=$player->getFloorZ();
				   	$player->teleport(new Vector3($x,$y+6,$z));
				   	
				   }
				   if($text[0]==TextFormat::GOLD."=========="&&$text[1]==TextFormat::RED."[엘".TextFormat::GOLD."레".TextFormat::YELLOW."베".TextFormat::GREEN."이".TextFormat::BLUE."터]"&&$text[2]==TextFormat::RED."↓↓하강↓↓"&&$text[3]==TextFormat::GOLD."=========="){
				   	$x=$player->getFloorX();
				   	$y=$player->getFloorY();
				   	$z=$player->getFloorZ();		   
				   $player->teleport(new Vector3($x,$y-5,$z));
				   }
				}
			}
	}
}

	
			














?>