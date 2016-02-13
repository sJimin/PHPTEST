<?php 
namespace Paticle;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\level\particle\CriticalParticle;
use pocketmine\math\Vector3;
use pocketmine\Player;


class Paticle extends PluginBase implements Listener{
	 
	
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$pdFile=$this->getDescription();
		$this->getLogger()->info(TextFormat::RED.$pdFile->getName()." 버전 ".$pdFile->getVersion()."이(가) 활성화 되었습니다.");	   
	}
	
	public function onDisable(){
		$pdFile=$this->getDescription();
		$this->getLogger()->info(TextFormat::BLUE.$pdFile->getName()." 버전 ".$pdFile->getVersion()."이(가) 종료되었습니다.");
	}
	
	public function getTile(PlayerMoveEvent $event){
		$player=$event->getPlayer();
		$x=$player->x;
		$y=$player->y-1;
		$z=$player->z;
		$blockId=$player->getLevel()->getBlockIdAt($x, $y, $z);
		if($blockId==7){
			$this->CritParticle($player);			
		}
		if($blockId==2){
			$this->CircleParticle($player);
		}
	}
		
	public function CircleParticle(Player $player){
		$px=$player->x;
		$py=$player->y;
		$pz=$player->z;
		for($i=0;$i<360;$i++){
		    $sin=sin($i/180*M_PI);
		    $cos=cos($i/180*M_PI);
		    $particle=new CriticalParticle(new Vector3($px+$sin*3,$py+1,$pz+$cos*3));
		    $player->getLevel()->addParticle($particle);
		}
	}
	public function CritParticle(Player $player){
		$x=$player->x;
		$y=$player->y;
		$z=$player->z;		
		$player->getLevel()->addParticle(new CriticalParticle(new Vector3($x,$y+1,$z-1)));
		$player->getLevel()->addParticle(new CriticalParticle(new Vector3($x,$y+1,$z-0.9)));
		$player->getLevel()->addParticle(new CriticalParticle(new Vector3($x,$y+1,$z-1.1)));			
	}	
}


?>