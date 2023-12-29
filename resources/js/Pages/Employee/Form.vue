<script setup>
import { ref, onMounted } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Swal from "sweetalert2";

const props = defineProps({
    status: {
        type: String,
        required: true,
    },
    employeeID: {
        type: Number,
    },
});

const employee = ref({
    first_name: "",
    last_name: "",
    position: "",
});

const submitForm = async (e) => {
    const formData = new FormData(e.target);
    let url = "/api/employee/create";

    if (props.status === "edit") {
        formData.append("_method", "PUT");
        url = `/api/employee/${props.employeeID}/update`;
    }

    await axios
        .post(url, formData)
        .then(async (response) => {
            if (
                (response.status === 201 || response.status === 200) &&
                response.data.status
            ) {
                Swal.fire({
                    title: "Success",
                    text: response.data.message,
                    icon: "success",
                }).then(() => {
                    formReset();
                    window.location = route("employee.list");
                });
            }
        })
        .catch((err) => console.error(err));
};

const formReset = () => {
    employee.value = {
        first_name: "",
        last_name: "",
        position: "",
    };
};

onMounted(async () => {
    if (props.status === "edit") {
        editEmployee(props.employeeID);
    }
});

const editEmployee = async (ID) => {
    await axios
        .get(`/api/employee/${ID}`)
        .then((response) => {
            if (response.status === 200 && response.data.status) {
                employee.value = response.data.data;
                employee.value.position = response.data.data.position
                    ? response.data.data.position
                    : "";
            }
        })
        .catch((err) => console.error(err));
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                :: Form Page ::
                            </h2>
                        </header>

                        <form
                            @submit.prevent="submitForm"
                            class="mt-6 space-y-6"
                        >
                            <div class="mb-5">
                                <label
                                    for="first_name"
                                    class="block mb-2 text-xs font-medium text-gray-900"
                                    >First Name</label
                                >
                                <input
                                    type="text"
                                    id="first_name"
                                    name="first_name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="Enter First Name"
                                    required
                                    v-model="employee.first_name"
                                />
                            </div>
                            <div class="mb-5">
                                <label
                                    for="last_name"
                                    class="block mb-2 text-xs font-medium text-gray-900"
                                    >Last Name</label
                                >
                                <input
                                    type="text"
                                    id="last_name"
                                    name="last_name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="Enter Last Name"
                                    required
                                    v-model="employee.last_name"
                                />
                            </div>
                            <div
                                class="mb-5"
                                v-if="$page.props.auth.user.role === 'Manager'"
                            >
                                <label
                                    for="position"
                                    class="block mb-2 text-xs font-medium text-gray-900"
                                    >Position</label
                                >
                                <select
                                    id="position"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    v-model="employee.position"
                                    name="position"
                                >
                                    <option value="" selected>
                                        -- Select Position --
                                    </option>
                                    <option value="Manager">Manager</option>
                                    <option value="Web Designer">
                                        Web Designer
                                    </option>
                                    <option value="Web Developer">
                                        Web Developer
                                    </option>
                                </select>
                            </div>
                            <div class="flex items-center justify-end mt-4">
                                <button
                                    type="submit"
                                    class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2"
                                >
                                    Save
                                </button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
