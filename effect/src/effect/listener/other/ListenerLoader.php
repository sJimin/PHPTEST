<?php

namespace effect\listener\other;

use pocketmine\event\Listener;
use pocketmine\plugin\Plugin;

class ListenerLoader implements Listener {
	private static $instance = null;
	private $plugin;

	public function __construct(Plugin $plugin) {
		if (self::$instance == null)
			self::$instance = $this;
		
		$this->plugin = $plugin;
		
	}	
	/**
	 * Return this listenerLoader instance
	 */
	public static function getInstance() {
		return static::$instance;
	}
}
?>