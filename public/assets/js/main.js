// assets/js/main.js
// Client-side interactions for Rumah Sunat Elnara

document.addEventListener('DOMContentLoaded', function () {
    // 1. Toggle Layanan Home Care / Klinik pada Form Pendaftaran
    const jenisLayananInputs = document.querySelectorAll('input[name="jenis_layanan"]');
    const homeCareSection = document.getElementById('homeCareSection');
    const inputAlamatHomeCare = document.getElementById('alamat_home_care');

    if (jenisLayananInputs.length > 0 && homeCareSection) {
        jenisLayananInputs.forEach(input => {
            input.addEventListener('change', function () {
                if (this.value === 'home_care') {
                    homeCareSection.style.display = 'block';
                    if (inputAlamatHomeCare) {
                        inputAlamatHomeCare.setAttribute('required', 'required');
                    }
                } else {
                    homeCareSection.style.display = 'none';
                    if (inputAlamatHomeCare) {
                        inputAlamatHomeCare.removeAttribute('required');
                    }
                }
            });
        });
    }

    // 2. Filter Kategori Paket di Halaman Katalog / Beranda
    const filterButtons = document.querySelectorAll('.btn-filter-paket');
    const packageItems = document.querySelectorAll('.package-item');

    if (filterButtons.length > 0 && packageItems.length > 0) {
        filterButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                filterButtons.forEach(b => b.classList.remove('active', 'btn-elnara'));
                filterButtons.forEach(b => b.classList.add('btn-outline-secondary'));
                
                this.classList.remove('btn-outline-secondary');
                this.classList.add('active', 'btn-elnara');

                const filter = this.getAttribute('data-filter');

                packageItems.forEach(item => {
                    const category = item.getAttribute('data-category');
                    if (filter === 'all' || category === filter) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    }

    // 3. Update Rincian Paket Terpilih pada Form Pendaftaran
    const selectPaket = document.getElementById('id_paket');
    const paketPreview = document.getElementById('paketPreview');
    const previewHarga = document.getElementById('previewHarga');
    const previewMetode = document.getElementById('previewMetode');
    const previewFasilitas = document.getElementById('previewFasilitas');

    if (selectPaket && paketPreview) {
        selectPaket.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            if (this.value) {
                const harga = selectedOption.getAttribute('data-harga');
                const metode = selectedOption.getAttribute('data-metode');
                const fasilitas = selectedOption.getAttribute('data-fasilitas');
                const kategori = selectedOption.getAttribute('data-kategori');

                if (previewHarga) previewHarga.textContent = harga;
                if (previewMetode) previewMetode.textContent = metode;
                if (previewFasilitas) previewFasilitas.textContent = fasilitas;

                // Auto switch jenis layanan jika memilih paket home care
                if (kategori === 'rumah') {
                    const radioHome = document.querySelector('input[name="jenis_layanan"][value="home_care"]');
                    if (radioHome) {
                        radioHome.checked = true;
                        radioHome.dispatchEvent(new Event('change'));
                    }
                }

                paketPreview.style.display = 'block';
            } else {
                paketPreview.style.display = 'none';
            }
        });
    }

    // 4. Hitung Usia Otomatis dari Tanggal Lahir
    const inputTglLahir = document.getElementById('tanggal_lahir');
    const inputUsia = document.getElementById('usia_tahun');

    if (inputTglLahir && inputUsia) {
        inputTglLahir.addEventListener('change', function () {
            if (this.value) {
                const dob = new Date(this.value);
                const today = new Date();
                let age = today.getFullYear() - dob.getFullYear();
                const m = today.getMonth() - dob.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                    age--;
                }
                inputUsia.value = age >= 0 ? age : 0;
            }
        });
    }
});

