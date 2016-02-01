<?php 

namespace FirstBase;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\block\Block;
use pocketmine\event\block\SignChangeEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\block\BlockPlaceEvent;


class FirstBase extends PluginBase implements Listener{
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getLogger()->info("플러그인 적용완료");
	}
    public function onPlayerjoin(PlayerJoinEvent $event){
    	$event->setJoinMessage(TextFormat::GOLD.$event->getPlayer()->getName()+"님이 입장하셨습니다.");
    }
    	
    public function signchange(SignChangeEvent $event){
    	$event->setLine(0,"sJimin's");
    	$event->setLine(1,"First");
    	$event->setLine(2,"Plugin");
    	$event->setLine(3,"work!");
    }
    public function onDisable(){
    	$this->getLogger()->info("플러그인이 종료되었습니다.");
    }
}

class Block{
	public static $Banblock;
	public function onBanblock(BlockPlaceEvent $event){
		$this->Banblock=array("LAVA,TNT,GRASS");
		if($event->getBlock()->getId()==Block::get(Block::$Banblock)){
			$player=$event->getPlayer();
			$player->sendMessage(TextFormat::RED.$event->getPlayer()->getName()+"님이 금지된 블록을 사용하셨습니다.");
			$event->setCancelled(true);
		}
	}
}	
		
	




?>