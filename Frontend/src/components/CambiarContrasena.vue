<script setup>
import { ref, reactive } from 'vue';
import api from '@/services/api.js'; // Tu instancia de axios sin interceptores
import { useRouter } from 'vue-router';

const router = useRouter();

// Estado del formulario
const form = reactive({
  current_password: '',
  new_password: '',
  new_password_confirmation: ''
});

// Mensajes de feedback
const mensaje = ref('');
const error = ref('');
const loading = ref(false);

const cambiarContrasena = async () => {
  // Limpiamos mensajes previos
  mensaje.value = '';
  error.value = '';
  loading.value = true;

  // 1. Validación básica en frontend
  if (form.new_password !== form.new_password_confirmation) {
    error.value = "Las contraseñas nuevas no coinciden.";
    loading.value = false;
    return;
  }

  if (form.new_password.length < 8) {
    error.value = "La nueva contraseña debe tener al menos 8 caracteres.";
    loading.value = false;
    return;
  }

  // 2. Recuperar token manualmente
  const token = localStorage.getItem('token');
  if (!token) {
    error.value = "No estás autenticado. Por favor, inicia sesión.";
    loading.value = false;
    return;
  }

  try {
    // 3. Petición al Backend pasando el Token manualmente
    const response = await api.post('/api/change-password', form, {
      headers: {
        Authorization: `Bearer ${token}` // <--- AQUÍ PASAMOS EL TOKEN
      }
    });

    // Éxito
    mensaje.value = "Contraseña actualizada correctamente.";
    
    // Limpiar formulario
    form.current_password = '';
    form.new_password = '';
    form.new_password_confirmation = '';

    // Opcional: Redirigir al home después de unos segundos
    setTimeout(() => {
       // router.push('/home'); 
    }, 2000);

  } catch (err) {
    console.error(err);
    // Manejo de errores que vienen de Laravel
    if (err.response && err.response.data) {
        if (err.response.data.errors) {
            // Si hay errores de validación (ej: password actual incorrecto)
            const firstError = Object.values(err.response.data.errors)[0][0];
            error.value = firstError;
        } else if (err.response.data.message) {
            error.value = err.response.data.message;
        }
    } else {
        error.value = "Ocurrió un error al conectar con el servidor.";
    }
  } finally {
    loading.value = false;
  }
};
</script>

<template>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm border-0">
          <div class="card-header bg-indigo text-white py-3">
            <h5 class="mb-0"><i class="bi bi-shield-lock me-2"></i> Cambiar Contraseña</h5>
          </div>
          <div class="card-body p-4">
            
            <div v-if="error" class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div>{{ error }}</div>
            </div>
            <div v-if="mensaje" class="alert alert-success d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <div>{{ mensaje }}</div>
            </div>

            <form @submit.prevent="cambiarContrasena">
              <div class="mb-3">
                <label for="current_pass" class="form-label text-secondary fw-bold">Contraseña Actual</label>
                <input 
                  type="password" 
                  id="current_pass" 
                  class="form-control" 
                  v-model="form.current_password" 
                  required
                  placeholder="Escribe tu contraseña actual"
                >
              </div>

              <div class="mb-3">
                <label for="new_pass" class="form-label text-secondary fw-bold">Nueva Contraseña</label>
                <input 
                  type="password" 
                  id="new_pass" 
                  class="form-control" 
                  v-model="form.new_password" 
                  required
                  minlength="8"
                  placeholder="Mínimo 8 caracteres"
                >
              </div>

              <div class="mb-4">
                <label for="confirm_pass" class="form-label text-secondary fw-bold">Confirmar Nueva Contraseña</label>
                <input 
                  type="password" 
                  id="confirm_pass" 
                  class="form-control" 
                  v-model="form.new_password_confirmation" 
                  required
                  placeholder="Repite la nueva contraseña"
                >
              </div>

              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-indigo text-white" :disabled="loading">
                  <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
                  {{ loading ? 'Actualizando...' : 'Actualizar Contraseña' }}
                </button>
                <RouterLink to="/home" class="btn btn-outline-secondary">
                    Cancelar
                </RouterLink>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>