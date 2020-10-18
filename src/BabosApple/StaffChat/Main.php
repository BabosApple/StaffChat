<?php

namespace BabosApple\StaffChat;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerJoinEvent;

class Main extends PluginBase implements Listener
{

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public $sChat = [];

    public function onCommand(CommandSender $sender, Command $command, String $label, Array $args) : bool 
    {
        if($command->getName() == "sc")
        {
            if($sender instanceof Player)
            {
                if(isset($args[0]))
                {
                    switch(strtolower($args[0]))
                    {
                        case "help":
                            $sender->sendMessage("§l§6StaffChat §aHelp§r\n §9- /sc on §cTurn on the staff chat mode\n§9 - /sc off §cTurn off the staff chat mode");
                        break;

                        case "on":
                            if(isset($this->sChat[$sender->getName()]))
                            {
                                $sender->sendMessage("§l§6StaffChat §e> §r§cYou already in staffchat mode");
                            }
                            else{
                                $this->sChat[$sender->getName()] = $sender->getName();
                                $sender->sendMessage("§l§6StaffChat §e> §r§aYou've turn on the StaffChat mode");
                            }
                        break;

                        case "off":
                            if(isset($this->sChat[$sender->getName()]))
                            {
                                unset($this->sChat[$sender->getName()]);
                                $sender->sendMessage("§l§6StaffChat §e> §r§aYou've turn off the StaffChat mode");
                            }
                            else{
                                $sender->sendMessage("§l§6StaffChat §e> §r§cYou already turn off the StaffChat mode");
                        break;
                    }
                }
                if(count($args) >= 2)
                {
                    $sender->sendMessage("§l§6StaffChat §r§9Use /sc help");
                }
            }
            else{
                    $sender->sendMessage("§l§6StaffChat §e> §r§9Use /sc help");
                }
            }
            else{
                $sender->sendMessage("Please use this command in-game");
            }
        }
    return true;
    }

    public function onChat(PlayerChatEvent $event)
    {
        $player = $event->getPlayer();
        $p = $this->getServer()->getOnlinePlayers();
        if(isset($this->sChat[$player->getName()]))
        {
            foreach($p as $pl)
            {
                if($pl->hasPermission("sc.use"))
                {
                    $event->setCancelled();
                    $pl->sendMessage("§l§6StaffChat §e> §r§6" . $player->getName() . " §6: §r" . $event->getMessage());
                }
            }
        }
    }

}