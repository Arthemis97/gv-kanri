<script setup>
import useRequest from '../composables/useRequest.js';
import { message } from 'ant-design-vue';
import useAuthStore from '../stores/auth'

const authStore = useAuthStore()
const router = useRouter();
const name = ref('')
const password = ref('')
const loading = ref(false)

const login = async () => {
	loading.value = true
	const response = await useRequest.post('/login', {
        name: name.value,
        password: password.value
      })
	  if(!response.data.error) {
		authStore.login({
			user: response.data.user,
			token: response.data.token
		})
		loading.value = false
		router.push('/')
		message.success(response.data?.message || "Logged");
	  } else {
		loading.value = false
		message.error(response.data?.message || "Error");
	  }
}
</script>
<template>
    <div class="tw-min-h-screen tw-bg-gray-100 tw-flex tw-flex-col tw-justify-center sm:tw-py-12">
        <div class="tw-p-10 xs:tw-p-0 tw-mx-auto md:tw-w-full md:tw-max-w-md">
            <h1 class="tw-font-bold tw-text-center tw-text-2xl tw-mb-5">Login</h1>
            <div class="tw-bg-white tw-shadow tw-w-full tw-rounded-lg tw-divide-y tw-divide-gray-200">
                <a-form layout="vertical" class="tw-px-5 tw-py-7">
                    <a-form-item label="Username">
                        <a-input v-model:value="name" class="tw-w-full" size="large"></a-input>
                    </a-form-item>
                    <a-form-item label="Password">
                        <a-input v-model:value="password" class="tw-w-full" size="large" type="password"></a-input>
                    </a-form-item>
                    <a-button @click="login()" :loading="loading" @keydown.enter="login" type="primary" class="tw-w-full"
                        size="large">Login</a-button>
                </a-form>
            </div>
        </div>
    </div>
</template>
