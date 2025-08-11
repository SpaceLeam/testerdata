<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Anggaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 text-sm">

    <div class="max-w-5xl mx-auto mt-8">
        <h2 class="text-xl font-semibold mb-4">Detail Data Anggaran</h2>

        <div class="bg-white rounded shadow border border-gray-200">
            <table class="w-full table-auto">
                <tbody>
                    <tr class="border-b">
                        <th class="px-4 py-2 text-left w-1/3 bg-gray-50">ID Anggaran</th>
                        <td class="px-4 py-2">{{ $anggaran->id_agr }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-50">ID Kategori Anggaran</th>
                        <td class="px-4 py-2">{{ $anggaran->id_kag }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-50">Nama Anggaran</th>
                        <td class="px-4 py-2">{{ $anggaran->nama_agr }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-50">Status</th>
                        <td class="px-4 py-2">
                            @if ($anggaran->status_agr == 1)
                                <span class="text-green-600 font-medium">Aktif</span>
                            @else
                                <span class="text-red-600 font-medium">Tidak Aktif</span>
                            @endif
                        </td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-50">Dibuat Pada</th>
                        <td class="px-4 py-2">{{ $anggaran->created_at }}</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-2 bg-gray-50">Diupdate Terakhir</th>
                        <td class="px-4 py-2">{{ $anggaran->updated_at }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <a href="{{ url('/anggaran') }}" class="inline-block bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded text-sm">← Kembali</a>
        </div>
    </div>

    <!-- ===== JS SCRIPTS ===== -->
    <script>
        // Contoh interaksi: notifikasi ketika halaman dimuat
        document.addEventListener("DOMContentLoaded", function () {
            console.log("Halaman detail anggaran berhasil dimuat.");
        });

        // Tambahan fungsi JS lain bisa disini
    </script>

</body>
</html>
