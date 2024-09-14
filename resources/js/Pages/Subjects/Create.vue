<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const form = useForm({
    name: null,
    status: null,
});

function storeSubject() {
    form.post("/subjects", {
        onSuccess: () => {
            form.reset();
        },
    });
}
</script>

<template>
    <Head title="Subjects" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Subjects
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex m-2 p-2">
                    <Link
                        href="/subjects"
                        class="px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded"
                        >Back</Link
                    >
                </div>
                <div>
                    <!-- component -->
                    <div class="bg-grey-lighter min-h-screen flex flex-col">
                        <div
                            class="container max-w-xl mx-auto flex-1 flex flex-col items-center justify-center px-2"
                        >
                            <form
                                @submit.prevent="storeSubject"
                                class="bg-white px-6 py-8 rounded shadow-md text-black w-full"
                            >
                                <h1 class="mb-8 text-3xl text-center">
                                    Create a Subjects
                                </h1>

                                <label for="name">Subject Name</label>
                                <input
                                    type="text"
                                    v-model="form.name"
                                    class="block mt-2 border border-grey-light w-full p-3 rounded mb-4"
                                    name="name"
                                    placeholder="Subject Name"
                                />

                                <label for="status"> Status </label>

                                <div
                                    class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-2 py-4"
                                >
                                    <label>
                                        <input
                                            type="radio"
                                            v-model="form.status"
                                            value="1"
                                            class="peer hidden"
                                            name="status"
                                        />

                                        <div
                                            class="hover:bg-gray-50 flex items-center justify-between px-4 py-2 border-2 rounded-lg cursor-pointer text-sm border-gray-200 group peer-checked:border-blue-500"
                                        >
                                            <h2
                                                class="font-medium text-gray-700"
                                            >
                                                Active
                                            </h2>
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                                class="w-9 h-9 text-blue-600 invisible group-[.peer:checked+&]:visible"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                                />
                                            </svg>
                                        </div>
                                    </label>

                                    <label>
                                        <input
                                            type="radio"
                                            v-model="form.status"
                                            value="0"
                                            class="peer hidden"
                                            name="status"
                                        />

                                        <div
                                            class="hover:bg-gray-50 flex items-center justify-between px-4 py-2 border-2 rounded-lg cursor-pointer text-sm border-gray-200 group peer-checked:border-blue-500"
                                        >
                                            <h2
                                                class="font-medium text-gray-700"
                                            >
                                                Inactive
                                            </h2>
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                                class="w-9 h-9 text-blue-600 invisible group-[.peer:checked+&]:visible"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                                />
                                            </svg>
                                        </div>
                                    </label>
                                </div>

                                

                                <button
                                    type="submit"
                                    class="w-full text-center py-3 rounded bg-indigo-500 hover:bg-indigo-600 text-white focus:outline-none my-1"
                                >
                                    Create Subject
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
