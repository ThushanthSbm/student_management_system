<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";

const props = defineProps({
    students: Array,
});

function updateStatus(student) {
    if (
        confirm(
            `Are you sure you want to change the status of ${student.name}?`
        )
    ) {
        const url = route("students.status", { student: student.id });
        router.put(url);
    }
}
</script>

<template>
    <Head title="Students" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Students
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-end m-2 p-2">
                    <Link
                        href="/students/create"
                        class="px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded"
                    >Create</Link>
                </div>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">Student Name</th>
                                <th scope="col" class="px-6 py-3">Age</th>
                                <th scope="col" class="px-6 py-3">Grade</th>
                                <th scope="col" class="px-6 py-3">Subjects</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="student in students"
                                :key="student.id"
                                class="bg-white border-b hover:bg-gray-50"
                            >
                                <th
                                    scope="row"
                                    class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap"
                                >
                                    <img
                                        class="w-10 h-10 rounded-full"
                                        :src="student.image"
                                        alt="Student image"
                                    />
                                    <div class="ps-3">
                                        <div class="text-base font-semibold">
                                            {{ student.name }}
                                        </div>
                                    </div>
                                </th>
                                <td class="px-6 py-4">
                                    {{ student.age }} years
                                </td>
                                <td class="px-6 py-4">
                                    {{ student.grade }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ student.subjects.join(', ') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div
                                        v-if="student.status"
                                        class="flex items-center"
                                    >
                                        <div
                                            class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"
                                        ></div>
                                        Active
                                    </div>
                                    <div
                                        v-if="!student.status"
                                        class="flex items-center"
                                    >
                                        <div
                                            class="h-2.5 w-2.5 rounded-full bg-red-500 me-2"
                                        ></div>
                                        Inactive
                                    </div>
                                </td>
                                <td class="">
                                    <div class="flex items-center">
                                        <Link
                                            :href="`/students/${student.id}/edit`"
                                            class="bg-blue-500 hover:bg-blue-700 mr-2 text-white py-2 px-4 rounded font-medium"
                                        >Edit</Link>
                                        <button
                                            @click="updateStatus(student)"
                                            class="bg-green-500 hover:bg-green-700 mr-2 text-white py-2 px-4 rounded font-medium"
                                        >
                                            Status
                                        </button>

                                        <Link
                                            :href="`/students/${student.id}`"
                                            method="delete"
                                            as="button"
                                            type="button"
                                            class="bg-red-500 hover:bg-red-700 mr-2 text-white py-2 px-4 rounded font-medium"
                                        >Delete</Link>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
