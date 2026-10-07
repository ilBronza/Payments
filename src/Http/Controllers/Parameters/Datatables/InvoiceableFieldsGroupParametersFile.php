<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\Datatables;

use IlBronza\Datatables\Providers\FieldsGroupParametersFile;

class InvoiceableFieldsGroupParametersFile extends FieldsGroupParametersFile
{
    static function getFieldsGroup(): array
    {
        return [
            'translationPrefix' => 'payments::invoiceables',
            'fields' => [
                'mySelfSee' => 'links.see',
                'invoice' => 'relations.belongsTo',
                'target' => 'translatedClassBasename',
                'mySelfSeeTarget.target' => 'links.see',
                'mySelfSeeTargetName.target' => '_fn_getName',
            ],
        ];
    }
}
