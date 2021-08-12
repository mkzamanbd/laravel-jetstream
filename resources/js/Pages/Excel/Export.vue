<template>
    <app-layout title="Export Form Excel">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Export Form Excel
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <strong>Total {{ $page.props.asses_list.length }} records found!</strong>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mt-4">
 
                        <div class="alert flex flex-row items-center bg-green-200 p-4 rounded border-b-2 border-green-300">
                            <div class="alert-icon flex items-center bg-green-100 border-2 border-green-500 justify-center h-10 w-10 flex-shrink-0 rounded-full">
                            <span class="text-green-500">
                                <svg fill="currentColor" viewBox="0 0 20 20" class="h-6 w-6">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            </div>
                            <div class="alert-content ml-4">
                                <div class="alert-title font-semibold text-lg text-green-800">
                                    Success
                                </div>
                                <div class="alert-description text-sm text-green-600">
                                    Success
                                </div>
                            </div>
                        </div>




                        <div class="flex flex-col">
                            <div class="overflow-x-auto">
                                <div class="py-2 align-middle inline-block w-full">
                                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <!-- <x-auth-validation-errors class="mb-4" :errors="$errors" />
                                        <form action="{{ route('export-excel') }}" method="post" class="py-2">
                                            @csrf
                                            <button class="bg-white text-gray-800 font-bold rounded border-b-2 border-green-500 hover:border-green-600 hover:bg-green-500 hover:text-white shadow-md py-2 px-6 inline-flex items-center focus:outline-none">
                                                <span class="mr-2">{{ __('Export') }}</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-download" viewBox="0 0 16 16">
                                                    <path d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383z"/>
                                                    <path d="M7.646 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V5.5a.5.5 0 0 0-1 0v8.793l-2.146-2.147a.5.5 0 0 0-.708.708l3 3z"/>
                                                </svg>
                                            </button>
                                        </form> -->
                                        <table class="w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-200 text-black">
                                                <tr class="border-b border-gray-200">
                                                    <th class="text-left px-2 py-1 text-sm border-2 border-left border-gray-200">
                                                        SL
                                                    </th>
                                                    <th class="text-left px-2 py-1 text-sm border-2 border-left border-gray-200">
                                                        E-TIN
                                                    </th>

                                                    <th class="text-left px-2 py-1 text-sm border-2 border-left border-gray-200">
                                                        TIN Date
                                                    </th>
                                                    <th class="text-left px-2 py-1 text-sm border-2 border-left border-gray-200">
                                                        Name
                                                    </th>
                                                    <th class="text-left px-2 py-1 text-sm border-2 border-left border-gray-200">
                                                        Mobile
                                                    </th>

                                                    <th class="text-left px-2 py-1 text-sm border-2 border-left border-gray-200">
                                                        Address
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-300">
                                                <tr v-for="(item, index) in asses_list" :key="index" class="border-b border-gray-200 hover:bg-gray-100">
                                                    <td class="px-2 py-1 whitespace-nowrap text-sm border-2 border-left border-gray-200">
                                                        {{ index + 1 }}
                                                    </td>
                                                    <td class="px-2 py-1 text-left whitespace-nowrap text-sm border-2 border-left border-gray-200">
                                                        {{ item.e_tin }}
                                                    </td>
                                                    <td class="px-2 py-1 text-left whitespace-nowrap text-sm border-2 border-left border-gray-200">
                                                        {{ item.tin_date }}
                                                    </td>
                                                    <td class="px-2 py-1 text-left whitespace-nowrap text-sm border-2 border-left border-gray-200">
                                                        {{ item.asses_name }}
                                                    </td>
                                                    <td class="px-2 py-1 text-left whitespace-nowrap text-sm border-2 border-left border-gray-200">
                                                        {{ item.mobile || 'N/A' }}
                                                    </td>
                                                    <td class="px-2 py-1 text-left whitespace-nowrap text-sm border-2 border-left border-gray-200">
                                                        {{ item.address }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue'

    export default {
        props:{
            asses_list: {type: Array, required: true},
        },
        data(){
            return {}
        },
        components: {
            AppLayout
        },
        mounted(){
            console.log(this.asses_list)
        },
        methods:{}
    }
</script>