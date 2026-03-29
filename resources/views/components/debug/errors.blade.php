<div class="bg-gray-800 p-4 rounded-lg mb-6 border-2 border-yellow-500 font-mono text-xs">
    <h3 class="text-yellow-500 mb-2 uppercase font-bold">// Debug de Errores:</h3>
    @foreach ($errors->getMessages() as $key => $messages)
        <div class="mb-2">
            <span class="text-indigo-400">Key:</span>
            <span class="text-white bg-indigo-900 px-1 rounded">"{{ $key }}"</span>
            <br>
            <span class="text-red-400 font-bold">Error:</span>
            <span class="text-gray-300 italic">{{ $messages[0] }}</span>
        </div>
    @endforeach

    @if($errors->isEmpty())
        <p class="text-gray-500 italic">No hay errores en el bolso actualmente.</p>
    @endif
</div>
