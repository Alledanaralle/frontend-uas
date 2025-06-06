<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simon Kehadiran</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- DataTables JS -->
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<style>
    * {
        font-family: 'Poppins';
    }
</style>
<body class="bg-gray-100 h-screen flex">
    <div class="bg-green-800 text-white w-64 flex-shrink-0 p-4">
        <h1 class="text-xl font-bold mb-4">Simon Kehadiran</h1>
        <nav>
            <a href="{{ route('dashboard') }}" class="block py-2 text-gray-300 hover:bg-white hover:text-black px-2 rounded">
                User
            </a>
            <a href="{{ route('dashboard_matkul') }}" class="block py-2 text-gray-300 hover:bg-white hover:text-black px-2 rounded">
                Matkul
            </a>
            </nav>
    </div>

    <main class="flex-1 p-8 overflow-auto">
        <h1 class="text-2xl font-bold mb-4">Data Matkul</h1>
        <button class="bg-green-800 text-white rounded p-2 mb-2">
            Tambah Data Matkul
        </button>

        {{-- Pesan Sukses/Error dari Controller --}}
        @if (session('success'))
            <div class="bg-green-200 border border-green-500 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-200 border border-red-500 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-200 border border-red-500 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ $errors->first() }}</span>
            </div>
        @endif

        <div class="shadow mt-2 overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <div class="overflow-x-auto">
                <table id="example" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Matkul</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Matkul</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKS</th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Aksi</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($matkul as $matkul)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $matkul['kode_matkul'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $matkul['nama_matkul'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $matkul['sks'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button onclick="openEditModal('{{ $matkul['kode_matkul'] }}', '{{ $matkul['nama_matkul'] }}', '{{ $matkul['sks'] }}')"
                                            class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mr-2">
                                        Edit
                                    </button>
                                    <form action="{{ route('matkul.destroy', $matkul['kode_matkul']) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                                    onclick="return confirm('Kamu yakin mau menghapus matkul ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" colspan="5">Data matkul kosong.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div id="editModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-green-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-left sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg text-center leading-6 font-medium text-white" id="modal-title">
                                Edit Data Matkul
                            </h3>
                            <div class="mt-2">
                                {{-- Form akan disubmit ke Laravel Controller --}}
                                <form class="space-y-4" action="{{ route('matkul.update') }}" method="POST">
                                    @csrf
                                    @method('PUT') {{-- Ini penting untuk spoofing method PUT di Laravel --}}
                                    <div>
                                    <input type="hidden" name="kode_matkul" id="edit-kode-matkul" class="mt-1 p-1.5  focus:ring-green-500 focus:border-green-500 w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="edit-nama-matkul" class="block text-sm font-medium text-white">Nama Matkul</label>
                                        <input type="text" name="nama_matkul" id="edit-nama-matkul" class="mt-1 p-1.5  focus:ring-green-500 focus:border-green-500 w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="edit-sks" class="block text-sm font-medium text-white">SKS</label>
                                        <input type="sks" name="sks" id="edit-sks" class="mt-1 p-1.5  focus:ring-green-500 focus:border-green-500 w-full shadow-sm sm:text-sm border-gray-300 rounded-md" >
                                    </div>

                                    <div class="flex mt-6 gap-2">
                                        <button type="button" onclick="closeEditModal()" class="w-full inline-flex justify-center rounded-md border border-gray-300 bg-white text-base font-medium text-black px-2 items-center hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                            Batal
                                        </button>
                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                                            Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Matkul --}}
        <div id="addModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-green-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-left sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-center text-white" id="modal-title-add">
                                    Tambah Data Matkul Baru
                                </h3>
                                <div class="mt-2">
                                    <form class="space-y-4" action="{{ route('matkul.store') }}" method="POST">
                                        @csrf
                                        <div>
                                            <label for="add-kode-matkul" class="block text-sm font-medium text-white">Kode Matkul</label>
                                        <input type="text" name="kode_matkul" id="add-kode-matkul" class="mt-1 p-1.5  focus:ring-green-500 focus:border-green-500 w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                        <div>
                                            <label for="add-nama-matkul" class="block text-sm font-medium text-white">Nama Matkul</label>
                                            <input type="text" name="nama_matkul" id="add-nama-matkul" class="mt-1 p-1.5  focus:ring-green-500 focus:border-green-500 w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                        </div>
                                        <div>
                                            <label for="add-sks" class="block text-sm font-medium text-white">SKS</label>
                                            <input type="sks" name="sks" id="add-sks" class="mt-1 p-1.5  focus:ring-green-500 focus:border-green-500 w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                        </div>
                                        <div class="flex mt-6 gap-2">
                                            <button type="button" onclick="closeAddModal()" class="w-full items-center px-4 inline-flex justify-center rounded-md border border-gray-300 bg-white text-base font-medium text-black hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                Batal
                                            </button>
                                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <script>
        // Fungsi untuk membuka modal edit dan mengisi data
        function openEditModal(kodeMatkul, namaMatkul, sks) {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('edit-kode-matkul').value = kodeMatkul;
            document.getElementById('edit-nama-matkul').value = namaMatkul;
            document.getElementById('edit-sks').value = sks;
        }

        // Fungsi untuk menutup modal edit
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function openAddModal() {
                    document.getElementById('addModal').classList.remove('hidden');
                }
                function closeAddModal() {
                    document.getElementById('addModal').classList.add('hidden');
                }

                // Event listener untuk tombol "Tambah Data Matkul"
                document.querySelector('main > button').addEventListener('click', openAddModal);

                $(document).ready(function() {
                            // Initialize the DataTable
                            var table = $('#example').DataTable();

                            // Example of a global search
                            $('#searchInput').on('keyup', function() {
                                table.search(this.value).draw();
                            });


                        });
    </script>
</body>
</html>
