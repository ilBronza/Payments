<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\RelationshipsManagers;

use IlBronza\CRUD\Providers\RelationshipsManager\RelationshipsManager;

class CardassignmentRelationManager extends RelationshipsManager
{
    public function getAllRelationsParameters(): array
    {
        $relations = [
            'card' => config('payments.models.card.controllers.show'),
        ];

        if (config('operators.enabled', true) && $controller = config('operators.models.operator.controllers.show')) {
            $relations['utilizer'] = [
                'controller' => $controller,
                'translatedTitle' => __('payments::cardassignments.utilizer'),
            ];
        }

        return [
            'show' => [
                'relations' => $relations,
            ],
        ];
    }
}
