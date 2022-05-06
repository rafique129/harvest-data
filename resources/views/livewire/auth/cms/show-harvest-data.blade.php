<x-cms.layout>
    <x-cms.main-header heading="Harvest Data" />

    <main>
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <livewire:auth.cms.import-harvest-data />
            <!-- Replace with your content -->
            <div class="px-4 py-6 sm:px-0">
                <div class="border-4 border-dashed border-gray-200 rounded-lg h-auto">
                    <!-- This example requires Tailwind CSS v2.0+ -->
                    <div class="bg-gray-200 shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">My Harvest Data</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">It’s harvest time. If you have a feed of harvest data from a data supplier. You can import that CSV file, We will show all you harvest data in clean form.</p>
                        </div>

                        @forelse($counties as $county)

                        <div class="border-t border-gray-200">
                            <div class="px-4 py-3">
                                <div class="flex justify-between items-center">
                                    <strong>{{$county->name}}</strong>
                                    <strong class="text-gray-500">{{$county->created_at->diffForHumans()}}</strong>
                                </div>

                           </div>
                            <dl>

                                @forelse($county->crop_code_with_weights as $key => $data)
                                    @php

                                        $compareCode = [
                                            ' W' => 'Wheat',
                                            ' C' => 'Carrot',
                                            ' B' => 'Barley',
                                            ' M' => 'Maize',
                                            ' BE' => 'Beetroot',
                                            ' PO' => 'Potatoes',
                                            ' PA' => 'Parsnips',
                                            ' O' => 'Oats'
                                        ];

                                    @endphp
                                <div class="bg-gray-50 px-1 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">{{$compareCode[$data->crop_code]}}</dt>

                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{$data->weight}} %</dd>

                                </div>
                                @empty
                                <div class="text-center">
                                    Not found !</div>
                                @endforelse
                            </dl>
                        </div>
                        @empty
                        <div class="text-center py-16">
                            <strong>Data not found!</strong>
                        </div>
                        @endforelse
                    </div>

                </div>
            </div>
            <!-- /End replace -->
        </div>
    </main>
</x-cms.layout>
