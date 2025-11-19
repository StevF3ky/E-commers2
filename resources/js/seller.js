document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('productModal');
    const form = document.getElementById('productForm');
    const modalTitle = document.querySelector('.modal-title');
    const methodField = document.getElementById('methodField'); // Wadah untuk @method('PUT')
    const imagePreview = document.getElementById('imagePreview');

    // URL dasar untuk produk (sesuai route Laravel Anda)
    const baseUrl = '/seller/products'; 

    // 1. Fungsi Buka Modal TAMBAH (Create Mode)
    window.openModal = function() {
        // Reset form agar kosong
        form.reset();
        imagePreview.style.display = 'none';
        
        // Ubah Tampilan ke Mode Tambah
        modalTitle.innerText = "Tambah Produk Baru";
        
        // Set Action Form ke URL Simpan (Store)
        form.action = baseUrl; 
        
        // Hapus input hidden PUT (karena tambah pakai POST)
        if (methodField) methodField.innerHTML = ''; 

        // Tampilkan Modal
        showModal();
    }

    // 2. Fungsi Buka Modal EDIT (Update Mode)
    window.editProduct = function(product) {
        // Isi form dengan data produk yang diklik
        // Pastikan nama field input di HTML (name="...") sama dengan di sini
        form.name.value = product.name;
        form.price.value = product.price;
        form.stock.value = product.stock;
        form.category_id.value = product.category_id;
        form.description.value = product.description || ''; // Pakai string kosong jika null

        // Handle Preview Gambar Lama
        if(product.image) {
            // Tampilkan gambar dari storage
            imagePreview.src = '/storage/' + product.image;
            imagePreview.style.display = 'block';
        } else {
            imagePreview.style.display = 'none';
        }

        // Ubah Tampilan ke Mode Edit
        modalTitle.innerText = "Edit Produk";
        
        // Ubah Action Form ke URL Update (pake ID produk)
        // Contoh hasil: /seller/products/15
        form.action = baseUrl + '/' + product.product_id;
        
        // Tambahkan Input Hidden Method PUT (PENTING untuk Update di Laravel)
        if (methodField) {
            methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
        }

        // Tampilkan Modal
        showModal();
    }

    // Helper: Tampilkan Modal dengan Animasi
    function showModal() {
        modal.style.display = 'flex';
        setTimeout(() => {
            modal.classList.add('active');
        }, 10);
    }

    // 3. Fungsi Tutup Modal
    window.closeModal = function() {
        modal.classList.remove('active');
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
    }

    // Tutup modal jika klik di area gelap (luar modal)
    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });

    // Fungsi Preview Gambar Baru (saat user pilih file)
    window.previewImage = function(event) {
        const file = event.target.files[0];
        if(file) {
            const reader = new FileReader();
            reader.onload = function(){
                imagePreview.src = reader.result;
                imagePreview.style.display = "block";
            }
            reader.readAsDataURL(file);
        }
    }
});