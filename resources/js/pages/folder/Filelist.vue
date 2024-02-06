<template>
    <div class="px-1 ">
        <p class="px-2 mb-2" style="font-size: 95%; font-weight: 500;"> Recent uploads</p>
        <div class="file-item mt-0  mt-2 list" style="display: flex;" v-for="file in files">
            <div class="image-item pt-2 px-2 " style="width: 52px; height: 67px;">
                <!-- <i class="pt-2 mt-5 fa-solid fa-file-image fa-2xl" style="color: #190038;"></i> -->
                <!-- <img :src="`/storage/uploads/${file.name}`" alt=""> -->
                <img :src="`/storage/uploads/${file.name}`" alt="" style="object-fit: contain;">


            </div>
            <div class=" pt-2 px-2" style="width: calc(100% - 80px);">
                <p class="mt-1" style="font-size: 90%; font-weight: 600;">{{ file.name }} </p>
                <p class="mt-1" style="font-size: 85%; font-weight: 500; opacity: 0.5;">{{ file.created_at }}</p>
            </div>
            <div class="pt-2" style="width: 20px; height: 67px;">
                <i class="fa-solid fa-cloud-arrow-down fa-lg cursor-pointer text-blue-600 mt-1"
                    @click="download(file.id, file.name)"></i>
                <i class="fa-solid fa-trash-can fa-lg cursor-pointer text-red-600 mt-1" @click="deleteFile(file.id)"
                    style="margin-left: 2px;"></i>
            </div>
        </div>
    </div>
    <input type="file" ref="uploadFile" @change="handleFileChange" style="display: none;">
    <div class="text-center" @click="createFolder"
        style="width: 50px;height: 50px; background: #1d4ed8; position: fixed; border-radius: 50px; right: 10px; top: 87vh;">
        <i class="fa-solid fa-cloud-arrow-up" @click="openDialog"
            style="font-size: 140%; line-height: 48px; color: white; cursor: pointer;"></i>
    </div>
</template>
<script>
import Swal from 'sweetalert2';

export default {
    data() {
        return {
            files: [],
            selectedFile: null
        }
    }, mounted: function () {
        this.getFiles();
    }, watch: {
        selectedFile() {
            this.uploadFile();
        }
    },
    methods: {
        async getFiles() {
            try {
                const { data } = await axios.get('/api/files/get-data/' + this.$route.params.id);
                this.files = data;
                console.log(data);
            } catch (error) {
                console.log("error is ", error);
            }
        }, handleFileChange(event) {
            this.selectedFile = event.target.files[0];
        }
        , openDialog() {
            const elm = this.$refs.uploadFile;
            elm.click();
        },
        async uploadFile() {
            const formData = new FormData();
            formData.append('file', this.selectedFile);
            try {
                const { data } = await axios.post('/api/files/upload/' + this.$route.params.id, formData);
                this.getFiles();
            } catch (error) {
                console.log(error);
                Swal.fire(error?.response?.data?.message);
            }
        },
        download(id, name) {
            axios.get('/api/files/download/' + id, { responseType: 'blob' })
                .then(response => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', name);
                    document.body.appendChild(link);
                    link.click();
                }).catch(error => {
                    console.log(error);
                });
        },
        async deleteFile(id) {
            try {
                const { data } = await axios.get('/api/file/delete/' + id);
                if (data) {
                    this.getFiles();
                }
            } catch (error) {
                console.log(error);
            }
        }
    }
}
</script>