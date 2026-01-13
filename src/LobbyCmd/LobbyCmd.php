<?php

namespace LobbyCmd;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class LobbyCmd extends PluginBase {
    public function onEnable() {
        $this->getServer()->getCommandMap()->register("lobby", new LobbyCommand($this));
    }
}

class LobbyCommand extends Command {
    private $plugin;

    public function __construct(LobbyCmd $plugin) {
        parent::__construct("lobby", "Teleport to default world", "/lobby");
        $this->setAliases(["hub"]);
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, $commandLabel, array $args) {
        if (!$sender instanceof Player) {
            return;
        }

        $defaultWorld = $this->plugin->getServer()->getDefaultLevel();
        if (!$defaultWorld) {
            return;
        }

        $sender->setGamemode(Player::ADVENTURE);
        $sender->getInventory()->clearAll();
        $sender->teleport($defaultWorld->getSpawnLocation());
    }
}
