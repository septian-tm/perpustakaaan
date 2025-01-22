<?php

function alert_timer($data, $location) {
    echo
    "<script>
        let timerInterval
        Swal.fire({
            icon: 'success',
            title: '".$data."',
            timer: 1000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft()
                }, 100)
            },
            willClose: () => {
                clearInterval(timerInterval)
            }
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
                window.location='".$location."';
            }
        })
    </script>
    ";
}

function alert($icon, $title, $text, $location){
    echo '
        <script>
            Swal.fire({
                icon: "'.$icon.'",
                title: "'.$title.'",
                text: "'.$text.'",
                showCancelButton: false,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "ok"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href="'.$location.'"
                }
            })
        </script>
    ';
}