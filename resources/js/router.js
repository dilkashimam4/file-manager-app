// import { create } from "lodash";
import { createWebHistory, createRouter } from "vue-router";
import home from './pages/Home.vue';
import FolderCreate from './pages/folder/Create.vue';
import folderEdit from './pages/folder/Edit.vue';
import fileList from './pages/folder/FileList.vue';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: home,
        meta: { title: 'File Manager' }

    },
    {
        path: '/folder/create',
        name: 'FolderCreate',
        component: FolderCreate,
        meta: { title: 'Folder Create' }

    },
    {
        path: '/folders/:id',
        name: 'FileList',
        component: fileList,
        meta: { title: 'File List' }

    },
    {
        path: '/folders/edit/:id',
        name: 'EditFolder',
        component: folderEdit,
        meta: { title: 'Folders Edit' }
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;