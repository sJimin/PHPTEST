<?php

namespace Calculator;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;

class Calculator extends PluginBase implements Listener {
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
		if (strtolower ( $command->getName () ) == "m") {
			if (! isset ( $args [0] )) {
				$sender->sendMessage ( TextFormat::GREEN . " [Calculator]" . TextFormat::GRAY . " /m help1 /m help2 /m help3" );
				return true;
			}
			if ($args [0] == "sum") {
				if (! isset ( $args [1] ) || ! isset ( $args [2] )) {
					$sender->sendMessage ( TextFormat::RED . "/m sum a b => a+b" );
					return true;
				}
				$sender->sendMessage ( TextFormat::GREEN . "[Calculator] Result => " . TextFormat::GRAY . $this->sum ( $args [1], $args [2] ) );
			}
			if ($args [0] == "degree") {
				if (! isset ( $args [1] ) || ! isset ( $args [2] )) {
					$sender->sendMessage ( TextFormat::RED . "/m square a b => a^b" );
					return true;
				}
				$sender->sendMessage ( TextFormat::GREEN . "[Calculator] Result => " . TextFormat::GRAY . $this->square ( $args [1], $args [2] ) );
			}
			if ($args [0] == "subtract") {
				if (! isset ( $args [1] ) || ! isset ( $args [2] )) {
					$sender->sendMessage ( TextFormat::RED . "/m subtract a b => a-b" );
					return true;
				}
				$sender->sendMessage ( TextFormat::GREEN . "[Calculator] Result => " . TextFormat::GRAY . $this->subtract ( $args [1], $args [2] ) );
			}
			if ($args [0] == "divide") {
				if (! isset ( $args [1] ) || ! isset ( $args [2] )) {
					$sender->sendMessage ( TextFormat::RED . "/m divide a b => a÷b" );
					return true;
				}
				$sender->sendMessage ( TextFormat::GREEN . "[Calculator] Result => " . TextFormat::GRAY . $this->divide ( $args [1], $args [2] ) );
			}
			if ($args [0] == "root") {
				if (! isset ( $args [1] )) {
					$sender->sendMessage ( TextFormat::RED . "/m root a => √a" );
					return true;
				}
				$sender->sendMessage ( TextFormat::GREEN . "[Calculator] Result => " . TextFormat::GRAY . $this->root ( $args [1] ) );
			}
			if ($args [0] == "abs") {
				if (! isset ( $args [1] )) {
					$sender->sendMessage ( TextFormat::RED . "/m abs -1 => 1" );
					return true;
				}
				$sender->sendMessage ( TextFormat::GREEN . "[Calculator] Result => " . TextFormat::GRAY . $this->absvalue ( $args [1] ) );
			}
			if ($args [0] == "plane") {
				if (! isset ( $args [1] ) || ! isset ( $args [2] ) || ! isset ( $args [3] ) || ! isset ( $args [4] )) {
					$sender->sendMessage ( TextFormat::RED . "/m plane x1 y1 x2 y2 => √(x1-x2)²+(y1-y2)²" );
					return true;
				}
				$sender->sendMessage ( TextFormat::GREEN . "[Calculator] Result => " . TextFormat::GRAY . $this->PlaneDistance ( $args [1], $args [2], $args [3], $args [4] ) );
			}
			if ($args [0] == "trapezoid") {
				if (! isset ( $args [1] ) || ! isset ( $args [2] ) || ! isset ( $args [3] )) {
					$sender->sendMessage ( TextFormat::RED . "/m trapzoid Top Bottom Height => TrapezoidArea" );
					return true;
				}
				$sender->sendMessage ( TextFormat::GREEN . "[Calculator] Result => " . TextFormat::GRAY . $this->TrapezoidArea ( $args [1], $args [2], $args [3] ) );
			}
			if ($args [0] == "multiply") {
				if (! isset ( $args [1] ) || ! isset ( $args [2] )) {
					$sender->sendMessage ( TextFormat::RED . "/m multiply a b => a×b" );
					return true;
				}
				$sender->sendMessage ( TextFormat::GREEN . "[Calculator] Result => " . TextFormat::GRAY . $this->multiply ( $args [1], $args [2] ) );
			}
			if ($args [0] == "sin") {
				if (! isset ( $args [1] )) {
					$sender->sendMessage ( TextFormat::RED . "/m sin x => sinx" );
					return true;
				}
				$sender->sendMessage ( TextFormat::GREEN . "[Calculator] Result => " . TextFormat::GRAY . $this->sinx ( $args [1] ) );
			}
			if ($args [0] == "cos") {
				if (! isset ( $args [1] )) {
					$sender->sendMessage ( TextFormat::RED . "/m cos x => cosx" );
					return true;
				}
				$sender->sendMessage ( TextFormat::GREEN . "[Calculator] Result => " . TextFormat::GRAY . $this->cosx ( $args [1] ) );
			}
			if ($args [0] == "tan") {
				if (! isset ( $args [1] )) {
					$sender->sendMessage ( TextFormat::RED . "/m tan x => tanx" );
					return true;
				}
				$sender->sendMessage ( TextFormat::GREEN . "[Calculator] Result => " . TextFormat::GRAY . $this->tanx ( $args [1] ) );
			}
			if ($args [0] == "bindec") {
				if (! isset ( $args [1] )) {
					$sender->sendMessage ( TextFormat::RED . "/m bindec 1010100 => 84" );
					return true;
				}
				$sender->sendMessage ( TextFormat::GREEN . "[Calculator] Result => " . TextFormat::GRAY . $this->bindecc ( $args [1] ) );
			}
			if ($args [0] == "decbin") {
				if (! isset ( $args [1] )) {
					$sender->sendMessage ( TextFormat::RED . "/m decbin 84 => 1010100" );
					return true;
				}
				$sender->sendMessage ( TextFormat::GREEN . "[Calculator] Result => " . TextFormat::GRAY . $this->decbinn ( $args [1] ) );
			}
			if ($args [0] == "octdec") {
				if (! isset ( $args [1] )) {
					$sender->sendMessage ( TextFormat::RED . "/m octdec 72 => 58" );
					return true;
				}
				$sender->sendMessage ( TextFormat::GREEN . "[Calculator] Result => " . TextFormat::GRAY . $this->octdecc ( $args [1] ) );
			}
			if ($args [0] == "decoct") {
				if (! isset ( $args [1] )) {
					$sender->sendMessage ( TextFormat::RED . "/m decoct 58 => 72" );
					return true;
				}
				$sender->sendMessage ( TextFormat::GREEN . "[Calculator] Result => " . TextFormat::GRAY . $this->decoctt ( $args [1] ) );
			}
			if ($args [0] == "hexdec") {
				if (! isset ( $args [1] )) {
					$sender->sendMessage ( TextFormat::RED . "/m hexdec 275 => 189" );
					return true;
				}
				$sender->sendMessage ( TextFormat::GREEN . "[Calculator] Result => " . TextFormat::GRAY . $this->octdecc ( $args [1] ) );
			}
			if ($args [0] == "dechex") {
				if (! isset ( $args [1] )) {
					$sender->sendMessage ( TextFormat::RED . "/m dechex 189 => 275" );
					return true;
				}
				$sender->sendMessage ( TextFormat::GREEN . "[Calculator] Result => " . TextFormat::GRAY . $this->decoctt ( $args [1] ) );
			}
			if ($args [0] == "date") {
				$sender->sendMessage ( $this->datee () );
			}
			
			if ($args [0] == "help1") {
				$sender->sendMessage ( $this->help1 () );
			}
			if ($args [0] == "help2") {
				$sender->sendMessage ( $this->help2 () );
			}
			if ($args [0] == "help3") {
				$sender->sendMessage ( $this->help3 () );
			}
		}
	}
	/* 덧셈 */
	public function sum($args1, $args2) {
		return $args1 + $args2;
	}
	/* n제곱 */
	public function square($args1, $args2) {
		return pow ( $args1, $args2 );
	}
	/* 곱셈 */
	public function multiply($args1, $args2) {
		return $args1 * $args2;
	}
	/* 뺄셈 */
	public function subtract($args1, $args2) {
		return $args1 - $args2;
	}
	/* 나누기 몫과 나머지 반환 */
	public function divide($args1, $args2) {
		$share = floor ( $args1 / $args2 );
		$rest = fmod ( $args1, $args2 );
		return $res = "몫 : " . $share . "나머지 : " . $rest;
	}
	/* 제곱근 */
	public function root($args1) {
		return sqrt ( $args1 );
	}
	/* 절대값 */
	public function absvalue($args1) {
		return abs ( $args1 );
	}
	/* 두좌표 사이 거리 계산 */
	public function PlaneDistance($args1, $args2, $args3, $args4) {
		return sqrt ( pow ( $args1 - $args3, 2 ) + pow ( $args2 - $args4, 2 ) );
	}
	/* 사다리꼴 넓이 */
	function TrapezoidArea($args1, $args2, $args3) {
		return ($args1 + $args2) * $args3 / 2;
	}
	/* 삼각함수 */
	public function sinx($args1) {
		return sin ( $args1 / 180 * M_PI );
	}
	public function cosx($args1) {
		return cos ( $args1 / 180 * M_PI );
	}
	public function tanx($args1) {
		return tan ( $args1 / 180 * M_PI );
	}
	/*
	 * bindecc 2진수 -> 10진수
	 * decbinn 10진수 -> 2진수
	 */
	public function bindecc($args1) {
		return bindec ( $args1 );
	}
	public function decbinn($args1) {
		return decbin ( $args1 );
	}
	/*
	 * octdecc 8진수 -> 10진수
	 * decoctt 10진수 -> 8진수
	 */
	public function octdecc($args1) {
		return octdec ( $args1 );
	}
	public function decoctt($args1) {
		return decoct ( $args1 );
	}
	/*
	 * hexdecc 16진수 -> 10진수
	 * dechexx 10진수 -> 16진수
	 */
	public function hexdecc($args1) {
		return hexdec ( $args1 );
	}
	public function dechexx($args1) {
		return dechex ( $args1 );
	}
	public function datee() {
		$time = date ( "Y-m-d A h:i:s" );
		return $time;
	}
	public function help1() {
		$list1 = TextFormat::YELLOW . "/m square a , a를 제곱해줍니다 \n";
		$list2 = TextFormat::YELLOW . "/m abs a , a의 절대값을 구해줍니다 \n";
		$list3 = TextFormat::YELLOW . "/m root a , a의 제곱근을 구해줍니다 \n";
		$list4 = TextFormat::YELLOW . "/m subtract a b , a에서 b를 빼줍니다 \n";
		$list5 = TextFormat::YELLOW . "/m sum a b , a와 b를 더해줍니다 \n";
		return $list1 . $list2 . $list3 . $list4 . $list5;
	}
	public function help2() {
		$list6 = TextFormat::YELLOW . "/m divide a b , a 에서 b를 나눠줍니다 \n";
		$list7 = TextFormat::YELLOW . "/m multiply a b , a와 b를 곱해줍니다 \n";
		$list8 = TextFormat::YELLOW . "/m plane x1 y1 x2 y2 , 두점 (x1,y1),(x2,y2) 사이 거리를 구해줍니다 \n";
		$list9 = TextFormat::YELLOW . "/m trapezoid top bottom height , 사다리꼴의 넓이를 구해줍니다\n";
		$list10 = TextFormat::YELLOW . "/m sin x , /m cos x , /m tan x 삼각함수 값을 구해줍니다.";
		return $list6 . $list7 . $list8 . $list9 . $list10;
	}
	public function help3() {
		$list11 = TextFormat::YELLOW . "/m bindec 2진수 : 2진수->10진수, /m decbin 10진수 : 10진수->2진수\n";
		$list12 = TextFormat::YELLOW . "/m octdec 8진수 : 8진수->10진수, /m decoct 10진수 : 10진수->8진수\n";
		$list13 = TextFormat::YELLOW . "/m hexdec 16진수 : 16진수->10진수 , /m dechex 10진수 : 10진수->16진수\n";
		return $list11 . $list12 . $list13;
	}
}

?>