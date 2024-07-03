<template>
    <h1>{{ hash }}</h1>
</template>

<script setup>
    import { useRoute } from 'vue-router';
    const route = useRoute();

    const hash = route.params.hash;
</script>
