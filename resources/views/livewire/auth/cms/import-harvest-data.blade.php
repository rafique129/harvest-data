<div>
    <div class="flex justify-between items-center px-4 lg:px-0 md:px-0">
        <div>
            @error('file')
            <div class="bg-red-300 text-gray-900 p-2 border border-gray-200 rounded-md font-medium ">
                {{$message}}
            </div>
            @enderror
        </div>
      <div>
        <button  onclick="document.getElementById('csv').click()"
        class="group relative  flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        Import CSV
    </button>
    <input hidden type="file" id="csv" wire:model='file' accept=".csv"/>
      </div>
    </div>
</div>
