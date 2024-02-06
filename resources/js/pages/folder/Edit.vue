<template>
    <div class="p-3">
        <div class="mb-6">
            <label for="large-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Folder Name
            </label>
            <input type="text" id="large-input" v-model="formData.name"
                class="block w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            <button type="button" @click="editFolder"
                class="mt-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                Update
            </button>
            <button type="button" @click="deleteFolder(id)"
                class="mt-2 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                Delete
            </button>

        </div>
    </div>
</template>
  
<script>
import Swal from 'sweetalert2'
export default {
    data() {
        return {
            formData: {
                name: '',
            },
            id: null
        };
    },
    created() {
        this.getFolderName(this.$route.params.id);
    },
    methods: {
        async getFolderName(id) {
            try {
                const { data } = await axios.get(`/api/folder/edit/${id}`);

                this.formData.name = data.name;
                this.id = data.id;
            } catch (error) {
                console.log('Error fetching folder name:', error);
            }
        },
        async editFolder() {
            Swal.fire({
                title: "Do you want to save the changes?",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Save",
                denyButtonText: `Don't save`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Swal.fire("Saved!", "", "success");
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
            });
            try {
                const { data } = await axios.post('/api/folder/update/' + this.$route.params.id, this.formData);

                console.log('Folder updated:', data);
                if (data) {
                    this.$router.go(-1)
                }
            } catch (error) {
                console.log('Error updating folder:', error);
                Swal.fire(error?.response?.data?.message || 'Error updating folder', '', 'error');

            }
        },
        deleteFolder(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    try {
                        const { data } = axios.get('/api/folder/delete/' + this.$route.params.id);
                        if (!data) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success"
                            });
                            this.$router.push({ name: 'Home' });
                        }
                    } catch (error) {
                        console.log('Error updating folder:', error);
                        Swal.fire(error?.response?.data?.message || 'Error updating folder', '', 'error');
                    }

                }
            });


        },
    },
};
</script> 
  
<!-- <script>
import Swal from 'sweetalert2';

export default {
    data() {
        return {
            formData: {
                name: '',
            },
        };
    },
    created() {
        this.getFolderName(this.$route.params.id);
    },
    methods: {
        async getFolderName() {
            try {
                const { data } = await axios.get(`/api/folder/edit/${id}`);
                this.formData.name = data.name;
                console.log(this.formData.name);
            } catch (error) {
                console.log('Error fetching folder name:', error);
            }
        },
        async editFolder() {
            Swal.fire({
                title: "Do you want to save the changes?",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Save",
                denyButtonText: `Don't save`
            }).then(async (result) => {
                if (result.isConfirmed) {
                    Swal.fire("Saved!", "", "success");
                    try {
                        const { data } = await axios.post('/api/folder/edit/' + this.$route.params.id, this.formData);
                        // console.log('Folder updated:', data);
                        if (data) {
                            this.$router.go(-1);
                        }
                    } catch (error) {
                        console.log('Error updating folder:', error);
                        Swal.fire(error?.response?.data?.message || 'Error updating folder', '', 'error');
                    }
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
            });
        },
        async deleteFolder() {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const { data } = await axios.delete('/api/folder/delete/' + this.$route.params.id);
                        if (data) {
                            // Handle successful deletion if needed
                        }
                    } catch (error) {
                        console.log('Error deleting folder:', error);
                        Swal.fire(error?.response?.data?.message || 'Error deleting folder', '', 'error');
                    }

                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });

                    this.$router.push({ name: 'Home' });
                }
            });
        },
    },
};
</script> -->