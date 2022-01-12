<?php
declare(strict_types=1);

namespace pl_895\ItemInfo\command;

use pl_895\ItemInfo\form\OptionListForm;
use pl_895\ItemInfo\ItemInfo;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class ChangeItemInfoCommand extends Command
{
    public ItemInfo $owner;

    public function __construct(ItemInfo $owner)
    {
        parent::__construct('아이템 설정', '아이템 정보를 수정합니다.', '/아이템 설정', ['아이템', '아이템설정', 'item info', 'item set']);
        $this->setPermission('ItemInfo.op');
        $this->owner = $owner;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$sender instanceof Player || !$this->testPermission($sender)) return;
        $sender->sendForm(new OptionListForm($this->owner));
    }
}