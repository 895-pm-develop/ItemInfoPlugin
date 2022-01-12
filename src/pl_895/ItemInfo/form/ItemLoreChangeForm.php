<?php
declare(strict_types=1);

namespace pl_895\ItemInfo\form;

use JetBrains\PhpStorm\ArrayShape;
use pl_895\ItemInfo\ItemInfo;
use pocketmine\form\Form;
use pocketmine\player\Player;

class ItemLoreChangeForm implements Form
{
    public ItemInfo $owner;

    public int $data;

    public function __construct(ItemInfo $owner, int $data)
    {
        $this->owner = $owner;
        $this->data = $data;
    }

    #[ArrayShape(['type' => "string", 'title' => "string", 'content' => "string", 'buttons' => "array"])] public function jsonSerialize(): array
    {
        return [
            'type' => 'custom_form',
            'title' => $this->owner->title,
            'content' => [
                [
                    'type' => 'input',
                    'text' => '아이템 설명을 입력해주세요. (n)을 통해 줄바꿈을 진행할 수 있습니다.',
                    'placeholder' => '나는 첫번째 줄(n)나는 두번째 줄'
                ]
            ]
        ];
    }

    public function handleResponse(Player $player, $data): void
    {
        if(!isset($data[0])){
            $this->owner->msg($player, '아이템 설명을 제대로 적어주세요.');
            return;
        }
        $item = $player->getInventory()->getItemInHand();
        if($item->isNull()){
            $this->owner->msg($player, '공기의 이름은 바꿀 수 없습니다.');
            return;
        }
        $lore = $this->data === 0 ? [] : $item->getLore();
        $lore_new = explode('(n)', $data[0]);
        foreach($lore_new as $unit){
            $lore[] = $unit;
        }
        $item->setLore($lore);
        $player->getInventory()->setItemInHand($item);
        $this->owner->msg($player, '아이템의 설명이 변경되었습니다.');
    }
}