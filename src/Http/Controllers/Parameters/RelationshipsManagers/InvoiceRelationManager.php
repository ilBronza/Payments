<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\RelationshipsManagers;

use IlBronza\CRUD\Providers\RelationshipsManager\RelationshipsManager;

class InvoiceRelationManager extends RelationshipsManager
{
    public function getAllRelationsParameters() : array
    {
        $relations = [
            'deadlines' => [
                'controller' => config('payments.models.deadline.controllers.index'),
                'elementGetterMethod' => 'getRelatedDeadlineElements',
            ],
            'invoiceables' => [
                'controller' => config('payments.models.invoiceable.controllers.index'),
                'elementGetterMethod' => 'getRelatedInvoiceableElements',
                'hasCreateButton' => false,
            ],
            'details' => [
                'fieldsGroupsParametersFile' => config('payments.models.invoiceDetail.fieldsGroupsFiles.related'),
                'hasCreateButton' => false,
                'hasAssociateButton' => false,
                'selectRowCheckboxes' => false,
                'sorting' => false,
            ],
        ];

        if (config('products.enabled', true)) {
            if ($controller = config('products.models.supplier.controllers.show')) {
                $relations['emitter'] = [
                    'controller' => $controller,
                    'translatedTitle' => __('payments::invoices.emitter'),
                ];
            }

            foreach (['orderrows' => 'orderrow', 'quotationrows' => 'quotationrow'] as $relation => $model) {
                if ($controller = config("products.models.{$model}.controllers.index")) {
                    $relations[$relation] = [
                        'controller' => $controller,
                        'hasCreateButton' => false,
                        'hasAssociateButton' => false,
                    ];
                }
            }
        }

        if (config('clients.enabled', true) && $controller = config('clients.models.client.controllers.show')) {
            $relations['target'] = [
                'controller' => $controller,
                'translatedTitle' => __('payments::invoices.target'),
            ];
        }

        return [
            'show' => [
                'relations' => $relations,
            ]
        ];
    }
}
