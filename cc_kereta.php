<?php
$harga_cc = [
    "0-1400" => 273.80,
    "1401-1650" => 305.50,
    "1651-2200" => 339.10,
    "2201-3050" => 372.60,
    "3051-4100" => 404.30,
    "4101-4250" => 436.00,
    "4251-4400" => 469.60,
    "4401-ke-atas" => 501.30
];

$selected_cc = $_POST['cc'] ?? '';
$sum_insured = $_POST['sum_insured'] ?? '';
$insurans_company = $_POST['insurans_company'] ?? '';

$result = null;
$result2 = null;

if ($selected_cc && is_numeric($sum_insured)) {
    $cc_price = $harga_cc[$selected_cc];
    $result = $cc_price + ($sum_insured * 26);

    if (is_numeric($insurans_company) && $result > 0) {
        $result2 = (($insurans_company / $result) * 100) - 100;
    }
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Kalkulator Insurans Kereta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-white via-blue-100 to-blue-200 min-h-screen flex items-center justify-center p-4">

<div class="bg-white p-6 rounded-2xl shadow-2xl w-full max-w-xl">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">🧾 Kalkulator Insurans Kereta</h1>

    <form method="POST" class="space-y-6">
        <!-- Kapasiti CC -->
        <div>
            <label class="block font-semibold text-gray-700 mb-2">1. Pilih Kapasiti CC:</label>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <?php foreach ($harga_cc as $cc => $harga): ?>
                    <label class="flex items-center bg-gray-100 hover:bg-gray-200 px-3 py-2 rounded-lg cursor-pointer">
                        <input type="radio" name="cc" value="<?= $cc ?>" class="mr-2" required <?= $selected_cc == $cc ? 'checked' : '' ?>>
                        <?= $cc ?> (RM<?= number_format($harga, 2) ?>)
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Sum Insured -->
        <div>
            <label class="block font-semibold text-gray-700 mb-2">2. Nilai Sum Insured (RM):</label>
            <input type="number" name="sum_insured" step="0.01" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400" required value="<?= htmlspecialchars($sum_insured) ?>">
        </div>

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl w-full transition-all duration-300">
            📊 Kira Jumlah Insurans
        </button>
    </form>

    <?php if ($result !== null): ?>
        <div class="mt-6 bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded">
            <strong>✅ Jumlah Insurans:</strong> RM<?= number_format($result, 2) ?>
        </div>

        <!-- Harga syarikat -->
        <form method="POST" class="mt-6 space-y-4">
            <input type="hidden" name="cc" value="<?= $selected_cc ?>">
            <input type="hidden" name="sum_insured" value="<?= $sum_insured ?>">

            <div>
                <label class="block font-semibold text-gray-700 mb-2">3. Harga Dari Syarikat Insurans (RM):</label>
                <input type="number" name="insurans_company" step="0.01" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-400" required value="<?= htmlspecialchars($insurans_company) ?>">
            </div>

            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 py-3 rounded-xl w-full transition-all duration-300">
                📉 Kira Perbezaan (%)
            </button>
        </form>
    <?php endif; ?>

    <?php if ($result2 !== null): ?>
        <div class="mt-6 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 rounded">
            <strong>📌 Peratus Perbezaan:</strong> <?= number_format($result2, 2) ?>%
        </div>
    <?php endif; ?>

    <div class="mt-8 text-center">
        <a href="index.html" class="inline-block text-white bg-gray-600 hover:bg-gray-800 px-5 py-3 rounded-lg transition">
            ← Kembali ke Halaman Utama
        </a>
    </div>
</div>

</body>
</html>
