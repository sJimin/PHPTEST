<?php

namespace InfoBlock;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\block\Block;

class InfoBlock extends PluginBase implements Listener {
	public function onEnable() {
		$this->getServer ()->getPluginManager ()->registerEvents ( $this, $this );
		$pdFile = $this->getDescription ();
		$this->getLogger ()->info ( TextFormat::RED . $pdFile->getName () . " 버전 " . $pdFile->getVersion () . "이(가) 활성화 되었습니다." );
	}
	public function onDisable() {
		$pdFile = $this->getDescription ();
		$this->getLogger ()->info ( TextFormat::BLUE . $pdFile->getName () . " 버전 " . $pdFile->getVersion () . "이(가) 종료되었습니다." );
	}
	// 286
	public function BlockBreakEvent(PlayerInteractEvent $event) {
		$player = $event->getPlayer ();
		if ($player->isOp ()) {
			$tag = "<op> ";
		}
		if (! $player->isOp ()) {
			$tag = "<user> ";
		}
		if ($player->getInventory ()->getItemInHand ()->getId () == 286) {
			$x = $event->getBlock ()->getX ();
			$y = $event->getBlock ()->getY ();
			$z = $event->getBlock ()->getZ ();
			$BlockName = $event->getBlock ()->getName ();
			$BlockId = $event->getBlock ()->getId ();
			$BlockDamage = $event->getBlock ()->getDamage ();
			$BlockHardness = $event->getBlock ()->getHardness ();
			$MaxPlayers = $this->getServer ()->getMaxPlayers ();
			$PlayerName = $player->getName ();
			$Players = count ( $this->getServer ()->getOnlinePlayers () );
			$player->sendMessage ( TextFormat::RED . "Block Name : " . TextFormat::GRAY . $BlockName );
			$player->sendMessage ( TextFormat::GOLD . "Position : " . TextFormat::GRAY . "x:" . $x . " y:" . $y . " z:" . $z );
			$player->sendMessage ( TextFormat::YELLOW . "Block Code : " . TextFormat::GRAY . $BlockId . " : " . $BlockDamage );
			$player->sendMessage ( TextFormat::GREEN . "BlockHardness : " . TextFormat::GRAY . $BlockHardness );
			$player->sendMessage ( TextFormat::AQUA . $tag . $PlayerName . " " . TextFormat::GRAY . $Players . "/" . $MaxPlayers . " 접속중" );
		}
		if ($player->getInventory ()->getItemInHand ()->getId () == 285) {
			foreach ( $player->getBlocksAround () as $block ) {
				$BlockName = $block->getName ();
				$BlockId = $block->getId ();
				$BlockDamage = $block->getDamage ();
				$BlockHardness = $block->getHardness ();
				$x = $block->getX ();
				$y = $block->getY ();
				$z = $block->getZ ();
				$MaxPlayers = $this->getServer ()->getMaxPlayers ();
				$PlayerName = $player->getName ();
				$Players = count ( $this->getServer ()->getOnlinePlayers () );
				$player->sendMessage ( TextFormat::RED . "Block Name : " . TextFormat::GRAY . $BlockName );
				$player->sendMessage ( TextFormat::GOLD . "Position : " . TextFormat::GRAY . "x:" . $x . " y:" . $y . " z:" . $z );
				$player->sendMessage ( TextFormat::YELLOW . "Block Code : " . TextFormat::GRAY . $BlockId . " : " . $BlockDamage );
				$player->sendMessage ( TextFormat::GREEN . "BlockHardness : " . TextFormat::GRAY . $BlockHardness );
				$player->sendMessage ( TextFormat::AQUA . $tag . $PlayerName . " " . TextFormat::GRAY . $Players . "/" . $MaxPlayers . " 접속중" );
			}
		}
	}
	public function BlockBreakEven(BlockBreakEvent $event) {
		$player = $event->getPlayer ();
		if ($player->getInventory ()->getItemInHand ()->getId () == 286) {
			$event->setCancelled ( true );
		}
		if ($player->getInventory ()->getItemInHand ()->getId () == 285) {
			$event->setCancelled ( true );
		}
	}
}

?>
