@extends($layout)
@section('title','User')
@section('css')
 <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .scanner-container {
            margin: 20px auto;
            padding: 10px;
            max-width: 600px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        #reader {
            width: 100%;
            margin: 0 auto;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        #result {
            margin-top: 20px;
            font-size: 18px;
            color: green;
            font-weight: bold;
        }

        .error {
            color: red;
        }
    </style>   
@endsection
@section('content')

        <div class="page-content-wrapper py-3">
            @include('include.admin.alert')
			

           
           

            

			<div class="top-products-area product-list-wrap">
				<div class="container">
					<div class="row g-3">

                        <div class="col-12">
                            <div class="card single-product-card">
                                <div class="card-body">
                                    <div id="reader"></div>
                                    <div id="result"></div>
                                </div>
                            </div>
                        </div>
						
					</div>
				</div>
			</div>


			

		</div>
@section('js')
<script src="https://unpkg.com/html5-qrcode/html5-qrcode.min.js"></script>
<script>
        const reader = new Html5Qrcode("reader");
        const resultContainer = document.getElementById("result");
        let isScanned = false; // Flag to track if a scan has already occurred

        Html5Qrcode.getCameras()
            .then(cameras => {
                if (cameras.length > 0) {
                    // Try to select the back camera
                    const backCamera = cameras.find(camera => camera.label.toLowerCase().includes("back")) || cameras[0];

                    reader.start(
                        backCamera.id, // Use the ID of the back camera
                        {
                            fps: 10,
                            qrbox: {
                                width: 250,
                                height: 250
                            }
                        },
                        qrCodeMessage => {
                            if (isScanned) {
                                return; // Prevent further scanning if already scanned
                            }

                            // Set the flag to true to indicate the scan has been processed
                            isScanned = true;

                            // Display the scanned result and redirect immediately
                            const targetUrl = qrCodeMessage;
                            resultContainer.innerHTML = `Processing... Please wait.`;

                            setTimeout(() => {
                                window.location.href = targetUrl; // Redirect after scanning
                            }, 1000); // Redirect after 1 second

                            // Stop the scanner to prevent multiple scans
                            reader.stop().then(() => {
                                console.log("QR Code Scanner stopped.");
                            }).catch(err => {
                                console.error("Error stopping scanner:", err);
                            });
                        },
                        error => {
                            console.warn("QR Code scan error:", error);
                        }
                    ).catch(err => {
                        console.error("Error starting scanner:", err);
                        resultContainer.innerHTML = `<span class="error">Error starting scanner. Ensure camera access is enabled.</span>`;
                    });
                } else {
                    resultContainer.innerHTML = `<span class="error">No cameras found on this device.</span>`;
                }
            })
            .catch(err => {
                console.error("Error accessing cameras:", err);
                resultContainer.innerHTML = `<span class="error">Camera access denied or not supported.</span>`;
            });
    </script>
@endsection  

@endsection