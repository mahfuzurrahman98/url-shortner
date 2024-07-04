<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
        <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">
                URL Shortener
            </h2>
            <form @submit.prevent="onSubmit">
                <div class="mb-4">
                    <label for="originalUrl" class="block text-lg text-gray-800 font-semibold mb-2">
                        Original URL
                    </label>
                    <textarea
                        v-model="formData.originalUrl"
                        name="originalUrl"
                        id="originalUrl"
                        cols="30"
                        rows="3"
                        :class="{
                            'w-full p-2 bg-gray-100 text-gray-800 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-gray-500':
                                !validationErrors.originalUrl,
                            'w-full p-2 bg-red-100 text-gray-800 border border-red-500 rounded focus:outline-none focus:ring-2 focus:ring-red-500':
                                validationErrors.originalUrl,
                        }"
                        :disabled="btnLoading"
                        placeholder="https://example.com/"
                    ></textarea>
                    <p
                        v-if="validationErrors.originalUrl"
                        class="text-red-500 text-sm"
                    >
                        {{ validationErrors.originalUrl }}
                    </p>
                </div>
                <button
                    type="submit"
                    :disabled="btnLoading"
                    :class="btnLoading ? 'bg-gray-400' : 'bg-black'"
                    class="w-full py-2 px-4 text-white text-lg font-semibold rounded hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 disabled:opacity-50"
                >
                    {{ btnLoading ? 'Loading...' : 'Submit' }}
                </button>
            </form>

            <div v-if="shortUrlResponse">
                <p v-if="shortUrlResponse.success" class="mt-4 text-green-600">
                    Short URL generated:
                    <span class="text-gray-800">{{
                        shortUrlResponse.data.shortUrl
                    }}</span>
                    <button
                        @click="copyShortUrl"
                        class="ml-2 px-3 py-1 bg-gray-300 text-gray-800 font-semibold rounded hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500"
                    >
                        Copy
                    </button>
                </p>
                <p v-else class="mt-4 text-red-600">
                    Error: {{ shortUrlResponse.message }}
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { reactive, ref, watch } from 'vue';
    import axios from '../api/axios';

    const formData = reactive({
        originalUrl: '',
    });

    const btnLoading = ref(false);

    const validationErrors = reactive({
        originalUrl: null,
    });

    const shortUrlResponse = ref(null);

    // as soon as the originalUrl changes, clear the error
    watch(formData, () => {
        if (formData.originalUrl) {
            validationErrors.originalUrl = null;
        }
    });

    const onSubmit = async () => {
        if (!formData.originalUrl) {
            validationErrors.originalUrl = 'Original URL is required';
            return;
        }

        try {
            btnLoading.value = true;
            const response = await axios.post('/shortens', {
                originalUrl: formData.originalUrl,
            });

            if (response.data.success) shortUrlResponse.value = response.data;
        } catch (error) {
            shortUrlResponse.value = error.response.data;
        } finally {
            btnLoading.value = false;
        }
    };

    const copyShortUrl = () => {
        navigator.clipboard.writeText(shortUrlResponse.value.data.shortUrl);
    };
</script>
