<?php

namespace IlBronza\Payments\Helpers;

use Carbon\Carbon;
use IlBronza\Payments\Models\CardAssignment;
use Illuminate\Support\Str;

class CardassignmentDownloadContractFilenameHelper
{
	public static function getFilename(CardAssignment $cardAssignment): string
	{
		return Str::slug($cardAssignment->card->holder->getName()) . '_' . $cardAssignment->card->holder->getFiscalCode() . '_card-assignment_' . Carbon::now()->format('Y-m-d') . '.pdf';
	}
}
