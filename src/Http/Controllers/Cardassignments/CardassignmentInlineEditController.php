<?php

namespace IlBronza\Payments\Http\Controllers\Cardassignments;

use IlBronza\Datatables\Datatables;

class CardassignmentInlineEditController extends CardassignmentCRUD
{
    public $allowedMethods = ['inlineEdit'];

    public function inlineEdit(string $cardAssignment)
    {
        $cardAssignment = $this->findModel($cardAssignment);

        $parametersFile = cconfig('payments.models.cardassignment.fieldsGroupsFiles.inlineEdit');
        $sourceParametersFile = cconfig('payments.models.cardassignment.fieldsGroupsFiles.index');

        $table = Datatables::createInlineEditTable(
            'cardassignmentInlineEdit',
            $parametersFile::getTracedFieldsGroup($cardAssignment),
            $cardAssignment,
            $sourceParametersFile::getTracedFieldsGroup($cardAssignment)
        );

        return $table->renderInlineEdit();
    }
}
