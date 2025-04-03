<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🌾 AgriWeather Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-900 text-white transition-all duration-300">

    <!-- Hero Section -->
    <div class="flex flex-col items-center justify-center h-screen bg-gradient-to-r from-green-400 via-green-500 to-green-700">
        <h1 class="text-5xl font-bold text-white mb-4">🌱 AgriWeather Dashboard</h1>
        <p class="text-lg text-gray-200 mb-6">Real-time weather insights for better farming decisions.</p>

        <div class="flex space-x-4">
            <input type="text" id="city" class="p-3 w-72 rounded-lg border-none outline-none text-black" placeholder="Enter city name">
            <button onclick="fetchWeather()" class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">Get Weather</button>
            <button onclick="detectLocation()" class="px-6 py-3 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition">Detect Location</button>
        </div>
    </div>

    <!-- Weather Info Section -->
    <div id="weatherInfo" class="hidden mt-6 mb-16 container mx-auto px-6">
        <h2 class="text-center text-3xl font-semibold text-green-300 mb-8">Weather in <span id="locationName"></span></h2>

        

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Temperature Card -->
            <div class="bg-gradient-to-br from-red-500 to-orange-500 p-6 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300">
                <h3 class="text-xl font-semibold text-white mb-2">🌡 Temperature</h3>
                <canvas id="temperatureChart"></canvas>
            </div>

            <!-- Humidity Card -->
            <div class="bg-gradient-to-br from-blue-500 to-cyan-500 p-6 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300">
                <h3 class="text-xl font-semibold text-white mb-2">💧 Humidity</h3>
                <canvas id="humidityChart"></canvas>
            </div>

            <!-- Pressure Card -->
            <div class="bg-gradient-to-br from-yellow-500 to-amber-500 p-6 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300">
                <h3 class="text-xl font-semibold text-white mb-2">🌀 Pressure</h3>
                <canvas id="pressureChart"></canvas>
            </div>
        </div>
    </div>

    <script src="assets/script.js"></script>
</body>
</html>
