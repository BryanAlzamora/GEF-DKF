<script setup>
    import Navbar from '@/components/Navbar.vue';
    import EmpresasList from '@/components/Empresa/EmpresasList.vue';
    import { defineAsyncComponent, ref } from 'vue';
    const EmpresaDatos = defineAsyncComponent(() => import('@/components/Empresa/EmpresaDatos.vue'))

    const empresaSeleccionada = ref(null)
</script>

<template>
    <Navbar></Navbar>
    <div class="container-fluid">
        <div class="row">
            <EmpresasList @seleccionarEmpresa="empresaSeleccionada = $event"></EmpresasList>
            <EmpresaDatos :empresa="empresaSeleccionada"></EmpresaDatos>
        </div>
    </div>
</template>


<style scoped>

</style>
