<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crop Recommendation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        async function getRecommendation(event) {
            event.preventDefault(); // Prevent form reload

            const formData = new FormData(document.getElementById('cropForm'));

            const response = await fetch("process.php", {
                method: "POST",
                body: formData
            });

            const result = await response.json(); // Get JSON response
            if (result.success) {
                document.getElementById("cropResult").innerHTML = `
                    <div class="p-6 bg-green-100 border-l-4 border-green-500 rounded-lg shadow-md">
                        <h3 class="text-2xl font-semibold text-green-700">🌱 Recommended Crop:</h3>
                        <p class="text-gray-900 text-3xl font-bold mt-2">${result.crop}</p>
                    </div>
                    <div class="mt-6 p-6 bg-gray-50 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold text-gray-700">📊 Inputs Taken:</h3>
                        <ul class="list-disc pl-6 text-gray-600 mt-2 space-y-1">
                            <li><strong>Nitrogen:</strong> ${result.inputs.N}</li>
                            <li><strong>Phosphorus:</strong> ${result.inputs.P}</li>
                            <li><strong>Potassium:</strong> ${result.inputs.K}</li>
                            <li><strong>Temperature:</strong> ${result.inputs.temperature} °C</li>
                            <li><strong>Humidity:</strong> ${result.inputs.humidity} %</li>
                            <li><strong>pH Level:</strong> ${result.inputs.ph}</li>
                            <li><strong>Rainfall:</strong> ${result.inputs.rainfall} mm</li>
                        </ul>
                    </div>
                `;
            } else {
                document.getElementById("cropResult").innerHTML = `<p class="text-red-500 text-lg">${result.error}</p>`;
            }
        }
    </script>
</head>
<body class="bg-green-50 flex justify-center items-center min-h-screen">
    <div class="bg-white p-10 rounded-2xl shadow-2xl w-full max-w-4xl flex space-x-10">
        
        <!-- Input Form -->
        <div class="w-1/2">
            <h2 class="text-3xl font-bold mb-6 text-center text-green-700">🌾 Crop Recommendation</h2>
            <form id="cropForm" class="space-y-4" onsubmit="getRecommendation(event)">
                <input type="number" name="N" placeholder="Nitrogen" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-green-400">
                <input type="number" name="P" placeholder="Phosphorus" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-green-400">
                <input type="number" name="K" placeholder="Potassium" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-green-400">
                <input type="text" name="temperature" placeholder="Temperature (°C)" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-green-400">
                <input type="text" name="humidity" placeholder="Humidity (%)" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-green-400">
                <input type="text" name="ph" placeholder="pH Level" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-green-400">
                <input type="text" name="rainfall" placeholder="Rainfall (mm)" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-green-400">
                <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition">
                    Recommend Crop
                </button>
            </form>
        </div>

        <!-- Result Section -->
        <div class="w-1/2" id="cropResult"></div>
        
    </div>
</body>
</html>
