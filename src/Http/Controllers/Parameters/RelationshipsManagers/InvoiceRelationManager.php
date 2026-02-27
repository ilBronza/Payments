<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\RelationshipsManagers;

use IlBronza\CRUD\Providers\RelationshipsManager\RelationshipsManager;

class InvoiceRelationManager extends RelationshipsManager
{
    public function getAllRelationsParameters() : array
    {
        return [
            'show' => [
                'relations' => [
                    'deadlines' => config('payments.models.deadline.controllers.show'),
                    'invoiceables' => config('payments.models.invoiceable.controllers.show'),
                ]
            ]
        ];
    }
}
