<script setup lang="ts">
import { onMounted } from "vue";
import useEmployeeStore from "../../stores/employee";
import { message } from "ant-design-vue";
import useNationStore from "../../stores/nation";
const employeeStore = useEmployeeStore();
const nationStore = useNationStore()
const { getList, getPrefecture, getWorkplace } = storeToRefs(nationStore)
const router = useRouter();
const route = useRoute();
const form = ref({
    advancement: "5"
})
const loading = ref(false)
const errors = ref({})


const drlc = [
    { value: "1", text: "普通免許(AT、MT、第一種、第二種)" },
    { value: "2", text: "準中型免許" },
    { value: "3", text: "中型免許(第一種、第二種)" },
    { value: "4", text: "大型免許(第一種、第二種)" },
    { value: "5", text: "小型特殊免許" },
    { value: "6", text: "大型特殊免許(第一種、第二種)" },
    { value: "7", text: "牽引免許(第一種、第二種)" },
    { value: "8", text: "普通二輪免許(AT、MT)" },
    { value: "9", text: "大型二輪免許" },
    { value: "10", text: "原付免許" },
    { value: "11", text: "運転免許証なし" }
]

const visatype = [
    { value: '1', text: "外交 " },
    { value: '2', text: "公用" },
    { value: '3', text: "教授" },
    { value: '4', text: "芸術" },
    { value: '5', text: "宗教" },
    { value: '6', text: "報道" },
    { value: '7', text: "高度専門職" },
    { value: '8', text: "経営・管理" },
    { value: '9', text: "法律・会計業務" },
    { value: '10', text: "医療" },
    { value: '11', text: "研究" },
    { value: '12', text: "教育" },
    { value: '13', text: "技術・人文知識・国際業務" },
    { value: '14', text: "企業内転勤" },
    { value: '15', text: "介護（※１）" },
    { value: '16', text: "興行" },
    { value: '17', text: "技能" },
    { value: '18', text: "技能実習" },
    { value: '19', text: "文化活動" },
    { value: '20', text: "短期滞在" },
    { value: '21', text: "留学" },
    { value: '22', text: "研修" },
    { value: '23', text: "家族滞在" },
    { value: '24', text: "特定活動" },
    { value: '25', text: "永住者" },
    { value: '26', text: "日本人の配偶者等" },
    { value: '27', text: "永住者の配偶者等" },
    { value: '28', text: "定住者" }
]
const advancement = [
    { value: "5", text: "在籍中" },
    { value: "1", text: "就職" },
    { value: "2", text: "進学" },
    { value: "3", text: "帰国" },
    { value: "4", text: "休職" }
]
const jpnlvl = [
    { value: "1", text: "N1" },
    { value: "2", text: "N2" },
    { value: "3", text: "N3" },
    { value: "4", text: "N4" },
    { value: "5", text: "N5" },
    { value: "6", text: "NO" }
]
const pos = [
    { value: "1", text: "1年3ヶ月" },
    { value: "2", text: "3年" },
    { value: "3", text: "5年" },
    { value: "4", text: "5年以降" }
]
const black_list_values = [
    { value: "0", text: "問題おこしたことがない" },
    { value: "1", text: "1回問題おこした." },
    { value: "2", text: "1回以上おこした。" }
]

const save = async () => {
    loading.value = true
    if (form.value.id) {
        const resp = await employeeStore.update(form.value.id, form.value)
        if (resp.data.errors) {
            errors.value = resp.data.errors
            loading.value = false
        } else {
            message.success('Updated')
            router.push('/workers')
        }
    } else {
        const resp = await employeeStore.storeWorker(form.value)
        if (resp.data.errors) {
            errors.value = resp.data.errors
            loading.value = false
        } else {
            message.success('Success')
            router.push('/workers')
        }
    }
}

const handleImage = (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();

        reader.onload = (e) => {
            form.value.picture = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

const filterOption = (input: string, option: any) => {
    return option.label.toLowerCase().indexOf(input.toLowerCase()) >= 0;
};

onMounted(async () => {
    if (route.params.id) {
        const data = await employeeStore.fetchOne(route.params.id)
        if (data && data.id) {
            form.value = data
        }
    }
})
</script>
<template>
    <div class="tw-flex tw-space-x-4">
        <a-form class="tw-max-w-[600px]" layout="vertical">
            <a-row :gutter="14">
                <a-col :span="12">
                    <a-form-item label="氏名">
                        <a-input placeholder="氏名" v-model:value="form.name" :status="errors.name ? 'error' : ''" />
                    </a-form-item>
                </a-col>
                <a-col :span="12">
                    <a-form-item label="フリガナ">
                        <a-input placeholder="フリガナ" v-model:value="form.furigana"
                            :status="errors.furigana ? 'error' : ''" />
                    </a-form-item>
                </a-col>
                <a-col :span="12">
                    <a-form-item label="ID">
                        <a-input placeholder="ID" v-model:value="form.custom_id"
                            :status="errors.custom_id ? 'error' : ''" />
                    </a-form-item>
                </a-col>
                <a-col :span="12">
                    <a-form-item label="誕生日">
                        <a-date-picker valueFormat="YYYY-MM-DD" placeholder="誕生日" class="tw-w-full" v-model:value="form.dob"
                            :status="errors.dob ? 'error' : ''" />
                    </a-form-item>
                </a-col>
                <a-col :span="12">
                    <a-form-item label="電話番号">
                        <a-input placeholder="電話番号" v-model:value="form.phone_number"
                            :status="errors.phone_number ? 'error' : ''" />
                    </a-form-item>
                </a-col>
                <a-col :span="12">
                    <a-form-item label="評価">
                        <a-select placeholder="評価" v-model:value="form.black_list"
                            :status="errors.black_list ? 'error' : ''">
                            <a-select-option v-for="(bl, bl_id) in black_list_values" :key="bl_id" :label="bl.name"
                                :value="bl.value">{{ bl.text }}</a-select-option>
                        </a-select>
                    </a-form-item>
                </a-col>
                <a-col v-if="form.black_list == 1 || form.black_list == 2" :span="24">
                    <a-form-item label="評価">
                        <a-input placeholder="評価" v-model:value="form.black_list_description"
                            :status="errors.black_list_description ? 'error' : ''" />
                    </a-form-item>
                </a-col>
                <a-col :span="12">
                    <a-form-item label="都道府県">
                        <a-select placeholder="都道府県" v-model:value="form.prefecture_id" show-search
                            :filter-option="filterOption" :status="errors.prefecture_id ? 'error' : ''">
                            <a-select-option v-for="(pr, pr_id) in getPrefecture" :key="pr_id" :label="pr.name"
                                :value="pr.id">{{
                                    pr.name }}</a-select-option>
                        </a-select>
                    </a-form-item>
                </a-col>
                <a-col :span="12">

                </a-col>
                <a-col :span="12">
                    <a-form-item label="写真">
                        <input type="file" accept="image/*" @change="handleImage">
                    </a-form-item>
                </a-col>


                <a-col :span="12">
                    <a-avatar v-if="form.picture" :size="128" :src="form.picture">
                    </a-avatar>
                </a-col>
                <a-col :span="12">
                    <a-form-item label="性別">
                        <a-select placeholder="性別" v-model:value="form.gender" :status="errors.gender ? 'error' : ''">
                            <a-select-option key="1" :value="1">男</a-select-option>
                            <a-select-option key="2" :value="0">女</a-select-option>
                        </a-select>
                    </a-form-item>
                </a-col>



                <a-col :span="12">
                    <a-form-item label="国籍">
                        <a-select placeholder="国籍" v-model:value="form.nationality" show-search
                            :filter-option="filterOption" :status="errors.nationality ? 'error' : ''">
                            <a-select-option v-for="(nation, nation_id) in getList" :key="nation_id" :label="nation.name_jp"
                                :value="nation.id">{{
                                    nation.name_jp }}</a-select-option>
                        </a-select>
                    </a-form-item>
                </a-col>

                <a-col :span="12">
                    <a-form-item label="在留資格">
                        <a-select placeholder="在留資格" v-model:value="form.visa_type" show-search
                            :filter-option="filterOption" :status="errors.visa_type ? 'error' : ''">
                            <a-select-option v-for="(visa, visa_id) in visatype" :key="visa_id" :label="visa.text"
                                :value="visa.value">{{
                                    visa.text }}</a-select-option>
                        </a-select>
                    </a-form-item>
                </a-col>


                <a-col :span="12">
                    <a-form-item label="在留カード番号">
                        <a-input placeholder="在留カード番号" v-model:value="form.resisdence_card_number"
                            :status="errors.resisdence_card_number ? 'error' : ''" />
                    </a-form-item>
                </a-col>

                <a-col :span="12">
                    <a-form-item label="就労制限">
                        <a-select placeholder="就労制限" v-model:value="form.work_restrictions"
                            :status="errors.work_restrictions ? 'error' : ''">
                            <a-select-option key="1" :value="1">Yes</a-select-option>
                            <a-select-option key="2" :value="0">No</a-select-option>
                        </a-select>
                    </a-form-item>
                </a-col>

                <a-col :span="12">
                    <a-form-item label="在籍情報">
                        <a-select placeholder="在籍情報" v-model:value="form.advancement" show-search
                            :filter-option="filterOption" :status="errors.advancement ? 'error' : ''">
                            <a-select-option v-for="(adv, adv_id) in advancement" :key="adv_id" :label="adv.text"
                                :value="adv.value">{{
                                    adv.text }}</a-select-option>
                        </a-select>
                    </a-form-item>
                </a-col>


                <a-col :span="12">
                    <a-form-item label="日本語レベル">
                        <a-select placeholder="日本語レベル" v-model:value="form.japanese_level"
                            :status="errors.japanese_level ? 'error' : ''">
                            <a-select-option v-for="(jpn, jpn_id) in jpnlvl" :key="jpn_id" :label="jpn.text"
                                :value="jpn.value">{{
                                    jpn.text }}</a-select-option>
                        </a-select>
                    </a-form-item>
                </a-col>


                <a-col :span="12">
                    <a-form-item label="緊急連絡先">
                        <a-input placeholder="緊急連絡先" v-model:value="form.urgent_contact"
                            :status="errors.urgent_contact ? 'error' : ''" />
                    </a-form-item>
                </a-col>

                <a-col :span="24">
                    <a-form-item label="住所">
                        <a-input placeholder="住所" v-model:value="form.address" :status="errors.address ? 'error' : ''" />
                    </a-form-item>
                </a-col>
                <a-col :span="12">
                    <a-form-item label="在留期間">
                        <a-select placeholder="在留期間" v-model:value="form.pos" :status="errors.pos ? 'error' : ''">
                            <a-select-option v-for="(i, i_index) in pos" :value="i.value" :key="i_index">{{ i.text
                            }}</a-select-option>
                        </a-select>
                    </a-form-item>
                </a-col>
                <a-col :span="12">
                    <a-form-item label="終了日">
                        <a-date-picker valueFormat="YYYY-MM-DD" placeholder="終了日" class="tw-w-full"
                            v-model:value="form.pos_date" :status="errors.pos_date ? 'error' : ''" />
                    </a-form-item>
                </a-col>

                <a-col :span="12">
                    <a-form-item label="登録日">
                        <a-date-picker valueFormat="YYYY-MM-DD" placeholder="登録日" class="tw-w-full"
                            v-model:value="form.registred_day" :status="errors.registred_day ? 'error' : ''" />
                    </a-form-item>
                </a-col>


                <a-col :span="12">
                    <a-form-item label="現場名">
                        <a-select placeholder="現場名" v-model:value="form.work_place_id" show-search
                            :filter-option="filterOption" :status="errors.work_place_id ? 'error' : ''">
                            <a-select-option v-for="(wp, wp_id) in getWorkplace" :key="wp_id" :label="wp.name"
                                :value="wp.id">{{
                                    wp.name }}</a-select-option>
                        </a-select>
                    </a-form-item>
                </a-col>


                <a-col :span="12">
                    <a-form-item label="緊急連絡先名">
                        <a-input placeholder="緊急連絡先名" v-model:value="form.emergency_contact_name"
                            :status="errors.emergency_contact_name ? 'error' : ''" />
                    </a-form-item>
                </a-col>

                <a-col :span="12">
                    <a-form-item label="業務開始日">
                        <a-date-picker valueFormat="YYYY-MM-DD" placeholder="業務開始日" class="tw-w-full"
                            v-model:value="form.start_date" :status="errors.start_date ? 'error' : ''" />
                    </a-form-item>
                </a-col>

                <a-col :span="24">
                    <a-form-item label="運転免許">
                        <a-select placeholder="運転免許" v-model:value="form.driver_license"
                            :status="errors.driver_license ? 'error' : ''">
                            <a-select-option v-for="(i, i_index) in drlc" :value="i.value" :key="i_index">{{ i.text
                            }}</a-select-option>
                        </a-select>
                    </a-form-item>
                </a-col>
            </a-row>
            <a-button type="primary" @click="save" :disabled="loading">Save</a-button>
        </a-form>
        <div class="tw-flex-1">
            <div class="tw-flex tw-flex-col tw-space-y-2">
                <a-alert v-for="(i, index) in Object.keys(errors)" :key="index" :message="errors[i][0]" type="error"
                    show-icon />
            </div>
        </div>
    </div>
</template>

