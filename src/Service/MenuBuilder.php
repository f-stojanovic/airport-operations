<?php

namespace App\Service;

class MenuBuilder
{
    public function getMenuData(): array
    {
        return [
            'list' => [
                'link' => '/aircraft',
                'icon' => 'fa-plane',
                'label' => 'List of Aircraft',
            ],
            [
                'link' => '/logs',
                'icon' => 'fa-file-o',
                'label' => 'Logs',
            ],
        ];
    }
}
