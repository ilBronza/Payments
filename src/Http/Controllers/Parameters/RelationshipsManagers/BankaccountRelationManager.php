<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\RelationshipsManagers;

use IlBronza\CRUD\Providers\RelationshipsManager\RelationshipsManager;

class BankaccountRelationManager extends RelationshipsManager
{
    use ResolvesPolymorphicRelations;

    public function getAllRelationsParameters(): array
    {
        return [
            'show' => [
                'relations' => [
                    'bank' => config('payments.models.bank.controllers.show'),
                    'cards' => [
                        'controller' => config('payments.models.card.controllers.index'),
                        'elementGetterMethod' => 'getRelatedCardElements',
                    ],
                    ...$this->getPolymorphicRelationParameters('bankaccountable'),
                ],
            ],
        ];
    }
}
