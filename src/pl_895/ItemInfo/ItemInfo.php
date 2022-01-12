<?php
declare(strict_types=1);

namespace pl_895\ItemInfo;

use pl_895\ItemInfo\command\ChangeItemInfoCommand;
use pocketmine\permission\Permission;
use pocketmine\permission\PermissionManager;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;

class ItemInfo extends PluginBase
{
    public string $title = '§b아이템 정보 변경 UI';

    protected function onEnable(): void
    {
        PermissionManager::getInstance()->addPermission(new Permission('ItemInfo.op'));
        $this->getServer()->getCommandMap()->register('895', new ChangeItemInfoCommand($this));
    }

    public function msg(Player $player, string $msg)
    {
        $player->sendMessage('§7[ §l§e! §r§7] §f' . $msg);
    }
}