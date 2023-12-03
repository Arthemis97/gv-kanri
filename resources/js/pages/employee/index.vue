<script setup lang="ts">
import { PlusOutlined, DeleteOutlined, EditOutlined, SearchOutlined } from '@ant-design/icons-vue'
import { Modal } from 'ant-design-vue';
import useEmployeeStore from "../../stores/employee";
import useAuthStore from "../../stores/auth";
const router = useRouter();
const employeeStore = useEmployeeStore();
const authStore = useAuthStore();
const { getList } = storeToRefs(employeeStore)
const { getUser } = storeToRefs(authStore)
const state = reactive({
    searchText: '',
    searchedColumn: '',
});

const searchInput = ref();
const search_value = ref("")

const loading = ref(false)

const columns = [
    {
        title: '#',
        key: 'id',
        width: 50,
        fixed: 'left',
    },
    {
        title: '写真',
        key: 'picture',
        width: 40,
        fixed: 'left',
    },
    {
        title: '氏名',
        key: 'name',
        customFilterDropdown: true,
        onFilterDropdownOpenChange: visible => {
            if (visible) {
                setTimeout(() => {
                    searchInput.value.focus();
                }, 100);
            }
        },
        fixed: 'left',
        width: 200
    },
    {
        title: 'フリガナ',
        key: 'furigana',
        customFilterDropdown: true,
        onFilterDropdownOpenChange: visible => {
            if (visible) {
                setTimeout(() => {
                    searchInput.value.focus();
                }, 100);
            }
        },
        fixed: 'left',
        width: 200
    },
    {
        title: '呼ぶ名',
        key: 'nick_name',
        fixed: 'left',
    },
    {
        title: '誕生日',
        key: 'dob',
    },
    {
        title: '性別',
        key: 'gender',
    },
    {
        title: '住所',
        key: 'address',
    },
    {
        title: '在留カード番号',
        key: 'resisdence_card_number',
        width: 120
    },
    {
        title: 'マイナンバー',
        key: 'my_number',
        width: 120
    },
    {
        title: '扶養',
        key: 'dependent',
    },
    {
        title: '電話番号',
        key: 'phone_number',
        width: 120
    },
    {
        title: '在留期間',
        key: 'pos',
    },
    {
        title: '終了日',
        key: 'pos_date',
    },
    {
        title: '運転免許',
        key: 'driver_license',
        width: 250
    },
    {
        title: '職場名',
        key: 'working_place',
    },
    {
        title: '入社日',
        key: 'start_date',
    },
    {
        title: '働く期間（プラン）',
        key: 'working_plan',
        width: 120
    },
    {
        title: '自己PR',
        key: 'introduce',
    },
    {
        title: '担当者',
        key: 'manager',
        width: 120
    },
    {
        title: '',
        key: 'action',
        width: 75
    },
];

const pgn = ref({})

const edit = (id) => {
    router.push(`/employee/${id}`)
}


const handleSearch = (selectedKeys, confirm, dataIndex) => {
    confirm();
    state.searchText = selectedKeys[0];
    state.searchedColumn = dataIndex;
};

const handleReset = (clearFilters, key) => {
    clearFilters({ confirm: true });
    state.searchText = '';
};

const fetchList = async (filters, pagination) => {
    loading.value = true
    const pag = await employeeStore.fetchList(filters, pagination);
    pgn.value = { ...pag, ...{ pageSize: 20 } }
    loading.value = false
}

const handleTableChange = (pagination, filters, sorter, { currentDataSource }) => {
    fetchList(filters, pagination)
}

const onSearch = async () => {
    fetchList({ search: search_value.value }, null)
}

const deleteuser = (id) => {
    Modal.confirm({
        title: '消してもよろしいですか',
        async onOk() {
            await employeeStore.deleteUser(id)
        },
        onCancel() { },
    });
}

const showModal = (data) => {
    useEvent.emit('modal:profile:open', data)
}

const showDep = (data) => {
    useEvent.emit('modal:dep:open', data.relation)
}

const canDo = (role) => {
    return role.includes(getUser.value.admin_type)
}

watch(search_value, (newVal) => {
    if(!newVal || newVal.length == 0){
        fetchList(null, null)
    }
})

onMounted(async () => {
    fetchList(null, null)
})
</script>
<template>
    <div>
        <a-page-header class="demo-page-header" title="正社員データ" @back="() => $router.go(-1)">
            <template #extra>
                <a-input-search size="small" v-model:value="search_value" placeholder="Search..." style="width: 200px"
                    @search="onSearch" />
                <a-button v-if="canDo(['admin', 'regular'])" size="small" key="3" @click="() => $router.push('/employee/add')">
                    <PlusOutlined #icon />
                </a-button>
            </template>
        </a-page-header>
        <a-table :loading="loading" :dataSource="getList" :columns="columns" size="small" bordered :pagination="pgn"
            @change="handleTableChange" :scroll="{ x: 3000, y: 1000 }">

            <template #customFilterDropdown="{ setSelectedKeys, selectedKeys, confirm, clearFilters, column }">
                <div style="padding: 8px">
                    <a-input ref="searchInput" :placeholder="`${column.title}`" :value="selectedKeys[0]"
                        style="width: 188px; margin-bottom: 8px; display: block"
                        @change="(e: any) => setSelectedKeys(e.target.value ? e.target.value : '')"
                        @pressEnter="handleSearch(selectedKeys, confirm, column.key)" />
                    <a-button type="primary" size="small" style="width: 90px; margin-right: 8px"
                        @click="handleSearch(selectedKeys, confirm, column.key)">
                        <template #icon>
                            <SearchOutlined />
                        </template>
                        Search
                    </a-button>
                    <a-button size="small" style="width: 90px" @click="handleReset(clearFilters, column.key)">
                        Reset
                    </a-button>
                </div>
            </template>
            <template #customFilterIcon="{ filtered }">
                <search-outlined :style="{ color: filtered ? '#108ee9' : undefined }" />
            </template>
            <template #bodyCell="{ column, record }">
                <template v-if="column.key === 'id'">
                    {{ record.id }}
                </template>
                <template v-if="column.key === 'picture'">
                    <a-avatar @click="showModal(record)" v-if="record.picture" :size="32" :src="record.picture">
                    </a-avatar>
                </template>


                <template v-else-if="column.key === 'nick_name'">
                    {{ record.nick_name }}
                </template>

                <template v-else-if="column.key === 'resisdence_card_number'">
                    {{ record.resisdence_card_number }}
                </template>

                <template v-else-if="column.key === 'dependent'">
                    <a-button @click="showDep(record)" type="primary" size="small" v-if="record.dependent">います</a-button>
                    <a-button type="text" size="small" v-else>いません</a-button>
                </template>

                <template v-else-if="column.key === 'start_date'">
                    {{ record.start_date }}
                </template>

                <template v-else-if="column.key === 'manager'">
                    {{ record.manager_value }}
                </template>
                <template v-else-if="column.key === 'my_number'">
                    {{ record.my_number }}
                </template>





                <template v-else-if="column.key === 'name'">
                    {{ record.name }}
                </template>
                <template v-else-if="column.key === 'phone_number'">
                    {{ record.phone_number }}
                </template>
                <template v-else-if="column.key === 'furigana'">
                    {{ record.furigana }}
                </template>
                <template v-else-if="column.key === 'dob'">
                    {{ record.dob }}
                </template>
                <template v-else-if="column.key === 'gender'">
                    {{ record.gender ? '男' : '女' }}
                </template>
                <template v-else-if="column.key === 'address'">
                    <a-typography-text :style="{ width: '100px' }"
                        :ellipsis="{ tooltip: record.address ? record.address : '' }" :content="record.address" />
                </template>
                <template v-else-if="column.key === 'pos'">
                    {{ record.pos_value }}
                </template>
                <template v-else-if="column.key === 'pos_date'">
                    {{ record.pos_date }}
                </template>
                <template v-else-if="column.key === 'driver_license'">
                    {{ record.driver_license_value }}
                </template>
                <template v-else-if="column.key === 'working_place'">
                    {{ record.working_place_value }}
                </template>
                <template v-else-if="column.key === 'working_plan'">
                    {{ record.working_plan_value }}
                </template>
                <template v-else-if="column.key === 'introduce'">
                    {{ record.introduce }}
                </template>
                <template v-else-if="column.key === 'action'">
                    <a-button v-if="canDo(['admin', 'regular'])" @click="edit(record.id)" size="small" class="tw-mr-1">
                        <EditOutlined #icon />
                    </a-button>
                    <a-button v-if="canDo(['admin'])" size="small" danger @click="deleteuser(record.id)">
                        <DeleteOutlined #icon />
                    </a-button>
                </template>
            </template>
        </a-table>
    </div>
</template>

