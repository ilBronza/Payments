<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\RelationshipsManagers;

use IlBronza\CRUD\Providers\RelationshipsManager\RelationshipsManager;

class CardRelationManager extends RelationshipsManager
{
    public function getAllRelationsParameters(): array
    {
        return [
            'show' => [
                'relations' => [
                    'assignments' => [
                        'controller' => config('payments.models.cardassignment.controllers.index'),
                        'elementGetterMethod' => 'getRelatedCardassignmentElements',
                    ],
                ],
            ],
        ];
    }
}
