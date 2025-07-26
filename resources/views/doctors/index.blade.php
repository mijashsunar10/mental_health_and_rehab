@extends('template.template')

@section('pagecontent')
<div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Doctors List</h1>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('doctors.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add New Doctor</a>

        <div class="bg-white shadow-md rounded my-6">
            <table class="min-w-max w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Name</th>
                        <th class="py-3 px-6 text-left">NMC Number</th>
                        <th class="py-3 px-6 text-left">Hospital</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach($doctors as $doctor)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            {{ $doctor->name }}
                        </td>
                        <td class="py-3 px-6 text-left">
                            {{ $doctor->nmc_number }}
                        </td>
                        <td class="py-3 px-6 text-left">
                            {{ $doctor->doctorProfile->hospital ?? 'N/A' }}
                        </td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center">
                                <a href="{{ route('doctors.show', $doctor->id) }}" class="text-blue-500 mx-2">
                                    View
                                </a>
                                <a href="{{ route('doctors.edit', $doctor->id) }}" class="text-yellow-500 mx-2">
                                    Edit
                                </a>
                                <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 mx-2">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endsection