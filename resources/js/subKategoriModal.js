import axios from "axios";

$(document).ready(function () {
    let subCategories = [];

    $('#sub_category_name').on('click', function () {
        $('#subCategoryModal').removeClass('hidden');

        $('#spinner-subCategory').removeClass('hidden');
        $('#spinner-subCategory').addClass('flex');
        $('#modal-content-subCategory').html('');
        let idKategori = $('#category_id').val();

        axios.get(`http://127.0.0.1:8000/api/sub-kategori/${idKategori}`)
            .then(function (response) {
                $('#spinner-subCategory').addClass('hidden');
                $('#spinner-subCategory').removeClass('flex');

                subCategories = response.data.data;
                displayData(subCategories);
            })
            .catch(function () {
                $('#searchSubKategori').val('');
                $('#spinner-subCategory').addClass('hidden');
                $('#spinner-subCategory').removeClass('flex');;
                $('#modal-content-subCategory').html('<p class="text-center text-sm text-gray-400">Terjadi kesalahan saat mengambil data.</p>');
            });
    });

    function displayData(subCategories) {
        let content = '';
        subCategories.forEach(function (subCategory) {
            content += '<div class="p-2 m-2 bg-gray-200 rounded cursor-pointer" onclick="selectData(\'' + subCategory.id + '\', \'' + subCategory.sub_category_name + '\')">' + subCategory.sub_category_name + '</div>';
        });
        $('#modal-content-subCategory').html(content);
    }

    window.selectData = function (id, name) {
        $('#searchSubKategori').val('');
        $('#sub_category_name').val(name);
        $('#sub_category_id').val(id);
        $('#subCategoryModal').addClass('hidden');
    }

    $('#searchSubKategori').on('input', function () {
        const searchText = $(this).val().toLowerCase();
        const filtered = subCategories.filter(subCategory => subCategory.sub_category_name.toLowerCase().includes(searchText));
        displayData(filtered);
    });

    $('#closeModalSubCategory').on('click', function () {
        $('#searchSubKategori').val('');
        $('#subCategoryModal').addClass('hidden');
    });
});

