<script setup lang="ts">
import useAuthStore from "../stores/auth"
import { Modal } from 'ant-design-vue';
import profile from "../components/profile.vue";
import dep from "../components/dep.vue";
import black from "../components/black.vue";
const authStore = useAuthStore()
const router = useRouter()
const { getUser } = storeToRefs(authStore)
const push = (path) => {
    router.push(path)
}
const logout = () => {
    Modal.confirm({
        title: 'Logging out?',
        onOk() {
            authStore.logout();
            router.push('/login')
        },
    })
}
</script>
<template>
    <a-layout style="min-height: 100vh">
        <a-layout-sider theme="light" class="tw-relative">
            <div class="tw-py-10 tw-px-6 tw-text-center">
                <img src="/images/logo.png" class="tw-w-20" />
            </div>
            <div v-if="getUser" class="tw-px-8 tw-py-4 tw-text-center">
                <span class="tw-text-slate-100 tw-flex tw-space-x-2 tw-justify-center tw-items-center tw-bg-black tw-rounded-md tw-px-2 tw-py-1">
                    <span>{{ getUser.real_name }}</span>
                </span>
            </div>
            <a-menu mode="inline">
                <a-menu-item key="1" @click="push('/')">
                    <span>ダッシュボード</span>
                </a-menu-item>
                <a-menu-item key="2" @click="push('/employee')">
                    <span>正社員データ</span>
                </a-menu-item>
                <a-menu-item key="3" @click="push('/workers')">
                    <span>GVデータ</span>
                </a-menu-item>
            </a-menu>
            <div class="tw-absolute tw-bottom-2 tw-text-center tw-px-4 tw-w-full">
                <a-button danger class="tw-w-full" @click="logout()">LOGOUT</a-button>
            </div>
        </a-layout-sider>
    <a-layout>
        <a-layout-content style="margin: 16px">
            <div v-if="getUser" :style="{ padding: '24px', background: '#fff', minHeight: '360px' }">
                <slot />
                <profile />
                <dep />
                <black />
            </div>
        </a-layout-content>
    </a-layout>
</a-layout></template>

