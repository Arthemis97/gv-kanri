<script lang="ts" setup>
import useAuthStore from "./stores/auth";
import { theme } from 'ant-design-vue'
import defaultLayout from './layouts/default.vue'
import jpJP from 'ant-design-vue/es/locale/ja_JP';
import dayjs from 'dayjs';
import 'dayjs/locale/ja';
import useNationStore from "./stores/nation";
dayjs.locale('ja');
const authStore = useAuthStore()
const nationStore = useNationStore()
const router = useRouter()
const route = useRoute()
useEvent.on('logout', () => {
    authStore.logout();
    router.push('/login')
})

onMounted(async () => {
    // console.log(route.meta.layout)
    await nationStore.fetchList();
    await nationStore.fetchPrefecture();
    await nationStore.fetchWorkplace();
})
</script>

<template>
    <a-config-provider :locale="jpJP" :theme="{
        algorithm: theme.compactAlgorithm,
        token: {},
    }">
        <defaultLayout v-if="route.meta.layout == 'defaultLayout'">
            <router-view />
        </defaultLayout>
        <template v-else>
            <router-view />
        </template>
    </a-config-provider>
</template>
