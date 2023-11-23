const useNationStore = defineStore('nation', {
    state: () => ({
        list: [],
        prefectures: [],
        work_places: []
    }),
    getters: {
        getList: (state) => state.list,
        getPrefecture: (state) => state.prefectures,
        getWorkplace: (state) => state.work_places
    },
    actions: {
        async fetchList() {
            const resp = await useRequest.get('/nation');
            if (resp.data) {
                this.list = resp.data;
            }
        },

        async fetchPrefecture() {
            const resp = await useRequest.get('/prefecture');
            if (resp.data) {
                this.prefectures = resp.data;
            }
        },

        async fetchWorkplace() {
            const resp = await useRequest.get('/work_place');
            if (resp.data) {
                this.work_places = resp.data;
            }
        }
    },
});
export default useNationStore
