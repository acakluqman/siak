<div class="content pt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        <form action="" class="form" method="post">
                            <div class="form-group">
                                <label for="kode_permohonan">Kode Permohonan</label>
                                <input type="text" class="form-control" name="kode_permohonan" id="kode_permohonan" value="<?= isset($_POST['kode_permohonan']) ? $_POST['kode_permohonan'] : '' ?>" placeholder="Masukkan Kode Permohonan">
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Tampilkan</button>
                        </form>

                        <?php if (isset($_POST['kode_permohonan'])) : ?>
                            <div class="pt-4" id="result">
                                <p>Status Permohonan</p>
                                <table class="w-100">
                                    <tr>
                                        <td>NIK</td>
                                        <td style="width: 80%;">: 32786498534867456</td>
                                    </tr>
                                    <tr>
                                        <td>Nama Lengkap</td>
                                        <td>: Nama Pemohon</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Pengajuan</td>
                                        <td>: 10 Oktober 2022 12:34 PM</td>
                                    </tr>
                                    <tr>
                                        <td>Tujuan</td>
                                        <td>: Tujuan</td>
                                    </tr>
                                    <tr>
                                        <td>Keperluan</td>
                                        <td>: Keperluan</td>
                                    </tr>
                                    <tr>
                                        <td>Keterangan Lainnya</td>
                                        <td>: Keterangan Lainnya</td>
                                    </tr>
                                </table>
                                <table class="w-100 mt-3">
                                    <tr>
                                        <td><i class="fa fa-check-circle text-success" aria-hidden="true"></i></td>
                                        <td style="width: 95%;">Validasi Ketua RT</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-check-circle text-muted" aria-hidden="true"></i></td>
                                        <td>Menunggu validasi Ketua RW</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-check-circle text-danger" aria-hidden="true"></i></td>
                                        <td>Ditolak Ketua RW<br><span class="text-muted"><i>Keterangan penolakan</i></span></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><button class="btn btn-danger mt-4"><i class="fa fa-file-pdf mr-3" aria-hidden="true"></i>Unduh Surat</button></td>
                                    </tr>
                                </table>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>