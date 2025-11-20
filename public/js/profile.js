function toggleEditMode(enable) {
    const form = document.getElementById('profileForm');
    
    if (enable) {
        form.classList.add('editing');
    } else {
        form.classList.remove('editing');
        
        document.getElementById('profileForm').reset();
    }
}


document.getElementById('profileForm').addEventListener('submit', function(e) {
    
});

function deleteAccount() {
    const confirmation = confirm("PERINGATAN: Apakah Anda yakin ingin menghapus akun ini? Tindakan ini tidak dapat dibatalkan.");
    
    if (confirmation) {
        
        document.getElementById('deleteAccountForm').submit();
    }
}

function toggleEditMode(enable) {
    const form = document.getElementById('profileForm');
    if (enable) {
        form.classList.add('editing');
    } else {
        form.classList.remove('editing');
        document.getElementById('profileForm').reset(); 
    }
}


function deleteAccount() {
    const confirmation = confirm("PERINGATAN: Apakah Anda yakin ingin menghapus akun ini? Tindakan ini tidak dapat dibatalkan.");
    if (confirmation) {
        document.getElementById('deleteAccountForm').submit();
    }
}


function togglePasswordVisibility(inputId, iconElement) {
    const input = document.getElementById(inputId);
    
    if (input.type === "password") {
        input.type = "text";
        iconElement.classList.remove('fa-eye');
        iconElement.classList.add('fa-eye-slash');
    } else {
        input.type = "password";
        iconElement.classList.remove('fa-eye-slash');
        iconElement.classList.add('fa-eye');
    }
}