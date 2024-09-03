</div>


<footer class="footer pt-3 pb-3">
    <hr class="horizontal dark mt-0">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 mb-lg-0 mb-4 d-flex justify-content-between align-items-center">
                <div class="textstart">
                    Copyright &copy; <?= date("Y"); ?> • <a href=""> Leapverse -
                        Bank Soal.</a> All Rights Reserved
                </div>
                <div class="footer-right">
                    2.3.0
                </div>
            </div>

        </div>
    </div>
</footer>

</main>

<!--   Core JS Files   -->
<script src="<?= base_url(); ?>tinymce/tinymce.min.js"></script>
<script src="<?= base_url() ?>front/dashboard_new/assets/js/core/popper.min.js"></script>
<script src="<?= base_url() ?>front/dashboard_new/assets/js/core/bootstrap.min.js"></script>
<script src="<?= base_url() ?>front/dashboard_new/assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="<?= base_url() ?>front/dashboard_new/assets/js/plugins/smooth-scrollbar.min.js"></script>
<script src="<?= base_url() ?>front/dashboard_new/assets/js/plugins/chartjs.min.js"></script>
<!-- General JS Scripts -->
<script src="<?= base_url() ?>front/assets/js/jquery.min.js"></script>
<script src="<?= base_url() ?>front/assets/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"
    integrity="sha512-zMfrMAZYAlNClPKjN+JMuslK/B6sPM09BGvrWlW+cymmPmsUT1xJF3P4kxI3lOh9zypakSgWaTpY6vDJY/3Dig=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="<?= base_url() ?>front/dashboard/assets/js/stisla.js"></script>

<!-- JS Libraies -->

<!-- Search Subtopic -->
<script>
    var search = document.getElementById("searchInput-sub");
    var els = document.querySelectorAll(".search-sub");

    search.addEventListener("keyup", function() {
        var searchValue = search.value.toLowerCase();

        Array.prototype.forEach.call(els, function(el) {
            if (el.textContent.trim().toLowerCase().indexOf(searchValue) > -1) {
                el.style.display = 'block';
            } else {
                el.style.display = 'none';
            }
        });
    });
</script>

<!-- Template JS File -->
<script src="<?= base_url() ?>front/dashboard/assets/js/scripts.js"></script>
<script src="<?= base_url() ?>front/dashboard/assets/js/custom.js"></script>

<!-- Page Specific JS File -->
<!-- Code injected by live-server -->
<script>
    // <![CDATA[  <-- For SVG support
    // if ('WebSocket' in window) {
    //     (function() {
    //         function refreshCSS() {
    //             var sheets = [].slice.call(document.getElementsByTagName("link"));
    //             var head = document.getElementsByTagName("head")[0];
    //             for (var i = 0; i < sheets.length; ++i) {
    //                 var elem = sheets[i];
    //                 var parent = elem.parentElement || head;
    //                 parent.removeChild(elem);
    //                 var rel = elem.rel;
    //                 if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() ==
    //                     "stylesheet") {
    //                     var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
    //                     elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date()
    //                         .valueOf());
    //                 }
    //                 parent.appendChild(elem);
    //             }
    //         }
    //         var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
    //         var address = protocol + window.location.host + window.location.pathname + '/ws';
    //         var socket = new WebSocket(address);
    //         socket.onmessage = function(msg) {
    //             if (msg.data == 'reload') window.location.reload();
    //             else if (msg.data == 'refreshcss') refreshCSS();
    //         };
    //         if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
    //             console.log('Live reload enabled.');
    //             sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
    //         }
    //     })();
    // } else {
    //     console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
    // }
    // ]]>

    // Fungsi untuk mendapatkan tanggal dalam format "dd MMMM yyyy"
    function getCurrentDate() {
        const date = new Date();
        const day = date.getDate().toString().padStart(2, '0'); // Format hari dengan dua digit
        const month = new Intl.DateTimeFormat('en', {
            month: 'long'
        }).format(date); // Nama bulan dalam bahasa Inggris
        const year = date.getFullYear();
        return `${day} ${month} ${year}`;
    }

    // Fungsi untuk mendapatkan hari saat ini
    function getCurrentDay() {
        const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        return days[new Date().getDay()];
    }


    // Mengisi elemen HTML dengan tanggal dan hari saat ini
    document.getElementById("current-date").textContent = getCurrentDate();
    document.getElementById("current-day").textContent = getCurrentDay();
</script>

<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }

    //Dashboard Click

    const dashboardPaths = [
        '/public/homesiswa',
        '/public/subtopic1',
        '/public/index.php/subtopic1/',
        'https://kemitraan.leapsurabaya.sch.id/homesiswa',
        'https://kemitraan.leapsurabaya.sch.id/subtopic1',
        'https://kemitraan.leapsurabaya.sch.id/index.php/subtopic1'
    ];
    const historyPaths = [
        '/public/history',
        'https://kemitraan.leapsurabaya.sch.id/history'
    ];
    const sessionPaths = [
        '/public/session',
        'https://kemitraan.leapsurabaya.sch.id/session'
    ];
    const subscribePaths = [
        '/public/Subscribe',
        'https://kemitraan.leapsurabaya.sch.id/Subscribe',
        '/public/subscribe/index',
        'https://kemitraan.leapsurabaya.sch.id/Subscribe/index'
    ];

    const activePage = window.location.pathname;
    if (dashboardPaths.some(path => activePage.includes(path))) {
        document.querySelector('.side-dashboard').classList.add('active');
    } else if ((historyPaths.some(path => activePage.includes(path)))) {
        document.querySelector('.side-history').classList.add('active');
    } else if ((sessionPaths.some(path => activePage.includes(path)))) {
        document.querySelector('.side-session').classList.add('active');
    } else if ((subscribePaths.some(path => activePage.includes(path)))) {
        document.querySelector('.side-subscribe').classList.add('active');
    }

    //Message

    $(document).ready(function() {
        // Show the flash message
        $('#flashMessage').addClass('show');

        // Hide the flash message after 5 seconds
        setTimeout(function() {
            $('#flashMessage').removeClass('show');
        }, 5000);
    });
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
<script src="<?= base_url() ?>front/dashboard_new/assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>