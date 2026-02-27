<?php

namespace IlBronza\Payments\Http\Controllers\Deadlines;

use IlBronza\Payments\Http\Controllers\Deadlines\DeadlineIndexController;

class DeadlineExportBankTransfersIndexController extends DeadlineIndexController
{
    public $avoidCreateButton = true;
    public $rowSelectCheckboxes = true;

    public $scopes = ['toExport'];

    public function addIndexButtons()
    {
        $this->getTable()->createPostButton([
            'href' => app('payments')->route('deadlines.exportCsv'),
            'text' => 'payments::deadlines.exportCsv',
            'icon' => 'file-csv',
        ]);
    }

    public function getIndexElements()
    {
        $result = $this->getModelClass()::with([
			'invoice.target',
	        'invoice.emitter.target',
	        'invoice.invoiceables.target'
        ]);

        foreach($this->scopes as $scope)
            $result->{$scope}();

        return $result->get();
    }

}
