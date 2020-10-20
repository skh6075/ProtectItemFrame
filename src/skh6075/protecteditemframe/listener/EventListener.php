<?php


namespace skh6075\protecteditemframe\listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\server\DataPacketReceiveEvent;

use pocketmine\block\Block;
use pocketmine\level\Position;
use pocketmine\tile\ItemFrame;

class EventListener implements Listener {



    public function onDataPacketReceive (DataPacketReceiveEvent $event): void{
        $packet = $event->getPacket ();
        if ($packet->pid () === 0x47) {
            $player = $event->getPlayer ();
            $pos = new Position ($packet->x, $packet->y, $packet->z, $player->getLevel ());
            if (($tile = $player->getLevel ()->getTile ($pos)) instanceof ItemFrame) {
                if (!$player->isOp ()) {
                    $event->setCancelled ();
                }
            }
        }
    }
    
    public function onBlockBreak (BlockBreakEvent $event): void{
        $block = $event->getBlock ();
        $player = $event->getPlayer ();
        if ($block->getId () === Block::ITEM_FRAME_BLOCK) {
            if ($player->isOp ()) {
                $tile = $player->getLevel ()->getTile ($block);
                $tile->setItem (null);
            } else {
                $event->setCancelled ();
            }
        }
    }
    
    public function onPlayerInteract (PlayerInteractEvent $event): void{
        $player = $event->getPlayer ();
        $action = $event->getAction ();
        if ($action === PlayerInteractEvent::RIGHT_CLICK_BLOCK) {
            $block = $event->getBlock ();
            if ($block->getId () === Block::ITEM_FRAME_BLOCK) {
                if (!$player->isOp ()) {
                    $event->setCancelled ();
                }
            }
        }
    }
}