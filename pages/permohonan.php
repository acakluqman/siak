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
                        <div class="bs-stepper linear">
                            <div class="bs-stepper-header" role="tablist">
                                <div class="step active" data-target="#logins-part">
                                    <button type="button" class="step-trigger" role="tab" aria-controls="logins-part" id="logins-part-trigger" aria-selected="true">
                                        <span class="bs-stepper-circle">1</span>
                                        <span class="bs-stepper-label">Data Pemohon</span>
                                    </button>
                                </div>
                                <div class="line"></div>
                                <div class="step" data-target="#information-part">
                                    <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger" aria-selected="false" disabled="disabled">
                                        <span class="bs-stepper-circle">2</span>
                                        <span class="bs-stepper-label">Informasi Permohonan</span>
                                    </button>
                                </div>
                            </div>
                            <div class="bs-stepper-content">
                                <div id="logins-part" class="content active dstepper-block" role="tabpanel" aria-labelledby="logins-part-trigger">
                                    <div class="form-group">
                                        <label for="nik">NIK Pemohon</label>
                                        <input type="text" class="form-control is-invalid" name="nik" id="nik" placeholder="Masukkan NIK Pemohon" aria-describedby="nik_error" aria-invalid="true">
                                        <span id="nik_error" class="error invalid-feedback">NIK tidak ditemukan. Silahkan hubungi admin untuk proses entri data!</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Nama Lengkap Pemohon</label>
                                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Lengkap Pemohon" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="tgl_lahir">Tanggal Lahir Pemohon</label>
                                        <input type="password" class="form-control is-invalid" name="tgl_lahir" id="tgl_lahir" placeholder="Masukkan Tanggal Lahir Pemohon" aria-describedby="tgl_lahir_error" aria-invalid="true">
                                        <span id="tgl_lahir_error" class="error invalid-feedback">Mohon maaf, data yang Anda masukkan tidak valid!</span>
                                    
                                    </div>
                                    <button class="btn btn-primary" onclick="stepper.next()"><i class="fa fa-arrow-right mr-2" aria-hidden="true"></i> Lanjutkan</button>
                                </div>
                                <div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                    <div class="form-group">
                                        <label for="tujuan">Tujuan</label>
                                        <textarea class="form-control" name="tujuan" id="tujuan" rows="2" placeholder="Masukkan Tujuan"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="keperluan">Keperluan</label>
                                        <textarea class="form-control" name="keperluan" id="keperluan" rows="2" placeholder="Masukkan Keperluan"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="keterangan">Keterangan Lainnya</label>
                                        <textarea class="form-control" name="keterangan" id="keterangan" rows="2" placeholder="Masukkan Keterangan"></textarea>
                                    </div>
                                    <button class="btn btn-danger" onclick="stepper.previous()"><i class="fa fa-arrow-left mr-2" aria-hidden="true"></i>Kembali</button>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check mr-2" aria-hidden="true"></i>Ajukan Sekarang</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>