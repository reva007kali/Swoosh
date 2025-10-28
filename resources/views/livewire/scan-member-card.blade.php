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

    {{-- Instascan script --}}
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            let scanner = new Instascan.Scanner({
                video: document.getElementById('preview'),
                mirror: false
            });

            let currentCameraIndex = 0;
            let cameras = [];

            const qrResult = document.getElementById('qr-result');
            const qrContent = document.getElementById('qr-content');
            const errorMessage = document.getElementById('error-message');
            const switchButton = document.getElementById('switch-camera');

            scanner.addListener('scan', function (content) {
                console.log('QR Code detected:', content);
                qrContent.textContent = content;

                // redirect otomatis ke hasil QR code
                setTimeout(() => {
                    window.location.href = content;
                }, 800);
            });

            Instascan.Camera.getCameras().then(function (foundCameras) {
                if (foundCameras.length > 0) {
                    cameras = foundCameras;
                    scanner.start(cameras[currentCameraIndex]);
                } else {
                    errorMessage.textContent = 'Tidak ada kamera terdeteksi.';
                    errorMessage.classList.remove('hidden');
                }
            }).catch(function (e) {
                errorMessage.textContent = 'Gagal mengakses kamera: ' + e.message;
                errorMessage.classList.remove('hidden');
                console.error(e);
            });

            switchButton.addEventListener('click', function () {
                if (cameras.length > 1) {
                    currentCameraIndex = (currentCameraIndex + 1) % cameras.length;
                    scanner.start(cameras[currentCameraIndex]);
                } else {
                    errorMessage.textContent = 'Tidak ada kamera lain yang tersedia.';
                    errorMessage.classList.remove('hidden');
                }
            });
        });
    </script>
</div>
