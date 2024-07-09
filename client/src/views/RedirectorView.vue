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

    const errorMessage = ref(null);

    const getUrl = async (folder, hash) => {
        try {
            if (folder) {
                const response = await axios.get(`/shortens/${folder}/${hash}`);
                if (response.data.success) {
                    window.location.href = response.data.data.originalUrl;
                }
            } else {
                const response = await axios.get(`/shortens/${hash}`);
                if (response.data.success) {
                    window.location.href = response.data.data.originalUrl;
                }
            }
        } catch (error) {
            // console.error(error);
            console.log(error.response.data.message);
            errorMessage.value = error.response.data.message;
        }
    };

    const isFolderValid = (folder) => {
        // if anything rather than a-z, 0-9, - or _ then return false
        if (!folder.match(/^[a-zA-Z0-9_-]+$/)) {
            return false;
        }
        return folder.length > 0 && folder.length <= 50;
    };

    const isHashValid = (hash) => {
        // if anything rather than a-z, 0-9 return false
        if (!hash.match(/^[a-zA-Z0-9]+$/)) {
            return false;
        }
        return hash.length === 6;
    };

    // Use onMounted hook to call getUrl when the component is mounted
    onMounted(() => {
        const route = useRoute();
        const folder = route.params.folder;
        const hash = route.params.hash;

        if (folder) {
            console.log('yes, have folder');
            if (!isFolderValid(folder)) {
                console.log('Invalid folder name');
                errorMessage.value = 'Invalid folder name';
                return;
            } else {
                console.log('folder is valid');
            }
        }

        if (!isHashValid(hash)) {
            errorMessage.value = 'Invalid hash';
            return;
        }

        getUrl(folder, hash);
    });
</script>
