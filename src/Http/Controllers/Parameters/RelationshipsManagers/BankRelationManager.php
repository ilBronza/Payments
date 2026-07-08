<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\RelationshipsManagers;

use IlBronza\CRUD\Providers\RelationshipsManager\RelationshipsManager;

class BankRelationManager extends RelationshipsManager
{
    public function getAllRelationsParameters(): array
    {
        return [
            'show' => [
                'relations' => [
                    'bankaccounts' => [
                        'controller' => config('payments.models.bankaccount.controllers.index'),
                        'elementGetterMethod' => 'getRelatedBankaccountElements',
                    ],
                ],
            ],
        ];
    }
}
