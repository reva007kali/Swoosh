<div class="flex flex-col items-center justify-center min-h-screen bg-gradient-to-b from-blue-50 to-blue-100 p-6">
    <div class="w-full max-w-sm bg-white shadow-lg rounded-2xl p-5 text-center">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Scan Member Card</h2>

        <div class="relative w-full aspect-square bg-gray-200 rounded-lg overflow-hidden">
            <video id="preview" class="absolute inset-0 w-full h-full object-cover"></video>

            <div id="camera-overlay" class="absolute inset-0 flex items-center justify-center">
                <div class="border-4 border-blue-500 w-48 h-48 animate-pulse rounded-lg"></div>
            </div>
        </div>

        <div id="qr-result" class="mt-4 text-sm text-gray-700">
            Hasil QR code: <span id="qr-content" class="font-medium text-blue-600">-</span>
        </div>

        <button id="switch-camera" 
                class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
            Ganti Kamera
        </button>

        <div id="error-message" class="mt-3 text-red-500 text-sm hidden"></div>
    </div>

</div>
