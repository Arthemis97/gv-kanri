const useNationStore = defineStore('nation', {
    state: () => ({
        list: [],
    }),
    getters: {
        getList: (state) => state.list
    },
    actions: {
        async fetchList() {
            const resp = await useRequest.get('/nation');
            if (resp.data) {
                this.list = resp.data;
            }
        }
    },
});
export default useNationStore
