import axios from "axios";

$(document).ready(function () {
    // Data kategori disimpan di variabel global
    let categories = [];

    // Tampilkan modal saat input dengan ID 'category_id' diklik
    $('#kategori').on('click', function () {
        $('#categoryModal').removeClass('hidden');

        // Tampilkan spinner
        $('#spinner').removeClass('hidden');
        $('#spinner').addClass('flex');
        $('#modal-content').html('');

        // Lakukan fetching data dengan Axios
        axios.get('http://127.0.0.1:8000/api/kategori')
            .then(function (response) {
                // Sembunyikan spinner
                $('#spinner').addClass('hidden');
                $('#spinner').removeClass('flex');

                // Tangani data yang diterima
                categories = response.data.data;
                displayCategories(categories);
            })
            .catch(function () {
                $('#searchKategori').val('');
                $('#spinner').addClass('hidden');
                $('#spinner').removeClass('flex');;
                $('#modal-content').html('<p class="text-center text-sm text-gray-400">Terjadi kesalahan saat mengambil data.</p>');
            });
    });

    // Fungsi untuk menampilkan kategori
    function displayCategories(categories) {
        let content = '';
        categories.forEach(function (category) {
            content += '<div class="category-item p-2 m-2 bg-gray-200 rounded cursor-pointer" onclick="selectCategory(\'' + category.id + '\', \'' + category.category_name + '\')">' + category.category_name + '</div>';
        });
        $('#modal-content').html(content);
    }

    window.selectCategory = function (id, name) {
        $('#searchKategori').val('');
        $('#kategori').val(name);  // Contoh: Isi input dengan nama kategori yang dipilih
        $('#category_id').val(id);  // Contoh: Isi input dengan nama kategori yang dipilih
        $('#categoryModal').addClass('hidden');  // Tutup modal setelah kategori dipilih
    }

    $('#searchKategori').on('input', function () {
        const searchText = $(this).val().toLowerCase();
        const filteredCategories = categories.filter(category => category.category_name.toLowerCase().includes(searchText));
        displayCategories(filteredCategories);
    });

    // Tutup modal saat tombol dengan ID 'closeModal' diklik
    $('#closeModal').on('click', function () {
        $('#searchKategori').val('');
        $('#categoryModal').addClass('hidden');
    });
});

