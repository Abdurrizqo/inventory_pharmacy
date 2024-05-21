<html>

<head>
    <title>Gudang Farmasi</title>
    @vite('resources/css/app.css')
</head>

<body>
    <nav class="bg-white border-b shadow px-3 py-4 flex items-center gap-6 fixed top-0 left-0 right-0">
        <a href='/home' class="text-sm roboto-medium hover:text-emerald-600">Home</a>
        <div class="relative inline-block">
            <span id="triggerElement" onclick="dropDownMenu()"
                class="text-sm roboto-medium hover:text-emerald-600 cursor-pointer">Master
                Data</span>
            <div id="menuHidden" class="absolute hidden left-0 border w-40 bg-white shadow-md rounded-md mt-1">
                <ul>
                    <li class="px-4 py-2 hover:bg-gray-200 rounded-md">
                        <a href="/kategori">Kategori</a>
                    </li>

                    <li class="px-4 py-2 hover:bg-gray-200 rounded-md">
                        <a href="/sub-kategori">Sub Kategori</a>
                    </li>

                    <li class="px-4 py-2 hover:bg-gray-200 rounded-md">
                        <a href="/supplier">Supplier</a>
                    </li>
                </ul>
            </div>
        </div>
        <a href='/obat' class="text-sm roboto-medium hover:text-emerald-600">Obat</a>
        <a href='/stok' class="text-sm roboto-medium hover:text-emerald-600">Stok</a>
        <a href='/transaksi-keluar' class="text-sm roboto-medium hover:text-emerald-600">Transaksi Keluar</a>
    </nav>

    <div class="w-full h-20"></div>

    <div class="px-4 mb-10 w-full min-h-screen">
        @yield('content')
    </div>

    <script>
        function dropDownMenu() {
            const triggerElement = document.getElementById("triggerElement");
            const dropdownMenu = document.getElementById("menuHidden");

            dropdownMenu.classList.toggle("hidden"); // Toggle hidden class on click

            document.addEventListener("click", function(event) {
                const isClickInside = event.target === triggerElement || event.target.parentNode === triggerElement;
                if (!isClickInside && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.add("hidden");
                }
            });
        }
    </script>
</body>

</html>
