<?php 
namespace SneakingHide;


use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerToggleSneakEvent;
use pocketmine\utils\TextFormat;
use pocketmine\entity\Effect;


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
		if($event->isSneaking()){
			   $effect= Effect::getEffect(14);
			   $effect->setDuration (600 * 20);
			   $effect->setAmplifier (10);
			   $player->addEffect($effect);
			   $player->sendMessage(TextFormat::BLUE.$player->getName()."님의 스텔스 모드가 켜졌습니다");
			} 
			elseif(!$event->isSneaking()){
		
				$player->removeEffect(14);
				
		        $player->sendMessage(TextFormat::RED.$player->getName()."님의 스텔스 모드가 꺼졌습니다");
			}
	}
}
			

?>