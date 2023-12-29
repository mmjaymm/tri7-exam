<script setup>
import { ref, onMounted } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import Swal from "sweetalert2";
let employees = ref([]);

onMounted(async () => {
    getEmployees();
});

const getEmployees = async () => {
    let response = await axios.get("/api/employee/get-all");
    employees.value = response.data.data.data;
};

const editEmployee = async (ID) => {
    router.get("/employee/edit/" + ID);
};

const deleteEmployee = async (ID) => {
    Swal.fire({
        title: "Are you sure you want to delete this employee?",
        showCancelButton: true,
        confirmButtonText: "Yes",
    }).then(async (result) => {
        if (result.isConfirmed) {
            await axios
                .delete(`/api/employee/${ID}`)
                .then((response) => {
                    if (response.status === 200 && response.data.status) {
                        employees.value = employees.value.filter(
                            (employee) => employee.id != ID
                        );
                        Swal.fire("Deleted!", response.data.message, "success");
                    }
                })
                .catch((err) => console.error(err));
        }
    });
};
</script>

<template>
    <Head title="Employee List" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="relative overflow-x-auto">
                        <table
                            class="w-full text-sm text-left rtl:text-right text-gray-500"
                        >
                            <thead
                                class="text-lg text-gray-700 capitalize bg-gray-50"
                            >
                                <tr>
                                    <th scope="col" class="px-6 py-3">#</th>
                                    <th scope="col" class="px-6 py-3">
                                        First Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Last Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Position
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Created At
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <Link :href="route('employee.create')">
                                            <button
                                                type="button"
                                                class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2"
                                            >
                                                Add
                                            </button>
                                        </Link>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-if="employees.length > 0"
                                    v-for="employee in employees"
                                    :key="employee.id"
                                    class="bg-white border-b"
                                >
                                    <td class="px-6 py-4">{{ employee.id }}</td>
                                    <td class="px-6 py-4">
                                        {{ employee.first_name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ employee.last_name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ employee.position }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ employee.created_at }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <button
                                            @click="editEmployee(employee.id)"
                                            type="button"
                                            class="focus:outline-none text-white bg-yellow-300 hover:bg-yellow-400 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2"
                                        >
                                            Edit
                                        </button>
                                        <button
                                            @click="deleteEmployee(employee.id)"
                                            type="button"
                                            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2"
                                        >
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                <tr v-else class="bg-white border-b">
                                    <td class="text-center p-6" colspan="6">
                                        No Record Found !
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
