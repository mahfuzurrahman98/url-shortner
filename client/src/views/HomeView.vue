<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
        <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">URL Shortener</h2>
            <form @submit.prevent="onSubmit">
                <div class="mb-4">
                    <label
                        for="originalUrl"
                        class="block text-lg text-gray-800 font-semibold mb-2"
                    >
                        Original URL
                    </label>
                    <textarea
                        v-model="formData.originalUrl"
                        name="originalUrl"
                        id="originalUrl"
                        cols="30"
                        rows="3"
                        :class="{
                            'w-full p-2 bg-gray-50 text-gray-800 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-gray-500':
                                !validationErrors.originalUrl,
                            'w-full p-2 bg-red-100 text-gray-800 border border-red-500 rounded focus:outline-none focus:ring-2 focus:ring-red-500':
                                validationErrors.originalUrl,
                        }"
                        :disabled="btnLoading || disableInput"
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
                    v-if="!disableInput"
                    type="submit"
                    :disabled="btnLoading"
                    :class="btnLoading ? 'bg-gray-400' : 'bg-black'"
                    class="w-full py-2 px-4 text-white text-lg font-semibold rounded hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 disabled:opacity-50"
                >
                    {{ btnLoading ? 'Loading...' : 'Submit' }}
                </button>
            </form>

            <div v-if="apiResponse">
                <p v-if="apiResponse.success" class="mt-4">
                    <span class="text-green-700 font-semibold mr-1">
                        Short URL:
                    </span>
                    <span class="text-gray-800 mr-2">
                        {{ shortUrl }}
                    </span>
                    <button
                        @click="copyShortUrl"
                        :class="{
                            'px-2 py-0.5 text-sm font-semibold rounded focus:outline-none focus:ring-2 focus:ring-gray-500': true,
                            'bg-gray-300 text-gray-800 hover:bg-gray-400':
                                !copied,
                            'bg-green-600 text-white hover:bg-green-500':
                                copied,
                        }"
                    >
                        {{ copied ? 'Copied!' : 'Copy' }}
                    </button>
                </p>
                <p v-else class="mt-4 text-red-600">
                    {{ apiResponse.message }}
                </p>
                <button
                    @click="createNew"
                    class="mt-4 px-2 py-1 rounded bg-gray-300 text-gray-800 hover:bg-gray-400"
                >
                    Create new
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { reactive, ref, watch, computed } from 'vue';
    import axios from '../api/axios';

    const formData = reactive({
        originalUrl: '',
    });

    const btnLoading = ref(false);
    const disableInput = ref(false);

    const copied = ref(false);

    const validationErrors = reactive({
        originalUrl: null,
    });

    const apiResponse = ref(null);

    // as soon as the originalUrl changes, clear the error
    watch(formData, () => {
        if (formData.originalUrl) {
            validationErrors.originalUrl = null;
        }
    });

    const onSubmit = async () => {
        apiResponse.value = null;
        validationErrors.originalUrl = null;

        if (!formData.originalUrl) {
            validationErrors.originalUrl = 'Original URL is required';
            return;
        }

        try {
            btnLoading.value = true;
            const response = await axios.post('/shortens', {
                originalUrl: formData.originalUrl,
            });

            if (response.data.success) {
                apiResponse.value = response.data;
                disableInput.value = true;
            }
        } catch (error) {
            apiResponse.value = error.response.data;
        } finally {
            btnLoading.value = false;
        }
    };

    const copyShortUrl = () => {
        navigator.clipboard.writeText(shortUrl.value);
        copied.value = true;

        setTimeout(() => {
            copied.value = false;
        }, 3000);
    };

    const shortUrl = computed(() => {
        if (apiResponse.value) {
            let curDomain = window.location.origin;
            return curDomain + '/' + apiResponse.value.data.hash;
        }

        return null;
    });

    const createNew = () => {
        apiResponse.value = null;
        formData.originalUrl = '';
        disableInput.value = false;
        btnLoading.value = false;
        validationErrors.originalUrl = null;
    };
</script>
