<!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
{{-- <a href="{{route('auth.cms.dashboard')}}" class="{{request()->route()->getName() == 'auth.cms.dashboard' ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium block lg:inline md:inline"
aria-current="page">Dashboard</a> --}}
<a href="{{route('auth.cms.show-harvest-data')}}"
class="{{request()->route()->getName() == 'auth.cms.show-harvest-data' ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium block lg:inline md:inline">Harvest
Data</a>
