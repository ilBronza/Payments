<?php

namespace IlBronza\Payments\Helpers;

use IlBronza\Payments\Models\Invoice;
use IlBronza\Products\Models\Sellables\Supplier;

class InvoiceGetterHelper
{
	public Supplier $supplier;
	public string $invoiceNumber;

	static function createBySupplierAndInvoiceNumber(Supplier $supplier, $invoiceNumber) : static
	{
		$helper = new static();

		$helper->setSupplier($supplier);
		$helper->setInvoiceNumber($invoiceNumber);

		return $helper;
	}

	static function findInvoiceBySupplierAndRow(Supplier $supplier, $row) : ? Invoice
	{
		$helper = static::createBySupplierAndRow($supplier, $row);

		dd($row);
	}

	static function findInvoiceBySupplier(Supplier $supplier, string $invoiceNumber) : ? Invoice
	{
		$helper = static::createBySupplierAndInvoiceNumber($supplier, $invoiceNumber);

		return $helper->_findInvoice();
	}

	static function provideInvoiceBySupplierAndInvoiceNumber(Supplier $supplier, string $invoiceNumber) : Invoice
	{
		$helper = static::createBySupplierAndInvoiceNumber($supplier, $invoiceNumber);

		if ($invoice = $helper->_findInvoice())
			return $invoice;

		return $helper->createInvoice();
	}

	public function _findInvoice() : ?Invoice
	{
		return Invoice::gpc()::where(
			'name', $this->getInvoiceNumber()
		)->where('emitter_id', $this->getSupplier()->getKey())->first();
	}

	public function createInvoice() : Invoice
	{
		$invoice = Invoice::gpc()::make();
		$invoice->name = $this->getInvoiceNumber();

		$invoice->emitter()->associate(
			$this->getSupplier()
		);

		$invoice->save();

		return $invoice;
	}

	public function setSupplier(Supplier $supplier)
	{
		$this->supplier = $supplier;
	}

	public function getSupplier() : Supplier
	{
		return $this->supplier;
	}

	public function getInvoiceNumber() : string
	{
		return $this->invoiceNumber;
	}

	public function setInvoiceNumber($invoiceNumber)
	{
		$this->invoiceNumber = $invoiceNumber;
	}
}