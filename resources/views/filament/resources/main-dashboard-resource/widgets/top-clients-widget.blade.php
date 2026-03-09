<x-filament::widget>
    <div class="w-full overflow-x-auto">
        <table class="table-auto w-full border rounded-lg">
            <thead>
            <tr class="bg-cyan text-white">
                <th class="p-2">Nom</th>
                <th class="p-2">Prénom</th>
                <th class="p-2">Total Solde</th>
            </tr>
            </thead>
            <tbody>
            @foreach($this->getClients() as $client)
                <tr class="border-b hover:bg-gray-100">
                    <td class="p-2">{{ $client->nom }}</td>
                    <td class="p-2">{{ $client->prenom }}</td>
                    <td class="p-2 soldeMasked">*****
                        <span class="hidden">{{ number_format($client->total_solde, 2, ',', ' ') }} MAD</span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <script>
        document.querySelectorAll('.soldeMasked').forEach(el => {
            el.addEventListener('click', () => {
                el.querySelector('span').classList.toggle('hidden');
                el.childNodes[0].nodeValue = el.querySelector('span').classList.contains('hidden') ? '***** ' : '';
            });
        });
    </script>
</x-filament::widget>
