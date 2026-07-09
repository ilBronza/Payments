<?php

use IlBronza\Payments\Payments;

Route::group([
	'middleware' => [
		'web',
		'auth',
		'payments.roles',
		'role:paymentsManager'
	],
	'prefix' => 'payments-manager',
	'as' => config('payments.routePrefix')
], function()
{

	Route::group(['prefix' => 'cards'], function()
	{
		Route::get('', [Payments::getController('card', 'index'), 'index'])->name('cards.index');
		Route::get('create', [Payments::getController('card', 'create'), 'create'])->name('cards.create');
		Route::post('', [Payments::getController('card', 'store'), 'store'])->name('cards.store');
		Route::get('{card}', [Payments::getController('card', 'show'), 'show'])->name('cards.show');
		Route::get('{card}/edit', [Payments::getController('card', 'edit'), 'edit'])->name('cards.edit');
		Route::put('{card}', [Payments::getController('card', 'edit'), 'update'])->name('cards.update');
		Route::delete('{card}/delete', [Payments::getController('card', 'destroy'), 'destroy'])->name('cards.destroy');
	});

	Route::group(['prefix' => 'cardassignments'], function()
	{
		Route::get('', [Payments::getController('cardassignment', 'index'), 'index'])
			->name('cardAssignments.index')
			->withoutMiddleware('role:paymentsManager')
			->middleware('role:paymentsManager|cardAssignment');

		Route::get('create', [Payments::getController('cardassignment', 'create'), 'create'])
			->name('cardAssignments.create')
			->withoutMiddleware('role:paymentsManager')
			->middleware('role:paymentsManager|cardAssignment');

		Route::post('', [Payments::getController('cardassignment', 'store'), 'store'])
			->name('cardAssignments.store')
			->withoutMiddleware('role:paymentsManager')
			->middleware('role:paymentsManager|cardAssignment');

		Route::get('history', [Payments::getController('cardassignment', 'history'), 'index'])
			->name('cardAssignments.history')
			->withoutMiddleware('role:paymentsManager')
			->middleware('role:paymentsManager|cardAssignment');

		//CardassignmentReassignController
		Route::get('{cardAssignment}/reassign', [Payments::getController('cardassignment', 'reassign'), 'reassign'])
			->name('cardAssignments.reassign')
			->withoutMiddleware('role:paymentsManager')
			->middleware('role:paymentsManager|cardAssignment');

		//CardassignmentDownloadContractController
		Route::get('{cardAssignment}/download-contract', [Payments::getController('cardassignment', 'downloadContract'), 'downloadContract'])
			->name('cardAssignments.downloadContract')
			->withoutMiddleware('role:paymentsManager')
			->middleware('role:paymentsManager|cardAssignment');
		Route::get('{cardAssignment}', [Payments::getController('cardassignment', 'show'), 'show'])->name('cardAssignments.show');
		Route::get('{cardAssignment}/edit', [Payments::getController('cardassignment', 'edit'), 'edit'])->name('cardAssignments.edit');
		Route::put('{cardAssignment}', [Payments::getController('cardassignment', 'edit'), 'update'])->name('cardAssignments.update')
			->withoutMiddleware('role:paymentsManager')
			->middleware('role:paymentsManager|cardAssignment');

		Route::delete('{cardAssignment}/delete', [Payments::getController('cardassignment', 'destroy'), 'destroy'])->name('cardAssignments.destroy');

		Route::match(['get', 'post', 'patch', 'delete'], 'delete-media/{cardAssignment}/{media}', [
			Payments::getController('cardassignment', 'deleteMedia'), 'deleteMedia'])->name('cardAssignments.deleteMedia');

	});

	Route::group(['prefix' => 'cardtypes'], function()
	{
		Route::get('', [Payments::getController('cardtype', 'index'), 'index'])->name('cardtypes.index');
		Route::get('create', [Payments::getController('cardtype', 'create'), 'create'])->name('cardtypes.create');
		Route::post('', [Payments::getController('cardtype', 'store'), 'store'])->name('cardtypes.store');
		Route::get('{cardtype}', [Payments::getController('cardtype', 'show'), 'show'])->name('cardtypes.show');
		Route::get('{cardtype}/edit', [Payments::getController('cardtype', 'edit'), 'edit'])->name('cardtypes.edit');
		Route::put('{cardtype}', [Payments::getController('cardtype', 'edit'), 'update'])->name('cardtypes.update');
		Route::delete('{cardtype}/delete', [Payments::getController('cardtype', 'destroy'), 'destroy'])->name('cardtypes.destroy');
	});

	Route::group(['prefix' => 'cardcircuits'], function()
	{
		Route::get('', [Payments::getController('cardcircuit', 'index'), 'index'])->name('cardcircuits.index');
		Route::get('create', [Payments::getController('cardcircuit', 'create'), 'create'])->name('cardcircuits.create');
		Route::post('', [Payments::getController('cardcircuit', 'store'), 'store'])->name('cardcircuits.store');
		Route::get('{cardcircuit}', [Payments::getController('cardcircuit', 'show'), 'show'])->name('cardcircuits.show');
		Route::get('{cardcircuit}/edit', [Payments::getController('cardcircuit', 'edit'), 'edit'])->name('cardcircuits.edit');
		Route::put('{cardcircuit}', [Payments::getController('cardcircuit', 'edit'), 'update'])->name('cardcircuits.update');
		Route::delete('{cardcircuit}/delete', [Payments::getController('cardcircuit', 'destroy'), 'destroy'])->name('cardcircuits.destroy');
	});

	Route::group(['prefix' => 'banks'], function()
	{
		Route::get('', [Payments::getController('bank', 'index'), 'index'])->name('banks.index');
		Route::get('create', [Payments::getController('bank', 'create'), 'create'])->name('banks.create');
		Route::post('', [Payments::getController('bank', 'store'), 'store'])->name('banks.store');
		Route::get('{bank}', [Payments::getController('bank', 'show'), 'show'])->name('banks.show');
		Route::get('{bank}/edit', [Payments::getController('bank', 'edit'), 'edit'])->name('banks.edit');
		Route::put('{bank}', [Payments::getController('bank', 'edit'), 'update'])->name('banks.update');
		Route::delete('{bank}/delete', [Payments::getController('bank', 'destroy'), 'destroy'])->name('banks.destroy');
	});

	Route::group(['prefix' => 'bankaccounts'], function()
	{
		Route::get('', [Payments::getController('bankaccount', 'index'), 'index'])->name('bankaccounts.index');
		Route::get('create', [Payments::getController('bankaccount', 'create'), 'create'])->name('bankaccounts.create');
		Route::post('', [Payments::getController('bankaccount', 'store'), 'store'])->name('bankaccounts.store');
		Route::get('{bankaccount}', [Payments::getController('bankaccount', 'show'), 'show'])->name('bankaccounts.show');
		Route::get('{bankaccount}/edit', [Payments::getController('bankaccount', 'edit'), 'edit'])->name('bankaccounts.edit');
		Route::put('{bankaccount}', [Payments::getController('bankaccount', 'edit'), 'update'])->name('bankaccounts.update');
		Route::delete('{bankaccount}/delete', [Payments::getController('bankaccount', 'destroy'), 'destroy'])->name('bankaccounts.destroy');
	});

	Route::group(['prefix' => 'paymenttypes'], function()
	{
		Route::get('', [Payments::getController('paymenttype', 'index'), 'index'])->name('paymenttypes.index');
		Route::get('create', [Payments::getController('paymenttype', 'create'), 'create'])->name('paymenttypes.create');
		Route::post('', [Payments::getController('paymenttype', 'store'), 'store'])->name('paymenttypes.store');
		Route::get('{paymenttype}', [Payments::getController('paymenttype', 'show'), 'show'])->name('paymenttypes.show');
		Route::get('{paymenttype}/edit', [Payments::getController('paymenttype', 'edit'), 'edit'])->name('paymenttypes.edit');
		Route::put('{paymenttype}', [Payments::getController('paymenttype', 'edit'), 'update'])->name('paymenttypes.update');

		Route::delete('{paymenttype}/delete', [Payments::getController('paymenttype', 'destroy'), 'destroy'])->name('paymenttypes.destroy');
	});

	Route::group(['prefix' => 'invoices'], function()
	{
		Route::get('', [Payments::getController('invoice', 'index'), 'index'])->name('invoices.index');

		//InvoiceByYearIndexController
		Route::get('by-year/{year}', [Payments::getController('invoice', 'byYear'), 'index'])->name('invoices.byYear');

		Route::get('create', [Payments::getController('invoice', 'create'), 'create'])->name('invoices.create');
		Route::post('', [Payments::getController('invoice', 'store'), 'store'])->name('invoices.store');

		//InvoiceGeneratePdfController
		Route::get('{invoice}/generate-pdf', [Payments::getController('invoice', 'generatePdf'), 'generatePdf'])->name('invoices.generatePdf');
		Route::get('{invoice}', [Payments::getController('invoice', 'show'), 'show'])->name('invoices.show');
		Route::get('{invoice}/edit', [Payments::getController('invoice', 'edit'), 'edit'])->name('invoices.edit');
		Route::put('{invoice}', [Payments::getController('invoice', 'edit'), 'update'])->name('invoices.update');

		Route::delete('{invoice}/delete', [Payments::getController('invoice', 'destroy'), 'destroy'])->name('invoices.destroy');

	});

	Route::group(['prefix' => 'deadlines'], function()
	{
		Route::get('export-bank-transfers', [Payments::getController('deadline', 'exportBankTransefers'), 'index'])->name('deadlines.exportBankTransefersIndex');

		//DeadlineExportCsvController
		Route::post('export-csv', [Payments::getController('deadline', 'exportCsv'), 'exportCsv'])->name('deadlines.exportCsv');

		Route::get('', [Payments::getController('deadline', 'index'), 'index'])->name('deadlines.index');
		Route::get('create', [Payments::getController('deadline', 'create'), 'create'])->name('deadlines.create');
		Route::post('', [Payments::getController('deadline', 'store'), 'store'])->name('deadlines.store');
		Route::get('{deadline}', [Payments::getController('deadline', 'show'), 'show'])->name('deadlines.show');
		Route::get('{deadline}/edit', [Payments::getController('deadline', 'edit'), 'edit'])->name('deadlines.edit');
		Route::put('{deadline}', [Payments::getController('deadline', 'edit'), 'update'])->name('deadlines.update');
		Route::delete('{deadline}/delete', [Payments::getController('deadline', 'destroy'), 'destroy'])->name('deadlines.destroy');
	});

	Route::group(['prefix' => 'invoiceables'], function()
	{
		Route::get('', [Payments::getController('invoiceable', 'index'), 'index'])->name('invoiceables.index');
		Route::get('create', [Payments::getController('invoiceable', 'create'), 'create'])->name('invoiceables.create');
		Route::post('', [Payments::getController('invoiceable', 'store'), 'store'])->name('invoiceables.store');
		Route::get('{invoiceable}', [Payments::getController('invoiceable', 'show'), 'show'])->name('invoiceables.show');
		Route::get('{invoiceable}/edit', [Payments::getController('invoiceable', 'edit'), 'edit'])->name('invoiceables.edit');
		Route::put('{invoiceable}', [Payments::getController('invoiceable', 'edit'), 'update'])->name('invoiceables.update');

		Route::delete('{invoiceable}/delete', [Payments::getController('invoiceable', 'destroy'), 'destroy'])->name('invoiceables.destroy');
	});





	Route::group(['prefix' => 'paymentables'], function()
{
	Route::get('', [Payments::getController('paymentable', 'index'), 'index'])->name('paymentables.index');
	// Route::get('create', [Payments::getController('paymentable', 'create'), 'create'])->name('paymentables.create');
	// Route::post('', [Payments::getController('paymentable', 'store'), 'store'])->name('paymentables.store');
	Route::get('{paymentable}', [Payments::getController('paymentable', 'show'), 'show'])->name('paymentables.show');
	Route::get('{paymentable}/edit', [Payments::getController('paymentable', 'edit'), 'edit'])->name('paymentables.edit');
	Route::put('{paymentable}', [Payments::getController('paymentable', 'edit'), 'update'])->name('paymentables.update');


	Route::delete('{paymentable}/delete', [Payments::getController('paymentable', 'destroy'), 'destroy'])->name('paymentables.destroy');
});


});
