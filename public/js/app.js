// Toggle Sidebar
document.addEventListener('DOMContentLoaded', function() {
    const toggleSidebar = document.getElementById('toggle-sidebar');
    const sidebar = document.getElementById('sidebar');
    
    if (toggleSidebar) {
        toggleSidebar.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
    }
    
    // Mobile toggle
    if (window.innerWidth <= 768) {
        if (toggleSidebar) {
            toggleSidebar.addEventListener('click', function() {
                sidebar.classList.toggle('show');
            });
        }
    }
    
    // Close sidebar on outside click (mobile)
    document.addEventListener('click', function(event) {
        const isClickInsideSidebar = sidebar.contains(event.target);
        const isClickOnToggle = toggleSidebar && toggleSidebar.contains(event.target);
        
        if (!isClickInsideSidebar && !isClickOnToggle && window.innerWidth <= 768) {
            sidebar.classList.remove('show');
        }
    });
});

// Handle form submissions with AJAX
$(document).ready(function() {
    // Handle delete confirmations
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        
        if (!confirm('¿Está seguro de que desea eliminar este registro?')) {
            return;
        }
        
        const form = $(this).closest('form');
        const url = form.attr('action');
        const method = form.find('input[name="_method"]').val() || 'DELETE';
        
        $.ajax({
            url: url,
            type: method,
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                alert(response.message || 'Registro eliminado correctamente');
                location.reload();
            },
            error: function(xhr) {
                alert('Error al eliminar el registro');
                console.error(xhr);
            }
        });
    });
    
    // Handle form submissions
    $(document).on('submit', '.ajax-form', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const url = form.attr('action');
        const method = form.find('input[name="_method"]').val() || form.attr('method') || 'POST';
        
        $.ajax({
            url: url,
            type: method,
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                alert('Operación exitosa');
                window.location.href = response.redirect || window.location.href;
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    // Validation errors
                    const errors = xhr.responseJSON.errors;
                    let errorMessage = 'Por favor corrija los siguientes errores:\n\n';
                    
                    for (let field in errors) {
                        errorMessage += errors[field][0] + '\n';
                    }
                    
                    alert(errorMessage);
                } else {
                    alert('Error al procesar la solicitud');
                    console.error(xhr);
                }
            }
        });
    });
    
    // Auto-hide alerts
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
});

// Utility functions
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('es-ES', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    });
}

function formatDateTime(dateString) {
    const date = new Date(dateString);
    return date.toLocaleString('es-ES', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit'
    });
}

