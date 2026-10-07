<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\RelationshipsManagers;

use IlBronza\CRUD\Providers\RelationshipsManager\RelationshipsManager;

class InvoiceableRelationManager extends RelationshipsManager
{
    use ResolvesPolymorphicRelations;

    public function getAllRelationsParameters(): array
    {
        return [
            'show' => [
                'relations' => [
                    'invoice' => config('payments.models.invoice.controllers.show'),
                    ...$this->getPolymorphicRelationParameters('target'),
                ],
            ],
        ];
    }
}
