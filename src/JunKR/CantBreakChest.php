<?php

namespace JunKR;

use pocketmine\block\Chest;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

class CantBreakChest extends PluginBase implements Listener{

    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onBreak(BlockBreakEvent $ev){
        $player = $ev->getPlayer();
        $block = $ev->getBlock();
        if(!$block instanceof Chest){
            return;
        }
        $tile = $block->getLevel()->getTile($block->asVector3());
        if(!$tile instanceof \pocketmine\tile\Chest){
            return;
        }

        if(count($tile->getInventory()->getContents()) > 0){
            $player->sendMessage("§l§c[주의] §r§f상자가 비여있어야 해당 상자를 파괴 할 수 있습니다!");
            CrossUtils::playSound($player, "note.bass");
            $ev->setCancelled();
        }
    }
}