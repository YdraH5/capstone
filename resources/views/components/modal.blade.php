@props(['name','title'])
<div 
    x-data = "{ show : false, name : '{{$name}}' }"
    x-show = "show"
    x-on:open-modal.window="show = ($event.detail.name === name)"
    x-on:close-modal.window="show = false"
    x-on:keydown.escape.window = "show = false"
    style="display:none;"
    class="fixed z-50 inset-0">


    <div class="fixed inset-0 backdrop-blur-sm">

    {{-- modal body --}}
        <div class=" fixed inset-y-24 duration-150 ease-in-out z-10 right-0 bottom-0 left-0 flex justify-center shadow-inner w-full">
            <div class="container mx-auto w-11/12 md:w-2/3 max-w-lg">
                <div class="relative py-2 px-5 md:px-10 bg-white shadow-md rounded">
                    {{-- form header --}}
                    @if(isset($title))
                    <h1 class="py-3 flex items-center shadow">
                        {{$title}}
                    </h1> 
                    @endif
                    <div class="py-8">
                        {{$body}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>