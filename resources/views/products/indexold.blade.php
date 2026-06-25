<!-- resources/views/products.blade.php -->
<x-layout>

    <div class="mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($products as $product)
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="bg-gray-800 text-white p-2 grid grid-cols-4">
                        <h5 class="text-xl font-bold">{{ $product->name }}</h5>
                        <p>Total Cooked: {{ $product->cooked }}</p>
                        <p>Total Wasted: {{ $product->wasted }}</p>
                        <p>Total Sold: {{ $product->sold }}</p>
                    </div>
                    <div class="p-4 grid grid-cols-4 gap-4">
                    @foreach ($product->batches as $batch)
                        @php
                            $now = now(); // Current time
                            $expirationTime = $batch->expires_at; // Expiration time

                            // Ensure both are Carbon instances
                            $expirationTime = \Carbon\Carbon::parse($expirationTime);
                            $minutesUntilExpiration = $now->diffInMinutes($expirationTime, false); // Use the `false` flag to get a signed result

                            // Determine border and text color
                            $borderColor = $minutesUntilExpiration <= 0 ? 'red-500' : ($minutesUntilExpiration <= 10 ? 'yellow-500' : 'green-500');
                            $textColor = $minutesUntilExpiration <= 0 ? 'text-red-500' : ($minutesUntilExpiration <= 10 ? 'text-yellow-500' : 'text-green-500');
                        @endphp

                        <div class="w-24 h-24 border-4 border-{{ $borderColor }} p-2 rounded-lg flex flex-col justify-between">
                            <div class="flex-grow flex flex-col justify-center items-center">
                                <p class="{{ $textColor }} font-bold text-xl">{{ $batch->quantity }}</p>
                            </div>
                            <div class="bg-{{ $borderColor }} p-1 text-center rounded-b-lg ">
                                <p class="text-white text-xs">{{ $batch->expires_at->format('H:i') }}</p>
                            </div>
                        </div>
                    @endforeach
                    </div>

                    <div class="grid grid-cols-3">
                        <div class="p-4">
                            <button class="bg-orange-500 text-black btn btn-primary cook-button w-full py-2" data-product-id="{{ $product->id }}">Cook</button>
                        </div>
                        <div class="p-4">
                            <button class="bg-red-500 text-black btn btn-primary cook-button w-full py-2" data-product-id="{{ $product->id }}">Waste</button>
                        </div>
                        <div class="p-4">
                            <button class="bg-green-500 text-black btn btn-primary cook-button w-full py-2" data-product-id="{{ $product->id }}">Sell</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="flex justify-center items-center">
        <a href="/" class="bg-green-500 hover:bg-green-600 text-white font-bold py-5 px-10 mt-5 rounded inline-flex items-center text-xl">
            <svg class="fill-current w-10 h-10 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M10 15l-5-5h3V5h4v5h3l-5 5z"/>
            </svg>
            Export Paper Chart
        </a>
    </div>

    <!-- Include the keypad component -->
    <x-keypad />

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('quantityInput');
        const keys = document.querySelectorAll('.key');
        const keypadContainer = document.getElementById('keypad-container');
        const closeKeypad = document.getElementById('close-keypad');
        let currentProductId = null;

        // Function to reset the input value when the keypad is opened
        function resetInput() {
            input.value = '';
        }

        // Handle clicking on the cook buttons
        const cookButtons = document.querySelectorAll('.cook-button');
        cookButtons.forEach(function(button) {
            button.addEventListener('click', function () {
                currentProductId = this.getAttribute('data-product-id');
                resetInput();  // Reset the input field when the keypad is shown
                keypadContainer.classList.remove('hidden');
            });
        });

        // Handle keypad number button clicks
        keys.forEach(key => {
            key.addEventListener('click', function () {
                const value = this.getAttribute('data-value');
                if (value !== null) {
                    input.value += value;
                }
            });
        });

        // Handle clear button click
        document.getElementById('clear').addEventListener('click', function () {
            input.value = '';
        });

        // Handle enter button click
        document.getElementById('enter').addEventListener('click', function () {
            const quantity = input.value;
            if (quantity && currentProductId) {
                fetch(`/products/${currentProductId}/cook`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ quantity: quantity })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
            }
            keypadContainer.classList.add('hidden');
        });

        // Handle close button click
        closeKeypad.addEventListener('click', function () {
            keypadContainer.classList.add('hidden');
        });
    });
    </script>
</x-layout>
