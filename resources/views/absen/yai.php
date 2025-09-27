<?= $this->extend('layout/template.php') ?>

<?= $this->section('content') ?>

<style>
    /* #video {
        -webkit-transform: scaleX(-1);
        transform: scaleX(-1);
    }

    #canvas {
        -webkit-transform: scaleX(-1);
        transform: scaleX(-1);
    } */
    .responsive-embed {
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        width: 100%;
        height: 100%;
    }
</style>

<!---------- Preloader ----------------->
<!-- <div id="preloader">
    <div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
</div> -->
<!---------------------------------------------->

<div class="internet-connection-status" id="internetStatus"></div>
<div class="header-area" id="headerArea">
    <div class="container">

        <div class="header-content position-relative d-flex align-items-center justify-content-between">
            <div class="back-button"><a href="<?= base_url() ?>/absensi?tgl_awal=<?= date('Y-m-d') ?>&tgl_akhir=<?= date('Y-m-d') ?>">
                    <svg class="bi bi-arrow-left-short" width="32" height="32" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
                    </svg></a></div>


            <div class="page-heading">
                <h6 class="mb-0">Absensi Karyawan</h6>
            </div>



            <div class="setting-wrapper">
                <div class="setting-trigger-btn" id="settingTriggerBtn">

                </div>
            </div>
        </div>
    </div>
</div>


<div class="setting-wrapper">
    <div class="setting-trigger-btn" id="settingTriggerBtn">
    </div>
</div>

</div>
</div>
</div>




<div class="page-content-wrapper py-3">

    <div class="container">

        <div class="card user-info-card mb-3">
            <div class="card-body d-flex align-items-center">
                <div class="user-profile me-3">
                    <?php if ($d['foto']) { ?>
                        <img src="http://ppsdm.yai.ac.id/v5/images/foto_karyawan/<?= $_SESSION['nik'] ?>/<?= $d['foto'] ?>" alt="">
                    <?php } else { ?>
                        <img src="<?= base_url() ?>/public/img/images.png" alt="">
                    <?php } ?>
                    <!-- <form action="#">
                        <input class="form-control" type="file">
                    </form> -->
                </div>
                <div class="user-info">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-1"><?= $d['nama_lengkap'] ?></h5>
                    </div>
                    <p class="mb-0" style="font-size: 12px;"><?= $d['nama_jabatan'] ?></p>

                </div>
            </div>
        </div>
        <div class="card user-data-card">
            <div class="card-body" style="height: 300px;">


                <embed class="responsive-embed" src="https://maps.google.com/maps?q=-6.200000,106.816666&output=embed" id="embedMaps" type="">



            </div>
        </div>
        <!-- User Meta Data-->
        <div class="card user-data-card">
            <div class="card-body">
                <form action="<?= base_url() ?>/absensi/a_wajah_dev" method="post" enctype="multipart/form-data">
                    <div id="divMapa"></div>
                    <div id="divCoordenadas"></div>
                    <input type="hidden" name="LokasiMaps">
                    <input type="hidden" name="Latitude">
                    <input type="hidden" name="Longitude">
                    <input type="hidden" name="address">
                    <input type="hidden" name="kode_hari" value="<?= kode_hari(date("Y-m-d")) ?>">
                    <label for="file-input">
                        <img style="width:25%;" src="<?= base_url() ?>/public/img/icons/camera-icon.jpg" />
                        Ambil Selfie<br />
                        Klik pada gambar kamera

                    </label>
                    <input style="display:none;" type="file" name="picture" id="file-input" accept="image/*" capture="camera" onchange="loadFile(event)" required>
                    <img id="output" />
                    <div id="errors"></div>
                    <br /><br />
                    <button type="submit" id="button-save" style="display: none;" class="btn btn-primary">Simpan</button>
                </form>

            </div>
        </div>
    </div>
</div>




<!----------------------- Footer Nav ------------------------->

<?= $this->include('layout/footer') ?>
<script>
    var loadFile = function(event) {
        var output = document.getElementById('output');

        //console.log(event.target.files[0]);

        output.src = URL.createObjectURL(event.target.files[0]);

        // output.onload = function() {
        //     URL.revokeObjectURL(output.src) // free memory
        // }
        document.getElementById("button-save").style.display = 'block';
        //$("#btn-save").show('fast');
    };
</script>
<?= $this->endSection() ?>