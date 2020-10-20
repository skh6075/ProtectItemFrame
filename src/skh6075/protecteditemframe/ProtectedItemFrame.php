<?php

namespace skh6075\protecteditemframe;

use pocketmine\plugin\PluginBase;
use skh6075\protecteditemframe\listener\EventListener;

class ProtectedItemFrame extends PluginBase {


    public function onEnable (): void{
        $this->getServer ()->getPluginManager ()->registerEvents (new EventListener (), $this);
    }
}