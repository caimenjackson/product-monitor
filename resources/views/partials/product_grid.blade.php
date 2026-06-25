<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach ($products as $product)
        @php
            $totalRemaining = 0;
            $lastExpirationTime = null;
            $isSpecial = $product->category === 'special';
            $isOpen = $product->category === 'openfryers';
        @endphp

        @if ($isSpecial)
            <!-- Special Category Product -->
            <div class="bg-gray-900 shadow-md rounded-lg overflow-hidden relative flex items-center">
                @if ($product->batches->isNotEmpty() && $product->batches->last()->expires_at)
                    <div class="bg-green-500 text-white p-2 text-center w-1/4">
                        <p class="font-bold text-xl">{{ \Carbon\Carbon::parse($product->batches->last()->expires_at)->format('H:i') }}</p>
                    </div>
                @else
                    <div class="bg-gray-500 text-white p-2 text-center w-1/4">
                        <p class="font-bold text-xl">N/A</p>
                    </div>
                @endif
                <div class="bg-gray-800 text-white p-2 flex-1">
                    <p class="text-lg font-bold">{{ $product->name }}</p>
                </div>
                <div class="flex p-2 space-x-1">
                    <!-- Small buttons for Cook, Waste, and Sell -->
                    <button class="bg-orange-500 text-black btn btn-primary cook-button w-8 h-8 text-xs" data-product-id="{{ $product->id }}" data-quantity="1">C</button>
                    <button class="bg-red-500 text-black btn btn-primary waste-button w-8 h-8 text-xs" data-product-id="{{ $product->id }}" data-quantity="1">W</button>
                    <button class="bg-green-500 text-black btn btn-primary sell-button w-8 h-8 text-xs" data-product-id="{{ $product->id }}" data-quantity="1">S</button>
                </div>
            </div>
        @else
            <!-- Regular Product Display -->
            <div class="bg-gray-900 shadow-md rounded-lg overflow-hidden relative">
                <div class="bg-gray-800 text-white p-1 grid grid-cols-4">
                    <h5 class="text-xl font-bold">{{ $product->name }}</h5>
                    <p>Total Cooked: {{ $product->cooked }}</p>
                    <p>Total Wasted: {{ $product->wasted }}</p>
                    <p>Total Sold: {{ $product->sold }}</p>
                </div>

                <div class="p-1 grid grid-cols-4">
                    @foreach ($product->batches as $batch)
                        @php
                            $now = now();
                            $expirationTime = \Carbon\Carbon::parse($batch->expires_at);
                            $minutesUntilExpiration = $now->diffInMinutes($expirationTime, false);

                            $borderColor = $minutesUntilExpiration <= 0 ? 'red-500' : ($minutesUntilExpiration <= 10 ? 'yellow-500' : 'green-500');
                            $textColor = $minutesUntilExpiration <= 0 ? 'text-red-500' : ($minutesUntilExpiration <= 10 ? 'text-yellow-500' : 'text-green-500');

                            $remainingQuantity = $batch->quantity - ($batch->fresh_sold + $batch->expired_sold + $batch->waste);
                            $totalRemaining += $remainingQuantity;
                            $lastExpirationTime = $batch->expires_at;
                        @endphp

                        @if ($remainingQuantity > 0)
                            <div class="bg-white w-24 h-24 border-4 border-{{ $borderColor }} flex flex-col justify-between">
                                <div class="flex-grow flex flex-col justify-center items-center">
                                    <p class="{{ $textColor }} font-bold text-xl">{{ $remainingQuantity }}</p>
                                </div>
                                <div class="bg-{{ $borderColor }} p-1 text-center">
                                    <p class="text-white text-xl">{{ \Carbon\Carbon::parse($batch->expires_at)->format('H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    @if ($totalRemaining == 0 && $lastExpirationTime)
                        <div class="bg-white w-24 h-24 border-4 border-red-500 p-2 flex flex-col justify-between">
                            <div class="flex-grow flex flex-col justify-center items-center">
                                <p class="text-red-500 font-bold text-xl">0</p>
                            </div>
                            <div class="bg-red-500 p-1 text-center">
                                <p class="text-white text-lg">{{ \Carbon\Carbon::parse($lastExpirationTime)->format('H:i') }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="absolute top-10 right-0 bg-blue-800 text-white p-1 rounded-bl-lg w-24 h-24 flex flex-col justify-center items-center">
                    <p class="text-lg font-bold">On Hand</p>
                    <p class="text-xl font-bold">{{ $product->on_hand }}</p>
                </div>

                <div class="grid grid-cols-3">
                    <div class="p-1">
                        <button class="bg-orange-500 text-black btn btn-primary cook-button w-full py-2" data-product-id="{{ $product->id }}">Cook</button>
                    </div>
                    <div class="p-1">
                        <button class="bg-red-500 text-black btn btn-primary waste-button w-full py-2" data-product-id="{{ $product->id }}">Waste</button>
                    </div>
                    <div class="p-1">
                        <button class="bg-green-500 text-black btn btn-primary sell-button w-full py-2" data-product-id="{{ $product->id }}">Sell</button>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>
