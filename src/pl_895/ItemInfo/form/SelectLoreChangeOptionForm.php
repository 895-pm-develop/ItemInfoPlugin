<?php
declare(strict_types=1);

namespace pl_895\ItemInfo\form;

use JetBrains\PhpStorm\ArrayShape;
use pl_895\ItemInfo\ItemInfo;
use pocketmine\form\Form;
use pocketmine\player\Player;

class SelectLoreChangeOptionForm implements Form
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
                    'text' => '덮어쓰기(기존 설명을 제거합니다.)'
                ],
                [
                    'text' => '이어쓰기(기존 설명에 새로운 설명을 추가합니다.)'
                ]
            ]
        ];
    }

    public function handleResponse(Player $player, $data): void
    {
        if($data === null) return;
        $player->sendForm(new ItemLoreChangeForm($this->owner, $data));
    }
}