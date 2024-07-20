<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\RelationshipsManagers;

use IlBronza\CRUD\Providers\RelationshipsManager\RelationshipsManager;

class PaymenttypeRelationManager Extends RelationshipsManager
{
	public  function getAllRelationsParameters() : array
	{
		return [
			'show' => [
				'relations' => [
					'paymentables' => [
						'controller' => config('payments.models.paymentable.controllers.index'),
						'elementGetterMethod' => 'getRelatedPaymentableElements'
					]
				]
			]
		];
	}
}