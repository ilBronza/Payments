<?php

namespace IlBronza\Payments\Http\Controllers\Cardassignments;

use IlBronza\CRUD\Traits\CRUDCreateStoreTrait;
use IlBronza\Payments\Models\CardAssignment;
use Illuminate\Http\Request;

class CardassignmentCreateStoreController extends CardassignmentCRUD
{
    use CRUDCreateStoreTrait;

    private const STORE_CONFIRMATION_FIELD = '_cardassignment_store_confirmed';

    public $allowedMethods = ['create', 'store'];

    public function getGenericParametersFile(): ?string
    {
        return config('payments.models.cardassignment.parametersFiles.create');
    }

    public function store(Request $request, ?string $model = null)
    {
        if(! $request->boolean(static::STORE_CONFIRMATION_FIELD))
            if($activeCardAssignment = $this->findConflictingActiveCardAssignment($request))
                return $this->getStoreConfirmationResponse($request, $activeCardAssignment);

        $request->request->remove(static::STORE_CONFIRMATION_FIELD);

        return $this->_store($request);
    }

    private function findConflictingActiveCardAssignment(Request $request): ?CardAssignment
    {
        if(! $request->filled('card_id'))
            return null;

        if(! $request->filled('utilizer_id'))
            return null;

        if(! $request->filled('starts_at'))
            return null;

        return $this->getModelClass()::query()
            ->notExpired()
            ->where('card_id', $request->input('card_id'))
            ->where('utilizer_id', '!=', $request->input('utilizer_id'))
            ->where(function ($query) use ($request)
            {
                $query->whereNull('ends_at')
                    ->orWhere('ends_at', '>', $request->input('starts_at'));
            })
            ->with('card', 'utilizer')
            ->orderByDesc('starts_at')
            ->first();
    }

    private function getStoreConfirmationResponse(Request $request, CardAssignment $activeCardAssignment)
    {
        $cardName = $activeCardAssignment->card?->getName() ?? $activeCardAssignment->card_id;
        $utilizerName = $activeCardAssignment->utilizer?->getName() ?? 'un altro utilizzatore';
        $startsAt = $request->input('starts_at');

        return view('crud::messages.confirmation', [
            'title' => 'Conferma assegnazione carta',
            'messages' => [
                'La carta <strong>' . e($cardName) . '</strong> risulta gia assegnata a <strong>' . e($utilizerName) . '</strong>.',
                'Procedendo, la vecchia assegnazione verra chiusa alla data di inizio indicata: <strong>' . e($startsAt) . '</strong>.',
            ],
            'description' => 'Vuoi confermare la nuova assegnazione?',
            'formAction' => $this->getStoreModelAction(),
            'formMethod' => 'POST',
            'hiddenParameters' => $request->except(['_token', static::STORE_CONFIRMATION_FIELD]),
            'confirmationField' => static::STORE_CONFIRMATION_FIELD,
            'confirmationValue' => 1,
            'confirmButtonText' => 'Conferma e procedi',
            'cancelUrl' => $this->getRouteUrlByType('create'),
            'cancelButtonText' => 'Annulla',
        ]);
    }
}
