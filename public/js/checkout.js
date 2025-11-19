/* public/js/checkout.js */

function processCheckout() {
    const btn = document.querySelector('.checkout-btn');
    const originalText = btn.innerHTML;

    // Ubah tombol jadi loading
    btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Memproses...';
    btn.style.background = '#4b5563';
    btn.disabled = true;
    
    // Simulasi Loading (Nanti bisa diganti redirect ke Payment Gateway)
    setTimeout(() => {
        alert('Pembayaran Berhasil! Terima kasih telah berbelanja.');
        
        // Redirect ke Home (Contoh)
        window.location.href = '/';
    }, 2000);
}