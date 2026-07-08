<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\RelationshipsManagers;

use IlBronza\CRUD\Providers\RelationshipsManager\RelationshipsManager;

class CardtypeRelationManager extends RelationshipsManager
{
    public function getAllRelationsParameters(): array
    {
        return [
            'show' => [
                'relations' => [
                    'cards' => [
                        'controller' => config('payments.models.card.controllers.index'),
                        'elementGetterMethod' => 'getRelatedCardElements',
                    ],
                ],
            ],
        ];
    }
}
