<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Permohonan Surat Pengantar / Keterangan</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="bs-stepper linear">
                                <div class="bs-stepper-header" role="tablist">
                                    <div class="step active" data-target="#validasi-part">
                                        <button type="button" class="step-trigger" role="tab" aria-controls="validasi-part" id="validasi-part-trigger" aria-selected="true">
                                            <span class="bs-stepper-circle">1</span>
                                            <span class="bs-stepper-label">Data Pemohon</span>
                                        </button>
                                    </div>
                                    <div class="line"></div>
                                    <div class="step" data-target="#informasi-part">
                                        <button type="button" class="step-trigger" role="tab" aria-controls="informasi-part" id="informasi-part-trigger" aria-selected="false" disabled="disabled">
                                            <span class="bs-stepper-circle">2</span>
                                            <span class="bs-stepper-label">Informasi Permohonan</span>
                                        </button>
                                    </div>
                                    <div class="line"></div>
                                    <div class="step" data-target="#done-part">
                                        <button type="button" class="step-trigger" role="tab" aria-controls="done-part" id="done-part-trigger" aria-selected="false" disabled="disabled">
                                            <span class="bs-stepper-circle">3</span>
                                            <span class="bs-stepper-label">Selesai</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="bs-stepper-content">
                                    <div id="validasi-part" class="content active" role="tabpanel" aria-labelledby="validasi-part-trigger">
                                        <div class="form-group">
                                            <label for="nik">NIK Pemohon</label>
                                            <input type="text" class="form-control" name="nik" id="nik" placeholder="Masukkan NIK Pemohon" aria-describedby="nik_error" onblur="cekNik()" maxlength="16" minlength="16">
                                            <span id="nik_error" class="error invalid-feedback"></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="nama">Nama Lengkap Pemohon</label>
                                            <input type="text" class="form-control" name="nama" id="nama" value="" placeholder="Nama Lengkap Pemohon" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="tgl_lahir">Tanggal Lahir Pemohon</label>
                                            <input type="text" class="form-control datepicker" name="tgl_lahir" id="tgl_lahir" placeholder="Masukkan Tanggal Lahir Pemohon" onblur="cekNikTglLahir()" aria-describedby="tgl_lahir_error">
                                            <span id="tgl_lahir_error" class="error invalid-feedback"></span>
                                        </div>

                                        <button class="btn btn-primary" id="btn_next" onclick="stepper.next()"><i class="fa fa-arrow-right mr-2" aria-hidden="true"></i> Lanjutkan</button>
                                    </div>
                                    <div id="informasi-part" class="content" role="tabpanel" aria-labelledby="informasi-part-trigger">
                                        <div class="form-group">
                                            <label for="tujuan">Tujuan</label>
                                            <textarea class="form-control" name="tujuan" id="tujuan" rows="2" placeholder="Masukkan Tujuan" required></textarea>
                                            <span id="tujuan_error" class="error invalid-feedback"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="keperluan">Keperluan</label>
                                            <textarea class="form-control" name="keperluan" id="keperluan" rows="2" placeholder="Masukkan Keperluan" required></textarea>
                                            <span id="keperluan_error" class="error invalid-feedback"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="keterangan">Keterangan Lainnya</label>
                                            <textarea class="form-control" name="keterangan" id="keterangan" rows="2" placeholder="Masukkan Keterangan" required></textarea>
                                            <span id="keterangan_error" class="error invalid-feedback"></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="ktp">Unggah Bukti KTP</label>
                                            <input type="file" class="form-control" name="ktp" id="ktp" required accept="image/*">
                                            <span id="ktp_error" class="error invalid-feedback"></span>
                                        </div>

                                        <span class="text-danger" id="pengajuan_error"></span>

                                        <button class="btn btn-danger" onclick="stepper.previous()"><i class="fa fa-arrow-left mr-2" aria-hidden="true"></i>Kembali</button>
                                        <button type="button" id="btn_ajukan" onclick="btnAjukan()" class="btn btn-primary"><i class="fa fa-check mr-2" aria-hidden="true"></i>Ajukan Sekarang</button>
                                    </div>
                                    <div id="done-part" class="content" role="tabpanel" aria-labelledby="done-part-trigger">
                                        <div class="text-center">
                                            <center>
                                                <lottie-player src="https://assets8.lottiefiles.com/packages/lf20_jbrw3hcz.json" background="transparent" speed="1" style="width: 200px; height: 200px;" loop autoplay></lottie-player>
                                            </center>
                                            <h5 style="margin-top: -40px !important;">Pengajuan Surat Pengantar Berhasil Dilakukan</h5>
                                            <p>
                                                Silahkan menunggu sampai permohonan Anda divalidasi oleh Ketua RT dan Ketua RW.
                                                <br />
                                                Anda dapat mengecek permohonan melalui menu <strong>Cek Permohonan</strong>
                                            </p>

                                            <p>Silahkan <em>screenshot</em> atau salin <strong>Kode Permohonan</strong> dibawah ini!</p>

                                            <h5><strong>Kode Permohonan</strong><br />#<span id="kode_pengajuan"></span></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var input_nik = $("#nik");
    var error_nik = $("#nik_error");
    var input_nama = $('#nama');
    var input_tgl_lahir = $('#tgl_lahir');
    var error_tgl_lahir = $('#tgl_lahir_error');
    var btn_next = document.getElementById('btn_next');

    $(function() {
        btn_next.disabled = true;
        input_tgl_lahir.attr('readonly', true);
    })

    function cekNik() {
        $.ajax({
            url: 'ajax.php',
            type: 'post',
            data: {
                action: 'cek_nik',
                nik: $('#nik').val()
            },
            success: function(response) {
                const res = JSON.parse(response);
                console.log(res.status)
                if (res.status != 200) {
                    input_nik.addClass('is-invalid');
                    input_nik.attr('aria-invalid', true);

                    error_nik.html('NIK tidak ditemukan. Silahkan hubungi operator!');
                    document.getElementById("nama").value = '';
                    input_tgl_lahir.attr('readonly', true);
                    document.getElementById("tgl_lahir").value = '';
                } else {
                    input_nik.removeClass('is-invalid');
                    input_nik.attr('aria-invalid', false);

                    error_nik.html('');
                    document.getElementById("nama").value = res.data.nama;
                    input_tgl_lahir.attr('readonly', false);
                }
            }
        });
    }

    function cekNikTglLahir() {
        $.ajax({
            url: 'ajax.php',
            type: 'post',
            data: {
                action: 'cek_nik_tgl_lahir',
                nik: $('#nik').val(),
                tgl_lahir: $('#tgl_lahir').val()
            },
            success: function(response) {
                const res = JSON.parse(response);
                console.log(res.status)
                if (res.status != 200) {
                    input_tgl_lahir.addClass('is-invalid');
                    input_tgl_lahir.attr('aria-invalid', true);

                    error_tgl_lahir.html('Mohon maaf, data yang Anda masukkan tidak valid!');
                    btn_next.disabled = true;
                } else {
                    input_tgl_lahir.removeClass('is-invalid');
                    input_tgl_lahir.attr('aria-invalid', false);
                    error_tgl_lahir.html('');

                    btn_next.disabled = false;
                }
            }
        });
    }

    function btnAjukan() {
        const fileupload = $('#ktp').prop('files')[0];

        if ($('#tujuan').val() == '') {
            $('#tujuan').addClass('is-invalid')
            $('#tujuan_error').html('Tujuan harap diisi!');
        } else {
            $('#tujuan').removeClass('is-invalid')
            $('#tujuan_error').html('');
        }

        if ($('#keperluan').val() == '') {
            $('#keperluan').addClass('is-invalid')
            $('#keperluan_error').html('Keperluan harap diisi!');
        } else {
            $('#keperluan').removeClass('is-invalid')
            $('#keperluan_error').html('');
        }

        if ($('#keterangan').val() == '') {
            $('#keterangan').addClass('is-invalid')
            $('#keterangan_error').html('Keterangan harap diisi!');
        } else {
            $('#keterangan').removeClass('is-invalid')
            $('#keterangan_error').html('');
        }

        if (fileupload == '' || typeof fileupload === 'undefined') {
            $('#ktp').addClass('is-invalid')
            $('#ktp_error').html('Silahkan unggah file KTP Anda!');
        } else {
            $('#ktp').removeClass('is-invalid')
            $('#ktp_error').html('');
        }

        if ($('#tujuan').val() != '' && $('#keperluan').val() != '' && $('#keterangan').val() != '' && (fileupload != '' || typeof fileupload !== 'undefined')) {
            let formData = new FormData();
            formData.append('action', 'pengajuan');
            formData.append('nik', $('#nik').val());
            formData.append('tujuan', $('#tujuan').val());
            formData.append('keperluan', $('#keperluan').val());
            formData.append('keterangan', $('#keterangan').val());
            formData.append('fileupload', fileupload);

            $.ajax({
                url: 'ajax.php',
                type: 'post',
                enctype: 'multipart/form-data',
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    const res = JSON.parse(response);
                    if (res.status == 200) {
                        stepper.next();
                        $('#kode_pengajuan').html(res.message)
                    } else {
                        $('#pengajuan_error').html('ERROR: ' + res.message)
                    }
                }
            });
        }
    }
</script>