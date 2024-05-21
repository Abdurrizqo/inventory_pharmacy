import axios from "axios";
let selectedObat = [];

function removeElementFromContainerKeluar(id) {
    selectedObat = selectedObat.filter(item => item.id !== id);
    addToContainerKeluar();
}

function addToContainerKeluar() {
    $('#containerKeluar').empty();
    selectedObat.forEach((item, index) => {
        let row = $('<tr>').addClass('hover:bg-gray-100 cursor-default');
        row.append($('<td>').addClass('border border-gray-400 px-3 py-2 text-center').text(index + 1));
        row.append($('<td>').addClass('border border-gray-400 px-3 py-2 whitespace-nowrap').text(item.nama_obat));
        row.append($('<td>').addClass('border border-gray-400 px-3 py-2 whitespace-nowrap').text(item.supplier_name));
        row.append($('<td>').addClass('border border-gray-400 px-3 py-2').text(item.jumlah_stok));
        row.append($('<td>').addClass('border border-gray-400 px-3 py-2').text(item.harga_satuan));
        row.append($('<td>').addClass('border border-gray-400 px-3 py-2').text(item.exp_date));

        var hiddenInputId = $('<input/>', {
            type: 'hidden',
            value: item.id
        });

        var inputJumlah = $('<input/>', {
            type: 'number',
            value: 1
        }).addClass('w-full outline-none bg-transparent py-3 text-center jumlahKeluar ');

        row.append($('<td>').addClass('border border-gray-400').append(hiddenInputId).append(inputJumlah));

        var deleteButton = $('<button>').addClass('bg-red-400 text-white px-6 py-[2px] rounded active:scale-95').text('Delete');

        deleteButton.on('click', () => {
            removeElementFromContainerKeluar(item.id);
        });

        var buttonContainer = $('<div>').addClass('flex items-center justify-center').append(deleteButton);
        row.append($('<td>').addClass('border border-gray-400 px-3 py-2').append(buttonContainer));

        $('#containerKeluar').append(row);
    })
}

$(document).ready(function () {
    $('#formPencarianStok').on('submit', function (event) {
        event.preventDefault();
        $('#errorSearch').addClass('hidden');
        $('#spinner').removeClass('hidden');
        $('#spinner').addClass('flex');
        $('#containerStok').empty();
        const searchText = $('#searchStok').val().toLowerCase();
        axios.get('http://127.0.0.1:8000/api/stok', {
            params: {
                search: searchText
            }
        })
            .then((res) => {
                $('#spinner').addClass('hidden');
                $('#spinner').removeClass('flex');
                const result = res.data.data;

                result.forEach((item, index) => {
                    let row = $('<tr>').addClass('hover:bg-gray-100 cursor-default');
                    row.append($('<td>').addClass('border border-gray-400 px-3 py-2 text-center').text(index + 1));
                    row.append($('<td>').addClass('border border-gray-400 px-3 py-2 whitespace-nowrap').text(item.nama_obat));
                    row.append($('<td>').addClass('border border-gray-400 px-3 py-2 whitespace-nowrap').text(item.supplier_name));
                    row.append($('<td>').addClass('border border-gray-400 px-3 py-2').text(item.jumlah_stok));
                    row.append($('<td>').addClass('border border-gray-400 px-3 py-2').text(item.harga_satuan));
                    row.append($('<td>').addClass('border border-gray-400 px-3 py-2').text(item.exp_date));

                    var addButton = $('<button>').addClass('bg-emerald-400 text-white px-6 py-[2px] rounded active:scale-95').text('Add');

                    addButton.on('click', () => {
                        const exists = selectedObat.some((select) => select.id === item.id);
                        if (!exists) {
                            selectedObat.push(item);
                        }
                        $('#simpanButton').removeAttr('disabled').addClass('active:scale-95');
                        $('#removeButton').removeAttr('disabled').addClass('active:scale-95');
                        addToContainerKeluar();
                    });

                    var buttonContainer = $('<div>').addClass('flex items-center justify-center').append(addButton);
                    row.append($('<td>').addClass('border border-gray-400 px-3 py-2').append(buttonContainer));

                    $('#containerStok').append(row);
                });
            })
            .catch((err) => {
                $('#spinner').addClass('hidden');
                $('#spinner').removeClass('flex');
                $('#errorSearch').addClass('block');
            })
    });
});

window.simpanData = () => {
    $('#spinner-putih').removeClass('hidden');
    $('#spinner-putih').addClass('inline-flex');

    const listJumlahItem = $('.jumlahKeluar');
    let sendData = [];

    listJumlahItem.each((index, element) => {
        const hiddenInputValue = $(element).siblings('input[type="hidden"]').val();
        const jumlahKeluarValue = $(element).val();

        sendData.push({
            stokId: hiddenInputValue,
            jumlahItem: jumlahKeluarValue
        })
    });

    var toast;

    axios.post('http://127.0.0.1:8000/api/stok/stok-keluar', { stok: sendData })
        .then(() => {
            $('#spinner-putih').addClass('hidden');
            $('#spinner-putih').removeClass('flex');
            $('#containerStok').empty();
            $('#containerKeluar').html('');
            const message = "Stok Keluar Berhasil Di Catat";
            toast = $('<div id="toastResult">').addClass('fixed right-10 bottom-24 bg-white p-3 rounded-lg text-green-400 border border-gray-300 shadow-md cursor-default flex items-center justify-center gap-3');
            var spinner = $('<span>').addClass('spinner-response inline-flex');
            toast.append(spinner);
            toast.append($('<span>').text(message));
            $('#containerToast').append(toast);
        })
        .catch((err) => {
            const message = err.response.data.error
            $('#spinner-putih').addClass('hidden');
            $('#spinner-putih').removeClass('flex');
            $('#containerStok').empty();
            $('#containerKeluar').html('');
            toast = $('<div id="toastResult">').addClass('fixed right-10 bottom-24 bg-white p-3 rounded-lg text-red-400 border border-gray-300 shadow-md cursor-default flex items-center justify-center gap-3');
            var spinner = $('<span>').addClass('spinner-response inline-flex');
            toast.append(spinner);
            toast.append($('<span>').text(message));
            $('#containerToast').append(toast);
        })

    setTimeout(function () {
        toast.remove();
    }, 3000);
}

window.resetData = () => {
    $('#containerKeluar').html('');
}