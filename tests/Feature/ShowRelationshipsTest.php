<?php

namespace IlBronza\Payments\Tests\Feature;

use IlBronza\Payments\Http\Controllers\Parameters\RelationshipsManagers\InvoiceRelationManager;
use IlBronza\Payments\Models\Bank;
use IlBronza\Payments\Models\Invoice;
use IlBronza\Payments\Models\Invoiceable;
use IlBronza\Payments\Tests\TestCase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ShowRelationshipsTest extends TestCase
{
    public function test_all_existing_shows_can_build_their_relationships_and_table_fields(): void
    {
        $shows = 0;

        foreach (config('payments.models') as $parameters) {
            if (! $show = $parameters['controllers']['show'] ?? null) {
                continue;
            }

            $model = new $parameters['class']();
            $model->setRelation('target', null)->setRelation('paymentable', null);
            $controller = app($show);
            $controller->setModel($model);
            $manager = $controller->setRelationshipsManager();

            $this->assertNotFalse($manager, $show);
            $this->assertSame($parameters['relationshipsManagerClasses']['show'], get_class($manager));
            $this->assertNotEmpty($manager->getRelationships(), $show);

            foreach ($manager->getRelationships() as $relationship) {
                if ($relationship->renderAsTable()) {
                    $this->assertNotEmpty($relationship->getTableFieldsGroups(), $relationship->getName());
                } else {
                    $this->assertTrue(class_exists($relationship->getController()), $relationship->getName());
                }
            }

            $shows++;
        }

        $this->assertSame(11, $shows);
    }

    public function test_polymorphic_links_follow_the_related_models_configured_show(): void
    {
        // A host application's controller override must also be used in related teasers.
        config(['payments.models.bank.controllers.show' => 'App\\Http\\Controllers\\CustomBankShowController']);

        foreach (['invoiceable' => 'target', 'paymentable' => 'paymentable'] as $modelKey => $relation) {
            $class = config("payments.models.{$modelKey}.class");
            $model = new $class();
            $model->setRelation($relation, new Bank());
            $managerClass = config("payments.models.{$modelKey}.relationshipsManagerClasses.show");
            $manager = new $managerClass($model);

            $this->assertSame(
                'App\\Http\\Controllers\\CustomBankShowController',
                $manager->getRelationsParameters()[$relation]
            );
        }
    }

    public function test_missing_or_unmanaged_polymorphic_targets_do_not_break_parent_relations(): void
    {
        foreach ([null, new UnmanagedTarget(), new Bank()] as $target) {
            config(['payments.models.bank.controllers.show' => null]);

            foreach (['invoiceable' => ['target', 'invoice'], 'paymentable' => ['paymentable', 'paymenttype']] as $modelKey => [$relation, $parent]) {
                $class = config("payments.models.{$modelKey}.class");
                $model = new $class();
                $model->setRelation($relation, $target);
                $managerClass = config("payments.models.{$modelKey}.relationshipsManagerClasses.show");
                $manager = new $managerClass($model);

                $this->assertSame([$parent], $manager->getRelationshipsNamesArray());
            }
        }
    }

    public function test_external_relations_are_omitted_when_their_package_is_disabled_or_unconfigured(): void
    {
        foreach ([false, null] as $configuration) {
            foreach (['operators', 'products', 'clients'] as $package) {
                config([$package => $configuration === false ? ['enabled' => false] : []]);
            }

            foreach (['card' => ['cardtype', 'cardcircuit', 'bankaccount', 'assignments'], 'cardassignment' => ['card'], 'invoice' => ['deadlines', 'invoiceables', 'details']] as $modelKey => $relations) {
                $class = config("payments.models.{$modelKey}.class");
                $managerClass = config("payments.models.{$modelKey}.relationshipsManagerClasses.show");
                $manager = new $managerClass(new $class());

                $this->assertSame($relations, $manager->getRelationshipsNamesArray());
            }
        }
    }

    public function test_invoice_details_are_scoped_ordered_and_render_without_missing_crud_routes(): void
    {
        Schema::create('payments__invoice_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('invoice_id');
            $table->string('description');
            $table->integer('sorting_index');
            $table->decimal('quantity', 12, 4)->nullable();
            $table->decimal('unit_price', 12, 2)->nullable();
            $table->decimal('total_price', 12, 2)->nullable();
            $table->decimal('vat_rate', 5, 2)->nullable();
            $table->softDeletes();
        });

        $invoiceId = '00000000-0000-4000-8000-000000000001';
        DB::table('payments__invoice_details')->insert([
            ['id' => '00000000-0000-4000-8000-000000000002', 'invoice_id' => $invoiceId, 'description' => 'Second row', 'sorting_index' => 2],
            ['id' => '00000000-0000-4000-8000-000000000003', 'invoice_id' => $invoiceId, 'description' => 'First row', 'sorting_index' => 1],
            ['id' => '00000000-0000-4000-8000-000000000004', 'invoice_id' => 'another-invoice', 'description' => 'Unrelated row', 'sorting_index' => 0],
        ]);

        $invoice = new Invoice();
        $invoice->setRawAttributes(['id' => $invoiceId]);
        $details = (new InvoiceRelationManager($invoice))->getRelationships()->get('details');

        $this->assertSame(['First row', 'Second row'], $details->getElements()->pluck('description')->all());

        // Global defaults must not introduce links to CRUD actions which do not exist.
        config(['crud.realtionshipManagers.createButton' => true, 'crud.realtionshipManagers.associateButton' => true]);
        $details->prepare();

        $this->assertFalse($details->hasCreateButton());
        $this->assertFalse($details->hasAssociateButton());
        $this->assertFalse($details->hasSorting());
        $this->assertFalse($details->hasSelectRowCheckboxes());
        $this->assertStringContainsString('Descrizione', $details->render());

        $this->app['request']->headers->set('X-Requested-With', 'XMLHttpRequest');
        $response = $details->setTable();
        $this->assertSame(2, $response['recordsTotal']);
        $this->assertStringContainsString('First row', json_encode($response['data']));
        $this->assertStringNotContainsString('Unrelated row', json_encode($response['data']));
    }

    public function test_invoice_tables_can_build_with_their_index_controllers(): void
    {
        $invoice = new Invoice();
        $invoice->setRelation('invoiceables', collect());
        $invoice->setRelation('deadlines', collect());
        $manager = new InvoiceRelationManager($invoice);

        foreach (['invoiceables', 'deadlines'] as $relation) {
            $table = $manager->getRelationships()->get($relation);
            $table->prepare();
            $this->assertStringContainsString('<table', $table->render());
        }
    }

    public function test_invoiceable_table_can_render_an_orphaned_target_over_ajax(): void
    {
        $invoice = new Invoice();
        $invoice->setRawAttributes(['id' => '00000000-0000-4000-8000-000000000001', 'name' => 'INV-1']);
        $invoiceable = new Invoiceable();
        $invoiceable->setRawAttributes(['id' => '00000000-0000-4000-8000-000000000002']);
        $invoiceable->setRelation('invoice', $invoice)->setRelation('target', null);

        $relation = (new InvoiceRelationManager($invoice))->getRelationships()->get('invoiceables');
        $relation->setElements(collect([$invoiceable]));
        $this->app['request']->headers->set('X-Requested-With', 'XMLHttpRequest');
        $response = $relation->setTable();

        $this->assertSame(1, $response['recordsTotal']);
        $this->assertStringContainsString('INV-1', json_encode($response['data']));
    }
}

class UnmanagedTarget extends Model
{
}
