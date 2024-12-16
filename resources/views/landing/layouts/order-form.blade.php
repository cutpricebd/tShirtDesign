<div class="mt-6 border-primary border-2 p-3 rounded" data-scroll-index="2">
    <h2 class="text-2xl md:text-4xl bg-yellow-300 text-center py-2 font-bold px-1 mb-3">অর্ডার করতে নিচের ফর্মটি সম্পূর্ণ পূরন করুন</h2>
    <form action="{{(($order_type ?? 'normal') == 'builder') ? route('landing.builderOrder', $landing->id) : route('landing.order', $product->id)}}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-10 checkoutForm">
       @csrf
       <input type="hidden" name="uu_id" class="uu_id" value="{{\Str::uuid()}}">

       <div>
          <div class="mb-4">
             <label class="block text-text_color text-sm font-bold mb-2">আপনার নাম *</label>
             <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline shipping_name information_field @error('name') border-red-500 @enderror" type="text" name="name" value="{{old('name')}}" placeholder="আপনার নাম *" required="">

             @error('name')
                 <span class="invalid-feedback block text-red-5" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">ফোন নম্বর*</label>
            <div class="grid grid-cols-5 gap-4">
               <div class="col-span-1 text-right pt-2">
                  +88
               </div>
               <input type="number" placeholder="ফোন নম্বর" name="mobile_number" value="{{old('mobile_number')}}" required="required" class="col-span-4 shadow appearance-none shipping_mobile_number information_field border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mobile_number @error('mobile_number') border-red-500 @enderror">
            </div>

            @error('mobile_number')
                <span class="invalid-feedback block text-red-5" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
         </div>
          <div class="mb-4">
             <label class="block text-text_color text-sm font-bold mb-2">বাসা/রোড নাম্বার, এলাকার নাম, থানা নাম *</label>
             <input class="shadow appearance-none border rounded w-full shipping_address information_field py-2 px-3 text-gray-700 leading-tight focus:shadow-outline @error('address') border-red-500 @enderror" type="text" name="address" value="{{old('address')}}" placeholder="বাসা/রোড নাম্বার, এলাকার নাম, থানা নাম *" required="">

             @error('address')
                 <span class="invalid-feedback block text-red-5" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
          </div>
          <div class="mb-4">
             <label class="block text-text_color text-sm font-bold mb-2">আপনার জেলা সিলেক্ট করুন*</label>
             <select name="state" class="form-control select_state w-full shipping_state information_field @error('state') border-red-500 @enderror" id="state" required>
                <option selected disabled>জেলা সিলেক্ট করুন</option>
                @foreach ($states as $state)
                    <option value="{{$state['name']}}">{{$state['name']}}</option>
                @endforeach
            </select>

            @error('state')
                <span class="invalid-feedback block text-red-5" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          {{-- <div class="mb-4">
             <label class="block text-text_color text-sm font-bold mb-2">আপনার শহর সিলেক্ট করুন*</label>
             <select name="city" class="form-control select_city w-full shipping_city information_field @error('state') border-red-500 @enderror" id="city">
                <option selected disabled>শহর সিলেক্ট করুন</option>
            </select>

            @error('state')
                <span class="invalid-feedback block text-red-5" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div> --}}

          @if(request()->getHost() == 'ladies.jacketbd.com')
          <div class="mb-4">
             <label class="block text-text_color text-sm font-bold mb-2">আপনার সাইজের বিবরণ লিখুন</label>

             <textarea name="note" class="shadow appearance-none rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline border-green-800 border-2" cols="30" rows="5"></textarea>
          </div>
          @endif
          {{-- <div class="mb-4">
             <label class="block text-text_color text-sm font-bold mb-2">আপনি যে নাম্বার থেকে পেমেন্ট করেছেন ওই নম্বর টি এইখানে দিন:</label>
             <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline @error('payment_number') border-red-500 @enderror" type="text" name="payment_number" value="{{old('payment_number')}}" placeholder="আপনি যে নাম্বার থেকে পেমেন্ট করেছেন ওই নম্বর টি এইখানে দিন:">

             @error('payment_number')
                 <span class="invalid-feedback block text-red-5" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
          </div> --}}

          <div class="mt-6 md:hidden">
            <button type="submit" class="text-center rounded-md border-2 bg-green-800 border-green-800 px-6 py-2 text-base font-medium text-white shadow-sm hover:bg-green-700 block w-full">Order Now</button>

            <p class="text-sm mt-2 text-red-500">ঢাকার বাইরে অর্ডার করলে ডেলিভারি চার্জ অবশ্যই অগ্রিম দিতে হবে এবং "ক্যাশ অন ডেলিভারি" তে প্রোডাক্ট নিতে হবে! Personal bKash + Nogod number(send money): 01674911639, Payment Number / Merchant Number(Make Payment): 01974322255</p>

            <p class="my-1 text-center font-semibold">অথবা</p>
            <a href="https://api.whatsapp.com/send?phone=8801784222266&text={{url()->current()}}&" target="_blank" class="bg-green-800 border border-transparent rounded-md py-1.5 px-2 md:px-4 md:inline-block items-center justify-center text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 w-full block text-center"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-5 h-5 inline-block"><path fill="currentColor" d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"></path></svg> <span class="hidden lg:inline-block">হোয়াটস্যাপ এ অর্ডার করুন:</span> 8801784222266
            </a>
         </div>
       </div>
       <div>
          <div class="py-2 md-py-6">
              <div class="flow-root">
                 <ul role="list" class="-my-6 divide-y divide-gray-200 listed_items">
                    <li class="flex py-6 default_item">
                       <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                          <img src="{{$product->img_paths['small']}}" alt="{{$product->name}}" class="h-full w-full object-cover object-center">
                       </div>
                       <div class="ml-4 flex flex-1 flex-col">
                          <div>
                             <div class="flex justify-between text-base font-medium">
                                <h3>
                                   {{$product->name}}

                                    <input type="hidden" name="meta[]" value="">
                                    <input type="hidden" class="selected_price" value="{{$product->first_price}}">
                                    <input type="hidden" name="product_id[]" value="{{$product->id}}">
                                    <input type="hidden" name="variation[]" value="">
                                </h3>
                                <p class="ml-4"><span class="product_price">{{$product->first_price}}</span> টাকা</p>
                             </div>
                          </div>
                          {{-- <div class="flex flex-1 items-end justify-between text-sm">
                             <p>Qty: 1</p>
                          </div> --}}
                          <div class="flex flex-1 items-end justify-between text-sm">
                            <div class="flex">
                                <button class="w-6 h-6 text-center border-2 border-red-500 cursor-pointer font-bold border-l-0 bg-red-500 text-white qty_btn" data-type="minus" type="button">-</button>
                                <input type="number" class="h-6 border-2 border-red-500 px-1 w-10 focus:outline-none text-center selected_qty" name="quantity[]" value="1" readonly>
                                <button class="w-6 h-6 text-center border-2 border-red-500 cursor-pointer font-bold border-r-0 bg-red-500 text-white qty_btn" data-type="plus" type="button">+</button>
                            </div>

                            <div class="flex">
                               <button type="button" class="font-medium text-red-400 hover:text-red-500 removeItem" onclick="return confirm('Are you sure to remove?');">
                                  <svg data-v-1caa4ad4="" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                     <path data-v-1caa4ad4="" stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>
                                  </svg>
                               </button>
                            </div>
                         </div>
                       </div>
                    </li>
                 </ul>
              </div>
          </div>
          <div class="border-t border-gray-200 py-2 xl:pt-2">
            <div class="overflow-auto">
                <table class="border-collapse table-auto w-full text-sm">
                   <tbody class="bg-white">
                      <tr class="border-t border-l">
                         <td class="border-b border-r px-2 py-2.5">সাবটোটাল</td>
                         <td class="border-b border-r px-2 py-2.5"><span class="product_total">{{$product->first_price}}</span> টাকা</td>
                      </tr>
                      <tr class="border-t border-l">
                         <td class="border-b border-r px-2 py-2.5">শিপিং</td>
                         <td class="border-b border-r px-2 py-2.5">
                            <div>
                               <div><input type="radio" id="odhd" class="shipping_charge" value="130" name="shipping_charge" checked> <label for="odhd" class="form-check-label">Outside Dhaka Home Delivery - 130 tk - 24/48H</label></div>
                               {{-- <div><input type="radio" id="odcd" class="shipping_charge" value="130" name="shipping_charge"> <label for="odcd" class="form-check-label">Outside Dhaka Courier Delivery - 130 tk - 24/48H</label></div> --}}
                               <div><input type="radio" id="idhd" class="shipping_charge" value="60" name="shipping_charge" disabled> <label for="idhd" class="form-check-label">Inside Dhaka Home Delivery - 60 tk - 24/48H</label></div>
                            </div>
                            <p class="text-red-500 mt-2">ডেলিভারি চার্জ আপনার প্রোডাক্ট এর ওজন এর ওপর বাড়তে বা কমতে পারে।</p>
                            <ul class="list-disc pl-4">
                               <li class="text-primary">From 0-500gm you will be charged 60 BDT in inside dhaka</li>
                               <li class="text-primary">500gm to 1kg you will be charged 70 BDT</li>
                               <li class="text-primary">1kg to 2kg you will be charged 90 BDT</li>
                               <li class="text-primary">And after 2kg for every kg you will be charged 15BDT</li>
                            </ul>
                         </td>
                      </tr>
                      <tr class="border-t border-l">
                         <td class="border-b border-r px-2 py-2.5">সর্বমোট</td>
                         <td class="border-b border-r px-2 py-2.5"><span class="grand_total">{{$product->first_price + 130}}</span> টাকা</td>
                      </tr>
                      <tr class="border-t border-l">
                         <td class="border-b border-r px-2 py-2.5">পেমেন্ট মাধ্যম</td>
                         <td class="border-b border-r px-2 py-2.5">
                            <div><input type="radio" id="payment_cod" value="cod" checked> <label for="payment_cod" class="form-check-label">Cash on Delivery</label></div>
                         </td>
                      </tr>
                   </tbody>
                </table>
             </div>

             <div class="mt-6 hidden md:block">
                <button type="submit" class="text-center rounded-md border-2 bg-green-800 border-green-800 px-6 py-2 text-base font-medium text-white shadow-sm hover:bg-green-700 block w-full">Order Now</button>

                <p class="font-semibold text-lg mt-2 text-red-500">ঢাকার বাইরে অর্ডার করলে ডেলিভারি চার্জ অবশ্যই অগ্রিম দিতে হবে এবং "ক্যাশ অন ডেলিভারি" তে প্রোডাক্ট নিতে হবে! Personal bKash + Nogod number(send money): 01674911639, Payment Number / Merchant Number(Make Payment): 01974322255</p>

                <p class="my-1 text-center text-xl">অথবা</p>
                <a href="https://api.whatsapp.com/send?phone=8801784222266&text={{url()->current()}}&" target="_blank" class="bg-green-800 border border-transparent rounded-md py-1.5 px-2 md:px-4 md:inline-block items-center justify-center text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 w-full block text-center"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-5 h-5 inline-block"><path fill="currentColor" d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"></path></svg> <span class="hidden lg:inline-block">হোয়াটস্যাপ এ অর্ডার করুন:</span> 8801784222266
                </a>
             </div>
          </div>
       </div>
    </form>
</div>
