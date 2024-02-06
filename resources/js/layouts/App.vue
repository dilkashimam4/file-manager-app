<template>
    <div class="p-2 w-full" style="width: 100%;">
        <div @click="$router.go(-1)" class="pt-1" style="width: 40px; height: 40px; float: left; cursor: pointer;">
            <i class="fa-solid fa-chevron-left"></i>
        </div>
        <div class="pt-1" style="width: calc(100% - 80px); height: 40px; float:left; ">
            <p class="text-center mt-1 font-semibold">
                {{ currentTitlePage }}
            </p>
        </div>
        <div class="pt-1 text-center" style="width: 40px; height: 40px; float: right; cursor: pointer;font: 130%;"
            v-if="isFolderPage">
            <i class="fa-solid fa-magnifying-glass"></i>

        </div>


        <div class="pt-1 text-center" style="width: 40px; height: 40px; float: right; cursor: pointer;font: 130%;"
            v-if="!isFolderPage">
            <router-link :to="{ name: 'EditFolder' }">
                <i class="fa-solid fa-gear"></i>
            </router-link>
        </div>

        <div style="clear: both;"></div>
    </div>
    <router-view></router-view>
</template>
<script>
export default {
    data() {
        return {

        }
    },
    computed: {
        currentTitlePage() {
            return this.$route?.meta?.title || '';
        },
        isFolderPage() {
            return this.$route?.meta?.title == "File List" ? false : true;
        }
    }
}
</script>