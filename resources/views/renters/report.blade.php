@section('title', 'Home')
@section('renters')
<x-renter-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
                {{ __('REPORT') }}
            </h2>
            <div class="flex items-center">
              <button class="" x-data x-on:click="$dispatch('open-modal',{name:'add-report'})">
                @include('buttons.add')
            </button> 
            </div>
        </div>
    </x-slot>
      <x-modal name="add-report" title="Submit Report">
        <x-slot:body>
          <form id="modalForm" class="space-y-4"action="{{route('renters.report.create')}}"method="post">
              @csrf
              @method('post')
                <input type="number" name="user_id"value="{{Auth::user()->id}}"hidden> 
                  <div>
                    <label for="name" class="block font-medium opacity-70">Report Category</label>
                      <select name="report_category" id="cars" class="w-full h-10 rounded-lg opacity-50">
                        <option value="">Report Category</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="Room service">Room service</option>
                        <option value="Room service">Others</option>
                       </select>
                  </div>
                  <div>
                    <label for="email" class="block font-medium opacity-70">Description</label>
                      <textarea id="description" rows="4" class="w-full rounded-lg " name="description" placeholder="Complain description"></textarea>   
                    </div>
                    <div>
                      <!-- Hidden input for default value -->
                      <input type="hidden" name="is_anonymous" value="false">
                      <label class="inline-flex items-center">
                          <input type="checkbox" name="is_anonymous" value="true" class="rounded">
                          <span class="ml-2 text-gray-700">Submit anonymously</span>
                      </label>
                  </div>
                  <div class="flex justify-end">
                      <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                      <button  x-on:click="$dispatch('close-modal',{name:'add-apartment'})" type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close</button>
                  </div>
          </form>
          </x-slot:body>
        </x-modal>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="flex flex-col">
                          @livewire('view-report')
                        </div>
                    </div>
                </div>
            </div>

    @stop
</x-renter-layout>

