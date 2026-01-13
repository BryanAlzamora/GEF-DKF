<script setup>
defineProps({
    empresa: Object
})
</script>

<template>
    <div class="card shadow-sm mt-3">
        <div class="card-header bg-primary text-white">
            Información de {{ empresa.Nombre }}
        </div>
        <div class="card-body">
            <p><strong>CIF:</strong> {{ empresa.CIF }}</p>
            <p><strong>Dirección:</strong> {{ empresa.Direccion }}</p>
            <p><strong>Email:</strong> {{ empresa.Email }}</p>
        </div>
    </div>
</template>
