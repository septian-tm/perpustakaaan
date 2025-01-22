function toggle() {
    var side = $("#sidebar");
    side.toggleClass("active");
    var page = $("#page");
    page.toggleClass("active");
}

$(document).ready(function () {
    $('#example').DataTable();
});


$(document).ready(function () {
    $(function () {
        $("#summernote").summernote()
    });
})

$(document).ready(function() {
    $('#uploadImageDB').change(function() {
        var input = this;

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            // Set the onload event handler
            reader.onload = function(e) {
                // Update the preview image src
                $('#uploadPreviewDB').attr('src', e.target.result);
            };

            // Read the selected file as a data URL
            reader.readAsDataURL(input.files[0]);
        }
    });
});


$(document).on('click', '#delete', function (e) {
    e.preventDefault();
    var id = $(this).data('kategori');
    var ids = $(this).data('buku');
    var id_peminjaman = $(this).data('peminjaman');
    Swal.fire({
        title: 'Apakah kamu yakin?',
        text: "Ingin menghapus data ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.isConfirmed){
            $.ajax({
                url: '../config/function.php',
                type: 'POST',
                data: {
                    kategori: id,
                    buku: ids,
                    peminjaman: id_peminjaman
                }
                
            })
            .done(function(){
                Swal.fire('Deleted!', 'Deleted Successfully', 'success');
                window.setTimeout(function() {
                    window.location.href = '';
                }, 1000);
            })
            .fail(function(){
                Swal.fire('Oops...', 'Something went wrong with ajax !', 'error');
            });
        }
    })
});

$(document).on('click', '#admin', function(e){
    e.preventDefault();
    var id_user = $(this).data("id")
    Swal.fire({
        title: 'Jadikan Admin?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!'
    }).then((result) => {
        if (result.isConfirmed){
            $.ajax({
                url: '../config/function.php',
                type: 'POST',
                data: {
                    id_user: id_user
                }
                
            })
            .done(function(){
                Swal.fire('Berhasil!', 'Sukses Dijadikan admin', 'success');
                window.setTimeout(function() {
                    window.location.href = '';
                }, 1000);
            })
            .fail(function(){
                Swal.fire('Oops...', 'Something went wrong with ajax !', 'error');
            });
        }
    })
})
$(document).on('click', '#removeAdmin', function(e){
    e.preventDefault();
    var id_remove_user = $(this).data("id")
    Swal.fire({
        title: 'Kembalikan Hak akses admin?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!'
    }).then((result) => {
        if (result.isConfirmed){
            $.ajax({
                url: '../config/function.php',
                type: 'POST',
                data: {
                    id_remove_user: id_remove_user
                }
                
            })
            .done(function(){
                Swal.fire('Berhasil!', 'Hak akses admin dihapus', 'success');
                window.setTimeout(function() {
                    window.location.href = '';
                }, 1000);
            })
            .fail(function(){
                Swal.fire('Oops...', 'Something went wrong with ajax !', 'error');
            });
        }
    })
})

// CHART JS
var jmlData = $("#forChart").html();
var label = $("#label").html(); 
const data = {
    labels:  JSON.parse(label),
    datasets: [{
        label: 'My First Dataset',
        // data: [jmlData, 2 ,5],
        data: JSON.parse(jmlData),
        backgroundColor: [
            'rgb(255, 205, 86)',
            'rgb(54, 162, 235)',
            'rgb(255, 99, 132)'
        ],
        hoverOffset: 4
    }]
};
const config = {
    type: 'doughnut',
    data: data,
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
};

const myChart = new Chart(
    $('#myChart'),
    config
)


// TOGGLE STATUS IN DASHBOARD
$('#hide-status').click(function () {
    $("#lihat-status").slideToggle("200");
})

// TOGGLE PASSWORD
$("#toggle-password").click(function () {
    var checked = $(this).is(':checked');

    if (checked) {
        $(".password-input").attr('type', 'text')
    } else {
        $(".password-input").attr('type', 'password')
    }
})