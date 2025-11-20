

function processCheckout() {
    const btn = document.querySelector('.checkout-btn');
    const originalText = btn.innerHTML;

    
    btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Memproses...';
    btn.style.background = '#4b5563';
    btn.disabled = true;
    
    
    setTimeout(() => {
        alert('Pembayaran Berhasil! Terima kasih telah berbelanja.');
        
        
        window.location.href = '/';
    }, 2000);
}

function updateQuantity(itemId, change) {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    
    const buttons = document.querySelectorAll('.qty-btn');
    buttons.forEach(btn => btn.disabled = true);

    fetch(`/cart/update/${itemId}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ change: change })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
           
            document.getElementById(`qty-val-${itemId}`).innerText = data.new_quantity;
            
            
            document.getElementById(`line-total-${itemId}`).innerText = data.new_line_total;
            
            
            document.getElementById('subtotal').innerText = data.new_subtotal;
            document.getElementById('total').innerText = data.new_subtotal;
        } else {
            alert(data.message); 
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengupdate keranjang.');
    })
    .finally(() => {
        
        buttons.forEach(btn => btn.disabled = false);
    });
}