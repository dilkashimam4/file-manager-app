<template>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-8 gap-4 p-2" style="">
        <div class="folder-icon pt-1 text-center folders" style="" v-for="folder in folders" :key="folder.id">
            <!-- <img src="/images/icon/download (1).jpg" alt=""> -->
            <router-link :to="{ name: 'FileList', params: { id: folder.id } }">
                <i class="icon fa-solid fa-folder-closed" style="color: #250094;"></i>
                <p class="text-center mt-1" style="font-size: 85%; font-weight: 600;">{{ folder.name }}</p>
            </router-link>
        </div>
    </div>

    <div class="px-1 mt-4">
        <p class="px-2 mb-2" style="font-size: 95%; font-weight: 500;"> Recent uploads</p>
        <div class="file-item mt-0  mt-2 list" style="display: flex;" v-for="file in files">
            <div class="image-item pt-2 px-2 " style="width: 52px; height: 67px;">
                <!-- <i class="pt-2 mt-5 fa-solid fa-file-image fa-2xl" style="color: #190038;"></i> -->
                <img :src="`/images/icon/${file.type}.png`" alt="" style="object-fit: contain;">

            </div>
            <div class="pt-2 px-2" style="width: calc(100% - 80px);">
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

    <div class="text-center" @click="createFolder"
        style="width: 50px;height: 50px; background: #1d4ed8; position: fixed; border-radius: 50px; right: 10px; top: 87vh;">
        <i class="fa-regular fa-folder-open" style="font-size: 140%; line-height: 48px; color: white; cursor: pointer;"></i>
    </div>

    <!-- <router-link :to="{ name: 'FolderCreate' }">
        <div class="text-center"
            style="width: 50px;height: 50px; background: #1d4ed8; position: fixed; border-radius: 50px; right: 10px; top: 87vh;">
            <i class="fa-regular fa-folder-open"
                style="font-size: 140%; line-height: 48px; color: white; cursor: pointer;"></i>
        </div>
    </router-link> -->
</template>
<script>
export default {
    data() {
        return {
            folders: [],
            files: [],
            formData: {
                name: ''
            }
        }
    }, created: function () {
        this.getData();
    }, methods: {
        async getData() {
            try {
                const { data } = await axios.get('api/home/get-data');
                console.log(data);
                this.folders = data.folders;
                this.files = data.files;
            } catch (error) {
                console.log('error is ', error);
            }
        },
        createFolder() {
            Swal.fire({
                title: "Create Folder",
                input: "text",
                inputLabel: "Folder Name",
                inputValue: this.formData.name,
                showCancelButton: true,
                inputValidator: async (value) => {
                    if (!value) {
                        return "You need to write something!";
                    } else {
                        try {
                            const { data } = await axios.post('/api/folder/create', { name: value });
                            if (data) {
                                this.getData();
                            }
                        } catch (error) {
                            console.error('Error creating folder:', error);
                            Swal.fire(error?.response?.data?.message || 'Error creating folder', '', 'error');
                        }
                    }
                }
            });
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
                    this.getData();
                }
            } catch (error) {
                console.log(error);
            }
        }

    }
}

</script>

<style>
.icon {
    text-align: center;
}

.icon::before {
    font-size: 60px;
    cursor: pointer;
    filter: drop-shadow(0px 6px 3px #777575);
}

.fa-file-image {
    text-align: center;
    font-size: 60px;
}

.fa-file-image::before {
    font-size: 60px;

}

.list {
    background: #f7f4f4;
}
</style>