<?php 
namespace SneakingHide;


use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerToggleSneakEvent;
use pocketmine\utils\TextFormat;
use pocketmine\event\block\SignChangeEvent;


class SneakingHide extends PluginBase implements Listener{
	
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$pdFile=$this->getDescription();
		$this->getLogger()->info(TextFormat::RED.$pdFile->getName()." 버전 ".$pdFile->getVersion()."이(가) 활성화 되었습니다.");
	}
	
	public function onDisable(){
		$pdFile=$this->getDescription();
		$this->getLogger()->info(TextFormat::BLUE.$pdFile->getName()." 버전 ".$pdFile->getVersion()."이(가) 종료되었습니다.");
	}
	
	public function onHide(PlayerToggleSneakEvent $event){
		$player=$event->getPlayer();
		foreach($player->getLevel()->getPlayers() as $p){
		if($event->isSneaking()){
			$p->hidePlayer($player);
			if($p==$player){
			   $player->sendMessage(TextFormat::BLUE."스텔스 모드가 켜졌습니다");
			}
			else{
				$p->showPlayer($player);
				if($p==$player)
					$player->sendMessage(TextFormat::BLUE."스텔스 모드가 꺼졌습니다");
			}
		}
		}
	}
	
	public function onSignChange(SignChangeEvent $event){
		$player=$event->getPlayer();
		if($event->getLine(0)=="Hide"){
			$player->hidePlayer($player);
			$player->sendMessage(TextFormat::BLUE."스텔스 모드가 켜졌습니다");
			
		}
		}
}
			
	

?>