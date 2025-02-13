<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\Fieldsets;

use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;

class InvoiceShowFieldsetsParameters extends FieldsetParametersFile
{
    public function _getFieldsetsParameters() : array
    {
        return [
	        'base' => [
		        'translationPrefix' => 'payments::fields',
		        'fields' => [
			        'name' => ['text' => 'string|required|max:32'],
			        'date' => ['date' => 'date|nullable'],
			        'description' => ['textEditor' => 'string|nullable|max:2048'],
			        'amount' => ['number' => 'numeric|nullable|min:0|max:999999.99'],
		        ],
		        'width' => ['1-3@l', '1-2@m']
	        ],
	        'companies' => [
		        'translationPrefix' => 'payments::fields',
		        'fields' => [
			        'emitter' => [
						'type' => 'select',
				        'multiple' => false,
				        'rules' => 'string|nullable',
				        'relation' => 'emitter'
			        ],
			        'target' => [
						'type' => 'select',
				        'multiple' => false,
				        'rules' => 'string|nullable',
				        'relation' => 'target'
			        ],
		        ],
		        'width' => ['1-3@l', '1-2@m']
	        ],
	        'documents' => [
		        'fields' => [],
		        'view' => [
			        'name' => 'filecabinet::fetchers._modelDossiersByCategory',
			        'parameters' => [
				        'categorySlug' => 'documenti-fatture',
				        'model' => $this->getModel()
			        ]
		        ],
		        'width' => ['medium']
		        //				'fields' => $documentsFields,
		        //				'width' => ['large']
	        ],
        ];
    }
}
