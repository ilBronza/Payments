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
                    'cardtype' => config('payments.models.cardtype.controllers.show'),
                    'cardcircuit' => config('payments.models.cardcircuit.controllers.show'),
                    'bankaccount' => config('payments.models.bankaccount.controllers.show'),
                    ...$this->getHolderRelation(),
                    'assignments' => [
                        'controller' => config('payments.models.cardassignment.controllers.index'),
                        'elementGetterMethod' => 'getRelatedCardassignmentElements',
                        'fieldsGroupsParametersFile' => config('payments.models.cardassignment.fieldsGroupsFiles.related')
                    ],
                ],
            ],
        ];
    }

    protected function getHolderRelation(): array
    {
        if (config('operators.enabled', true) && $controller = config('operators.models.operator.controllers.show')) {
            return ['holder' => [
                'controller' => $controller,
                'translatedTitle' => __('payments::cards.holder'),
            ]];
        }

        return [];
    }
}
