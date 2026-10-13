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

