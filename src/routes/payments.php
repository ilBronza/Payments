<?php

use IlBronza\Payments\Payments;

Route::group([
	'middleware' => ['web', 'auth'],
	'prefix' => 'payments-manager',
	'as' => config('payments.routePrefix')
], function()
{

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