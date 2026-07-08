<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\RelationshipsManagers;

use IlBronza\CRUD\Providers\RelationshipsManager\RelationshipsManager;

class CardassignmentRelationManager extends RelationshipsManager
{
    public function getAllRelationsParameters(): array
    {
        return [
            'show' => [
                'relations' => [
                    'card' => config('payments.models.card.controllers.show'),
                ],
            ],
        ];
    }
}
