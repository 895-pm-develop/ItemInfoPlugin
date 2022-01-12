<?php
declare(strict_types=1);

namespace pl_895\ItemInfo\form;

use JetBrains\PhpStorm\ArrayShape;
use pl_895\ItemInfo\ItemInfo;
use pocketmine\form\Form;
use pocketmine\player\Player;

class ItemNameChangeForm implements Form
{
    public ItemInfo $owner;

    public function __construct(ItemInfo $owner)
    {
        $this->owner = $owner;
    }

    #[ArrayShape(['type' => "string", 'title' => "string", 'content' => "string"])] public function jsonSerialize(): array
    {
        return [
            'type' => 'custom_form',
            'title' => $this->owner->title,
            'content' => [
                [
                    'type' => 'input',
                    'text' => '아이템 이름을 입력해주세요.'
                ]
            ]
        ];
    }

    public function handleResponse(Player $player, $data): void
    {
        if(!isset($data[0])){
            $this->owner->msg($player, '아이템 이름을 정확하게 입력해주세요.');
            return;
        }
        $item = $player->getInventory()->getItemInHand();
        if($item->isNull()){
            $this->owner->msg($player, '공기의 이름은 바꿀 수 없습니다.');
            return;
        }
        $item->setCustomName($data[0]);
        $player->getInventory()->setItemInHand($item);
        $this->owner->msg($player, '아이템 이름이 변경되었습니다.');
    }
}