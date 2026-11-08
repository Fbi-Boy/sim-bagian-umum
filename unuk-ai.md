Siap, brok. Kali ini saya jelaskan keseluruhan proyek dari sudut pandang Senior System Analyst, Software Architect, dan Laravel Developer. Jadi bukan hanya menjelaskan fitur website, tetapi juga alasan setiap fitur dibuat, siapa yang menggunakannya, bagaimana pekerjaan antarbagian terhubung, dan bagaimana AI Coding Assistant harus memahami sistem ini.

Kamu bisa menjadikan penjelasan ini sebagai konteks utama ketika bekerja dengan Claude Code, Cursor, atau AI coding lainnya.

# 1. Gambaran umum proyek

# SIM-BU

Sistem Informasi Manajemen Bagian Umum

## Integrated Government General Affairs Management System

Satu platform untuk mengelola, menghubungkan, memantau, dan mendokumentasikan seluruh aktivitas operasional Bagian Umum.

Multi-role

Akses berdasarkan tanggung jawab

Workflow

Alur pekerjaan antarpegawai

Integrated Data

Satu sumber data terintegrasi

Accountability

Audit dan pertanggungjawaban

SIM-BU merupakan aplikasi web yang bertujuan mendigitalisasi proses administrasi dan operasional Bagian Umum di lingkungan Sekretariat Daerah Pemerintah Daerah.

Permasalahan yang ingin diselesaikan bukan sekadar pencatatan manual. Ada permasalahan lebih besar:

- Informasi pekerjaan tersebar di banyak tempat.
- Data dicatat berulang kali oleh pegawai berbeda.
- Sulit mengetahui siapa yang bertanggung jawab atas pekerjaan tertentu.
- Proses persetujuan sulit dilacak.
- Pekerjaan sering bergantung pada komunikasi WhatsApp atau komunikasi lisan.
- Riwayat peminjaman barang dan penggunaan fasilitas sulit ditemukan.
- Kepala Bagian kesulitan memantau perkembangan seluruh pekerjaan.
- Dokumen berisiko hilang atau tidak terorganisasi.

Solusi yang ditawarkan: setiap aktivitas memiliki identitas transaksi, penanggung jawab, status, alur proses, tenggat, dokumen pendukung, dan riwayat aktivitas.

Artinya, setiap pekerjaan yang dilakukan pegawai dapat dipantau sesuai kewenangan masing-masing.

# 2. Memahami struktur organisasi dan role

Ini bagian paling penting dari keseluruhan sistem.

Jangan berpikir bahwa setiap modul otomatis memiliki satu role. Dalam organisasi pemerintah, seseorang mempunyai jabatan organisasi, tugas fungsional, dan kewenangan tertentu. Ketiganya harus dipetakan secara benar ke sistem.

## 2.1 Perbedaan jabatan, role, dan permission

Contoh:

Seorang pegawai mempunyai jabatan Kepala Subbagian.

Di dalam aplikasi, dia mungkin memiliki role `kepala_subbagian_persuratan`.

Role tersebut memberikannya permission:

- Melihat surat dalam lingkup unitnya.
- Memeriksa kelengkapan surat.
- Memantau disposisi.
- Memverifikasi pekerjaan pegawai.
- Memberikan persetujuan apabila memang didelegasikan.

Jadi:

| Komponen   | Menjelaskan                            |
| ---------- | -------------------------------------- |
| Jabatan    | Posisi seseorang dalam organisasi      |
| Role       | Kelompok kewenangan di dalam aplikasi  |
| Permission | Tindakan spesifik yang boleh dilakukan |
| Scope      | Batas data yang boleh diakses          |
| Delegasi   | Pelimpahan kewenangan sementara        |

Satu pegawai dapat memiliki beberapa role, tetapi tidak boleh otomatis memperoleh semua kewenangan hanya karena memiliki jabatan tinggi.

## 2.2 Role pengguna dalam sistem

Berikut role konseptual yang dapat digunakan.

| Role                   | Tanggung jawab                             |
| ---------------------- | ------------------------------------------ |
| Super Admin            | Konfigurasi teknis dan pengelolaan sistem  |
| Kepala Bagian          | Pengawasan dan keputusan sesuai kewenangan |
| Kepala Subbagian       | Koordinasi pekerjaan dalam unit            |
| Admin Persuratan       | Administrasi surat                         |
| Petugas Arsip          | Pengelolaan arsip                          |
| Admin Perlengkapan     | Inventaris dan perlengkapan                |
| Pengurus Barang        | Pengelolaan BMD sesuai penugasan           |
| Admin Kendaraan        | Operasional kendaraan                      |
| Pengemudi              | Pelaksanaan tugas transportasi             |
| Admin Fasilitas        | Pengelolaan fasilitas kantor               |
| Admin Protokol         | Agenda dan keprotokolan                    |
| Admin Perjalanan Dinas | Administrasi perjalanan dinas              |
| Petugas Lapangan       | Pemeliharaan dan pelaksanaan pekerjaan     |
| Pegawai                | Pemohon layanan internal                   |
| Auditor/Viewer         | Pemeriksaan data sesuai izin               |

Tidak semua Pemda memiliki pembagian role tersebut. Kita akan mencocokkan nama jabatan dan kewenangannya dengan struktur organisasi sebenarnya.

## 2.3 Bagaimana role saling berhubungan?

Bayangkan seorang pegawai mengajukan peminjaman kendaraan.

Contoh hubungan role

Pegawai

Mengajukan peminjaman

Atasan / Pejabat Berwenang

Memeriksa dan menyetujui jika diwajibkan

Admin Kendaraan

Memeriksa jadwal dan menetapkan kendaraan

Pengemudi

Melaksanakan perjalanan

Admin Kendaraan

Mencatat pengembalian dan kondisi kendaraan

Seluruh proses tersebut memiliki ID transaksi yang sama.

Kepala Bagian dapat melihat ringkasan sesuai kewenangannya tanpa harus menghubungi satu per satu petugas.

# 3. Seluruh modul dan pekerjaan di dalamnya

Saya membagi sistem menjadi beberapa domain bisnis. Masing-masing domain memiliki pekerjaan, fitur, subfitur, dan hubungan dengan domain lain.

## 3.1 Modul Dashboard dan Monitoring

[Correspondence Management System by Lama on Dribbble](https://images.openai.com/static-rsc-4/mf40vODygZ12K8NuKJfJEpe6TMrwAjo6CdRWrHJIjA6OqYaLiVRUSgt-qNTBmbz9u6aVIRm1IhgqKVbwsBjEit8IolX60YZ5-HxDZwMvYkkpKm2pI9QRWKtkwN-Kkotn8ha6x49apzq3yCf-7tcZ2QHQMI3hqF7QvHuq-QLJtNU?purpose=inline)

[dribbble.com](https://dribbble.com/shots/26624181-Correspondence-Management-System?utm_source=chatgpt.com)

Dashboard merupakan halaman utama setiap pengguna setelah login.

Dashboard tidak boleh sama untuk semua role. Informasi yang ditampilkan harus sesuai tanggung jawab pengguna.

A. Dashboard Super Admin

Fungsinya mengawasi kesehatan aplikasi.

Subfitur:

- Manajemen akun.
- Manajemen role dan permission.
- Aktivitas login.
- Riwayat perubahan konfigurasi.
- Monitoring antrean pekerjaan sistem.
- Status proses backup.
- Monitoring error aplikasi.

Super Admin tidak otomatis mendapatkan hak persetujuan surat, kendaraan, atau transaksi kedinasan.

B. Dashboard Kepala Bagian

Fungsinya memberikan gambaran menyeluruh mengenai operasional Bagian Umum.

Subfitur:

- Total pekerjaan setiap modul.
- Permohonan yang menunggu keputusan.
- Surat yang belum ditindaklanjuti.
- Inventaris rusak.
- Kendaraan yang tersedia atau sedang digunakan.
- Fasilitas yang sedang diperbaiki.
- Agenda kegiatan.
- Pekerjaan yang melewati tenggat.
- Laporan performa unit.

C. Dashboard Admin Modul

Contoh Admin Inventaris:

- Total barang.
- Barang tersedia.
- Barang dipinjam.
- Barang rusak.
- Permohonan peminjaman baru.
- Pengembalian yang terlambat.
- Transaksi terakhir.

D. Dashboard Pegawai

- Permohonan milik sendiri.
- Status pengajuan.
- Tugas yang diberikan.
- Notifikasi.
- Jadwal penggunaan fasilitas.
- Riwayat aktivitas pribadi yang relevan.

Hubungan modul: Dashboard membaca data dari seluruh modul. Dashboard tidak boleh menjadi tempat menyimpan angka statistik secara manual.

## 3.2 Modul Persuratan

[Addis Ababa Science and Technology University](https://images.openai.com/static-rsc-4/lwTUCm42hL-D_YpaNIytJnCEEbU5XEdguOxj3hfuB3D9hkB_mGKjBH-dPPzAwr6wir54Uz4VbwlqCxGhwZFxmaTMzI_7eqQDXqxfwvDO1FQjGni99ANXzJl-TfdHmeb1XhfXmERev_UzDKnzwDxEgXqZZmnpU7PNtiqkT3SrVss?purpose=inline)

[eoffice-aastu.com](https://eoffice-aastu.com/?utm_source=chatgpt.com)

Pekerjaan utama: mengelola arus surat masuk, surat keluar, serta distribusi arahan atau disposisi.

Role utama: Admin Persuratan/Tata Usaha, pejabat pemberi disposisi, penerima disposisi, dan petugas arsip.

### A. Surat masuk

Subfitur:

1. Registrasi surat masuk.
2. Pembuatan nomor agenda internal.
3. Pencatatan nomor surat asli.
4. Pencatatan pengirim dan instansi asal.
5. Pencatatan tanggal surat dan tanggal diterima.
6. Pencatatan perihal.
7. Klasifikasi surat.
8. Klasifikasi kerahasiaan.
9. Upload scan dokumen.
10. Penentuan unit penerima.
11. Pencarian surat.
12. Riwayat penanganan surat.

Informasi yang harus dimiliki setiap surat:

- Nomor agenda.
- Nomor surat dari pengirim.
- Tanggal surat.
- Tanggal diterima.
- Pengirim.
- Perihal.
- Klasifikasi.
- Sifat atau urgensi.
- Dokumen lampiran.
- Petugas registrasi.
- Status.

### B. Surat keluar

Subfitur:

- Pembuatan draft metadata surat.
- Pencatatan unit pembuat.
- Pengelolaan penerima.
- Pemeriksaan kelengkapan.
- Pencatatan nomor surat sesuai mekanisme resmi.
- Pengelolaan dokumen final.
- Pencatatan tanggal pengiriman.
- Bukti pengiriman.
- Riwayat revisi.

Sistem tidak boleh menganggap surat sudah sah hanya karena admin mengunggah file. Pengesahan dan tanda tangan harus mengikuti mekanisme resmi instansi.

### C. Disposisi

Disposisi merupakan bagian penting karena menjadi penghubung surat dengan pekerjaan pegawai.

Subfitur:

- Pemberian instruksi.
- Penunjukan penerima.
- Pemilihan unit tujuan.
- Penetapan prioritas.
- Penetapan tenggat.
- Konfirmasi penerimaan.
- Pembaruan progres.
- Upload bukti tindak lanjut.
- Penyelesaian disposisi.
- Penerusan disposisi sesuai kewenangan.

### Hubungannya dengan modul lain

| Modul terkait    | Hubungan                                       |
| ---------------- | ---------------------------------------------- |
| Dashboard        | Menampilkan surat dan disposisi tertunda       |
| Keprotokolan     | Surat undangan menjadi referensi kegiatan      |
| Perjalanan Dinas | Surat tugas/undangan menjadi dokumen pendukung |
| Arsip            | Surat final disimpan sebagai dokumen arsip     |
| Workflow         | Mengatur proses pemeriksaan dan persetujuan    |
| Notification     | Memberi tahu penerima disposisi                |

Contoh: surat undangan rapat diterima oleh Admin Persuratan. Setelah mendapatkan arahan pejabat, surat diteruskan kepada Admin Protokol untuk ditindaklanjuti.

## 3.3 Modul Arsip Digital

[Document Management System Screenshots | OpenKM](https://images.openai.com/static-rsc-4/aX5lY342b4jPgEbRB1inpiu6LGiyi4bqOStsdAaMUyAO8Q9NO0hRK9warUfWljLveDER0ZwsJoR_xk6VistEeSJqcQahVEgGTTlCByPlu1nHJ93857HF3nHaaGVEMGBRvZMEN-GlPrmzWprdK3t3WrnpvIG8x5tuJBVaSZe41ws?purpose=inline)

[openkm.com](https://www.openkm.com/en/screenshots.html?utm_source=chatgpt.com)

Pekerjaan utama: menjaga dokumen agar mudah ditemukan, terorganisasi, dan memiliki riwayat pengelolaan.

Role: Petugas Arsip dan pegawai yang mendapatkan akses.

Subfitur:

- Registrasi arsip.
- Klasifikasi arsip.
- Kategori dokumen.
- Metadata dokumen.
- Upload dokumen.
- Versi dokumen.
- Pencarian arsip.
- Preview PDF.
- Riwayat unduh.
- Peminjaman arsip fisik.
- Pengembalian arsip.
- Pemantauan retensi.
- Pemindahan arsip.
- Usulan tindakan terhadap arsip sesuai aturan resmi.

Hubungan dengan modul lain:

Semua modul dapat menghubungkan dokumen ke Arsip Digital.

Misalnya:

- Surat masuk memiliki dokumen PDF.
- Inventaris memiliki berita acara serah terima.
- Kendaraan memiliki dokumen administrasi.
- Kegiatan memiliki rundown dan laporan.
- Perjalanan dinas memiliki surat tugas dan dokumen pendukung.

Jangan membuat file yang sama diunggah berkali-kali sebagai dokumen berbeda jika sebenarnya hanya merupakan referensi ke dokumen yang sudah ada. Gunakan sistem document linking dan versioning.

## 3.4 Modul Inventaris dan Perlengkapan

[TrackEase | Asset Management Software & Asset Tracking](https://images.openai.com/static-rsc-4/sG5ibbooRBDlxBZFqZZInQxzDaOOircepCZOxd-a53dwpQLRB3Cjwq_jR5LuT7dTd0SUvSvOWuC67Acya9FGRmu0dFlYA8YlXLKnPrJrn2jLc5JiWQt4YCyw21lbmLyWKAxfhoE0LHvzHXlSBTxr_YD2hMbzbplFRYNV2h_MVQE?purpose=inline)

[trackease.app](https://trackease.app/landing?utm_source=chatgpt.com)

Pekerjaan utama: mencatat, memantau, mendistribusikan, dan mengelola barang operasional kantor.

Role: Admin Perlengkapan, pengurus barang jika ada, koordinator, dan pegawai peminjam.

### A. Data inventaris

Subfitur:

- Kode barang.
- Nama barang.
- Kategori.
- Merek dan tipe.
- Nomor seri.
- Tanggal perolehan.
- Lokasi.
- Unit penanggung jawab.
- Kondisi barang.
- Status barang.
- Foto barang.
- QR Code.
- Riwayat perubahan.

### B. Distribusi dan penempatan

Subfitur:

- Penempatan barang di ruangan.
- Penanggung jawab barang.
- Serah terima.
- Perpindahan lokasi.
- Mutasi penanggung jawab.
- Riwayat mutasi.
- Berita acara.

### C. Peminjaman dan pengembalian

Subfitur:

- Pengajuan peminjaman.
- Pemilihan barang.
- Pengecekan ketersediaan.
- Verifikasi.
- Persetujuan jika dibutuhkan.
- Pencatatan serah terima.
- Konfirmasi penerimaan.
- Pengembalian.
- Pemeriksaan kondisi.
- Penanganan kerusakan atau kehilangan.

### D. Pengelolaan ATK

ATK harus dipisahkan dari barang inventaris tahan lama.

Barang seperti kertas, pulpen, tinta printer, dan map menggunakan sistem stok kuantitas.

Subfitur:

- Master barang ATK.
- Kategori ATK.
- Satuan barang.
- Penerimaan stok.
- Stok per lokasi.
- Permintaan ATK.
- Persetujuan.
- Pengeluaran stok.
- Pengembalian bila relevan.
- Penyesuaian stok.
- Stok minimum.
- Peringatan stok menipis.
- Kartu stok.

### Hubungan dengan modul lain

- Pegawai mengajukan peminjaman.
- Kepala/koordinator memverifikasi sesuai prosedur.
- Admin Perlengkapan melakukan serah terima.
- Admin Pemeliharaan menangani barang rusak.
- Arsip menyimpan berita acara.
- Dashboard menampilkan jumlah dan kondisi barang.

Penting: pengelolaan inventaris internal tidak boleh otomatis dianggap sama dengan kewenangan resmi pengelolaan Barang Milik Daerah.

## 3.5 Modul Kendaraan Dinas

[Commander — Die SaaS-Telematikplattform | Rosenberger](https://images.openai.com/static-rsc-4/Uq_zyFMMn4n9oTJoMMbA2nUtFCsRl4zr23EYhKlasxM2Rtx23d9WcAvqZxS2UaJvQ9UjIEVCEOS4t5ijXXYRDs-FE3IXuGkO2nxCVC15TdqYtkXivDfxbRMOYokW_ibbNNrmJ0Fwpp7btE52U7b6eRM-omvT0K0W8UqeuFeJ92o?purpose=inline)

[rosenberger-telematics.com](https://www.rosenberger-telematics.com/commander.html?utm_source=chatgpt.com)

Pekerjaan utama: mengatur operasional kendaraan dinas.

Role: Admin Kendaraan, pengemudi, pemohon, dan pejabat berwenang.

Subfitur:

A. Master kendaraan

- Kode kendaraan.
- Nomor polisi.
- Merek.
- Tipe kendaraan.
- Tahun.
- Kapasitas.
- Kondisi.
- Status.
- Lokasi.
- Dokumen masa berlaku.
- Riwayat servis.

B. Master pengemudi

- Identitas pengemudi.
- Status aktif.
- Nomor lisensi sesuai kebutuhan.
- Kelas lisensi.
- Masa berlaku.
- Jadwal tugas.

C. Pengajuan kendaraan

- Pemohon.
- Unit kerja.
- Tanggal dan waktu.
- Tujuan.
- Lokasi penjemputan.
- Jumlah penumpang.
- Keperluan.
- Referensi agenda atau surat tugas.

D. Penjadwalan

- Kalender kendaraan.
- Pemeriksaan konflik.
- Penetapan kendaraan.
- Penetapan pengemudi.
- Konfirmasi penugasan.
- Pembatalan.
- Perubahan jadwal.

E. Penggunaan

- Konfirmasi kendaraan keluar.
- Kilometer awal.
- Catatan penggunaan.
- Kilometer akhir.
- Konfirmasi kendaraan kembali.
- Kondisi setelah digunakan.
- Laporan kerusakan.

Hubungan dengan modul lain:

- Agenda/Protokol memberikan referensi kegiatan.
- Perjalanan Dinas memberikan referensi penugasan.
- Inventaris menyimpan data aset kendaraan.
- Pemeliharaan menerima laporan kerusakan.
- Pegawai menjadi pemohon layanan.

Sistem wajib mencegah kendaraan dan pengemudi memperoleh dua penugasan yang waktunya saling bertabrakan.

## 3.6 Modul Fasilitas dan Ruang Rapat

[Meet the new Spacebring platform | Spacebring](https://images.openai.com/static-rsc-4/vX5rw4sXblbrMgcohdta3pijXEDKUvbESFMYOMm923urZ24u8DYypnMVXRim2gxzRxZQQ5YmKC-PhpN9Lxbk4LSsDmxbMFDdjVuWUlaEebEGcK4ibSTE_8wll938fE6IwUl60QUYG-Y_LvhkYrg5bd2tLRQM0z5qMLkK6QpRs2Q?purpose=inline)

[spacebring.com](https://www.spacebring.com/blog/productivity/meet-new-spacebring?utm_source=chatgpt.com)

Pekerjaan utama: memastikan fasilitas kantor dapat digunakan dan dijadwalkan dengan baik.

Role: Admin Fasilitas, pegawai, petugas pemeliharaan.

Subfitur:

A. Master fasilitas

- Gedung.
- Ruangan.
- Kapasitas.
- Peralatan ruangan.
- Status ketersediaan.
- Lokasi.
- Penanggung jawab.

B. Booking ruangan

- Pengajuan.
- Tujuan pemakaian.
- Tanggal.
- Jam mulai.
- Jam selesai.
- Jumlah peserta.
- Kebutuhan peralatan.
- Persetujuan sesuai aturan.
- Konfirmasi penggunaan.
- Check-in dan check-out.
- Pembatalan.

C. Pengelolaan fasilitas

- Pemeriksaan fasilitas.
- Laporan kerusakan.
- Penjadwalan perbaikan.
- Riwayat penggunaan.
- Jadwal perawatan.

Hubungan dengan modul lain:

Admin Protokol mengatur agenda kegiatan, lalu Admin Fasilitas mengatur ruangan berdasarkan agenda tersebut.

Admin Perlengkapan dapat diminta menyediakan proyektor, mikrofon, meja, dan kursi.

Dengan demikian, satu kegiatan dapat secara otomatis membuat beberapa pekerjaan persiapan di unit berbeda.

## 3.7 Modul Pemeliharaan dan Pengaduan Kerusakan

[maint.works | CNC Maintenance and Field Service Platform](https://images.openai.com/static-rsc-4/symjSl3v5zURFR8Se0OTVdRWw1LnJ79fr4ar0s0QP_gxvB0UQLRgPGIODoUmXm6k9Ecgb3xjT6wzjYkygjsXZlQnld4qGBxIGh5Lo6JpVE6rwkQXP0yy6pu0qXGa3LRWyxRj0jvggSS2nH_Scti4kgUNHrWkYYppqWJETZhDi9Y?purpose=inline)

[maint.works](https://maint.works/en.html?utm_source=chatgpt.com)

Pekerjaan utama: memastikan kerusakan fasilitas atau barang dapat ditangani dan ditelusuri.

Role: Pegawai pelapor, Admin Fasilitas, Admin Pemeliharaan, petugas teknis, koordinator.

Subfitur:

- Form laporan kerusakan.
- Foto kondisi.
- Pemilihan barang/fasilitas.
- Lokasi kerusakan.
- Kategori kerusakan.
- Prioritas.
- Verifikasi laporan.
- Penugasan petugas.
- Progres perbaikan.
- Upload bukti.
- Verifikasi hasil.
- Penyelesaian tiket.
- Riwayat pemeliharaan.
- Jadwal pemeliharaan berkala.

Contoh hubungan:

1. Pegawai melaporkan AC ruang rapat rusak.
2. Admin Fasilitas memverifikasi.
3. Koordinator menugaskan petugas.
4. Petugas melakukan perbaikan.
5. Petugas mengunggah bukti.
6. Admin memverifikasi penyelesaian.
7. Riwayat kerusakan ruangan diperbarui.

Sistem tidak boleh menutup tiket hanya karena petugas menekan tombol selesai. Harus ada catatan pekerjaan dan bukti sesuai kebijakan.

## 3.8 Modul Agenda dan Keprotokolan

[Stela Protocolo & Eventos también en Feria de Zaragoza – Noticias – Diaple Networking SL](https://images.openai.com/static-rsc-4/IPUOJ6qoQB0LEc-b_i4hXGfGdnXhk8dmleBKACGZ7t5fyMuUFAIbo0YT0A9Te7QTKxPpKKcUvpoyAO9_U464Fd3xOx-0K3vL5B68vLDT5UHpmf929otaNYMp5XRwE1TyJOzYKXpL2QzfzL3_vmRiLEAsC-HlACaczbLnAdIDEyM?purpose=inline)

[diaple.com](https://www.diaple.com/actualidad/stela-protocolo-eventos-tambien-en-feria-de-zaragoza?utm_source=chatgpt.com)

Pekerjaan utama: menyiapkan dan mengoordinasikan kegiatan resmi pemerintah.

Role: Admin Protokol, pejabat terkait, Admin Fasilitas, Admin Kendaraan, Admin Perlengkapan.

Subfitur:

A. Agenda

- Nama kegiatan.
- Penyelenggara.
- Waktu kegiatan.
- Lokasi.
- Penanggung jawab.
- Referensi surat.
- Pimpinan yang hadir.
- Status persiapan.

B. Susunan acara

- Urutan acara.
- Waktu mulai dan selesai.
- Durasi.
- Penanggung jawab acara.
- Pembawa acara.
- Kebutuhan perlengkapan.
- Riwayat revisi rundown.

C. Penerimaan tamu

- Nama tamu.
- Instansi.
- Tujuan kunjungan.
- Jadwal kunjungan.
- Petugas penerima.
- Status kehadiran.
- Catatan protokol.

D. Checklist persiapan

- Ruangan.
- Kendaraan.
- Peralatan.
- Konsumsi jika termasuk kewenangan.
- Petugas.
- Dokumentasi.

Hubungan dengan modul lain:

Admin Protokol menjadi koordinator kebutuhan acara.

Ketika kegiatan dibuat, sistem dapat menyediakan checklist tugas kepada:

- Admin Fasilitas.
- Admin Perlengkapan.
- Admin Kendaraan.
- Admin Persuratan.
- Petugas terkait.

Ini membuat pekerjaan setiap unit saling terhubung melalui satu ID kegiatan.

## 3.9 Modul Perjalanan Dinas

[Aplikasi Surat Perintah Perjalanan Dinas SPPD, E-Perjadin - Raja Coding](https://images.openai.com/static-rsc-4/7nkFMiGRzDQAKr_grOkvpWlULGBCg2lYo7iSMwsrSQzPfljSLuB3U5zqD3_FVk76WA9FCqaW4MaSkbF1ydTfgeTzjuTmc_e5Z8VKZ5HQJZk5xFaZPqTSAplP0ogE1pl9MbEBKuF5sdsw5fD2pVRVztY3n-yA1oIPUqbQLr05G1M?purpose=inline)

[rajacoding.com](https://rajacoding.com/produk/aplikasi-surat-perintah-perjalanan-dinas-sppd-e-perjadin?utm_source=chatgpt.com)

Pekerjaan utama: mengelola administrasi perjalanan kedinasan apabila memang menjadi lingkup kewenangan Bagian Umum.

Subfitur:

- Pengajuan perjalanan.
- Pegawai peserta.
- Tujuan perjalanan.
- Tanggal berangkat.
- Tanggal pulang.
- Maksud perjalanan.
- Dokumen pendukung.
- Verifikasi.
- Persetujuan pejabat.
- Administrasi surat tugas.
- Pencatatan pelaksanaan.
- Upload dokumen penyelesaian.
- Rekap perjalanan.

Hubungan dengan modul lain:

- Persuratan: undangan dan surat tugas.
- Protokol: agenda pimpinan.
- Kendaraan: transportasi dinas.
- Keuangan: proses anggaran dan pertanggungjawaban sesuai kewenangan.
- Arsip: penyimpanan dokumen.

Modul ini harus dikoordinasikan dengan unit keuangan dan kepegawaian. Jangan membuat sistem perhitungan anggaran yang belum divalidasi.

# 4. Integrasi seluruh modul: satu kegiatan bisa melibatkan banyak bagian

Ini adalah nilai utama SIM-BU.

Saya tidak ingin sistem ini hanya menjadi kumpulan menu yang berdiri sendiri.

Kita harus membuat hubungan proses bisnis.

Contoh: Pemda akan mengadakan rapat koordinasi di lingkungan kantor Bupati.

Siklus pengelolaan kegiatan

1. Persuratan

   Surat undangan diterima dan dicatat.
2. Pejabat berwenang

   Memberikan disposisi atau arahan.
3. Protokol

   Membuat agenda, rundown, dan checklist.
4. Fasilitas

   Menyiapkan ruang rapat.
5. Perlengkapan

   Menyiapkan proyektor, mikrofon, meja, dan kursi.
6. Kendaraan

   Menyiapkan transportasi jika diperlukan.
7. Perjalanan Dinas

   Mengurus administrasi perjalanan apabila dibutuhkan.
8. Arsip

   Menyimpan dokumen kegiatan dan bukti administrasi.

Hasil akhir

Dashboard kegiatan menampilkan semua pekerjaan, siapa penanggung jawabnya, mana yang selesai, dan mana yang masih tertunda.

Perhatikan bahwa setiap modul tetap memiliki pemilik data masing-masing. Protokol tidak boleh mengubah langsung database inventaris atau kendaraan. Protokol cukup membuat permintaan/tugas melalui mekanisme integrasi yang telah ditentukan.

# 5. Workflow dan sistem persetujuan

Workflow merupakan mesin alur pekerjaan yang digunakan bersama oleh seluruh modul.

## 5.1 Konsep status

Setiap proses memiliki status yang jelas:

| Status         | Makna                         |
| -------------- | ----------------------------- |
| Draft          | Belum diajukan                |
| Submitted      | Sudah diajukan                |
| Under Review   | Sedang diperiksa              |
| Needs Revision | Dikembalikan untuk diperbaiki |
| Approved       | Disetujui                     |
| Rejected       | Ditolak                       |
| In Progress    | Sedang dilaksanakan           |
| Completed      | Selesai                       |
| Cancelled      | Dibatalkan                    |
| Archived       | Sudah diarsipkan              |

Tidak semua modul harus memakai seluruh status tersebut. Status disesuaikan dengan karakter proses.

## 5.2 Contoh workflow peminjaman aset

Pegawai tidak boleh langsung mengubah status barang menjadi dipinjam.

Urutannya:

1. Pegawai mengajukan peminjaman.
2. Backend memvalidasi ketersediaan barang.
3. Sistem memeriksa kewenangan pemohon.
4. Permohonan masuk ke antrean admin/pejabat yang tepat.
5. Pejabat menyetujui jika persetujuan dibutuhkan.
6. Admin melakukan serah terima.
7. Barang berubah menjadi status dipinjam.
8. Pengembalian dicatat.
9. Petugas memeriksa kondisi.
10. Barang kembali tersedia atau masuk penanganan kerusakan.

## 5.3 Pemisahan tugas

Untuk proses sensitif, pembuat transaksi dan penyetuju tidak boleh orang yang sama apabila aturan instansi mewajibkan pemisahan tugas.

Aplikasi harus mengetahui:

- Siapa pembuat permohonan.
- Siapa pemeriksa.
- Siapa penyetuju.
- Siapa pelaksana.
- Siapa yang mengonfirmasi penyelesaian.

Semua keputusan menyimpan waktu, aktor, dan alasan.

# 6. Arsitektur teknis menggunakan Laravel

Sekarang masuk ke bagian bagaimana sistem ini dibangun secara teknis.

Arsitektur aplikasi

Web Browser

Pegawai · Admin · Kepala Bagian

Laravel HTTP Layer

Routes · Middleware · Controller · Form Request

Domain Business Layer

Identity

Workflow

Correspondence

Archives

Inventory

Supplies

Vehicles

Facilities

Maintenance

Events

Official Travel

Reporting

Infrastructure Layer

Eloquent · MySQL · Queue · Storage · Notifications

## 6.1 Mengapa Modular Monolith?

Kita menggunakan satu aplikasi Laravel, tetapi kode setiap modul dipisah.

Contohnya:

```
app/
├── Modules/
│   ├── Identity/
│   ├── Organization/
│   ├── Workflow/
│   ├── Correspondence/
│   ├── Archives/
│   ├── Inventory/
│   ├── Supplies/
│   ├── Vehicles/
│   ├── Facilities/
│   ├── Maintenance/
│   ├── Events/
│   ├── OfficialTravel/
│   ├── Reporting/
│   └── Audit/
│
├── Http/
├── Models/
├── Livewire/
├── Jobs/
├── Notifications/
└── Support/
```

Kelebihannya:

- Satu sistem autentikasi.
- Satu database utama.
- Komponen workflow bisa dipakai banyak modul.
- Perubahan satu modul lebih terkontrol.
- Lebih mudah dilakukan testing.
- Tidak membutuhkan kompleksitas microservices sejak awal.

## 6.2 Fungsi komponen Laravel

| Komponen     | Fungsi                             |
| ------------ | ---------------------------------- |
| Model        | Mewakili data dan relasi           |
| Controller   | Menangani HTTP request             |
| Form Request | Validasi input                     |
| Policy       | Memastikan pengguna memiliki akses |
| Action       | Menjalankan satu tindakan bisnis   |
| Event        | Menandai peristiwa bisnis          |
| Listener     | Menjalankan respons terhadap event |
| Job          | Pekerjaan asynchronous             |
| Notification | Mengirim pemberitahuan             |
| Query        | Mengelola pembacaan data kompleks  |
| Migration    | Membuat dan mengubah tabel         |
| Seeder       | Mengisi data awal                  |

Contoh: `SubmitVehicleRequest.php` adalah Action yang menangani proses pengajuan kendaraan, bukan sekadar menyimpan form ke database.

# 7. Arsitektur database

Database menjadi fondasi untuk seluruh keterhubungan di atas.

Kita menggunakan MySQL dengan struktur yang saling terhubung.

Ada beberapa kelompok data utama:

| Domain database | Entitas penting                                          |
| --------------- | -------------------------------------------------------- |
| Identity        | users, roles, permissions, user_roles                    |
| Organization    | employees, organizational_units, positions               |
| Workflow        | workflow_instances, workflow_steps, workflow_approvals   |
| Correspondence  | incoming_letters, outgoing_letters, letter_dispositions  |
| Archives        | documents, document_versions, archive_records            |
| Inventory       | assets, asset_categories, asset_loans, asset_movements   |
| Supplies        | supply_items, stock_balances, stock_transactions         |
| Vehicles        | vehicles, drivers, vehicle_requests, vehicle_assignments |
| Facilities      | rooms, locations, room_bookings                          |
| Maintenance     | maintenance_tickets, maintenance_updates                 |
| Events          | events, event_agendas, event_tasks                       |
| Official Travel | official_travel_requests, official_travel_participants   |
| Audit           | activity_logs                                            |

### Bagaimana hubungan datanya?

Misalnya pegawai meminjam laptop:

- `users`: akun yang mengajukan.
- `employees`: identitas pegawai.
- `organizational_units`: unit kerja.
- `assets`: laptop yang dipinjam.
- `asset_loans`: transaksi peminjaman.
- `asset_loan_items`: barang dalam transaksi.
- `workflow_instances`: proses persetujuan.
- `workflow_approvals`: keputusan pejabat.
- `documents`: berita acara.
- `activity_logs`: riwayat tindakan.

Satu pekerjaan dapat menggunakan sejumlah tabel, tetapi setiap tabel memiliki fungsi berbeda.

Hal yang harus dihindari: menyimpan seluruh informasi di satu tabel besar atau menduplikasi identitas pegawai di setiap modul.

Untuk desain final, ERD, foreign key, unique constraint, indeks, dan urutan migration harus diperiksa bersama sebelum database produksi dibuat.

# 8. Pencegahan human error

Kamu sebelumnya menekankan bahwa sistem harus dirancang untuk mengurangi human error. Ini harus diterapkan di seluruh lapisan.

Saya mengusulkan delapan jenis kontrol.

| Kontrol              | Penerapan                                            |
| -------------------- | ---------------------------------------------------- |
| Input validation     | Memastikan data yang dimasukkan valid                |
| Duplicate prevention | Mencegah data ganda                                  |
| Authorization        | Mencegah tindakan oleh pengguna yang tidak berwenang |
| Workflow validation  | Mencegah status berubah sembarangan                  |
| Conflict detection   | Mencegah jadwal kendaraan/ruangan bentrok            |
| Stock integrity      | Mencegah stok negatif                                |
| Audit trail          | Mengetahui siapa melakukan perubahan                 |
| Error recovery       | Memungkinkan koreksi dengan riwayat yang jelas       |

Contoh nyata:

Pegawai mengajukan peminjaman ruangan pukul 09.00–11.00. Pegawai lain sudah memesan ruangan yang sama pukul 10.00–12.00.

Sistem harus langsung mendeteksi adanya overlap dan menolak atau meminta pemohon memilih waktu lain.

Tidak cukup hanya menampilkan kalender. Backend harus mengunci dan memvalidasi data agar dua permohonan yang masuk bersamaan tidak sama-sama berhasil.

Hal yang sama berlaku untuk stok dan kendaraan.

## 8.1 Audit trail

Setiap perubahan penting harus menyimpan:

- Pengguna yang melakukan tindakan.
- Jenis aktivitas.
- Data yang diubah.
- Nilai sebelum dan sesudah jika relevan.
- Waktu.
- Alasan perubahan jika diperlukan.
- Referensi transaksi.

Data historis tidak boleh dihapus begitu saja untuk menyembunyikan kesalahan. Gunakan pembatalan, koreksi, atau reversal yang tercatat.

# 9. Keamanan dan perlindungan data

Karena ini aplikasi untuk lingkungan pemerintah, keamanan tidak boleh dianggap sebagai fitur tambahan.

Beberapa aspek yang wajib ada:

Autentikasi

- Login aman.
- Password hashing.
- Reset password.
- Pembatasan percobaan login.
- Pengelolaan session.

Otorisasi

- Role dan permission.
- Policy pada setiap resource.
- Pembatasan akses antarunit.
- Pembatasan dokumen berdasarkan klasifikasi.
- Delegasi dengan masa berlaku.

Keamanan dokumen

- Private storage.
- Validasi file.
- Pembatasan ukuran.
- Pengunduhan melalui endpoint yang memeriksa izin.
- Versioning dokumen.
- Backup file.

Keamanan operasional

- HTTPS.
- Secret tidak masuk repository.
- Backup dan restore.
- Logging error.
- Pemisahan development dan production.
- Pembatasan akses database.
- Uji keamanan sebelum deployment.

Perlu ada persetujuan instansi terkait penggunaan server, cloud, integrasi eksternal, serta jenis data yang boleh disimpan.

# 10. Desain antarmuka dan pengalaman pengguna

Saya merekomendasikan UI yang profesional, minimalis, dan cocok untuk aplikasi administrasi pemerintahan.

Bukan berarti harus terlihat seperti aplikasi pemerintah yang kaku. Tetapi tampilannya harus mudah dipahami, konsisten, dan tidak membingungkan pegawai.

[Orders and invoices dashboard — Untitled UI by Jordan Hughes® on Dribbble](https://images.openai.com/static-rsc-4/mHEZTsy-XS5d99rhWvqnC1BrvZVTB8n7TLOOJpJQyufkFK-pN85qrvpJ2MV0u7LqwNQ5Odrkr5b-ce4QIjLm30S_Z0Q26iJ5SDSiVvuwxgfTyDl-Nk5X-vO5YiXbkP_evjyuREuC3MqQt2KYODJR7kQYnWB2la74mhMfShPulM4?purpose=inline)

Light mode

Dominan putih, abu-abu, dan hijau tua.

[NoviceDesigner - SaaS Admin Dashboard UI by Riyanto Febrian | Novice Designer on Dribbble](https://images.openai.com/static-rsc-4/VWPIfNNz921rGLJ9n6DLGxP6PfEwdCIrJyvfPzdUIjJ5ZIqwykSLtiUuIaYXogLBCPZ8UwOyNHJHO5HnmL7RcIxycaLZ3JzjtaO0VWax2pG3klhoK22uQ0SdiRkDq-g_pdYUBRfxlWiJ1-PVCykYSG26eKuI_XihzUtdoncWSM4?purpose=inline)

Dark mode

Dark charcoal dengan aksen hijau yang terkontrol.

Komponen UI yang dibutuhkan:

- Sidebar dinamis berdasarkan permission.
- Header dan profil pengguna.
- Dashboard dengan widget sesuai role.
- Data table dengan filter.
- Form yang konsisten.
- Modal konfirmasi.
- Status badge.
- Timeline aktivitas.
- Notifikasi.
- Empty state.
- Loading state.
- Error state.
- Halaman detail transaksi dengan riwayat.

### Contoh halaman detail permohonan

Setiap transaksi sebaiknya memiliki halaman detail dengan struktur:

1. Informasi utama permohonan.
2. Identitas pemohon.
3. Unit kerja.
4. Data objek yang diminta.
5. Dokumen pendukung.
6. Status saat ini.
7. Riwayat persetujuan.
8. Timeline aktivitas.
9. Petugas penanggung jawab.
10. Tombol tindakan yang tersedia bagi pengguna tersebut.

Dengan pola ini, pegawai tidak perlu berpindah ke banyak halaman untuk memahami satu pekerjaan.

# 11. Strategi pengembangan per sprint

Saya tidak menyarankan mengembangkan semua modul sekaligus. Proyek sebesar ini harus dibangun dari fondasi menuju fitur operasional.

## Roadmap pengembangan SIM-BU

1. Sprint 0 — Discovery

   Observasi, struktur organisasi, SOTK, analisis proses manual, kebutuhan dan kewenangan.

   Fondasi bisnis
2. Sprint 1 — Core System

   Laravel setup, login, akun pegawai, unit kerja, RBAC, permission, audit, dan dashboard.
3. Sprint 2 — Persuratan dan Arsip

   Surat masuk, surat keluar, disposisi, pengarsipan, dan document management.
4. Sprint 3 — Inventaris dan ATK

   Barang, lokasi, peminjaman, pengembalian, stok, dan mutasi.
5. Sprint 4 — Kendaraan dan Fasilitas

   Data kendaraan, pengemudi, booking, ruang rapat, dan ketersediaan.
6. Sprint 5 — Pemeliharaan

   Tiket kerusakan, penugasan, progres, penyelesaian, dan jadwal perawatan.
7. Sprint 6 — Agenda dan Keprotokolan

   Agenda pimpinan, rundown, daftar tamu, checklist, dan koordinasi kegiatan.
8. Sprint 7 — Perjalanan Dinas

   Administrasi pengajuan, persetujuan, dokumen, dan penyelesaian sesuai kewenangan.
9. Sprint 8 — Monitoring dan Reporting

   Laporan lintas modul, analitik, export, dan evaluasi.
10. Sprint 9 — QA dan Deployment

    Pengujian menyeluruh, UAT, keamanan, backup, deployment, panduan, dan serah terima.

Setiap sprint harus menghasilkan sesuatu yang bisa diperiksa, bukan hanya sekumpulan kode.

Contoh satu sprint:

- Buat branch.
- Buat issue/tugas.
- Implementasikan fitur.
- Buat test.
- Jalankan test.
- Review perubahan.
- Buat Pull Request.
- Merge jika memenuhi kriteria.
- Perbarui dokumentasi.

# 12. Aturan yang harus dipatuhi AI Coding Assistant

Bagian ini sangat penting. AI harus memahami bahwa proyek ini bukan tempat untuk membuat fitur secara sembarangan.

Gunakan aturan berikut sebagai instruksi kerja:

AI Developer Operating Rules

Instruksi yang dapat ditempatkan dalam `AGENTS.md` atau dijadikan konteks proyek.

1\. Understand before coding

Selalu periksa struktur repository, kode yang sudah tersedia, dan dokumentasi sebelum melakukan perubahan.

2\. Respect business processes

Jangan mengarang kewenangan pejabat atau proses persetujuan. Tandai kebutuhan yang belum diverifikasi.

3\. Follow modular architecture

Pertahankan batas antar-domain dan jangan memasukkan seluruh logika ke controller.

4\. Protect existing work

Jangan menghapus atau menimpa implementasi yang sudah ada tanpa memahami dampaknya.

5\. Backend authorization is mandatory

Jangan hanya mengandalkan hidden menu atau validasi frontend.

6\. Database integrity matters

Gunakan foreign key, constraint, transaksi database, dan audit history.

7\. Test every critical workflow

Prioritaskan pengujian otorisasi, persetujuan, stok, jadwal, dan akses dokumen.

8\. No fake functionality

Jangan membuat tombol, status, notifikasi, atau statistik yang hanya terlihat bekerja tetapi tidak memiliki fungsi backend.

9\. Document all important decisions

Perbarui dokumentasi ketika terjadi perubahan arsitektur atau aturan bisnis.

10\. Work incrementally

Kerjakan berdasarkan sprint, satu lingkup perubahan yang jelas, kemudian review sebelum melanjutkan.

# 13. Hal yang masih harus dikonfirmasi kepada Pemda

Saya ingin kamu berhati-hati di bagian ini.

Kita sedang membuat sistem berdasarkan gambaran umum pekerjaan Bagian Umum, tetapi belum tentu semuanya berada di bawah kewenangan Bagian Umum pada lokasi magang adik kelasmu.

Karena itu, beberapa hal harus diverifikasi:

| Hal yang perlu diketahui           | Mengapa penting                         |
| ---------------------------------- | --------------------------------------- |
| Struktur organisasi resmi          | Menentukan role aktual                  |
| Uraian tugas masing-masing jabatan | Menentukan tanggung jawab               |
| Sistem persuratan yang digunakan   | Menentukan kebutuhan integrasi          |
| Pengelolaan BMD                    | Menentukan batas modul inventaris       |
| Pengelolaan kendaraan              | Menentukan pemilik proses               |
| Pengelolaan fasilitas              | Menentukan role operasional             |
| Pengelolaan perjalanan dinas       | Menentukan batas dengan keuangan        |
| Klasifikasi arsip                  | Menentukan akses dan retensi            |
| Kebijakan IT Pemda                 | Menentukan infrastruktur dan deployment |

Sistem yang dibuat harus mengikuti proses nyata. Apabila sebuah proses sudah memiliki aplikasi resmi, kita sebaiknya mempertimbangkan integrasi daripada membuat sistem kedua yang berpotensi menghasilkan data ganda.

# 14. Definisi akhir proyek

Saya ingin kamu memiliki gambaran bahwa hasil akhir SIM-BU bukan hanya website yang bisa login, menambah barang, atau mengirim surat.

Targetnya adalah aplikasi yang mampu:

1. Mengelola identitas pegawai dan struktur organisasi.
2. Memberikan akses berdasarkan role, permission, dan cakupan data.
3. Menjalankan proses pekerjaan secara terstruktur.
4. Menghubungkan permohonan dengan petugas yang bertanggung jawab.
5. Menjalankan workflow pemeriksaan dan persetujuan.
6. Menghubungkan modul yang membutuhkan data satu sama lain.
7. Menyimpan dokumen dan bukti kegiatan.
8. Menampilkan status pekerjaan secara real-time atau mendekati real-time.
9. Menyimpan riwayat seluruh tindakan penting.
10. Menghasilkan laporan yang dapat ditelusuri.
11. Mengurangi kesalahan input dan konflik operasional.
12. Menjaga keamanan dan keberlanjutan data.

Kesimpulan arsitektural: SIM-BU adalah platform manajemen proses kerja Bagian Umum berbasis Laravel, dengan Modular Monolith, RBAC, workflow engine, shared master data, document management, audit trail, dan modul operasional yang terintegrasi.

Bukan sekadar aplikasi CRUD.

## 15. Urutan pekerjaan kita setelah ini

Menurut saya, urutannya harus seperti berikut:

| Prioritas | Pekerjaan                                 | Status                     |
| --------- | ----------------------------------------- | -------------------------- |
| 1         | Memahami proses dan kebutuhan Bagian Umum | Berjalan                   |
| 2         | Memastikan struktur organisasi dan role   | Menunggu validasi instansi |
| 3         | Menyelesaikan SRS                         | Draft                      |
| 4         | Menyelesaikan ERD dan database schema     | Belum                      |
| 5         | Menyusun BPMN masing-masing proses        | Belum                      |
| 6         | Menentukan UI/UX dan design system        | Belum                      |
| 7         | Implementasi Laravel                      | Belum                      |
| 8         | Testing dan deployment                    | Belum                      |

Saya sengaja menempatkan ERD dan BPMN sebelum coding, karena keduanya menentukan bagaimana data dan pekerjaan saling berhubungan.

Saran saya: jadikan penjelasan ini sebagai Project Context utama AI. Lalu simpan tiga jenis dokumentasi di repository: `PROJECT_OVERVIEW.md`, `ARCHITECTURE.md`, dan `BUSINESS_PROCESSES.md`. Dengan begitu AI tidak perlu menebak-nebak fungsi website setiap kali kamu memulai sesi pengembangan baru.

Kita juga bisa membuat evaluasi progres setiap minggu berdasarkan sprint yang sedang dikerjakan.

🗂️Evaluasi progres sprint SIM-BU mingguanTap to set up
