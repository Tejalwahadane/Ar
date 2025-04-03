function fetchWeather() {
    let city = $("#city").val().trim();
    if (!city) return alert("Please enter a city!");

    $.getJSON("fetch_data.php?city=" + city, function (data) {
        updateWeatherUI(city, data);
    });
}

function detectLocation() {
    $.getJSON("get_location.php", function (locationData) {
        if (locationData.city) {
            $("#city").val(locationData.city);
            fetchWeather();
        } else {
            alert("Could not detect location.");
        }
    });
}

function updateWeatherUI(city, data) {
    if (data.error) {
        alert(data.error);
        return;
    }

    $("#locationName").text(city);
    $("#weatherInfo").removeClass("hidden");

    let days = data.map(d => d.day);
    let temperatures = data.map(d => d.temperature);
    let humidities = data.map(d => d.humidity);
    let pressures = data.map(d => d.pressure);

    createChart("temperatureChart", "Temperature (°C)", days, temperatures, "rgba(255, 99, 132, 1)");
    createChart("humidityChart", "Humidity (%)", days, humidities, "rgba(54, 162, 235, 1)");
    createChart("pressureChart", "Pressure (hPa)", days, pressures, "rgba(255, 206, 86, 1)");
}

document.getElementById("getWeatherBtn").addEventListener("click", function () {
    setTimeout(() => {
        document.querySelector(".weather-details").classList.add("show");
        document.querySelector(".weather-details").scrollIntoView({ behavior: "smooth" });
    }, 800); // Delay to ensure smooth transition
});

// Graph Animation Effect
function createChart(canvasId, label, labels, data, color) {
    let ctx = document.getElementById(canvasId).getContext("2d");
    new Chart(ctx, {
        type: "line",
        data: {
            labels: labels,
            datasets: [{
                label: label,
                data: data,
                borderColor: color,
                backgroundColor: color.replace("1)", "0.2)"),
                borderWidth: 5,
                fill: true,
                tension: 0.3,
                pointBorderColor: "#fff",
                pointBackgroundColor: color,
                pointRadius: 5,
            }]
        },
        options: {
            animation: {
                duration: 1200, // Smooth animation on load
                easing: "easeInOutQuart",
            },
            responsive: true,
            plugins: {
                legend: { labels: { font: { size: 16, weight: "bold" }, color: "#fff" } }
            },
            scales: {
                x: { grid: { display: false }, ticks: { color: "#ddd" } },
                y: { grid: { color: "rgba(255, 255, 255, 0.2)" }, ticks: { color: "#fff" } }
            }
        }
    });
}


// Apply new colors
createChart("temperatureChart", "Temperature (°C)", tempLabels, tempData, "#8A2BE2"); // Purple/Violet
createChart("humidityChart", "Humidity (%)", humidityLabels, humidityData, "#003366"); // Dark Navy Blue


