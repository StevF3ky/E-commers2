/* public/js/product-detail.js */

document.addEventListener('DOMContentLoaded', function() {
    // Ambil elemen-elemen penting
    const qtyInput = document.getElementById('qtyInput');
    const btnMinus = document.getElementById('btnMinus');
    const btnPlus = document.getElementById('btnPlus');
    
    // Ambil stok maksimal dari atribut data-stock di HTML (dikirim dari Laravel)
    const maxStock = parseInt(qtyInput.getAttribute('data-max-stock')) || 0;
    
    // Fungsi Update Nilai Quantity
    function updateQty(change) {
        let currentVal = parseInt(qtyInput.value) || 1;
        let newVal = currentVal + change;

        // Validasi agar tidak kurang dari 1 dan tidak lebih dari stok
        if (newVal >= 1 && newVal <= maxStock) {
            qtyInput.value = newVal;
        }
    }

    // Event Listener Tombol Minus
    if(btnMinus) {
        btnMinus.addEventListener('click', function() {
            updateQty(-1);
        });
    }

    // Event Listener Tombol Plus
    if(btnPlus) {
        btnPlus.addEventListener('click', function() {
            updateQty(1);
        });
    }

    // Fungsi Animasi "Add to Cart" (Toast)
   window.addToCart = function() {
        // Definisi ulang elemen agar pasti ketemu
        const btnAdd = document.querySelector('.btn-primary');
        const productId = btnAdd.getAttribute('data-product-id');
        const qty = parseInt(document.getElementById('qtyInput').value);
        const toast = document.getElementById('toast');     // <--- Ambil elemen Toast lagi
        const cartBadge = document.getElementById('cartCount'); // <--- Ambil Badge lagi
        
        // Ambil CSRF Token
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Kirim Request
        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: qty
            })
        })
        .then(response => {
            if (response.status === 401) {
                alert("Silakan login untuk berbelanja.");
                window.location.href = '/login';
                return;
            }
            return response.json();
        })
        .then(data => {
            if (data && data.status === 'success') {
                // 1. Update Angka Keranjang
                if(cartBadge) {
                    cartBadge.innerText = data.total_items;
                }

                // 2. Tampilkan Toast (Notifikasi)
                if (toast) {
                    // Paksa hapus class dulu biar animasi bisa restart kalau diklik cepat
                    toast.classList.remove('show'); 
                    
                    // Beri jeda sedikit, lalu tambahkan class 'show'
                    setTimeout(() => {
                        toast.classList.add('show');
                    }, 10);

                    // Sembunyikan setelah 3 detik
                    setTimeout(() => {
                        toast.classList.remove('show');
                    }, 3000);
                }
            }
        })
        .catch(error => console.error('Error:', error));
    };
});