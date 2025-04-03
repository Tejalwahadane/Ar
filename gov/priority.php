<?php
include '../db.php';

$result = $conn->query("SELECT * FROM farmers ORDER BY (100 - (5 * previous_enrollments) - (income / 20000) + (10 * crop_losses) + (15 * debt_status) - (5 * land_size)) DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Farmer Rankings</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="bg-white p-6 shadow-lg rounded-lg w-2/3 mx-auto">
        <h2 class="text-xl font-bold text-green-600">Ranked Farmers</h2>
        <table class="w-full mt-4 border">
            <tr class="bg-gray-200">
                <th class="p-2">Name</th>
                <th class="p-2">Aadhaar</th>
                <th class="p-2">Priority Score</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr class="border">
                    <td class="p-2"><?= $row['name'] ?></td>
                    <td class="p-2"><?= $row['aadhaar'] ?></td>
                    <td class="p-2"><?= $row['priority_score'] ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
<?php
include '../db.php';

// Fetch top farmers sorted by priority_score
$result = $conn->query("SELECT id, priority_score FROM farmers ORDER BY priority_score DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Farmer Rankings</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="bg-white p-6 shadow-lg rounded-lg w-2/3 mx-auto">
        <h2 class="text-xl font-bold text-green-600">Ranked Farmers</h2>
        <table class="w-full mt-4 border">
            <tr class="bg-gray-200">
                <th class="p-2">Rank</th>
                <th class="p-2">Anonymous ID</th>
                <th class="p-2">Priority Score</th>
            </tr>
            <?php 
            $rank = 1;
            while ($row = $result->fetch_assoc()) { ?>
                <tr class="border">
                    <td class="p-2"><?= $rank ?></td>
                    <td class="p-2">Farmer-<?= $row['id'] ?></td>
                    <td class="p-2"><?= $row['priority_score'] ?></td>
                </tr>
            <?php $rank++; } ?>
        </table>
    </div>
</body>
</html>