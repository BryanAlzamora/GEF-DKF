<template>
  <div>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Email</th>
          <th>Tipo</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.id }}</td>
          <td>{{ user.nombre }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.tipo }}</td>
        </tr>
      </tbody>
    </table>

    <!-- Paginación Bootstrap -->
    <nav>
      <ul class="pagination">
        <li class="page-item" :class="{ disabled: currentPage === 1 }">
          <button class="page-link" @click="fetchUsers(currentPage - 1)">Anterior</button>
        </li>

        <li
          class="page-item"
          v-for="page in totalPages"
          :key="page"
          :class="{ active: currentPage === page }"
        >
          <button class="page-link" @click="fetchUsers(page)">{{ page }}</button>
        </li>

        <li class="page-item" :class="{ disabled: currentPage === totalPages }">
          <button class="page-link" @click="fetchUsers(currentPage + 1)">Siguiente</button>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

// Estado reactivo
const users = ref([]);
const currentPage = ref(1);
const totalPages = ref(1);
const perPage = ref(5);

// Función para obtener usuarios
async function fetchUsers(page = 1) {
  currentPage.value = page;
  try {
    const response = await axios.get("http://127.0.0.1:8000/api/users", {
      params: {
        page: currentPage.value,
        per_page: perPage.value,
      },
    });

    users.value = response.data.data.data ||[];
    totalPages.value = response.data.last_page;
  } catch (error) {
    console.error(error);
  }
}

// Cargar primera página al montar
onMounted(() => {
  fetchUsers(1);
});
</script>

<style scoped>
.pagination {
  justify-content: center;
}
</style>
