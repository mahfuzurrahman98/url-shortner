<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
        <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-gray-800">
                URL Shortener Redirect {{ !errorMessage ? '...' : '' }}
            </h2>
            <div v-if="errorMessage" class="mt-4">
                <p>
                    <span class="text-red-600">
                        {{ errorMessage }}
                    </span>
                    <span class="ml-1">
                        <RouterLink class="text-blue-700 underline" to="/">
                            Go Home
                        </RouterLink>
                    </span>
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { useRoute, RouterLink } from 'vue-router';
    import axios from '../api/axios';
    import { onMounted, ref } from 'vue';

    const route = useRoute();
    const hash = route.params.hash;
    const errorMessage = ref(null);

    const getUrl = async () => {
        try {
            const response = await axios.get(`/shortens/${hash}`);
            if (response.data.success) {
                window.location.href = response.data.data.originalUrl;
            }
        } catch (error) {
            // console.error(error);
            console.log(error.response.data.message);
            errorMessage.value = error.response.data.message;
        }
    };

    // Use onMounted hook to call getUrl when the component is mounted
    onMounted(() => {
        getUrl();
    });
</script>
