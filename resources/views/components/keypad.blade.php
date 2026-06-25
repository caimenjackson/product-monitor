<div id="keypad-container" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-gray-300 p-6 rounded-lg shadow-lg w-80">
        <h2 class="text-2xl font-bold mb-4 text-center text-black">Enter Quantity</h2>
        <input type="text" id="quantityInput" readonly class="w-full mb-4 text-center p-2 border border-gray-300 rounded text-black">
        <div class="grid grid-cols-3 gap-2">
            <button class="key bg-blue-700 text-white p-4 rounded aspect-square" data-value="1">1</button>
            <button class="key bg-blue-700 text-white p-4 rounded aspect-square" data-value="2">2</button>
            <button class="key bg-blue-700 text-white p-4 rounded aspect-square" data-value="3">3</button>
            <button class="key bg-blue-700 text-white p-4 rounded aspect-square" data-value="4">4</button>
            <button class="key bg-blue-700 text-white p-4 rounded aspect-square" data-value="5">5</button>
            <button class="key bg-blue-700 text-white p-4 rounded aspect-square" data-value="6">6</button>
            <button class="key bg-blue-700 text-white p-4 rounded aspect-square" data-value="7">7</button>
            <button class="key bg-blue-700 text-white p-4 rounded aspect-square" data-value="8">8</button>
            <button class="key bg-blue-700 text-white p-4 rounded aspect-square" data-value="9">9</button>
            <button class="key bg-red-700 text-white p-4 rounded aspect-square" id="clear">CLEAR</button>
            <button class="key bg-blue-700 text-white p-4 rounded aspect-square" data-value="0">0</button>
            <button class="key bg-green-700 text-white p-4 rounded aspect-square" id="enter">ENTER</button>
        </div>
        <button id="close-keypad" class="mt-4 text-center bg-red-500 text-white p-2 rounded w-full">Cancel</button>
    </div>
</div>


