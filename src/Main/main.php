<?php

namespace Main;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;
use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\player\PlayerDeathEvent;
use MixCoinSystem\MixCoinSystem;

class main extends PluginBase implements Listener{

	public function onEnable(){ 
		
		if(!file_exists($this->getDataFolder())){
			mkdir($this->getDataFolder(), 0744, true);
		}
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->set = new Config($this->getDataFolder() . "setting.yml", CONFIG::YAML,array(
			"コイン数"=>"10"
		));
		$this->set->save();
		$this->getLogger()->info("KillMinusCoinを起動しました");
	}
	
	public function onDisable(){
	}
	
	public function onPlayerDeath(PlayerDeathEvent $event) : void{
	    $player = $event->getPlayer();
	    $coin = $this->set->get("コイン数");
	    if($player->getLastDamageCause() instanceof EntityDamageByEntityEvent){
	        if($player->getLastDamageCause()->getDamager() instanceof Player){
	            $player1 = $player->getLastDamageCause()->getDamager();
	            $playername = $player->getName();
	            $playername1 = $player1->getName();
	            MixCoinSystem::getInstance()->MinusCoin($player,$coin);
	            $player->sendMessage("§c{$playername1}に殺されたので{$coin}コインを減らしました");
	            MixCoinSystem::getInstance()->PlusCoin($player1,$coin);
	            $player1->sendMessage("§c{$playername}を殺したので{$coin}コインを増やししました");
	        }
	    }
	}
}	            
