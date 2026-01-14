<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useUserStore } from '@/stores/userStore';

const estancia = ref(null);
const userStore = useUserStore();
const alumnoId = userStore.user.id;

async function fetchEstancia() {
  try {
    const response = await axios.get(`http://localhost:8000/api/alumno/${alumnoId}/estancia`);
    estancia.value = response.data;
    console.log(estancia.value);
  } catch (error) {
    console.error(error);
  }
}

onMounted(() => {
  fetchEstancia();
});
</script>


<template>
  <div v-if="estancia">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Empresa</th>
          <th>Instructor</th>
          <th>Tutor</th>
          <th>Fecha inicio</th>
          <th>Fecha fin</th>
          <th>Horario</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{ estancia.empresa?.Nombre }}</td>

          <td>
            {{ estancia.alumno?.instructor?.user?.nombre }}
            {{ estancia.alumno?.instructor?.user?.apellidos }}
          </td>

          <td>
            {{ estancia.alumno?.tutor?.user?.nombre }}
            {{ estancia.alumno?.tutor?.user?.apellidos }}
          </td>

          <td>{{ estancia.Fecha_inicio }}</td>
          <td>{{ estancia.Fecha_fin ?? '—' }}</td>

          <td>
            <div class="d-flex flex-column gap-2">
              <div v-for="h in estancia.horario" :key="h.id" class="border rounded p-2">
                <div class="fw-bold text-primary">
                  {{ h.Dias }}
                </div>
                <div>
                  <span class="badge bg-success me-1">{{ h.Horario1 }}</span>
                  <span v-if="h.Horario2" class="badge bg-success">
                    {{ h.Horario2 }}
                  </span>
                </div>
              </div>
            </div>
          </td>

        </tr>
      </tbody>
    </table>
  </div>

  <div v-else>
    No hay estancia registrada.
  </div>
</template>
