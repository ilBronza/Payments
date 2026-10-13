# Payments

## Dati di fatturazione di un model

Il model `InvoicingData` salva `vat` (partita IVA), `rea_number`, `istat_code`,
`ateco_code`, `pubblica_amministrazione`, `sdi` e `split_payment`.
I codici sono stringhe nullable, per conservare zeri iniziali e separatori;
`pubblica_amministrazione` e `split_payment` sono booleani con valore iniziale `false`.

Eseguire `php artisan migrate` nell'applicazione per creare la tabella
`payments__invoicing_data`. Il model genera il proprio UUID e usa la relazione
polimorfica `invoicingDataable` per collegarsi a qualsiasi model con chiave UUID.

Per esporre una scheda di fatturazione dal model proprietario, aggiungere il trait:

```php
use IlBronza\Payments\Models\Traits\InteractsWithInvoicingData;

class Client extends Model
{
    use InteractsWithInvoicingData;
}
```

Creare o aggiornare i dati attraverso la relazione `MorphOne`:

```php
$dati = $cliente->invoicingData()->updateOrCreate([], [
    'vat' => '01234567890',
    'rea_number' => 'MI-1234567',
    'istat_code' => '015146',
    'ateco_code' => '62.10.00',
    'pubblica_amministrazione' => false,
    'sdi' => 'ABC1234',
    'split_payment' => false,
]);

$dati = $cliente->invoicingData;
$proprietario = $dati->invoicingDataable;
```

Per assegnare i dati a un model senza aggiungere il trait:

```php
$dati->invoicingDataable()->associate($model);
$dati->save();
```

Classe e tabella sono configurabili tramite `payments.models.invoicingData`.

## Conti bancari di un model

Il model `Bankaccount` salva `iban`, `abi`, `cab`, `account_number` e `bank_id`.
ABI e CAB sono stringhe nullable di cinque cifre, per conservare gli zeri iniziali;
i form del package validano questo formato. Non vengono ricavati automaticamente dall'IBAN.

Eseguire `php artisan migrate` nell'applicazione per aggiungere i nuovi campi e il
collegamento polimorfico opzionale `bankaccountable`. I conti esistenti restano
disponibili senza intestatario e mantengono il collegamento alle carte.

Per collegare uno o più conti a un model con chiave UUID, ULID o intera, aggiungere il trait:

```php
use IlBronza\Payments\Models\Traits\InteractsWithBankaccounts;

class Client extends Model
{
    use InteractsWithBankaccounts;
}
```

Creare il conto attraverso la relazione imposta automaticamente l'intestatario:

```php
$conto = $cliente->bankaccounts()->create([
    'iban' => 'IT60X0542811101000000123456',
    'abi' => '05428',
    'cab' => '11101',
    'account_number' => '000000123456',
]);

$conti = $cliente->bankaccounts;
$intestatario = $conto->bankaccountable;
```

Ogni conto può appartenere a un solo model; un model può avere più conti.
Per collegare un conto già esistente oppure rimuovere il collegamento:

```php
$conto->bankaccountable()->associate($cliente);
$conto->save();

$conto->bankaccountable()->dissociate();
$conto->save();
```

Il trait rispetta la classe configurata in `payments.models.bankaccount.class` e
fornisce `getRelatedBankaccountElements()` per i gestori delle relazioni CRUD.
Nel relationship manager del model ospite si può aggiungere:

```php
'bankaccounts' => [
    'controller' => config('payments.models.bankaccount.controllers.index'),
    'elementGetterMethod' => 'getRelatedBankaccountElements',
],
```
