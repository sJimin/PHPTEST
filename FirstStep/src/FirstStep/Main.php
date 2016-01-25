<?php 

namespace  FirstStep;

use pocketmine\block\Block;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\utils\TextFormat;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\item\Item;
use pocketmine\event\player\PlayerChatEvent;


class Main extends PluginBase implements Listener{
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	public function onBlock(BlockPlaceEvent $event){
		$event->getBlock()->getLevel()->setBlock($event->getBlock(), Block::get(Block::SNOW_BLOCK));
	}
	public function onJoin(PlayerJoinEvent $event){
		$event->getPlayer()->getInventory()->addItem(Item::get(Item::GOLD_ORE,0,1));
	} 
	public function onBreak(BlockBreakEvent $event){
		if($event->getBlock()->getId()==Block::GRASS)
			$event->getPlayer()->kick(":P!");
	}
	public function onPlayerChatEvent(PlayerChatEvent $event){
		if(isset(explode("바보", $event->getMessage())[1] )){
			$event->setcancelled();
			$event->getPlayer()->setBanned(true);
			$event->getPlayer()->kick("욕사용 금지!"); 
		}
	}
	public function onCommand(CommandSender $player,Command $command, $label,array $args){
		if(strtolower($command->getName())=="firststep")
			$this->getLogger()->info(TextFormat::DARK_AQUA."명령어가 실행되었습니다!");
	}
}



?>