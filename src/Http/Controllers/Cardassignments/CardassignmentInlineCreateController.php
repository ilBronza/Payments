<?php

namespace IlBronza\Payments\Http\Controllers\Cardassignments;

use IlBronza\Datatables\Datatables;

class CardassignmentInlineCreateController extends CardassignmentCRUD
{
    public $allowedMethods = ['inlineCreate'];

    public function inlineCreate()
    {
        $cardAssignment = new ($this->getModelClass())();
        $parametersFile = config('payments.models.cardassignment.fieldsGroupsFiles.inlineCreate');
        $sourceParametersFile = config('payments.models.cardassignment.fieldsGroupsFiles.index');

        abort_unless(
            is_string($parametersFile) && class_exists($parametersFile)
            && is_string($sourceParametersFile) && class_exists($sourceParametersFile),
            404
        );

        $table = Datatables::createInlineCreateTable(
            'cardassignmentInlineCreate',
            $parametersFile::getTracedFieldsGroup($cardAssignment),
            $cardAssignment,
            $sourceParametersFile::getTracedFieldsGroup($cardAssignment)
        );

        return $table->renderInlineCreate();
    }
}
