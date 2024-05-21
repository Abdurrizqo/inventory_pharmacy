import axios from "axios";

$(document).ready(function () {
    let dataFetch = [];

    $('#obatName').on('click', function () {
        $('#obatModal').removeClass('hidden');

        $('#spinner-obat').removeClass('hidden');
        $('#spinner-obat').addClass('flex');
        $('#modal-content-obat').html('');

        axios.get('http://127.0.0.1:8000/api/obat')
            .then(function (response) {
                $('#spinner-obat').addClass('hidden');
                $('#spinner-obat').removeClass('flex');

                dataFetch = response.data.data;
                displayData(dataFetch);
            })
            .catch(function () {
                $('#searchObat').val('');
                $('#spinner-obat').addClass('hidden');
                $('#spinner-obat').removeClass('flex');;
                $('#modal-content-obat').html('<p class="text-center text-sm text-gray-400">Terjadi kesalahan saat mengambil data.</p>');
            });
    });

    function displayData(dataResponses) {
        let content = '';
        dataResponses.forEach(function (item) {
            content += '<div class="p-2 m-2 bg-gray-200 rounded cursor-pointer" onclick="selectDataObat(\'' + item.id + '\', \'' + item.nama_obat + '\')">' + item.nama_obat + '</div>';
        });
        $('#modal-content-obat').html(content);
    }

    window.selectDataObat = function (id, name) {
        $('#searchObat').val('');
        $('#obatName').val(name);
        $('#obat_id').val(id);
        $('#obatModal').addClass('hidden');
    }

    $('#searchObat').on('input', function () {
        const searchText = $(this).val().toLowerCase();
        const filtered = dataFetch.filter(item => item.nama_obat.toLowerCase().includes(searchText));
        displayData(filtered);
    });

    $('#closeModal-supplier').on('click', function () {
        $('#searchObat').val('');
        $('#obatModal').addClass('hidden');
    });
});

