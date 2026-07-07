<?php

namespace IlBronza\Payments\Helpers;

use Carbon\Carbon;
use IlBronza\Payments\Models\CardAssignment;
use Illuminate\Support\Str;

class CardassignmentDownloadContractFilenameHelper
{
	public static function getFilename(CardAssignment $cardAssignment): string
	{
		return Str::slug($cardAssignment->holder->getName()) . '_' . $cardAssignment->holder->getFiscalCode() . '_card-assignment_' . Carbon::now()->format('Y-m-d') . '.pdf';
	}
}
