document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('productModal');
    const form = document.getElementById('productForm');
    const modalTitle = document.querySelector('.modal-title');
    const methodField = document.getElementById('methodField'); 
    const imagePreview = document.getElementById('imagePreview');

   
    const baseUrl = '/seller/products'; 
    window.openModal = function() {   
        form.reset();
        imagePreview.style.display = 'none';
        modalTitle.innerText = "Tambah Produk Baru";
        form.action = baseUrl; 
        if (methodField) methodField.innerHTML = ''; 
        showModal();
    }
    window.editProduct = function(product) { 
        form.name.value = product.name;
        form.price.value = product.price;
        form.stock.value = product.stock;
        form.category_id.value = product.category_id;
        form.description.value = product.description || '';
        if(product.image) {  
            imagePreview.src = '/storage/' + product.image;
            imagePreview.style.display = 'block';
        } else {
            imagePreview.style.display = 'none';
        } 
        modalTitle.innerText = "Edit Produk";
        form.action = baseUrl + '/' + product.product_id; 
        if (methodField) {
            methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
        }  
        showModal();
    }
    function showModal() {
        modal.style.display = 'flex';
        setTimeout(() => {
            modal.classList.add('active');
        }, 10);
    }
    window.closeModal = function() {
        modal.classList.remove('active');
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
    }   
    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });
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