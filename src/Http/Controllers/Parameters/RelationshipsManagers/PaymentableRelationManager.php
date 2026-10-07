<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\RelationshipsManagers;

use IlBronza\CRUD\Providers\RelationshipsManager\RelationshipsManager;

class PaymentableRelationManager extends RelationshipsManager
{
	use ResolvesPolymorphicRelations;

	public  function getAllRelationsParameters() : array
	{
		$relations = [];

		$relations['paymenttype'] = config('payments.models.paymenttype.controllers.show');

		$relations = array_merge($relations, $this->getPolymorphicRelationParameters('paymentable'));

		return [
			'show' => [
				'relations' => $relations
			]
		];
	}
}
