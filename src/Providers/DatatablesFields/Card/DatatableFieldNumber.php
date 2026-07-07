<?php

namespace IlBronza\Payments\Providers\DatatablesFields\Card;

use IlBronza\Datatables\DatatablesFields\DatatableField;
use Illuminate\Support\Facades\Auth;

class DatatableFieldNumber extends DatatableField
{
	public ?bool $seeValue = null;

	public function transformValue($value)
	{
		if(! $value)
			return '';

		$number = preg_replace('/\D/', '', (string) $value);

		if($this->shouldSeeValue())
			return $this->formatInGroups($number);

		if(strlen($number) <= 4)
			return $number;

		return $this->formatInGroups(
			str_repeat('*', strlen($number) - 4) . substr($number, -4)
		);
	}

	protected function formatInGroups(string $value) : string
	{
		return implode(' ', str_split($value, 4));
	}

	protected function shouldSeeValue() : bool
	{
		if(! is_null($this->seeValue))
			return $this->seeValue;

		return Auth::user()?->hasAnyRole([
			'paymentsManager',
			'cardCreation',
		]) ?? false;
	}
}
