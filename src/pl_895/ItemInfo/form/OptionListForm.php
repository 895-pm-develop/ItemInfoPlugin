<?php
declare(strict_types=1);

namespace pl_895\ItemInfo\form;

use JetBrains\PhpStorm\ArrayShape;
use pl_895\ItemInfo\ItemInfo;
use pocketmine\form\Form;
use pocketmine\player\Player;

class OptionListForm implements Form
{
    public ItemInfo $owner;

    public function __construct(ItemInfo $owner)
    {
        $this->owner = $owner;
    }

    #[ArrayShape(['type' => "string", 'title' => "string", 'content' => "string", 'buttons' => "array"])] public function jsonSerialize(): array
    {
        return [
            'type' => 'form',
            'title' => $this->owner->title,
            'content' => "\n" . '원하시는 작업을 선택해주세요.' . "\n\n",
            'buttons' => [
                [
                    'text' => '아이템 이름 설정하기'
                ],
                [
                    'text' => '아이템 로어(설명) 설정하기'
                ]
            ]
        ];
    }

    public function handleResponse(Player $player, $data): void
    {
        if($data === null) return;
        if($data === 0){
            $player->sendForm(new ItemNameChangeForm($this->owner));
        }else{
            $player->sendForm(new SelectLoreChangeOptionForm($this->owner));
        }
    }
}