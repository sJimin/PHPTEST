<?php 

namespace FirstBase;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\block\SignChangeEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\utils\TextFormat;
use pocketmine\event\entity\EntityExplodeEvent;



class FirstBase extends PluginBase implements Listener{	 	
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$pdFile=$this->getDescription();
		$this->getLogger()->info(TextFormat::RED.$pdFile->getName()." 버전 ".$pdFile->getVersion()."이(가) 활성화 되었습니다.");
	}
	
    public function onPlayerjoin(PlayerJoinEvent $event){
    	$player=$event->getPlayer();
    	$event->setJoinMessage(TextFormat::AQUA.$player->getName()."님 반갑습니다");
    	
    	
    }
    	
    public function signchange(SignChangeEvent $event){
    	$event->setLine(0,"sJimin's");
    	$event->setLine(1,"First");
    	$event->setLine(2,"Plugin");
    	$event->setLine(3,"work!");
    }
    public function onDisable(){
    	$pdFile=$this->getDescription();
		$this->getLogger()->info(TextFormat::BLUE.$pdFile->getName()." 버전 ".$pdFile->getVersion()."이(가) 종료되었습니다.");
    }
    public function onBanblock(BlockPlaceEvent $event){
    	$blocklist=array("46","327","10","11");
    	foreach ($blocklist as $Bancode){
    	if($event->getBlock()->getId()==$Bancode){
    		$event->setCancelled(true);
    		$player=$event->getPlayer();
    		$player->sendMessage(TextFormat::RED.$player->getName()."님이 금지된 아이템을 사용하였습니다");
    	
    	}
    	
    }
    }
    	
    
    public function onExplode(EntityExplodeEvent $event){
    	$event->setCancelled(true);
    }  
}
    


?>