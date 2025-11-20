

document.addEventListener('DOMContentLoaded', function() {
   
    const qtyInput = document.getElementById('qtyInput');
    const btnMinus = document.getElementById('btnMinus');
    const btnPlus = document.getElementById('btnPlus');
    
    
    const maxStock = parseInt(qtyInput.getAttribute('data-max-stock')) || 0;
    
   
    function updateQty(change) {
        let currentVal = parseInt(qtyInput.value) || 1;
        let newVal = currentVal + change;

        
        if (newVal >= 1 && newVal <= maxStock) {
            qtyInput.value = newVal;
        }
    }

   
    if(btnMinus) {
        btnMinus.addEventListener('click', function() {
            updateQty(-1);
        });
    }

    
    if(btnPlus) {
        btnPlus.addEventListener('click', function() {
            updateQty(1);
        });
    }

   
   window.addToCart = function() {
        
        const btnAdd = document.querySelector('.btn-primary');
        const productId = btnAdd.getAttribute('data-product-id');
        const qty = parseInt(document.getElementById('qtyInput').value);
        const toast = document.getElementById('toast');    
        const cartBadge = document.getElementById('cartCount'); 
        
       
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        
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
               
                if(cartBadge) {
                    cartBadge.innerText = data.total_items;
                }

                
                if (toast) {
                    
                    toast.classList.remove('show'); 
                    
                   
                    setTimeout(() => {
                        toast.classList.add('show');
                    }, 10);

                    
                    setTimeout(() => {
                        toast.classList.remove('show');
                    }, 3000);
                }
            }
        })
        .catch(error => console.error('Error:', error));
    };
});