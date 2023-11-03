<script setup lang="ts">
import useAuthStore from "../stores/auth"
import { Modal } from 'ant-design-vue';
const authStore = useAuthStore()
const router = useRouter()

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
            <a-menu mode="inline">
                <a-menu-item key="1" @click="push('/')">
                    <span>ダッシュボード</span>
                </a-menu-item>
                <a-menu-item key="2" @click="push('/employee')">
                    <span>社員</span>
                </a-menu-item>
                <a-menu-item key="3" @click="push('/workers')">
                    <span>バイトデーター</span>
                </a-menu-item>
            </a-menu>
            <div class="tw-absolute tw-bottom-2 tw-text-center tw-px-4 tw-w-full">
                <a-button danger class="tw-w-full" @click="logout()">LOGOUT</a-button>
            </div>
        </a-layout-sider>
        <a-layout>
            <a-layout-content style="margin: 16px">
                <div :style="{ padding: '24px', background: '#fff', minHeight: '360px' }">
                    <slot />
                </div>
            </a-layout-content>
        </a-layout>
    </a-layout>
</template>

