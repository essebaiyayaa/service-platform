@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-12">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-center mb-8 text-orange-600">Feedback Babysitter</h1>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Evaluation du Babysitter</h2>
            <p class="text-gray-600 mb-4">
                Access the feedback with URL parameters.
            </p>
            
            <div class="bg-orange-50 rounded-lg p-4 mb-4">
                <p class="text-sm text-orange-800">
                    <strong>URL Format:</strong> 
                    <code class="bg-orange-100 px-2 py-1 rounded text-xs">
                        /feedback/{demandeId}/{auteurId}/{cibleId}/client
                    </code>
                </p>
            </div>
            
            @if(isset($demandeId))
            <livewire:feedback-component 
                :demandeId="$demandeId" 
                :auteurId="$auteurId" 
                :cibleId="$cibleId" 
                :typeAuteur="$typeAuteur" 
            />
            @else
            <div class="text-center py-8 text-gray-500">
                <p>Please provide URL parameters to access the feedback form.</p>
                <p class="text-sm mt-2">Example: /feedback/babysitter/1/1/1/client</p>
            </div>
            @endif
        </div>
        
        <div class="mt-8 bg-orange-50 rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-2 text-orange-800">Usage:</h3>
            <ul class="list-disc list-inside space-y-1 text-sm text-orange-700">
                <li>The component will use babysitting-specific criteria</li>
                <li>Orange theme for the interface</li>
                <li>Criteria: Child relationship, Cleanliness, etc.</li>
                <li>cibleId must exist in babysitters table</li>
            </ul>
        </div>
    </div>
</div>
@endsection
