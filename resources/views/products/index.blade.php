<!-- resources/views/products.blade.php -->
<x-layout>

    <div class="mx-auto px-4">
        <div id="product-container">
            @include('partials.product_grid', ['products' => $products])
        </div>
    </div>

    <div class="flex justify-center items-center">
        <a href="{{ route('export.pdf') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-10 mt-5 rounded inline-flex items-center text-xl">
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
            const keypadContainer = document.getElementById('keypad-container');
            let currentProductId = null;
            let currentAction = null;

            function resetInput() {
                input.value = '';
            }

            document.body.addEventListener('click', function (event) {
                const isSpecial = event.target.getAttribute('data-quantity') === '1';

                if (event.target.classList.contains('cook-button') || 
                    event.target.classList.contains('waste-button') || 
                    event.target.classList.contains('sell-button')) {

                    event.preventDefault();
                    currentProductId = event.target.getAttribute('data-product-id');
                    currentAction = event.target.classList.contains('cook-button') ? 'cook' : 
                                    event.target.classList.contains('waste-button') ? 'waste' : 
                                    'sell';

                    if (isSpecial) {
                        // Directly perform the action with quantity 1 for special items
                        performAction(currentAction, currentProductId, 1);
                    } else {
                        // Show keypad for regular items
                        resetInput();
                        keypadContainer.classList.remove('hidden');
                    }
                }

                if (event.target.classList.contains('key')) {
                    const value = event.target.getAttribute('data-value');
                    if (value !== null) {
                        input.value += value;
                    }
                }

                if (event.target.id === 'clear') {
                    input.value = '';
                }

                if (event.target.id === 'enter') {
                    const quantity = input.value;
                    if (quantity && currentProductId && currentAction) {
                        performAction(currentAction, currentProductId, quantity);
                    }
                    keypadContainer.classList.add('hidden');
                }

                if (event.target.id === 'close-keypad') {
                    keypadContainer.classList.add('hidden');
                }
            });

            function performAction(action, productId, quantity) {
                let url;
                switch (action) {
                    case 'cook':
                        url = `/products/${productId}/cook`;
                        break;
                    case 'waste':
                        url = `/products/${productId}/waste`;
                        break;
                    case 'sell':
                        url = `/products/${productId}/sell`;
                        break;
                }

                fetch(url, {
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

            function refreshProductGrid() {
                fetch('{{ route('special.products.refresh') }}', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest' // To identify that this is an AJAX request
                    }
                })
                .then(response => {
                    if (response.redirected) {
                        // If the user is redirected (e.g., due to authentication), reload the page
                        window.location.href = response.url;
                    } else {
                        return response.text();
                    }
                })
                .then(html => {
                    if (html) {
                        document.getElementById('product-container').innerHTML = html;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }

            // Refresh every 10 seconds
            setInterval(refreshProductGrid, 1000);
        });
    </script>

</x-layout>
