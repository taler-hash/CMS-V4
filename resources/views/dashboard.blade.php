@extends('layout.master')

@section('title','Dashboard')

@section('header','Dashboard')

@section('content')
    <div x-data="data" class="relative h-[calc(100%-3.5rem)] w-screen  bg-white flex text-gray-800">
        {{-- Links --}}

        {{-- Options --}}
        <div class="">
            <div 
                x-cloak
                x-bind:class="fullViewOption ? 'w-96 shadow-md shadow-gray-500 ' : 'w-32 shrink'"
                class="relative flex flex-col items-start transition-all h-full border-r overflow-x-hidden bg-white z-10 overflow-y-hidden pb-16 ">
                {{-- Option full trigger --}}
                <div class="pl-5 p-2 absolute bg-white w-full bottom-0">
                    <button x-on:click="fullViewOption = !fullViewOption" class="border rounded-md border-gray-300 p-1">
                        <svg x-show="!fullViewOption" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd" d="M3 9a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 9zm0 6.75a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75a.75.75 0 01-.75-.75z" clip-rule="evenodd" />
                        </svg> 
                        <svg x-show="fullViewOption" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd" d="M3 6.75A.75.75 0 013.75 6h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 6.75zM3 12a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 12zm0 5.25a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75a.75.75 0 01-.75-.75z" clip-rule="evenodd" />
                        </svg>  
                    </button>
                </div>
                {{-- Option Links --}}
                <div class=" flex grow flex-col items-start h-[50%] w-full pb-40"
                    x-bind:class="fullViewOption ? 'overflow-y-scroll' : ''">
                    <div x-cloak x-show="$store.global.isLoading" class="absolute w-full h-full z-50 top-0 bg-gray-100/50"></div>
                    <div class="grow p-3 h-fit w-full">
                        <template x-for="option in options">
                            <div class="w-full" >
                                <div class="flex items-center space-x-1  " >
                                    <span x-on:click="handleOption(option.optionId)" x-bind:class=" option.isOpen ? 'rotate-90': ''" class="text-[10px] transition-all cursor-pointer">▶</span>
                                    <div class="font-semibold  flex items-center">
                                        <p x-text="option.optionName"></p>
                                        <template x-if="fullViewOption && $store.global.supplier.length > 0 && !option.isOpen &&option.optionId === 1">
                                            <p x-text="$store.global.searchStringSupplier" class="p-1 rounded-lg border border-gray-300 bg-gray-200 ml-1"></p>
                                        </template>
                                    </div>
                                </div>
                                {{-- Supplier --}}
                                <template x-if="fullViewOption && option.optionId == 1 && option.isOpen">
                                    <div class="pl-3 border-b border-l border-gray-500">
                                        <div x-data="{showSearchSupplier:false}" class="pb-2 ">
                                            <div class="w-full relative flex items-center space-x-1">
                                                <label class="text-sm font-medium">Supplier</label>
                                                <button x-on:click="showSearchSupplier = !showSearchSupplier" class="font-bold p-1 bg-green-500 text-white rounded-md ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                                      </svg>                                                          
                                                </button>
                                            </div>
                                            <div x-init="$watch('showSearchSupplier',()=>{$nextTick(() => {showSearchSupplier ? $refs.searchSupplier.focus() : ''})})" x-show="showSearchSupplier" class="py-1">
                                                <input type="number" x-ref="searchSupplier" x-model="$store.global.searchStringSupplier" x-on:keyup.enter="$store.global.getAll()" class="border border-gray-300 rounded-lg p-1 text-sm font-bold w-full" placeholder="Search Supplier Number">
                                            </div>
                                            <div class="w-full my-1 ">
                                                <p x-text="$store.global.supplier.code.length > 1 ? `${$store.global.supplier.code} - ${$store.global.supplier.name}` : 'No Supplier Available'" class="rounded-lg text-sm font-bold" x-bind:class="$store.global.supplier.code.length > 1 ? 'border border-gray-300 p-1 w-full bg-gray-200' : ''"></p>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                {{-- Commission Rates --}}
                                <template x-if="fullViewOption && option.optionId == 2 && option.isOpen " class="">
                                    <div class="pl-3 border-l border-b pb-2 border-gray-500 w-full">
                                        <template x-if="$store.global.brandswithConcessionRates.length >= 1">
                                            <div class="">
                                                <div x-data="{showCommRateOption:false}" class="relative flex items-center space-x-1">
                                                    <p class="text-sm font-medium">Commission Rates </p>
                                                    <button x-on:click="showCommRateOption = true" class="font-bold p-1 bg-green-500 text-white rounded-md ">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                                          </svg>                                                          
                                                    </button>
                                                    {{-- Choices --}}
                                                    <div x-data="{searchStringCommRate:''}" x-on:click.outside="showCommRateOption = false" x-show="showCommRateOption" class="absolute top-7 bg-white z-10 rounded-lg w-full  overflow-x-hidden border border-gray-500 shadow-md shadow-gray-400">
                                                        <div x-init="$watch('showCommRateOption',()=>{$nextTick(() => { showCommRateOption ? $refs.searchInputCommRate.focus() : ''})})" class="w-full bg-white border-b border-gray-300 sticky top-0 p-1 px-2">
                                                            <input x-ref="searchInputCommRate" x-model="searchStringCommRate" type="text" class="px-1 text-sm w-full p-1 border border-gray-300 rounded-lg" placeholder="Search Comm Rate">
                                                        </div>
                                                        <template x-for="(commRate, index) in $store.global.filterCommRates(searchStringCommRate)">
                                                            <div class="">
                                                                <div 
                                                                    x-on:click="searchStringCommRate = ''; showCommRateOption = false ;$store.global.handleChooseCommRateOption(commRate.concession_rate)" 
                                                                   x-bind:class="$store.global.commissionRates.map((item)=>{ return item.concession_rate}).includes(commRate.concession_rate) ? 'bg-gray-300' : 'hover:bg-blue-500 bg-white hover:text-white'"
                                                                    class="p-1 px-2 border-b border-gray-300 font-bold cursor-pointer">
                                                                    <p x-text="`${100 - commRate.concession_rate} %`" class=""></p>
                                                                </div>
                                                            </div>
                                                        </template>
                                                        <template x-if="$store.global.filterCommRates(searchStringCommRate).length === 0">
                                                            <div class="px-2 py-1 border-b border-gray-300 text-sm font-bold flex-nowrap border-b border-gray-300 bg-gray-300 ">No Comm Rate Available</div>
                                                        </template>
                                                    </div>
                                                </div>
                                                <div class="pl-1 pb-1 border-b border-l border-gray-500">
                                                    options
                                                </div>
                                            </div>
                                        </template>
                                        <template x-if="$store.global.brandswithConcessionRates.length === 0" class="">
                                            <p class="text-sm font-bold">No Rates Available</p>
                                        </template>
                                    </div>
                                </template>
                                {{-- Charges --}}
                                <template x-if="fullViewOption && option.optionId == 3 && option.isOpen " class="">
                                    <div class="pl-3 pb-2 border-b border-l border-gray-500">
                                        <template x-for="charge in $store.global.charges">
                                            <div x-data="{showSubOption:false}" class="w-full mt-2">
                                                <div class="flex items-center space-x-1">
                                                    <p x-text="charge.chargeName" class="text-sm font-semibold"></p>
                                                    <span x-on:click="showSubOption = !showSubOption" x-bind:class=" showSubOption ? 'rotate-90': ''" class="text-[10px] transition-all cursor-pointer">▶</span>
                                                </div>
                                                <template x-if="showSubOption">
                                                    <div class="pl-2 pb-1 border-l border-b border-gray-500">
                                                        <label class="text-sm font-medium">Charge Type</label>
                                                        <select x-model="charge.chargeType" 
                                                            x-on:change="
                                                                charge.fixedValue = ''; 
                                                                charge.percentage = ''; 
                                                                charge.startMonth = ''; 
                                                                charge.endMonth = '';
                                                                charge.postingCycle = '';
                                                            " 
                                                            type="text" 
                                                            class="border border-gray-300 rounded-lg p-1 text-sm font-bold w-full capitalize bg-gray-200">
                                                            <option value="">Select Charge Type</option>
                                                            <option value="n/a">Not Available</option>
                                                            <option value="ltc">Lumped to Commission</option>
                                                            <option value="fixed">Fixed</option>
                                                            <option value="percent">Percentage</option>
                                                        </select>
                                                        <template x-if="(['fixed', 'percent']).includes(charge.chargeType)">
                                                            <div class="pl-2">
                                                                <template x-if="charge.chargeType === 'fixed'">
                                                                    <div class="w-full">
                                                                        <label class="text-sm font-medium">Fixed Value</label>
                                                                        <input type="number" x-model="charge.fixedValue" class="border border-gray-300 rounded-lg p-1 text-sm font-bold w-full uppercase bg-gray-200" placeholder="Input Fixed Value">
                                                                    </div>
                                                                </template>
                                                                <template x-if="charge.chargeType === 'percent'">
                                                                    <div class="w-full">
                                                                        <label class="text-sm font-medium"> Percentage</label>
                                                                        <input type="number" x-model="charge.percentage" class="border border-gray-300 rounded-lg p-1 text-sm font-bold w-full uppercase bg-gray-200" placeholder="Input Percentage">
                                                                    </div>
                                                                </template>
                                                                <div class="w-full">
                                                                    <label class="text-sm font-medium">Start Month</label>
                                                                    <input type="month" x-model="charge.startMonth" class="border border-gray-300 rounded-lg p-1 text-sm font-bold w-full uppercase bg-gray-200">
                                                                </div>
                                                                <div class="w-full">
                                                                    <label class="text-sm font-medium">End Month</label>
                                                                    <input type="month" x-model="charge.endMonth" class="border border-gray-300 rounded-lg p-1 text-sm font-bold w-full uppercase bg-gray-200">
                                                                </div>
                                                                <div class="w-full">
                                                                    <label class="text-sm font-medium">Posting Cycle</label>
                                                                    <select type="month" x-model="charge.postingCycle" class="border border-gray-300 rounded-lg p-1 text-sm font-bold w-full uppercase bg-gray-200">
                                                                        <option value="">Select Posting Cycle</option>
                                                                        <option value="weekly">Weekly</option>
                                                                        <option value="monthly">Monthly</option>
                                                                        <option value="annually">Annually</option>
                                                                    </select>
                                                                </div>
                                                                

                                                            </div>
                                                        </template>
                                                    </div>
                                                </template>
                                                
                                            </div>
                                        </template>
                                    </div>
                                </template>
                                {{-- Merchandise Assortment --}}
                                <template x-if="fullViewOption && option.optionId == 4 && option.isOpen">
                                    <div class="pl-3 pb-2 border-b border-l border-gray-500">
                                        <template x-if="$store.global.classCodes.length > 0 ">
                                            <div class="">
                                                <div class="flex items-center space-x-1">
                                                    <p class="text-sm font-medium">Class Code </p>
                                                    <button x-on:click="$store.global.handleAddClassCodeDescriptions()" class="font-bold p-1 bg-green-500 text-white rounded-md ">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                                          </svg>                                                          
                                                    </button>
                                                </div>
                                                <div class="pl-1 pb-1 border-b border-l border-gray-500">
                                                    <template x-for="(desc, index) in $store.global.classCodeDescriptions">
                                                        <div x-data="{showSubDepartment:false}" class="">
                                                            {{-- Department --}}
                                                            <div class="">
                                                            <p class="text-sm font-medium">Department </p>
                                                                <div x-data="{showDepartmentOption:false}"  class="relative w-full">
                                                                    {{-- Selected Option --}}
                                                                    <div class="flex items-center mb-2">
                                                                        <div x-on:click="showDepartmentOption = true" class="border border-gray-300 rounded-lg p-1 text-sm font-bold w-full cursor-pointer flex min-h-[2rem]">
                                                                            <p x-show="desc.group.no === null" class="text-gray-400 font-bold">Select Department</p>
                                                                            <p x-show="desc.group.no !== null" x-text="`${desc.group.no} - ${desc.group.name}`"></p>
                                                                        </div>
                                                                        <div class="flex items-center  rounded-lg border border-gray-300 ml-1">
                                                                            <button x-on:click="showSubDepartment = !showSubDepartment" class="border-x border-gray-300 p-1">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4 transition-all" x-bind:class="showSubDepartment ? ' rotate-180' : ''">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                                                                                </svg>
                                                                            </button>
                                                                            <button x-on:click="$store.global.handleRemoveDepartment(index)" class="p-1">
                                                                                ✖
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    {{-- Options --}}
                                                                    <div x-show="showDepartmentOption">
                                                                        <div x-data="{searchStringGroup:''}"  class="absolute top-[2rem] z-10 w-full bg-white rounded-lg  border border-gray-500 shadow-md shadow-gray-400 min-h-fit max-h-[12rem] overflow-y-auto overflow-x-hidden" x-on:click.outside="showDepartmentOption = false ">
                                                                            {{-- Search Bar --}}
                                                                            <div class="px-2 py-1 sticky top-0 bg-white border-b border-gray-300">
                                                                                <input x-model="searchStringGroup" type="text" class="border border-gray-300 w-full text-sm font-medium rounded-lg p-1" placeholder="Search...">
                                                                            </div>
                                                                            {{-- Choices --}}
                                                                            <template x-for="(group, groupIndex) in $store.global.filterGroup(searchStringGroup)">
                                                                                <div x-on:click=" 
                                                                                desc.group.no !== group.group_no ?
                                                                                ()=>  
                                                                                {
                                                                                    desc.group.no = group.group_no ;
                                                                                    desc.group.name = group.group_name ; 
                                                                                    showDepartmentOption = false;
                                                                                    showSubDepartment = true;
                                                                                    desc.dept = {no:'',name:''};
                                                                                    desc.class = {no:'',name:''};
                                                                                    desc.subClass = [];
                                                                                    $nextTick(()=>{searchStringGroup = ''})
                                                                                }
                                                                            :
                                                                                ()=>
                                                                                {
                                                                                    desc.group.no = '' ;
                                                                                    desc.group.name = '' ; 
                                                                                    showDepartmentOption = false;
                                                                                    showSubDepartment = true;
                                                                                    desc.dept = {no:'',name:''};
                                                                                    desc.class = {no:'',name:''};
                                                                                    desc.subClass = [];
                                                                                    $nextTick(()=>{searchStringGroup = ''})
                                                                                }
                                                                                    "
                                                                                    x-bind:class="$store.global.classCodeDescriptions.filter((item,ind)=> ind === index).map((item)=>{return item.group.no}).includes(group.group_no) ? ' bg-gray-300' : ' hover:text-white hover:bg-blue-500'"
                                                                                    class="px-2 py-1 border-b border-gray-300 text-sm font-bold flex-nowrap border-b border-gray-300 cursor-pointer ">
                                                                                    <p x-text="`${group.group_no} - ${group.group_name}`"></p>
                                                                                </div>
                                                                            </template>
                                                                            <template x-if="$store.global.filterGroup(searchStringGroup).length === 0">
                                                                                <div class="px-2 py-1 border-b border-gray-300 text-sm font-bold flex-nowrap border-b border-gray-300 bg-gray-300 ">No data Available</div>
                                                                            </template>
                                                                        </div>
                                                                    </div>
                                                                    {{-- Sub Department --}}
                                                                    <template x-if="showSubDepartment">
                                                                        <div x-data="{showClass:false}" class="pl-1 pb-1 border-b border-l border-gray-500">
                                                                            <p class="text-sm font-medium">Sub Department </p>
                                                                            <div x-data="{showSubDepartmentOption:false}">
                                                                                {{-- Selected Option --}}
                                                                                <div class="flex items-center mb-2">
                                                                                    <div x-on:click="showSubDepartmentOption = true" class="border border-gray-300 rounded-lg p-1 text-sm font-bold w-full cursor-pointer flex min-h-[2rem]">
                                                                                        <p x-show="desc.dept.no === null" class="text-gray-400 font-bold">Select Sub Department</p>
                                                                                        <template x-if="desc.dept.no !== null">
                                                                                            <p  x-text="`${desc.dept.no} - ${desc.dept.name}`"></p>
                                                                                        </template>
                                                                                    </div>
                                                                                    <div class="flex items-center  rounded-lg border border-gray-300 ml-1">
                                                                                        <button x-ref="CaretSubDepartment" x-on:click="showClass = !showClass" class="border-x border-gray-300 p-1">
                                                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4 transition-all" x-bind:class="showClass ? ' rotate-180' : ''">
                                                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                                                                                            </svg>
                                                                                        </button>
                                                                                        <button x-on:click="$store.global.handleEmptySubDepartment(index); showSubDepartment = false" class="p-1">
                                                                                            ✖
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                                {{-- Options --}}
                                                                                <div x-show="showSubDepartmentOption">
                                                                                    <div x-data="{searchStringDepartment:''}"  class="absolute z-10 w-full bg-white rounded-lg  border border-gray-500 shadow-md shadow-gray-400 min-h-fit max-h-[12rem] overflow-y-auto overflow-x-hidden" x-on:click.outside="showSubDepartmentOption = false ">
                                                                                        {{-- Search Bar --}}
                                                                                        <div class="px-2 py-1 sticky top-0 bg-white border-b border-gray-300">
                                                                                            <input x-model="searchStringDepartment" type="text" class="border border-gray-300 w-full text-sm font-medium rounded-lg p-1" placeholder="Search...">
                                                                                        </div>
                                                                                        {{-- Choices --}}
                                                                                        <template x-for="department in $store.global.filterDepartment(searchStringDepartment, index)">
                                                                                            
                                                                                            <div 
                                                                                            x-on:click=" 
                                                                                                desc.dept.no !== department.dept ?
                                                                                                    ()=>
                                                                                                    {
                                                                                                        desc.dept.no = department.dept ;
                                                                                                        desc.dept.name = department.dept_name ; 
                                                                                                        showSubDepartmentOption = false;
                                                                                                        showClass = true;
                                                                                                        desc.class = {no:'',name:''};
                                                                                                        desc.subClass = []
                                                                                                        setTimeout(()=>{searchStringDepartment = ''},100)
                                                                                                    }
                                                                                                :  
                                                                                                    ()=>
                                                                                                    {
                                                                                                        desc.dept.no = '' ;
                                                                                                        desc.dept.name = '' ; 
                                                                                                        showSubDepartmentOption = false;
                                                                                                        showClass = true;
                                                                                                        desc.class = {no:'',name:''};
                                                                                                        desc.subClass = []
                                                                                                        setTimeout(()=>{searchStringDepartment = ''},100)
                                                                                                    }
                                                                                                "
                                                                                                x-bind:class="desc.dept.no === department.dept ? 'cursor-default bg-gray-300' : 'cursor-pointer hover:text-white hover:bg-blue-500'"
                                                                                                class="px-2 py-1 border-b border-gray-300 text-sm font-bold flex-nowrap border-b border-gray-300 ">
                                                                                                <p x-text="`${department.dept} - ${department.dept_name}`"></p>
                                                                                            </div>
                                                                                            
                                                                                        </template>
                                                                                        <template x-if="$store.global.filterDepartment(searchStringDepartment,index).length === 0">
                                                                                            <div class="px-2 py-1 border-b border-gray-300 text-sm font-bold flex-nowrap border-b border-gray-300 bg-gray-300 ">No data Available</div>
                                                                                        </template>
                                                                                    </div>
                                                                                </div>
                                                                                {{-- Class --}}
                                                                                <template x-if="showClass">
                                                                                    <div x-data="{showSubClass:false}" class="pl-1 pb-1 border-b border-l border-gray-500">
                                                                                        <p class="text-sm font-medium">Class </p>
                                                                                        <div x-data="{showClassOption:false}">
                                                                                            {{-- Selected Option --}}
                                                                                            <div class="flex items-center mb-2">
                                                                                                <div x-on:click="showClassOption = true" class="border border-gray-300 rounded-lg p-1 text-sm font-bold w-full cursor-pointer flex min-h-[2rem]">
                                                                                                    <p x-show="desc.class.no.length === 0" class="text-gray-400 font-bold">Select Class</p>
                                                                                                    <template x-if="desc.class.no.length > 0">
                                                                                                        <p  x-text="`${desc.class.no} - ${desc.class.name}`"></p>
                                                                                                    </template>
                                                                                                </div>
                                                                                                <div class="flex items-center  rounded-lg border border-gray-300 ml-1">
                                                                                                    <button x-on:click="showSubClass = !showSubClass" class="border-x border-gray-300 p-1">
                                                                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4 transition-all" x-bind:class="showSubClass ? ' rotate-180' : ''">
                                                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                                                                                                        </svg>
                                                                                                    </button>
                                                                                                    <button x-on:click="$store.global.handleEmptyClass(index); showClass = false" class="p-1">
                                                                                                        ✖
                                                                                                    </button>
                                                                                                </div>
                                                                                            </div>
                                                                                            {{-- Options --}}
                                                                                            <div x-show="showClassOption">
                                                                                                <div x-data="{searchStringClass:''}"  class="absolute z-10 w-full bg-white rounded-lg  border border-gray-500 shadow-md shadow-gray-400 min-h-fit max-h-[12rem] overflow-y-auto overflow-x-hidden" x-on:click.outside="showClassOption = false ">
                                                                                                    {{-- Search Bar --}}
                                                                                                    <div class="px-2 py-1 sticky top-0 bg-white border-b border-gray-300">
                                                                                                        <input x-model="searchStringClass" type="text" class="border border-gray-300 w-full text-sm font-medium rounded-lg p-1" placeholder="Search...">
                                                                                                    </div>
                                                                                                    {{-- Choices --}}
                                                                                                    <template x-for="Class in $store.global.filterClass(searchStringClass, index)">
                                                                                                        <div 
                                                                                                        x-on:click=" 
                                                                                                            desc.class.no !== Class.class ?
                                                                                                                ()=>
                                                                                                                { 
                                                                                                                    desc.class.no = Class.class ;
                                                                                                                    desc.class.name = Class.class_name ; 
                                                                                                                    showClassOption = false;
                                                                                                                    showSubClass = true;
                                                                                                                    desc.subClass = [];
                                                                                                                    setTimeout(()=>{searchStringClass = ''},100)
                                                                                                                }
                                                                                                            :
                                                                                                                ()=>
                                                                                                                {
                                                                                                                    desc.class.no = '' ;
                                                                                                                    desc.class.name = '' ; 
                                                                                                                    showClassOption = false;
                                                                                                                    showSubClass = true;
                                                                                                                    desc.subClass = [];
                                                                                                                    setTimeout(()=>{searchStringClass = ''},100)
                                                                                                                }
                                                                                                            "
                                                                                                            x-bind:class="desc.class.no === Class.class && desc.class.name === Class.class_name ? 'cursor-default bg-gray-300' : 'cursor-pointer hover:text-white hover:bg-blue-500'"
                                                                                                            class="px-2 py-1 border-b border-gray-300 text-sm font-bold flex-nowrap border-b border-gray-300 ">
                                                                                                            <p x-text="`${Class.class} - ${Class.class_name}`"></p>
                                                                                                        </div>
                                                                                                    </template>
                                                                                                    <template x-if="$store.global.filterClass(searchStringClass,index).length === 0">
                                                                                                        <div class="px-2 py-1 border-b border-gray-300 text-sm font-bold flex-nowrap border-b border-gray-300 bg-gray-300 ">No data Available</div>
                                                                                                    </template>
                                                                                                </div>
                                                                                            </div>
                                                                                            {{-- Sub Class --}}
                                                                                            <template x-if="showSubClass">
                                                                                                <div class="pl-1 pb-1 border-b border-l border-gray-500">
                                                                                                    <p class="text-sm font-medium">Sub Class </p>
                                                                                                    <div class="relative" x-data="{showSubClassOption:false}">
                                                                                                        {{-- Choosen --}}
                                                                                                        <div x-on:click="showSubClassOption = true" class="border border-gray-300 w-full text-sm font-medium rounded-lg p-2 flex flex-wrap cursor-text">
                                                                                                            <p x-show="desc.subClass.length === 0" class="text-gray-400 font-bold">Select Sub Class</p>
                                                                                                            <template x-for="(subClass, subClassIndex) in desc.subClass">
                                                                                                                <div x-on:click.stop="desc.subClass.splice(subClassIndex , 1); showSubClassOption = false" class="p-1 border border-gray-300 rounded-md text-sm font-bold hover:bg-red-500 hover:text-white transition-all cursor-pointer">
                                                                                                                    <p x-text="`${subClass.no} - ${subClass.name}`"></p>
                                                                                                                </div>
                                                                                                            </template>
                                                                                                        </div>
                                                                                                        {{-- Options --}}
                                                                                                        <div x-show="showSubClassOption">
                                                                                                            <div x-data="{searchStringSubClass:''}" x-on:click.outside="showSubClassOption = false" class="absolute z-10 w-full bg-white rounded-lg  border border-gray-500 shadow-md shadow-gray-400 min-h-fit max-h-[12rem] overflow-y-auto overflow-x-hidden">
                                                                                                                {{-- Search Bar --}}
                                                                                                                <div class="px-2 py-1 sticky top-0 bg-white border-b border-gray-300">
                                                                                                                    <input x-model="searchStringSubClass" type="text" class="border border-gray-300 w-full text-sm font-medium rounded-lg p-1" placeholder="Search...">
                                                                                                                </div>
                                                                                                                {{-- Choices --}}
                                                                                                                <template 
                                                                                                                    x-for="(subClass, subClassIndex) in $store.global.filterSubClass(searchStringSubClass,index)">
                                                                                                                        <div
                                                                                                                            x-on:click="
                                                                                                                                desc.subClass.filter(item=>item.no.includes(subClass.subclass)).length > 0  ? desc.subClass = desc.subClass.filter((item)=> !item.no.includes(subClass.subclass) && !item.name.includes(subClass.sub_name)) : desc.subClass.push({no:subClass.subclass, name:subClass.sub_name});
                                                                                                                                showSubClassOption = false; 
                                                                                                                                searchStringSubClass = ''"
                                                                                                                            x-bind:class="desc.subClass.filter(item=>item.no.includes(subClass.subclass)).length > 0  ? 'cursor-default bg-gray-300' : 'cursor-pointer hover:text-white hover:bg-blue-500'"
                                                                                                                            class="px-2 py-1 border-b border-gray-300 text-sm font-bold flex-nowrap border-b border-gray-300 " 
                                                                                                                            x-text="`${subClass.subclass} - ${subClass.sub_name}`"></div>
                                                                                                                </template>
                                                                                                                <template x-if="$store.global.filterSubClass(searchStringSubClass,index).length === 0">
                                                                                                                    <div class="px-2 py-1 border-b border-gray-300 text-sm font-bold flex-nowrap border-b border-gray-300 bg-gray-300 ">No data Available</div>
                                                                                                                </template>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </template>
                                                                                        </div>
                                                                                    </div>
                                                                                </template>
                                                                            </div>
                                                                        </div>
                                                                    </template>
                                                                </div>
                                                            </div>
                                                            {{-- Product Cycle --}}
                                                            <div class="">
                                                                <p class="text-sm font-medium">Product Cycle</p>
                                                                <input x-model="desc.productCycle" type="text" class="border border-gray-300 rounded-lg p-1 text-sm font-bold w-full" placeholder="Input Product Cycle">
                                                            </div>
                                                            {{-- Timeline --}}
                                                            <div class="">
                                                                <p class="text-sm font-medium">Product Cycle</p>
                                                                <textarea row="3" x-model="desc.timeline" type="text" class="border border-gray-300 rounded-lg p-1 text-sm font-bold w-full" placeholder="Input Timeline">
                                                            </div>
                                                        </div> 
                                                    </template>
                                                </div>
                                            </div>
                                        </template>
                                        <template x-if="$store.global.classCodes.length === 0 ">
                                            <p class="text-sm font-bold">No Groups Available</p>
                                        </template>
                                    </div>
                                </template>
                                {{-- Stores --}}
                                <template x-if="fullViewOption && option.optionId == 5 && option.isOpen">
                                    <div class="pl-3 border-b border-l border-gray-500 w-full">
                                        <template x-if="$store.global.availableStores.length >= 1" class="">
                                            <div x-data="{showSearchStoresOption:false}" class="pb-2 w-full">
                                                <div class="w-full relative flex items-center space-x-1">
                                                    <label class="text-sm font-medium">Stores</label>
                                                    <button x-on:click="showSearchStoresOption = !showSearchStoresOption" class="font-bold p-1 bg-green-500 text-white rounded-md ">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                                                          </svg>                                                          
                                                    </button>
                                                    {{-- Choices --}}
                                                    <div x-data="{searchStringStores:''}" x-on:click.outside="showSearchStoresOption = false" x-show="showSearchStoresOption" class="absolute top-7 bg-white z-10 rounded-lg w-full  overflow-x-hidden border border-gray-500 shadow-md shadow-gray-400" style="">
                                                        <div x-init="$watch('showSearchStoresOption',()=>{$nextTick(() => { showSearchStoresOption ? $refs.searchInputCommRate.focus() : ''})})" class="w-full bg-white border-b border-gray-300 sticky top-0 p-1 px-2">
                                                            <input x-ref="searchInputCommRate" x-model="searchStringStores" type="text" class="px-1 text-sm w-full p-1 border border-gray-300 rounded-lg" placeholder="Search Comm Rate">
                                                        </div>
                                                        <template x-for="(commRate, index) in $store.global.filterStores(searchStringStores)">
                                                            <div class="">
                                                                <div x-on:click="searchStringStores = ''; showSearchStoresOption = false ;$store.global.handleChooseCommRateOption(commRate.concession_rate)" x-bind:class="$store.global.commissionRates.map((item)=>{ return item.concession_rate}).includes(commRate.concession_rate) ? 'bg-gray-300' : 'hover:bg-blue-500 bg-white hover:text-white'" class="p-1 px-2 border-b border-gray-300 font-bold cursor-pointer">
                                                                    <p x-text="`${100 - commRate.concession_rate} %`" class=""></p>
                                                                </div>
                                                            </div>
                                                        </template>
                                                        <template x-if="$store.global.filterCommRates(searchStringCommRate).length === 0">
                                                            <div class="px-2 py-1 border-b border-gray-300 text-sm font-bold flex-nowrap border-b border-gray-300 bg-gray-300 ">No Comm Rate Available</div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                        <template x-if="$store.global.availableStores.length === 0" class="">
                                            <p class="text-sm font-bold w-full">No Stores Available</p>
                                        </template>
                                    </div>
                                </template>
                                {{-- All --}}
                                <template x-if="fullViewOption && option.optionId == 6 && option.isOpen " class="">
                                    <div class="pl-3 pb-2 border-b border-l border-gray-500">
                                        <div class="w-full">
                                            <label class="text-sm font-medium">Representative Name</label>
                                            <input type="text" x-model="$store.global.inputs.representativeName" class="border border-gray-300 rounded-lg p-1 text-sm font-bold w-full capitalize bg-gray-200" placeholder="Input Representative Name">
                                        </div>
                                        <div class="w-full">
                                            <label class="text-sm font-medium">Representative Position</label>
                                            <input type="text" x-model="$store.global.inputs.representativePosition" class="border border-gray-300 rounded-lg p-1 text-sm font-bold w-full capitalize bg-gray-200" placeholder="Input Representative Position">
                                        </div>
                                        <div class="w-full">
                                            <label class="text-sm font-medium">Address</label>
                                            <input type="text" x-model="$store.global.inputs.address" class="border border-gray-300 rounded-lg p-1 text-sm font-bold w-full capitalize bg-gray-200" placeholder="Input Address">
                                        </div>
                                        <div class="w-full">
                                            <label class="text-sm font-medium">Start Date</label>
                                            <input type="date" x-model="$store.global.inputs.startDate" class="border border-gray-300 rounded-lg p-1 text-sm font-bold w-full uppercase bg-gray-200">
                                        </div>
                                        <div class="w-full">
                                            <label class="text-sm font-medium">End Date</label>
                                            <input type="date" x-model="$store.global.inputs.endDate" class="border border-gray-300 rounded-lg p-1 text-sm font-bold w-full uppercase bg-gray-200">
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>
                        <button x-on:click="console.log($store.global.classCodeDescriptions)" class="">fire</button>
                    </div>
                    {{-- Loading Bar --}}
                    <div x-cloak x-show.transition="$store.global.isLoading" class="absolute top-0 w-full h-1 bg-blue-500 animate-pulse">
                        
                    </div>
                    
                </div>
                
            </div>
        </div> 

        <!--Content-->
        <div  
            class="transition-all flex-1 p-4 shrink w-full h-full bg-gray-100">
            <div class=" w-full h-full bg-white border border-gray-300  flex flex-col overflow-hidden">
                <div class="grow h-[calc(100%-20rem)] w-full ">
                <template x-if="activeTab === 'rates'">
                    <!--table-->
                    <div class="h-full w-full overflow-auto">
                        <div class="h-full w-full overflow-x-auto min-h-full">
                            <table class="w-full text-sm text-left text-gray-500 ">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 sticky left-0 bg-gray-50">
                                            Charge Name
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Charge Description
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Category
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Price
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-white border-b ">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap sticky left-0 bg-white">
                                            Apple MacBook Pro 17"
                                        </th>
                                        <td class="px-6 py-4">
                                            Silver
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </template>
                {{-- Preview Data --}}
                <template x-if="activeTab === 'preview'">
                    <div class="h-full w-full overflow-auto overflow-x-hidden">
                        <div class="grid grid-cols-1 gap-1">
                            {{-- Information --}}
                            <div class="w-full p-1 ">
                                <p class="font-bold text-lg">Information</p>
                                <div class="pl-2">
                                    <table>
                                        <tbody>
                                            <tr >
                                                <td class="">Supplier Code</td> 
                                                <td class="pl-2"><span x-text="$store.global.supplier.code" class="pl-2 font-semibold"></span></td>
                                             </tr>
                                            <tr>
                                               <td class="">Supplier</td> 
                                               <td class="pl-2"><span x-text="$store.global.supplier.length === 0 ? '' : $store.global.supplier.name" class="pl-2 font-semibold"></span></td>
                                            </tr>
                                            <tr>
                                                <td class="">Representative Name</td> 
                                                <td class="pl-2"><span x-text="$store.global.inputs.representativeName.length === 0 ? '' : $store.global.inputs.representativeName" class="pl-2 font-semibold capitalize"></span></td>
                                             </tr>
                                             <tr>
                                                <td class="">Representative Position</td> 
                                                <td class="pl-2"><span x-text="$store.global.inputs.representativePosition.length === 0 ? '' : $store.global.inputs.representativePosition" class="pl-2 font-semibold capitalize"></span></td>
                                             </tr>
                                             <tr>
                                                <td class="">Address</td> 
                                                <td class="pl-2"><span x-text="$store.global.inputs.address.length === 0 ? '' : $store.global.inputs.address" class="pl-2 font-semibold capitalize"></span></td>
                                             </tr>
                                             <tr>
                                                <td class="">Start Date</td> 
                                                <td class="pl-2"><span x-text="$store.global.inputs.startDate.length === 0 ? '' : new Date($store.global.inputs.startDate).toLocaleDateString(undefined, {year: 'numeric',month: 'long',day: 'numeric'})" class="pl-2 font-semibold"></span></td>
                                             </tr>
                                             <tr>
                                                <td class="">End Date</td> 
                                                <td class="pl-2"><span x-text="$store.global.inputs.endDate.length === 0 ? '' : new Date($store.global.inputs.endDate).toLocaleDateString(undefined, {year: 'numeric',month: 'long',day: 'numeric'})" class="pl-2 font-semibold"></span></td>
                                             </tr>
                                             <tr>
                                                <td class="">Brands</td> 
                                                <td class="pl-2">
                                                    <div class="flex flex-wrap">
                                                        <template x-for="brand in $store.global.uniqueBrand()">
                                                            <div x-text="brand.length >= 1 ? brand.uda_value_desc : `${brand.uda_value_desc},`" class="pl-2 font-semibold"></div>
                                                        </template>
                                                    </div>
                                                </td>
                                             </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- Commission Rates --}}
                            <div class="w-full p-1 ">
                                <p class="font-bold text-lg"> Commission Rates</p>
                                <div class="pl-2 overflow-x-auto">
                                    <div class="flex space-x-1 ">
                                        <template x-for="rate in $store.global.commRates">
                                            <template x-if="rate.isPicked">
                                                <div class="p-2 border border-gray-300 min-w-[20rem] max-w-[20rem]">
                                                    <p class="font-medium">Rate</p>
                                                    <P x-text="`${rate.commission_rate}%`" class=" pl-2 font-bold"></P>
                                                    <p class="font-medium">Description</p>
                                                    <p x-text="rate.commissionDesc.length === 0 ? 'Not Available' :rate.commissionDesc" class="font-bold pl-2"></p>
                                                    <p class="font-medium">Brands</p>
                                                    <div class="">
                                                        <template x-for="brand in $store.global.brandswithConcessionRates">
                                                            <template x-if="brand.concession_rate === rate.commission_rate">
                                                                <template x-if="brand.isPicked">
                                                                    <div x-text="brand.uda_value_desc" class="font-bold p-1 border border-gray-300"></div>            
                                                                </template>
                                                            </template>
                                                        </template>
                                                    </div>
                                                </div>
                                            </template>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            {{-- Charges --}}
                            <div class="w-full p-1 ">
                                <p class="font-bold text-lg">Charges</p>
                                <div class="pl-2">
                                    <template x-for="charge in $store.global.charges">
                                        <div class="">
                                            <p x-text="charge.chargeName" class="font-semibold"></p>
                                            <div class="border-l border-gray-500 pl-2 mb-2">
                                                <div class="text-sm font-medium capitalize">Charge Type: <span class="font-bold" 
                                                    x-text="charge.chargeType === 'ltc' ? 'lumped to commission' : charge.chargeType === 'fixed' ? 'fixed' : charge.chargeType === 'percent' ? 'percentage' : charge.chargeType"></span></div>
                                                <template x-if="charge.fixedValue != ''">
                                                    <div class="text-sm font-medium"> Fixed Value: <span x-text="charge.fixedValue" class="font-bold"></span></div>
                                                </template>
                                                <template x-if="charge.percentage != ''">
                                                    <div class="text-sm font-medium"> Percentage: <span x-text="charge.percentage" class="font-bold"></span></div>
                                                </template>
                                                <template x-if="(['fixed','percent']).includes(charge.chargeType)">
                                                    <div class="">
                                                        <div class="text-sm flex space-x-1"> 
                                                            <p class="font-medium">Collect Month:</p> 
                                                            <template x-if="charge.startMonth && charge.endMonth">
                                                                <div class="">
                                                                    <span x-text="new Date(charge.startMonth).toLocaleDateString(undefined, {year: 'numeric',month: 'long'})" class="font-bold"></span>
                                                                    <span x-show="charge.startMonth !==  ''" class="font-bold">/</span>
                                                                    <span x-text="new Date(charge.endMonth).toLocaleDateString(undefined, {year: 'numeric',month: 'long'})" class="font-bold"></span>
                                                                </div>
                                                            </template>
                                                        </div>
                                                        <div class="text-sm font-medium capitalize"> Posting Cycle: <span x-text="charge.postingCycle" class="font-bold"></span></div>
                                                    </div>
                                                </template>
                                            </div>
                                       </div>
                                    </template>
                                </div>
                            </div>
                            {{-- Merchandise Assortment --}}
                            <div class="w-full p-1 ">
                                <p class="font-bold text-lg">Merchandise Assortment</p>
                                <div class="pl-2">
                                    <!--table-->
                                    <div class="h-full w-full overflow-auto">
                                        <div class="h-full w-full overflow-x-auto min-h-full">
                                            <table class="w-full text-sm text-left  ">
                                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                                    <tr>
                                                        <th scope="col" class="px-6 py-3 sticky left-0 bg-gray-50">
                                                            #
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 sticky left-12 bg-gray-50">
                                                            Dept/Sub-Dept/Class/Sub-Class
                                                        </th>
                                                        <th scope="col" class="px-6 py-3">
                                                            Merchandise Hierarchy Description
                                                        </th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <template x-for="(classCode, index) in $store.global.classCodeDescriptions">
                                                        <tr class="bg-white border-b ">
                                                            <th class="px-6 py-4 sticky left-0 bg-white">
                                                                <p x-text="index + 1" class=""></p>
                                                            </th>
                                                            <th scope="row" class="text-sm px-6 py-4 font-medium text-gray-900 whitespace-nowrap sticky left-12 bg-white">
                                                                <div class="flex items-center">
                                                                    <p x-text="classCode.group.no" class="after:content-['-']"></p>
                                                                    <p x-text="classCode.dept.no" class="after:content-['-']"></p>
                                                                    <p x-text="classCode.class.no" class="after:content-['-']"></p>
                                                                    <template x-for="subClass in classCode.subClass">
                                                                            <p x-text="subClass.no" class="after:content-['/']"></p>
                                                                    </template>
                                                                </div>
                                                            </th>
                                                            <th class="font medium px-6 py-4 w-full whitespace-nowrap">
                                                                <div class="flex items-center">
                                                                    <p x-text="classCode.group.name" class="after:content-['-']"></p>
                                                                    <p x-text="classCode.dept.name" class="after:content-['-']"></p>
                                                                    <p x-text="classCode.class.name" class="after:content-['-']"></p>
                                                                    <template x-for="subClass in classCode.subClass">
                                                                            <p x-text="subClass.name" class="after:content-['/']"></p>
                                                                    </template>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </template>
                                                </tbody>
                                            </table>
                                        </div>
                                </div>
                            </div>
                            {{-- Stores --}}
                            <div class="w-full p-1 ">
                                <p class="font-bold text-lg">Stores</p>
                            </div>
                        </div>
                    </div>
                </template>
                {{-- Live Contract --}}
                <template x-if="activeTab === 'contract'">
                    <div class="h-full w-full overflow-auto bg-lime-500">
                        Live Contract
                    </div>
                </template>
                </div>
                {{-- Tabs --}}
                <div class="shrink w-full bg-gray-100">
                    <ul class="flex space-x-1 text-xs font-bold border-t">
                        <li x-on:click="activeTab = 'rates'" x-bind:class="activeTab === 'rates' ?'bg-blue-600 font-bold text-white  border-gray-700 border-b cursor-default' : 'cursor-pointer'" class="p-2  ">
                            Contract Rates
                        </li>
                        <li  x-on:click="activeTab = 'assortment'" x-bind:class="activeTab === 'assortment' ? 'bg-blue-600 font-bold text-white  border-gray-700 border-b cursor-default' : 'cursor-pointer'" class="p-2  ">
                            Merch Assortment
                        </li>
                        <li x-on:click="activeTab = 'assignment'" x-bind:class="activeTab === 'assignment' ? 'bg-blue-600 font-bold text-white border-gray-700 border-b cursor-default' : 'cursor-pointer'" class="p-2  ">
                            Store Assignment
                        </li>
                        <li x-on:click="activeTab = 'target'" x-bind:class="activeTab === 'target' ? 'bg-blue-600 font-bold text-white  border-gray-700 border-b cursor-default' : 'cursor-pointer'" class="p-2 ">
                            Sales Target
                        </li>
                        <li x-on:click="activeTab = 'preview'" x-bind:class="activeTab === 'preview' ? 'bg-blue-600 font-bold text-white border-gray-700 border-b cursor-default' : 'cursor-pointer'" class="p-2  ">
                            Preview Data
                        </li>
                        <li x-on:click="activeTab = 'contract'" x-bind:class="activeTab === 'contract' ? 'bg-blue-600 font-bold text-white border-gray-700 border-b cursor-default' : 'cursor-pointer'" class="p-2  ">
                            Preview Contract
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script src="{{asset('/js/interceptor/axiosInterceptor.js')}}"></script>
    <script src="{{asset('/js/js.js')}}"></script>
    @endpush
@endsection