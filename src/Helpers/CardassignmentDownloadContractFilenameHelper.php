<?php

namespace IlBronza\Payments\Helpers;

use Carbon\Carbon;
use IlBronza\Payments\Models\CardAssignment;

class CardassignmentDownloadContractFilenameHelper
{
	public static function getFilename(CardAssignment $cardAssignment): string
	{
		return $cardAssignment->holder->getName() . 'card_assignment' . Carbon::now()->format('Y-m-d') . '.pdf';
	}
}
