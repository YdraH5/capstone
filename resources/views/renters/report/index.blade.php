@section('title', 'Home')
@section('renters')
<x-renter-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight ">
            {{ __('Home') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col ">
                    <div class="flex justify-between bg-slate-200">
                        <div class="w-5/12 bg-gray-100 rounded-lg p-6 shadow-md ">
                            <h2 class="text-lg font-semibold mb-4">Pending Report</h2>
                            <table class="w-full table-auto rounded-lg">
                                <thead>
                                    <tr class="bg-neutral-400">
                                        <th class="w-1/3 px-4 py-2 text-left">Date</th>
                                        <th class="w-2/3 px-4 py-2 text-left">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border px-4 py-2">April 8, 2024</td>
                                        <td class="border px-4 py-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</td>
                                    </tr>
                                    <!-- Add more rows as needed -->
                                </tbody>
                            </table>
                        </div>
                        <div class="w-7/12 bg-gray-100 rounded-lg p-6 shadow-md ml-4">
                            <h2 class="text-lg font-semibold mb-4">Previous Report</h2>
                            <table class="w-full table-auto">
                                <thead>
                                    <tr class="bg-neutral-400">
                                        <th class="w-1/3 px-4 py-2 text-left">Date</th>
                                        <th class="w-2/3 px-4 py-2 text-left">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border px-4 py-2">April 1, 2024</td>
                                        <td class="border px-4 py-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</td>
                                    </tr>
                                    <!-- Add more rows as needed -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    @stop
</x-renter-layout>

