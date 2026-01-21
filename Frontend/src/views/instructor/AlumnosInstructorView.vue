<script setup>
    import { useRoute } from "vue-router";
    import AlumnosList from "../../components/AlumnosList.vue";
  import Navbar from "@/components/Navbar.vue";


const route = useRoute();
const instructorId = route.params.id;
</script>
<template>
    <Navbar />

    <AlumnosList
    :endpoint="`http://127.0.0.1:8000/api/instructores/${instructorId}/alumnos`"
    title="Tus alumnos"
  />

</template>
