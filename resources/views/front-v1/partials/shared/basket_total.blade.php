<a href="{{ route('cart.index') }}"
   title="سبد خرید"
   role="button"
   class="bg-lightgreen mx-1 py-2 px-2 text-dark rounded"
>
    <i class="far fa-shopping-cart fa-2x align-middle"></i>
    {{--SHOW TOTAL PRICE OF CART--}}
    @if(session()->get('total'))
        <span
            class="border border-dark rounded px-2 ">{{ session()->get('total')['count'] }}</span>
        <span
            class="mr-2"> {{ number_format(session()->get('total')['final_price']) }} تومن</span>
    @else

        <span class="border border-dark rounded px-2 ">0</span>
        <span class="mr-2"> 0 تومن </span>
    @endif
</a>
