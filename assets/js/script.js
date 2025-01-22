window.addEventListener('scroll', function(){
    var hd = document.querySelector('.navbar');
    hd.classList.toggle('sticky', window.scrollY > 0);
});

// DATA TABLE
$(document).ready(function () {
    $('#example').DataTable();
});

// OWL CAROUSEL,
// DIGUNAKAN DI HALAMAN DETAIL | REKOMENDASI
$(document).ready(function () {
    $('.owl-carousel').owlCarousel({
        margin:10,
            nav: true,
        lazyLoad:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
    })
});

// SHOW HIDE ICON FORM , UNTUK MENAMPILKAN FORM SEARCH
// DIGUNAKAN PADA HALAMAN HOME | NAVBAR | MOBILE VERSION
$(".showForm").click(function () {
    $(".search-form").toggleClass("active");
    if ($(".search-form").hasClass('active')) {
        $("#iconShowForm").removeClass("fa-magnifying-glass");
        $("#iconShowForm").addClass("fa-xmark");
    } else {
        $("#iconShowForm").addClass("fa-magnifying-glass");
        $("#iconShowForm").removeClass("fa-xmark");
    }
} )

// DATE PICKER UNTUK DISABLE TANGGAL YANG LAMPAU
// DIGUNAKAN PADA HALAMAN DETAIL | PEMINJMANAN BUKU | MODAL_PEMINJAMAN
$(document).ready(function () {
    $("#datepicker").datepicker({
        minDate: new Date(),
        dateFormat: 'yy-mm-dd'
    });
})

// PRINT 
$(document).ready(function () {
    $("#printArea").click(function () {
        $("#printMe").print(/*options*/);
    });
})

// TOGGLE SHOW HIDE PASSWORD
function togglePassword() {
    var passwordInput = $(".password-input");
    var toggleIcon = $("#toggle-icon");

    if (passwordInput.attr("type") === "password") {
        passwordInput.attr("type", "text");
        toggleIcon.removeClass("fa-solid fa-eye-slash");
        toggleIcon.addClass("fa-solid fa-eye");
    } else {
        passwordInput.attr("type", "password");
        toggleIcon.removeClass("fa-solid fa-eye");
        toggleIcon.addClass("fa-solid fa-eye-slash");
    }
}

$("#toggle-icon").click(function() {
    togglePassword()
});

// UNTUK MENAMPILKAN DATA DESKRIPSI SECARA KESELURUHAN
$(document).ready(function () {
    let readMoreHTML = $("#deskripsis").html();
    let lessText = readMoreHTML.substring(0, 1500);

    if(readMoreHTML.length > 1500){
        $(".deskripsis").html(lessText).append("<a href='' class='read-more-link'> Baca Selengkapnya</a>");
    } else {
        $(".deskripsis").html(readMoreHTML);
    }

    $("body").on("click", ".read-more-link", function(e){
        e.preventDefault();
        $(this).parent(".deskripsis").html(readMoreHTML).append("<a href='' class='show-less-link'> Ringkas</a>");
    });

    $("body").on("click", ".show-less-link", function(e){
        e.preventDefault();
        $(this).parent(".deskripsis").html(readMoreHTML.substring(0, 1500)).append("<a href='' class='read-more-link'> Baca Selengkapnya</a>");
    });
})

// MENAMPILKAN ALERT ERROR JIKA USER BELUM LOGIN / SUPER ADMIN
$('#pinjam').click(function () {
    Swal.fire({
        title: 'Opps...',
        text: "Kamu Harus Login Terlebih Dahulu!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Login!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = '?p=account';
        }
    })
})
