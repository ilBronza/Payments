<?php

namespace IlBronza\Payments\Http\Controllers\Cardassignments;

use IlBronza\Datatables\Datatables;

class CardassignmentInlineEditController extends CardassignmentCRUD
{
    public $allowedMethods = ['inlineEdit'];

    public function inlineEdit(string $cardAssignment)
    {
        $cardAssignment = $this->findModel($cardAssignment);
        $parametersFile = config('payments.models.cardassignment.fieldsGroupsFiles.inlineEdit');

        abort_unless(is_string($parametersFile) && class_exists($parametersFile), 404);

        $table = Datatables::createInlineEditTable(
            'cardassignmentInlineEdit',
            $parametersFile::getTracedFieldsGroup($cardAssignment),
            $cardAssignment
        );

        return $table->renderInlineEdit();
    }
}
