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
		$this->getLogger()->info(TextFormat::BLUE."플러그인 적용완료");
	}
	
    public function onPlayerjoin(PlayerJoinEvent $event){
    	$player=$event->getPlayer();
    	$event->setJoinMessage(TextFormat::DARK_PURPLE.$player->getName()."님 반갑습니다");
    	
    	
    }
    	
    public function signchange(SignChangeEvent $event){
    	$event->setLine(0,"sJimin's");
    	$event->setLine(1,"First");
    	$event->setLine(2,"Plugin");
    	$event->setLine(3,"work!");
    }
    public function onDisable(){
    	$this->getLogger()->info(TextFormat::RED."플러그인이 종료되었습니다.");
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