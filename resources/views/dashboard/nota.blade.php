@extends('dashboard.user.dashboard')
@section('title-user')
    Nota
@endsection
@section('user')
    <section>
        <div class="card">
            <div class="card-header">
                <h3>Scan Qr Code</h3>
            </div>
            <div class="card-body">
                {{-- <input type="file" id="qr-file-input">/ --}}
                {{-- <p id="result"></p> --}}
                <div class="mb-3">
                    <label for="formFile" class="form-label">Upload Qr Code Nota Anda</label>
                    <input class="form-control" type="file" id="qr-file-input">
                </div>
                <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
                <script>
                    document.getElementById('qr-file-input').addEventListener('change', function(event) {
                        const file = event.target.files[0];
                        const reader = new FileReader();

                        reader.onload = function(event) {
                            const img = new Image();
                            img.onload = function() {
                                const canvas = document.createElement('canvas');
                                const context = canvas.getContext('2d');
                                canvas.width = img.width;
                                canvas.height = img.height;
                                context.drawImage(img, 0, 0, img.width, img.height);
                                const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                                const code = jsQR(imageData.data, imageData.width, imageData.height);

                                if (code) {
                                    // document.getElementById('result').innerText = 'QR Code detected: ' + code.data;
                                    // Redirect to the scanned URL
                                    window.location.href = code.data;
                                }
                            };
                            img.src = event.target.result;
                        };
                        reader.readAsDataURL(file);
                    });
                </script>
            </div>
        </div>
    </section>
@endsection
