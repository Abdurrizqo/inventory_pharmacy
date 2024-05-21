import axios from "axios";

$(document).ready(function () {
    let dataFetch = [];

    $('#supplierName').on('click', function () {
        $('#supplierModal').removeClass('hidden');

        $('#spinner-supplier').removeClass('hidden');
        $('#spinner-supplier').addClass('flex');
        $('#modal-content-supplier').html('');

        axios.get('http://127.0.0.1:8000/api/supplier')
            .then(function (response) {
                $('#spinner-supplier').addClass('hidden');
                $('#spinner-supplier').removeClass('flex');

                dataFetch = response.data.data;
                displayData(dataFetch);
            })
            .catch(function () {
                $('#searchSupplier').val('');
                $('#spinner-supplier').addClass('hidden');
                $('#spinner-supplier').removeClass('flex');;
                $('#modal-content-supplier').html('<p class="text-center text-sm text-gray-400">Terjadi kesalahan saat mengambil data.</p>');
            });
    });

    function displayData(dataResponses) {
        let content = '';
        dataResponses.forEach(function (item) {
            content += '<div class="p-2 m-2 bg-gray-200 rounded cursor-pointer" onclick="selectDataSupplier(\'' + item.id + '\', \'' + item.supplier_name + '\')">' + item.supplier_name + '</div>';
        });
        $('#modal-content-supplier').html(content);
    }

    window.selectDataSupplier = function (id, name) {
        $('#searchSupplier').val('');
        $('#supplierName').val(name);
        $('#supplier_id').val(id);
        $('#supplierModal').addClass('hidden');
    }

    $('#searchSupplier').on('input', function () {
        const searchText = $(this).val().toLowerCase();
        const filtered = dataFetch.filter(item => item.supplier_name.toLowerCase().includes(searchText));
        displayData(filtered);
    });

    $('#closeModal-supplier').on('click', function () {
        $('#searchSupplier').val('');
        $('#supplierModal').addClass('hidden');
    });
});

