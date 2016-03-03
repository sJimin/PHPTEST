<?php

namespace OpList;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\utils\TextFormat;

class OpList extends PluginBase implements Listener {
	public function onEnable() {
		$this->getServer ()->getPluginManager ()->registerEvents ( $this, $this );
		$pdFile = $this->getDescription ();
		$this->getLogger ()->info ( TextFormat::RED . $pdFile->getName () . " 버전 " . $pdFile->getVersion () . "이(가) 활성화 되었습니다." );
	}
	public function onDisable() {
		$pdFile = $this->getDescription ();
		$this->getLogger ()->info ( TextFormat::BLUE . $pdFile->getName () . " 버전 " . $pdFile->getVersion () . "이(가) 종료되었습니다." );
	}
	public function onCommand(CommandSender $sender, Command $command, $label, array $args) {
		if (strtolower ( $command->getName () ) == "oplist") {
			foreach ( $this->getServer ()->getOnlinePlayers () as $opPlayer ) {
				$OPcounts = count ( $opPlayer->isOp () );
				$MaxPlayers = $this->getServer ()->getMaxPlayers ();
				if ($opPlayer->isOp ()) {
					$sender->sendMessage ( TextFormat::RED . "현재 접속중인 관리자 " . $OPcounts . "/" . $MaxPlayers . "\n" . TextFormat::AQUA . $opPlayer->getName () );
				}
			}
			foreach ( $this->getServer ()->getOnlinePlayers () as $onlineop ) {
				if (! $onlineop->isOp ()) {
					$sender->sendMessage ( TextFormat::RED . "현재 접속중인 관리자가 없습니다" );
				}
			}
		}
	}
}

?>