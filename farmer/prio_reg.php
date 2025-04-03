<!DOCTYPE html>
<html lang="en">
<head>
<script src="https://cdn.botpress.cloud/webchat/v2.2/inject.js"></script>
<script src="https://files.bpcontent.cloud/2025/03/22/22/20250322221348-N1BQQ8PV.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Scheme Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 w-1/3">
        <h2 class="text-xl font-bold text-green-600 text-center">🌾 Farmer Registration</h2>
        <form action="../gov/register.php" method="POST" class="space-y-3 mt-4">
            <input type="text" name="name" placeholder="Farmer Name" required class="w-full p-3 border rounded-md">
            <input type="text" name="aadhaar" placeholder="Aadhaar Number" required class="w-full p-3 border rounded-md">
            <input type="number" name="income" placeholder="Annual Income" required class="w-full p-3 border rounded-md">
            <input type="number" name="land_size" placeholder="Land Size (Acres)" required class="w-full p-3 border rounded-md">
            <input type="number" name="previous_enrollments" placeholder="Previous Scheme Enrollments" required class="w-full p-3 border rounded-md">
            <input type="number" name="crop_losses" placeholder="Crop Loss Percentage" required class="w-full p-3 border rounded-md">
            <label class="block">
                <span>Debt Status:</span>
                <select name="debt_status" class="w-full p-3 border rounded-md">
                    <option value="yes">In Debt</option>
                    <option value="no">No Debt</option>
                </select>
            </label>
            <button type="submit" class="bg-green-500 text-white py-3 rounded-md hover:bg-green-600 transition w-full">Register</button>
        </form>
    </div>
</body>
</html>